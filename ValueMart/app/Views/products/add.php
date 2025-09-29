<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Add Product</title>
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

        <a class="active" href="index.php?controller=product&action=index"><i class="fa fa-box"></i> Products</a>
        <a href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
        <a href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i> Sales</a>
        <a href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i> Reports</a>

        <div class="sidebar-footer">
            <a href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h1 class="dashboard-title">➕ Add New Product</h1>
        <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=product&action=index" class="btn btn-secondary">⬅ Back to Products</a>
        </div>
        <br>

        <!-- Add Product Form -->
        <div class="form-container">
            <form action="" method="post" class="styled-form">
                
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" required>

                <label for="category">Category</label>
                <input type="text" name="category" id="category" required>

                <label for="price">Price</label>
                <input type="number" name="price" id="price" step="0.01" min="0" required>

                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="0" required>

                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id" required>
                    <option value="">-- Select Supplier --</option>
                    <?php foreach($suppliers as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-primary">💾 Add Product</button>
            </form>
        </div>
    </div>

</body>
</html>
