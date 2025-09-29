<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../Models/ShopInfo.php';

// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get PDO + Model
$pdo = (new Database())->getConnection();
$shopModel = new ShopInfo($pdo);
$shop = $shopModel->getAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        // Only update known fields
        if (in_array($key, ['shop_name', 'phone', 'email', 'address'])) {
            $shopModel->update($key, $value);
        }
    }

    // Handle file upload
    if (!empty($_FILES['shop_logo']['name'])) {
        $filename = time() . "_" . basename($_FILES['shop_logo']['name']);
        $targetPath = __DIR__ . '/../../../common/images/' . $filename;

        if (move_uploaded_file($_FILES['shop_logo']['tmp_name'], $targetPath)) {
            $shopModel->update('shop_logo', $filename);
        }
    }

    // Flash message
    $_SESSION['flash_message'] = "Shop information updated successfully!";

    // Redirect back to this page
    header("Location: index.php?controller=settings&action=editShopInfo");
    exit();
}

// Show flash message if available
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop Info</title>
    <link rel="stylesheet" href="../../../common/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../../../common/index.php'; ?>

    <div class="sidebar">
        <!-- Logo Section -->
        <div class="logo-section">
            <img src="http://localhost/ValueMart/common/images/ValueMart_logo.png" 
                 alt="ValueMart Logo" class="dashboard-logo">
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
            <a class="active" href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <h1 class="dashboard-title">Shop Info</h1>
        <hr>

        <!-- Flash message -->
        <?php if (!empty($flashMessage)): ?>
            <p style="color: green; font-weight: bold;">
                <?= htmlspecialchars($flashMessage) ?>
            </p>
        <?php endif; ?>

        <div class="dashboard-actions">
            <a href="index.php?controller=settings&action=index" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Settings
            </a>
        </div>
        <br>

        <form class="styled-form" method="post" enctype="multipart/form-data">
            <label for="shop_name">Shop Name:</label>
            <input type="text" name="shop_name" id="shop_name" 
                value="<?= htmlspecialchars($shop['shop_name'] ?? '') ?>" required>

            <label for="phone">Phone No.:</label>
            <input type="number" name="phone" id="phone" min="0"
                value="<?= htmlspecialchars($shop['phone'] ?? '') ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" 
                value="<?= htmlspecialchars($shop['email'] ?? '') ?>" required>

            <label for="address">Shop Address:</label>
            <textarea name="address" id="address"><?= htmlspecialchars($shop['address'] ?? '') ?></textarea>

            <label for="shop_logo">Shop Logo:</label>
            <?php if(!empty($shop['shop_logo'])): ?>
                <img src="../../../common/images/<?= htmlspecialchars($shop['shop_logo']) ?>" 
                    alt="Shop Logo" style="width:150px; display:block; margin-bottom:10px;">
            <?php endif; ?>
            <input type="file" name="shop_logo" id="shop_logo">

            <button type="submit">Save Shop Info</button>
        </form>
    </div>

</body>
</html>
