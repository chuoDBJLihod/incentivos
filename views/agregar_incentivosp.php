<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";
// Mostrar tabla de usuarios Precilla
if (!empty($usuarios_Precilla)) {
    echo '<h2>Precilla</h2>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Módulo</th>';
    echo '<th>Nombre de Usuario</th>';
    
    // Mostrar las fechas como encabezados de columnas
    if ($fecha_1 && $fecha_2) echo '<th>' . $fecha_1 . ' al ' . $fecha_2 . '</th>';
    if ($fecha_3 && $fecha_4) echo '<th>' . $fecha_3 . ' al ' . $fecha_4 . '</th>';
    if ($fecha_5 && $fecha_6) echo '<th>' . $fecha_5 . ' al ' . $fecha_6 . '</th>';
    if ($fecha_7 && $fecha_8) echo '<th>' . $fecha_7 . ' al ' . $fecha_8 . '</th>';
    
    echo '<th>Total</th>';
    echo '<th>Acciones</th>'; // Nueva columna para acciones
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($usuarios_Precilla as $Precilla) {
        $total = $Precilla['valor_1'] + $Precilla['valor_2'] + $Precilla['valor_3'] + $Precilla['valor_4'];

        echo '<tr>';
        echo '<td>' . $Precilla['modulo'] . '</td>';
        echo '<td>' . $Precilla['nombre_completo'] . '</td>';
        echo '<td>' . $Precilla['valor_1'] . '</td>'; // Columna para valor_1
        echo '<td>' . $Precilla['valor_2'] . '</td>'; // Columna para valor_2
        echo '<td>' . $Precilla['valor_3'] . '</td>'; // Columna para valor_3
        echo '<td>' . $Precilla['valor_4'] . '</td>'; // Columna para valor_4
        echo '<td>' . $total . '</td>'; // Columna para el total

        // Columna para acciones
        echo '<td>';
        echo '<a href="#">Editar</a> | ';
        echo '<a href="#">Eliminar</a> | ';
        echo '<a href="#">Detalles</a> | ';
        echo '<a href="#">Otra Acción</a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No hay usuarios tipo Precilla.</p>';
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

