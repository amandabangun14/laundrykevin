

<?php $__env->startSection('title', 'Layanan & Harga - Kevin Laundry'); ?>
<?php $__env->startSection('page-title', 'Layanan & Harga'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header with Add Button -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Kelola Layanan</h2>
        <p class="text-gray-600">Atur layanan dan harga yang tersedia untuk customer</p>
    </div>
    <a href="<?php echo e(route('admin.services.create')); ?>" 
       class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
        <i class="fas fa-plus mr-1"></i>Tambah Layanan
    </a>
</div>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($service->name); ?></h3>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.services.edit', $service)); ?>" 
                       class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors"
                       title="Edit layanan">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.services.destroy', $service)); ?>" 
                          class="inline" 
                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors"
                                title="Hapus layanan">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Deskripsi</p>
                    <p class="text-gray-900"><?php echo e($service->description ?: 'Tidak ada deskripsi'); ?></p>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Harga per kg:</span>
                    <span class="font-semibold text-blue-600">Rp <?php echo e(number_format($service->price_per_kg)); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Estimasi hari:</span>
                    <span class="font-semibold text-gray-900"><?php echo e($service->estimated_days); ?> hari</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Status:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                        <?php echo e($service->is_active ? 'Aktif' : 'Nonaktif'); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full">
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <i class="fas fa-cogs text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada layanan</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan layanan pertama Anda</p>
            <a href="<?php echo e(route('admin.services.create')); ?>" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i>Tambah Layanan
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Success Message -->
<?php if(session('success')): ?>
<div id="success-message" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <?php echo e(session('success')); ?>

    </div>
</div>

<script>
    // Auto-hide success message after 3 seconds
    setTimeout(function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.transition = 'opacity 0.5s ease-out';
            successMessage.style.opacity = '0';
            setTimeout(function() {
                successMessage.remove();
            }, 500);
        }
    }, 3000);
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\kevinlaundry\resources\views/admin/services/index.blade.php ENDPATH**/ ?>