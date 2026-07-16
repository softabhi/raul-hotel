@extends('layouts.app')

@section('title', 'Manage Rooms')
@section('page_title', 'Rooms Directory')

@section('content')
<!-- Header Controls -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <div class="space-y-1">
        <h2 class="font-semibold text-slate-800 text-sm">Resort Room Inventory</h2>
        <p class="text-xs text-slate-400">Total list of rooms, suites and presidential units</p>
    </div>
    
    <a href="{{ route('admin.rooms.create') }}" 
       class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Add New Room</span>
    </a>
</div>

<!-- Search & Filters -->
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <form method="GET" action="{{ route('admin.rooms.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        
        <!-- Search -->
        <div class="relative sm:col-span-2">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4.5 h-4.5"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by room name..." 
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Category -->
        <div>
            <select name="category" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <!-- Availability -->
        <div class="flex items-center gap-3">
            <select name="availability" 
                    class="flex-1 bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Statuses</option>
                <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>Unavailable/Maintenance</option>
            </select>
            
            <button type="submit" 
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 p-2.5 rounded-xl border border-slate-200 transition-colors cursor-pointer" 
                    title="Apply Filters">
                <i data-lucide="sliders-horizontal" class="w-4.5 h-4.5"></i>
            </button>
        </div>

    </form>
</div>

<!-- Rooms Table -->
<div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Room Details</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Occupancy / Bed</th>
                    <th class="px-6 py-4">Nightly Price</th>
                    <th class="px-6 py-4">Availability</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium">
                @forelse($rooms as $room)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-4">
                            <div class="relative shrink-0">
                                <div class="w-16 h-12 rounded-xl overflow-hidden border border-slate-100 bg-slate-50">
                                    <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                                </div>
                                @if(count($room->images) > 1)
                                    <span class="absolute -bottom-1 -right-1 bg-slate-900/80 text-white font-bold text-[8px] px-1.5 py-0.5 rounded-md">
                                        +{{ count($room->images) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <span class="block font-semibold text-slate-800 text-xs sm:text-sm">{{ $room->name }}</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Size: {{ $room->size }} | Floor: {{ $room->floor }}</span>
                                
                                @if(count($room->images) > 1)
                                    <div class="flex gap-1 mt-1.5">
                                        @foreach(array_slice($room->images, 0, 4) as $subImg)
                                            <div class="w-5 h-5 rounded-md overflow-hidden border border-slate-200 shrink-0">
                                                <img src="{{ $subImg }}" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                        @if(count($room->images) > 4)
                                            <div class="w-5 h-5 rounded-md bg-slate-100 border border-slate-250 flex items-center justify-center text-[7px] text-slate-500 font-bold shrink-0">
                                                +{{ count($room->images) - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $room->category }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block font-semibold text-slate-700">{{ $room->capacity }} Guests Max</span>
                            <span class="block text-slate-400 mt-0.5">{{ $room->bed }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-baseline gap-1">
                                <span class="font-bold text-slate-800">₹{{ number_format($room->price) }}</span>
                                @if($room->original_price)
                                    <span class="text-[10px] text-slate-400 line-through">₹{{ number_format($room->original_price) }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($room->available)
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wide">Available</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100 uppercase tracking-wide">Maintenance</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" 
                                   class="p-2 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-xl transition-colors" 
                                   title="Edit Room Details">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this room? This action is permanent.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 hover:bg-rose-50 text-slate-500 hover:text-rose-600 rounded-xl transition-colors cursor-pointer" 
                                            title="Delete Room">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
                            <span class="block">No rooms found in the inventory database.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($rooms->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $rooms->links() }}
        </div>
    @endif

</div>
@endsection
