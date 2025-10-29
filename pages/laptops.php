<?php
include '../components/sessions.php';
require_once '../functions/DbHelper.php';

$laptops = DbHelper::getAllLaptops();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Laptops</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
</head>

<body class="min-h-screen bg-gray-50">
  <?php include '../components/sidemenu.php'; ?>

  <div class="lg:pl-64 min-h-screen flex flex-col">
    <?php include '../components/header.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Page Header -->
      <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Laptop Devices</h1>
          <p class="mt-1 text-sm text-gray-600">Manage and track all laptop devices in the system</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
          <button onclick="openAddLaptopModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i>
            Add New Laptop
          </button>
          <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            <i class="fas fa-file-excel mr-2"></i>
            Export to Excel
          </button>
        </div>
      </div>

      <!-- Enhanced Filters -->
      <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-filter text-white"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Filter Laptops</h3>
                <p class="text-sm text-gray-600">Refine your search results</p>
              </div>
            </div>
            <button onclick="clearFilters()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
              <i class="fas fa-times mr-2"></i>Clear All
            </button>
          </div>
        </div>

        <!-- Filter Content -->
        <div class="p-6">
          <!-- Search Bar - Prominent Position -->
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Quick Search</label>
            <div class="relative">
              <input
                type="text"
                placeholder="Search by printer name, model, or serial number..."
                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
              <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
          </div>

          <!-- Filter Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Status Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-circle-dot text-blue-600 mr-2"></i>Status
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Status</option>
                <option value="active">✓ Active</option>
                <option value="under_repair">⚠ Under Repair</option>
                <option value="retired">✕ Retired</option>
                <option value="maintenance">🔧 Under Maintenance</option>
              </select>
            </div>

            <!-- Type Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-print text-blue-600 mr-2"></i>Type
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Types</option>
                <option value="laser">Laser Printer</option>
                <option value="inkjet">Inkjet Printer</option>
                <option value="dotmatrix">Dot Matrix Printer</option>
                <option value="multifunction">Multifunction Printer</option>
              </select>
            </div>

            <!-- Department Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-building text-blue-600 mr-2"></i>Department
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Departments</option>
                <option value="it">IT Department</option>
                <option value="hr">HR Department</option>
                <option value="finance">Finance Department</option>
                <option value="operations">Operations</option>
              </select>
            </div>

            <!-- Location Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Location
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Locations</option>
                <option value="head_office">Head Office</option>
                <option value="branch_office">Branch Office</option>
                <option value="site_office">Site Office</option>
              </select>
            </div>
          </div>

          <!-- Location Type Checkboxes -->
          <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-3">
              <i class="fas fa-location-dot text-blue-600 mr-2"></i>Location Type
            </label>
            <div class="flex flex-wrap gap-4">
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_type[]"
                  value="bandarawela">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Bandarawela</span>
              </label>
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_type[]"
                  value="non_bandarawela">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Non Bandarawela</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Footer with Apply Button -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
          <button onclick="resetFilters()" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors duration-200">
            <i class="fas fa-rotate-right mr-2"></i>Reset
          </button>
          <button onclick="applyFilters()" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
            <i class="fas fa-check mr-2"></i>Apply Filters
          </button>
        </div>
      </div>

      <!-- Laptops Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Basic Info</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Hardware Specs</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Additional Features</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Connectivity</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Assignment & Status</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <!-- Sample Row -->
              <?php foreach ($laptops as $laptop): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4">
                    <div class="flex items-center">
                      <i class="fas fa-laptop text-gray-400 mr-3"></i>
                      <div>
                        <div class="text-sm font-medium text-gray-900">
                          Device: <?php echo $laptop['device_name'] ?? 'if need'; ?>
                        </div>
                        <div class="text-sm text-gray-500">
                          Model: <?php echo $laptop['model'] ?? 'if need'; ?>
                        </div>
                        <div class="text-sm text-gray-500">
                          Made in: <?php echo $laptop['made_in'] ?? 'if need'; ?>
                        </div>
                        <div class="text-sm text-gray-500">
                          Purchase: <?php echo $laptop['purchase_date'] ?? 'if need'; ?>
                        </div>
                      </div>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm">
                      <div>Processor: <?php echo $laptop['processor'] ?? 'if need'; ?></div>
                      <div>RAM: <?php echo $laptop['ram'] ?? 'if need'; ?></div>
                      <div>Storage: <?php echo $laptop['hard_drive_capacity'] ?? 'if need'; ?></div>
                      <div>Monitor: <?php echo $laptop['monitor_info'] ?? 'if need'; ?></div>
                      <div>Serial: <?php echo $laptop['cpu_serial'] ?? 'if need'; ?></div>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm">
                      <div>Keyboard: <?php echo $laptop['keyboard'] ?? 'if need'; ?></div>
                      <div>Mouse: <?php echo $laptop['mouse'] ?? 'if need'; ?></div>
                      <div>Printer Connectivity: <?php echo $laptop['printer_connectivity'] ?? 'if need'; ?></div>
                      <div>Virus Guard: <?php echo $laptop['virus_guard'] ?? 'if need'; ?></div>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm">
                      <div>IP Address: <?php echo $laptop['ip_address'] ?? 'if need'; ?></div>
                      <div>Network: <?php echo $laptop['network_connectivity'] ?? 'if need'; ?></div>
                      <div>OS: <?php echo $laptop['operating_system'] ?? 'if need'; ?></div>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm mb-2">
                      <div>Section: <?php echo $laptop['section_name'] ?? 'if need'; ?></div>
                      <div>Assigned to: <?php echo $laptop['user_name'] ?? 'if need'; ?></div>
                    </div>

                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
        <?php echo ($laptop['status'] == 'active') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                      <?php echo ucfirst($laptop['status'] ?? 'if need'); ?>
                    </span>

                    <div class="text-xs text-gray-500 mt-2">
                      <i class="fas fa-info-circle"></i>
                      <?php echo !empty($laptop['notes']) ? htmlspecialchars($laptop['notes']) : 'if need'; ?>
                    </div>
                  </td>

                  <td class="px-6 py-4 text-right text-sm font-medium">
                    <button class="text-blue-600 hover:text-blue-900 mr-3">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
          <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Previous
              </button>
              <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Next
              </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-medium">1</span>
                  to
                  <span class="font-medium">10</span>
                  of
                  <span class="font-medium">20</span>
                  results
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-left"></i>
                  </button>
                  <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</button>
                  <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</button>
                  <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</button>
                  <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                  </button>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Add New Laptop Modal -->
  <div id="addLaptopModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 backdrop-blur-sm bg-white/30 flex items-center justify-center p-4" onclick="closeAddLaptopModal()">
    <!-- Modal content -->
    <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-lg rounded-lg bg-white" onclick="event.stopPropagation()">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-laptop text-white"></i>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Add New Laptop</h3>
            <p class="text-sm text-gray-600">Enter laptop details and specifications</p>
          </div>
        </div>
        <button onclick="closeAddLaptopModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>

      <!-- Modal Body with Scrollable Content -->
      <div class="max-h-96 overflow-y-auto p-4">
        <form id="addLaptopForm">
          <!-- Basic Information Section -->
          <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-info-circle text-blue-600 mr-2"></i>
              Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Device Name *</label>
                <input type="text" name="device_name" required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Laptop Computer, Notebook">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                <input type="text" name="model"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Dell Latitude 5520, HP EliteBook">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Made In</label>
                <input type="text" name="made_in"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., USA, China, Taiwan">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category_id" required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                  <option value="">Select Category</option>
                  <option value="2">Laptop</option>
                  <option value="1">Computer</option>
                  <option value="3">Workstation</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Assignment Information Section -->
          <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-users text-blue-600 mr-2"></i>
              Assignment Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                <select name="section_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                  <option value="">Select Section</option>
                  <option value="1">IT Department</option>
                  <option value="2">HR Department</option>
                  <option value="3">Finance Department</option>
                  <option value="4">Operations</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                <select name="assigned_to"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                  <option value="">Select User</option>
                  <option value="1">John Smith</option>
                  <option value="2">Jane Doe</option>
                  <option value="3">Michael Johnson</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Hardware Specifications Section -->
          <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-microchip text-blue-600 mr-2"></i>
              Hardware Specifications
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Operating System</label>
                <input type="text" name="operating_system"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Windows 11 Pro, macOS Monterey">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Processor</label>
                <input type="text" name="processor"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Intel i7-11800H, AMD Ryzen 7 5800H">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                <input type="text" name="ram"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., 16GB DDR4, 32GB DDR5">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Storage Capacity</label>
                <input type="text" name="hard_drive_capacity"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., 512GB SSD, 1TB NVMe">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keyboard Type</label>
                <input type="text" name="keyboard"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Backlit, Standard, Mechanical">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mouse/Trackpad</label>
                <input type="text" name="mouse"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Built-in Trackpad, External Mouse">
              </div>
            </div>
          </div>

          <!-- Connectivity & Network Section -->
          <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-wifi text-blue-600 mr-2"></i>
              Connectivity & Network
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Network Connectivity</label>
                <input type="text" name="network_connectivity"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., WiFi 6, Ethernet, Bluetooth">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Printer Connectivity</label>
                <input type="text" name="printer_connectivity"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., USB, WiFi, Bluetooth">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">IP Address</label>
                <input type="text" name="ip_address"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., 192.168.1.105 (if static)">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Virus Guard</label>
                <input type="text" name="virus_guard"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., Windows Defender, Norton, BitDefender">
              </div>
            </div>
          </div>

          <!-- Additional Information Section -->
          <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
              Additional Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monitor/Display Info</label>
                <input type="text" name="monitor_info"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="e.g., 15.6inch FHD, 13inch Retina">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CPU/Device Serial</label>
                <input type="text" name="cpu_serial"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                  placeholder="Enter laptop serial number">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date</label>
                <input type="date" name="purchase_date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                  <option value="active">Active</option>
                  <option value="under_repair">Under Repair</option>
                  <option value="retired">Retired</option>
                  <option value="lost">Lost</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Notes Section -->
          <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-sticky-note text-blue-600 mr-2"></i>
              Additional Notes
            </h4>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
              <textarea name="notes" rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                placeholder="Enter any additional notes or comments about this laptop..."></textarea>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="flex items-center justify-end gap-3 p-4 border-t border-gray-200">
        <button onclick="closeAddLaptopModal()"
          class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors duration-200">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button onclick="resetLaptopForm()"
          class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors duration-200">
          <i class="fas fa-refresh mr-2"></i>Reset
        </button>
        <button onclick="saveLaptop()"
          class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
          <i class="fas fa-save mr-2"></i>Save Laptop
        </button>
      </div>
    </div>
  </div>

  <script>
    // Filter functionality
    document.getElementById('search').addEventListener('keyup', function() {
      // Add search filter logic here
    });

    document.getElementById('status').addEventListener('change', function() {
      // Add status filter logic here
    });

    // Modal functionality
    function openAddLaptopModal() {
      document.getElementById('addLaptopModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeAddLaptopModal() {
      document.getElementById('addLaptopModal').classList.add('hidden');
      document.body.style.overflow = 'auto'; // Restore background scrolling
    }

    function resetLaptopForm() {
      document.getElementById('addLaptopForm').reset();
    }

    function saveLaptop() {
      // Get form data
      const formData = new FormData(document.getElementById('addLaptopForm'));

      // Basic validation
      const deviceName = formData.get('device_name');
      const categoryId = formData.get('category_id');

      if (!deviceName || !categoryId) {
        alert('Please fill in all required fields (Device Name and Category)');
        return;
      }

      // Here you would typically send the data to your PHP backend
      console.log('Laptop data to save:', Object.fromEntries(formData));

      // For now, just show a success message and close modal
      alert('Laptop saved successfully! (Note: This is just a UI demo)');
      closeAddLaptopModal();
      resetLaptopForm();
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAddLaptopModal();
      }
    });
  </script>
</body>

</html>