<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <!-- Incluir la librería de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include "../includes/header.php"; ?>

    <div class="form-container">
        <h2>Registro de Usuario</h2>
        <!-- Ajuste de la ruta de acción para enviar el formulario correctamente -->
        <form action="../controller/registro.php" method="POST">
            <!-- Nombre de Usuario -->
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" placeholder="Ingresa tu nombre de usuario" required>
            </div>

            <!-- Módulo -->
            <div class="form-group">
                <label for="module">Módulo</label>
                <input type="text" id="module" name="module" placeholder="Ingresa el módulo" required>
            </div>

            <!-- Tipo de Usuario -->
            <div class="form-group">
                <label for="user-type">Tipo de Usuario</label>
                <select id="user-type" name="user_type" required>
                    <option value="" disabled selected>Selecciona el tipo de usuario</option>
                    <option value="manualidad">Manualidad</option>
                    <option value="Precilla">Presilla</option>
                    <option value="modular">Modular</option>
                </select>
            </div>

            <!-- Botón de Enviar -->
            <div class="form-group">
                <button type="submit">Registrar</button>
            </div>
        </form>
    </div>

    <?php include "../includes/footer.php"; ?>

    <!-- Mostrar notificaciones SweetAlert basadas en el estado del registro -->
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == "success") {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registro Exitoso',
                    text: 'El usuario ha sido registrado correctamente.',
                    confirmButtonText: 'OK'
                });
            </script>";
        } elseif ($status == "exists") {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Usuario Ya Registrado',
                    text: 'Este usuario ya está registrado en el sistema.',
                    confirmButtonText: 'OK'
                });
            </script>";
        } elseif ($status == "error") {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el Registro',
                    text: 'Hubo un error al intentar registrar al usuario.',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
    ?>

</body>
</html>
