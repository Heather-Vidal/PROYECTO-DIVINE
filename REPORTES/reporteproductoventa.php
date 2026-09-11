<?php

session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);

if ($conn->connect_error) {
    die("Error de conexión");
}


/* =========================================================
   PRODUCTOS MÁS VENDIDOS DEL MES
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
<<<<<<< HEAD


=======
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b
        ORDER BY total_vendido DESC";

$resultado = $conn->query($sql);

$nombres = [];
$veces = [];

if ($resultado) {

    while ($fila = $resultado->fetch_assoc()) {

        $nombres[] =
            $fila["nombre"];

        $veces[] =
            (int)$fila["total_vendido"];

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

<<<<<<< HEAD

$resultadoStock = $conn->query($sqlStock);
=======
$resultadoStock =
    $conn->query($sqlStock);
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

$nombresStock = [];
$cantidadesStock = [];

if ($resultadoStock) {

<<<<<<< HEAD
    while ($fila = $resultadoStock->fetch_assoc()) {

        $nombresStock[] = $fila["nombre"];
        $cantidadesStock[] = $fila["stock"];
=======
    while ($fila =
        $resultadoStock->fetch_assoc()) {

        $nombresStock[] =
            $fila["nombre"];

        $cantidadesStock[] =
            (int)$fila["stock"];
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

    }

}


/* =========================================================
   PRODUCTOS
   ========================================================= */

$sqlProductos = "SELECT
                    codigo,
                    nombre,
                    stock
                 FROM PRODUCTO
                 ORDER BY codigo ASC
                 LIMIT 10";

$resultadoProductos =
    $conn->query($sqlProductos);

$productos = [];

if ($resultadoProductos) {

    while ($fila =
        $resultadoProductos->fetch_assoc()) {

        $productos[] = [

            "codigo" =>
                $fila["codigo"],

            "nombre" =>
                $fila["nombre"],

            "stock" =>
                (int)$fila["stock"]

        ];

    }

}


/* =========================================================
   ESTADÍSTICAS
   ========================================================= */

$totalProductos =
    count($productos);

$totalBajoStock =
    count($nombresStock);

$totalVendido =
    array_sum($veces);

$productoTop =
    count($nombres) > 0
        ? $nombres[0]
        : "Sin datos";

$cantidadTop =
    count($veces) > 0
        ? $veces[0]
        : 0;

?>

<!DOCTYPE html>

<html lang="es">

<head>
<<<<<<< HEAD

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Ventas e Inventario</title>


    <style>
=======

<meta charset="UTF-8">
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<<<<<<< HEAD
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

            margin-bottom: 30px;
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
=======
<title>
    DIVINE | Dashboard
</title>


<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
>


<script
    src="https://cdn.jsdelivr.net/npm/chart.js">
</script>


<style>

/* =========================================================
   RESET
   ========================================================= */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

}


/* =========================================================
   VARIABLES
   ========================================================= */

:root {

    --vino:
        #542c3d;

    --vino-dark:
        #3d202d;

    --vino-light:
        #81556a;

    --rosa:
        #c48a9e;

    --rosa-soft:
        #ead7de;

    --crema:
        #f8f3ed;

    --marfil:
        #fffdfa;

    --dorado:
        #b79662;

    --texto:
        #55434b;

    --gris:
        #9c8d94;

    --linea:
        #eadfe2;

}


/* =========================================================
   BODY
   ========================================================= */

body {

    min-height:
        100vh;

    background:

        radial-gradient(
            circle at 5% 0%,
            rgba(216,178,192,.28),
            transparent 25%
        ),

        radial-gradient(
            circle at 100% 100%,
            rgba(183,150,98,.10),
            transparent 25%
        ),

        var(--crema);

    color:
        var(--texto);

    font-family:
        "DM Sans",
        sans-serif;

}


/* =========================================================
   CONTENEDOR GENERAL
   ========================================================= */

.dashboard {

    width:
        min(1440px, 94%);

    margin:
        auto;

}


/* =========================================================
   HEADER
   ========================================================= */

.header {

    min-height:
        105px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    border-bottom:
        1px solid var(--linea);

}


/* =========================================================
   BRAND
   ========================================================= */

.brand {

    display:
        flex;

    align-items:
        center;

    gap:
        14px;

}


