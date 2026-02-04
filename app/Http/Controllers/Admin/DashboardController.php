<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $startOfDay = $now->copy()->startOfDay();
        $startOfWeek = $now->copy()->subDays(7);
        $startOfMonth = $now->copy()->subDays(30);

        $playersTotal = User::query()->where('user_type', 'user')->count();
        $playersNew7d = User::query()
            ->where('user_type', 'user')
            ->where('created_at', '>=', $startOfWeek)
            ->count();

        $ordersPending = Order::query()->where('estado_pago', 'pendiente')->count();
        $ordersPaidToday = Order::query()
            ->where('estado_pago', 'pagado')
            ->where('created_at', '>=', $startOfDay)
            ->count();
        $revenueToday = (int) Order::query()
            ->where('estado_pago', 'pagado')
            ->where('created_at', '>=', $startOfDay)
            ->sum('total');

        $ordersPaid30d = Order::query()
            ->where('estado_pago', 'pagado')
            ->where('created_at', '>=', $startOfMonth)
            ->count();
        $revenue30d = (int) Order::query()
            ->where('estado_pago', 'pagado')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');

        return view('admin.dashboard', compact(
            'playersTotal',
            'playersNew7d',
            'ordersPending',
            'ordersPaidToday',
            'revenueToday',
            'ordersPaid30d',
            'revenue30d',
        ));
    }
}
