@extends('admin.maindesign')
@section('page_title', 'Slider')
@section('content')
<div class="container">
    <h2 class="mb-4">Slides del Slider</h2>
    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary mb-3">Agregar Slide</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <h5>Slides Activos</h5>
        <div class="d-flex flex-wrap gap-3">
            @foreach($items->where('active', true) as $item)
                <div class="border rounded p-2 text-center" style="min-width:180px;max-width:220px;">
                    <img src="{{ asset('front_end/images/' . $item->image) }}" style="max-width:100%;max-height:80px;object-fit:cover;border-radius:6px;">
                    <div class="mt-2 small text-muted">{{ $item->text }}</div>
                </div>
            @endforeach
            @if($items->where('active', true)->count() == 0)
                <span class="text-muted">No hay slides activos.</span>
            @endif
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Texto</th>
                <th>Orden</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td><img src="{{ asset('front_end/images/' . $item->image) }}" style="max-width:120px;"></td>
                    <td>{{ $item->text }}</td>
                    <td>{{ $item->order }}</td>
                    <td>{{ $item->active ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.slider.edit', $item) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.slider.destroy', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar slide?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