.logo {

    width:
        48px;

    height:
        48px;

    border-radius:
        50%;

    background:
        var(--vino);

    color:
        white;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        27px;

    box-shadow:
        0 8px 20px
        rgba(84,44,61,.18);

}


.brand-name {

    color:
        var(--vino);

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        25px;

    font-weight:
        600;

    letter-spacing:
        2px;

}


.brand-sub {

    color:
        var(--rosa);

    display:
        block;

    font-size:
        9px;

    text-transform:
        uppercase;

    letter-spacing:
        3px;

}


/* =========================================================
   HEADER RIGHT
   ========================================================= */

.header-right {

    display:
        flex;

    align-items:
        center;

    gap:
        15px;

}


.status {

    display:
        flex;

    align-items:
        center;

    gap:
        7px;

    font-size:
        10px;

    text-transform:
        uppercase;

    letter-spacing:
        1.5px;

    color:
        #88777e;

}


.status-dot {

    width:
        7px;

    height:
        7px;

    background:
        #9bba8d;

    border-radius:
        50%;

    box-shadow:
        0 0 0 4px
        rgba(155,186,141,.12);

}


/* =========================================================
   HERO
   ========================================================= */

.hero {

    display:
        grid;

    grid-template-columns:
        1fr 390px;

    gap:
        30px;

    padding:
        48px 0 35px;

}


.hero-left small {

    color:
        var(--dorado);

    font-size:
        10px;

    font-weight:
        700;

    letter-spacing:
        4px;

    text-transform:
        uppercase;

}


.hero-left h1 {

    font-family:
        "Cormorant Garamond",
        serif;

    color:
        var(--vino);

    font-size:
        clamp(48px, 6vw, 76px);

    font-weight:
        500;

    line-height:
        .92;

    margin-top:
        8px;

}


.hero-left h1 em {

    color:
        var(--rosa);

    font-weight:
        400;

}


.hero-left p {

    max-width:
        580px;

    margin-top:
        18px;

    color:
        var(--gris);

    font-size:
        13px;

    line-height:
        1.7;

}


/* =========================================================
   HERO FEATURE
   ========================================================= */

.hero-feature {

    position:
        relative;

    overflow:
        hidden;

    background:
        var(--vino);

    color:
        white;

    border-radius:
        3px;

    padding:
        27px;

    min-height:
        175px;

    box-shadow:
        0 18px 35px
        rgba(84,44,61,.15);

}


.hero-feature::before {

    content:
        "";

    position:
        absolute;

    width:
        190px;

    height:
        190px;

    border:
        1px solid
        rgba(255,255,255,.12);

    border-radius:
        50%;

    right:
        -80px;

    top:
        -85px;

}


.hero-feature::after {

    content:
        "";

    position:
        absolute;

    width:
        120px;

    height:
        120px;

    border:
        1px solid
        rgba(255,255,255,.08);

    border-radius:
        50%;

    right:
        -35px;

    top:
        -35px;

}


.feature-label {

    color:
        #d5bda4;

    text-transform:
        uppercase;

    letter-spacing:
        2px;

    font-size:
        9px;

}


.feature-title {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        28px;

    margin-top:
        9px;

    position:
        relative;

    z-index:
        2;

}


.feature-value {

    margin-top:
        7px;

    font-size:
        12px;

    color:
        #d7c6cd;

}


/* =========================================================
   KPI
   ========================================================= */

.kpis {

    display:
        grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap:
        15px;

    margin-bottom:
        20px;

}


.kpi {

    background:
        var(--marfil);

    border:
        1px solid var(--linea);

    padding:
        22px;

    min-height:
        135px;

    position:
        relative;

    overflow:
        hidden;

}


.kpi::after {

    content:
        "";

    position:
        absolute;

    width:
        75px;

    height:
        75px;

    border-radius:
        50%;

    background:
        var(--rosa-soft);

    opacity:
        .5;

    right:
        -25px;

    top:
        -25px;

}


.kpi-top {

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        center;

}


.kpi-label {

    color:
        var(--gris);

    font-size:
        9px;

    text-transform:
        uppercase;

    letter-spacing:
        1.8px;

}


.kpi-icon {

    color:
        var(--rosa);

    font-size:
        17px;

}


.kpi-number {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        38px;

    color:
        var(--vino);

    margin-top:
        8px;

    line-height:
        1;

}


.kpi-description {

    color:
        #b1a2a8;

    font-size:
        10px;

    margin-top:
        7px;

}


