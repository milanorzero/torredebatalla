@extends('maindesign')

@section('title', 'Eventos y torneos - Torre de Batalla')

@section('shop')
<div class="container my-5">

    <div class="text-center mb-4">
        <h2 class="mb-1">Calendario semanal</h2>
        <p class="text-muted mb-0">Eventos y actividades de la semana.</p>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body text-center">
            @if($calendarImageUrl)
                <img src="{{ $calendarImageUrl }}"
                     alt="Calendario semanal"
                     class="img-fluid rounded shadow-sm"
                     style="max-width: 100%; height: auto;">
            @else
                <div class="text-muted">Aún no hay calendario cargado.</div>
            @endif
        </div>
    </div>

    <div id="torneos" class="text-center mb-4">
        <h2 class="mb-1">Proximos eventos</h2>
        <p class="text-muted mb-0">Inscribite a nuestros torneos antes que se agoten.</p>
    </div>

    <div class="row">
        @forelse($tournaments as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                <div class="box shadow-sm rounded p-2 h-100 w-100 d-flex flex-column">
                    <a href="{{ route('product_details', ['id' => $product->id]) }}">
                        <div class="img-box text-center mb-2">
                            <img src="{{ asset('products/' . $product->product_image) }}"
                                 alt="{{ $product->product_title }}"
                                 class="img-fluid w-100"
                                 style="max-height: 200px; object-fit: contain;">
                        </div>

                        <div class="detail-box mt-3 text-center">
                            <h6 class="mb-1">{{ $product->product_title }}</h6>
                            <div class="text-success fw-bold">
                                ${{ number_format($product->final_price, 0, ',', '.') }}
                            </div>

                            <div class="mt-2">
                                @if(!is_null($product->product_quantity))
                                    @if((int) $product->product_quantity > 0)
                                        <span class="badge bg-success">Cupos: {{ $product->product_quantity }}</span>
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
