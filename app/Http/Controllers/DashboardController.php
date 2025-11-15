<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $totalOrders = Orders::count();
        $completedOrders = Orders::where('status', 'Selesai')->count();
        $pendingOrders = Orders::whereNot('status', 'Pembayaran')->count();
        $newCustomers = User::whereDate('created_at', '>=', now()->subMonth())->where('role_id', 3)->count();

        // Ambil 5 pesanan terbaru
        $recentOrders = Orders::with(['user', 'service'])
            ->orderByDesc('updated_at')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'newCustomers',
            'recentOrders'
        ));
    }
}
