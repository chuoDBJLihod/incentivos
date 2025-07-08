<?php
include "../config/conexion.php";
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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Semanal por Módulo</title>
    <link rel="stylesheet" href="../assets/css/.css">
    <!-- Incluir la librería de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="form-container">
        <center>
            <h2>Semana 2</h2>
            <?php if ($fecha_3 && $fecha_4): ?>
                <p>Incentivos del : <?php echo $fecha_3; ?> al <?php echo $fecha_4; ?></p>
            <?php else: ?>
                <p>No se encontraron fechas para el último registro.</p>
            <?php endif; ?>
        </center>

        <form id="registroForm" action="../controller/guardar_registro2.php" method="POST">
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
                    // Consulta modificada para ordenar módulos numéricamente
                    $consulta_modulos = "SELECT DISTINCT modulo FROM usuario WHERE modulo != '0' ORDER BY CAST(modulo AS SIGNED) ASC";
                    $resultado_modulos = $conexion->query($consulta_modulos);

                    if ($resultado_modulos->num_rows > 0) {
                        while ($row_modulo = $resultado_modulos->fetch_assoc()) {
                            $modulo = $row_modulo['modulo'];

                            $consulta_incentivos = "SELECT valor_lunes, valor_martes, valor_miercoles, valor_jueves, valor_viernes, valor_sabado, 
                                                    eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, eficiencia_jueves, eficiencia_viernes, eficiencia_sabado
                                                    FROM incentivo2 
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
                                <td><input type="number" name="lunes[<?php echo $modulo; ?>][]" placeholder="0"
                                        value="<?php echo $eficiencia_lunes; ?>"></td>
                                <td><input type="number" name="martes[<?php echo $modulo; ?>][]" placeholder="0"
                                        value="<?php echo $eficiencia_martes; ?>"></td>
                                <td><input type="number" name="miercoles[<?php echo $modulo; ?>][]" placeholder="0"
                                        value="<?php echo $eficiencia_miercoles; ?>"></td>
                                <td><input type="number" name="jueves[<?php echo $modulo; ?>][]" placeholder="0"
                                        value="<?php echo $eficiencia_jueves; ?>"></td>
                                <td><input type="number" name="viernes[<?php echo $modulo; ?>][]" placeholder="0"
                                        value="<?php echo $eficiencia_viernes; ?>"></td>
                                <td><input type="number" name="sabado[<?php echo $modulo; ?>][]" placeholder="0"
                                        value="<?php echo $eficiencia_sabado; ?>"></td>
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

                    $conexion->close();
                    ?>
                </tbody>
            </table>

            <div class="form-group">
                <button type="submit">Guardar Registro</button>
                <button type="submit" onclick="reiniciarFormulario()">Reiniciar</button>
            </div>
        </form>
    </div>

</body>

</html>