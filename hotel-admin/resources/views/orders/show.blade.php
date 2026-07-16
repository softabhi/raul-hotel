@extends('layouts.app')

@section('title', 'Order Details #' . $order->id)
@section('page_title', 'Order Summary')

@section('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printArea, #printArea * {
            visibility: visible;
        }
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<!-- Back control and top buttons -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.orders.index') }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="font-semibold text-slate-800 text-sm">Restaurant Order Details</h2>
            <p class="text-xs text-slate-400">ID: ORD-{{ $order->id }} | Date: {{ $order->created_at->format('M d, Y H:i') }}</p>
        </div>
    </div>
    
    <button onclick="window.print()" 
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl border border-slate-200 transition-all text-xs cursor-pointer">
        <i data-lucide="printer" class="w-4 h-4"></i>
        <span>Print Receipt</span>
    </button>
</div>

<!-- Details Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Order Items invoice (Print Area) -->
    <div class="lg:col-span-2 space-y-6" id="printArea">
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xs space-y-8 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-bl-full pointer-events-none"></div>

            <!-- Receipt Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="space-y-1.5">
                    <h1 class="font-playfair text-2xl font-bold text-slate-800 tracking-wider">KITCHEN DINING BILL</h1>
                    <span class="block text-xs font-semibold text-slate-400 tracking-widest uppercase">Luxury Resort & Restaurant</span>
                </div>
                <div class="text-left sm:text-right text-xs text-slate-500 space-y-1">
                    <span class="block text-slate-800 font-bold text-sm">No: ORD-{{ $order->id }}</span>
                    <span>Date: {{ $order->created_at->format('Y-m-d') }}</span>
                    <span class="block">Delivery Room/Table: <strong class="text-slate-800 font-bold">{{ $order->delivery_address }}</strong></span>
                </div>
            </div>

            <!-- Customer Meta -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-slate-600">
                <div class="space-y-1.5">
                    <span class="block font-bold text-slate-800 uppercase tracking-wider mb-0.5">Guest Information</span>
                    <span class="block font-semibold text-slate-800 text-sm">{{ $order->customer_name }}</span>
                    <span class="block">Phone: {{ $order->customer_phone }}</span>
                    @if($order->customer_email)
                        <span class="block">Email: {{ $order->customer_email }}</span>
                    @endif
                </div>
                <div class="space-y-1.5">
                    <span class="block font-bold text-slate-800 uppercase tracking-wider mb-0.5">Payment Details</span>
                    <span class="block">Payment Status: <strong class="text-amber-500 uppercase">{{ $order->payment_status }}</strong></span>
                    <span>Order Status: <strong class="text-slate-700 uppercase">{{ $order->status }}</strong></span>
                </div>
            </div>

            <!-- Items list -->
            <div class="space-y-3">
                <span class="block text-xs font-bold text-slate-800 uppercase tracking-wider">Ordered items</span>
                <table class="w-full text-left text-xs text-slate-600 border border-slate-100 rounded-xl overflow-hidden">
                    <thead class="bg-slate-50 font-bold text-slate-500 uppercase">
                        <tr>
                            <th class="p-3.5">Dish Item</th>
                            <th class="p-3.5 text-center">Quantity</th>
                            <th class="p-3.5 text-right">Price (INR)</th>
                            <th class="p-3.5 text-right">Total (INR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="p-3.5">
                                    <span class="block font-semibold text-slate-800">{{ $item->food->name ?? 'Deleted Item' }}</span>
                                    <span class="block text-[10px] text-slate-400 mt-0.5">Cat: {{ $item->food->category ?? 'N/A' }} | Cuisine: {{ $item->food->cuisine ?? 'N/A' }}</span>
                                </td>
                                <td class="p-3.5 text-center">{{ $item->quantity }}</td>
                                <td class="p-3.5 text-right">₹{{ number_format($item->price) }}</td>
                                <td class="p-3.5 text-right font-semibold text-slate-800">₹{{ number_format($item->quantity * $item->price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Price Breakdown Calculation -->
            <div class="flex justify-end pt-4">
                <div class="w-full sm:w-80 text-xs text-slate-600 space-y-2">
                    <div class="flex justify-between font-semibold">
                        <span>Items Subtotal:</span>
                        <span class="text-slate-800">₹{{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold">
                        <span>Taxes (CGST + SGST 5%):</span>
                        <span class="text-slate-800">₹{{ number_format($order->tax) }}</span>
                    </div>
                    @if($order->delivery_charge)
                        <div class="flex justify-between font-semibold">
                            <span>Delivery/Service Charge:</span>
                            <span class="text-slate-800">₹{{ number_format($order->delivery_charge) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-slate-800 font-bold border-t border-slate-200 pt-3 mt-2 text-sm">
                        <span>Grand Total Due:</span>
                        <span class="text-amber-600">₹{{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Right Column: Status Operations Controls (No Print) -->
    <div class="space-y-6 no-print">
        
        <!-- Kitchen Status Control Box -->
        <div class="bg-slate-900 border border-slate-800 text-white rounded-3xl p-6 shadow-xl space-y-4">
            <h3 class="font-semibold text-sm">Kitchen Status Control</h3>
            <p class="text-xs text-slate-400">Progress the food preparation step-by-step</p>
            
            <div class="bg-slate-950 rounded-2xl p-4 flex items-center justify-between border border-slate-800">
                <span class="text-xs text-slate-400">Current Status:</span>
                <span class="text-xs font-bold text-amber-400 uppercase">{{ $order->status }}</span>
            </div>

            <div class="space-y-2 pt-2">
                @if($order->status === 'Pending')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Preparing">
                        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Start Preparation
                        </button>
                    </form>
                @endif

                @if($order->status === 'Preparing')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Out for Delivery">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Send Out for Room Delivery
                        </button>
                    </form>
                @endif

                @if($order->status === 'Out for Delivery' || $order->status === 'Preparing')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Delivered">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Mark as Delivered / Served
                        </button>
                    </form>
                @endif

                @if($order->status !== 'Delivered' && $order->status !== 'Cancelled')
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                        @csrf
                        <input type="hidden" name="status" value="Cancelled">
                        <button type="submit" class="w-full bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Cancel Food Order
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Payment Control Box -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
            <h3 class="font-semibold text-slate-800 text-sm">Payment Registry</h3>
            <p class="text-xs text-slate-400">Record cash transactions or digital wallet approvals</p>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center justify-between">
                <span class="text-xs text-slate-500 font-medium">Payment status:</span>
                @if($order->payment_status === 'Paid')
                    <span class="text-xs font-bold text-emerald-600 uppercase">Paid</span>
                @elseif($order->payment_status === 'Failed')
                    <span class="text-xs font-bold text-rose-600 uppercase">Failed</span>
                @else
                    <span class="text-xs font-bold text-amber-600 uppercase">Pending</span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-2 pt-2">
                @if($order->payment_status !== 'Paid')
                    <form action="{{ route('admin.orders.payment-status', $order->id) }}" method="POST" class="col-span-2">
                        @csrf
                        <input type="hidden" name="payment_status" value="Paid">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Mark as Paid
                        </button>
                    </form>
                @endif

                @if($order->payment_status === 'Pending')
                    <form action="{{ route('admin.orders.payment-status', $order->id) }}" method="POST" class="col-span-2">
                        @csrf
                        <input type="hidden" name="payment_status" value="Failed">
                        <button type="submit" class="w-full bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold py-2 px-4 rounded-xl text-xs transition-all cursor-pointer">
                            Mark as Failed
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
