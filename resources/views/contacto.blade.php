@extends('maindesign')

@section('title', 'Contacto - Torre de Batalla')

@section('shop')
<div class="container mt-4">
    <h2 class="mb-4">Contacto</h2>

    <p>Escríbenos y con gusto te ayudamos.</p>

    <div class="row">
        <div class="col-12 col-md-7 mb-4 mb-md-0">
            <form method="POST" action="{{ route('contacto.send', [], false) }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="message">Mensaje</label>
                    <textarea
                        id="message"
                        name="message"
                        class="form-control"
                        rows="6"
                        required
                    >{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Enviar mensaje
                </button>
            </form>
        </div>

        <div class="col-md-5 mt-4 mt-md-0">
            <h5 class="mb-3">Redes</h5>
            <ul>
                <li>Email: <a href="mailto:{{ config('app.contact_to_email') }}">{{ config('app.contact_to_email') }}</a></li>
                <li>Instagram: <a href="https://www.instagram.com/torredebatalla/" target="_blank" rel="noopener noreferrer">@torredebatalla</a></li>
                <li>YouTube: <a href="https://www.youtube.com/@TorredeBatalla" target="_blank" rel="noopener noreferrer">@TorredeBatalla</a></li>
            </ul>
        </div>
    </div>

    <h3 class="mt-5 mb-3">Encuéntranos</h3>

    @if (config('app.contact_address'))
        <p><strong>Dirección:</strong> {{ config('app.contact_address') }}</p>
    @endif

    @php
        $mapQuery = rawurlencode(
            config('app.contact_map_query')
                ?: (config('app.contact_address') ?: 'Torre de Batalla')
        );
    @endphp

    <div class="embed-responsive embed-responsive-16by9">
        <iframe
            class="embed-responsive-item"
            src="https://www.google.com/maps?q={{ $mapQuery }}&output=embed"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            title="Mapa - Encuéntranos"
        ></iframe>
    </div>
</div>
@endsection
