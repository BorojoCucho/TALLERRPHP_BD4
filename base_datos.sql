-- Base de datos de la aplicacion
CREATE DATABASE IF NOT EXISTS universidad_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE universidad_db;

CREATE TABLE IF NOT EXISTS estudiantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  programa VARCHAR(100) NOT NULL
);

INSERT INTO estudiantes (nombre, correo, programa) VALUES
('Ana Torres', 'ana@example.com', 'Ingeniería de Sistemas'),
('Luis Pérez', 'luis@example.com', 'Ingeniería Industrial');

CREATE USER IF NOT EXISTS 'app_lasalle'@'localhost'
IDENTIFIED BY 'Cambiar_Esta_Clave_2026!';
GRANT SELECT, INSERT ON universidad_db.*
TO 'app_lasalle'@'localhost';
