<?php // includes/footer.php ?>
<footer class="idein-footer">
  <div class="idein-footer-inner">

    <!-- Columna 1: Marca -->
    <div class="idein-footer-col">
      <a href="<?= SITE_URL ?>/index.php" class="idein-footer-brand">
        <img src="<?= SITE_URL ?>/img/logo.png" alt="<?= SITE_NAME ?>" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
        <span style="display:none;font-size:24px;font-weight:900;color:#60a5fa">IDeIn</span>
      </a>
      <p>Venta de artículos informáticos, reparación de impresoras y mantenimiento de equipos.</p>
      <div class="idein-footer-social">
        <a href="https://wa.me/<?= WHATSAPP_NUM ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.121 1.533 5.851L.057 23.5l5.77-1.514A11.95 11.95 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.893 0-3.668-.523-5.183-1.43l-.371-.22-3.842 1.007 1.027-3.74-.241-.386A9.944 9.944 0 0 1 2 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10z"/></svg>
        </a>
      </div>
    </div>

    <!-- Columna 2: Productos -->
    <div class="idein-footer-col">
      <h4>Productos</h4>
      <?php foreach (getCategorias() as $cat): ?>
        <a href="<?= SITE_URL ?>/catalogo.php?cat=<?= e($cat['slug']) ?>"><?= e($cat['icono']) ?> <?= e($cat['nombre']) ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Columna 3: Servicios -->
    <div class="idein-footer-col">
      <h4>Servicios</h4>
      <a href="<?= SITE_URL ?>/servicios.php#reparacion">🖨️ Reparación de impresoras</a>
      <a href="<?= SITE_URL ?>/servicios.php#mantenimiento">💻 Mantenimiento de PC</a>
      <a href="<?= SITE_URL ?>/servicios.php#notebooks">🔋 Reparación de notebooks</a>
      <a href="<?= SITE_URL ?>/servicios.php#diagnostico">🔍 Diagnóstico de equipos</a>
    </div>

    <!-- Columna 4: Contacto -->
    <div class="idein-footer-col">
      <h4>Contacto</h4>
      <a href="https://wa.me/<?= WHATSAPP_NUM ?>" target="_blank" rel="noopener">📱 WhatsApp: +54 9 3754 40-6435</a>
      <a href="mailto:<?= ADMIN_EMAIL ?>"  >📧 <?= ADMIN_EMAIL ?></a>
      <a href="https://www.google.com/maps/search/?api=1&query=Cataratas+del+Iguazu+912+Leandro+N+Alem+Misiones+Argentina" target="_blank" rel="noopener">📍 <?= DIRECCION ?>, <?= CIUDAD ?>, <?= PROVINCIA ?></a>
    </div>

  </div>

  <!-- Mapa de ubicación -->
  <div class="idein-footer-map">
    <h4 style="text-align: center; color: #94a3b8; margin-bottom: 1rem; font-size: 1rem;">📍 Encontranos acá</h4>
    <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.3); max-width: 900px; margin: 0 auto;">
      <iframe
        src="https://www.google.com/maps?q=Cataratas+del+Iguazu+912,+Leandro+N+Alem,+Misiones,+Argentina&output=embed"
        width="100%"
        height="300"
        style="border:0; display: block;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Ubicación de IDeIn Computación">
      </iframe>
    </div>
  </div>

  <div class="idein-footer-bottom">
    <p>© <?= date('Y') ?> <?= SITE_NAME ?>. Todos los derechos reservados.</p>
    <p><?= DIRECCION ?>, <?= CIUDAD ?>, <?= PROVINCIA ?>, <?= PAIS ?></p>
    <p>Los precios pueden variar. Consultá disponibilidad antes de comprar.</p>
  </div>
</footer>

<script src="<?= SITE_URL ?>/js/tienda.js"></script>
</body>
</html>
