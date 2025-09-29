<?php
require_once 'Controller.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController extends Controller {

    public function login(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->verifyPassword($username, $password);

            if($user){
                // Store session values
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect to dashboard/products page
                header('Location: index.php?controller=product&action=index');
                exit;
            } else {
                // Invalid login, reload login view with error
                $error = "Invalid username or password";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            // Just show login form
            $this->view('auth/login');
        }
    }

    public function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destroy session completely
        session_unset();
        session_destroy();

        // Redirect back to login page
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
?>