/* =========================================================
   MAIN GRID
   ========================================================= */

.main-grid {

    display:
        grid;

    grid-template-columns:
        minmax(0, 1.55fr)
        minmax(300px, .75fr);

    gap:
        20px;

}


/* =========================================================
   PANEL
   ========================================================= */

.panel {

    background:
        var(--marfil);

    border:
        1px solid var(--linea);

    padding:
        27px;

}


.panel-head {

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        flex-start;

    margin-bottom:
        25px;

}


.panel-kicker {

    color:
        var(--dorado);

    font-size:
        9px;

    letter-spacing:
        2px;

    text-transform:
        uppercase;

}


.panel-title {

    color:
        var(--vino);

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        28px;

    font-weight:
        600;

    margin-top:
        3px;

}


.panel-description {

    color:
        #aa9ba2;

    font-size:
        10px;

    margin-top:
        3px;

}


.panel-badge {

    background:
        #f5e9ee;

    color:
        var(--vino-light);

    padding:
        7px 11px;

    font-size:
        9px;

    text-transform:
        uppercase;

    letter-spacing:
        1px;

}


/* =========================================================
   CHART
   ========================================================= */

.chart {

    height:
        410px;

    position:
        relative;

}


/* =========================================================
   SIDE PANEL
   ========================================================= */

.side-panel {

    background:
        var(--vino);

    color:
        white;

    padding:
        28px;

    position:
        relative;

    overflow:
        hidden;

}


.side-panel::before {

    content:
        "";

    position:
        absolute;

    width:
        280px;

    height:
        280px;

    border:
        1px solid
        rgba(255,255,255,.07);

    border-radius:
        50%;

    right:
        -150px;

    bottom:
        -130px;

}


.side-kicker {

    color:
        #d2af7c;

    font-size:
        9px;

    letter-spacing:
        3px;

    text-transform:
        uppercase;

}


.side-title {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        32px;

    line-height:
        1;

    margin-top:
        8px;

}


.side-sub {

    color:
        #cdbbc3;

    font-size:
        11px;

    line-height:
        1.6;

    margin-top:
        10px;

}


/* =========================================================
   TOP PRODUCT
   ========================================================= */

.top-product {

    margin-top:
        35px;

    padding-top:
        25px;

    border-top:
        1px solid
        rgba(255,255,255,.12);

}


.crown {

    width:
        52px;

    height:
        52px;

    border:
        1px solid
        rgba(214,175,124,.5);

    color:
        #d6af7c;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    font-size:
        21px;

    margin-bottom:
        15px;

}


.top-product h3 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        31px;

    font-weight:
        500;

    word-break:
        break-word;

}


.top-product p {

    color:
        #c7b5bd;

    font-size:
        10px;

    margin-top:
        4px;

}


.top-number {

    display:
        flex;

    align-items:
        baseline;

    gap:
        8px;

    margin-top:
        24px;

}


.top-number strong {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        45px;

    font-weight:
        500;

    color:
        #e2c495;

}


.top-number span {

    color:
        #c5b2ba;

    font-size:
        10px;

}


/* =========================================================
   STOCK SECTION
   ========================================================= */

.stock-section {

    margin-top:
        20px;

    background:
        var(--marfil);

    border:
        1px solid var(--linea);

    padding:
        28px;

}


.stock-heading {

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        flex-end;

    margin-bottom:
        24px;

}


.stock-heading h2 {

    color:
        var(--vino);

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        30px;

    font-weight:
        600;

}


.stock-heading p {

    color:
        #a6949c;

    font-size:
        10px;

    margin-top:
        3px;

}


.stock-heading span {

    color:
        var(--dorado);

    font-size:
        9px;

    text-transform:
        uppercase;

    letter-spacing:
        1.5px;

}


/* =========================================================
   PRODUCTS
   ========================================================= */

.products {

    display:
        grid;

    grid-template-columns:
        repeat(5, 1fr);

    gap:
        12px;

}


.product {

    border:
        1px solid var(--linea);

    background:
        #fff;

    padding:
        16px;

    min-height:
        170px;

    transition:
        .25s ease;

}


.product:hover {

    transform:
        translateY(-4px);

    box-shadow:
        0 12px 25px
        rgba(84,44,61,.08);

    border-color:
        #d8bcc7;

}


