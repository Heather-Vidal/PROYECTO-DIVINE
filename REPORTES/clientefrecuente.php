<?php
$conexion = new mysqli("localhost", "root", "", "DIVINE");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT
    pedidos.nombre,
    COUNT(pedidos.ID) AS cantidad_pedidos
FROM pedidos
WHERE pedidos.estado = 'Aceptado'
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

$totalClientes = count($nombres);
$totalPedidos = array_sum($cantidades);

$clienteTop = $totalClientes > 0 ? $nombres[0] : "Sin datos";
$pedidosTop = $totalClientes > 0 ? $cantidades[0] : 0;

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes | DIVINE</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            min-height: 100vh;

            font-family: "DM Sans", sans-serif;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(239, 192, 214, .45),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 90% 90%,
                    rgba(213, 190, 228, .40),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    #fff9fc,
                    #fdf5fa 45%,
                    #f8f2fb
                );

            color: #574450;
            padding: 45px 25px;

        }

        .dashboard {
            width: 100%;
            max-width: 1250px;
            margin: auto;

        }
        .encabezado {

            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;

        }


        .marca {
            display: flex;
            align-items: center;
            gap: 15px;

        }


        .logo {

            width: 55px;

            height: 55px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(
                135deg,
                #d99bb8,
                #b981a7
            );
            color: white;
            font-family: "Playfair Display", serif;
            font-size: 24px;
            box-shadow:
                0 8px 25px rgba(174, 117, 151, .25);

        }


        .marca-texto h2 {
            font-family: "Playfair Display", serif;
            font-size: 25px;
            color: #704f65;
            font-weight: 600;

        }


        .marca-texto span {
            color: #aa879f;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;

        }
        .fecha {

            color: #a78b9f;
            font-size: 13px;

        }

        .titulo {
            margin-bottom: 28px;

        }

        .titulo small {
            color: #c28baa;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 11px;
            font-weight: 600;

        }


        .titulo h1 {

            font-family: "Playfair Display", serif;

            font-size: clamp(38px, 5vw, 58px);

            line-height: 1.1;
            color: #66495c;
            margin-top: 5px;

        }

        .titulo p {

            margin-top: 10px;
            color: #9c8395;
            font-size: 14px;

        }
        .estadisticas {
            display: grid;
            grid-template-columns:
                repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;

        }


        .card {

            position: relative;
            overflow: hidden;
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(255,255,255,.85);
            border-radius: 24px;
            padding: 25px;
            box-shadow:
                0 15px 40px rgba(139, 93, 122, .08);

            backdrop-filter: blur(12px);
            transition: .3s ease;

        }


        .card:hover {
            transform: translateY(-4px);
            box-shadow:
                0 20px 45px rgba(139, 93, 122, .13);

        }


        .card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(220,170,200,.15);
            right: -35px;
            top: -35px;

        }


        .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8e7f0;
            color: #a96f91;
            font-size: 20px;
            margin-bottom: 18px;

        }


        .card-label {
            color: #a68c9f;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .card-value {

            font-family: "Playfair Display", serif;
            font-size: 30px;
            color: #694e60;
            margin-top: 4px;

        }

        .card-description {
            color: #b197a9;
            font-size: 11px;
            margin-top: 5px;

        }

        .contenido {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 25px;

        }

        .grafico-card {
            background: rgba(255,255,255,.80);
            border: 1px solid rgba(255,255,255,.9);
            border-radius: 28px;
            padding: 30px;
            box-shadow:
                0 18px 50px rgba(139, 93, 122, .08);
            min-width: 0;

        }
        .grafico-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;

        }


        .grafico-header h3 {
            font-family: "Playfair Display", serif;
            color: #694e60;
            font-size: 23px;

        }
        .grafico-header span {
            font-size: 11px;
            color: #b18da4;
            background: #fbf0f6;
            padding: 7px 12px;
            border-radius: 20px;

        }

        .grafico {
            position: relative;
            height: 430px;
        }

        .favorito {
            background:
                linear-gradient(
                    145deg,
                    #fff,
                    #fdf2f7
                );

            border-radius: 28px;

            padding: 28px;

            box-shadow:
                0 18px 50px rgba(139, 93, 122, .08);

            border: 1px solid rgba(255,255,255,.9);

        }


        .favorito-titulo {

            color: #b0839e;

            font-size: 11px;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-bottom: 25px;

        }


        .corona {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #ead0a5,
                    #c99b58
                );

            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 29px;
            margin-bottom: 20px;
            box-shadow:
                0 10px 25px rgba(190,145,77,.20);

        }
        .favorito h3 {
            font-family: "Playfair Display", serif;
            color: #65495b;
            font-size: 27px;
            word-break: break-word;

        }
        .favorito p {
            color: #a68d9e;
            font-size: 13px;
            margin-top: 5px;

        }
        .numero-pedidos {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #f1e1ea;

        }
        .numero-pedidos strong {
            font-family: "Playfair Display", serif;
            font-size: 35px;
            color: #ad6f91;

        }
        .numero-pedidos span {
            display: block;
            font-size: 11px;
            color: #a8909f;
            text-transform: uppercase;
            letter-spacing: 1px;

        }
        .detalle {

         text-align: center;
            margin-top: 35px;
            color: #c5a7b9;
            font-size: 13px;
            letter-spacing: 2px;

        }
        .detalle::before,
        .detalle::after {
            content: "✦";
            margin: 0 12px;
            color: #d5a7c0;

        }
        @media(max-width: 900px) {

            .contenido {

                grid-template-columns: 1fr;
            }
        }
        @media(max-width: 700px) {
            body {

                padding: 25px 15px;

            }

            .estadisticas {

                grid-template-columns: 1fr;

            }
            .encabezado {

                align-items: flex-start;
            }

            .fecha {

                display: none;

            }

            .grafico-card {
                padding: 20px;
            }
            .grafico {
                height: 380px;
            }
        }
        @media(max-width: 450px) {
            .titulo h1 {
                font-size: 38px;
            }
            .grafico {
                height: 330px;

            }
        }
    </style>
