<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/User.php';

class AccountController {
    private $pdo;
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Block if not logged in (front controller also enforces)
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $this->pdo = (new Database())->getConnection();
        $this->userModel = new User($this->pdo);
    }

    public function edit() {
        $userId = (int) $_SESSION['user_id'];
        $user = $this->userModel->getById($userId);

        // For flash-like messages
        $success = $_GET['success'] ?? '';
        $error   = $_GET['error'] ?? '';

        require __DIR__ . '/../Views/account/edit.php';
    }

    public function updateProfile() {
        $userId = (int) $_SESSION['user_id'];

        $full_name = trim($_POST['full_name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $phone     = trim($_POST['phone'] ?? '');

        // Handle optional avatar upload
        $avatarName = null;
        if (!empty($_FILES['avatar']['name'])) {
            $uploadDir = realpath(__DIR__ . '/../../common/images'); // /ValueMart/common/images
            if (!$uploadDir) {
                $this->redirectWith('account','edit','', 'Upload path error');
            }

            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif'])) {
                $this->redirectWith('account','edit','', 'Invalid image type');
            }

            $newName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
            $dest = $uploadDir . DIRECTORY_SEPARATOR . $newName;

            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
                $this->redirectWith('account','edit','', 'Failed to upload image');
            }
            $avatarName = $newName;
        }

        $data = [
            'full_name' => $full_name,
            'email'     => $email,
            'phone'     => $phone
        ];
        if ($avatarName) $data['avatar'] = $avatarName;

        $this->userModel->updateProfile($userId, $data);
        $this->redirectWith('account','edit','Profile updated successfully','');
    }

    public function deleteUser() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit;
    }

    $userId = $_SESSION['user_id'];

    $userModel = new User($this->pdo);
        if ($userModel->deleteById($userId)) {
            // Clear session
            session_destroy();
            header("Location: index.php?controller=auth&action=login&msg=account_deleted");
            exit;
        } else {
            echo "<p style='color:red;'>Failed to delete account. Please try again.</p>";
        }
    }

    public function changePassword() {
        $userId = (int) $_SESSION['user_id'];

        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (strlen($new) < 8) {
            $this->redirectWith('account','edit','', 'New password must be at least 8 characters');
        }
        if ($new !== $confirm) {
            $this->redirectWith('account','edit','', 'New passwords do not match');
        }

        $res = $this->userModel->changePassword($userId, $current, $new);
        if (!$res['ok']) {
            $this->redirectWith('account','edit','', $res['error'] ?? 'Failed to change password');
        }

        $this->redirectWith('account','edit','Password changed successfully','');
    }

    private function redirectWith($controller,$action,$success='',$error='') {
        $qs = [];
        if ($success) $qs[] = 'success='.urlencode($success);
        if ($error)   $qs[] = 'error='.urlencode($error);
        $suffix = $qs ? '&'.implode('&',$qs) : '';
        header("Location: index.php?controller={$controller}&action={$action}{$suffix}");
        exit;
    }

    public function registerUser() {
        $userModel = new User();

        // Handle avatar upload
        $avatar = null;
        if (!empty($_FILES['avatar']['name'])) {
            $filename = time() . "_" . basename($_FILES['avatar']['name']);
            $target = __DIR__ . "/../../common/images/" . $filename;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
                $avatar = $filename;
            }
        }

        $data = [
            'username'  => $_POST['username'],
            'password'  => $_POST['password'], // plain text
            'role'      => $_POST['role'],
            'full_name' => $_POST['full_name'],
            'email'     => $_POST['email'],
            'phone'     => $_POST['phone'],
            'avatar'    => $avatar
        ];

        if ($userModel->register($data)) {
            $success = "User registered successfully!";
        } else {
            $error = "Failed to register user.";
        }

        // reload account page with messages
        require __DIR__ . "/../Views/account/edit.php";
    }

}
?>