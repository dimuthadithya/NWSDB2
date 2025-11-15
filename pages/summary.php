<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

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
          <h3 class="text-2xl font-bold text-gray-800 mb-1">2,547</h3>
          <p class="text-gray-500 text-sm">Total Devices</p>
          <div class="mt-4 flex items-center text-green-600">
            <i class="fas fa-arrow-up text-xs mr-1"></i>
            <span class="text-xs">12% from last month</span>
          </div>
        </div>
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
              <i class="fas fa-tools text-red-600 text-xl"></i>
            </div>
            <span
              class="text-sm font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg">Issues</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-800 mb-1">48</h3>
          <p class="text-gray-500 text-sm">Active Issues</p>
          <div class="mt-4 flex items-center text-red-600">
            <i class="fas fa-arrow-down text-xs mr-1"></i>
            <span class="text-xs">8% from last week</span>
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
          <h3 class="text-2xl font-bold text-gray-800 mb-1">95.8%</h3>
          <p class="text-gray-500 text-sm">Uptime Rate</p>
          <div class="mt-4 flex items-center text-green-600">
            <i class="fas fa-arrow-up text-xs mr-1"></i>
            <span class="text-xs">2.3% improvement</span>
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
          <h3 class="text-2xl font-bold text-gray-800 mb-1">342</h3>
          <p class="text-gray-500 text-sm">Active Users</p>
          <div class="mt-4 flex items-center text-green-600">
            <i class="fas fa-arrow-up text-xs mr-1"></i>
            <span class="text-xs">5% new users</span>
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
        <!-- Monthly Issues Chart -->
        <div class="chart-container bg-white p-6 rounded-2xl shadow-sm">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            Monthly Issues Trend
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
        <!-- Branch Distribution -->
        <div class="chart-container bg-white p-6 rounded-2xl shadow-sm">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            Branch Distribution
          </h3>
          <div class="h-80" id="branchDistributionChart"></div>
        </div>
      </div>
      <!-- Recent Activity Table -->
      <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold text-gray-800">Recent Activity</h3>
          <a
            href="#"
            class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="border-b border-gray-100">
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Activity
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Device
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  User
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr class="table-row">
                <td class="px-6 py-4 text-sm text-gray-600">2025-10-31</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                  Device Registration
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  HP ProBook 450 G8
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">John Doe</td>
                <td class="px-6 py-4">
                  <span
                    class="px-2 py-1 text-xs font-medium bg-green-50 text-green-600 rounded-lg">Completed</span>
                </td>
              </tr>
              <!-- Add more rows as needed -->
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
          data: [45, 25, 20, 10],
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
        },
      },
    });

    // Monthly Issues Chart
    const issuesCtx = document
      .getElementById('monthlyIssuesChart')
      .getContext('2d');
    new Chart(issuesCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Issues Reported',
          data: [65, 59, 80, 81, 56, 55],
          borderColor: 'rgba(59, 130, 246, 1)',
          tension: 0.4,
          fill: true,
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
        }, ],
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
          },
        },
      },
    });

    // Device Status Chart (ApexCharts)
    const deviceStatusOptions = {
      series: [44, 55, 13, 43],
      chart: {
        type: 'donut',
        height: 320,
      },
      labels: ['Active', 'Under Repair', 'Retired', 'Lost'],
      colors: ['#10B981', '#F59E0B', '#6B7280', '#EF4444'],
      legend: {
        position: 'bottom',
      },
    };
    const deviceStatusChart = new ApexCharts(
      document.querySelector('#deviceStatusChart'),
      deviceStatusOptions
    );
    deviceStatusChart.render();

    // Branch Distribution Chart (ApexCharts)
    const branchDistributionOptions = {
      series: [{
        name: 'Devices',
        data: [44, 55, 57, 56, 61, 58, 63],
      }, ],
      chart: {
        type: 'bar',
        height: 320,
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: true,
        },
      },
      dataLabels: {
        enabled: false,
      },
      colors: ['#3B82F6'],
      xaxis: {
        categories: [
          'Main Office',
          'Branch A',
          'Branch B',
          'Branch C',
          'Branch D',
          'Branch E',
          'Branch F',
        ],
      },
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
          this.classList.remove('animate-spin');
        }, 1000);
      });
  </script>
</body>

</html>