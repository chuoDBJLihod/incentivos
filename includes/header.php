<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incentivos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>
<body>

<!-- Header -->
<header class="header">
    <nav class="navbar">
        <!-- Brand -->
        <div class="navbar__brand">
            <img src="../assets/img/logo.avif" alt="Logo" class="navbar__logo" style="height: 50px; width: 50px;">
            <h1 class="navbar__title">Manufacturas Zuluaga</h1>
        </div>

        <!-- Menu -->
        <ul class="navbar__menu">
            <li class="navbar__item"><a href="../views/menu.php" class="navbar__link">Inicio</a></li>
            <li class="navbar__item">
                <a href="#" class="navbar__link" onclick="toggleDropdown(event)">Incentivos</a>
                <ul class="dropdown-menu">
                    <li><a href="../views/registerm.php" class="dropdown-item">Incentivo Modular</a></li>
                    <li><a href="../views/registerp.php" class="dropdown-item">Incentivo Precilla</a></li>
                </ul>
            </li>
            <li class="navbar__item"><a href="../views/login.php" class="navbar__link">Registro</a></li>
            <li class="navbar__item"><a href="#" class="navbar__link">Gráficos</a></li>
        </ul>

        <!-- Button -->
        <div class="navbar__button">
            <a href="../views/menu.html" class="btn">Volver al Inicio</a>
        </div>
    </nav>
</header>


</body>
</html>
