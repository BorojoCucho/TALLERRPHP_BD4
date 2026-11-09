<?php

$pruebasPasadas = 0;
$pruebasTotales = 0;

function asegurar($condicion, $mensaje) {
    global $pruebasPasadas, $pruebasTotales;
    $pruebasTotales++;
    if ($condicion) {
        $pruebasPasadas++;
        echo "[OK] $mensaje\n";
    } else {
        echo "[FALLO] $mensaje\n";
        exit(1);
    }
}

$archivosPhp = [
    'C:/xampp/htdocs/mi_primer_php/index.php',
    'C:/xampp/htdocs/lasalle_estudiantes/conexion.php',
    'C:/xampp/htdocs/lasalle_estudiantes/guardar.php',
    'C:/xampp/htdocs/lasalle_estudiantes/index.php'
];

foreach ($archivosPhp as $archivo) {
    asegurar(file_exists($archivo), "El archivo existe: " . basename($archivo));
    $salida = [];
    $codigoRetorno = 0;
    exec("C:\\xampp\\php\\php.exe -l \"$archivo\"", $salida, $codigoRetorno);
    asegurar($codigoRetorno === 0, "Sintaxis valida en: " . basename($archivo));
}

function validarEntradaEstudiante($metodo, $datos) {
    if ($metodo !== 'POST') {
        return ['valido' => false, 'codigo' => 405, 'mensaje' => 'Método no permitido.'];
    }

    $nombre = trim($datos['nombre'] ?? '');
    $correo = trim($datos['correo'] ?? '');
    $programa = trim($datos['programa'] ?? '');

    if ($nombre === '' || $programa === '' ||
        !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
        strlen($nombre) > 100 || strlen($correo) > 150 ||
        strlen($programa) > 100) {
        return ['valido' => false, 'codigo' => 400, 'mensaje' => 'Datos inválidos. Regrese y revise el formulario.'];
    }

    return ['valido' => true, 'codigo' => 200, 'nombre' => $nombre, 'correo' => $correo, 'programa' => $programa];
}

$casoValido = validarEntradaEstudiante('POST', [
    'nombre' => 'Carlos Mendoza',
    'correo' => 'carlos@lasalle.edu.co',
    'programa' => 'Ingeniería de Alimentos'
]);
asegurar($casoValido['valido'] === true, 'Validacion con datos correctos');

$casoMetodoGet = validarEntradaEstudiante('GET', []);
asegurar($casoMetodoGet['valido'] === false && $casoMetodoGet['codigo'] === 405, 'Rechazo de metodo GET');

$casoCorreoInvalido = validarEntradaEstudiante('POST', [
    'nombre' => 'Carlos Mendoza',
    'correo' => 'correo-no-valido',
    'programa' => 'Ingeniería'
]);
asegurar($casoCorreoInvalido['valido'] === false && $casoCorreoInvalido['codigo'] === 400, 'Rechazo de correo invalido');

$casoNombreVacio = validarEntradaEstudiante('POST', [
    'nombre' => '   ',
    'correo' => 'test@lasalle.edu.co',
    'programa' => 'Ingeniería'
]);
asegurar($casoNombreVacio['valido'] === false && $casoNombreVacio['codigo'] === 400, 'Rechazo de nombre vacio');

$casoNombreLargo = validarEntradaEstudiante('POST', [
    'nombre' => str_repeat('A', 101),
    'correo' => 'test@lasalle.edu.co',
    'programa' => 'Ingeniería'
]);
asegurar($casoNombreLargo['valido'] === false && $casoNombreLargo['codigo'] === 400, 'Rechazo de nombre mayor a 100 caracteres');

$textoPeligroso = '<script>alert("xss")</script>';
$textoEscapado = htmlspecialchars($textoPeligroso, ENT_QUOTES, 'UTF-8');
asegurar($textoEscapado === '&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', 'Escape correcto de caracteres peligrosos');

$contenidoSql = file_get_contents('C:/xampp/htdocs/lasalle_estudiantes/base_datos.sql');
asegurar(strpos($contenidoSql, 'CREATE DATABASE IF NOT EXISTS universidad_db') !== false, 'Script SQL contiene CREATE DATABASE');
asegurar(strpos($contenidoSql, 'CREATE TABLE IF NOT EXISTS estudiantes') !== false, 'Script SQL contiene CREATE TABLE estudiantes');
asegurar(strpos($contenidoSql, 'app_lasalle') !== false, 'Script SQL contiene usuario app_lasalle');

echo "\nResultado final: $pruebasPasadas de $pruebasTotales pruebas pasadas con exito.\n";
