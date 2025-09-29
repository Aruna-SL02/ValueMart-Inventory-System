<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Settings</title>
    <link rel="stylesheet" href="ValueMart/common/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../../../common/index.php'; ?>

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
        <a href="index.php?controller=product&action=index"><i class="fa fa-box"></i> Products</a>
        <a href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
        <a href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i> Sales</a>
        <a href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i> Reports</a>

        <!-- Footer Menu -->
        <div class="sidebar-footer">
            <a class="active"  href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h1 class="dashboard-title">⚙️ Settings</h1>
        <hr>

        <div class="settings-grid">

            <a href="index.php?controller=account&action=edit" class="settings-card">
                <i class="fa fa-user-cog"></i>
                <h3>User Account</h3>
                <p>Update profile & password</p>
            </a>

            <a href="index.php?controller=settings&action=editShopInfo" class="settings-card">
                <i class="fa fa-store"></i>
                <h3>Shop Info</h3>
                <p>Edit shop name, logo, address</p>
            </a>

            <a href="index.php?controller=settings&action=editInventory" class="settings-card">
                <i class="fa fa-boxes"></i>
                <h3>Inventory Settings</h3>
                <p>Manage stock alerts & policies</p>
            </a>

            <a href="index.php?controller=settings&action=editSecurity" class="settings-card">
                <i class="fa fa-database"></i>
                <h3>Backup & Security</h3>
                <p>Backup database & enable 2FA</p>
            </a>

        </div>
    </div>

</body>
</html>
