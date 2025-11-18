-- ===============================================================
-- DEVICE RECORD SYSTEM (UPDATED: Sections belong to WSS)
-- ===============================================================

CREATE DATABASE IF NOT EXISTS devicerecordsystem;
USE devicerecordsystem;

-- ===============================================================
-- 1. USERS TABLE
-- ===============================================================
CREATE TABLE users (
  user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  username VARCHAR(50) UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  mobile_number VARCHAR(15) UNIQUE,
  gender VARCHAR(10),
  password VARCHAR(255) NOT NULL,
  wss_id INT DEFAULT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  status ENUM('active','inactive','suspended') DEFAULT 'active',
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login DATETIME DEFAULT NULL,
  CONSTRAINT fk_users_wss FOREIGN KEY (wss_id)
    REFERENCES water_supply_schemes(wss_id) ON DELETE SET NULL
);

-- ===============================================================
-- 2. DEVICE CATEGORIES
-- ===============================================================
CREATE TABLE device_categories (
  category_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(100) NOT NULL,
  description TEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (category_id),
  UNIQUE (category_name)
);

-- ===============================================================
-- 3. REGIONS
-- ===============================================================
CREATE TABLE regions (
  region_id INT NOT NULL AUTO_INCREMENT,
  region_code VARCHAR(20) NOT NULL,
  region_name VARCHAR(100) NOT NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (region_id),
  UNIQUE (region_code)
);

-- ===============================================================
-- 4. AREAS (UNDER REGIONS)
-- ===============================================================
CREATE TABLE areas (
  area_id INT NOT NULL AUTO_INCREMENT,
  region_id INT NOT NULL,
  area_code VARCHAR(20) NOT NULL,
  area_name VARCHAR(100) NOT NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (area_id),
  UNIQUE (area_code),
  CONSTRAINT fk_areas_region FOREIGN KEY (region_id)
    REFERENCES regions(region_id) ON DELETE CASCADE
);

-- ===============================================================
-- 5. WATER SUPPLY SCHEMES (WSS) UNDER AREAS
-- ===============================================================
CREATE TABLE water_supply_schemes (
  wss_id INT NOT NULL AUTO_INCREMENT,
  area_id INT NOT NULL,
  wss_code VARCHAR(20) NOT NULL,
  wss_name VARCHAR(100) NOT NULL,
  status ENUM('active','inactive','maintenance') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (wss_id),
  UNIQUE (wss_code),
  CONSTRAINT fk_wss_area FOREIGN KEY (area_id)
    REFERENCES areas(area_id) ON DELETE CASCADE
);

-- ===============================================================
-- 6. SECTIONS BELONG TO WSS  <<< UPDATED
-- ===============================================================
CREATE TABLE sections (
  section_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  section_name VARCHAR(150) NOT NULL,
  wss_id INT NOT NULL,  -- UPDATED: SECTION BELONGS TO WSS  
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (section_id),
  UNIQUE (section_name, wss_id),
  CONSTRAINT fk_sections_wss FOREIGN KEY (wss_id)
    REFERENCES water_supply_schemes(wss_id) 
    ON DELETE CASCADE
);

-- ===============================================================
-- 7. DEVICES (BELONG TO WSS + SECTION + USER)
-- ===============================================================
CREATE TABLE devices (
  device_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_name VARCHAR(150) NOT NULL,
  model VARCHAR(100),
  category_id INT UNSIGNED NOT NULL,
  wss_id INT NOT NULL,              -- new: device directly belongs to WSS
  section_id INT UNSIGNED NULL,     -- optional section under WSS
  assigned_to INT UNSIGNED NULL,    -- user assigned
  
  -- Common fields
  operating_system VARCHAR(100),
  processor VARCHAR(100),
  ram VARCHAR(50),
  hard_drive_capacity VARCHAR(50),
  keyboard VARCHAR(50),
  mouse VARCHAR(50),
  network_connectivity VARCHAR(100),
  printer_connectivity VARCHAR(100),
  virus_guard VARCHAR(100),
  ip_address VARCHAR(45),
  monitor_info VARCHAR(100),
  system_unit_serial VARCHAR(100),
  ups_serial VARCHAR(100),
  purchase_date DATE,
  status ENUM('active','under_repair','retired','lost') DEFAULT 'active',
  notes TEXT,

  -- RVPN fields
  employee_number VARCHAR(50),
  designation VARCHAR(100),
  working_location VARCHAR(150),
  cost_code VARCHAR(50),
  rvpn_serial_number VARCHAR(100),
  rvpn_username VARCHAR(100),
  pin_number VARCHAR(50),
  connection_required ENUM('required','not_required'),

  -- Fingerprint device fields
  location_name VARCHAR(150),
  sub_location VARCHAR(150),
  make VARCHAR(100),
  device_type VARCHAR(100),
  device_number VARCHAR(50),
  identification_code VARCHAR(100),
  ip_address_adsl VARCHAR(100),
  installed_date DATE,
  company_name VARCHAR(150),
  device_cost DECIMAL(10,2),
  warranty_period VARCHAR(50),
  port_number VARCHAR(20),
  managed_by VARCHAR(100),
  approval_status ENUM('approved','pending','rejected'),
  remark TEXT,

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (device_id),

  CONSTRAINT fk_device_category FOREIGN KEY (category_id)
    REFERENCES device_categories(category_id),

  CONSTRAINT fk_device_wss FOREIGN KEY (wss_id)
    REFERENCES water_supply_schemes(wss_id),

  CONSTRAINT fk_device_section FOREIGN KEY (section_id)
    REFERENCES sections(section_id) ON DELETE SET NULL,

  CONSTRAINT fk_device_user FOREIGN KEY (assigned_to)
    REFERENCES users(user_id) ON DELETE SET NULL
);

-- ===============================================================
-- 8. REPAIRS
-- ===============================================================
CREATE TABLE repairs (
  repair_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_id INT UNSIGNED NOT NULL,
  technician_id INT UNSIGNED NULL,
  repair_details TEXT,
  cost DECIMAL(10,2),
  repair_date DATE,
  status ENUM('pending','completed') DEFAULT 'pending',
  PRIMARY KEY (repair_id),
  CONSTRAINT fk_repairs_device FOREIGN KEY (device_id) REFERENCES devices(device_id) ON DELETE CASCADE,
  CONSTRAINT fk_repairs_technician FOREIGN KEY (technician_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- ===============================================================
-- 9. DEVICE ISSUES
-- ===============================================================
CREATE TABLE device_issues (
  issue_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_id INT UNSIGNED NOT NULL,
  reported_by INT UNSIGNED NULL,
  issue_title VARCHAR(200) NOT NULL,
  issue_description TEXT,
  priority ENUM('low','medium','high') DEFAULT 'medium',
  status ENUM('open','in_progress','resolved','closed') DEFAULT 'open',
  reported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  resolved_at DATETIME NULL,
  PRIMARY KEY (issue_id),
  CONSTRAINT fk_issue_device FOREIGN KEY (device_id) REFERENCES devices(device_id) ON DELETE CASCADE,
  CONSTRAINT fk_issue_user FOREIGN KEY (reported_by) REFERENCES users(user_id) ON DELETE SET NULL
);
