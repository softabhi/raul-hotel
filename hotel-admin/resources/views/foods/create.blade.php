@extends('layouts.app')

@section('title', 'Add Menu Item')
@section('page_title', 'Create Food Item')

@section('content')
<div class="flex items-center gap-3 mb-4">
    <a href="{{ route('admin.foods.index') }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500 hover:text-slate-800 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
    </a>
    <div>
        <h2 class="font-semibold text-slate-800 text-sm">Add New Menu Dish</h2>
        <p class="text-xs text-slate-400">Configure information inside resort kitchen catalog</p>
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

<form method="POST" action="{{ route('admin.foods.store') }}" enctype="multipart/form-data" class="bg-white border border-slate-200/80 rounded-3xl p-6 lg:p-8 shadow-xs space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Dish Name -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Dish Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                   placeholder="e.g. Garlic Butter Naan"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Category -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu Category *</label>
            <select name="category" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <!-- Food Type -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Food Type (Veg / Non-Veg) *</label>
            <select name="type" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">Select Type</option>
                @foreach($types as $t)
                    <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ strtoupper($t) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Cuisine -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Cuisine Origin *</label>
            <select name="cuisine" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">Select Cuisine</option>
                @foreach($cuisines as $cui)
                    <option value="{{ $cui }}" {{ old('cuisine') === $cui ? 'selected' : '' }}>{{ $cui }}</option>
                @endforeach
            </select>
        </div>

        <!-- Price -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Price (INR) *</label>
            <input type="number" name="price" value="{{ old('price') }}" required min="0"
                   placeholder="e.g. 299"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Original Price -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Original Price (INR - for discount slash)</label>
            <input type="number" name="original_price" value="{{ old('original_price') }}" min="0"
                   placeholder="e.g. 399"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Prep Time -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Preparation Time *</label>
            <input type="text" name="prep_time" value="{{ old('prep_time', '20 mins') }}" required
                   placeholder="e.g. 15 mins or 30 mins"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Servings -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Servings (No of Persons) *</label>
            <input type="number" name="servings" value="{{ old('servings', 1) }}" required min="1"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Calories -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Calories (kcal)</label>
            <input type="number" name="calories" value="{{ old('calories') }}" min="0"
                   placeholder="e.g. 350"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Spice Level -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Spice Level</label>
            <select name="spice_level" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                @foreach($spiceLevels as $sl)
                    <option value="{{ $sl }}" {{ old('spice_level', 'None') === $sl ? 'selected' : '' }}>{{ $sl }}</option>
                @endforeach
            </select>
        </div>

        <!-- Is Popular -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Mark as Popular? *</label>
            <select name="is_popular" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="0" {{ old('is_popular') === '0' || old('is_popular') === null ? 'selected' : '' }}>No, standard item</option>
                <option value="1" {{ old('is_popular') === '1' ? 'selected' : '' }}>Yes, show popular badge</option>
            </select>
        </div>

        <!-- Is Bestseller -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Mark as Bestseller? *</label>
            <select name="is_bestseller" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="0" {{ old('is_bestseller') === '0' || old('is_bestseller') === null ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('is_bestseller') === '1' ? 'selected' : '' }}>Yes, best selling item</option>
            </select>
        </div>

    </div>

    <!-- Food Images Upload -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Food Images *</label>
        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 hover:border-amber-500 transition-colors bg-slate-50/50">
            <div class="flex flex-col items-center justify-center text-center">
                <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-400 mb-2"></i>
                <p class="text-xs font-semibold text-slate-600 mb-1">Click to upload multiple files</p>
                <p class="text-[10px] text-slate-400">PNG, JPG, JPEG, WEBP or SVG up to 5MB</p>
                <input type="file" name="images[]" multiple accept="image/*" required class="hidden" id="food_images" onchange="previewImages(this, 'preview-container')">
                <label for="food_images" class="mt-4 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold px-4 py-2 rounded-xl cursor-pointer transition-colors shadow-sm">
                    Select Images
                </label>
            </div>
            <!-- Preview grid -->
            <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4 mt-6 hidden">
                <!-- Preview items will be dynamically injected here -->
            </div>
        </div>
    </div>

    <!-- Ingredients (Comma-separated) -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ingredients (Comma separated list)</label>
        <textarea name="ingredients" rows="2" 
                  placeholder="Butter, Garlic, Yeast, Refined Flour, Salt"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('ingredients') }}</textarea>
    </div>

    <!-- Tags (Comma-separated) -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tags / Label Tags (Comma separated)</label>
        <textarea name="tags" rows="2" 
                  placeholder="Soft, Freshly baked, Chef Special"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('tags') }}</textarea>
    </div>

    <!-- Description -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Dish Description *</label>
        <textarea name="description" rows="4" required
                  placeholder="Describe the dish taste profile, texture, serving temperature..."
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('description') }}</textarea>
    </div>

    <!-- Submit buttons -->
    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <a href="{{ route('admin.foods.index') }}" 
           class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 font-bold text-xs text-slate-500 hover:text-slate-800 transition-colors">
            Cancel
        </a>
        <button type="submit" 
                class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
            Create Menu Item
        </button>
    </div>

</form>

<script>
    function previewImages(input, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';
        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-video rounded-xl overflow-hidden border border-slate-200 bg-slate-100 group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-[10px] text-white font-medium truncate px-2 w-full text-center">${file.name}</span>
                        </div>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endsection
