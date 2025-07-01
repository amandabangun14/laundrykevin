<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display customer dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $activeOrders = $user->orders()->whereNotIn('status', ['picked_up'])->count();
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->sum('total_amount');
        $recentOrders = $user->orders()->with(['orderItems.service'])->latest()->take(5)->get();
        $readyOrders = $user->orders()->where('status', 'ready_for_pickup')->get();
        
        return view('customer.dashboard', compact('activeOrders', 'totalOrders', 'totalSpent', 'recentOrders', 'readyOrders'));
    }

    /**
     * Show laundry order form
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('customer.laundry.create', compact('services'));
    }

    /**
     * Store new laundry order
     */
    public function store(Request $request)
    {
        $request->validate([
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.weight' => 'required|numeric|min:0.1',
            'notes' => 'nullable|string',
        ]);

        // Calculate total weight and amount
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

        // Create order
        $order = Order::create([
            'invoice_number' => 'LDR' . str_pad(Order::count() + 1, 3, '0', STR_PAD_LEFT),
            'customer_id' => Auth::id(),
            'status' => 'pending',
            'total_weight' => $totalWeight,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
            'estimated_completion_date' => now()->addDays(3),
        ]);

        // Create order items
        foreach ($request->services as $serviceData) {
            $service = $services->find($serviceData['service_id']);
            $weight = $serviceData['weight'];
            $subtotal = $weight * $service->price_per_kg;

            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'weight' => $weight,
                'price_per_kg' => $service->price_per_kg,
                'subtotal' => $subtotal,
            ]);
        }

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibuat! Invoice: ' . $order->invoice_number);
    }

    /**
     * Display customer orders
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->with(['orderItems.service'])->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.service']);
        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show transaction history
     */
    public function history()
    {
        $orders = Auth::user()->orders()->with(['orderItems.service'])->latest()->get();
        return view('customer.history.index', compact('orders'));
    }

    /**
     * Show customer profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile.index', compact('user'));
    }

    /**
     * Update customer profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only(['name', 'email']));

        return redirect()->route('customer.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
