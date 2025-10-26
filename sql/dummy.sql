USE devicerecordsystem;

-- ===============================================================
-- 1. Users
-- ===============================================================
INSERT INTO users (first_name, last_name, username, email, mobile_number, gender, password, site_office, role)
VALUES
('Admin', 'User', 'admin', 'admin@gmail.com', '0000000000', 'Male', SHA2('admin123', 256), 'Head Office', 'admin'),
('John', 'Doe', 'johndoe', 'john.doe@gmail.com', '0771111111', 'Male', SHA2('user123', 256), 'Head Office', 'user'),
('Jane', 'Smith', 'janesmith', 'jane.smith@gmail.com', '0772222222', 'Female', SHA2('user123', 256), 'Branch Office', 'user'),
('Michael', 'Fernando', 'mikef', 'mike.fernando@gmail.com', '0773333333', 'Male', SHA2('user123', 256), 'Site Office', 'user'),
('Nethmi', 'Silva', 'nethmi', 'nethmi.silva@gmail.com', '0774444444', 'Female', SHA2('user123', 256), 'Head Office', 'user');

-- ===============================================================
-- 2. Branches
-- ===============================================================
INSERT INTO branches (branch_name, location)
VALUES
('Head Office', 'Colombo'),
('Branch Office - Kandy', 'Kandy'),
('Branch Office - Galle', 'Galle');

-- ===============================================================
-- 3. Sections
-- ===============================================================
INSERT INTO sections (section_name, branch_id)
VALUES
('IT Department', 1),
('HR Department', 1),
('Finance Department', 2),
('Operations', 3);

-- ===============================================================
-- 4. Device Categories
-- ===============================================================
INSERT INTO device_categories (category_name, description)
VALUES
('Computer', 'Desktop or Laptop computers'),
('Printer', 'All types of printers'),
('Scanner', 'Document scanners'),
('Network Device', 'Routers, Switches, Access Points');

-- ===============================================================
-- 5. Devices
-- ===============================================================
INSERT INTO devices (
  device_name, model, made_in, category_id, section_id, assigned_to,
  operating_system, processor, ram, hard_drive_capacity, keyboard, mouse,
  network_connectivity, printer_connectivity, virus_guard, ip_address,
  monitor_info, cpu_serial, purchase_date, status, notes
)
VALUES
('Dell OptiPlex 7080', 'OptiPlex 7080', 'China', 1, 1, 2, 'Windows 10 Pro', 'Intel i5', '8GB', '512GB SSD',
 'Dell Keyboard', 'Dell Mouse', 'Ethernet', 'None', 'Kaspersky', '192.168.1.10',
 'Dell 22” Monitor', 'CPU-1001', '2023-04-15', 'active', 'Used by John Doe'),

('HP LaserJet Pro M404dn', 'M404dn', 'Vietnam', 2, 2, 3, NULL, NULL, NULL, NULL,
 NULL, NULL, 'Wi-Fi + Ethernet', 'USB', NULL, '192.168.1.25',
 NULL, 'PRN-2024', '2022-12-01', 'active', 'HR Department printer'),

('Lenovo ThinkPad E14', 'E14 Gen 2', 'China', 1, 3, 4, 'Windows 11', 'Intel i7', '16GB', '1TB SSD',
 'Logitech Keyboard', 'Logitech Mouse', 'Wi-Fi', NULL, 'Windows Defender', '192.168.1.45',
 '14” FHD Display', 'CPU-2030', '2024-03-20', 'under_repair', 'Battery issue'),

('Canon CanoScan LiDE 400', 'LiDE 400', 'Japan', 3, NULL, NULL, NULL, NULL, NULL, NULL,
 NULL, NULL, 'USB', NULL, NULL, NULL,
 NULL, 'SCN-1002', '2021-07-10', 'active', 'Scanner shared among staff'),

('TP-Link Archer AX55', 'AX55', 'Malaysia', 4, 4, 5, NULL, 'Qualcomm', NULL, NULL,
 NULL, NULL, 'Wi-Fi', NULL, NULL, '192.168.2.1',
 NULL, 'NET-3321', '2024-01-05', 'active', 'Network router for Operations section');

-- ===============================================================
-- 6. Repairs
-- ===============================================================
INSERT INTO repairs (device_id, technician_id, repair_details, cost, repair_date, status)
VALUES
(3, 2, 'Replaced laptop battery and updated BIOS', 15000.00, '2024-04-05', 'completed'),
(2, 4, 'Replaced toner and cleaned printer head', 5000.00, '2024-06-12', 'completed'),
(5, 2, 'Firmware update and security patch', 0.00, '2024-08-01', 'pending');

-- ===============================================================
-- 7. Device Issues
-- ===============================================================
INSERT INTO device_issues (device_id, reported_by, issue_title, issue_description, priority, status, resolved_at)
VALUES
(3, 4, 'Laptop not charging', 'The Lenovo laptop battery isn’t charging properly.', 'high', 'resolved', '2024-04-06'),
(2, 3, 'Printer paper jam', 'Frequent paper jams when printing multiple pages.', 'medium', 'in_progress', NULL),
(5, 5, 'Router disconnecting', 'Network drops frequently when multiple users connect.', 'high', 'open', NULL);
