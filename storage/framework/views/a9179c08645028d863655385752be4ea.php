<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Kevin Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="<?php echo e(route('customer.orders.index')); ?>" class="text-blue-600 hover:text-blue-800 mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold"><?php echo e(auth()->user()->name); ?></span>
                    </div>
                    <form method="POST" action="/logout" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Pesanan</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Invoice Number</h3>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($order->invoice_number); ?></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Status</h3>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
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
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Pesan</h3>
                        <p class="text-gray-900"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Estimasi Selesai</h3>
                        <p class="text-gray-900"><?php echo e($order->estimated_completion_date ? $order->estimated_completion_date->format('d/m/Y') : '-'); ?></p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Berat</h3>
                        <p class="text-gray-900"><?php echo e($order->total_weight); ?> kg</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Harga</h3>
                        <p class="text-lg font-semibold text-blue-600">Rp <?php echo e(number_format($order->total_amount)); ?></p>
                    </div>
                </div>
                
                <?php if($order->notes): ?>
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Catatan</h3>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-md"><?php echo e($order->notes); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Detail Layanan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga/kg</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($item->service->name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($item->weight); ?> kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp <?php echo e(number_format($item->price_per_kg)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp <?php echo e(number_format($item->subtotal)); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="bg-white rounded-lg shadow-sm mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Status Pesanan</h2>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <?php
                            $statuses = [
                                'pending' => ['icon' => 'fas fa-clock', 'title' => 'Menunggu Konfirmasi', 'description' => 'Pesanan telah diterima dan menunggu konfirmasi admin'],
                                'received' => ['icon' => 'fas fa-check-circle', 'title' => 'Diterima', 'description' => 'Pesanan telah dikonfirmasi dan diterima'],
                                'washing' => ['icon' => 'fas fa-tshirt', 'title' => 'Sedang Dicuci', 'description' => 'Pakaian sedang dalam proses pencucian'],
                                'ironing' => ['icon' => 'fas fa-iron', 'title' => 'Sedang Disetrika', 'description' => 'Pakaian sedang dalam proses penyetrikaan'],
                                'completed' => ['icon' => 'fas fa-check-double', 'title' => 'Selesai', 'description' => 'Pesanan telah selesai diproses'],
                                'ready_for_pickup' => ['icon' => 'fas fa-box', 'title' => 'Siap Diambil', 'description' => 'Pesanan siap untuk diambil'],
                                'picked_up' => ['icon' => 'fas fa-handshake', 'title' => 'Sudah Diambil', 'description' => 'Pesanan telah diambil oleh customer']
                            ];
                            
                            $currentStatusIndex = array_search($order->status, array_keys($statuses));
                        ?>
                        
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isCompleted = array_search($status, array_keys($statuses)) <= $currentStatusIndex;
                            $isCurrent = $status === $order->status;
                        ?>
                        <li>
                            <div class="relative pb-8">
                                <?php if(!$loop->last): ?>
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                <?php endif; ?>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                            <?php if($isCompleted): ?> bg-green-500 <?php else: ?> bg-gray-300 <?php endif; ?>">
                                            <i class="fas <?php echo e($info['icon']); ?> text-sm 
                                                <?php if($isCompleted): ?> text-white <?php else: ?> text-gray-500 <?php endif; ?>"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500 <?php if($isCurrent): ?> font-medium text-gray-900 <?php endif; ?>">
                                                <?php echo e($info['title']); ?>

                                            </p>
                                            <p class="text-xs text-gray-400"><?php echo e($info['description']); ?></p>
                                        </div>
                                        <?php if($isCurrent): ?>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Saat Ini</span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html> <?php /**PATH C:\laragon\www\kevinlaundry\resources\views/customer/orders/show.blade.php ENDPATH**/ ?>