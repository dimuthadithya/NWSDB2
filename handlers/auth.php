<?php

require_once __DIR__ . '/../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $password = $_POST['password'];
    $role = 'user';

    $userId = DbHelper::createUser(
        $first_name,
        $last_name,
        $email,
        $gender,
        $password,
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Handle login logic here
} else {
    header('Location: ../index.php');
    exit();
}
