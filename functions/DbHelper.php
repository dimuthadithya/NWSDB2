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

    public static function getLastError()
    {
        self::init();
        return self::$db->getLastError();
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
        $mobile,
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
            'mobile_number' => $mobile,
            'role' => $role,
            'status' => 'active',
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

        if (!$users) {
            return [];
        }

        // Get water supply schemes
        $schemes = self::$db->select('water_supply_schemes', ['wss_id', 'wss_name']);
        $schemeMap = [];
        if ($schemes) {
            foreach ($schemes as $scheme) {
                $schemeMap[$scheme['wss_id']] = $scheme['wss_name'];
            }
        }

        // Add wss_name to users
        foreach ($users as &$user) {
            $user['wss_name'] = isset($user['wss_id']) && isset($schemeMap[$user['wss_id']])
                ? $schemeMap[$user['wss_id']]
                : 'N/A';
        }

        return $users;
    }

    /**
     * Update a user
     * @param int $user_id User ID
     * @param array $data Data to update
     * @return bool Returns true on success, false on failure
     */
    public static function updateUser($user_id, $data)
    {
        self::init();

        if (!is_numeric($user_id)) {
            return false;
        }

        // If password is being updated, hash it
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Remove password from update if it's empty
            unset($data['password']);
        }

        return self::$db->update('users', $data, ['user_id' => $user_id]);
    }

    /**
     * Delete a user
     * @param int $user_id User ID
     * @return bool Returns true on success, false on failure
     */
    public static function deleteUser($user_id)
    {
        self::init();

        if (!is_numeric($user_id)) {
            return false;
        }

        return self::$db->delete('users', ['user_id' => $user_id]);
    }

    public static function getAllBranches()
    {
        self::init();

        $branches = self::$db->select('branches');

        return $branches ? $branches : [];
    }

    public static function getAllSections()
    {
        self::init();

        $sections = self::$db->select('sections');

        if (!$sections) {
            return [];
        }

        // Get water supply schemes
        $schemes = self::$db->select('water_supply_schemes', ['wss_id', 'wss_name']);
        $schemeMap = [];
        if ($schemes) {
            foreach ($schemes as $scheme) {
                $schemeMap[$scheme['wss_id']] = $scheme['wss_name'];
            }
        }

        // Add wss_name to sections
        foreach ($sections as &$section) {
            $section['wss_name'] = $schemeMap[$section['wss_id']] ?? 'N/A';
        }

        return $sections;
    }

    public static function getAllComputers()
    {
        self::init();

        $computerId = self::$db->getId('device_categories', 'category_name', 'Desktop Computer', 'category_id');

        $sql = "SELECT d.*, s.section_name, w.wss_name 
                FROM devices d 
                LEFT JOIN sections s ON d.section_id = s.section_id
                LEFT JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                WHERE d.category_id = ?
                ORDER BY d.created_at DESC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute([$computerId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllComputers failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function getAllLaptops()
    {
        self::init();

        $laptopId = self::$db->getId('device_categories', 'category_name', 'Laptop', 'category_id');

        $laptops = self::$db->select('devices', ['*'], ['category_id' => $laptopId]);

        return $laptops ? $laptops : false;
    }
    public static function getAllOtherDevices()
    {
        self::init();

        $otherDeviceId = self::$db->getId('device_categories', 'category_name', 'Other', 'category_id');

        $otherDevices = self::$db->select('devices', ['*'], ['category_id' => $otherDeviceId]);

        return $otherDevices ? $otherDevices : false;
    }

    public static function getAllPrinters()
    {
        self::init();

        $printerId = self::$db->getId('device_categories', 'category_name', 'Printer', 'category_id');

        $sql = "SELECT d.*, s.section_name, w.wss_name 
                FROM devices d 
                LEFT JOIN sections s ON d.section_id = s.section_id
                LEFT JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                WHERE d.category_id = ?
                ORDER BY d.created_at DESC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute([$printerId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllPrinters failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function getAllRVPNConnections()
    {
        self::init();

        $rvpnId = self::$db->getId('device_categories', 'category_name', 'RVPN Device', 'category_id');

        $sql = "SELECT d.*, s.section_name, w.wss_name 
                FROM devices d 
                LEFT JOIN sections s ON d.section_id = s.section_id
                LEFT JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                WHERE d.category_id = ?
                ORDER BY d.created_at DESC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute([$rvpnId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllRVPNConnections failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function getAllFingerDevices()
    {
        self::init();

        $fingerId = self::$db->getId('device_categories', 'category_name', 'Fingerprint Device', 'category_id');

        $sql = "SELECT d.*, s.section_name, w.wss_name 
                FROM devices d 
                LEFT JOIN sections s ON d.section_id = s.section_id
                LEFT JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                WHERE d.category_id = ?
                ORDER BY d.created_at DESC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fingerId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllFingerDevices failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function getAllRepairs()
    {
        self::init();

        $sql = "SELECT r.*, d.device_name, d.model, c.category_name, w.wss_name 
                FROM repairs r 
                INNER JOIN devices d ON r.device_id = d.device_id
                INNER JOIN device_categories c ON d.category_id = c.category_id
                INNER JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                ORDER BY r.repair_date DESC, r.created_at DESC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllRepairs failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function getAllDevices()
    {
        self::init();

        $sql = "SELECT d.device_id, d.device_name, d.model, c.category_name, w.wss_name 
                FROM devices d 
                INNER JOIN device_categories c ON d.category_id = c.category_id
                INNER JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                ORDER BY d.device_name ASC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllDevices failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function createRepair($data)
    {
        self::init();

        // Validate required fields
        if (empty($data['device_id']) || empty($data['repair_details'])) {
            return false;
        }

        return self::$db->insert('repairs', $data);
    }

    public static function getAllIssues()
    {
        self::init();

        $sql = "SELECT i.*, d.device_name, d.model, c.category_name, w.wss_name,
                u.first_name, u.last_name
                FROM device_issues i 
                INNER JOIN devices d ON i.device_id = d.device_id
                INNER JOIN device_categories c ON d.category_id = c.category_id
                INNER JOIN water_supply_schemes w ON d.wss_id = w.wss_id
                LEFT JOIN users u ON i.reported_by = u.user_id
                ORDER BY i.reported_at DESC";

        try {
            $db = Database::getInstance();
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getAllIssues failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function createIssue($data)
    {
        self::init();

        // Validate required fields
        if (empty($data['device_id']) || empty($data['issue_title'])) {
            return false;
        }

        return self::$db->insert('device_issues', $data);
    }

    public static function updateIssue($issue_id, $data)
    {
        self::init();

        if (!is_numeric($issue_id)) {
            return false;
        }

        $where = ['issue_id' => $issue_id];
        return self::$db->update('device_issues', $data, $where);
    }

    public static function deleteIssue($issue_id)
    {
        self::init();

        if (!is_numeric($issue_id)) {
            return false;
        }

        $where = ['issue_id' => $issue_id];
        return self::$db->delete('device_issues', $where);
    }

    public static function updateRepair($repair_id, $data)
    {
        self::init();

        if (!is_numeric($repair_id)) {
            return false;
        }

        $where = ['repair_id' => $repair_id];
        return self::$db->update('repairs', $data, $where);
    }

    public static function deleteRepair($repair_id)
    {
        self::init();

        if (!is_numeric($repair_id)) {
            return false;
        }

        $where = ['repair_id' => $repair_id];
        return self::$db->delete('repairs', $where);
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

    /**
     * Update a device category
     * @param int $category_id Category ID
     * @param array $data Data to update
     * @return bool Returns true on success, false on failure
     */
    public static function updateDeviceCategory($category_id, $data)
    {
        self::init();

        if (!is_numeric($category_id)) {
            return false;
        }

        return self::$db->update('device_categories', $data, ['category_id' => $category_id]);
    }

    public static function createDevice($data)
    {
        self::init();

        // Validate required fields
        if (empty($data['device_name']) || empty($data['category_id']) || empty($data['wss_id'])) {
            return false;
        }

        return self::$db->insert('devices', $data);
    }

    public static function createSection($section_name, $wss_id)
    {
        self::init();

        $sectionData = [
            'section_name' => $section_name,
            'wss_id' => $wss_id
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

    /**
     * Update a section
     * @param int $section_id Section ID
     * @param array $data Data to update
     * @return bool Returns true on success, false on failure
     */
    public static function updateSection($section_id, $data)
    {
        self::init();

        if (!is_numeric($section_id)) {
            return false;
        }

        return self::$db->update('sections', $data, ['section_id' => $section_id]);
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

    public static function updateDevice($device_id, $data)
    {
        self::init();

        if (!is_numeric($device_id)) {
            return false;
        }

        return self::$db->update('devices', $data, ['device_id' => $device_id]);
    }

    public static function deleteDevice($device_id)
    {
        self::init();

        if (!is_numeric($device_id)) {
            return false;
        }

        $where = ['device_id' => $device_id];
        return self::$db->delete('devices', $where);
    }

    public static function getRowCount($tableName)
    {
        self::init();

        $result = self::$db->count($tableName);

        return $result ? $result : 0;
    }

    public static function getRowCountWithCondition($tableName, $conditions)
    {
        self::init();

        $result = self::$db->count($tableName, $conditions);

        return $result ? $result : 0;
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

    public static function getCategoryId($category)
    {
        self::init();

        $categoryId = self::$db->getId('device_categories', 'category_name', $category, 'category_id');

        return $categoryId ? $categoryId : null;
    }

    /**
     * Get issue counts by priority
     * @return array Returns array with counts for each priority
     */
    public static function getIssuePriorityCounts()
    {
        self::init();

        $highPriority = self::$db->count('device_issues', ['priority' => 'high', 'status !=' => 'closed']);
        $mediumPriority = self::$db->count('device_issues', ['priority' => 'medium', 'status !=' => 'closed']);
        $lowPriority = self::$db->count('device_issues', ['priority' => 'low', 'status !=' => 'closed']);

        return [
            'high' => $highPriority ? $highPriority : 0,
            'medium' => $mediumPriority ? $mediumPriority : 0,
            'low' => $lowPriority ? $lowPriority : 0
        ];
    }

    /**
     * Get recent activities (issues, repairs, devices)
     * @param int $limit Number of activities to fetch
     * @return array|bool Returns array of activities or false
     */
    public static function getRecentActivities($limit = 10)
    {
        self::init();

        $activities = [];

        try {
            // Get recent devices
            $recentDevices = self::$db->rawQuery("
                SELECT 
                    d.device_id,
                    d.device_name,
                    d.created_at,
                    dc.category_name,
                    'device' as type
                FROM devices d
                LEFT JOIN device_categories dc ON d.category_id = dc.category_id
                ORDER BY d.created_at DESC
                LIMIT 3
            ");

            if ($recentDevices) {
                foreach ($recentDevices as $device) {
                    $activities[] = [
                        'type' => 'device',
                        'title' => 'New Device Added',
                        'description' => $device['device_name'] . ' - ' . $device['category_name'],
                        'time' => $device['created_at'],
                        'icon' => 'fa-plus',
                        'color' => 'blue'
                    ];
                }
            }

            // Get recent repairs
            $recentRepairs = self::$db->rawQuery("
                SELECT 
                    r.repair_id,
                    d.device_name,
                    r.created_at,
                    r.status
                FROM repairs r
                LEFT JOIN devices d ON r.device_id = d.device_id
                WHERE r.status = 'in_progress' OR r.status = 'completed'
                ORDER BY r.created_at DESC
                LIMIT 3
            ");

            if ($recentRepairs) {
                foreach ($recentRepairs as $repair) {
                    $activities[] = [
                        'type' => 'repair',
                        'title' => $repair['status'] === 'completed' ? 'Repair Completed' : 'Repair Started',
                        'description' => $repair['device_name'],
                        'time' => $repair['created_at'],
                        'icon' => $repair['status'] === 'completed' ? 'fa-check-circle' : 'fa-wrench',
                        'color' => $repair['status'] === 'completed' ? 'green' : 'orange'
                    ];
                }
            }

            // Get recent issues
            $recentIssues = self::$db->rawQuery("
                SELECT 
                    i.issue_id,
                    d.device_name,
                    i.issue_title,
                    i.created_at,
                    i.status,
                    i.resolved_at
                FROM device_issues i
                LEFT JOIN devices d ON i.device_id = d.device_id
                ORDER BY i.created_at DESC
                LIMIT 3
            ");

            if ($recentIssues) {
                foreach ($recentIssues as $issue) {
                    $isResolved = in_array($issue['status'], ['resolved', 'closed']);
                    $activities[] = [
                        'type' => 'issue',
                        'title' => $isResolved ? 'Issue Resolved' : 'New Issue Reported',
                        'description' => $issue['device_name'] . ' - ' . $issue['issue_title'],
                        'time' => $isResolved ? $issue['resolved_at'] : $issue['created_at'],
                        'icon' => $isResolved ? 'fa-check-circle' : 'fa-exclamation-triangle',
                        'color' => $isResolved ? 'green' : 'red'
                    ];
                }
            }

            // Sort all activities by time
            usort($activities, function ($a, $b) {
                return strtotime($b['time']) - strtotime($a['time']);
            });

            return array_slice($activities, 0, $limit);
        } catch (Exception $e) {
            return [];
        }
    }

    // ============================================
    // REGIONS Functions
    // ============================================

    /**
     * Get all regions
     * @return array|bool Returns array of regions or false
     */
    public static function getAllRegions()
    {
        self::init();
        $regions = self::$db->select('regions', ['*'], [], 'region_name ASC');
        return $regions ? $regions : [];
    }

    /**
     * Get region by ID
     * @param int $region_id Region ID
     * @return array|bool Returns region data or false
     */
    public static function getRegionById($region_id)
    {
        self::init();
        if (!is_numeric($region_id)) {
            return false;
        }
        $region = self::$db->getById('regions', $region_id, 'region_id');
        return $region ? $region : false;
    }

    /**
     * Get region count
     * @return int Region count
     */
    public static function getRegionCount()
    {
        self::init();
        $result = self::$db->count('regions');
        return $result ? $result : 0;
    }

    /**
     * Get active region count
     * @return int Active region count
     */
    public static function getActiveRegionCount()
    {
        self::init();
        $result = self::$db->count('regions', ['status' => 'active']);
        return $result ? $result : 0;
    }

    /**
     * Create a new region
     * @param string $region_code Region code
     * @param string $region_name Region name
     * @param string $status Region status (active/inactive)
     * @return bool|int Returns region ID on success, false on failure
     */
    public static function createRegion($region_code, $region_name, $status = 'active')
    {
        self::init();

        $regionData = [
            'region_code' => $region_code,
            'region_name' => $region_name,
            'status' => $status
        ];

        return self::$db->insert('regions', $regionData);
    }

    /**
     * Update a region
     * @param int $region_id Region ID
     * @param array $data Data to update
     * @return bool Returns true on success, false on failure
     */
    public static function updateRegion($region_id, $data)
    {
        self::init();

        if (!is_numeric($region_id)) {
            return false;
        }

        return self::$db->update('regions', $data, ['region_id' => $region_id]);
    }

    /**
     * Delete a region
     * @param int $region_id Region ID
     * @return bool Returns true on success, false on failure
     */
    public static function deleteRegion($region_id)
    {
        self::init();

        if (!is_numeric($region_id)) {
            return false;
        }

        return self::$db->delete('regions', ['region_id' => $region_id]);
    }

    // ============================================
    // AREAS Functions
    // ============================================

    /**
     * Get all areas with region information
     * @return array Returns array of areas
     */
    public static function getAllAreas()
    {
        self::init();
        // For now, get areas and regions separately
        // TODO: Add JOIN support to Database class
        $areas = self::$db->select('areas', ['*'], [], 'area_name ASC');
        if (!$areas) {
            return [];
        }

        // Get all regions for reference
        $regions = self::$db->select('regions', ['region_id', 'region_name']);
        $regionMap = [];
        if ($regions) {
            foreach ($regions as $region) {
                $regionMap[$region['region_id']] = $region['region_name'];
            }
        }

        // Add region names to areas
        foreach ($areas as &$area) {
            $area['region_name'] = isset($regionMap[$area['region_id']]) ? $regionMap[$area['region_id']] : 'N/A';
        }

        return $areas;
    }

    /**
     * Get area by ID
     * @param int $area_id Area ID
     * @return array|bool Returns area data or false
     */
    public static function getAreaById($area_id)
    {
        self::init();
        if (!is_numeric($area_id)) {
            return false;
        }
        $area = self::$db->getById('areas', $area_id, 'area_id');
        return $area ? $area : false;
    }

    /**
     * Get areas by region ID
     * @param int $region_id Region ID
     * @return array Returns array of areas
     */
    public static function getAreasByRegion($region_id)
    {
        self::init();
        $areas = self::$db->select('areas', ['*'], ['region_id' => $region_id], 'area_name ASC');
        return $areas ? $areas : [];
    }

    /**
     * Get area count
     * @return int Area count
     */
    public static function getAreaCount()
    {
        self::init();
        $result = self::$db->count('areas');
        return $result ? $result : 0;
    }

    /**
     * Get active area count
     * @return int Active area count
     */
    public static function getActiveAreaCount()
    {
        self::init();
        $result = self::$db->count('areas', ['status' => 'active']);
        return $result ? $result : 0;
    }

    /**
     * Create a new area
     * @param int $region_id Region ID
     * @param string $area_code Area code
     * @param string $area_name Area name
     * @param string $status Area status (active/inactive)
     * @return bool|int Returns area ID on success, false on failure
     */
    public static function createArea($region_id, $area_code, $area_name, $status = 'active')
    {
        self::init();

        $areaData = [
            'region_id' => $region_id,
            'area_code' => $area_code,
            'area_name' => $area_name,
            'status' => $status
        ];

        return self::$db->insert('areas', $areaData);
    }

    /**
     * Update an area
     * @param int $area_id Area ID
     * @param array $data Data to update
     * @return bool Returns true on success, false on failure
     */
    public static function updateArea($area_id, $data)
    {
        self::init();

        if (!is_numeric($area_id)) {
            return false;
        }

        return self::$db->update('areas', $data, ['area_id' => $area_id]);
    }

    /**
     * Delete an area
     * @param int $area_id Area ID
     * @return bool Returns true on success, false on failure
     */
    public static function deleteArea($area_id)
    {
        self::init();

        if (!is_numeric($area_id)) {
            return false;
        }

        return self::$db->delete('areas', ['area_id' => $area_id]);
    }

    // ============================================
    // WATER SUPPLY SCHEMES Functions
    // ============================================

    /**
     * Get all water supply schemes with area and region information
     * @return array Returns array of schemes
     */
    public static function getAllWaterSupplySchemes()
    {
        self::init();
        // Get schemes and related data separately
        $schemes = self::$db->select('water_supply_schemes', ['*'], [], 'wss_name ASC');
        if (!$schemes) {
            return [];
        }

        // Get areas
        $areas = self::$db->select('areas', ['area_id', 'area_name', 'region_id']);
        $areaMap = [];
        if ($areas) {
            foreach ($areas as $area) {
                $areaMap[$area['area_id']] = [
                    'area_name' => $area['area_name'],
                    'region_id' => $area['region_id']
                ];
            }
        }

        // Get regions
        $regions = self::$db->select('regions', ['region_id', 'region_name']);
        $regionMap = [];
        if ($regions) {
            foreach ($regions as $region) {
                $regionMap[$region['region_id']] = $region['region_name'];
            }
        }

        // Add area and region names to schemes
        foreach ($schemes as &$scheme) {
            if (isset($areaMap[$scheme['area_id']])) {
                $scheme['area_name'] = $areaMap[$scheme['area_id']]['area_name'];
                $regionId = $areaMap[$scheme['area_id']]['region_id'];
                $scheme['region_name'] = isset($regionMap[$regionId]) ? $regionMap[$regionId] : 'N/A';
            } else {
                $scheme['area_name'] = 'N/A';
                $scheme['region_name'] = 'N/A';
            }
        }

        return $schemes;
    }

    /**
     * Get water supply scheme by ID
     * @param int $wss_id Scheme ID
     * @return array|bool Returns scheme data or false
     */
    public static function getWaterSupplySchemeById($wss_id)
    {
        self::init();
        if (!is_numeric($wss_id)) {
            return false;
        }
        $scheme = self::$db->getById('water_supply_schemes', $wss_id, 'wss_id');
        return $scheme ? $scheme : false;
    }

    /**
     * Get schemes by area ID
     * @param int $area_id Area ID
     * @return array Returns array of schemes
     */
    public static function getSchemesByArea($area_id)
    {
        self::init();
        $schemes = self::$db->select('water_supply_schemes', ['*'], ['area_id' => $area_id], 'wss_name ASC');
        return $schemes ? $schemes : [];
    }

    /**
     * Get water supply scheme count
     * @return int Scheme count
     */
    public static function getWaterSupplySchemeCount()
    {
        self::init();
        $result = self::$db->count('water_supply_schemes');
        return $result ? $result : 0;
    }

    /**
     * Get active scheme count
     * @return int Active scheme count
     */
    public static function getActiveSchemeCount()
    {
        self::init();
        $result = self::$db->count('water_supply_schemes', ['status' => 'active']);
        return $result ? $result : 0;
    }

    /**
     * Get operational scheme count
     * @return int Operational scheme count
     */
    public static function getOperationalSchemeCount()
    {
        self::init();
        $result = self::$db->count('water_supply_schemes', ['status' => 'active']);
        return $result ? $result : 0;
    }

    /**
     * Get maintenance scheme count
     * @return int Maintenance scheme count
     */
    public static function getMaintenanceSchemeCount()
    {
        self::init();
        $result = self::$db->count('water_supply_schemes', ['status' => 'maintenance']);
        return $result ? $result : 0;
    }

    /**
     * Create a new water supply scheme
     * @param int $area_id Area ID
     * @param string $wss_code Scheme code
     * @param string $wss_name Scheme name
     * @param string $status Scheme status (active/inactive/maintenance)
     * @return bool|int Returns scheme ID on success, false on failure
     */
    public static function createWaterSupplyScheme($area_id, $wss_code, $wss_name, $status = 'active')
    {
        self::init();

        $schemeData = [
            'area_id' => $area_id,
            'wss_code' => $wss_code,
            'wss_name' => $wss_name,
            'status' => $status
        ];

        return self::$db->insert('water_supply_schemes', $schemeData);
    }

    /**
     * Update a water supply scheme
     * @param int $wss_id Scheme ID
     * @param array $data Data to update
     * @return bool Returns true on success, false on failure
     */
    public static function updateWaterSupplyScheme($wss_id, $data)
    {
        self::init();

        if (!is_numeric($wss_id)) {
            return false;
        }

        return self::$db->update('water_supply_schemes', $data, ['wss_id' => $wss_id]);
    }

    /**
     * Delete a water supply scheme
     * @param int $wss_id Scheme ID
     * @return bool Returns true on success, false on failure
     */
    public static function deleteWaterSupplyScheme($wss_id)
    {
        self::init();

        if (!is_numeric($wss_id)) {
            return false;
        }

        return self::$db->delete('water_supply_schemes', ['wss_id' => $wss_id]);
    }
}
