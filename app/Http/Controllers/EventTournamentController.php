<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventTournamentController extends Controller
{
    private function findCalendarImageUrl(): ?string
    {
        $base = public_path('front_end/images/weekly_calendar');
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];

        foreach ($extensions as $ext) {
            $path = $base . '.' . $ext;
            if (file_exists($path)) {
                return asset('front_end/images/weekly_calendar.' . $ext);
            }
        }

        return null;
    }

    public function __invoke(Request $request): View
    {
        $tournaments = Product::query()
            ->where('is_tournament', true)
            ->orderByDesc('created_at')
            ->get();

        $count = Auth::check()
            ? ProductCart::where('user_id', Auth::id())->count()
            : collect(session('cart', []))->count();

        return view('events', [
            'calendarImageUrl' => $this->findCalendarImageUrl(),
            'tournaments' => $tournaments,
            'count' => $count,
        ]);
    }
}
