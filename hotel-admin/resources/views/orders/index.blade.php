@extends('layouts.app')

@section('title', 'Food Orders')
@section('page_title', 'Restaurant Orders')

@section('content')
<!-- Header Controls -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <div class="space-y-1">
        <h2 class="font-semibold text-slate-800 text-sm">Resort Food Orders Registry</h2>
        <p class="text-xs text-slate-400">List of kitchen dining orders, room-delivery orders, and payments</p>
    </div>
</div>

<!-- Search & Filters -->
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        
        <!-- Search -->
        <div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4.5 h-4.5"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search Guest Name, Phone, ID..." 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
            </div>
        </div>

        <!-- Order Status -->
        <div>
            <select name="status" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Order Statuses</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
        </div>

        <!-- Payment Status -->
        <div class="flex items-center gap-3 sm:col-span-2">
            <select name="payment_status" 
                    class="flex-1 bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Payment Statuses</option>
                @foreach($paymentStatuses as $pst)
                    <option value="{{ $pst }}" {{ request('payment_status') === $pst ? 'selected' : '' }}>{{ $pst }}</option>
                @endforeach
            </select>
            
            <button type="submit" 
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 p-2.5 rounded-xl border border-slate-200 transition-colors cursor-pointer" 
                    title="Apply Filters">
                <i data-lucide="sliders-horizontal" class="w-4.5 h-4.5"></i>
            </button>
        </div>

    </form>
</div>

<!-- Orders Table -->
<div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Guest Details</th>
                    <th class="px-6 py-4">Table / Room Location</th>
                    <th class="px-6 py-4">Bill Amount</th>
                    <th class="px-6 py-4">Order Status</th>
                    <th class="px-6 py-4">Payment</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium font-medium">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-slate-800">
                            ORD-{{ $order->id }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="block font-semibold text-slate-800 text-sm">{{ $order->customer_name }}</span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">{{ $order->customer_phone }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 font-semibold">
                            {{ $order->delivery_address }}
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">
                            ₹{{ number_format($order->total) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($order->status === 'Delivered')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wide">Delivered</span>
                            @elseif($order->status === 'Preparing')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wide">Preparing</span>
                            @elseif($order->status === 'Out for Delivery')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wide">Out for Delivery</span>
                            @elseif($order->status === 'Cancelled')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100 uppercase tracking-wide">Cancelled</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wide">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($order->payment_status === 'Paid')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Paid</span>
                                </span>
                            @elseif($order->payment_status === 'Failed')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-600 border border-rose-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    <span>Failed</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-600 border border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span>Pending</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="p-2 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-xl transition-colors" 
                                   title="View Order Items & Status Actions">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 hover:bg-rose-50 text-slate-500 hover:text-rose-600 rounded-xl transition-colors cursor-pointer" 
                                            title="Delete Order">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
                            <span class="block">No orders matched the select criteria.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection
