-- ===============================================================
-- DUMMY DATA FOR DEVICE RECORD SYSTEM
-- ===============================================================

USE devicerecordsystem;

-- ===============================================================
-- 1. Insert Device Categories
-- ===============================================================
INSERT INTO device_categories (category_name, description) VALUES
('Desktop Computer', 'Standard desktop computers for office use'),
('Laptop', 'Portable laptop computers'),
('Printer', 'Printing devices'),
('Network Device', 'Routers, switches, and network equipment'),
('RVPN Device', 'Remote VPN connection devices'),
('Fingerprint Device', 'Biometric fingerprint scanners'),
('UPS', 'Uninterruptible Power Supply units'),
('Monitor', 'Display monitors');

-- ===============================================================
-- 2. Insert Regions
-- ===============================================================
INSERT INTO regions (region_code, region_name, status) VALUES
('REG001', 'Central Region', 'active'),
('REG002', 'Western Region', 'active'),
('REG003', 'Southern Region', 'active'),
('REG004', 'Northern Region', 'active'),
('REG005', 'Eastern Region', 'active');

-- ===============================================================
-- 3. Insert Areas
-- ===============================================================
INSERT INTO areas (region_id, area_code, area_name, status) VALUES
(1, 'AREA001', 'Colombo District', 'active'),
(1, 'AREA002', 'Kandy District', 'active'),
(2, 'AREA003', 'Gampaha District', 'active'),
(2, 'AREA004', 'Kalutara District', 'active'),
(3, 'AREA005', 'Galle District', 'active'),
(3, 'AREA006', 'Matara District', 'active'),
(4, 'AREA007', 'Jaffna District', 'active'),
(5, 'AREA008', 'Batticaloa District', 'active');

-- ===============================================================
-- 4. Insert Water Supply Schemes
-- ===============================================================
INSERT INTO water_supply_schemes (area_id, wss_code, wss_name, status) VALUES
(1, 'WSS001', 'Colombo City Water Supply', 'active'),
(1, 'WSS002', 'Dehiwala Water Supply', 'active'),
(2, 'WSS003', 'Kandy Municipal Water Supply', 'active'),
(3, 'WSS004', 'Gampaha Regional Water Supply', 'active'),
(4, 'WSS005', 'Kalutara Water Distribution', 'active'),
(5, 'WSS006', 'Galle Urban Water Supply', 'active'),
(6, 'WSS007', 'Matara District Water Supply', 'active'),
(7, 'WSS008', 'Jaffna Peninsula Water Supply', 'active'),
(8, 'WSS009', 'Batticaloa Water Board', 'active');

-- ===============================================================
-- 5. Insert Users
-- ===============================================================
INSERT INTO users (first_name, last_name, username, email, mobile_number, gender, password, wss_id, role, status) VALUES
('Rajesh', 'Kumar', 'rkumar', 'rajesh.kumar@waterboard.lk', '0771234567', 'male', '$2y$10$abcdefghijklmnopqrstuv', 1, 'admin', 'active'),
('Priya', 'Fernando', 'pfernando', 'priya.fernando@waterboard.lk', '0772345678', 'female', '$2y$10$abcdefghijklmnopqrstuv', 1, 'user', 'active'),
('Saman', 'Perera', 'sperera', 'saman.perera@waterboard.lk', '0773456789', 'male', '$2y$10$abcdefghijklmnopqrstuv', 2, 'user', 'active'),
('Nilantha', 'Silva', 'nsilva', 'nilantha.silva@waterboard.lk', '0774567890', 'male', '$2y$10$abcdefghijklmnopqrstuv', 3, 'admin', 'active'),
('Amara', 'Jayasinghe', 'ajayasinghe', 'amara.jay@waterboard.lk', '0775678901', 'female', '$2y$10$abcdefghijklmnopqrstuv', 3, 'user', 'active'),
('Kamal', 'Wickramasinghe', 'kwickrama', 'kamal.w@waterboard.lk', '0776789012', 'male', '$2y$10$abcdefghijklmnopqrstuv', 4, 'user', 'active'),
('Chandani', 'Dissanayake', 'cdissanayake', 'chandani.d@waterboard.lk', '0777890123', 'female', '$2y$10$abcdefghijklmnopqrstuv', 5, 'user', 'active'),
('Tharindu', 'Rodrigo', 'trodrigo', 'tharindu.r@waterboard.lk', '0778901234', 'male', '$2y$10$abcdefghijklmnopqrstuv', 6, 'admin', 'active'),
('Sanduni', 'Mendis', 'smendis', 'sanduni.m@waterboard.lk', '0779012345', 'female', '$2y$10$abcdefghijklmnopqrstuv', 7, 'user', 'active'),
('Buddhika', 'Amarasinghe', 'bamarasinghe', 'buddhika.a@waterboard.lk', '0770123456', 'male', '$2y$10$abcdefghijklmnopqrstuv', 8, 'user', 'active');

