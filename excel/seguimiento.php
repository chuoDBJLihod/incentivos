<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename = Seguimiento.xls");
?>
<?php
include "../config/conexion.php";

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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Semanal por Módulo</title>
    <!-- Incluir la librería de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
            margin: 0;
            text-align: center;
        }
        .form-container {
            display: inline-block;
            max-width: 100%;
            width: 90%;
            margin: 0 auto;
            overflow-x: auto;
            padding: 20px;
            box-sizing: border-box;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <center>
            <h2>Semana 1</h2>
            <?php if ($fecha_1 && $fecha_2): ?>
                <p>Incentivos del: <?php echo $fecha_1; ?> al <?php echo $fecha_2; ?></p>
            <?php else: ?>
                <p>No se encontraron fechas para el último registro.</p>
            <?php endif; ?>
        </center>

        <!-- Tabla para mostrar los valores semanales por módulo -->
        <table>
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener los módulos únicos, excluyendo el módulo 0
                $consulta_modulos = "SELECT DISTINCT modulo FROM usuario WHERE modulo != 0 ORDER BY modulo ASC";
                $resultado_modulos = $conexion->query($consulta_modulos);

                if ($resultado_modulos->num_rows > 0) {
                    while ($row_modulo = $resultado_modulos->fetch_assoc()) {
                        $modulo = $row_modulo['modulo'];

                        // Consulta para obtener incentivos y eficiencias diarios de la tabla incentivo1 para el módulo actual
                        $consulta_incentivos = "SELECT valor_lunes, valor_martes, valor_miercoles, valor_jueves, valor_viernes, valor_sabado, 
                                                eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, eficiencia_jueves, eficiencia_viernes, eficiencia_sabado
                                                FROM incentivo1 
                                                WHERE modulo = '$modulo' 
                                                ORDER BY fecha DESC LIMIT 1";
                        $resultado_incentivos = $conexion->query($consulta_incentivos);

                        // Variables para almacenar los valores de incentivos y eficiencia diarios
                        $valor_lunes = $valor_martes = $valor_miercoles = $valor_jueves = $valor_viernes = $valor_sabado = 0;
                        $eficiencia_lunes = $eficiencia_martes = $eficiencia_miercoles = $eficiencia_jueves = $eficiencia_viernes = $eficiencia_sabado = 0;

                        if ($resultado_incentivos->num_rows > 0) {
                            $row_incentivos = $resultado_incentivos->fetch_assoc();
                            $valor_lunes = $row_incentivos['valor_lunes'];
                            $valor_martes = $row_incentivos['valor_martes'];
                            $valor_miercoles = $row_incentivos['valor_miercoles'];
                            $valor_jueves = $row_incentivos['valor_jueves'];
                            $valor_viernes = $row_incentivos['valor_viernes'];
                            $valor_sabado = $row_incentivos['valor_sabado'];

                            $eficiencia_lunes = $row_incentivos['eficiencia_lunes'];
                            $eficiencia_martes = $row_incentivos['eficiencia_martes'];
                            $eficiencia_miercoles = $row_incentivos['eficiencia_miercoles'];
                            $eficiencia_jueves = $row_incentivos['eficiencia_jueves'];
                            $eficiencia_viernes = $row_incentivos['eficiencia_viernes'];
                            $eficiencia_sabado = $row_incentivos['eficiencia_sabado'];
                        }

                        // Calcular el total de incentivos de la semana
                        $total_incentivo = $valor_lunes + $valor_martes + $valor_miercoles + $valor_jueves + $valor_viernes + $valor_sabado;

                        // Mostrar la fila con los valores
                        ?>
                        <tr>
                            <td><?php echo $modulo; ?></td>
                            <td><?php echo number_format($eficiencia_lunes); ?></td>
                            <td><?php echo number_format($eficiencia_martes); ?></td>
                            <td><?php echo number_format($eficiencia_miercoles); ?></td>
                            <td><?php echo number_format($eficiencia_jueves); ?></td>
                            <td><?php echo number_format($eficiencia_viernes); ?></td>
                            <td><?php echo number_format($eficiencia_sabado); ?></td>
                            <td><?php echo number_format($total_incentivo); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modulo; ?></td>
                            <td><?php echo number_format($valor_lunes); ?></td>
                            <td><?php echo number_format($valor_martes); ?></td>
                            <td><?php echo number_format($valor_miercoles); ?></td>
                            <td><?php echo number_format($valor_jueves); ?></td>
                            <td><?php echo number_format($valor_viernes); ?></td>
                            <td><?php echo number_format($valor_sabado); ?></td>
                            <td><?php echo number_format($total_incentivo); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No se encontraron módulos registrados.</td></tr>";
                }

                 ?>
            </tbody>
        </table>
    </div>
 
<?php

$consulta_fechas = "SELECT fecha_3, fecha_4 FROM fechas_eventos ORDER BY fecha_3, fecha_4 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_3 = '';
$fecha_4 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_3 = $row_fechas['fecha_3'];
    $fecha_4 = $row_fechas['fecha_4'];
}
?>

    <div class="form-container">
        <center>
            <h2>Semana 2</h2>       
            <?php if ($fecha_3 && $fecha_4): ?>
                <p>Incentivos del: <?php echo $fecha_3; ?> al <?php echo $fecha_4; ?></p>
            <?php else: ?>
                <p>No se encontraron fechas para el último registro.</p>
            <?php endif; ?>
        </center>

        <!-- Tabla para mostrar los valores semanales por módulo -->
        <table>
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener los módulos únicos
                $consulta_modulos = "SELECT DISTINCT modulo FROM usuario WHERE modulo != 0 ORDER BY modulo ASC";
                $resultado_modulos = $conexion->query($consulta_modulos);

                if ($resultado_modulos->num_rows > 0) {
                    while ($row_modulo = $resultado_modulos->fetch_assoc()) {
                        $modulo = $row_modulo['modulo'];

                        // Consulta para obtener incentivos y eficiencias diarios de la tabla incentivo2 para el módulo actual
                        $consulta_incentivos = "SELECT valor_lunes, valor_martes, valor_miercoles, valor_jueves, valor_viernes, valor_sabado, 
                                                eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, eficiencia_jueves, eficiencia_viernes, eficiencia_sabado
                                                FROM incentivo2 
                                                WHERE modulo = '$modulo' 
                                                ORDER BY fecha DESC LIMIT 1";
                        $resultado_incentivos = $conexion->query($consulta_incentivos);

                        // Variables para almacenar los valores de incentivos y eficiencia diarios
                        $valor_lunes = $valor_martes = $valor_miercoles = $valor_jueves = $valor_viernes = $valor_sabado = 0;
                        $eficiencia_lunes = $eficiencia_martes = $eficiencia_miercoles = $eficiencia_jueves = $eficiencia_viernes = $eficiencia_sabado = 0;

                        if ($resultado_incentivos->num_rows > 0) {
                            $row_incentivos = $resultado_incentivos->fetch_assoc();
                            $valor_lunes = $row_incentivos['valor_lunes'];
                            $valor_martes = $row_incentivos['valor_martes'];
                            $valor_miercoles = $row_incentivos['valor_miercoles'];
                            $valor_jueves = $row_incentivos['valor_jueves'];
                            $valor_viernes = $row_incentivos['valor_viernes'];
                            $valor_sabado = $row_incentivos['valor_sabado'];

                            $eficiencia_lunes = $row_incentivos['eficiencia_lunes'];
                            $eficiencia_martes = $row_incentivos['eficiencia_martes'];
                            $eficiencia_miercoles = $row_incentivos['eficiencia_miercoles'];
                            $eficiencia_jueves = $row_incentivos['eficiencia_jueves'];
                            $eficiencia_viernes = $row_incentivos['eficiencia_viernes'];
                            $eficiencia_sabado = $row_incentivos['eficiencia_sabado'];
                        }

                        // Calcular el total de incentivos de la semana
                        $total_incentivo = $valor_lunes + $valor_martes + $valor_miercoles + $valor_jueves + $valor_viernes + $valor_sabado;
                        ?>
                        <tr>
                            <td><?php echo $modulo; ?></td>
                            <td><?php echo $eficiencia_lunes; ?></td>
                            <td><?php echo $eficiencia_martes; ?></td>
                            <td><?php echo $eficiencia_miercoles; ?></td>
                            <td><?php echo $eficiencia_jueves; ?></td>
                            <td><?php echo $eficiencia_viernes; ?></td>
                            <td><?php echo $eficiencia_sabado; ?></td>
                            <td><?php echo number_format($total_incentivo); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modulo; ?></td>
                            <td><?php echo number_format($valor_lunes); ?></td>
                            <td><?php echo number_format($valor_martes); ?></td>
                            <td><?php echo number_format($valor_miercoles); ?></td>
                            <td><?php echo number_format($valor_jueves); ?></td>
                            <td><?php echo number_format($valor_viernes); ?></td>
                            <td><?php echo number_format($valor_sabado); ?></td>
                            <td><?php echo number_format($total_incentivo); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No se encontraron módulos registrados.</td></tr>";
                }

                ?>
            </tbody>
        </table>

    </div>

<?php
$consulta_fechas = "SELECT fecha_5, fecha_6 FROM fechas_eventos ORDER BY fecha_5, fecha_6 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_5 = '';
$fecha_6 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_5 = $row_fechas['fecha_5'];
    $fecha_6 = $row_fechas['fecha_6'];
}
?>

    <div class="form-container">
        <center>
            <h2>Semana 3</h2>
            <?php if ($fecha_5 && $fecha_6): ?>
                <p>Incentivos del : <?php echo $fecha_5; ?> al <?php echo $fecha_6; ?></p>
            <?php else: ?>
                <p>No se encontraron fechas para el último registro.</p>
            <?php endif; ?>

        </center>

        <!-- Tabla para mostrar los valores semanales por módulo -->
        <table>
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener los módulos únicos
                $consulta_modulos = "SELECT DISTINCT modulo FROM usuario ORDER BY modulo ASC";
                $resultado_modulos = $conexion->query($consulta_modulos);

                if ($resultado_modulos->num_rows > 0) {
                    while ($row_modulo = $resultado_modulos->fetch_assoc()) {
                        $modulo = $row_modulo['modulo'];

                        // Consulta para obtener incentivos y eficiencias diarios de la tabla incentivo3 para el módulo actual
                        $consulta_incentivos = "SELECT valor_lunes, valor_martes, valor_miercoles, valor_jueves, valor_viernes, valor_sabado, 
                                                eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, eficiencia_jueves, eficiencia_viernes, eficiencia_sabado
                                                FROM incentivo3 
                                                WHERE modulo = '$modulo' 
                                                ORDER BY fecha DESC LIMIT 1";
                        $resultado_incentivos = $conexion->query($consulta_incentivos);

                        // Variables para almacenar los valores de incentivos y eficiencia diarios
                        $valor_lunes = $valor_martes = $valor_miercoles = $valor_jueves = $valor_viernes = $valor_sabado = 0;
                        $eficiencia_lunes = $eficiencia_martes = $eficiencia_miercoles = $eficiencia_jueves = $eficiencia_viernes = $eficiencia_sabado = 0;

                        if ($resultado_incentivos->num_rows > 0) {
                            $row_incentivos = $resultado_incentivos->fetch_assoc();
                            $valor_lunes = $row_incentivos['valor_lunes'];
                            $valor_martes = $row_incentivos['valor_martes'];
                            $valor_miercoles = $row_incentivos['valor_miercoles'];
                            $valor_jueves = $row_incentivos['valor_jueves'];
                            $valor_viernes = $row_incentivos['valor_viernes'];
                            $valor_sabado = $row_incentivos['valor_sabado'];

                            $eficiencia_lunes = $row_incentivos['eficiencia_lunes'];
                            $eficiencia_martes = $row_incentivos['eficiencia_martes'];
                            $eficiencia_miercoles = $row_incentivos['eficiencia_miercoles'];
                            $eficiencia_jueves = $row_incentivos['eficiencia_jueves'];
                            $eficiencia_viernes = $row_incentivos['eficiencia_viernes'];
                            $eficiencia_sabado = $row_incentivos['eficiencia_sabado'];
                        }

                        // Calcular el total de incentivos de la semana
                        $total_incentivo = $valor_lunes + $valor_martes + $valor_miercoles + $valor_jueves + $valor_viernes + $valor_sabado;

                        // Mostrar los datos
                        ?>
                        <tr>
                            <td><?php echo $modulo; ?></td>
                            <td><?php echo number_format($eficiencia_lunes); ?></td>
                            <td><?php echo number_format($eficiencia_martes); ?></td>
                            <td><?php echo number_format($eficiencia_miercoles); ?></td>
                            <td><?php echo number_format($eficiencia_jueves); ?></td>
                            <td><?php echo number_format($eficiencia_viernes); ?></td>
                            <td><?php echo number_format($eficiencia_sabado); ?></td>
                            <td><?php echo number_format($total_incentivo); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modulo; ?></td>
                            <td><?php echo number_format($valor_lunes); ?></td>
                            <td><?php echo number_format($valor_martes); ?></td>
                            <td><?php echo number_format($valor_miercoles); ?></td>
                            <td><?php echo number_format($valor_jueves); ?></td>
                            <td><?php echo number_format($valor_viernes); ?></td>
                            <td><?php echo number_format($valor_sabado); ?></td>
                            <td><?php echo number_format($total_incentivo); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No se encontraron módulos registrados.</td></tr>";
                }

                 ?>
            </tbody>
        </table>
    </div>


<?php
$consulta_fechas = "SELECT fecha_7, fecha_8 FROM fechas_eventos ORDER BY fecha_7, fecha_8 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_7 = '';
$fecha_8 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_7 = $row_fechas['fecha_7'];
    $fecha_8 = $row_fechas['fecha_8'];
}   
?>

<div class="form-container">
    <h2>Semana 4</h2>
    <?php if ($fecha_7 && $fecha_8): ?>
        <p>Incentivos del: <?php echo $fecha_7; ?> al <?php echo $fecha_8; ?></p>
    <?php else: ?>
        <p>No se encontraron fechas para el último registro.</p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
                <th>Sábado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $consulta_modulos = "SELECT DISTINCT modulo FROM usuario WHERE modulo != 0 ORDER BY modulo ASC";
                $resultado_modulos = $conexion->query($consulta_modulos);

            if ($resultado_modulos->num_rows > 0) {
                while ($row_modulo = $resultado_modulos->fetch_assoc()) {
                    $modulo = $row_modulo['modulo'];
                    $consulta_incentivos = "SELECT valor_lunes, valor_martes, valor_miercoles, valor_jueves, valor_viernes, valor_sabado, 
                                            eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, eficiencia_jueves, eficiencia_viernes, eficiencia_sabado
                                            FROM incentivo4 
                                            WHERE modulo = '$modulo' 
                                            ORDER BY fecha DESC LIMIT 1";
                    $resultado_incentivos = $conexion->query($consulta_incentivos);

                    $valor_lunes = $valor_martes = $valor_miercoles = $valor_jueves = $valor_viernes = $valor_sabado = 0;
                    $eficiencia_lunes = $eficiencia_martes = $eficiencia_miercoles = $eficiencia_jueves = $eficiencia_viernes = $eficiencia_sabado = 0;

                    if ($resultado_incentivos->num_rows > 0) {
                        $row_incentivos = $resultado_incentivos->fetch_assoc();
                        $valor_lunes = $row_incentivos['valor_lunes'];
                        $valor_martes = $row_incentivos['valor_martes'];
                        $valor_miercoles = $row_incentivos['valor_miercoles'];
                        $valor_jueves = $row_incentivos['valor_jueves'];
                        $valor_viernes = $row_incentivos['valor_viernes'];
                        $valor_sabado = $row_incentivos['valor_sabado'];

                        $eficiencia_lunes = $row_incentivos['eficiencia_lunes'];
                        $eficiencia_martes = $row_incentivos['eficiencia_martes'];
                        $eficiencia_miercoles = $row_incentivos['eficiencia_miercoles'];
                        $eficiencia_jueves = $row_incentivos['eficiencia_jueves'];
                        $eficiencia_viernes = $row_incentivos['eficiencia_viernes'];
                        $eficiencia_sabado = $row_incentivos['eficiencia_sabado'];
                    }

                    $total_incentivo = $valor_lunes + $valor_martes + $valor_miercoles + $valor_jueves + $valor_viernes + $valor_sabado;
                    ?>
                    <tr>
                        <td><?php echo $modulo; ?></td>
                        <td><?php echo number_format($eficiencia_lunes); ?></td>
                        <td><?php echo number_format($eficiencia_martes); ?></td>
                        <td><?php echo number_format($eficiencia_miercoles); ?></td>
                        <td><?php echo number_format($eficiencia_jueves); ?></td>
                        <td><?php echo number_format($eficiencia_viernes); ?></td>
                        <td><?php echo number_format($eficiencia_sabado); ?></td>
                        <td><?php echo number_format($total_incentivo); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $modulo; ?></td>
                        <td><?php echo number_format($valor_lunes); ?></td>
                        <td><?php echo number_format($valor_martes); ?></td>
                        <td><?php echo number_format($valor_miercoles); ?></td>
                        <td><?php echo number_format($valor_jueves); ?></td>
                        <td><?php echo number_format($valor_viernes); ?></td>
                        <td><?php echo number_format($valor_sabado); ?></td>
                        <td><?php echo number_format($total_incentivo); ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='8'>No se encontraron módulos registrados.</td></tr>";
            }

            ?>
        </tbody>
    </table>
</div>

<?php

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


echo '<style>';
echo 'body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f9; margin: 0; text-align: center; }';
echo '.form-container { display: inline-block; max-width: 100%; width: 90%; margin: 0 auto; overflow-x: auto; padding: 20px; box-sizing: border-box; }';
echo 'h2 { color: #333; text-align: center; }';
echo 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }';
echo 'th { background-color: #007BFF; color: white; }';
echo 'tr:nth-child(even) { background-color: #f2f2f2; }';
echo 'tr:hover { background-color: #ddd; }';
echo '</style>';
echo '<div class="form-container">';
echo '<h2>Incentivos Precilla</h2>';
echo '<h2>Semana 1</h2>';

if ($fecha_1 && $fecha_2): ?>
    <p>Incentivos del : <?php echo $fecha_1; ?> al <?php echo $fecha_2; ?></p>
<?php else: ?>
    <p>No se encontraron fechas para el último registro.</p>
<?php endif; ?>

<?php 
if ($result->num_rows > 0) {
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
        echo '<td>' . htmlspecialchars($row['eficiencia_lunes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_martes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_miercoles'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_jueves'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_viernes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_sabado'] ?? '') . '</td>';
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
} else {
    echo "<p>No se encontraron datos para usuarios tipo 'Precilla'.</p>";
}

echo '</div>';

?>

<?php
// Consulta para obtener la última fecha registrada
$consulta_fechas = "SELECT fecha_3, fecha_4 FROM fechas_eventos ORDER BY fecha_3, fecha_4 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_3 = '';
$fecha_4 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_3 = $row_fechas['fecha_3'];
    $fecha_4 = $row_fechas['fecha_4'];
}

