<?php
include "../config/conexion.php";
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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Semanal por Módulo</title>
    <link rel="stylesheet" href="../assets/css/.css">
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
    input[type="number"] {
        width: 80%;
        padding: 5px;
        margin: 5px 0;
        border: none;
        text-align: center;
        background-color: transparent;
        font-size: 16px;
        color: #000;
        outline: none;
    }
    input[type="number"]:focus {
        border-bottom: 1px solid #007BFF;
        background-color: #f9f9f9;
        transition: background-color 0.3s ease;
    }
    input[type="number"]::placeholder {
        color: #aaa;
        opacity: 0.7;
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
    .form-group {
        text-align: center;
        margin-top: 20px;
    }
    .form-group button {
        display: inline-block;
        margin: 0 10px;
    }
</style>
</head>

<body>

    <div class="form-container">
        <center>
            <h2>Semana 4</h2>
            <?php if ($fecha_7 && $fecha_8): ?>
                <p>Incentivos del : <?php echo $fecha_7; ?> al <?php echo $fecha_8; ?></p>
            <?php else: ?>
                <p>No se encontraron fechas para el último registro.</p>
            <?php endif; ?>
        </center>

        <form id="registroForm" action="../controller/guardar_registro4.php" method="POST">
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