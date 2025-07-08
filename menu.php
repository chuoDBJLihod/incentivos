<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incentivos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        /* Grid Styling */
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 40px;
        }

        /* Card Styling */
        .c-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 400px;
            text-align: center;
        }

        .c-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* Image Styling */
        .c-card__image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Content Styling */
        .c-card__content {
            padding: 20px;
        }

        .c-card__title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
        }

        .c-card__title:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include "../includes/header.php"; ?>

<!-- Main Content -->
<div class="grid">
    <div class="c-card">
        <div class="c-card__image">
            <a href="registerm.php">
                <img src="../assets/img/incentivo.avif" alt="Calcular Incentivos">
            </a>
        </div>
        <div class="c-card__content">
            <h1 class="c-card__title">Calcular Incentivos</h1>
        </div>
    </div>

    <div class="c-card">
        <div class="c-card__image">
            <a href="registerp.php">
                <img src="../assets/img/incentivo.avif" alt="Calcular Precilla">
            </a>
        </div>
        <div class="c-card__content">
            <h1 class="c-card__title">Calcular Precilla</h1>
        </div>
    </div>

    <div class="c-card">
        <div class="c-card__image">
            <a href="login.php">
                <img src="../assets/img/registro.png" alt="Registro">
            </a>
        </div>
        <div class="c-card__content">
            <h1 class="c-card__title">Registro</h1>
        </div>
    </div>

    <div class="c-card">
        <div class="c-card__image">
            <a href="agregar_incentivos.php">
                <img src="../assets/img/añadir.avif" alt="Agregar Incentivos">
            </a>
        </div>
        <div class="c-card__content">
            <h1 class="c-card__title">Agregar Incentivos</h1>
        </div>
    </div>

    <div class="c-card">
        <div class="c-card__image">
            <a href="../graficos/graficom1.php">
                <img src="../assets/img/graficos.avif" alt="Gráficos">
            </a>
        </div>
        <div class="c-card__content">
            <h1 class="c-card__title">Gráficos</h1>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
