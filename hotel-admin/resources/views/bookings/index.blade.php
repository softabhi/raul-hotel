@extends('layouts.app')

@section('title', 'Room Bookings')
@section('page_title', 'Room Reservations')

@section('content')
<!-- Header Controls -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <div class="space-y-1">
        <h2 class="font-semibold text-slate-800 text-sm">Resort Bookings Registry</h2>
        <p class="text-xs text-slate-400">List of active, completed and cancelled reservations</p>
    </div>
    
    <a href="{{ route('admin.bookings.create') }}" 
       class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Create Walk-in Booking</span>
    </a>
</div>

<!-- Search & Filters -->
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- Search -->
        <div class="relative sm:col-span-2">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4.5 h-4.5"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by Guest Name, Email, Phone, Booking ID..." 
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Status -->
        <div class="flex items-center gap-3">
            <select name="status" 
                    class="flex-1 bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Statuses</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
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

<!-- Bookings Table -->
<div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Booking ID</th>
                    <th class="px-6 py-4">Guest Details</th>
                    <th class="px-6 py-4">Room Reserved</th>
                    <th class="px-6 py-4">Dates / Nights</th>
                    <th class="px-6 py-4">Total Amount</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium font-medium">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-slate-800">
                            LXS-{{ $booking->id }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="block font-semibold text-slate-800 text-sm">{{ $booking->customer_name }}</span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">{{ $booking->customer_phone }} | {{ $booking->customer_email }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            <span class="block text-slate-800 font-semibold">{{ $booking->room->name ?? 'Deleted Room' }}</span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">Cat: {{ $booking->room->category ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">
                            <div class="flex items-center gap-1">
                                <span class="font-semibold text-slate-700">{{ $booking->check_in->format('Y-m-d') }}</span>
                                <span class="text-slate-400">to</span>
                                <span class="font-semibold text-slate-700">{{ $booking->check_out->format('Y-m-d') }}</span>
                            </div>
                            <span class="block text-[10px] text-amber-500 font-bold mt-1 uppercase tracking-wider">{{ $booking->nights }} Nights | {{ $booking->guests }} Guests</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">
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
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                   class="p-2 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-xl transition-colors" 
                                   title="View Invoice & Status">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
                                   class="p-2 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-xl transition-colors" 
                                   title="Edit Booking details">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 hover:bg-rose-50 text-slate-500 hover:text-rose-600 rounded-xl transition-colors cursor-pointer" 
                                            title="Delete Booking">
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
                            <span class="block">No bookings matched the select criteria.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $bookings->links() }}
        </div>
    @endif

</div>
@endsection
