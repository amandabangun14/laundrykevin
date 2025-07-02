<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Pesanan - Kevin Laundry</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-droplet me-2"></i>
                Kevin Laundry
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('customer.dashboard') }}">
                    <i class="bi bi-house me-1"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('customer.orders.index') }}">
                    <i class="bi bi-cart me-1"></i>Pesanan Saya
                </a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="/logout" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>
                            Buat Pesanan Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.laundry.store') }}" id="orderForm">
                            @csrf
                            
                            <!-- Services Selection -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Pilih Layanan</h6>
                                <div id="services-container">
                                    <div class="service-item border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Layanan</label>
                                                <select name="services[0][service_id]" class="form-select service-select" required>
                                                    <option value="">Pilih layanan...</option>
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}" data-price="{{ $service->price_per_kg }}">
                                                            {{ $service->name }} - Rp {{ number_format($service->price_per_kg) }}/kg
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Berat (kg)</label>
                                                <input type="number" name="services[0][weight]" class="form-control weight-input" step="0.1" min="0.1" placeholder="0.0" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Subtotal</label>
                                                <div class="form-control-plaintext subtotal-display">Rp 0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addService">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah Layanan
                                </button>
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Catatan khusus untuk pesanan..."></textarea>
                            </div>

                            <!-- Summary -->
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Ringkasan Pesanan</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Total Berat:</strong> <span id="totalWeight">0 kg</span></p>
                                            <p class="mb-0"><strong>Total Biaya:</strong> <span id="totalAmount" class="text-primary fw-bold">Rp 0</span></p>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-1"><strong>Estimasi Selesai:</strong></p>
                                            <p class="mb-0 text-muted">{{ now()->addDays(3)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Buat Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let serviceIndex = 1;

        // Add new service row
        document.getElementById('addService').addEventListener('click', function() {
            const container = document.getElementById('services-container');
            const newService = document.querySelector('.service-item').cloneNode(true);
            
            // Update names and clear values
            newService.querySelector('.service-select').name = `services[${serviceIndex}][service_id]`;
            newService.querySelector('.service-select').value = '';
            newService.querySelector('.weight-input').name = `services[${serviceIndex}][weight]`;
            newService.querySelector('.weight-input').value = '';
            newService.querySelector('.subtotal-display').textContent = 'Rp 0';
            
            // Add remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-outline-danger btn-sm mt-2';
            removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Hapus';
            removeBtn.onclick = function() {
                newService.remove();
                calculateTotal();
            };
            newService.appendChild(removeBtn);
            
            container.appendChild(newService);
            serviceIndex++;
        });

        // Calculate subtotal and total
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

        // Event listeners for calculation
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
</body>
</html> 