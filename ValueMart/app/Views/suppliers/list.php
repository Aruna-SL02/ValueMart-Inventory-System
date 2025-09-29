<!DOCTYPE html>
<html>
<head>
    <title>ValueMart - Suppliers</title>
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
        <a href="index.php?controller=product&action=index"><i class="fa fa-box"></i> Products</a>
        <a class="active" href="index.php?controller=supplier&action=index"><i class="fa fa-truck"></i> Suppliers</a>
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
        <h1 class="dashboard-title">Supplier Dashboard</h1> <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=supplier&action=add" class="btn btn-primary">➕ Add New Supplier</a>
        </div>
        <br>

        <!-- Supplier Table -->
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Contact</th><th>Email</th><th>Phone</th><th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($suppliers)): ?>
                        <?php foreach($suppliers as $s): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['id']) ?></td>
                            <td><?= htmlspecialchars($s['name']) ?></td>
                            <td><?= htmlspecialchars($s['contact']) ?></td>
                            <td><?= htmlspecialchars($s['email']) ?></td>
                            <td><?= htmlspecialchars($s['address']) ?></td>
                            <td>
                                <a href="index.php?controller=supplier&action=edit&id=<?= $s['id'] ?>" class="btn-action">✏️ Edit</a>
                                <a href="index.php?controller=supplier&action=delete&id=<?= $s['id'] ?>" class="btn-delete" onclick="return confirm('Delete this supplier?')">🗑️ Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No suppliers found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
