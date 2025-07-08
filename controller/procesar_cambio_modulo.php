<?php
include '../config/conexion.php'; // Conectar a la base de datos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $modulo = $_POST['modulo'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validar que todos los campos estén completos.
    if (!empty($id_usuario) && !empty($modulo) && !empty($tipo_usuario)) {
        // Actualizar el usuario en la base de datos.
        $query = "UPDATE usuario 
                  SET modulo = ?, tipo_usuario = ? 
                  WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssi', $modulo, $tipo_usuario, $id_usuario);

        if ($stmt->execute()) {
            echo "<script>
                alert('Usuario actualizado correctamente.');
                window.location.href = '../views/agregar_incentivos.php';
            </script>";
        } else {
            echo "<script>
                alert('Error al actualizar el usuario.');
                window.location.href = 'cambiar_modulo.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Por favor, complete todos los campos.');
            window.location.href = 'cambiar_modulo.php';
        </script>";
    }
} else {
    header("Location:cambiar_modulo.php");
    exit();
}
?>
