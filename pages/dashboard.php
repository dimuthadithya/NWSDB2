<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// get category id s 
$laptopCatId = DbHelper::getCategoryId('laptop');
$desktopCatId = DbHelper::getCategoryId('Desktop Computer');
$printerId = DbHelper::getCategoryId('printer');
$fingerprintId = DbHelper::getCategoryId('Fingerprint Device');
$rvpnId = DbHelper::getCategoryId('RVPN Device');


// get counts
$totalDevices = DbHelper::getRowCount('devices');
$totalUsers = DbHelper::getRowCount('users');

$adminUsers = DbHelper::getRowCountWithCondition('users', ['role' => 'admin']);
$activeUsers = DbHelper::getRowCountWithCondition('users', ['status' => 'active']);
$regularUsers = $totalUsers - $adminUsers;
$activeDevices = DbHelper::getRowCountWithCondition('devices', ['status' => 'active']);
$repairDevices = DbHelper::getRowCountWithCondition('devices', ['status' => 'under_repair']);

$laptopsCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $laptopCatId]);
$printersCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $printerId]);
$computersCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $desktopCatId]);
$fingerprintCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $fingerprintId]);
$rvpnCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $rvpnId]);

$otherDevicesCount = $totalDevices - ($laptopsCount + $printersCount + $computersCount + $fingerprintCount + $rvpnCount);

// Get top 3 sections by device count
$topSections = DbHelper::getSectionsByDeviceCount();
$top3Sections = $topSections ? array_slice($topSections, 0, 3) : [];

// Get issue priority counts
$issuePriorityCounts = DbHelper::getIssuePriorityCounts();
$highPriorityIssues = $issuePriorityCounts['high'];
$mediumPriorityIssues = $issuePriorityCounts['medium'];
$lowPriorityIssues = $issuePriorityCounts['low'];
$totalPriorityIssues = $highPriorityIssues + $mediumPriorityIssues + $lowPriorityIssues;

