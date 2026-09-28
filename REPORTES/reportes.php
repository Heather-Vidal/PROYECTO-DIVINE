<?php
session_start();

/* =========================================================
   CONEXIÓN A LA BASE DE DATOS
   ========================================================= */

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

/* =========================================================
   VALIDAR SESIÓN
   ========================================================= */

if (!isset($_SESSION['rol'])) {
    header("Location: ../SESIONES/loginform.php");
    exit();
}

$rol = $_SESSION['rol'];
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";

/* =========================================================
   CONSULTA DE VENTAS
   ========================================================= */

$sql = "
    SELECT
        v.id,
        v.estado,
        v.metodo,
        v.costototal,
        v.PEDIDOS_ID,
        v.fecha,
        p.nombrevendedor,
        p.estado AS estado_pedido
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE p.estado = 'Aceptado'
    ORDER BY
        DATE(v.fecha) = CURDATE() DESC,
        v.fecha DESC,
        v.id DESC
";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error al consultar las ventas: " . $conn->error);
}

/* =========================================================
   VENTAS DE HOY
   ========================================================= */

$sqlHoy = "
    SELECT
        COUNT(v.id) AS cantidad,
        COALESCE(SUM(v.costototal), 0) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE p.estado = 'Aceptado'
      AND DATE(v.fecha) = CURDATE()
";

$resultadoHoy = $conn->query($sqlHoy);

if (!$resultadoHoy) {
    die("Error al calcular las ventas de hoy: " . $conn->error);
}

$filaHoy = $resultadoHoy->fetch_assoc();

$cantidadHoy = isset($filaHoy['cantidad'])
    ? (int)$filaHoy['cantidad']
    : 0;

$totalHoy = isset($filaHoy['total'])
    ? (float)$filaHoy['total']
    : 0;

/* =========================================================
   TOTAL GENERAL
   ========================================================= */

$sqlTotal = "
    SELECT
        COUNT(v.id) AS cantidad,
        COALESCE(SUM(v.costototal), 0) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE p.estado = 'Aceptado'
";

$resultadoTotal = $conn->query($sqlTotal);

if (!$resultadoTotal) {
    die("Error al calcular el total general: " . $conn->error);
}

$filaTotal = $resultadoTotal->fetch_assoc();

$cantidadTotal = isset($filaTotal['cantidad'])
    ? (int)$filaTotal['cantidad']
    : 0;

$totalGeneral = isset($filaTotal['total'])
    ? (float)$filaTotal['total']
    : 0;

/* =========================================================
   ÚLTIMOS 7 DÍAS
   ========================================================= */

$sqlSemana = "
    SELECT
        COALESCE(SUM(v.costototal), 0) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE p.estado = 'Aceptado'
      AND DATE(v.fecha) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
      AND DATE(v.fecha) <= CURDATE()
";

$resultadoSemana = $conn->query($sqlSemana);

if (!$resultadoSemana) {
    die("Error al calcular las ventas de los últimos 7 días: " . $conn->error);
}

$filaSemana = $resultadoSemana->fetch_assoc();

$totalSemana = isset($filaSemana['total'])
    ? (float)$filaSemana['total']
    : 0;

/* =========================================================
   ÚLTIMOS 30 DÍAS
   ========================================================= */

$sqlMes = "
    SELECT
        COALESCE(SUM(v.costototal), 0) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE p.estado = 'Aceptado'
      AND DATE(v.fecha) >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
      AND DATE(v.fecha) <= CURDATE()
";

$resultadoMes = $conn->query($sqlMes);

if (!$resultadoMes) {
    die("Error al calcular las ventas de los últimos 30 días: " . $conn->error);
}

$filaMes = $resultadoMes->fetch_assoc();

$totalMes = isset($filaMes['total'])
    ? (float)$filaMes['total']
    : 0;

$totalRegistros = $resultado->num_rows;

/* =========================================================
   DATOS PARA GRÁFICOS
   ========================================================= */

$valorDia = $totalHoy;
$valorSemana = $totalSemana;
$valorMes = $totalMes;
$valorTotal = $totalGeneral;

$maxBarra = max(
    $valorDia,
    $valorSemana,
    $valorMes,
    $valorTotal,
    1
);

$barraDia = ($valorDia / $maxBarra) * 100;
$barraSemana = ($valorSemana / $maxBarra) * 100;
$barraMes = ($valorMes / $maxBarra) * 100;
$barraTotal = ($valorTotal / $maxBarra) * 100;

$totalGrafico =
    $valorDia +
    $valorSemana +
    $valorMes +
    $valorTotal;

