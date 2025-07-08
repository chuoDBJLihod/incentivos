<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recorrer los valores enviados por el formulario
    foreach ($_POST['valor_1'] as $id_usuario => $valor_1) {
        // Obtener los demás valores del formulario
        $valor_2 = isset($_POST['valor_2'][$id_usuario]) ? $_POST['valor_2'][$id_usuario] : 0;
        $valor_3 = isset($_POST['valor_3'][$id_usuario]) ? $_POST['valor_3'][$id_usuario] : 0;
        $valor_4 = isset($_POST['valor_4'][$id_usuario]) ? $_POST['valor_4'][$id_usuario] : 0;

        // Asegurarse de que todos los valores sean numéricos antes de actualizarlos
        $valor_1 = is_numeric($valor_1) ? $valor_1 : 0;
        $valor_2 = is_numeric($valor_2) ? $valor_2 : 0;
        $valor_3 = is_numeric($valor_3) ? $valor_3 : 0;
        $valor_4 = is_numeric($valor_4) ? $valor_4 : 0;

        // Consulta para actualizar los valores en la base de datos
        $query_update = "UPDATE usuario 
                         SET valor_1 = ?, valor_2 = ?, valor_3 = ?, valor_4 = ? 
                         WHERE id_usuario = ?";

        // Preparar la consulta para evitar inyecciones SQL
        if ($stmt = $conexion->prepare($query_update)) {
            // Vincular los parámetros
            $stmt->bind_param("ddddd", $valor_1, $valor_2, $valor_3, $valor_4, $id_usuario);
            
            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si la consulta fue exitosa
            if ($stmt->affected_rows > 0) {
                echo "Incentivos del usuario con ID $id_usuario actualizados correctamente.<br>";
            } else {
                echo "No se actualizaron los incentivos del usuario con ID $id_usuario.<br>";
            }

            // Cerrar la consulta preparada
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conexion->error . "<br>";
        }
    }
} else {
    echo "No se recibieron datos del formulario.";
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Redirigir de vuelta a la página de incentivos (opcional)
header("Location: ../views/agregar_incentivos.php");
exit();

?>
