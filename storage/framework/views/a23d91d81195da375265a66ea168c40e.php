<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Kevin Laundry'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-tshirt text-2xl text-blue-600 mr-3"></i>
                <h1 class="text-xl font-bold text-gray-900">Kevin Laundry</h1>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- User Info -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e(ucfirst(auth()->user()->role)); ?></p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="px-4 py-6">
            <?php if(auth()->user()->isAdmin()): ?>
                <!-- Admin Menu -->
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-3 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('admin.orders')); ?>" class="flex items-center px-3 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('admin.orders*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-list-alt w-5 h-5 mr-3"></i>
                        Kelola Pesanan
                    </a>
                    <a href="<?php echo e(route('admin.customers')); ?>" class="flex items-center px-3 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('admin.customers*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        Data Customer
                    </a>
                    <a href="<?php echo e(route('admin.services')); ?>" class="flex items-center px-3 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('admin.services*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                        Layanan & Harga
                    </a>
                    <a href="<?php echo e(route('admin.reports')); ?>" class="flex items-center px-3 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('admin.reports*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                        Laporan
                    </a>
                    <a href="<?php echo e(route('admin.settings')); ?>" class="flex items-center px-3 py-2 text-sm font-medium rounded-md <?php echo e(request()->routeIs('admin.settings*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        Pengaturan
                    </a>
                </div>
            <?php endif; ?>
        </nav>

        <!-- Logout -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
            <form method="POST" action="/logout">
                <?php echo csrf_field(); ?>
                <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Bar -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        Selamat datang, <span class="font-semibold"><?php echo e(auth()->user()->name); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            <?php if(session('success')): ?>
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <script>
        // Show/hide overlay when sidebar is toggled
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html> <?php /**PATH C:\laragon\www\kevinlaundry\resources\views/layouts/app.blade.php ENDPATH**/ ?>