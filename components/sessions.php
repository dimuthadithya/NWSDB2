<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../index.php?access=denied');
        exit();
    } else {
        $userId = $_SESSION['user_id'];
    }

    if (!isset($_SESSION['user_role'])) {
        header('Location: ../index.php?access=denied');
        exit();
    } else {
        $userRole = $_SESSION['user_role'];
    }
}
