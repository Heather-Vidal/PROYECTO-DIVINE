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
    header("Location: ../SESIONES/loginformcliente.php");
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --rosa-principal: #e094b0;
    --rosa-fuerte: #d67096;
    --rosa-oscuro: #8c3b5d;
    --rosa-claro: #fbebf1;
    --rosa-palido: #fff8fa;
    --rosa-gradiente-1: #f8c2d4;
    --rosa-gradiente-2: #eed5e1;
    --blanco: #ffffff;
    --texto: #4a3840;
    --gris: #88727c;
    --borde: #f0d5df;
    --sombra: 0 16px 40px rgba(140, 59, 93, 0.09);
    --sombra-hover: 0 22px 50px rgba(140, 59, 93, 0.18);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif;
    min-height: 100vh;
    background: 
        radial-gradient(circle at 10% 10%, rgba(248, 194, 212, 0.35), transparent 45%),
        radial-gradient(circle at 90% 80%, rgba(251, 235, 241, 0.7), transparent 45%),
        linear-gradient(135deg, #fffafd, #fdf4f7);
    color: var(--texto);
    padding-bottom: 50px;
}

.contenedor {
    width: 94%;
    max-width: 1320px;
    margin: 35px auto 0;
}

/* Encabezado */
.encabezado {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    padding: 20px 30px;
    border-radius: 24px;
    border: 1px solid var(--borde);
    box-shadow: var(--sombra);
}

.izquierda-cabecera {
    display: flex;
    align-items: center;
    gap: 16px;
}

.menu-icono {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--rosa-fuerte), var(--rosa-principal));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 8px 20px rgba(214, 112, 150, 0.35);
}

.titulo {
    font-size: 24px;
    font-weight: 800;
    color: var(--rosa-oscuro);
    letter-spacing: -0.5px;
}

.subtitulo {
    color: var(--gris);
    font-size: 13px;
    font-weight: 500;
}

.usuario {
    display: flex;
    align-items: center;
    gap: 14px;
}

.usuario-info {
    text-align: right;
}

.usuario-nombre {
    font-size: 14px;
    font-weight: 700;
    color: var(--texto);
}

.usuario-rol {
    font-size: 11px;
    font-weight: 700;
    color: var(--rosa-fuerte);
    text-transform: uppercase;
    letter-spacing: 0.6px;
}

.avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--rosa-principal), var(--rosa-fuerte));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 18px;
    box-shadow: 0 6px 16px rgba(214, 112, 150, 0.3);
    border: 3px solid white;
}

.dashboard-titulo {
    margin-bottom: 28px;
}

.dashboard-titulo h1 {
    font-size: 28px;
    font-weight: 800;
    color: var(--rosa-oscuro);
    letter-spacing: -0.6px;
}

.dashboard-titulo p {
    font-size: 14px;
    color: var(--gris);
    margin-top: 6px;
    font-weight: 500;
}

/* Tarjetas Principales Agrandadas */
.resumen-principal {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 28px;
}

