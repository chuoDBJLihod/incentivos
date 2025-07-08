<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";

// Obtener el ID del usuario y el módulo desde los parámetros GET
$id_usuario = $_GET['id_usuario'];
$modulo = $_GET['modulo'];

try {
    // Iniciar transacción
    $conexion->begin_transaction();

    // Consultar los valores de las tablas incentivo
    $query1 = "SELECT valor FROM incentivo1 WHERE modulo = ?";
    $query2 = "SELECT valor FROM incentivo2 WHERE modulo = ?";
    $query3 = "SELECT valor FROM incentivo3 WHERE modulo = ?";
    $query4 = "SELECT valor FROM incentivo4 WHERE modulo = ?";

    // Preparar y ejecutar las consultas
    $stmt1 = $conexion->prepare($query1);
    $stmt1->bind_param("s", $modulo);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $valor_1 = $result1->fetch_assoc()['valor'] ?? 0;

    $stmt2 = $conexion->prepare($query2);
    $stmt2->bind_param("s", $modulo);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $valor_2 = $result2->fetch_assoc()['valor'] ?? 0;

    $stmt3 = $conexion->prepare($query3);
    $stmt3->bind_param("s", $modulo);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $valor_3 = $result3->fetch_assoc()['valor'] ?? 0;

    $stmt4 = $conexion->prepare($query4);
    $stmt4->bind_param("s", $modulo);
    $stmt4->execute();
    $result4 = $stmt4->get_result();
    $valor_4 = $result4->fetch_assoc()['valor'] ?? 0;

    // Actualizar la tabla usuario
    $update_query = "UPDATE usuario 
                     SET valor_1 = ?, valor_2 = ?, valor_3 = ?, valor_4 = ? 
                     WHERE id_usuario = ?";
    $update_stmt = $conexion->prepare($update_query);
    $update_stmt->bind_param("iiiis", $valor_1, $valor_2, $valor_3, $valor_4, $id_usuario);
    $update_stmt->execute();

    // Confirmar la transacción
    $conexion->commit();

    header("Location: ../views/agregar_incentivos.php");
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conexion->rollback();
    echo "Error al actualizar los valores: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
