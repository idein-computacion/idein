<?php
require_once __DIR__ . '/includes/header.php';
$destacados = getDestacados(8);
?>
<main>
  <!-- Hero Section -->
  <section style="background: var(--primary); color: white; padding: 4rem 2rem; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
      <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">IDeIn Computación</h1>
      <p style="font-size: 1.25rem; color: #cbd5e1; margin-bottom: 2rem;">Venta de insumos, accesorios y servicio técnico especializado.</p>
      <a href="<?= SITE_URL ?>/catalogo.php" class="idein-btn" style="display: inline-block; width: auto; padding: 1rem 2rem; font-size: 1.1rem;">Ver Catálogo Completo</a>
    </div>
  </section>

  <!-- Categorías destacadas -->
  <section class="idein-container">
    <h2 style="text-align: center; margin-bottom: 2rem;">Nuestras Categorías</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
      <?php foreach (array_slice($categorias, 0, 6) as $cat): ?>
      <a href="<?= SITE_URL ?>/catalogo.php?cat=<?= e($cat['slug']) ?>" style="background: white; padding: 2rem 1rem; text-align: center; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: transform 0.2s;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;"><?= e($cat['icono']) ?></div>
        <div style="font-weight: 600;"><?= e($cat['nombre']) ?></div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Productos Destacados -->
  <section class="idein-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
      <h2 style="margin: 0;">Productos Destacados</h2>
      <a href="<?= SITE_URL ?>/catalogo.php" style="color: var(--accent); font-weight: 600;">Ver todos &rarr;</a>
    </div>
    
    <div class="idein-grid">
      <?php foreach ($destacados as $prod): ?>
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
  </section>

  <!-- Servicios -->
  <section style="background: white; padding: 4rem 2rem; margin-top: 2rem;">
    <div class="idein-container" style="padding: 0;">
      <h2 style="text-align: center; margin-bottom: 3rem;">Servicio Técnico Especializado</h2>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <div style="text-align: center;">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🖨️</div>
          <h3 style="font-size: 1.25rem;">Reparación de Impresoras</h3>
          <p style="color: var(--muted);">Mantenimiento preventivo, destape de cabezales, sistemas continuos y repuestos multimarca.</p>
        </div>
        <div style="text-align: center;">
          <div style="font-size: 3rem; margin-bottom: 1rem;">💻</div>
          <h3 style="font-size: 1.25rem;">Mantenimiento de PC y Notebooks</h3>
          <p style="color: var(--muted);">Limpieza interna, cambio de pasta térmica, instalación de SSD, formateo y backup de datos.</p>
        </div>
        <div style="text-align: center;">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🔋</div>
          <h3 style="font-size: 1.25rem;">Baterías y Accesorios</h3>
          <p style="color: var(--muted);">Reemplazo de baterías para notebooks, cargadores universales y originales.</p>
        </div>
      </div>
    </div>
  </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
