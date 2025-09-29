<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Add Supplier</title>
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
        <a class="active" href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
        <a href="index.php?controller=sale&action=index"><i class="fa fa-shopping-cart"></i> Sales</a>
        <a href="index.php?controller=report&action=index"><i class="fa fa-chart-line"></i> Reports</a>

        <div class="sidebar-footer">
            <a href="index.php?controller=settings&action=index"><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h1 class="dashboard-title">➕ Add New Supplier</h1>
        <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=supplier&action=index" class="btn btn-secondary">⬅ Back to Suppliers</a>
        </div>
        <br>

        <!-- Supplier Form -->
        <div class="form-container">
            <form action="" method="post" class="styled-form">
                <label for="name">Supplier Name</label>
                <input type="text" id="name" name="name" required>

                <label for="contact">Contact Number</label>
                <input type="number" id="contact" name="contact" min="0" >

                <label for="email">Email</label>
                <input type="email" id="email" name="email">

                <label for="address">Address</label>
                <textarea id="address" name="address"></textarea>

                <button type="submit" class="btn btn-primary">💾 Save Supplier</button>
            </form>
        </div>
    </div>

</body>
</html>
