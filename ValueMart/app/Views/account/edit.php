<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
    <link rel="stylesheet" href="ValueMart/common/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">

    <!-- Sidebar (same style as other pages) -->
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
            <a href="index.php?controller=settings&action=index" ><i class="fa fa-cog"></i> Settings</a>
            <a href="index.php?controller=auth&action=logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main -->
    <div class="dashboard-container">
        <h1 class="dashboard-title">My Account</h1>
        <hr>

        <div class="dashboard-actions">
            <a href="index.php?controller=settings&action=index" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Settings</a>
        </div>
        <br>

        <?php if (!empty($success)): ?>
            <div class="error-message" style="background:#d1e7dd;color:#0f5132;border:1px solid #badbcc;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="content">

            <!-- Profile form -->
            <div class="card">
                <h2>Profile</h2>
                <form class="styled-form" method="post" action="index.php?controller=account&action=updateProfile" enctype="multipart/form-data">
                    <label>Username (read only)</label>
                    <input type="text" value="<?= htmlspecialchars($user['username'] ?? '') ?>" readonly>

                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">

                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">

                    <label for="avatar">Avatar</label>
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="ValueMart/common/images/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" style="width:100px;border-radius:50%;margin-bottom:10px;">
                    <?php endif; ?>
                    <input type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png,.gif">

                    <button type="submit">Save Profile</button>
                </form> <br>
                
                <form class="delete-btn" method="post" action="index.php?controller=account&action=deleteUser" 
                    onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                    <button type="submit" 
                        style="
                            background-color: #dc3545;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            padding: 12px 18px;
                            font-size: 16px;
                            transition: background-color 0.3s ease;
                        "
                        onmouseover="this.style.backgroundColor='#c82333';"
                        onmouseout="this.style.backgroundColor='#dc3545';"
                    >
                        Delete My Account
                    </button>
                </form>
            </div>

            <!-- Change password -->
            <div class="card" style="margin-top:20px;">
                <h2>Change Password</h2>
                <form class="styled-form" method="post" action="index.php?controller=account&action=changePassword">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required>

                    <label for="new_password">New Password (min 8 chars)</label>
                    <input type="password" name="new_password" id="new_password" minlength="8" required>

                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" minlength="8" required>

                    <button type="submit">Change Password</button>
                </form>
            </div>
            
            <!-- User Registration -->
            <div class="card" style="margin-top:20px;">
                <h2>Register New User</h2>
                <form class="styled-form" method="post" action="index.php?controller=account&action=registerUser" enctype="multipart/form-data">
                    <label for="reg_username">Username</label>
                    <input type="text" name="username" id="reg_username" required>

                    <label for="reg_password">Password</label>
                    <input type="password" name="password" id="reg_password" required>

                    <label for="reg_role">Role</label>
                    <select name="role" id="reg_role">
                        <option value="Admin">Admin</option>
                        <option value="Staff" selected>Staff</option>
                    </select>

                    <label for="reg_full_name">Full Name</label>
                    <input type="text" name="full_name" id="reg_full_name">

                    <label for="reg_email">Email</label>
                    <input type="email" name="email" id="reg_email">

                    <label for="reg_phone">Phone</label>
                    <input type="number" name="phone" id="reg_phone" min="0">

                    <label for="reg_avatar">Avatar</label>
                    <input type="file" name="avatar" id="reg_avatar" accept=".jpg,.jpeg,.png,.gif">

                    <button type="submit">Register User</button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
