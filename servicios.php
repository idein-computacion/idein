<?php
require_once __DIR__ . '/includes/header.php';
$pageTitle = 'Servicios - ' . SITE_NAME;
?>
<main class="idein-container">
  <div style="text-align: center; margin-bottom: 4rem;">
    <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Servicio Técnico Especializado</h1>
    <p style="font-size: 1.25rem; color: var(--muted); max-width: 800px; margin: 0 auto;">
      En IDeIn Computación no solo vendemos productos, también somos especialistas en reparación y mantenimiento para darle más vida útil a tus equipos.
    </p>
  </div>

  <div style="display: grid; gap: 3rem; max-width: 900px; margin: 0 auto;">
    
    <!-- Reparación Impresoras -->
    <div id="reparacion" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <div style="flex: 1; min-width: 250px;">
        <h2 style="color: var(--accent); margin-top: 0;">Reparación de Impresoras</h2>
        <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Mantenimiento preventivo y limpieza general</li>
          <li>Destape de cabezales Epson, HP, Brother</li>
          <li>Reparación y reseteo de almohadillas</li>
          <li>Instalación y reparación de sistemas continuos</li>
          <li>Solución de problemas de toma de papel</li>
        </ul>
        <a href="https://wa.me/<?= WHATSAPP_NUM ?>?text=Hola, necesito consultar por reparación de una impresora..." target="_blank" rel="noopener" class="idein-btn" style="width: auto;">Consultar presupuesto</a>
      </div>
      <div style="font-size: 8rem; line-height: 1; text-align: center; flex: 1; min-width: 200px;">
        🖨️
      </div>
    </div>

    <!-- Mantenimiento PC -->
    <div id="mantenimiento" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <div style="font-size: 8rem; line-height: 1; text-align: center; flex: 1; min-width: 200px; order: -1;">
        💻
      </div>
      <div style="flex: 1; min-width: 250px;">
        <h2 style="color: var(--accent); margin-top: 0;">Mantenimiento de PC y Notebooks</h2>
        <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Limpieza interna y cambio de pasta térmica</li>
          <li>Formateo, instalación de Windows y programas</li>
          <li>Backup y recuperación de datos</li>
          <li>Actualización a disco sólido (SSD) y ampliación de RAM</li>
          <li>Eliminación de virus y optimización del sistema</li>
        </ul>
        <a href="https://wa.me/<?= WHATSAPP_NUM ?>?text=Hola, necesito consultar por mantenimiento de PC/Notebook..." target="_blank" rel="noopener" class="idein-btn" style="width: auto;">Consultar presupuesto</a>
      </div>
    </div>

    <!-- Baterías y Notebooks -->
    <div id="notebooks" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <div style="flex: 1; min-width: 250px;">
        <h2 style="color: var(--accent); margin-top: 0;">Baterías y Reparación de Hardware</h2>
        <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1.5rem; padding-left: 1.5rem;">
          <li>Cambio de pantallas rotas o con fallas</li>
          <li>Reemplazo de baterías internas y externas</li>
          <li>Reparación de pin de carga y placas</li>
          <li>Cambio de teclados de notebooks</li>
          <li>Cargadores originales y alternativos de alta calidad</li>
        </ul>
        <a href="https://wa.me/<?= WHATSAPP_NUM ?>?text=Hola, busco repuestos/batería para mi notebook..." target="_blank" rel="noopener" class="idein-btn" style="width: auto;">Consultar disponibilidad</a>
      </div>
      <div style="font-size: 8rem; line-height: 1; text-align: center; flex: 1; min-width: 200px;">
        🔋
      </div>
    </div>

  </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
