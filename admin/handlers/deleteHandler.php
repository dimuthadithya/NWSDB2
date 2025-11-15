<?php
require_once __DIR__ . '/../../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'delete_branch' && isset($_GET['branch_id'])) {
        $branch_id = intval($_GET['branch_id']);

        // Call the DbHelper method to delete the branch
        $deleted = DbHelper::deleteBranch($branch_id);

        if ($deleted) {
            // Redirect back to site offices page with success message
            header('Location: ../../pages/site-offices.php?message=Branch+deleted+successfully');
            exit();
        } else {
            // Redirect back with error message
            header('Location: ../../pages/site-offices.php?error=Failed+to+delete+branch');
            exit();
        }
    }

    if ($action === 'delete_device_category' && isset($_GET['category_id'])) {
        $category_id = intval($_GET['category_id']);

        // Call the DbHelper method to delete the device category
        $deleted = DbHelper::deleteDeviceCategory($category_id);

        if ($deleted) {
            // Redirect back to devices page with success message
            header('Location: ../devices.php?message=Device+category+deleted+successfully');
            exit();
        } else {
            // Redirect back with error message
            header('Location: ../devices.php?error=Failed+to+delete+device+category');
            exit();
        }
    }

    if ($action === 'delete_section' && isset($_GET['section_id'])) {
        $section_id = intval($_GET['section_id']);

        // Call the DbHelper method to delete the section
        $deleted = DbHelper::deleteSection($section_id);

        if ($deleted) {
            // Redirect back to sections page with success message
            header('Location: ../sections.php?message=Section+deleted+successfully');
            exit();
        } else {
            // Redirect back with error message
            header('Location: ../sections.php?error=Failed+to+delete+section');
            exit();
        }
    }
}
