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
                header('Location: ../computers.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Valid category is required.';
                header('Location: ../computers.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Valid WSS is required.';
                header('Location: ../computers.php');
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
                'operating_system' => trim($_POST['operating_system'] ?? ''),
                'processor' => trim($_POST['processor'] ?? ''),
                'ram' => trim($_POST['ram'] ?? ''),
                'hard_drive_capacity' => trim($_POST['hard_drive_capacity'] ?? ''),

                'network_connectivity' => trim($_POST['network_connectivity'] ?? ''),
                'printer_connectivity' => trim($_POST['printer_connectivity'] ?? ''),
                'virus_guard' => trim($_POST['virus_guard'] ?? ''),
                'ip_address' => trim($_POST['ip_address'] ?? ''),
                'monitor_info' => trim($_POST['monitor_info'] ?? ''),
                'system_unit_serial' => trim($_POST['system_unit_serial'] ?? ''),
                'ups_serial' => trim($_POST['ups_serial'] ?? ''),
                'purchase_date' => !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null,
                'status' => $_POST['status'] ?? 'active',

                'notes' => trim($_POST['notes'] ?? ''),
                'has_speaker' => isset($_POST['has_speaker']) ? 1 : 0,
                'has_camera' => isset($_POST['has_camera']) ? 1 : 0,
                'has_mouse' => isset($_POST['has_mouse']) ? 1 : 0,
                'has_web_cam' => isset($_POST['has_web_cam']) ? 1 : 0,
                'has_keyboard' => isset($_POST['has_keyboard']) ? 1 : 0
            ];

            // Create device
            $result = DbHelper::createDevice($deviceData);

            if ($result) {
                $_SESSION['success_message'] = 'Computer created successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to create computer.';
            }

            header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error_message'] = 'Invalid device ID.';
                header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
                exit();
            }

            if (empty($_POST['device_name'])) {
                $_SESSION['error_message'] = 'Device name is required.';
                header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Valid category is required.';
                header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Valid WSS is required.';
                header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
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
                'operating_system' => trim($_POST['operating_system'] ?? ''),
                'processor' => trim($_POST['processor'] ?? ''),
                'ram' => trim($_POST['ram'] ?? ''),
                'hard_drive_capacity' => trim($_POST['hard_drive_capacity'] ?? ''),
                'network_connectivity' => trim($_POST['network_connectivity'] ?? ''),
                'printer_connectivity' => trim($_POST['printer_connectivity'] ?? ''),
                'virus_guard' => trim($_POST['virus_guard'] ?? ''),
                'ip_address' => trim($_POST['ip_address'] ?? ''),
                'monitor_info' => trim($_POST['monitor_info'] ?? ''),
                'system_unit_serial' => trim($_POST['system_unit_serial'] ?? ''),
                'ups_serial' => trim($_POST['ups_serial'] ?? ''),
                'purchase_date' => !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null,
                'status' => $_POST['status'] ?? 'active',
                'notes' => trim($_POST['notes'] ?? ''),
                'has_speaker' => isset($_POST['has_speaker']) ? 1 : 0,
                'has_camera' => isset($_POST['has_camera']) ? 1 : 0,
                'has_mouse' => isset($_POST['has_mouse']) ? 1 : 0,
                'has_web_cam' => isset($_POST['has_web_cam']) ? 1 : 0,
                'has_keyboard' => isset($_POST['has_keyboard']) ? 1 : 0
            ];

            // Update device
            $result = DbHelper::updateDevice($device_id, $data);

            if ($result) {
                $_SESSION['success_message'] = 'Computer updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update computer.';
            }

            header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
            exit();

        case 'delete':
            // Validate device ID
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error_message'] = 'Invalid device ID.';
                header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
                exit();
            }

            $device_id = $_POST['device_id'];

            // Delete device
            $result = DbHelper::deleteDevice($device_id);

            if ($result) {
                $_SESSION['success_message'] = 'Computer deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete computer.';
            }

            header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
            exit();

        default:
            $_SESSION['error_message'] = 'Invalid action.';
            header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = 'An error occurred: ' . $e->getMessage();
    header("Location: " . ($_POST['redirect_to'] ?? '../../computers.php'));
    exit();
}
