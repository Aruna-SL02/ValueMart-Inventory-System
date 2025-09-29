<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../Models/SecuritySettings.php';

$pdo = (new Database())->getConnection();
$securityModel = new SecuritySettings($pdo);
$security = $securityModel->getAll();

// Ensure $security is always an array
if (!$security || !is_array($security)) {
    $security = [];
}

// Handle form submission
$successMessage = $errorMessage = "";
if ($_POST) {
    $success = true;
    foreach ($_POST as $key => $value) {
        if (!$securityModel->update($key, $value)) {
            $success = false;
        }
    }
    if ($success) {
        $successMessage = "Security settings saved successfully.";
    } else {
        $errorMessage = "Failed to update settings.";
    }
    $security = $securityModel->getAll(); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Backup & Security</title>
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
        <div class="logo-section">
            <img src="http://localhost/ValueMart/common/images/ValueMart_logo.png" alt="ValueMart Logo" class="dashboard-logo">
        </div>
        <div class="profile-section">
            <i class="fa fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
        </div>

        <a href="index.php?controller=product&action=index"><i class="fa fa-box"></i> Products</a>
        <a href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
        <a href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i> Sales</a>
        <a href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i> Reports</a>

        <div class="sidebar-footer">
            <a class="active" href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <h1 class="dashboard-title">Backup & Security</h1>
        <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=settings&action=index" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Settings</a>
        </div>
        <br>

        <!-- Success/Error Message -->
        <?php if (!empty($successMessage)): ?>
            <div class="message success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <?php if (!empty($errorMessage)): ?>
            <div class="message error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form class="styled-form" method="post">
            <label for="backup_frequency">Backup Frequency (days):</label>
            <input type="number" name="backup_frequency" id="backup_frequency" min="0"
                   value="<?= htmlspecialchars($security['backup_frequency'] ?? '') ?>" required>

            <label for="backup_email">Backup Notification Email:</label>
            <input type="email" name="backup_email" id="backup_email"
                   value="<?= htmlspecialchars($security['backup_email'] ?? '') ?>" required>

            <label for="two_factor_enabled">Enable Two-Factor Authentication:</label>
            <select name="two_factor_enabled" id="two_factor_enabled">
                <option value="1" <?= (isset($security['two_factor_enabled']) && $security['two_factor_enabled'] == 1) ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (isset($security['two_factor_enabled']) && $security['two_factor_enabled'] == 0) ? 'selected' : '' ?>>No</option>
            </select>

            <button type="submit">Save Security Settings</button>
        </form>
    </div>

</body>
</html>
