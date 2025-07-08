<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";

// Verificar si se ha recibido el ID del usuario
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Obtener el módulo del usuario seleccionado
    $query_modulo = "SELECT modulo FROM usuario WHERE id_usuario = ?";
    $stmt = $conexion->prepare($query_modulo);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result_modulo = $stmt->get_result();

    if ($result_modulo->num_rows > 0) {
        $row_modulo = $result_modulo->fetch_assoc();
        $modulo = $row_modulo['modulo'];

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

            // Actualizar todos los usuarios del mismo módulo con los valores obtenidos
            $query_update = "UPDATE usuario SET 
                valor_1 = ?, 
                valor_2 = ?, 
                valor_3 = ?, 
                valor_4 = ? 
                WHERE modulo = ?";
            
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("iiiss", $valor1, $valor2, $valor3, $valor4, $modulo);
            $stmt_update->execute();

            if ($stmt_update->affected_rows > 0) {
                // Redirigir a la página de agregar incentivos después de actualizar
                header( "Location: ../views/agregar_incentivos.php");
                exit();  // Asegurarse de que el script se detenga aquí
            } else {
                echo "No se pudieron actualizar los valores para los usuarios del módulo.";
            }
        } else {
            echo "No se encontraron incentivos para el módulo seleccionado.";
        }
    } else {
        echo "No se encontró el módulo del usuario.";
    }

    $stmt->close();
    $stmt_incentivos->close();
    $stmt_update->close();
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
