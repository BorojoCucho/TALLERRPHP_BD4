<?php
require __DIR__ . '/conexion.php';
$consulta = $conexion->query(
    'SELECT id, nombre, correo, programa FROM estudiantes ORDER BY id DESC'
);
$estudiantes = $consulta->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Estudiantes - La Salle</title>
</head>
<body>
  <h1>Registro de estudiantes</h1>
  <table border="1" cellpadding="8">
    <tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Programa</th></tr>
    <?php foreach ($estudiantes as $fila): ?>
      <tr>
        <td><?= (int) $fila['id'] ?></td>
        <td><?= htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($fila['programa'], ENT_QUOTES, 'UTF-8') ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <h2>Agregar estudiante</h2>
  <form action="guardar.php" method="post">
    <label>Nombre: <input type="text" name="nombre" required maxlength="100"></label><br>
    <label>Correo: <input type="email" name="correo" required maxlength="150"></label><br>
    <label>Programa: <input type="text" name="programa" required maxlength="100"></label><br>
    <button type="submit">Guardar</button>
  </form>
</body>
</html>
