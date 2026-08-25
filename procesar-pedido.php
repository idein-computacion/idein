<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/carrito.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . SITE_URL);
    exit;
}

$items = carritoItems();
$total = carritoTotal();

if (empty($items)) {
    header('Location: ' . SITE_URL . '/carrito.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$notas = trim($_POST['notas'] ?? '');
$pago = trim($_POST['pago'] ?? 'transferencia');

if (!$nombre || !$telefono || !$email) {
    die("Faltan datos obligatorios.");
}

$pdo = getDB();
$numero_pedido = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);

try {
    $pdo->beginTransaction();
    
    $st = $pdo->prepare("INSERT INTO pedidos (numero_pedido, nombre, email, telefono, direccion, notas, subtotal, total, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $st->execute([$numero_pedido, $nombre, $email, $telefono, $direccion, $notas, $total, $total, $pago]);
    $pedido_id = $pdo->lastInsertId();
    
    $stItem = $pdo->prepare("INSERT INTO pedido_items (pedido_id, producto_id, nombre_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($items as $item) {
        $sub = $item['precio'] * $item['cantidad'];
        $stItem->execute([$pedido_id, $item['producto_id'], $item['nombre'], $item['cantidad'], $item['precio'], $sub]);
    }
    
    $pdo->commit();
    carritoVaciar();
    
    // Generar link de WA con el número de orden
    $waText = "Hola IDeIn Computación, acabo de realizar el pedido *$numero_pedido* por un total de $" . number_format($total, 2, ',', '.') . ". Mi nombre es $nombre. ¿Me confirman?";
    $waLink = "https://wa.me/" . WHATSAPP_NUM . "?text=" . urlencode($waText);
    
    require_once __DIR__ . '/includes/header.php';
    ?>
    <main class="idein-container" style="text-align: center; padding: 4rem 2rem;">
        <div style="font-size: 5rem; margin-bottom: 1rem;">✅</div>
        <h1 style="color: var(--success); margin-bottom: 1rem;">¡Pedido Confirmado!</h1>
        <p style="font-size: 1.25rem; margin-bottom: 0.5rem;">Tu número de orden es: <strong><?= e($numero_pedido) ?></strong></p>
        <p style="color: var(--muted); margin-bottom: 2rem;">Recibimos tu solicitud correctamente. Nos pondremos en contacto pronto.</p>
        
        <div style="background: var(--soft); padding: 2rem; border-radius: 8px; max-width: 500px; margin: 0 auto 2rem;">
            <h3>¿Querés agilizar tu pedido?</h3>
            <p style="margin-bottom: 1.5rem;">Envianos un WhatsApp con tu número de orden.</p>
            <a href="<?= $waLink ?>" target="_blank" rel="noopener" class="idein-btn" style="background: #25D366; width: 100%;">Avisar por WhatsApp</a>
        </div>
        
        <a href="<?= SITE_URL ?>/index.php" style="color: var(--accent); font-weight: 600;">Volver al inicio</a>
    </main>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al procesar el pedido. Intentá nuevamente más tarde.");
}
