
<?php
require_once 'Model.php';

class Report extends Model {

    public function getStockValue() {
        $stmt = $this->conn->query("SELECT SUM(price * quantity) AS total_stock_value FROM products");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_stock_value'] ?? 0;
    }

    public function getMostSoldProducts($limit = 5) {
        $stmt = $this->conn->prepare("
            SELECT p.name, SUM(s.quantity) AS total_sold
            FROM sales s
            JOIN products p ON s.product_id = p.id
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOtherSoldProducts($excludeLimit = 5) {
        $stmt = $this->conn->prepare("
            SELECT p.name, SUM(s.quantity) AS total_sold
            FROM sales s
            JOIN products p ON s.product_id = p.id
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT 100 OFFSET :offset
        ");
        $stmt->bindValue(':offset', (int)$excludeLimit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Total sales summary
    public function getSalesSummary() {
        $stmt = $this->conn->query("
            SELECT 
                SUM(total * quantity) AS total_sales,
                SUM(quantity) AS total_items_sold
            FROM sales
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Low stock products (quantity below threshold)
    public function getLowStockProducts($threshold = 10) {
        $stmt = $this->conn->prepare("
            SELECT name, quantity 
            FROM products 
            WHERE quantity < :threshold
        ");
        $stmt->bindValue(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlySales() {
        $stmt = $this->conn->query("
            SELECT DATE_FORMAT(sale_date, '%Y-%m') AS month, SUM(total * quantity) AS total_sales
            FROM sales
            GROUP BY month
            ORDER BY month ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}



?>
