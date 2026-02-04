<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function editSlider()
    {
        $slider = SiteSetting::get('slider_image', null);
        return view('admin.edit_slider', compact('slider'));
    }

    public function updateSlider(Request $request)
    {
        $request->validate([
            'slider_image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('slider_image')) {
            $image = $request->file('slider_image');
            $imagename = 'slider_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('front_end/images'), $imagename);
            SiteSetting::set('slider_image', $imagename);
        }

        return redirect()->back()->with('success', 'Imagen del slider actualizada');
    }
}
