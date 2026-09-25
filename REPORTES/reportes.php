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

$conn->set_charset("utf8");

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
   =========================================================
   IMPORTANTE:
   - Se mantienen los nombres de las tablas y columnas del archivo:
       VENTAS, PEDIDOS
       v.id, v.estado, v.metodo, v.costototal, v.PEDIDOS_ID, v.fecha
       p.ID, p.estado, p.nombrevendedor
   - El WHERE queda SOLO con:
       p.estado = 'Aceptado'
   - Se ordena para que HOY aparezca primero y después
     todas las ventas de otros días.
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
   DATOS DE LAS VENTAS DE HOY
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
$cantidadHoy = isset($filaHoy['cantidad']) ? (int)$filaHoy['cantidad'] : 0;
$totalHoy = isset($filaHoy['total']) ? (float)$filaHoy['total'] : 0;

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
$cantidadTotal = isset($filaTotal['cantidad']) ? (int)$filaTotal['cantidad'] : 0;
$totalGeneral = isset($filaTotal['total']) ? (float)$filaTotal['total'] : 0;

/* =========================================================
   TOTAL ÚLTIMOS 7 DÍAS
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
$totalSemana = isset($filaSemana['total']) ? (float)$filaSemana['total'] : 0;

/* =========================================================
   TOTAL ÚLTIMOS 30 DÍAS
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
$totalMes = isset($filaMes['total']) ? (float)$filaMes['total'] : 0;

$totalRegistros = $resultado->num_rows;

/* =========================================================
   DATOS PARA GRÁFICOS
   ========================================================= */

$valorDia = $totalHoy;
$valorSemana = $totalSemana;
$valorMes = $totalMes;
$valorTotal = $totalGeneral;

$maxBarra = max($valorDia, $valorSemana, $valorMes, $valorTotal, 1);

$barraDia = ($valorDia / $maxBarra) * 100;
$barraSemana = ($valorSemana / $maxBarra) * 100;
$barraMes = ($valorMes / $maxBarra) * 100;
$barraTotal = ($valorTotal / $maxBarra) * 100;

$totalGrafico = $valorDia + $valorSemana + $valorMes + $valorTotal;

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
?>
<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ventas - DIVINE</title>

<style>
:root{
    --rosa:#eeb0c6;
    --rosa-fuerte:#d985a3;
    --rosa-oscuro:#a95676;
    --rosa-claro:#f8dfe8;
    --rosa-palido:#fff4f7;
    --rosa-suave:#fdebf1;
    --blanco:#ffffff;
    --texto:#5d4650;
    --gris:#8b7b81;
    --borde:#f0d8e0;
    --sombra:0 10px 30px rgba(169,86,118,.12);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    min-height:100vh;
    background:
        radial-gradient(circle at 5% 5%, rgba(238,176,198,.35), transparent 25%),
        radial-gradient(circle at 95% 10%, rgba(248,223,232,.7), transparent 25%),
        linear-gradient(135deg,#fff8fa,#fff1f5);
    color:var(--texto);
}

.contenedor{
    width:94%;
    max-width:1250px;
    margin:32px auto 50px;
}

.encabezado{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
}

.izquierda-cabecera{
    display:flex;
    align-items:center;
    gap:13px;
}

.menu-icono{
    width:46px;
    height:46px;
    border-radius:14px;
    background:linear-gradient(135deg,var(--rosa-fuerte),var(--rosa));
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:19px;
    box-shadow:0 7px 18px rgba(169,86,118,.2);
}

.titulo{
    font-size:25px;
    font-weight:800;
    color:var(--rosa-oscuro);
    letter-spacing:-.7px;
}

.subtitulo{
    color:var(--gris);
    font-size:11px;
    margin-top:3px;
}

.usuario{
    display:flex;
    align-items:center;
    gap:10px;
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
    font-size:8px;
    color:var(--gris);
    text-transform:uppercase;
    margin-top:2px;
}

.avatar{
    width:43px;
    height:43px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--rosa),var(--rosa-fuerte));
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    font-size:15px;
    box-shadow:0 6px 16px rgba(169,86,118,.18);
}

.dashboard-titulo{
    margin-bottom:18px;
}

.dashboard-titulo h1{
    font-size:21px;
    color:var(--rosa-oscuro);
}

.dashboard-titulo p{
    font-size:10px;
    color:var(--gris);
    margin-top:5px;
}

.resumen-principal{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    margin-bottom:16px;
}

