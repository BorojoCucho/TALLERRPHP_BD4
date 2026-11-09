<?php
$servidor = 'localhost';
$puerto = '3306';
$baseDatos = 'universidad_db';
$usuario = 'app_lasalle';
$contrasena = 'Cambiar_Esta_Clave_2026!';

$dsn = "mysql:host=$servidor;port=$puerto;dbname=$baseDatos;charset=utf8mb4";

try {
    $conexion = new PDO($dsn, $usuario, $contrasena, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $error) {
    error_log($error->getMessage());
    http_response_code(500);
    exit('No fue posible conectar con la base de datos.');
}
