@extends('layouts.app')

@section('title', 'Layanan & Harga - Kevin Laundry')
@section('page-title', 'Layanan & Harga')

@section('content')
<!-- Header with Add Button -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Kelola Layanan</h2>
        <p class="text-gray-600">Atur layanan dan harga yang tersedia untuk customer</p>
    </div>
    <a href="{{ route('admin.services.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
        <i class="fas fa-plus mr-1"></i>Tambah Layanan
    </a>
</div>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($services as $service)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.services.edit', $service) }}" 
                       class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors"
                       title="Edit layanan">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                          class="inline" 
                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                        @csrf
                        @method('DELETE')
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
                    <p class="text-gray-900">{{ $service->description ?: 'Tidak ada deskripsi' }}</p>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Harga per kg:</span>
                    <span class="font-semibold text-blue-600">Rp {{ number_format($service->price_per_kg) }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Estimasi hari:</span>
                    <span class="font-semibold text-gray-900">{{ $service->estimated_days }} hari</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Status:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <i class="fas fa-cogs text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada layanan</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan layanan pertama Anda</p>
            <a href="{{ route('admin.services.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i>Tambah Layanan
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Success Message -->
@if(session('success'))
<div id="success-message" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
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
@endif
@endsection 