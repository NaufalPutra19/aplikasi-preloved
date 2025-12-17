<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\item;
use App\Models\order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = item::count();
        $totalOrders = order::count();
        $totalUsers = User::where('role', 'customer')->count();
        $pendingOrders = order::where('status', 'pending')->count();
        
        $recentOrders = order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $lowStockItems = item::where('stock', '<=', DB::raw('stock_min'))
            ->where('stock', '>', 0)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders', 
            'totalUsers',
            'pendingOrders',
            'recentOrders',
            'lowStockItems'
        ));
    }
}