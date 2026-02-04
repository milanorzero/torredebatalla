@extends('admin.maindesign')

@section('page_title', 'Publicar torneo')

@section('content')
<div class="container-fluid">

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

            <form method="POST" action="{{ route('admin.events.tournaments.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Nombre del torneo</label>
                    <input type="text" name="product_title" value="{{ old('product_title') }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Descripción (opcional)</label>
                    <textarea name="product_description" rows="4" class="form-control">{{ old('product_description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Cupos (stock)</label>
                    <input type="number" name="product_quantity" value="{{ old('product_quantity', 0) }}" class="form-control" min="0" required>
                    <small class="text-muted">Se descuenta automáticamente al crear orden pendiente.</small>
                </div>

                <div class="form-group">
                    <label>Precio</label>
                    <input type="number" name="product_price" value="{{ old('product_price', 0) }}" class="form-control" min="0" required>
                </div>

                <div class="form-group">
                    <label>Categoría (opcional)</label>
                    <select name="product_category" class="form-control">
                        <option value="">-- Seleccionar --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->category }}" @selected(old('product_category') === $c->category)>
                                {{ $c->category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Canal de venta</label>
                    <select name="sale_channel" class="form-control" required>
                        <option value="web" @selected(old('sale_channel', 'web') === 'web')>Web</option>
                        <option value="store" @selected(old('sale_channel') === 'store')>Tienda</option>
                        <option value="both" @selected(old('sale_channel') === 'both')>Ambos</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Imagen (opcional)</label>
                    <input type="file" name="product_image" class="form-control">
                </div>

                <div class="d-flex">
                    <button class="btn btn-primary">Publicar</button>
                    <a href="{{ route('admin.events.tournaments.index') }}" class="btn btn-link">Cancelar</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
