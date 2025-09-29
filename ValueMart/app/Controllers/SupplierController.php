<?php
require_once 'Controller.php';
require_once __DIR__ . "/../Models/Supplier.php";

class SupplierController extends Controller {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $suppliers = $this->supplierModel->getAll();
        include __DIR__ . '/../Views/suppliers/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->create($_POST);
            header("Location: index.php?controller=supplier&action=index");
            exit;
        }
        include __DIR__ . '/../Views/suppliers/add.php';
    }

    public function edit() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplierModel->update($id, $_POST);
            header("Location: index.php?controller=supplier&action=index");
            exit;
        }
        $supplier = $this->supplierModel->getById($id);
        include __DIR__ . '/../Views/suppliers/edit.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $this->supplierModel->delete($id);
        header("Location: index.php?controller=supplier&action=index");
        exit;
    }
}
?>