if ($totalGrafico > 0) {

    $porDia = ($valorDia / $totalGrafico) * 100;
    $porSemana = ($valorSemana / $totalGrafico) * 100;
    $porMes = ($valorMes / $totalGrafico) * 100;
    $porTotal = ($valorTotal / $totalGrafico) * 100;

} else {

    $porDia = 25;
    $porSemana = 25;
    $porMes = 25;
    $porTotal = 25;
}

$anguloDia = $porDia * 3.6;
$anguloSemana = ($porDia + $porSemana) * 3.6;
$anguloMes = ($porDia + $porSemana + $porMes) * 3.6;

/* =========================================================
   INICIALES DEL USUARIO
   ========================================================= */

$inicial = strtoupper(
    substr(
        trim($nombre ?: 'U'),
        0,
        1
    )
);
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>DIVINE | Ventas</title>

<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =========================================================
   PALETA PREMIUM DIVINE
   ========================================================= */

:root{

    --vino:#6f3048;
    --vino-oscuro:#4d2434;
    --vino-suave:#8d5368;

    --champagne:#c9a878;
    --champagne-claro:#eee3d2;
    --champagne-palido:#f8f3ea;

    --marfil:#fbf9f5;
    --blanco:#ffffff;
    --crema:#f6f2eb;

    --texto:#3f3438;
    --texto-suave:#83767a;
    --gris:#a49a9d;

    --borde:#e8dfd4;

    --verde:#668572;
    --verde-claro:#edf4ef;

    --dorado:#b99a68;

    --sombra:
        0 18px 50px rgba(77,36,52,.09);

    --sombra-suave:
        0 8px 25px rgba(77,36,52,.06);
}


/* =========================================================
   RESET
   ========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{

    min-height:100vh;

    font-family:
        "DM Sans",
        Arial,
        sans-serif;

    color:var(--texto);

    background:

        radial-gradient(
            circle at 0% 0%,
            rgba(201,168,120,.13),
            transparent 28%
        ),

        radial-gradient(
            circle at 100% 0%,
            rgba(111,48,72,.07),
            transparent 25%
        ),

        radial-gradient(
            circle at 80% 80%,
            rgba(201,168,120,.08),
            transparent 28%
        ),

        linear-gradient(
            135deg,
            #fbf9f5,
            #f8f4ee
        );

}


/* =========================================================
   DECORACIÓN
   ========================================================= */

body::before{

    content:"";

    position:fixed;

    width:300px;
    height:300px;

    border-radius:50%;

    top:35%;
    left:-180px;

    background:
        radial-gradient(
            circle,
            rgba(111,48,72,.07),
            transparent 70%
        );

    pointer-events:none;

}

body::after{

    content:"";

    position:fixed;

    width:250px;
    height:250px;

    border-radius:50%;

    right:-130px;
    bottom:5%;

    background:
        radial-gradient(
            circle,
            rgba(201,168,120,.10),
            transparent 70%
        );

    pointer-events:none;

}


/* =========================================================
   CONTENEDOR
   ========================================================= */

.contenedor{

    width:92%;

    max-width:1320px;

    margin:0 auto;

    padding:
        35px
        0
        60px;

}


/* =========================================================
   HEADER
   ========================================================= */

.encabezado{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:45px;

}


.izquierda-cabecera{

    display:flex;

    align-items:center;

    gap:16px;

}


.logo{

    width:55px;
    height:55px;

    border-radius:18px;

    display:flex;

    align-items:center;
    justify-content:center;

    color:white;

    font-family:
        "Playfair Display",
        serif;

    font-size:25px;

    background:

        linear-gradient(
            145deg,
            #8d5368,
            #4d2434
        );

    box-shadow:
        0 12px 25px
        rgba(77,36,52,.22);

    position:relative;

    overflow:hidden;

}


.logo::after{

    content:"";

    position:absolute;

    width:35px;
    height:35px;

    border:1px solid
        rgba(255,255,255,.4);

    border-radius:50%;

}


.marca{

    font-family:
        "Playfair Display",
        serif;

    font-size:29px;

    font-weight:700;

    letter-spacing:1px;

    color:var(--vino-oscuro);

}


.subtitulo{

    margin-top:3px;

    color:var(--texto-suave);

    font-size:11px;

    letter-spacing:.3px;

}


.usuario{

    display:flex;

    align-items:center;

    gap:12px;

    padding:
        7px
        9px
        7px
        16px;

    background:
        rgba(255,255,255,.78);

    border:1px solid
        rgba(232,223,212,.9);

    border-radius:50px;

    box-shadow:var(--sombra-suave);

    backdrop-filter:blur(10px);

}


.usuario-info{

    text-align:right;

}


.usuario-nombre{

    font-size:11px;

    font-weight:700;

    color:var(--texto);

}


