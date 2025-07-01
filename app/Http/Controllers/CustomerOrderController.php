<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Display customer orders
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with(['orderItems.service'])->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('customer.orders.create', compact('services'));
    }

    /**
     * Store a newly created order
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
            'estimated_completion_date' => now()->addDays(3), // Default 3 days
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
     * Display the specified order
     */
    public function show(Order $order)
    {
        // Ensure customer can only view their own orders
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.service']);
        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show order history
     */
    public function history()
    {
        $orders = Auth::user()->orders()->with(['orderItems.service'])->latest()->get();
        return view('customer.orders.history', compact('orders'));
    }
}
