<?php
class Settings {
    private $conn; // PDO connection

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM settings");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($key, $value) {
        $stmt = $this->conn->prepare("UPDATE settings SET value = ? WHERE name = ?");
        return $stmt->execute([$value, $key]);
    }
}
?>