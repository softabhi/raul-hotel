@extends('layouts.app')

@section('title', 'Dashboard Overview')
@section('page_title', 'Analytics Dashboard')

@section('content')
<!-- Overview Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <!-- Revenue -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex items-center justify-between group hover:border-amber-500/30 transition-all duration-300">
        <div class="space-y-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Revenue</span>
            <span class="text-2xl font-bold text-slate-800 tracking-tight">₹{{ number_format($totalRevenue) }}</span>
            <span class="text-[10px] text-emerald-500 font-semibold flex items-center gap-0.5">
                <i data-lucide="trending-up" class="w-3 h-3"></i>
                <span>+12.4% this month</span>
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shadow-xs shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
            <i data-lucide="indian-rupee" class="w-6 h-6"></i>
        </div>
    </div>

    <!-- Bookings -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex items-center justify-between group hover:border-blue-500/30 transition-all duration-300">
        <div class="space-y-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Bookings</span>
            <span class="text-2xl font-bold text-slate-800 tracking-tight">{{ $totalBookings }}</span>
            <span class="text-xs text-slate-500 block font-medium">{{ $activeBookings }} currently active</span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shadow-xs shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
            <i data-lucide="calendar" class="w-6 h-6"></i>
        </div>
    </div>

    <!-- Occupancy -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex items-center justify-between group hover:border-emerald-500/30 transition-all duration-300">
        <div class="space-y-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Occupancy Rate</span>
            <span class="text-2xl font-bold text-slate-800 tracking-tight">{{ $occupancyRate }}%</span>
            <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden mt-2.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $occupancyRate }}%"></div>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shadow-xs shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
            <i data-lucide="bed" class="w-6 h-6"></i>
        </div>
    </div>

    <!-- F&B Orders -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex items-center justify-between group hover:border-indigo-500/30 transition-all duration-300">
        <div class="space-y-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Food Orders</span>
            <span class="text-2xl font-bold text-slate-800 tracking-tight">{{ $totalOrders }}</span>
            <span class="text-xs text-slate-500 block font-medium">₹{{ number_format($averageOrderValue) }} avg order value</span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-xs shrink-0 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
            <i data-lucide="soup" class="w-6 h-6"></i>
        </div>
    </div>

</div>

<!-- Interactive Charts Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Revenue Trend Chart -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs lg:col-span-2 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-semibold text-slate-800 text-sm">Revenue Operations Analysis</h3>
                <p class="text-xs text-slate-400">Past 7 days income breakdown</p>
            </div>
            <span class="text-xs font-bold text-amber-500 bg-amber-50 border border-amber-100 rounded-lg px-2.5 py-1">Live Streams</span>
        </div>
        <div class="h-80 w-full relative">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Room Category Distribution Pie -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="font-semibold text-slate-800 text-sm">Booking Demand Share</h3>
            <p class="text-xs text-slate-400">Total volume by room category</p>
        </div>
        <div class="h-64 w-full relative flex items-center justify-center">
            <canvas id="demandChart"></canvas>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Food Orders by Cuisine -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="font-semibold text-slate-800 text-sm">Cuisine Popularity Index</h3>
            <p class="text-xs text-slate-400">Total units ordered by cuisine style</p>
        </div>
        <div class="h-64 w-full relative flex items-center justify-center">
            <canvas id="cuisineChart"></canvas>
        </div>
    </div>

    <!-- Room Status Summary -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs lg:col-span-2 space-y-4">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="font-semibold text-slate-800 text-sm">Real-time Suite Availability</h3>
            <p class="text-xs text-slate-400">Current status of resort inventory</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
                <span class="block text-2xl font-bold text-slate-700">{{ $roomStatusSummary['total'] }}</span>
                <span class="text-xs text-slate-400 font-medium">Total Inventory</span>
            </div>
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-center">
                <span class="block text-2xl font-bold text-emerald-600">{{ $roomStatusSummary['available'] }}</span>
                <span class="text-xs text-emerald-500 font-medium">Vacant Clean</span>
            </div>
            <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-center">
                <span class="block text-2xl font-bold text-rose-600">{{ $roomStatusSummary['occupied'] }}</span>
                <span class="text-xs text-rose-500 font-medium">Occupied Rooms</span>
            </div>
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 text-center">
                <span class="block text-2xl font-bold text-amber-600">{{ $roomStatusSummary['maintenance'] }}</span>
                <span class="text-xs text-amber-500 font-medium">Out of Service</span>
            </div>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center justify-between mt-2">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="percent" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="block font-semibold text-slate-700 text-sm">Occupancy Analytics</span>
                    <span class="block text-xs text-slate-400">Goal is 75% for optimal operation margins</span>
                </div>
            </div>
            <span class="text-sm font-bold text-slate-700">{{ $occupancyRate }}% reached</span>
        </div>
    </div>
