<?php
// Datos de la conexión
$servername = "localhost";
$username = "juan211121";
$password = "O%uX9Dqwx?W-";
$dbname = "sistema_incentivos";

// Crear la conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Definir el juego de caracteres (UTF-8)
$conexion->set_charset("utf8");

// Mensaje de éxito (opcional)
?>
