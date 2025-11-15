<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Site Office Management</title>
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
  <!-- Mobile Menu Toggle -->
  <button
    id="mobileMenuBtn"
    class="lg:hidden fixed top-4 left-4 z-50 bg-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all">
    <i class="fas fa-bars text-blue-600"></i>
  </button>

  <!-- Sidebar -->
  <aside
    id="sidebar"
    class="fixed top-0 left-0 h-full w-64 bg-white shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 overflow-y-auto">
    <div class="p-6 border-b border-gray-100">
      <div class="flex items-center space-x-3">
        <div
          class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
          <i class="fas fa-database text-white text-xl"></i>
        </div>
        <div>
          <h2 class="text-lg font-bold text-gray-800">NWSDB</h2>
          <p class="text-xs text-gray-500">Hardware Device Manager</p>
        </div>
      </div>
    </div>

    <nav class="p-4">
      <div class="space-y-1">
        <a
          href="../dashboard.html"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-home w-5"></i>
          <span>Dashboard</span>
        </a>
        <a
          href="../computers.html"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-desktop w-5"></i>
          <span class="font-medium">Computers</span>
        </a>
        <a
          href="../printers.html"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-print w-5"></i>
          <span>Printers</span>
        </a>
        <a
          href="../rvpn-connections.html"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-network-wired w-5"></i>
          <span>RVPN Connections</span>
        </a>
        <a
          href="../finger-device.html"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-fingerprint w-5"></i>
          <span>Finger Devices</span>
        </a>
        <a
          href="#"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-microchip w-5"></i>
          <span>Other Devices</span>
        </a>
        <a
          href="#"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-tools w-5"></i>
          <span>Repairs</span>
        </a>
        <a
          href="#"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-exclamation-triangle w-5"></i>
          <span>Issues</span>
        </a>
        <a
          href="../summary.html"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
          <i class="fas fa-chart-pie w-5"></i> <span>Summary</span>
        </a>
      </div>

      <div class="mt-8 pt-8 border-t border-gray-100">
        <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-3">
          Administration
        </p>
        <div class="space-y-1">
          <a
            href="./site_offices.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-600">
            <i class="fas fa-building w-5"></i>
            <span>Site Offices</span>
          </a>
          <a
            href="./sections.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
            <i class="fas fa-sitemap w-5"></i>
            <span>Sections</span>
          </a>

          <a
            href="./users.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
            <i class="fas fa-users w-5"></i>
            <span>Users</span>
          </a>
          <a
            href="./categories.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
            <i class="fas fa-tags w-5"></i>
            <span>Categories</span>
          </a>
          <a
            href="./reports.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
            <i class="fas fa-chart-line w-5"></i>
            <span>Reports</span>
          </a>
          <a
            href="#"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
            <i class="fas fa-cog w-5"></i>
            <span>Settings</span>
          </a>
        </div>
      </div>
    </nav>

    <div class="p-4 border-t border-gray-100 mt-auto">
      <a
        href="#"
        class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50">
        <i class="fas fa-sign-out-alt w-5"></i>
        <span>Logout</span>
      </a>
    </div>
  </aside>

  <main class="lg:ml-64 min-h-screen">
    <header
      class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-30 border-b border-gray-100">
      <div class="px-6 py-4 flex items-center justify-between">
        <div class="animate-fade-up">
          <h1 class="text-2xl font-bold text-gray-800">
            Site Office Management
          </h1>
          <p class="text-sm text-gray-500 mt-1">
            Manage all NWSDB site offices and branches
          </p>
        </div>
        <div class="flex items-center space-x-4">
          <button
            class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fas fa-bell text-xl"></i>
            <span
              class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div
            class="flex items-center space-x-3 pl-4 border-l border-gray-200">
            <div class="text-right">
              <p class="text-sm font-medium text-gray-800">Admin User</p>
              <p class="text-xs text-gray-500">Administrator</p>
            </div>
            <div
              class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
              <i class="fas fa-user text-white text-sm"></i>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="p-6 space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
          <i class="fas fa-building text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1">12</h3>
          <p class="text-blue-100 text-sm">Total Offices</p>
        </div>
        <div
          class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
          <i class="fas fa-check-circle text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1">11</h3>
          <p class="text-green-100 text-sm">Total Devices</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddOfficeModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Site Office
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
                  Office Name
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Location
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Contact
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Manager
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                  Status
                </th>
                <th
                  class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4">
                  <div class="font-semibold text-gray-900">
                    Bandarawela Main Office
                  </div>
                  <div class="text-xs text-gray-500">Uva Province</div>
                </td>
                <td class="px-6 py-4">123 Main St, Bandarawela</td>
                <td class="px-6 py-4">057-222-1234</td>
                <td class="px-6 py-4">Mr. John Smith</td>
                <td class="px-6 py-4">
                  <span
                    class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                </td>
                <td class="px-6 py-4 text-right">
                  <button class="p-2 text-blue-600">
                    <i class="fas fa-eye"></i></button><button class="p-2 text-green-600">
                    <i class="fas fa-edit"></i></button><button class="p-2 text-red-600">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Add Site Office Modal -->
  <div
    id="addOfficeModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div
      class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
      <div
        class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">
            <i class="fas fa-building mr-2"></i>Add New Site Office
          </h3>
          <button
            onclick="closeAddOfficeModal()"
            class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>
      </div>

      <form id="addOfficeForm" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Office Name -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Office Name <span class="text-red-500">*</span>
            </label>
            <input
              type="text"
              name="office_name"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., Bandarawela Main Office" />
          </div>

          <!-- Province/Region -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Province/Region <span class="text-red-500">*</span>
            </label>
            <select
              name="province"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Province</option>
              <option value="Western">Western Province</option>
              <option value="Central">Central Province</option>
              <option value="Southern">Southern Province</option>
              <option value="Northern">Northern Province</option>
              <option value="Eastern">Eastern Province</option>
              <option value="North Western">North Western Province</option>
              <option value="North Central">North Central Province</option>
              <option value="Uva">Uva Province</option>
              <option value="Sabaragamuwa">Sabaragamuwa Province</option>
            </select>
          </div>

          <!-- District -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              District
            </label>
            <input
              type="text"
              name="district"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., Badulla" />
          </div>

          <!-- Address -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Address <span class="text-red-500">*</span>
            </label>
            <textarea
              name="address"
              required
              rows="2"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter complete address"></textarea>
          </div>

          <!-- Contact Number -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Contact Number <span class="text-red-500">*</span>
            </label>
            <input
              type="tel"
              name="contact_number"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., 057-222-1234" />
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Email Address
            </label>
            <input
              type="email"
              name="email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., bandarawela@nwsdb.lk" />
          </div>

          <!-- Manager Name -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Office Manager
            </label>
            <input
              type="text"
              name="manager_name"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., Mr. John Smith" />
          </div>

          <!-- Manager Contact -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Manager Contact
            </label>
            <input
              type="tel"
              name="manager_contact"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., 077-1234567" />
          </div>

          <!-- Number of Employees -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Number of Employees
            </label>
            <input
              type="number"
              name="employee_count"
              min="0"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="e.g., 25" />
          </div>

          <!-- Office Type -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Office Type
            </label>
            <select
              name="office_type"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Type</option>
              <option value="Head Office">Head Office</option>
              <option value="Regional Office">Regional Office</option>
              <option value="Branch Office">Branch Office</option>
              <option value="Sub Office">Sub Office</option>
            </select>
          </div>

          <!-- Established Date -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Established Date
            </label>
            <input
              type="date"
              name="established_date"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Status <span class="text-red-500">*</span>
            </label>
            <select
              name="status"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">Select Status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="under_renovation">Under Renovation</option>
              <option value="temporary_closed">Temporary Closed</option>
            </select>
          </div>

          <!-- Remarks -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Remarks / Notes
            </label>
            <textarea
              name="remarks"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter any additional information..."></textarea>
          </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
          <button
            type="button"
            onclick="closeAddOfficeModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-times mr-2"></i>Cancel
          </button>
          <button
            type="submit"
            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
            <i class="fas fa-save mr-2"></i>Save Site Office
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
      document
        .getElementById('sidebar')
        .classList.toggle('-translate-x-full');
    });

    function openAddOfficeModal() {
      document.getElementById('addOfficeModal').classList.remove('hidden');
    }

    function closeAddOfficeModal() {
      document.getElementById('addOfficeModal').classList.add('hidden');
    }
  </script>
</body>

</html>