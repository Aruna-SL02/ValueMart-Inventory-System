<?php

require_once 'Controller.php';
require_once __DIR__ . '/../Models/Report.php';

class ReportController extends Controller {
    public function index() {
        $reportModel = new Report();

        $totalStock = $reportModel->getStockValue();
        $topProducts = $reportModel->getMostSoldProducts(5);
        $otherProducts = $reportModel->getOtherSoldProducts(5);
        $salesSummary = $reportModel->getSalesSummary();
        $lowStockProducts = $reportModel->getLowStockProducts(10);


        include __DIR__ . '/../Views/reports/report_dashboard.php';

    }
}

?>