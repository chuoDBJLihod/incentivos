<?php
// Incluye la conexión a la base de datos
include '../config/conexion.php';

// Consultas para los datos existentes
// Consulta para obtener la última fecha registrada
$consulta_fechas = "SELECT fecha_1, fecha_2, fecha_3, fecha_4, fecha_5, fecha_6, fecha_7, fecha_8 FROM fechas_eventos ORDER BY fecha_1, fecha_2, fecha_3, fecha_4, fecha_5, fecha_6, fecha_7, fecha_8 DESC LIMIT 1";
$resultado_fechas = $conexion->query($consulta_fechas);

$fecha_1 = '';
$fecha_2 = '';
$fecha_3 = '';
$fecha_4 = '';
$fecha_5 = '';
$fecha_6 = '';
$fecha_7 = '';
$fecha_8 = '';



if ($resultado_fechas->num_rows > 0) {
  $row_fechas = $resultado_fechas->fetch_assoc();
  $fecha_1 = $row_fechas['fecha_1'];
  $fecha_2 = $row_fechas['fecha_2'];
  $fecha_3 = $row_fechas['fecha_3'];
  $fecha_4 = $row_fechas['fecha_4'];
  $fecha_5 = $row_fechas['fecha_5'];
  $fecha_6 = $row_fechas['fecha_6'];
  $fecha_7 = $row_fechas['fecha_7'];
  $fecha_8 = $row_fechas['fecha_8'];
}
// Consulta para incentivo1
$query1 = "
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
    FROM incentivo1
    WHERE modulo != '0'  -- Excluye el módulo con valor 0
    ORDER BY modulo;
";
$result1 = $conexion->query($query1);
$data1 = array();
while ($row = $result1->fetch_assoc()) {
  $data1[] = $row;
}

// Consulta para incentivo2
$query2 = "
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
    FROM incentivo2
    WHERE modulo != '0'
    ORDER BY modulo;
";
$result2 = $conexion->query($query2);
$data2 = array();
while ($row = $result2->fetch_assoc()) {
  $data2[] = $row;
}

// Consulta para incentivo3
$query3 = "
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
    FROM incentivo3
    WHERE modulo != '0'  -- Excluye el módulo con valor 0
    ORDER BY modulo;
";
$result3 = $conexion->query($query3);
$data3 = array();
while ($row = $result3->fetch_assoc()) {
  $data3[] = $row;
}

// Consulta para incentivo4
$query4 = "
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
    WHERE modulo != '0'
    ORDER BY modulo;
";
$result4 = $conexion->query($query4);
$data4 = array();
while ($row = $result4->fetch_assoc()) {
  $data4[] = $row;
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

    .grafico-container {
      width: 80%;
      margin: 20px auto;
    }
  </style>
</head>

<body>

  <h2>Diagrama Interactivo de Eficiencia y Valor por Módulo (Semana)</h2>

  <!-- Div donde se dibujarán los gráficos -->
  <center>
    <h2>Semana 1</h2>
    <?php if ($fecha_1 && $fecha_2): ?>
      <p>Incentivos del: <?php echo $fecha_1; ?> al <?php echo $fecha_2; ?></p>
    <?php else: ?>
      <p>No se encontraron fechas para el último registro.</p>
    <?php endif; ?>
  </center>
  <div id="grafico1" class="grafico-container"></div>
  <center>
    <h2>Semana 2</h2>
    <?php if ($fecha_3 && $fecha_4): ?>
      <p>Incentivos del: <?php echo $fecha_3; ?> al <?php echo $fecha_4; ?></p>
    <?php else: ?>
      <p>No se encontraron fechas para el último registro.</p>
    <?php endif; ?>
  </center>
  <div id="grafico2" class="grafico-container"></div>
  <center>
    <h2>Semana 3</h2>
    <?php if ($fecha_5 && $fecha_6): ?>
      <p>Incentivos del: <?php echo $fecha_5; ?> al <?php echo $fecha_6; ?></p>
    <?php else: ?>
      <p>No se encontraron fechas para el último registro.</p>
    <?php endif; ?>
  </center>
  <div id="grafico3" class="grafico-container"></div>
  <center>
    <h2>Semana 4</h2>
    <?php if ($fecha_7 && $fecha_8): ?>
      <p>Incentivos del: <?php echo $fecha_7; ?> al <?php echo $fecha_8; ?></p>
    <?php else: ?>
      <p>No se encontraron fechas para el último registro.</p>
    <?php endif; ?>
  </center>
  <div id="grafico4" class="grafico-container"></div>

  <script>
    // Paso de los datos PHP a JavaScript usando json_encode
    const data1 = <?php echo json_encode($data1); ?>;
    const data2 = <?php echo json_encode($data2); ?>;
    const data3 = <?php echo json_encode($data3); ?>;
    const data4 = <?php echo json_encode($data4); ?>;

    const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

    // Función para crear los gráficos
    function createGraph(data, graphId) {
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
        mode: 'lines+markers',
        name: modulo.modulo,
        line: {
          color: `rgba(${(index * 50) % 255}, ${(index * 80) % 255}, ${(index * 110) % 255}, 1)`,
          width: 3
        },
        marker: {
          size: 8
        },
        text: [
          `Eficiencia: ${modulo.eficiencia_lunes}%<br>Valor: ${modulo.valor_lunes}`,
          `Eficiencia: ${modulo.eficiencia_martes}%<br>Valor: ${modulo.valor_martes}`,
          `Eficiencia: ${modulo.eficiencia_miercoles}%<br>Valor: ${modulo.valor_miercoles}`,
          `Eficiencia: ${modulo.eficiencia_jueves}%<br>Valor: ${modulo.valor_jueves}`,
          `Eficiencia: ${modulo.eficiencia_viernes}%<br>Valor: ${modulo.valor_viernes}`,
          `Eficiencia: ${modulo.eficiencia_sabado}%<br>Valor: ${modulo.valor_sabado}`
        ],
        hoverinfo: 'text'
      }));

      const layout = {
        title: 'Eficiencia y Valor por Módulo en la Semana',
        xaxis: { title: 'Días de la Semana' },
        yaxis: { title: 'Eficiencia (%)' },
        showlegend: true,
        height: 450
      };

      Plotly.newPlot(graphId, traces, layout);
    }

    // Crear los gráficos
    createGraph(data1, 'grafico1');
    createGraph(data2, 'grafico2');
    createGraph(data3, 'grafico3');
    createGraph(data4, 'grafico4');
  </script>

</body>

</html>