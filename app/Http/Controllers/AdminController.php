<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderReadyForPickupMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $completedOrders = Order::where('status', 'completed')->whereDate('updated_at', today())->count();
        $pendingOrders = Order::whereIn('status', ['pending', 'received', 'washing', 'ironing'])->count();
        $todayRevenue = Order::whereDate('created_at', today())->sum('total_amount');
        
        $recentOrders = Order::with(['customer'])->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('todayOrders', 'completedOrders', 'pendingOrders', 'todayRevenue', 'recentOrders'));
    }

    /**
     * Display all orders
     */
    public function orders()
    {
        $orders = Order::with(['customer', 'orderItems.service'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function showOrder(Order $order)
    {
        $order->load(['customer', 'orderItems.service']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,received,washing,ironing,completed,ready_for_pickup,picked_up',
        ]);

        $data = ['status' => $request->status];
        
        if ($request->status === 'completed' && $order->status !== 'completed') {
            $data['actual_completion_date'] = now();
        }

        $order->update($data);

        // Kirim email jika status ready_for_pickup
        if ($request->status === 'ready_for_pickup') {
            Mail::to($order->customer->email)->send(new OrderReadyForPickupMail($order));
        }

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Display all customers
     */
    public function customers()
    {
        $customers = User::where('role', 'customer')->withCount('orders')->withSum('orders', 'total_amount')->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show customer details
     */
    public function showCustomer(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $orders = $customer->orders()->with(['orderItems.service'])->latest()->get();
        return view('admin.customers.show', compact('customer', 'orders'));
    }

    /**
     * Display services management
     */
    public function services()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show service form
     */
    public function createService()
    {
        return view('admin.services.create');
    }

    /**
     * Store new service
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_kg' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Service::create($data);

        return redirect()->route('admin.services')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Show service edit form
     */
    public function editService(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update service
     */
    public function updateService(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_kg' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $service->update($data);

        return redirect()->route('admin.services')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Delete service
     */
    public function destroyService(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Display reports
     */
    public function reports()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $totalCustomers = User::where('role', 'customer')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        // Data pendapatan bulanan
        $monthlyRevenueRaw = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $months = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
        $monthlyRevenue = [];
        foreach ($months as $num => $label) {
            $found = $monthlyRevenueRaw->firstWhere('month', $num);
            $monthlyRevenue[] = $found ? (float)$found->revenue : 0;
        }
        // Data status pesanan
        $statusLabels = ['pending','received','washing','ironing','completed','ready_for_pickup','picked_up'];
        $statusCounts = [];
        foreach ($statusLabels as $status) {
            $statusCounts[] = Order::where('status', $status)->count();
        }
        // Top customers by total transaksi
        $topCustomers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderByDesc('orders_sum_total_amount')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();
        return view('admin.reports.index', compact(
            'totalOrders', 'totalRevenue', 'totalCustomers', 'completedOrders',
            'monthlyRevenue', 'months', 'statusLabels', 'statusCounts', 'topCustomers'
        ));
    }

    /**
     * Display settings
     */
    public function settings()
    {
        return view('admin.settings.index');
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        // Update application settings here
        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Hapus customer dan seluruh pesanan miliknya
     */
    public function destroyCustomer(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }
        // Hapus semua order items dan orders milik customer
        foreach ($customer->orders as $order) {
            $order->orderItems()->delete();
            $order->delete();
        }
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Customer dan seluruh pesanan berhasil dihapus.');
    }

    /**
     * Tampilkan form input pesanan baru oleh admin
     */
    public function createOrder()
    {
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        $services = Service::where('is_active', true)->get();
        return view('admin.orders.create', compact('customers', 'services'));
    }

    /**
     * Simpan pesanan baru yang diinput admin
     */
    public function storeOrder(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.weight' => 'required|numeric|min:0.1',
            'notes' => 'nullable|string',
        ]);

        $totalWeight = 0;
        $totalAmount = 0;
        $services = Service::whereIn('id', collect($request->services)->pluck('service_id'))->get();

        foreach ($request->services as $serviceData) {
            $service = $services->find($serviceData['service_id']);
            $weight = $serviceData['weight'];
            $subtotal = $weight * $service->price_per_kg;
            $totalWeight += $weight;
            $totalAmount += $subtotal;
        }

        $order = Order::create([
            'invoice_number' => 'LDR' . str_pad(Order::count() + 1, 3, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'status' => 'pending',
            'total_weight' => $totalWeight,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
            'estimated_completion_date' => now()->addDays(3),
        ]);

        foreach ($request->services as $serviceData) {
            $service = $services->find($serviceData['service_id']);
            $weight = $serviceData['weight'];
            $subtotal = $weight * $service->price_per_kg;
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'weight' => $weight,
                'price_per_kg' => $service->price_per_kg,
                'subtotal' => $subtotal,
            ]);
        }

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dibuat untuk customer.');
    }
}
