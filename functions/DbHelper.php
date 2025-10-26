<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Database.php';

/**
 * Helper functions for common database operations
 */
class DbHelper
{
    private static $db;

    public static function init()
    {
        if (!self::$db) {
            self::$db = Database::getInstance();
        }
    }


    /**
     * Creates a new user in the database
     * @param string $first_name User's first name
     * @param string $last_name User's last name
     * @param string $email User's email
     * @param string $gender User's gender (Male/Female)
     * @param string $password User's password
     * @param string $role User's role (admin/user)
     * @return bool|int Returns user ID on success, false on failure
     */
    public static function createUser(
        $first_name,
        $last_name,
        $email,
        $gender,
        $password,
        $role = 'user'
    ) {
        self::init();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userData = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'gender' => $gender,
            'password' => $hashedPassword,
            'role' => $role,
            'status' => 'active'
        ];

        return self::$db->insert('users', $userData);
    }


    /**
     * Authenticates a user login attempt
     * @param string $email User's email
     * @param string $password User's password
     * @return array|bool Returns user data on success, false on failure
     */
    public static function loginUser($email, $password)
    {
        self::init();

        $where = ['email' => $email];
        $result = self::$db->select('users', ['*'], $where);

        if ($result && count($result) > 0) {
            $user = $result[0];
            if (password_verify($password, $user['password'])) {
                unset($user['password']); // Remove password from return data
                return $user;
            }
        }

        return false;
    }

    public static function getUserById($userId)
    {
        self::init();

        if (!is_numeric($userId)) {
            return false;
        }

        $userInfo = self::$db->getById('users', $userId);

        return $userInfo ? $userInfo : false;
    }
}
