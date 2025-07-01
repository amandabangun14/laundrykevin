<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems.service'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'total_weight' => 'required|numeric|min:0.1',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'estimated_completion_date' => 'required|date|after:today',
        ]);

        $order = Order::create([
            'invoice_number' => 'LDR' . str_pad(Order::count() + 1, 3, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'status' => 'received',
            'total_weight' => $request->total_weight,
            'total_amount' => $request->total_amount,
            'notes' => $request->notes,
            'estimated_completion_date' => $request->estimated_completion_date,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.service']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,received,washing,ironing,completed,ready_for_pickup,picked_up',
            'total_weight' => 'required|numeric|min:0.1',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'estimated_completion_date' => 'required|date',
        ]);

        $data = $request->all();
        
        // Set actual completion date if status is completed
        if ($request->status === 'completed' && $order->status !== 'completed') {
            $data['actual_completion_date'] = now();
        }

        $order->update($data);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,received,washing,ironing,completed,ready_for_pickup,picked_up',
        ]);

        $data = ['status' => $request->status];
        
        // Set actual completion date if status is completed
        if ($request->status === 'completed' && $order->status !== 'completed') {
            $data['actual_completion_date'] = now();
        }

        $order->update($data);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
