<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

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

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddComputerModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Sections
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
                  WSS ID
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
                      <?php echo htmlspecialchars($section['wss_id']); ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                      <?php echo date('M d, Y', strtotime($section['created_at'])); ?>
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

  <div
    id="addSectionModal"
    class="hidden fixed inset-0 z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl">
      <div class="flex items-center justify-between p-6 border-b">
        <h3 class="text-xl font-bold text-gray-900">Add New Section</h3>
        <button
          onclick="closeAddSectionModal()"
          class="text-gray-400 hover:text-gray-600">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>
      <div class="p-6">
        <form id="addSectionForm" class="space-y-4">
          <input
            type="text"
            placeholder="Section Name"
            class="w-full px-4 py-2.5 rounded-lg border" />
          <input
            type="text"
            placeholder="Head of Section"
            class="w-full px-4 py-2.5 rounded-lg border" />
        </form>
      </div>
      <div
        class="flex items-center justify-end gap-3 p-6 border-t bg-gray-50">
        <button
          onclick="closeAddSectionModal()"
          class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border rounded-lg">
          Cancel
        </button>
        <button
          type="submit"
          form="addSectionForm"
          class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg">
          Save Section
        </button>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
      document
        .getElementById('sidebar')
        .classList.toggle('-translate-x-full');
    });

    function openAddSectionModal() {
      document.getElementById('addSectionModal').classList.remove('hidden');
    }

    function closeAddSectionModal() {
      document.getElementById('addSectionModal').classList.add('hidden');
    }
  </script>
</body>

</html>