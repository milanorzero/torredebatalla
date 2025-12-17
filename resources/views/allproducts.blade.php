@extends('maindesign')

@section('shop')
<div class="container">
    <div class="heading_container heading_center">
        <h2>Productos</h2>
    </div>

    {{-- Mostrar término de búsqueda si existe --}}
    @if(request('query'))
        <h5 class="text-center mb-4">Resultados para: "{{ request('query') }}"</h5>
    @endif

    <div class="row">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="box shadow-sm rounded p-2">
                    <a href="{{ route('product_details', ['id' => $product->id]) }}">
                        <div class="img-box text-center">
                            <img src="{{ asset('products/' . $product->product_image) }}" 
                                 alt="{{ $product->product_title }}" 
                                 class="img-fluid" 
                                 style="max-height: 200px; object-fit: contain;">
                        </div>
                        <div class="detail-box mt-3 text-center">
                            <h6>{{ $product->product_title }}</h6>
                            <h6>
                                Precio: 
                                <span class="text-success fw-bold">${{ number_format($product->product_price) }}</span>
                            </h6>
                        </div>
                        @if($product->is_new ?? true)
                        <div class="new"><span>Nuevo</span></div>
                        @endif
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center">No hay productos disponibles por el momento.</p>
        @endforelse
    </div>

    <div class="btn-box text-center mt-4">
        <a href="{{ route('index') }}" class="btn btn-primary">Página Principal</a>
    </div>
</div>
@endsection
