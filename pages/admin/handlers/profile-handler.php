<?php
session_start();
require_once __DIR__ . '/../../../functions/DbHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = $_SESSION['user']['id'];

    if (!$userId) {
        $_SESSION['error_message'] = "User not authenticated.";
        header('Location: ../../../pages/settings.php');
        exit;
    }

    $db = Database::getInstance();

    if ($action === 'update_profile') {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile_number']);

        if (empty($firstName) || empty($lastName) || empty($email)) {
            $_SESSION['error_message'] = "First Name, Last Name, and Email are required.";
            header('Location: ../../../pages/settings.php');
            exit;
        }

        // Update User
        $updateData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'mobile_number' => $mobile
        ];

        try {
            $updated = $db->update('users', $updateData, ['user_id' => $userId]);
            if ($updated) {
                // Update Session
                $_SESSION['user']['first_name'] = $firstName;
                $_SESSION['user']['last_name'] = $lastName;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['mobile_number'] = $mobile;
                $_SESSION['user']['name'] = $firstName . ' ' . $lastName; // Assuming name is composite

                $_SESSION['success_message'] = "Profile updated successfully.";
            } else {
                $_SESSION['error_message'] = "Failed to update profile. " . $db->getLastError();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }

    } elseif ($action === 'change_password') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (empty($currentPassword) || empty($newPassword)) {
            $_SESSION['error_message'] = "Current and New Password are required.";
            header('Location: ../../../pages/settings.php');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_message'] = "New passwords do not match.";
            header('Location: ../../../pages/settings.php');
            exit;
        }

        // Verify Current Password
        // Need to fetch user password hash
        $user = $db->select('users', ['password'], ['user_id' => $userId]);
        if (!$user) {
             $_SESSION['error_message'] = "User not found.";
             header('Location: ../../../pages/settings.php');
             exit;
        }

        $passwordHash = $user[0]['password'];
        if (!password_verify($currentPassword, $passwordHash)) {
            $_SESSION['error_message'] = "Incorrect current password.";
            header('Location: ../../../pages/settings.php');
            exit;
        }

        // Update Password
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        try {
            $updated = $db->update('users', ['password' => $newHash], ['user_id' => $userId]);
             if ($updated) {
                $_SESSION['success_message'] = "Password changed successfully.";
            } else {
                $_SESSION['error_message'] = "Failed to update password.";
            }
        } catch (Exception $e) {
             $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    }

    header('Location: ../../../pages/settings.php');
    exit;
} else {
    header('Location: ../../../pages/settings.php');
    exit;
}
