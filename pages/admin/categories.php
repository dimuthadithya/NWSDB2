<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NWSDB - Category Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
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
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-600"
            >
              <i class="fas fa-tags w-5"></i>
              <span class="font-medium">Categories</span>
            </a>
            <a
              href="./reports.html"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-chart-line w-5"></i>
              <span>Reports</span>
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
              Device Category Management
            </h1>
            <p class="text-sm text-gray-500 mt-1">
              Manage all device categories and types
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
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
            style="animation-delay: 0.1s"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-tags text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Total</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">8</h3>
            <p class="text-blue-100 text-sm">Total Categories</p>
          </div>

          <div
            class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
            style="animation-delay: 0.2s"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-desktop text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Devices</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">2,547</h3>
            <p class="text-green-100 text-sm">Total Devices</p>
          </div>

          <div
            class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
            style="animation-delay: 0.3s"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-star text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >Popular</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">Computer</h3>
            <p class="text-orange-100 text-sm">Most Used Category</p>
          </div>

          <div
            class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
            style="animation-delay: 0.4s"
          >
            <div class="flex items-center justify-between mb-4">
              <div
                class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-plus-circle text-2xl"></i>
              </div>
              <span class="text-sm bg-white/20 px-3 py-1 rounded-full"
                >New</span
              >
            </div>
            <h3 class="text-3xl font-bold mb-1">3</h3>
            <p class="text-purple-100 text-sm">Added This Month</p>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-3">
          <button
            onclick="openAddModal()"
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all"
          >
            <i class="fas fa-plus mr-2"></i>
            Add New Category
          </button>
          <button
            class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 shadow-sm border border-gray-200 transition-all"
          >
            <i class="fas fa-file-excel mr-2 text-green-600"></i>
            Export to Excel
          </button>
          <button
            class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 shadow-sm border border-gray-200 transition-all"
          >
            <i class="fas fa-file-pdf mr-2 text-red-600"></i>
            Export to PDF
          </button>
        </div>

        <!-- Category Cards Grid -->
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
          <!-- Computer Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-desktop text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Computer</h3>
            <p class="text-sm text-gray-600 mb-4">
              Desktop and workstation computers
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-blue-600">1,245</span>
            </div>
          </div>

          <!-- Printer Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-print text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Printer</h3>
            <p class="text-sm text-gray-600 mb-4">Laser and inkjet printers</p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-green-600">487</span>
            </div>
          </div>

          <!-- Laptop Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-laptop text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Laptop</h3>
            <p class="text-sm text-gray-600 mb-4">Portable laptop computers</p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-purple-600">356</span>
            </div>
          </div>

          <!-- RVPN Connection Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-network-wired text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              RVPN Connection
            </h3>
            <p class="text-sm text-gray-600 mb-4">Remote VPN connections</p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-cyan-600">156</span>
            </div>
          </div>

          <!-- Finger Device Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-fingerprint text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Finger Device</h3>
            <p class="text-sm text-gray-600 mb-4">Biometric finger scanners</p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-orange-600">67</span>
            </div>
          </div>

          <!-- Scanner Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-scanner text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Scanner</h3>
            <p class="text-sm text-gray-600 mb-4">Document scanners</p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-pink-600">89</span>
            </div>
          </div>

          <!-- UPS Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-battery-full text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">UPS</h3>
            <p class="text-sm text-gray-600 mb-4">
              Uninterruptible power supply
            </p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-yellow-600">123</span>
            </div>
          </div>

          <!-- Other Category -->
          <div
            class="category-card bg-white rounded-2xl p-6 shadow-sm border border-gray-200"
          >
            <div class="flex items-start justify-between mb-4">
              <div
                class="w-14 h-14 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center"
              >
                <i class="fas fa-microchip text-white text-2xl"></i>
              </div>
              <div class="flex gap-2">
                <button class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Other</h3>
            <p class="text-sm text-gray-600 mb-4">Miscellaneous devices</p>
            <div
              class="flex items-center justify-between pt-4 border-t border-gray-100"
            >
              <span class="text-xs text-gray-500">Devices</span>
              <span class="text-lg font-bold text-gray-600">24</span>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Add Category Modal -->
    <div
      id="addModal"
      class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
    >
      <div
        class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
      >
        <div
          class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl"
        >
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-white">Add New Category</h3>
            <button
              onclick="closeAddModal()"
              class="text-white hover:text-gray-200 transition-colors"
            >
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>
        </div>

        <form class="p-6">
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Category Name</label
              >
              <input
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g., Computer, Printer, Scanner"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Description</label
              >
              <textarea
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter category description..."
              ></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Icon</label
              >
              <select
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="desktop">Desktop (Computer)</option>
                <option value="print">Print (Printer)</option>
                <option value="laptop">Laptop</option>
                <option value="network-wired">Network Wired (RVPN)</option>
                <option value="fingerprint">Fingerprint</option>
                <option value="scanner">Scanner</option>
                <option value="battery-full">Battery (UPS)</option>
                <option value="microchip">Microchip (Other)</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"
                >Color</label
              >
              <select
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="blue">Blue</option>
                <option value="green">Green</option>
                <option value="purple">Purple</option>
                <option value="orange">Orange</option>
                <option value="cyan">Cyan</option>
                <option value="pink">Pink</option>
                <option value="yellow">Yellow</option>
                <option value="gray">Gray</option>
              </select>
            </div>
          </div>

          <div class="mt-6 flex gap-3 justify-end">
            <button
              type="button"
              onclick="closeAddModal()"
              class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all"
            >
              <i class="fas fa-save mr-2"></i>Save Category
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
        .addEventListener('click', function (e) {
          if (e.target === this) {
            closeAddModal();
          }
        });
    </script>
  </body>
</html>