</div>

<!-- Recent Activities Logs (Bookings & Orders) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Recent Bookings -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800 text-sm">Recent Guest Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs text-amber-500 hover:text-amber-600 font-bold flex items-center gap-1">
                <span>View All</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Guest / Booking ID</th>
                        <th class="px-6 py-3.5">Room</th>
                        <th class="px-6 py-3.5">Check In</th>
                        <th class="px-6 py-3.5">Amount</th>
                        <th class="px-6 py-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800">{{ $booking->customer_name }}</span>
                                <span class="block text-[10px] text-slate-400 uppercase tracking-widest mt-0.5">ID: LXS-{{ $booking->id }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $booking->room->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                {{ $booking->check_in->format('M d') }}
                            </td>
                            <td class="px-6 py-4 text-slate-800">
                                ₹{{ number_format($booking->total) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->status === 'Confirmed')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wide">Confirmed</span>
                                @elseif($booking->status === 'Checked In')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wide">Checked In</span>
                                @elseif($booking->status === 'Checked Out')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wide">Checked Out</span>
                                @elseif($booking->status === 'Cancelled')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100 uppercase tracking-wide">Cancelled</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-wide">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <span>No bookings logged recently.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800 text-sm">Recent Food Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-amber-500 hover:text-amber-600 font-bold flex items-center gap-1">
                <span>View All</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">Customer / Table</th>
                        <th class="px-6 py-3.5">Grand Total</th>
                        <th class="px-6 py-3.5">Order Status</th>
                        <th class="px-6 py-3.5">Payment</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800">{{ $order->customer_name }}</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Loc: {{ $order->delivery_address }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-800">
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
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Paid</span>
                                    </span>
                                @elseif($order->payment_status === 'Failed')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-500/10 text-rose-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Failed</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Pending</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <span>No restaurant orders logged recently.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // 1. Revenue Chart Configuration (Bookings vs Orders vs Combined Total)
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Bookings Revenue',
                    data: {!! json_encode($bookingRevenueData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true
                },
                {
                    label: 'Restaurant Revenue',
                    data: {!! json_encode($orderRevenueData) !!},
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.05)',
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true
                },
                {
                    label: 'Total Combined Revenue',
                    data: {!! json_encode($totalRevenueData) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 3,
                    tension: 0.35,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: { family: 'Instrument Sans', size: 11, weight: '500' },
                        color: '#64748b'
                    }
                },
                tooltip: {
                    padding: 12,
                    titleFont: { family: 'Instrument Sans', size: 12, weight: '600' },
                    bodyFont: { family: 'Instrument Sans', size: 12 },
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.dataset.label + ': ₹' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Instrument Sans', size: 10 },
                        callback: function(value) { return '₹' + value.toLocaleString(); }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { family: 'Instrument Sans', size: 10 } }
                }
            }
        }
    });

    // 2. Room Category Demand Share Doughnut
    const ctxDemand = document.getElementById('demandChart').getContext('2d');
    new Chart(ctxDemand, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryCounts) !!},
                backgroundColor: ['#3b82f6', '#10b981', '#6366f1', '#f59e0b', '#ec4899'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { family: 'Instrument Sans', size: 11, weight: '500' },
                        color: '#64748b',
                        padding: 15
                    }
                },
                tooltip: {
                    padding: 10,
                    titleFont: { family: 'Instrument Sans', size: 12, weight: '600' },
                    bodyFont: { family: 'Instrument Sans', size: 12 }
                }
            },
            cutout: '65%'
        }
    });

    // 3. Cuisine Popularity Index Bar Chart
    const ctxCuisine = document.getElementById('cuisineChart').getContext('2d');
    new Chart(ctxCuisine, {
        type: 'bar',
        data: {
            labels: {!! json_encode($cuisineLabels) !!},
            datasets: [{
                label: 'Qty Ordered',
                data: {!! json_encode($cuisineCounts) !!},
                backgroundColor: '#6366f1',
                borderRadius: 8,
                barThickness: 18
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 10,
                    titleFont: { family: 'Instrument Sans', size: 12, weight: '600' },
                    bodyFont: { family: 'Instrument Sans', size: 12 }
                }
            },
            scales: {
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#64748b', font: { family: 'Instrument Sans', size: 10 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { family: 'Instrument Sans', size: 10 } }
                }
            }
        }
    });
</script>
@endsection
