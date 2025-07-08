<?php
// Incluye la conexión a la base de datos
include '../config/conexion.php';

// Realizamos la consulta para obtener los datos de eficiencia y valor de la tabla incentivo4
$query = "
    SELECT 
        modulo,
        eficiencia_lunes,
        eficiencia_martes,
        eficiencia_miercoles,
        eficiencia_jueves,
        eficiencia_viernes,
        eficiencia_sabado,
        valor_lunes,
        valor_martes,
        valor_miercoles,
        valor_jueves,
        valor_viernes,
        valor_sabado
    FROM incentivo4
    WHERE modulo != '0'  -- Excluye el módulo con valor 0
    ORDER BY modulo;
";

$result = $conexion->query($query);

// Creamos un arreglo para almacenar los resultados
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'modulo' => $row['modulo'],
        'eficiencia_lunes' => $row['eficiencia_lunes'],
        'eficiencia_martes' => $row['eficiencia_martes'],
        'eficiencia_miercoles' => $row['eficiencia_miercoles'],
        'eficiencia_jueves' => $row['eficiencia_jueves'],
        'eficiencia_viernes' => $row['eficiencia_viernes'],
        'eficiencia_sabado' => $row['eficiencia_sabado'],
        'valor_lunes' => $row['valor_lunes'],
        'valor_martes' => $row['valor_martes'],
        'valor_miercoles' => $row['valor_miercoles'],
        'valor_jueves' => $row['valor_jueves'],
        'valor_viernes' => $row['valor_viernes'],
        'valor_sabado' => $row['valor_sabado']
    );
}

// Cerramos la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diagrama Interactivo de Eficiencia y Valor por Módulo</title>
  <script src="https://cdn.jsdelivr.net/npm/plotly.js-dist@2.24.0/plotly.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      padding: 0;
      background-color: #f4f4f9;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    #grafico {
      width: 80%;
      margin: 0 auto;
    }
  </style>
</head>
<body>

  <h2>Diagrama Interactivo de Eficiencia y Valor por Módulo (Semana)</h2>
  
  <!-- Div donde se dibujará el gráfico -->
  <div id="grafico"></div>

  <script>
    // Paso de los datos PHP a JavaScript usando json_encode
    const data = <?php echo json_encode($data); ?>;

    // Extraemos los días de la semana
    const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

    // Crear los traces para Plotly.js con colores dinámicos para cada módulo
    const traces = data.map((modulo, index) => ({
      x: diasSemana,
      y: [
        modulo.eficiencia_lunes,
        modulo.eficiencia_martes,
        modulo.eficiencia_miercoles,
        modulo.eficiencia_jueves,
        modulo.eficiencia_viernes,
        modulo.eficiencia_sabado
      ],
      mode: 'lines+markers',  // Dibujar líneas con marcadores
      name: modulo.modulo,  // Nombre del módulo
      line: {
        color: `rgba(${(index * 50) % 255}, ${(index * 80) % 255}, ${(index * 110) % 255}, 1)`,  // Colores dinámicos
        width: 3
      },
      marker: {
        size: 8
      },
      // Información adicional al pasar el mouse
      text: [
        `Eficiencia: ${modulo.eficiencia_lunes}%<br>Valor: ${modulo.valor_lunes}`,
        `Eficiencia: ${modulo.eficiencia_martes}%<br>Valor: ${modulo.valor_martes}`,
        `Eficiencia: ${modulo.eficiencia_miercoles}%<br>Valor: ${modulo.valor_miercoles}`,
        `Eficiencia: ${modulo.eficiencia_jueves}%<br>Valor: ${modulo.valor_jueves}`,
        `Eficiencia: ${modulo.eficiencia_viernes}%<br>Valor: ${modulo.valor_viernes}`,
        `Eficiencia: ${modulo.eficiencia_sabado}%<br>Valor: ${modulo.valor_sabado}`
      ],  // El texto que se muestra en el tooltip
      hoverinfo: 'text'  // Mostrar solo el texto personalizado en el hover
    }));

    // Layout de Plotly
    const layout = {
      title: 'Eficiencia y Valor por Módulo en la Semana4',
      xaxis: {
        title: 'Días de la Semana',
        showgrid: true
      },
      yaxis: {
        title: 'Eficiencia (%)',
        range: [0, 100],  // Rango de eficiencia de 0 a 100
        showgrid: true
      },
      hovermode: 'closest',  // Muestra datos cuando el mouse pasa cerca
      showlegend: true
    };

    // Crear el gráfico con Plotly
    Plotly.newPlot('grafico', traces, layout);
  </script>

</body>
</html>
