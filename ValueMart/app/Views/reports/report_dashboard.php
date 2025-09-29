<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Dashboard</title>
    <link rel="stylesheet" href="common/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Logo Section -->
        <div class="logo-section">
            <img src="http://localhost/ValueMart/common/images/ValueMart_logo.png" alt="ValueMart Logo" class="dashboard-logo">
        </div>
        <!-- Profile Top -->
        <div class="profile-section">
            <i class="fa fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
        </div>

        <!-- Navigation -->
        <a href="index.php?controller=product&action=index"><i class="fa fa-box"></i>     Products</a>
        <a href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i>     Suppliers</a>
        <a href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i>     Sales</a>
        <a class="active" href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i>     Reports</a>
        <a href="#lowStock">
            <span>📦 Low Stock Alerts</span>
            <span class="badge"><?= count($lowStockProducts) ?></span>
        </a>


        <!-- Footer Menu -->
        <div class="sidebar-footer">
            <a href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <div class="navbar">
            <h1>Report Dashboard</h1>
        </div>

        <!-- Report Sections -->
        <div class="content">
            <!-- Sales Summary -->
            <div class="card">
                <h2>Sales Summary</h2>
                <p><strong>Total Sales:</strong> Rs. <?= number_format($salesSummary['total_sales'], 2) ?></p>
                <p><strong>Total Items Sold:</strong> <?= $salesSummary['total_items_sold'] ?></p>
            </div>

            <!-- Top & Other Sold Products -->
            <div class="card flex-row">
                <div class="table-container">
                    <h2>Top Sold Products</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($topProducts as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['total_sold']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-container">
                    <h2>Other Sold Products</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($otherProducts as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['total_sold']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="card low-stock" id="lowStock">
                <h2>Low Stock Alerts</h2>
                <table border="1" cellpadding="5" style="width:100%; margin-bottom:20px;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity Left</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lowStockProducts as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['quantity']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>


            <!-- Charts Section -->
            <div class="charts-container">
                <!-- Top Products Chart -->
                <div class="card chart-box">
                    <h2>Top Products</h2>
                    <canvas id="topProductsChart"></canvas>
                </div>

                <!-- Other Sold Products Chart -->
                <div class="card chart-box">
                    <h2>Other Sold Products</h2>
                    <canvas id="otherProductsChart"></canvas>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Top Products Chart
        const ctx = document.getElementById('topProductsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($topProducts, 'name')) ?>,
                datasets: [{
                    label: 'Top Products Sold',
                    data: <?= json_encode(array_column($topProducts, 'total_sold')) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            }
        });

        // Other Sold Products Chart
        const otherProductsCtx = document.getElementById('otherProductsChart').getContext('2d');
        new Chart(otherProductsCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($otherProducts, 'name')) ?>,
                datasets: [{
                    label: 'Total Sold',
                    data: <?= json_encode(array_column($otherProducts, 'total_sold')) ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)'
                }]
            }
        });

    </script>
</body>
</html>
