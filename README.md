# NWSDB Device Record System

## Project Information

- **Project Name:** NWSDB Hardware Device Management System
- **Duration:** 12 Weeks (September 2, 2025 - November 22, 2025)
- **Technology Stack:** HTML, CSS, JavaScript, TailwindCSS, PHP (vanilla), MySQL
- **Developer:** Development Team

---

## Getting Started

Follow these instructions to set up the project on your local machine.

### Prerequisites

- **PHP**: Version 7.4 or higher.
- **MySQL/MariaDB**: For the database.
- **Web Server**: Apache or Nginx (e.g., via XAMPP, WAMP, or Laragon).

### Installation

1.  **Clone the Repository**

    ```bash
    git clone <repository-url>
    cd NWSDB2
    ```

2.  **Database Setup**

    - Open your MySQL client (e.g., phpMyAdmin, HeidiSQL).
    - Create a new database named `devicerecordsystem`.
    - Import the schema file: `sql/updated.sql`.
    - (Optional) Import dummy data: `sql/updatedDummy.sql`.

3.  **Configuration**

    - Open `config/db.php`.
    - Verify the database credentials match your local setup:
      ```php
      define('DB_HOST', 'localhost');
      define('DB_USERNAME', 'root');
      define('DB_PASSWORD', ''); // Your database password
      define('DB_NAME', 'devicerecordsystem');
      ```

4.  **Running the Application**
    - If using **Laragon/XAMPP**: Move the project folder to the `www` or `htdocs` directory. Access it via `http://localhost/NWSDB2`.
    - Or use the PHP built-in server:
      ```bash
      php -S localhost:8000
      ```
      Then access `http://localhost:8000` in your browser.

### Usage

1.  **Registration**: Go to `/pages/register.php` to create a new account.
2.  **Login**: Use your credentials at `/pages/login.php`.
3.  **Admin Access**: By default, new users have the 'user' role. To make a user an admin, manually update the `role` column in the `users` table to 'admin'.

---

## Development Diary

## Week 01 (September 2 - 6, 2025)

### Monday, September 2, 2025

- Met with NWSDB management to discuss project requirements and objectives for the hardware device tracking system.
- Gathered initial documentation about current device inventory management processes and pain points.
- Created preliminary list of required features including device registration, tracking, repair management, and reporting.

### Tuesday, September 3, 2025

- Analyzed existing manual record-keeping system and identified automation opportunities.
- Documented database entities needed: users, devices, repairs, sections, branches, and device categories.
- Sketched initial wireframes for login page, dashboard, and main device listing pages on paper.

### Wednesday, September 4, 2025

- Created detailed feature specification document outlining core modules: authentication, device management, repair tracking, and admin controls.
- Defined user roles (admin and regular user) with different permission levels for system access.
- Planned database schema with relationships between users, devices, sections, and water supply schemes.

### Thursday, September 5, 2025

- Designed low-fidelity wireframes for all major pages including computers, printers, repairs, and summary views.
- Prepared visual style guide selecting color scheme (blue/cyan theme) matching NWSDB branding.
- Outlined navigation structure with sidebar menu and hierarchical organization of features.

### Friday, September 6, 2025

- Reviewed wireframes with project supervisor and incorporated feedback on layout improvements.
- Finalized UI component library decisions: TailwindCSS for styling, custom JavaScript for interactions.
- Set up development environment with Laragon (Apache, PHP, MySQL) on local machine.

### **Progress Summary**

This week focused on project initiation and planning. Successfully gathered requirements from NWSDB stakeholders and documented the scope of the hardware device management system. Created wireframes and technical architecture plans for the application. Established the technology stack (HTML, CSS, JavaScript, TailwindCSS, PHP, MySQL) and set up the local development environment. Defined user roles and core features including device tracking, repair management, and reporting capabilities.

### **Errors Encountered and Fixes**

#### Error 1 — Laragon MySQL Service Not Starting

**Issue:**  
During development environment setup, MySQL service failed to start in Laragon, preventing database connection testing.

**Previous Code (Incorrect):**

```
MySQL service running on default port 3306
Another MySQL instance already using the port
```

**Fix:**

```
Stopped conflicting MySQL service from system services
Changed Laragon MySQL port to 3307 in configuration
Restarted Laragon and verified MySQL service running properly
```

**Reason:**  
System had another MySQL installation running on default port 3306, causing port conflict. Laragon couldn't bind to the occupied port.

**Notes:**  
After resolving port conflict, tested database connection successfully and created initial empty database for future use.

### **Next Week Plan**

- Begin creating static HTML pages for login and registration forms.
- Design dashboard layout with TailwindCSS styling.
- Create basic navigation structure and header components.

---

## Week 02 (September 9 - 13, 2025)

### Monday, September 9, 2025

- Created project folder structure with organized directories for pages, assets, config, and includes.
- Built basic HTML skeleton for login page with proper semantic markup and form elements.
- Added NWSDB logo and branding elements to maintain visual consistency with organization identity.

### Tuesday, September 10, 2025

- Styled login page using TailwindCSS utility classes for responsive design and modern appearance.
- Implemented registration page HTML structure with input fields for user information (name, email, password, gender).
- Created reusable CSS classes for buttons, form inputs, and container elements.

### Wednesday, September 11, 2025

- Developed landing page (index.php) showcasing system features with animated gradient background.
- Added responsive navigation header with links to login and registration pages.
- Implemented hover effects and transitions on buttons using Tailwind utility classes.

### Thursday, September 12, 2025

- Created dashboard page layout with sidebar navigation and main content area structure.
- Designed stat cards displaying device counts and status summaries using Tailwind grid system.
- Built sidebar menu component with icons and navigation links for all major sections.

### Friday, September 13, 2025

