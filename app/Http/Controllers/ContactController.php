<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contacto');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Mail::to(config('app.contact_to_email'))
            ->send(new ContactMessageMail(
                name: $validated['name'],
                email: $validated['email'],
                message: $validated['message'],
            ));

        return back()->with('success', 'Mensaje enviado correctamente. ¡Gracias por contactarnos!');
    }
}
