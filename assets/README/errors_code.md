# NWSDB Device Record System - Error Codes & Solutions

## Phase 1: Initial Setup & Authentication

### Error 1: Form Attribute Case Sensitivity

**Before:**

```html
<form method="post" action="auth.php"></form>
```

**After:**

```html
<form method="POST" action="auth.php"></form>
```

---

### Error 2: Incorrect File Extension in Links

**Before:**

```html
<a href="index.html">Sign In</a>
```

**After:**

```html
<a href="index.php">Sign In</a>
```

---

### Error 3: Database Schema - NULL Value Constraints

**Before:**

```sql
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL
);
```

**After:**

```sql
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NULL,
    mobile_number VARCHAR(15) NULL
);
```

---

## Phase 2: User Registration & Authentication System

### Error 4: Form Submission Parameter Mismatch

**Before:**

```html
<form method="POST" action="auth.php">
  <button type="submit" name="submit">Register</button>
</form>
```

```php
if (isset($_POST['register'])) {
    // Process registration
}
```

**After:**

```html
<form method="POST" action="auth.php">
  <button type="submit" name="register">Register</button>
</form>
```

```php
if (isset($_POST['register'])) {
    // Process registration
}
```

---

### Error 5: Incorrect Form Action Path

**Before:**

```html
<form action="process_register.php" method="POST"></form>
```

**After:**

```html
<form action="auth.php" method="POST"></form>
```

---

### Error 6: Method Parameter Misalignment

**Before:**

```php
public function createUser($username, $email, $password, $mobile_number, $site_office) {
    // Insert user
}

// Call
$result = $dbHelper->createUser($username, $email, $password, $mobile, $site);
```

**After:**

```php
public function createUser($email, $password, $gender = 'Male') {
    $username = $this->generateUsername($email);
    // Insert user
}

// Call
$result = $dbHelper->createUser($email, $password);
```

---

### Error 7: Mobile Number Field Name Inconsistency

**Before:**

```html
<input type="tel" name="mobile" required />
```

```php
$mobile = $_POST['mobile'];
$stmt = $pdo->prepare("INSERT INTO users (mobile_number) VALUES (?)");
```

**After:**

```html
<input type="tel" name="mobile_number" required />
```

```php
$mobile_number = $_POST['mobile_number'];
$stmt = $pdo->prepare("INSERT INTO users (mobile_number) VALUES (?)");
```

---

### Error 8: User ID Field Mismatch

**Before:**

```php
$user = $db->select('users', ['*'], ['id' => $userId]);
$_SESSION['user_id'] = $user['userId'];
```

**After:**

```php
$user = $db->select('users', ['*'], ['user_id' => $userId]);
$_SESSION['user_id'] = $user['user_id'];
```

---

## Phase 3: Session Management & Navigation

### Error 9: Login Redirect Path

**Before:**

```php
if ($user) {
    header('Location: dashboard.php');
    exit();
}
```

**After:**

```php
if ($user) {
    header('Location: index.php');
    exit();
}
```

---

### Error 10: Session Handling Issues

**Before:**

```php
// Each page separately
session_start();
require_once 'config/db.php';
require_once 'functions/DbHelper.php';
```

**After:**

```php
// sessions.php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../functions/Database.php';
require_once __DIR__ . '/../functions/DbHelper.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}
?>

// Each page
<?php require_once 'middleware/sessions.php'; ?>
```

---

### Error 11: DbHelper Not Included in Sessions

**Before:**

```php
// sessions.php
<?php
session_start();
require_once __DIR__ . '/../config/db.php';
?>
```

**After:**

```php
// sessions.php
<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../functions/Database.php';
require_once __DIR__ . '/../functions/DbHelper.php';
?>
```

---

## Phase 4: Database Integration & CRUD Operations

### Error 12: Missing Database Method

**Before:**

```php
// Database.php - getId() method not implemented
$lastId = $db->getId();  // Fatal error
```

**After:**

```php
// Database.php
public function getId() {
    return $this->conn->lastInsertId();
}

// Usage
$db->insert('users', $data);
$userId = $db->getId();
```

---

### Error 13: Device Category Name Inconsistency

**Before:**

```php
// DbHelper.php
public function getAllComputers() {
    $categoryId = $this->getCategoryIdByName('Computer');
    return self::$db->select('devices', ['*'], ['category_id' => $categoryId]);
}
```

```sql
-- Database
INSERT INTO device_categories (category_name) VALUES ('Desktop Computer');
```

**After:**

```php
// DbHelper.php
public function getAllComputers() {
    $categoryId = $this->getCategoryIdByName('Desktop Computer');
    return self::$db->select('devices', ['*'], ['category_id' => $categoryId]);
}
```

---

### Error 14: Foreign Key Relationship Errors

**Before:**

```sql
CREATE TABLE devices (
    device_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES device_categories(category_id) ON DELETE CASCADE
);
```

**After:**

```sql
CREATE TABLE devices (
    device_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES device_categories(category_id) ON DELETE RESTRICT
);
```

---