- Developed static pages for computers, printers, and other devices with table layouts.
- Added filter sections and search bars to device management pages using Tailwind form components.
- Created modal structures (hidden by default) for adding new devices using Tailwind classes.

### **Progress Summary**

Completed all major static HTML pages with TailwindCSS styling. Built responsive layouts for login, registration, dashboard, and device management pages. Implemented consistent navigation structure with sidebar menu and header components. Created reusable UI components including stat cards, tables, modals, and form elements. Established visual design system with proper spacing, colors, and typography using Tailwind utility classes. All pages are mobile-responsive and follow modern web design principles.

### **Errors Encountered and Fixes**

#### Error 1 — TailwindCSS Not Loading Styles

**Issue:**  
TailwindCSS classes applied to HTML elements were not rendering any styles in the browser, showing unstyled content.

**Previous Code (Incorrect):**

```html
<link href="tailwind.css" rel="stylesheet" />
<!-- Local file reference that doesn't exist -->
```

**Fix:**

```html
<link href="https://cdn.tailwindcss.com" rel="stylesheet" />
<!-- Using CDN instead of local build -->
```

**Reason:**  
Referenced a local Tailwind CSS file that wasn't compiled. TailwindCSS requires build process or CDN for styles to work.

**Notes:**  
Using CDN is suitable for development. For production, would need to set up Tailwind build process with PostCSS.

#### Error 2 — Modal Not Displaying Correctly

**Issue:**  
Modal dialog boxes created for "Add Device" functionality were not appearing centered on screen and had no backdrop overlay.

**Previous Code (Incorrect):**

```html
<div class="modal fixed top-0 left-0">
  <!-- Missing positioning and display classes -->
</div>
```

**Fix:**

```html
<div
  class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden"
>
  <div class="bg-white rounded-lg p-6">
    <!-- Modal content -->
  </div>
</div>
```

**Reason:**  
Missing Tailwind classes for proper modal positioning (`inset-0`), flexbox centering (`flex items-center justify-center`), and backdrop overlay.

**Notes:**  
Added JavaScript later to toggle `hidden` class for showing/hiding modals on button clicks.

### **Next Week Plan**

- Add JavaScript functionality for modal open/close interactions.
- Implement client-side form validation for registration and login forms.
- Create dynamic table sorting and filtering features with vanilla JavaScript.

---

## Week 03 (September 16 - 20, 2025)

### Monday, September 16, 2025

- Wrote JavaScript functions to show and hide modal dialogs when clicking "Add Device" and "Cancel" buttons.
- Implemented event listeners on all modal trigger buttons across device management pages.
- Created reusable modal handler functions to avoid code duplication across multiple pages.

### Tuesday, September 17, 2025

- Added client-side form validation for registration page checking empty fields and email format.
- Implemented password confirmation matching validation before form submission.
- Created visual feedback for validation errors displaying red borders and error messages under input fields.

### Wednesday, September 18, 2025

- Developed search functionality for device tables filtering rows based on search input in real-time.
- Implemented table row highlighting on hover for better user experience using JavaScript event listeners.
- Added click handlers for delete buttons showing confirmation dialogs before removal actions.

### Thursday, September 19, 2025

- Created dynamic dropdown population for filter selects (location, status, category) using JavaScript arrays.
- Implemented combined filtering logic allowing multiple filters to work together (e.g., location AND status).
- Added "Clear Filters" button functionality resetting all filter dropdowns to default state.

### Friday, September 20, 2025

- Built toggle functionality for sidebar collapse/expand on mobile devices using hamburger menu icon.
- Implemented smooth scroll behavior for navigation links within single-page sections.
- Added keyboard navigation support (Enter key) for form submissions and modal interactions.

### **Progress Summary**

Successfully implemented core JavaScript functionality across all pages. Added interactive modal dialogs for adding devices and other data entry forms. Implemented comprehensive client-side form validation with visual feedback for user inputs. Created dynamic search and filtering capabilities for device tables without page reloads. Enhanced user experience with hover effects, keyboard navigation, and mobile-responsive sidebar menu. All interactions work smoothly without requiring any backend integration yet.

### **Errors Encountered and Fixes**

#### Error 1 — JavaScript Function Not Defined Error

**Issue:**  
Clicking "Add Device" button threw console error: "Uncaught ReferenceError: openModal is not defined" and modal didn't appear.

**Previous Code (Incorrect):**

```html
<button onclick="openModal('addDeviceModal')">Add Device</button>
<!-- Function called before script loaded -->

<script src="scripts.js"></script>
```

**Fix:**

```html
<script src="scripts.js"></script>
<!-- Moved script to head or before button -->

<button onclick="openModal('addDeviceModal')">Add Device</button>
```

**Reason:**  
JavaScript file was loaded after the button element, so function wasn't available when HTML parsed the onclick attribute.

**Notes:**  
Alternatively, could use `addEventListener` in JavaScript file instead of inline onclick handlers to avoid execution order issues.

#### Error 2 — Email Validation Regex Not Working

**Issue:**  
Email validation was accepting invalid email formats like "test@" or "user@domain" without proper domain extension.

**Previous Code (Incorrect):**

```javascript
const emailRegex = /^[a-zA-Z0-9]+@[a-zA-Z]+$/;
// Too simple, missing dot and extension
```

**Fix:**

```javascript
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
// Requires @ symbol and at least one dot after @
```

**Reason:**  
Original regex pattern was too simplistic and didn't account for domain extensions (.com, .lk, etc.).

**Notes:**  
This basic regex handles most common email formats. More comprehensive validation would be done server-side.

### **Next Week Plan**

- Set up MySQL database and create tables for users, devices, and related entities.
- Write PHP database connection configuration file.
- Create Database helper class for executing queries and managing connections.

---

## Week 04 (September 23 - 27, 2025)

### Monday, September 23, 2025

