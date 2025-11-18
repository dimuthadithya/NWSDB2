<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Get all device and system statistics
$totalDevices = DbHelper::getRowCount('devices');
$activeDevices = DbHelper::getRowCountWithCondition('devices', ['status' => 'active']);
$repairDevices = DbHelper::getRowCountWithCondition('devices', ['status' => 'under_repair']);
$retiredDevices = DbHelper::getRowCountWithCondition('devices', ['status' => 'retired']);
$lostDevices = DbHelper::getRowCountWithCondition('devices', ['status' => 'lost']);

// Calculate uptime percentage
$uptimeRate = $totalDevices > 0 ? round(($activeDevices / $totalDevices) * 100, 1) : 0;

// Get category counts
$laptopCatId = DbHelper::getCategoryId('laptop');
$desktopCatId = DbHelper::getCategoryId('Desktop Computer');
$printerId = DbHelper::getCategoryId('printer');
$otherId = DbHelper::getCategoryId('other');

$laptopsCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $laptopCatId]);
$computersCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $desktopCatId]);
$printersCount = DbHelper::getRowCountWithCondition('devices', ['category_id' => $printerId]);
$otherDevicesCount = $totalDevices - ($laptopsCount + $printersCount + $computersCount);

// Get user statistics
$totalUsers = DbHelper::getRowCount('users');
$activeUsers = DbHelper::getRowCountWithCondition('users', ['status' => 'active']);

// Get issue statistics
$totalIssues = DbHelper::getRowCount('device_issues');
$openIssues = DbHelper::getRowCountWithCondition('device_issues', ['status' => 'open']);
$inProgressIssues = DbHelper::getRowCountWithCondition('device_issues', ['status' => 'in_progress']);
$activeIssues = $openIssues + $inProgressIssues;

// Get repair statistics
$totalRepairs = DbHelper::getRowCount('repairs');
$pendingRepairs = DbHelper::getRowCountWithCondition('repairs', ['status' => 'pending']);
$completedRepairs = DbHelper::getRowCountWithCondition('repairs', ['status' => 'completed']);

// Get top sections by device count
$topSections = DbHelper::getSectionsByDeviceCount();
$top7Sections = $topSections ? array_slice($topSections, 0, 7) : [];

// Get recent activities
$recentActivities = DbHelper::getRecentActivities(10);