## Phase 5: Navigation & UI Issues

### Error 15: Broken Sidebar Links

**Before:**

```php
<a href="computer.php">Computers</a>
<a href="printer.php">Printers</a>
<a href="admin/site-offices.php">Site Offices</a>
```

**After:**

```php
<a href="computers.php">Computers</a>
<a href="printers.php">Printers</a>
<a href="admin/site_offices.php">Site Offices</a>
```

---

### Error 16: Duplicate Navigation Items

**Before:**

```php
// sidemenu.php
<a href="reports.php">Reports</a>
<!-- ... other items ... -->
<a href="reports.php">Reports</a>
```

**After:**

```php
// sidemenu.php
<a href="reports.php">Reports</a>
<!-- ... other items ... -->
```

---

### Error 17: File Naming Convention Conflicts

**Before:**

```
site-offices.php
site_offices.html
laptops.php (duplicate)
```

**After:**

```
site_offices.php
laptops.php (single file)
```

---

## Phase 6: Data Display & Frontend Issues

### Error 18: Missing Data Fetching Functions

**Before:**

```php
// printers.php
<?php
require_once 'middleware/sessions.php';
$printers = DbHelper::getAllPrinters();  // Method doesn't exist
?>
```

**After:**

```php
// DbHelper.php
public static function getAllPrinters() {
    $categoryId = self::getCategoryIdByName('Printer');
    return self::$db->select('devices', ['*'], ['category_id' => $categoryId]);
}

// printers.php
<?php
require_once 'middleware/sessions.php';
$printers = DbHelper::getAllPrinters();
?>
```

---

### Error 19: Device Count Calculation Errors

**Before:**

```php
public function getDeviceCount($categoryName) {
    $devices = self::$db->select('devices', ['*']);
    return count($devices);  // Returns all devices, not filtered
}
```

**After:**

```php
public function getDeviceCount($categoryName) {
    $categoryId = self::getCategoryIdByName($categoryName);
    if (!$categoryId) return 0;

    $devices = self::$db->select('devices', ['*'], ['category_id' => $categoryId]);
    return count($devices);
}
```

---

### Error 20: Hardcoded Statistics Not Updated

**Before:**

```html
<div class="stat-card">
  <h3>Total Computers</h3>
  <p class="stat-number">150</p>
</div>
```

**After:**

```php
<?php
$computerCount = DbHelper::getDeviceCount('Desktop Computer');
?>
<div class="stat-card">
    <h3>Total Computers</h3>
    <p class="stat-number"><?php echo $computerCount; ?></p>
</div>
```

---

## Phase 7: Water Supply Management Module

### Error 21: Extra Form Fields Not Matching Schema

**Before:**

```html
<form id="addRegionForm">
  <input type="text" name="region_name" required />
  <input type="text" name="description" />
  <input type="text" name="manager_name" />
  <input type="email" name="manager_email" />
  <input type="tel" name="phone_number" />
  <!-- 10 more unnecessary fields -->
</form>
```

**After:**

```html
<form id="addRegionForm">
  <input type="text" name="region_name" required />
</form>
```

---

### Error 22: Duplicate Field in Modal

**Before:**

```html
<div class="modal">
  <label>Status</label>
  <select name="status">
    <option value="Active">Active</option>
  </select>

  <label>Status</label>
  <select name="status">
    <option value="Active">Active</option>
  </select>
</div>
```

**After:**

```html
<div class="modal">
  <label>Status</label>
  <select name="status">
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
  </select>
</div>
```

---

### Error 23: SQL Schema Verbosity

**Before:**

```sql
CREATE TABLE regions (
    region_id INT PRIMARY KEY AUTO_INCREMENT,
    region_name VARCHAR(100) NOT NULL,
    description TEXT,
    manager_name VARCHAR(100),
    manager_email VARCHAR(100),
    phone_number VARCHAR(15),
    fax_number VARCHAR(15),
    address TEXT,
    established_date DATE,
    budget DECIMAL(15,2)
    -- 5 more unnecessary columns
);
```

**After:**

```sql
CREATE TABLE regions (
    region_id INT PRIMARY KEY AUTO_INCREMENT,
    region_name VARCHAR(100) NOT NULL
);
```

---

## Phase 8: Active Navigation & Dynamic Content

### Error 24: Static Navigation Highlighting

**Before:**

```php
<a href="dashboard.php" class="active">Dashboard</a>
<a href="computers.php">Computers</a>
```

**After:**

```php
<?php
function isActive($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page ? 'active' : '';
}
?>
<a href="dashboard.php" class="<?php echo isActive('dashboard.php'); ?>">Dashboard</a>
<a href="computers.php" class="<?php echo isActive('computers.php'); ?>">Computers</a>
```

---

### Error 25: Static Header Content

**Before:**

```php
// header.php
<h1>Dashboard</h1>
<p>Welcome to Device Management System</p>
```

**After:**

```php
// Each page
<?php
$page_info = [
    'title' => 'Computers',
    'description' => 'Manage desktop computers and workstations'
];
require_once 'includes/header.php';
?>

// header.php
<h1><?php echo $page_info['title']; ?></h1>
<p><?php echo $page_info['description']; ?></p>
```

