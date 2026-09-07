<?php
$conexion = new mysqli("localhost", "root", "", "DIVINE");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$sql = "SELECT
            pedidos.nombre,
            COUNT(pedidos.ID) AS cantidad_pedidos
        FROM pedidos
        GROUP BY pedidos.nombre
        ORDER BY cantidad_pedidos DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}


$nombres = [];
$cantidades = [];

while ($fila = $resultado->fetch_assoc()) {

    $nombres[] = $fila["nombre"];
    $cantidades[] = (int)$fila["cantidad_pedidos"];

}


$nombresJSON = json_encode($nombres);
$cantidadesJSON = json_encode($cantidades);


$conexion->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente más frecuente</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="contenedor">
    <h1>Clientes más frecuentes</h1>
    <div class="grafico">
        <canvas id="graficoClientes"></canvas>
    </div>
</div>
<script>
const nombres = <?php echo $nombresJSON; ?>;
const cantidades = <?php echo $cantidadesJSON; ?>;
const ctx = document.getElementById("graficoClientes");
new Chart(ctx, {
    type: "bar",
    data: {
        labels: nombres,
        datasets: [
            {
                label: "Cantidad de pedidos",
                data: cantidades,
                backgroundColor: "#e0b7eb",
                borderColor: "#c786d4",
                borderWidth: 1
            }
        ]
      },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                },

                title: {
                    display: true,
                    text: "Cantidad de pedidos"

                }
            },
            x: {
                title: {
                    display: true,
                    text: "Clientes"
                }
            }
        },
        plugins: {
            legend: {
                display: true
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return "Pedidos: " + context.raw;
                    }
                }
            }
        }
      }
});

</script>
</body>
</html>