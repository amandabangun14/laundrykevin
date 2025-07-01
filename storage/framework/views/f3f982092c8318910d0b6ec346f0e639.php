

<?php $__env->startSection('title', 'Laporan - Kevin Laundry'); ?>
<?php $__env->startSection('page-title', 'Laporan'); ?>

<?php $__env->startSection('content'); ?>
<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <i class="fas fa-shopping-cart text-blue-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-2xl font-semibold text-gray-900"><?php echo e($totalOrders); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
                <i class="fas fa-money-bill text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                <p class="text-2xl font-semibold text-gray-900">Rp <?php echo e(number_format($totalRevenue)); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100">
                <i class="fas fa-users text-purple-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Customer</p>
                <p class="text-2xl font-semibold text-gray-900"><?php echo e($totalCustomers); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100">
                <i class="fas fa-check-circle text-orange-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pesanan Selesai</p>
                <p class="text-2xl font-semibold text-gray-900"><?php echo e($completedOrders); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Pendapatan Bulanan</h3>
        </div>
        <div class="p-6">
            <canvas id="revenueChart" height="200"></canvas>
        </div>
    </div>

    <!-- Orders Status Chart -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Status Pesanan</h3>
        </div>
        <div class="p-6">
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Top Customers -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Customer Teratas</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($customer->name); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e($customer->email); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e($customer->orders_count); ?> pesanan</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">Rp <?php echo e(number_format($customer->orders_sum_total_amount ?? 0)); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-gray-500 text-center py-4">Belum ada data customer</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Service Performance -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Performa Layanan</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Cuci Reguler</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">75%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Cuci Express</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">60%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Dry Clean</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">45%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Setrika Saja</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-orange-600 h-2 rounded-full" style="width: 30%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">30%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_values($months), 15, 512) ?>,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: <?php echo json_encode($monthlyRevenue, 15, 512) ?>,
            backgroundColor: 'rgba(59, 130, 246, 0.7)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($statusLabels, 15, 512) ?>,
        datasets: [{
            label: 'Jumlah Pesanan',
            data: <?php echo json_encode($statusCounts, 15, 512) ?>,
            backgroundColor: [
                '#fbbf24', // pending
                '#60a5fa', // received
                '#6366f1', // washing
                '#a78bfa', // ironing
                '#34d399', // completed
                '#f59e42', // ready_for_pickup
                '#9ca3af'  // picked_up
            ]
        }]
    }
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\kevinlaundry\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>