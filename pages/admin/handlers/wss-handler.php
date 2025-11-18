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
    // CREATE - Add new water supply scheme
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $area_id = intval($_POST['area_id'] ?? 0);
        $wss_code = trim($_POST['wss_code'] ?? '');
        $wss_name = trim($_POST['wss_name'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validation
        if ($area_id <= 0) {
            $response['message'] = 'Please select an area';
        } elseif (empty($wss_code)) {
            $response['message'] = 'Water supply scheme code is required';
        } elseif (empty($wss_name)) {
            $response['message'] = 'Water supply scheme name is required';
        } else {
            // Create water supply scheme
            $result = DbHelper::createWaterSupplyScheme($area_id, $wss_code, $wss_name, $status);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Water supply scheme created successfully';
                $_SESSION['success_message'] = 'Water supply scheme created successfully';
            } else {
                $response['message'] = 'Failed to create water supply scheme. Scheme code may already exist.';
            }
        }
    }

    // UPDATE - Update existing water supply scheme
    elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        $wss_id = intval($_POST['wss_id'] ?? 0);
        $area_id = intval($_POST['area_id'] ?? 0);
        $wss_code = trim($_POST['wss_code'] ?? '');
        $wss_name = trim($_POST['wss_name'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validation
        if ($wss_id <= 0) {
            $response['message'] = 'Invalid water supply scheme ID';
        } elseif ($area_id <= 0) {
            $response['message'] = 'Please select an area';
        } elseif (empty($wss_code)) {
            $response['message'] = 'Water supply scheme code is required';
        } elseif (empty($wss_name)) {
            $response['message'] = 'Water supply scheme name is required';
        } else {
            $updateData = [
                'area_id' => $area_id,
                'wss_code' => $wss_code,
                'wss_name' => $wss_name,
                'status' => $status
            ];

            $result = DbHelper::updateWaterSupplyScheme($wss_id, $updateData);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Water supply scheme updated successfully';
                $_SESSION['success_message'] = 'Water supply scheme updated successfully';
            } else {
                $response['message'] = 'Failed to update water supply scheme';
            }
        }
    }

    // DELETE - Delete water supply scheme
    elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $wss_id = intval($_POST['wss_id'] ?? 0);

        if ($wss_id <= 0) {
            $response['message'] = 'Invalid water supply scheme ID';
        } else {
            $result = DbHelper::deleteWaterSupplyScheme($wss_id);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Water supply scheme deleted successfully';
                $_SESSION['success_message'] = 'Water supply scheme deleted successfully';
            } else {
                $response['message'] = 'Failed to delete water supply scheme. It may be linked to sections.';
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
    // Redirect back to water-schemes page for non-AJAX requests
    if ($response['success']) {
        header('Location: ../water-schemes.php?success=1');
    } else {
        $_SESSION['error_message'] = $response['message'];
        header('Location: ../water-schemes.php?error=1');
    }
}
exit;
