<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Handle success/error messages
$successMessage = '';
$errorMessage = '';

if (isset($_SESSION['success_message'])) {
  $successMessage = $_SESSION['success_message'];
  unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
  $errorMessage = $_SESSION['error_message'];
  unset($_SESSION['error_message']);
}

// Fetch regions data
$allRegions = DbHelper::getAllRegions();
$totalRegions = count($allRegions);

// Pagination Logic
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$totalPages = ceil($totalRegions / $limit);

// Ensure page is valid
if ($page < 1) $page = 1;
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;

$regions = array_slice($allRegions, $offset, $limit);
$totalRegions = DbHelper::getRegionCount();
$activeRegions = DbHelper::getActiveRegionCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Regional Management</title>
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
            <i class="fas fa-globe-asia text-2xl"></i>
          </div>
          <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?php echo $totalRegions; ?></h3>
        <p class="text-blue-100 text-sm">Total Regions</p>
      </div>

      <div
        class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
        <div class="flex items-center justify-between mb-4">
          <div
            class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
            <i class="fas fa-check-circle text-2xl"></i>
          </div>
          <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Active</span>
        </div>
        <h3 class="text-3xl font-bold mb-1"><?php echo $activeRegions; ?></h3>
        <p class="text-green-100 text-sm">Active Regions</p>
      </div>

      <div
        class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
        <div class="flex items-center justify-between mb-4">
          <div
            class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
            <i class="fas fa-map-marked-alt text-2xl"></i>
          </div>
          <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Coverage</span>
        </div>
        <h3 class="text-3xl font-bold mb-1">45</h3>
        <p class="text-orange-100 text-sm">Total Areas</p>
      </div>

      <div
        class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
        <div class="flex items-center justify-between mb-4">
          <div
            class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
            <i class="fas fa-users text-2xl"></i>
          </div>
          <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Managers</span>
        </div>
        <h3 class="text-3xl font-bold mb-1">9</h3>
        <p class="text-purple-100 text-sm">Regional Managers</p>
      </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if ($successMessage): ?>
      <div id="successMessage" class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm animate-fade-up">
        <div class="flex items-center">
          <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
          <p class="text-green-700 font-medium"><?php echo htmlspecialchars($successMessage); ?></p>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
      <div id="errorMessage" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-up">
        <div class="flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
          <p class="text-red-700 font-medium"><?php echo htmlspecialchars($errorMessage); ?></p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-3">
      <button
        onclick="openAddModal()"
        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
        <i class="fas fa-plus mr-2"></i>
        Add New Region
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
            placeholder="Search regions..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
        </div>
        <select
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <option>All Provinces</option>
          <option>Western Province</option>
          <option>Central Province</option>
          <option>Southern Province</option>
          <option>Northern Province</option>
          <option>Eastern Province</option>
          <option>North Western Province</option>
          <option>North Central Province</option>
          <option>Uva Province</option>
          <option>Sabaragamuwa Province</option>
        </select>
        <select
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <option>All Status</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
    </div>

    <!-- Regions Table -->
    <div
      class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
            <tr>
              <th
                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                Region Code
              </th>
              <th
                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                Region Name
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
            <?php if (!empty($regions)): ?>
              <?php foreach ($regions as $region): ?>
                <tr class="table-row">
                  <td class="px-6 py-4">
                    <span class="font-mono text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($region['region_code']); ?></span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-semibold text-gray-900"><?php echo htmlspecialchars($region['region_name']); ?></div>
                  </td>
                  <td class="px-6 py-4">
                    <?php if ($region['status'] === 'active'): ?>
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    <?php else: ?>
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">
                    <?php echo date('M d, Y', strtotime($region['created_at'])); ?>
                  </td>
                  <td class="px-6 py-4 text-right space-x-2">
                    <button
                      onclick='openEditModal(<?php echo json_encode($region); ?>)'
                      class="p-2 text-green-600 hover:bg-green-50 rounded-lg"
                      title="Edit">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button
                      onclick="confirmDelete(<?php echo $region['region_id']; ?>, '<?php echo htmlspecialchars($region['region_name']); ?>')"
                      class="p-2 text-red-600 hover:bg-red-50 rounded-lg"
                      title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                  <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                  <p class="text-lg font-medium">No regions found</p>
                  <p class="text-sm">Click "Add Region" to create your first region</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if ($totalRegions > 0): ?>
      <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-600">
            Showing <span class="font-medium"><?php echo $offset + 1; ?></span> to
            <span class="font-medium"><?php echo min($offset + $limit, $totalRegions); ?></span> of
            <span class="font-medium"><?php echo $totalRegions; ?></span> entries
        </div>
        <div class="flex gap-2">
           <!-- Previous Button -->
           <a href="?page=<?php echo max(1, $page - 1); ?>"
             class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100 <?php echo $page <= 1 ? 'pointer-events-none opacity-50' : ''; ?>">
             Previous
           </a>

           <!-- Page Numbers -->
           <?php
           $startPage = max(1, $page - 2);
           $endPage = min($totalPages, $page + 2);

           if ($startPage > 1) {
               echo '<a href="?page=1" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100">1</a>';
               if ($startPage > 2) echo '<span class="px-2">...</span>';
           }

           for ($i = $startPage; $i <= $endPage; $i++):
           ?>
             <a href="?page=<?php echo $i; ?>"
                class="px-4 py-2 border <?php echo $i === $page ? 'bg-blue-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-100'; ?> rounded-lg text-sm">
               <?php echo $i; ?>
             </a>
           <?php endfor; ?>

           <?php
           if ($endPage < $totalPages) {
               if ($endPage < $totalPages - 1) echo '<span class="px-2">...</span>';
               echo '<a href="?page=' . $totalPages . '" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100">' . $totalPages . '</a>';
           }
           ?>

           <!-- Next Button -->
           <a href="?page=<?php echo min($totalPages, $page + 1); ?>"
             class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-100 <?php echo $page >= $totalPages ? 'pointer-events-none opacity-50' : ''; ?>">
             Next
           </a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- Add Region Modal -->
