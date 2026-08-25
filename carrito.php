<?php
require_once __DIR__ . '/includes/header.php';
$items = carritoItems();
$total = carritoTotal();
$pageTitle = 'Tu Carrito - ' . SITE_NAME;
?>
<main class="idein-container">
  <h1 style="margin-bottom: 2rem;">Tu Carrito de Compras</h1>

  <?php if (empty($items)): ?>
    <div style="text-align: center; background: white; padding: 4rem; border-radius: 8px;">
      <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
      <h2 style="margin-bottom: 1rem;">Tu carrito está vacío</h2>
      <p style="color: var(--muted); margin-bottom: 2rem;">¡Agregá productos para verlos acá!</p>
      <a href="<?= SITE_URL ?>/catalogo.php" class="idein-btn" style="width: auto;">Volver a la tienda</a>
    </div>
  <?php else: ?>
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
      <div style="background: white; border-radius: 8px; padding: 1.5rem;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="border-bottom: 2px solid var(--line); text-align: left;">
              <th style="padding-bottom: 1rem;">Producto</th>
              <th style="padding-bottom: 1rem; width: 100px;">Precio</th>
              <th style="padding-bottom: 1rem; width: 120px;">Cantidad</th>
              <th style="padding-bottom: 1rem; width: 100px; text-align: right;">Subtotal</th>
              <th style="padding-bottom: 1rem; width: 40px;"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $key => $item): 
              $idProd = $item['producto_id'];
              $subtotal = $item['precio'] * $item['cantidad'];
            ?>
            <tr style="border-bottom: 1px solid var(--line);" id="row-<?= $idProd ?>">
              <td style="padding: 1rem 0;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                  <img src="<?= imgSrc($item['imagen']) ?>" alt="<?= e($item['nombre']) ?>" style="width: 60px; height: 60px; object-fit: contain; border: 1px solid var(--line); border-radius: 4px;">
                  <a href="<?= SITE_URL ?>/producto.php?id=<?= $idProd ?>" style="font-weight: 600; color: var(--accent);"><?= e($item['nombre']) ?></a>
                </div>
              </td>
              <td style="padding: 1rem 0;"><?= precio($item['precio']) ?></td>
              <td style="padding: 1rem 0;">
                <input type="number" class="qty-update" data-id="<?= $idProd ?>" value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['stock'] ?>" style="width: 60px; padding: 0.5rem; border: 1px solid var(--line); border-radius: 4px;">
              </td>
              <td style="padding: 1rem 0; text-align: right; font-weight: 600;" class="subtotal-td"><?= precio($subtotal) ?></td>
              <td style="padding: 1rem 0; text-align: right;">
                <button class="remove-btn" data-id="<?= $idProd ?>" style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 0.5rem;">✖</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div style="background: white; border-radius: 8px; padding: 1.5rem; align-self: start;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; border-bottom: 1px solid var(--line); padding-bottom: 1rem;">Resumen de compra</h3>
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
          <span style="color: var(--muted);">Subtotal</span>
          <span id="cart-total-sub"><?= precio($total) ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem; border-top: 1px solid var(--line); padding-top: 1rem;">
          <span>Total</span>
          <span id="cart-total" style="color: var(--accent);"><?= precio($total) ?></span>
        </div>
        
        <a href="<?= SITE_URL ?>/checkout.php" class="idein-btn" style="margin-bottom: 1rem; background: var(--success); text-align:center;">Iniciar Checkout</a>
        <a href="https://wa.me/<?= WHATSAPP_NUM ?>?text=<?= urlencode(carritoWAMessage()) ?>" target="_blank" rel="noopener" class="idein-btn" style="background: #25D366; text-align:center;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.5rem;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.121 1.533 5.851L.057 23.5l5.77-1.514A11.95 11.95 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.893 0-3.668-.523-5.183-1.43l-.371-.22-3.842 1.007 1.027-3.74-.241-.386A9.944 9.944 0 0 1 2 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10z"/></svg>
          Pedir por WhatsApp
        </a>
      </div>
    </div>
  <?php endif; ?>
</main>

<script>
document.querySelectorAll('.remove-btn').forEach(btn => {
  btn.addEventListener('click', async () => {
    const id = btn.dataset.id;
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('id', id);
    
    await fetch('api/carrito.php', { method: 'POST', body: formData });
    location.reload();
  });
});

document.querySelectorAll('.qty-update').forEach(input => {
  input.addEventListener('change', async () => {
    const id = input.dataset.id;
    const qty = input.value;
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('id', id);
    formData.append('cantidad', qty);
    
    await fetch('api/carrito.php', { method: 'POST', body: formData });
    location.reload();
  });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
