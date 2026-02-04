@extends('maindesign')

@section('shop')
<div class="container">
    <div class="heading_container heading_center">
        <h2>Productos</h2>
    </div>

    @if(request('category'))
        <div class="text-center mb-3">
            <span class="badge badge-info">Categoría: {{ request('category') }}</span>
            <a href="{{ route('view_allproducts') }}" class="ml-2">Quitar filtro</a>
        </div>
    @endif

    {{-- Mostrar término de búsqueda si existe --}}
    @if(request('query'))
        <h5 class="text-center mb-4">Resultados para: "{{ request('query') }}"</h5>
    @endif

    <div class="row">
        @forelse($products as $product)
            @php
                $isNew = $product->created_at && $product->created_at->greaterThanOrEqualTo(now()->subDays(14));
            @endphp
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                <div class="box shadow-sm rounded p-2 w-100 d-flex flex-column">
                    <a href="{{ route('product_details', ['id' => $product->id]) }}">
                        <div class="img-box text-center mb-2">
                            <img src="{{ $product->product_image ? asset('products/' . $product->product_image) : asset('front_end/images/logo.png') }}" 
                                 alt="{{ $product->product_title }}" 
                                 class="img-fluid w-100" 
                                 style="max-height: 200px; object-fit: contain;">
                        </div>
                        <div class="detail-box mt-3 text-center flex-grow-1 d-flex flex-column justify-content-between">
                            <h6>{{ $product->product_title }}</h6>

                            @if($product->is_on_offer && $product->offer_price)
                                <div>
                                    <span class="text-muted" style="text-decoration: line-through;">
                                        ${{ number_format((int) $product->product_price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-success font-weight-bold" style="margin-left: 6px;">
                                        ${{ number_format((int) $product->final_price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-warning">Oferta</span>
                                </div>
                            @else
                                <div class="text-success font-weight-bold">
                                    ${{ number_format((int) $product->final_price, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>

                        @if($isNew)
                            <div class="new"><span>Nuevo</span></div>
                        @endif
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center">No hay productos disponibles por el momento.</p>
        @endforelse
    </div>

    @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

    <div class="btn-box text-center mt-4">
        <a href="{{ route('index') }}" class="btn btn-primary">Página Principal</a>
    </div>
</div>
@endsection