.product-code {

    color:
        #c3a4b0;

    font-size:
        8px;

    text-transform:
        uppercase;

    letter-spacing:
        1px;

}


.product-name {

    color:
        var(--vino);

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        19px;

    line-height:
        1.05;

    min-height:
        42px;

    margin-top:
        9px;

    font-weight:
        600;

}


.product-line {

    height:
        1px;

    background:
        #eee5e8;

    margin:
        13px 0;

}


.product-stock-label {

    color:
        #a899a0;

    font-size:
        8px;

    text-transform:
        uppercase;

    letter-spacing:
        1px;

}


.product-stock {

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        center;

    margin-top:
        3px;

}


.product-stock strong {

    color:
        var(--vino);

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        29px;

    font-weight:
        600;

}


.stock-status {

    font-size:
        8px;

    padding:
        5px 7px;

    background:
        #edf5ea;

    color:
        #6f9065;

}


.stock-status.low {

    background:
        #f9e9e6;

    color:
        #bd655b;

}


/* =========================================================
   STOCK BAR
   ========================================================= */

.bar {

    height:
        4px;

    background:
        #eee7e9;

    margin-top:
        12px;

}


.bar-fill {

    height:
        100%;

    background:
        linear-gradient(
            90deg,
            #d5a9b9,
            #82536a
        );

}


.bar-fill.low {

    background:
        linear-gradient(
            90deg,
            #dfa59d,
            #bd665c
        );

}


/* =========================================================
   FOOTER
   ========================================================= */

.footer {

    padding:
        28px 0 35px;

    text-align:
        center;

    color:
        #b19da5;

    font-size:
        9px;

    letter-spacing:
        2px;

    text-transform:
        uppercase;

}


.footer b {

    color:
        var(--vino);

}


/* =========================================================
   RESPONSIVE 1100
   ========================================================= */

@media(max-width:1100px) {

    .products {

        grid-template-columns:
            repeat(3, 1fr);

    }

}


/* =========================================================
   RESPONSIVE 900
   ========================================================= */

@media(max-width:900px) {

    .hero {

        grid-template-columns:
            1fr;

    }


    .main-grid {

        grid-template-columns:
            1fr;

    }


    .side-panel {

        min-height:
            auto;

    }


    .kpis {

        grid-template-columns:
            repeat(3, 1fr);

    }

}


/* =========================================================
   RESPONSIVE 650
   ========================================================= */

@media(max-width:650px) {

    .dashboard {

        width:
            92%;

    }


    .header {

        min-height:
            80px;

    }


    .header-right {

        display:
            none;

    }


    .hero {

        padding:
            35px 0 25px;

    }


    .hero-left h1 {

        font-size:
            51px;

    }


    .hero-feature {

        padding:
            23px;

    }


    .kpis {

        grid-template-columns:
            1fr;

    }


    .panel {

        padding:
            20px;

    }


    .panel-head {

        margin-bottom:
            15px;

    }


    .panel-title {

        font-size:
            25px;

    }


    .chart {

        height:
            330px;

    }


    .stock-section {

        padding:
            20px;

    }


    .products {

        grid-template-columns:
            repeat(2, 1fr);

    }


    .stock-heading {

        display:
            block;

    }


    .stock-heading span {

        display:
            block;

        margin-top:
            7px;

    }

}


/* =========================================================
   RESPONSIVE 420
   ========================================================= */

@media(max-width:420px) {

    .products {

        grid-template-columns:
            1fr;

    }


    .hero-left h1 {

        font-size:
            44px;

    }


    .hero-feature {

        min-height:
            155px;

    }


    .chart {

        height:
            290px;

    }

}

</style>

</head>


<body>

<<<<<<< HEAD

    <!-- =====================================================
         PRODUCTO MÁS VENDIDO DEL MES
         ===================================================== -->
=======
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

<div class="dashboard">


<<<<<<< HEAD
        <div class="grafico">

            <canvas id="graficoVentas"></canvas>

        </div>

    </div>



    <!-- =====================================================
         PRODUCTOS CON BAJO STOCK
         ===================================================== -->

    <div class="contenedor">

        <h2>Productos con bajo stock</h2>

        <div class="grafico">

            <canvas id="graficoStock"></canvas>

        </div>

    </div>



    <script>
=======
<!-- =====================================================
     HEADER
     ===================================================== -->

