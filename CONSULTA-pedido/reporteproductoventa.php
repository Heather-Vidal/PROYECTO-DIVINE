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
        $veces[] = $fila["total_vendido"];


    }


}


?>


<!DOCTYPE html>


<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Ventas</title>


    <style>


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }


        body {
            min-height: 100vh;


            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;


            background: linear-gradient(
                135deg,
                #fff5f7,
                #f8dfe5
            );


            padding: 30px;
        }


        .contenedor {


            width: 800px;
            max-width: 95%;


            background: white;


            padding: 35px;


            border-radius: 20px;


            box-shadow:
                0 15px 35px rgba(191, 116, 133, 0.20);


            border: 1px solid #f1d1d9;
        }


        h2 {


            text-align: center;


            color: #bf7485;


            margin-bottom: 30px;


            font-size: 28px;
        }


        .grafico {


            width: 100%;
            height: 400px;


        }


    </style>


</head>


<body>


    <div class="contenedor">


        <h2>Producto más vendido del mes</h2>


        <div class="grafico">


            <canvas id="graficoVentas"></canvas>


        </div>


    </div>




    <script>


        const nombres = <?php echo json_encode($nombres); ?>;


        const veces = <?php echo json_encode($veces); ?>;




        const ctx = document.getElementById('graficoVentas');




        new Chart(ctx, {


            type: 'bar',


            data: {


                labels: nombres,


                datasets: [{


                    label: 'Cantidad de productos vendidos',


                    data: veces,


                    backgroundColor: '#c96f84',


                    borderColor: '#b45d72',


                    borderWidth: 1,


                    borderRadius: 8


                }]


            },


            options: {


                responsive: true,


                maintainAspectRatio: false,


                plugins: {


                    legend: {


                        display: true


                    }


                },


                scales: {


                    y: {


                        beginAtZero: true,


                        ticks: {


                            stepSize: 1


                        },


                        title: {


                            display: true,


                            text: 'Cantidad vendida'


                        }


                    },


                    x: {


                        title: {


                            display: true,


                            text: 'Productos'


                        }


                    }


                }


            }


        });


    </script>


</body>


</html>


