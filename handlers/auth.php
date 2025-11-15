<?php
require_once __DIR__ . '/../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // register handler 
    if (isset($_POST['register'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : 'Male'; // Default to Male if not provided
        $mobile = trim($_POST['mobile']);
        $password = $_POST['password'];
        $role = 'user';

        $userId = DbHelper::createUser($first_name, $last_name, $email, $gender, $password, $role, $mobile);

        if ($userId) {
            header('Location: ../pages/login.php?registration=success');
            exit();
        } else {
            error_log("Registration failed for email: " . $email);
            header('Location: ../pages/register.php?registration=failed');
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

            // Example: fetched from DB after login check
            $user = [
                'id'    => $user['user_id'],
                'name'  => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'role'  =>    $user['role']
            ];

            // Store user data in session
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];

            header('Location: ../pages/dashboard.php');
            exit();
        } else {
            header('Location: ../pages/login.php?login=failed');
            exit();
        }
    }

    // If neither register or login found
    header('Location: ../index.php');
    exit();
} else {
    header('Location: ../index.php');
    exit();
}
