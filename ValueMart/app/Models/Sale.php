<?php
// app/Models/Sale.php
require_once 'Model.php';

class Sale extends Model {
    public $lastError = null;

    public function __construct() {
        parent::__construct();
    }

    // Create a new sale and decrease stock
    public function create($data) {
        try {
            $this->conn->beginTransaction();

            // Lock the product row to avoid race conditions
            $stmt = $this->conn->prepare(
                "SELECT price, quantity FROM products WHERE id = :id FOR UPDATE"
            );
            $stmt->execute([':id' => $data['product_id']]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                throw new Exception("Product not found");
            }

            $qty = (int)($data['quantity'] ?? 0);
            if ($qty <= 0) {
                throw new Exception("Quantity must be greater than zero");
            }

            if ((int)$product['quantity'] < $qty) {
                throw new Exception("Not enough stock available");
            }

            $total = (float)$product['price'] * $qty;

            // Insert sale
            $stmt = $this->conn->prepare(
                "INSERT INTO sales (product_id, quantity, total) 
                 VALUES (:product_id, :quantity, :total)"
            );
            $stmt->execute([
                ':product_id' => $data['product_id'],
                ':quantity'   => $qty,
                ':total'      => $total
            ]);

            // Decrease stock
            $stmt = $this->conn->prepare(
                "UPDATE products SET quantity = quantity - :quantity WHERE id = :id"
            );
            $stmt->execute([
                ':quantity' => $qty,
                ':id'       => $data['product_id']
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback and surface a friendly error to the controller/view
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            $this->lastError = $e->getMessage();
            return false;
        }
    }

    // List all sales with product name & price
    public function getAll() {
        $sql = "SELECT s.*, p.name AS product_name, p.price
                FROM sales s
                JOIN products p ON s.product_id = p.id
                ORDER BY s.sale_date DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>