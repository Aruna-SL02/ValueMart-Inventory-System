<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Add Sale</title>
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
        <h1 class="dashboard-title">➕ Add Sale</h1>
        <hr>
        
        <div class="dashboard-actions">
            <a href="index.php?controller=sale&action=index" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Sales</a>
        </div>
        <br>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="product_id">Product:</label>
                    <select name="product_id" id="product_id" required>
                        <option value="">-- Select Product --</option>
                        <?php foreach($products as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (Stock: <?= $p['quantity'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">💾 Complete Sale</button>
            </form>
        </div>
    </div>

</body>
</html>