.usuario-rol{

    margin-top:2px;

    color:var(--gris);

    font-size:8px;

    letter-spacing:1px;

    text-transform:uppercase;

}


.avatar{

    width:42px;
    height:42px;

    border-radius:50%;

    display:flex;

    align-items:center;
    justify-content:center;

    background:

        linear-gradient(
            145deg,
            #8d5368,
            #4d2434
        );

    color:white;

    font-family:
        "Playfair Display",
        serif;

    font-size:17px;

    box-shadow:
        inset 0 0 0 3px
        rgba(255,255,255,.3);

}


/* =========================================================
   TÍTULO
   ========================================================= */

.dashboard-titulo{

    margin-bottom:28px;

}


.dashboard-titulo .mini{

    display:inline-flex;

    align-items:center;

    gap:6px;

    color:var(--champagne);

    font-size:9px;

    font-weight:700;

    letter-spacing:2px;

    text-transform:uppercase;

    margin-bottom:8px;

}


.dashboard-titulo h1{

    font-family:
        "Playfair Display",
        serif;

    font-size:34px;

    font-weight:600;

    color:var(--vino-oscuro);

    line-height:1.1;

}


.dashboard-titulo p{

    margin-top:8px;

    color:var(--texto-suave);

    font-size:11px;

}


/* =========================================================
   RESUMEN PRINCIPAL
   ========================================================= */

.resumen-principal{

    display:grid;

    grid-template-columns:
        1.2fr
        .8fr;

    gap:18px;

    margin-bottom:18px;

}


.tarjeta-grande{

    min-height:190px;

    padding:28px;

    position:relative;

    overflow:hidden;

    border-radius:28px;

    box-shadow:var(--sombra);

}


.tarjeta-grande::before{

    content:"";

    position:absolute;

    width:220px;
    height:220px;

    border-radius:50%;

    right:-70px;
    top:-100px;

    border:
        1px solid
        rgba(255,255,255,.35);

}


.tarjeta-grande::after{

    content:"✦";

    position:absolute;

    right:28px;
    bottom:5px;

    font-family:
        "Playfair Display",
        serif;

    font-size:115px;

    line-height:1;

    color:
        rgba(255,255,255,.13);

}


.tarjeta-hoy{

    background:

        linear-gradient(
            135deg,
            #7d4057,
            #5a293d 65%,
            #432131
        );

    color:white;

}


.tarjeta-general{

    background:

        linear-gradient(
            135deg,
            #f8f3ea,
            #eee3d2
        );

    border:
        1px solid
        #e3d4bd;

}


.etiqueta-grande{

    position:relative;
    z-index:2;

    font-size:9px;

    font-weight:700;

    letter-spacing:1.8px;

}


.tarjeta-hoy .etiqueta-grande{

    color:#f9eee4;

}


.tarjeta-general .etiqueta-grande{

    color:var(--vino-suave);

}


.monto-grande{

    position:relative;
    z-index:2;

    margin:
        14px
        0
        5px;

    font-family:
        "Playfair Display",
        serif;

    font-size:38px;

    font-weight:700;

}


.tarjeta-hoy .monto-grande{

    color:white;

}


.tarjeta-general .monto-grande{

    color:var(--vino-oscuro);

}


.cantidad-grande{

    position:relative;
    z-index:2;

    font-size:10px;

    font-weight:700;

}


.tarjeta-hoy .cantidad-grande{

    color:#f9eee4;

}


.tarjeta-general .cantidad-grande{

    color:#795968;

}


.detalle-grande{

    position:relative;
    z-index:2;

    max-width:430px;

    margin-top:9px;

    font-size:9px;

    line-height:1.5;

}


.tarjeta-hoy .detalle-grande{

    color:#f5e7df;

}


.tarjeta-general .detalle-grande{

    color:#8b777d;

}


/* =========================================================
   ESTADÍSTICAS
   ========================================================= */

.estadisticas{

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:15px;

    margin-bottom:18px;

}


.card{

    min-height:150px;

    padding:19px;

    background:
        rgba(255,255,255,.90);

    border:
        1px solid
        var(--borde);

    border-radius:21px;

    box-shadow:var(--sombra-suave);

    display:flex;

    flex-direction:column;

    justify-content:space-between;

    transition:
        transform .25s ease,
        box-shadow .25s ease;

    backdrop-filter:blur(8px);

}


.card:hover{

    transform:translateY(-5px);

    box-shadow:
        0 18px 35px
        rgba(77,36,52,.12);

}


.card-arriba{

    display:flex;

    align-items:center;

    justify-content:space-between;

}


.card-icono{

    width:34px;
    height:34px;

    border-radius:12px;

    display:flex;

    align-items:center;
    justify-content:center;

    background:var(--champagne-palido);

    color:var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size:13px;

}


