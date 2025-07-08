<?php
include '../config/conexion.php';

// Función para calcular el incentivo basado en la eficiencia
function calcularIncentivo($eficiencia)
{
    if ($eficiencia >= 70 && $eficiencia < 80) {
        return 4000;
    } elseif ($eficiencia >= 80 && $eficiencia < 90) {
        return 5000;
    } elseif ($eficiencia >= 90 && $eficiencia < 100) {
        return 6000;
    } elseif ($eficiencia == 100) {
        return 7000;
    } elseif ($eficiencia > 100) {
        return 7000 + ($eficiencia - 100) * 450;
    } else {
        return 0;
    }
}

// Validar y procesar cada día ingresado en el formulario
foreach ($_POST as $day => $values) {
    foreach ($values as $id_precilla3 => $eficiencia) {
        // Escapar y validar valores
        $day_column = htmlspecialchars($day);
        $id_precilla3 = (int) $id_precilla3;
        $eficiencia = (int) $eficiencia;

        // Calcular el incentivo basado en la eficiencia ingresada
        $incentivo = calcularIncentivo($eficiencia);

        // Determinar la columna de incentivo correspondiente al día
        $valor_column = str_replace('eficiencia', 'valor', $day_column);

        // Validar que el día ingresado sea un campo correcto
        $valid_columns = [
            'eficiencia_lunes', 'eficiencia_martes', 'eficiencia_miercoles',
            'eficiencia_jueves', 'eficiencia_viernes', 'eficiencia_sabado'
        ];

        if (in_array($day_column, $valid_columns)) {
            // Comprobar si el registro ya existe
            $check_query = "SELECT * FROM incentivop3 WHERE id_usuario = $id_precilla3";
            $result = $conexion->query($check_query);

            if ($result->num_rows > 0) {
                // Si el registro existe, actualiza el campo de eficiencia e incentivo correspondiente
                $update_query = "UPDATE incentivop3 SET $day_column = $eficiencia, $valor_column = $incentivo WHERE id_usuario = $id_precilla3";
                $conexion->query($update_query);
            } else {
                // Si el registro no existe, inserta un nuevo registro con los valores de eficiencia e incentivo
                $insert_query = "INSERT INTO incentivop3 (id_usuario, $day_column, $valor_column) VALUES ($id_precilla3, $eficiencia, $incentivo)";
                $conexion->query($insert_query);
            }
        }
    }
}

// Calcular el total de incentivo semanal para cada usuario y actualizar la columna `valor`
$users_query = "SELECT id_usuario FROM incentivop3";
$users_result = $conexion->query($users_query);

if ($users_result->num_rows > 0) {
    while ($user = $users_result->fetch_assoc()) {
        $id_usuario = (int)$user['id_usuario'];

        // Calcular la suma total de incentivos semanales
        $total_query = "
            SELECT 
                COALESCE(SUM(valor_lunes), 0) +
                COALESCE(SUM(valor_martes), 0) +
                COALESCE(SUM(valor_miercoles), 0) +
                COALESCE(SUM(valor_jueves), 0) +
                COALESCE(SUM(valor_viernes), 0) +
                COALESCE(SUM(valor_sabado), 0) AS total_incentivo
            FROM incentivop3
            WHERE id_usuario = $id_usuario
        ";

        $total_result = $conexion->query($total_query);
        $total_row = $total_result->fetch_assoc();
        $total_incentivo = (int)$total_row['total_incentivo'];

        // Actualizar la columna `valor` con el total calculado
        $update_total_query = "UPDATE incentivop3 SET valor = $total_incentivo WHERE id_usuario = $id_usuario";
        $conexion->query($update_total_query);

                // Actualizar la columna `valor_1` en usuario
                $update_usuario_query = "UPDATE usuario SET valor_3 = $total_incentivo WHERE id_usuario = $id_usuario";
                $conexion->query($update_usuario_query);
    }
}

header("Location: ../views/registerp.php");
exit();
?>
