<?php
include '../config/conexion.php'; // Asegúrate de conectar a tu base de datos.

// Obtener los usuarios activos.
$query = "SELECT id_usuario, nombre_completo, modulo, tipo_usuario FROM usuario WHERE estado = 'Activo'";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Usuarios de Módulo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Form container */
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Form header */
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        /* Input and select fields */
        .form-group label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Buttons */
        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Cambiar Usuarios de Módulo</h1>
        </div>
        <form action="procesar_cambio_modulo.php" method="POST">
            <div class="form-group mb-3">
                <label for="usuario">Seleccionar Usuario:</label>
                <select id="usuario" name="id_usuario" class="form-control" required>
                    <option value="">-- Seleccione un usuario --</option>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <option value="<?= $row['id_usuario']; ?>">
                            <?= $row['nombre_completo']; ?> (Módulo: <?= $row['modulo']; ?>, Tipo: <?= $row['tipo_usuario']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="modulo">Nuevo Módulo:</label>
                <input type="text" id="modulo" name="modulo" class="form-control" placeholder="Ingrese el nuevo módulo" required>
            </div>
            <div class="form-group mb-4">
                <label for="tipo_usuario">Nuevo Tipo de Usuario:</label>
                <select id="tipo_usuario" name="tipo_usuario" class="form-control" required>
                    <option value="Precilla">Precilla</option>
                    <option value="Modular">Modular</option>
                    <option value="Manualidad">Manualidad</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
    <?php include "../includes/footer.php"; ?>

</body>
</html>
