<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderItem;

class SliderItemController extends Controller
{
    public function index()
    {
        $items = SliderItem::orderBy('order')->get();
        return view('admin.slider.index', compact('items'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {

        try {

            // Forzar el valor de 'active' a booleano antes de validar
            $request->merge([
                'active' => $request->has('active') ? true : false
            ]);

            $request->validate([
                'image' => 'required|image|max:4096',
                'text' => 'nullable|string|max:255',
                'order' => 'nullable|integer',
                'active' => 'boolean',
            ]);

            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            // Guardar en public_html/front_end/images/slider
            $slidesPath = base_path('../public_html/front_end/images/slider');
            if (!file_exists($slidesPath)) {
                mkdir($slidesPath, 0775, true);
            }
            $image->move($slidesPath, $imageName);

            SliderItem::create([
                'image' => 'front_end/images/slider/'.$imageName,
                'text' => $request->text,
                'order' => $request->order ?? 0,
                'active' => $request->boolean('active'),
            ]);

            return redirect()->route('admin.slider.index')->with('success', 'Slide agregado');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: '.$e->getMessage())->withInput();
        }
    }

    public function edit(SliderItem $slider)
    {
        return view('admin.slider.edit', ['slider' => $slider]);
    }

    public function update(Request $request, SliderItem $slider)
    {
        $request->validate([
            'image' => 'nullable|image|max:4096',
            'text' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        $data = [
            'text' => $request->text,
            'order' => $request->order ?? 0,
            'active' => $request->has('active'),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $slidesPath = base_path('../public_html/front_end/images/slider');
            if (!file_exists($slidesPath)) {
                mkdir($slidesPath, 0775, true);
            }
            $image->move($slidesPath, $imageName);
            $data['image'] = 'front_end/images/slider/'.$imageName;
        }

        $slider->update($data);

        return redirect()->route('admin.slider.index')->with('success', 'Slide actualizado');
    }

    public function destroy(SliderItem $sliderItem)
    {
        \Log::info('Intentando eliminar slide', ['id' => $sliderItem->id, 'image' => $sliderItem->image]);
        // Eliminar imagen física si existe
        if ($sliderItem->image) {
            $imagePath = base_path('../public_html/' . $sliderItem->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
                \Log::info('Imagen eliminada', ['path' => $imagePath]);
            } else {
                \Log::warning('Imagen no encontrada', ['path' => $imagePath]);
            }
        }
        $deleted = $sliderItem->delete();
        \Log::info('Resultado delete', ['deleted' => $deleted]);
        return redirect()->route('admin.slider.index')->with('success', 'Slide eliminado');
    }
}
