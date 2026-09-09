<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión");
}


/* =========================================================
   PRODUCTO MÁS VENDIDO DEL MES
   ========================================================= */

$sql = "SELECT
            p.nombre,
            SUM(c.cantidad) AS total_vendido
        FROM VENTAS v
        INNER JOIN PEDIDOS pe
            ON v.PEDIDOS_ID = pe.ID
        INNER JOIN CARRITO c
            ON pe.ID = c.PEDIDOS_ID
        INNER JOIN PRODUCTO p
            ON c.PRODUCTO_codigo = p.codigo
        WHERE MONTH(pe.fecha) = MONTH(CURDATE())
        AND YEAR(pe.fecha) = YEAR(CURDATE())
        GROUP BY p.codigo, p.nombre
        ORDER BY total_vendido DESC";

$resultado = $conn->query($sql);

$nombres = [];
$veces = [];

if ($resultado) {

    while ($fila = $resultado->fetch_assoc()) {

        $nombres[] = $fila["nombre"];

        $veces[] = (int)$fila["total_vendido"];
    }
}


/* =========================================================
   PRODUCTOS CON BAJO STOCK
   ========================================================= */

$sqlStock = "SELECT
                codigo,
                nombre,
                stock
            FROM PRODUCTO
            WHERE stock <= 5
            ORDER BY stock ASC";

$resultadoStock = $conn->query($sqlStock);

$nombresStock = [];
$cantidadesStock = [];

if ($resultadoStock) {

    while ($fila = $resultadoStock->fetch_assoc()) {

        $nombresStock[] = $fila["nombre"];

        $cantidadesStock[] = (int)$fila["stock"];
    }
}


/* =========================================================
   OBTENER LOS 10 PRODUCTOS
   =========================================================

   El stock actual se obtiene desde PRODUCTO.stock.

   Las gráficas se generan automáticamente.
   Si existen 10 productos, aparecerán 10 gráficas.

   ========================================================= */

$sqlProductos = "SELECT
                    codigo,
                    nombre,
                    stock
                 FROM PRODUCTO
                 ORDER BY codigo ASC
                 LIMIT 10";

$resultadoProductos = $conn->query($sqlProductos);

$productos = [];

