@extends('admin.maindesign')

@section('page_title', 'Editar torneo')

@section('content')
<div class="container-fluid">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card w-100">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.events.tournaments.update', $tournament) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nombre del torneo</label>
                    <input type="text" name="product_title" value="{{ old('product_title', $tournament->product_title) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Descripción (opcional)</label>
                    <textarea name="product_description" rows="4" class="form-control">{{ old('product_description', $tournament->product_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Cupos (stock)</label>
                    <input type="number" name="product_quantity" value="{{ old('product_quantity', $tournament->product_quantity ?? 0) }}" class="form-control" min="0" required>
                </div>

                <div class="form-group">
                    <label>Precio</label>
                    <input type="number" name="product_price" value="{{ old('product_price', $tournament->product_price ?? 0) }}" class="form-control" min="0" required>
                </div>

                <div class="form-group">
                    <label>Categoría (opcional)</label>
                    <select name="product_category" class="form-control">
                        <option value="">-- Seleccionar --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->category }}" @selected(old('product_category', $tournament->product_category) === $c->category)>
                                {{ $c->category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Canal de venta</label>
                    <select name="sale_channel" class="form-control" required>
                        <option value="web" @selected(old('sale_channel', $tournament->sale_channel) === 'web')>Web</option>
                        <option value="store" @selected(old('sale_channel', $tournament->sale_channel) === 'store')>Tienda</option>
                        <option value="both" @selected(old('sale_channel', $tournament->sale_channel) === 'both')>Ambos</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Imagen (opcional)</label>

                    @if($tournament->product_image)
                        <div class="mb-2">
                            <img src="{{ asset('products/' . $tournament->product_image) }}" alt="Imagen" style="max-width: 260px;" class="img-thumbnail">
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                            <label class="form-check-label" for="remove_image">Quitar imagen</label>
                        </div>
                    @endif

                    <input type="file" name="product_image" class="form-control">
                </div>

                <div class="d-flex">
                    <button class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.events.tournaments.index') }}" class="btn btn-link">Volver</a>

                    @if(!is_null($tournament->product_quantity) && (int) $tournament->product_quantity > 0)
                        <form action="{{ route('admin.events.tournaments.unpublish', $tournament) }}" method="POST" class="ms-auto me-2"
                              onsubmit="return confirm('¿Despublicar este torneo? Dejará los cupos en 0.');">
                            @csrf
                            <button type="submit" class="btn btn-warning">Despublicar</button>
                        </form>
                    @endif

                    <form action="{{ route('admin.events.tournaments.destroy', $tournament) }}" method="POST" class="ms-auto"
                          onsubmit="return confirm('¿Eliminar este torneo? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