// Consulta con LEFT JOIN para mostrar todos los usuarios "Precilla"
$query = "
    SELECT 
        usuario.id_usuario AS id_precilla2, 
        usuario.nombre_completo AS nombre_usuario,
        incentivop2.eficiencia, 
        incentivop2.eficiencia_lunes, 
        incentivop2.eficiencia_martes, 
        incentivop2.eficiencia_miercoles, 
        incentivop2.eficiencia_jueves, 
        incentivop2.eficiencia_viernes, 
        incentivop2.eficiencia_sabado,
        incentivop2.valor_lunes,
        incentivop2.valor_martes,
        incentivop2.valor_miercoles,
        incentivop2.valor_jueves,
        incentivop2.valor_viernes,
        incentivop2.valor_sabado
    FROM usuario
    LEFT JOIN incentivop2 ON usuario.id_usuario = incentivop2.id_usuario
    WHERE usuario.tipo_usuario = 'Precilla'
";

$result = $conexion->query($query);

echo '<div class="form-container">';
echo'<h2>Semana 2</h2>';       
?><?php if ($fecha_3 && $fecha_4): ?>
    <p>Incentivos del : <?php echo $fecha_3; ?> al <?php echo $fecha_4; ?></p>
<?php else: ?>
    <p>No se encontraron fechas para el último registro.</p>
