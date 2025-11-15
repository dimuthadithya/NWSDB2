  <!-- Mobile Menu Toggle -->
  <button
      id="mobileMenuBtn"
      class="lg:hidden fixed top-4 left-4 z-50 bg-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all">
      <i class="fas fa-bars text-blue-600"></i>
  </button>

  <?php
    // Get current page name
    $current_page = basename($_SERVER['PHP_SELF']);

    // Function to check if current page matches
    function isActive($page)
    {
        global $current_page;
        return $current_page === $page ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50';
    }

    function isFontWeight($page)
    {
        global $current_page;
        return $current_page === $page ? 'font-medium' : '';
    }
    ?>

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
                  href="<?php echo $pathUpdate2 ? '../dashboard.php' : './dashboard.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('dashboard.php'); ?>">
                  <i class="fas fa-home w-5"></i>
                  <span class="<?php echo isFontWeight('dashboard.php'); ?>">Dashboard</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../computers.php' : './computers.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('computers.php'); ?>">
                  <i class="fas fa-desktop w-5"></i>
                  <span class="<?php echo isFontWeight('computers.php'); ?>">Computers</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../printers.php' : './printers.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('printers.php'); ?>">
                  <i class="fas fa-print w-5"></i>
                  <span class="<?php echo isFontWeight('printers.php'); ?>">Printers</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../rvpn-connections.php' : './rvpn-connections.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('rvpn-connections.php'); ?>">
                  <i class="fas fa-network-wired w-5"></i>
                  <span class="<?php echo isFontWeight('rvpn-connections.php'); ?>">RVPN Connections</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../finger-device.php' : './finger-device.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('finger-device.php'); ?>">
                  <i class="fas fa-fingerprint w-5"></i>
                  <span class="<?php echo isFontWeight('finger-device.php'); ?>">Finger Devices</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../other-devices.php' : './other-devices.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('other-devices.php'); ?>">
                  <i class="fas fa-microchip w-5"></i>
                  <span class="<?php echo isFontWeight('other-devices.php'); ?>">Other Devices</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../repairs.php' : './repairs.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('repairs.php'); ?>">
                  <i class="fas fa-tools w-5"></i>
                  <span class="<?php echo isFontWeight('repairs.php'); ?>">Repairs</span>
              </a>
              <a
                  href="#"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50">
                  <i class="fas fa-exclamation-triangle w-5"></i>
                  <span>Issues</span>
              </a>
              <a
                  href="<?php echo $pathUpdate2 ? '../summary.php' : './summary.php' ?>"
                  class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl <?php echo isActive('summary.php'); ?>">
                  <i class="fas fa-chart-pie w-5"></i>
                  <span class="<?php echo isFontWeight('summary.php'); ?>">Summary</span>
              </a>
          </div>

          <?php if ($role == 'admin')
                echo '
        <div class="mt-8 pt-8 border-t border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-3">
                WSS
            </p>
            <div class="space-y-1">
                <a href="' . ($pathUpdate ? './admin/regions.php' : './regions.php') . '" 
                class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('regions.php') . '"
                >
                <i class="fas fa-globe-asia w-5"></i>
                <span class="' . isFontWeight('regions.php') . '">Regions</span>
                </a>
                <a href="' . ($pathUpdate ? './admin/areas.php' : './areas.php') . '" 
                class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('areas.php') . '"
                >
                <i class="fas fa-map-marked-alt w-5"></i>
                <span class="' . isFontWeight('areas.php') . '">Areas</span>
                </a>
                <a href="' . ($pathUpdate ? './admin/water-schemes.php' : './water-schemes.php') . '" 
                class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('water-schemes.php') . '"
                >
                <i class="fas fa-tint w-5"></i>
                <span class="' . isFontWeight('water-schemes.php') . '">Water Supply Schemes</span>
                </a>
          </div>
        </div>

          <div class="mt-8 pt-8 border-t border-gray-100">
              <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-3">
                  Administration
              </p>
              <div class="space-y-1">
                     <a href="' . ($pathUpdate ? './admin/site_offices.php' : './site_offices.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('site_offices.php') . '">
                      <i class="fas fa-building w-5"></i>
                      <span class="' . isFontWeight('site_offices.php') . '">Site Offices</span>
                  </a>
                     <a href="' . ($pathUpdate ? './admin/sections.php' : './sections.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('sections.php') . '">
                      <i class="fas fa-sitemap w-5"></i>
                      <span class="' . isFontWeight('sections.php') . '">Sections</span>
                  </a>
                      <a href="' . ($pathUpdate ? './admin/users.php' : './users.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('users.php') . '">
                      <i class="fas fa-users w-5"></i>
                      <span class="' . isFontWeight('users.php') . '">Users</span>
                  </a>
                      <a href="' . ($pathUpdate ? './admin/categories.php' : './categories.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('categories.php') . '">
                      <i class="fas fa-tags w-5"></i>
                      <span class="' . isFontWeight('categories.php') . '">Categories</span>
                  </a>
                      <a href="' . ($pathUpdate ? './admin/reports.php' : './reports.php') . '" 
                      class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl ' . isActive('reports.php') . '">
                      <i class="fas fa-chart-line w-5"></i>
                      <span class="' . isFontWeight('reports.php') . '">Reports</span>
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