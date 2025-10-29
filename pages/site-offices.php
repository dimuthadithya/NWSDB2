<?php
include '../components/sessions.php';
require_once '../functions/DbHelper.php';

$branches = DbHelper::getAllBranches();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Site Offices</title>
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
          <h1 class="text-2xl font-bold text-gray-900">Site Offices & Branches</h1>
          <p class="mt-1 text-sm text-gray-600">Manage and track all branch offices in the system</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
          <button command="show-modal" commandfor="dialog" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i>
            Add New Branch
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
                <h3 class="text-lg font-semibold text-gray-900">Filter Branches</h3>
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
                placeholder="Search by branch name or location..."
                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
              <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
          </div>

          <!-- Filter Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Region Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-map text-blue-600 mr-2"></i>Region
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Regions</option>
                <option value="central">Central Region</option>
                <option value="southern">Southern Region</option>
                <option value="northern">Northern Region</option>
                <option value="eastern">Eastern Region</option>
                <option value="western">Western Region</option>
              </select>
            </div>

            <!-- Branch Type Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-building text-blue-600 mr-2"></i>Branch Type
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Types</option>
                <option value="head_office">Head Office</option>
                <option value="main_branch">Main Branch</option>
                <option value="sub_branch">Sub Branch</option>
                <option value="service_center">Service Center</option>
              </select>
            </div>

            <!-- Created Date Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-calendar text-blue-600 mr-2"></i>Created Date
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Dates</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
              </select>
            </div>

            <!-- Status Filter -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <i class="fas fa-circle-dot text-blue-600 mr-2"></i>Status
              </label>
              <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white">
                <option value="">All Status</option>
                <option value="active">✓ Active</option>
                <option value="inactive">✕ Inactive</option>
                <option value="maintenance">🔧 Under Maintenance</option>
              </select>
            </div>
          </div>

          <!-- Location Type Checkboxes -->
          <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-3">
              <i class="fas fa-location-dot text-blue-600 mr-2"></i>Location Areas
            </label>
            <div class="flex flex-wrap gap-4">
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_area[]"
                  value="bandarawela">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Bandarawela</span>
              </label>
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_area[]"
                  value="badulla">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Badulla</span>
              </label>
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_area[]"
                  value="welimada">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Welimada</span>
              </label>
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_area[]"
                  value="ella">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Ella</span>
              </label>
              <label class="inline-flex items-center cursor-pointer group">
                <input
                  type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                  name="location_area[]"
                  value="nuwara_eliya">
                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">Nuwara Eliya</span>
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

      <!-- Modal -->
      <el-dialog>
        <dialog id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
          <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in" onclick="document.getElementById('dialog').close()"></el-dialog-backdrop>

          <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0" onclick="if(event.target === this) document.getElementById('dialog').close()">
            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
              <form id="addBranchForm" action="../admin/handlers/addHandler.php" method="post">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                    <div class="w-full">
                      <h3 id="dialog-title" class="text-lg font-semibold text-gray-900 mb-5">Add New Branch Office</h3>
                      <div class="space-y-4">
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Branch Name</label>
                          <input type="text" name="branch_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                          <input type="text" name="branch_location" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Enter branch location">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                  <button type="submit" name="save_branch" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Save Branch</button>
                  <button type="button" command="close" commandfor="dialog" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
              </form>
            </el-dialog-panel>
          </div>
        </dialog>
      </el-dialog>

      <!-- Branches Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Branch Info</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Location Details</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Date Information</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php
              if (is_array($branches) && count($branches) > 0) { ?>
                <?php foreach ($branches as $key => $branch) { ?>
                  <tr class="hover:bg-gray-50">
                    <!-- Branch Basic Info -->
                    <td class="px-6 py-4">
                      <div class="flex items-center">
                        <i class="fas fa-building text-blue-500 mr-3 text-lg"></i>
                        <div>
                          <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($branch['branch_name'] ?? 'N/A') ?>
                          </div>
                          <div class="text-sm text-gray-500">
                            ID: <?= htmlspecialchars($branch['branch_id'] ?? 'N/A') ?>
                          </div>
                        </div>
                      </div>
                    </td>

                    <!-- Location Details -->
                    <td class="px-6 py-4">
                      <div class="text-sm">
                        <div class="flex items-center mb-1">
                          <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                          <span class="font-medium text-gray-900">
                            <?= htmlspecialchars($branch['location'] ?? 'Location not specified') ?>
                          </span>
                        </div>
                        <div class="text-xs text-gray-500">
                          Full Address
                        </div>
                      </div>
                    </td>

                    <!-- Date Information -->
                    <td class="px-6 py-4">
                      <div class="text-sm">
                        <div class="flex items-center mb-1">
                          <i class="fas fa-calendar-plus text-green-500 mr-2"></i>
                          <span class="text-gray-900">Created:</span>
                        </div>
                        <div class="text-xs text-gray-600 mb-2">
                          <?= htmlspecialchars($branch['created_at'] ?? 'N/A') ?>
                        </div>
                        <div class="flex items-center">
                          <i class="fas fa-calendar-edit text-orange-500 mr-2"></i>
                          <span class="text-gray-900">Updated:</span>
                        </div>
                        <div class="text-xs text-gray-600">
                          <?= htmlspecialchars($branch['updated_at'] ?? 'N/A') ?>
                        </div>
                      </div>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Active
                      </span>
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-right text-sm font-medium">
                      <div class="flex justify-end space-x-2">
                        <button class="text-indigo-600 hover:text-indigo-900 p-2 hover:bg-indigo-50 rounded transition-colors duration-200" title="Edit Branch">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded transition-colors duration-200" title="View Details">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 cursor-pointer">
                          <a href="../admin/handlers/deleteHandler.php?branch_id=<?php echo $branch['branch_id']; ?>&&action=delete_branch">
                            <i class="fas fa-trash"></i>
                          </a>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="5" class="text-center py-4">No branches found.</td>
                </tr>
              <?php } ?>
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
              Showing <span class="font-medium">1</span> to <span class="font-medium"><?= count($branches) ?: 2 ?></span> of <span class="font-medium"><?= count($branches) ?: 2 ?></span> results
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

  <script>
    function clearFilters() {
      // Clear all filter inputs
      document.querySelectorAll('select, input[type="text"], input[type="checkbox"]').forEach(element => {
        if (element.type === 'checkbox') {
          element.checked = false;
        } else {
          element.value = '';
        }
      });
    }

    function resetFilters() {
      clearFilters();
    }

    function applyFilters() {
      // Here you would typically send the filter data to the server
      console.log('Applying filters...');
      // You can add AJAX call here to filter the results
    }
  </script>
</body>

</html>