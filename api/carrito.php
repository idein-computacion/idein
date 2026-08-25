<?php
require_once __DIR__ . '/includes/carrito.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
$cantidad = (int)($_POST['cantidad'] ?? 1);

$response = ['ok' => false, 'msg' => 'Acción no válida'];

if ($action === 'add' && $id > 0) {
    $response = carritoAgregar($id, $cantidad);
} elseif ($action === 'update' && $id > 0) {
    carritoActualizar($id, $cantidad);
    $response = ['ok' => true, 'items' => carritoCount(), 'total' => carritoTotal()];
} elseif ($action === 'remove' && $id > 0) {
    carritoEliminar($id);
    $response = ['ok' => true, 'items' => carritoCount(), 'total' => carritoTotal()];
}

echo json_encode($response);
