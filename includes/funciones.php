<?php
// ============================================
// IDeIn Computación - Funciones helpers
// ============================================
require_once __DIR__ . '/db.php';

// ── Precio formateado ─────────────────────────────────────────────
function precio(float $n): string {
    return MONEDA . ' ' . number_format($n, 2, ',', '.');
}

// ── Porcentaje de descuento ───────────────────────────────────────
function descuento(float $original, float $oferta): int {
    if ($original <= 0) return 0;
    return (int) round((($original - $oferta) / $original) * 100);
}

// ── Slug a partir de texto ────────────────────────────────────────
function slugify(string $text): string {
    $text = mb_strtolower($text, 'UTF-8');
    $text = str_replace(['á','é','í','ó','ú','ü','ñ'], ['a','e','i','o','u','u','n'], $text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', trim($text));
    return $text;
}

// ── Sanitizar output ──────────────────────────────────────────────
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ── Categorías activas ────────────────────────────────────────────
function getCategorias(): array {
    $pdo = getDB();
    return $pdo->query("SELECT * FROM categorias WHERE activa = 1 ORDER BY orden ASC")->fetchAll();
}

// ── Categoría por slug ────────────────────────────────────────────
function getCategoriaBySlug(string $slug): ?array {
    $pdo = getDB();
    $st = $pdo->prepare("SELECT * FROM categorias WHERE slug = ? AND activa = 1");
    $st->execute([$slug]);
    return $st->fetch() ?: null;
}

// ── Producto por slug ─────────────────────────────────────────────
function getProductoBySlug(string $slug): ?array {
    $pdo = getDB();
    $st = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
        FROM productos p
        JOIN categorias c ON c.id = p.categoria_id
        WHERE p.slug = ? AND p.activo = 1
    ");
    $st->execute([$slug]);
    return $st->fetch() ?: null;
}

// ── Specs de un producto ──────────────────────────────────────────
function getSpecs(int $productoId): array {
    $pdo = getDB();
    $st = $pdo->prepare("SELECT nombre, valor FROM producto_specs WHERE producto_id = ? ORDER BY orden ASC");
    $st->execute([$productoId]);
    return $st->fetchAll();
}

// ── Imágenes extra de un producto ────────────────────────────────
function getImagenesProducto(int $productoId): array {
    $pdo = getDB();
    $st = $pdo->prepare("SELECT ruta FROM producto_imagenes WHERE producto_id = ? ORDER BY orden ASC");
    $st->execute([$productoId]);
    return $st->fetchAll(PDO::FETCH_COLUMN);
}

// ── Productos destacados ──────────────────────────────────────────
function getDestacados(int $limite = 8): array {
    $pdo = getDB();
    $st = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p JOIN categorias c ON c.id = p.categoria_id
        WHERE p.activo = 1 AND p.destacado = 1
        ORDER BY p.created_at DESC LIMIT ?
    ");
    $st->execute([$limite]);
    return $st->fetchAll();
}

// ── Productos por categoría con paginación ────────────────────────
function getProductosByCategoria(int $catId, int $pagina = 1, int $porPagina = 16): array {
    $pdo = getDB();
    $offset = ($pagina - 1) * $porPagina;
    $st = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p JOIN categorias c ON c.id = p.categoria_id
        WHERE p.activo = 1 AND p.categoria_id = ?
        ORDER BY p.destacado DESC, p.nombre ASC
        LIMIT ? OFFSET ?
    ");
    $st->execute([$catId, $porPagina, $offset]);
    return $st->fetchAll();
}

// ── Total de productos de una categoría ──────────────────────────
function countProductosByCategoria(int $catId): int {
    $pdo = getDB();
    $st = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE activo = 1 AND categoria_id = ?");
    $st->execute([$catId]);
    return (int) $st->fetchColumn();
}

// ── Búsqueda de productos ─────────────────────────────────────────
function buscarProductos(string $q, int $pagina = 1, int $porPagina = 16): array {
    $pdo = getDB();
    $like = '%' . $q . '%';
    $offset = ($pagina - 1) * $porPagina;
    $st = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p JOIN categorias c ON c.id = p.categoria_id
        WHERE p.activo = 1 AND (p.nombre LIKE ? OR p.descripcion_corta LIKE ? OR p.marca LIKE ?)
        ORDER BY p.destacado DESC, p.nombre ASC
        LIMIT ? OFFSET ?
    ");
    $st->execute([$like, $like, $like, $porPagina, $offset]);
    return $st->fetchAll();
}

function countBusqueda(string $q): int {
    $pdo = getDB();
    $like = '%' . $q . '%';
    $st = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE activo=1 AND (nombre LIKE ? OR descripcion_corta LIKE ? OR marca LIKE ?)");
    $st->execute([$like, $like, $like]);
    return (int) $st->fetchColumn();
}

// ── Todos los productos (catálogo general) ────────────────────────
function getAllProductos(int $pagina = 1, int $porPagina = 16, ?int $catId = null, string $orden = 'destacado'): array {
    $pdo = getDB();
    $offset = ($pagina - 1) * $porPagina;
    $where = "p.activo = 1";
    $params = [];
    if ($catId) { $where .= " AND p.categoria_id = ?"; $params[] = $catId; }

    $orderSql = match($orden) {
        'precio_asc'  => "p.precio ASC",
        'precio_desc' => "p.precio DESC",
        'nombre'      => "p.nombre ASC",
        default       => "p.destacado DESC, p.created_at DESC",
    };

    $params[] = $porPagina;
    $params[] = $offset;

    $st = $pdo->prepare("
        SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p JOIN categorias c ON c.id = p.categoria_id
        WHERE $where ORDER BY $orderSql LIMIT ? OFFSET ?
    ");
    $st->execute($params);
    return $st->fetchAll();
}

function countAllProductos(?int $catId = null): int {
    $pdo = getDB();
    if ($catId) {
        $st = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE activo=1 AND categoria_id=?");
        $st->execute([$catId]);
    } else {
        $st = $pdo->query("SELECT COUNT(*) FROM productos WHERE activo=1");
    }
    return (int) $st->fetchColumn();
}

// ── Paginación HTML ───────────────────────────────────────────────
function paginacion(int $total, int $porPagina, int $actual, string $baseUrl): string {
    $paginas = (int) ceil($total / $porPagina);
    if ($paginas <= 1) return '';

    $sep = str_contains($baseUrl, '?') ? '&' : '?';
    $html = '<nav class="idein-paginacion" aria-label="Páginas">';
    if ($actual > 1)
        $html .= '<a href="' . $baseUrl . $sep . 'pag=' . ($actual - 1) . '" class="idein-pag-btn">‹ Anterior</a>';

    for ($i = 1; $i <= $paginas; $i++) {
        $active = $i === $actual ? ' is-active' : '';
        $html .= '<a href="' . $baseUrl . $sep . 'pag=' . $i . '" class="idein-pag-btn' . $active . '">' . $i . '</a>';
    }

    if ($actual < $paginas)
        $html .= '<a href="' . $baseUrl . $sep . 'pag=' . ($actual + 1) . '" class="idein-pag-btn">Siguiente ›</a>';

    return $html . '</nav>';
}

// ── Imagen con fallback ───────────────────────────────────────────
function imgSrc(string $ruta): string {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/idein/' . $ruta)) {
        return SITE_URL . '/' . $ruta;
    }
    return SITE_URL . '/img/productos/sin-imagen.jpg';
}
