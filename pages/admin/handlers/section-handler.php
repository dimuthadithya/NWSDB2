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
            if (empty($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Please select a water supply scheme.';
                header('Location: ../sections.php');
                exit();
            }

            if (empty($_POST['section_name'])) {
                $_SESSION['error_message'] = 'Section name is required.';
                header('Location: ../sections.php');
                exit();
            }

            $wss_id = $_POST['wss_id'];
            $section_name = trim($_POST['section_name']);

            // Create section
            $result = DbHelper::createSection($section_name, $wss_id);

            if ($result) {
                $_SESSION['success_message'] = 'Section created successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to create section. Section name may already exist.';
            }

            header('Location: ../sections.php');
            exit();
            break;

        case 'update':
            // Validate required fields
            if (empty($_POST['section_id']) || !is_numeric($_POST['section_id'])) {
                $_SESSION['error_message'] = 'Invalid section ID.';
                header('Location: ../sections.php');
                exit();
            }

            if (empty($_POST['wss_id'])) {
                $_SESSION['error_message'] = 'Please select a water supply scheme.';
                header('Location: ../sections.php');
                exit();
            }

            if (empty($_POST['section_name'])) {
                $_SESSION['error_message'] = 'Section name is required.';
                header('Location: ../sections.php');
                exit();
            }

            $section_id = $_POST['section_id'];
            $data = [
                'wss_id' => $_POST['wss_id'],
                'section_name' => trim($_POST['section_name'])
            ];

            // Update section
            $result = DbHelper::updateSection($section_id, $data);

            if ($result) {
                $_SESSION['success_message'] = 'Section updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update section. Section name may already exist.';
            }

            header('Location: ../sections.php');
            exit();
            break;

        case 'delete':
            // Validate section ID
            if (empty($_POST['section_id']) || !is_numeric($_POST['section_id'])) {
                $_SESSION['error_message'] = 'Invalid section ID.';
                header('Location: ../sections.php');
                exit();
            }

            $section_id = $_POST['section_id'];

            // Delete section
            $result = DbHelper::deleteSection($section_id);

            if ($result) {
                $_SESSION['success_message'] = 'Section deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete section. It may be linked to other records.';
            }

            header('Location: ../sections.php');
            exit();
            break;

        default:
            $_SESSION['error_message'] = 'Invalid action.';
            header('Location: ../sections.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../sections.php');
    exit();
}
