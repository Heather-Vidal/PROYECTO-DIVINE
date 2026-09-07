<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// =========================================================
// OBTENER ROL ACTUAL
// =========================================================

$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';


// =========================================================
// CONSULTA DE VENTAS
// =========================================================

if ($rol == 'administrador') {

    $sql = "SELECT v.id, v.estado, v.metodo, v.costototal, v.PEDIDOS_ID, p.fecha 
            FROM VENTAS v 
            INNER JOIN PEDIDOS p ON p.ID = v.PEDIDOS_ID";

} elseif ($rol == 'vendedor') {

    $nombre = $_SESSION['nombre'];

    $sql = "SELECT v.id, v.estado, v.metodo, v.costototal, v.PEDIDOS_ID, p.fecha 
            FROM VENTAS v 
            INNER JOIN PEDIDOS p ON p.ID = v.PEDIDOS_ID 
            WHERE p.nombrevendedor = '$nombre'";

} else {

    $sql = "SELECT * FROM VENTAS WHERE 1=0";
}

$result = $conn->query($sql);


// =========================================================
// FUNCIÓN PARA OBTENER TOTALES
// =========================================================

function obtenerTotal($conn, $intervalo = null) {

    if ($intervalo === 'HOY') {

        $where = "WHERE p.fecha = CURDATE()";

    } elseif ($intervalo) {

        $where = "WHERE p.fecha >= DATE_SUB(CURDATE(), INTERVAL $intervalo)";

    } else {

        $where = "";
    }

    $query = "SELECT SUM(v.costototal) as total 
              FROM VENTAS v 
              INNER JOIN PEDIDOS p ON p.ID = v.PEDIDOS_ID $where";

    $res = $conn->query($query)->fetch_assoc();

    return $res['total'] ?? 0;
}


// =========================================================
// TOTALES
// =========================================================

$totalventadia    = obtenerTotal($conn, 'HOY');
$totalventasemana = obtenerTotal($conn, '7 DAY');
$totalventames    = obtenerTotal($conn, '30 DAY');
$totalventaanio   = obtenerTotal($conn, '365 DAY');


// =========================================================
// REGISTROS
// =========================================================

$totalRegistros = ($result) ? $result->num_rows : 0;

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard de Ventas | DIVINE</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {

    --rosa: #ee5b8b;
    --rosa-fuerte: #e9477d;
    --rosa-claro: #f8dce7;
    --rosa-palido: #fff3f7;

    --texto: #252027;
    --gris: #8c8389;
    --blanco: #ffffff;

    --borde: #f1e5ea;

    --verde: #3caf7d;

}


/* =========================================================
   RESET
========================================================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* =========================================================
   BODY
========================================================= */

body {

    min-height: 100vh;

    background: #fff;

    color: var(--texto);

    font-family: 'DM Sans', sans-serif;

    padding: 25px;

}


/* =========================================================
   CONTENEDOR
========================================================= */

.contenedor {

    width: min(1250px, 100%);

    margin: auto;

}


/* =========================================================
   CABECERA
========================================================= */

.cabecera {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 28px;

}


.titulo {

    color: var(--rosa);

    font-size: clamp(30px, 5vw, 52px);

    line-height: .95;

    font-weight: 700;

    letter-spacing: -2px;

}


.subtitulo {

    color: var(--gris);

    font-size: 13px;

    margin-top: 10px;

}


.logo {

    width: 48px;

    height: 48px;

    border-radius: 50%;

    background: var(--rosa-palido);

    color: var(--rosa);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;

    border: 1px solid var(--rosa-claro);

}


/* =========================================================
   TARJETAS PRINCIPALES
========================================================= */

.estadisticas {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 14px;

    margin-bottom: 18px;

}


.card {

    background: var(--rosa-palido);

    border: 1px solid #f8e2e9;

    border-radius: 17px;

    padding: 20px;

    min-height: 145px;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    transition: .3s ease;

}


.card:hover {

    transform: translateY(-4px);

    box-shadow: 0 12px 30px rgba(238,91,139,.12);

}