.tarjeta-grande {
    padding: 36px 32px;
    border-radius: 28px;
    border: 1px solid rgba(255, 255, 255, 0.9);
    box-shadow: var(--sombra);
    position: relative;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.tarjeta-grande:hover {
    transform: translateY(-5px);
    box-shadow: var(--sombra-hover);
}

.tarjeta-grande::after {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    right: -40px;
    bottom: -60px;
    background: rgba(255, 255, 255, 0.22);
    pointer-events: none;
}

.tarjeta-hoy {
    background: linear-gradient(135deg, #f7b1c8, #e08ea8);
}

.tarjeta-general {
    background: linear-gradient(135deg, #e4c4d4, #c988a3);
}

.etiqueta-grande {
    font-size: 12px;
    font-weight: 800;
    color: #5c1e34;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.monto-grande {
    font-size: 42px;
    font-weight: 800;
    color: #4a1327;
    margin: 14px 0 8px;
    letter-spacing: -1.2px;
}

.cantidad-grande {
    font-size: 14px;
    color: #5c1e34;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detalle-grande {
    font-size: 12px;
    color: #6e2a44;
    margin-top: 14px;
    font-weight: 500;
    line-height: 1.4;
}

/* Grid de Estadísticas Agrandado */
.estadisticas {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}

.card {
    padding: 28px 24px;
    border-radius: 24px;
    background: white;
    border: 1px solid var(--borde);
    box-shadow: var(--sombra);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    min-height: 150px;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: var(--sombra-hover);
    border-color: var(--rosa-principal);
}

.card-arriba {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.card-icono {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: var(--rosa-claro);
    color: var(--rosa-oscuro);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
}

.card-menu {
    color: #c7aab5;
    font-size: 16px;
    cursor: pointer;
}

.card-titulo {
    font-size: 13px;
    color: var(--gris);
    font-weight: 600;
}

.card-valor {
    font-size: 26px;
    font-weight: 800;
    color: var(--rosa-oscuro);
    margin-top: 6px;
    letter-spacing: -0.5px;
}

.card-cambio {
    font-size: 12px;
    color: #9a7d88;
    margin-top: 6px;
    font-weight: 500;
}

/* Gráficos Agrandados */
.graficas {
    display: grid;
    grid-template-columns: 1fr 1.15fr;
    gap: 24px;
    margin-bottom: 28px;
}

.panel {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid var(--borde);
    border-radius: 26px;
    padding: 28px;
    box-shadow: var(--sombra);
}

.panel-cabecera {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.panel-titulo {
    color: var(--rosa-oscuro);
    font-size: 17px;
    font-weight: 800;
}

.panel-subtitulo {
    font-size: 12px;
    color: var(--gris);
    margin-top: 3px;
    font-weight: 500;
}

.filtro {
    background: var(--rosa-claro);
    border: 1px solid var(--borde);
    padding: 6px 14px;
    border-radius: 20px;
    color: var(--rosa-oscuro);
    font-size: 12px;
    font-weight: 700;
}

.donut-contenedor {
    min-height: 230px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 36px;
    padding: 10px 0;
}

.donut {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 24px rgba(140, 59, 93, 0.12);
    transition: transform 0.3s ease;
}

.donut:hover {
    transform: scale(1.04);
}

.donut::before {
    content: "";
    width: 114px;
    height: 114px;
    border-radius: 50%;
    background: white;
    position: absolute;
}

.donut-centro {
    position: relative;
    z-index: 2;
    text-align: center;
}

.donut-centro small {
    display: block;
    font-size: 11px;
    color: var(--gris);
    font-weight: 600;
    text-transform: uppercase;
}

.donut-centro strong {
    display: block;
    font-size: 18px;
    color: var(--rosa-oscuro);
    font-weight: 800;
    margin-top: 2px;
}

.leyenda {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.leyenda-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--texto);
    font-weight: 600;
}

.punto {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.punto.rosa1 { background: #d67096; }
.punto.rosa2 { background: #e094b0; }
.punto.rosa3 { background: #f3c9d8; }
.punto.rosa4 { background: #aa5073; }

.grafico-barras {
    height: 230px;
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    gap: 18px;
    padding: 20px 10px 0;
}

.columna {
    height: 100%;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

.valor-barra {
    font-size: 11px;
    color: var(--rosa-oscuro);
    font-weight: 700;
    white-space: nowrap;
}

.barrita {
    width: 44px;
    max-width: 85%;
    border-radius: 10px 10px 4px 4px;
    min-height: 10px;
    animation: subir 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
    transition: opacity 0.2s ease;
}

.barrita:hover {
    opacity: 0.85;
}

.barrita.rosa1 { background: #f3b0c3; }
.barrita.rosa2 { background: #e08ea8; }
.barrita.rosa3 { background: #d67096; }
.barrita.rosa4 { background: #b04e73; }

.nombre-barra {
    font-size: 12px;
    color: var(--gris);
    font-weight: 600;
}

@keyframes subir {
    from { transform: scaleY(0); transform-origin: bottom; }
    to { transform: scaleY(1); transform-origin: bottom; }
}

/* Tabla de Ventas */
.contenedor-tabla {
    background: white;
    border: 1px solid var(--borde);
    border-radius: 26px;
    padding: 28px;
    box-shadow: var(--sombra);
    overflow-x: auto;
}

.titulo-tabla {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.titulo-tabla h2 {
    color: var(--rosa-oscuro);
    font-size: 20px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 10px;
}

.registros {
    background: var(--rosa-claro);
    color: var(--rosa-oscuro);
    padding: 7px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

table {
    width: 100%;
    min-width: 700px;
    border-collapse: separate;
    border-spacing: 0;
}

th {
    text-align: center;
    padding: 16px 14px;
    color: var(--gris);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-weight: 700;
    border-bottom: 2px solid var(--rosa-claro);
    background: #fffcfd;
}

td {
    padding: 16px 14px;
    text-align: center;
    border-bottom: 1px solid #f9ebf0;
    font-size: 14px;
    color: var(--texto);
    font-weight: 500;
}

tbody tr {
    transition: background-color 0.2s ease;
}

tbody tr:not(.separador-ventas):hover {
    background-color: var(--rosa-palido);
}

.venta-hoy {
    background-color: rgba(251, 235, 241, 0.45);
}

td:first-child strong {
    color: var(--rosa-oscuro);
}

.precio {
    color: var(--rosa-oscuro) !important;
    font-weight: 800 !important;
    font-size: 15px !important;
}

.estado {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    background: #fbebf1;
    color: #b04e73;
    font-size: 12px;
    font-weight: 700;
}

.estado::before {
    content: "";
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--rosa-fuerte);
}

.separador-ventas td {
    padding: 0;
    border: none;
    background: transparent;
}

.separador-hoy-contenido {
    margin: 22px 0 12px;
    padding: 14px 20px;
    text-align: left;
    background: linear-gradient(90deg, var(--rosa-claro), white);
    border-left: 5px solid var(--rosa-fuerte);
    border-radius: 12px;
    color: var(--rosa-oscuro);
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.separador-anteriores-contenido {
    margin: 26px 0 12px;
    padding: 14px 20px;
    text-align: left;
    background: linear-gradient(90deg, #f7edf2, white);
    border-left: 5px solid #b88699;
    border-radius: 12px;
    color: #7d5464;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.indicador-hoy {
    display: inline-block;
    margin-top: 4px;
    padding: 3px 10px;
    border-radius: 12px;
    background: var(--rosa-fuerte);
    color: white;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.sin-ventas {
    padding: 60px 20px;
    text-align: center;
    color: var(--gris);
}

.sin-ventas .emoji {
    font-size: 48px;
    margin-bottom: 14px;
}

.sin-ventas h3 {
    color: var(--rosa-oscuro);
    margin-bottom: 6px;
    font-weight: 700;
}

.volver {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-top: 24px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--rosa-fuerte), var(--rosa-oscuro));
    color: white;
    text-decoration: none;
    border-radius: 16px;
    font-weight: 700;
    font-size: 13px;
    transition: all 0.25s ease;
    box-shadow: 0 6px 16px rgba(140, 59, 93, 0.25);
}

.volver:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(140, 59, 93, 0.35);
}

/* Responsivo */
@media(max-width: 950px) {
    .estadisticas { grid-template-columns: 1fr 1fr; }
    .graficas { grid-template-columns: 1fr; }
}

@media(max-width: 650px) {
    .contenedor { width: 94%; margin-top: 20px; }
    .usuario-info { display: none; }
    .titulo { font-size: 20px; }
    .resumen-principal { grid-template-columns: 1fr; }
    .estadisticas { grid-template-columns: 1fr 1fr; }
    .donut-contenedor { flex-direction: column; gap: 24px; }
    .leyenda { flex-direction: row; flex-wrap: wrap; justify-content: center; }
}

@media(max-width: 420px) {
    .estadisticas { grid-template-columns: 1fr; }
    .avatar { width: 40px; height: 40px; }
}
</style>
</head>

<body>
    <?php include '../menus.php'; ?>

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
            <div class="etiqueta-grande"> VENTAS DE HOY </div>
            <div class="monto-grande">Bs <?= number_format($totalHoy, 2) ?></div>
            <div class="cantidad-grande">
                <span>💗</span> <?= $cantidadHoy ?> <?= $cantidadHoy == 1 ? 'VENTA HOY' : 'VENTAS HOY' ?>
            </div>
            <div class="detalle-grande">Pedidos cuyo estado es "Aceptado" y cuya venta corresponde a hoy.</div>
        </div>

        <div class="tarjeta-grande tarjeta-general">
            <div class="etiqueta-grande"> TOTAL DE VENTAS</div>
            <div class="monto-grande">Bs <?= number_format($totalGeneral, 2) ?></div>
            <div class="cantidad-grande">
                <span>✨</span> <?= $cantidadTotal ?> <?= $cantidadTotal == 1 ? 'VENTA REGISTRADA' : 'VENTAS REGISTRADAS' ?>
            </div>
            <div class="detalle-grande">Todas las ventas relacionadas con pedidos en estado "Aceptado".</div>
        </div>
    </section>

    <section class="estadisticas">
        <article class="card">
            <div>
                <div class="card-arriba">
                    <div class="card-icono">♡</div>

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
                        #d67096 0deg <?= $anguloDia ?>deg,
                        #e094b0 <?= $anguloDia ?>deg <?= $anguloSemana ?>deg,
                        #f3c9d8 <?= $anguloSemana ?>deg <?= $anguloMes ?>deg,
                        #aa5073 <?= $anguloMes ?>deg 360deg
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
                    <div class="barrita rosa1" style="height:<?= max(10,$barraDia*1.5) ?>px;"></div>
                    <div class="nombre-barra">Hoy</div>
                </div>

                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorSemana,0) ?></div>
                    <div class="barrita rosa2" style="height:<?= max(10,$barraSemana*1.5) ?>px;"></div>
                    <div class="nombre-barra">7 días</div>
                </div>

                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorMes,0) ?></div>
                    <div class="barrita rosa3" style="height:<?= max(10,$barraMes*1.5) ?>px;"></div>
                    <div class="nombre-barra">30 días</div>
                </div>

                <div class="columna">
                    <div class="valor-barra">Bs <?= number_format($valorTotal,0) ?></div>
                    <div class="barrita rosa4" style="height:<?= max(10,$barraTotal*1.5) ?>px;"></div>
                    <div class="nombre-barra">Total</div>
                </div>
            </div>
        </article>
    </section>

    <div class="contenedor-tabla">
        <div class="titulo-tabla">
            <h2><span>💗</span> Ventas registradas</h2>
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
                                VENTAS DE HOY 
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (!$esHoy && !$mostroAnteriores): ?>
                    <?php $mostroAnteriores = true; ?>
                    <tr class="separador-ventas">
                        <td colspan="6">
                            <div class="separador-anteriores-contenido">
                                 VENTAS DE OTROS DÍAS
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