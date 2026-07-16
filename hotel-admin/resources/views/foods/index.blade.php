@extends('layouts.app')

@section('title', 'Restaurant Menu')
@section('page_title', 'Dining Menu Inventory')

@section('content')
<!-- Header Controls -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <div class="space-y-1">
        <h2 class="font-semibold text-slate-800 text-sm">Resort Kitchen Menu</h2>
        <p class="text-xs text-slate-400">List of starters, main courses, desserts, and beverages</p>
    </div>
    
    <a href="{{ route('admin.foods.create') }}" 
       class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Add Menu Item</span>
    </a>
</div>

<!-- Search & Filters -->
<div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
    <form method="GET" action="{{ route('admin.foods.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        
        <!-- Search -->
        <div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4.5 h-4.5"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search menu..." 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
            </div>
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

        <!-- Cuisine -->
        <div>
            <select name="cuisine" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Cuisines</option>
                @foreach($cuisines as $cui)
                    <option value="{{ $cui }}" {{ request('cuisine') === $cui ? 'selected' : '' }}>{{ $cui }}</option>
                @endforeach
            </select>
        </div>

        <!-- Type (Veg/Non-veg) -->
        <div class="flex items-center gap-3">
            <select name="type" 
                    class="flex-1 bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-3 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">All Types</option>
                @foreach($types as $t)
                    <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ strtoupper($t) }}</option>
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

<!-- Foods Table -->
<div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 tracking-wider border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Menu Dish</th>
                    <th class="px-6 py-4">Category / Cuisine</th>
                    <th class="px-6 py-4">Spice / Prep Time</th>
                    <th class="px-6 py-4">Price</th>
                    <th class="px-6 py-4">Attributes</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium font-medium">
                @forelse($foods as $food)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- Image & Name -->
                        <td class="px-6 py-4 flex items-center gap-4">
                            <div class="relative shrink-0">
                                <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border border-slate-100 bg-slate-50 relative">
                                    <img src="{{ $food->image }}" alt="{{ $food->name }}" class="w-full h-full object-cover">
                                    @if($food->type === 'veg')
                                        <div class="absolute top-1 right-1 w-3 h-3 bg-white border border-emerald-500 flex items-center justify-center rounded-xs" title="Veg">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        </div>
                                    @else
                                        <div class="absolute top-1 right-1 w-3 h-3 bg-white border border-rose-600 flex items-center justify-center rounded-xs" title="Non-Veg">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                        </div>
                                    @endif
                                </div>
                                @if(count($food->images) > 1)
                                    <span class="absolute -bottom-1 -right-1 bg-slate-900/80 text-white font-bold text-[8px] px-1.5 py-0.5 rounded-md">
                                        +{{ count($food->images) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <span class="block font-semibold text-slate-800 text-xs sm:text-sm">{{ $food->name }}</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Servings: {{ $food->servings }} person | Calories: {{ $food->calories ?? 'N/A' }} kcal</span>
                                
                                @if(count($food->images) > 1)
                                    <div class="flex gap-1 mt-1.5">
                                        @foreach(array_slice($food->images, 0, 4) as $subImg)
                                            <div class="w-5 h-5 rounded-md overflow-hidden border border-slate-200 shrink-0">
                                                <img src="{{ $subImg }}" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                        @if(count($food->images) > 4)
                                            <div class="w-5 h-5 rounded-md bg-slate-100 border border-slate-250 flex items-center justify-center text-[7px] text-slate-500 font-bold shrink-0">
                                                +{{ count($food->images) - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>
                        <!-- Category/Cuisine -->
                        <td class="px-6 py-4 text-xs">
                            <span class="block text-slate-800">{{ $food->category }}</span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">{{ $food->cuisine }} Cuisine</span>
                        </td>
                        <!-- Prep & Spice -->
                        <td class="px-6 py-4 text-xs">
                            <span class="block text-slate-700 font-semibold">{{ $food->prep_time ?? 'N/A' }}</span>
                            <span class="block text-[10px] text-amber-500 font-bold mt-0.5 uppercase tracking-wide">Spice: {{ $food->spice_level ?? 'None' }}</span>
                        </td>
                        <!-- Price -->
                        <td class="px-6 py-4 font-bold text-slate-800">
                            <div class="flex items-baseline gap-1">
                                <span>₹{{ number_format($food->price) }}</span>
                                @if($food->original_price)
                                    <span class="text-[10px] text-slate-400 line-through">₹{{ number_format($food->original_price) }}</span>
                                @endif
                            </div>
                        </td>
                        <!-- Attributes -->
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if($food->is_popular)
                                    <span class="px-1.5 py-0.5 rounded text-[8px] font-bold bg-amber-50 text-amber-700 border border-amber-100 uppercase">Popular</span>
                                @endif
                                @if($food->is_bestseller)
                                    <span class="px-1.5 py-0.5 rounded text-[8px] font-bold bg-purple-50 text-purple-700 border border-purple-100 uppercase">Bestseller</span>
                                @endif
                            </div>
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.foods.edit', $food->id) }}" 
                                   class="p-2 hover:bg-slate-100 text-slate-500 hover:text-slate-800 rounded-xl transition-colors" 
                                   title="Edit Dish details">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                
                                <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 hover:bg-rose-50 text-slate-500 hover:text-rose-600 rounded-xl transition-colors cursor-pointer" 
                                            title="Delete Dish">
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
                            <span class="block">No dishes found in the restaurant menu directory.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($foods->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $foods->links() }}
        </div>
    @endif

</div>
@endsection