- Designed complete database schema with tables for users, devices, categories, sections, repairs, and issues.
- Created Entity-Relationship diagram documenting relationships between all database tables.
- Defined appropriate data types, constraints, and indexes for optimal query performance.

### Tuesday, September 24, 2025

- Wrote SQL script (`devicerecordsystem.sql`) creating database structure with proper foreign key relationships.
- Created users table with fields for authentication (email, password hash) and profile data (name, role, gender).
- Implemented devices table with category, section, status, and detailed specification fields (serial numbers, models).

### Wednesday, September 25, 2025

- Created supporting tables for device_categories, sections, branches, regions, areas, and water_supply_schemes.
- Wrote SQL for repairs table tracking device repair history with dates, descriptions, and costs.
- Implemented device_issues table for logging problems with priority levels (low, medium, high).

### Thursday, September 26, 2025

- Populated database with dummy data for testing: 10 users, 5 device categories, multiple sections and branches.
- Created sample device records (computers, printers, RVPN connections) with realistic specifications.
- Added test repair records and device issues with various statuses and priority levels.

### Friday, September 27, 2025

- Wrote `db.php` configuration file defining database connection constants (host, username, password, database name).
- Created `Database.php` class implementing singleton pattern for database connection management.
- Implemented PDO-based connection with error handling and UTF-8 character set configuration.

### **Progress Summary**

Successfully designed and implemented complete MySQL database schema for the device management system. Created all necessary tables with proper relationships, constraints, and indexes. Wrote comprehensive SQL scripts for database creation and populated tables with realistic dummy data for testing. Developed PHP database configuration and connection management using PDO with singleton pattern. Established solid foundation for database-driven functionality in upcoming weeks.

### **Errors Encountered and Fixes**

#### Error 1 — Foreign Key Constraint Violation

**Issue:**  
When inserting device records, MySQL error occurred: "Cannot add or update a child row: a foreign key constraint fails".

**Previous Code (Incorrect):**

```sql
INSERT INTO devices (name, category_id, section_id)
VALUES ('Computer-001', 999, 1);
-- Category ID 999 doesn't exist in device_categories table
```

**Fix:**

```sql
-- First ensure category exists
INSERT INTO device_categories (name, icon) VALUES ('Desktop Computer', 'computer');

-- Then insert device with valid category_id
INSERT INTO devices (name, category_id, section_id)
VALUES ('Computer-001', 1, 1);
```

**Reason:**  
Foreign key constraint ensures referential integrity. Can't insert device with category_id that doesn't exist in device_categories table.

**Notes:**  
Must insert parent table records (categories, sections) before inserting child table records (devices) that reference them.

#### Error 2 — Database Connection Not Working

**Issue:**  
PHP pages threw error: "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'" when trying to connect to database.

**Previous Code (Incorrect):**

```php
define('DB_PASSWORD', 'password123');
// Incorrect password for MySQL root user
```

**Fix:**

```php
define('DB_PASSWORD', '');
// Empty password for Laragon's default MySQL root user
```

**Reason:**  
Laragon's MySQL installation has no password for root user by default. Provided password caused authentication failure.

**Notes:**  
For production environment, should use strong password and non-root database user with limited privileges.

### **Next Week Plan**

- Create DbHelper class with methods for common database operations (CRUD).
- Implement user registration functionality connecting PHP forms to MySQL database.
- Build authentication system for login with password verification.

---

## Week 05 (September 30 - October 4, 2025)

### Monday, September 30, 2025

- Created `DbHelper.php` class with static methods for database operations to avoid code repetition.
- Implemented `createUser()` method accepting user details and inserting records into users table with hashed passwords.
- Wrote `getUserByEmail()` method for retrieving user records during authentication process.

### Tuesday, October 1, 2025

- Built authentication handler (`auth.php`) processing registration form submissions and validating input data.
- Implemented password hashing using PHP's `password_hash()` function with default bcrypt algorithm.
- Created session management starting user sessions after successful registration and redirecting to dashboard.

### Wednesday, October 2, 2025

- Developed login functionality verifying email and password against database records using `password_verify()`.
- Implemented session variable storage for logged-in user data (user_id, name, role) for authorization checks.
- Created logout handler destroying sessions and redirecting users to login page.

### Thursday, October 3, 2025

- Built authentication middleware checking session variables before allowing access to protected pages.
- Implemented `requireLogin()` function redirecting unauthenticated users to login page automatically.
- Added guest-only middleware preventing logged-in users from accessing login/register pages (redirecting to dashboard).

### Friday, October 4, 2025

- Updated registration page connecting form submission to `auth.php` handler with POST method.
- Modified login page form action pointing to authentication handler for credential verification.
- Tested complete authentication flow: registration → auto-login → dashboard → logout → login cycle.

### **Progress Summary**

Successfully implemented complete user authentication system with registration, login, and logout functionality. Created secure password hashing and verification using PHP's built-in functions. Built session management system storing user data for authorization across pages. Developed authentication middleware protecting pages from unauthorized access. Connected HTML forms to PHP handlers for processing user input and database operations. System now supports user account creation and secure login with proper session handling.

### **Errors Encountered and Fixes**

#### Error 1 — Undefined Index Session Error

**Issue:**  
Dashboard page threw PHP warning: "Undefined index: user" when trying to access session data after login.

**Previous Code (Incorrect):**

```php
$userName = $_SESSION['user']['name'];
// Accessing session before checking if it exists
```

**Fix:**

```php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$userName = $_SESSION['user']['name'];
```

**Reason:**  
Code attempted to access `$_SESSION['user']` array without first checking if session exists or user is logged in.

**Notes:**  
Always validate session existence before accessing session data. Added authentication middleware to handle this consistently.

#### Error 2 — Password Verify Always Failing

**Issue:**  
Login always failed even with correct credentials. `password_verify()` consistently returned false for valid passwords.

