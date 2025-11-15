<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch users data
$users = DbHelper::getAllUsers();
$totalUsers = count($users);
$activeUsers = count(array_filter($users, fn($u) => $u['status'] === 'active'));
$adminUsers = count(array_filter($users, fn($u) => $u['role'] === 'admin'));
$inactiveUsers = count(array_filter($users, fn($u) => $u['status'] === 'inactive'));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - User Management</title>
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
              <i class="fas fa-users text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $totalUsers; ?></h3>
          <p class="text-blue-100 text-sm">Total Users</p>
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
          <h3 class="text-3xl font-bold mb-1"><?php echo $activeUsers; ?></h3>
          <p class="text-green-100 text-sm">Active Users</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Admin</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $adminUsers; ?></h3>
          <p class="text-orange-100 text-sm">Administrators</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.4s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-pause-circle text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Inactive</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $inactiveUsers; ?></h3>
          <p class="text-purple-100 text-sm">Inactive Users</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New User
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

      <!-- Users Table -->
      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up">
        <div
          class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">
                  Users List
                </h3>
                <p class="text-sm text-gray-600">
                  View and manage all system users
                </p>
              </div>
            </div>
            <div class="relative">
              <input
                type="text"
                placeholder="Search users..."
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
                  User ID
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Name
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Username
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Email
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Mobile Number
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Role
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Last Login
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <?php echo htmlspecialchars($user['user_id']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?php echo htmlspecialchars($user['email']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?php echo htmlspecialchars($user['mobile_number'] ?? 'N/A'); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 py-1 text-xs font-medium <?php echo $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?> rounded-full">
                        <?php echo ucfirst($user['role']); ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?php if ($user['status'] === 'active'): ?>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                      <?php elseif ($user['status'] === 'inactive'): ?>
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                      <?php else: ?>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Suspended</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <?php echo $user['last_login'] ? date('Y-m-d H:i', strtotime($user['last_login'])) : 'Never'; ?>
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
              <?php else: ?>
                <tr>
                  <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p class="text-lg font-medium">No users found</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing <span class="font-medium">1</span> to
              <span class="font-medium"><?php echo min($totalUsers, 10); ?></span> of
              <span class="font-medium"><?php echo $totalUsers; ?></span> results
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

  <!-- Add User Modal -->
  <div
    id="addModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">Add New User</h3>
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
            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              type="email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
            <input
              type="tel"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input
              type="password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Site Office</label>
            <input
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="suspended">Suspended</option>
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
            <i class="fas fa-save mr-2"></i>Save User
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