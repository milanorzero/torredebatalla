@extends('admin.maindesign')

@section('page_title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Nuevos jugadores (7 días)</strong>
                <h3>{{ $playersNew7d }}</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Jugadores totales</strong>
                <h3>{{ $playersTotal }}</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Órdenes pendientes</strong>
                <h3>{{ $ordersPending }}</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Ventas hoy (pagadas)</strong>
                <h3>${{ number_format($revenueToday, 0, ',', '.') }}</h3>
                <small class="text-muted">{{ $ordersPaidToday }} órdenes</small>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="statistic-block block">
                <strong>Ventas 30 días</strong>
                <h3>${{ number_format($revenue30d, 0, ',', '.') }}</h3>
                <small class="text-muted">{{ $ordersPaid30d }} órdenes pagadas</small>
            </div>
        </div>

    </div>

</div>

@endsection