if ($resultadoProductos) {

    while ($fila = $resultadoProductos->fetch_assoc()) {

        $productos[] = [

            "codigo" => $fila["codigo"],

            "nombre" => $fila["nombre"],

            "stock" => (int)$fila["stock"]

        ];
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Ventas e Inventario</title>


    <style>


        /* =====================================================
           CONFIGURACIÓN GENERAL
           ===================================================== */

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

            font-family:
                'Segoe UI',
                'Poppins',
                sans-serif;
        }


        /* =====================================================
           CUERPO PRINCIPAL
           ===================================================== */

        body {

            min-height: 100vh;

            padding: 45px 35px;

            background:

                radial-gradient(
                    circle at top left,
                    rgba(255, 255, 255, 0.95),
                    transparent 40%
                ),

                radial-gradient(
                    circle at bottom right,
                    rgba(232, 154, 170, 0.25),
                    transparent 45%
                ),

                linear-gradient(
                    135deg,
                    #fff7f9 0%,
                    #fce9ee 45%,
                    #f7dce4 100%
                );

            color: #5f4650;

            overflow-x: hidden;
        }


        /* =====================================================
           CONTENEDOR DE LAS DOS GRÁFICAS PRINCIPALES
           ===================================================== */

        .contenedores-principales {

            width: 100%;

            max-width: 1250px;

            margin: 0 auto 35px auto;

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 30px;
        }


        /* =====================================================
           TARJETAS PRINCIPALES
           ===================================================== */

        .contenedor {

            width: 100%;

            max-width: none;

            min-width: 0;

            background:
                rgba(255, 255, 255, 0.38);

            backdrop-filter: blur(18px);

            -webkit-backdrop-filter: blur(18px);

            padding: 30px;

            border-radius: 24px;

            border:
                1px solid
                rgba(255, 255, 255, 0.70);

            box-shadow:

                0 20px 45px
                rgba(191, 116, 133, 0.16),

                inset 0 1px 0
                rgba(255, 255, 255, 0.75);

            margin-bottom: 0;

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }


        .contenedor:hover {

            transform:
                translateY(-4px);

            box-shadow:

                0 25px 55px
                rgba(191, 116, 133, 0.22),

                inset 0 1px 0
                rgba(255, 255, 255, 0.85);
        }


        /* =====================================================
           TÍTULOS
           ===================================================== */

        h2 {

            text-align: center;

            color: #b96579;

            margin-bottom: 25px;

            font-size: 25px;

            font-weight: 600;

            letter-spacing: 0.3px;
        }


        .titulo-productos {

            text-align: center;

            color: #b96579;

            margin-bottom: 28px;

            font-size: 27px;

            font-weight: 600;
        }


        /* =====================================================
           GRÁFICAS GRANDES
           ===================================================== */

        .grafico {

            width: 100%;

            height: 420px;

            position: relative;
        }


        /* =====================================================
           CONTENEDOR DE LAS 10 GRÁFICAS
           ===================================================== */

        .contenedor-productos {

            width: 100%;

            max-width: 1250px;

            margin: 0 auto 30px auto;

            background:
                rgba(255, 255, 255, 0.30);

            backdrop-filter: blur(20px);

            -webkit-backdrop-filter: blur(20px);

            padding: 32px;

            border-radius: 26px;

            border:
                1px solid
                rgba(255, 255, 255, 0.70);

            box-shadow:

                0 20px 50px
                rgba(191, 116, 133, 0.15),

                inset 0 1px 0
                rgba(255, 255, 255, 0.75);
        }


        /* =====================================================
           GRID DE LAS 10 GRÁFICAS
           ===================================================== */

        .grid-productos {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 25px;
        }


        /* =====================================================
           TARJETA DE CADA PRODUCTO
           ===================================================== */

        .producto-grafica {

            position: relative;

            background:
                rgba(255, 255, 255, 0.20);

            backdrop-filter: blur(15px);

            -webkit-backdrop-filter: blur(15px);

            border:
                1px solid
                rgba(255, 255, 255, 0.60);

            border-radius: 20px;

            padding: 20px;

            box-shadow:

                0 10px 30px
                rgba(191, 116, 133, 0.10),

                inset 0 1px 0
                rgba(255, 255, 255, 0.65);

            transition:

                transform 0.3s ease,

                box-shadow 0.3s ease,

                background 0.3s ease;

            overflow: hidden;
        }


        /* =====================================================
           BRILLO DECORATIVO
           ===================================================== */

        .producto-grafica::before {

            content: "";

            position: absolute;

            top: -60px;

            right: -60px;

            width: 130px;

            height: 130px;

            border-radius: 50%;

            background:
                rgba(232, 154, 170, 0.12);

            pointer-events: none;
        }


        /* =====================================================
           EFECTO HOVER
           ===================================================== */

        .producto-grafica:hover {

            transform:
                translateY(-5px);

            background:
                rgba(255, 255, 255, 0.35);

            box-shadow:

                0 18px 35px
                rgba(191, 116, 133, 0.18),

                inset 0 1px 0
                rgba(255, 255, 255, 0.80);
        }


        /* =====================================================
           NOMBRE DEL PRODUCTO
           ===================================================== */

        .producto-grafica h3 {

            position: relative;

            z-index: 2;

            text-align: center;

            color: #b96579;

            font-size: 18px;

            font-weight: 600;

            margin-bottom: 15px;

            min-height: 45px;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 0 10px;
        }


        /* =====================================================
           GRÁFICAS PEQUEÑAS
           ===================================================== */

        .grafico-producto {

            width: 100%;

            height: 230px;

            position: relative;

            z-index: 2;
        }


        /* =====================================================
           INFORMACIÓN DEL STOCK
           ===================================================== */

        .stock-info {

            position: relative;

            z-index: 2;

            text-align: center;

            margin-top: 12px;

            padding-top: 12px;

            border-top:
                1px solid
                rgba(191, 116, 133, 0.12);

            font-size: 14px;

            color: #866c75;

            letter-spacing: 0.2px;
        }


        .stock-numero {

            display: inline-block;

            margin: 0 4px;

            color: #c45f77;

            font-size: 21px;

            font-weight: 700;
        }


        /* =====================================================
           CANVAS TRANSPARENTE
           ===================================================== */

        canvas {

            background:
                transparent !important;
        }


        /* =====================================================
           SCROLLBAR
           ===================================================== */

        ::-webkit-scrollbar {

            width: 9px;

            height: 9px;
        }


        ::-webkit-scrollbar-track {

            background:
                rgba(255, 255, 255, 0.30);
        }


        ::-webkit-scrollbar-thumb {

            background:

                linear-gradient(
                    180deg,
                    #d98a9d,
                    #bd687d
                );

            border-radius: 20px;
        }


        ::-webkit-scrollbar-thumb:hover {

            background:
                #b85e74;
        }


        /* =====================================================
           TABLETS
           ===================================================== */

        @media (max-width: 950px) {

            body {

                padding:
                    30px 20px;
            }


            .contenedores-principales {

                grid-template-columns:
                    1fr;

                max-width: 800px;
            }


            .contenedor-productos {

                max-width: 800px;
            }


            .grid-productos {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }


        /* =====================================================
           CELULARES
           ===================================================== */

        @media (max-width: 600px) {

            body {

                padding:
                    20px 12px;
            }


            .contenedor {

                padding: 22px;

                border-radius: 20px;
            }


            .contenedor-productos {

                padding: 20px;

                border-radius: 20px;
            }


            .contenedores-principales {

                gap: 20px;

                margin-bottom: 25px;
            }


            .grid-productos {

                grid-template-columns:
                    1fr;

                gap: 18px;
            }


            h2 {

                font-size: 21px;

                margin-bottom: 20px;
            }


            .titulo-productos {

                font-size: 23px;
            }


            .grafico {

                height: 320px;
            }


            .grafico-producto {

                height: 220px;
            }


            .producto-grafica {

                padding: 17px;
            }
        }

    </style>

</head>


<body>


    <!-- =====================================================
         GRÁFICAS PRINCIPALES
         ===================================================== -->

    <div class="contenedores-principales">


        <!-- =================================================
             PRODUCTO MÁS VENDIDO
             ================================================= -->

        <div class="contenedor">

            <h2>
                Producto más vendido del mes
            </h2>

            <div class="grafico">

                <canvas id="graficoVentas"></canvas>

            </div>

        </div>


        <!-- =================================================
             PRODUCTOS CON BAJO STOCK
             ================================================= -->

        <div class="contenedor">

            <h2>
                Productos con bajo stock
            </h2>

            <div class="grafico">

                <canvas id="graficoStock"></canvas>

            </div>

        </div>


    </div>



    <!-- =====================================================
         10 GRÁFICAS DINÁMICAS
         ===================================================== -->

    <div class="contenedor-productos">


        <h2 class="titulo-productos">

            Stock de productos

        </h2>


        <div class="grid-productos">


            <?php if (count($productos) > 0): ?>


                <?php foreach ($productos as $indice => $producto): ?>


                    <div class="producto-grafica">


                        <h3>

                            <?php

                            echo htmlspecialchars(
                                $producto["nombre"]
                            );

                            ?>

                        </h3>


                        <div class="grafico-producto">


                            <canvas
                                id="graficoProducto<?php echo $indice; ?>"
                            >
                            </canvas>


                        </div>


                        <div class="stock-info">

                            Stock actual:

                            <span class="stock-numero">

                                <?php

                                echo $producto["stock"];

                                ?>

                            </span>

                            unidades

                        </div>


                    </div>


                <?php endforeach; ?>


            <?php else: ?>


                <p>

                    No existen productos registrados.

                </p>


            <?php endif; ?>


        </div>


    </div>



    <script>


        /* =====================================================
           GRÁFICO PRODUCTO MÁS VENDIDO DEL MES
           ===================================================== */

        const nombres =
            <?php echo json_encode($nombres); ?>;


        const veces =
            <?php echo json_encode($veces); ?>;


        const ctx =
            document.getElementById(
                'graficoVentas'
            );


        new Chart(ctx, {


            type: 'pie',


            data: {


                labels: nombres,


                datasets: [{

                    label:
                        'Cantidad de productos vendidos',

                    data:
                        veces,

                    backgroundColor:
                        '#c96f84',

                    borderColor:
                        '#b45d72',

                    borderWidth:
                        1,

                    borderRadius:
                        8

                }]

            },


            options: {


                responsive:
                    true,


                maintainAspectRatio:
                    false,


                plugins: {


                    legend: {

                        display:
                            true

                    }

                },


                scales: {


                    y: {


                        beginAtZero:
                            true,


                        ticks: {

                            stepSize:
                                1

                        },


                        title: {

                            display:
                                true,

                            text:
                                'Cantidad vendida'

                        }

                    },


                    x: {


                        title: {

                            display:
                                true,

                            text:
                                'Productos'

                        }

                    }

                }

            }

        });



        /* =====================================================
           GRÁFICO PRODUCTOS CON BAJO STOCK
           ===================================================== */

        const nombresStock =
            <?php echo json_encode($nombresStock); ?>;


        const cantidadesStock =
            <?php echo json_encode($cantidadesStock); ?>;


        const ctxStock =
            document.getElementById(
                'graficoStock'
            );


        new Chart(ctxStock, {


            type: 'bar',


            data: {


                labels:
                    nombresStock,


                datasets: [{


                    label:
                        'Cantidad disponible',


                    data:
                        cantidadesStock,


                    backgroundColor:
                        '#e89aaa',


                    borderColor:
                        '#c96f84',


                    borderWidth:
                        1,


                    borderRadius:
                        8

                }]

            },


            options: {


                responsive:
                    true,


                maintainAspectRatio:
                    false,


                plugins: {


                    legend: {

                        display:
                            true

                    }

                },


                scales: {


                    y: {


                        beginAtZero:
                            true,


                        ticks: {

                            stepSize:
                                1

                        },


                        title: {

                            display:
                                true,

                            text:
                                'Cantidad en stock'

                        }

                    },


                    x: {


                        title: {

                            display:
                                true,

                            text:
                                'Productos'

                        }

                    }

                }

            }

        });



        /* =====================================================
           10 GRÁFICAS DINÁMICAS DE STOCK
           ===================================================== */

        const productos =
            <?php echo json_encode($productos); ?>;


        productos.forEach(

            function(producto, indice) {


                const canvas =
                    document.getElementById(
                        'graficoProducto' +
                        indice
                    );


                if (!canvas) {

                    return;

                }


                new Chart(canvas, {


                    type: 'bar',


                    data: {


                        labels:
                            ['Stock disponible'],


                        datasets: [{


                            label:
                                producto.nombre,


                            data:
                                [producto.stock],


                            backgroundColor:
                                '#d98295',


                            borderColor:
                                '#b45d72',


                            borderWidth:
                                1,


                            borderRadius:
                                8,


                            barThickness:
                                55

                        }]

                    },


                    options: {


                        responsive:
                            true,


                        maintainAspectRatio:
                            false,


                        plugins: {


                            legend: {

                                display:
                                    false

                            },


                            tooltip: {


                                callbacks: {


                                    label:
                                        function(context) {


                                            return (
                                                ' Stock: ' +
                                                context.raw +
                                                ' unidades'
                                            );

                                        }

                                }

                            }

                        },


                        scales: {


                            y: {


                                beginAtZero:
                                    true,


                                ticks: {

                                    stepSize:
                                        1

                                },


                                title: {


                                    display:
                                        true,


                                    text:
                                        'Unidades'

                                }

                            },


                            x: {


                                title: {


                                    display:
                                        true,


                                    text:
                                        'Estado del producto'

                                }

                            }

                        }

                    }

                });

            }

        );

    </script>


</body>

</html>