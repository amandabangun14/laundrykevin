

<?php $__env->startSection('title', 'Buat Pesanan - Kevin Laundry'); ?>
<?php $__env->startSection('page-title', 'Buat Pesanan Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <form method="POST" action="<?php echo e(route('admin.orders.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="space-y-6">
                    <!-- Pilih Customer -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Customer <span class="text-red-500">*</span></label>
                        <select id="customer_id" name="customer_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Pilih customer...</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>><?php echo e($customer->name); ?> (<?php echo e($customer->email); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <!-- Pilih Layanan dan Berat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Layanan & Berat <span class="text-red-500">*</span></label>
                        <div id="services-container">
                            <div class="service-item border rounded p-3 mb-3">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <select name="services[0][service_id]" class="service-select w-full px-2 py-1 border rounded" required>
                                            <option value="">Pilih layanan...</option>
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>" data-price="<?php echo e($service->price_per_kg); ?>"><?php echo e($service->name); ?> - Rp <?php echo e(number_format($service->price_per_kg)); ?>/kg</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="number" name="services[0][weight]" class="weight-input w-full px-2 py-1 border rounded" step="0.1" min="0.1" placeholder="Berat (kg)" required>
                                    </div>
                                    <div>
                                        <div class="form-control-plaintext subtotal-display">Rp 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addService">
                            <i class="fas fa-plus mr-1"></i>Tambah Layanan
                        </button>
                    </div>
                    <!-- Catatan -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3" placeholder="Catatan khusus untuk pesanan..."></textarea>
                    </div>
                </div>
                <!-- Ringkasan -->
                <div class="card bg-light mt-6">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Ringkasan Pesanan</h6>
                        <div class="flex flex-col md:flex-row md:justify-between">
                            <div>
                                <p class="mb-1"><strong>Total Berat:</strong> <span id="totalWeight">0 kg</span></p>
                                <p class="mb-0"><strong>Total Biaya:</strong> <span id="totalAmount" class="text-primary fw-bold">Rp 0</span></p>
                            </div>
                            <div class="text-md-end">
                                <p class="mb-1"><strong>Estimasi Selesai:</strong></p>
                                <p class="mb-0 text-muted"><?php echo e(now()->addDays(3)->format('d M Y')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tombol -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="<?php echo e(route('admin.orders')); ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <i class="fas fa-save mr-1"></i>Simpan Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
let serviceIndex = 1;
document.getElementById('addService').addEventListener('click', function() {
    const container = document.getElementById('services-container');
    const newService = document.querySelector('.service-item').cloneNode(true);
    newService.querySelector('.service-select').name = `services[${serviceIndex}][service_id]`;
    newService.querySelector('.service-select').value = '';
    newService.querySelector('.weight-input').name = `services[${serviceIndex}][weight]`;
    newService.querySelector('.weight-input').value = '';
    newService.querySelector('.subtotal-display').textContent = 'Rp 0';
    container.appendChild(newService);
    serviceIndex++;
});
function calculateTotal() {
    let totalWeight = 0;
    let totalAmount = 0;
    document.querySelectorAll('.service-item').forEach(function(item) {
        const select = item.querySelector('.service-select');
        const weightInput = item.querySelector('.weight-input');
        const subtotalDisplay = item.querySelector('.subtotal-display');
        if (select.value && weightInput.value) {
            const price = parseFloat(select.options[select.selectedIndex].dataset.price);
            const weight = parseFloat(weightInput.value);
            const subtotal = price * weight;
            subtotalDisplay.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            totalWeight += weight;
            totalAmount += subtotal;
        }
    });
    document.getElementById('totalWeight').textContent = totalWeight.toFixed(1) + ' kg';
    document.getElementById('totalAmount').textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');
}
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('service-select') || e.target.classList.contains('weight-input')) {
        calculateTotal();
    }
});
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('weight-input')) {
        calculateTotal();
    }
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\kevinlaundry\resources\views/admin/orders/create.blade.php ENDPATH**/ ?>