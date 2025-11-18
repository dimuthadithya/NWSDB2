<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch printers data
$printers = DbHelper::getAllPrinters();
$sections = DbHelper::getAllSections();
$waterSupplySchemes = DbHelper::getAllWaterSupplySchemes();
$categories = DbHelper::getAllDeviceCategories();

// Get printer category ID
$printerCategoryId = null;
foreach ($categories as $category) {
  if ($category['category_name'] === 'Printer') {
    $printerCategoryId = $category['category_id'];
    break;
  }
}

$totalPrinters = $printers ? count($printers) : 0;
$activePrinters = $printers ? count(array_filter($printers, fn($p) => $p['status'] === 'active')) : 0;
$repairPrinters = $printers ? count(array_filter($printers, fn($p) => $p['status'] === 'under_repair')) : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - Printer Management</title>
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

    .stat-card:hover {
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

    <div class="p-6 space-y-6">
      <!-- Success/Error Messages -->
      <?php if (isset($_SESSION['success_message'])): ?>
        <div id="successMessage" class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <p class="text-green-700 font-medium"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
          </div>
        </div>
        <?php unset($_SESSION['success_message']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error_message'])): ?>
        <div id="errorMessage" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md animate-fade-up">
          <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
            <p class="text-red-700 font-medium"><?= htmlspecialchars($_SESSION['error_message']) ?></p>
          </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
      <?php endif; ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up">
          <i class="fas fa-print text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1"><?php echo $totalPrinters; ?></h3>
          <p class="text-blue-100 text-sm">Total Printers</p>
        </div>
        <div
          class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.1s">
          <i class="fas fa-check-circle text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1"><?php echo $activePrinters; ?></h3>
          <p class="text-green-100 text-sm">Active Devices</p>
        </div>
        <div
          class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.2s">
          <i class="fas fa-wrench text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1"><?php echo $repairPrinters; ?></h3>
          <p class="text-orange-100 text-sm">Under Repair</p>
        </div>
        <div
          class="stat-card bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg animate-fade-up"
          style="animation-delay: 0.3s">
          <i class="fas fa-exclamation-triangle text-2xl"></i>
          <h3 class="text-3xl font-bold mt-4 mb-1">1</h3>
          <p class="text-red-100 text-sm">Low Toner</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          onclick="openAddPrinterModal()"
          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
          <i class="fas fa-plus mr-2"></i>
          Add New Printer
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
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up">
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
                  Filter Printers
                </h3>

                <p class="text-sm text-gray-600">
                  Refine your search results
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-print text-blue-600 mr-2"></i>Printer
                Type</label>

              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white">
                <option value="">All Types</option>

                <option value="laser">Laser</option>

                <option value="inkjet">Inkjet</option>

                <option value="dot-matrix">Dot Matrix</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-circle-dot text-blue-600 mr-2"></i>Status</label>

              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white">
                <option value="">All Status</option>

                <option value="active">Active</option>

                <option value="under_repair">Under Repair</option>

                <option value="retired">Retired</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-building text-blue-600 mr-2"></i>Section</label>

              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white">
                <option value="">All Sections</option>

                <option value="it">IT Department</option>

                <option value="hr">HR Department</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-network-wired text-blue-600 mr-2"></i>Connectivity</label>

              <select
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white">
                <option value="">All</option>

                <option value="usb">USB</option>

                <option value="network">Network</option>

                <option value="wifi">Wi-Fi</option>
              </select>
            </div>
          </div>

          <div class="mt-4 flex justify-end gap-3">
            <button
              class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
              Reset
            </button>

            <button
              class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
              Apply Filters
            </button>
          </div>
        </div>
      </div>

      <div
        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden animate-fade-up">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
              <tr>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Basic Info
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Specifications
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Status
                </th>
                <th
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Assignment
                </th>
                <th
                  class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (empty($printers)): ?>
                <tr>
                  <td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                      <i class="fas fa-print text-5xl mb-3 text-gray-300"></i>
                      <p class="text-lg font-medium">No printers found</p>
                      <p class="text-sm">Click "Add New Printer" to add your first device</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($printers as $printer): ?>
                  <tr class="table-row">
                    <td class="px-6 py-4">
                      <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                          <i class="fas fa-print text-blue-600"></i>
                        </div>
                        <div>
                          <div class="text-sm font-semibold text-gray-900">
                            <?= htmlspecialchars($printer['device_name'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-500"><?= htmlspecialchars($printer['model'] ?? 'N/A') ?></div>
                          <div class="text-xs text-gray-500 mt-1">
                            ID: <?= htmlspecialchars($printer['device_id'] ?? 'N/A') ?>
                          </div>
                          <div class="text-xs text-gray-400">
                            Created: <?= date('M d, Y', strtotime($printer['created_at'])) ?>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm space-y-1">
                        <div class="flex items-center">
                          <i class="fas fa-tag text-gray-400 text-xs mr-2 w-4"></i>
                          <span class="text-gray-700">Type: <?= htmlspecialchars($printer['printer_type'] ?? 'N/A') ?></span>
                        </div>
                        <div class="flex items-center">
                          <i class="fas fa-palette text-gray-400 text-xs mr-2 w-4"></i>
                          <span class="text-gray-700">Color: <?= htmlspecialchars($printer['color_capability'] ?? 'N/A') ?></span>
                        </div>
                        <div class="flex items-center">
                          <i class="fas fa-file-alt text-gray-400 text-xs mr-2 w-4"></i>
                          <span class="text-gray-700">Paper: <?= htmlspecialchars($printer['paper_size'] ?? 'N/A') ?></span>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <?php
                      $statusClass = '';
                      $statusText = ucfirst(str_replace('_', ' ', $printer['status'] ?? 'unknown'));
                      switch ($printer['status']) {
                        case 'active':
                          $statusClass = 'bg-green-100 text-green-800';
                          break;
                        case 'under_repair':
                          $statusClass = 'bg-yellow-100 text-yellow-800';
                          break;
                        case 'retired':
                          $statusClass = 'bg-gray-100 text-gray-800';
                          break;
                        default:
                          $statusClass = 'bg-gray-100 text-gray-800';
                      }
                      ?>
                      <div class="flex items-center">
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full <?= $statusClass ?>"><?= $statusText ?></span>
                      </div>
                      <div class="text-sm text-gray-600 mt-1">Speed: <?= htmlspecialchars($printer['print_speed'] ?? 'N/A') ?></div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm mb-2">
                        <div class="font-medium text-gray-900"><?= htmlspecialchars($printer['section_name'] ?? 'Unassigned') ?></div>
                        <div class="text-gray-600 text-xs"><?= htmlspecialchars($printer['assigned_to'] ?? 'Not assigned') ?></div>
                      </div>
                      <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full <?= $statusClass ?>">
                        <i class="fas fa-circle text-xs mr-1"></i><?= $statusText ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <div class="flex items-center justify-end space-x-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($printer)) ?>)" class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDelete(<?= $printer['device_id'] ?>, '<?= htmlspecialchars($printer['device_name'], ENT_QUOTES) ?>')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
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
      </div>
    </div>
  </main>

  <!-- Add Printer Modal -->
  <div id="addPrinterModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-print text-white text-xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Add New Printer</h3>
            <p class="text-sm text-gray-600">Enter printer details and specifications</p>
          </div>
        </div>
        <button onclick="closeAddPrinterModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="flex-1 overflow-y-auto p-6">
        <form id="addPrinterForm" method="POST" action="admin/handlers/printer-handler.php" class="space-y-6">
          <input type="hidden" name="action" value="create">
          <input type="hidden" name="category_id" value="<?= $printerCategoryId ?>">

          <!-- Basic Information -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-info-circle text-blue-600 mr-2"></i>
              Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Device Name *</label>
                <input type="text" name="device_name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="e.g., HP LaserJet Pro" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                <input type="text" name="model" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="e.g., M404dn" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number</label>
                <input type="text" name="system_unit_serial" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="Enter serial number" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                <input type="date" name="purchase_date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" />
              </div>
            </div>
          </div>

          <!-- Assignment Information -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-users text-blue-600 mr-2"></i>
              Assignment Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WSS *</label>
                <select name="wss_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                  <option value="">Select WSS</option>
                  <?php if ($waterSupplySchemes): ?>
                    <?php foreach ($waterSupplySchemes as $wss): ?>
                      <option value="<?= $wss['wss_id'] ?>"><?= htmlspecialchars($wss['wss_name']) ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
                <select name="section_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                  <option value="">Select Section</option>
                  <?php if ($sections): ?>
                    <?php foreach ($sections as $section): ?>
                      <option value="<?= $section['section_id'] ?>"><?= htmlspecialchars($section['section_name']) ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
                <input type="text" name="assigned_to" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="Enter user name" />
              </div>
            </div>
          </div>

          <!-- Printer Specifications -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-cog text-blue-600 mr-2"></i>
              Printer Specifications
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Printer Type</label>
                <input type="text" name="device_type" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="e.g., Laser, Inkjet, Dot Matrix" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Make/Brand</label>
                <input type="text" name="make" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="e.g., HP, Canon, Epson" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">IP Address</label>
                <input type="text" name="ip_address" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="e.g., 192.168.1.100" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Network Connectivity</label>
                <input type="text" name="network_connectivity" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="e.g., Ethernet, WiFi, USB" />
              </div>
            </div>
          </div>

          <!-- Additional Info -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
              Additional Information
            </h4>
            <div class="grid grid-cols-1 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                  <option value="active">Active</option>
                  <option value="under_repair">Under Repair</option>
                  <option value="retired">Retired</option>
                  <option value="lost">Lost</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="Additional notes..."></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
        <button onclick="closeAddPrinterModal()" type="button" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button type="button" onclick="document.getElementById('addPrinterForm').reset()" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="fas fa-refresh mr-2"></i>Reset
        </button>
        <button type="submit" form="addPrinterForm" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg">
          <i class="fas fa-save mr-2"></i>Save Printer
        </button>
      </div>
    </div>
  </div>

  <!-- Edit Printer Modal -->
  <div id="editPrinterModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-edit text-white text-xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Edit Printer</h3>
            <p class="text-sm text-gray-600">Update printer details and specifications</p>
          </div>
        </div>
        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="flex-1 overflow-y-auto p-6">
        <form id="editPrinterForm" method="POST" action="admin/handlers/printer-handler.php" class="space-y-6">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="device_id" id="edit_device_id">
          <input type="hidden" name="category_id" value="<?= $printerCategoryId ?>">

          <!-- Basic Information -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-info-circle text-green-600 mr-2"></i>
              Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Device Name *</label>
                <input type="text" name="device_name" id="edit_device_name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                <input type="text" name="model" id="edit_model" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number</label>
                <input type="text" name="system_unit_serial" id="edit_system_unit_serial" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                <input type="date" name="purchase_date" id="edit_purchase_date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
            </div>
          </div>

          <!-- Assignment Information -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-users text-green-600 mr-2"></i>
              Assignment Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">WSS *</label>
                <select name="wss_id" id="edit_wss_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                  <option value="">Select WSS</option>
                  <?php if ($waterSupplySchemes): ?>
                    <?php foreach ($waterSupplySchemes as $wss): ?>
                      <option value="<?= $wss['wss_id'] ?>"><?= htmlspecialchars($wss['wss_name']) ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Section</label>
                <select name="section_id" id="edit_section_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                  <option value="">Select Section</option>
                  <?php if ($sections): ?>
                    <?php foreach ($sections as $section): ?>
                      <option value="<?= $section['section_id'] ?>"><?= htmlspecialchars($section['section_name']) ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
                <input type="text" name="assigned_to" id="edit_assigned_to" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" placeholder="Enter user name" />
              </div>
            </div>
          </div>

          <!-- Printer Specifications -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-cog text-green-600 mr-2"></i>
              Printer Specifications
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Printer Type</label>
                <input type="text" name="device_type" id="edit_device_type" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Make/Brand</label>
                <input type="text" name="make" id="edit_make" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">IP Address</label>
                <input type="text" name="ip_address" id="edit_ip_address" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Network Connectivity</label>
                <input type="text" name="network_connectivity" id="edit_network_connectivity" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all" />
              </div>
            </div>
          </div>

          <!-- Additional Info -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <i class="fas fa-clipboard-list text-green-600 mr-2"></i>
              Additional Information
            </h4>
            <div class="grid grid-cols-1 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="edit_status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all">
                  <option value="active">Active</option>
                  <option value="under_repair">Under Repair</option>
                  <option value="retired">Retired</option>
                  <option value="lost">Lost</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" id="edit_notes" rows="3" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
        <button onclick="closeEditModal()" type="button" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="fas fa-times mr-2"></i>Cancel
        </button>
        <button type="submit" form="editPrinterForm" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg">
          <i class="fas fa-save mr-2"></i>Update Printer
        </button>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deletePrinterModal" class="hidden fixed inset-0 overflow-y-auto h-full w-full z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-red-50 to-pink-50">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-trash text-white text-xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Delete Printer</h3>
          </div>
        </div>
        <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6">
        <div class="mb-6">
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex">
              <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-3"></i>
              <div>
                <h4 class="text-red-800 font-medium mb-1">Warning: This action cannot be undone</h4>
                <p class="text-red-700 text-sm">Are you sure you want to delete this printer?</p>
              </div>
            </div>
          </div>
        </div>

        <form id="deletePrinterForm" method="POST" action="admin/handlers/printer-handler.php">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="device_id" id="delete_device_id">

          <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-600 mb-2">Printer Name:</p>
            <p class="font-semibold text-gray-900" id="delete_printer_name"></p>
          </div>

          <div class="flex items-center justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
              <i class="fas fa-times mr-2"></i>Cancel
            </button>
            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-pink-600 rounded-lg hover:from-red-700 hover:to-pink-700 transition-all shadow-lg">
              <i class="fas fa-trash mr-2"></i>Delete Printer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Auto-hide messages after 5 seconds
    setTimeout(() => {
      const successMessage = document.getElementById('successMessage');
      const errorMessage = document.getElementById('errorMessage');
      if (successMessage) successMessage.style.display = 'none';
      if (errorMessage) errorMessage.style.display = 'none';
    }, 5000);

    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
      document
        .getElementById('sidebar')
        .classList.toggle('-translate-x-full');
    });

    // Add Printer Modal functions
    function openAddPrinterModal() {
      document.getElementById('addPrinterModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeAddPrinterModal() {
      document.getElementById('addPrinterModal').classList.add('hidden');
      document.getElementById('addPrinterForm').reset();
      document.body.style.overflow = 'auto';
    }

    // Edit Printer Modal functions
    function openEditModal(printer) {
      document.getElementById('edit_device_id').value = printer.device_id;
      document.getElementById('edit_device_name').value = printer.device_name || '';
      document.getElementById('edit_model').value = printer.model || '';
      document.getElementById('edit_system_unit_serial').value = printer.system_unit_serial || '';
      document.getElementById('edit_purchase_date').value = printer.purchase_date || '';
      document.getElementById('edit_wss_id').value = printer.wss_id || '';
      document.getElementById('edit_section_id').value = printer.section_id || '';
      document.getElementById('edit_assigned_to').value = printer.assigned_to || '';
      document.getElementById('edit_device_type').value = printer.device_type || '';
      document.getElementById('edit_make').value = printer.make || '';
      document.getElementById('edit_ip_address').value = printer.ip_address || '';
      document.getElementById('edit_network_connectivity').value = printer.network_connectivity || '';
      document.getElementById('edit_status').value = printer.status || 'active';
      document.getElementById('edit_notes').value = printer.notes || '';

      document.getElementById('editPrinterModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
      document.getElementById('editPrinterModal').classList.add('hidden');
      document.getElementById('editPrinterForm').reset();
      document.body.style.overflow = 'auto';
    }

    // Delete Printer Modal functions
    function confirmDelete(deviceId, deviceName) {
      document.getElementById('delete_device_id').value = deviceId;
      document.getElementById('delete_printer_name').textContent = deviceName;
      document.getElementById('deletePrinterModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
      document.getElementById('deletePrinterModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    // Close modals on background click
    document.getElementById('addPrinterModal').addEventListener('click', (e) => {
      if (e.target.id === 'addPrinterModal') closeAddPrinterModal();
    });

    document.getElementById('editPrinterModal').addEventListener('click', (e) => {
      if (e.target.id === 'editPrinterModal') closeEditModal();
    });

    document.getElementById('deletePrinterModal').addEventListener('click', (e) => {
      if (e.target.id === 'deletePrinterModal') closeDeleteModal();
    });

    // Close modals on ESC key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeAddPrinterModal();
        closeEditModal();
        closeDeleteModal();
      }
    });
  </script>
</body>

</html>