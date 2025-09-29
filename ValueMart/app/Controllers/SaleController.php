<?php
require_once __DIR__ . '/../Models/Sale.php';
require_once __DIR__ . '/../Models/Product.php';

class SaleController {
    public function index() {
        $saleModel = new Sale();
        $sales = $saleModel->getAll();
        include __DIR__ . '/../Views/sales/list.php';
    }

    public function add() {
        $productModel = new Product();
        $products = $productModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $saleModel = new Sale();
            if ($saleModel->create($_POST)) {
                header("Location: index.php?controller=sale&action=index");
                exit;
            } else {
                $error = "Sale could not be completed. Check stock.";
            }
        }

        include __DIR__ . '/../Views/sales/add.php';
    }
}
?>