<div class="form-container">
    <h2>Fechas</h2>
    <button id="toggleButton" class="toggle-button">+</button>
    <form id="fechaForm" action="../controller/guardar_fechas.php" method="POST">
        <div class="fechas">
            <div class="date">
                <label for="fecha_1">Fecha 1:</label>
                <input type="date" name="fecha_1" id="fecha_1">
            </div>
            <div class="date">
                <label for="fecha_2">Fecha 2:</label>
                <input type="date" name="fecha_2" id="fecha_2">
            </div>
            <div class="date">
                <label for="fecha_3">Fecha 3:</label>
                <input type="date" name="fecha_3" id="fecha_3">
            </div>
            <div class="date">
                <label for="fecha_4">Fecha 4:</label>
                <input type="date" name="fecha_4" id="fecha_4">
            </div>
            <div class="date">
                <label for="fecha_5">Fecha 5:</label>
                <input type="date" name="fecha_5" id="fecha_5">
            </div>
            <div class="date">
                <label for="fecha_6">Fecha 6:</label>
                <input type="date" name="fecha_6" id="fecha_6">
            </div>
            <div class="date">
                <label for="fecha_7">Fecha 7:</label>
                <input type="date" name="fecha_7" id="fecha_7">
            </div>
            <div class="date">
                <label for="fecha_8">Fecha 8:</label>
                <input type="date" name="fecha_8" id="fecha_8">
            </div>
        </div>
        <input class="button" type="submit" value="Guardar">
    </form>
</div>

<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f4f4f4;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .fechas {
        margin-top: 20px;
    }

    .date {
        margin-bottom: 15px;
    }

    .date label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .date input[type="date"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .button {
        display: block;
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background-color: #007BFF;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .date input[type="date"]:focus {
        outline: none;
        border-color: #007BFF;
    }

    /* Botón para alternar entre más y menos */
    .toggle-button {
        display: block;
        margin: 10px auto;
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .toggle-button:hover {
        background-color: #0056b3;
    }

    /* Formulario oculto por defecto */
    #fechaForm {
        display: none;
    }
</style>

<script>
    // Alternar entre mostrar y ocultar el formulario
    document.getElementById("toggleButton").addEventListener("click", function() {
        var form = document.getElementById("fechaForm");
        var button = document.getElementById("toggleButton");

        // Si el formulario está oculto, lo mostramos y cambiamos el botón a menos
        if (form.style.display === "none") {
            form.style.display = "block";
            button.textContent = "-"; // Cambiar a signo menos
        } else {
            form.style.display = "none";
            button.textContent = "+"; // Cambiar a signo más
        }
    });
</script>
