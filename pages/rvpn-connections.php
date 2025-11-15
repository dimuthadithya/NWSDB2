<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch RVPN connections from database
$rvpnConnections = DbHelper::getAllRVPNConnections();
if (!$rvpnConnections) {
  $rvpnConnections = [];
}

// Calculate statistics
$totalConnections = count($rvpnConnections);
$activeConnections = count(array_filter($rvpnConnections, function ($conn) {
  return $conn['status'] === 'active';
}));
$inactiveConnections = $totalConnections - $activeConnections;
$totalUsers = $totalConnections; // Each connection represents a user

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - RVPN Connections</title>
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
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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
  <!-- Side Menu   -->
  <?php
  $pathUpdate = true;
  $pathUpdate2 = false;
  include_once __DIR__ . '/../includes/sidemenu.php';
  ?>

  <!-- Main Content -->
  <main class="lg:ml-64 min-h-screen">
    <!-- Header -->
    <?php include_once __DIR__ . '/../includes/header.php'; ?>


    <!-- Content -->
    <div class="p-6 space-y-6">
      <!-- Summary Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.1s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-network-wired text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $totalConnections ?></h3>
          <p class="text-blue-100 text-sm">Total Connections</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.2s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Active</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $activeConnections ?></h3>
          <p class="text-green-100 text-sm">Active Connections</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-pause-circle text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Inactive</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $inactiveConnections ?></h3>
          <p class="text-orange-100 text-sm">Inactive Connections</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.4s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-users text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Users</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $totalUsers ?></h3>
          <p class="text-purple-100 text-sm">Total Users</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New RVPN Connection
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

      <!-- RVPN Connections Table -->
      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up">
        <div
          class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-network-wired text-white"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">
                  RVPN Connections List
                </h3>
                <p class="text-sm text-gray-600">
                  View and manage all RVPN connections
                </p>
              </div>
            </div>
            <div class="relative">
              <input
                type="text"
                placeholder="Search connections..."
                class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" />
              <i
                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Serial No.
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Name of RVPN User
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Employee Number
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Designation
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Working Location
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Cost Code
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Serial Number
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Username
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Pin No.
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Required Status
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (empty($rvpnConnections)): ?>
                <tr>
                  <td colspan="11" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                      <i class="fas fa-network-wired text-5xl mb-3 text-gray-300"></i>
                      <p class="text-lg font-medium">No RVPN connections found</p>
                      <p class="text-sm">Click "Add New RVPN Connection" to add your first connection</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($rvpnConnections as $index => $conn): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <?= str_pad($index + 1, 3, '0', STR_PAD_LEFT) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <?= htmlspecialchars($conn['device_name'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['employee_number'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['designation'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['working_location'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['cost_code'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['rvpn_serial_number'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['rvpn_username'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($conn['pin_number'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?php
                      $required = $conn['connection_required'] ?? 'not_required';
                      $badgeClass = $required === 'required' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
                      $badgeText = ucfirst(str_replace('_', ' ', $required));
                      ?>
                      <span class="px-2 py-1 text-xs font-medium <?= $badgeClass ?> rounded-full"><?= $badgeText ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button class="text-blue-600 hover:text-blue-900 mr-3" title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="text-red-600 hover:text-red-900" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing <span class="font-medium">1</span> to
              <span class="font-medium">10</span> of
              <span class="font-medium">156</span> results
            </div>
            <div class="flex gap-2">
              <button
                class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                disabled>
                Previous
              </button>
              <button
                class="px-3 py-1 border border-blue-500 bg-blue-500 text-white rounded-lg">
                1
              </button>
              <button
                class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50">
                2
              </button>
              <button
                class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50">
                3
              </button>
              <button
                class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50">
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Add RVPN Connection Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">
            Add New RVPN Connection
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Name of RVPN User</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Employee Number</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Designation</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Working Location</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cost Code</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number of RVPN Connection</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username of RVPN Connection</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pin No.</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Whether the connection is required or not</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="required">Required</option>
              <option value="not_required">Not Required</option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
          <button
            type="button"
            onclick="closeAddModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
            <i class="fas fa-save mr-2"></i>Save Connection
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