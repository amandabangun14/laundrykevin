

<?php $__env->startSection('title', 'Dashboard Customer - Kevin Laundry'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php if(isset($readyOrders) && $readyOrders->count()): ?>
<div class="mb-8">
    <div class="bg-green-50 border border-green-300 text-green-900 px-6 py-4 rounded-lg flex items-center shadow-sm">
        <i class="fas fa-bell text-3xl mr-4 text-green-500"></i>
        <div>
            <div class="font-bold text-lg mb-1">Pesanan Siap Diambil!</div>
            <ul class="ml-4 list-disc text-sm">
                <?php $__currentLoopData = $readyOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    Pesanan <b><?php echo e($order->invoice_number); ?></b> sudah siap diambil. <a href="<?php echo e(route('customer.orders.show', $order)); ?>" class="underline text-blue-700 font-semibold">Lihat detail</a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white rounded-xl shadow p-6 flex items-center">
        <div class="p-4 rounded-full bg-blue-100 flex items-center justify-center">
            <i class="fas fa-clock text-3xl text-blue-600"></i>
        </div>
        <div class="ml-6">
            <div class="text-gray-500 text-sm">Pesanan Aktif</div>
            <div class="text-3xl font-bold text-gray-900"><?php echo e($activeOrders); ?></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center">
        <div class="p-4 rounded-full bg-green-100 flex items-center justify-center">
            <i class="fas fa-list text-3xl text-green-600"></i>
        </div>
        <div class="ml-6">
            <div class="text-gray-500 text-sm">Total Pesanan</div>
            <div class="text-3xl font-bold text-gray-900"><?php echo e($totalOrders); ?></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center">
        <div class="p-4 rounded-full bg-purple-100 flex items-center justify-center">
            <i class="fas fa-money-bill text-3xl text-purple-600"></i>
        </div>
        <div class="ml-6">
            <div class="text-gray-500 text-sm">Total Pengeluaran</div>
            <div class="text-3xl font-bold text-gray-900">Rp <?php echo e(number_format($totalSpent)); ?></div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow">
    <div class="px-8 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
        <a href="<?php echo e(route('customer.orders.index')); ?>" class="text-blue-600 hover:underline text-sm">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                    <th class="px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <?php echo e($order->invoice_number); ?>

                    </td>
                    <td class="px-8 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($order->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($order->status === 'received'): ?> bg-blue-100 text-blue-800
                            <?php elseif($order->status === 'washing'): ?> bg-indigo-100 text-indigo-800
                            <?php elseif($order->status === 'ironing'): ?> bg-purple-100 text-purple-800
                            <?php elseif($order->status === 'completed'): ?> bg-green-100 text-green-800
                            <?php elseif($order->status === 'ready_for_pickup'): ?> bg-orange-100 text-orange-800
                            <?php else: ?> bg-gray-100 text-gray-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                        </span>
                    </td>
                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp <?php echo e(number_format($order->total_amount)); ?>

                    </td>
                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                    </td>
                    <td class="px-8 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?php echo e(route('customer.orders.show', $order)); ?>" class="text-blue-600 hover:text-blue-900 font-semibold">Detail</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-8 py-8 text-center text-gray-400 text-lg">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <div>Belum ada pesanan</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\kevinlaundry\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>