</head>

<body>
<div class="dashboard">
    <div class="encabezado">
        <div class="marca">
            <div class="logo">
                D
            </div>
            <div class="marca-texto">
                <h2>DIVINE</h2>
                <span>Beauty & Elegance</span>
            </div>

        </div>

        <div class="fecha">
            Panel administrativo
        </div>

    </div>
    <div class="titulo">

        <small>Estadísticas</small>

        <h1>Clientes más frecuentes</h1>

        <p>
            Conoce a las clientas que hacen de DIVINE parte de su día.
        </p>

    </div>
    <div class="estadisticas">


        <div class="card">

            <div class="card-icon">
                ♡
            </div>

            <div class="card-label">
                Clientes
            </div>

            <div class="card-value">
                <?php echo $totalClientes; ?>
            </div>

            <div class="card-description">
                Clientes registrados
            </div>

        </div>


        <div class="card">

            <div class="card-icon">
                ✦
            </div>

            <div class="card-label">
                Pedidos
            </div>

            <div class="card-value">
                <?php echo $totalPedidos; ?>
            </div>

            <div class="card-description">
                Pedidos realizados
            </div>

        </div>
        <div class="card">

            <div class="card-icon">
                ♛
            </div>

            <div class="card-label">
                Favorita
            </div>

            <div class="card-value">
                <?php echo htmlspecialchars($clienteTop); ?>
            </div>

            <div class="card-description">
                Cliente más frecuente
            </div>

        </div>


    </div>
    <div class="contenido">
        <div class="grafico-card">
            <div class="grafico-header">
                <h3>
                    Frecuencia de pedidos
                </h3>

                <span>
                    Ranking
                </span>

            </div>

            <div class="grafico">

                <canvas id="graficoClientes"></canvas>

            </div>

        </div>

        <div class="favorito">

            <div class="favorito-titulo">
                Cliente destacada
            </div>

            <div class="corona">
                ♛
            </div>

            <h3>
                <?php echo htmlspecialchars($clienteTop); ?>
            </h3>
            <p>
                Nuestra cliente más frecuente
            </p>

            <div class="numero-pedidos">

                <strong>
                    <?php echo $pedidosTop; ?>
                </strong>
                <span>
                    pedidos realizados
                </span>
            </div>
        </div>
    </div>
    <div class="detalle">
        DIVINE · Elegancia en cada detalle
    </div>
</div>
<script>

const nombres = <?php echo $nombresJSON; ?>;
const cantidades = <?php echo $cantidadesJSON; ?>;
const ctx =
    document.getElementById("graficoClientes");
new Chart(ctx, {

    type: "bar",

    data: {

        labels: nombres,
        datasets: [{
            label: "Pedidos",
            data: cantidades,
            backgroundColor: function(context) {
                const chart =
                    context.chart;

                const {ctx, chartArea} =
                    chart;

                if (!chartArea) {
                    return "#d59bb9";
                }

                const gradient =
                    ctx.createLinearGradient(
                        0,
                        chartArea.bottom,
                        0,
                        chartArea.top
                    );

                gradient.addColorStop(
                    0,
                    "#d9a1bc"
                );

                gradient.addColorStop(
                    1,
                    "#b981a7"
                );

                return gradient;
            },
            borderColor: "#b77f9f",
            borderWidth: 1,
            borderRadius: 10,
            borderSkipped: false,
            barPercentage: .62,
            categoryPercentage: .72
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1200,
            easing: "easeOutQuart"
        },
        scales: {

            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    color: "#a18b9a",
                    font: {
                        family: "DM Sans",
                        size: 11
                    }
                },

                grid: {
                    color:
                        "rgba(180,140,165,.12)",

                    drawBorder: false
                },

                title: {
                    display: true,
                    text: "Cantidad de pedidos",
                    color: "#9b7c90",
                    font: {
                        family: "DM Sans",
                        size: 12,
                        weight: "500"
                    }

                }

            },
            x: {
                ticks: {
                    color: "#806979",
                    font: {
                        family: "DM Sans",
                        size: 11,
                        weight: "500"

                    }

                },
                grid: {
                    display: false

                },
                title: {
                    display: true,
                    text: "Clientes",
                    color: "#9b7c90",
                    font: {
                        family: "DM Sans",
                        size: 12,
                        weight: "500"

                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor:
                    "rgba(92,67,83,.96)",
                titleColor: "#fff",
                bodyColor: "#f9eaf2",
                padding: 14,
                cornerRadius: 12,
                displayColors: false,
                titleFont: {
                    family: "Playfair Display",
                    size: 15
                },
                bodyFont: {
                    family: "DM Sans",
                    size: 12
                },
                callbacks: {
                    label: function(context) {
                        return "♡ " +
                            context.raw +
                            " pedidos";

                    }

                }

            }

      }

    }
});
</script>
</body>
</html>