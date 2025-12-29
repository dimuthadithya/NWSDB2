-- ===============================================================
-- DEVICE RECORD SYSTEM (CORRECTED ORDER)
-- ===============================================================

CREATE DATABASE IF NOT EXISTS devicerecordsystem;
USE devicerecordsystem;

-- ===============================================================
-- 1. DEVICE CATEGORIES (NO DEPENDENCIES)
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
-- 2. REGIONS (NO DEPENDENCIES)
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
-- 3. AREAS (DEPENDS ON REGIONS)
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
-- 4. WATER SUPPLY SCHEMES (DEPENDS ON AREAS)
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
-- 5. USERS (DEPENDS ON WSS)
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
-- 6. SECTIONS (DEPENDS ON WSS)
-- ===============================================================
CREATE TABLE sections (
  section_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  section_name VARCHAR(150) NOT NULL,
  wss_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (section_id),
  UNIQUE (section_name, wss_id),
  CONSTRAINT fk_sections_wss FOREIGN KEY (wss_id)
    REFERENCES water_supply_schemes(wss_id) 
    ON DELETE CASCADE
);

-- ===============================================================
-- 7. DEVICES (DEPENDS ON CATEGORIES, WSS, SECTIONS)
-- ===============================================================
CREATE TABLE devices (
  device_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_name VARCHAR(150) NOT NULL,
  model VARCHAR(100),
  category_id INT UNSIGNED NOT NULL,
  wss_id INT NOT NULL,
  section_id INT UNSIGNED NULL,
  assigned_to VARCHAR(150) NULL,
  
  -- Common fields
  operating_system VARCHAR(100),
  processor VARCHAR(100),
  ram VARCHAR(50),
  hard_drive_capacity VARCHAR(50),

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

  -- Peripheral Checkboxes
  has_speaker TINYINT(1) DEFAULT 0,
  has_camera TINYINT(1) DEFAULT 0,
  has_mouse TINYINT(1) DEFAULT 0,
  has_web_cam TINYINT(1) DEFAULT 0,
  has_keyboard TINYINT(1) DEFAULT 0,

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
    REFERENCES sections(section_id) ON DELETE SET NULL
);

-- ===============================================================
-- 8. REPAIRS (DEPENDS ON DEVICES)
-- ===============================================================
CREATE TABLE repairs (
  repair_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  device_id INT UNSIGNED NOT NULL,
  repair_details TEXT,
  cost DECIMAL(10,2),
  repair_date DATE,
  status ENUM('pending','in_progress','completed','cancelled') DEFAULT 'pending',
  notes TEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (repair_id),
  CONSTRAINT fk_repairs_device FOREIGN KEY (device_id) 
    REFERENCES devices(device_id) ON DELETE CASCADE
);

-- ===============================================================
-- 9. DEVICE ISSUES (DEPENDS ON DEVICES, USERS)
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
  CONSTRAINT fk_issue_device FOREIGN KEY (device_id) 
    REFERENCES devices(device_id) ON DELETE CASCADE,
  CONSTRAINT fk_issue_user FOREIGN KEY (reported_by) 
    REFERENCES users(user_id) ON DELETE SET NULL
);