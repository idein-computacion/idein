-- ============================================
-- IDeIn Computación - Base de Datos
-- Ejecutar en phpMyAdmin o MySQL CLI
-- ============================================

CREATE DATABASE IF NOT EXISTS idein_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE idein_db;

-- Categorías
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  descripcion TEXT,
  icono VARCHAR(10) DEFAULT '📦',
  activa TINYINT(1) DEFAULT 1,
  orden INT DEFAULT 0
);

-- Productos
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria_id INT NOT NULL,
  nombre VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  descripcion_corta VARCHAR(300),
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL DEFAULT 0,
  precio_oferta DECIMAL(10,2) DEFAULT NULL,
  stock INT DEFAULT 0,
  marca VARCHAR(100),
  modelo VARCHAR(100),
  sku VARCHAR(80),
  imagen VARCHAR(300) DEFAULT 'img/productos/sin-imagen.jpg',
  activo TINYINT(1) DEFAULT 1,
  destacado TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- Imágenes adicionales de productos
CREATE TABLE producto_imagenes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  ruta VARCHAR(300) NOT NULL,
  orden INT DEFAULT 0,
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Especificaciones técnicas
CREATE TABLE producto_specs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  valor VARCHAR(200) NOT NULL,
  orden INT DEFAULT 0,
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Pedidos
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero_pedido VARCHAR(20) NOT NULL UNIQUE,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(150),
  telefono VARCHAR(30),
  direccion TEXT,
  localidad VARCHAR(100),
  notas TEXT,
  subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
  total DECIMAL(10,2) NOT NULL DEFAULT 0,
  estado ENUM('pendiente','confirmado','preparando','enviado','entregado','cancelado') DEFAULT 'pendiente',
  metodo_pago ENUM('transferencia','efectivo','mercadopago','whatsapp') DEFAULT 'transferencia',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Items de pedidos
CREATE TABLE pedido_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT,
  nombre_producto VARCHAR(200) NOT NULL,
  cantidad INT NOT NULL DEFAULT 1,
  precio_unitario DECIMAL(10,2) NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
);

-- Administradores
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- DATOS INICIALES
-- ============================================

INSERT INTO categorias (nombre, slug, descripcion, icono, orden) VALUES
('Ratones', 'ratones', 'Ratones inalámbricos, con cable y para juegos', '🖱️', 1),
('Teclados', 'teclados', 'Teclados USB, inalámbricos y mecánicos', '⌨️', 2),
('Auriculares', 'auriculares', 'Auriculares con y sin micrófono', '🎧', 3),
('Cables', 'cables', 'Cables USB, HDMI, de red y más', '🔌', 4),
('Tintas y Tóners', 'tintas-toners', 'Cartuchos, tóners y recargas de tinta', '🖨️', 5),
('Periféricos', 'perifericos', 'Otros accesorios y periféricos informáticos', '💻', 6);

-- Admin por defecto: admin@idein.com / idein2025
-- Cambiar la contraseña desde el panel admin
INSERT INTO admins (nombre, email, password_hash) VALUES
('Administrador', 'admin@idein.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TiGFJiOqGILUqHcXE3qOdLxmtb2W');

-- Productos de muestra
INSERT INTO productos (categoria_id, nombre, slug, descripcion_corta, precio, stock, marca, imagen, activo, destacado) VALUES
(1, 'Ratón USB Óptico Estándar', 'mouse-usb-optico-standard', 'Ratón con cable USB, sensor óptico 1000 DPI, conectar y usar.', 4500.00, 30, 'Genérico', 'img/productos/mouse-usb-optico-standard.png', 1, 0),
(1, 'Ratón Inalámbrico Recargable', 'mouse-inalambrico-recargable', 'Ratón inalámbrico 2.4GHz, batería recargable, silencioso.', 12500.00, 15, 'Logitech', 'img/productos/mouse-inalambrico-recargable.png', 1, 1),
(2, 'Teclado USB Español', 'teclado-usb-espanol', 'Teclado con cable USB, distribución en español, resistente al polvo.', 6800.00, 25, 'Genius', 'img/productos/teclado-usb-espanol.png', 1, 0),
(2, 'Combo Teclado + Ratón Inalámbrico', 'combo-teclado-mouse-inalambrico', 'Juego inalámbrico con receptor USB unificado, pilas incluidas.', 18500.00, 10, 'Logitech', 'img/productos/combo-teclado-mouse-inalambrico.png', 1, 1),
(3, 'Auriculares con Micrófono USB', 'auriculares-microfono-usb', 'Auriculares estéreo con micrófono, ideal para videollamadas.', 9800.00, 20, 'Genérico', 'img/productos/auriculares-microfono-usb.png', 1, 0),
(3, 'Auriculares Bluetooth Inalámbricos', 'auriculares-bluetooth', 'Bluetooth 5.0, autonomía 20hs, cancelación de ruido básica.', 22000.00, 8, 'JBL', 'img/productos/auriculares-bluetooth.png', 1, 1),
(4, 'Cable HDMI 1.8m', 'cable-hdmi-18m', 'Cable HDMI 2.0 Full HD/4K, 1.8 metros, dorado en conectores.', 3200.00, 40, 'Genérico', 'img/productos/cable-hdmi-18m.png', 1, 0),
(4, 'Cable USB-C a USB-A 1m', 'cable-usbc-usba-1m', 'Cable de carga y datos USB-C, 1 metro, trenzado.', 2800.00, 50, 'Genérico', 'img/productos/cable-usbc-usba-1m.png', 1, 0),
(5, 'Cartucho Negro HP 664', 'cartucho-negro-hp-664', 'Cartucho de tinta negra original HP 664, compatible con HP Deskjet.', 7500.00, 20, 'HP', 'img/productos/cartucho-negro-hp-664.png', 1, 0),
(5, 'Tóner Samsung MLT-D101S', 'toner-samsung-mlt-d101s', 'Tóner compatible Samsung, rendimiento 1500 páginas aprox.', 15000.00, 12, 'Compatible', 'img/productos/toner-samsung-mlt-d101s.png', 1, 0),
(5, 'Recarga de Tinta Negra 100ml', 'recarga-tinta-negra-100ml', 'Tinta pigmentada negra 100ml, compatible con la mayoría de impresoras.', 2500.00, 35, 'IDeIn', 'img/productos/recarga-tinta-negra-100ml.png', 1, 1),
(6, 'Concentrador USB 4 Puertos', 'hub-usb-4-puertos', 'Concentrador USB 3.0 con 4 puertos, compatible con Windows/Mac.', 5500.00, 18, 'Genérico', 'img/productos/hub-usb-4-puertos.png', 1, 0);

