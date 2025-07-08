<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename = validar_pagos.xls");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            table-layout: fixed;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f5e9;
        }

        td {
            font-size: 14px;
        }

        .section-title {
            margin-top: 40px;
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
    <!-- Incluir la librería de SheetJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
</head>
<body>

    <a href="javascript:void(0);" class="btn" onclick="exportToExcel()">Validar pagos Excel</a>

    <?php
    // Incluir la conexión a la base de datos
    include "../config/conexion.php";
    // Consulta para obtener la última fecha registrada
    $consulta_fechas = "SELECT fecha_1, fecha_2, fecha_3, fecha_4, fecha_5, fecha_6, fecha_7, fecha_8 
                        FROM fechas_eventos ORDER BY fecha_1, fecha_2, fecha_3, fecha_4, fecha_5, fecha_6, fecha_7, fecha_8 DESC LIMIT 1";
    $resultado_fechas = $conexion->query($consulta_fechas);

    $fecha_1 = $fecha_2 = $fecha_3 = $fecha_4 = $fecha_5 = $fecha_6 = $fecha_7 = $fecha_8 = '';

    // Asignar las fechas si existen en la base de datos
    if ($resultado_fechas->num_rows > 0) {
        $row_fechas = $resultado_fechas->fetch_assoc();
        $fecha_1 = $row_fechas['fecha_1'];
        $fecha_2 = $row_fechas['fecha_2'];
        $fecha_3 = $row_fechas['fecha_3'];
        $fecha_4 = $row_fechas['fecha_4'];
        $fecha_5 = $row_fechas['fecha_5'];
        $fecha_6 = $row_fechas['fecha_6'];
        $fecha_7 = $row_fechas['fecha_7'];
        $fecha_8 = $row_fechas['fecha_8'];
    }
    // Consulta para obtener los usuarios
    $query = "SELECT id_usuario, nombre_completo, modulo, valor_1, valor_2, valor_3, valor_4, tipo_usuario 
              FROM usuario ORDER BY tipo_usuario ASC, modulo ASC";
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        $usuarios_precilla = [];
        $usuarios_modulares = [];
        $total_precilla = 0;
        $total_modulares = 0;

        // Procesar los usuarios
        while ($row = $result->fetch_assoc()) {
            $usuario = [
                'nombre' => $row['nombre_completo'],
                'valor_1' => $row['valor_1'],
                'valor_2' => $row['valor_2'],
                'valor_3' => $row['valor_3'],
                'valor_4' => $row['valor_4'],
                'total' => $row['valor_1'] + $row['valor_2'] + $row['valor_3'] + $row['valor_4']
            ];

            // Clasificar por tipo de usuario
            if ($row['tipo_usuario'] == 'Precilla') {
                $usuarios_precilla[] = $usuario;
                $total_precilla += $usuario['total'];
            } else {
                $usuarios_modulares[] = $usuario;
                $total_modulares += $usuario['total'];
            }
        }

        // Mostrar usuarios Precilla
        echo '<div class="section-title">Usuarios Precilla</div>';
        echo '<table id="table_precilla">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nombre de Usuario</th>';
        if ($fecha_1 && $fecha_2)
            echo '<th>' . $fecha_1 . ' al ' . $fecha_2 . '</th>';
        if ($fecha_3 && $fecha_4)
            echo '<th>' . $fecha_3 . ' al ' . $fecha_4 . '</th>';
        if ($fecha_5 && $fecha_6)
            echo '<th>' . $fecha_5 . ' al ' . $fecha_6 . '</th>';
        if ($fecha_7 && $fecha_8)
            echo '<th>' . $fecha_7 . ' al ' . $fecha_8 . '</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($usuarios_precilla as $usuario) {
            echo '<tr>';
            echo '<td>' . $usuario['nombre'] . '</td>';
            echo '<td>' . $usuario['valor_1'] . '</td>';
            echo '<td>' . $usuario['valor_2'] . '</td>';
            echo '<td>' . $usuario['valor_3'] . '</td>';
            echo '<td>' . $usuario['valor_4'] . '</td>';
            echo '<td>' . $usuario['total'] . '</td>';
            echo '</tr>';
        }

        // Fila para el subtotal de los Precilla
        echo '<tr class="total-row">';
        echo '<td colspan="5">Subtotal de Precilla</td>';
        echo '<td>' . $total_precilla . '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';

        // Mostrar usuarios Modulares
        echo '<div class="section-title">Usuarios Modulares</div>';
        echo '<table id="table_modulares">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nombre de Usuario</th>';
        if ($fecha_1 && $fecha_2)
            echo '<th>' . $fecha_1 . ' al ' . $fecha_2 . '</th>';
        if ($fecha_3 && $fecha_4)
            echo '<th>' . $fecha_3 . ' al ' . $fecha_4 . '</th>';
        if ($fecha_5 && $fecha_6)
            echo '<th>' . $fecha_5 . ' al ' . $fecha_6 . '</th>';
        if ($fecha_7 && $fecha_8)
            echo '<th>' . $fecha_7 . ' al ' . $fecha_8 . '</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($usuarios_modulares as $usuario) {
            echo '<tr>';
            echo '<td>' . $usuario['nombre'] . '</td>';
            echo '<td>' . $usuario['valor_1'] . '</td>';
            echo '<td>' . $usuario['valor_2'] . '</td>';
            echo '<td>' . $usuario['valor_3'] . '</td>';
            echo '<td>' . $usuario['valor_4'] . '</td>';
            echo '<td>' . $usuario['total'] . '</td>';
            echo '</tr>';
        }

        // Fila para el subtotal de los Modulares
        echo '<tr class="total-row">';
        echo '<td colspan="5">Subtotal de Modulares</td>';
        echo '<td>' . $total_modulares . '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';

        // Fila para el total general
        $total_general = $total_precilla + $total_modulares;
        echo '<div class="total-row">';
        echo '<p><strong>Total de los Totales: ' . $total_general . '</strong></p>';
        echo '</div>';
    }

    $conexion->close();
    ?>

    <script>
        function exportToExcel() {
            const wb = XLSX.utils.book_new();
            const table_precilla = document.getElementById('table_precilla');
            const table_modulares = document.getElementById('table_modulares');
            
            // Convertir tablas HTML a hojas de Excel
            const ws_precilla = XLSX.utils.table_to_sheet(table_precilla);
            const ws_modulares = XLSX.utils.table_to_sheet(table_modulares);

            // Aplicar estilos a las hojas (colores, bordes, etc.)
            const headerStyle = {
                font: { bold: true },
                fill: { fgColor: { rgb: "4CAF50" } },
                alignment: { horizontal: "center" }
            };

            // Aplicar estilo a las celdas de los encabezados de ambas hojas
            const range_precilla = XLSX.utils.decode_range(ws_precilla['!ref']);
            const range_modulares = XLSX.utils.decode_range(ws_modulares['!ref']);
            for (let i = range_precilla.s.c; i <= range_precilla.e.c; i++) {
                ws_precilla[XLSX.utils.encode_cell({ r: range_precilla.s.r, c: i })].s = headerStyle;
            }
            for (let i = range_modulares.s.c; i <= range_modulares.e.c; i++) {
                ws_modulares[XLSX.utils.encode_cell({ r: range_modulares.s.r, c: i })].s = headerStyle;
            }

            // Añadir hojas al libro
            XLSX.utils.book_append_sheet(wb, ws_precilla, "Precilla");
            XLSX.utils.book_append_sheet(wb, ws_modulares, "Modulares");

            // Descargar el archivo Excel
            XLSX.writeFile(wb, "usuarios_validacion.xlsx");
        }
    </script>
</body>
</html>
