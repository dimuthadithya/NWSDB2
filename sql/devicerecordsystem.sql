-- ===============================================================
-- Device Record System Database
-- This script creates the full database structure for a device
-- management system including users, branches, sections, device
-- categories, devices, repairs, and device issues.
-- ===============================================================

-- -----------------------------
-- 1. Create the database
-- -----------------------------
CREATE DATABASE IF NOT EXISTS devicerecordsystem;
USE devicerecordsystem;

-- ===============================================================
-- 2. Users Table
-- Stores information about system users (admins, employees, etc.)
-- ===============================================================
CREATE TABLE IF NOT EXISTS users (
  user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, -- Unsigned INT for FK compatibility
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  username VARCHAR(50) UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  mobile_number VARCHAR(15) UNIQUE,
  gender ENUM('Male', 'Female') NOT NULL,
  password VARCHAR(255) NOT NULL,
  site_office VARCHAR(100),
  role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  status ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login DATETIME DEFAULT NULL
);

-- ===============================================================
-- 3. Device Categories Table
-- Stores types/categories of devices (e.g., Computer, Printer)
-- ===============================================================
CREATE TABLE device_categories (
  category_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(100) NOT NULL,
  description TEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (category_id),
  UNIQUE KEY unique_category_name (category_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- 4. Branches Table
-- Stores company branches/offices
-- ===============================================================
CREATE TABLE branches (
  branch_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  branch_name VARCHAR(150) NOT NULL,
  location VARCHAR(255) NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (branch_id),
  UNIQUE KEY unique_branch_name (branch_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- 5. Sections Table
-- Sections belong to branches (e.g., IT, HR, Finance)
-- ===============================================================
CREATE TABLE sections (
  section_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  section_name VARCHAR(150) NOT NULL,
  branch_id INT UNSIGNED NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (section_id),
  UNIQUE KEY unique_section_branch (section_name, branch_id),
  CONSTRAINT fk_sections_branch FOREIGN KEY (branch_id) REFERENCES branches(branch_id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- 6. Devices Table
-- Stores details of each device in the system
-- ===============================================================
CREATE TABLE devices (
  device_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_name VARCHAR(150) NOT NULL,        -- Device type/name
  model VARCHAR(100) NULL,                  -- Device model
  category_id INT UNSIGNED NOT NULL,        -- Device category reference
  section_id INT UNSIGNED NULL,             -- Optional section assignment
  assigned_to INT UNSIGNED NULL,            -- User assigned to this device
  operating_system VARCHAR(100) NULL,
  processor VARCHAR(100) NULL,
  ram VARCHAR(50) NULL,
  hard_drive_capacity VARCHAR(50) NULL,
  keyboard VARCHAR(50) NULL,
  mouse VARCHAR(50) NULL,
  network_connectivity VARCHAR(100) NULL,
  printer_connectivity VARCHAR(100) NULL,
  virus_guard VARCHAR(100) NULL,
  ip_address VARCHAR(45) NULL,
  monitor_info VARCHAR(100) NULL,
  system_unit_serial VARCHAR(100) NULL,
  ups_serial VARCHAR(100) NULL,
  purchase_date DATE NULL,
  status ENUM('active','under_repair','retired','lost') DEFAULT 'active',
  notes TEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (device_id),
  CONSTRAINT fk_devices_category FOREIGN KEY (category_id) REFERENCES device_categories(category_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_devices_section FOREIGN KEY (section_id) REFERENCES sections(section_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_devices_user FOREIGN KEY (assigned_to) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- 7. Repairs Table
-- Stores repair history for devices
-- ===============================================================
CREATE TABLE repairs (
  repair_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_id INT UNSIGNED NOT NULL,
  technician_id INT UNSIGNED NULL,        -- Nullable for ON DELETE SET NULL
  repair_details TEXT NULL,
  cost DECIMAL(10,2) NULL,
  repair_date DATE NULL,
  status ENUM('pending','completed') DEFAULT 'pending',
  PRIMARY KEY (repair_id),
  CONSTRAINT fk_repairs_device FOREIGN KEY (device_id) REFERENCES devices(device_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_repairs_technician FOREIGN KEY (technician_id) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- 8. Device Issues Table
-- Tracks issues reported for devices
-- ===============================================================
CREATE TABLE device_issues (
  issue_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_id INT UNSIGNED NOT NULL,
  reported_by INT UNSIGNED NULL,           -- Nullable for ON DELETE SET NULL
  issue_title VARCHAR(200) NOT NULL,
  issue_description TEXT NULL,
  priority ENUM('low','medium','high') DEFAULT 'medium',
  status ENUM('open','in_progress','resolved','closed') DEFAULT 'open',
  reported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  resolved_at DATETIME NULL,
  PRIMARY KEY (issue_id),
  CONSTRAINT fk_issues_device FOREIGN KEY (device_id) REFERENCES devices(device_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_issues_user FOREIGN KEY (reported_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

