@extends('maindesign')

@section('title', 'Mi Carrito - Torre de Batalla')

@section('shop')

<h2 class="mb-4 text-center">Mi Carrito</h2>

@if($cart->isEmpty())
    <p class="text-center">No hay productos en el carrito.</p>
@else
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $cartJs = [];
                @endphp

                @foreach ($cart as $item)
                    @php
                        $subtotal = $item->quantity * $item->product->product_price;
                        $total += $subtotal;

                        $cartJs[$item->id] = [
                            'qty'   => $item->quantity,
                            'price' => $item->product->product_price,
                            'stock' => $item->product->product_quantity,
                        ];
                    @endphp

                    <tr id="row-{{ $item->id }}">
                        <td>{{ $item->product->product_title }}</td>
                        <td>${{ number_format($item->product->product_price, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateCart({{ $item->id }}, 'decrease')">−</button>
                            <span id="qty-{{ $item->id }}" class="mx-2 font-weight-bold">{{ $item->quantity }}</span>
                            <button class="btn btn-sm btn-outline-secondary"
                                    id="btn-plus-{{ $item->id }}"
                                    onclick="updateCart({{ $item->id }}, 'increase')"
                                    @if($item->quantity >= $item->product->product_quantity) disabled @endif>+</button>
                        </td>
                        <td>
                            <img src="{{ asset('products/' . $item->product->product_image) }}" 
                                 alt="{{ $item->product->product_title }}" 
                                 style="width: 120px;">
                        </td>
                        <td>
                            <a href="{{ route('removecartproduct', $item->id) }}" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4" class="text-right font-weight-bold">Total:</td>
                    <td id="cart-total" class="font-weight-bold">${{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

{{-- Datos para JS --}}
<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.cartData = @json($cartJs);

    function formatPrice(value) {
        return '$' + Number(value).toLocaleString('es-CL');
    }

    function updateCart(id, action) {
        fetch(`/cart/${action}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.error) { alert(data.error); return; }
            if(data.removed) { document.getElementById(`row-${id}`)?.remove(); return; }

            document.getElementById(`qty-${id}`).innerText = data.quantity;
            document.getElementById('cart-total').innerText = formatPrice(data.total);

            cartData[id].qty = data.quantity;

            const btnPlus = document.getElementById(`btn-plus-${id}`);
            if(btnPlus) btnPlus.disabled = cartData[id].qty >= cartData[id].stock;
        })
        .catch(() => alert('Error al actualizar el carrito'));
    }
</script>

@endsection
