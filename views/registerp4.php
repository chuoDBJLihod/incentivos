<?php
// Conexión a la base de datos
include '../config/conexion.php';
$consulta_fechas = "SELECT fecha_7, fecha_8 FROM fechas_eventos ORDER BY fecha_7, fecha_8 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_7 = '';
$fecha_8 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_7 = $row_fechas['fecha_7'];
    $fecha_8 = $row_fechas['fecha_8'];
}   
// Consulta con LEFT JOIN para mostrar todos los usuarios "Precilla"
$query = "
    SELECT 
        usuario.id_usuario AS id_precilla4, 
        usuario.nombre_completo AS nombre_usuario,
        incentivop4.eficiencia, 
        incentivop4.eficiencia_lunes, 
        incentivop4.eficiencia_martes, 
        incentivop4.eficiencia_miercoles, 
        incentivop4.eficiencia_jueves, 
        incentivop4.eficiencia_viernes, 
        incentivop4.eficiencia_sabado,
        incentivop4.valor_lunes,
        incentivop4.valor_martes,
        incentivop4.valor_miercoles,
        incentivop4.valor_jueves,
        incentivop4.valor_viernes,
        incentivop4.valor_sabado
    FROM usuario
    LEFT JOIN incentivop4 ON usuario.id_usuario = incentivop4.id_usuario
    WHERE usuario.tipo_usuario = 'Precilla'
";

$result = $conexion->query($query);

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Registro de Incentivos</title>';
echo '<style>';
// estilos omitidos para simplicidad
echo '</style>';
echo '</head>';
echo '<body>';

echo '<div class="form-container">';
?>
    <h2>Semana 4</h2>
    <?php if ($fecha_7 && $fecha_8): ?>
        <p>Incentivos del: <?php echo $fecha_7; ?> al <?php echo $fecha_8; ?></p>
    <?php else: ?>
        <p>No se encontraron fechas para el último registro.</p>
    <?php endif; ?>
<?php 
 if ($result->num_rows > 0) {
    echo '<form action="../controller/procesar_incentivosp4.php" method="POST">';
    echo '<table>';
    echo '<tr>';
    echo '<th>Nombre</th>';
    echo '<th>Lunes</th>';
    echo '<th>Martes</th>';
    echo '<th>Miércoles</th>';
    echo '<th>Jueves</th>';
    echo '<th>Viernes</th>';
    echo '<th>Sábado</th>';
    echo '<th>Total</th>';
    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada usuario con sus datos
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['nombre_usuario']) . '</td>';
        echo '<td><input type="number" name="eficiencia_lunes[' . $row['id_precilla4'] . ']" value="' . htmlspecialchars($row['eficiencia_lunes'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_martes[' . $row['id_precilla4'] . ']" value="' . htmlspecialchars($row['eficiencia_martes'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_miercoles[' . $row['id_precilla4'] . ']" value="' . htmlspecialchars($row['eficiencia_miercoles'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_jueves[' . $row['id_precilla4'] . ']" value="' . htmlspecialchars($row['eficiencia_jueves'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_viernes[' . $row['id_precilla4'] . ']" value="' . htmlspecialchars($row['eficiencia_viernes'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_sabado[' . $row['id_precilla4'] . ']" value="' . htmlspecialchars($row['eficiencia_sabado'] ?? '') . '"></td>';
        echo '<td></td>'; // Columna vacía para total de incentivo
        echo '</tr>';

        // Calcular el total de incentivo para la semana
        $total_incentivo = ($row['valor_lunes'] ?? 0) + ($row['valor_martes'] ?? 0) + ($row['valor_miercoles'] ?? 0) + ($row['valor_jueves'] ?? 0) + ($row['valor_viernes'] ?? 0) + ($row['valor_sabado'] ?? 0);

        // Fila de valores de incentivo
        echo '<tr>';
        echo '<td>Valor Incentivo</td>';
        echo '<td>' . htmlspecialchars($row['valor_lunes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['valor_martes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['valor_miercoles'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['valor_jueves'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['valor_viernes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['valor_sabado'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($total_incentivo) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    echo '<div class="form-group">';
    echo '<button type="submit">Guardar Cambios</button>';
    echo '</div>';
    echo '</form>';
} else {
    echo "<p>No se encontraron datos para usuarios tipo 'Precilla'.</p>";
}

echo '</div>';
echo '</body>';
echo '</html>';

$conexion->close();
?>
