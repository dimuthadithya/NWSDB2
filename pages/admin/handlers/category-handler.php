<?php
session_start();
require_once __DIR__ . '/../../../functions/DbHelper.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

// Get the action
$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            // Validate required fields
            if (empty($_POST['category_name'])) {
                $_SESSION['error_message'] = 'Category name is required.';
                header('Location: ../categories.php');
                exit();
            }

            $category_name = trim($_POST['category_name']);
            $description = trim($_POST['description'] ?? '');

            // Create category
            $result = DbHelper::createDeviceCategory($category_name, $description);

            if ($result) {
                $_SESSION['success_message'] = 'Category created successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to create category. Category name may already exist.';
            }

            header('Location: ../categories.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Invalid category ID.';
                header('Location: ../categories.php');
                exit();
            }

            if (empty($_POST['category_name'])) {
                $_SESSION['error_message'] = 'Category name is required.';
                header('Location: ../categories.php');
                exit();
            }

            $category_id = $_POST['category_id'];

            // Protected system categories that cannot have their names changed
            $protectedCategories = ['Desktop Computer', 'Laptop', 'Printer', 'Fingerprint Device', 'RVPN Device'];

            // Get current category details
            $currentCategory = DbHelper::getDeviceCategoryById($category_id);

            if (!$currentCategory) {
                $_SESSION['error_message'] = 'Category not found.';
                header('Location: ../categories.php');
                exit();
            }

            $newCategoryName = trim($_POST['category_name']);

            // If this is a protected category and the name is being changed, block it
            if (
                in_array($currentCategory['category_name'], $protectedCategories) &&
                $currentCategory['category_name'] !== $newCategoryName
            ) {
                $_SESSION['error_message'] = 'Cannot rename system category "' . htmlspecialchars($currentCategory['category_name']) . '". You can only update its description.';
                header('Location: ../categories.php');
                exit();
            }

            $data = [
                'category_name' => $newCategoryName,
                'description' => trim($_POST['description'] ?? '')
            ];

            // Update category
            $result = DbHelper::updateDeviceCategory($category_id, $data);

            if ($result) {
                $_SESSION['success_message'] = 'Category updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update category. Category name may already exist.';
            }

            header('Location: ../categories.php');
            exit();

        case 'delete':
            // Validate category ID
            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Invalid category ID.';
                header('Location: ../categories.php');
                exit();
            }

            $category_id = $_POST['category_id'];

            // Protected system categories that cannot be deleted
            $protectedCategories = ['Desktop Computer', 'Laptop', 'Printer', 'Fingerprint Device', 'RVPN Device'];

            // Get category details to check if it's protected
            $category = DbHelper::getDeviceCategoryById($category_id);

            if ($category && in_array($category['category_name'], $protectedCategories)) {
                $_SESSION['error_message'] = 'Cannot delete system category "' . htmlspecialchars($category['category_name']) . '". This category is required by the system.';
                header('Location: ../categories.php');
                exit();
            }

            // Delete category
            $result = DbHelper::deleteDeviceCategory($category_id);

            if ($result) {
                $_SESSION['success_message'] = 'Category deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete category. It may be linked to devices.';
            }

            header('Location: ../categories.php');
            exit();

        default:
            $_SESSION['error_message'] = 'Invalid action.';
            header('Location: ../categories.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../categories.php');
    exit();
}
