<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PointHistoryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $transactions = $user
            ->pointTransactions()
            ->latest()
            ->paginate(20);

        return view('profile.points', [
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }
}
