<?php
require_once __DIR__ . '/../functions/DbHelper.php';
require '../components/sessions.php';

$computerCount = DbHelper::getComputerCount();
$printerCount = DbHelper::getPrinterCount();
$laptopCount = DbHelper::getLaptopCount();
$sectionsByDeviceCount = DBHelper::getSectionsByDeviceCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
</head>

<body class="min-h-screen bg-gray-50">
  <?php include '../components/sidemenu.php'; ?>

  <div class="lg:pl-64 min-h-screen flex flex-col">
    <?php include '../components/header.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Section -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">
          Welcome Back, <?php echo $first_name ?>!
        </h1>
        <p class="text-gray-600">
          Here's an overview of your device management system.
        </p>
      </div>

      <!-- Summary Cards Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Desktop Computers -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">
                Desktop Computers
              </p>
              <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo $computerCount ?></h3>
            </div>
            <div
              class="h-12 w-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
              <i class="fas fa-desktop text-xl"></i>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="text-green-500 mr-2"><i class="fas fa-arrow-up"></i> 2</span>
            <span class="text-gray-600">from last month</span>
          </div>
        </div>

        <!-- Laptops -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Laptops</p>
              <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo $laptopCount  ?></h3>
            </div>
            <div
              class="h-12 w-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
              <i class="fas fa-laptop text-xl"></i>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="text-green-500 mr-2"><i class="fas fa-arrow-up"></i> 1</span>
            <span class="text-gray-600">from last month</span>
          </div>
        </div>

        <!-- Printers -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Printers</p>
              <h3 class="text-2xl font-bold text-gray-900 mt-1"><?php echo $printerCount ?></h3>
            </div>
            <div
              class="h-12 w-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
              <i class="fas fa-print text-xl"></i>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="text-gray-500 mr-2"><i class="fas fa-minus"></i></span>
            <span class="text-gray-600">no change</span>
          </div>
        </div>

        <!-- Repairs -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Active Repairs</p>
              <h3 class="text-2xl font-bold text-gray-900 mt-1">5</h3>
            </div>
            <div
              class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600">
              <i class="fas fa-tools text-xl"></i>
            </div>
          </div>
          <div class="mt-4 flex items-center text-sm">
            <span class="text-red-500 mr-2"><i class="fas fa-arrow-up"></i> 2</span>
            <span class="text-gray-600">needs attention</span>
          </div>
        </div>
      </div>

      <!-- Recent Activity and Site Office Distribution -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-4">
            Recent Activity
          </h2>
          <div class="space-y-4">
            <div class="flex items-start space-x-4">
              <div
                class="h-8 w-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <i class="fas fa-plus-circle"></i>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">
                  New Desktop Added
                </p>
                <p class="text-xs text-gray-600">
                  Added to Engineering Department
                </p>
                <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
              </div>
            </div>
            <div class="flex items-start space-x-4">
              <div
                class="h-8 w-8 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600">
                <i class="fas fa-wrench"></i>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">
                  Repair Request
                </p>
                <p class="text-xs text-gray-600">
                  Printer maintenance required
                </p>
                <p class="text-xs text-gray-500 mt-1">5 hours ago</p>
              </div>
            </div>
            <div class="flex items-start space-x-4">
              <div
                class="h-8 w-8 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                <i class="fas fa-check-circle"></i>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">
                  Repair Completed
                </p>
                <p class="text-xs text-gray-600">Laptop repair finished</p>
                <p class="text-xs text-gray-500 mt-1">1 day ago</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Site Office Distribution -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-4">
            Site Office Distribution
          </h2>
          <div class="space-y-4">
            <?php
            if ($sectionsByDeviceCount) {
              foreach ($sectionsByDeviceCount as $section) { ?>
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div
                      class="h-8 w-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                      <i class="fas fa-building"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-900"><?php echo $section['section_name'] ?></span>
                  </div>
                  <span class="text-sm font-bold text-gray-900"><?php echo $section['total_devices'] ?></span>
                </div>
            <?php }
            }
            ?>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>