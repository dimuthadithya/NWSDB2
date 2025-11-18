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
            if (empty($_POST['location_name'])) {
                $_SESSION['error'] = 'Location name is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error'] = 'Valid category is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error'] = 'Valid WSS is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['make'])) {
                $_SESSION['error'] = 'Make is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['model'])) {
                $_SESSION['error'] = 'Model is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['device_type'])) {
                $_SESSION['error'] = 'Device type is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['device_number'])) {
                $_SESSION['error'] = 'Device number is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['identification_code'])) {
                $_SESSION['error'] = 'Identification code is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            // Prepare device data
            $deviceData = [
                'device_name' => trim($_POST['location_name']) . ' - ' . trim($_POST['device_number']),
                'category_id' => $_POST['category_id'],
                'wss_id' => $_POST['wss_id'],
                'section_id' => !empty($_POST['section_id']) ? $_POST['section_id'] : null,
                'location_name' => trim($_POST['location_name']),
                'sub_location' => trim($_POST['sub_location'] ?? ''),
                'make' => trim($_POST['make']),
                'model' => trim($_POST['model']),
                'device_type' => trim($_POST['device_type']),
                'device_number' => trim($_POST['device_number']),
                'identification_code' => trim($_POST['identification_code']),
                'ip_address_adsl' => trim($_POST['ip_address_adsl'] ?? ''),
                'installed_date' => !empty($_POST['installed_date']) ? $_POST['installed_date'] : null,
                'company_name' => trim($_POST['company_name'] ?? ''),
                'device_cost' => !empty($_POST['device_cost']) ? $_POST['device_cost'] : null,
                'warranty_period' => trim($_POST['warranty_period'] ?? ''),
                'port_number' => trim($_POST['port_number'] ?? ''),
                'managed_by' => trim($_POST['managed_by'] ?? ''),
                'assigned_to' => trim($_POST['assigned_to'] ?? ''),
                'approval_status' => $_POST['approval_status'] ?? 'pending',
                'remark' => trim($_POST['remark'] ?? ''),
                'status' => $_POST['status'] ?? 'active'
            ];

            // Create device
            $result = DbHelper::createDevice($deviceData);

            if ($result) {
                $_SESSION['success'] = 'Fingerprint device created successfully!';
            } else {
                $_SESSION['error'] = 'Failed to create fingerprint device.';
            }

            header('Location: ../../finger-device.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error'] = 'Invalid device ID.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['location_name'])) {
                $_SESSION['error'] = 'Location name is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error'] = 'Valid category is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error'] = 'Valid WSS is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['make'])) {
                $_SESSION['error'] = 'Make is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['model'])) {
                $_SESSION['error'] = 'Model is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['device_type'])) {
                $_SESSION['error'] = 'Device type is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['device_number'])) {
                $_SESSION['error'] = 'Device number is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            if (empty($_POST['identification_code'])) {
                $_SESSION['error'] = 'Identification code is required.';
                header('Location: ../../finger-device.php');
                exit();
            }

            $device_id = $_POST['device_id'];
            $data = [
                'device_name' => trim($_POST['location_name']) . ' - ' . trim($_POST['device_number']),
                'category_id' => $_POST['category_id'],
                'wss_id' => $_POST['wss_id'],
                'section_id' => !empty($_POST['section_id']) ? $_POST['section_id'] : null,
                'location_name' => trim($_POST['location_name']),
                'sub_location' => trim($_POST['sub_location'] ?? ''),
                'make' => trim($_POST['make']),
                'model' => trim($_POST['model']),
                'device_type' => trim($_POST['device_type']),
                'device_number' => trim($_POST['device_number']),
                'identification_code' => trim($_POST['identification_code']),
                'ip_address_adsl' => trim($_POST['ip_address_adsl'] ?? ''),
                'installed_date' => !empty($_POST['installed_date']) ? $_POST['installed_date'] : null,
                'company_name' => trim($_POST['company_name'] ?? ''),
                'device_cost' => !empty($_POST['device_cost']) ? $_POST['device_cost'] : null,
                'warranty_period' => trim($_POST['warranty_period'] ?? ''),
                'port_number' => trim($_POST['port_number'] ?? ''),
                'managed_by' => trim($_POST['managed_by'] ?? ''),
                'assigned_to' => trim($_POST['assigned_to'] ?? ''),
                'approval_status' => $_POST['approval_status'] ?? 'pending',
                'remark' => trim($_POST['remark'] ?? ''),
                'status' => $_POST['status'] ?? 'active'
            ];

            // Update device
            $result = DbHelper::updateDevice($device_id, $data);

            if ($result) {
                $_SESSION['success'] = 'Fingerprint device updated successfully!';
            } else {
                $_SESSION['error'] = 'Failed to update fingerprint device.';
            }

            header('Location: ../../finger-device.php');
            exit();

        case 'delete':
            // Validate device ID
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error'] = 'Invalid device ID.';
                header('Location: ../../finger-device.php');
                exit();
            }

            $device_id = $_POST['device_id'];

            // Delete device
            $result = DbHelper::deleteDevice($device_id);

            if ($result) {
                $_SESSION['success'] = 'Fingerprint device deleted successfully!';
            } else {
                $_SESSION['error'] = 'Failed to delete fingerprint device.';
            }

            header('Location: ../../finger-device.php');
            exit();

        default:
            $_SESSION['error'] = 'Invalid action.';
            header('Location: ../../finger-device.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../../finger-device.php');
    exit();
}
