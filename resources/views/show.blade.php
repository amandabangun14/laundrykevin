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
                    <a href="{{ route('customer.orders.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
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
                        <p class="text-lg font-semibold text-gray-900">{{ $order->invoice_number }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Status</h3>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
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
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Pesan</h3>
                        <p class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Estimasi Selesai</h3>
                        <p class="text-gray-900">{{ $order->estimated_completion_date ? $order->estimated_completion_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Berat</h3>
                        <p class="text-gray-900">{{ $order->total_weight }} kg</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total Harga</h3>
                        <p class="text-lg font-semibold text-blue-600">Rp {{ number_format($order->total_amount) }}</p>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Catatan</h3>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-md">{{ $order->notes }}</p>
                </div>
                @endif
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
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->service->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->weight }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($item->price_per_kg) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($item->subtotal) }}
                            </td>
                        </tr>
                        @endforeach
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
                        @php
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
                        @endphp
                        
                        @foreach($statuses as $status => $info)
                        @php
                            $isCompleted = array_search($status, array_keys($statuses)) <= $currentStatusIndex;
                            $isCurrent = $status === $order->status;
                        @endphp
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                            @if($isCompleted) bg-green-500 @else bg-gray-300 @endif">
                                            <i class="fas {{ $info['icon'] }} text-sm 
                                                @if($isCompleted) text-white @else text-gray-500 @endif"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500 @if($isCurrent) font-medium text-gray-900 @endif">
                                                {{ $info['title'] }}
                                            </p>
                                            <p class="text-xs text-gray-400">{{ $info['description'] }}</p>
                                        </div>
                                        @if($isCurrent)
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Saat Ini</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 