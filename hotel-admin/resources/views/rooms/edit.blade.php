@extends('layouts.app')

@section('title', 'Edit Room Details')
@section('page_title', 'Update Room')

@section('content')
<div class="flex items-center gap-3 mb-4">
    <a href="{{ route('admin.rooms.index') }}" class="p-2 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500 hover:text-slate-800 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
    </a>
    <div>
        <h2 class="font-semibold text-slate-800 text-sm">Edit Room details: {{ $room->name }}</h2>
        <p class="text-xs text-slate-400">Modify information inside resort database</p>
    </div>
</div>

@if ($errors->any())
    <div class="bg-rose-50 border border-rose-200/80 text-rose-800 rounded-2xl p-4 text-sm shadow-xs mb-6">
        <div class="font-bold flex items-center gap-2 mb-2">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            <span>Whoops! Please fix the validation errors below:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" enctype="multipart/form-data" class="bg-white border border-slate-200/80 rounded-3xl p-6 lg:p-8 shadow-xs space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Room Name -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Room / Suite Name *</label>
            <input type="text" name="name" value="{{ old('name', $room->name) }}" required 
                   placeholder="e.g. Classic Premium Ocean View"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Room Category -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Category *</label>
            <select name="category" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $room->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <!-- Price -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nightly Price (INR) *</label>
            <input type="number" name="price" value="{{ old('price', $room->price) }}" required min="0"
                   placeholder="e.g. 8999"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Original Price -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Original Price (INR - for discount slash)</label>
            <input type="number" name="original_price" value="{{ old('original_price', $room->original_price) }}" min="0"
                   placeholder="e.g. 11999"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Capacity -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Max Capacity (Guests) *</label>
            <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required min="1"
                   placeholder="e.g. 2"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Bed Details -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Bed Details *</label>
            <input type="text" name="bed" value="{{ old('bed', $room->bed) }}" required
                   placeholder="e.g. 1 King Bed or 2 Double Beds"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Size -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Room Size *</label>
            <input type="text" name="size" value="{{ old('size', $room->size) }}" required
                   placeholder="e.g. 42 sqm"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Floor location -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Floor location *</label>
            <input type="text" name="floor" value="{{ old('floor', $room->floor) }}" required
                   placeholder="e.g. 3rd Floor or Penthouse"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- View -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">View Details *</label>
            <input type="text" name="view" value="{{ old('view', $room->view) }}" required
                   placeholder="e.g. Sea View or Garden View"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
        </div>

        <!-- Availability Status -->
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Availability Status *</label>
            <select name="available" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">
                <option value="1" {{ old('available', $room->available ? '1' : '0') === '1' ? 'selected' : '' }}>Available for booking</option>
                <option value="0" {{ old('available', $room->available ? '1' : '0') === '0' ? 'selected' : '' }}>In maintenance (Block bookings)</option>
            </select>
        </div>

    </div>

    <!-- Room Images Section -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Room Images</label>

        <!-- ─── Existing Images ─── -->
        <div id="existing-images-wrapper" class="mb-4 {{ count($room->images) > 0 ? '' : 'hidden' }}">
            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Current Images — click <span class="text-rose-500">✕</span> to remove</p>
            <div id="existing-images-grid" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                @foreach($room->images as $index => $imgUrl)
                    @php
                        // Resolve relative /storage/... paths to full URL for display
                        $displayUrl = str_starts_with($imgUrl, '/') ? url($imgUrl) : $imgUrl;
                    @endphp
                    <div class="existing-img-item relative aspect-video rounded-xl overflow-hidden border border-slate-200 bg-slate-100" data-url="{{ $imgUrl }}">
                        <input type="hidden" name="existing_images[]" value="{{ $imgUrl }}">
                        <img src="{{ $displayUrl }}" class="w-full h-full object-cover" alt="Room image {{ $index + 1 }}" loading="lazy">
                        <!-- Delete button — always visible in top-right corner -->
                        <button type="button"
                                onclick="removeExistingImage(this)"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-rose-500 hover:bg-rose-600 active:scale-90 text-white flex items-center justify-center shadow-md transition-all z-10 cursor-pointer"
                                title="Remove this image">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="no-existing-msg" class="{{ count($room->images) > 0 ? 'hidden' : '' }} mb-3">
            <p class="text-xs text-slate-400 italic">No existing images — upload new ones below.</p>
        </div>

        <!-- ─── Upload New Images ─── -->
        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 hover:border-amber-400 transition-colors bg-slate-50/50">
            <div class="flex flex-col items-center justify-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                <p class="text-xs font-semibold text-slate-600 mb-1">Click to add new images</p>
                <p class="text-[10px] text-slate-400">PNG, JPG, JPEG, WEBP up to 5MB each. You can add multiple batches.</p>
                <!-- Hidden real input — no name; we use a dynamic hidden input approach -->
                <input type="file" id="room_images_picker" multiple accept="image/*" class="hidden" onchange="addNewImages(this)">
                <label for="room_images_picker" class="mt-4 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold px-4 py-2 rounded-xl cursor-pointer transition-colors shadow-sm select-none">
                    Select Images
                </label>
            </div>

            <!-- Preview grid for queued new images -->
            <div id="new-images-preview" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mt-5 hidden"></div>

            <!-- Counter badge -->
            <p id="new-images-count" class="text-center text-[10px] text-amber-600 font-semibold mt-3 hidden"></p>
        </div>

        <!-- Hidden container where real file inputs are placed per-image -->
        <div id="new-images-inputs" class="hidden"></div>
    </div>

    <!-- Amenities (Comma-separated) -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Amenities (Comma separated list)</label>
        <textarea name="amenities" rows="2"
                  placeholder="Free WiFi, Air Conditioning, Flat Screen TV, Mini Bar, Jacuzzi, Balcony, Safe"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('amenities', $room->amenities_str) }}</textarea>
    </div>

    <!-- Highlights (Comma-separated) -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Highlights (Comma separated list)</label>
        <textarea name="highlights" rows="2"
                  placeholder="Private pool access, Complimentary airport transfer, 24/7 butler service"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('highlights', $room->highlights_str) }}</textarea>
    </div>

    <!-- Description -->
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Description / Suite Overview *</label>
        <textarea name="description" rows="4" required
                  placeholder="A detailed description of the room..."
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all text-xs">{{ old('description', $room->description) }}</textarea>
    </div>

    <!-- Submit buttons -->
    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <a href="{{ route('admin.rooms.index') }}"
           class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 font-bold text-xs text-slate-500 hover:text-slate-800 transition-colors">
            Cancel
        </a>
        <button type="submit"
                class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md text-xs active:scale-[0.98] cursor-pointer">
            Save Changes
        </button>
    </div>

