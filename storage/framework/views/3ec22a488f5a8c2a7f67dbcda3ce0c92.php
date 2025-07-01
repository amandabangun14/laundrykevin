

<?php $__env->startSection('title', 'Pesan Laundry - Kevin Laundry'); ?>
<?php $__env->startSection('page-title', 'Pesan Laundry'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Form Pesanan Laundry</h2>
            <p class="text-sm text-gray-600 mt-1">Pilih layanan dan masukkan berat pakaian Anda</p>
        </div>
        
        <form method="POST" action="<?php echo e(route('customer.laundry.store')); ?>" class="p-6">
            <?php echo csrf_field(); ?>
            
            <div id="services-container">
                <div class="service-item border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Layanan</label>
                            <select name="services[0][service_id]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih Layanan</option>
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>" data-price="<?php echo e($service->price_per_kg); ?>">
                                    <?php echo e($service->name); ?> - Rp <?php echo e(number_format($service->price_per_kg)); ?>/kg
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berat (kg)</label>
                            <input type="number" name="services[0][weight]" step="0.1" min="0.1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="0.5" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtotal</label>
                            <input type="text" class="subtotal w-full border-gray-300 rounded-md shadow-sm bg-gray-50" readonly>
                        </div>
                    </div>
                    <button type="button" class="remove-service mt-2 text-red-600 hover:text-red-800 text-sm">
                        <i class="fas fa-trash mr-1"></i>Hapus
                    </button>
                </div>
            </div>
            
            <button type="button" id="add-service" class="mb-6 text-blue-600 hover:text-blue-800 text-sm font-medium">
                <i class="fas fa-plus mr-1"></i>Tambah Layanan
            </button>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Catatan khusus untuk pesanan Anda..."></textarea>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ringkasan Pesanan</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Berat:</span>
                        <span id="total-weight" class="font-medium">0 kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga:</span>
                        <span id="total-amount" class="font-medium text-lg text-blue-600">Rp 0</span>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-paper-plane mr-1"></i>Kirim Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let serviceIndex = 1;
    
    document.getElementById('add-service').addEventListener('click', function() {
        const container = document.getElementById('services-container');
        const newService = document.querySelector('.service-item').cloneNode(true);
        
        // Update the name attributes
        const selects = newService.querySelectorAll('select, input');
        selects.forEach(select => {
            if (select.name) {
                select.name = select.name.replace('[0]', `[${serviceIndex}]`);
            }
            if (select.classList.contains('subtotal')) {
                select.value = '';
            } else if (select.type === 'number') {
                select.value = '';
            } else if (select.tagName === 'SELECT') {
                select.selectedIndex = 0;
            }
        });
        
        container.appendChild(newService);
        serviceIndex++;
        
        // Add event listeners to new service
        addServiceEventListeners(newService);
    });
    
    function addServiceEventListeners(serviceElement) {
        const select = serviceElement.querySelector('select');
        const weightInput = serviceElement.querySelector('input[type="number"]');
        const subtotalInput = serviceElement.querySelector('.subtotal');
        const removeBtn = serviceElement.querySelector('.remove-service');
        
        function calculateSubtotal() {
            const selectedOption = select.options[select.selectedIndex];
            const weight = parseFloat(weightInput.value) || 0;
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const subtotal = weight * price;
            subtotalInput.value = `Rp ${subtotal.toLocaleString()}`;
            calculateTotal();
        }
        
        select.addEventListener('change', calculateSubtotal);
        weightInput.addEventListener('input', calculateSubtotal);
        
        removeBtn.addEventListener('click', function() {
            if (document.querySelectorAll('.service-item').length > 1) {
                serviceElement.remove();
                calculateTotal();
            }
        });
    }
    
    function calculateTotal() {
        let totalWeight = 0;
        let totalAmount = 0;
        
        document.querySelectorAll('.service-item').forEach(item => {
            const weight = parseFloat(item.querySelector('input[type="number"]').value) || 0;
            const select = item.querySelector('select');
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            
            totalWeight += weight;
            totalAmount += weight * price;
        });
        
        document.getElementById('total-weight').textContent = `${totalWeight.toFixed(1)} kg`;
        document.getElementById('total-amount').textContent = `Rp ${totalAmount.toLocaleString()}`;
    }
    
    // Add event listeners to initial service
    addServiceEventListeners(document.querySelector('.service-item'));
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\kevinlaundry\resources\views/customer/laundry/create.blade.php ENDPATH**/ ?>