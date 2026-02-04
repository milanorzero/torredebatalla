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
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex align-items-center justify-content-center">
                <div class="img-box text-center w-100">
                    <img src="{{ asset('products/' . $product->product_image) }}" 
                         alt="{{ $product->product_title }}" 
                         class="img-fluid w-100" 
                         style="max-height: 400px; object-fit: contain;">
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <h2>{{ $product->product_title }}</h2>

                <p class="mt-3">
                    {{ $product->product_description }}
                </p>

                @if($product->is_on_offer && $product->offer_price)
                    <div class="mt-3">
                        <span class="text-muted" style="text-decoration: line-through; font-size: 18px;">
                            ${{ number_format((int) $product->product_price, 0, ',', '.') }}
                        </span>
                        <span class="text-success font-weight-bold" style="font-size: 24px; margin-left: 8px;">
                            ${{ number_format((int) $product->final_price, 0, ',', '.') }}
                        </span>
                        <span class="badge badge-warning" style="margin-left: 8px;">Oferta</span>
                    </div>
                @else
                    <h4 class="text-success mt-3">
                        ${{ number_format((int) $product->final_price, 0, ',', '.') }}
                    </h4>
                @endif

                <p class="mt-2">
                    <strong>Stock:</strong>
                    @if(is_null($product->product_quantity))
                        Disponible
                    @else
                        {{ $product->product_quantity }}
                    @endif
                </p>

                @if(is_null($product->product_quantity) || (int) $product->product_quantity > 0)
                    <form action="{{ route('add_to_cart', $product->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group" style="max-width: 120px;">
                            <label>Cantidad</label>
                            <input type="number" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   @if(!is_null($product->product_quantity)) max="{{ $product->product_quantity }}" @endif
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
