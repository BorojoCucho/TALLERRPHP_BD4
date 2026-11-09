<?php

$estudiantes = [
    [
        'id' => 1,
        'nombre' => 'Ana Torres',
        'correo' => 'ana@example.com',
        'programa' => 'Ingeniería de Sistemas'
    ],
    [
        'id' => 2,
        'nombre' => 'Luis Pérez',
        'correo' => 'luis@example.com',
        'programa' => 'Ingeniería Industrial'
    ]
];

ob_start();
?>
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
<?php
$htmlGenerado = ob_get_clean();

if (strpos($htmlGenerado, 'Ana Torres') !== false &&
    strpos($htmlGenerado, 'luis@example.com') !== false &&
    strpos($htmlGenerado, 'Ingeniería de Sistemas') !== false) {
    echo "[OK] Renderizado de plantilla y datos HTML correcto.\n";
    exit(0);
} else {
    echo "[FALLO] El HTML generado no contiene los datos esperados.\n";
    exit(1);
}
