<?php

require_once __DIR__ . '/../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile_number = trim($_POST['mobile_number']);
    $gender = trim($_POST['gender']);
    $password = $_POST['password'];
    $site_office = trim($_POST['site_office']);
    $role = 'user';

    $userId = DbHelper::createUser(
        $first_name,
        $last_name,
        $username,
        $email,
        $mobile_number,
        $gender,
        $password,
        $site_office,
        $role
    );

    if ($userId) {
        header('Location: ../login.php?registration=success');
        exit();
    } else {
        header('Location: ../register.php?registration=failed');
        exit();
    }
} else {
    header('Location: ../register.php');
    exit();
}
