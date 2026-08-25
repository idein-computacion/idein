<?php
require_once __DIR__ . '/includes/header.php';

$slug = $_GET['slug'] ?? '';
$prod = getProductoBySlug($slug);

if (!$prod) {
    echo '<main class="idein-container"><div style="text-align:center; padding: 4rem;"><h2>Producto no encontrado</h2><a href="catalogo.php" class="idein-btn" style="width:auto; margin-top:1rem;">Volver al catálogo</a></div></main>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$specs = getSpecs($prod['id']);
$imagenesExtra = getImagenesProducto($prod['id']);
$todasLasImagenes = [imgSrc($prod['imagen'])];
foreach ($imagenesExtra as $img) {
    $todasLasImagenes[] = imgSrc($img);
}

$pageTitle = $prod['nombre'] . ' - ' . SITE_NAME;
?>
<main class="idein-container">
  <!-- Breadcrumbs -->
  <div style="margin-bottom: 1rem; color: var(--muted); font-size: 0.875rem;">
    <a href="<?= SITE_URL ?>/index.php" style="color: var(--accent);">Inicio</a> &raquo;
    <a href="<?= SITE_URL ?>/catalogo.php?cat=<?= e($prod['categoria_slug']) ?>" style="color: var(--accent);"><?= e($prod['categoria_nombre']) ?></a> &raquo;
    <?= e($prod['nombre']) ?>
  </div>

  <div class="idein-product-detail">
    <!-- Galería -->
    <div>
      <div style="border: 1px solid var(--line); border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
        <img src="<?= $todasLasImagenes[0] ?>" id="main-img" alt="<?= e($prod['nombre']) ?>" style="width:100%; aspect-ratio: 1; object-fit: contain;">
      </div>
      <?php if (count($todasLasImagenes) > 1): ?>
      <div style="display:flex; gap: 0.5rem; overflow-x: auto;">
        <?php foreach ($todasLasImagenes as $img): ?>
          <img src="<?= $img ?>" class="thumb-img" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid var(--line); border-radius: 4px; cursor: pointer;">
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

    <!-- Info del Producto -->
    <div>
      <h1 style="margin: 0 0 0.5rem; font-size: 2rem;"><?= e($prod['nombre']) ?></h1>
      <p style="color: var(--muted); margin-bottom: 1.5rem;">Marca: <strong><?= e($prod['marca'] ?? 'Genérico') ?></strong></p>
      
      <div style="font-size: 2.5rem; font-weight: 800; color: var(--accent); margin-bottom: 1.5rem;">
        <?php if ($prod['precio_oferta']): ?>
          <span style="font-size: 1.25rem; color: var(--muted); text-decoration: line-through; margin-right: 0.5rem;"><?= precio($prod['precio']) ?></span>
          <?= precio($prod['precio_oferta']) ?>
        <?php else: ?>
          <?= precio($prod['precio']) ?>
        <?php endif; ?>
      </div>

      <p style="margin-bottom: 2rem; color: var(--ink); line-height: 1.6;">
        <?= nl2br(e($prod['descripcion_corta'])) ?>
      </p>

      <div style="background: var(--soft); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <label for="qty-<?= $prod['id'] ?>" style="display:block; font-weight:600; margin-bottom: 0.5rem;">Cantidad:</label>
        <div style="display:flex; gap: 1rem; align-items:center;">
          <input type="number" id="qty-<?= $prod['id'] ?>" value="1" min="1" max="<?= max(1, $prod['stock']) ?>" style="width: 80px; padding: 0.75rem; border: 1px solid var(--line); border-radius: 6px; font-size: 1.1rem;">
          <button class="idein-btn js-add-cart" data-id="<?= $prod['id'] ?>" style="flex:1;">
            Agregar al Carrito
          </button>
        </div>
        <p style="margin: 0.5rem 0 0; font-size: 0.875rem; color: <?= $prod['stock'] > 0 ? 'var(--success)' : 'var(--danger)' ?>;">
          <?= $prod['stock'] > 0 ? "✓ Stock disponible ({$prod['stock']})" : "✗ Sin stock por el momento" ?>
        </p>
      </div>

      <!-- Specs Técnicas -->
      <?php if (!empty($specs)): ?>
      <h3 style="margin-bottom: 1rem;">Especificaciones Técnicas</h3>
      <table style="width: 100%; border-collapse: collapse;">
        <?php foreach ($specs as $spec): ?>
        <tr style="border-bottom: 1px solid var(--line);">
          <td style="padding: 0.75rem 0; font-weight: 600; width: 40%; color: var(--muted);"><?= e($spec['nombre']) ?></td>
          <td style="padding: 0.75rem 0;"><?= e($spec['valor']) ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php endif; ?>
    </div>
  </div>
  
  <?php if (!empty($prod['descripcion'])): ?>
  <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
    <h3>Descripción Detallada</h3>
    <div style="line-height: 1.6; color: var(--ink);">
      <?= nl2br(e($prod['descripcion'])) ?>
    </div>
  </div>
  <?php endif; ?>

</main>

<script>
document.querySelectorAll('.thumb-img').forEach(thumb => {
  thumb.addEventListener('click', (e) => {
    document.getElementById('main-img').src = e.target.src;
  });
});
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