.card-menu{

    color:#b8abad;

    font-size:11px;

    letter-spacing:2px;

}


.card-titulo{

    margin-top:12px;

    color:var(--texto-suave);

    font-size:9px;

    font-weight:600;

    text-transform:uppercase;

    letter-spacing:.6px;

}


.card-valor{

    margin-top:5px;

    color:var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size:23px;

    font-weight:700;

}


.card-cambio{

    margin-top:3px;

    color:#a49a9d;

    font-size:8px;

}


/* =========================================================
   GRÁFICAS
   ========================================================= */

.graficas{

    display:grid;

    grid-template-columns:
        .95fr
        1.05fr;

    gap:18px;

    margin-bottom:18px;

}


.panel{

    min-height:310px;

    padding:22px;

    background:
        rgba(255,255,255,.92);

    border:
        1px solid
        var(--borde);

    border-radius:24px;

    box-shadow:var(--sombra-suave);

}


.panel-cabecera{

    display:flex;

    align-items:flex-start;

    justify-content:space-between;

    margin-bottom:15px;

}


.panel-titulo{

    color:var(--vino-oscuro);

    font-family:
        "Playfair Display",
        serif;

    font-size:17px;

    font-weight:600;

}


.panel-subtitulo{

    margin-top:4px;

    color:var(--gris);

    font-size:8px;

}


.filtro{

    padding:
        7px
        12px;

    border-radius:20px;

    background:var(--champagne-palido);

    border:
        1px solid
        #e4d7c3;

    color:var(--vino);

    font-size:8px;

    font-weight:700;

}


/* =========================================================
   DONUT
   ========================================================= */

.donut-contenedor{

    min-height:240px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:35px;

}


.donut{

    width:175px;
    height:175px;

    flex-shrink:0;

    border-radius:50%;

    position:relative;

    display:flex;

    align-items:center;
    justify-content:center;

    box-shadow:
        0 12px 30px
        rgba(77,36,52,.12);

}


.donut::before{

    content:"";

    position:absolute;

    width:112px;
    height:112px;

    border-radius:50%;

    background:#fff;

    box-shadow:
        inset 0 0 20px
        rgba(77,36,52,.04);

}


.donut-centro{

    position:relative;

    z-index:2;

    text-align:center;

}


.donut-centro small{

    display:block;

    color:var(--gris);

    font-size:8px;

    text-transform:uppercase;

    letter-spacing:1px;

}


.donut-centro strong{

    display:block;

    margin-top:4px;

    color:var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size:17px;

}


.leyenda{

    display:flex;

    flex-direction:column;

    gap:12px;

}


.leyenda-item{

    display:flex;

    align-items:center;

    gap:8px;

    color:var(--texto-suave);

    font-size:9px;

}


.punto{

    width:9px;
    height:9px;

    border-radius:50%;

}


.punto.rosa1{
    background:#7d4057;
}

.punto.rosa2{
    background:#b99a68;
}

.punto.rosa3{
    background:#d9c6a5;
}

.punto.rosa4{
    background:#4d2434;
}


/* =========================================================
   BARRAS
   ========================================================= */

.grafico-barras{

    height:245px;

    display:flex;

    align-items:flex-end;

    justify-content:space-around;

    gap:16px;

    padding:
        10px
        10px
        0;

}


.columna{

    height:100%;

    flex:1;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:flex-end;

    gap:7px;

}


.valor-barra{

    color:var(--gris);

    font-size:7px;

    white-space:nowrap;

}


.barrita{

    width:45px;

    max-width:70%;

    min-height:8px;

    border-radius:
        13px
        13px
        5px
        5px;

    animation:
        subir .9s ease both;

    box-shadow:
        0 6px 12px
        rgba(77,36,52,.12);

}


.barrita.rosa1{

    background:
        linear-gradient(
            to top,
            #5a293d,
            #8d5368
        );

}


.barrita.rosa2{

    background:
        linear-gradient(
            to top,
            #a4875b,
            #c9a878
        );

}


.barrita.rosa3{

    background:
        linear-gradient(
            to top,
            #cdb994,
            #e3d5ba
        );

}


.barrita.rosa4{

    background:
        linear-gradient(
            to top,
            #432131,
            #6f3048
        );

}


.nombre-barra{

    color:var(--texto-suave);

    font-size:8px;

    font-weight:600;

}


@keyframes subir{

    from{

        transform:
            scaleY(0);

        transform-origin:
            bottom;

    }

    to{

        transform:
            scaleY(1);

        transform-origin:
            bottom;

    }

}


/* =========================================================
   TABLA
   ========================================================= */

