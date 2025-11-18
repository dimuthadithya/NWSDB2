<?php
session_start();
require_once __DIR__ . '/../../../functions/DbHelper.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$response = ['success' => false, 'message' => ''];

try {
    // CREATE - Add new area
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $region_id = intval($_POST['region_id'] ?? 0);
        $area_code = trim($_POST['area_code'] ?? '');
        $area_name = trim($_POST['area_name'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validation
        if ($region_id <= 0) {
            $response['message'] = 'Please select a region';
        } elseif (empty($area_code)) {
            $response['message'] = 'Area code is required';
        } elseif (empty($area_name)) {
            $response['message'] = 'Area name is required';
        } else {
            // Create area
            $result = DbHelper::createArea($region_id, $area_code, $area_name, $status);
            
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Area created successfully';
                $_SESSION['success_message'] = 'Area created successfully';
            } else {
                $response['message'] = 'Failed to create area. Area code may already exist.';
            }
        }
    }
    
    // UPDATE - Update existing area
    elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        $area_id = intval($_POST['area_id'] ?? 0);
        $region_id = intval($_POST['region_id'] ?? 0);
        $area_code = trim($_POST['area_code'] ?? '');
        $area_name = trim($_POST['area_name'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validation
        if ($area_id <= 0) {
            $response['message'] = 'Invalid area ID';
        } elseif ($region_id <= 0) {
            $response['message'] = 'Please select a region';
        } elseif (empty($area_code)) {
            $response['message'] = 'Area code is required';
        } elseif (empty($area_name)) {
            $response['message'] = 'Area name is required';
        } else {
            $updateData = [
                'region_id' => $region_id,
                'area_code' => $area_code,
                'area_name' => $area_name,
                'status' => $status
            ];
            
            $result = DbHelper::updateArea($area_id, $updateData);
            
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Area updated successfully';
                $_SESSION['success_message'] = 'Area updated successfully';
            } else {
                $response['message'] = 'Failed to update area';
            }
        }
    }
    
    // DELETE - Delete area
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $area_id = intval($_POST['area_id'] ?? 0);

        if ($area_id <= 0) {
            $response['message'] = 'Invalid area ID';
        } else {
            $result = DbHelper::deleteArea($area_id);
            
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Area deleted successfully';
                $_SESSION['success_message'] = 'Area deleted successfully';
            } else {
                $response['message'] = 'Failed to delete area. It may be linked to water supply schemes.';
            }
        }
    }
    
    else {
        $response['message'] = 'Invalid action';
    }
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Return JSON response for AJAX requests
if (isset($_POST['ajax']) && $_POST['ajax'] === '1') {
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Redirect back to areas page for non-AJAX requests
    if ($response['success']) {
        header('Location: ../areas.php?success=1');
    } else {
        $_SESSION['error_message'] = $response['message'];
        header('Location: ../areas.php?error=1');
    }
}
exit;
