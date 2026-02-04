@extends('maindesign')

@section('title', 'Torre de Batalla')


@section('slider')
    <x-dynamic-slider />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('shop')
<div class="container">
    @if(($categories ?? collect())->count())
        <div class="heading_container heading_center mb-3">
            <h2>Categorías</h2>
            <p>Encuentra rápido lo que buscas</p>
        </div>

        <div class="row mb-5">
            @foreach($categories as $cat)
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('view_allproducts', ['category' => $cat->category]) }}" class="text-decoration-none">
                        <div class="p-3 border rounded h-100 d-flex align-items-center justify-content-between">
                            <span class="font-weight-bold text-dark">{{ $cat->category }}</span>
                            <i class="fa fa-angle-right text-muted"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div class="heading_container heading_center">
        <h2>Últimos productos</h2>
        <p>Novedades y reposiciones recientes</p>
    </div>

    <div class="row">
        @forelse($products as $product)
            @php
                $isNew = $product->created_at && $product->created_at->greaterThanOrEqualTo(now()->subDays(14));
            @endphp
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="box shadow-sm rounded p-2 h-100">
                    <a href="{{ route('product_details', ['id' => $product->id]) }}">
                        <div class="img-box text-center">
                            <img src="{{ $product->product_image ? asset('products/' . $product->product_image) : asset('front_end/images/logo.png') }}"
                                 alt="{{ $product->product_title }}"
                                 class="img-fluid"
                                 style="max-height: 200px; object-fit: contain;">
                        </div>

                        <div class="detail-box mt-3 text-center">
                            <h6 class="mb-1">{{ $product->product_title }}</h6>

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

                            @if(!is_null($product->product_quantity))
                                <div class="mt-2">
                                    @if((int) $product->product_quantity > 0)
                                        <small class="text-muted">Stock: {{ $product->product_quantity }}</small>
                                    @else
                                        <span class="badge badge-danger">Sin stock</span>
                                    @endif
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
            <p>No hay productos disponibles por el momento.</p>
        @endforelse
    </div>

    <div class="btn-box text-center mt-4">
        <a href="{{ route('view_allproducts') }}" class="btn btn-primary">Ver todos los productos</a>
    </div>

    @if(($offers ?? collect())->count())
        <div class="heading_container heading_center mt-5">
            <h2>Ofertas</h2>
            <p>Aprovecha descuentos por tiempo limitado</p>
        </div>

        <div class="row">
            @foreach($offers as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="box shadow-sm rounded p-2 h-100">
                        <a href="{{ route('product_details', ['id' => $product->id]) }}">
                            <div class="img-box text-center">
                                <img src="{{ $product->product_image ? asset('products/' . $product->product_image) : asset('front_end/images/logo.png') }}"
                                     alt="{{ $product->product_title }}"
                                     class="img-fluid"
                                     style="max-height: 200px; object-fit: contain;">
                            </div>
                            <div class="detail-box mt-3 text-center">
                                <h6 class="mb-1">{{ $product->product_title }}</h6>
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
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row text-center mt-5">
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-truck fa-2x mb-2"></i>
                <div class="font-weight-bold">Envíos</div>
                <small class="text-muted">A todo Chile</small>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-map-marker fa-2x mb-2"></i>
                <div class="font-weight-bold">Retiro</div>
                <small class="text-muted">Concepción</small>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-lock fa-2x mb-2"></i>
                <div class="font-weight-bold">Pago seguro</div>
                <small class="text-muted">Múltiples medios</small>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-comments fa-2x mb-2"></i>
                <div class="font-weight-bold">Soporte</div>
                <small class="text-muted">Te ayudamos</small>
            </div>
        </div>
    </div>
</div>
@endsection