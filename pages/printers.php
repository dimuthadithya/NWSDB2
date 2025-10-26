<?php
include '../components/sessions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Printers</title>
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
          <h1 class="text-2xl font-bold text-gray-900">Printer Devices</h1>
          <p class="mt-1 text-sm text-gray-600">Manage and track all printer devices in the system</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
          <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i>
            Add New Printer
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
          </div>
        </div>
      </div>

      <!-- Printers Table -->
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
                    <i class="fas fa-print text-gray-400 mr-3"></i>
                    <div>
                      <div class="text-sm font-medium text-gray-900">HP LaserJet Pro</div>
                      <div class="text-sm text-gray-500">ID: PR001</div>
                      <div class="text-sm text-gray-500">Model: M404dn</div>
                      <div class="text-sm text-gray-500">Purchase: 2023-05-20</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">
                    <div>Type: Laser Printer</div>
                    <div>Print Speed: 38 ppm</div>
                    <div>Resolution: 1200 x 1200 dpi</div>
                    <div>Paper Size: A4, Letter, Legal</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">
                    <div>Duplex Printing: Yes</div>
                    <div>Color Printing: No</div>
                    <div>Paper Capacity: 250 sheets</div>
                    <div>Monthly Duty: 80,000 pages</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">
                    <div>Network: Ethernet</div>
                    <div>Wi-Fi: Yes</div>
                    <div>USB: Yes</div>
                    <div>IP: 192.168.1.101</div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">
                    <div>Section: IT Department</div>
                    <div>Location: 2nd Floor</div>
                    <div>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                      </span>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium">
                  <div class="flex justify-end space-x-2">
                    <button class="text-indigo-600 hover:text-indigo-900">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900">
                      <i class="fas fa-trash"></i>
                    </button>
                    <button class="text-gray-600 hover:text-gray-900">
                      <i class="fas fa-history"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-4 flex items-center justify-between">
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
              Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
            </p>
          </div>
          <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left"></i>
              </button>
              <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                1
              </button>
              <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                2
              </button>
              <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                3
              </button>
              <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right"></i>
              </button>
            </nav>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>
<p class="text-sm text-gray-700">
  Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
</p>
</div>
<div>
  <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
    <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
      <span class="sr-only">Previous</span>
      <i class="fas fa-chevron-left h-5 w-5"></i>
    </a>
    <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">1</a>
    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
    <a href="#" class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
    <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
      <span class="sr-only">Next</span>
      <i class="fas fa-chevron-right h-5 w-5"></i>
    </a>
  </nav>
</div>
</div>
</div>
</div>
</main>
</div>

<script>
  // Filter functionality
  document.getElementById('search').addEventListener('keyup', function() {
    // Add search filter logic here
  });

  document.getElementById('status').addEventListener('change', function() {
    // Add status filter logic here
  });

  document.getElementById('type').addEventListener('change', function() {
    // Add type filter logic here
  });
</script>
</body>

</html>