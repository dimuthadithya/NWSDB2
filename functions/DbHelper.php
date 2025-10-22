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