</form>

<script>
    // ─── Remove an existing (already-saved) image ───────────────────────────
    function removeExistingImage(btn) {
        const item = btn.closest('.existing-img-item');
        if (!item) return;
        if (!confirm('Remove this image? This takes effect when you save.')) return;

        item.remove();

        // If no existing images left, show the "no existing images" message
        const grid = document.getElementById('existing-images-grid');
        if (grid && grid.querySelectorAll('.existing-img-item').length === 0) {
            document.getElementById('existing-images-wrapper').classList.add('hidden');
            document.getElementById('no-existing-msg').classList.remove('hidden');
        }
    }

    // ─── Accumulative new-image picker ──────────────────────────────────────
    // We store queued File objects in a JS array, then sync them to hidden
    // <input type="file"> elements right before form submit.
    let queuedFiles = [];   // array of File objects

    function addNewImages(input) {
        if (!input.files || input.files.length === 0) return;

        Array.from(input.files).forEach(file => {
            // Avoid duplicates by name+size
            const isDupe = queuedFiles.some(f => f.name === file.name && f.size === file.size);
            if (!isDupe) queuedFiles.push(file);
        });

        // Reset the picker so the same file can be re-selected later
        input.value = '';

        renderNewPreviews();
    }

    function renderNewPreviews() {
        const container = document.getElementById('new-images-preview');
        const countBadge = document.getElementById('new-images-count');
        container.innerHTML = '';

        if (queuedFiles.length === 0) {
            container.classList.add('hidden');
            countBadge.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        countBadge.classList.remove('hidden');
        countBadge.textContent = `${queuedFiles.length} new image${queuedFiles.length > 1 ? 's' : ''} queued for upload`;

        queuedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-video rounded-xl overflow-hidden border border-slate-200 bg-slate-100 group';
                div.dataset.index = index;
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover" alt="${file.name}">
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-end">
                        <span class="text-[9px] text-white font-medium truncate px-2 pb-1 w-full">${file.name}</span>
                    </div>
                    <button type="button" onclick="removeQueuedImage(${index})"
                            class="absolute top-1 right-1 w-6 h-6 rounded-full bg-rose-500 hover:bg-rose-600 active:scale-90 text-white flex items-center justify-center shadow-md transition-all z-10 cursor-pointer"
                            title="Remove from queue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                `;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeQueuedImage(index) {
        queuedFiles.splice(index, 1);
        renderNewPreviews();
    }

    // ─── Before submit: inject queued files as real form inputs ─────────────
    // Because file inputs cannot be set programmatically, we use a single
    // DataTransfer trick to attach all queued files to one hidden input.
    document.querySelector('form').addEventListener('submit', function(e) {
        const inputsDiv = document.getElementById('new-images-inputs');
        inputsDiv.innerHTML = ''; // clear old

        if (queuedFiles.length > 0) {
            const dt = new DataTransfer();
            queuedFiles.forEach(f => dt.items.add(f));

            const inp = document.createElement('input');
            inp.type = 'file';
            inp.name = 'images[]';
            inp.multiple = true;
            inp.files = dt.files;    // assign the FileList
            inputsDiv.appendChild(inp);
        }
        // If queuedFiles is empty, no images[] input is submitted — existing_images[] handles the rest
    });
</script>
@endsection

