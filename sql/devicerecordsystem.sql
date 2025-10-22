-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS devicerecordsystem;

-- Use the database
USE devicerecordsystem;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  mobile_number VARCHAR(15) NOT NULL UNIQUE,
  gender ENUM('Male', 'Female') NOT NULL,
  password VARCHAR(255) NOT NULL,
  confirm_password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