**Previous Code (Incorrect):**

```php
$hashedPassword = md5($password);
// Storing MD5 hash

// Later, during login:
if (password_verify($inputPassword, $storedHash)) {
    // Never executes
}
```

**Fix:**

```php
// Registration
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Login
if (password_verify($inputPassword, $storedHash)) {
    // Now works correctly
}
```

**Reason:**  
`password_verify()` works with bcrypt hashes created by `password_hash()`, not MD5 hashes. Hash format mismatch caused verification failure.

**Notes:**  
MD5 is outdated and insecure. Modern PHP applications should use `password_hash()` and `password_verify()` functions.

### **Next Week Plan**

- Create methods in DbHelper for fetching device categories, sections, and branches.
- Implement dynamic dashboard displaying actual database statistics and counts.
- Build functionality to retrieve and display device lists from database on device pages.

---

## Week 06 (October 7 - 11, 2025)

### Monday, October 7, 2025

- Created `getRowCount()` method in DbHelper returning total record counts for any table.
- Implemented `getRowCountWithCondition()` method accepting WHERE clause parameters for filtered counting.
- Added `getCategoryId()` method retrieving category IDs by name for dynamic device counting.

### Tuesday, October 8, 2025

- Updated dashboard PHP code fetching real device counts from database instead of hardcoded numbers.
- Implemented calculation logic for total devices, active devices, computers, laptops, and printers using DbHelper methods.
- Added user statistics display showing total users, admin users, and active users dynamically.

### Wednesday, October 9, 2025

- Created `getAllComputers()` method in DbHelper retrieving computer records with JOIN to fetch section and category names.
- Modified computers page replacing static table rows with PHP foreach loop displaying database records.
- Implemented empty state handling showing "No devices found" message when database has no computer records.

### Thursday, October 10, 2025

- Built `getAllPrinters()` and `getAllLaptops()` methods fetching respective device types with related data.
- Updated printers and laptops pages with dynamic data display using PHP loops through database records.
- Added status badges with color coding (green for active, yellow for under repair, red for inactive).

### Friday, October 11, 2025

- Implemented `getAllBranches()` and `getAllSections()` methods for admin management pages.
- Created `getAllUsers()` method retrieving user list with role and status information for user management page.
- Updated admin pages (users, sections, site offices) displaying data from database with proper formatting.

### **Progress Summary**

Successfully transitioned from static hardcoded content to dynamic database-driven pages. Implemented comprehensive DbHelper methods for retrieving various data types with proper SQL JOIN operations. Updated dashboard to display real-time statistics calculated from actual database records. Modified all device management pages to fetch and display records from database using PHP loops. Added proper empty state handling and status indicators for better user experience. System now fully displays live data from MySQL database.

### **Errors Encountered and Fixes**

#### Error 1 — Undefined Variable in Foreach Loop

**Issue:**  
Device pages threw warning: "Invalid argument supplied for foreach()" when database query returned no results.

**Previous Code (Incorrect):**

```php
$devices = DbHelper::getAllComputers();

foreach ($devices as $device) {
    // Error when $devices is null
    echo $device['name'];
}
```

**Fix:**

```php
$devices = DbHelper::getAllComputers();

if ($devices && count($devices) > 0) {
    foreach ($devices as $device) {
        echo $device['name'];
    }
} else {
    echo "No devices found";
}
```

**Reason:**  
When database query returns no results, method returns null or empty array. Foreach on null value causes PHP warning.

**Notes:**  
Always check if array exists and has elements before using foreach loop. Prevents errors and allows proper empty state display.

#### Error 2 — SQL JOIN Returning Wrong Column Names

**Issue:**  
Accessing `$device['category_name']` threw "Undefined index" error even though JOIN included categories table.

**Previous Code (Incorrect):**

```php
$sql = "SELECT d.*, c.name
        FROM devices d
        JOIN device_categories c ON d.category_id = c.id";
// Ambiguous column name 'name'
```

**Fix:**

```php
$sql = "SELECT d.*, c.name as category_name, s.name as section_name
        FROM devices d
        JOIN device_categories c ON d.category_id = c.id
        JOIN sections s ON d.section_id = s.id";
```

**Reason:**  
Without alias, both `devices.name` and `categories.name` create column called 'name' in result. Later column overwrites earlier one.

**Notes:**  
Use column aliases (AS) in SQL JOINs to avoid naming conflicts and make result arrays more readable.

### **Next Week Plan**

- Implement device addition functionality processing form submissions and inserting into database.
- Create handlers for adding sections, categories, and branches from admin pages.
- Build delete functionality for removing records with proper confirmation.

---

## Week 07 (October 14 - 18, 2025)

### Monday, October 14, 2025

- Created `createDevice()` method in DbHelper accepting device specifications and inserting into devices table.
- Built form submission handler for adding computers processing POST data and validation before database insertion.
- Implemented redirect logic showing success message after successful device creation.

### Tuesday, October 15, 2025

- Developed `addHandler.php` in admin folder processing form submissions for branches, sections, and categories.
- Implemented validation checking for empty required fields before database operations.
- Added success and error message passing through URL parameters for user feedback display.

### Wednesday, October 16, 2025

- Created printer and laptop addition functionality reusing device creation logic with appropriate category IDs.
- Built unified device handler capable of processing different device types based on category parameter.
- Implemented form data sanitization removing extra whitespace and preventing empty string submissions.

### Thursday, October 17, 2025

- Developed `deleteDevice()` method in DbHelper accepting device ID and removing record from database.
- Created `deleteHandler.php` processing delete requests and redirecting back to appropriate pages.
- Added delete button functionality with confirmation dialog before executing deletion.

### Friday, October 18, 2025

