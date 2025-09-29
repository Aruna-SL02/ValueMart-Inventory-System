<?php
require_once __DIR__ . '/../Models/Product.php';
require_once 'Controller.php';

class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        //session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        $this->productModel = new Product();
    }

    public function index() {
        $searchName = $_GET['search_name'] ?? '';
        $searchCategory = $_GET['search_category'] ?? '';
        $searchSupplier = $_GET['search_supplier'] ?? '';

        $products = $this->productModel->getAllFiltered($searchName, $searchCategory, $searchSupplier);
        $this->view('products/list', ['products' => $products]);
    }


    public function add() {
        $supplierModel = new Supplier();
        $suppliers = $supplierModel->getAll(); // fetch suppliers

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new Product();
            $product->create($_POST);
            header("Location: index.php?controller=product&action=index");
            exit;
        }

        include __DIR__ . '/../Views/products/add.php';

    }

    public function edit() {
        $productModel = new Product();
        $supplierModel = new Supplier();
        $suppliers = $supplierModel->getAll();

        $id = $_GET['id'];
        
        $product = $productModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productModel->update($id, $_POST);
            header("Location: index.php?controller=product&action=index");
            exit;
        }

        include __DIR__ . '/../Views/products/edit.php';
    }



    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->productModel->delete($id);
        }
        header('Location: index.php?controller=product&action=index');
        exit;
    }
}
?>