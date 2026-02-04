<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('admin.points.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'points'      => 'required|integer|not_in:0',
            'description' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($request->user_id);

        $points = (int) $request->points;
        $reason = (string) $request->description;

        try {
            DB::transaction(function () use ($user, $points, $reason): void {
                if ($points > 0) {
                    $user->addPoints($points, $reason, 'admin');
                    return;
                }

                $user->spendPoints(abs($points), $reason, 'admin');
            });
        } catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Puntos asignados correctamente.');
    }
}
