<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NWSDB - Reports & Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

      .report-card {
        transition: all 0.3s ease;
        cursor: pointer;
      }

      .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
      }

      .sidebar-link {
        transition: all 0.2s ease;
      }

      .sidebar-link:hover {
        transform: translateX(5px);
      }

      .filter-btn {
        transition: all 0.2s ease;
      }

      .filter-btn.active {
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
      }
    </style>
  </head>
  <body
    class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen"
  >
    <!-- Mobile Menu Toggle -->
    <button
      id="mobileMenuBtn"
      class="lg:hidden fixed top-4 left-4 z-50 bg-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all"
    >
      <i class="fas fa-bars text-blue-600"></i>
    </button>

    <!-- Sidebar -->
    <aside
      id="sidebar"
      class="fixed top-0 left-0 h-full w-64 bg-white shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 overflow-y-auto"
    >
      <div class="p-6 border-b border-gray-100">
        <div class="flex items-center space-x-3">
          <div
            class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center"
          >
            <i class="fas fa-database text-white text-xl"></i>
          </div>
          <div>
            <h2 class="text-lg font-bold text-gray-800">NWSDB</h2>
            <p class="text-xs text-gray-500">Device Manager</p>
          </div>
        </div>
      </div>

      <nav class="p-4">
        <div class="space-y-1">
          <a
            href="../dashboard.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-home w-5"></i>
            <span>Dashboard</span>
          </a>
          <a
            href="../computers.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-desktop w-5"></i>
            <span>Computers</span>
          </a>
          <a
            href="../printers.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-print w-5"></i>
            <span>Printers</span>
          </a>
          <a
            href="#"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-microchip w-5"></i>
            <span>Other Devices</span>
          </a>
          <a
            href="#"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-tools w-5"></i>
            <span>Repairs</span>
          </a>
          <a
            href="#"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-exclamation-triangle w-5"></i>
            <span>Issues</span>
          </a>
          <a
            href="../summary.html"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
          >
            <i class="fas fa-chart-pie w-5"></i>
            <span>Summary</span>
          </a>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-100">
          <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-3">
            Administration
          </p>
          <div class="space-y-1">
            <a
              href="./site_offices.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-building w-5"></i>
              <span>Site Offices</span>
            </a>
            <a
              href="./sections.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-sitemap w-5"></i>
              <span>Sections</span>
            </a>
            <a
              href="../rvpn-connections.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-network-wired w-5"></i>
              <span>RVPN Connections</span>
            </a>
            <a
              href="../finger-device.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-fingerprint w-5"></i>
              <span>Finger Devices</span>
            </a>
            <a
              href="./users.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-users w-5"></i>
              <span>Users</span>
            </a>
            <a
              href="./categories.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-tags w-5"></i>
              <span>Categories</span>
            </a>
            <a
              href="./reports.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-600"
            >
              <i class="fas fa-chart-line w-5"></i>
              <span class="font-medium">Reports</span>
            </a>
            <a
              href="#"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-cog w-5"></i>
              <span>Settings</span>
            </a>
          </div>
        </div>
      </nav>

      <div class="p-4 border-t border-gray-100 mt-auto">
        <a
          href="#"
          class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50"
        >
          <i class="fas fa-sign-out-alt w-5"></i>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen">
      <!-- Header -->
      <header
        class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-30 border-b border-gray-100"
      >
        <div class="px-6 py-4 flex items-center justify-between">
          <div class="animate-fade-up">
            <h1 class="text-2xl font-bold text-gray-800">
              Reports & Analytics
            </h1>
            <p class="text-sm text-gray-500 mt-1">
              Comprehensive insights and data analysis
            </p>
          </div>
          <div class="flex items-center space-x-4">
            <button
              class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors"
            >
              <i class="fas fa-bell text-xl"></i>
              <span
                class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"
              ></span>
            </button>
            <div
              class="flex items-center space-x-3 pl-4 border-l border-gray-200"
            >
              <div class="text-right">
                <p class="text-sm font-medium text-gray-800">Admin User</p>
                <p class="text-xs text-gray-500">Administrator</p>
              </div>
              <div
                class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center"
              >
                <i class="fas fa-user text-white text-sm"></i>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Content -->
      <div class="p-6 space-y-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-file-alt text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Available</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">15</h3>
            <p class="text-blue-100 text-sm">Report Types</p>
          </div>

          <div
            class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-download text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Month</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">342</h3>
            <p class="text-green-100 text-sm">Generated Reports</p>
          </div>

          <div
            class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-clock text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Scheduled</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">8</h3>
            <p class="text-orange-100 text-sm">Auto Reports</p>
          </div>

          <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-share-alt text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Shared</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">23</h3>
            <p class="text-purple-100 text-sm">Shared Reports</p>
          </div>
        </div>

        <!-- Report Categories -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">
              <i class="fas fa-filter mr-2 text-blue-600"></i>Filter by Category
            </h2>
            <button
              onclick="clearFilters()"
              class="text-sm text-blue-600 hover:text-blue-800"
            >
              Clear All
            </button>
          </div>
          <div class="flex flex-wrap gap-3">
            <button
              class="filter-btn active px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all"
              onclick="filterReports('all')"
            >
              All Reports
            </button>
            <button
              class="filter-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all"
              onclick="filterReports('inventory')"
            >
              Inventory
            </button>
            <button
              class="filter-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all"
              onclick="filterReports('maintenance')"
            >
              Maintenance
            </button>
            <button
              class="filter-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all"
              onclick="filterReports('financial')"
            >
              Financial
            </button>
            <button
              class="filter-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all"
              onclick="filterReports('usage')"
            >
              Usage
            </button>
            <button
              class="filter-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all"
              onclick="filterReports('compliance')"
            >
              Compliance
            </button>
          </div>
        </div>

        <!-- Report Cards Grid -->
        <div
          id="reportGrid"
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
          <!-- Device Inventory Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="inventory"
            onclick="generateReport('device_inventory')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-boxes text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium"
                >Inventory</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Device Inventory
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Complete list of all devices with details, categorized by type and
              location
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 2 days ago</span
              >
              <button class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Category Distribution Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="inventory"
            onclick="generateReport('category_distribution')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-chart-pie text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium"
                >Inventory</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Category Distribution
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Device count breakdown by categories (Computer, Printer, Laptop,
              etc.)
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 1 day ago</span
              >
              <button class="text-green-600 hover:text-green-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Branch-wise Devices Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="inventory"
            onclick="generateReport('branch_devices')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-building text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full font-medium"
                >Inventory</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Branch-wise Devices
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Device allocation across all branches and site offices
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 3 hours ago</span
              >
              <button class="text-purple-600 hover:text-purple-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Repair History Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="maintenance"
            onclick="generateReport('repair_history')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-tools text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-orange-100 text-orange-700 px-3 py-1 rounded-full font-medium"
                >Maintenance</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Repair History</h3>
            <p class="text-sm text-gray-600 mb-4">
              Complete repair records with costs, technicians, and status
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 5 days ago</span
              >
              <button class="text-orange-600 hover:text-orange-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Issue Tracking Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="maintenance"
            onclick="generateReport('issue_tracking')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-medium"
                >Maintenance</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Issue Tracking</h3>
            <p class="text-sm text-gray-600 mb-4">
              Open and resolved issues with priority levels and resolution time
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 1 day ago</span
              >
              <button class="text-red-600 hover:text-red-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Repair Cost Analysis -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="financial"
            onclick="generateReport('repair_costs')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-dollar-sign text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full font-medium"
                >Financial</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Repair Cost Analysis
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Total repair costs by device type, branch, and time period
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 1 week ago</span
              >
              <button class="text-cyan-600 hover:text-cyan-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Device Purchase Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="financial"
            onclick="generateReport('device_purchases')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-shopping-cart text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-pink-100 text-pink-700 px-3 py-1 rounded-full font-medium"
                >Financial</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Device Purchases
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Purchase history with dates, costs, and procurement details
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 4 days ago</span
              >
              <button class="text-pink-600 hover:text-pink-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Device Status Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="usage"
            onclick="generateReport('device_status')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-heartbeat text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-medium"
                >Usage</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Device Status</h3>
            <p class="text-sm text-gray-600 mb-4">
              Active, under repair, retired, and lost devices summary
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 6 hours ago</span
              >
              <button class="text-yellow-600 hover:text-yellow-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- User Assignment Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="usage"
            onclick="generateReport('user_assignments')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-user-tag text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-medium"
                >Usage</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              User Assignments
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Devices assigned to users with assignment details
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 2 days ago</span
              >
              <button class="text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- RVPN Connections Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="inventory"
            onclick="generateReport('rvpn_connections')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-network-wired text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-teal-100 text-teal-700 px-3 py-1 rounded-full font-medium"
                >Inventory</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              RVPN Connections
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              All RVPN users with employee details, locations, and status
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 1 day ago</span
              >
              <button class="text-teal-600 hover:text-teal-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Finger Device Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="inventory"
            onclick="generateReport('finger_devices')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-fingerprint text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-rose-100 text-rose-700 px-3 py-1 rounded-full font-medium"
                >Inventory</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Finger Device Deployment
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Biometric device locations, models, and installation details
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 3 days ago</span
              >
              <button class="text-rose-600 hover:text-rose-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Warranty Expiration Report -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="compliance"
            onclick="generateReport('warranty_expiration')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-calendar-times text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-medium"
                >Compliance</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Warranty Expiration
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Devices with expired or soon-to-expire warranties
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 1 week ago</span
              >
              <button class="text-amber-600 hover:text-amber-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Section-wise Allocation -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="inventory"
            onclick="generateReport('section_allocation')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-lime-500 to-lime-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-sitemap text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-lime-100 text-lime-700 px-3 py-1 rounded-full font-medium"
                >Inventory</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Section-wise Allocation
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Device distribution across departments and sections
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 2 days ago</span
              >
              <button class="text-lime-600 hover:text-lime-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Technician Performance -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="maintenance"
            onclick="generateReport('technician_performance')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-user-cog text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-violet-100 text-violet-700 px-3 py-1 rounded-full font-medium"
                >Maintenance</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Technician Performance
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Repair completion rates and technician efficiency metrics
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 5 days ago</span
              >
              <button class="text-violet-600 hover:text-violet-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          <!-- Device Age Analysis -->
          <div
            class="report-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
            data-category="compliance"
            onclick="generateReport('device_age')"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-calendar-check text-white text-2xl"></i>
              </div>
              <span
                class="text-xs bg-sky-100 text-sky-700 px-3 py-1 rounded-full font-medium"
                >Compliance</span
              >
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              Device Age Analysis
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Devices categorized by purchase date and age for replacement
              planning
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500"
                >Last generated: 1 week ago</span
              >
              <button class="text-sky-600 hover:text-sky-800">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Report Generation Panel -->
        <div
          id="reportPanel"
          class="hidden bg-white rounded-2xl shadow-lg border border-gray-200 p-6"
        >
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
              <i class="fas fa-cog mr-2 text-blue-600"></i>Generate Report
            </h2>
            <button
              onclick="closeReportPanel()"
              class="text-gray-400 hover:text-gray-600"
            >
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Date Range</label
              >
              <select
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
              >
                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
                <option>Last Year</option>
                <option>All Time</option>
                <option>Custom Range</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Format</label
              >
              <select
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
              >
                <option>PDF</option>
                <option>Excel (XLSX)</option>
                <option>CSV</option>
                <option>HTML</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Branch Filter</label
              >
              <select
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
              >
                <option>All Branches</option>
                <option>Head Office</option>
                <option>Regional Office - North</option>
                <option>Regional Office - South</option>
                <option>Regional Office - East</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Device Category</label
              >
              <select
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
              >
                <option>All Categories</option>
                <option>Computer</option>
                <option>Printer</option>
                <option>Laptop</option>
                <option>RVPN Connection</option>
                <option>Finger Device</option>
                <option>Scanner</option>
                <option>UPS</option>
              </select>
            </div>
          </div>

          <div class="mt-6 flex gap-3 justify-end">
            <button
              onclick="closeReportPanel()"
              class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700"
            >
              <i class="fas fa-download mr-2"></i>Generate Report
            </button>
          </div>
        </div>
      </div>
    </main>

    <script>
      // Mobile menu toggle
      const mobileMenuBtn = document.getElementById('mobileMenuBtn');
      const sidebar = document.getElementById('sidebar');

      mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
      });

      // Filter reports
      function filterReports(category) {
        const cards = document.querySelectorAll('.report-card');
        const buttons = document.querySelectorAll('.filter-btn');

        // Update active button
        buttons.forEach((btn) => {
          btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // Filter cards
        cards.forEach((card) => {
          if (category === 'all') {
            card.style.display = 'block';
          } else {
            const cardCategory = card.getAttribute('data-category');
            card.style.display = cardCategory === category ? 'block' : 'none';
          }
        });
      }

      function clearFilters() {
        filterReports('all');
        document.querySelectorAll('.filter-btn')[0].classList.add('active');
      }

      // Generate report
      function generateReport(reportType) {
        document.getElementById('reportPanel').classList.remove('hidden');
        console.log('Generating report:', reportType);
      }

      function closeReportPanel() {
        document.getElementById('reportPanel').classList.add('hidden');
      }
    </script>
  </body>
</html>
