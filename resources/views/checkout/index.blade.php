@extends('maindesign')

@section('title', 'Checkout')

@section('shop')
<div class="container">
    <h2 class="mb-4">Checkout</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los datos del formulario:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RESUMEN DEL CARRITO --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Resumen del carrito</strong></div>
        <div class="card-body">
            @foreach($cartItems as $item)
                <p>
                    {{ $item->product->product_title }}
                    — {{ $item->quantity }} x ${{ number_format($item->product->final_price) }}
                </p>
            @endforeach
            <hr>
            <h5>Total: ${{ number_format($subtotal) }}</h5>
        </div>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf

        {{-- =============================
             PASO 1: DATOS PERSONALES
        ============================= --}}
        <div class="card mb-4">
            <div class="card-header"><strong>1. Datos personales</strong></div>
            <div class="card-body">
                <input type="email" name="email" class="form-control mb-2" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                <input type="text" name="first_name" class="form-control mb-2" placeholder="Nombres" value="{{ old('first_name') }}" required>
                <input type="text" name="last_name" class="form-control mb-2" placeholder="Apellidos" value="{{ old('last_name') }}" required>
                <input type="text" name="phone" class="form-control mb-2" placeholder="Teléfono" value="{{ old('phone') }}" required>

                <select name="document_type" id="documentType" class="form-control mb-2" required>
                    <option value="">Tipo de identificación</option>
                      <option value="rut" @selected(old('document_type')==='rut')>RUT</option>
                      <option value="passport" @selected(old('document_type')==='passport')>Pasaporte</option>
                </select>

                <input type="text" name="rut" id="rutField" placeholder="RUT"
                      class="form-control mb-2" value="{{ old('rut') }}" style="{{ old('document_type')==='rut' ? '' : 'display:none;' }}">
                <input type="text" name="passport" id="passportField" placeholder="Pasaporte"
                      class="form-control mb-2" value="{{ old('passport') }}" style="{{ old('document_type')==='passport' ? '' : 'display:none;' }}">

                <button type="button" class="btn btn-primary mt-2" onclick="goStep2()">
                    Guardar y continuar
                </button>
            </div>
        </div>

        {{-- =============================
             PASO 2: ENVÍO / RETIRO
        ============================= --}}
        <div class="card mb-4" id="step2" style="{{ (old('delivery_type') || $errors->any()) ? '' : 'display:none;' }}">
            <div class="card-header"><strong>2. Envío o retiro</strong></div>
            <div class="card-body">
                <select name="delivery_type" id="deliveryType"
                        class="form-control mb-3" required>
                    <option value="">Seleccione opción</option>
                    <option value="shipping" @selected(old('delivery_type')==='shipping')>Despacho</option>
                    <option value="pickup" @selected(old('delivery_type')==='pickup')>Retiro en local</option>
                </select>

                {{-- Campos despacho --}}
                  <div id="shippingFields" style="{{ old('delivery_type')==='shipping' ? '' : 'display:none;' }}">
                      <input type="text" name="commune" placeholder="Comuna"
                          class="form-control mb-2" value="{{ old('commune') }}">
                      <input type="text" name="street" placeholder="Calle"
                          class="form-control mb-2" value="{{ old('street') }}">
                      <input type="text" name="number" placeholder="Número"
                          class="form-control mb-2" value="{{ old('number') }}">
                    <input type="text" name="extra"
                           placeholder="Dpto / Oficina (opcional)"
                          class="form-control mb-2" value="{{ old('extra') }}">
                    <input type="text" name="postal_code"
                           placeholder="Código postal (opcional)"
                          class="form-control mb-2" value="{{ old('postal_code') }}">
                </div>

                {{-- Campos retiro --}}
                <div id="pickupFields" style="{{ old('delivery_type')==='pickup' ? '' : 'display:none;' }}">
                    <label>
                        <input type="radio" name="pickup_location"
                               value="Freire 1053, Concepción">
                        Freire 1053, Concepción
                    </label>
                </div>

                <button type="button" class="btn btn-primary mt-2"
                        onclick="goStep3()">
                    Continuar a pago
                </button>
            </div>
        </div>

        {{-- =============================
             PASO 3: MÉTODO DE PAGO
        ============================= --}}
        <div class="card mb-4" id="step3" style="{{ (old('payment_method') || $errors->any()) ? '' : 'display:none;' }}">
            <div class="card-header"><strong>3. Método de pago</strong></div>
            <div class="card-body">

                {{-- 🔹 USAR PUNTOS (NUEVO, NO ROMPE NADA) --}}
                @if(auth()->check() && auth()->user()->points_balance > 0)
                    <div class="alert alert-info">
                        <strong>Puntos disponibles:</strong>
                        {{ auth()->user()->points_balance }} pts
                        <br>
                        <small>1 punto = $1 de descuento</small>

                        <input type="number"
                               name="points_used"
                               class="form-control mt-2"
                               min="0"
                               max="{{ auth()->user()->points_balance }}"
                               value="{{ old('points_used') }}"
                               placeholder="¿Cuántos puntos deseas usar?">
                    </div>
                @endif

                {{-- MÉTODO DE PAGO --}}
                @php
                    $hasMercadoPago = filled(config('mercadopago.access_token'));
                @endphp
                <select name="payment_method"
                        class="form-control mb-3" required>
                    <option value="">Seleccione método</option>
                    <option value="transfer" @selected(old('payment_method')==='transfer')>Transferencia bancaria</option>
                    @if($hasMercadoPago)
                        <option value="mercadopago" @selected(old('payment_method')==='mercadopago')>Mercado Pago</option>
                    @endif
                </select>

                <button type="submit"
                        class="btn btn-success btn-lg w-100">
                    Confirmar y pagar
                </button>
            </div>
        </div>

    </form>
