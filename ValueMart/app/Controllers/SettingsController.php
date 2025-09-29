<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Settings.php';
require_once __DIR__ . '/../Models/Settings.php';
require_once __DIR__ . '/../Models/ShopInfo.php';
require_once __DIR__ . '/../Models/InventorySettings.php';
require_once __DIR__ . '/../Models/SecuritySettings.php';

class SettingsController {
    private $settingsModel;
    private $shopModel;
    private $inventoryModel;
    private $securityModel;

    public function __construct() {
        // Create database instance and get connection
        $database = new Database();
        $db = $database->getConnection();

        // Pass PDO to the model
        $this->settingsModel = new Settings($db);
        $this->shopModel = new ShopInfo($db);
        $this->inventoryModel = new InventorySettings($db);
        $this->securityModel = new SecuritySettings($db);
    }

    public function index() {
        $settings = $this->settingsModel->getAll();
        $shopInfo = $this->shopModel->getAll();
        $inventory = $this->inventoryModel->getAll();
        $security = $this->securityModel->getAll();

        require_once __DIR__ . '/../Views/settings/list.php';
    }

    public function updateShopInfo() {
        if ($_POST) {
            $success = false;

            foreach ($_POST as $key => $value) {
                if ($this->shopModel->update($key, $value)) {
                    $success = true;
                }
            }

            // Handle file upload
            if (!empty($_FILES['shop_logo']['name'])) {
                $filename = basename($_FILES['shop_logo']['name']);
                move_uploaded_file($_FILES['shop_logo']['tmp_name'], __DIR__ . '/../../../common/images/' . $filename);
                $this->shopModel->update('shop_logo', $filename);
                $success = true;
            }

            // Store success/failure in session
            session_start();
            $_SESSION['flash_message'] = $success ? "Shop info updated successfully." : "Failed to update shop info.";

            header("Location: index.php?controller=settings&action=editShopInfo");
            exit();
        }
    }

    public function updateInventory() {
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $this->inventoryModel->update($key, $value);
            }
            header("Location: index.php?controller=settings&action=index");
        }
    }

    public function updateSecurity() {
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $this->securityModel->update($key, $value);
            }
            header("Location: index.php?controller=settings&action=index");
        }
    }

    public function update() {
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $this->settingsModel->update($key, $value);
            }
            header("Location: index.php?controller=settings&action=index");
            exit;
        }
    }

    public function editShopInfo() {
        $settings = $this->settingsModel->getAll();
        require_once __DIR__ . '/../Views/settings/editShopInfo.php';
    }

    public function editInventory() {
        $settings = $this->settingsModel->getAll();
        require_once __DIR__ . '/../Views/settings/editInventory.php';
    }

    public function editSecurity() {
        $settings = $this->settingsModel->getAll();
        require_once __DIR__ . '/../Views/settings/editSecurity.php';
    }

}
?>