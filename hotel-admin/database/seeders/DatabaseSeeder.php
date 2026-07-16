<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Food;
use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@luxury.com'],
            [
                'name' => 'Admin Luxury',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Seed Rooms from rooms.js data
        $roomsData = [
            [
                'name' => 'Classic Standard Room',
                'category' => 'Standard',
                'price' => 4999,
                'original_price' => 6999,
                'capacity' => 2,
                'size' => '28 sqm',
                'bed' => '1 King Bed',
                'floor' => '2nd - 4th Floor',
                'view' => 'Garden View',
                'rating' => 4.3,
                'review_count' => 124,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "Flat Screen TV", "Mini Fridge", "Safe", "Hair Dryer", "Tea/Coffee"],
                'highlights' => ["Complimentary breakfast", "Daily housekeeping", "24/7 room service"],
                'description' => 'Our Classic Standard Room offers a comfortable and elegant retreat with modern amenities. Perfect for solo travelers or couples seeking a relaxing stay with all essential comforts.',
            ],
            [
                'name' => 'Deluxe Garden View',
                'category' => 'Deluxe',
                'price' => 7999,
                'original_price' => 10999,
                'capacity' => 2,
                'size' => '38 sqm',
                'bed' => '1 King Bed',
                'floor' => '3rd - 6th Floor',
                'view' => 'Garden View',
                'rating' => 4.6,
                'review_count' => 98,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "55\" Smart TV", "Mini Bar", "Bathtub", "Balcony", "Work Desk", "Safe"],
                'highlights' => ["Balcony with garden view", "Premium toiletries", "Welcome drink", "Turn-down service"],
                'description' => 'Experience luxury in our Deluxe Garden View Room, featuring a private balcony overlooking our lush gardens. The spacious layout includes a separate seating area and premium amenities.',
            ],
            [
                'name' => 'Deluxe Pool View',
                'category' => 'Deluxe',
                'price' => 8999,
                'original_price' => 12999,
                'capacity' => 2,
                'size' => '40 sqm',
                'bed' => '1 King Bed',
                'floor' => '2nd - 5th Floor',
                'view' => 'Pool View',
                'rating' => 4.7,
                'review_count' => 156,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "65\" Smart TV", "Mini Bar", "Jacuzzi", "Balcony", "Pool Access", "Safe"],
                'highlights' => ["Pool view balcony", "Jacuzzi", "Pool access", "Premium mini bar"],
                'description' => 'Wake up to stunning pool views from your private balcony. Our Deluxe Pool View Room features premium furnishings, a Jacuzzi, and direct access to the resort pool.',
            ],
            [
                'name' => 'Premium Suite',
                'category' => 'Suite',
                'price' => 14999,
                'original_price' => 19999,
                'capacity' => 4,
                'size' => '65 sqm',
                'bed' => '1 King Bed + Sofa Bed',
                'floor' => '7th - 9th Floor',
                'view' => 'City View',
                'rating' => 4.8,
                'review_count' => 87,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "75\" Smart TV", "Full Bar", "Jacuzzi", "Living Room", "Dining Area", "Kitchenette", "Butler Service"],
                'highlights' => ["Separate living room", "Butler service", "City panorama", "Complimentary airport transfer"],
                'description' => 'Our Premium Suite redefines luxury with a separate living room, dining area, and kitchenette. Perfect for families or extended stays, offering panoramic city views and butler service.',
            ],
            [
                'name' => 'Junior Suite',
                'category' => 'Suite',
                'price' => 11999,
                'original_price' => 15999,
                'capacity' => 3,
                'size' => '52 sqm',
                'bed' => '1 King Bed',
                'floor' => '6th - 8th Floor',
                'view' => 'Sea View',
                'rating' => 4.7,
                'review_count' => 63,
                'available' => true, // Made true so it can be booked in seed
                'image' => 'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "65\" Smart TV", "Mini Bar", "Rain Shower", "Seating Area", "Work Desk"],
                'highlights' => ["Sea view", "Rain shower", "Complimentary breakfast", "Evening cocktails"],
                'description' => 'The Junior Suite features breathtaking sea views and a generous seating area. The elegant decor and premium furnishings create an atmosphere of refined luxury.',
            ],
            [
                'name' => 'Presidential Suite',
                'category' => 'Presidential',
                'price' => 29999,
                'original_price' => 39999,
                'capacity' => 6,
                'size' => '120 sqm',
                'bed' => '2 King Beds',
                'floor' => 'Top Floor',
                'view' => 'Panoramic View',
                'rating' => 5.0,
                'review_count' => 34,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "85\" Smart TV", "Full Bar", "Private Pool", "2 Bedrooms", "Full Kitchen", "Private Terrace", "24/7 Butler", "Chauffeur"],
                'highlights' => ["Private rooftop pool", "24/7 personal butler", "Chauffeur service", "Private chef on request"],
                'description' => 'The crown jewel of our hotel, the Presidential Suite offers unparalleled luxury with a private rooftop pool, two master bedrooms, and 360-degree panoramic views. The ultimate indulgence.',
            ],
            [
                'name' => 'Family Room',
                'category' => 'Standard',
                'price' => 8499,
                'original_price' => 11499,
                'capacity' => 4,
                'size' => '45 sqm',
                'bed' => '2 Queen Beds',
                'floor' => '1st - 3rd Floor',
                'view' => 'Garden View',
                'rating' => 4.5,
                'review_count' => 142,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "2x Smart TV", "Mini Fridge", "Bathtub", "Kids Amenities", "Extra Pillows"],
                'highlights' => ["Kids welcome pack", "2 queen beds", "Garden view", "Family dining discounts"],
                'description' => "Designed for families, this spacious room features two queen beds, a relaxing garden view, and special kids' amenities. Everything your family needs for a comfortable stay.",
            ],
            [
                'name' => 'Honeymoon Suite',
                'category' => 'Suite',
                'price' => 18999,
                'original_price' => 24999,
                'capacity' => 2,
                'size' => '75 sqm',
                'bed' => '1 Super King Bed',
                'floor' => '8th - 10th Floor',
                'view' => 'Sea & City View',
                'rating' => 4.9,
                'review_count' => 47,
                'available' => true,
                'image' => 'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=800&q=80',
                'amenities' => ["Free WiFi", "Air Conditioning", "75\" Smart TV", "Champagne Bar", "Rose Petal Bath", "Private Terrace", "Couples Spa", "Candlelight Dinner"],
                'highlights' => ["Rose petal turndown", "Complimentary champagne", "Couples spa", "Candlelight dinner"],
                'description' => "Romance awaits in our Honeymoon Suite with a super king bed adorned with rose petals, a private terrace with sea views, and exclusive couples' spa access. Pure magic.",
            ]
        ];

        foreach ($roomsData as $rData) {
            Room::create($rData);
        }

        // 3. Seed Foods from foods.js data
        $foodsData = [
            [
                'name' => 'Paneer Butter Masala',
                'category' => 'Main Course',
                'type' => 'veg',
                'cuisine' => 'Indian',
                'price' => 349,
                'original_price' => 429,
                'rating' => 4.7,
                'review_count' => 234,
                'prep_time' => '20 mins',
                'servings' => 2,
                'calories' => 420,
                'spice_level' => 'Medium',
                'is_popular' => true,
                'is_bestseller' => true,
                'image' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80',
                'description' => 'Rich and creamy tomato-based curry with soft paneer cubes, cooked with aromatic spices and finished with butter and cream.',
                'ingredients' => ["Paneer", "Tomatoes", "Butter", "Cream", "Spices", "Onions", "Garlic", "Ginger"],
                'tags' => ["Creamy", "Rich", "Popular"],
            ],
            [
                'name' => 'Chicken Biryani',
                'category' => 'Main Course',
                'type' => 'non-veg',
                'cuisine' => 'Indian',
                'price' => 449,
                'original_price' => 549,
                'rating' => 4.8,
                'review_count' => 412,
                'prep_time' => '35 mins',
                'servings' => 2,
                'calories' => 680,
                'spice_level' => 'Medium-Hot',
                'is_popular' => true,
                'is_bestseller' => true,
                'image' => 'https://images.unsplash.com/photo-1563379091339-03246963d96c?w=800&q=80',
                'description' => 'Aromatic long-grain basmati rice layered with succulent chicken pieces marinated in yogurt and spices, slow-cooked to perfection.',
                'ingredients' => ["Basmati Rice", "Chicken", "Yogurt", "Saffron", "Whole Spices", "Caramelized Onions", "Mint", "Ghee"],
                'tags' => ["Aromatic", "Signature Dish", "Bestseller"],
            ],
            [
                'name' => 'Margherita Pizza',
                'category' => 'Pizza',
                'type' => 'veg',
                'cuisine' => 'Italian',
                'price' => 399,
                'original_price' => 479,
                'rating' => 4.5,
                'review_count' => 178,
                'prep_time' => '25 mins',
                'servings' => 2,
                'calories' => 580,
                'spice_level' => 'Mild',
                'is_popular' => false,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&q=80',
                'description' => 'Classic Italian pizza with San Marzano tomato sauce, fresh mozzarella, basil leaves, and a drizzle of extra-virgin olive oil on a crispy wood-fired crust.',
                'ingredients' => ["Pizza Dough", "San Marzano Tomatoes", "Fresh Mozzarella", "Fresh Basil", "Olive Oil", "Sea Salt"],
                'tags' => ["Classic", "Vegetarian", "Italian"],
            ],
            [
                'name' => 'Grilled Salmon Fillet',
                'category' => 'Seafood',
                'type' => 'non-veg',
                'cuisine' => 'Continental',
                'price' => 799,
                'original_price' => 999,
                'rating' => 4.8,
                'review_count' => 98,
                'prep_time' => '20 mins',
                'servings' => 1,
                'calories' => 390,
                'spice_level' => 'Mild',
                'is_popular' => true,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?w=800&q=80',
                'description' => 'Premium Atlantic salmon fillet grilled to perfection with lemon butter sauce, served with seasonal vegetables and roasted potatoes.',
                'ingredients' => ["Salmon Fillet", "Lemon Butter", "Herbs", "Seasonal Vegetables", "Roasted Potatoes", "Capers"],
                'tags' => ["Healthy", "Premium", "Continental"],
            ],
            [
                'name' => 'Dal Makhani',
                'category' => 'Main Course',
                'type' => 'veg',
                'cuisine' => 'Indian',
                'price' => 299,
                'original_price' => 369,
                'rating' => 4.6,
                'review_count' => 189,
                'prep_time' => '45 mins',
                'servings' => 2,
                'calories' => 380,
                'spice_level' => 'Mild',
                'is_popular' => false,
                'is_bestseller' => true,
                'image' => 'https://images.unsplash.com/photo-1546833998-877b37c2e5c6?w=800&q=80',
                'description' => 'Slow-cooked black lentils simmered overnight with butter and cream, creating a velvety, smoky dal that\'s the hallmark of Punjabi cuisine.',
                'ingredients' => ["Black Lentils", "Kidney Beans", "Butter", "Cream", "Tomatoes", "Spices", "Fenugreek"],
                'tags' => ["Slow-cooked", "Creamy", "Comforting"],
            ],
            [
                'name' => 'Tandoori Chicken',
                'category' => 'Appetizers',
                'type' => 'non-veg',
                'cuisine' => 'Indian',
                'price' => 499,
                'original_price' => 619,
                'rating' => 4.7,
                'review_count' => 267,
                'prep_time' => '30 mins',
                'servings' => 2,
                'calories' => 520,
                'spice_level' => 'Hot',
                'is_popular' => true,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=800&q=80',
                'description' => 'Chicken marinated in yogurt and aromatic spices, then cooked in a traditional clay tandoor oven for that authentic char and smoky flavor.',
                'ingredients' => ["Chicken", "Yogurt", "Tandoori Masala", "Lemon", "Ginger", "Garlic", "Red Chili"],
                'tags' => ["Smoky", "Tandoor-cooked", "Spicy"],
            ],
            [
                'name' => 'Veg Spring Rolls',
                'category' => 'Appetizers',
                'type' => 'veg',
                'cuisine' => 'Chinese',
                'price' => 249,
                'original_price' => 299,
                'rating' => 4.4,
                'review_count' => 143,
                'prep_time' => '15 mins',
                'servings' => 4,
                'calories' => 280,
                'spice_level' => 'Mild',
                'is_popular' => false,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=800&q=80',
                'description' => 'Crispy golden rolls stuffed with seasoned vegetables, glass noodles, and served with sweet chili dipping sauce.',
                'ingredients' => ["Spring Roll Wrappers", "Cabbage", "Carrots", "Glass Noodles", "Mushrooms", "Soy Sauce"],
                'tags' => ["Crispy", "Light", "Snack"],
            ],
            [
                'name' => 'Butter Naan',
                'category' => 'Breads',
                'type' => 'veg',
                'cuisine' => 'Indian',
                'price' => 89,
                'original_price' => 109,
                'rating' => 4.5,
                'review_count' => 312,
                'prep_time' => '10 mins',
                'servings' => 1,
                'calories' => 180,
                'spice_level' => 'None',
                'is_popular' => false,
                'is_bestseller' => true,
                'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=800&q=80',
                'description' => 'Soft leavened bread baked in a tandoor oven, brushed generously with butter and served hot. The perfect accompaniment to any curry.',
                'ingredients' => ["Refined Flour", "Yogurt", "Butter", "Yeast", "Salt"],
                'tags' => ["Soft", "Freshly baked", "Essential"],
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'category' => 'Desserts',
                'type' => 'veg',
                'cuisine' => 'Continental',
                'price' => 299,
                'original_price' => 379,
                'rating' => 4.9,
                'review_count' => 167,
                'prep_time' => '15 mins',
                'servings' => 1,
                'calories' => 450,
                'spice_level' => 'None',
                'is_popular' => true,
                'is_bestseller' => true,
                'image' => 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=800&q=80',
                'description' => 'Decadent warm chocolate cake with a gooey molten center, served with a scoop of premium vanilla ice cream and fresh berry coulis.',
                'ingredients' => ["Dark Chocolate", "Butter", "Eggs", "Sugar", "Flour", "Vanilla Ice Cream", "Mixed Berries"],
                'tags' => ["Indulgent", "Dessert", "Must Try"],
            ],
            [
                'name' => 'Mutton Rogan Josh',
                'category' => 'Main Course',
                'type' => 'non-veg',
                'cuisine' => 'Indian',
                'price' => 599,
                'original_price' => 749,
                'rating' => 4.7,
                'review_count' => 89,
                'prep_time' => '50 mins',
                'servings' => 2,
                'calories' => 620,
                'spice_level' => 'Hot',
                'is_popular' => false,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1567188040759-fb8a883dc6d8?w=800&q=80',
                'description' => 'Tender mutton slow-cooked in a bold Kashmiri-style gravy with whole spices, dried red chilies, and aromatic herbs. A legendary dish.',
                'ingredients' => ["Mutton", "Kashmiri Red Chili", "Whole Spices", "Yogurt", "Ginger", "Asafoetida", "Ghee"],
                'tags' => ["Rich", "Slow-cooked", "Kashmiri"],
            ],
            [
                'name' => 'Masala Chai',
                'category' => 'Beverages',
                'type' => 'veg',
                'cuisine' => 'Indian',
                'price' => 99,
                'original_price' => 129,
                'rating' => 4.6,
                'review_count' => 198,
                'prep_time' => '5 mins',
                'servings' => 1,
                'calories' => 90,
                'spice_level' => 'Mild',
                'is_popular' => false,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=800&q=80',
                'description' => 'Traditional Indian spiced tea brewed with premium Assam tea leaves, fresh ginger, cardamom, cinnamon, and full-cream milk.',
                'ingredients' => ["Assam Tea", "Milk", "Ginger", "Cardamom", "Cinnamon", "Cloves", "Sugar"],
                'tags' => ["Aromatic", "Warming", "Traditional"],
            ],
            [
                'name' => 'Prawn Masala',
                'category' => 'Seafood',
                'type' => 'non-veg',
                'cuisine' => 'Indian',
                'price' => 699,
                'original_price' => 899,
                'rating' => 4.6,
                'review_count' => 74,
                'prep_time' => '25 mins',
                'servings' => 2,
                'calories' => 460,
                'spice_level' => 'Hot',
                'is_popular' => false,
                'is_bestseller' => false,
                'image' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?w=800&q=80',
                'description' => 'Juicy tiger prawns cooked in a spicy coastal masala with coconut milk, curry leaves, and aromatic spices. A seafood lover\'s delight.',
                'ingredients' => ["Tiger Prawns", "Coconut Milk", "Tomatoes", "Curry Leaves", "Spices", "Onions", "Garlic"],
                'tags' => ["Spicy", "Coastal", "Premium"],
            ]
        ];

        foreach ($foodsData as $fData) {
            Food::create($fData);
        }

        // Fetch spawned references
        $rooms = Room::all();
        $foods = Food::all();

        // 4. Seed Historical Bookings (60+ bookings over the last 30 days)
        $names = ['Rahul Sharma', 'Amit Patel', 'Sneha Rao', 'John Doe', 'Jane Smith', 'Vikram Singh', 'Priya Nair', 'Nikhil Verma', 'Sanjay Dutt', 'Deepika K.', 'Arjun Rampal', 'Aishwarya R.', 'Ranbir Kapoor', 'Kareena K.', 'Virat Kohli', 'Anushka Sharma'];
        $statuses = ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Cancelled'];

        for ($i = 0; $i < 65; $i++) {
            $room = $rooms->random();
            $name = $names[array_rand($names)];
            
            // Random dates in past 30 days
            $checkIn = Carbon::now()->subDays(rand(1, 30));
            $nights = rand(1, 4);
            $checkOut = (clone $checkIn)->addDays($nights);

            $subtotal = $room->price * $nights;
            $gst = (int)round($subtotal * 0.18);
            $total = $subtotal + $gst;

            // Status distribution weight
            $randStatusVal = rand(1, 100);
            if ($randStatusVal <= 70) {
                $status = 'Checked Out';
            } elseif ($randStatusVal <= 85) {
                $status = 'Checked In';
            } elseif ($randStatusVal <= 92) {
                $status = 'Confirmed';
            } elseif ($randStatusVal <= 96) {
                $status = 'Pending';
            } else {
                $status = 'Cancelled';
            }

            // If check_in is in future/very recent, adjust status
            if ($checkIn->isFuture()) {
                $status = rand(1, 2) === 1 ? 'Confirmed' : 'Pending';
            }

            Booking::create([
                'room_id' => $room->id,
                'customer_name' => $name,
                'customer_email' => strtolower(str_replace(' ', '.', $name)) . '@demo.com',
                'customer_phone' => '+91 ' . rand(70000, 99999) . ' ' . rand(10000, 99999),
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'guests' => rand(1, min($room->capacity, 4)),
                'nights' => $nights,
                'subtotal' => $subtotal,
                'gst' => $gst,
                'total' => $total,
                'status' => $status,
                'special_requests' => rand(1, 5) === 1 ? 'Extra towels, high floor if available.' : null,
                'created_at' => $checkIn, // to align graph nicely
                'updated_at' => $checkIn,
            ]);
        }

        // 5. Seed Historical Orders (80+ food orders)
        $orderStatuses = ['Pending', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled'];
        $paymentStatuses = ['Pending', 'Paid', 'Failed'];

        for ($i = 0; $i < 85; $i++) {
            $name = $names[array_rand($names)];
            $deliveryType = rand(1, 2) == 1 ? 'Table ' . rand(1, 15) : 'Room ' . rand(101, 408);
            
            // Random date in past 30 days
            $orderDate = Carbon::now()->subDays(rand(0, 30))->subHours(rand(1, 12));

            // Select 1 to 4 random food items
            $orderFoods = $foods->random(rand(1, 3));
            
            $subtotal = 0;
            $itemsToCreate = [];

            foreach ($orderFoods as $food) {
                $qty = rand(1, 2);
                $subtotal += $food->price * $qty;
                $itemsToCreate[] = [
                    'food_id' => $food->id,
                    'quantity' => $qty,
                    'price' => $food->price
                ];
            }

            $tax = (int)round($subtotal * 0.05); // 5% F&B tax
            $deliveryCharge = rand(1, 4) === 1 ? 50 : 0; // sometimes delivery charge
            $total = $subtotal + $tax + $deliveryCharge;

            // Status weights
            $randVal = rand(1, 100);
            if ($randVal <= 80) {
                $status = 'Delivered';
                $payStatus = 'Paid';
            } elseif ($randVal <= 90) {
                $status = rand(1, 2) == 1 ? 'Preparing' : 'Out for Delivery';
                $payStatus = rand(1, 3) == 1 ? 'Pending' : 'Paid';
            } elseif ($randVal <= 95) {
                $status = 'Pending';
                $payStatus = 'Pending';
            } else {
                $status = 'Cancelled';
                $payStatus = 'Failed';
            }

            $order = Order::create([
                'customer_name' => $name,
                'customer_email' => strtolower(str_replace(' ', '.', $name)) . '@demo.com',
                'customer_phone' => '+91 ' . rand(70000, 99999) . ' ' . rand(10000, 99999),
                'delivery_address' => $deliveryType,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_charge' => $deliveryCharge,
                'total' => $total,
                'status' => $status,
                'payment_status' => $payStatus,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            foreach ($itemsToCreate as $itemData) {
                $itemData['order_id'] = $order->id;
                $itemData['created_at'] = $orderDate;
                $itemData['updated_at'] = $orderDate;
                OrderItem::create($itemData);
            }
        }
    }
}