- Implemented delete functionality for branches, sections, and device categories in admin handlers.
- Added validation preventing deletion of records that have dependent data (e.g., category with existing devices).
- Created error handling displaying appropriate messages when deletion fails due to foreign key constraints.

### **Progress Summary**

Successfully implemented complete CRUD (Create, Read, Update, Delete) operations for devices and admin entities. Created form handlers processing user input, validating data, and executing database insertions. Built delete functionality with proper confirmation dialogs and error handling. Implemented URL parameter-based messaging system for displaying success and error notifications. Added validation preventing orphaned records and maintaining data integrity. System now supports full device lifecycle management from creation to deletion.

### **Errors Encountered and Fixes**

#### Error 1 — Form Data Not Being Received

**Issue:**  
Handler file received empty `$_POST` array even though form was submitted with filled fields.

**Previous Code (Incorrect):**

```html
<form method="get" action="addHandler.php">
  <input type="text" name="device_name" />
  <button type="submit">Add</button>
</form>
```

**Fix:**

```html
<form method="POST" action="addHandler.php">
  <input type="text" name="device_name" />
  <button type="submit">Add</button>
</form>
```

**Reason:**  
Form method was set to "get" instead of "POST". GET sends data in URL parameters, not in `$_POST` array.

**Notes:**  
For data modification operations (create, update, delete), always use POST method. GET is for retrieving data only.

#### Error 2 — Header Already Sent Error

**Issue:**  
After form submission, got error: "Warning: Cannot modify header information - headers already sent" on redirect.

**Previous Code (Incorrect):**

```php
<?php
echo "Processing...";

// Some database operations

header('Location: devices.php');
```

**Fix:**

```php
<?php
// No output before header

// Database operations

header('Location: devices.php');
exit;
```

**Reason:**  
`header()` function must be called before any output (echo, HTML, even whitespace). Output sends headers, preventing further header modifications.

**Notes:**  
Always call `header()` before any echo/print statements. Add `exit` after redirect to stop script execution.

### **Next Week Plan**

- Implement update/edit functionality for devices allowing modification of existing records.
- Create edit modals with pre-populated data from database.
- Build handlers for processing update operations and validation.

---

## Week 08 (October 21 - 25, 2025)

### Monday, October 21, 2025

- Converted index.html to index.php for dynamic content handling and session integration.
- Refactored login and registration pages improving layout consistency and adding back-to-home navigation buttons.
- Updated all internal links changing .html extensions to .php throughout the application.

### Tuesday, October 22, 2025

- Enhanced landing page design with animated gradient background and improved feature highlights section.
- Updated dashboard layout removing old static content and adding dynamic greeting showing user's name and role.
- Improved responsive design for mobile devices adjusting sidebar collapse behavior and card layouts.

### Wednesday, October 23, 2025

- Created separate header and sidebar include files for code reusability across pages.
- Implemented dynamic page title display in header component based on current page URL.
- Added active link highlighting in sidebar menu showing current page with different background color.

### Thursday, October 24, 2025

- Built filter functionality combining search input with dropdown filters for comprehensive device filtering.
- Implemented JavaScript search updating table visibility in real-time as user types.
- Added pagination structure preparing for large dataset handling (UI only, backend pending).

### Friday, October 25, 2025

- Created summary page with comprehensive statistics display including charts and device distribution graphs.
- Implemented recent activity feed showing latest device additions, repairs, and issues chronologically.
- Added export button placeholders for future CSV/Excel export functionality.

### **Progress Summary**

Completed major refactoring converting all static HTML to dynamic PHP pages with includes. Enhanced UI consistency by creating reusable header and sidebar components used across all pages. Improved dashboard and summary pages with better data visualization and user-specific content. Implemented advanced filtering combining multiple search criteria for device management. Added dynamic navigation with active link highlighting and page title management. Refined responsive design ensuring proper display on various screen sizes.

### **Errors Encountered and Fixes**

#### Error 1 — Include Path Not Working

**Issue:**  
Pages threw error: "Warning: include(header.php): failed to open stream: No such file or directory" when including header component.

**Previous Code (Incorrect):**

```php
include 'header.php';
// Relative path doesn't work from different directories
```

**Fix:**

```php
include __DIR__ . '/../includes/header.php';
// Absolute path using __DIR__ constant
```

**Reason:**  
Relative paths in include statements are resolved from current working directory, not file location. Breaks when files are in different folders.

**Notes:**  
Use `__DIR__` constant to build absolute paths from current file location. Ensures includes work regardless of execution context.

#### Error 2 — Active Link Not Highlighting

**Issue:**  
Sidebar menu didn't highlight current page even though navigation worked correctly. All links had same styling.

**Previous Code (Incorrect):**

```php
<a href="dashboard.php" class="menu-link">Dashboard</a>
<a href="computers.php" class="menu-link">Computers</a>
// No logic to detect current page
```

**Fix:**

```php
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<a href="dashboard.php"
   class="menu-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
    Dashboard
</a>
```

**Reason:**  
No PHP logic to compare current page URL with link URLs. Need to dynamically add 'active' class based on current page.

**Notes:**  
`basename($_SERVER['PHP_SELF'])` extracts current page filename. Compare with link to add conditional active class.

### **Next Week Plan**

- Implement RVPN connections and fingerprint device management pages.
- Create repair tracking functionality with status updates and history.
- Build device issue logging system with priority levels.

---

## Week 09 (October 28 - November 1, 2025)

### Monday, October 28, 2025

- Created RVPN connections management page with table displaying connection details (IP, location, status).
- Designed fingerprint device management page showing biometric device inventory and configurations.
- Added modal forms for adding new RVPN connections and fingerprint devices with appropriate fields.

### Tuesday, October 29, 2025

- Implemented repairs page displaying repair history with device name, repair date, description, and cost.
- Created modal for logging new repairs with dropdowns for device selection and status indicators.
- Built database methods (`getAllRepairs()`) fetching repair records with JOIN to show device details.

