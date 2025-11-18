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

// Fetch sections data
$sections = DbHelper::getAllSections();
$totalSections = count($sections);
$waterSchemes = DbHelper::getAllWaterSupplySchemes(); // For dropdown

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Section Management</title>
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

    <div class="p-6 space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
          <i class="fas fa-sitemap text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1"><?php echo $totalSections; ?></h3>
          <p class="text-blue-100 text-sm">Total Sections</p>
        </div>
        <div
          class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
          <i class="fas fa-users text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1"><?php echo count(DbHelper::getAllUsers()); ?></h3>
          <p class="text-green-100 text-sm">Total Users</p>
        </div>
        <div
          class="stat-card bg-gradient-to-br from-sky-500 to-sky-600 rounded-2xl p-6 text-white shadow-lg">
          <i class="fas fa-laptop-house text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1">120</h3>
          <p class="text-sky-100 text-sm">Assigned Devices</p>
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
          Add New Section
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

      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
              <tr>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Section Name
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Water Supply Scheme
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
              <?php if (!empty($sections)): ?>
                <?php foreach ($sections as $section): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4 font-semibold text-gray-900">
                      <?php echo htmlspecialchars($section['section_name']); ?>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                      <?php echo htmlspecialchars($section['wss_name']); ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                      <?php echo date('M d, Y', strtotime($section['created_at'])); ?>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                      <button onclick='openEditModal(<?php echo json_encode($section); ?>)' class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button onclick="confirmDelete(<?php echo $section['section_id']; ?>, '<?php echo htmlspecialchars($section['section_name']); ?>')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p class="text-lg font-medium">No sections found</p>
                    <p class="text-sm">Click "Add New Computer" to create your first section</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Add Section Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">
            <i class="fas fa-map-marked-alt mr-2"></i>Add New Section
          </h3>
          <button
            onclick="closeAddModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form method="POST" action="handlers/section-handler.php" class="p-6">
        <input type="hidden" name="action" value="create">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Water Supply Scheme <span class="text-red-500">*</span>
            </label>
            <select
              name="wss_id"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Water Supply Scheme</option>
              <?php foreach ($waterSchemes as $scheme): ?>
                <option value="<?php echo $scheme['wss_id']; ?>">
                  <?php echo htmlspecialchars($scheme['wss_name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Section Name <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              name="section_name"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., Colombo Section A" />
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
            <i class="fas fa-save mr-2"></i>Save Section
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Section Modal -->
  <div
    id="editModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">
            <i class="fas fa-edit mr-2"></i>Edit Section
          </h3>
          <button
            onclick="closeEditModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form method="POST" action="handlers/section-handler.php" class="p-6">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="section_id" id="edit_section_id">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Water Supply Scheme <span class="text-red-500">*</span>
            </label>
            <select
              name="wss_id"
              id="edit_wss_id"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Select Water Supply Scheme</option>
              <?php foreach ($waterSchemes as $scheme): ?>
                <option value="<?php echo $scheme['wss_id']; ?>">
                  <?php echo htmlspecialchars($scheme['wss_name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Section Name <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              name="section_name"
              id="edit_section_name"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
              placeholder="e.g., Colombo Section A" />
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
            <i class="fas fa-save mr-2"></i>Update Section
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

      <form method="POST" action="handlers/section-handler.php" class="p-6">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="section_id" id="delete_section_id">

        <div class="mb-6">
          <p class="text-gray-700 mb-4">
            Are you sure you want to delete the section
            <strong class="text-red-600" id="delete_section_name"></strong>?
          </p>
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex">
              <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  <strong>Warning:</strong> This action cannot be undone.
                  It will also delete all devices associated with this section.
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

    function openEditModal(section) {
      document.getElementById('edit_section_id').value = section.section_id;
      document.getElementById('edit_wss_id').value = section.wss_id;
      document.getElementById('edit_section_name').value = section.section_name;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
      document.querySelector('#editModal form').reset();
    }

    function confirmDelete(sectionId, sectionName) {
      document.getElementById('delete_section_id').value = sectionId;
      document.getElementById('delete_section_name').textContent = sectionName;
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