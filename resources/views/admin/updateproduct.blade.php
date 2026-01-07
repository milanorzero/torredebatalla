@extends('admin.maindesign')

@section('page_title', 'Actualizar producto')

@section('content')

@if(session('product_updated_message'))
    <div class="alert alert-success mb-3">
        {{ session('product_updated_message') }}
    </div>
@endif

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <strong>Actualizar producto</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.postupdateproduct', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- NOMBRE --}}
                <div class="form-group mb-3">
                    <label>Nombre del producto</label>
                    <input type="text"
                           name="product_title"
                           value="{{ $product->product_title }}"
                           class="form-control"
                           required>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="form-group mb-3">
                    <label>Descripción</label>
                    <textarea name="product_description"
                              class="form-control"
                              rows="4"
                              required>{{ $product->product_description }}</textarea>
                </div>

                {{-- CANTIDAD --}}
                <div class="form-group mb-3">
                    <label>Cantidad</label>
                    <input type="number"
                           name="product_quantity"
                           value="{{ $product->product_quantity }}"
                           class="form-control"
                           min="0"
                           required>
                </div>

                {{-- PRECIO --}}
                <div class="form-group mb-3">
                    <label>Precio</label>
                    <input type="number"
                           name="product_price"
                           value="{{ $product->product_price }}"
                           class="form-control"
                           min="0"
                           required>
                </div>

                {{-- CANAL DE VENTA --}}
                <div class="form-group mb-3">
                    <label>Dónde se vende</label>
                    <select name="sale_channel"
                            class="form-control"
                            required>
                        <option value="both"
                            {{ $product->sale_channel === 'both' ? 'selected' : '' }}>
                            Web y tienda física
                        </option>

                        <option value="web"
                            {{ $product->sale_channel === 'web' ? 'selected' : '' }}>
                            Solo tienda web
                        </option>

                        <option value="store"
                            {{ $product->sale_channel === 'store' ? 'selected' : '' }}>
                            Solo tienda física
                        </option>
                    </select>
                </div>

                {{-- IMAGEN --}}
                <div class="form-group mb-3">
                    <label>Imagen actual</label><br>

                    @if($product->product_image)
                        <img src="{{ asset('products/' . $product->product_image) }}"
                             style="max-width: 120px;"
                             class="mb-2 d-block">
                    @else
                        <span class="text-muted d-block mb-2">Sin imagen</span>
                    @endif

                    <input type="file"
                           name="product_image"
                           class="form-control">
                </div>

                {{-- CATEGORÍA --}}
                <div class="form-group mb-4">
                    <label>Categoría</label>
                    <select name="product_category"
                            class="form-control"
                            required>
                        <option value="{{ $product->product_category }}" selected>
                            {{ $product->product_category }}
                        </option>

                        @foreach($categories as $category)
                            @if($category->category !== $product->product_category)
                                <option value="{{ $category->category }}">
                                    {{ $category->category }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- BOTONES --}}
                <button type="submit" class="btn btn-primary">
                    Actualizar producto
                </button>

                <a href="{{ route('admin.viewproduct') }}"
                   class="btn btn-secondary ms-2">
                    Volver
                </a>

            </form>
        </div>
    </div>

</div>

@endsection
