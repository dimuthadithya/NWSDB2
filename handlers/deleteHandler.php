<?php
require_once __DIR__ . '/../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($_GET['action'] == 'delete_device') {
        $device_id = $_GET['device_id'] ?? null;
        $page = $_GET['page'];

        // Call the DbHelper method to delete the section
        $deleted = DbHelper::deleteDevice($device_id);

        if ($deleted) {
            // Redirect back to sections page with success message
            if ($page == 'computer') {
                header('Location: ../pages/computers.php?success=Device+deleted+successfully');
                exit();
            } elseif ($page == 'laptop') {
                header('Location: ../pages/laptops.php?success=Device+deleted+successfully');
                exit();
            } elseif ($page == 'printer') {
                header('Location: ../pages/printers.php?success=Device+deleted+successfully');
                exit();
            }
        } else {
            // Redirect back with error message
            header('Location: ../pages/index.php?error=Failed+to+delete+device');
            exit();
        }
    }
}
