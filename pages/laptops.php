<?php
include '../components/sessions.php';
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
          <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                <h3 class="text-lg font-semibold text-gray-900">Filter Printers</h3>
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
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <i class="fas fa-laptop text-gray-400 mr-3"></i>
                    <div>
                      <div class="text-sm font-medium text-gray-900">Device: Dell Latitude 5520</div>
                      <div class="text-sm text-gray-500">Model: Latitude 5520</div>
                      <div class="text-sm text-gray-500">Made in: Malaysia</div>
                      <div class="text-sm text-gray-500">Purchase: 2023-01-15</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm">
                    <div>Processor: Intel i7-1165G7</div>
                    <div>RAM: 16GB DDR4</div>
                    <div>Storage: 512GB NVMe SSD</div>
                    <div>Display: 15.6" FHD</div>
                    <div>Serial: XYZ123456</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm">
                    <div>Battery: 4-Cell 63Whr</div>
                    <div>Keyboard: Backlit</div>
                    <div>Webcam: HD 720p</div>
                    <div>Charger: 65W USB-C</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm">
                    <div>IP Address: 192.168.1.100</div>
                    <div>WiFi: Intel AX201</div>
                    <div>Network: WiFi/Ethernet</div>
                    <div>Security: BitLocker</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm mb-2">
                    <div>Section: Field Operations</div>
                    <div>Assigned to: Jane Smith</div>
                  </div>
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Active
                  </span>
                  <div class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i> Click for notes
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
</body>

</html>