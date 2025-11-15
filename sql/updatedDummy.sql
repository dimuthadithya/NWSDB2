USE devicerecordsystem;

-- ===============================================================
-- 1. USERS (10 dummy users)
-- ===============================================================
INSERT INTO users (first_name,last_name,username,email,mobile_number,gender,password,site_office,role,status,last_login)
VALUES
('Admin','User','admin','admin@example.com','0777000001','Male','admin123','Head Office','admin','active',NOW()),
('John','Doe','jdoe','john@example.com','0777000002','Male','pass123','WSS Badulla','user','active',NOW()),
('Sarah','Perera','sperera','sarah@example.com','0777000003','Female','pass123','WSS Bandarawela','user','active',NOW()),
('Kamal','Silva','kamal','kamal@example.com','0777000004','Male','pass123','WSS Hali Ela','user','active',NOW()),
('Nadeesha','Fernando','nadee','nadeesha@example.com','0777000005','Female','pass123','WSS Mahiyanganaya','user','active',NOW()),
('Ruwan','Sampath','ruwan','ruwan@example.com','0777000006','Male','pass123','WSS Welimada','user','active',NOW()),
('Ishara','Madushani','ishara','ishara@example.com','0777000007','Female','pass123','WSS Uva Paranagama','user','active',NOW()),
('Nimal','Bandara','nimal','nimal@example.com','0777000008','Male','pass123','WSS Bandarawela','user','active',NOW()),
('Suneth','Weerasinghe','suneth','suneth@example.com','0777000009','Male','pass123','WSS Badulla','user','active',NOW()),
('Dilani','Karunarathna','dilani','dilani@example.com','0777000010','Female','pass123','Head Office','user','active',NOW());

-- ===============================================================
-- 2. DEVICE CATEGORIES
-- ===============================================================
INSERT INTO device_categories (category_name,description) VALUES
('Desktop Computer','General desktop computers'),
('Laptop','Portable computers'),
('Printer','Printers and multifunction machines'),
('RVPN Connection','Remote VPN access setup'),
('Fingerprint Device','Biometric attendance devices');

-- ===============================================================
-- 3. REGIONS
-- ===============================================================
INSERT INTO regions (region_code,region_name,status) VALUES
('UP','Uva Province','active');

-- ===============================================================
-- 4. AREAS (UNDER REGION 1)
-- ===============================================================
INSERT INTO areas (region_id,area_code,area_name,status) VALUES
(1,'BAD','Badulla','active'),
(1,'BND','Bandarawela','active'),
(1,'HEL','Hali Ela','active');

-- ===============================================================
-- 5. WATER SUPPLY SCHEMES (WSS)
-- ===============================================================
INSERT INTO water_supply_schemes (area_id,wss_code,wss_name,status) VALUES
(1,'ELL','Elliya WSS','active'),
(1,'BADW','Badulla Town WSS','active'),
(2,'BNDW','Bandarawela City WSS','active'),
(3,'HELW','Hali Ela WSS','active');

-- ===============================================================
-- 6. SECTIONS (BELONG TO WSS)
-- ===============================================================
INSERT INTO sections (section_name,wss_id) VALUES
('IT Section',1),
('HR Section',1),
('Technical Section',2),
('Billing Section',3),
('Maintenance Section',4);

-- ===============================================================
-- 7. DEVICES (ASSIGNED TO EXISTING WSS + SECTIONS + USERS)
-- ===============================================================
INSERT INTO devices (
  device_name,model,category_id,wss_id,section_id,assigned_to,
  operating_system,processor,ram,hard_drive_capacity,status,
  monitor_info,system_unit_serial,ups_serial,purchase_date
)
VALUES
('Desktop PC','Dell OptiPlex 7010',1,1,1,2,'Windows 10','Intel i5','8GB','500GB','active','Dell 22 inch','D12345','U9988','2024-02-10'),
('Laptop','HP ProBook 450 G6',2,2,3,3,'Windows 11','Intel i7','16GB','1TB SSD','active','N/A','N/A','N/A','2024-03-12'),
('Printer','Canon LBP 2900',3,3,4,NULL,NULL,NULL,NULL,NULL,'active','N/A','SN123P','N/A','2023-11-01'),
('RVPN Connection','-',4,1,NULL,4,NULL,NULL,NULL,NULL,'active','N/A','RVPN01','N/A','2024-01-15'),
('Fingerprint Device','ZKTeco F18',5,4,5,5,NULL,NULL,NULL,NULL,'active','N/A','FD5566','N/A','2023-09-22');

-- ===============================================================
-- 8. REPAIRS
-- ===============================================================
INSERT INTO repairs (device_id,technician_id,repair_details,cost,repair_date,status)
VALUES
(1,2,'Replaced RAM',1200.00,'2025-02-15','completed'),
(2,3,'Updated BIOS and drivers',0.00,'2025-03-01','completed'),
(3,6,'Fixed paper jam issue',300.00,'2025-03-10','completed');

-- ===============================================================
-- 9. DEVICE ISSUES
-- ===============================================================
INSERT INTO device_issues (device_id,reported_by,issue_title,issue_description,priority,status)
VALUES
(1,2,'Slow performance','PC running very slow for user', 'medium','open'),
(2,3,'Battery issue','Laptop battery draining quickly','high','in_progress'),
(5,5,'Device offline','Fingerprint machine not syncing data','high','open');