.contenedor-tabla{

    padding:25px;

    background:
        rgba(255,255,255,.95);

    border:
        1px solid
        var(--borde);

    border-radius:27px;

    box-shadow:var(--sombra);

    overflow-x:auto;

}


.titulo-tabla{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:18px;

}


.titulo-tabla h2{

    color:var(--vino-oscuro);

    font-family:
        "Playfair Display",
        serif;

    font-size:22px;

    font-weight:600;

}


.registros{

    padding:
        8px
        13px;

    border-radius:30px;

    background:var(--champagne-palido);

    color:var(--vino);

    font-size:8px;

    font-weight:800;

}


/* =========================================================
   TABLA
   ========================================================= */

table{

    width:100%;

    min-width:760px;

    border-collapse:separate;

    border-spacing:0 5px;

}


thead th{

    padding:
        11px
        12px;

    color:#8c7d82;

    background:#fbf9f5;

    border-bottom:
        1px solid
        var(--borde);

    font-size:8px;

    font-weight:700;

    text-align:center;

    text-transform:uppercase;

    letter-spacing:1px;

}


tbody tr{

    transition:
        transform .2s ease,
        background .2s ease;

}


tbody tr:not(.separador-ventas):hover{

    transform:
        translateY(-2px);

}


td{

    padding:
        14px
        11px;

    color:#66575c;

    background:#fff;

    border-top:
        1px solid
        #eee7df;

    border-bottom:
        1px solid
        #eee7df;

    font-size:10px;

    text-align:center;

}


tbody tr td:first-child{

    border-left:
        1px solid
        #eee7df;

    border-radius:
        13px
        0
        0
        13px;

}


tbody tr td:last-child{

    border-right:
        1px solid
        #eee7df;

    border-radius:
        0
        13px
        13px
        0;

}


.venta-hoy td{

    background:

        linear-gradient(
            90deg,
            #fbf6f0,
            #fff
        );

}


.precio{

    color:var(--vino)!important;

    font-family:
        "Playfair Display",
        serif;

    font-size:13px;

}


/* =========================================================
   ESTADO
   ========================================================= */

.estado{

    display:inline-flex;

    align-items:center;

    gap:6px;

    padding:
        6px
        10px;

    border-radius:20px;

    background:var(--verde-claro);

    color:var(--verde);

    font-size:8px;

    font-weight:800;

}


.estado::before{

    content:"";

    width:6px;
    height:6px;

    border-radius:50%;

    background:var(--verde);

    box-shadow:
        0 0 0 3px
        rgba(102,133,114,.12);

}


.indicador-hoy{

    display:inline-block;

    margin-top:6px;

    padding:
        4px
        9px;

    border-radius:20px;

    background:var(--champagne-palido);

    color:var(--vino);

    font-size:7px;

    font-weight:800;

    letter-spacing:.5px;

}


/* =========================================================
   SEPARADORES
   ========================================================= */

.separador-ventas td{

    padding:0!important;

    border:none!important;

    background:transparent!important;

}


.separador-hoy-contenido{

    margin:
        24px
        0
        9px;

    padding:
        14px
        18px;

    background:

        linear-gradient(
            90deg,
            #eee3d2,
            #fbf9f5
        );

    border-left:
        5px solid
        var(--champagne);

    border-radius:13px;

    color:var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size:14px;

    font-weight:600;

    letter-spacing:.7px;

    text-align:left;

}


.separador-anteriores-contenido{

    margin:
        28px
        0
        9px;

    padding:
        14px
        18px;

    background:

        linear-gradient(
            90deg,
            #f1ece4,
            #fbf9f5
        );

    border-left:
        5px solid
        #c9a878;

    border-radius:13px;

    color:#76656b;

    font-family:
        "Playfair Display",
        serif;

    font-size:13px;

    font-weight:600;

    letter-spacing:.5px;

    text-align:left;

}


/* =========================================================
   SIN VENTAS
   ========================================================= */

.sin-ventas{

    padding:
        70px
        20px;

    text-align:center;

}


.sin-ventas .emoji{

    margin-bottom:10px;

    font-size:48px;

}


.sin-ventas h3{

    margin-bottom:7px;

    color:var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size:22px;

}


.sin-ventas p{

    color:var(--texto-suave);

    font-size:10px;

}


/* =========================================================
   BOTÓN
   ========================================================= */

.volver{

    display:inline-flex;

    align-items:center;
    justify-content:center;

    gap:7px;

    margin-top:22px;

    padding:
        12px
        22px;

    color:white;

    background:

        linear-gradient(
            135deg,
            #7d4057,
            #4d2434
        );

    border-radius:30px;

    text-decoration:none;

    font-size:9px;

    font-weight:800;

    box-shadow:
        0 8px 18px
        rgba(77,36,52,.20);

    transition:
        transform .25s ease,
        box-shadow .25s ease;

}