### Wednesday, October 30, 2025

- Developed device issues page showing reported problems with priority levels (low, medium, high) and color coding.
- Implemented issue creation functionality allowing users to log problems with devices including descriptions.
- Added issue status tracking (open, in-progress, resolved) with visual indicators and filtering options.

### Thursday, October 31, 2025

- Created handlers for RVPN and fingerprint device additions processing form submissions and database insertions.
- Implemented repair logging functionality inserting repair records with timestamps and technician information.
- Built issue handler processing issue submissions with validation and automatic status initialization.

### Friday, November 1, 2025

- Enhanced summary page adding issue priority distribution chart showing breakdown of low/medium/high issues.
- Implemented recent activities display showing latest 10 actions across devices, repairs, and issues.
- Added device uptime calculations showing how long devices have been in active status.

### **Progress Summary**

Successfully expanded system functionality adding RVPN connection tracking, fingerprint device management, repair logging, and issue tracking modules. Created comprehensive forms and handlers for all new data types with proper validation. Implemented visual priority indicators and status tracking for repairs and issues. Enhanced summary page with charts and statistics covering all system modules. Added recent activity feed consolidating actions from multiple tables. System now provides complete hardware lifecycle tracking from acquisition through repairs and issues.

### **Errors Encountered and Fixes**

#### Error 1 — Date Format Display Issue

**Issue:**  
Repair dates displayed as "2025-10-29 14:30:00" in table, looking technical instead of user-friendly format.

**Previous Code (Incorrect):**

```php
echo $repair['repair_date'];
// Displays raw MySQL datetime format
```

**Fix:**

```php
$date = new DateTime($repair['repair_date']);
echo $date->format('M d, Y');
// Displays: Oct 29, 2025
```

**Reason:**  
MySQL stores dates in YYYY-MM-DD HH:MM:SS format. Direct display looks unfriendly without formatting.

**Notes:**  
Use PHP's DateTime class to format dates appropriately. Choose format based on context (short for tables, long for details).

#### Error 2 — Priority Color Not Showing

**Issue:**  
Issue priority badges showed all issues with same gray color instead of red/yellow/green based on priority level.

**Previous Code (Incorrect):**

```php
<span class="badge bg-gray-500">
    <?= $issue['priority'] ?>
</span>
```

**Fix:**

```php
<?php
$colorClass = match($issue['priority']) {
    'high' => 'bg-red-500',
    'medium' => 'bg-yellow-500',
    'low' => 'bg-green-500',
    default => 'bg-gray-500'
};
?>
<span class="badge <?= $colorClass ?>">
    <?= $issue['priority'] ?>
</span>
```

**Reason:**  
Badge color was hardcoded to gray. Need conditional logic assigning different Tailwind color classes based on priority value.

**Notes:**  
PHP 8's match expression is cleaner than if/else for mapping values. Falls back to gray for unexpected values.

### **Next Week Plan**

- Implement update/edit functionality for all entity types (devices, repairs, issues).
- Create admin pages for regions, areas, and water supply schemes.
- Build comprehensive user management with role assignment and status control.

---

## Week 10 (November 4 - 8, 2025)

### Monday, November 4, 2025

- Created regions management page for admin displaying regional offices in hierarchical structure.
- Implemented areas management showing geographical areas within regions for water supply organization.
- Built water supply schemes page listing all schemes with associated areas and operational details.

### Tuesday, November 5, 2025

- Developed handlers for creating regions, areas, and water supply schemes with form validation.
- Implemented cascading dropdowns showing regions → areas → schemes relationships dynamically.
- Added update functionality for water supply schemes allowing name and operational status modifications.

### Wednesday, November 6, 2025

- Enhanced user management page with add user modal including fields for role assignment and water scheme association.
- Implemented user update functionality allowing admin to change roles, status (active/inactive), and assigned schemes.
- Created user deletion handler with validation preventing deletion of users with associated device records.

### Thursday, November 7, 2025

- Built device category management allowing admin to add new categories with custom icons.
- Implemented category update and delete functions maintaining referential integrity with devices table.
- Added icon picker displaying available icon options when creating or editing device categories.

### Friday, November 8, 2025

- Created comprehensive section management with CRUD operations for organizational sections.
- Implemented section-to-scheme association allowing sections to be linked with water supply schemes.
- Enhanced sections page showing device count per section with visual progress indicators.

### **Progress Summary**

Completed admin module implementation covering all hierarchical entities: regions, areas, water schemes, sections, and users. Built comprehensive CRUD operations for all administrative data types with proper validation and relationship handling. Implemented cascading dropdowns reflecting organizational hierarchy for data entry efficiency. Created user management system with role-based access control and water scheme assignments. Added device category management allowing system customization. Enhanced section management showing associated device statistics and scheme relationships.

### **Errors Encountered and Fixes**

#### Error 1 — Cascading Dropdown Not Loading Options

**Issue:**  
When selecting region in dropdown, areas dropdown remained empty instead of showing areas for selected region.

**Previous Code (Incorrect):**

```javascript
document.getElementById('region').addEventListener('change', function () {
  const regionId = this.value;
  // No AJAX call to fetch areas
  console.log(regionId);
});
```

**Fix:**

```javascript
document.getElementById('region').addEventListener('change', function () {
  const regionId = this.value;
  fetch(`getAreas.php?region_id=${regionId}`)
    .then((response) => response.json())
    .then((areas) => {
      const areasSelect = document.getElementById('area');
      areasSelect.innerHTML = '<option value="">Select Area</option>';
      areas.forEach((area) => {
        areasSelect.innerHTML += `<option value="${area.id}">${area.name}</option>`;
      });
    });
});
```

**Reason:**  
Cascading dropdowns require AJAX to fetch dependent data dynamically. Static HTML can't reflect database relationships without server interaction.

