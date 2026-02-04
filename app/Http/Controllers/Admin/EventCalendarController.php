<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventCalendarController extends Controller
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

    public function edit(): View
    {
        return view('admin.events.calendar', [
            'calendarImageUrl' => $this->findCalendarImageUrl(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'calendar_image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $file = $request->file('calendar_image');
        $ext = strtolower($file->getClientOriginalExtension());

        $dir = public_path('front_end/images');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Remove previous versions
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $oldExt) {
            $old = $dir . DIRECTORY_SEPARATOR . 'weekly_calendar.' . $oldExt;
            if (file_exists($old)) {
                @unlink($old);
            }
        }

        $targetName = 'weekly_calendar.' . $ext;
        $file->move($dir, $targetName);

        return back()->with('success', 'Calendario semanal actualizado.');
    }
}
