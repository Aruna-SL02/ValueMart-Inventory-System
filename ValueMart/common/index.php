<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  

<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Prevent browser from caching protected pages
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Redirect to login if not logged in
    if (!isset($_SESSION['user_id']) && !($_GET['controller'] === 'auth' && $_GET['action'] === 'login')) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    // Determine controller and action from URL query params
    $controller = $_GET['controller'] ?? 'product';
    $action = $_GET['action'] ?? 'index';

    // Only show nav if not on login page
    if(!($controller === 'auth' && $action === 'login')): ?>
        <nav>
            <a href="index.php?controller=product&action=index">  </a>    
            <a href="index.php?controller=sale&action=index"> </a>  
            <a href="index.php?controller=supplier&action=index"> </a>  
            <a href="index.php?controller=report&action=index"> </a>   
            <a href="index.php?controller=settings&action=index"></a>
        </nav>
        <hr>
    <?php endif; 



    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // rest of your code...

    // Simple front controller and router

    // Basic autoloader for classes (Controller, Model)
    spl_autoload_register(function($class){
        $paths = [
            __DIR__ . '/../app/Controllers/' . $class . '.php',
            __DIR__ . '/../app/Models/' . $class . '.php',
        ];
        foreach($paths as $path){
            if(file_exists($path)){
                require_once $path;
                return;
            }
        }
    });

    // Determine controller and action from URL query params
    $controller = $_GET['controller'] ?? 'product';
    $action = $_GET['action'] ?? 'index';

    $controllerClass = ucfirst($controller) . 'Controller';

    // Check if controller class exists
    if(class_exists($controllerClass)){
        $ctrl = new $controllerClass();
        if(method_exists($ctrl, $action)){
            $ctrl->{$action}();
        } else {
            echo "Action '$action' not found!";
        }
    } else {
        echo "Controller '$controllerClass' not found!";
    }
?>

</body>
</html>


