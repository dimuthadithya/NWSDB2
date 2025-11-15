<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch computers data
$computers = DbHelper::getAllComputers();
$totalComputers = $computers ? count($computers) : 0;
$activeComputers = $computers ? count(array_filter($computers, fn($c) => $c['status'] === 'active')) : 0;
$repairComputers = $computers ? count(array_filter($computers, fn($c) => $c['status'] === 'under_repair')) : 0;
$retiredComputers = $computers ? count(array_filter($computers, fn($c) => $c['status'] === 'retired')) : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Computer Management</title>
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

    <!-- Content -->
    <div class="p-6 space-y-6">
      <!-- Summary Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.1s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-desktop text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Total</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $totalComputers; ?></h3>
          <p class="text-blue-100 text-sm">Total Computers</p>
        </div>

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
          <h3 class="text-3xl font-bold mb-1"><?php echo $activeComputers; ?></h3>
          <p class="text-green-100 text-sm">Active Devices</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-wrench text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Repair</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $repairComputers; ?></h3>
          <p class="text-orange-100 text-sm">Under Repair</p>
        </div>

        <div
          class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.4s">
          <div class="flex items-center justify-between mb-4">
            <div
              class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <i class="fas fa-ban text-2xl"></i>
            </div>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Retired</span>
          </div>
          <h3 class="text-3xl font-bold mb-1"><?php echo $retiredComputers; ?></h3>
          <p class="text-purple-100 text-sm">Retired Devices</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddComputerModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Computer
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

      <!-- Filter Section -->
      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up mb-8">
        <div
          class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-filter text-white"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">
                  Filter Devices
                </h3>
                <p class="text-sm text-gray-600">
                  Refine your search results
                </p>
              </div>
            </div>
            <button
              onclick="clearFilters()"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
              <i class="fas fa-times mr-2"></i>Clear All
            </button>
          </div>
        </div>

        <div class="p-6">
          <!-- Quick Search -->
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Quick Search</label>
            <div class="relative">
              <input
                type="text"
                placeholder="Search by name, model, or serial number..."
                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" />
              <i
                class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
          </div>

          <!-- Filters Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Device Type -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-desktop text-blue-600 mr-2"></i>Device Type
              </label>
              <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                  <input
                    type="checkbox"
                    class="form-checkbox text-blue-600 rounded focus:ring-blue-500" />
                  <span class="ml-2 text-gray-700">Desktop</span>
                </label>
                <label class="inline-flex items-center">
                  <input
                    type="checkbox"
                    class="form-checkbox text-blue-600 rounded focus:ring-blue-500" />
                  <span class="ml-2 text-gray-700">Laptop</span>
                </label>
              </div>
            </div>

            <!-- Status -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-circle-dot text-blue-600 mr-2"></i>Status
              </label>
              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                <option value="">All Status</option>
                <option value="active">✓ Active</option>
                <option value="under_repair">⚠ Under Repair</option>
                <option value="retired">✕ Retired</option>
                <option value="lost">🔴 Lost</option>
              </select>
            </div>

            <!-- Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-building text-blue-600 mr-2"></i>Section
              </label>
              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                <option value="">All Sections</option>
                <option value="it">IT Department</option>
                <option value="hr">HR Department</option>
                <option value="finance">Finance</option>
                <option value="operations">Operations</option>
              </select>
            </div>

            <!-- Processor -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-microchip text-blue-600 mr-2"></i>Processor
              </label>
              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                <option value="">All Processors</option>
                <option value="intel_i3">Intel i3</option>
                <option value="intel_i5">Intel i5</option>
                <option value="intel_i7">Intel i7</option>
                <option value="amd">AMD Ryzen</option>
              </select>
            </div>
          </div>

          <!-- Buttons -->
          <div class="mt-4 flex justify-end gap-3">
            <button
              class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
              <i class="fas fa-rotate-right mr-2"></i>Reset
            </button>
            <button
              class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
              <i class="fas fa-check mr-2"></i>Apply Filters
            </button>
          </div>
        </div>
      </div>
      <!-- Computers Table -->
      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up"
        style="animation-delay: 0.6s">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
              <tr>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-info-circle mr-2 text-blue-600"></i>Basic
                  Info
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-microchip mr-2 text-blue-600"></i>Hardware
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-desktop mr-2 text-blue-600"></i>System
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-network-wired mr-2 text-blue-600"></i>Network
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-user mr-2 text-blue-600"></i>Assignment
                </th>
                <th
                  class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  <i class="fas fa-cog mr-2 text-blue-600"></i>Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (empty($computers)): ?>
                <tr>
                  <td colspan="6" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                      <i class="fas fa-desktop text-5xl mb-3 text-gray-300"></i>
                      <p class="text-lg font-medium">No computers found</p>
                      <p class="text-sm">Click "Add New Computer" to add your first device</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($computers as $computer): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4">
                      <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                          <i class="fas fa-desktop text-blue-600"></i>
                        </div>
                        <div>
                          <div class="text-sm font-semibold text-gray-900">
                            <?= htmlspecialchars($computer['device_name'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-500">
                            <?= htmlspecialchars($computer['model'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-500 mt-1">
                            ID: <?= htmlspecialchars($computer['device_id'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-400">
                            Created: <?= date('M d, Y', strtotime($computer['created_at'])) ?>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm space-y-1">
                        <div class="flex items-center">
                          <i class="fas fa-microchip text-gray-400 text-xs mr-2 w-4"></i>
                          <span class="text-gray-700"><?= htmlspecialchars($computer['processor'] ?? 'N/A') ?></span>
                        </div>
                        <div class="flex items-center">
                          <i class="fas fa-memory text-gray-400 text-xs mr-2 w-4"></i>
                          <span class="text-gray-700"><?= htmlspecialchars($computer['ram'] ?? 'N/A') ?></span>
                        </div>
                        <div class="flex items-center">
                          <i class="fas fa-hdd text-gray-400 text-xs mr-2 w-4"></i>
                          <span class="text-gray-700"><?= htmlspecialchars($computer['storage'] ?? 'N/A') ?></span>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm space-y-1">
                        <div class="text-gray-700"><?= htmlspecialchars($computer['operating_system'] ?? 'N/A') ?></div>
                        <div class="text-gray-600 text-xs">Monitor: <?= htmlspecialchars($computer['monitor_type'] ?? 'N/A') ?></div>
                        <div class="text-gray-600 text-xs">KB: <?= htmlspecialchars($computer['keyboard'] ?? 'N/A') ?></div>
                        <div class="text-gray-600 text-xs">Mouse: <?= htmlspecialchars($computer['mouse'] ?? 'N/A') ?></div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm space-y-1">
                        <div class="flex items-center">
                          <i class="fas fa-network-wired text-gray-400 text-xs mr-2"></i>
                          <span class="text-gray-700"><?= htmlspecialchars($computer['ip_address'] ?? 'N/A') ?></span>
                        </div>
                        <div class="text-gray-600 text-xs"><?= htmlspecialchars($computer['network_type'] ?? 'N/A') ?></div>
                        <div class="text-gray-600 text-xs"><?= htmlspecialchars($computer['antivirus'] ?? 'N/A') ?></div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm mb-2">
                        <div class="font-medium text-gray-900"><?= htmlspecialchars($computer['section_id'] ?? 'Unassigned') ?></div>
                        <div class="text-gray-600 text-xs"><?= htmlspecialchars($computer['assigned_to'] ?? 'Not assigned') ?></div>
                      </div>
                      <?php
                      $statusClass = '';
                      $statusText = ucfirst(str_replace('_', ' ', $computer['status'] ?? 'unknown'));
                      switch ($computer['status']) {
                        case 'active':
                          $statusClass = 'bg-green-100 text-green-800';
                          break;
                        case 'under_repair':
                          $statusClass = 'bg-yellow-100 text-yellow-800';
                          break;
                        case 'retired':
                          $statusClass = 'bg-gray-100 text-gray-800';
                          break;
                        case 'lost':
                          $statusClass = 'bg-red-100 text-red-800';
                          break;
                        default:
                          $statusClass = 'bg-gray-100 text-gray-800';
                      }
                      ?>
                      <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full <?= $statusClass ?>">
                        <i class="fas fa-circle text-xs mr-1"></i><?= $statusText ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <div class="flex items-center justify-end space-x-2">
                        <button
                          class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                          title="View Details">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button
                          class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                          title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                          title="Delete">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Showing <span class="font-medium">1</span> to
              <span class="font-medium">4</span> of
              <span class="font-medium">42</span> results
            </div>
            <nav class="flex items-center space-x-2">
              <button
                class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-chevron-left"></i>
              </button>
              <button
                class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
                1
              </button>
              <button
                class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                2
              </button>
              <button
                class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                3
              </button>
              <span class="px-2 text-gray-500">...</span>
              <button
                class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                11
              </button>
              <button
                class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-chevron-right"></i>
              </button>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Add Computer Modal -->
  <div
    id="addComputerModal"
    class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div
      class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl max-h-[90vh] overflow-hidden flex flex-col"
      onclick="event.stopPropagation()">
      <!-- Modal Header -->
      <div
        class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="flex items-center gap-3">
          <div
            class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-desktop text-white text-xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Add New Computer</h3>
            <p class="text-sm text-gray-600">
              Enter computer details and specifications
            </p>
          </div>
        </div>
        <button
          onclick="closeAddComputerModal()"
          class="text-gray-400 hover:text-gray-600 focus:outline-none">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="flex-1 overflow-y-auto p-6">
        <form id="addComputerForm" class="space-y-6">
          <!-- Basic Information -->
          <div>
            <h4
              class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-info-circle text-blue-600 mr-2"></i>
              Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Device Name *</label>
                <input
                  type="text"
                  name="device_name"
                  required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Desktop Computer" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                <input
                  type="text"
                  name="model"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Dell OptiPlex 7090" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                <input
                  type="date"
                  name="purchase_date"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" />
              </div>
            </div>
          </div>

          <!-- Assignment Information -->
          <div>
            <h4
              class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-users text-blue-600 mr-2"></i>
              Assignment Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
                <select
                  name="section_id"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                  <option value="">Select Section</option>
                  <option value="1">IT Department</option>
                  <option value="2">HR Department</option>
                  <option value="3">Finance</option>
                  <option value="4">Operations</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
                <select
                  name="assigned_to"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                  <option value="">Select User</option>
                  <option value="1">John Smith</option>
                  <option value="2">Jane Doe</option>
                  <option value="3">Michael Johnson</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Hardware Specifications -->
          <div>
            <h4
              class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-microchip text-blue-600 mr-2"></i>
              Hardware Specifications
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Operating System</label>
                <input
                  type="text"
                  name="operating_system"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Windows 11 Pro" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Processor</label>
                <input
                  type="text"
                  name="processor"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Intel i7-12700" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">RAM</label>
                <input
                  type="text"
                  name="ram"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., 16GB DDR4" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Storage</label>
                <input
                  type="text"
                  name="hard_drive_capacity"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., 512GB SSD" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keyboard</label>
                <input
                  type="text"
                  name="keyboard"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Dell KB216" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mouse</label>
                <input
                  type="text"
                  name="mouse"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Dell MS116" />
              </div>
            </div>
          </div>

          <!-- Network & Connectivity -->
          <div>
            <h4
              class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-network-wired text-blue-600 mr-2"></i>
              Network & Connectivity
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">IP Address</label>
                <input
                  type="text"
                  name="ip_address"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., 192.168.1.100" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Network Connectivity</label>
                <input
                  type="text"
                  name="network_connectivity"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Ethernet, WiFi" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Printer Connectivity</label>
                <input
                  type="text"
                  name="printer_connectivity"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., USB, Network" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Virus Guard</label>
                <input
                  type="text"
                  name="virus_guard"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., Windows Defender" />
              </div>
            </div>
          </div>

          <!-- Additional Info -->
          <div>
            <h4
              class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
              Additional Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Monitor Info</label>
                <input
                  type="text"
                  name="monitor_info"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="e.g., 24 inch LED" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">UPS Serial</label>
                <input
                  type="text"
                  name="ups_serial"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="Enter CPU serial" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">System Unit Serial Number</label>
                <input
                  type="text"
                  name="system_unit_serial"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="Enter System Unit serial" />
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  name="status"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                  <option value="active">Active</option>
                  <option value="under_repair">Under Repair</option>
                  <option value="retired">Retired</option>
                  <option value="lost">Lost</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea
                  name="notes"
                  rows="3"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                  placeholder="Additional notes..."></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div
        class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
        <button
          onclick="closeAddComputerModal()"
          class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button
          onclick="document.getElementById('addComputerForm').reset()"
          class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="fas fa-refresh mr-2"></i>Reset
        </button>
        <button
          type="submit"
          form="addComputerForm"
          class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg">
          <i class="fas fa-save mr-2"></i>Save Computer
        </button>
      </div>
    </div>
  </div>

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

    // Modal functions
    function openAddComputerModal() {
      document.getElementById('addComputerModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeAddComputerModal() {
      document.getElementById('addComputerModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    function clearFilters() {
      document.querySelectorAll('input, select').forEach((el) => {
        if (el.type === 'text' || el.type === 'search') {
          el.value = '';
        } else if (el.tagName === 'SELECT') {
          el.selectedIndex = 0;
        }
      });
    }

    // Close modal on background click
    document
      .getElementById('addComputerModal')
      .addEventListener('click', (e) => {
        if (e.target.id === 'addComputerModal') {
          closeAddComputerModal();
        }
      });

    // Form submission
    document
      .getElementById('addComputerForm')
      .addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Computer added successfully!');
        closeAddComputerModal();
        document.getElementById('addComputerForm').reset();
      });
  </script>
</body>

</html>