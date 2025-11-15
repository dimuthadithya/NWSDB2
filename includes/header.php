   <?php
    // Get current page name
    $current_page = basename($_SERVER['PHP_SELF']);

    // Define page titles and descriptions
    $page_info = [
        'dashboard.php' => [
            'title' => 'Dashboard',
            'description' => 'Welcome back, ' . $name . '! Here\'s your device overview.'
        ],
        'computers.php' => [
            'title' => 'Computers',
            'description' => 'Manage and track all computer devices in the system.'
        ],
        'printers.php' => [
            'title' => 'Printers',
            'description' => 'View and manage printer inventory and status.'
        ],
        'rvpn-connections.php' => [
            'title' => 'RVPN Connections',
            'description' => 'Monitor and manage remote VPN connections.'
        ],
        'finger-device.php' => [
            'title' => 'Finger Devices',
            'description' => 'Track biometric and attendance devices.'
        ],
        'other-devices.php' => [
            'title' => 'Other Devices',
            'description' => 'Manage miscellaneous hardware and peripherals.'
        ],
        'repairs.php' => [
            'title' => 'Repairs',
            'description' => 'Track device repairs and maintenance history.'
        ],
        'summary.php' => [
            'title' => 'Summary',
            'description' => 'View comprehensive reports and statistics.'
        ],
        'regions.php' => [
            'title' => 'Regions',
            'description' => 'Manage regional divisions and coverage areas.'
        ],
        'areas.php' => [
            'title' => 'Areas',
            'description' => 'Manage service areas under regional divisions.'
        ],
        'water-schemes.php' => [
            'title' => 'Water Supply Schemes',
            'description' => 'Manage water supply projects and infrastructure.'
        ],
        'site_offices.php' => [
            'title' => 'Site Offices',
            'description' => 'Manage office locations and branch information.'
        ],
        'sections.php' => [
            'title' => 'Sections',
            'description' => 'Manage departments and organizational sections.'
        ],
        'users.php' => [
            'title' => 'Users',
            'description' => 'Manage system users and access permissions.'
        ],
        'categories.php' => [
            'title' => 'Categories',
            'description' => 'Manage device categories and classifications.'
        ],
        'reports.php' => [
            'title' => 'Reports',
            'description' => 'Generate and view detailed system reports.'
        ]
    ];

    // Get current page info or use default
    $page_title = isset($page_info[$current_page]) ? $page_info[$current_page]['title'] : 'Dashboard';
    $page_description = isset($page_info[$current_page]) ? $page_info[$current_page]['description'] : 'Welcome to NWSDB Hardware Management System.';
    ?>

   <header
       class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-30 border-b border-gray-100">
       <div class="px-6 py-4 flex items-center justify-between">
           <div class="animate-fade-up">
               <h1 class="text-2xl font-bold text-gray-800"><?php echo $page_title; ?></h1>
               <p class="text-sm text-gray-500 mt-1">
                   <?php echo $page_description; ?>
               </p>
           </div>
           <div class="flex items-center space-x-4">
               <button
                   class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                   <i class="fas fa-bell text-xl"></i>
                   <span
                       class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full status-badge"></span>
               </button>
               <div
                   class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                   <div class="text-right">
                       <p class="text-sm font-medium text-gray-800"><?php echo $name; ?> </p>
                       <p class="text-xs text-gray-500"><?php echo $role;  ?></p>
                   </div>
                   <div
                       class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                       <i class="fas fa-user text-white text-sm"></i>
                   </div>
               </div>
           </div>
       </div>
   </header>