<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch RVPN connections from database
$allConnections = DbHelper::getAllRVPNConnections();
$totalConnections = $allConnections ? count($allConnections) : 0;
$sections = DbHelper::getAllSections();
$waterSupplySchemes = DbHelper::getAllWaterSupplySchemes();
$categories = DbHelper::getAllDeviceCategories();

if (!$allConnections) {
  $allConnections = [];
}

// Get RVPN category ID
$rvpnCategoryId = null;
foreach ($categories as $category) {
  if ($category['category_name'] === 'RVPN Device') {
    $rvpnCategoryId = $category['category_id'];
    break;
  }
}

// Calculate statistics
$activeConnections = count(array_filter($allConnections, function ($conn) {
  return $conn['status'] === 'active';
}));
$inactiveConnections = $totalConnections - $activeConnections;
$totalUsers = $totalConnections; // Each connection represents a user

// Pagination Logic
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$totalPages = ceil($totalConnections / $limit);

// Ensure page is valid
if ($page < 1) $page = 1;
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;

$rvpnConnections = array_slice($allConnections, $offset, $limit);

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
      <!-- Success/Error Messages -->
      <?php if (isset($_SESSION['success_message'])): ?>
        <div id="successMessage" class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <p class="text-green-700 font-medium"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
          </div>
        </div>
        <?php unset($_SESSION['success_message']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error_message'])): ?>
        <div id="errorMessage" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
            <p class="text-red-700 font-medium"><?= htmlspecialchars($_SESSION['error_message']) ?></p>
          </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
      <?php endif; ?>
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
                      <button onclick="openEditModal(<?= htmlspecialchars(json_encode($conn)) ?>)" class="text-green-600 hover:text-green-900 mr-3" title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button onclick="confirmDelete(<?= $conn['device_id'] ?>, '<?= htmlspecialchars($conn['device_name'], ENT_QUOTES) ?>')" class="text-red-600 hover:text-red-900" title="Delete">
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
        <?php if ($totalConnections > 0): ?>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing <span class="font-medium"><?php echo $offset + 1; ?></span> to
              <span class="font-medium"><?php echo min($offset + $limit, $totalConnections); ?></span> of
              <span class="font-medium"><?php echo $totalConnections; ?></span> results
            </div>
            <div class="flex gap-2">
              <!-- Previous Button -->
              <a href="?page=<?php echo max(1, $page - 1); ?>"
                 class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 <?php echo $page <= 1 ? 'pointer-events-none opacity-50' : ''; ?>">
                Previous
              </a>

              <!-- Page Numbers -->
              <?php
              $startPage = max(1, $page - 2);
              $endPage = min($totalPages, $page + 2);

              if ($startPage > 1) {
                  echo '<a href="?page=1" class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50">1</a>';
                  if ($startPage > 2) echo '<span class="px-2">...</span>';
              }

              for ($i = $startPage; $i <= $endPage; $i++):
              ?>
                <a href="?page=<?php echo $i; ?>"
                   class="px-3 py-1 border <?php echo $i === $page ? 'border-blue-500 bg-blue-500 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'; ?> rounded-lg">
                  <?php echo $i; ?>
                </a>
              <?php endfor; ?>

              <?php
              if ($endPage < $totalPages) {
                  if ($endPage < $totalPages - 1) echo '<span class="px-2">...</span>';
                  echo '<a href="?page=' . $totalPages . '" class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50">' . $totalPages . '</a>';
              }
              ?>

              <!-- Next Button -->
              <a href="?page=<?php echo min($totalPages, $page + 1); ?>"
                 class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 <?php echo $page >= $totalPages ? 'pointer-events-none opacity-50' : ''; ?>">
                Next
              </a>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <!-- Add RVPN Connection Modal -->
  <div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
      <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Add New RVPN Connection</h3>
          <button onclick="closeAddModal()" class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form id="addRvpnForm" method="POST" action="admin/handlers/rvpn-handler.php" class="p-6">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="category_id" value="<?= $rvpnCategoryId ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Name of RVPN User *</label>
            <input type="text" name="device_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Employee Number *</label>
            <input type="text" name="employee_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Designation *</label>
            <input type="text" name="designation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Working Location *</label>
            <input type="text" name="working_location" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cost Code</label>
            <input type="text" name="cost_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number *</label>
            <input type="text" name="rvpn_serial_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
            <input type="text" name="rvpn_username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pin No.</label>
            <input type="text" name="pin_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">WSS *</label>
            <select name="wss_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select WSS</option>
              <?php if ($waterSupplySchemes): ?>
                <?php foreach ($waterSupplySchemes as $wss): ?>
                  <option value="<?= $wss['wss_id'] ?>"><?= htmlspecialchars($wss['wss_name']) ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
            <select name="section_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Section</option>
              <?php if ($sections): ?>
                <?php foreach ($sections as $section): ?>
                  <option value="<?= $section['section_id'] ?>"><?= htmlspecialchars($section['section_name']) ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Required Status</label>
            <select name="connection_required" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="required">Required</option>
              <option value="not_required">Not Required</option>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="active">Active</option>
              <option value="under_repair">Under Repair</option>
              <option value="retired">Retired</option>
              <option value="lost">Lost</option>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
          </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
          <button type="button" onclick="closeAddModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
            <i class="fas fa-save mr-2"></i>Save Connection
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit RVPN Connection Modal -->
  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
      <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Edit RVPN Connection</h3>
          <button onclick="closeEditModal()" class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form id="editRvpnForm" method="POST" action="admin/handlers/rvpn-handler.php" class="p-6">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="device_id" id="edit_device_id">
        <input type="hidden" name="category_id" value="<?= $rvpnCategoryId ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Name of RVPN User *</label>
            <input type="text" name="device_name" id="edit_device_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Employee Number *</label>
            <input type="text" name="employee_number" id="edit_employee_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Designation *</label>
            <input type="text" name="designation" id="edit_designation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Working Location *</label>
            <input type="text" name="working_location" id="edit_working_location" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cost Code</label>
            <input type="text" name="cost_code" id="edit_cost_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number *</label>
            <input type="text" name="rvpn_serial_number" id="edit_rvpn_serial_number" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
            <input type="text" name="rvpn_username" id="edit_rvpn_username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pin No.</label>
            <input type="text" name="pin_number" id="edit_pin_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">WSS *</label>
            <select name="wss_id" id="edit_wss_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Select WSS</option>
              <?php if ($waterSupplySchemes): ?>
                <?php foreach ($waterSupplySchemes as $wss): ?>
                  <option value="<?= $wss['wss_id'] ?>"><?= htmlspecialchars($wss['wss_name']) ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
            <select name="section_id" id="edit_section_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Select Section</option>
              <?php if ($sections): ?>
                <?php foreach ($sections as $section): ?>
                  <option value="<?= $section['section_id'] ?>"><?= htmlspecialchars($section['section_name']) ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Required Status</label>
            <select name="connection_required" id="edit_connection_required" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="required">Required</option>
              <option value="not_required">Not Required</option>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="edit_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="active">Active</option>
              <option value="under_repair">Under Repair</option>
              <option value="retired">Retired</option>
              <option value="lost">Lost</option>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" id="edit_notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
          </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
          <button type="button" onclick="closeEditModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button type="submit" class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all">
            <i class="fas fa-save mr-2"></i>Update Connection
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full" onclick="event.stopPropagation()">
      <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Delete RVPN Connection</h3>
          <button onclick="closeDeleteModal()" class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <div class="p-6">
        <div class="mb-6">
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex">
              <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-3"></i>
              <div>
                <h4 class="text-red-800 font-medium mb-1">Warning: This action cannot be undone</h4>
                <p class="text-red-700 text-sm">Are you sure you want to delete this RVPN connection?</p>
              </div>
            </div>
          </div>
        </div>

        <form id="deleteRvpnForm" method="POST" action="admin/handlers/rvpn-handler.php">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="device_id" id="delete_device_id">

          <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-600 mb-2">User Name:</p>
            <p class="font-semibold text-gray-900" id="delete_user_name"></p>
          </div>

          <div class="flex items-center justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
              <i class="fas fa-times mr-2"></i>Cancel
            </button>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-lg hover:from-red-700 hover:to-pink-700 transition-all">
              <i class="fas fa-trash mr-2"></i>Delete Connection
            </button>
          </div>
        </form>
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

    // Add Modal functions
    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
      document.getElementById('addRvpnForm').reset();
      document.body.style.overflow = 'auto';
    }

    // Edit Modal functions
    function openEditModal(conn) {
      document.getElementById('edit_device_id').value = conn.device_id;
      document.getElementById('edit_device_name').value = conn.device_name || '';
      document.getElementById('edit_employee_number').value = conn.employee_number || '';
      document.getElementById('edit_designation').value = conn.designation || '';
      document.getElementById('edit_working_location').value = conn.working_location || '';
      document.getElementById('edit_cost_code').value = conn.cost_code || '';
      document.getElementById('edit_rvpn_serial_number').value = conn.rvpn_serial_number || '';
      document.getElementById('edit_rvpn_username').value = conn.rvpn_username || '';
      document.getElementById('edit_pin_number').value = conn.pin_number || '';
      document.getElementById('edit_wss_id').value = conn.wss_id || '';
      document.getElementById('edit_section_id').value = conn.section_id || '';
      document.getElementById('edit_connection_required').value = conn.connection_required || 'not_required';
      document.getElementById('edit_status').value = conn.status || 'active';
      document.getElementById('edit_notes').value = conn.notes || '';

      document.getElementById('editModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
      document.getElementById('editRvpnForm').reset();
      document.body.style.overflow = 'auto';
    }

    // Delete Modal functions
    function confirmDelete(deviceId, deviceName) {
      document.getElementById('delete_device_id').value = deviceId;
      document.getElementById('delete_user_name').textContent = deviceName;
      document.getElementById('deleteModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    // Close modals on background click
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
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeAddModal();
        closeEditModal();
        closeDeleteModal();
      }
    });
  </script>
</body>

</html>