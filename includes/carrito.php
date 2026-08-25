<?php
// ============================================
// IDeIn Computación - Lógica del carrito (Sessions)
// ============================================
if (session_status() === PHP_SESSION_NONE) session_start();

function carritoInit(): void {
    if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
}

function carritoAgregar(int $id, int $cantidad = 1): array {
    carritoInit();
    $pdo = require_once __DIR__ . '/db.php'; // solo para tener scope
    $pdo = getDB();
    $st = $pdo->prepare("SELECT id, nombre, precio, precio_oferta, imagen, stock FROM productos WHERE id = ? AND activo = 1");
    $st->execute([$id]);
    $prod = $st->fetch();
    if (!$prod) return ['ok' => false, 'msg' => 'Producto no encontrado'];

    $precio = $prod['precio_oferta'] ?? $prod['precio'];
    $key = "p{$id}";

    if (isset($_SESSION['carrito'][$key])) {
        $nuevaCant = $_SESSION['carrito'][$key]['cantidad'] + $cantidad;
        if ($nuevaCant > $prod['stock']) $nuevaCant = $prod['stock'];
        $_SESSION['carrito'][$key]['cantidad'] = $nuevaCant;
    } else {
        if ($cantidad > $prod['stock']) $cantidad = $prod['stock'];
        $_SESSION['carrito'][$key] = [
            'producto_id' => $id,
            'nombre'      => $prod['nombre'],
            'precio'      => (float) $precio,
            'imagen'      => $prod['imagen'],
            'stock'       => (int) $prod['stock'],
            'cantidad'    => (int) $cantidad,
        ];
    }

    return ['ok' => true, 'msg' => 'Agregado al carrito', 'items' => carritoCount()];
}

function carritoActualizar(int $id, int $cantidad): void {
    carritoInit();
    $key = "p{$id}";
    if (!isset($_SESSION['carrito'][$key])) return;
    if ($cantidad <= 0) {
        unset($_SESSION['carrito'][$key]);
    } else {
        $maxStock = $_SESSION['carrito'][$key]['stock'];
        $_SESSION['carrito'][$key]['cantidad'] = min($cantidad, $maxStock);
    }
}

function carritoEliminar(int $id): void {
    carritoInit();
    unset($_SESSION['carrito']["p{$id}"]);
}

function carritoVaciar(): void {
    $_SESSION['carrito'] = [];
}

function carritoItems(): array {
    carritoInit();
    return $_SESSION['carrito'] ?? [];
}

function carritoCount(): int {
    carritoInit();
    return array_sum(array_column($_SESSION['carrito'] ?? [], 'cantidad'));
}

function carritoTotal(): float {
    carritoInit();
    $total = 0.0;
    foreach ($_SESSION['carrito'] ?? [] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return $total;
}

function carritoWAMessage(): string {
    carritoInit();
    $lineas = ["🛒 *Pedido IDeIn Computación*\n"];
    foreach ($_SESSION['carrito'] ?? [] as $item) {
        $sub = $item['precio'] * $item['cantidad'];
        $lineas[] = "• {$item['nombre']} x{$item['cantidad']} = $ " . number_format($sub, 2, ',', '.');
    }
    $total = carritoTotal();
    $lineas[] = "\n*Total: $ " . number_format($total, 2, ',', '.') . "*";
    $lineas[] = "\n¿Pueden confirmar disponibilidad y forma de pago?";
    return implode("\n", $lineas);
}
