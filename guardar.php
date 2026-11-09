<?php
require __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido.');
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$programa = trim($_POST['programa'] ?? '');

if ($nombre === '' || $programa === '' ||
    !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    strlen($nombre) > 100 || strlen($correo) > 150 ||
    strlen($programa) > 100) {
    http_response_code(400);
    exit('Datos inválidos. Regrese y revise el formulario.');
}

try {
    $sql = 'INSERT INTO estudiantes (nombre, correo, programa)
            VALUES (:nombre, :correo, :programa)';
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':programa' => $programa
    ]);
    header('Location: index.php', true, 303);
    exit;
} catch (PDOException $error) {
    error_log($error->getMessage());
    http_response_code(500);
    exit('No se pudo guardar. Revise si el correo ya existe.');
}
