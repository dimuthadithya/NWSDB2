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

// Fetch categories data
$categories = DbHelper::getAllDeviceCategories();
$totalCategories = count($categories);

// Get total devices count
$totalDevices = DbHelper::getRowCount('devices');

// Define protected system categories
$protectedCategories = ['Desktop Computer', 'Laptop', 'Printer', 'Fingerprint Device', 'RVPN Device'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Category Management</title>
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

    .category-card {
      transition: all 0.3s ease;
    }

    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
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
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.1s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-tags text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $totalCategories; ?></h3>
          <p class="text-blue-100 text-sm">Total Categories</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.2s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-desktop text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Devices</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo number_format($totalDevices); ?></h3>
          <p class="text-green-100 text-sm">Total Devices</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-star text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Popular</span>
          </div>
          <h3 class="text-3xl font-bold mb-1">Computer</h3>
          <p class="text-orange-100 text-sm">Most Used Category</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.4s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-plus-circle text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">New</span>
          </div>
          <h3 class="text-3xl font-bold mb-1">3</h3>
          <p class="text-purple-100 text-sm">Added This Month</p>
        </div>
      </div>

      <!-- Success Message -->
      <?php if (!empty($successMessage)): ?>
        <div id="successMessage" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center">
          <i class="fas fa-check-circle text-green-500 mr-3"></i>
          <span><?php echo htmlspecialchars($successMessage); ?></span>
        </div>
      <?php endif; ?>

      <!-- Error Message -->
      <?php if (!empty($errorMessage)): ?>
        <div id="errorMessage" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
          <span><?php echo htmlspecialchars($errorMessage); ?></span>
        </div>
      <?php endif; ?>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Category
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

      <!-- Category Cards Grid -->
      <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php if (!empty($categories)): ?>
          <?php
          $icons = [
            'Computer' => 'fa-desktop',
            'Printer' => 'fa-print',
            'Laptop' => 'fa-laptop',
            'RVPN Connection' => 'fa-network-wired',
            'Finger Device' => 'fa-fingerprint',
            'Scanner' => 'fa-scanner',
            'UPS' => 'fa-battery-full',
            'Other' => 'fa-microchip'
          ];
          $colors = [
            'Computer' => 'blue',
            'Printer' => 'green',
            'Laptop' => 'purple',
            'RVPN Connection' => 'cyan',
            'Finger Device' => 'orange',
            'Scanner' => 'pink',
            'UPS' => 'yellow',
            'Other' => 'gray'
          ];
          ?>
          <?php foreach ($categories as $category): ?>
            <?php
            $categoryName = $category['category_name'];
            $icon = $icons[$categoryName] ?? 'fa-tag';
            $color = $colors[$categoryName] ?? 'indigo';
            $isProtected = in_array($categoryName, $protectedCategories);
            ?>
            <div class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
              <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $color; ?>-500 to-<?php echo $color; ?>-600 rounded-xl flex items-center justify-center">
                  <i class="fas <?php echo $icon; ?> text-white text-2xl"></i>
                </div>
                <div class="flex gap-2">
                  <?php if ($isProtected): ?>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-semibold flex items-center gap-1" title="System category - Cannot be modified or deleted">
                      <i class="fas fa-shield-alt"></i>
                      Protected
                    </span>
                  <?php else: ?>
                    <button onclick='openEditModal(<?php echo json_encode($category); ?>)' class="text-green-600 hover:text-green-800" title="Edit">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="confirmDelete(<?php echo $category['category_id']; ?>, '<?php echo htmlspecialchars($categoryName); ?>')" class="text-red-600 hover:text-red-800" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  <?php endif; ?>
                </div>
              </div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">
                <?php echo htmlspecialchars($categoryName); ?>
                <?php if ($isProtected): ?>
                  <i class="fas fa-lock text-blue-500 text-xs ml-1" title="System category"></i>
                <?php endif; ?>
              </h3>
              <p class="text-sm text-gray-600 mb-4"><?php echo htmlspecialchars($category['description'] ?? 'No description'); ?></p>
              <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-500">Created</span>
                <span class="text-sm font-semibold text-<?php echo $color; ?>-600">
                  <?php echo date('M d, Y', strtotime($category['created_at'])); ?>
                </span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-span-full text-center py-12">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-lg font-medium text-gray-500">No categories found</p>
            <p class="text-sm text-gray-400">Click "Add New Category" to create your first category</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <!-- Add Category Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Add New Category</h3>
          <button
            onclick="closeAddModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form method="POST" action="handlers/category-handler.php" class="p-6">
        <input type="hidden" name="action" value="create">
        <div class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="category_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., Computer, Printer, Scanner"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea
              name="description"
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter category description..."></textarea>
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
            <i class="fas fa-save mr-2"></i>Save Category
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Category Modal -->
  <div
    id="editModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">
            <i class="fas fa-edit mr-2"></i>Edit Category
          </h3>
          <button
            onclick="closeEditModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form method="POST" action="handlers/category-handler.php" class="p-6">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="category_id" id="edit_category_id">

        <!-- Protected Category Warning -->
        <div id="edit_protected_warning" class="hidden mb-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
          <div class="flex">
            <div class="flex-shrink-0">
              <i class="fas fa-shield-alt text-blue-400"></i>
            </div>
            <div class="ml-3">
              <p class="text-sm text-blue-700">
                <strong>Protected System Category:</strong> The category name cannot be changed as it is required by the system. You can only update the description.
              </p>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
            <input
              type="text"
              name="category_name"
              id="edit_category_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              placeholder="e.g., Computer, Printer, Scanner"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea
              name="description"
              id="edit_description"
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              placeholder="Enter category description..."></textarea>
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
            class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all">
            <i class="fas fa-save mr-2"></i>Update Category
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
          <h3 class="text-xl font-bold text-white">
            <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Deletion
          </h3>
          <button
            onclick="closeDeleteModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form method="POST" action="handlers/category-handler.php" class="p-6">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="category_id" id="delete_category_id">

        <div class="mb-6">
          <p class="text-gray-700 mb-4">
            Are you sure you want to delete the category
            <strong class="text-red-600" id="delete_category_name"></strong>?
          </p>
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex">
              <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  <strong>Warning:</strong> This action cannot be undone.
                  It will also affect all devices associated with this category.
                </p>
              </div>
            </div>
          </div>
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
            class="px-6 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg hover:from-red-700 hover:to-rose-700 transition-all">
            <i class="fas fa-trash mr-2"></i>Delete
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
      document.querySelector('#addModal form').reset();
    }

    function openEditModal(category) {
      // Protected categories list
      const protectedCategories = ['Desktop Computer', 'Laptop', 'Printer', 'Fingerprint Device', 'RVPN Device'];
      const isProtected = protectedCategories.includes(category.category_name);

      document.getElementById('edit_category_id').value = category.category_id;
      document.getElementById('edit_category_name').value = category.category_name;
      document.getElementById('edit_description').value = category.description || '';

      // Disable category name field for protected categories
      const categoryNameField = document.getElementById('edit_category_name');
      const warningDiv = document.getElementById('edit_protected_warning');

      if (isProtected) {
        categoryNameField.disabled = true;
        categoryNameField.classList.add('bg-gray-100', 'cursor-not-allowed');
        categoryNameField.title = 'System category name cannot be changed';
        if (warningDiv) {
          warningDiv.classList.remove('hidden');
        }
      } else {
        categoryNameField.disabled = false;
        categoryNameField.classList.remove('bg-gray-100', 'cursor-not-allowed');
        categoryNameField.title = '';
        if (warningDiv) {
          warningDiv.classList.add('hidden');
        }
      }

      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
      document.querySelector('#editModal form').reset();
    }

    function confirmDelete(categoryId, categoryName) {
      document.getElementById('delete_category_id').value = categoryId;
      document.getElementById('delete_category_name').textContent = categoryName;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modals on outside click
    document.getElementById('addModal').addEventListener('click', function(e) {
      if (e.target === this) closeAddModal();
    });

    document.getElementById('editModal').addEventListener('click', function(e) {
      if (e.target === this) closeEditModal();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) closeDeleteModal();
    });

    // ESC key to close modals
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAddModal();
        closeEditModal();
        closeDeleteModal();
      }
    });

    // Auto-hide success/error messages
    setTimeout(function() {
      const successMsg = document.getElementById('successMessage');
      const errorMsg = document.getElementById('errorMessage');
      if (successMsg) successMsg.style.display = 'none';
      if (errorMsg) errorMsg.style.display = 'none';
    }, 5000);
  </script>
</body>

</html>