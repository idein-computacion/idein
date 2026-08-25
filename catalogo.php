<?php
require_once __DIR__ . '/includes/header.php';

$catSlug = $_GET['cat'] ?? '';
$categoria = $catSlug ? getCategoriaBySlug($catSlug) : null;
$pagina = max(1, (int)($_GET['pag'] ?? 1));
$porPagina = 12;

$catId = $categoria ? $categoria['id'] : null;
$productos = getAllProductos($pagina, $porPagina, $catId);
$total = countAllProductos($catId);

$pageTitle = $categoria ? $categoria['nombre'] . ' - ' . SITE_NAME : 'Catálogo de Productos - ' . SITE_NAME;
?>
<main class="idein-container">
  <div style="margin-bottom: 2rem;">
    <h1 style="margin: 0 0 0.5rem 0;"><?= $categoria ? e($categoria['nombre']) : 'Todos los Productos' ?></h1>
    <?php if ($categoria && $categoria['descripcion']): ?>
      <p style="color: var(--muted);"><?= e($categoria['descripcion']) ?></p>
    <?php endif; ?>
  </div>

  <?php if (empty($productos)): ?>
    <div style="padding: 3rem; text-align: center; background: white; border-radius: 8px;">
      <p style="color: var(--muted); font-size: 1.1rem;">No hay productos en esta categoría por el momento.</p>
      <a href="<?= SITE_URL ?>/catalogo.php" class="idein-btn" style="width: auto; margin-top: 1rem;">Ver todo el catálogo</a>
    </div>
  <?php else: ?>
    <div class="idein-grid">
      <?php foreach ($productos as $prod): ?>
      <article class="idein-prod-card">
        <a href="<?= SITE_URL ?>/producto.php?slug=<?= e($prod['slug']) ?>">
          <img src="<?= imgSrc($prod['imagen']) ?>" alt="<?= e($prod['nombre']) ?>" class="idein-prod-img">
        </a>
        <div class="idein-prod-body">
          <div class="idein-prod-cat"><?= e($prod['categoria_nombre']) ?></div>
          <h3 class="idein-prod-title">
            <a href="<?= SITE_URL ?>/producto.php?slug=<?= e($prod['slug']) ?>"><?= e($prod['nombre']) ?></a>
          </h3>
          <div class="idein-prod-price">
            <?php if ($prod['precio_oferta']): ?>
              <span class="idein-prod-price-old"><?= precio($prod['precio']) ?></span>
              <?= precio($prod['precio_oferta']) ?>
            <?php else: ?>
              <?= precio($prod['precio']) ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="idein-prod-actions">
          <button class="idein-btn js-add-cart" data-id="<?= $prod['id'] ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            Agregar
          </button>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    
    <div style="margin-top: 3rem; text-align: center;">
      <?= paginacion($total, $porPagina, $pagina, SITE_URL . '/catalogo.php' . ($catSlug ? '?cat=' . urlencode($catSlug) : '')) ?>
    </div>
  <?php endif; ?>
</main>

<style>
.idein-paginacion { display: flex; justify-content: center; gap: 0.5rem; }
.idein-pag-btn { padding: 0.5rem 1rem; border: 1px solid var(--line); border-radius: 6px; background: white; color: var(--ink); }
.idein-pag-btn:hover { background: var(--soft); }
.idein-pag-btn.is-active { background: var(--accent); color: white; border-color: var(--accent); }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
