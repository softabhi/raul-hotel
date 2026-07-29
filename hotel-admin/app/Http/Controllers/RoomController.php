<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('availability')) {
            $status = $request->availability === 'available';
            $query->where('available', $status);
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();
        $categories = ['Standard', 'Deluxe', 'Suite', 'Presidential'];

        return view('rooms.index', compact('rooms', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Standard', 'Deluxe', 'Suite', 'Presidential'];
        return view('rooms.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|integer|min:0',
            'original_price' => 'nullable|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'size' => 'required|string',
            'bed' => 'required|string',
            'floor' => 'required|string',
            'view' => 'required|string',
            'available' => 'required|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'amenities' => 'nullable|string',
            'description' => 'required|string',
            'highlights' => 'nullable|string',
        ]);

        //  dd($validated);

        // Process comma-separated strings to array
        $validated['amenities'] = !empty($validated['amenities'])
            ? array_map('trim', explode(',', $validated['amenities']))
            : [];

        $validated['highlights'] = !empty($validated['highlights'])
            ? array_map('trim', explode(',', $validated['highlights']))
            : [];

        // Save images directly into public/rooms
        $imageUrls = [];
        if ($request->hasFile('images')) {
            $destinationPath = public_path('rooms');

            // Ensure the folder exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                // Store as relative path so it works on any host/port
                $imageUrls[] = '/rooms/' . $filename;
            }
        }

        $validated['image'] = !empty($imageUrls) ? json_encode($imageUrls) : null;

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $categories = ['Standard', 'Deluxe', 'Suite', 'Presidential'];

        // Convert array back to comma-separated string for editing
        $room->amenities_str = is_array($room->amenities) ? implode(', ', $room->amenities) : '';
        $room->highlights_str = is_array($room->highlights) ? implode(', ', $room->highlights) : '';

        return view('rooms.edit', compact('room', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|integer|min:0',
            'original_price' => 'nullable|integer|min:0',
            'capacity' => 'required|integer|min:1',
            'size' => 'required|string',
            'bed' => 'required|string',
            'floor' => 'required|string',
            'view' => 'required|string',
            'available' => 'required|boolean',
            'existing_images' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'amenities' => 'nullable|string',
            'description' => 'required|string',
            'highlights' => 'nullable|string',
        ]);

        // dd($validated);
        // dump($request->all());

        $validated['amenities'] = !empty($validated['amenities'])
            ? array_map('trim', explode(',', $validated['amenities']))
            : [];

        $validated['highlights'] = !empty($validated['highlights'])
            ? array_map('trim', explode(',', $validated['highlights']))
            : [];

                

        $imageUrls = $request->input('existing_images', []);

        // Delete images that were removed by the user
        // Use getRawOriginal to bypass the getImageAttribute mutator (which returns only the first image URL)
        $rawImage = $room->getRawOriginal('image');
        $oldImages = $rawImage ? json_decode($rawImage, true) : [];
        if (!is_array($oldImages)) {
            $oldImages = [];
        }
        $removedImages = array_diff($oldImages, $imageUrls);

        foreach ($removedImages as $removedImage) {
            $filePath = public_path(ltrim($removedImage, '/'));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Save newly uploaded images directly into public/rooms
        if ($request->hasFile('images')) {
            $destinationPath = public_path('rooms');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                $imageUrls[] = '/rooms/' . $filename;
            }
        }

        $validated['image'] = !empty($imageUrls) ? json_encode($imageUrls) : null;

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
