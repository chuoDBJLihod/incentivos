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

// Consulta para obtener los usuarios por módulo (excluyendo a los de tipo Precilla)
$query = "SELECT id_usuario, nombre_completo, modulo, valor_1, valor_2, valor_3, valor_4, tipo_usuario FROM usuario ORDER BY modulo ASC";
$result = $conexion->query($query);
include '../includes/header.php';

echo '<style>
        body {
            font-family: "Roboto", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
            font-weight: 700;
        }
        a {
            text-decoration: none;
        }
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            table-layout: fixed;
        }
        th, td {
            padding: 9px 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        /* Ancho para las columnas regulares */
        th:not(:last-child), td:not(:last-child) {
            width: calc(100% / 7); /* Ajuste proporcional para las otras columnas */
        }
        /* Ancho doble para la columna de Acciones */
        th:last-child, td:last-child {
            width: calc(100% / 7 * 2); /* Doble ancho para la última columna */
        }
        th {
            background-color: #34495e;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e1f5fe;
            transition: background-color 0.3s ease;
        }
        input[type="number"] {
            width: 80px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            text-align: center;
        }
        input[type="submit"] {
            background-color: #1abc9c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px auto;
            display: block;
            text-transform: uppercase;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #16a085;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            font-size: 14px;
            color: #fff;
            border-radius: 4px;
            margin: 5px;
            text-align: center;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }
        .btn-success {
            background-color: #27ae60;
        }
        .btn-success:hover {
            background-color: #219150;
        }
        .btn-info {
            background-color: #2980b9;
        }
        .btn-info:hover {
            background-color: #21618c;
        }
        .btn-danger {
            background-color: #e74c3c;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .action-icons {
             flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        @media (max-width: 768px) {
            table, th, td {
                font-size: 12px;
            }
            input[type="number"] {
                width: 60px;
            }
            .btn {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
      </style>';
?>


<br>
<a href="../excel/tabla_pagos.php" class="btn btn-success">Validar pagos excel</a>
<a href="../excel/seguimiento.php" class="btn btn-success">Tablas de seguimiento</a>
<a href="cambiar_modulo.php" class="btn btn-success">Cambiar usuarios de módulo</a>
<br>
<?php
echo '<h2>Modulares</h2>';

if ($result->num_rows > 0) {
    echo '<form action="../controller/procesar_registroi.php" method="POST">';
    // Crear un array para almacenar los usuarios del módulo 0
    $modulo_0 = [];

    // Crear un array para almacenar usuarios por módulo
    $modulos = [];

    // Procesar los usuarios
    while ($row = $result->fetch_assoc()) {
        $modulo = $row['modulo'];
        $nombre = $row['nombre_completo'];
        $id_usuario = $row['id_usuario'];
        $tipo_usuario = $row['tipo_usuario'];
        $valor_1 = $row['valor_1'];
        $valor_2 = $row['valor_2'];
        $valor_3 = $row['valor_3'];
        $valor_4 = $row['valor_4'];

        // Si es del módulo 0, agregar al array $modulo_0
        if ($modulo == 0) {
            $modulo_0[] = [
                'nombre' => $nombre,
                'id_usuario' => $id_usuario,
                'tipo_usuario' => $tipo_usuario,
                'valor_1' => $valor_1,
                'valor_2' => $valor_2,
                'valor_3' => $valor_3,
                'valor_4' => $valor_4
            ];
        } else {
            // Si no es del módulo 0, agregar al array $modulos
            $modulos[$modulo][] = [
                'nombre' => $nombre,
                'id_usuario' => $id_usuario,
                'tipo_usuario' => $tipo_usuario,
                'valor_1' => $valor_1,
                'valor_2' => $valor_2,
                'valor_3' => $valor_3,
                'valor_4' => $valor_4
            ];
        }
    }

    // Ordenar los módulos en orden ascendente
    ksort($modulos);

    // Variable para controlar si es la primera tabla
    $esPrimeraTabla = true;

    // Mostrar los módulos
    foreach ($modulos as $modulo => $usuarios) {
        echo '<table>';
        
        // Mostrar el encabezado solo en la primera tabla
        if ($esPrimeraTabla) {
            echo '<thead>';
            echo '<tr>';
            echo '<th>Módulo</th>';
            echo '<th>Nombre de Usuario</th>';

            // Mostrar las fechas si están disponibles
            if ($fecha_1 && $fecha_2)
                echo '<th>' . $fecha_1 . ' al ' . $fecha_2 . '</th>';
            if ($fecha_3 && $fecha_4)
                echo '<th>' . $fecha_3 . ' al ' . $fecha_4 . '</th>';
            if ($fecha_5 && $fecha_6)
                echo '<th>' . $fecha_5 . ' al ' . $fecha_6 . '</th>';
            if ($fecha_7 && $fecha_8)
                echo '<th>' . $fecha_7 . ' al ' . $fecha_8 . '</th>';

            echo '<th>Total</th>';
            echo '<th>Acciones</th>';  // Nueva columna para acciones
            echo '</tr>';
            echo '</thead>';
            $esPrimeraTabla = false; // Cambiar a false después de la primera tabla
        }

        echo '<tbody>';

        foreach ($usuarios as $usuario) {
            $nombre = $usuario['nombre'];
            $id_usuario = $usuario['id_usuario'];
            $valor_1 = $usuario['valor_1'];
            $valor_2 = $usuario['valor_2'];
            $valor_3 = $usuario['valor_3'];
            $valor_4 = $usuario['valor_4'];

            echo '<tr>';
            echo '<td>' . $modulo . '</td>';
            echo '<td>' . $nombre . '</td>';
            $valor_total = $valor_1 + $valor_2 + $valor_3 + $valor_4;

            // Inputs para los valores
            echo '<td><input type="number" name="valor_1[' . $id_usuario . ']" value="' . $valor_1 . '"></td>';
            echo '<td><input type="number" name="valor_2[' . $id_usuario . ']" value="' . $valor_2 . '"></td>';
            echo '<td><input type="number" name="valor_3[' . $id_usuario . ']" value="' . $valor_3 . '"></td>';
            echo '<td><input type="number" name="valor_4[' . $id_usuario . ']" value="' . $valor_4 . '"></td>';
            echo '<td>' . $valor_total . '</td>'; // Columna para el total
            echo '<td>';
            echo '<div class="action-icons">';
            echo '<a href="../controller/agregar_modulo.php?id_usuario=' . $id_usuario . '&modulo=' . $modulo . '" class="btn btn-success">Modular</a>';
            echo '<a href="../controller/agregar_usuario.php?id_usuario=' . $id_usuario . '&modulo=' . $modulo . '" class="btn btn-info">Usuario</a>';
            echo '<a href="../controller/seleccion.php?id_usuario=' . $id_usuario . '" class="btn btn-danger">Selección</a>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
 


    // Mostrar tabla de usuarios del módulo 0
// Mostrar tabla de usuarios del módulo 0
    if (!empty($modulo_0)) {
        echo '<h2>Precilla</h2>';
        echo '<table>';
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
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($modulo_0 as $usuario) {
            $nombre = $usuario['nombre'];
            $id_usuario = $usuario['id_usuario'];
            $valor_1 = $usuario['valor_1'];
            $valor_2 = $usuario['valor_2'];
            $valor_3 = $usuario['valor_3'];
            $valor_4 = $usuario['valor_4'];

            $valor_total = $valor_1 + $valor_2 + $valor_3 + $valor_4;

            echo '<tr>';
            echo '<td>' . $nombre . '</td>';

            // Agregar inputs para editar valores dinámicamente
            echo '<td><input type="number" name="valor_1[' . $id_usuario . ']" value="' . $valor_1 . '"></td>';
            echo '<td><input type="number" name="valor_2[' . $id_usuario . ']" value="' . $valor_2 . '"></td>';
            echo '<td><input type="number" name="valor_3[' . $id_usuario . ']" value="' . $valor_3 . '"></td>';
            echo '<td><input type="number" name="valor_4[' . $id_usuario . ']" value="' . $valor_4 . '"></td>';
            echo '<td>' . $valor_total . '</td>';
            // Agregar acciones específicas
            echo '<td>';
            echo '<div class="action-icons">';
            echo '<a href="../controller/agregar_modulo.php?id_usuario=' . $id_usuario . '&modulo=0" class="btn btn-success">Modular</a>';
            echo '<a href="../controller/agregar_usuario.php?id_usuario=' . $id_usuario . '&modulo=0" class="btn btn-info">Usuario</a>';
            echo '<a href="../controller/seleccion.php?id_usuario=' . $id_usuario . '" class="btn btn-danger">Selección</a>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    echo '<input type="submit" value="Actualizar Incentivos">';
    echo'<center> <button type="button" onclick="reiniciarValores()" class="btn btn-danger">Reiniciar Valores</button></center>';
 
    echo '</form>';
    
}
echo'

';
include '../includes/footer.php';
// Cerrar la conexión a la base de datos
$conexion->close();
?>
<script>
    function reiniciarValores() {
        // Seleccionar todos los inputs tipo número dentro del formulario
        const inputs = document.querySelectorAll('form input[type="number"]');
        inputs.forEach(input => {
            input.value = 0; // Reiniciar el valor de cada input a cero
        });
    }
</script>