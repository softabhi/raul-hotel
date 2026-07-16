<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Room;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display report summaries and handle CSV export.
     */
    public function index(Request $request)
    {
        // Date range filter
        $startDateStr = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDateStr = $request->input('end_date', Carbon::now()->toDateString());
        
        $startDate = Carbon::parse($startDateStr)->startOfDay();
        $endDate = Carbon::parse($endDateStr)->endOfDay();

        // Handle CSV Exports
        if ($request->filled('export')) {
            $type = $request->export;
            if ($type === 'bookings') {
                return $this->exportBookings($startDate, $endDate);
            } elseif ($type === 'orders') {
                return $this->exportOrders($startDate, $endDate);
            } elseif ($type === 'financial') {
                return $this->exportFinancial($startDate, $endDate);
            }
        }

        // Room Bookings Analytics
        $bookingsQuery = Booking::whereBetween('created_at', [$startDate, $endDate]);
        $totalBookings = (clone $bookingsQuery)->count();
        $bookingRevenue = (clone $bookingsQuery)->whereIn('status', ['Confirmed', 'Checked In', 'Checked Out'])->sum('total');
        $cancelledBookings = (clone $bookingsQuery)->where('status', 'Cancelled')->count();
        
        // Food Orders Analytics
        $ordersQuery = Order::whereBetween('created_at', [$startDate, $endDate]);
        $totalOrders = (clone $ordersQuery)->count();
        $ordersRevenue = (clone $ordersQuery)->where('payment_status', 'Paid')->sum('total');
        $cancelledOrders = (clone $ordersQuery)->where('status', 'Cancelled')->count();

        // Financial Totals
        $totalRevenue = $bookingRevenue + $ordersRevenue;
        $totalTax = (clone $bookingsQuery)->whereIn('status', ['Confirmed', 'Checked In', 'Checked Out'])->sum('gst') + 
                    (clone $ordersQuery)->where('payment_status', 'Paid')->sum('tax');

        // Popular Rooms (by Booking Count)
        $popularRooms = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->select('rooms.name', 'rooms.category', DB::raw('count(bookings.id) as booking_count'), DB::raw('sum(bookings.total) as total_revenue'))
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('rooms.id', 'rooms.name', 'rooms.category')
            ->orderBy('booking_count', 'desc')
            ->limit(5)
            ->get();

        // Popular Food Items (by Quantity Sold)
        $popularFoods = DB::table('order_items')
            ->join('foods', 'order_items.food_id', '=', 'foods.id')
            ->select('foods.name', 'foods.cuisine', DB::raw('sum(order_items.quantity) as items_sold'), DB::raw('sum(order_items.quantity * order_items.price) as total_revenue'))
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->groupBy('foods.id', 'foods.name', 'foods.cuisine')
            ->orderBy('items_sold', 'desc')
            ->limit(5)
            ->get();

        return view('reports.index', compact(
            'startDateStr', 'endDateStr',
            'totalBookings', 'bookingRevenue', 'cancelledBookings',
            'totalOrders', 'ordersRevenue', 'cancelledOrders',
            'totalRevenue', 'totalTax',
            'popularRooms', 'popularFoods'
        ));
    }

    /**
     * Export Bookings report to CSV.
     */
    private function exportBookings($startDate, $endDate)
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=bookings_report_" . $startDate->format('Ymd') . "_to_" . $endDate->format('Ymd') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $bookings = Booking::with('room')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $callback = function() use($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Booking ID', 'Customer Name', 'Customer Email', 'Customer Phone', 'Room Name', 'Category', 'Check In', 'Check Out', 'Nights', 'Guests', 'Subtotal (INR)', 'GST 18% (INR)', 'Total (INR)', 'Status', 'Created At']);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->customer_name,
                    $booking->customer_email,
                    $booking->customer_phone,
                    $booking->room->name ?? 'N/A',
                    $booking->room->category ?? 'N/A',
                    $booking->check_in->format('Y-m-d'),
                    $booking->check_out->format('Y-m-d'),
                    $booking->nights,
                    $booking->guests,
                    $booking->subtotal,
                    $booking->gst,
                    $booking->total,
                    $booking->status,
                    $booking->created_at->toDateTimeString(),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Food Orders report to CSV.
     */
    private function exportOrders($startDate, $endDate)
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=food_orders_report_" . $startDate->format('Ymd') . "_to_" . $endDate->format('Ymd') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Order ID', 'Customer Name', 'Customer Email', 'Customer Phone', 'Delivery/Table', 'Subtotal (INR)', 'Tax (INR)', 'Delivery Charge (INR)', 'Total (INR)', 'Status', 'Payment Status', 'Created At']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->delivery_address,
                    $order->subtotal,
                    $order->tax,
                    $order->delivery_charge,
                    $order->total,
                    $order->status,
                    $order->payment_status,
                    $order->created_at->toDateTimeString(),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Financial report to CSV.
     */
    private function exportFinancial($startDate, $endDate)
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=financial_summary_" . $startDate->format('Ymd') . "_to_" . $endDate->format('Ymd') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Gather daily aggregates of bookings & orders
        $dailyBookings = DB::table('bookings')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'), DB::raw('SUM(gst) as tax'), DB::raw('COUNT(id) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['Confirmed', 'Checked In', 'Checked Out'])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');

        $dailyOrders = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'), DB::raw('SUM(tax) as tax'), DB::raw('COUNT(id) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'Paid')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');

        // Merge dates
        $allDates = collect(array_merge($dailyBookings->keys()->toArray(), $dailyOrders->keys()->toArray()))
            ->unique()
            ->sort();

        $callback = function() use($allDates, $dailyBookings, $dailyOrders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Bookings Count', 'Bookings Revenue (INR)', 'Bookings Tax (INR)', 'Orders Count', 'Orders Revenue (INR)', 'Orders Tax (INR)', 'Total Revenue (INR)', 'Total Tax (INR)']);

            foreach ($allDates as $date) {
                $bCount = $dailyBookings[$date]->count ?? 0;
                $bRev = $dailyBookings[$date]->revenue ?? 0;
                $bTax = $dailyBookings[$date]->tax ?? 0;
                
                $oCount = $dailyOrders[$date]->count ?? 0;
                $oRev = $dailyOrders[$date]->revenue ?? 0;
                $oTax = $dailyOrders[$date]->tax ?? 0;

                fputcsv($file, [
                    $date,
                    $bCount,
                    $bRev,
                    $bTax,
                    $oCount,
                    $oRev,
                    $oTax,
                    $bRev + $oRev,
                    $bTax + $oTax
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
