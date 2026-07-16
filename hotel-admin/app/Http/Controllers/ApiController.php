<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Food;
use App\Models\Booking;
use App\Models\Order;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Get all rooms formatted for Next.js frontend.
     */
    public function rooms()
    {
        $rooms = Room::all();
        $formatted = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'category' => $room->category,
                'price' => $room->price,
                'originalPrice' => $room->original_price,
                'capacity' => $room->capacity,
                'size' => $room->size,
                'bed' => $room->bed,
                'floor' => $room->floor,
                'view' => $room->view,
                'rating' => $room->rating,
                'reviewCount' => $room->review_count,
                'available' => (bool)$room->available,
                'images' => $room->images,
                'amenities' => $room->amenities ?? [],
                'description' => $room->description,
                'highlights' => $room->highlights ?? [],
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Get a single room detail.
     */
    public function room($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        return response()->json([
            'id' => $room->id,
            'name' => $room->name,
            'category' => $room->category,
            'price' => $room->price,
            'originalPrice' => $room->original_price,
            'capacity' => $room->capacity,
            'size' => $room->size,
            'bed' => $room->bed,
            'floor' => $room->floor,
            'view' => $room->view,
            'rating' => $room->rating,
            'reviewCount' => $room->review_count,
            'available' => (bool)$room->available,
            'images' => $room->images,
            'amenities' => $room->amenities ?? [],
            'description' => $room->description,
            'highlights' => $room->highlights ?? [],
        ]);
    }

    /**
     * Book a room.
     */
    public function book(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = $checkIn->diffInDays($checkOut);
        if ($nights <= 0) {
            $nights = 1;
        }

        $subtotal = $room->price * $nights;
        $gst = (int)round($subtotal * 0.18);
        $total = $subtotal + $gst;

        $booking = Booking::create([
            'room_id' => $validated['room_id'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'nights' => $nights,
            'subtotal' => $subtotal,
            'gst' => $gst,
            'total' => $total,
            'status' => 'Pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking placed successfully.',
            'booking_id' => 'LXS-' . (100000 + $booking->id),
            'id' => $booking->id
        ], 201);
    }

    /**
     * Get all foods.
     */
    public function foods()
    {
        $foods = Food::all();
        $formatted = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->name,
                'category' => $food->category,
                'type' => $food->type,
                'cuisine' => $food->cuisine,
                'price' => $food->price,
                'originalPrice' => $food->original_price,
                'rating' => $food->rating,
                'reviewCount' => $food->review_count,
                'prepTime' => $food->prep_time,
                'servings' => $food->servings,
                'calories' => $food->calories,
                'spiceLevel' => $food->spice_level,
                'isPopular' => (bool)$food->is_popular,
                'isBestSeller' => (bool)$food->is_bestseller,
                'images' => $food->images,
                'description' => $food->description,
                'ingredients' => $food->ingredients ?? [],
                'tags' => $food->tags ?? [],
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Get a single food detail.
     */
    public function food($id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['message' => 'Food item not found'], 404);
        }

        return response()->json([
            'id' => $food->id,
            'name' => $food->name,
            'category' => $food->category,
            'type' => $food->type,
            'cuisine' => $food->cuisine,
            'price' => $food->price,
            'originalPrice' => $food->original_price,
            'rating' => $food->rating,
            'reviewCount' => $food->review_count,
            'prepTime' => $food->prep_time,
            'servings' => $food->servings,
            'calories' => $food->calories,
            'spiceLevel' => $food->spice_level,
            'isPopular' => (bool)$food->is_popular,
            'isBestSeller' => (bool)$food->is_bestseller,
            'images' => $food->images,
            'description' => $food->description,
            'ingredients' => $food->ingredients ?? [],
            'tags' => $food->tags ?? [],
        ]);
    }

    /**
     * Place a food order.
     */
    public function order(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string',
            'customer_email' => 'nullable|email',
            'delivery_address' => 'required|string',
            'order_type' => 'required|string|in:dine-in,delivery',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:foods,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $subtotal = 0;
        $itemsToCreate = [];

        foreach ($validated['items'] as $item) {
            $food = Food::findOrFail($item['id']);
            $price = $food->price;
            $quantity = $item['qty'];
            $subtotal += $price * $quantity;

            $itemsToCreate[] = [
                'food_id' => $food->id,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        $tax = (int)round($subtotal * 0.05); // 5% GST
        $deliveryCharge = ($validated['order_type'] === 'delivery') ? 49 : 0;
        $total = $subtotal + $tax + $deliveryCharge;

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? '',
            'delivery_address' => $validated['delivery_address'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_charge' => $deliveryCharge,
            'total' => $total,
            'status' => 'Pending',
            'payment_status' => 'Pending',
        ]);

        foreach ($itemsToCreate as $itemData) {
            $order->items()->create($itemData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully.',
            'order_id' => 'RST-' . (100000 + $order->id),
            'id' => $order->id
        ], 201);
    }
}
