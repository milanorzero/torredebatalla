<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PointTransaction;
use Illuminate\Http\Request;

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

        // Evitar saldo negativo
        if ($request->points < 0 && abs($request->points) > $user->points_balance) {
            return back()->withErrors('El usuario no tiene suficientes puntos.');
        }

        // Actualizar saldo
        $user->points_balance += $request->points;
        $user->save();

        // Registrar transacción
        PointTransaction::create([
            'user_id'     => $user->id,
            'amount'      => $request->points,
            'type'        => $request->points > 0 ? 'earn' : 'spend',
            'channel'     => 'admin',
            'description' => $request->description,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Puntos asignados correctamente.');
    }
}
