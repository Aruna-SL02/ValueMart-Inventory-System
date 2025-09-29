<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ValueMart</title>
    <link rel="stylesheet" href="ValueMart/common/css/style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="http://localhost/ValueMart/common/images/ValueMart_logo.png" alt="ValueMart Logo" class="logo">
        </div>

        <h2 class="login-title">Inventory Management System</h2>
        <p class="login-subtitle">Please sign in to continue</p>

        <?php if(!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="/ValueMart/common/index.php?controller=auth&action=login" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'account_deleted'): ?>
            <div style="
                margin: 10px 0; 
                padding: 10px; 
                border-radius: 5px; 
                font-size: 14px;
                background: #d4edda; 
                color: #155724; 
                border: 1px solid #c3e6cb;">
                Your account has been deleted successfully.
            </div>
        <?php endif; ?>

    </div>

</body>
</html>
