-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS devicerecordsystem;

-- Use the database
USE devicerecordsystem;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  username VARCHAR(50)  UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  mobile_number VARCHAR(15)  UNIQUE,
  gender ENUM('Male', 'Female') NOT NULL,
  password VARCHAR(255) NOT NULL,
  site_office VARCHAR(100) ,
  role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  status ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login  DATETIME DEFAULT NULL
);


-- Insert default admin user (password: admin123)
INSERT INTO users (first_name, last_name, username, email, mobile_number, gender, password, site_office, role)
VALUES ('Admin', 'User', 'admin', 'admin@gmail.com'  , '0000000000', 'Male', SHA2('admin123', 256), 'Head Office', 'admin')
ON DUPLICATE KEY UPDATE id=id; -- Prevent duplicate insertion on rerun 
-- You can add more tables and initial data as needed
-- End of SQL script