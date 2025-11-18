<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

$role = $_SESSION['user']['role'];
$name = $_SESSION['user']['name'];

// Fetch issues from database
$issues = DbHelper::getAllIssues();
if (!$issues) {
    $issues = [];
}

// Fetch devices for dropdown
$devices = DbHelper::getAllDevices();
if (!$devices) {
    $devices = [];
}

// Calculate statistics
$totalIssues = count($issues);
$openIssues = count(array_filter($issues, function ($issue) {
    return $issue['status'] === 'open';
}));
$inProgressIssues = count(array_filter($issues, function ($issue) {
    return $issue['status'] === 'in_progress';
}));
$resolvedIssues = count(array_filter($issues, function ($issue) {
    return $issue['status'] === 'resolved';
}));
$closedIssues = count(array_filter($issues, function ($issue) {
    return $issue['status'] === 'closed';
}));
$highPriorityIssues = count(array_filter($issues, function ($issue) {
    return $issue['priority'] === 'high';
}));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NWSDB - Issue Management</title>
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
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <!-- Side Menu -->
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
            <!-- Session Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-up">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-xl mr-3"></i>
                        <p class="font-medium"><?= $_SESSION['success'];
                                                unset($_SESSION['success']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fade-up">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                        <p class="font-medium"><?= $_SESSION['error'];
                                                unset($_SESSION['error']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
                <!-- Total Issues -->
                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Issues</p>
                            <h3 class="text-3xl font-bold mt-2"><?= $totalIssues ?></h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-exclamation-circle text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Open -->
                <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Open</p>
                            <h3 class="text-3xl font-bold mt-2"><?= $openIssues ?></h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-folder-open text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">In Progress</p>
                            <h3 class="text-3xl font-bold mt-2"><?= $inProgressIssues ?></h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-spinner text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Resolved -->
                <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Resolved</p>
                            <h3 class="text-3xl font-bold mt-2"><?= $resolvedIssues ?></h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-check-circle text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Closed -->
                <div class="stat-card bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-100 text-sm font-medium">Closed</p>
                            <h3 class="text-3xl font-bold mt-2"><?= $closedIssues ?></h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-times-circle text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- High Priority -->
                <div class="stat-card bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium">High Priority</p>
                            <h3 class="text-3xl font-bold mt-2"><?= $highPriorityIssues ?></h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-exclamation-triangle text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Issues Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-list mr-2 text-blue-600"></i>Device Issues
                    </h2>
                    <button
                        onclick="openAddModal()"
                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md">
                        <i class="fas fa-plus mr-2"></i>Add Issue
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($issues)): ?>
                                <?php foreach ($issues as $issue): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #<?= htmlspecialchars($issue['issue_id']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <?= htmlspecialchars($issue['device_name']) ?>
                                            <?php if (!empty($issue['model'])): ?>
                                                <br><span class="text-xs text-gray-500"><?= htmlspecialchars($issue['model']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                            <div class="font-medium"><?= htmlspecialchars($issue['issue_title']) ?></div>
                                            <?php if (!empty($issue['issue_description'])): ?>
                                                <div class="text-gray-500 text-xs truncate"><?= htmlspecialchars($issue['issue_description']) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $priority = $issue['priority'] ?? 'medium';
                                            $priorityColors = [
                                                'low' => 'bg-blue-100 text-blue-800',
                                                'medium' => 'bg-yellow-100 text-yellow-800',
                                                'high' => 'bg-red-100 text-red-800'
                                            ];
                                            $priorityClass = $priorityColors[$priority] ?? 'bg-gray-100 text-gray-800';
                                            $priorityText = ucfirst($priority);
                                            ?>
                                            <span class="px-2 py-1 text-xs font-medium <?= $priorityClass ?> rounded-full">
                                                <?php if ($priority === 'high'): ?>
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                <?php endif; ?>
                                                <?= $priorityText ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $status = $issue['status'] ?? 'open';
                                            $statusColors = [
                                                'open' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'resolved' => 'bg-green-100 text-green-800',
                                                'closed' => 'bg-gray-100 text-gray-800'
                                            ];
                                            $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                            $statusText = ucwords(str_replace('_', ' ', $status));
                                            ?>
                                            <span class="px-2 py-1 text-xs font-medium <?= $statusClass ?> rounded-full"><?= $statusText ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <?php if (!empty($issue['first_name'])): ?>
                                                <?= htmlspecialchars($issue['first_name'] . ' ' . $issue['last_name']) ?>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <?= $issue['reported_at'] ? date('Y-m-d H:i', strtotime($issue['reported_at'])) : 'N/A' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button
                                                onclick='openEditModal(<?= json_encode($issue) ?>)'
                                                class="text-blue-600 hover:text-blue-900 mr-3"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                onclick="confirmDelete(<?= $issue['issue_id'] ?>, '<?= htmlspecialchars($issue['issue_title'], ENT_QUOTES) ?>')"
                                                class="text-red-600 hover:text-red-900"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2"></i>
                                        <p>No issues found</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Issue Modal -->
    <div
        id="addModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Report New Issue</h3>
                    <button
                        onclick="closeAddModal()"
                        class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form action="handlers/issue-handler.php" method="POST" class="p-6">
                <input type="hidden" name="action" value="create">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Device -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Device <span class="text-red-500">*</span></label>
                        <select
                            name="device_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Select Device</option>
                            <?php foreach ($devices as $device): ?>
                                <option value="<?= htmlspecialchars($device['device_id']) ?>">
                                    <?= htmlspecialchars($device['device_name']) ?>
                                    <?php if (!empty($device['model'])): ?>
                                        - <?= htmlspecialchars($device['model']) ?>
                                    <?php endif; ?>
                                    (<?= htmlspecialchars($device['category_name']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Issue Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Issue Title <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="issue_title"
                            placeholder="Brief description of the issue"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required />
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <select
                            name="priority"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select
                            name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="open" selected>Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <!-- Issue Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Issue Description</label>
                        <textarea
                            name="issue_description"
                            rows="4"
                            placeholder="Detailed description of the issue..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-3 justify-end">
                    <button
                        type="button"
                        onclick="closeAddModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
                        <i class="fas fa-save mr-2"></i>Report Issue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Issue Modal -->
    <div
        id="editModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Edit Issue</h3>
                    <button
                        onclick="closeEditModal()"
                        class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form action="handlers/issue-handler.php" method="POST" class="p-6">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="issue_id" id="edit_issue_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Device -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Device <span class="text-red-500">*</span></label>
                        <select
                            name="device_id"
                            id="edit_device_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            required>
                            <option value="">Select Device</option>
                            <?php foreach ($devices as $device): ?>
                                <option value="<?= htmlspecialchars($device['device_id']) ?>">
                                    <?= htmlspecialchars($device['device_name']) ?>
                                    <?php if (!empty($device['model'])): ?>
                                        - <?= htmlspecialchars($device['model']) ?>
                                    <?php endif; ?>
                                    (<?= htmlspecialchars($device['category_name']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Issue Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Issue Title <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="issue_title"
                            id="edit_issue_title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            required />
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <select
                            name="priority"
                            id="edit_priority"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select
                            name="status"
                            id="edit_status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <!-- Issue Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Issue Description</label>
                        <textarea
                            name="issue_description"
                            id="edit_issue_description"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-3 justify-end">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all">
                        <i class="fas fa-save mr-2"></i>Update Issue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
        id="deleteModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-red-600 to-rose-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Confirm Delete</h3>
                    <button
                        onclick="closeDeleteModal()"
                        class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form action="handlers/issue-handler.php" method="POST" class="p-6">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="issue_id" id="delete_issue_id">

                <div class="text-center mb-6">
                    <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
                    <p class="text-gray-700 text-lg">Are you sure you want to delete this issue?</p>
                    <p class="font-bold text-gray-900 mt-2" id="delete_issue_title"></p>
                </div>

                <div class="flex gap-3 justify-center">
                    <button
                        type="button"
                        onclick="closeDeleteModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg hover:from-red-700 hover:to-rose-700 transition-all">
                        <i class="fas fa-trash mr-2"></i>Delete Issue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');

        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Modal functions
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(issue) {
            document.getElementById('edit_issue_id').value = issue.issue_id;
            document.getElementById('edit_device_id').value = issue.device_id || '';
            document.getElementById('edit_issue_title').value = issue.issue_title || '';
            document.getElementById('edit_priority').value = issue.priority || 'medium';
            document.getElementById('edit_status').value = issue.status || 'open';
            document.getElementById('edit_issue_description').value = issue.issue_description || '';

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(issueId, issueTitle) {
            document.getElementById('delete_issue_id').value = issueId;
            document.getElementById('delete_issue_title').textContent = issueTitle;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals on outside click
        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
                closeDeleteModal();
            }
        });

        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>