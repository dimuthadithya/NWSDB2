<?php
session_start();
require_once __DIR__ . '/../../../functions/DbHelper.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

// Get the action
$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            // Validate required fields
            if (empty($_POST['first_name'])) {
                $_SESSION['error_message'] = 'First name is required.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['last_name'])) {
                $_SESSION['error_message'] = 'Last name is required.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['email'])) {
                $_SESSION['error_message'] = 'Email is required.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['password'])) {
                $_SESSION['error_message'] = 'Password is required.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['gender'])) {
                $_SESSION['error_message'] = 'Gender is required.';
                header('Location: ../users.php');
                exit();
            }

            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $gender = $_POST['gender'];
            $mobile = trim($_POST['mobile_number'] ?? '');
            $role = $_POST['role'] ?? 'user';
            $username = trim($_POST['username'] ?? '');
            $wss_id = !empty($_POST['wss_id']) ? $_POST['wss_id'] : null;
            $status = $_POST['status'] ?? 'active';

            // Create user using the existing createUser function
            $result = DbHelper::createUser($first_name, $last_name, $email, $gender, $password, $mobile, $role);

            if ($result) {
                // If username, wss_id or status need to be updated after creation
                if (!empty($username) || $wss_id !== null || $status !== 'active') {
                    // Get the newly created user's ID
                    $allUsers = DbHelper::getAllUsers();
                    $userId = null;
                    foreach ($allUsers as $u) {
                        if ($u['email'] === $email) {
                            $userId = $u['user_id'];
                            break;
                        }
                    }

                    if ($userId) {
                        $updateData = [];
                        if (!empty($username)) $updateData['username'] = $username;
                        if ($wss_id !== null) $updateData['wss_id'] = $wss_id;
                        if ($status !== 'active') $updateData['status'] = $status;
                        DbHelper::updateUser($userId, $updateData);
                    }
                }
                $_SESSION['success_message'] = 'User created successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to create user. Email may already exist.';
            }

            header('Location: ../users.php');
            exit();

        case 'update':
            // Validate required fields
            if (empty($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
                $_SESSION['error_message'] = 'Invalid user ID.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['first_name'])) {
                $_SESSION['error_message'] = 'First name is required.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['last_name'])) {
                $_SESSION['error_message'] = 'Last name is required.';
                header('Location: ../users.php');
                exit();
            }

            if (empty($_POST['email'])) {
                $_SESSION['error_message'] = 'Email is required.';
                header('Location: ../users.php');
                exit();
            }

            $user_id = $_POST['user_id'];
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'username' => trim($_POST['username'] ?? ''),
                'mobile_number' => trim($_POST['mobile_number'] ?? ''),
                'gender' => $_POST['gender'] ?? '',
                'wss_id' => !empty($_POST['wss_id']) ? $_POST['wss_id'] : null,
                'role' => $_POST['role'] ?? 'user',
                'status' => $_POST['status'] ?? 'active'
            ];

            // Only update password if provided
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            // Update user
            $result = DbHelper::updateUser($user_id, $data);

            if ($result) {
                $_SESSION['success_message'] = 'User updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to update user. Email may already exist.';
            }

            header('Location: ../users.php');
            exit();

        case 'delete':
            // Validate user ID
            if (empty($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
                $_SESSION['error_message'] = 'Invalid user ID.';
                header('Location: ../users.php');
                exit();
            }

            $user_id = $_POST['user_id'];

            // Prevent deleting own account
            if ($user_id == $_SESSION['user']['user_id']) {
                $_SESSION['error_message'] = 'You cannot delete your own account.';
                header('Location: ../users.php');
                exit();
            }

            // Delete user
            $result = DbHelper::deleteUser($user_id);

            if ($result) {
                $_SESSION['success_message'] = 'User deleted successfully!';
            } else {
                $_SESSION['error_message'] = 'Failed to delete user.';
            }

            header('Location: ../users.php');
            exit();

        default:
            $_SESSION['error_message'] = 'Invalid action.';
            header('Location: ../users.php');
            exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = 'An error occurred: ' . $e->getMessage();
    header('Location: ../users.php');
    exit();
}
