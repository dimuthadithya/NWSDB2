   <header
       class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-30 border-b border-gray-100">
       <div class="px-6 py-4 flex items-center justify-between">
           <div class="animate-fade-up">
               <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
               <p class="text-sm text-gray-500 mt-1">
                   Welcome back, <?php echo $name; ?>! Here's your device overview.
               </p>
           </div>
           <div class="flex items-center space-x-4">
               <button
                   class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                   <i class="fas fa-bell text-xl"></i>
                   <span
                       class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full status-badge"></span>
               </button>
               <div
                   class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                   <div class="text-right">
                       <p class="text-sm font-medium text-gray-800"><?php echo $name; ?> </p>
                       <p class="text-xs text-gray-500"><?php echo $role;  ?></p>
                   </div>
                   <div
                       class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                       <i class="fas fa-user text-white text-sm"></i>
                   </div>
               </div>
           </div>
       </div>
   </header>