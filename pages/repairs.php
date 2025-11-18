<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch repairs from database
$repairs = DbHelper::getAllRepairs();
if (!$repairs) {
  $repairs = [];
}

// Fetch devices for dropdown
$devices = DbHelper::getAllDevices();
if (!$devices) {
  $devices = [];
}

// Calculate statistics
$totalRepairs = count($repairs);
$pendingRepairs = count(array_filter($repairs, function ($repair) {
  return $repair['status'] === 'pending';
}));
$inProgressRepairs = count(array_filter($repairs, function ($repair) {
  return $repair['status'] === 'in_progress';
}));
$completedRepairs = count(array_filter($repairs, function ($repair) {
  return $repair['status'] === 'completed';
}));

// Calculate total cost
$totalCost = array_sum(array_column($repairs, 'cost'));

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Repair Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
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
  </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
  <!-- Side Menu -->
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
      <!-- Session Messages -->
      <?php if (isset($_SESSION['success'])): ?>
        <div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-check-circle text-xl mr-3"></i>
            <p class="font-medium"><?= $_SESSION['success'];
                                    unset($_SESSION['success']); ?></p>
          </div>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-xl mr-3"></i>
            <p class="font-medium"><?= $_SESSION['error'];
                                    unset($_SESSION['error']); ?></p>
          </div>
        </div>
      <?php endif; ?>

      <!-- Summary Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Repairs -->
        <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-blue-100 text-sm font-medium">Total Repairs</p>
              <h3 class="text-3xl font-bold mt-2"><?= $totalRepairs ?></h3>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
              <i class="fas fa-tools text-3xl"></i>
            </div>
          </div>
        </div>

        <!-- Pending -->
        <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-yellow-100 text-sm font-medium">Pending</p>
              <h3 class="text-3xl font-bold mt-2"><?= $pendingRepairs ?></h3>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
              <i class="fas fa-clock text-3xl"></i>
            </div>
          </div>
        </div>

        <!-- In Progress -->
        <div class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-orange-100 text-sm font-medium">In Progress</p>
              <h3 class="text-3xl font-bold mt-2"><?= $inProgressRepairs ?></h3>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
              <i class="fas fa-wrench text-3xl"></i>
            </div>
          </div>
        </div>

        <!-- Completed -->
        <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-100 text-sm font-medium">Completed</p>
              <h3 class="text-3xl font-bold mt-2"><?= $completedRepairs ?></h3>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
              <i class="fas fa-check-double text-3xl"></i>
            </div>
          </div>
        </div>

        <!-- Total Cost -->
        <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-purple-100 text-sm font-medium">Total Cost</p>
              <h3 class="text-3xl font-bold mt-2">$<?= number_format($totalCost, 2) ?></h3>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
              <i class="fas fa-dollar-sign text-3xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Repairs Table -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
          <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-list mr-2 text-blue-600"></i>Repair Records
          </h2>
          <button
            onclick="openAddModal()"
            class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md">
            <i class="fas fa-plus mr-2"></i>Add Repair
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Repair ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WSS</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Repair Details</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Repair Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (!empty($repairs)): ?>
                <?php foreach ($repairs as $repair): ?>
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      #<?= htmlspecialchars($repair['repair_id']) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($repair['device_name']) ?>
                      <?php if (!empty($repair['model'])): ?>
                        <br><span class="text-xs text-gray-500"><?= htmlspecialchars($repair['model']) ?></span>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($repair['category_name']) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($repair['wss_name']) ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                      <?= htmlspecialchars($repair['repair_details'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= $repair['repair_date'] ? date('Y-m-d', strtotime($repair['repair_date'])) : 'N/A' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      $<?= number_format($repair['cost'] ?? 0, 2) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?php
                      $status = $repair['status'] ?? 'pending';
                      $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'in_progress' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800'
                      ];
                      $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                      $statusText = ucwords(str_replace('_', ' ', $status));
                      ?>
                      <span class="px-2 py-1 text-xs font-medium <?= $statusClass ?> rounded-full"><?= $statusText ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button
                        onclick='openEditModal(<?= json_encode($repair) ?>)'
                        class="text-blue-600 hover:text-blue-900 mr-3"
                        title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        onclick="confirmDelete(<?= $repair['repair_id'] ?>, '<?= htmlspecialchars($repair['device_name'], ENT_QUOTES) ?>')"
                        class="text-red-600 hover:text-red-900"
                        title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>No repair records found</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Add Repair Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Add New Repair</h3>
          <button
            onclick="closeAddModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form action="./admin/handlers/region-handler.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="create">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Device -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Device <span class="text-red-500">*</span></label>
            <select
              name="device_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="">Select Device</option>
              <?php foreach ($devices as $device): ?>
                <option value="<?= htmlspecialchars($device['device_id']) ?>">
                  <?= htmlspecialchars($device['device_name']) ?>
                  <?php if (!empty($device['model'])): ?>
                    - <?= htmlspecialchars($device['model']) ?>
                  <?php endif; ?>
                  (<?= htmlspecialchars($device['category_name']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Repair Date -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Repair Date <span class="text-red-500">*</span></label>
            <input
              type="date"
              name="repair_date"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <!-- Cost -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cost ($)</label>
            <input
              type="number"
              step="0.01"
              name="cost"
              placeholder="0.00"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              name="status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="pending" selected>Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Repair Details -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Repair Details <span class="text-red-500">*</span></label>
            <textarea
              name="repair_details"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required></textarea>
          </div>

          <!-- Notes -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea
              name="notes"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
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
            <i class="fas fa-save mr-2"></i>Save Repair
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Repair Modal -->
  <div
    id="editModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Edit Repair</h3>
          <button
            onclick="closeEditModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form action="./admin/handlers/repair-handler.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="repair_id" id="edit_repair_id">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Device -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Device <span class="text-red-500">*</span></label>
            <select
              name="device_id"
              id="edit_device_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required>
              <option value="">Select Device</option>
              <?php foreach ($devices as $device): ?>
                <option value="<?= htmlspecialchars($device['device_id']) ?>">
                  <?= htmlspecialchars($device['device_name']) ?>
                  <?php if (!empty($device['model'])): ?>
                    - <?= htmlspecialchars($device['model']) ?>
                  <?php endif; ?>
                  (<?= htmlspecialchars($device['category_name']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Repair Date -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Repair Date <span class="text-red-500">*</span></label>
            <input
              type="date"
              name="repair_date"
              id="edit_repair_date"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required />
          </div>

          <!-- Cost -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cost ($)</label>
            <input
              type="number"
              step="0.01"
              name="cost"
              id="edit_cost"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              name="status"
              id="edit_status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Repair Details -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Repair Details <span class="text-red-500">*</span></label>
            <textarea
              name="repair_details"
              id="edit_repair_details"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required></textarea>
          </div>

          <!-- Notes -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea
              name="notes"
              id="edit_notes"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
          </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
          <button
            type="button"
            onclick="closeEditModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all">
            <i class="fas fa-save mr-2"></i>Update Repair
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div
    id="deleteModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
      <div class="bg-gradient-to-r from-red-600 to-rose-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Confirm Delete</h3>
          <button
            onclick="closeDeleteModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form action="./admin/handlers/repair-handler.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="repair_id" id="delete_repair_id">

        <div class="text-center mb-6">
          <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
          <p class="text-gray-700 text-lg">Are you sure you want to delete this repair record for:</p>
          <p class="font-bold text-gray-900 mt-2" id="delete_device_name"></p>
        </div>

        <div class="flex gap-3 justify-center">
          <button
            type="button"
            onclick="closeDeleteModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg hover:from-red-700 hover:to-rose-700 transition-all">
            <i class="fas fa-trash mr-2"></i>Delete Repair
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    if (mobileMenuBtn && sidebar) {
      mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
      });
    }

    // Modal functions
    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(repair) {
      document.getElementById('edit_repair_id').value = repair.repair_id;
      document.getElementById('edit_device_id').value = repair.device_id || '';
      document.getElementById('edit_repair_date').value = repair.repair_date || '';
      document.getElementById('edit_cost').value = repair.cost || '';
      document.getElementById('edit_status').value = repair.status || 'pending';
      document.getElementById('edit_repair_details').value = repair.repair_details || '';
      document.getElementById('edit_notes').value = repair.notes || '';

      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function confirmDelete(repairId, deviceName) {
      document.getElementById('delete_repair_id').value = repairId;
      document.getElementById('delete_device_name').textContent = deviceName;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modals on outside click
    document.getElementById('addModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeAddModal();
      }
    });

    document.getElementById('editModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeEditModal();
      }
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeDeleteModal();
      }
    });

    // Close modals on ESC key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAddModal();
        closeEditModal();
        closeDeleteModal();
      }
    });

    // Auto-hide messages after 5 seconds
    setTimeout(function() {
      const successMessage = document.getElementById('successMessage');
      const errorMessage = document.getElementById('errorMessage');
      if (successMessage) {
        successMessage.style.display = 'none';
      }
      if (errorMessage) {
        errorMessage.style.display = 'none';
      }
    }, 5000);
  </script>
</body>

</html>