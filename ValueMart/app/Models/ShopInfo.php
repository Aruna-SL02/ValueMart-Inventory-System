<?php
class ShopInfo {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM shop_info LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($key, $value) {
        $columns = [
            'shop_name' => 'shop_name',
            'phone' => 'phone',
            'email' => 'email',
            'shop_address' => 'address',
            'shop_logo' => 'logo'
        ];

        if (!isset($columns[$key])) {
            return false;
        }

        // Make sure row with id=1 exists
        $stmt = $this->conn->query("SELECT COUNT(*) FROM shop_info WHERE id=1");
        if ($stmt->fetchColumn() == 0) {
            $this->conn->exec("INSERT INTO shop_info (id) VALUES (1)");
        }

        $stmt = $this->conn->prepare("UPDATE shop_info SET `{$columns[$key]}` = :value WHERE id = 1");
        return $stmt->execute(['value' => $value]);
    }

}
?>
