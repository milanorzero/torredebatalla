@extends('maindesign')

@section('title', 'Redirigiendo a Webpay')

@section('shop')
<div class="container py-5">
    <h3>Redirigiendo a Webpay…</h3>

    <p>En unos segundos serás redirigido para completar tu pago.</p>

    <form id="webpay-form" method="POST" action="{{ $url }}">
        <input type="hidden" name="token_ws" value="{{ $token }}">
        <noscript>
            <button type="submit" class="btn btn-primary">Continuar</button>
        </noscript>
    </form>
</div>

<script>
    document.getElementById('webpay-form').submit();
</script>
@endsection
