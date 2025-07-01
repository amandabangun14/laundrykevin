<x-mail::message>
# Pesanan Laundry Anda Siap Diambil!

Halo {{ $order->customer->name }},

Pesanan laundry Anda dengan nomor invoice <b>{{ $order->invoice_number }}</b> sudah selesai dan siap diambil di outlet kami.

**Detail Pesanan:**
- Tanggal Pesan: {{ $order->created_at->format('d/m/Y H:i') }}
- Total Berat: {{ $order->total_weight }} kg
- Total Biaya: Rp {{ number_format($order->total_amount) }}

<x-mail::button :url="url('/customer/orders/' . $order->id)">
Lihat Detail Pesanan
</x-mail::button>

Silakan datang ke outlet untuk mengambil pesanan Anda. Terima kasih telah menggunakan layanan Kevin Laundry!

Salam,
{{ config('app.name') }}
</x-mail::message>
