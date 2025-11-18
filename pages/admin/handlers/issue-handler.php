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
                header('Location: ../../issues.php');
                exit();
            }

            if (empty($_POST['issue_title'])) {
                $_SESSION['error'] = 'Issue title is required.';
                header('Location: ../../issues.php');
                exit();
            }

            // Prepare issue data
            $issueData = [
                'device_id' => $_POST['device_id'],
                'reported_by' => $_SESSION['user']['user_id'] ?? null,
                'issue_title' => trim($_POST['issue_title']),
                'issue_description' => trim($_POST['issue_description'] ?? ''),
                'priority' => $_POST['priority'] ?? 'medium',
                'status' => $_POST['status'] ?? 'open'
            ];

            // Create issue
            $result = DbHelper::createIssue($issueData);

            if ($result) {
                $_SESSION['success'] = 'Issue created successfully!';
            } else {
                $_SESSION['error'] = 'Failed to create issue.';
            }

            header('Location: ../../issues.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['issue_id']) || !is_numeric($_POST['issue_id'])) {
                $_SESSION['error'] = 'Invalid issue ID.';
                header('Location: ../../issues.php');
                exit();
            }

            if (empty($_POST['device_id']) || !is_numeric($_POST['device_id'])) {
                $_SESSION['error'] = 'Valid device is required.';
                header('Location: ../../issues.php');
                exit();
            }

            if (empty($_POST['issue_title'])) {
                $_SESSION['error'] = 'Issue title is required.';
                header('Location: ../../issues.php');
                exit();
            }

            $issue_id = $_POST['issue_id'];
            $data = [
                'device_id' => $_POST['device_id'],
                'issue_title' => trim($_POST['issue_title']),
                'issue_description' => trim($_POST['issue_description'] ?? ''),
                'priority' => $_POST['priority'] ?? 'medium',
                'status' => $_POST['status'] ?? 'open'
            ];

            // If status is being changed to resolved/closed, set resolved_at
            if (in_array($_POST['status'], ['resolved', 'closed'])) {
                $data['resolved_at'] = date('Y-m-d H:i:s');
            }

            // Update issue
            $result = DbHelper::updateIssue($issue_id, $data);

            if ($result) {
                $_SESSION['success'] = 'Issue updated successfully!';
            } else {
                $_SESSION['error'] = 'Failed to update issue.';
            }

            header('Location: ../../issues.php');
            exit();

        case 'delete':
            // Validate issue ID
            if (empty($_POST['issue_id']) || !is_numeric($_POST['issue_id'])) {
                $_SESSION['error'] = 'Invalid issue ID.';
                header('Location: ../../issues.php');
                exit();
            }

            $issue_id = $_POST['issue_id'];

            // Delete issue
            $result = DbHelper::deleteIssue($issue_id);

            if ($result) {
                $_SESSION['success'] = 'Issue deleted successfully!';
            } else {
                $_SESSION['error'] = 'Failed to delete issue.';
            }

            header('Location: ../../issues.php');
            exit();

        default:
            $_SESSION['error'] = 'Invalid action.';
            header('Location: ../../issues.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../../issues.php');
    exit();
}