// Get issue priority counts
$issuePriorityCounts = DbHelper::getIssuePriorityCounts();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Summary Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- ApexCharts -->
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

    .chart-container {
      transition: all 0.3s ease;
    }

    .chart-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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

    <div class="p-6">
      <div class="flex justify-end mb-6">
        <div class="mt-4 md:mt-0 flex gap-3">
          <button
            onclick="window.print()"
            class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl shadow-sm hover:shadow-md transition-all text-gray-600">
            <i class="fas fa-print"></i>
            <span>Print Report</span>
          </button>
          <button
            id="refreshBtn"
            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:shadow-md transition-all">
            <i class="fas fa-sync-alt"></i>
            <span>Refresh Data</span>
          </button>
        </div>
      </div>

      <!-- System Health Overview -->
      <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div class="text-center">
            <div class="text-4xl font-bold mb-2"><?php echo number_format($totalDevices); ?></div>
            <div class="text-blue-100 text-sm">Total Devices</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold mb-2"><?php echo $uptimeRate; ?>%</div>
            <div class="text-blue-100 text-sm">System Uptime</div>
            <div class="mt-2">
              <div class="bg-white/20 rounded-full h-2">
                <div class="bg-green-400 h-2 rounded-full" style="width: <?php echo $uptimeRate; ?>%"></div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold mb-2"><?php echo $activeIssues; ?></div>
            <div class="text-blue-100 text-sm">Active Issues</div>
            <?php if ($activeIssues > 0): ?>
              <div class="text-xs mt-1 text-yellow-200">
                <i class="fas fa-exclamation-triangle"></i> Requires attention
              </div>
            <?php else: ?>
              <div class="text-xs mt-1 text-green-200">
                <i class="fas fa-check-circle"></i> All clear
              </div>
            <?php endif; ?>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold mb-2"><?php echo $activeUsers; ?></div>
            <div class="text-blue-100 text-sm">Active Users</div>
            <div class="text-xs mt-1 text-blue-200">
              <?php echo $totalUsers - $activeUsers; ?> inactive
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-desktop text-blue-600 text-xl"></i>
            </div>
            <span
              class="text-sm font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Devices</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($totalDevices); ?></h3>
          <p class="text-gray-500 text-sm">Total Devices</p>
          <div class="mt-4 flex items-center text-blue-600">
            <i class="fas fa-check-circle text-xs mr-1"></i>
            <span class="text-xs"><?php echo $activeDevices; ?> Active</span>
          </div>
        </div>
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <span
              class="text-sm font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg">Issues</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo $activeIssues; ?></h3>
          <p class="text-gray-500 text-sm">Active Issues</p>
          <div class="mt-4 flex items-center text-gray-600">
            <i class="fas fa-list text-xs mr-1"></i>
            <span class="text-xs"><?php echo $totalIssues; ?> Total</span>
          </div>
        </div>
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <span
              class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">Active</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo $uptimeRate; ?>%</h3>
          <p class="text-gray-500 text-sm">Device Uptime</p>
          <div class="mt-4 flex items-center text-green-600">
            <i class="fas fa-arrow-up text-xs mr-1"></i>
            <span class="text-xs"><?php echo $activeDevices; ?> / <?php echo $totalDevices; ?> operational</span>
          </div>
        </div>
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
            <span
              class="text-sm font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-lg">Users</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo $activeUsers; ?></h3>
          <p class="text-gray-500 text-sm">Active Users</p>
          <div class="mt-4 flex items-center text-purple-600">
            <i class="fas fa-user-check text-xs mr-1"></i>
            <span class="text-xs"><?php echo $totalUsers; ?> Total Users</span>
          </div>
        </div>
      </div>

      <!-- Additional Statistics Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Repairs -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Total Repairs</p>
              <h4 class="text-2xl font-bold text-gray-800"><?php echo $totalRepairs; ?></h4>
              <p class="text-xs text-gray-500 mt-1"><?php echo $pendingRepairs; ?> pending</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-wrench text-orange-600 text-xl"></i>
            </div>
          </div>
        </div>

        <!-- Completed Repairs -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Completed Repairs</p>
              <h4 class="text-2xl font-bold text-gray-800"><?php echo $completedRepairs; ?></h4>
              <p class="text-xs text-gray-500 mt-1">
                <?php echo $totalRepairs > 0 ? round(($completedRepairs / $totalRepairs) * 100, 1) : 0; ?>% completion rate
              </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-check-double text-green-600 text-xl"></i>
            </div>
          </div>
        </div>

        <!-- Under Repair -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">Under Repair</p>
              <h4 class="text-2xl font-bold text-gray-800"><?php echo $repairDevices; ?></h4>
              <p class="text-xs text-gray-500 mt-1">
                <?php echo $totalDevices > 0 ? round(($repairDevices / $totalDevices) * 100, 1) : 0; ?>% of devices
              </p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-tools text-yellow-600 text-xl"></i>
            </div>
          </div>
        </div>

        <!-- Issue Statistics -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 mb-1">High Priority Issues</p>
              <h4 class="text-2xl font-bold text-gray-800"><?php echo $issuePriorityCounts['high']; ?></h4>
              <p class="text-xs text-gray-500 mt-1">Requires immediate attention</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Device Distribution Chart -->
        <div class="chart-container bg-white p-6 rounded-2xl shadow-sm">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            Device Distribution
          </h3>
          <div class="h-80">
            <canvas id="deviceDistributionChart"></canvas>
          </div>
        </div>
        <!-- Issue Status Overview Chart -->
        <div class="chart-container bg-white p-6 rounded-2xl shadow-sm">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            Issue Status Overview
          </h3>
          <div class="h-80">
            <canvas id="monthlyIssuesChart"></canvas>
          </div>
        </div>
      </div>
      <!-- Device Status & Branch Distribution -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Device Status -->
        <div class="chart-container bg-white p-6 rounded-2xl shadow-sm">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            Device Status Overview
          </h3>
          <div class="h-80" id="deviceStatusChart"></div>
        </div>
        <!-- Section Distribution -->
        <div class="chart-container bg-white p-6 rounded-2xl shadow-sm">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            Section Distribution (Top 7)
          </h3>
          <div class="h-80" id="branchDistributionChart"></div>
        </div>
      </div>
      <!-- Recent Activity Table -->
      <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold text-gray-800">Recent Activity</h3>
          <span class="text-sm text-gray-500"><?php echo count($recentActivities); ?> recent activities</span>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b border-gray-100">
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date/Time
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Activity Type
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Description
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <?php if (!empty($recentActivities)): ?>
                <?php foreach ($recentActivities as $activity): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4 text-sm text-gray-600">
                      <?php echo date('Y-m-d H:i', strtotime($activity['time'])); ?>
                    </td>
                    <td class="px-6 py-4 text-sm">
                      <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-<?php echo $activity['color']; ?>-100 rounded-lg flex items-center justify-center">
                          <i class="fas <?php echo $activity['icon']; ?> text-<?php echo $activity['color']; ?>-600 text-xs"></i>
                        </div>
                        <span class="font-medium text-gray-900"><?php echo htmlspecialchars($activity['title']); ?></span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                      <?php echo htmlspecialchars($activity['description']); ?>
                    </td>
                    <td class="px-6 py-4">
                      <span class="px-2 py-1 text-xs font-medium bg-<?php echo $activity['color']; ?>-50 text-<?php echo $activity['color']; ?>-600 rounded-lg">
                        <?php echo ucfirst($activity['type']); ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p>No recent activities</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
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

    // Device Distribution Chart
    const deviceCtx = document
      .getElementById('deviceDistributionChart')
      .getContext('2d');
    new Chart(deviceCtx, {
      type: 'doughnut',
      data: {
        labels: ['Computers', 'Laptops', 'Printers', 'Other Devices'],
        datasets: [{
          data: [<?php echo $computersCount; ?>, <?php echo $laptopsCount; ?>, <?php echo $printersCount; ?>, <?php echo $otherDevicesCount; ?>],
          backgroundColor: [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(249, 115, 22, 0.8)',
            'rgba(139, 92, 246, 0.8)',
          ],
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.label || '';
                let value = context.parsed || 0;
                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                let percentage = ((value / total) * 100).toFixed(1);
                return label + ': ' + value + ' (' + percentage + '%)';
              }
            }
          }
        },
      },
    });

    // Issue Status Overview Chart
    const issuesCtx = document
      .getElementById('monthlyIssuesChart')
      .getContext('2d');
    new Chart(issuesCtx, {
      type: 'bar',
      data: {
        labels: ['High Priority', 'Medium Priority', 'Low Priority', 'Open', 'In Progress', 'Resolved', 'Closed'],
        datasets: [{
          label: 'Issues Count',
          data: [
            <?php echo $issuePriorityCounts['high']; ?>,
            <?php echo $issuePriorityCounts['medium']; ?>,
            <?php echo $issuePriorityCounts['low']; ?>,
            <?php echo $openIssues; ?>,
            <?php echo $inProgressIssues; ?>,
            <?php echo DbHelper::getRowCountWithCondition('device_issues', ['status' => 'resolved']); ?>,
            <?php echo DbHelper::getRowCountWithCondition('device_issues', ['status' => 'closed']); ?>
          ],
          backgroundColor: [
            'rgba(239, 68, 68, 0.8)',
            'rgba(251, 146, 60, 0.8)',
            'rgba(234, 179, 8, 0.8)',
            'rgba(234, 179, 8, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(34, 197, 94, 0.8)',
            'rgba(107, 114, 128, 0.8)'
          ],
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          },
        },
      },
    });

    // Device Status Chart (ApexCharts)
    const deviceStatusOptions = {
      series: [<?php echo $activeDevices; ?>, <?php echo $repairDevices; ?>, <?php echo $retiredDevices; ?>, <?php echo $lostDevices; ?>],
      chart: {
        type: 'donut',
        height: 320,
      },
      labels: ['Active', 'Under Repair', 'Retired', 'Lost'],
      colors: ['#10B981', '#F59E0B', '#6B7280', '#EF4444'],
      legend: {
        position: 'bottom',
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              total: {
                show: true,
                label: 'Total Devices',
                formatter: function(w) {
                  return <?php echo $totalDevices; ?>;
                }
              }
            }
          }
        }
      }
    };
    const deviceStatusChart = new ApexCharts(
      document.querySelector('#deviceStatusChart'),
      deviceStatusOptions
    );
    deviceStatusChart.render();

    // Section Distribution Chart (ApexCharts)
    const branchDistributionOptions = {
      series: [{
        name: 'Devices',
        data: [<?php echo !empty($top7Sections) ? implode(', ', array_column($top7Sections, 'total_devices')) : '0'; ?>],
      }],
      chart: {
        type: 'bar',
        height: 320,
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: true,
          distributed: false,
        },
      },
      dataLabels: {
        enabled: true,
      },
      colors: ['#3B82F6'],
      xaxis: {
        categories: [
          <?php
          if (!empty($top7Sections)) {
            echo "'" . implode("', '", array_map(function ($s) {
              return addslashes($s['section_name']);
            }, $top7Sections)) . "'";
          } else {
            echo "'No Data'";
          }
          ?>
        ],
      },
      title: {
        text: 'Top Sections by Device Count',
        align: 'left'
      }
    };
    const branchDistributionChart = new ApexCharts(
      document.querySelector('#branchDistributionChart'),
      branchDistributionOptions
    );
    branchDistributionChart.render();

    // Refresh Data Button
    document
      .getElementById('refreshBtn')
      .addEventListener('click', function() {
        this.classList.add('animate-spin');
        setTimeout(() => {
          location.reload();
        }, 500);
      });
  </script>
</body>

</html>