.card-icono {

    width: 37px;

    height: 37px;

    border-radius: 50%;

    background: var(--rosa);

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 17px;

}


.card-titulo {

    color: #484047;

    font-size: 10px;

    text-transform: uppercase;

    line-height: 1.3;

    margin-top: 10px;

}


.card-valor {

    color: var(--rosa-fuerte);

    font-size: 24px;

    font-weight: 700;

}


/* =========================================================
   ZONA DE GRÁFICAS
========================================================= */

.graficas {

    display: grid;

    grid-template-columns: 1.15fr .85fr;

    gap: 18px;

    margin-bottom: 18px;

}


.panel {

    background: white;

    border: 1px solid var(--borde);

    border-radius: 18px;

    padding: 20px;

}


.panel-titulo {

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    margin-bottom: 18px;

    color: #353036;

}


/* =========================================================
   GRÁFICA DE INGRESOS
========================================================= */

.grafica-linea {

    height: 210px;

    position: relative;

    display: flex;

    flex-direction: column;

    justify-content: flex-end;

}


.lineas-fondo {

    position: absolute;

    inset: 0;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

}


.linea {

    width: 100%;

    height: 1px;

    background: #f1eaed;

}


.grafica-svg {

    position: absolute;

    inset: 10px 0 20px 0;

    width: 100%;

    height: calc(100% - 30px);

}


.meses {

    position: absolute;

    bottom: 0;

    left: 0;

    width: 100%;

    display: flex;

    justify-content: space-between;

    color: #aaa1a7;

    font-size: 8px;

}


/* =========================================================
   BARRAS
========================================================= */

.barras {

    height: 210px;

    display: flex;

    flex-direction: column;

    justify-content: center;

    gap: 12px;

}


.barra-item {

    display: flex;

    align-items: center;

    gap: 8px;

}


.barra-numero {

    width: 22px;

    font-size: 9px;

    color: var(--gris);

}


.barra-contenedor {

    flex: 1;

    height: 15px;

    background: #faf0f4;

    border-radius: 3px;

    overflow: hidden;

}


.barra {

    height: 100%;

    background: var(--rosa);

    border-radius: 3px;

    animation: crecer .9s ease both;

}


.barra:nth-child(1) {
    width: 92%;
}

.barra:nth-child(2) {
    width: 78%;
}

.barra:nth-child(3) {
    width: 61%;
}

.barra:nth-child(4) {
    width: 50%;
}

.barra:nth-child(5) {
    width: 42%;
}


@keyframes crecer {

    from {
        width: 0;
    }

}


/* =========================================================
   RESUMEN INFERIOR
========================================================= */

.resumen {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;

    margin-bottom: 18px;

}


.resumen-card {

    border: 1px solid var(--borde);

    border-radius: 18px;

    padding: 22px;

    background: white;

}


.resumen-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

}


.resumen-header span {

    font-size: 10px;

    text-transform: uppercase;

    color: var(--gris);

    font-weight: 700;

}


.resumen-header strong {

    color: var(--rosa);

    font-size: 18px;

}


.progreso {

    width: 100%;

    height: 8px;

    background: #f6e9ee;

    border-radius: 20px;

    overflow: hidden;

    margin-top: 20px;

}


.progreso span {

    display: block;

    height: 100%;

    background: var(--rosa);

    border-radius: 20px;

}


.resumen-info {

    display: flex;

    justify-content: space-between;

    margin-top: 8px;

    font-size: 9px;

    color: var(--gris);

}


/* =========================================================
   HISTORIAL
========================================================= */

.historial {

    background: white;

    border: 1px solid var(--borde);

    border-radius: 20px;

    padding: 22px;

}


.historial-cabecera {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 18px;

}


.historial-titulo {

    display: flex;

    align-items: center;

    gap: 12px;

}


.historial-icono {

    width: 38px;

    height: 38px;

    border-radius: 11px;

    background: var(--rosa-palido);

    color: var(--rosa);

    display: flex;

    align-items: center;

    justify-content: center;

}