// Get recent activities
$recentActivities = DbHelper::getRecentActivities(4);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(30px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

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

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.5;
      }
    }

    .animate-slide-in {
      animation: slideInRight 0.5s ease-out forwards;
    }

    .animate-fade-up {
      animation: fadeInUp 0.6s ease-out forwards;
    }

    .stat-card {
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .sidebar-link {
      transition: all 0.2s ease;
    }

    .sidebar-link:hover {
      transform: translateX(5px);
    }

    .chart-container {
      position: relative;
      height: 300px;
    }

    .activity-item {
      transition: all 0.2s ease;
    }

    .activity-item:hover {
      background: rgba(59, 130, 246, 0.05);
    }

    .status-badge {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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

    <!-- Dashboard Content -->
    <div class="p-6 space-y-6">
      <!-- Quick Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Devices -->
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.1s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-server text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1">
            <?php echo $totalDevices; ?>
          </h3>
          <p class="text-blue-100 text-sm">Total Devices</p>
          <div class="mt-4 flex items-center text-sm">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>12% from last month</span>
          </div>
        </div>

        <!-- Active Devices -->
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
          <h3 class="text-3xl font-bold mb-1">
            <?php echo $activeDevices; ?>
          </h3>
          <p class="text-green-100 text-sm">Active Devices</p>
          <div class="mt-4 flex items-center text-sm">
            <i class="fas fa-check mr-1"></i>
            <span>94.4% operational</span>
          </div>
        </div>

        <!-- Under Repair -->
        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-wrench text-2xl"></i>
            </div>
            <span
              class="text-sm bg-white/20 px-3 py-1 rounded-full status-badge">Repairs</span>
          </div>
          <h3 class="text-3xl font-bold mb-1">
            <?php echo $repairDevices; ?>
          </h3>
          <p class="text-orange-100 text-sm">Under Repair</p>
          <div class="mt-4 flex items-center text-sm">
            <i class="fas fa-tools mr-1"></i>
            <span>2 pending completion</span>
          </div>
        </div>
      </div>

      <!-- Device Categories Overview -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          class="stat-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md animate-fade-up"
          style="animation-delay: 0.5s">
          <div class="flex items-center space-x-4">
            <div
              class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-desktop text-blue-600 text-2xl"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Desktop Computers</p>
              <h3 class="text-2xl font-bold text-gray-800">
                <?php echo $computersCount; ?>
              </h3>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md animate-fade-up"
          style="animation-delay: 0.6s">
          <div class="flex items-center space-x-4">
            <div
              class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-laptop text-indigo-600 text-2xl"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Laptops</p>
              <h3 class="text-2xl font-bold text-gray-800">
                <?php echo $laptopsCount; ?>
              </h3>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md animate-fade-up"
          style="animation-delay: 0.7s">
          <div class="flex items-center space-x-4">
            <div
              class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-print text-purple-600 text-2xl"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Printers</p>
              <h3 class="text-2xl font-bold text-gray-800">
                <?php echo $printersCount; ?>
              </h3>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md animate-fade-up"
          style="animation-delay: 0.8s">
          <div class="flex items-center space-x-4">
            <div
              class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-fingerprint text-teal-600 text-2xl"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Fingerprint Devices</p>
              <h3 class="text-2xl font-bold text-gray-800">
                <?php echo $fingerprintCount; ?>
              </h3>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md animate-fade-up"
          style="animation-delay: 0.9s">
          <div class="flex items-center space-x-4">
            <div
              class="w-14 h-14 bg-rose-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-shield-alt text-rose-600 text-2xl"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">RVPN Devices</p>
              <h3 class="text-2xl font-bold text-gray-800">
                <?php echo $rvpnCount; ?>
              </h3>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-2xl p-6 shadow-sm hover:shadow-md animate-fade-up"
          style="animation-delay: 1.0s">
          <div class="flex items-center space-x-4">
            <div
              class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-microchip text-amber-600 text-2xl"></i>
            </div>
            <div>
              <p class="text-gray-500 text-sm">Other Devices</p>
              <h3 class="text-2xl font-bold text-gray-800">
                <?php echo $otherDevicesCount; ?>
              </h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts and Activity -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Device Distribution Chart -->
        <div
          class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm animate-fade-up"
          style="animation-delay: 0.9s">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Device Distribution
          </h3>
          <div class="chart-container">
            <canvas id="deviceChart"></canvas>
          </div>
        </div>

        <!-- Recent Activity -->
        <div
          class="bg-white rounded-2xl p-6 shadow-sm animate-fade-up"
          style="animation-delay: 1s">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Recent Activity
          </h3>
          <div class="space-y-4">
            <?php if (!empty($recentActivities)): ?>
              <?php foreach ($recentActivities as $activity): ?>
                <div class="activity-item flex items-start space-x-3 p-3 rounded-xl">
                  <div class="w-10 h-10 bg-<?php echo $activity['color']; ?>-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas <?php echo $activity['icon']; ?> text-<?php echo $activity['color']; ?>-600"></i>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">
                      <?php echo htmlspecialchars($activity['title']); ?>
                    </p>
                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($activity['description']); ?></p>
                    <p class="text-xs text-gray-400 mt-1">
                      <?php
                      $time = strtotime($activity['time']);
                      $diff = time() - $time;
                      if ($diff < 3600) {
                        echo floor($diff / 60) . ' minutes ago';
                      } elseif ($diff < 86400) {
                        echo floor($diff / 3600) . ' hours ago';
                      } else {
                        echo floor($diff / 86400) . ' days ago';
                      }
                      ?>
                    </p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-center py-8 text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                <p class="text-sm">No recent activity</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Branch Distribution -->
      <div
        class="bg-white rounded-2xl p-6 shadow-sm animate-fade-up"
        style="animation-delay: 1.1s">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">
          Top 3 Sections by Device Count
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php if (!empty($top3Sections)): ?>
            <?php
            $colors = [
              ['bg' => 'from-blue-50 to-indigo-50', 'border' => 'border-blue-100', 'text' => 'text-blue-600', 'progress' => 'bg-blue-600', 'progressBg' => 'bg-blue-200'],
              ['bg' => 'from-green-50 to-emerald-50', 'border' => 'border-green-100', 'text' => 'text-green-600', 'progress' => 'bg-green-600', 'progressBg' => 'bg-green-200'],
              ['bg' => 'from-purple-50 to-violet-50', 'border' => 'border-purple-100', 'text' => 'text-purple-600', 'progress' => 'bg-purple-600', 'progressBg' => 'bg-purple-200']
            ];
            $maxDevices = !empty($top3Sections) ? max(array_column($top3Sections, 'total_devices')) : 1;
            ?>
            <?php foreach ($top3Sections as $index => $section): ?>
              <?php
              $color = $colors[$index];
              $percentage = $maxDevices > 0 ? ($section['total_devices'] / $maxDevices) * 100 : 0;
              ?>
              <div class="p-4 bg-gradient-to-br <?php echo $color['bg']; ?> rounded-xl border <?php echo $color['border']; ?>">
                <div class="flex items-center justify-between mb-3">
                  <div class="flex items-center space-x-3">
                    <i class="fas fa-building <?php echo $color['text']; ?>"></i>
                    <span class="font-medium text-gray-800"><?php echo htmlspecialchars($section['section_name']); ?></span>
                  </div>
                  <span class="text-2xl font-bold <?php echo $color['text']; ?>"><?php echo $section['total_devices']; ?></span>
                </div>
                <div class="w-full <?php echo $color['progressBg']; ?> rounded-full h-2">
                  <div class="<?php echo $color['progress']; ?> h-2 rounded-full" style="width: <?php echo $percentage; ?>%"></div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-span-3 text-center py-8 text-gray-500">
              <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
              <p class="text-lg font-medium">No sections found</p>
              <p class="text-sm">Add sections to see device distribution</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Issue Priority and User Stats -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Issue Priority Breakdown -->
        <div
          class="bg-white rounded-2xl p-6 shadow-sm animate-fade-up"
          style="animation-delay: 1.2s">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Issue Priority Status
          </h3>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <span class="text-gray-700">High Priority</span>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-32 bg-gray-200 rounded-full h-2">
                  <div
                    class="bg-red-500 h-2 rounded-full"
                    style="width: <?php echo $totalPriorityIssues > 0 ? ($highPriorityIssues / $totalPriorityIssues * 100) : 0; ?>%"></div>
                </div>
                <span class="font-semibold text-gray-800 w-8"><?php echo $highPriorityIssues; ?></span>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                <span class="text-gray-700">Medium Priority</span>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-32 bg-gray-200 rounded-full h-2">
                  <div
                    class="bg-orange-500 h-2 rounded-full"
                    style="width: <?php echo $totalPriorityIssues > 0 ? ($mediumPriorityIssues / $totalPriorityIssues * 100) : 0; ?>%"></div>
                </div>
                <span class="font-semibold text-gray-800 w-8"><?php echo $mediumPriorityIssues; ?></span>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                <span class="text-gray-700">Low Priority</span>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-32 bg-gray-200 rounded-full h-2">
                  <div
                    class="bg-yellow-500 h-2 rounded-full"
                    style="width: <?php echo $totalPriorityIssues > 0 ? ($lowPriorityIssues / $totalPriorityIssues * 100) : 0; ?>%"></div>
                </div>
                <span class="font-semibold text-gray-800 w-8"><?php echo $lowPriorityIssues; ?></span>
              </div>
            </div>
          </div>
        </div>

        <!-- User Statistics -->
        <div
          class="bg-white rounded-2xl p-6 shadow-sm animate-fade-up"
          style="animation-delay: 1.3s">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">
            System Users
          </h3>
          <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-blue-50 rounded-xl text-center">
              <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
              <h4 class="text-2xl font-bold text-gray-800">
                <?php echo $totalUsers; ?>
              </h4>
              <p class="text-sm text-gray-600">Total Users</p>
            </div>
            <div class="p-4 bg-green-50 rounded-xl text-center">
              <i class="fas fa-user-check text-green-600 text-2xl mb-2"></i>
              <h4 class="text-2xl font-bold text-gray-800">
                <?php echo $activeUsers; ?>
              </h4>
              <p class="text-sm text-gray-600">Active Users</p>
            </div>
            <div class="p-4 bg-purple-50 rounded-xl text-center">
              <i class="fas fa-user-shield text-purple-600 text-2xl mb-2"></i>
              <h4 class="text-2xl font-bold text-gray-800">
                <?php echo $adminUsers; ?>
              </h4>
              <p class="text-sm text-gray-600">Admins</p>
            </div>
            <div class="p-4 bg-indigo-50 rounded-xl text-center">
              <i class="fas fa-user text-indigo-600 text-2xl mb-2"></i>
              <h4 class="text-2xl font-bold text-gray-800"><?php echo $regularUsers; ?></h4>
              <p class="text-sm text-gray-600">Regular Users</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    mobileMenuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
      if (
        window.innerWidth < 1024 &&
        !sidebar.contains(e.target) &&
        !mobileMenuBtn.contains(e.target)
      ) {
        sidebar.classList.add('-translate-x-full');
      }
    });

    // Device Distribution Chart
    const ctx = document.getElementById('deviceChart').getContext('2d');
    const deviceData = {
      desktops: <?php echo $computersCount; ?>,
      laptops: <?php echo $laptopsCount; ?>,
      printers: <?php echo $printersCount; ?>,
      fingerprint: <?php echo $fingerprintCount; ?>,
      rvpn: <?php echo $rvpnCount; ?>,
      others: <?php echo $otherDevicesCount; ?>,
    };
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Desktop Computers', 'Laptops', 'Printers', 'Fingerprint', 'RVPN', 'Other Devices'],
        datasets: [{
          data: [
            deviceData.desktops,
            deviceData.laptops,
            deviceData.printers,
            deviceData.fingerprint,
            deviceData.rvpn,
            deviceData.others
          ],
          backgroundColor: [
            'rgba(59, 130, 246, 0.8)',
            'rgba(99, 102, 241, 0.8)',
            'rgba(147, 51, 234, 0.8)',
            'rgba(20, 184, 166, 0.8)',
            'rgba(244, 63, 94, 0.8)',
            'rgba(251, 191, 36, 0.8)',
          ],
          borderWidth: 0,
          hoverOffset: 10,
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              font: {
                size: 12,
              },
              usePointStyle: true,
              pointStyle: 'circle',
            },
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            cornerRadius: 8,
            titleFont: {
              size: 14,
            },
            bodyFont: {
              size: 13,
            },
            callbacks: {
              label: function(context) {
                let label = context.label || '';
                let value = context.parsed || 0;
                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                let percentage = ((value / total) * 100).toFixed(1);
                return label + ': ' + value + ' (' + percentage + '%)';
              },
            },
          },
        },
        animation: {
          animateRotate: true,
          animateScale: true,
          duration: 1500,
          easing: 'easeInOutQuart',
        },
      },
    });

    // Add staggered animation to elements
    document.addEventListener('DOMContentLoaded', () => {
      const animatedElements = document.querySelectorAll('.animate-fade-up');
      animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        setTimeout(() => {
          el.style.opacity = '1';
        }, index * 100);
      });
    });
  </script>
</body>

</html>