<header class="header">


    <div class="brand">


        <div class="logo">
            D
        </div>


        <div>

            <div class="brand-name">
                DIVINE
            </div>

            <span class="brand-sub">
                Beauty & Elegance
            </span>

        </div>


    </div>


    <div class="header-right">


        <div class="status">

            <span class="status-dot"></span>

            Sistema activo

        </div>


    </div>


</header>
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b



<!-- =====================================================
     HERO
     ===================================================== -->

<section class="hero">


    <div class="hero-left">

<<<<<<< HEAD
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
=======

        <small>
            Dashboard · Analytics
        </small>


        <h1>

            Ventas
            <em>&</em>
            inventario

        </h1>


        <p>

            Una mirada elegante y precisa al rendimiento
            de tus productos, las ventas del mes y el
            estado actual de tu inventario.

        </p>


    </div>


    <div class="hero-feature">


        <div class="feature-label">
            Producto destacado
        </div>


        <div class="feature-title">

            <?php

            echo htmlspecialchars(
                $productoTop
            );

            ?>

        </div>


        <div class="feature-value">

            <?php echo $cantidadTop; ?>

            unidades vendidas este mes

        </div>


    </div>


</section>



<!-- =====================================================
     KPI
     ===================================================== -->

<section class="kpis">


    <div class="kpi">


        <div class="kpi-top">

            <span class="kpi-label">
                Productos
            </span>

            <span class="kpi-icon">
                ♡
            </span>

        </div>


        <div class="kpi-number">

            <?php
            echo $totalProductos;
            ?>

        </div>


        <div class="kpi-description">

            Productos registrados en el panel

        </div>


    </div>



    <div class="kpi">


        <div class="kpi-top">

            <span class="kpi-label">
                Ventas del mes
            </span>

            <span class="kpi-icon">
                ✦
            </span>

        </div>


        <div class="kpi-number">

            <?php
            echo $totalVendido;
            ?>

        </div>


        <div class="kpi-description">

            Unidades vendidas durante este mes

        </div>


    </div>



    <div class="kpi">


        <div class="kpi-top">

            <span class="kpi-label">
                Atención
            </span>

            <span class="kpi-icon">
                !
            </span>

        </div>


        <div class="kpi-number">

            <?php
            echo $totalBajoStock;
            ?>

        </div>


        <div class="kpi-description">

            Productos que necesitan reposición

        </div>


    </div>


</section>



<!-- =====================================================
     GRÁFICAS PRINCIPALES
     ===================================================== -->

<section class="main-grid">


    <!-- =================================================
         GRÁFICA VENTAS
         ================================================= -->

    <div class="panel">


        <div class="panel-head">


            <div>

                <div class="panel-kicker">
                    Rendimiento
                </div>

                <div class="panel-title">
                    Productos más vendidos
                </div>

                <div class="panel-description">

                    Comparativa de unidades vendidas
                    durante el mes actual.

                </div>

            </div>


            <div class="panel-badge">
                Mensual
            </div>


        </div>


        <div class="chart">

            <canvas
                id="graficoVentas">
            </canvas>

        </div>


    </div>



    <!-- =================================================
         PANEL TOP PRODUCT
         ================================================= -->

    <aside class="side-panel">


        <div class="side-kicker">
            Ranking #1
        </div>


        <div class="side-title">
            Favorito de DIVINE
        </div>


        <div class="side-sub">

            El producto que lidera las ventas
            durante el periodo seleccionado.

        </div>


        <div class="top-product">


            <div class="crown">
                ♛
            </div>


            <h3>

                <?php

                echo htmlspecialchars(
                    $productoTop
                );

                ?>

            </h3>


            <p>
                Producto más vendido
            </p>


            <div class="top-number">


                <strong>

                    <?php
                    echo $cantidadTop;
                    ?>

                </strong>


                <span>
                    unidades vendidas
                </span>


            </div>


        </div>


    </aside>


</section>



<!-- =====================================================
     BAJO STOCK
     ===================================================== -->

<section
    class="panel"
    style="margin-top:20px;"
>


    <div class="panel-head">


        <div>

            <div class="panel-kicker">
                Inventario
            </div>

            <div class="panel-title">
                Productos con bajo stock
            </div>

            <div class="panel-description">

                Productos que actualmente cuentan
                con cinco unidades o menos.

            </div>

        </div>


        <div
            class="panel-badge"
            style="
                background:#f9e9e6;
                color:#bd655b;
            "
        >

            <?php
            echo $totalBajoStock;
            ?>
            alertas

        </div>


    </div>


    <div
        class="chart"
        style="height:330px;"
    >

        <canvas
            id="graficoStock">
        </canvas>

    </div>


