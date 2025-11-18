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
            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error'] = 'Valid device is required.';
                header('Location: ../../repairs.php');
                exit();
            }

            if (empty($_POST['repair_details'])) {
                $_SESSION['error'] = 'Repair details are required.';
                header('Location: ../../repairs.php');
                exit();
            }

            if (empty($_POST['repair_date'])) {
                $_SESSION['error'] = 'Repair date is required.';
                header('Location: ../../repairs.php');
                exit();
            }

            // Prepare repair data
            $repairData = [
                'device_id' => $_POST['device_id'],
                'repair_details' => trim($_POST['repair_details']),
                'repair_date' => $_POST['repair_date'],
                'cost' => !empty($_POST['cost']) ? $_POST['cost'] : null,
                'status' => $_POST['status'] ?? 'pending',
                'notes' => trim($_POST['notes'] ?? '')
            ];

            // Create repair
            $result = DbHelper::createRepair($repairData);

            if ($result) {
                $_SESSION['success'] = 'Repair record created successfully!';
            } else {
                $_SESSION['error'] = 'Failed to create repair record.';
            }

            header('Location: ../../repairs.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['repair_id']) || !is_numeric($_POST['repair_id'])) {
                $_SESSION['error'] = 'Invalid repair ID.';
                header('Location: ../../repairs.php');
                exit();
            }

            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error'] = 'Valid device is required.';
                header('Location: ../../repairs.php');
                exit();
            }

            if (empty($_POST['repair_details'])) {
                $_SESSION['error'] = 'Repair details are required.';
                header('Location: ../../repairs.php');
                exit();
            }

            if (empty($_POST['repair_date'])) {
                $_SESSION['error'] = 'Repair date is required.';
                header('Location: ../../repairs.php');
                exit();
            }

            $repair_id = $_POST['repair_id'];
            $data = [
                'device_id' => $_POST['device_id'],
                'repair_details' => trim($_POST['repair_details']),
                'repair_date' => $_POST['repair_date'],
                'cost' => !empty($_POST['cost']) ? $_POST['cost'] : null,
                'status' => $_POST['status'] ?? 'pending',
                'notes' => trim($_POST['notes'] ?? '')
            ];

            // Update repair
            $result = DbHelper::updateRepair($repair_id, $data);

            if ($result) {
                $_SESSION['success'] = 'Repair record updated successfully!';
            } else {
                $_SESSION['error'] = 'Failed to update repair record.';
            }

            header('Location: ../../repairs.php');
            exit();

        case 'delete':
            // Validate repair ID
            if (empty($_POST['repair_id']) || !is_numeric($_POST['repair_id'])) {
                $_SESSION['error'] = 'Invalid repair ID.';
                header('Location: ../../repairs.php');
                exit();
            }

            $repair_id = $_POST['repair_id'];

            // Delete repair
            $result = DbHelper::deleteRepair($repair_id);

            if ($result) {
                $_SESSION['success'] = 'Repair record deleted successfully!';
            } else {
                $_SESSION['error'] = 'Failed to delete repair record.';
            }

            header('Location: ../../repairs.php');
            exit();

        default:
            $_SESSION['error'] = 'Invalid action.';
            header('Location: ../../repairs.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../../repairs.php');
    exit();
}
