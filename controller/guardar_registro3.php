<?php
include "../config/conexion.php";

// Parámetros base para calcular el incentivo
$base_eficiencia = 70;
$base_valor = 2750;
$valor_porcentaje = 550;

// Función para calcular el incentivo por día
function calcular_incentivo($eficiencia, $base_eficiencia, $base_valor, $valor_porcentaje) {
    if ($eficiencia >= $base_eficiencia) {
        return $base_valor + (($eficiencia - $base_eficiencia) * $valor_porcentaje);
    } else {
        return 0; // Incentivo 0 si la eficiencia es menor a 70%
    }
}

// Obtener los valores enviados por el formulario
$lunes = $_POST['lunes'];
$martes = $_POST['martes'];
$miercoles = $_POST['miercoles'];
$jueves = $_POST['jueves'];
$viernes = $_POST['viernes'];
$sabado = $_POST['sabado'];

foreach ($lunes as $modulo => $dias) {

    // Eliminar el registro anterior para este módulo si existe
    $consulta_eliminar = "DELETE FROM incentivo3 WHERE modulo = '$modulo'";
    $conexion->query($consulta_eliminar); // Ejecuta la consulta de eliminación

    // Datos de eficiencia e incentivos para todos los días
    $eficiencia_lunes = $dias[0];
    $eficiencia_martes = $martes[$modulo][0];
    $eficiencia_miercoles = $miercoles[$modulo][0];
    $eficiencia_jueves = $jueves[$modulo][0];
    $eficiencia_viernes = $viernes[$modulo][0];
    $eficiencia_sabado = $sabado[$modulo][0];

    $total_incentivo = 0;
    $total_eficiencia = 0;
    $dias_con_incentivo = 0;

    // Sumar los incentivos por día (lunes a sábado)
    for ($i = 0; $i < count($dias); $i++) {
        // Convertir las entradas a números
        $lunes_val = floatval($lunes[$modulo][$i]);
        $martes_val = floatval($martes[$modulo][$i]);
        $miercoles_val = floatval($miercoles[$modulo][$i]);
        $jueves_val = floatval($jueves[$modulo][$i]);
        $viernes_val = floatval($viernes[$modulo][$i]);
        $sabado_val = floatval($sabado[$modulo][$i]);

        // Calcular incentivos para cada día
        $incentivo_lunes = calcular_incentivo($lunes_val, $base_eficiencia, $base_valor, $valor_porcentaje);
        $incentivo_martes = calcular_incentivo($martes_val, $base_eficiencia, $base_valor, $valor_porcentaje);
        $incentivo_miercoles = calcular_incentivo($miercoles_val, $base_eficiencia, $base_valor, $valor_porcentaje);
        $incentivo_jueves = calcular_incentivo($jueves_val, $base_eficiencia, $base_valor, $valor_porcentaje);
        $incentivo_viernes = calcular_incentivo($viernes_val, $base_eficiencia, $base_valor, $valor_porcentaje);
        $incentivo_sabado = calcular_incentivo($sabado_val, $base_eficiencia, $base_valor, $valor_porcentaje);

        // Sumar los incentivos diarios para obtener el total
        $total_incentivo += ($incentivo_lunes + $incentivo_martes + $incentivo_miercoles + $incentivo_jueves + $incentivo_viernes + $incentivo_sabado);

        // Sumar las eficiencias para el promedio
        $total_eficiencia += ($lunes_val + $martes_val + $miercoles_val + $jueves_val + $viernes_val + $sabado_val);
        $dias_con_incentivo += 6; // Siempre hay 6 días
    }

    // Calcular el promedio de la eficiencia semanal
    if ($dias_con_incentivo > 0) {
        $promedio_eficiencia = $total_eficiencia / $dias_con_incentivo;
    } else {
        $promedio_eficiencia = 0;
    }

    // Insertar los nuevos resultados en la tabla incentivo3
    $fecha_actual = date("Y-m-d");
    $sql_insert = "INSERT INTO incentivo3 (eficiencia, modulo, fecha, valor, valor_lunes, valor_martes, valor_miercoles, valor_jueves, valor_viernes, valor_sabado, 
                    eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, eficiencia_jueves, eficiencia_viernes, eficiencia_sabado)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("dssddddddddddddd", 
                      $promedio_eficiencia, $modulo, $fecha_actual, $total_incentivo, 
                      $incentivo_lunes, $incentivo_martes, $incentivo_miercoles, $incentivo_jueves, 
                      $incentivo_viernes, $incentivo_sabado, 
                      $lunes_val, $martes_val, $miercoles_val, $jueves_val, $viernes_val, $sabado_val);
    $stmt->execute();
}

// Cerrar conexión
$conexion->close();

// Redirigir o mostrar mensaje de éxito
header("Location: ../views/registerm.php");
exit();
?>