.volver:hover{

    transform:
        translateY(-3px);

    box-shadow:
        0 13px 25px
        rgba(77,36,52,.27);

}


/* =========================================================
   ANIMACIÓN
   ========================================================= */

.encabezado,
.dashboard-titulo,
.resumen-principal,
.estadisticas,
.graficas,
.contenedor-tabla{

    animation:
        aparecer .65s ease both;

}


.dashboard-titulo{
    animation-delay:.05s;
}

.resumen-principal{
    animation-delay:.10s;
}

.estadisticas{
    animation-delay:.15s;
}

.graficas{
    animation-delay:.20s;
}

.contenedor-tabla{
    animation-delay:.25s;
}


@keyframes aparecer{

    from{

        opacity:0;

        transform:
            translateY(15px);

    }

    to{

        opacity:1;

        transform:
            translateY(0);

    }

}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width:1050px){

    .estadisticas{

        grid-template-columns:
            repeat(2,1fr);

    }

    .graficas{

        grid-template-columns:1fr;

    }

}


@media(max-width:750px){

    .contenedor{

        width:94%;

        padding-top:22px;

    }

    .encabezado{

        margin-bottom:32px;

    }

    .resumen-principal{

        grid-template-columns:1fr;

    }

    .dashboard-titulo h1{

        font-size:29px;

    }

    .donut-contenedor{

        flex-direction:column;

        gap:20px;

    }

    .leyenda{

        flex-direction:row;

        flex-wrap:wrap;

        justify-content:center;

    }

}


@media(max-width:550px){

    .estadisticas{

        grid-template-columns:1fr;

    }

    .usuario-info{

        display:none;

    }

    .usuario{

        padding:5px;

        background:transparent;

        border:none;

        box-shadow:none;

    }

    .marca{

        font-size:25px;

    }

    .subtitulo{

        font-size:9px;

    }

    .logo{

        width:47px;
        height:47px;

        border-radius:15px;

        font-size:21px;

    }

    .tarjeta-grande{

        padding:23px;

    }

    .monto-grande{

        font-size:31px;

    }

    .contenedor-tabla{

        padding:17px;

        border-radius:21px;

    }

    .titulo-tabla h2{

        font-size:18px;

    }

}


@media(max-width:380px){

    .dashboard-titulo h1{

        font-size:25px;

    }

    .monto-grande{

        font-size:27px;

    }

}

</style>

</head>


<body>

