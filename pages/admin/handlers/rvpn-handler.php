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
                $_SESSION['error_message'] = 'Name of RVPN User is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Valid category is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Valid WSS is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['employee_number'])) {
                $_SESSION['error_message'] = 'Employee Number is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['designation'])) {
                $_SESSION['error_message'] = 'Designation is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['working_location'])) {
                $_SESSION['error_message'] = 'Working Location is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['rvpn_serial_number'])) {
                $_SESSION['error_message'] = 'Serial Number is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['rvpn_username'])) {
                $_SESSION['error_message'] = 'Username is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            // Prepare device data
            $deviceData = [
                'device_name' => trim($_POST['device_name']),
                'category_id' => $_POST['category_id'],
                'wss_id' => $_POST['wss_id'],
                'section_id' => !empty($_POST['section_id']) ? $_POST['section_id'] : null,
                'employee_number' => trim($_POST['employee_number']),
                'designation' => trim($_POST['designation']),
                'working_location' => trim($_POST['working_location']),
                'cost_code' => trim($_POST['cost_code'] ?? ''),
                'rvpn_serial_number' => trim($_POST['rvpn_serial_number']),
                'rvpn_username' => trim($_POST['rvpn_username']),
                'pin_number' => trim($_POST['pin_number'] ?? ''),
                'connection_required' => $_POST['connection_required'] ?? 'not_required',
                'status' => $_POST['status'] ?? 'active',
                'notes' => trim($_POST['notes'] ?? '')
            ];

            // Create device
            $result = DbHelper::createDevice($deviceData);

            if ($result) {
                $_SESSION['success_message'] = 'RVPN Connection created successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to create RVPN Connection.';
            }

            header('Location: ../../rvpn-connections.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error_message'] = 'Invalid device ID.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['device_name'])) {
                $_SESSION['error_message'] = 'Name of RVPN User is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['category_id']) || !is_numeric($_POST['category_id'])) {
                $_SESSION['error_message'] = 'Valid category is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['wss_id']) || !is_numeric($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Valid WSS is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['employee_number'])) {
                $_SESSION['error_message'] = 'Employee Number is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['designation'])) {
                $_SESSION['error_message'] = 'Designation is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['working_location'])) {
                $_SESSION['error_message'] = 'Working Location is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['rvpn_serial_number'])) {
                $_SESSION['error_message'] = 'Serial Number is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            if (empty($_POST['rvpn_username'])) {
                $_SESSION['error_message'] = 'Username is required.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            $device_id = $_POST['device_id'];
            $data = [
                'device_name' => trim($_POST['device_name']),
                'category_id' => $_POST['category_id'],
                'wss_id' => $_POST['wss_id'],
                'section_id' => !empty($_POST['section_id']) ? $_POST['section_id'] : null,
                'employee_number' => trim($_POST['employee_number']),
                'designation' => trim($_POST['designation']),
                'working_location' => trim($_POST['working_location']),
                'cost_code' => trim($_POST['cost_code'] ?? ''),
                'rvpn_serial_number' => trim($_POST['rvpn_serial_number']),
                'rvpn_username' => trim($_POST['rvpn_username']),
                'pin_number' => trim($_POST['pin_number'] ?? ''),
                'connection_required' => $_POST['connection_required'] ?? 'not_required',
                'status' => $_POST['status'] ?? 'active',
                'notes' => trim($_POST['notes'] ?? '')
            ];

            // Update device
            $result = DbHelper::updateDevice($device_id, $data);

            if ($result) {
                $_SESSION['success_message'] = 'RVPN Connection updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update RVPN Connection.';
            }

            header('Location: ../../rvpn-connections.php');
            exit();

        case 'delete':
            // Validate device ID
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error_message'] = 'Invalid device ID.';
                header('Location: ../../rvpn-connections.php');
                exit();
            }

            $device_id = $_POST['device_id'];

            // Delete device
            $result = DbHelper::deleteDevice($device_id);

            if ($result) {
                $_SESSION['success_message'] = 'RVPN Connection deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete RVPN Connection.';
            }

            header('Location: ../../rvpn-connections.php');
            exit();

        default:
            $_SESSION['error_message'] = 'Invalid action.';
            header('Location: ../../rvpn-connections.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../../rvpn-connections.php');
    exit();
}
