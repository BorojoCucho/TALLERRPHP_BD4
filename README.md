# Sistema de Registro de Estudiantes - Universidad de La Salle

**Asignatura:** Bases de Datos  
**Docente:** Gabriel Barrera  
**Tecnologías:** PHP 8, MySQL/MariaDB, PDO, Apache (XAMPP), HTML5  

---

## 📁 Estructura del Repositorio

- `base_datos.sql`: Script DDL y DML para la creación de la base de datos `universidad_db`, tabla `estudiantes` y el usuario seguro `app_lasalle`.
- `conexion.php`: Conexión segura a MySQL utilizando PDO con manejo de errores y codificación UTF-8.
- `index.php`: Interfaz web que lista los estudiantes en una tabla HTML (con protección XSS vía `htmlspecialchars`) y provee el formulario de registro.
- `guardar.php`: Script de procesamiento del formulario con validación en servidor e inserción mediante sentencias preparadas.
- `README.md`: Documentación del proyecto, arquitectura, guía de ejecución y preguntas de comprobación.

---

## 🚀 Requisitos e Instalación

1. **Instalar e Iniciar XAMPP**:
   - Abrir el **XAMPP Control Panel**.
   - Iniciar los servicios **Apache** (puerto `80` o `8080`) y **MySQL** (puerto `3306`).

2. **Configurar la Base de Datos**:
   - Ingresar a `http://localhost/phpmyadmin/`.
   - Seleccionar la pestaña **SQL**.
   - Copiar y ejecutar el contenido del archivo `base_datos.sql`.

3. **Ejecutar la Aplicación**:
   - Clonar o ubicar esta carpeta dentro de `htdocs` en la ruta de instalación de XAMPP (ej. `C:\xampp\htdocs\lasalle_estudiantes`).
   - Abrir en el navegador: `http://localhost/lasalle_estudiantes/`.

---

## 🏛️ Arquitectura y Puertos

- **Apache (Puerto 80 / 8080):** Servidor web HTTP encargado de atender las peticiones de los navegadores y ejecutar el motor de PHP.
- **MySQL (Puerto 3306):** Motor de base de datos relacional donde residen las tablas y registros.
- **Flujo de comunicación:**  
  Navegador ➡️ Solicitud HTTP ➡️ Apache ➡️ Script PHP ➡️ PDO (puerto 3306) ➡️ Motor MySQL ➡️ Resultado ➡️ Renderizado HTML ➡️ Navegador.

---

## ❓ Preguntas de Comprobación

### 1. ¿Por qué `http://localhost:3306` no es una dirección válida para abrir phpMyAdmin?
El puerto `3306` corresponde al socket binario TCP del motor de MySQL, no a un servidor web HTTP. phpMyAdmin es una aplicación web y debe abrirse a través del servidor Apache (`http://localhost/phpmyadmin/` o puerto `8080`).

### 2. ¿Cuál es la diferencia entre Apache y MySQL?
Apache es el servidor web que atiende solicitudes HTTP, ejecuta el código PHP y entrega HTML al navegador. MySQL es el sistema gestor de bases de datos relacional encargado de persistir y consultar información estructurada.

### 3. ¿Por qué un archivo PHP no debe abrirse con doble clic?
Porque el doble clic abre el archivo localmente con el protocolo `file:///`. El navegador no interpreta código PHP de servidor; requiere que un servidor web (Apache) lo procese y le entregue únicamente el código HTML final.

### 4. ¿Qué cambia en `conexion.php` si MySQL escucha en el puerto 3307?
Se debe ajustar la variable `$puerto = '3307';` para que la cadena DSN de PDO se conecte a dicho puerto específico: `"mysql:host=$servidor;port=3307;..."`.

### 5. ¿Qué diferencia existe entre `query()`, `prepare()` y `execute()`?
- `query()`: Ejecuta una sentencia SQL directamente sin parámetros; ideal para consultas fijas.
- `prepare()`: Precompila la estructura SQL en el motor de base de datos usando marcadores de posición (`:parametro`).
- `execute()`: Envía los valores de los parámetros por separado, impidiendo inyecciones SQL.

### 6. ¿Por qué no debemos mostrar directamente en HTML los datos de la base sin `htmlspecialchars()`?
Para mitigar vulnerabilidades de Cross-Site Scripting (XSS). Si un dato contiene etiquetas `<script>` o caracteres especiales (`<`, `>`, `"`), `htmlspecialchars()` los convierte en entidades de texto seguras para que no se ejecuten en el navegador.

### 7. ¿Por qué es preferible `app_lasalle` frente a `root`?
Por el principio de mínimo privilegio. La cuenta `root` tiene permisos destructivos y globales sobre todo el servidor. Una cuenta limitada como `app_lasalle` únicamente tiene permisos `SELECT` e `INSERT` sobre la base de datos `universidad_db`.
