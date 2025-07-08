<?php
// Conexión a la base de datos
include '../config/conexion.php';

// Consulta para obtener la última fecha registrada
$consulta_fechas = "SELECT fecha_1, fecha_2 FROM fechas_eventos ORDER BY fecha_1, fecha_2 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_1 = '';
$fecha_2 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_1 = $row_fechas['fecha_1'];
    $fecha_2 = $row_fechas['fecha_2'];
}

// Consulta con LEFT JOIN para mostrar todos los usuarios "Precilla"
$query = "
    SELECT 
        usuario.id_usuario AS id_precilla, 
        usuario.nombre_completo AS nombre_usuario,
        incentivop.eficiencia, 
        incentivop.eficiencia_lunes, 
        incentivop.eficiencia_martes, 
        incentivop.eficiencia_miercoles, 
        incentivop.eficiencia_jueves, 
        incentivop.eficiencia_viernes, 
        incentivop.eficiencia_sabado,
        incentivop.valor_lunes,
        incentivop.valor_martes,
        incentivop.valor_miercoles,
        incentivop.valor_jueves,
        incentivop.valor_viernes,
        incentivop.valor_sabado
    FROM usuario
    LEFT JOIN incentivop ON usuario.id_usuario = incentivop.id_usuario
    WHERE usuario.tipo_usuario = 'Precilla'
";

$result = $conexion->query($query);

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Registro de Incentivos</title>';
echo '</head>';
echo '<body>';
 include "../includes/header.php"; 
 echo '<style>';
echo 'body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f9; margin: 0; text-align: center; }';
echo '.form-container { display: inline-block; max-width: 100%; width: 90%; margin: 0 auto; overflow-x: auto; padding: 20px; box-sizing: border-box; }';
echo 'h2 { color: #333; text-align: center; }';
echo 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }';
echo 'th { background-color: #007BFF; color: white; }';
echo 'tr:nth-child(even) { background-color: #f2f2f2; }';
echo 'tr:hover { background-color: #ddd; }';
echo 'input[type="number"] { width: 80%; padding: 5px; margin: 5px 0; border: none; text-align: center; background-color: transparent; font-size: 16px; color: #000; outline: none; }';
echo 'input[type="number"]:focus { border-bottom: 1px solid #007BFF; background-color: #f9f9f9; transition: background-color 0.3s ease; }';
echo 'input[type="number"]::placeholder { color: #aaa; opacity: 0.7; }';
echo 'button { padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer; border-radius: 5px; }';
echo 'button:hover { background-color: #45a049; }';
echo '.form-group { text-align: center; margin-top: 20px; }';
echo '</style>';
 echo '<div class="form-container">';
echo '<h2>Incentivos Precilla</h2>';
echo'<h2>Semana 1</h2>'
?> <?php if ($fecha_1 && $fecha_2): ?>
    <p>Incentivos del : <?php echo $fecha_1; ?> al <?php echo $fecha_2; ?></p>
<?php else: ?>
    <p>No se encontraron fechas para el último registro.</p>
<?php endif; ?>
<?php 
if ($result->num_rows > 0) {
    echo '<form action="../controller/procesar_incentivosp.php" method="POST">';
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
        echo '<td><input type="number" name="eficiencia_lunes[' . $row['id_precilla'] . ']" value="' . htmlspecialchars($row['eficiencia_lunes'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_martes[' . $row['id_precilla'] . ']" value="' . htmlspecialchars($row['eficiencia_martes'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_miercoles[' . $row['id_precilla'] . ']" value="' . htmlspecialchars($row['eficiencia_miercoles'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_jueves[' . $row['id_precilla'] . ']" value="' . htmlspecialchars($row['eficiencia_jueves'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_viernes[' . $row['id_precilla'] . ']" value="' . htmlspecialchars($row['eficiencia_viernes'] ?? '') . '"></td>';
        echo '<td><input type="number" name="eficiencia_sabado[' . $row['id_precilla'] . ']" value="' . htmlspecialchars($row['eficiencia_sabado'] ?? '') . '"></td>';
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
include 'registerp2.php';
include 'registerp3.php';
include 'registerp4.php';

include'../includes/footer.php';

echo '</body>';
echo '</html>';

 ?>


 