<div
  id="addModal"
  class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
  <div
    class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
    <div
      class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
      <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-white">
          <i class="fas fa-globe-asia mr-2"></i>Add New Region
        </h3>
        <button
          onclick="closeAddModal()"
          class="text-white hover:text-gray-200 transition-colors">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>
    </div>

    <form id="addRegionForm" method="POST" action="handlers/region-handler.php" class="p-6">
      <input type="hidden" name="action" value="create">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Region Code <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            name="region_code"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="e.g., WR001" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Region Name <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            name="region_name"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="e.g., Western Region" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Status
          </label>
          <select
            name="status"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
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
          <i class="fas fa-save mr-2"></i>Save Region
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Region Modal -->
<div
  id="editModal"
  class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
  <div
    class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
    <div
      class="sticky top-0 bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4 rounded-t-2xl">
      <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-white">
          <i class="fas fa-edit mr-2"></i>Edit Region
        </h3>
        <button
          onclick="closeEditModal()"
          class="text-white hover:text-gray-200 transition-colors">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>
    </div>

    <form id="editRegionForm" method="POST" action="handlers/region-handler.php" class="p-6">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="region_id" id="edit_region_id">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Region Code <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            name="region_code"
            id="edit_region_code"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            placeholder="e.g., WR001" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Region Name <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            name="region_name"
            id="edit_region_name"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            placeholder="e.g., Western Region" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Status
          </label>
          <select
            name="status"
            id="edit_status"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>

      <div class="mt-6 flex gap-3 justify-end">
        <button
          type="button"
          onclick="closeEditModal()"
          class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button
          type="submit"
          class="px-6 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:from-green-700 hover:to-teal-700 transition-all">
          <i class="fas fa-save mr-2"></i>Update Region
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
    <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4 rounded-t-2xl">
      <h3 class="text-xl font-bold text-white">
        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
      </h3>
    </div>

    <form id="deleteRegionForm" method="POST" action="handlers/region-handler.php" class="p-6">
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="region_id" id="delete_region_id">

      <div class="mb-6">
        <p class="text-gray-700 mb-2">Are you sure you want to delete this region?</p>
        <p class="text-lg font-semibold text-gray-900" id="delete_region_name"></p>
        <p class="text-sm text-red-600 mt-2">
          <i class="fas fa-exclamation-circle mr-1"></i>
          This action cannot be undone. All associated areas will be affected.
        </p>
      </div>

      <div class="flex gap-3 justify-end">
        <button
          type="button"
          onclick="closeDeleteModal()"
          class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button
          type="submit"
          class="px-6 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-lg hover:from-red-700 hover:to-pink-700 transition-all">
          <i class="fas fa-trash mr-2"></i>Delete Region
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // Auto-hide success/error messages after 5 seconds
  setTimeout(() => {
    const successMsg = document.getElementById('successMessage');
    const errorMsg = document.getElementById('errorMessage');
    if (successMsg) {
      successMsg.style.transition = 'opacity 0.5s';
      successMsg.style.opacity = '0';
      setTimeout(() => successMsg.remove(), 500);
    }
    if (errorMsg) {
      errorMsg.style.transition = 'opacity 0.5s';
      errorMsg.style.opacity = '0';
      setTimeout(() => errorMsg.remove(), 500);
    }
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
  }

  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addRegionForm').reset();
  }

  // Edit Modal functions
  function openEditModal(region) {
    document.getElementById('edit_region_id').value = region.region_id;
    document.getElementById('edit_region_code').value = region.region_code;
    document.getElementById('edit_region_name').value = region.region_name;
    document.getElementById('edit_status').value = region.status;
    document.getElementById('editModal').classList.remove('hidden');
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editRegionForm').reset();
  }

  // Delete Modal functions
  function confirmDelete(regionId, regionName) {
    document.getElementById('delete_region_id').value = regionId;
    document.getElementById('delete_region_name').textContent = regionName;
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
</script>
</body>

</html>