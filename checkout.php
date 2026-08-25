<?php
require_once __DIR__ . '/includes/header.php';
$items = carritoItems();
$total = carritoTotal();

if (empty($items)) {
    header('Location: ' . SITE_URL . '/carrito.php');
    exit;
}

$pageTitle = 'Finalizar Compra - ' . SITE_NAME;
?>
<main class="idein-container">
  <h1 style="margin-bottom: 2rem;">Finalizar Compra</h1>

  <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Formulario -->
    <div style="background: white; border-radius: 8px; padding: 2rem;">
      <h2 style="margin-top: 0; margin-bottom: 1.5rem; color: var(--accent);">Tus Datos</h2>
      <form action="<?= SITE_URL ?>/procesar-pedido.php" method="POST" id="checkout-form">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
          <div>
            <label style="display:block; font-weight: 600; margin-bottom: 0.5rem;">Nombre Completo *</label>
            <input type="text" name="nombre" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 6px;">
          </div>
          <div>
            <label style="display:block; font-weight: 600; margin-bottom: 0.5rem;">Teléfono / WhatsApp *</label>
            <input type="tel" name="telefono" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 6px;">
          </div>
        </div>

        <div style="margin-bottom: 1rem;">
          <label style="display:block; font-weight: 600; margin-bottom: 0.5rem;">Correo Electrónico *</label>
          <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 6px;">
        </div>

        <div style="margin-bottom: 1rem;">
          <label style="display:block; font-weight: 600; margin-bottom: 0.5rem;">Dirección de Entrega</label>
          <input type="text" name="direccion" placeholder="Calle, Número, Barrio..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 6px;">
        </div>

        <div style="margin-bottom: 2rem;">
          <label style="display:block; font-weight: 600; margin-bottom: 0.5rem;">Notas adicionales</label>
          <textarea name="notas" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 6px; resize: vertical;"></textarea>
        </div>
        
        <h3 style="margin-top: 0; margin-bottom: 1rem; color: var(--ink);">Método de Pago Preferido</h3>
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
          <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
            <input type="radio" name="pago" value="transferencia" checked> Transferencia / CBU
          </label>
          <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
            <input type="radio" name="pago" value="efectivo"> Efectivo al retirar/recibir
          </label>
        </div>

        <button type="submit" class="idein-btn" style="width: 100%; font-size: 1.1rem; padding: 1rem;">Confirmar Pedido</button>
      </form>
    </div>

    <!-- Resumen -->
    <div style="background: white; border-radius: 8px; padding: 1.5rem; align-self: start;">
      <h3 style="margin-top: 0; margin-bottom: 1rem; border-bottom: 1px solid var(--line); padding-bottom: 1rem;">Resumen de tu Pedido</h3>
      
      <div style="margin-bottom: 1.5rem;">
        <?php foreach ($items as $item): ?>
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.875rem;">
            <span><?= $item['cantidad'] ?>x <?= e($item['nombre']) ?></span>
            <span style="font-weight: 600;"><?= precio($item['precio'] * $item['cantidad']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>

      <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; border-top: 1px solid var(--line); padding-top: 1rem;">
        <span>Total a Pagar</span>
        <span style="color: var(--accent);"><?= precio($total) ?></span>
      </div>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
