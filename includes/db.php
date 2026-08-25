<?php
// ============================================
// IDeIn Computación - Conexión a base de datos (PDO)
// ============================================
require_once __DIR__ . '/config.php';

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $opciones);
        } catch (PDOException $e) {
            http_response_code(500);
            die('<div style="font-family:sans-serif;padding:40px;color:#b42318;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;max-width:500px;margin:60px auto">
                <strong>Error de conexión a la base de datos.</strong><br>
                Verificá que XAMPP esté corriendo y la base de datos configurada.<br><br>
                <small>Detalle: ' . htmlspecialchars($e->getMessage()) . '</small>
            </div>');
        }
    }
    return $pdo;
}
