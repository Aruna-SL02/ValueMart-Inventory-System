<?php
class InventorySettings {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        // Fetch row with id=1
        $stmt = $this->conn->query("SELECT * FROM inventory_settings WHERE id=1 LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($key, $value) {
        // Map form fields to DB columns
        $columns = [
            'low_stock_threshold' => 'low_stock_threshold',
            'stock_alert_email'   => 'stock_alert_email',
            'restock_policy'      => 'restock_policy' 
        ];

        if (!isset($columns[$key])) {
            return false; 
        }

        // Ensure row with id=1 exists
        $stmt = $this->conn->query("SELECT COUNT(*) FROM inventory_settings WHERE id=1");
        if ($stmt->fetchColumn() == 0) {
            $this->conn->exec("INSERT INTO inventory_settings (id) VALUES (1)");
        }

        // Update the mapped column
        $stmt = $this->conn->prepare("UPDATE inventory_settings SET `{$columns[$key]}` = :value WHERE id = 1");
        return $stmt->execute(['value' => $value]);
    }
}
?>
