<?php
// Conexión a la base de datos
include "../config/conexion.php";


// Obtener las fechas del formulario
$fecha_1 = $_POST['fecha_1'];
$fecha_2 = $_POST['fecha_2'];
$fecha_3 = $_POST['fecha_3'];
$fecha_4 = $_POST['fecha_4'];
$fecha_5 = $_POST['fecha_5'];
$fecha_6 = $_POST['fecha_6'];
$fecha_7 = $_POST['fecha_7'];
$fecha_8 = $_POST['fecha_8'];

// Consulta SQL para insertar las fechas
$sql = "INSERT INTO fechas_eventos (fecha_1, fecha_2, fecha_3, fecha_4, fecha_5, fecha_6, fecha_7, fecha_8)
        VALUES ('$fecha_1', '$fecha_2', '$fecha_3', '$fecha_4', '$fecha_5', '$fecha_6', '$fecha_7', '$fecha_8')";

if ($conexion->query($sql) === TRUE) {
    header(header: "Location: ../views/registerm.php");
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

$conexion->close();
?>
