<?php
require_once __DIR__ . '/../functions/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header('Location: ../index.php?login=false');
    exit();
}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

// userInfo Array 
$userInfo = DbHelper::getUserById($userId);

$full_name = $userInfo['first_name'] . " " . $userInfo['last_name'];
$first_name = $userInfo['first_name'];
$role = $userInfo['role'];
