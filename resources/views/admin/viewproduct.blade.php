@extends('admin.maindesign')

@section('page_title', 'Productos')

@section('content')

@if(session('deleteproduct_message'))
    <div class="alert alert-danger mb-3">
        {{ session('deleteproduct_message') }}
    </div>
@endif

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <strong>Listado de productos</strong>
        </div>

        <div class="card-body">
            <div class="mb-3 d-flex flex-wrap gap-2">
                <a class="btn btn-sm btn-secondary" href="{{ route('admin.viewproduct') }}">
                    Todos
                </a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.viewproduct', ['type' => 'products']) }}">
                    Solo productos
                </a>
                <a class="btn btn-sm btn-outline-success" href="{{ route('admin.viewproduct', ['type' => 'tournaments']) }}">
                    Solo torneos (cupos)
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        <th>Canal</th>
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_title }}</td>

                            <td>
                                @if($product->is_tournament)
                                    <span class="badge badge-success">Torneo</span>
                                @else
                                    <span class="badge badge-secondary">Producto</span>
                                @endif
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($product->product_description, 120) }}
                            </td>

                            <td>
                                @if($product->is_tournament)
                                    {{ $product->product_quantity }} cupos
                                @else
                                    {{ $product->product_quantity }}
                                @endif
                            </td>

                            <td>
                                ${{ number_format($product->final_price, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($product->sale_channel === 'web')
                                    <span class="badge badge-info">Web</span>
                                @elseif($product->sale_channel === 'store')
                                    <span class="badge badge-warning">Tienda física</span>
                                @else
                                    <span class="badge badge-success">Web + Tienda</span>
                                @endif
                            </td>

                            <td>
                                @if($product->product_image)
                                    <img src="{{ asset('products/' . $product->product_image) }}"
                                         style="max-width: 100px;">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>

                            <td>
                                {{ $product->product_category }}
                            </td>

                            <td>
                                <a href="{{ route('admin.updateproduct', $product->id) }}"
                                   class="btn btn-sm btn-warning mb-1">
                                    Editar
                                </a>

                                <a href="{{ route('admin.deleteproduct', $product->id) }}"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Confirma borrar producto?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>

</div>

@endsection
