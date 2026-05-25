<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class RevenueController extends Controller
{
    public function index()
    {
        // ===== MẶC ĐỊNH THEO NGÀY =====
        $data = Order::selectRaw("DATE(created_at) as date, SUM(total_price) as total")
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        $labels = $data->pluck('date');
        $revenues = $data->pluck('total');

        return view('revenue.index', [
            'labels' => $labels,
            'revenues' => $revenues,
            'totalRevenue' => Order::sum('total_price'),
            'todayRevenue' => Order::whereDate('created_at', now())->sum('total_price'),
            'totalOrders' => Order::count(),
            'topProducts' => \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_qty')
                ->groupBy('product_id')
                ->orderByDesc('total_qty')
                ->take(5)
                ->with('product')
                ->get()
        ]);
    }

    public function data(Request $request)
    {
        $type = $request->type ?? 'day';

        if ($type == 'week') {

            $data = Order::selectRaw("YEARWEEK(created_at, 1) as week, SUM(total_price) as total")
                ->groupBy('week')
                ->orderBy('week', 'ASC')
                ->take(7)
                ->get();

            $labels = $data->pluck('week')->map(function ($week) {
                return "Tuần " . $week;
            });

            $revenues = $data->pluck('total');

        } else {

            $data = Order::selectRaw("DATE(created_at) as date, SUM(total_price) as total")
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->take(7)
                ->get();

            $labels = $data->pluck('date');
            $revenues = $data->pluck('total');
        }

        return response()->json([
            'labels' => $labels,
            'revenues' => $revenues,
            'totalRevenue' => Order::sum('total_price'),
            'todayRevenue' => Order::whereDate('created_at', now())->sum('total_price'),
            'totalOrders' => Order::count()
        ]);
    }
}