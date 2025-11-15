<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

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
          <h3 class="text-3xl font-bold mb-1">67</h3>
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
          <h3 class="text-3xl font-bold mb-1">62</h3>
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
          <h3 class="text-3xl font-bold mb-1">24</h3>
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
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Warranty</span>
          </div>
          <h3 class="text-3xl font-bold mb-1">45</h3>
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
              <tr class="table-row">
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  Main Office
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  Reception
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  ZKTeco
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  F18
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  Finger
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  DEV001
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  ZK123456
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  192.168.1.100
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  2023-01-15
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  ZKTeco Inc
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  $250
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  2 yrs
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  4370
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  IT Dept
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Approved</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button
                    class="text-blue-600 hover:text-blue-900 mr-3"
                    title="Edit">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button
                    class="text-red-600 hover:text-red-900"
                    title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <!-- Add more sample rows as needed -->
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

      <form class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Location Name</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sub Location</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Make</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="">Select Type</option>
              <option value="finger">Finger</option>
              <option value="finger_palm">Finger, Palm</option>
              <option value="finger_face">Finger, Face</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device No</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Identification Code (Serial No)</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">IP Address / ADSL</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Installed Date</label>
            <input
              type="date"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Device Cost</label>
            <input
              type="number"
              step="0.01"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Warranty Period (yrs)</label>
            <input
              type="number"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Port No</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Managed By</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Approve</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="approved">Approved</option>
              <option value="pending">Pending</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>

          <div class="md:col-span-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
            <textarea
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
            <i class="fas fa-save mr-2"></i>Save Device
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