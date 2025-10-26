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

      <!-- Filters -->
      <div class="mb-6 bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
              <option value="">All Status</option>
              <option value="active">Active</option>
              <option value="under_repair">Under Repair</option>
              <option value="retired">Retired</option>
              <option value="maintenance">Under Maintenance</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
              <option value="">All Types</option>
              <option value="laser">Laser Printer</option>
              <option value="inkjet">Inkjet Printer</option>
              <option value="dotmatrix">Dot Matrix Printer</option>
              <option value="multifunction">Multifunction Printer</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
              <option value="">All Departments</option>
              <option value="it">IT Department</option>
              <option value="hr">HR Department</option>
              <option value="finance">Finance Department</option>
              <option value="operations">Operations</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
            <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
              <option value="">All Locations</option>
              <option value="head_office">Head Office</option>
              <option value="branch_office">Branch Office</option>
              <option value="site_office">Site Office</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="relative">
              <input type="text" placeholder="Search printers..." class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-10">
              <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <div class="flex flex-col gap-2">
              <label class="block text-sm font-medium text-gray-700">Location Type</label>
              <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                  <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="location_type[]" value="bandarawela">
                  <span class="ml-2">Bandarawela</span>
                </label>
                <label class="inline-flex items-center">
                  <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="location_type[]" value="non_bandarawela">
                  <span class="ml-2">Non Bandarawela</span>
                </label>
              </div>
            </div>
          </div>
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