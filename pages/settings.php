<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../functions/DbHelper.php';

requireLogin();

// Fetch current user data
// Fetch current user data
$userId = $_SESSION['user']['id'];
$user = DbHelper::getUserById($userId);

// Fallback if user not found in DB (e.g. session stale)
if (!$user) {
    $user = $_SESSION['user'];
}

// Variables required by header.php
$name = $_SESSION['user']['name'] ?? ($user['first_name'] . ' ' . $user['last_name']);
$role = $_SESSION['user']['role'] ?? $user['role'];

// Fetch WSS name if user has one
$wssName = 'Not Assigned';
if (!empty($user['wss_id'])) {
    // Assuming getById for WSS or a direct query
    // Since DbHelper doesn't have explicit getWssById exposed widely, using generic select
    $wss = Database::getInstance()->select('water_supply_schemes', ['wss_name'], ['wss_id' => $user['wss_id']]);
    if ($wss && count($wss) > 0) {
        $wssName = $wss[0]['wss_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB - User Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .animate-fade-up {
      animation: fadeInUp 0.6s ease-out forwards;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
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

      <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-user-cog text-blue-600 mr-3"></i> Profile Settings
        </h2>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Tabs or Sections -->
            <div class="p-6 md:p-8 space-y-8">
                
                <!-- Personal Information Form -->
                <form action="admin/handlers/profile-handler.php" method="POST" class="space-y-6">
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                                </div>
                            </div>
                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="text" name="mobile_number" value="<?= htmlspecialchars($user['mobile_number'] ?? '') ?>"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                                </div>
                            </div>
                            
                            <!-- Username (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-at"></i>
                                    </span>
                                    <input type="text" value="<?= htmlspecialchars($user['username'] ?? '') ?>" readonly
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Username cannot be changed.</p>
                            </div>

                            <!-- Assigned WSS (Read Only) -->
                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Assigned Location (WSS)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" value="<?= htmlspecialchars($wssName) ?>" readonly
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>
                            </div>
                            
                            <!-- Role (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                    <input type="text" value="<?= htmlspecialchars(ucfirst($user['role'])) ?>" readonly
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all shadow-md flex items-center">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Change Password Form -->
                <form action="admin/handlers/profile-handler.php" method="POST" class="space-y-6 pt-6 border-t border-gray-100">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4 flex items-center">
                            <i class="fas fa-lock mr-2 text-gray-400"></i> Change Password
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Current Password -->
                            <div class="md:col-span-2 lg:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" required placeholder="Enter current password"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                            </div>

                             <div class="hidden md:block lg:hidden"></div>

                            <!-- New Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="new_password" required placeholder="Enter new password"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" name="confirm_password" required placeholder="Confirm new password"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition-all">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-900 focus:ring-4 focus:ring-gray-200 transition-all shadow-md flex items-center">
                                <i class="fas fa-key mr-2"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
      </div>

    </div>
  </main>

  <script>
    // Auto-hide messages
    setTimeout(() => {
        const success = document.getElementById('successMessage');
        const error = document.getElementById('errorMessage');
        if (success) success.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 5000);
  </script>
</body>
</html>
