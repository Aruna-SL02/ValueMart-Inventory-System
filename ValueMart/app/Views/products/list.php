<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Product List</title> 
    <link rel="stylesheet" href="ValueMart/common/css/style.css">

    <!-- Add FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">

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
        <a class="active" href="index.php?controller=product&action=index"><i class="fa fa-box"></i> Products</a>
        <a href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
        <a href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i> Sales</a>
        <a href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i> Reports</a>

        <!-- Footer Menu -->
        <div class="sidebar-footer">
            <a href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>


    <!-- Main Content -->
    <div class="dashboard-container">
        <h1 class="dashboard-title">Product Dashboard</h1> <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=product&action=add" class="btn btn-primary">➕ Add New Product</a>
        </div>
        <br>

        <!-- Search & Filter Form -->
        <form method="get" action="index.php" class="search-form">
            <input type="hidden" name="controller" value="product">
            <input type="hidden" name="action" value="index">

            <input type="text" name="search_name" placeholder="Search by Name"
                   value="<?= htmlspecialchars($_GET['search_name'] ?? '') ?>">

            <input type="text" name="search_category" placeholder="Search by Category"
                   value="<?= htmlspecialchars($_GET['search_category'] ?? '') ?>">

            <input type="text" name="search_supplier" placeholder="Search by Supplier"
                   value="<?= htmlspecialchars($_GET['search_supplier'] ?? '') ?>">

            <button type="submit" class="btn btn-secondary">🔍 Search / Filter</button>
            <a href="index.php?controller=product&action=index" class="btn btn-reset">Reset</a>
        </form>

        <!-- Products Table -->
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Quantity</th><th>Supplier</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach($products as $p): ?>
                        <tr class="<?= ($p['quantity'] < 10) ? 'low-stock' : '' ?>">
                            <td><?= htmlspecialchars($p['id']) ?></td>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['category']) ?></td>
                            <td>Rs. <?= number_format($p['price'], 2) ?></td>
                            <td><?= htmlspecialchars($p['quantity']) ?></td>
                            <td>
                                <a href="index.php?controller=supplier&action=edit&id=<?= $p['supplier_id'] ?>">
                                    <?= htmlspecialchars($p['supplier_name']) ?>
                                </a>
                            </td>
                            <td>
                                <a href="index.php?controller=product&action=edit&id=<?= $p['id'] ?>" class="btn-action">✏️ Edit</a>
                                <a href="index.php?controller=product&action=delete&id=<?= $p['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No products found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
