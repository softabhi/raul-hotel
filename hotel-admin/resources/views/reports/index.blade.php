@extends('layouts.app')

@section('title', 'Reports & Export')
@section('page_title', 'Financial Reports')

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
<!-- Header Controls -->
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
    <div class="space-y-1">
        <h2 class="font-semibold text-slate-800 text-sm">Resort Intelligence Dashboard</h2>
        <p class="text-xs text-slate-400">Generate statements, export raw CSV streams and analyze revenue</p>
    </div>
    
    <button onclick="window.print()" 
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl border border-slate-200 transition-all text-xs cursor-pointer">
        <i data-lucide="printer" class="w-4 h-4"></i>
        <span>Print Report Sheet</span>
    </button>
</div>

<!-- Filters Panel -->
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs no-print">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col sm:flex-row sm:items-end gap-4">
        
        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDateStr }}" 
                   class="bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">End Date</label>
            <input type="date" name="end_date" value="{{ $endDateStr }}" 
                   class="bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <button type="submit" 
                class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
            Filter Data
        </button>

    </form>
</div>

<!-- PRINT AREA WRAPPER -->
<div id="printArea" class="space-y-6">

    <!-- Print Title Header (only visible on print) -->
    <div class="hidden print:block border-b border-slate-200 pb-4 mb-6">
        <h1 class="font-playfair text-2xl font-bold text-slate-800 tracking-wider">THE LUXURY RESORT</h1>
        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Financial Report Statement</span>
        <span class="block text-[10px] text-slate-500 mt-1">Filtered from {{ $startDateStr }} to {{ $endDateStr }} | Printed: {{ now()->format('Y-m-d H:i') }}</span>
    </div>

    <!-- Aggregate Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <!-- Combined Revenue -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Combined Gross Revenue</span>
            <span class="text-2xl font-bold text-slate-800">₹{{ number_format($totalRevenue) }}</span>
            <div class="flex justify-between items-center text-[10px] font-medium text-slate-500 mt-3 pt-3 border-t border-slate-100">
                <span>Rooms: ₹{{ number_format($bookingRevenue) }}</span>
                <span>F&B: ₹{{ number_format($ordersRevenue) }}</span>
            </div>
        </div>

        <!-- Taxes Collected -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Taxes Collected</span>
            <span class="text-2xl font-bold text-slate-800">₹{{ number_format($totalTax) }}</span>
            <div class="text-[10px] font-medium text-slate-500 mt-3 pt-3 border-t border-slate-100">
                Includes GST 18% (Rooms) & 5% (F&B)
            </div>
        </div>

        <!-- Bookings Summary -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Bookings & Orders</span>
            <span class="text-2xl font-bold text-slate-800">{{ $totalBookings + $totalOrders }} Units</span>
            <div class="flex justify-between items-center text-[10px] font-medium text-slate-500 mt-3 pt-3 border-t border-slate-100">
                <span>Bookings: {{ $totalBookings }} ({{ $cancelledBookings }} canc.)</span>
                <span>Orders: {{ $totalOrders }} ({{ $cancelledOrders }} canc.)</span>
            </div>
        </div>

    </div>

    <!-- Raw Data CSV Export Buttons (No Print) -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4 no-print">
        <h3 class="font-semibold text-slate-800 text-sm">Download Raw Data Exports</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <a href="{{ route('admin.reports.index', ['start_date' => $startDateStr, 'end_date' => $endDateStr, 'export' => 'bookings']) }}" 
               class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 hover:border-amber-500/30 hover:bg-slate-100/50 rounded-2xl transition-all font-medium text-xs text-slate-700 cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-50 text-blue-500 flex items-center justify-center rounded-lg">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </div>
                    <span>Export Rooms Bookings</span>
                </div>
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
            </a>

            <a href="{{ route('admin.reports.index', ['start_date' => $startDateStr, 'end_date' => $endDateStr, 'export' => 'orders']) }}" 
               class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 hover:border-amber-500/30 hover:bg-slate-100/50 rounded-2xl transition-all font-medium text-xs text-slate-700 cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-50 text-indigo-500 flex items-center justify-center rounded-lg">
                        <i data-lucide="soup" class="w-4 h-4"></i>
                    </div>
                    <span>Export Food Orders</span>
                </div>
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
            </a>

            <a href="{{ route('admin.reports.index', ['start_date' => $startDateStr, 'end_date' => $endDateStr, 'export' => 'financial']) }}" 
               class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 hover:border-amber-500/30 hover:bg-slate-100/50 rounded-2xl transition-all font-medium text-xs text-slate-700 cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-amber-50 text-amber-500 flex items-center justify-center rounded-lg">
                        <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                    </div>
                    <span>Export Financial summary</span>
                </div>
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
            </a>

        </div>
    </div>

    <!-- Data Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Popular Rooms -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Popular Rooms & Suites Demand</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">Room Suite</th>
                            <th class="px-6 py-3.5">Category</th>
                            <th class="px-6 py-3.5 text-center">Bookings</th>
                            <th class="px-6 py-3.5 text-right">Revenue Generated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($popularRooms as $room)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $room->name }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $room->category }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-700">
                                    {{ $room->booking_count }} times
                                </td>
                                <td class="px-6 py-4 text-right text-slate-800 font-semibold">
                                    ₹{{ number_format($room->total_revenue) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                    No room bookings logged in the date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popular Food Items -->
        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Popular Food Dishes Sold</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">Dish Name</th>
                            <th class="px-6 py-3.5">Cuisine</th>
                            <th class="px-6 py-3.5 text-center">Quantity Sold</th>
                            <th class="px-6 py-3.5 text-right">Sales Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($popularFoods as $food)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $food->name }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $food->cuisine }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-700">
                                    {{ $food->items_sold }} units
                                </td>
                                <td class="px-6 py-4 text-right text-slate-800 font-semibold">
                                    ₹{{ number_format($food->total_revenue) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                    No food orders logged in the date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