.tarjeta-grande{
    padding:21px;
    border-radius:20px;
    border:1px solid rgba(255,255,255,.9);
    box-shadow:var(--sombra);
    position:relative;
    overflow:hidden;
}

.tarjeta-grande::after{
    content:"";
    position:absolute;
    width:120px;
    height:120px;
    border-radius:50%;
    right:-35px;
    bottom:-55px;
    background:rgba(255,255,255,.3);
}

.tarjeta-hoy{
    background:linear-gradient(135deg,#f6c4d5,#efb0c7);
}

.tarjeta-general{
    background:linear-gradient(135deg,#f9dfe8,#f3c7d6);
}

.etiqueta-grande{
    font-size:10px;
    font-weight:800;
    color:#8e4e68;
    letter-spacing:.6px;
}

.monto-grande{
    font-size:29px;
    font-weight:800;
    color:#873e5c;
    margin:10px 0 6px;
}

.cantidad-grande{
    font-size:10px;
    color:#96556f;
    font-weight:700;
}

.detalle-grande{
    font-size:9px;
    color:#a16b80;
    margin-top:7px;
}

.estadisticas{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:13px;
    margin-bottom:16px;
}

.card{
    min-height:125px;
    padding:16px;
    border-radius:18px;
    background:white;
    border:1px solid var(--borde);
    box-shadow:var(--sombra);
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    transition:.25s ease;
}

.card:hover{
    transform:translateY(-3px);
    box-shadow:0 14px 30px rgba(169,86,118,.16);
}

.card-arriba{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.card-icono{
    width:29px;
    height:29px;
    border-radius:9px;
    background:var(--rosa-claro);
    color:var(--rosa-oscuro);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    font-weight:800;
}

.card-menu{
    color:#c7aab5;
    font-size:12px;
}

.card-titulo{
    margin-top:8px;
    font-size:9px;
    color:var(--gris);
    font-weight:700;
}

.card-valor{
    font-size:21px;
    font-weight:800;
    color:var(--rosa-oscuro);
}

.card-cambio{
    font-size:8px;
    color:#aa8793;
    margin-top:3px;
}

.graficas{
    display:grid;
    grid-template-columns:1fr 1.15fr;
    gap:16px;
    margin-bottom:16px;
}

.panel{
    background:rgba(255,255,255,.9);
    border:1px solid var(--borde);
    border-radius:18px;
    padding:18px;
    box-shadow:var(--sombra);
}

.panel-cabecera{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.panel-titulo{
    color:var(--rosa-oscuro);
    font-size:13px;
    font-weight:800;
}

.panel-subtitulo{
    font-size:8px;
    color:var(--gris);
    margin-top:3px;
}

.filtro{
    background:var(--rosa-palido);
    border:1px solid var(--borde);
    padding:7px 10px;
    border-radius:9px;
    color:var(--rosa-oscuro);
    font-size:8px;
}

.donut-contenedor{
    min-height:205px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:25px;
}

.donut{
    width:165px;
    height:165px;
    border-radius:50%;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 8px 20px rgba(169,86,118,.12);
}

.donut::before{
    content:"";
    width:105px;
    height:105px;
    border-radius:50%;
    background:white;
    position:absolute;
}

.donut-centro{
    position:relative;
    z-index:2;
    text-align:center;
}

.donut-centro small{
    display:block;
    font-size:8px;
    color:var(--gris);
}

.donut-centro strong{
    display:block;
    font-size:17px;
    color:var(--rosa-oscuro);
    margin-top:3px;
}

.leyenda{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.leyenda-item{
    display:flex;
    align-items:center;
    gap:7px;
    font-size:8px;
    color:var(--gris);
}

.punto{
    width:8px;
    height:8px;
    border-radius:50%;
}

.punto.rosa1{background:#d985a3}
.punto.rosa2{background:#efb0c7}
.punto.rosa3{background:#f3c9d8}
.punto.rosa4{background:#c56f91}

.grafico-barras{
    height:220px;
    display:flex;
    align-items:flex-end;
    justify-content:space-around;
    gap:15px;
    padding:10px 5px 0;
}

.columna{
    height:100%;
    flex:1;
    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    align-items:center;
    gap:7px;
}

.valor-barra{
    font-size:7px;
    color:var(--gris);
    white-space:nowrap;
}

.barrita{
    width:42px;
    max-width:80%;
    border-radius:12px 12px 5px 5px;
    min-height:8px;
    animation:subir .8s ease both;
}

.barrita.rosa1{background:#efc4d3}
.barrita.rosa2{background:#d99ab1}
.barrita.rosa3{background:#efb0c7}
.barrita.rosa4{background:#c97d99}

.nombre-barra{
    font-size:8px;
    color:var(--gris);
}

@keyframes subir{
    from{transform:scaleY(0);transform-origin:bottom}
    to{transform:scaleY(1);transform-origin:bottom}
}

.contenedor-tabla{
    background:white;
    border:1px solid var(--borde);
    border-radius:22px;
    padding:21px;
    box-shadow:var(--sombra);
    overflow-x:auto;
}

.titulo-tabla{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:17px;
}

.titulo-tabla h2{
    color:var(--rosa-oscuro);
    font-size:19px;
}

.registros{
    background:var(--rosa-claro);
    color:var(--rosa-oscuro);
    padding:7px 11px;
    border-radius:20px;
    font-size:8px;
    font-weight:800;
}

table{
    width:100%;
    min-width:720px;
    border-collapse:collapse;
}

th{
    text-align:center;
    padding:12px 10px;
    color:#a48b95;
    font-size:8px;
    text-transform:uppercase;
    letter-spacing:.7px;
    border-bottom:1px solid var(--borde);
    background:#fffafd;
}

td{
    padding:13px 10px;
    text-align:center;
    border-bottom:1px solid #f7e8ed;
    font-size:11px;
    color:#6c5961;
}

tbody tr{
    transition:.2s ease;
}

tbody tr:hover{
    background:var(--rosa-palido);
}

.venta-hoy{
    background:rgba(253,235,241,.65);
}

.venta-hoy td{
    border-bottom:1px solid var(--rosa-claro);
}

td:first-child{
    color:var(--rosa-oscuro);
    font-weight:800;
}

.precio{
    color:var(--rosa-oscuro)!important;
    font-weight:800;
}

.estado{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:6px 10px;
    border-radius:20px;
    background:#f7e0e8;
    color:#a65374;
    font-size:8px;
    font-weight:800;
}

.estado::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:#d985a3;
}

.separador-ventas td{
    padding:0;
    border:none;
    background:white;
}

.separador-hoy-contenido{
    margin:23px 0 12px;
    padding:13px 16px;
    text-align:left;
    background:linear-gradient(90deg,var(--rosa-claro),#fff);
    border-left:6px solid var(--rosa-fuerte);
    border-radius:13px;
    color:var(--rosa-oscuro);
    font-size:15px;
    font-weight:800;
    letter-spacing:.7px;
}

.separador-anteriores-contenido{
    margin:28px 0 12px;
    padding:13px 16px;
    text-align:left;
    background:linear-gradient(90deg,#fff0f4,#fff);
    border-left:6px solid #c98aa0;
    border-radius:13px;
    color:#8c6070;
    font-size:14px;
    font-weight:800;
    letter-spacing:.5px;
}

.indicador-hoy{
    display:inline-block;
    margin-top:5px;
    padding:4px 9px;
    border-radius:15px;
    background:var(--rosa-claro);
    color:var(--rosa-oscuro);
    font-size:8px;
    font-weight:800;
}

.sin-ventas{
    padding:55px 20px;
    text-align:center;
    color:var(--gris);
}

.sin-ventas .emoji{
    font-size:45px;
    margin-bottom:10px;
}

.sin-ventas h3{
    color:var(--rosa-oscuro);
    margin-bottom:7px;
}

.volver{
    display:inline-block;
    margin-top:18px;
    padding:11px 23px;
    background:linear-gradient(135deg,var(--rosa-fuerte),var(--rosa-oscuro));
    color:white;
    text-decoration:none;
    border-radius:20px;
    font-weight:800;
    font-size:10px;
    transition:.25s;
}

.volver:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(169,86,118,.22);
}

@media(max-width:950px){
    .estadisticas{grid-template-columns:1fr 1fr}
    .graficas{grid-template-columns:1fr}
}

@media(max-width:650px){
    .contenedor{width:94%;margin-top:20px}
    .usuario-info{display:none}
    .titulo{font-size:20px}
    .resumen-principal{grid-template-columns:1fr}
    .estadisticas{grid-template-columns:1fr 1fr}
    .donut-contenedor{flex-direction:column;gap:15px}
    .leyenda{flex-direction:row;flex-wrap:wrap;justify-content:center}
}

@media(max-width:400px){
    .estadisticas{grid-template-columns:1fr}
    .avatar{width:37px;height:37px}
}
</style>
</head>

<body>
<div class="contenedor">

    <div class="encabezado">
        <div class="izquierda-cabecera">
            <div class="menu-icono">☰</div>
            <div>
                <div class="titulo">DIVINE</div>
                <div class="subtitulo">Control y registro de ventas</div>
            </div>
        </div>

        <div class="usuario">
            <div class="usuario-info">
                <div class="usuario-nombre"><?= htmlspecialchars($nombre) ?></div>
                <div class="usuario-rol"><?= htmlspecialchars($rol) ?></div>
            </div>
            <div class="avatar">
                <?= htmlspecialchars(strtoupper(substr($nombre ?: 'U', 0, 1))) ?>
            </div>
        </div>
    </div>

    <div class="dashboard-titulo">
        <h1>Resumen de ventas</h1>
        <p>Las ventas de hoy aparecen primero y después todas las ventas registradas.</p>
    </div>

    <section class="resumen-principal">
        <div class="tarjeta-grande tarjeta-hoy">
            <div class="etiqueta-grande">✨ VENTAS DE HOY ✨</div>
            <div class="monto-grande">Bs <?= number_format($totalHoy, 2) ?></div>
            <div class="cantidad-grande">
                💗 <?= $cantidadHoy ?> <?= $cantidadHoy == 1 ? 'VENTA HOY' : 'VENTAS HOY' ?>
            </div>
            <div class="detalle-grande">Pedidos cuyo estado es "Aceptado" y cuya venta corresponde a hoy.</div>
        </div>

        <div class="tarjeta-grande tarjeta-general">
            <div class="etiqueta-grande">📊 TOTAL DE VENTAS</div>
            <div class="monto-grande">Bs <?= number_format($totalGeneral, 2) ?></div>
            <div class="cantidad-grande">
                ✨ <?= $cantidadTotal ?> <?= $cantidadTotal == 1 ? 'VENTA REGISTRADA' : 'VENTAS REGISTRADAS' ?>
            </div>
            <div class="detalle-grande">Todas las ventas relacionadas con pedidos en estado "Aceptado".</div>
        </div>
    </section>

    <section class="estadisticas">
        <article class="card">
            <div>
                <div class="card-arriba">
                    <div class="card-icono">♡</div>
                    <div class="card-menu">•••</div>
                </div>
                <div class="card-titulo">Ventas de hoy</div>
            </div>
            <div>
                <div class="card-valor">Bs <?= number_format($totalHoy,2) ?></div>
                <div class="card-cambio"><?= $cantidadHoy ?> ventas hoy</div>
            </div>
        </article>

        <article class="card">
            <div>
                <div class="card-arriba">
                    <div class="card-icono">7</div>
                    <div class="card-menu">•••</div>
                </div>
                <div class="card-titulo">Últimos 7 días</div>
            </div>
            <div>
                <div class="card-valor">Bs <?= number_format($totalSemana,2) ?></div>
                <div class="card-cambio">Ventas acumuladas</div>
            </div>
        </article>

        <article class="card">
            <div>
                <div class="card-arriba">
                    <div class="card-icono">30</div>
                    <div class="card-menu">•••</div>
                </div>
                <div class="card-titulo">Últimos 30 días</div>
            </div>
            <div>
                <div class="card-valor">Bs <?= number_format($totalMes,2) ?></div>
                <div class="card-cambio">Rendimiento mensual</div>
            </div>
        </article>

        <article class="card">
            <div>
                <div class="card-arriba">
                    <div class="card-icono">✦</div>
                    <div class="card-menu">•••</div>
                </div>
                <div class="card-titulo">Total general</div>
            </div>
            <div>
                <div class="card-valor">Bs <?= number_format($totalGeneral,2) ?></div>
                <div class="card-cambio">Todas las ventas</div>
            </div>
        </article>
    </section>

    <section class="graficas">
        <article class="panel">
            <div class="panel-cabecera">
                <div>
                    <div class="panel-titulo">Distribución de ventas</div>
                    <div class="panel-subtitulo">Resumen visual por período</div>
                </div>
                <div class="filtro">DIVINE ♡</div>
            </div>

            <div class="donut-contenedor">
                <div
                    class="donut"
                    style="background:conic-gradient(
                        #d985a3 0deg <?= $anguloDia ?>deg,
                        #efb0c7 <?= $anguloDia ?>deg <?= $anguloSemana ?>deg,
                        #f3c9d8 <?= $anguloSemana ?>deg <?= $anguloMes ?>deg,
                        #c56f91 <?= $anguloMes ?>deg 360deg
                    );"
                >
                    <div class="donut-centro">
                        <small>Total</small>
                        <strong>Bs <?= number_format($totalGrafico,0) ?></strong>
                    </div>
                </div>

                <div class="leyenda">
                    <div class="leyenda-item"><span class="punto rosa1"></span>Hoy</div>
                    <div class="leyenda-item"><span class="punto rosa2"></span>7 días</div>
                    <div class="leyenda-item"><span class="punto rosa3"></span>30 días</div>
                    <div class="leyenda-item"><span class="punto rosa4"></span>Total</div>
                </div>
            </div>
        </article>

        <article class="panel">
            <div class="panel-cabecera">
                <div>
                    <div class="panel-titulo">Resumen de ventas</div>
                    <div class="panel-subtitulo">Comparación por período</div>
                </div>
                <div class="filtro">Ventas</div>
            </div>

            <div class="grafico-barras">
                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorDia,0) ?></div>
                    <div class="barrita rosa1" style="height:<?= max(8,$barraDia*1.55) ?>px;"></div>
                    <div class="nombre-barra">Hoy</div>
                </div>

                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorSemana,0) ?></div>
                    <div class="barrita rosa2" style="height:<?= max(8,$barraSemana*1.55) ?>px;"></div>
                    <div class="nombre-barra">7 días</div>
                </div>

                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorMes,0) ?></div>
                    <div class="barrita rosa3" style="height:<?= max(8,$barraMes*1.55) ?>px;"></div>
                    <div class="nombre-barra">30 días</div>
                </div>

                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorTotal,0) ?></div>
                    <div class="barrita rosa4" style="height:<?= max(8,$barraTotal*1.55) ?>px;"></div>
                    <div class="nombre-barra">Total</div>
                </div>
            </div>
        </article>
    </section>

    <div class="contenedor-tabla">
        <div class="titulo-tabla">
            <h2>💗 Ventas registradas</h2>
            <div class="registros"><?= $totalRegistros ?> registros</div>
        </div>

        <?php if ($resultado && $resultado->num_rows > 0): ?>

        <table id="tabla-ingresos">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Pedido</th>
                    <th>Fecha de venta</th>
                    <th>Método</th>
                    <th>Estado</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $fechaHoy = date('Y-m-d');
            $mostroHoy = false;
            $mostroAnteriores = false;

            while ($fila = $resultado->fetch_assoc()):
                $fechaVenta = !empty($fila['fecha'])
                    ? date('Y-m-d', strtotime($fila['fecha']))
                    : '';

                $esHoy = ($fechaVenta === $fechaHoy);
            ?>

                <?php if ($esHoy && !$mostroHoy): ?>
                    <?php $mostroHoy = true; ?>
                    <tr class="separador-ventas">
                        <td colspan="6">
                            <div class="separador-hoy-contenido">
                                💗 ✨ VENTAS DE HOY ✨ 💗
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (!$esHoy && !$mostroAnteriores): ?>
                    <?php $mostroAnteriores = true; ?>
                    <tr class="separador-ventas">
                        <td colspan="6">
                            <div class="separador-anteriores-contenido">
                                📋 VENTAS DE OTROS DÍAS
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr class="<?= $esHoy ? 'venta-hoy' : '' ?>">
                    <td>
                        <strong>#<?= htmlspecialchars($fila['id']) ?></strong>
                    </td>

                    <td>
                        #<?= htmlspecialchars($fila['PEDIDOS_ID']) ?>
                    </td>

                    <td>
                        <?= !empty($fila['fecha'])
                            ? date('d/m/Y H:i', strtotime($fila['fecha']))
                            : 'Sin fecha' ?>

                        <?php if ($esHoy): ?>
                            <br>
                            <span class="indicador-hoy">HOY 💗</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($fila['metodo'] ?? '') ?>
                    </td>

                    <td>
                        <span class="estado">
                            ✓ <?= htmlspecialchars($fila['estado_pedido'] ?? 'Aceptado') ?>
                        </span>
                    </td>

                    <td>
                        <strong class="precio">
                            Bs <?= number_format((float)$fila['costototal'], 2) ?>
                        </strong>
                    </td>
                </tr>

            <?php endwhile; ?>
            </tbody>
        </table>

        <?php else: ?>

            <div class="sin-ventas">
                <div class="emoji">🌸</div>
                <h3>No hay ventas registradas</h3>
                <p>No existen ventas relacionadas con pedidos cuyo estado sea "Aceptado".</p>
            </div>

        <?php endif; ?>

        <a href="../REPORTES/reportes.php" class="volver">← Volver a reportes</a>
    </div>

</div>
</body>
</html>

<?php
$conn->close();
?>