<div class="contenedor">


    <!-- =====================================================
         ENCABEZADO
         ===================================================== -->

    <header class="encabezado">

        <div class="izquierda-cabecera">

            <div class="logo">
                D
            </div>

            <div>

                <div class="marca">
                    DIVINE
                </div>

                <div class="subtitulo">
                    Control y registro de ventas
                </div>

            </div>

        </div>


        <div class="usuario">

            <div class="usuario-info">

                <div class="usuario-nombre">
                    <?= htmlspecialchars($nombre) ?>
                </div>

                <div class="usuario-rol">
                    <?= htmlspecialchars($rol) ?>
                </div>

            </div>

            <div class="avatar">
                <?= htmlspecialchars($inicial) ?>
            </div>

        </div>

    </header>


    <!-- =====================================================
         TÍTULO
         ===================================================== -->

    <section class="dashboard-titulo">

        <div class="mini">
            ✦ Dashboard de ventas
        </div>

        <h1>
            Resumen de ventas
        </h1>

        <p>
            Un vistazo elegante a tus ventas, ingresos y rendimiento.
        </p>

    </section>


    <!-- =====================================================
         TARJETAS PRINCIPALES
         ===================================================== -->

    <section class="resumen-principal">


        <div class="tarjeta-grande tarjeta-hoy">

            <div class="etiqueta-grande">
                ✦ VENTAS DE HOY
            </div>

            <div class="monto-grande">
                Bs <?= number_format($totalHoy, 2) ?>
            </div>

            <div class="cantidad-grande">

                <?= $cantidadHoy ?>

                <?= $cantidadHoy == 1
                    ? 'venta realizada'
                    : 'ventas realizadas'
                ?>

            </div>

            <div class="detalle-grande">

                Pedidos aceptados cuya venta corresponde al día de hoy.

            </div>

        </div>


        <div class="tarjeta-grande tarjeta-general">

            <div class="etiqueta-grande">
                ♡ INGRESOS GENERALES
            </div>

            <div class="monto-grande">
                Bs <?= number_format($totalGeneral, 2) ?>
            </div>

            <div class="cantidad-grande">

                <?= $cantidadTotal ?>

                <?= $cantidadTotal == 1
                    ? 'venta registrada'
                    : 'ventas registradas'
                ?>

            </div>

            <div class="detalle-grande">

                Total acumulado de todas las ventas vinculadas a pedidos aceptados.

            </div>

        </div>

    </section>


    <!-- =====================================================
         ESTADÍSTICAS
         ===================================================== -->

    <section class="estadisticas">


        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        ♡
                    </div>

                    <div class="card-menu">
                        ···
                    </div>

                </div>

                <div class="card-titulo">
                    Ventas de hoy
                </div>

            </div>

            <div>

                <div class="card-valor">
                    Bs <?= number_format($totalHoy,2) ?>
                </div>

                <div class="card-cambio">
                    <?= $cantidadHoy ?> ventas hoy
                </div>

            </div>

        </article>


        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        7
                    </div>

                    <div class="card-menu">
                        ···
                    </div>

                </div>

                <div class="card-titulo">
                    Últimos 7 días
                </div>

            </div>

            <div>

                <div class="card-valor">
                    Bs <?= number_format($totalSemana,2) ?>
                </div>

                <div class="card-cambio">
                    Ventas acumuladas
                </div>

            </div>

        </article>


        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        30
                    </div>

                    <div class="card-menu">
                        ···
                    </div>

                </div>

                <div class="card-titulo">
                    Últimos 30 días
                </div>

            </div>

            <div>

                <div class="card-valor">
                    Bs <?= number_format($totalMes,2) ?>
                </div>

                <div class="card-cambio">
                    Rendimiento mensual
                </div>

            </div>

        </article>


        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        ✦
                    </div>

                    <div class="card-menu">
                        ···
                    </div>

                </div>

                <div class="card-titulo">
                    Total general
                </div>

            </div>

            <div>

                <div class="card-valor">
                    Bs <?= number_format($totalGeneral,2) ?>
                </div>

                <div class="card-cambio">
                    Todas las ventas
                </div>

            </div>

        </article>


    </section>


    <!-- =====================================================
         GRÁFICAS
         ===================================================== -->

    <section class="graficas">


        <!-- DONUT -->

        <article class="panel">

            <div class="panel-cabecera">

                <div>

                    <div class="panel-titulo">
                        Distribución de ventas
                    </div>

                    <div class="panel-subtitulo">
                        Resumen visual por período
                    </div>

                </div>

                <div class="filtro">
                    DIVINE ✦
                </div>

            </div>


            <div class="donut-contenedor">


                <div
                    class="donut"
                    style="
                        background:
                        conic-gradient(
                            #7d4057
                            0deg
                            <?= $anguloDia ?>deg,

                            #b99a68
                            <?= $anguloDia ?>deg
                            <?= $anguloSemana ?>deg,

                            #d9c6a5
                            <?= $anguloSemana ?>deg
                            <?= $anguloMes ?>deg,

                            #4d2434
                            <?= $anguloMes ?>deg
                            360deg
                        );
                    "
                >

                    <div class="donut-centro">

                        <small>
                            Total visual
                        </small>

                        <strong>
                            Bs <?= number_format($totalGrafico,0) ?>
                        </strong>

                    </div>

                </div>


                <div class="leyenda">

                    <div class="leyenda-item">

                        <span class="punto rosa1"></span>

                        Hoy

                    </div>


                    <div class="leyenda-item">

                        <span class="punto rosa2"></span>

                        7 días

                    </div>


                    <div class="leyenda-item">

                        <span class="punto rosa3"></span>

                        30 días

                    </div>


                    <div class="leyenda-item">

                        <span class="punto rosa4"></span>

                        Total general

                    </div>

                </div>


            </div>

        </article>


        <!-- BARRAS -->

        <article class="panel">

            <div class="panel-cabecera">

                <div>

                    <div class="panel-titulo">
                        Rendimiento
                    </div>

                    <div class="panel-subtitulo">
                        Comparación de ingresos por período
                    </div>

                </div>

                <div class="filtro">
                    Ventas
                </div>

            </div>


            <div class="grafico-barras">


                <div class="columna">

                    <div class="valor-barra">
                        Bs <?= number_format($valorDia,0) ?>
                    </div>

                    <div
                        class="barrita rosa1"
                        style="
                            height:
                            <?= max(8,$barraDia*1.55) ?>px;
                        "
                    ></div>

                    <div class="nombre-barra">
                        Hoy
                    </div>

                </div>


                <div class="columna">

                    <div class="valor-barra">
                        Bs <?= number_format($valorSemana,0) ?>
                    </div>

                    <div
                        class="barrita rosa2"
                        style="
                            height:
                            <?= max(8,$barraSemana*1.55) ?>px;
                        "
                    ></div>

                    <div class="nombre-barra">
                        7 días
                    </div>

                </div>


                <div class="columna">

                    <div class="valor-barra">
                        Bs <?= number_format($valorMes,0) ?>
                    </div>

                    <div
                        class="barrita rosa3"
                        style="
                            height:
                            <?= max(8,$barraMes*1.55) ?>px;
                        "
                    ></div>

                    <div class="nombre-barra">
                        30 días
                    </div>

                </div>


                <div class="columna">

                    <div class="valor-barra">
                        Bs <?= number_format($valorTotal,0) ?>
                    </div>

                    <div
                        class="barrita rosa4"
                        style="
                            height:
                            <?= max(8,$barraTotal*1.55) ?>px;
                        "
                    ></div>

                    <div class="nombre-barra">
                        Total
                    </div>

                </div>


            </div>

        </article>


    </section>


    <!-- =====================================================
         TABLA
         ===================================================== -->

    <section class="contenedor-tabla">


        <div class="titulo-tabla">

            <h2>
                ♡ Ventas registradas
            </h2>

            <div class="registros">

                <?= $totalRegistros ?>

                <?= $totalRegistros == 1
                    ? 'registro'
                    : 'registros'
                ?>

            </div>

        </div>


        <?php if ($resultado && $resultado->num_rows > 0): ?>


        <table id="tabla-ingresos">

            <thead>

                <tr>

                    <th>
                        ID Venta
                    </th>

                    <th>
                        Pedido
                    </th>

                    <th>
                        Fecha
                    </th>

                    <th>
                        Método
                    </th>

                    <th>
                        Estado
                    </th>

                    <th>
                        Total
                    </th>

                </tr>

            </thead>


            <tbody>


            <?php

            $fechaHoy = date('Y-m-d');

            $mostroHoy = false;

            $mostroAnteriores = false;

            while ($fila = $resultado->fetch_assoc()):

                $fechaVenta = !empty($fila['fecha'])
                    ? date(
                        'Y-m-d',
                        strtotime($fila['fecha'])
                    )
                    : '';

                $esHoy =
                    ($fechaVenta === $fechaHoy);

            ?>


                <?php if ($esHoy && !$mostroHoy): ?>

                    <?php
                    $mostroHoy = true;
                    ?>

                    <tr class="separador-ventas">

                        <td colspan="6">

                            <div class="separador-hoy-contenido">

                                ♡ ✦ VENTAS DE HOY ✦ ♡

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>


                <?php if (!$esHoy && !$mostroAnteriores): ?>

                    <?php
                    $mostroAnteriores = true;
                    ?>

                    <tr class="separador-ventas">

                        <td colspan="6">

                            <div class="separador-anteriores-contenido">

                                ✦ VENTAS DE OTROS DÍAS

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>


                <tr
                    class="<?= $esHoy
                        ? 'venta-hoy'
                        : ''
                    ?>"
                >


                    <td>

                        <strong>
                            #<?= htmlspecialchars($fila['id']) ?>
                        </strong>

                    </td>


                    <td>

                        #<?= htmlspecialchars(
                            $fila['PEDIDOS_ID']
                        ) ?>

                    </td>


                    <td>

                        <?= !empty($fila['fecha'])

                            ? date(
                                'd/m/Y H:i',
                                strtotime($fila['fecha'])
                            )

                            : 'Sin fecha'
                        ?>


                        <?php if ($esHoy): ?>

                            <br>

                            <span class="indicador-hoy">

                                HOY ✦

                            </span>

                        <?php endif; ?>

                    </td>


                    <td>

                        <?= htmlspecialchars(
                            $fila['metodo'] ?? ''
                        ) ?>

                    </td>


                    <td>

                        <span class="estado">

                            ✓

                            <?= htmlspecialchars(
                                $fila['estado_pedido']
                                ?? 'Aceptado'
                            ) ?>

                        </span>

                    </td>


                    <td>

                        <strong class="precio">

                            Bs
                            <?= number_format(
                                (float)$fila['costototal'],
                                2
                            ) ?>

                        </strong>

                    </td>


                </tr>


            <?php endwhile; ?>


            </tbody>

        </table>


        <?php else: ?>


            <div class="sin-ventas">

                <div class="emoji">
                    ✦
                </div>

                <h3>
                    Aún no hay ventas
                </h3>

                <p>
                    No existen ventas relacionadas con
                    pedidos cuyo estado sea "Aceptado".
                </p>

            </div>


        <?php endif; ?>


        <a
            href="../admin.php"
            class="volver"
        >
            ← Volver al perfil
        </a>


    </section>


</div>


</body>

</html>


<?php

$conn->close();

?>
