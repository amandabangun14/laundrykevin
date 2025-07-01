@extends('layouts.app')

@section('title', 'Detail Customer - Kevin Laundry')
@section('page-title', 'Detail Customer')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <!-- Profil Customer -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:col-span-1">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Profil Customer</h2>
            <div class="mb-3">
                <span class="block text-sm text-gray-600">Nama</span>
                <span class="font-medium text-gray-900">{{ $customer->name }}</span>
            </div>
            <div class="mb-3">
                <span class="block text-sm text-gray-600">Email</span>
                <span class="font-medium text-gray-900">{{ $customer->email }}</span>
            </div>
            <div class="mb-3">
                <span class="block text-sm text-gray-600">Tanggal Daftar</span>
                <span class="font-medium text-gray-900">{{ $customer->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="mb-3">
                <span class="block text-sm text-gray-600">Total Pesanan</span>
                <span class="font-medium text-gray-900">{{ $customer->orders()->count() }}</span>
            </div>
            <div class="mb-3">
                <span class="block text-sm text-gray-600">Total Transaksi</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($customer->orders()->sum('total_amount')) }}</span>
            </div>
        </div>

        <!-- Daftar Pesanan Customer -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Pesanan Customer</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $order->invoice_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'received') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'washing') bg-indigo-100 text-indigo-800
                                        @elseif($order->status === 'ironing') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'ready_for_pickup') bg-orange-100 text-orange-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($order->total_amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada pesanan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 