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
    // CREATE - Add new region
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $region_code = trim($_POST['region_code'] ?? '');
        $region_name = trim($_POST['region_name'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validation
        if (empty($region_code)) {
            $response['message'] = 'Region code is required';
        } elseif (empty($region_name)) {
            $response['message'] = 'Region name is required';
        } else {
            // Create region
            $result = DbHelper::createRegion($region_code, $region_name, $status);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Region created successfully';
                $_SESSION['success_message'] = 'Region created successfully';
            } else {
                $response['message'] = 'Failed to create region. Region code may already exist.';
            }
        }
    }

    // UPDATE - Update existing region
    elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        $region_id = intval($_POST['region_id'] ?? 0);
        $region_code = trim($_POST['region_code'] ?? '');
        $region_name = trim($_POST['region_name'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validation
        if ($region_id <= 0) {
            $response['message'] = 'Invalid region ID';
        } elseif (empty($region_code)) {
            $response['message'] = 'Region code is required';
        } elseif (empty($region_name)) {
            $response['message'] = 'Region name is required';
        } else {
            $updateData = [
                'region_code' => $region_code,
                'region_name' => $region_name,
                'status' => $status
            ];

            $result = DbHelper::updateRegion($region_id, $updateData);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Region updated successfully';
                $_SESSION['success_message'] = 'Region updated successfully';
            } else {
                $response['message'] = 'Failed to update region';
            }
        }
    }

    // DELETE - Delete region
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $region_id = intval($_POST['region_id'] ?? 0);

        if ($region_id <= 0) {
            $response['message'] = 'Invalid region ID';
        } else {
            $result = DbHelper::deleteRegion($region_id);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Region deleted successfully';
                $_SESSION['success_message'] = 'Region deleted successfully';
            } else {
                $response['message'] = 'Failed to delete region. It may be linked to other records.';
            }
        }
    } else {
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
    // Redirect back to regions page for non-AJAX requests
    if ($response['success']) {
        header('Location: ../regions.php?success=1');
    } else {
        $_SESSION['error_message'] = $response['message'];
        header('Location: ../regions.php?error=1');
    }
}
exit;
