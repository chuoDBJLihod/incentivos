<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";

// Verificar si se ha recibido el formulario
if (isset($_POST['id_usuario']) && isset($_POST['seleccion'])) {
    $id_usuario = $_POST['id_usuario'];
    $modulo = $_POST['modulo'];
    $seleccion = $_POST['seleccion'];

    // Obtener los valores de las tablas de incentivo para el módulo seleccionado
    $query_incentivos = "SELECT 
        i1.valor AS valor1, 
        i2.valor AS valor2, 
        i3.valor AS valor3, 
        i4.valor AS valor4 
        FROM incentivo1 i1
        JOIN incentivo2 i2 ON i2.modulo = i1.modulo
        JOIN incentivo3 i3 ON i3.modulo = i1.modulo
        JOIN incentivo4 i4 ON i4.modulo = i1.modulo
        WHERE i1.modulo = ?";

    $stmt_incentivos = $conexion->prepare($query_incentivos);
    $stmt_incentivos->bind_param("s", $modulo);
    $stmt_incentivos->execute();
    $result_incentivos = $stmt_incentivos->get_result();

    if ($result_incentivos->num_rows > 0) {
        $row_incentivos = $result_incentivos->fetch_assoc();
        $valor1 = $row_incentivos['valor1'];
        $valor2 = $row_incentivos['valor2'];
        $valor3 = $row_incentivos['valor3'];
        $valor4 = $row_incentivos['valor4'];

        // Actualizar los valores seleccionados en la tabla usuario
        $query_update = "UPDATE usuario SET ";

        // Condicional para verificar los valores seleccionados
        $update_values = [];
        if (in_array("valor1", $seleccion)) {
            $update_values[] = "valor_1 = ?";
        }
        if (in_array("valor2", $seleccion)) {
            $update_values[] = "valor_2 = ?";
        }
        if (in_array("valor3", $seleccion)) {
            $update_values[] = "valor_3 = ?";
        }
        if (in_array("valor4", $seleccion)) {
            $update_values[] = "valor_4 = ?";
        }

        // Concatenar las condiciones para la actualización
        $query_update .= implode(", ", $update_values);
        $query_update .= " WHERE id_usuario = ?";

        // Preparar la declaración de actualización
        $stmt_update = $conexion->prepare($query_update);
        
        // Asignar los valores de los campos seleccionados
        $bind_params = [];
        foreach ($seleccion as $valor) {
            if ($valor == "valor1") {
                $bind_params[] = $valor1;
            } elseif ($valor == "valor2") {
                $bind_params[] = $valor2;
            } elseif ($valor == "valor3") {
                $bind_params[] = $valor3;
            } elseif ($valor == "valor4") {
                $bind_params[] = $valor4;
            }
        }

        // Agregar el id_usuario al final
        $bind_params[] = $id_usuario;

        // Asociar los parámetros y ejecutar la actualización
        $stmt_update->bind_param(str_repeat("i", count($bind_params)), ...$bind_params);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo "Los valores se han actualizado correctamente.";
        } else {
            echo "No se pudieron actualizar los valores.";
        }
    } else {
        echo "No se encontraron incentivos para el módulo seleccionado.";
    }

    $stmt_incentivos->close();
    $stmt_update->close();
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
