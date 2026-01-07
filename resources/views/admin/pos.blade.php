@extends('admin.maindesign')

@section('page_title', 'Venta en tienda')

@section('content')
<div class="container-fluid">

    <form method="POST" action="{{ route('admin.pos.store') }}" id="posForm">
        @csrf

        {{-- CLIENTE --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Cliente</h5>

                <select name="user_id" id="userSelect"
                        class="form-control" required>
                    <option value="">Seleccione cliente</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                                data-points="{{ $user->points_balance }}">
                            {{ $user->name }} — {{ $user->points_balance }} pts
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- PRODUCTOS --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Productos</h5>

                @foreach($products as $product)
                    <div class="row align-items-center mb-2 product-row"
                         data-price="{{ $product->final_price }}">
                        <div class="col-md-6">
                            {{ $product->product_title }}
                        </div>
                        <div class="col-md-3">
                            ${{ number_format($product->final_price) }}
                        </div>
                        <div class="col-md-3">
                            <input type="number"
                                   name="products[{{ $product->id }}]"
                                   class="form-control qty-input"
                                   min="0"
                                   value="0">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- PUNTOS --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-2">Usar puntos</h5>

                <p>
                    Puntos disponibles:
                    <strong id="pointsAvailable">0</strong>
                </p>

                <input type="number"
                       name="points_used"
                       id="pointsUsed"
                       class="form-control"
                       min="0"
                       value="0">

                <small class="text-muted">
                    1 punto = $1 de descuento
                </small>
            </div>
        </div>

        {{-- RESUMEN --}}
        <div class="card mb-4 border-primary">
            <div class="card-body">
                <h5 class="mb-3">Resumen</h5>

                <p>Subtotal: $<span id="subtotal">0</span></p>
                <p class="text-danger">
                    Descuento por puntos: −$<span id="pointsDiscount">0</span>
                </p>
                <hr>
                <h4>
                    Total a pagar: $
                    <span id="total">0</span>
                </h4>
            </div>
        </div>

        <button class="btn btn-success btn-lg">
            Registrar venta
        </button>
    </form>

</div>

{{-- ================= JS UX ================= --}}
<script>
const products = document.querySelectorAll('.product-row');
const qtyInputs = document.querySelectorAll('.qty-input');
const subtotalEl = document.getElementById('subtotal');
const totalEl = document.getElementById('total');
const pointsInput = document.getElementById('pointsUsed');
const pointsAvailableEl = document.getElementById('pointsAvailable');
const pointsDiscountEl = document.getElementById('pointsDiscount');
const userSelect = document.getElementById('userSelect');

function calculateTotals() {
    let subtotal = 0;

    products.forEach(row => {
        const price = parseInt(row.dataset.price);
        const qty = row.querySelector('.qty-input').value;
        subtotal += price * qty;
    });

    let pointsUsed = parseInt(pointsInput.value || 0);
    const maxPoints = parseInt(pointsAvailableEl.innerText);

    if (pointsUsed > maxPoints) {
        pointsUsed = maxPoints;
        pointsInput.value = maxPoints;
    }

    if (pointsUsed > subtotal) {
        pointsUsed = subtotal;
        pointsInput.value = subtotal;
    }

    subtotalEl.innerText = subtotal;
    pointsDiscountEl.innerText = pointsUsed;
    totalEl.innerText = subtotal - pointsUsed;
}

qtyInputs.forEach(input =>
    input.addEventListener('input', calculateTotals)
);

pointsInput.addEventListener('input', calculateTotals);

userSelect.addEventListener('change', function () {
    const points = this.options[this.selectedIndex]
        .getAttribute('data-points') || 0;

    pointsAvailableEl.innerText = points;
    pointsInput.value = 0;
    calculateTotals();
});
</script>
@endsection