<?php endif; ?><?php 
 if ($result->num_rows > 0) {
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
        echo '<td>' . htmlspecialchars($row['eficiencia_lunes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_martes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_miercoles'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_jueves'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_viernes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_sabado'] ?? '') . '</td>';
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
} else {
    echo "<p>No se encontraron datos para usuarios tipo 'Precilla'.</p>";
}

echo '</div>';


?>


<?php
// Consulta para obtener la última fecha registrada
$consulta_fechas = "SELECT fecha_5, fecha_6 FROM fechas_eventos ORDER BY fecha_5, fecha_6 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_5 = '';
$fecha_6 = '';

if ($resultado_fechas->num_rows > 0) {
    $row_fechas = $resultado_fechas->fetch_assoc();
    $fecha_5 = $row_fechas['fecha_5'];
    $fecha_6 = $row_fechas['fecha_6'];
}

// Consulta con LEFT JOIN para mostrar todos los usuarios "Precilla"
$query = "
    SELECT 
        usuario.id_usuario AS id_precilla3, 
        usuario.nombre_completo AS nombre_usuario,
        incentivop3.eficiencia, 
        incentivop3.eficiencia_lunes, 
        incentivop3.eficiencia_martes, 
        incentivop3.eficiencia_miercoles, 
        incentivop3.eficiencia_jueves, 
        incentivop3.eficiencia_viernes, 
        incentivop3.eficiencia_sabado,
        incentivop3.valor_lunes,
        incentivop3.valor_martes,
        incentivop3.valor_miercoles,
        incentivop3.valor_jueves,
        incentivop3.valor_viernes,
        incentivop3.valor_sabado
    FROM usuario
    LEFT JOIN incentivop3 ON usuario.id_usuario = incentivop3.id_usuario
    WHERE usuario.tipo_usuario = 'Precilla'
";

$result = $conexion->query($query);

echo '<div class="form-container">';
?>
            <h2>Semana 3</h2>
            <?php if ($fecha_5 && $fecha_6): ?>
                <p>Incentivos del : <?php echo $fecha_5; ?> al <?php echo $fecha_6; ?></p>
            <?php else: ?>
                <p>No se encontraron fechas para el último registro.</p>
            <?php endif; ?>
<?php 
 if ($result->num_rows > 0) {
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
        echo '<td>' . htmlspecialchars($row['eficiencia_lunes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_martes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_miercoles'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_jueves'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_viernes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_sabado'] ?? '') . '</td>';
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
} else {
    echo "<p>No se encontraron datos para usuarios tipo 'Precilla'.</p>";
}
  
echo '</div>';



?> 
<?php
// Consulta para obtener la última fecha registrada
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
;

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
        echo '<td>' . htmlspecialchars($row['eficiencia_lunes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_martes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_miercoles'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_jueves'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_viernes'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['eficiencia_sabado'] ?? '') . '</td>';
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
} else {
    echo "<p>No se encontraron datos para usuarios tipo 'Precilla'.</p>";
}

echo '</div>';


$conexion->close();
?>

 
</body>
</html>
