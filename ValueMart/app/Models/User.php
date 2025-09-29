<?php

require_once __DIR__ . '/../../config/database.php';

class User {
    private $conn;

    public function __construct($pdo = null) {
        if ($pdo instanceof PDO) {
            $this->conn = $pdo;
        } else {
            $this->conn = (new Database())->getConnection();
        }
    }

    // ---- AUTH METHODS ----
    public function findByUsername(string $username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    public function create(string $username, string $password, string $role = 'staff') {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (:username, :password, :role, NOW())");
        return $stmt->execute([
            ':username' => $username,
            ':password' => $password, 
            ':role'     => $role
        ]);
    }

    public function verifyPassword(string $username, string $password) {
        $user = $this->findByUsername($username);

        if ($user) {
            // Check hashed password
            if (password_verify($password, $user['password'])) {
                return $user;
            }

            // Support for old plain-text passwords (optional)
            if ($password === $user['password']) {
                return $user;
            }
        }
        return false;
    }

    // ---- PROFILE METHODS ----
    public function getById(int $id) {
        $stmt = $this->conn->prepare("
            SELECT id, username, full_name, email, phone, avatar 
            FROM users WHERE id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateProfile(int $id, array $data) {
        $stmt = $this->conn->prepare("
            UPDATE users 
            SET full_name = :full_name,
                email     = :email,
                phone     = :phone,
                avatar    = :avatar,
                updated_at = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([
            ':full_name' => $data['full_name'] ?? '',
            ':email'     => $data['email'] ?? '',
            ':phone'     => $data['phone'] ?? '',
            ':avatar'    => $data['avatar'] ?? null,
            ':id'        => $id
        ]);
    }

    public function deleteById($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function changePassword(int $id, string $currentPlain, string $newPlain) {
        // Get current password from DB
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check current password (direct comparison, since stored as plain text)
        if (!$row || $currentPlain !== $row['password']) {
            return ['ok' => false, 'error' => 'Current password is incorrect'];
        }

        // Update password directly in plain text
        $upd = $this->conn->prepare("UPDATE users SET password = :p, updated_at = NOW() WHERE id = :id");
        $upd->execute([':p' => $newPlain, ':id' => $id]);

        return ['ok' => true];
    }

    public function register(array $data) {
        $stmt = $this->conn->prepare("
            INSERT INTO users (username, password, role, full_name, email, phone, avatar, created_at, updated_at) 
            VALUES (:username, :password, :role, :full_name, :email, :phone, :avatar, NOW(), NOW())
        ");

        return $stmt->execute([
            ':username'  => $data['username'],
            ':password'  => $data['password'], // plain text
            ':role'      => $data['role'] ?? 'staff',
            ':full_name' => $data['full_name'] ?? '',
            ':email'     => $data['email'] ?? '',
            ':phone'     => $data['phone'] ?? '',
            ':avatar'    => $data['avatar'] ?? null
        ]);
    }

}
?>
