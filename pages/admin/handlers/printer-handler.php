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
            if (empty($_POST['device_name'])) {
                $_SESSION['error_message'] = 'Device name is required.';
                header('Location: ../../printers.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Valid category is required.';
                header('Location: ../../printers.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Valid WSS is required.';
                header('Location: ../../printers.php');
                exit();
            }

            // Prepare device data
            $deviceData = [
                'device_name' => trim($_POST['device_name']),
                'model' => trim($_POST['model'] ?? ''),
                'category_id' => $_POST['category_id'],
                'wss_id' => $_POST['wss_id'],
                'section_id' => !empty($_POST['section_id']) ? $_POST['section_id'] : null,
                'assigned_to' => trim($_POST['assigned_to'] ?? ''),
                'device_type' => trim($_POST['device_type'] ?? ''),
                'make' => trim($_POST['make'] ?? ''),
                'ip_address' => trim($_POST['ip_address'] ?? ''),
                'network_connectivity' => trim($_POST['network_connectivity'] ?? ''),
                'system_unit_serial' => trim($_POST['system_unit_serial'] ?? ''),
                'purchase_date' => !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null,
                'status' => $_POST['status'] ?? 'active',
                'notes' => trim($_POST['notes'] ?? '')
            ];

            // Create device
            $result = DbHelper::createDevice($deviceData);

            if ($result) {
                $_SESSION['success_message'] = 'Printer created successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to create printer.';
            }

            header('Location: ../../printers.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error_message'] = 'Invalid device ID.';
                header('Location: ../../printers.php');
                exit();
            }

            if (empty($_POST['device_name'])) {
                $_SESSION['error_message'] = 'Device name is required.';
                header('Location: ../../printers.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Valid category is required.';
                header('Location: ../../printers.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Valid WSS is required.';
                header('Location: ../../printers.php');
                exit();
            }

            $device_id = $_POST['device_id'];
            $data = [
                'device_name' => trim($_POST['device_name']),
                'model' => trim($_POST['model'] ?? ''),
                'category_id' => $_POST['category_id'],
                'wss_id' => $_POST['wss_id'],
                'section_id' => !empty($_POST['section_id']) ? $_POST['section_id'] : null,
                'assigned_to' => trim($_POST['assigned_to'] ?? ''),
                'device_type' => trim($_POST['device_type'] ?? ''),
                'make' => trim($_POST['make'] ?? ''),
                'ip_address' => trim($_POST['ip_address'] ?? ''),
                'network_connectivity' => trim($_POST['network_connectivity'] ?? ''),
                'system_unit_serial' => trim($_POST['system_unit_serial'] ?? ''),
                'purchase_date' => !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null,
                'status' => $_POST['status'] ?? 'active',
                'notes' => trim($_POST['notes'] ?? '')
            ];

            // Update device
            $result = DbHelper::updateDevice($device_id, $data);

            if ($result) {
                $_SESSION['success_message'] = 'Printer updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update printer.';
            }

            header('Location: ../../printers.php');
            exit();

        case 'delete':
            // Validate device ID
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error_message'] = 'Invalid device ID.';
                header('Location: ../../printers.php');
                exit();
            }

            $device_id = $_POST['device_id'];

            // Delete device
            $result = DbHelper::deleteDevice($device_id);

            if ($result) {
                $_SESSION['success_message'] = 'Printer deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete printer.';
            }

            header('Location: ../../printers.php');
            exit();

        default:
            $_SESSION['error_message'] = 'Invalid action.';
            header('Location: ../../printers.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../../printers.php');
    exit();
}
