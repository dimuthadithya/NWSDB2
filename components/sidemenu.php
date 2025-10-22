<?php
// Sidebar Navigation
?>
<!-- Mobile Menu Toggle Button -->
<div class="fixed bottom-4 right-4 lg:hidden z-50">
    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Sidebar Navigation -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 h-full w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo Section -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-center">
                <img src="../assets/images/logo.png" alt="NWSDB Logo" class="h-12 w-auto" />
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto p-4">
            <ul class="space-y-2">
                <li>
                    <a href="index.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="computers.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'computers.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-desktop"></i>
                        <span>Computers</span>
                    </a>
                </li>
                <li>
                    <a href="laptops.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'laptops.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-laptop"></i>
                        <span>Laptops</span>
                    </a>
                </li>
                <li>
                    <a href="repairs.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'repairs.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-tools"></i>
                        <span>Repair Details</span>
                    </a>
                </li>
                <li>
                    <a href="site-offices.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'site-offices.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-building"></i>
                        <span>Site Offices</span>
                    </a>
                </li>
                <li>
                    <a href="printers.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'printers.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-print"></i>
                        <span>Printer Details</span>
                    </a>
                </li>
                <li>
                    <a href="other-devices.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'other-devices.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-microchip"></i>
                        <span>Other Details</span>
                    </a>
                </li>
                <li>
                    <a href="summary.php" class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'summary.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?>">
                        <i class="fas fa-chart-pie"></i>
                        <span>Summary</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Bottom Section -->
        <div class="p-4 border-t border-gray-200">
            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</aside>