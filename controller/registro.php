<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre_usuario = $_POST['username'];
    $modulo = $_POST['module'];
    $tipo_usuario = $_POST['user_type'];

    // Verificar si el usuario ya existe en la base de datos
    $consulta = "SELECT * FROM usuario WHERE nombre_completo = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si el usuario ya existe, redirigir con estado "exists"
            header("Location: ../views/login.php?status=exists");
            exit();
        } else {
            // Si no existe, insertar el nuevo registro
            $sql = "INSERT INTO usuario (nombre_completo, modulo, tipo_usuario, valor_1, valor_2, valor_3, valor_4, estado) 
                    VALUES (?, ?, ?, 0, 0, 0, 0, 'Activo')";

            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("sss", $nombre_usuario, $modulo, $tipo_usuario);
                if ($stmt->execute()) {
                    // Redirigir con estado "success"
                    header("Location: ../views/login.php?status=success");
                    exit();
                } else {
                    // Redirigir con estado "error" si falla la ejecución
                    header("Location: ../views/login.php?status=error");
                    exit();
                }
            } else {
                // Redirigir con estado "error" si falla la preparación
                header("Location: ../views/login.php?status=error");
                exit();
            }
        }
     } else {
        // Redirigir con estado "error" si falla la consulta
        header("Location: ../views/login.php?status=error");
        exit();
    }
}

// Cerrar la conexión
$conexion->close();
?>
