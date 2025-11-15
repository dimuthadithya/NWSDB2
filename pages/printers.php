<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch printers data
$printers = DbHelper::getAllPrinters();
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
          onclick="openAddComputerModal()"
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
                        <div class="font-medium text-gray-900"><?= htmlspecialchars($printer['section_id'] ?? 'Unassigned') ?></div>
                        <div class="text-gray-600 text-xs"><?= htmlspecialchars($printer['assigned_to'] ?? 'Not assigned') ?></div>
                      </div>
                      <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full <?= $statusClass ?>">
                        <i class="fas fa-circle text-xs mr-1"></i><?= $statusText ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <div class="flex items-center justify-end space-x-2">
                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View Details">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
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

  <div
    id="addPrinterModal"
    class="hidden fixed inset-0 z-50 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl">
      <div class="flex items-center justify-between p-6 border-b">
        <h3 class="text-xl font-bold text-gray-900">Add New Printer</h3>
        <button
          onclick="closeAddPrinterModal()"
          class="text-gray-400 hover:text-gray-600">
          <i class="fas fa-times text-2xl"></i>
        </button>
      </div>
      <div class="p-6">
        <form id="addPrinterForm" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input
              type="text"
              placeholder="Printer Model"
              class="w-full px-4 py-2.5 rounded-lg border" />
            <input
              type="text"
              placeholder="Serial Number"
              class="w-full px-4 py-2.5 rounded-lg border" />
            <select class="w-full px-4 py-2.5 rounded-lg border">
              <option>Select Type</option>
              <option>Laser</option>
              <option>Inkjet</option>
              <option>Dot Matrix</option>
            </select>
            <select class="w-full px-4 py-2.5 rounded-lg border">
              <option>Select Status</option>
              <option>Active</option>
              <option>Under Repair</option>
              <option>Retired</option>
            </select>
          </div>
          <textarea
            placeholder="Notes..."
            rows="3"
            class="w-full px-4 py-2.5 rounded-lg border"></textarea>
        </form>
      </div>
      <div
        class="flex items-center justify-end gap-3 p-6 border-t bg-gray-50">
        <button
          onclick="closeAddPrinterModal()"
          class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border rounded-lg">
          Cancel
        </button>
        <button
          type="submit"
          form="addPrinterForm"
          class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg">
          Save Printer
        </button>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
      document
        .getElementById('sidebar')
        .classList.toggle('-translate-x-full');
    });

    function openAddPrinterModal() {
      document.getElementById('addPrinterModal').classList.remove('hidden');
    }

    function closeAddPrinterModal() {
      document.getElementById('addPrinterModal').classList.add('hidden');
    }
  </script>
</body>

</html>