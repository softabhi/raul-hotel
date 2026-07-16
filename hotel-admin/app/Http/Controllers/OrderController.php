<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        
        $statuses = ['Pending', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled'];
        $paymentStatuses = ['Pending', 'Paid', 'Failed'];

        return view('orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('items.food');
        return view('orders.show', compact('order'));
    }

    /**
     * Update the specified resource's status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Preparing,Out for Delivery,Delivered,Cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', "Order status updated to {$request->status} successfully.");
    }

    /**
     * Update the payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:Pending,Paid,Failed',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', "Payment status updated to {$request->payment_status} successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
