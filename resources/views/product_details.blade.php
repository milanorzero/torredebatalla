@extends('maindesign')

@section('title', $product->product_title . ' - Torre de Batalla')

@section('shop')

@if(session('cart_message'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('cart_message') }}
    </div>
@endif

<!-- product details -->
<section class="shop_section layout_padding">
    <div class="container">
        <div class="row">
            <!-- Imagen del producto -->
            <div class="col-md-6">
                <div class="img-box text-center">
                    <img src="{{ asset('products/' . $product->product_image) }}" 
                         alt="{{ $product->product_title }}" 
                         class="img-fluid" 
                         style="max-height: 400px; object-fit: contain;">
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="col-md-6">
                <h2>{{ $product->product_title }}</h2>

                <p class="mt-3">
                    {{ $product->product_description }}
                </p>

                <h4 class="text-success mt-3">
                    ${{ number_format($product->product_price) }}
                </h4>

                <p class="mt-2">
                    <strong>Stock:</strong> {{ $product->product_quantity }}
                </p>

                @if($product->product_quantity > 0)
                    <form action="{{ route('add_to_cart', $product->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group" style="max-width: 120px;">
                            <label>Cantidad</label>
                            <input type="number" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->product_quantity }}" 
                                   class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">
                            Agregar al carrito
                        </button>
                    </form>
                @else
                    <span class="badge badge-danger">Sin stock</span>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- end product details -->

@endsection