.historial h2 {

    font-size: 18px;

    color: #302a30;

}


.registros {

    background: var(--rosa-palido);

    color: var(--rosa);

    padding: 7px 12px;

    border-radius: 20px;

    font-size: 9px;

    font-weight: 700;

}


/* =========================================================
   TABLA
========================================================= */

.tabla-scroll {

    overflow-x: auto;

}


#tabla-ingresos {

    width: 100%;

    min-width: 750px;

    border-collapse: collapse;

}


#tabla-ingresos th {

    text-align: left;

    padding: 12px;

    color: #a49ba0;

    font-size: 8px;

    text-transform: uppercase;

    letter-spacing: 1px;

    border-bottom: 1px solid var(--borde);

}


#tabla-ingresos td {

    padding: 15px 12px;

    border-bottom: 1px solid #f7eef1;

    font-size: 11px;

    color: #554c52;

}


#tabla-ingresos tbody tr {

    transition: .25s ease;

}


#tabla-ingresos tbody tr:hover {

    background: #fff8fa;

}


#tabla-ingresos td:first-child {

    font-weight: 700;

    color: #352e34;

}


/* =========================================================
   ESTADO
========================================================= */

.estado {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 5px 9px;

    border-radius: 20px;

    background: #e9f8f1;

    color: var(--verde);

    font-size: 8px;

    font-weight: 700;

}


.estado::before {

    content: "";

    width: 5px;

    height: 5px;

    background: var(--verde);

    border-radius: 50%;

}


/* =========================================================
   PRECIO
========================================================= */

.precio {

    color: var(--rosa) !important;

    font-weight: 700;

}


/* =========================================================
   BOTÓN MOSTRAR
========================================================= */

a.ver1 {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 7px 11px;

    border-radius: 8px;

    background: var(--rosa-palido);

    color: var(--rosa);

    text-decoration: none;

    font-size: 9px;

    font-weight: 700;

    transition: .25s ease;

}


a.ver1::after {

    content: "→";

}


a.ver1:hover {

    background: var(--rosa);

    color: white;

}


/* =========================================================
   SIN RESULTADOS
========================================================= */

.zzz {

    text-align: center !important;

    padding: 45px !important;

    color: var(--gris) !important;

    font-style: italic;

}


/* =========================================================
   ANIMACIONES
========================================================= */

.card {

    animation: aparecer .6s ease both;

}


.card:nth-child(1) {
    animation-delay: .05s;
}

.card:nth-child(2) {
    animation-delay: .10s;
}

.card:nth-child(3) {
    animation-delay: .15s;
}

.card:nth-child(4) {
    animation-delay: .20s;
}