</section>



<!-- =====================================================
     INVENTARIO
     ===================================================== -->

<section class="stock-section">


    <div class="stock-heading">


        <div>

            <h2>
                Inventario actual
            </h2>

            <p>
                Vista rápida del stock disponible por producto.
            </p>

        </div>


        <span>
            10 productos
        </span>


    </div>


    <div class="products">


        <?php if (
            count($productos) > 0
        ): ?>


            <?php foreach (
                $productos
                as $indice => $producto
            ): ?>


                <?php

                $stock =
                    $producto["stock"];

                $porcentaje =
                    min(
                        ($stock / 20) * 100,
                        100
                    );

                $bajo =
                    $stock <= 5;

                ?>


                <article class="product">


                    <div class="product-code">

                        Código
                        <?php
                        echo htmlspecialchars(
                            $producto["codigo"]
                        );
                        ?>

                    </div>


                    <div class="product-name">

                        <?php

                        echo htmlspecialchars(
                            $producto["nombre"]
                        );

                        ?>

                    </div>


                    <div class="product-line">
                    </div>


                    <div class="product-stock-label">

                        Stock disponible

                    </div>


                    <div class="product-stock">


                        <strong>

                            <?php
                            echo $stock;
                            ?>

                        </strong>


                        <span
                            class="stock-status
                            <?php
                            echo $bajo
                                ? 'low'
                                : '';
                            ?>"
                        >

                            <?php

                            echo $bajo
                                ? 'Bajo'
                                : 'Disponible';

                            ?>

                        </span>


                    </div>


                    <div class="bar">


                        <div
                            class="bar-fill
                            <?php
                            echo $bajo
                                ? 'low'
                                : '';
                            ?>"
                            style="
                                width:
                                <?php
                                echo $porcentaje;
                                ?>%;
                            "
                        >
                        </div>


                    </div>


                </article>


            <?php endforeach; ?>


        <?php else: ?>


            <p>
                No existen productos registrados.
            </p>


        <?php endif; ?>


    </div>


</section>



<!-- =====================================================
     FOOTER
     ===================================================== -->

<footer class="footer">

    <b>DIVINE</b>

    &nbsp;·&nbsp;

    Beauty & Elegance

    &nbsp;·&nbsp;

    Panel administrativo

</footer>


</div>



<script>


/* =========================================================
   DATOS PHP → JAVASCRIPT
   ========================================================= */

const nombres =
    <?php

    echo json_encode(
        $nombres,
        JSON_UNESCAPED_UNICODE
    );

    ?>;


const cantidades =
    <?php

    echo json_encode(
        $veces
    );

    ?>;


const nombresStock =
    <?php

    echo json_encode(
        $nombresStock,
        JSON_UNESCAPED_UNICODE
    );

    ?>;


const cantidadesStock =
    <?php

    echo json_encode(
        $cantidadesStock
    );

    ?>;


/* =========================================================
   GRÁFICA DE VENTAS
   ========================================================= */

const ctxVentas =
    document.getElementById(
        "graficoVentas"
    );


