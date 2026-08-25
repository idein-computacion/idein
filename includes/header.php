<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/carrito.php';
$categorias = getCategorias();
$cartCount  = carritoCount();
$currentUrl = $_SERVER['REQUEST_URI'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? SITE_NAME) ?></title>
  <meta name="description" content="<?= e($pageDesc ?? 'Venta de artículos informáticos, reparación de impresoras y mantenimiento de PC en ' . SITE_NAME) ?>">
  <meta name="theme-color" content="#1a56db">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= SITE_URL ?>/css/tienda.css">
</head>
<body>

<!-- TOPBAR -->
<header class="idein-topbar" id="top">
  <div class="idein-topbar-inner">

    <!-- Logo -->
    <a class="idein-brand" href="<?= SITE_URL ?>/index.php" aria-label="<?= SITE_NAME ?> - Inicio">
      <img src="<?= SITE_URL ?>/img/logo.png" alt="<?= SITE_NAME ?>" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
      <span class="idein-brand-text" style="display:none">IDeIn</span>
    </a>

    <!-- Buscador -->
    <form class="idein-search-form" action="<?= SITE_URL ?>/buscar.php" method="GET" role="search">
      <input
        type="search"
        name="q"
        class="idein-search-input"
        placeholder="Buscar productos..."
        value="<?= e($_GET['q'] ?? '') ?>"
        aria-label="Buscar productos"
        autocomplete="off"
      >
      <button type="submit" class="idein-search-btn" aria-label="Buscar">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </button>
    </form>

    <!-- Acciones derecha -->
    <div class="idein-topbar-actions">
      <a class="idein-cart-btn" href="<?= SITE_URL ?>/carrito.php" aria-label="Ver carrito">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <?php if ($cartCount > 0): ?>
          <span class="idein-cart-badge" id="cart-badge"><?= $cartCount ?></span>
        <?php else: ?>
          <span class="idein-cart-badge idein-cart-badge-hidden" id="cart-badge">0</span>
        <?php endif; ?>
      </a>

      <!-- Hamburguesa mobile -->
      <button class="idein-menu-toggle" id="menu-toggle" type="button"
              aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <!-- NAV PRINCIPAL -->
  <nav class="idein-nav" id="main-nav" aria-label="Navegación principal">
    <div class="idein-nav-inner">
      <a href="<?= SITE_URL ?>/index.php" class="idein-nav-link <?= str_contains($currentUrl,'index') || $currentUrl === '/' ? 'is-active' : '' ?>">Inicio</a>

      <!-- Catálogo dropdown -->
      <div class="idein-nav-dropdown-wrap">
        <button class="idein-nav-link idein-nav-dropdown-btn" aria-expanded="false" aria-controls="nav-catalogo">
          Catálogo
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div class="idein-nav-dropdown" id="nav-catalogo">
          <a href="<?= SITE_URL ?>/catalogo.php" class="idein-nav-dropdown-item">
            <span>🛍️</span> Todos los productos
          </a>
          <?php foreach ($categorias as $cat): ?>
          <a href="<?= SITE_URL ?>/catalogo.php?cat=<?= e($cat['slug']) ?>" class="idein-nav-dropdown-item">
            <span><?= e($cat['icono']) ?></span> <?= e($cat['nombre']) ?>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

      <a href="<?= SITE_URL ?>/servicios.php" class="idein-nav-link <?= str_contains($currentUrl,'servicios') ? 'is-active' : '' ?>">Servicios</a>
      <a href="<?= SITE_URL ?>/contacto.php" class="idein-nav-link <?= str_contains($currentUrl,'contacto') ? 'is-active' : '' ?>">Contacto</a>
      <a href="https://wa.me/<?= WHATSAPP_NUM ?>" target="_blank" rel="noopener" class="idein-nav-link idein-nav-wa">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.121 1.533 5.851L.057 23.5l5.77-1.514A11.95 11.95 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.893 0-3.668-.523-5.183-1.43l-.371-.22-3.842 1.007 1.027-3.74-.241-.386A9.944 9.944 0 0 1 2 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10z"/></svg>
        WhatsApp
      </a>
    </div>
  </nav>
</header>

<!-- Toast notificación -->
<div id="idein-toast" class="idein-toast" aria-live="polite" aria-atomic="true"></div>