@keyframes aparecer {

    from {

        opacity: 0;

        transform: translateY(15px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 900px) {

    .estadisticas {

        grid-template-columns: repeat(2, 1fr);

    }

    .graficas {

        grid-template-columns: 1fr;

    }

}


@media(max-width: 600px) {

    body {

        padding: 14px;

    }

    .cabecera {

        margin-bottom: 20px;

    }

    .titulo {

        font-size: 34px;

    }

    .estadisticas {

        grid-template-columns: 1fr 1fr;

        gap: 10px;

    }

    .card {

        padding: 14px;

        min-height: 125px;

    }

    .card-valor {

        font-size: 19px;

    }

    .graficas {

        gap: 12px;

    }

    .resumen {

        grid-template-columns: 1fr;

    }

    .panel,
    .resumen-card,
    .historial {

        padding: 16px;

    }

}


@media(max-width: 400px) {

    .estadisticas {

        grid-template-columns: 1fr;

    }

    .titulo {

        font-size: 30px;

    }

}

</style>

</head>


<body>

<div class="contenedor">


    <!-- =====================================================
         CABECERA
    ====================================================== -->

    <header class="cabecera">

        <div>

            <h1 class="titulo">
                E-COMMERCE<br>
                SALES DASHBOARD
            </h1>

            <p class="subtitulo">
                Resumen general de las ventas realizadas
            </p>

        </div>


        <div class="logo">
            ♡
        </div>

    </header>


    <!-- =====================================================
         ESTADÍSTICAS
    ====================================================== -->

    <section class="estadisticas">


        <!-- TOTAL DEL DÍA -->

        <article class="card">

            <div>

                <div class="card-icono">
                    $
                </div>

                <div class="card-titulo">
                    Total Revenue
                </div>

            </div>

            <div class="card-valor">

                $<?php echo number_format($totalventadia, 2); ?>

            </div>

        </article>


        <!-- ÚLTIMOS 7 DÍAS -->

        <article class="card">

            <div>

                <div class="card-icono">
                    ▥
                </div>

                <div class="card-titulo">
                    Ventas últimos 7 días
                </div>

            </div>

            <div class="card-valor">

                $<?php echo number_format($totalventasemana, 2); ?>

            </div>

        </article>


        <!-- ÚLTIMOS 30 DÍAS -->

        <article class="card">

            <div>

                <div class="card-icono">
                    %
                </div>

                <div class="card-titulo">
                    Ventas últimos 30 días
                </div>

            </div>

            <div class="card-valor">

                $<?php echo number_format($totalventames, 2); ?>

            </div>

        </article>


        <!-- ÚLTIMOS 365 DÍAS -->

        <article class="card">

            <div>

                <div class="card-icono">
                    ✦
                </div>

                <div class="card-titulo">
                    Ventas último año
                </div>

            </div>

            <div class="card-valor">

                $<?php echo number_format($totalventaanio, 2); ?>

            </div>

        </article>


    </section>


    <!-- =====================================================
         GRÁFICAS
    ====================================================== -->

    <section class="graficas">


        <!-- =================================================
             TENDENCIA
        ================================================== -->

        <article class="panel">

            <div class="panel-titulo">
                Monthly Revenue Trend
            </div>


            <div class="grafica-linea">


                <div class="lineas-fondo">

                    <div class="linea"></div>
                    <div class="linea"></div>
                    <div class="linea"></div>
                    <div class="linea"></div>
                    <div class="linea"></div>

                </div>


                <svg
                    class="grafica-svg"
                    viewBox="0 0 600 190"
                    preserveAspectRatio="none"
                >

                    <defs>

                        <linearGradient
                            id="relleno"
                            x1="0"
                            y1="0"
                            x2="0"
                            y2="1"
                        >

                            <stop
                                offset="0%"
                                stop-color="#ee5b8b"
                                stop-opacity=".30"
                            />

                            <stop
                                offset="100%"
                                stop-color="#ee5b8b"
                                stop-opacity=".02"
                            />

                        </linearGradient>

                    </defs>


                    <path
                        d="
                        M0,135
                        C35,110 55,95 85,115
                        C115,135 125,145 155,120
                        C185,95 205,45 235,65
                        C270,90 285,115 320,105
                        C350,95 365,65 390,50
                        C420,35 445,65 470,70
                        C505,75 530,95 550,70
                        C570,50 585,60 600,40
                        L600,190
                        L0,190
                        Z
                        "
                        fill="url(#relleno)"
                    />


                    <path
                        d="
                        M0,135
                        C35,110 55,95 85,115
                        C115,135 125,145 155,120
                        C185,95 205,45 235,65
                        C270,90 285,115 320,105
                        C350,95 365,65 390,50
                        C420,35 445,65 470,70
                        C505,75 530,95 550,70
                        C570,50 585,60 600,40
                        "
                        fill="none"
                        stroke="#ee5b8b"
                        stroke-width="4"
                        stroke-linecap="round"
                    />

                </svg>


                <div class="meses">

                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                    <span>Jul</span>
                    <span>Aug</span>
                    <span>Sep</span>
                    <span>Oct</span>

                </div>


            </div>

        </article>


        <!-- =================================================
             BARRAS
        ================================================== -->

        <article class="panel">

            <div class="panel-titulo">
                Top ventas
            </div>


            <div class="barras">


                <div class="barra-item">

                    <div class="barra-numero">
                        01
                    </div>

                    <div class="barra-contenedor">

                        <div
                            class="barra"
                            style="width:92%"
                        ></div>

                    </div>

                </div>


                <div class="barra-item">

                    <div class="barra-numero">
                        02
                    </div>

                    <div class="barra-contenedor">

                        <div
                            class="barra"
                            style="width:78%"
                        ></div>

                    </div>

                </div>


                <div class="barra-item">

                    <div class="barra-numero">
                        03
                    </div>

                    <div class="barra-contenedor">

                        <div
                            class="barra"
                            style="width:61%"
                        ></div>

                    </div>

                </div>


                <div class="barra-item">

                    <div class="barra-numero">
                        04
                    </div>

                    <div class="barra-contenedor">

                        <div
                            class="barra"
                            style="width:50%"
                        ></div>

                    </div>

                </div>


                <div class="barra-item">

                    <div class="barra-numero">
                        05
                    </div>

                    <div class="barra-contenedor">

                        <div
                            class="barra"
                            style="width:42%"
                        ></div>

                    </div>

                </div>


            </div>

        </article>


    </section>


    <!-- =====================================================
         RESUMEN
    ====================================================== -->

    <section class="resumen">


        <article class="resumen-card">

            <div class="resumen-header">

                <span>
                    Rendimiento mensual
                </span>

                <strong>
                    $<?php echo number_format($totalventames, 2); ?>
                </strong>

            </div>


            <div class="progreso">

                <span style="width:75%;"></span>

            </div>


            <div class="resumen-info">

                <span>
                    Últimos 30 días
                </span>

                <span>
                    Ventas
                </span>

            </div>

        </article>


        <article class="resumen-card">

            <div class="resumen-header">

                <span>
                    Rendimiento anual
                </span>

                <strong>
                    $<?php echo number_format($totalventaanio, 2); ?>
                </strong>

            </div>


            <div class="progreso">

                <span style="width:65%;"></span>

            </div>


            <div class="resumen-info">

                <span>
                    Últimos 365 días
                </span>

                <span>
                    Total acumulado
                </span>

            </div>

        </article>


    </section>


    <!-- =====================================================
         HISTORIAL
    ====================================================== -->

    <section class="historial">


        <div class="historial-cabecera">


            <div class="historial-titulo">

                <div class="historial-icono">
                    ♡
                </div>

                <h2>
                    Historial de ventas
                </h2>

            </div>


            <div class="registros">

                <?php echo $totalRegistros; ?> registros

            </div>


        </div>


        <div class="tabla-scroll">


            <table id="tabla-ingresos">


                <thead>

                    <tr>

                        <th>
                            ID Pedido
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Método
                        </th>

                        <th>
                            Costo Total
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php

                if ($result && $result->num_rows > 0) {

                    while($fila = $result->fetch_assoc()) {

                        $idPedido = $fila["PEDIDOS_ID"];

                        echo "<tr>";


                        echo "<td>";
                        echo htmlspecialchars($fila["PEDIDOS_ID"]);
                        echo "</td>";


                        echo "<td>";

                        echo "<span class='estado'>";

                        echo htmlspecialchars($fila["estado"]);

                        echo "</span>";

                        echo "</td>";


                        echo "<td>";

                        echo htmlspecialchars($fila["metodo"]);

                        echo "</td>";


                        echo "<td class='precio'>";

                        echo "$" . number_format(
                            $fila["costototal"],
                            2
                        );

                        echo "</td>";


                        echo "<td>";

                        echo htmlspecialchars($fila["fecha"]);

                        echo "</td>";


                        echo "<td>";

                        echo "<a
                                class='ver1'
                                href='readventas1.php?idpedidos=$idPedido'
                              >
                                Mostrar
                              </a>";

                        echo "</td>";


                        echo "</tr>";

                    }

                } else {

                    echo "

                    <tr>

                        <td
                            colspan='6'
                            class='zzz'
                        >

                            No hay pedidos registrados

                        </td>

                    </tr>

                    ";

                }

                ?>


                </tbody>

            </table>


        </div>


    </section>


</div>

</body>

</html>
