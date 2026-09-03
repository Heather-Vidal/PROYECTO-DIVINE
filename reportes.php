<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario,$contrasena,$bd);

    if($conn->connect_error){
        die("Error de conexión");
    }
    $ci = $_SESSION["Ci"];
    $filtroVendedor = "";

if (isset($_SESSION['rol']) && $_SESSION['rol'] == "Vendedor") {

    $nombre = $_SESSION['nombre'];

    $nombre = $conn->real_escape_string($nombre);

    $filtroVendedor = " AND p.nombrevendedor = '$nombre' ";
}
$sqlDia = "SELECT SUM(v.costototalventas) AS total
           FROM ventas v
           INNER JOIN pedidos p 
           ON p.idpedidos = v.pedidos_idpedidos
           WHERE DATE(p.fecha) = CURDATE()
           AND v.estadoventas = 'Entregado'
           $filtroVendedor";

$resultadoDia = $conn->query($sqlDia);

$resDia = $resultadoDia->fetch_assoc();

$totalVentaDia = $resDia['total'];

if ($totalVentaDia == null) {
    $totalVentaDia = 0;
}

$sqlSemana = "SELECT SUM(v.costototalventas) AS total
              FROM ventas v
              INNER JOIN pedidos p
              ON p.idpedidos = v.pedidos_idpedidos
              WHERE YEARWEEK(p.fecha, 1) = YEARWEEK(CURDATE(), 1)
              AND v.estadoventas = 'Entregado'
              $filtroVendedor";

$resultadoSemana = $conn->query($sqlSemana);

$resSemana = $resultadoSemana->fetch_assoc();

$totalVentaSemana = $resSemana['total'];

if ($totalVentaSemana == null) {
    $totalVentaSemana = 0;
}

$sqlMes = "SELECT SUM(v.costototalventas) AS total
           FROM ventas v
           INNER JOIN PEDIDOS_ID
           ON p.idPedido = v.pedidos_id.pedido
           WHERE MONTH(p.fecha) = MONTH(CURDATE())
           AND YEAR(p.fecha) = YEAR(CURDATE())
           AND v.estadoventas = 'Entregado'
           $filtroVendedor";

$resultadoMes = $conn->query($sqlMes);

$resMes = $resultadoMes->fetch_assoc();

$totalVentaMes = $resMes['total'];

if ($totalVentaMes == null) {
    $totalVentaMes = 0;
}

$sqlAnio = "SELECT SUM(v.costototalventas) AS total
            FROM ventas v
            INNER JOIN pedidos p
            ON p.idpedidos = v.pedidos_idpedidos
            WHERE YEAR(p.fecha) = YEAR(CURDATE())
            AND v.estadoventas = 'Entregado'
            $filtroVendedor";

$resultadoAnio = $conn->query($sqlAnio);

$resAnio = $resultadoAnio->fetch_assoc();

$totalVentaAnio = $resAnio['total'];

if ($totalVentaAnio == null) {
    $totalVentaAnio = 0;
}

    $sql = "SELECT Fecha, count(*) AS ventas FROM ventas GROUP BY Fecha";

    $resultado = $conn->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
        $fechas[] = $fila["Fecha"];
        $ventas[] = $fila["ventas"];
    }
    $resultado = $conn->query($sql);
?>

<!DOCTYPE html>

<html>

<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Ventas</title>
<style>

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .centro {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .reportes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .reporte {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .reporte h2 {
            margin-bottom: 15px;
            font-size: 22px;
        }

        .total {
            font-size: 30px;
            font-weight: bold;
        }

        .descripcion {
            margin-top: 10px;
            color: #666;
            font-size: 15px;
        }

        @media (max-width: 700px) {

            .reportes {
                grid-template-columns: 1fr;
            }

        }

    </style>
</head>

<body>
    <h1>Reporte de Ingresos Totales</h1>

    <div class="reportes">

        <div class="reporte">

            <h2>Ingresos del Día</h2>

            <div class="total">
                Bs. <?php echo number_format($totalVentaDia, 2); ?>
            </div>

            <div class="descripcion">
                Total de ventas registradas hoy
            </div>

        </div>

        <div class="reporte">

            <h2>Ingresos de la Semana</h2>

            <div class="total">
                Bs. <?php echo number_format($totalVentaSemana, 2); ?>
            </div>

            <div class="descripcion">
                Total de ventas registradas esta semana
            </div>

        </div>

        <div class="reporte">

            <h2>Ingresos del Mes</h2>

            <div class="total">
                Bs. <?php echo number_format($totalVentaMes, 2); ?>
            </div>

            <div class="descripcion">
                Total de ventas registradas este mes
            </div>

        </div>

    <div class="reporte">

            <h2>Ingresos del Año</h2>

            <div class="total">
                Bs. <?php echo number_format($totalVentaAnio, 2); ?>
            </div>

            <div class="descripcion">
                Total de ventas registradas este año
            </div>

        </div>


    </div>

</div>

<h2>Lista de Ventas</h2>

<script>
const fechas = <?php echo json_encode($fechas); ?>;
const ventas = <?php echo json_encode($ventas); ?>;
</script>
<div style="width: 400px; height: 250px;">

    <canvas id="graficoVentas" ></canvas>
</div>

<script>
const ctx = document.getElementById('graficoVentas');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: fechas,
        datasets: [{
            label: 'Totales de ventas',
            data: ventas
        }]
    }
});
</script>


</body>

</html>