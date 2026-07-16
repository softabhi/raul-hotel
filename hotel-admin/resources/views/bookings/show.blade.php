@extends('layouts.app')

@section('title', 'Booking Details #' . $booking->id)
@section('page_title', 'Booking Summary')

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
        <a href="{{ route('admin.bookings.index') }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500 hover:text-slate-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h2 class="font-semibold text-slate-800 text-sm">Reservation Details</h2>
            <p class="text-xs text-slate-400">ID: LXS-{{ $booking->id }} | Logged: {{ $booking->created_at->format('M d, Y H:i') }}</p>
        </div>
    </div>
    
    <div class="flex items-center gap-2">
        <button onclick="window.print()" 
                class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl border border-slate-200 transition-all text-xs cursor-pointer">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Print Invoice</span>
        </button>
        <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
           class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-md text-xs cursor-pointer">
            <i data-lucide="pencil" class="w-4 h-4"></i>
            <span>Edit details</span>
        </a>
    </div>
</div>

<!-- Main detailed invoice and details grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Invoice Details (Print Area) -->
    <div class="lg:col-span-2 space-y-6" id="printArea">
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xs space-y-8 relative overflow-hidden">
            
            <!-- Watermark/Background Accent -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-bl-full pointer-events-none"></div>

            <!-- Invoice Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="space-y-1.5">
                    <h1 class="font-playfair text-2xl font-bold text-slate-800 tracking-wider">THE LUXURY RESORT</h1>
                    <span class="block text-xs font-semibold text-slate-400 tracking-widest uppercase">INVOICE STATEMENT</span>
                </div>
                <div class="text-left sm:text-right text-xs text-slate-500 space-y-1">
                    <span class="block text-slate-800 font-bold text-sm">No: LXS-{{ $booking->id }}</span>
                    <span>Date: {{ $booking->created_at->format('Y-m-d') }}</span>
                    <span class="block">Status: <strong class="text-amber-500 uppercase">{{ $booking->status }}</strong></span>
                </div>
            </div>

            <!-- Guest & Hotel Meta -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs text-slate-600">
                <div class="space-y-2">
                    <span class="block font-bold text-slate-800 uppercase tracking-wider">Customer Details</span>
                    <span class="block font-semibold text-slate-800 text-sm">{{ $booking->customer_name }}</span>
                    <span class="block">Email: {{ $booking->customer_email }}</span>
                    <span class="block">Phone: {{ $booking->customer_phone }}</span>
                </div>
                <div class="space-y-2">
                    <span class="block font-bold text-slate-800 uppercase tracking-wider">Resort Address</span>
                    <span class="block font-semibold text-slate-800">The Luxury Resort & Spa</span>
                    <span>101 Beachfront Road, Marine Lines</span>
                    <span class="block">Goa, India - 403001</span>
                </div>
            </div>

            <!-- Reservation Specifications -->
            <div class="bg-slate-50 border border-slate-200/50 rounded-2xl p-5 grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Check In</span>
                    <span class="font-semibold text-slate-700 text-sm">{{ $booking->check_in->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Check Out</span>
                    <span class="font-semibold text-slate-700 text-sm">{{ $booking->check_out->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Total Nights</span>
                    <span class="font-semibold text-slate-700 text-sm">{{ $booking->nights }} Night{{ $booking->nights > 1 ? 's' : '' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Guests</span>
                    <span class="font-semibold text-slate-700 text-sm">{{ $booking->guests }} Guests</span>
                </div>
            </div>

            <!-- Invoice Item Table -->
            <div class="space-y-3">
                <span class="block text-xs font-bold text-slate-800 uppercase tracking-wider">Services Rendered</span>
                <table class="w-full text-left text-xs text-slate-600 border border-slate-100 rounded-xl overflow-hidden">
                    <thead class="bg-slate-50 font-bold text-slate-500 uppercase">
                        <tr>
                            <th class="p-3.5">Item Description</th>
                            <th class="p-3.5 text-center">Nights</th>
                            <th class="p-3.5 text-right">Unit Price (INR)</th>
                            <th class="p-3.5 text-right">Total (INR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        <tr>
                            <td class="p-3.5">
                                <span class="block font-semibold text-slate-800">{{ $booking->room->name ?? 'Suite Booking' }}</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Cat: {{ $booking->room->category ?? 'N/A' }} | Floor: {{ $booking->room->floor ?? 'N/A' }}</span>
                            </td>
                            <td class="p-3.5 text-center">{{ $booking->nights }}</td>
                            <td class="p-3.5 text-right">₹{{ number_format($booking->room->price ?? ($booking->subtotal / $booking->nights)) }}</td>
                            <td class="p-3.5 text-right font-semibold text-slate-800">₹{{ number_format($booking->subtotal) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Price Breakdown Calculation -->
            <div class="flex justify-end pt-4">
                <div class="w-full sm:w-80 text-xs text-slate-600 space-y-2">
                    <div class="flex justify-between font-semibold">
                        <span>Room Subtotal:</span>
                        <span class="text-slate-800">₹{{ number_format($booking->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold">
                        <span>GST (18% Goods & Services Tax):</span>
                        <span class="text-slate-800">₹{{ number_format($booking->gst) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-800 font-bold border-t border-slate-200 pt-3 mt-2 text-sm">
                        <span>Grand Total Due/Paid:</span>
                        <span class="text-amber-600">₹{{ number_format($booking->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Invoice Footer -->
            @if($booking->special_requests)
                <div class="pt-6 border-t border-slate-100">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">Guest Special Instructions</span>
                    <p class="text-xs text-slate-500 bg-slate-50 rounded-xl p-3 border border-slate-100 font-medium italic">
                        "{{ $booking->special_requests }}"
                    </p>
                </div>
            @endif

        </div>
    </div>

    <!-- Right Column: Status Operations Controls (No Print) -->
    <div class="space-y-6 no-print">
        
        <!-- Status Action Box -->
        <div class="bg-slate-900 border border-slate-800 text-white rounded-3xl p-6 shadow-xl space-y-4">
            <h3 class="font-semibold text-sm">Reservation Control</h3>
            <p class="text-xs text-slate-400">Progress the workflow based on guest arrival and payments</p>
            
            <div class="bg-slate-950 rounded-2xl p-4 flex items-center justify-between border border-slate-800">
                <span class="text-xs text-slate-400">Current Status:</span>
                @if($booking->status === 'Confirmed')
                    <span class="text-xs font-bold text-blue-400 uppercase">Confirmed</span>
                @elseif($booking->status === 'Checked In')
                    <span class="text-xs font-bold text-emerald-400 uppercase">Checked In</span>
                @elseif($booking->status === 'Checked Out')
                    <span class="text-xs font-bold text-slate-400 uppercase">Checked Out</span>
                @elseif($booking->status === 'Cancelled')
                    <span class="text-xs font-bold text-rose-400 uppercase">Cancelled</span>
                @else
                    <span class="text-xs font-bold text-amber-400 uppercase">Pending Payment</span>
                @endif
            </div>

            <div class="space-y-2 pt-2">
                @if($booking->status === 'Pending')
                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Confirmed">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Confirm Booking Payment
                        </button>
                    </form>
                @endif

                @if($booking->status === 'Confirmed' || $booking->status === 'Pending')
                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Checked In">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Check In Guest
                        </button>
                    </form>
                @endif

                @if($booking->status === 'Checked In')
                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Checked Out">
                        <button type="submit" class="w-full bg-slate-700 hover:bg-slate-600 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Check Out Guest (Release Room)
                        </button>
                    </form>
                @endif

                @if($booking->status !== 'Checked Out' && $booking->status !== 'Cancelled')
                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking? This will refund/invalidate the reservation.');">
                        @csrf
                        <input type="hidden" name="status" value="Cancelled">
                        <button type="submit" class="w-full bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 font-bold py-2.5 px-4 rounded-xl text-xs transition-all active:scale-[0.98] cursor-pointer">
                            Cancel Reservation
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Room Meta Box -->
        @if($booking->room)
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-4">
            <h3 class="font-semibold text-slate-800 text-sm">Suite Details</h3>
            <div class="w-full h-36 rounded-2xl overflow-hidden border border-slate-100">
                <img src="{{ $booking->room->image }}" alt="{{ $booking->room->name }}" class="w-full h-full object-cover">
            </div>
            <div class="text-xs text-slate-600 space-y-1.5 font-medium">
                <span class="block font-semibold text-slate-800 text-sm">{{ $booking->room->name }}</span>
                <span>Category: {{ $booking->room->category }}</span>
                <span class="block">Floor: {{ $booking->room->floor }} | View: {{ $booking->room->view }}</span>
                <span class="block text-slate-800 font-semibold pt-1">Capacity: {{ $booking->room->capacity }} Guests Max | {{ $booking->room->bed }}</span>
            </div>
        </div>
        @endif

    </div>

</div>
@endsection
