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

        return $users ? $users : false;
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

        return $sections ? $sections : false;
    }

    public static function getAllComputers()
    {
        self::init();

        $computerId = self::$db->getId('device_categories', 'category_name', 'Desktop Computer', 'category_id');

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

        $printers = self::$db->select('devices', ['*'], ['category_id' => $printerId]);

        return $printers ? $printers : false;
    }

    public static function getAllRVPNConnections()
    {
        self::init();

        $rvpnId = self::$db->getId('device_categories', 'category_name', 'RVPN Connection', 'category_id');

        $rvpnConnections = self::$db->select('devices', ['*'], ['category_id' => $rvpnId]);

        return $rvpnConnections ? $rvpnConnections : false;
    }

    public static function getAllFingerDevices()
    {
        self::init();

        $fingerId = self::$db->getId('device_categories', 'category_name', 'Fingerprint Device', 'category_id');

        $fingerDevices = self::$db->select('devices', ['*'], ['category_id' => $fingerId]);

        return $fingerDevices ? $fingerDevices : false;
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

    public static function createDevice(
        $deviceName,
        $model,
        $madeIn,
        $categoryId,
        $sectionId,
        $assignedTo,
        $operatingSystem,
        $processor,
        $ram,
        $hardDriveCapacity,
        $keyboard,
        $mouse,
        $networkConnectivity,
        $printerConnectivity,
        $ipAddress,
        $virusGuard,
        $monitorInfo,
        $cpuSerial,
        $purchaseDate,
        $status,
        $notes
    ) {
        self::init();

        // Implementation for creating a device goes here
        $deviceData = [
            'device_name' => $deviceName,
            'model' => $model,
            'made_in' => $madeIn,
            'category_id' => $categoryId,
            'section_id' => $sectionId,
            'assigned_to' => $assignedTo,
            'operating_system' => $operatingSystem,
            'processor' => $processor,
            'ram' => $ram,
            'hard_drive_capacity' => $hardDriveCapacity,
            'keyboard' => $keyboard,
            'mouse' => $mouse,
            'network_connectivity' => $networkConnectivity,
            'printer_connectivity' => $printerConnectivity,
            'ip_address' => $ipAddress,
            'virus_guard' => $virusGuard,
            'monitor_info' => $monitorInfo,
            'cpu_serial' => $cpuSerial,
            'purchase_date' => $purchaseDate,
            'status' => $status,
            'notes' => $notes
        ];
        return self::$db->insert('devices', $deviceData);
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
}
