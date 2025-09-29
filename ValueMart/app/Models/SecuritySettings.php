<?php
class SecuritySettings {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM security_settings WHERE id=1 LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($key, $value) {
        // force boolean for two_factor_enabled
        if ($key === "two_factor_enabled") {
            $value = ($value == "1") ? 1 : 0;
        }

        // Ensure row exists
        $stmt = $this->conn->query("SELECT COUNT(*) FROM security_settings WHERE id=1");
        if ($stmt->fetchColumn() == 0) {
            $this->conn->exec("INSERT INTO security_settings (id) VALUES (1)");
        }

        $stmt = $this->conn->prepare("UPDATE security_settings SET `$key` = :value WHERE id=1");
        return $stmt->execute(['value' => $value]);
    }
}
?>
