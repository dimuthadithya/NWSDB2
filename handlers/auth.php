<?php
require_once __DIR__ . '/../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // register handler 
    if (isset($_POST['register'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $gender = trim($_POST['gender']);
        $mobile = trim($_POST['mobile']);
        $password = $_POST['password'];
        $role = 'user';

        $userId = DbHelper::createUser($first_name, $last_name, $email, $gender, $password, $role, $mobile);

        if ($userId) {
            header('Location: ../index.php?registration=success');
            exit();
        } else {
            header('Location: ../register.php?registration=failed');
            exit();
        }
    }

    // login handler 
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = DbHelper::loginUser($email, $password);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: ../pages/index.php?login=true');
            exit();
        } else {
            header('Location: ../index.php?login=failed');
            exit();
        }
    }

    // If neither register nor login found
    header('Location: ../index.php?invalid=request');
    exit();
} else {
    header('Location: ../index.php');
    exit();
}
