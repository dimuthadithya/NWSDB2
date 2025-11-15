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
                  href="./dashboard.html"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl bg-blue-50 text-blue-600">
                  <i class="fas fa-home w-5"></i>
                  <span class="font-medium">Dashboard</span>
              </a>
              <a
                  href="./computers.html"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                  <i class="fas fa-desktop w-5"></i>
                  <span>Computers</span>
              </a>
              <a
                  href="./printers.html"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                  <i class="fas fa-print w-5"></i>
                  <span>Printers</span>
              </a>
              <a
                  href="./rvpn-connections.html"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                  <i class="fas fa-network-wired w-5"></i>
                  <span>RVPN Connections</span>
              </a>
              <a
                  href="./finger-device.html"
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
                  href="./summary.html"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                  <i class="fas fa-chart-pie w-5"></i> <span>Summary</span>
              </a>
          </div>

          <?php if ($role == 'admin')
                echo '

    <div class="mt-8 pt-8 border-t border-gray-100">
          <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-3">
            Water Supply Management
          </p>
          <div class="space-y-1">
              <a href="' . ($pathUpdate ? './admin/regions.php' : './regions.php') . '" 
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-globe-asia w-5"></i>
              <span>Regions</span>
            </a>
              <a href="' . ($pathUpdate ? './admin/areas.php' : './areas.php') . '" 
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-map-marked-alt w-5"></i>
              <span class="font-medium">Areas</span>
            </a>
              <a href="' . ($pathUpdate ? './admin/water-schemes.php' : './water-schemes.php') . '" 
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50"
            >
              <i class="fas fa-tint w-5"></i>
              <span>Water Supply Schemes</span>
            </a>
          </div>
        </div>

          <div class="mt-8 pt-8 border-t border-gray-100">
              <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-3">
                  Administration
              </p>
              <div class="space-y-1">
                     <a href="' . ($pathUpdate ? './admin/site_offices.php' : './site_offices.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                      <i class="fas fa-building w-5"></i>
                      <span>Site Offices</span>
                  </a>
                     <a href="' . ($pathUpdate ? './admin/sections.php' : './sections.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                      <i class="fas fa-sitemap w-5"></i>
                      <span>Sections</span>
                  </a>
                      <a href="' . ($pathUpdate ? './admin/users.php' : './users.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                      <i class="fas fa-users w-5"></i>
                      <span>Users</span>
                  </a>
                      <a href="' . ($pathUpdate ? './admin/categories.php' : './categories.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                      <i class="fas fa-tags w-5"></i>
                      <span>Categories</span>
                  </a>
                      <a href="' . ($pathUpdate ? './admin/reports.php' : './reports.php') . '" 
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
          </div>'

            ?>

      </nav>

      <div class="p-4 border-t border-gray-100 mt-auto">
          <a
              href="../handlers/logout.php"
              class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50">
              <i class="fas fa-sign-out-alt w-5"></i>
              <span>Logout</span>
          </a>
      </div>
  </aside>