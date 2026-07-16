@extends('layouts.app')

@section('title', 'Modify Booking details')
@section('page_title', 'Update Booking')

@section('content')
<div class="flex items-center gap-3 mb-4">
    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500 hover:text-slate-800 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
    </a>
    <div>
        <h2 class="font-semibold text-slate-800 text-sm">Edit Booking details: LXS-{{ $booking->id }}</h2>
        <p class="text-xs text-slate-400">Modify information inside resort database</p>
    </div>
</div>

@if ($errors->any())
    <div class="bg-rose-50 border border-rose-200/80 text-rose-800 rounded-2xl p-4 text-sm shadow-xs mb-6">
        <div class="font-bold flex items-center gap-2 mb-2">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            <span>Validation errors detected:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" class="bg-white border border-slate-200/80 rounded-3xl p-6 lg:p-8 shadow-xs space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Select Suite/Room -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Select Room / Suite *</label>
            <select name="room_id" required id="roomSelect"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                @foreach($rooms as $r)
                    <option value="{{ $r->id }}" data-price="{{ $r->price }}" {{ old('room_id', $booking->room_id) == $r->id ? 'selected' : '' }}>
                        {{ $r->name }} (₹{{ number_format($r->price) }}/night, max {{ $r->capacity }} guests)
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Reservation Status -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Booking Status *</label>
            <select name="status" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ old('status', $booking->status) === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
        </div>

        <!-- Guest Details -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Guest Full Name *</label>
            <input type="text" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" required 
                   placeholder="e.g. John Doe"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Guest Phone -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Guest Phone number *</label>
            <input type="text" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" required 
                   placeholder="e.g. +91 98765 43210"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Guest Email -->
        <div class="md:col-span-2">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Guest Email Address *</label>
            <input type="email" name="customer_email" value="{{ old('customer_email', $booking->customer_email) }}" required 
                   placeholder="e.g. guest@example.com"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Check-in Date -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Check In Date *</label>
            <input type="date" name="check_in" value="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}" required id="checkInDate"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Check-out Date -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Check Out Date *</label>
            <input type="date" name="check_out" value="{{ old('check_out', $booking->check_out->format('Y-m-d')) }}" required id="checkOutDate"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Guests Count -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Number of Guests *</label>
            <input type="number" name="guests" value="{{ old('guests', $booking->guests) }}" required min="1"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Interactive estimation preview box -->
        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-4 flex flex-col justify-center text-xs">
            <span class="text-slate-400 font-semibold uppercase block mb-1.5 tracking-wide">Charges Breakdown Preview</span>
            <div class="space-y-1 text-slate-600 font-medium">
                <div class="flex justify-between">
                    <span>Days calculated:</span>
                    <span id="previewNights">0 nights</span>
                </div>
                <div class="flex justify-between">
                    <span>GST (18%):</span>
                    <span id="previewTax">₹0</span>
                </div>
                <div class="flex justify-between text-slate-800 font-bold border-t border-slate-200 pt-1.5 mt-1">
                    <span>Grand Total:</span>
                    <span id="previewTotal" class="text-amber-600">₹0</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Special Requests -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Special Requests / Notes</label>
        <textarea name="special_requests" rows="3" 
                  placeholder="Need early check-in, honeymoon setup..."
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('special_requests', $booking->special_requests) }}</textarea>
    </div>

    <!-- Submit buttons -->
    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" 
           class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 font-bold text-xs text-slate-500 hover:text-slate-800 transition-colors">
            Cancel
        </a>
        <button type="submit" 
                class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
            Save Changes
        </button>
    </div>

</form>
@endsection

@section('scripts')
<script>
    const roomSelect = document.getElementById('roomSelect');
    const checkInInput = document.getElementById('checkInDate');
    const checkOutInput = document.getElementById('checkOutDate');
    
    const previewNights = document.getElementById('previewNights');
    const previewTax = document.getElementById('previewTax');
    const previewTotal = document.getElementById('previewTotal');

    function calculateCharges() {
        const option = roomSelect.options[roomSelect.selectedIndex];
        if (!option || !option.value) {
            previewNights.innerText = '0 nights';
            previewTax.innerText = '₹0';
            previewTotal.innerText = '₹0';
            return;
        }

        const price = parseFloat(option.getAttribute('data-price')) || 0;
        
        const date1 = new Date(checkInInput.value);
        const date2 = new Date(checkOutInput.value);
        
        let nights = 0;
        if (!isNaN(date1) && !isNaN(date2)) {
            const diffTime = Math.abs(date2 - date1);
            nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }
        if (nights <= 0) nights = 1;

        const subtotal = price * nights;
        const gst = Math.round(subtotal * 0.18);
        const total = subtotal + gst;

        previewNights.innerText = `${nights} night${nights > 1 ? 's' : ''} (₹${price.toLocaleString()}/night)`;
        previewTax.innerText = `₹${gst.toLocaleString()}`;
        previewTotal.innerText = `₹${total.toLocaleString()}`;
    }

    roomSelect.addEventListener('change', calculateCharges);
    checkInInput.addEventListener('change', calculateCharges);
    checkOutInput.addEventListener('change', calculateCharges);
    
    // Initial load
    calculateCharges();
</script>
@endsection
