@extends('maindesign')

@section('title', 'Torneos')

@section('shop')
<div class="container">
    <div class="heading_container heading_center">
        <h2>Torneos</h2>
        <p class="text-muted mb-0">Inscribite a nuestros torneos antes que se agoten.</p>
    </div>

    <div class="row mt-4">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                <div class="box shadow-sm rounded p-2 w-100 d-flex flex-column">
                    <a href="{{ route('product_details', ['id' => $product->id]) }}">
                        <div class="img-box text-center mb-2">
                            <img src="{{ asset('products/' . $product->product_image) }}"
                                 alt="{{ $product->product_title }}"
                                 class="img-fluid w-100"
                                 style="max-height: 200px; object-fit: contain;">
                        </div>

                        <div class="detail-box mt-3 text-center flex-grow-1 d-flex flex-column justify-content-between">
                            <h6 class="mb-1">{{ $product->product_title }}</h6>

                            <div class="text-success fw-bold">
                                ${{ number_format($product->final_price, 0, ',', '.') }}
                            </div>

                            <div class="mt-2">
                                @if(!is_null($product->product_quantity))
                                    @if((int) $product->product_quantity > 0)
                                        <span class="badge bg-success">Stock: {{ $product->product_quantity }}</span>
                                    @else
                                        <span class="badge bg-danger">Sin cupos</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Disponible</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center">No hay torneos disponibles por el momento.</p>
        @endforelse
    </div>
</div>
@endsection
