<?php
require_once 'Model.php';

class Product extends Model {

    public function getAll(){
        $stmt = $this->conn->prepare("SELECT p.*, s.name AS supplier_name FROM products p LEFT JOIN suppliers s ON p.supplier_id = s.id ORDER BY p.id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data){
        $stmt = $this->conn->prepare("INSERT INTO products (name, category, price, quantity, supplier_id) VALUES (:name, :category, :price, :quantity, :supplier_id)");
        $stmt->execute([
            ':name' => $data['name'],
            ':category' => $data['category'],
            ':price' => $data['price'],
            ':quantity' => $data['quantity'],
            ':supplier_id' => $data['supplier_id']
        ]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $data){
        $stmt = $this->conn->prepare("UPDATE products SET name = :name, category = :category, price = :price, quantity = :quantity, supplier_id = :supplier_id WHERE id = :id");
        return $stmt->execute([
            ':name' => $data['name'],
            ':category' => $data['category'],
            ':price' => $data['price'],
            ':quantity' => $data['quantity'],
            ':supplier_id' => $data['supplier_id'],
            ':id' => $id
        ]);
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getAllFiltered($name = '', $category = '', $supplier = '') {
        $sql = "SELECT p.*, s.name AS supplier_name 
                FROM products p 
                LEFT JOIN suppliers s ON p.supplier_id = s.id 
                WHERE 1";

        $params = [];

        if ($name !== '') {
            $sql .= " AND p.name LIKE :name";
            $params[':name'] = "%$name%";
        }

        if ($category !== '') {
            $sql .= " AND p.category LIKE :category";
            $params[':category'] = "%$category%";
        }

        if ($supplier !== '') {
            $sql .= " AND s.name LIKE :supplier";
            $params[':supplier'] = "%$supplier%";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>