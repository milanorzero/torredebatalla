const cartState = {};

function initCart(data) {
  Object.assign(cartState, data);
  Object.keys(cartState).forEach(togglePlusButton);
  renderTotal();
}

function togglePlusButton(id) {
  const item = cartState[id];
  const btn = document.getElementById(`btn-plus-${id}`);
  if (!btn) return;
  btn.disabled = item.qty >= item.stock;
}

function renderTotal() {
  let total = 0;
  Object.values(cartState).forEach(i => {
    total += i.qty * i.price;
  });

  const el = document.getElementById('cart-total');
  if (el) el.innerText = '$' + total.toLocaleString('es-CL');
}

function changeQty(id, diff) {
  const item = cartState[id];
  if (!item) return;

  const newQty = item.qty + diff;
  if (newQty < 1 || newQty > item.stock) return;

  // UI inmediata
  item.qty = newQty;
  document.getElementById(`qty-${id}`).innerText = newQty;
  togglePlusButton(id);
  renderTotal();

  fetch(`/cart/update/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': window.csrfToken,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ quantity: newQty })
  })
  .then(r => r.json())
  .then(res => {
    if (res.error) {
      item.qty -= diff;
      document.getElementById(`qty-${id}`).innerText = item.qty;
      togglePlusButton(id);
      renderTotal();
      alert(res.error);
    }
  });
}
