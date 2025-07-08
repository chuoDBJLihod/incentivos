
function reiniciarFormulario() {
    var inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(function(input) {
        input.value = '';  // Eliminar los valores de todos los campos
    });
}


