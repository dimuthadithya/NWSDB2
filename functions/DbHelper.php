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

        $userInfo = self::$db->getById('users', $userId, $idColumn = 'user_id');

        return $userInfo ? $userInfo : false;
    }

    public static function getAllDeviceCategories()
    {
        self::init();

        $deviceCategories = self::$db->select('device_categories');

        return $deviceCategories ? $deviceCategories : false;
    }
    public static function getAllUsers()
    {
        self::init();

        $users = self::$db->select('users');

        return $users ? $users : false;
    }
    public static function getAllBranches()
    {
        self::init();

        $branches = self::$db->select('branches');

        return $branches ? $branches : false;
    }

    public static function getAllSections()
    {
        self::init();

        $sections = self::$db->select('sections');

        return $sections ? $sections : false;
    }

    public static function getAllComputers()
    {
        self::init();

        $computerId = self::$db->getId('device_categories', 'category_name', 'Computer', 'category_id');

        $computers = self::$db->select('devices', ['*'], ['category_id' => $computerId]);

        return $computers ? $computers : false;
    }

    public static function getAllLaptops()
    {
        self::init();

        $laptopId = self::$db->getId('device_categories', 'category_name', 'Laptop', 'category_id');

        $laptops = self::$db->select('devices', ['*'], ['category_id' => $laptopId]);

        return $laptops ? $laptops : false;
    }

    public static function getAllPrinters()
    {
        self::init();

        $printerId = self::$db->getId('device_categories', 'category_name', 'Printer', 'category_id');

        $printers = self::$db->select('devices', ['*'], ['category_id' => $printerId]);

        return $printers ? $printers : false;
    }

    public static function createBranch($branch_name, $branch_location)
    {
        self::init();

        $branchData = [
            'branch_name' => $branch_name,
            'location' => $branch_location
        ];

        return self::$db->insert('branches', $branchData);
    }

    public static function createDeviceCategory($category_name, $category_description)
    {
        self::init();

        $categoryData = [
            'category_name' => $category_name,
            'description' => $category_description
        ];

        return self::$db->insert('device_categories', $categoryData);
    }

    public static function createSection($section_name, $branch_id)
    {
        self::init();

        $sectionData = [
            'section_name' => $section_name,
            'branch_id' => $branch_id
        ];

        return self::$db->insert('sections', $sectionData);
    }

    public static function deleteBranch($branch_id)
    {
        self::init();

        if (!is_numeric($branch_id)) {
            return false;
        }

        $where = ['branch_id' => $branch_id];
        return self::$db->delete('branches', $where);
    }

    public static function deleteDeviceCategory($category_id)
    {
        self::init();

        if (!is_numeric($category_id)) {
            return false;
        }

        $where = ['category_id' => $category_id];
        return self::$db->delete('device_categories', $where);
    }

    public static function deleteSection($section_id)
    {
        self::init();

        if (!is_numeric($section_id)) {
            return false;
        }

        $where = ['section_id' => $section_id];
        return self::$db->delete('sections', $where);
    }

    public static function getComputerCount()
    {
        self::init();

        $computerRecord = self::$db->select('device_categories', ['category_id'], ['category_name' => 'Computer']);

        if (!$computerRecord || empty($computerRecord[0]['category_id'])) {
            return 0; // No Computer category found
        }

        $computerId = $computerRecord[0]['category_id'];

        $result = self::$db->count('devices', ['category_id' => $computerId]);

        return $result ? $result : 0;
    }

    public static function getLaptopCount()
    {
        self::init();

        $laptopRecord = self::$db->select('device_categories', ['category_id'], ['category_name' => 'Laptop']);

        if (!$laptopRecord || empty($laptopRecord[0]['category_id'])) {
            return 0; // No Laptop category found
        }

        $laptopId = $laptopRecord[0]['category_id'];

        $result = self::$db->count('devices', ['category_id' => $laptopId]);

        return $result ? $result : 0;
    }


    public static function getPrinterCount()
    {
        self::init();

        // Get the printer category record
        $printerRecord = self::$db->select('device_categories', ['category_id'], ['category_name' => 'Printer']);

        if (!$printerRecord || empty($printerRecord[0]['category_id'])) {
            return 0; // no printer category found
        }

        // Extract the category_id (it's inside the first element)
        $printerId = $printerRecord[0]['category_id'];

        // Count devices with that category_id
        $result = self::$db->count('devices', ['category_id' => $printerId]);

        return $result ? $result : 0;
    }

    public static function getSectionsByDeviceCount()
    {
        self::init();

        $sections = self::$db->getSectionsByDeviceCount();

        return $sections ? $sections : false;
    }
}
