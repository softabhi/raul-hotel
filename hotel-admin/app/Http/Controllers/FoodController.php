<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Food::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('cuisine')) {
            $query->where('cuisine', $request->cuisine);
        }

        $foods = $query->latest()->paginate(10)->withQueryString();
        
        $categories = ["Main Course", "Appetizers", "Pizza", "Seafood", "Breads", "Desserts", "Beverages"];
        $cuisines = ["Indian", "Italian", "Chinese", "Continental"];
        $types = ["veg", "non-veg"];

        return view('foods.index', compact('foods', 'categories', 'cuisines', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ["Main Course", "Appetizers", "Pizza", "Seafood", "Breads", "Desserts", "Beverages"];
        $cuisines = ["Indian", "Italian", "Chinese", "Continental"];
        $types = ["veg", "non-veg"];
        $spiceLevels = ["None", "Mild", "Medium", "Hot", "Medium-Hot"];

        return view('foods.create', compact('categories', 'cuisines', 'types', 'spiceLevels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'type' => 'required|string|in:veg,non-veg',
            'cuisine' => 'required|string',
            'price' => 'required|integer|min:0',
            'original_price' => 'nullable|integer|min:0',
            'prep_time' => 'nullable|string',
            'servings' => 'required|integer|min:1',
            'calories' => 'nullable|integer',
            'spice_level' => 'nullable|string',
            'is_popular' => 'required|boolean',
            'is_bestseller' => 'required|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'description' => 'required|string',
            'ingredients' => 'nullable|string', // Comma separated, we will split into array
            'tags' => 'nullable|string', // Comma separated, we will split into array
        ]);

        if (!empty($validated['ingredients'])) {
            $validated['ingredients'] = array_map('trim', explode(',', $validated['ingredients']));
        } else {
            $validated['ingredients'] = [];
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        $imageUrls = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('foods', 'public');
                $imageUrls[] = asset('storage/' . $path);
            }
        }

        if (empty($imageUrls)) {
            $imageUrls[] = 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80';
        }

        $validated['image'] = json_encode($imageUrls);

        Food::create($validated);

        return redirect()->route('admin.foods.index')->with('success', 'Food item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        $categories = ["Main Course", "Appetizers", "Pizza", "Seafood", "Breads", "Desserts", "Beverages"];
        $cuisines = ["Indian", "Italian", "Chinese", "Continental"];
        $types = ["veg", "non-veg"];
        $spiceLevels = ["None", "Mild", "Medium", "Hot", "Medium-Hot"];

        $food->ingredients_str = is_array($food->ingredients) ? implode(', ', $food->ingredients) : '';
        $food->tags_str = is_array($food->tags) ? implode(', ', $food->tags) : '';

        return view('foods.edit', compact('food', 'categories', 'cuisines', 'types', 'spiceLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'type' => 'required|string|in:veg,non-veg',
            'cuisine' => 'required|string',
            'price' => 'required|integer|min:0',
            'original_price' => 'nullable|integer|min:0',
            'prep_time' => 'nullable|string',
            'servings' => 'required|integer|min:1',
            'calories' => 'nullable|integer',
            'spice_level' => 'nullable|string',
            'is_popular' => 'required|boolean',
            'is_bestseller' => 'required|boolean',
            'existing_images' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'description' => 'required|string',
            'ingredients' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        if (!empty($validated['ingredients'])) {
            $validated['ingredients'] = array_map('trim', explode(',', $validated['ingredients']));
        } else {
            $validated['ingredients'] = [];
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        $imageUrls = $request->input('existing_images', []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('foods', 'public');
                $imageUrls[] = asset('storage/' . $path);
            }
        }

        if (empty($imageUrls)) {
            $imageUrls[] = 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80';
        }

        $validated['image'] = json_encode($imageUrls);

        $food->update($validated);

        return redirect()->route('admin.foods.index')->with('success', 'Food item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        $food->delete();
        return redirect()->route('admin.foods.index')->with('success', 'Food item deleted successfully.');
    }
}
