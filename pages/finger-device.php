<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch finger devices from database
$fingerDevices = DbHelper::getAllFingerDevices();
if (!$fingerDevices) {
  $fingerDevices = [];
}

// Calculate statistics
$totalDevices = count($fingerDevices);
$activeDevices = count(array_filter($fingerDevices, function ($device) {
  return $device['status'] === 'active';
}));
$approvedDevices = count(array_filter($fingerDevices, function ($device) {
  return $device['approval_status'] === 'approved';
}));
// Get unique locations
$locations = array_unique(array_column($fingerDevices, 'location_name'));
$totalLocations = count(array_filter($locations));

// Fetch data for dropdowns
$sections = DbHelper::getAllSections();
$waterSupplySchemes = DbHelper::getAllWaterSupplySchemes();
$categories = DbHelper::getAllDeviceCategories();

// Get the fingerprint device category ID
$fingerDeviceCategoryId = null;
if ($categories) {
  foreach ($categories as $category) {
    if ($category['category_name'] === 'Fingerprint Device') {
      $fingerDeviceCategoryId = $category['category_id'];
      break;
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Finger Device Management</title>
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
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.1s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-fingerprint text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $totalDevices ?></h3>
          <p class="text-blue-100 text-sm">Total Devices</p>
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
          <h3 class="text-3xl font-bold mb-1"><?= $activeDevices ?></h3>
          <p class="text-green-100 text-sm">Active Devices</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-map-marker-alt text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Locations</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $totalLocations ?></h3>
          <p class="text-orange-100 text-sm">Locations</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.4s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-shield-alt text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Approved</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?= $approvedDevices ?></h3>
          <p class="text-purple-100 text-sm">Under Warranty</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Finger Device
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

      <!-- Finger Devices Table -->
      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up">
        <div
          class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-fingerprint text-white"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">
                  Finger Devices List
                </h3>
                <p class="text-sm text-gray-600">
                  View and manage all biometric devices
                </p>
              </div>
            </div>
            <div class="relative">
              <input
                type="text"
                placeholder="Search devices..."
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
                  Location Name
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Sub Location
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Make
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Model
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Device Type
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Device No
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Serial No
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  IP Address
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Installed Date
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Company
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Cost
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Warranty
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Port No
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Managed By
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (empty($fingerDevices)): ?>
                <tr>
                  <td colspan="16" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                      <i class="fas fa-fingerprint text-5xl mb-3 text-gray-300"></i>
                      <p class="text-lg font-medium">No finger devices found</p>
                      <p class="text-sm">Click "Add New Finger Device" to add your first device</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($fingerDevices as $device): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <?= htmlspecialchars($device['location_name'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['sub_location'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['make'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['model'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['device_type'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['device_number'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['identification_code'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['ip_address_adsl'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= $device['installed_date'] ? date('Y-m-d', strtotime($device['installed_date'])) : 'N/A' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['company_name'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= $device['device_cost'] ? '$' . number_format($device['device_cost'], 2) : 'N/A' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['warranty_period'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['port_number'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?= htmlspecialchars($device['managed_by'] ?? 'N/A') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?php
                      $approvalStatus = $device['approval_status'] ?? 'pending';
                      $statusColors = [
                        'approved' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'rejected' => 'bg-red-100 text-red-800'
                      ];
                      $statusClass = $statusColors[$approvalStatus] ?? 'bg-gray-100 text-gray-800';
                      $statusText = ucfirst($approvalStatus);
                      ?>
                      <span class="px-2 py-1 text-xs font-medium <?= $statusClass ?> rounded-full"><?= $statusText ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button
                        onclick='openEditModal(<?= json_encode($device) ?>)'
                        class="text-blue-600 hover:text-blue-900 mr-3"
                        title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        onclick="confirmDelete(<?= $device['device_id'] ?>, '<?= htmlspecialchars($device['location_name'] ?? 'Device', ENT_QUOTES) ?>')"
                        class="text-red-600 hover:text-red-900"
                        title="Delete">
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
              <span class="font-medium">67</span> results
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

  <!-- Add Finger Device Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Add New Finger Device</h3>
          <button
            onclick="closeAddModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form action="./admin/handlers/finger-device-handler.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="category_id" value="<?= htmlspecialchars($fingerDeviceCategoryId) ?>">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- WSS (Water Supply Scheme) -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">WSS Code <span class="text-red-500">*</span></label>
            <select
              name="wss_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="">Select WSS</option>
              <?php foreach ($waterSupplySchemes as $wss): ?>
                <option value="<?= htmlspecialchars($wss['wss_id']) ?>">
                  <?= htmlspecialchars($wss['wss_code']) ?> - <?= htmlspecialchars($wss['wss_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Section -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
            <select
              name="section_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Section</option>
              <?php foreach ($sections as $section): ?>
                <option value="<?= htmlspecialchars($section['section_id']) ?>">
                  <?= htmlspecialchars($section['section_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Location Name <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="location_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sub Location</label>
            <input
              type="text"
              name="sub_location"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Make <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="make"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Model <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="model"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type <span class="text-red-500">*</span></label>
            <select
              name="device_type"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="">Select Type</option>
              <option value="finger">Finger</option>
              <option value="finger_palm">Finger, Palm</option>
              <option value="finger_face">Finger, Face</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device No <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="device_number"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Identification Code (Serial No) <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="identification_code"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">IP Address / ADSL</label>
            <input
              type="text"
              name="ip_address_adsl"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Installed Date</label>
            <input
              type="date"
              name="installed_date"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
            <input
              type="text"
              name="company_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device Cost</label>
            <input
              type="number"
              step="0.01"
              name="device_cost"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Warranty Period</label>
            <input
              type="text"
              name="warranty_period"
              placeholder="e.g., 2 years"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Port No</label>
            <input
              type="text"
              name="port_number"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Managed By</label>
            <input
              type="text"
              name="managed_by"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
            <input
              type="text"
              name="assigned_to"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Approval Status</label>
            <select
              name="approval_status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="pending" selected>Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>

          <div class="md:col-span-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
            <textarea
              name="remark"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              name="status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="active" selected>Active</option>
              <option value="inactive">Inactive</option>
              <option value="under_repair">Under Repair</option>
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
            <i class="fas fa-save mr-2"></i>Save Device
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Finger Device Modal -->
  <div
    id="editModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Edit Finger Device</h3>
          <button
            onclick="closeEditModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form action="./admin/handlers/finger-device-handler.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="device_id" id="edit_device_id">
        <input type="hidden" name="category_id" value="<?= htmlspecialchars($fingerDeviceCategoryId) ?>">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- WSS (Water Supply Scheme) -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">WSS Code <span class="text-red-500">*</span></label>
            <select
              name="wss_id"
              id="edit_wss_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required>
              <option value="">Select WSS</option>
              <?php foreach ($waterSupplySchemes as $wss): ?>
                <option value="<?= htmlspecialchars($wss['wss_id']) ?>">
                  <?= htmlspecialchars($wss['wss_code']) ?> - <?= htmlspecialchars($wss['wss_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Section -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
            <select
              name="section_id"
              id="edit_section_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Select Section</option>
              <?php foreach ($sections as $section): ?>
                <option value="<?= htmlspecialchars($section['section_id']) ?>">
                  <?= htmlspecialchars($section['section_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Location Name <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="location_name"
              id="edit_location_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sub Location</label>
            <input
              type="text"
              name="sub_location"
              id="edit_sub_location"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Make <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="make"
              id="edit_make"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Model <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="model"
              id="edit_model"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type <span class="text-red-500">*</span></label>
            <select
              name="device_type"
              id="edit_device_type"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required>
              <option value="">Select Type</option>
              <option value="finger">Finger</option>
              <option value="finger_palm">Finger, Palm</option>
              <option value="finger_face">Finger, Face</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device No <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="device_number"
              id="edit_device_number"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Identification Code (Serial No) <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="identification_code"
              id="edit_identification_code"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">IP Address / ADSL</label>
            <input
              type="text"
              name="ip_address_adsl"
              id="edit_ip_address_adsl"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Installed Date</label>
            <input
              type="date"
              name="installed_date"
              id="edit_installed_date"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
            <input
              type="text"
              name="company_name"
              id="edit_company_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device Cost</label>
            <input
              type="number"
              step="0.01"
              name="device_cost"
              id="edit_device_cost"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Warranty Period</label>
            <input
              type="text"
              name="warranty_period"
              id="edit_warranty_period"
              placeholder="e.g., 2 years"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Port No</label>
            <input
              type="text"
              name="port_number"
              id="edit_port_number"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Managed By</label>
            <input
              type="text"
              name="managed_by"
              id="edit_managed_by"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
            <input
              type="text"
              name="assigned_to"
              id="edit_assigned_to"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Approval Status</label>
            <select
              name="approval_status"
              id="edit_approval_status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>

          <div class="md:col-span-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
            <textarea
              name="remark"
              id="edit_remark"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              name="status"
              id="edit_status"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="under_repair">Under Repair</option>
            </select>
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
            <i class="fas fa-save mr-2"></i>Update Device
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
      <div
        class="bg-gradient-to-r from-red-600 to-rose-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Confirm Deletion</h3>
          <button
            onclick="closeDeleteModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form action="./admin/handlers/finger-device-handler.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="device_id" id="delete_device_id">

        <div class="text-center mb-6">
          <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
          </div>
          <p class="text-lg text-gray-700 mb-2">Are you sure you want to delete this device?</p>
          <p class="text-gray-600"><strong id="delete_device_name"></strong></p>
          <p class="text-sm text-red-600 mt-2">This action cannot be undone.</p>
        </div>

        <div class="flex gap-3 justify-end">
          <button
            type="button"
            onclick="closeDeleteModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg hover:from-red-700 hover:to-rose-700 transition-all">
            <i class="fas fa-trash mr-2"></i>Delete Device
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

    function openEditModal(device) {
      // Populate form fields
      document.getElementById('edit_device_id').value = device.device_id;
      document.getElementById('edit_wss_id').value = device.wss_id || '';
      document.getElementById('edit_section_id').value = device.section_id || '';
      document.getElementById('edit_location_name').value = device.location_name || '';
      document.getElementById('edit_sub_location').value = device.sub_location || '';
      document.getElementById('edit_make').value = device.make || '';
      document.getElementById('edit_model').value = device.model || '';
      document.getElementById('edit_device_type').value = device.device_type || '';
      document.getElementById('edit_device_number').value = device.device_number || '';
      document.getElementById('edit_identification_code').value = device.identification_code || '';
      document.getElementById('edit_ip_address_adsl').value = device.ip_address_adsl || '';
      document.getElementById('edit_installed_date').value = device.installed_date || '';
      document.getElementById('edit_company_name').value = device.company_name || '';
      document.getElementById('edit_device_cost').value = device.device_cost || '';
      document.getElementById('edit_warranty_period').value = device.warranty_period || '';
      document.getElementById('edit_port_number').value = device.port_number || '';
      document.getElementById('edit_managed_by').value = device.managed_by || '';
      document.getElementById('edit_assigned_to').value = device.assigned_to || '';
      document.getElementById('edit_approval_status').value = device.approval_status || 'pending';
      document.getElementById('edit_remark').value = device.remark || '';
      document.getElementById('edit_status').value = device.status || 'active';

      // Show modal
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function confirmDelete(deviceId, deviceName) {
      document.getElementById('delete_device_id').value = deviceId;
      document.getElementById('delete_device_name').textContent = deviceName;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modal on outside click
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