**Notes:**  
Created separate PHP endpoint returning JSON data for areas filtered by region ID. Fetch API populates dropdown dynamically.

#### Error 2 — Delete Operation Not Checking Dependencies

**Issue:**  
Deleting device category succeeded even when devices existed using that category, creating orphaned device records.

**Previous Code (Incorrect):**

```php
public static function deleteCategory($id) {
    $sql = "DELETE FROM device_categories WHERE id = ?";
    return self::$db->delete($sql, [$id]);
    // No dependency check
}
```

**Fix:**

```php
public static function deleteCategory($id) {
    // Check for dependent devices
    $deviceCount = self::getRowCountWithCondition('devices', ['category_id' => $id]);

    if ($deviceCount > 0) {
        return false; // Cannot delete
    }

    $sql = "DELETE FROM device_categories WHERE id = ?";
    return self::$db->delete($sql, [$id]);
}
```

**Reason:**  
Foreign key constraint should prevent deletion, but without ON DELETE RESTRICT, MySQL might allow it depending on configuration.

**Notes:**  
Application-level validation ensures business rule enforcement. Returns false with error message when deletion would orphan records.

### **Next Week Plan**

- Implement edit modals for all device types with pre-populated form fields.
- Create update handlers processing device modifications and validating changes.
- Add comprehensive statistics to summary page with charts and trends.

---

## Week 11 (November 11 - 15, 2025)

### Monday, November 11, 2025

- Implemented edit functionality for computers opening modal with pre-filled data from selected device record.
- Created update handler processing device modifications and validating changed fields before database update.
- Added "Edit" button to device table rows opening modal and populating fields using JavaScript.

### Tuesday, November 12, 2025

- Built edit modals for printers, RVPN connections, and fingerprint devices with appropriate field types.
- Implemented update handlers for all device types reusing existing validation logic with modification checks.
- Added confirmation messages after successful updates redirecting users back to respective list pages.

### Wednesday, November 13, 2025

- Created edit functionality for repairs allowing updates to repair description, cost, and completion status.
- Implemented issue update handler enabling status changes (open → in-progress → resolved) and priority adjustments.
- Added visual indicators showing last modified timestamp for updated records in tables.

### Thursday, November 14, 2025

- Enhanced summary page adding Chart.js integration for visual data representation with bar and pie charts.
- Implemented device distribution chart showing breakdown by category (computers, printers, others) with percentages.
- Created monthly issues trend chart displaying issue counts over last 6 months for pattern analysis.

### Friday, November 15, 2025

- Added comprehensive statistics section to summary showing system uptime, total assets value, average repair cost.
- Implemented top sections by device count visualization with progress bars and percentage calculations.
- Created repairs cost analysis showing total spent on repairs categorized by device type.

### **Progress Summary**

Completed full CRUD implementation adding update functionality for all entity types in the system. Created edit modals with pre-populated data loading and validation matching creation logic. Implemented status tracking for repairs and issues with complete lifecycle management. Enhanced summary and dashboard pages with advanced data visualization using charts and graphs. Added comprehensive statistics calculations providing insights into device inventory, repair costs, and issue patterns. System now provides complete data management with professional reporting capabilities.

### **Errors Encountered and Fixes**

#### Error 1 — Edit Modal Not Populating Data

**Issue:**  
Clicking "Edit" button opened modal but all input fields remained empty instead of showing current device data.

**Previous Code (Incorrect):**

```javascript
function openEditModal(deviceId) {
  document.getElementById('editModal').classList.remove('hidden');
  // No data fetching logic
}
```

**Fix:**

```javascript
function openEditModal(deviceId) {
  fetch(`getDevice.php?id=${deviceId}`)
    .then((response) => response.json())
    .then((device) => {
      document.getElementById('edit_device_name').value = device.name;
      document.getElementById('edit_serial').value = device.serial_number;
      document.getElementById('edit_status').value = device.status;
      document.getElementById('editModal').classList.remove('hidden');
    });
}
```

**Reason:**  
Modal opened without fetching device data from database. Need AJAX call retrieving record data and populating form fields.

**Notes:**  
Created endpoint returning single device as JSON. JavaScript fills form inputs before displaying modal.

#### Error 2 — Chart Not Rendering on Page

**Issue:**  
Summary page loaded but chart area showed empty canvas element instead of expected bar chart visualization.

**Previous Code (Incorrect):**

```html
<canvas id="deviceChart"></canvas>
<script>
  const ctx = document.getElementById('deviceChart').getContext('2d');
  new Chart(ctx, {...});
</script>
<!-- Script runs before Chart.js library loads -->
```

**Fix:**

```html
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="deviceChart"></canvas>
<script>
  window.addEventListener('load', function() {
      const ctx = document.getElementById('deviceChart').getContext('2d');
      new Chart(ctx, {...});
  });
</script>
```

**Reason:**  
Chart initialization code executed before Chart.js library finished loading. Chart constructor not available yet.

**Notes:**  
Load Chart.js from CDN before chart creation code. Use window load event ensuring DOM and libraries ready.

### **Next Week Plan**

- Perform comprehensive testing across all modules identifying bugs and edge cases.
- Fix any remaining issues and polish user interface elements.
- Create documentation and prepare deployment package.

---

## Week 12 (November 18 - 22, 2025)

### Monday, November 18, 2025

- Conducted thorough testing of all CRUD operations across devices, repairs, issues, and admin modules.
- Fixed minor validation bugs in region and area handlers preventing duplicate entries.
- Tested cascading delete operations ensuring proper handling of foreign key relationships.

### Tuesday, November 19, 2025

- Performed cross-browser testing on Chrome, Firefox, and Edge ensuring consistent appearance and functionality.
- Fixed responsive design issues on mobile devices adjusting sidebar behavior and table scrolling.
- Tested form validations confirming proper error messages and field highlighting on invalid input.

