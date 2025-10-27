<?php
require_once __DIR__ . '/../../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_branch'])) {
    $branch_name = trim($_POST['branch_name']);
    $branch_location = trim($_POST['branch_location']);

    $branchId = DbHelper::createBranch($branch_name, $branch_location);

    if ($branchId) {
        header('Location: ../site_offices.php?branch_add=success');
        exit();
    } else {
        header('Location: ../site_offices.php?branch_add=failed');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_device_category'])) {
    $category_name = trim($_POST['category_name']);
    $category_description = trim($_POST['description']);

    $categoryId = DbHelper::createDeviceCategory($category_name, $category_description);

    if ($categoryId) {
        header('Location: ../devices.php?category_add=success');
        exit();
    } else {
        header('Location: ../devices.php?category_add=failed');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_section'])) {
    $section_name = trim($_POST['section_name']);
    $branch_id = intval($_POST['branch_id']);

    $sectionId = DbHelper::createSection($section_name, $branch_id);

    if ($sectionId) {
        header('Location: ../sections.php?section_add=success');
        exit();
    } else {
        header('Location: ../sections.php?section_add=failed');
        exit();
    }
}
