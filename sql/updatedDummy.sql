USE devicerecordsystem;

-- ===============================================================
-- 1. USERS TABLE
-- ===============================================================
INSERT INTO users (first_name,last_name,username,email,mobile_number,gender,password,site_office,role,status,last_login)
VALUES
('Admin','One','admin1','admin1@example.com','0771000001','Male','adminpass1','Head Office','admin','active',NOW()),
('Admin','Two','admin2','admin2@example.com','0771000002','Female','adminpass2','Head Office','admin','active',NOW()),
('User','One','user1','user1@example.com','0771000003','Male','userpass1','WSS BADULLA','user','active',NOW()),
('User','Two','user2','user2@example.com','0771000004','Female','userpass2','WSS BANDARAWELA','user','active',NOW());

-- ===============================================================
-- 2. DEVICE CATEGORIES
-- ===============================================================
INSERT INTO device_categories (category_name,description)
VALUES
('Desktop Computer','Desktop computers for office use'),
('Laptop','Portable laptops'),
('Printer','Printers and multifunction devices'),
('RVPN Connection','Remote VPN connections for users'),
('Finger Device','Biometric finger devices');

-- ===============================================================
-- 3. REGIONS
-- ===============================================================
INSERT INTO regions (region_code,region_name,status)
VALUES
('BRD','Bandarawela Region','active');

-- ===============================================================
-- 4. AREAS
-- ===============================================================
INSERT INTO areas (region_id,area_code,area_name,status)
VALUES
(1,'BAD','Badulla','active'),
(1,'BND','Bandarawela','active');

-- ===============================================================
-- 5. WSS (WATER SUPPLY SCHEMES)
-- Based on your large list
-- ===============================================================
INSERT INTO water_supply_schemes (area_id,wss_code,wss_name,status)
VALUES
(1,'ELL','Ellampitiya','active'),
(1,'KEP','Keppetipola','active'),
(1,'ARE','Area','active'),
(1,'BAD','Badulla','active'),
(1,'BND','Bandarawela','active'),
(1,'THU','Thursday','active'),
(1,'BOG','Bogahakumbura','active'),
(1,'MAD','Madovita','active'),
(1,'SIL','Silmiyapura','active'),
(1,'DIV','Divithotawela','active'),
(1,'BOR','Bora','active'),
(1,'LAN','Landa','active'),
(1,'AMB','Ambagasdowa','active'),
(1,'MED','Medawela','active'),
(1,'LUN','Lunuwatta','active'),
(1,'WEL','Welima','active'),
(1,'DA','Da','active'),
(1,'DIY','Diya','active'),
(1,'THA','Thalawa','active'),
(1,'AMU','Amunukele','active'),
(1,'HAP','Haputhale','active'),
(1,'HAL','Haldummulla','active'),
(1,'SEL','Seelathanna','active'),
(1,'BAN','Bandarawela','active'),
(1,'LIY','Liyangahawela','active'),
(1,'JUN','June','active'),
(1,'MTW','MTWTFSS','active'),
(1,'FRI','Friday','active'),
(1,'HAL2','Hali','active'),
(1,'ELA','Ela','active'),
(1,'DEM','Demodara','active'),
(1,'BAD2','Badulla','active'),
(1,'MAH','Mahiyanganayate','active'),
(1,'GIR','Girah','active'),
(1,'RAT','Rathkinda','active'),
(1,'KAN','Kandeketiya','active');

-- ===============================================================
-- 6. SECTIONS (NOW BELONG DIRECTLY TO WSS)
-- Sample 3 WSS get sections
-- ===============================================================
INSERT INTO sections (section_name, wss_id)
VALUES
('Administration', 1),
('Finance', 1),
('IT', 1),

('Administration', 4),
('Finance', 4),
('IT', 4),

('Administration', 5),
('Finance', 5),
('IT', 5);

-- ===============================================================
-- 7. DEVICES (ADDED WSS ID + Optional SECTION)
-- ===============================================================
INSERT INTO devices (device_name, model, category_id, wss_id, section_id, assigned_to, operating_system, processor, ram, hard_drive_capacity, status)
VALUES
('Desktop PC','Dell OptiPlex 7010',1,1,1,3,'Windows 10','Intel i5','8GB','500GB','active'),
('Laptop','HP EliteBook 840',2,4,4,4,'Windows 10','Intel i7','16GB','1TB','active'),
('Printer','Canon LBP2900',3,1,1,3,NULL,NULL,NULL,NULL,'active'),
('RVPN Connection',NULL,4,4,NULL,3,NULL,NULL,NULL,NULL,'active'),
('Finger Device','ZKTeco F18',5,5,7,7,NULL,NULL,NULL,NULL,'active');

-- ===============================================================
-- 8. REPAIRS
-- ===============================================================
INSERT INTO repairs (device_id,technician_id,repair_details,cost,repair_date,status)
VALUES
(1,3,'Replaced faulty RAM',150.00,'2025-10-15','completed'),
(2,4,'Updated BIOS',0.00,'2025-10-20','completed'),
(3,3,'Changed toner cartridge',50.00,'2025-11-01','completed');

-- ===============================================================
-- 9. DEVICE ISSUES
-- ===============================================================
INSERT INTO device_issues (device_id,reported_by,issue_title,issue_description,priority,status)
VALUES
(1,3,'Slow performance','PC is running slow','medium','open'),
(2,4,'Battery issue','Laptop battery drains quickly','high','in_progress'),
(3,3,'Paper jam','Printer jams frequently','medium','resolved');
