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
     * @param string $username User's username
     * @param string $email User's email
     * @param string $mobile_number User's mobile number
     * @param string $gender User's gender (Male/Female)
     * @param string $password User's password
     * @param string $site_office User's site office
     * @param string $role User's role (admin/user)
     * @return bool|int Returns user ID on success, false on failure
     */
    public static function createUser(
        $first_name,
        $last_name,
        $username,
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
            'username' => $username,
            'email' => $email,
            'gender' => $gender,
            'password' => $hashedPassword,
            'role' => $role,
            'status' => 'active'
        ];

        return self::$db->insert('users', $userData);
    }
}
