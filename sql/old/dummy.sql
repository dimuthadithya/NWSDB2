-- ===============================================================
-- Device Record System Database with Dummy Data
-- ===============================================================

-- -----------------------------
-- 1. Create the database
-- -----------------------------
CREATE DATABASE IF NOT EXISTS devicerecordsystem;
USE devicerecordsystem;

-- ===============================================================
-- 2. Users Table
-- ===============================================================
INSERT INTO users (first_name,last_name,username,email,mobile_number,gender,password,site_office,role,status,last_login)
VALUES
('Admin','One','admin1','admin1@example.com','0771000001','Male','adminpass1','Head Office','admin','active',NOW()),
('Admin','Two','admin2','admin2@example.com','0771000002','Female','adminpass2','Head Office','admin','active',NOW()),
('User','One','user1','user1@example.com','0771000003','Male','userpass1','Branch 1','user','active',NOW()),
('User','Two','user2','user2@example.com','0771000004','Female','userpass2','Branch 1','user','active',NOW()),
('User','Three','user3','user3@example.com','0771000005','Male','userpass3','Branch 2','user','active',NOW()),
('User','Four','user4','user4@example.com','0771000006','Female','userpass4','Branch 2','user','active',NOW()),
('User','Five','user5','user5@example.com','0771000007','Male','userpass5','Branch 3','user','active',NOW()),
('User','Six','user6','user6@example.com','0771000008','Female','userpass6','Branch 3','user','active',NOW()),
('User','Seven','user7','user7@example.com','0771000009','Male','userpass7','Branch 4','user','active',NOW()),
('User','Eight','user8','user8@example.com','0771000010','Female','userpass8','Branch 4','user','active',NOW()),
('User','Nine','user9','user9@example.com','0771000011','Male','userpass9','Branch 5','user','active',NOW()),
('User','Ten','user10','user10@example.com','0771000012','Female','userpass10','Branch 5','user','active',NOW()),
('User','Eleven','user11','user11@example.com','0771000013','Male','userpass11','Branch 1','user','active',NOW()),
('User','Twelve','user12','user12@example.com','0771000014','Female','userpass12','Branch 1','user','active',NOW()),
('User','Thirteen','user13','user13@example.com','0771000015','Male','userpass13','Branch 2','user','active',NOW()),
('User','Fourteen','user14','user14@example.com','0771000016','Female','userpass14','Branch 2','user','active',NOW()),
('User','Fifteen','user15','user15@example.com','0771000017','Male','userpass15','Branch 3','user','active',NOW()),
('User','Sixteen','user16','user16@example.com','0771000018','Female','userpass16','Branch 3','user','active',NOW()),
('User','Seventeen','user17','user17@example.com','0771000019','Male','userpass17','Branch 4','user','active',NOW()),
('User','Eighteen','user18','user18@example.com','0771000020','Female','userpass18','Branch 4','user','active',NOW()),
('User','Nineteen','user19','user19@example.com','0771000021','Male','userpass19','Branch 5','user','active',NOW()),
('User','Twenty','user20','user20@example.com','0771000022','Female','userpass20','Branch 5','user','active',NOW());

-- ===============================================================
-- 3. Device Categories Table
-- ===============================================================
INSERT INTO device_categories (category_name,description)
VALUES
('Desktop Computer','Desktop computers for office use'),
('Laptop','Portable laptops'),
('Printer','Printers and multifunction devices'),
('RVPN Connection','Remote VPN connections for users'),
('Finger Device','Biometric finger devices');

-- ===============================================================
-- 4. Branches Table
-- ===============================================================
INSERT INTO branches (branch_name,location)
VALUES
('Head Office','Colombo'),
('Branch 1','Badulla'),
('Branch 2','Bandarawela');

-- ===============================================================
-- 5. Sections Table
-- ===============================================================
INSERT INTO sections (section_name,branch_id)
VALUES
('IT',1),
('HR',1),
('Finance',1),
('IT',2),
('HR',2),
('Finance',2),
('IT',3),
('HR',3);

-- ===============================================================
-- 6. Devices Table
-- ===============================================================
INSERT INTO devices (device_name,model,category_id,section_id,assigned_to,operating_system,processor,ram,hard_drive_capacity,status)
VALUES
('Desktop PC','Dell OptiPlex 7010',1,1,3,'Windows 10','Intel i5','8GB','500GB','active'),
('Laptop','HP EliteBook 840',2,4,4,'Windows 10','Intel i7','16GB','1TB','active'),
('Printer','Canon LBP2900',3,1,5,NULL,NULL,NULL,NULL,'active'),
('RVPN Connection',NULL,4,NULL,6,NULL,NULL,NULL,NULL,'active'),
('Finger Device','ZKTeco F18',5,7,7,NULL,NULL,NULL,NULL,'active');

-- ===============================================================
-- 7. Repairs Table
-- ===============================================================
INSERT INTO repairs (device_id,technician_id,repair_details,cost,repair_date,status)
VALUES
(1,3,'Replaced faulty RAM',150.00,'2025-10-15','completed'),
(2,4,'Updated BIOS',0.00,'2025-10-20','completed'),
(3,5,'Changed toner cartridge',50.00,'2025-11-01','completed');

-- ===============================================================
-- 8. Device Issues Table
-- ===============================================================
INSERT INTO device_issues (device_id,reported_by,issue_title,issue_description,priority,status)
VALUES
(1,3,'Slow performance','PC is running slow','medium','open'),
(2,4,'Battery issue','Laptop battery drains quickly','high','in_progress'),
(3,5,'Paper jam','Printer jams frequently','medium','resolved');

-- ===============================================================
-- 9. Regions Table
-- ===============================================================
INSERT INTO regions (region_code,region_name,status)
VALUES
('BRD','Bandarawela','active');

-- ===============================================================
-- 10. Areas Table
-- ===============================================================
INSERT INTO areas (region_id,area_code,area_name,status)
VALUES
(1,'BAD','Badulla','active'),
(1,'BND','Bandarawela','active');

-- ===============================================================
-- 11. Water Supply Schemes Table
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
