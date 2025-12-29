<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Get all devices excluding computers, laptops, and printers
$allDevices = DbHelper::getAllDevices();
$otherDevices = array_filter($allDevices, function($device) {
    $excludeCategories = ['Desktop Computer', 'Laptop', 'Printer', 'RVPN Device', 'Fingerprint Device'];
    return !in_array($device['category_name'], $excludeCategories);
});

// Get all categories for the filter
$categories = DbHelper::getAllDeviceCategories();
$wssOptions = DbHelper::getAllWaterSupplySchemes();

// Success/Error messages
$successMessage = $_SESSION['success_message'] ?? null;
$errorMessage = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Other Devices</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
  <style>
    @keyframes fadeUp {
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
      animation: fadeUp 0.5s ease-out forwards;
      opacity: 0;
    }

    .table-row {
      transition: all 0.2s ease;
    }

    .table-row:hover {
      background-color: #f9fafb;
      transform: translateX(4px);
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-gray-100">
  <?php 
  $pathUpdate = true;
  $pathUpdate2 = false;
  include '../includes/sidemenu.php'; 
  ?>

  <div class="lg:pl-64 min-h-screen flex flex-col">
    <?php include '../includes/header.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <!-- Success/Error Messages -->
      <?php if ($successMessage): ?>
        <div id="successMessage" class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <p class="text-green-700 font-medium"><?= htmlspecialchars($successMessage) ?></p>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($errorMessage): ?>
        <div id="errorMessage" class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
            <p class="text-red-700 font-medium"><?= htmlspecialchars($errorMessage) ?></p>
          </div>
        </div>
      <?php endif; ?>

      <!-- Page Header -->
      <div class="mb-8 animate-fade-up" style="animation-delay: 0.1s">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
              <i class="fas fa-server text-purple-600 mr-3"></i>
              Other Devices
            </h1>
            <p class="mt-2 text-gray-600">Manage network devices, UPS, monitors, and other equipment</p>
          </div>
          <div class="flex gap-3">
            <button onclick="openAddDeviceModal()" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
              <i class="fas fa-plus"></i>
              <span>Add New Device</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-up" style="animation-delay: 0.2s">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Devices</p>
              <p class="text-3xl font-bold text-gray-900 mt-2"><?= count($otherDevices) ?></p>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-server text-purple-600 text-2xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Active</p>
              <p class="text-3xl font-bold text-green-600 mt-2">
                <?= count(array_filter($otherDevices, fn($d) => $d['status'] === 'active')) ?>
              </p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Under Repair</p>
              <p class="text-3xl font-bold text-yellow-600 mt-2">
                <?= count(array_filter($otherDevices, fn($d) => $d['status'] === 'under_repair')) ?>
              </p>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-wrench text-yellow-600 text-2xl"></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Categories</p>
              <p class="text-3xl font-bold text-indigo-600 mt-2">
                <?= count(array_unique(array_column($otherDevices, 'category_name'))) ?>
              </p>
            </div>
            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-layer-group text-indigo-600 text-2xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Device Filters -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8 animate-fade-up" style="animation-delay: 0.2s">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
          <div>
             <h3 class="text-lg font-bold text-gray-900">Filter Devices</h3>
             <p class="text-sm text-gray-500">Search and filter your device list</p>
          </div>
          <button onclick="clearFilters()" class="text-sm text-red-600 hover:text-red-700 font-medium">
            Clear Filters
          </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
           <!-- Search -->
           <div class="col-span-1 md:col-span-2 lg:col-span-1">
             <input type="text" id="searchInput" onkeyup="filterDevices()" placeholder="Search devices..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition-all">
           </div>

           <!-- Category Filter -->
           <div>
             <select id="categoryFilter" onchange="filterDevices()" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition-all cursor-pointer">
               <option value="">All Categories</option>
               <?php 
                $uniqueCategories = array_unique(array_column($otherDevices, 'category_name'));
                sort($uniqueCategories);
                foreach ($uniqueCategories as $catName):
               ?>
               <option value="<?= htmlspecialchars($catName) ?>"><?= htmlspecialchars($catName) ?></option>
               <?php endforeach; ?>
             </select>
           </div>
           
           <!-- Status Filter -->
           <div>
             <select id="statusFilter" onchange="filterDevices()" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition-all cursor-pointer">
               <option value="">All Status</option>
               <option value="active">Active</option>
               <option value="under_repair">Under Repair</option>
               <option value="retired">Retired</option>
               <option value="lost">Lost</option>
             </select>
           </div>

           <!-- WSS Filter -->
           <div>
             <select id="wssFilter" onchange="filterDevices()" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition-all cursor-pointer">
               <option value="">All Locations</option>
               <?php 
                $uniqueWss = array_unique(array_column($otherDevices, 'wss_name'));
                sort($uniqueWss);
                foreach($uniqueWss as $wss):
               ?>
               <option value="<?= htmlspecialchars($wss) ?>"><?= htmlspecialchars($wss) ?></option>
               <?php endforeach; ?>
             </select>
           </div>
        </div>
      </div>

      <!-- Devices Table -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up" style="animation-delay: 0.3s">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-info-circle mr-2 text-purple-600"></i>Device Info
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-tag mr-2 text-purple-600"></i>Category
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-building mr-2 text-purple-600"></i>Location
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-user mr-2 text-purple-600"></i>Assignment
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-circle mr-2 text-purple-600"></i>Status
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-cog mr-2 text-purple-600"></i>Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (empty($otherDevices)): ?>
                <tr>
                  <td colspan="6" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                      <i class="fas fa-server text-5xl mb-3 text-gray-300"></i>
                      <p class="text-lg font-medium">No other devices found</p>
                      <p class="text-sm">Click "Add New Device" to add your first device</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($otherDevices as $device): ?>
                  <tr class="table-row hover:bg-gray-50 transition-colors"
                      data-search="<?= htmlspecialchars(strtolower($device['device_name'] . ' ' . ($device['model'] ?? '') . ' ' . $device['device_id'] . ' ' . ($device['system_unit_serial'] ?? ''))) ?>"
                      data-category="<?= htmlspecialchars($device['category_name'] ?? '') ?>"
                      data-wss="<?= htmlspecialchars($device['wss_name'] ?? '') ?>"
                      data-status="<?= $device['status'] ?>">
                    <td class="px-6 py-4">
                      <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                          <i class="fas fa-server text-purple-600"></i>
                        </div>
                        <div>
                          <div class="text-sm font-semibold text-gray-900">
                            <?= htmlspecialchars($device['device_name'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-500">
                            <?= htmlspecialchars($device['model'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-500 mt-1">
                            ID: <?= htmlspecialchars($device['device_id'] ?? 'N/A') ?>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                        <?= htmlspecialchars($device['category_name'] ?? 'N/A') ?>
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-900"><?= htmlspecialchars($device['wss_name'] ?? 'N/A') ?></div>
                      <div class="text-xs text-gray-500"><?= htmlspecialchars($device['section_name'] ?? 'Unassigned') ?></div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-900"><?= htmlspecialchars($device['assigned_to'] ?? 'Not assigned') ?></div>
                    </td>
                    <td class="px-6 py-4">
                      <?php
                      $statusClass = '';
                      $statusText = ucfirst(str_replace('_', ' ', $device['status'] ?? 'unknown'));
                      switch ($device['status']) {
                        case 'active':
                          $statusClass = 'bg-green-100 text-green-800';
                          break;
                        case 'under_repair':
                          $statusClass = 'bg-yellow-100 text-yellow-800';
                          break;
                        case 'retired':
                          $statusClass = 'bg-gray-100 text-gray-800';
                          break;
                        case 'lost':
                          $statusClass = 'bg-red-100 text-red-800';
                          break;
                        default:
                          $statusClass = 'bg-gray-100 text-gray-800';
                      }
                      ?>
                      <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full <?= $statusClass ?>">
                        <i class="fas fa-circle text-xs mr-1"></i><?= $statusText ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <div class="flex items-center justify-end space-x-2">
                        <button onclick="viewDevice(<?= htmlspecialchars(json_encode($device)) ?>)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="editDevice(<?= htmlspecialchars(json_encode($device)) ?>)" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(<?= $device['device_id'] ?>, '<?= htmlspecialchars($device['device_name'], ENT_QUOTES) ?>')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Add Device Modal -->
  <div id="addDeviceModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50">
        <h3 class="text-xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-plus-circle text-purple-600 mr-2"></i>
            Add New Device
        </h3>
        <button onclick="closeAddDeviceModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6 max-h-[70vh] overflow-y-auto">
        <form id="addDeviceForm" method="POST" action="admin/handlers/computer-handler.php">
          <input type="hidden" name="action" value="create">
          <input type="hidden" name="redirect_to" value="../../other-devices.php">
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div class="md:col-span-2">
              <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4 border-b pb-2">Basic Information</h4>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Device Name *</label>
              <input type="text" name="device_name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all" placeholder="e.g. UPS-Main-Server">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Device Category *</label>
              <select name="category_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                <option value="">Select Category</option>
                <?php 
                $excludeCategories = ['Desktop Computer', 'Laptop', 'Printer', 'RVPN Device', 'Fingerprint Device'];
                if ($categories):
                    foreach ($categories as $cat):
                        if (!in_array($cat['category_name'], $excludeCategories)):
                ?>
                    <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php 
                        endif;
                    endforeach;
                endif; 
                ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
              <input type="text" name="model" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
            </div>

             <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number</label>
              <input type="text" name="system_unit_serial" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
            </div>

            <!-- Location Info -->
            <div class="md:col-span-2 mt-2">
              <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4 border-b pb-2">Location & Assignment</h4>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Water Supply Scheme *</label>
              <select name="wss_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                <option value="">Select Scheme</option>
                <?php foreach ($wssOptions as $wss): ?>
                  <option value="<?= $wss['wss_id'] ?>"><?= htmlspecialchars($wss['wss_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
              <select name="section_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                <option value="">Select Section (Optional)</option>
                 <?php
                  $allSections = DbHelper::getAllSections();
                  foreach ($allSections as $section):
                 ?>
                  <option value="<?= $section['section_id'] ?>"><?= htmlspecialchars($section['section_name']) ?> (<?= htmlspecialchars($section['wss_name']??'') ?>)</option>
                 <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
              <input type="text" name="assigned_to" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
               <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all">
                  <option value="active">Active</option>
                  <option value="under_repair">Under Repair</option>
                  <option value="retired">Retired</option>
                  <option value="lost">Lost</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all"></textarea>
            </div>

          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
        <button onclick="closeAddDeviceModal()" type="button" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button type="submit" form="addDeviceForm" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg">
          <i class="fas fa-save mr-2"></i>Save Device
        </button>
      </div>
    </div>
  </div>

  <script>
    // Auto-hide messages after 5 seconds
    setTimeout(() => {
      const successMessage = document.getElementById('successMessage');
      const errorMessage = document.getElementById('errorMessage');
      if (successMessage) successMessage.style.display = 'none';
      if (errorMessage) errorMessage.style.display = 'none';
    }, 5000);

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    mobileMenuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
      if (
        window.innerWidth < 1024 &&
        !sidebar.contains(e.target) &&
        !mobileMenuBtn.contains(e.target)
      ) {
        sidebar.classList.add('-translate-x-full');
      }
    });

    function filterDevices() {
      const searchText = document.getElementById('searchInput').value.toLowerCase();
      const category = document.getElementById('categoryFilter').value;
      const status = document.getElementById('statusFilter').value;
      const wss = document.getElementById('wssFilter').value;

      const rows = document.querySelectorAll('.table-row');

      rows.forEach(row => {
        const rowSearch = row.getAttribute('data-search') || '';
        const rowCategory = row.getAttribute('data-category') || '';
        const rowStatus = row.getAttribute('data-status') || '';
        const rowWss = row.getAttribute('data-wss') || '';

        let matchesSearch = searchText === '' || rowSearch.includes(searchText);
        let matchesCategory = category === '' || rowCategory === category;
        let matchesStatus = status === '' || rowStatus === status;
        let matchesWss = wss === '' || rowWss === wss;

        if (matchesSearch && matchesCategory && matchesStatus && matchesWss) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function clearFilters() {
      document.getElementById('searchInput').value = '';
      document.getElementById('categoryFilter').value = '';
      document.getElementById('statusFilter').value = '';
      document.getElementById('wssFilter').value = '';
      filterDevices();
    }

    function openAddDeviceModal() {
      document.getElementById('addDeviceModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeAddDeviceModal() {
        document.getElementById('addDeviceModal').classList.add('hidden');
        document.getElementById('addDeviceForm').reset();
        document.body.style.overflow = 'auto';
    }

    function viewDevice(device) {
      alert('View device: ' + device.device_name + ' (Implementation Pending)');
    }

    function editDevice(device) {
      alert('Edit device: ' + device.device_name + ' (Implementation Pending)');
    }

    function confirmDelete(deviceId, deviceName) {
      if (confirm('Are you sure you want to delete ' + deviceName + '?')) {
        // Use a form to submit delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'admin/handlers/computer-handler.php';
        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete';
        
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'device_id';
        idInput.value = deviceId;
        
        const redirectInput = document.createElement('input');
        redirectInput.type = 'hidden';
        redirectInput.name = 'redirect_to';
        redirectInput.value = '../../other-devices.php';
        
        form.appendChild(actionInput);
        form.appendChild(idInput);
        form.appendChild(redirectInput);
        
        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</body>

</html>