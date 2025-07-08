<?php
// Incluir la conexión a la base de datos
include "../config/conexion.php";

// Verificar si se ha recibido el ID del usuario y módulo
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

            // Mostrar el formulario en un modal (está oculto por defecto)
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['seleccion'])) {
                // Procesar la selección
                $seleccion = $_POST['seleccion'];

                // Actualizar los valores seleccionados en la tabla usuario
                $query_update = "UPDATE usuario SET ";

                // Condicional para verificar los valores seleccionados
                $update_values = [];
                $bind_params = [];
                if (in_array("valor1", $seleccion)) {
                    $update_values[] = "valor_1 = ?";
                    $bind_params[] = $valor1;
                }
                if (in_array("valor2", $seleccion)) {
                    $update_values[] = "valor_2 = ?";
                    $bind_params[] = $valor2;
                }
                if (in_array("valor3", $seleccion)) {
                    $update_values[] = "valor_3 = ?";
                    $bind_params[] = $valor3;
                }
                if (in_array("valor4", $seleccion)) {
                    $update_values[] = "valor_4 = ?";
                    $bind_params[] = $valor4;
                }

                // Concatenar las condiciones para la actualización
                $query_update .= implode(", ", $update_values);
                $query_update .= " WHERE id_usuario = ?";

                // Agregar el id_usuario al final
                $bind_params[] = $id_usuario;

                // Preparar la declaración de actualización
                $stmt_update = $conexion->prepare($query_update);
                $stmt_update->bind_param(str_repeat("i", count($bind_params)), ...$bind_params);
                $stmt_update->execute();

                if ($stmt_update->affected_rows > 0) {
                    echo "<p>Los valores se han actualizado correctamente.</p>";
                    // Redirigir después de guardar la selección
                    header("Location: ../views/agregar_incentivos.php");
                    exit;
                } else {
                    echo "<p>No se pudieron actualizar los valores.</p>";
                }
            }

            // Mostrar el formulario directamente (sin necesidad de hacer clic en un enlace)
            echo '
            <div id="modalForm" style="display:block;">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Selecciona los valores a agregar:</h3>
                    <form action="" method="POST">
                        <input type="hidden" name="id_usuario" value="' . $id_usuario . '">
                        <input type="hidden" name="modulo" value="' . $modulo . '">
                        
                        <label><input type="checkbox" name="seleccion[]" value="valor1"> Agregar a valor_1 (Valor: ' . $valor1 . ')</label><br>
                        <label><input type="checkbox" name="seleccion[]" value="valor2"> Agregar a valor_2 (Valor: ' . $valor2 . ')</label><br>
                        <label><input type="checkbox" name="seleccion[]" value="valor3"> Agregar a valor_3 (Valor: ' . $valor3 . ')</label><br>
                        <label><input type="checkbox" name="seleccion[]" value="valor4"> Agregar a valor_4 (Valor: ' . $valor4 . ')</label><br>
                        
                        <button type="submit">Guardar Selección</button>
                    </form>
                </div>
            </div>';
        } else {
            echo "No se encontraron incentivos para el módulo seleccionado.";
        }
    } else {
        echo "No se encontró el módulo del usuario.";
    }

    $stmt->close();
    $stmt_incentivos->close();
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!-- Estilos para el Modal -->
<style>
    /* Modal background */
    #modalForm {
        display: block; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
    }

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Botones */
    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<!-- Scripts para abrir y cerrar el modal -->
<script>
    function closeModal() {
        document.getElementById("modalForm").style.display = "none";
    }
</script>
