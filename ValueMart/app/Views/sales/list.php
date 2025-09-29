<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Sales</title>
    <link rel="stylesheet" href="ValueMart/common/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <div class="sidebar">

    <!-- Logo Section -->
        <div class="logo-section">
            <img src="http://localhost/ValueMart/common/images/ValueMart_logo.png" alt="ValueMart Logo" class="dashboard-logo">
        </div>
        <div class="profile-section">
            <i class="fa fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
        </div>

        <a href="index.php?controller=product&action=index"><i class="fa fa-box"></i> Products</a>
        <a href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
        <a class="active" href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i> Sales</a>
        <a href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i> Reports</a>

        <div class="sidebar-footer">
            <a href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h1 class="dashboard-title">Sales Dashboard</h1> <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=sale&action=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Sale</a>
        </div>
        <br>

        <!-- Sales Table -->
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Saled Quantity</th>
                        <th>Unite Price</th>
                        <th>Total Revenue</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php foreach($sales as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['id']) ?></td>
                                <td><?= htmlspecialchars($s['product_name']) ?></td>
                                <td><?= htmlspecialchars($s['quantity']) ?></td>
                                <td>Rs. <?= number_format($s['price'], 2) ?></td>
                                <td>Rs. <?= number_format($s['total'], 2) ?></td>
                                <td><?= htmlspecialchars($s['sale_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-data">No sales found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