new Chart(
    ctxVentas,
    {

        type:
            "bar",

        data: {

            labels:
                nombres,

            datasets: [{

                data:
                    cantidades,

                backgroundColor:
                    function(context) {

                        const chart =
                            context.chart;

                        const {
                            ctx,
                            chartArea
                        } =
                            chart;

                        if (!chartArea) {

                            return "#9b617b";

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
                            "#c991a5"
                        );

                        gradient.addColorStop(
                            1,
                            "#603447"
                        );

                        return gradient;

                    },

                borderWidth:
                    0,

                borderRadius:
                    5,

                borderSkipped:
                    false,

                barPercentage:
                    .55,

                categoryPercentage:
                    .70

            }]

        },


        options: {

            responsive:
                true,

            maintainAspectRatio:
                false,


            animation: {

                duration:
                    1100,

                easing:
                    "easeOutQuart"

            },


            scales: {

                y: {

                    beginAtZero:
                        true,

                    ticks: {

                        stepSize:
                            1,

                        color:
                            "#9d8d95",

                        font: {

                            family:
                                "DM Sans",

                            size:
                                10

                        }

                    },

                    grid: {

                        color:
                            "rgba(84,44,61,.07)",

                        drawBorder:
                            false
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

                    }

                },

<<<<<<< HEAD
                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            stepSize: 1

                        },

                        title: {

                            display: true,

                            text: 'Cantidad vendida'
=======

                x: {

                    ticks: {

                        color:
                            "#705865",

                        font: {

                            family:
                                "DM Sans",

                            size:
                                10,

                            weight:
                                "500"
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

                        }

                    },

<<<<<<< HEAD
                    x: {

                        title: {

                            display: true,

                            text: 'Productos'

                        }
=======
                    grid: {

                        display:
                            false
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

                    }

                }
<<<<<<< HEAD

            }

        });


        /* =====================================================
           GRÁFICO PRODUCTOS CON BAJO STOCK
           ===================================================== */

        const nombresStock = <?php echo json_encode($nombresStock); ?>;

        const cantidadesStock = <?php echo json_encode($cantidadesStock); ?>;

        const ctxStock = document.getElementById('graficoStock');


        new Chart(ctxStock, {

            type: 'bar',

            data: {

                labels: nombresStock,

                datasets: [{

                    label: 'Cantidad disponible',

                    data: cantidadesStock,

                    backgroundColor: '#e89aaa',

                    borderColor: '#c96f84',

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

                            text: 'Cantidad en stock'

                        }

                    },

                    x: {

                        title: {

                            display: true,

                            text: 'Productos'

                        }
=======

            },


            plugins: {

                legend: {

                    display:
                        false

                },


                tooltip: {

                    backgroundColor:
                        "#3d202d",

                    titleColor:
                        "#fff",

                    bodyColor:
                        "#ead7de",

                    padding:
                        13,

                    cornerRadius:
                        3,

                    displayColors:
                        false,

                    titleFont: {

                        family:
                            "Cormorant Garamond",

                        size:
                            17

                    },

                    bodyFont: {

                        family:
                            "DM Sans",

                        size:
                            11

                    },


                    callbacks: {

                        label:
                            function(context) {

                                return (
                                    "✦ " +
                                    context.raw +
                                    " unidades vendidas"
                                );

                            }
>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

                    }

                }

            }

<<<<<<< HEAD
        });

    </script>
=======
        }

    }
);


/* =========================================================
   GRÁFICA STOCK
   ========================================================= */

const ctxStock =
    document.getElementById(
        "graficoStock"
    );


new Chart(
    ctxStock,
    {

        type:
            "bar",

        data: {

            labels:
                nombresStock,

            datasets: [{

                data:
                    cantidadesStock,

                backgroundColor:
                    "#d28a80",

                borderWidth:
                    0,

                borderRadius:
                    5,

                borderSkipped:
                    false,

                barPercentage:
                    .55,

                categoryPercentage:
                    .70

            }]

        },


        options: {

            responsive:
                true,

            maintainAspectRatio:
                false,


            animation: {

                duration:
                    1000,

                easing:
                    "easeOutQuart"

            },


            scales: {

                y: {

                    beginAtZero:
                        true,

                    ticks: {

                        stepSize:
                            1,

                        color:
                            "#9d8d95",

                        font: {

                            family:
                                "DM Sans",

                            size:
                                10

                        }

                    },

                    grid: {

                        color:
                            "rgba(84,44,61,.07)",

                        drawBorder:
                            false

                    }

                },


                x: {

                    ticks: {

                        color:
                            "#705865",

                        font: {

                            family:
                                "DM Sans",

                            size:
                                10

                        }

                    },

                    grid: {

                        display:
                            false

                    }

                }

            },


            plugins: {

                legend: {

                    display:
                        false

                },


                tooltip: {

                    backgroundColor:
                        "#3d202d",

                    titleColor:
                        "#fff",

                    bodyColor:
                        "#ead7de",

                    padding:
                        13,

                    cornerRadius:
                        3,

                    displayColors:
                        false,


                    callbacks: {

                        label:
                            function(context) {

                                return (
                                    "⚠ " +
                                    context.raw +
                                    " unidades disponibles"
                                );

                            }

                    }

                }

            }

        }

    }
);

</script>

>>>>>>> 8d8211b851797b7924f15609b5123ddced00ee7b

</body>

</html>