### Wednesday, November 20, 2025

- Optimized database queries adding indexes on frequently searched columns (status, category_id, section_id).
- Improved page load performance by reducing unnecessary JOIN operations in list queries.
- Added SQL query result caching for static data like categories and sections reducing database load.

### Thursday, November 21, 2025

- Created comprehensive documentation including setup instructions, database schema diagrams, and user manual.
- Wrote README files explaining project structure, installation steps, and configuration requirements.
- Documented all database tables with field descriptions and relationship explanations.

### Friday, November 22, 2025

- Finalized deployment package with SQL scripts, code files, and configuration templates.
- Tested fresh installation process following documentation to verify accuracy and completeness.
- Prepared presentation materials demonstrating system features and capabilities to stakeholders.

### **Progress Summary**

Successfully completed final testing, optimization, and documentation phase of the NWSDB Device Management System. Conducted comprehensive testing across all modules ensuring data integrity and proper error handling. Optimized database performance with strategic indexing and query improvements. Fixed remaining responsive design issues providing consistent experience across devices and browsers. Created complete documentation including setup guides, schema diagrams, and user manuals. Prepared deployment package with installation scripts and configuration templates. Project completed successfully meeting all specified requirements within 12-week timeline.

### **Errors Encountered and Fixes**

#### Error 1 — Slow Page Load with Large Dataset

**Issue:**  
Device list pages took 5+ seconds to load when database contained 1000+ device records due to inefficient queries.

**Previous Code (Incorrect):**

```php
$sql = "SELECT d.*, c.name as category_name, s.name as section_name,
               b.name as branch_name, u.first_name, u.last_name
        FROM devices d
        LEFT JOIN device_categories c ON d.category_id = c.id
        LEFT JOIN sections s ON d.section_id = s.id
        LEFT JOIN branches b ON s.branch_id = b.id
        LEFT JOIN users u ON d.created_by = u.id";
// No indexing, returns all columns
```

**Fix:**

```php
// Added indexes in database
ALTER TABLE devices ADD INDEX idx_category (category_id);
ALTER TABLE devices ADD INDEX idx_section (section_id);
ALTER TABLE devices ADD INDEX idx_status (status);

// Optimized query selecting only needed columns
$sql = "SELECT d.id, d.name, d.serial_number, d.status,
               c.name as category_name, s.name as section_name
        FROM devices d
        LEFT JOIN device_categories c ON d.category_id = c.id
        LEFT JOIN sections s ON d.section_id = s.id
        WHERE d.status != 'deleted'";
```

**Reason:**  
Query performed multiple JOIN operations without indexes on foreign key columns. Retrieved all columns even though only few displayed.

**Notes:**  
Indexing foreign key columns dramatically improves JOIN performance. Select only necessary columns reducing data transfer overhead.

#### Error 2 — Modal Flickering on Mobile Devices

**Issue:**  
On mobile browsers, opening modal caused screen flicker and modal appeared misaligned before centering properly.

**Previous Code (Incorrect):**

```css
.modal {
  display: none;
}
.modal.active {
  display: block;
  /* Position calculated after display */
}
```

**Fix:**

```css
.modal {
  display: flex;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s ease;
}
.modal.active {
  opacity: 1;
  pointer-events: auto;
}
```

**Reason:**  
Changing display property from none to block triggers reflow causing visible layout shift. Browser recalculates positions after display change.

**Notes:**  
Using opacity and pointer-events instead of display allows smooth transitions without layout recalculation. Flex layout handles centering efficiently.

### **Next Week Plan**

Project completed successfully. Potential future enhancements:

- Mobile app development for field technicians.
- Barcode scanning integration for device tracking.
- Email notifications for repair status updates.

---

## Project Completion Summary

The NWSDB Hardware Device Management System was successfully developed over 12 weeks, meeting all project objectives and requirements. The system provides comprehensive functionality for tracking computer hardware, printers, RVPN connections, fingerprint devices, repairs, and device issues across the NWSDB organization.

### Key Achievements

**Technical Implementation:**

- Built responsive web application using HTML, CSS, JavaScript, and TailwindCSS for modern UI
- Implemented backend with vanilla PHP and MySQL database without frameworks
- Created comprehensive CRUD operations for all entity types
- Developed hierarchical data management (regions → areas → water schemes → sections)
- Implemented role-based access control (admin and regular users)

**Features Delivered:**

- User authentication and session management
- Device inventory tracking with detailed specifications
- Repair history logging and cost tracking
- Issue management with priority levels
- Administrative controls for organizational structure
- Dashboard with real-time statistics and visualizations
- Summary reports with charts and trend analysis

**Code Quality:**

- Organized project structure with separation of concerns
- Reusable components (header, sidebar, database classes)
- Proper error handling and validation
- Optimized database queries with indexing
- Responsive design supporting multiple devices

### Technical Skills Developed

Throughout this 12-week internship, gained practical experience in:

- Full-stack web development with PHP and MySQL
- Front-end frameworks (TailwindCSS) and vanilla JavaScript
- Database design, normalization, and optimization
- User authentication and session management
- RESTful patterns and AJAX for dynamic content
- Version control and deployment processes

### Lessons Learned

1. **Planning Importance:** Initial wireframing and database design prevented major refactoring later
2. **Validation Necessity:** Both client-side and server-side validation essential for data integrity
3. **Performance Optimization:** Indexing and query optimization critical for scalability
4. **User Experience:** Consistent feedback (error messages, confirmations) improves usability
5. **Code Reusability:** Creating helper classes and components reduces duplication and errors

The project demonstrates comprehensive understanding of web application development principles and practical ability to deliver functional systems solving real-world organizational needs.

---

**End of Development Diary**
