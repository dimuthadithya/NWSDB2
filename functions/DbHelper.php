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
     * Create a new user
     * @param array $data User data
     * @return int|false User ID or false on failure
     */
    public static function createUser($data)
    {
        self::init();
        // Hash password if it exists in data
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return self::$db->insert('users', $data);
    }

    /**
     * Update a user
     * @param int $id User ID
     * @param array $data Updated user data
     * @return bool Success or failure
     */
    public static function updateUser($id, $data)
    {
        self::init();
        // Hash password if it exists in data
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return self::$db->update('users', $data, ['id' => $id]);
    }

    /**
     * Get user by ID
     * @param int $id User ID
     * @return array|false User data or false if not found
     */
    public static function getUser($id)
    {
        self::init();
        return self::$db->getById('users', $id);
    }

    /**
     * Get user by email
     * @param string $email User email
     * @return array|false User data or false if not found
     */
    public static function getUserByEmail($email)
    {
        self::init();
        $result = self::$db->select('users', ['*'], ['email' => $email]);
        return $result ? $result[0] : false;
    }

    /**
     * Get user by username
     * @param string $username Username
     * @return array|false User data or false if not found
     */
    public static function getUserByUsername($username)
    {
        self::init();
        $result = self::$db->select('users', ['*'], ['username' => $username]);
        return $result ? $result[0] : false;
    }

    /**
     * Verify user login
     * @param string $email User email
     * @param string $password Password to verify
     * @return array|false User data if verified, false otherwise
     */
    public static function verifyLogin($email, $password)
    {
        self::init();
        $user = self::getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Don't return password hash
            return $user;
        }
        return false;
    }

    /**
     * Get all users with optional filtering
     * @param array $where WHERE conditions
     * @param string $orderBy ORDER BY clause
     * @param int|null $limit LIMIT clause
     * @param int|null $offset OFFSET clause
     * @return array|false Array of users or false on failure
     */
    public static function getUsers($where = [], $orderBy = 'id DESC', $limit = null, $offset = null)
    {
        self::init();
        $users = self::$db->select('users', ['id', 'username', 'email', 'full_name', 'role', 'site_office', 'status', 'created_at', 'last_login'], $where, $orderBy, $limit, $offset);
        return $users;
    }

    /**
     * Delete a user
     * @param int $id User ID
     * @return bool Success or failure
     */
    public static function deleteUser($id)
    {
        self::init();
        return self::$db->delete('users', ['id' => $id]);
    }

    /**
     * Update user's last login timestamp
     * @param int $id User ID
     * @return bool Success or failure
     */
    public static function updateLastLogin($id)
    {
        self::init();
        return self::$db->update('users', ['last_login' => date('Y-m-d H:i:s')], ['id' => $id]);
    }

    /**
     * Check if email already exists
     * @param string $email Email to check
     * @param int|null $excludeUserId Exclude this user ID from check (for updates)
     * @return bool True if email exists, false otherwise
     */
    public static function emailExists($email, $excludeUserId = null)
    {
        self::init();
        $where = ['email' => $email];
        if ($excludeUserId) {
            $result = self::$db->select('users', ['id'], $where);
            return $result && $result[0]['id'] != $excludeUserId;
        }
        return self::$db->count('users', $where) > 0;
    }

    /**
     * Check if username already exists
     * @param string $username Username to check
     * @param int|null $excludeUserId Exclude this user ID from check (for updates)
     * @return bool True if username exists, false otherwise
     */
    public static function usernameExists($username, $excludeUserId = null)
    {
        self::init();
        $where = ['username' => $username];
        if ($excludeUserId) {
            $result = self::$db->select('users', ['id'], $where);
            return $result && $result[0]['id'] != $excludeUserId;
        }
        return self::$db->count('users', $where) > 0;
    }

    /**
     * Create a new computer record
     */
    public static function createComputer($data)
    {
        self::init();
        return self::$db->insert('computers', $data);
    }

    /**
     * Update a computer record
     */
    public static function updateComputer($id, $data)
    {
        self::init();
        return self::$db->update('computers', $data, ['id' => $id]);
    }

    /**
     * Get computer by ID
     */
    public static function getComputer($id)
    {
        self::init();
        return self::$db->getById('computers', $id);
    }

    /**
     * Get all computers with optional filtering
     */
    public static function getComputers($where = [], $orderBy = 'id DESC', $limit = null, $offset = null)
    {
        self::init();
        return self::$db->select('computers', ['*'], $where, $orderBy, $limit, $offset);
    }

    /**
     * Delete a computer record
     */
    public static function deleteComputer($id)
    {
        self::init();
        return self::$db->delete('computers', ['id' => $id]);
    }

    /**
     * Create a new laptop record
     */
    public static function createLaptop($data)
    {
        self::init();
        return self::$db->insert('laptops', $data);
    }

    /**
     * Update a laptop record
     */
    public static function updateLaptop($id, $data)
    {
        self::init();
        return self::$db->update('laptops', $data, ['id' => $id]);
    }

    /**
     * Get laptop by ID
     */
    public static function getLaptop($id)
    {
        self::init();
        return self::$db->getById('laptops', $id);
    }

    /**
     * Get all laptops with optional filtering
     */
    public static function getLaptops($where = [], $orderBy = 'id DESC', $limit = null, $offset = null)
    {
        self::init();
        return self::$db->select('laptops', ['*'], $where, $orderBy, $limit, $offset);
    }

    /**
     * Delete a laptop record
     */
    public static function deleteLaptop($id)
    {
        self::init();
        return self::$db->delete('laptops', ['id' => $id]);
    }

    /**
     * Create a new printer record
     */
    public static function createPrinter($data)
    {
        self::init();
        return self::$db->insert('printers', $data);
    }

    /**
     * Update a printer record
     */
    public static function updatePrinter($id, $data)
    {
        self::init();
        return self::$db->update('printers', $data, ['id' => $id]);
    }

    /**
     * Get printer by ID
     */
    public static function getPrinter($id)
    {
        self::init();
        return self::$db->getById('printers', $id);
    }

    /**
     * Get all printers with optional filtering
     */
    public static function getPrinters($where = [], $orderBy = 'id DESC', $limit = null, $offset = null)
    {
        self::init();
        return self::$db->select('printers', ['*'], $where, $orderBy, $limit, $offset);
    }

    /**
     * Delete a printer record
     */
    public static function deletePrinter($id)
    {
        self::init();
        return self::$db->delete('printers', ['id' => $id]);
    }

    /**
     * Create a new repair record
     */
    public static function createRepair($data)
    {
        self::init();
        return self::$db->insert('repairs', $data);
    }

    /**
     * Update a repair record
     */
    public static function updateRepair($id, $data)
    {
        self::init();
        return self::$db->update('repairs', $data, ['id' => $id]);
    }

    /**
     * Get repair by ID
     */
    public static function getRepair($id)
    {
        self::init();
        return self::$db->getById('repairs', $id);
    }

    /**
     * Get all repairs with optional filtering
     */
    public static function getRepairs($where = [], $orderBy = 'id DESC', $limit = null, $offset = null)
    {
        self::init();
        return self::$db->select('repairs', ['*'], $where, $orderBy, $limit, $offset);
    }

    /**
     * Delete a repair record
     */
    public static function deleteRepair($id)
    {
        self::init();
        return self::$db->delete('repairs', ['id' => $id]);
    }

    /**
     * Get device statistics for summary
     */
    public static function getDeviceStatistics()
    {
        self::init();
        $stats = [
            'computers' => self::$db->count('computers'),
            'laptops' => self::$db->count('laptops'),
            'printers' => self::$db->count('printers'),
            'repairs' => self::$db->count('repairs'),
            'active_repairs' => self::$db->count('repairs', ['status' => 'pending'])
        ];
        return $stats;
    }
}