</div>

{{-- ================= JS (NO SE TOCA) ================= --}}
<script>
const rutField = document.getElementById('rutField');
const passportField = document.getElementById('passportField');
const shippingFields = document.getElementById('shippingFields');
const pickupFields = document.getElementById('pickupFields');

document.getElementById('documentType').addEventListener('change', function() {
    rutField.style.display = this.value==='rut'?'block':'none';
    passportField.style.display = this.value==='passport'?'block':'none';
});

document.getElementById('deliveryType').addEventListener('change', function() {
    shippingFields.style.display = this.value==='shipping'?'block':'none';
    pickupFields.style.display = this.value==='pickup'?'block':'none';
});

function goStep2() {
    const required = ['email','first_name','last_name','phone','document_type']
        .map(name => document.getElementsByName(name)[0]);

    for (let f of required) {
        if (!f.value) {
            alert('Completa todos los datos personales');
            return;
        }
    }

    if (document.getElementById('documentType').value==='rut' && !rutField.value) {
        alert('Completa el RUT'); return;
    }
    if (document.getElementById('documentType').value==='passport' && !passportField.value) {
        alert('Completa el pasaporte'); return;
    }

    document.getElementById('step2').style.display='block';
    document.getElementById('step2').scrollIntoView({behavior:'smooth'});
}

function goStep3() {
    const delivery = document.getElementById('deliveryType').value;
    if (!delivery) {
        alert('Selecciona despacho o retiro'); return;
    }

    if (delivery==='shipping') {
        const required = ['commune','street','number'];
        for (let name of required) {
            if (!document.getElementsByName(name)[0].value) {
                alert('Completa los campos de despacho');
                return;
            }
        }
    } else if (delivery==='pickup') {
        if (!document.querySelector('input[name="pickup_location"]:checked')) {
            alert('Selecciona un local de retiro');
            return;
        }
    }

    document.getElementById('step3').style.display='block';
    document.getElementById('step3').scrollIntoView({behavior:'smooth'});
}
</script>
@endsection
