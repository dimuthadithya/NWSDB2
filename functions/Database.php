<?php

/**
 * Common database functions for CRUD operations
 */

class Database
{
    private $conn;
    private static $instance = null;

    private function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USERNAME,
                DB_PASSWORD
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get database instance (Singleton pattern)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Execute a query with parameters
     * @param string $query SQL query
     * @param array $params Parameters for the query
     * @return PDOStatement|false
     */
    private function executeQuery($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query execution failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Insert a record into a table
     * @param string $table Table name
     * @param array $data Associative array of column => value
     * @return int|false Last insert ID or false on failure
     */
    public function insert($table, $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));
            $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

            $stmt = $this->executeQuery($query, array_values($data));
            return $stmt ? $this->conn->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log("Insert failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update records in a table
     * @param string $table Table name
     * @param array $data Associative array of column => value to update
     * @param array $where Associative array of column => value for WHERE clause
     * @return bool Success or failure
     */
    public function update($table, $data, $where)
    {
        try {
            $setParts = array_map(function ($key) {
                return "{$key} = ?";
            }, array_keys($data));

            $whereParts = array_map(function ($key) {
                return "{$key} = ?";
            }, array_keys($where));

            $query = "UPDATE {$table} SET " . implode(", ", $setParts);
            if (!empty($whereParts)) {
                $query .= " WHERE " . implode(" AND ", $whereParts);
            }

            $params = array_merge(array_values($data), array_values($where));
            $stmt = $this->executeQuery($query, $params);
            return $stmt !== false;
        } catch (PDOException $e) {
            error_log("Update failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete records from a table
     * @param string $table Table name
     * @param array $where Associative array of column => value for WHERE clause
     * @return bool Success or failure
     */
    public function delete($table, $where)
    {
        try {
            $whereParts = array_map(function ($key) {
                return "{$key} = ?";
            }, array_keys($where));

            $query = "DELETE FROM {$table}";
            if (!empty($whereParts)) {
                $query .= " WHERE " . implode(" AND ", $whereParts);
            }

            $stmt = $this->executeQuery($query, array_values($where));
            return $stmt !== false;
        } catch (PDOException $e) {
            error_log("Delete failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Select records from a table
     * @param string $table Table name
     * @param array $columns Columns to select
     * @param array $where Optional WHERE conditions
     * @param string $orderBy Optional ORDER BY clause
     * @param int $limit Optional LIMIT clause
     * @param int $offset Optional OFFSET clause
     * @return array|false Array of records or false on failure
     */
    public function select($table, $columns = ["*"], $where = [], $orderBy = "", $limit = null, $offset = null)
    {
        try {
            $query = "SELECT " . implode(", ", $columns) . " FROM {$table}";

            $params = [];
            if (!empty($where)) {
                $whereParts = array_map(function ($key) {
                    return "{$key} = ?";
                }, array_keys($where));
                $query .= " WHERE " . implode(" AND ", $whereParts);
                $params = array_values($where);
            }

            if ($orderBy) {
                $query .= " ORDER BY {$orderBy}";
            }

            if ($limit !== null) {
                $query .= " LIMIT {$limit}";
                if ($offset !== null) {
                    $query .= " OFFSET {$offset}";
                }
            }

            $stmt = $this->executeQuery($query, $params);
            return $stmt ? $stmt->fetchAll() : false;
        } catch (PDOException $e) {
            error_log("Select failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a single record by ID
     * @param string $table Table name
     * @param int $id ID of the record
     * @param string $idColumn Name of the ID column (default: 'id')
     * @return array|false Record array or false if not found
     */
    public function getById($table, $id, $idColumn = 'id')
    {
        try {
            $query = "SELECT * FROM {$table} WHERE {$idColumn} = ? LIMIT 1";
            $stmt = $this->executeQuery($query, [$id]);
            return $stmt ? $stmt->fetch() : false;
        } catch (PDOException $e) {
            error_log("GetById failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count records in a table
     * @param string $table Table name
     * @param array $where Optional WHERE conditions
     * @return int|false Number of records or false on failure
     */
    public function count($table, $where = [])
    {
        try {
            $query = "SELECT COUNT(*) as count FROM {$table}";

            $params = [];
            if (!empty($where)) {
                $whereParts = array_map(function ($key) {
                    return "{$key} = ?";
                }, array_keys($where));
                $query .= " WHERE " . implode(" AND ", $whereParts);
                $params = array_values($where);
            }

            $stmt = $this->executeQuery($query, $params);
            return $stmt ? (int)$stmt->fetch()['count'] : false;
        } catch (PDOException $e) {
            error_log("Count failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    public function commit()
    {
        return $this->conn->commit();
    }

    /**
     * Rollback a transaction
     */
    public function rollback()
    {
        return $this->conn->rollBack();
    }

    /**
     * Get the last error message
     */
    public function getLastError()
    {
        $error = $this->conn->errorInfo();
        return $error[2];
    }
}
