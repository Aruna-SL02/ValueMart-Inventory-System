<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../Models/InventorySettings.php';

// Get PDO
$pdo = (new Database())->getConnection();
$inventoryModel = new InventorySettings($pdo);
$inventory = $inventoryModel->getAll();

$successMessage = $errorMessage = "";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        foreach ($_POST as $key => $value) {
            if (!$inventoryModel->update($key, $value)) {
                throw new Exception("Failed to update $key");
            }
        }
        $successMessage = "Inventory settings updated successfully.";
        $inventory = $inventoryModel->getAll(); 
    } catch (Exception $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Settings</title>
    <link rel="stylesheet" href="../../../common/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .message { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body class="dashboard-body">

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
        <h1 class="dashboard-title">Inventory Settings</h1>
        <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=settings&action=index" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Settings
            </a>
        </div>
        <br>

        <?php if (!empty($successMessage)): ?>
            <div class="message success"><?= $successMessage ?></div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <div class="message error"><?= $errorMessage ?></div>
        <?php endif; ?>

        <form class="styled-form" method="post">
            <label for="low_stock_threshold">Low Stock Threshold:</label>
            <input type="number" name="low_stock_threshold" id="low_stock_threshold"
                   value="<?= htmlspecialchars($inventory['low_stock_threshold'] ?? '') ?>" required>

            <label for="stock_alert_email">Stock Alert Email:</label>
            <input type="email" name="stock_alert_email" id="stock_alert_email"
                   value="<?= htmlspecialchars($inventory['stock_alert_email'] ?? '') ?>" required>

            <label for="restock_policy">Restock Policy:</label>
            <textarea name="restock_policy" id="restock_policy" rows="4" cols="50"><?= htmlspecialchars($inventory['restock_column'] ?? '') ?></textarea>

            <button type="submit">Save Settings</button>
        </form>
    </div>
</body>
</html>