---

## Phase 9: Advanced Features & Optimization

### Error 26: Missing Manual JOIN Logic

**Before:**

```php
public function getAllAreas() {
    return self::$db->select('areas', ['*']);
    // No region_name available
}
```

**After:**

```php
public function getAllAreas() {
    $areas = self::$db->select('areas', ['*']);
    $regions = self::$db->select('regions', ['*']);

    foreach ($areas as &$area) {
        $region = array_filter($regions, function($r) use ($area) {
            return $r['region_id'] == $area['region_id'];
        });
        $area['region_name'] = $region ? reset($region)['region_name'] : 'N/A';
    }

    return $areas;
}
```

---

### Error 27: Incorrect Default Gender Value

**Before:**

```php
public function createUser($email, $password) {
    $data = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'gender' => NULL  // Fails if NOT NULL constraint
    ];
    return self::$db->insert('users', $data);
}
```

**After:**

```php
public function createUser($email, $password, $gender = 'Male') {
    $data = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'gender' => $gender
    ];
    return self::$db->insert('users', $data);
}
```

---

### Error 28: Logout Link Path Error

**Before:**

```php
// sidemenu.php
<a href="logout.php">Logout</a>
```

**After:**

```php
// sidemenu.php
<a href="middleware/logout.php">Logout</a>
```

---

## Phase 10: Database Integration for Device Pages

### Error 29: Table Bodies Not Updated with Database Data

**Before:**

```php
<?php
$computers = DbHelper::getAllComputers();
$computerCount = count($computers);
?>

<p>Total: <?php echo $computerCount; ?></p>

<table>
    <tbody>
        <tr>
            <td>COMP-001</td>
            <td>Dell OptiPlex 7090</td>
            <td>Section A</td>
        </tr>
        <tr>
            <td>COMP-002</td>
            <td>HP EliteDesk 800</td>
            <td>Section B</td>
        </tr>
    </tbody>
</table>
```

**After:**

```php
<?php
$computers = DbHelper::getAllComputers();
$computerCount = count($computers);
?>

<p>Total: <?php echo $computerCount; ?></p>

<table>
    <tbody>
        <?php foreach ($computers as $computer): ?>
        <tr>
            <td><?php echo htmlspecialchars($computer['device_id']); ?></td>
            <td><?php echo htmlspecialchars($computer['device_name']); ?></td>
            <td><?php echo htmlspecialchars($computer['section_name']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```

---

### Error 30: Empty State Not Handled

**Before:**

```php
<?php
$devices = DbHelper::getAllComputers();
?>

<table>
    <tbody>
        <?php foreach ($devices as $device): ?>
        <tr>
            <td><?php echo $device['device_name']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```

**After:**

```php
<?php
$devices = DbHelper::getAllComputers();
?>

<table>
    <tbody>
        <?php if (empty($devices)): ?>
        <tr>
            <td colspan="5" class="text-center py-4">
                <p class="text-gray-500">No devices found</p>
            </td>
        </tr>
        <?php else: ?>
        <?php foreach ($devices as $device): ?>
        <tr>
            <td><?php echo htmlspecialchars($device['device_name']); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
```

---

## Additional Best Practice Code Examples

### Consistent Error Handling

```php
// Database.php
public function select($table, $columns = ['*'], $conditions = []) {
    try {
        $columnList = implode(', ', $columns);
        $sql = "SELECT $columnList FROM $table";

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return [];
    }
}
```

### Dynamic Page Title System

```php
// config/page_titles.php
<?php
return [
    'dashboard.php' => [
        'title' => 'Dashboard',
        'description' => 'Overview of all devices and statistics'
    ],
    'computers.php' => [
        'title' => 'Desktop Computers',
        'description' => 'Manage desktop computers and workstations'
    ],
    'printers.php' => [
        'title' => 'Printers',
        'description' => 'Manage printing devices'
    ]
];
?>

// Usage in pages
<?php
$pageTitles = require_once 'config/page_titles.php';
$currentPage = basename($_SERVER['PHP_SELF']);
$page_info = $pageTitles[$currentPage] ?? ['title' => 'Page', 'description' => ''];
?>
```

### Centralized Database Constants

```php
// config/constants.php
<?php
define('DEVICE_CATEGORIES', [
    'DESKTOP' => 'Desktop Computer',
    'LAPTOP' => 'Laptop',
    'PRINTER' => 'Printer',
    'RVPN' => 'RVPN Connection',
    'FINGERPRINT' => 'Fingerprint Device'
]);

define('USER_ROLES', [
    'ADMIN' => 1,
    'USER' => 2,
    'VIEWER' => 3
]);
?>

// Usage
<?php
$computers = DbHelper::getAllDevicesByCategory(DEVICE_CATEGORIES['DESKTOP']);
?>
```

---

**Document Version**: 1.0  
**Last Updated**: November 17, 2025  
**Total Errors Documented**: 30
