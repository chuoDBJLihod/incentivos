<?php
// Incluye la conexión a la base de datos
include '../config/conexion.php';

// Realizamos la consulta para obtener los datos de eficiencia, valor y nombre del usuario de las tablas incentivop y usuario
$query = "
    SELECT 
        u.nombre_completo,
        i.eficiencia_lunes,
        i.eficiencia_martes,
        i.eficiencia_miercoles,
        i.eficiencia_jueves,
        i.eficiencia_viernes,
        i.eficiencia_sabado,
        i.valor_lunes,
        i.valor_martes,
        i.valor_miercoles,
        i.valor_jueves,
        i.valor_viernes,
        i.valor_sabado
    FROM incentivop i
    INNER JOIN usuario u ON i.id_usuario = u.id_usuario
    WHERE u.estado = 'Activo'  -- Solo usuarios activos
    ORDER BY u.nombre_completo;
";

$result = $conexion->query($query);

// Creamos un arreglo para almacenar los resultados
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'nombre_completo' => $row['nombre_completo'],
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
  <title>Diagrama Interactivo de Eficiencia y Valor por Usuario</title>
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

  <h2>Diagrama Interactivo de Eficiencia y Valor por Usuario (Semana)</h2>
  
  <!-- Div donde se dibujará el gráfico -->
  <div id="grafico"></div>

  <script>
    // Paso de los datos PHP a JavaScript usando json_encode
    const data = <?php echo json_encode($data); ?>;

    // Extraemos los días de la semana
    const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

    // Crear los traces para Plotly.js con colores dinámicos para cada usuario
    const traces = data.map((usuario, index) => ({
      x: diasSemana,
      y: [
        usuario.eficiencia_lunes,
        usuario.eficiencia_martes,
        usuario.eficiencia_miercoles,
        usuario.eficiencia_jueves,
        usuario.eficiencia_viernes,
        usuario.eficiencia_sabado
      ],
      mode: 'lines+markers',  // Dibujar líneas con marcadores
      name: usuario.nombre_completo,  // Nombre del usuario
      line: {
        color: `rgba(${(index * 50) % 255}, ${(index * 80) % 255}, ${(index * 110) % 255}, 1)`,  // Colores dinámicos
        width: 3
      },
      marker: {
        size: 8
      },
      // Información adicional al pasar el mouse
      text: [
        `Usuario: ${usuario.nombre_completo}<br>Eficiencia: ${usuario.eficiencia_lunes}%<br>Valor: ${usuario.valor_lunes}`,
        `Usuario: ${usuario.nombre_completo}<br>Eficiencia: ${usuario.eficiencia_martes}%<br>Valor: ${usuario.valor_martes}`,
        `Usuario: ${usuario.nombre_completo}<br>Eficiencia: ${usuario.eficiencia_miercoles}%<br>Valor: ${usuario.valor_miercoles}`,
        `Usuario: ${usuario.nombre_completo}<br>Eficiencia: ${usuario.eficiencia_jueves}%<br>Valor: ${usuario.valor_jueves}`,
        `Usuario: ${usuario.nombre_completo}<br>Eficiencia: ${usuario.eficiencia_viernes}%<br>Valor: ${usuario.valor_viernes}`,
        `Usuario: ${usuario.nombre_completo}<br>Eficiencia: ${usuario.eficiencia_sabado}%<br>Valor: ${usuario.valor_sabado}`
      ],  // El texto que se muestra en el tooltip
      hoverinfo: 'text'  // Mostrar solo el texto personalizado en el hover
    }));

    // Layout de Plotly
    const layout = {
      title: 'Eficiencia y Valor por Usuario en la Semana',
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
