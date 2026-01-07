@extends('admin.maindesign')

@section('page_title', 'Dashboard')

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="statistic-block block">
            <strong>Nuevos jugadores</strong>
            <h3>27</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="statistic-block block">
            <strong>Nuevos clientes</strong>
            <h3>375</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="statistic-block block">
            <strong>Jugadores totales</strong>
            <h3>140</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="statistic-block block">
            <strong>Historial torneos</strong>
            <h3>41</h3>
        </div>
    </div>

</div>

@endsection
