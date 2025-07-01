@extends('layouts.app')

@section('title', 'Laporan - Kevin Laundry')
@section('page-title', 'Laporan')

@section('content')
<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <i class="fas fa-shopping-cart text-blue-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalRevenue) }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ $totalCustomers }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ $completedOrders }}</p>
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
                @forelse($topCustomers as $customer)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                            <p class="text-xs text-gray-500">{{ $customer->orders_count }} pesanan</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($customer->orders_sum_total_amount ?? 0) }}</span>
                </div>
                @empty
                <div class="text-gray-500 text-center py-4">Belum ada data customer</div>
                @endforelse
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: @json(array_values($months)),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($monthlyRevenue),
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
        labels: @json($statusLabels),
        datasets: [{
            label: 'Jumlah Pesanan',
            data: @json($statusCounts),
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
@endpush 