-- ===============================================================
-- 6. Insert Sections
-- ===============================================================
INSERT INTO sections (section_name, wss_id) VALUES
('Administration', 1),
('Technical Department', 1),
('Finance Division', 1),
('Customer Service', 1),
('Engineering Section', 2),
('Operations', 2),
('Maintenance Team', 3),
('Quality Control', 3),
('IT Department', 4),
('Human Resources', 4),
('Procurement', 5),
('Distribution Network', 6),
('Billing Section', 7),
('Field Operations', 8);

-- ===============================================================
-- 7. Insert Devices - Regular Computers
-- ===============================================================
INSERT INTO devices (device_name, model, category_id, wss_id, section_id, assigned_to, operating_system, processor, ram, hard_drive_capacity, ip_address, system_unit_serial, purchase_date, status, has_keyboard, has_mouse, has_speaker, has_camera, has_web_cam) VALUES
('Admin Desktop 01', 'Dell OptiPlex 7090', 1, 1, 1, 'Rajesh Kumar', 'Windows 11 Pro', 'Intel Core i7-11700', '16GB', '512GB SSD', '192.168.1.101', 'DL7090-SN001', '2023-01-15', 'active', 1, 1, 1, 0, 0),
('Tech Laptop 01', 'HP EliteBook 840', 2, 1, 2, 'Priya Fernando', 'Windows 10 Pro', 'Intel Core i5-10210U', '8GB', '256GB SSD', '192.168.1.102', 'HP840-SN002', '2022-11-20', 'active', 1, 1, 1, 1, 1),
('Finance Desktop 01', 'Lenovo ThinkCentre M70', 1, 1, 3, 'Saman Perera', 'Windows 11 Pro', 'Intel Core i5-11400', '16GB', '1TB HDD', '192.168.1.103', 'LN-M70-SN003', '2023-03-10', 'active', 1, 1, 0, 0, 0),
('Network Printer 01', 'HP LaserJet Pro M404dn', 3, 1, 4, NULL, NULL, NULL, NULL, NULL, '192.168.1.201', 'HP-LJ-SN201', '2023-02-05', 'active', 0, 0, 0, 0, 0),
('Engineering Workstation', 'Dell Precision 3650', 1, 2, 5, 'Nilantha Silva', 'Windows 11 Pro', 'Intel Xeon W-1350', '32GB', '1TB SSD', '192.168.2.101', 'DL-PR-SN004', '2023-05-12', 'active', 1, 1, 0, 0, 0),
('Operations Laptop', 'Lenovo ThinkPad X1 Carbon', 2, 2, 6, 'Amara Jayasinghe', 'Windows 10 Pro', 'Intel Core i7-10510U', '16GB', '512GB SSD', '192.168.2.102', 'LN-X1-SN005', '2022-09-18', 'active', 1, 1, 1, 1, 1),
('Maintenance Desktop', 'Acer Veriton M200', 1, 3, 7, 'Kamal Wickramasinghe', 'Windows 10 Pro', 'Intel Core i3-10100', '8GB', '256GB SSD', '192.168.3.101', 'AC-VM-SN006', '2022-07-22', 'under_repair', 1, 1, 0, 0, 0),
('QC Desktop', 'ASUS ExpertCenter D5', 1, 3, 8, 'Chandani Dissanayake', 'Windows 11 Pro', 'Intel Core i5-11400', '16GB', '512GB SSD', '192.168.3.102', 'AS-D5-SN007', '2023-04-08', 'active', 1, 1, 0, 0, 0),
('IT Admin Workstation', 'Dell OptiPlex 7090', 1, 4, 9, 'Tharindu Rodrigo', 'Windows 11 Pro', 'Intel Core i7-11700', '32GB', '1TB SSD', '192.168.4.101', 'DL-OPT-SN008', '2023-06-15', 'active', 1, 1, 0, 0, 0),
('HR Laptop', 'HP ProBook 450 G8', 2, 4, 10, 'Sanduni Mendis', 'Windows 10 Pro', 'Intel Core i5-1135G7', '8GB', '256GB SSD', '192.168.4.102', 'HP-PB-SN009', '2022-12-03', 'active', 1, 1, 1, 1, 1);

