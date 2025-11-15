<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch water supply schemes data
$schemes = DbHelper::getAllWaterSupplySchemes();
$totalSchemes = DbHelper::getWaterSupplySchemeCount();
$activeSchemes = DbHelper::getActiveSchemeCount();
$maintenanceSchemes = DbHelper::getMaintenanceSchemeCount();
$areas = DbHelper::getAllAreas(); // For dropdown in modal

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Water Supply Schemes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-up {
      animation: fadeInUp 0.6s ease-out forwards;
    }

    .stat-card {
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .sidebar-link {
      transition: all 0.2s ease;
    }

    .sidebar-link:hover {
      transform: translateX(5px);
    }

    .table-row {
      transition: all 0.2s ease;
    }

    .table-row:hover {
      background: rgba(59, 130, 246, 0.03);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>

<body
  class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
  <?php
  $pathUpdate2 = true;
  $pathUpdate = false;
  include '../../includes/sidemenu.php';
  ?>
  <!-- Main Content -->
  <main class="lg:ml-64 min-h-screen">
    <!-- Header -->
    <?php
    include '../../includes/header.php';
    ?>

    <!-- Content -->
    <div class="p-6 space-y-6">
      <!-- Summary Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-tint text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $totalSchemes; ?></h3>
          <p class="text-blue-100 text-sm">Total Schemes</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Operational</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $activeSchemes; ?></h3>
          <p class="text-green-100 text-sm">Active Schemes</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-wrench text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Maintenance</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $maintenanceSchemes; ?></h3>
          <p class="text-orange-100 text-sm">Under Maintenance</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-network-wired text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Connections</span>
          </div>
          <h3 class="text-3xl font-bold mb-1">425K</h3>
          <p class="text-purple-100 text-sm">Total Connections</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Scheme
        </button>
        <button
          class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 shadow-sm border border-gray-200 transition-all">
          <i class="fas fa-file-excel mr-2 text-green-600"></i>
          Export to Excel
        </button>
        <button
          class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 shadow-sm border border-gray-200 transition-all">
          <i class="fas fa-file-pdf mr-2 text-red-600"></i>
          Export to PDF
        </button>
      </div>

      <!-- Search and Filter -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <input
              type="text"
              placeholder="Search schemes..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>
          <select
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option>All Areas</option>
            <option>Colombo North</option>
            <option>Kandy Central</option>
            <option>Galle South</option>
          </select>
          <select
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option>All Types</option>
            <option>Rural</option>
            <option>Urban</option>
            <option>Semi-Urban</option>
            <option>Estate</option>
          </select>
          <select
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option>All Status</option>
            <option>Operational</option>
            <option>Under Maintenance</option>
            <option>Non-Operational</option>
            <option>Under Construction</option>
          </select>
        </div>
      </div>

      <!-- Schemes Table -->
      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
              <tr>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Scheme Code
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Scheme Name
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Area
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Region
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Status
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Created Date
                </th>
                <th
                  class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (!empty($schemes)): ?>
                <?php foreach ($schemes as $scheme): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4">
                      <span class="font-mono text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($scheme['wss_code']); ?></span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="font-semibold text-gray-900"><?php echo htmlspecialchars($scheme['wss_name']); ?></div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="font-medium text-gray-700"><?php echo htmlspecialchars($scheme['area_name'] ?? 'N/A'); ?></div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-600"><?php echo htmlspecialchars($scheme['region_name'] ?? 'N/A'); ?></div>
                    </td>
                    <td class="px-6 py-4">
                      <?php if ($scheme['status'] === 'active'): ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                      <?php elseif ($scheme['status'] === 'maintenance'): ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Maintenance</span>
                      <?php else: ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                      <?php echo date('M d, Y', strtotime($scheme['created_at'])); ?>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                      <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p class="text-lg font-medium">No water supply schemes found</p>
                    <p class="text-sm">Click "Add Scheme" to create your first water supply scheme</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div
          class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
          <div class="text-sm text-gray-600">
            Showing <?php echo count($schemes); ?> of <?php echo $totalSchemes; ?> entries
          </div>
          <div class="flex gap-2">
            <button
              class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100">
              Previous
            </button>
            <button
              class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
              1
            </button>
            <button
              class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100">
              2
            </button>
            <button
              class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100">
              3
            </button>
            <button
              class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100">
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Add Water Scheme Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">
            <i class="fas fa-tint mr-2"></i>Add New Water Supply Scheme
          </h3>
          <button
            onclick="closeAddModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Area <span class="text-red-500">*</span>
            </label>
            <select
              name="area_id"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Area</option>
              <?php foreach ($areas as $area): ?>
                <option value="<?php echo $area['area_id']; ?>">
                  <?php echo htmlspecialchars($area['area_name']); ?> - <?php echo htmlspecialchars($area['region_name'] ?? ''); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              WSS Code <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., WSS001" />
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              WSS Name <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., Colombo City Water Supply" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Status
            </label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="maintenance">Maintenance</option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
          <button
            type="button"
            onclick="closeAddModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-times mr-2"></i>Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
            <i class="fas fa-save mr-2"></i>Save Scheme
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    mobileMenuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });

    // Modal functions
    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
    }

    // Close modal on outside click
    document
      .getElementById('addModal')
      .addEventListener('click', function(e) {
        if (e.target === this) {
          closeAddModal();
        }
      });
  </script>
</body>

</html>