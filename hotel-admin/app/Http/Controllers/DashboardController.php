<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Food;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // 1. KPI Stats
        $totalBookingsRevenue = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out'])->sum('total');
        $totalOrdersRevenue = Order::where('payment_status', 'Paid')->sum('total');
        $totalRevenue = $totalBookingsRevenue + $totalOrdersRevenue;

        $totalBookings = Booking::count();
        $activeBookings = Booking::whereIn('status', ['Confirmed', 'Checked In'])->count();
        
        $totalRooms = Room::count();
        $occupiedRooms = Booking::whereIn('status', ['Confirmed', 'Checked In'])
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>=', $today)
            ->distinct('room_id')
            ->count('room_id');
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $totalOrders = Order::count();
        $averageOrderValue = Order::count() > 0 ? round(Order::sum('total') / Order::count()) : 0;

        // 2. Recent lists
        $recentBookings = Booking::with('room')->latest()->limit(5)->get();
        $recentOrders = Order::latest()->limit(5)->get();

        // 3. Charts Logic - Last 7 Days Revenue (combined bookings + orders)
        $chartLabels = [];
        $bookingRevenueData = [];
        $orderRevenueData = [];
        $totalRevenueData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('M d');
            
            $bRev = Booking::whereDate('created_at', $date->toDateString())
                ->whereIn('status', ['Confirmed', 'Checked In', 'Checked Out'])
                ->sum('total');
            $oRev = Order::whereDate('created_at', $date->toDateString())
                ->where('payment_status', 'Paid')
                ->sum('total');

            $bookingRevenueData[] = (int)$bRev;
            $orderRevenueData[] = (int)$oRev;
            $totalRevenueData[] = (int)($bRev + $oRev);
        }

        // 4. Booking by Room Categories Distribution
        $categoriesData = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->select('rooms.category', DB::raw('count(bookings.id) as count'))
            ->groupBy('rooms.category')
            ->get();

        $categoryLabels = [];
        $categoryCounts = [];
        foreach ($categoriesData as $data) {
            $categoryLabels[] = $data->category;
            $categoryCounts[] = $data->count;
        }

        // Default categories if empty
        if (empty($categoryLabels)) {
            $categoryLabels = ['Standard', 'Deluxe', 'Suite', 'Presidential'];
            $categoryCounts = [0, 0, 0, 0];
        }

        // 5. Food Orders by Cuisine
        $cuisineData = DB::table('order_items')
            ->join('foods', 'order_items.food_id', '=', 'foods.id')
            ->select('foods.cuisine', DB::raw('sum(order_items.quantity) as count'))
            ->groupBy('foods.cuisine')
            ->get();

        $cuisineLabels = [];
        $cuisineCounts = [];
        foreach ($cuisineData as $data) {
            $cuisineLabels[] = $data->cuisine;
            $cuisineCounts[] = (int)$data->count;
        }

        // Default cuisines if empty
        if (empty($cuisineLabels)) {
            $cuisineLabels = ['Indian', 'Italian', 'Chinese', 'Continental'];
            $cuisineCounts = [0, 0, 0, 0];
        }

        // 6. Quick Status Summary
        $roomStatusSummary = [
            'total' => $totalRooms,
            'available' => Room::where('available', true)->count(),
            'occupied' => $occupiedRooms,
            'maintenance' => Room::where('available', false)->count() - $occupiedRooms,
        ];
        if ($roomStatusSummary['maintenance'] < 0) {
            $roomStatusSummary['maintenance'] = 0;
        }

        return view('dashboard', compact(
            'totalRevenue', 'totalBookings', 'activeBookings', 'occupancyRate', 'totalOrders', 'averageOrderValue',
            'recentBookings', 'recentOrders',
            'chartLabels', 'bookingRevenueData', 'orderRevenueData', 'totalRevenueData',
            'categoryLabels', 'categoryCounts',
            'cuisineLabels', 'cuisineCounts',
            'roomStatusSummary'
        ));
    }
}