-- ===============================================================
-- 8. Insert Devices - RVPN Devices
-- ===============================================================
INSERT INTO devices (device_name, model, category_id, wss_id, section_id, assigned_to, employee_number, designation, working_location, rvpn_serial_number, rvpn_username, connection_required, status) VALUES
('RVPN Device 01', 'Cisco AnyConnect', 5, 1, 2, 'Priya Fernando', 'EMP001', 'Technical Officer', 'Colombo Office', 'RVPN-2023-001', 'pfernando_vpn', 'required', 'active'),
('RVPN Device 02', 'Fortinet SSL VPN', 5, 2, 5, 'Nilantha Silva', 'EMP002', 'Chief Engineer', 'Dehiwala Office', 'RVPN-2023-002', 'nsilva_vpn', 'required', 'active'),
('RVPN Device 03', 'Cisco AnyConnect', 5, 3, 7, 'Kamal Wickramasinghe', 'EMP003', 'Maintenance Supervisor', 'Kandy Office', 'RVPN-2023-003', 'kwickrama_vpn', 'required', 'active');

-- ===============================================================
-- 9. Insert Devices - Fingerprint Devices
-- ===============================================================
INSERT INTO devices (device_name, category_id, wss_id, section_id, location_name, sub_location, make, device_type, device_number, ip_address, installed_date, company_name, device_cost, warranty_period, managed_by, approval_status, status) VALUES
('Fingerprint Scanner Main Gate', 6, 1, 1, 'Main Office Building', 'Entrance Gate', 'ZKTeco', 'Biometric Reader', 'FP-001', '192.168.1.210', '2023-01-10', 'ZKTeco Lanka', 45000.00, '2 years', 'IT Department', 'approved', 'active'),
('Fingerprint Scanner Admin Block', 6, 1, 1, 'Admin Block', 'Ground Floor', 'Suprema', 'BioStation 2', 'FP-002', '192.168.1.211', '2023-02-15', 'Suprema Lanka', 65000.00, '3 years', 'IT Department', 'approved', 'active'),
('Fingerprint Scanner Tech Wing', 6, 2, 5, 'Technical Wing', 'First Floor', 'ZKTeco', 'ProCapture X', 'FP-003', '192.168.2.210', '2023-03-20', 'ZKTeco Lanka', 50000.00, '2 years', 'IT Department', 'approved', 'active'),
('Fingerprint Scanner Kandy Office', 6, 3, 7, 'Kandy Regional Office', 'Main Entrance', 'Hikvision', 'DS-K1T341', 'FP-004', '192.168.3.210', '2023-04-05', 'Hikvision Lanka', 55000.00, '2 years', 'Security Team', 'approved', 'active');

-- ===============================================================
-- 10. Insert Repairs
-- ===============================================================
INSERT INTO repairs (device_id, repair_details, cost, repair_date, status) VALUES
(7, 'Replaced motherboard due to power surge damage', 15000.00, '2024-10-15', 'completed'),
(4, 'Fixed paper jam issue and cleaned printer heads', 2500.00, '2024-09-20', 'completed'),
(6, 'Upgraded RAM and replaced battery', 8500.00, '2024-08-10', 'completed'),
(3, 'Replaced hard drive and reinstalled OS', 12000.00, '2024-11-01', 'pending');

-- ===============================================================
-- 11. Insert Device Issues
-- ===============================================================
INSERT INTO device_issues (device_id, reported_by, issue_title, issue_description, priority, status, reported_at) VALUES
(1, 2, 'Slow Performance', 'Computer is running very slowly, takes long time to boot', 'medium', 'in_progress', '2024-11-15 09:30:00'),
(3, 3, 'Network Connectivity Problem', 'Unable to connect to network shares intermittently', 'high', 'open', '2024-11-16 11:15:00'),
(5, 5, 'Software Installation Issue', 'AutoCAD installation fails with error code', 'medium', 'open', '2024-11-17 14:20:00'),
(7, 6, 'Hardware Failure', 'Computer not turning on, suspected motherboard issue', 'high', 'resolved', '2024-10-10 10:00:00'),
(9, 8, 'Printer Not Responding', 'Network printer showing offline status', 'low', 'closed', '2024-11-10 16:45:00'),
(10, 9, 'Screen Flickering', 'Laptop screen flickers when opened beyond 90 degrees', 'medium', 'in_progress', '2024-11-14 13:30:00');