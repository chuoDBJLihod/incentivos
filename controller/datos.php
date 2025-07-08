<?php
include '../config/conexion.php'; // Conexión a la base de datos
// Tablas a consultar
$tablas = ['incentivo1', 'incentivo2', 'incentivo3', 'incentivo4'];

$data = [];

foreach ($tablas as $tabla) {
    $query = "SELECT modulo, 
                     eficiencia_lunes, eficiencia_martes, eficiencia_miercoles, 
                     eficiencia_jueves, eficiencia_viernes, eficiencia_sabado, 
                     valor_lunes, valor_martes, valor_miercoles, 
                     valor_jueves, valor_viernes, valor_sabado 
              FROM $tabla";
    $result = $conexion->query($query);

    while ($row = $result->fetch_assoc()) {
        $modulo = $row['modulo'];
        if (!isset($data[$modulo])) {
            $data[$modulo] = [
                'eficiencias' => [
                    'lunes' => 0, 'martes' => 0, 'miercoles' => 0, 
                    'jueves' => 0, 'viernes' => 0, 'sabado' => 0
                ],
                'valores' => [
                    'lunes' => 0, 'martes' => 0, 'miercoles' => 0, 
                    'jueves' => 0, 'viernes' => 0, 'sabado' => 0
                ]
            ];
        }

        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'] as $dia) {
            $data[$modulo]['eficiencias'][$dia] += $row["eficiencia_$dia"];
            $data[$modulo]['valores'][$dia] += $row["valor_$dia"];
        }
    }
}

echo json_encode($data);
?>
