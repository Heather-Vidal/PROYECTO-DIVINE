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


/* =========================================================
   VALIDAR SESIÓN
========================================================= */

if (!isset($_SESSION['rol'])) {
    header("Location: ../SESIONES/loginform.php");
    exit();
}

$rol = $_SESSION['rol'];

$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

/* =========================================================
   CONSULTAR VENTAS
========================================================= */

if ($rol == "administrador") {

    /*
       MOSTRAR TODAS LAS VENTAS
       PERO SOLO DE PEDIDOS COMPLETADOS

       LAS VENTAS DE HOY APARECEN PRIMERO
    */

    $sql = "
        SELECT 
            v.id,
            v.estado,
            v.metodo,
            v.costototal,
            v.PEDIDOS_ID,
            p.fecha
        FROM VENTAS v
        INNER JOIN PEDIDOS p
            ON p.ID = v.PEDIDOS_ID
        WHERE p.estado = 'Completado'
        ORDER BY
            DATE(p.fecha) = CURDATE() DESC,
            p.fecha DESC
    ";

} elseif ($rol == "vendedor") {

    /*
       MOSTRAR SOLO LAS VENTAS DEL VENDEDOR
       Y SOLO DE PEDIDOS COMPLETADOS

       LAS VENTAS DE HOY APARECEN PRIMERO
    */

    $sql = "
        SELECT 
            v.id,
            v.estado,
            v.metodo,
            v.costototal,
            v.PEDIDOS_ID,
            p.fecha
        FROM VENTAS v
        INNER JOIN PEDIDOS p
            ON p.ID = v.PEDIDOS_ID
        WHERE 
            p.estado = 'Completado'
            AND p.nombrevendedor = '$nombre'
        ORDER BY
            DATE(p.fecha) = CURDATE() DESC,
            p.fecha DESC
    ";

} else {

    header("Location: ../SESIONES/loginform.php");
    exit();

}


$resultado = $conn->query($sql);


/* =========================================================
   VENTAS DE HOY
========================================================= */

$sqlHoy = "
    SELECT SUM(v.costototal) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE
        DATE(p.fecha) = CURDATE()
        AND p.estado = 'Completado'
";

if ($rol == "vendedor") {
    $sqlHoy .= " AND p.nombrevendedor = '$nombre'";
}

$resultadoHoy = $conn->query($sqlHoy);
$filaHoy = $resultadoHoy->fetch_assoc();

$totalHoy = $filaHoy['total'] ?? 0;


/* =========================================================
   VENTAS ÚLTIMOS 7 DÍAS
========================================================= */

$sqlSemana = "
    SELECT SUM(v.costototal) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE
        p.fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        AND p.estado = 'Completado'
";

if ($rol == "vendedor") {
    $sqlSemana .= " AND p.nombrevendedor = '$nombre'";
}

$resultadoSemana = $conn->query($sqlSemana);
$filaSemana = $resultadoSemana->fetch_assoc();

$totalSemana = $filaSemana['total'] ?? 0;


/* =========================================================
   VENTAS ÚLTIMOS 30 DÍAS
========================================================= */

$sqlMes = "
    SELECT SUM(v.costototal) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE
        p.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        AND p.estado = 'Completado'
";

if ($rol == "vendedor") {
    $sqlMes .= " AND p.nombrevendedor = '$nombre'";
}

$resultadoMes = $conn->query($sqlMes);
$filaMes = $resultadoMes->fetch_assoc();

$totalMes = $filaMes['total'] ?? 0;


/* =========================================================
   TOTAL GENERAL
========================================================= */

$sqlTotal = "
    SELECT SUM(v.costototal) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID
    WHERE p.estado = 'Completado'
";

if ($rol == "vendedor") {
    $sqlTotal .= " AND p.nombrevendedor = '$nombre'";
}

$resultadoTotal = $conn->query($sqlTotal);
$filaTotal = $resultadoTotal->fetch_assoc();

$totalGeneral = $filaTotal['total'] ?? 0;


// =========================================================
// DATOS PARA EL GRÁFICO
// =========================================================

// Se utilizan los mismos totales existentes.
// No se modifica ninguna consulta ni función.

$valorDia    = (float)$totalventadia;
$valorSemana = (float)$totalventasemana;
$valorMes    = (float)$totalventames;
$valorAnio   = (float)$totalventaanio;

$totalGrafico = $valorDia + $valorSemana + $valorMes + $valorAnio;

if ($totalGrafico > 0) {

    $porDia    = ($valorDia / $totalGrafico) * 100;
    $porSemana = ($valorSemana / $totalGrafico) * 100;
    $porMes    = ($valorMes / $totalGrafico) * 100;
    $porAnio   = ($valorAnio / $totalGrafico) * 100;

} else {

    $porDia = 25;
    $porSemana = 25;
    $porMes = 25;
    $porAnio = 25;
}


// =========================================================
// BARRAS
// =========================================================

$maxBarra = max(
    $valorDia,
    $valorSemana,
    $valorMes,
    $valorAnio,
    1
);

$barraDia    = ($valorDia / $maxBarra) * 100;
$barraSemana = ($valorSemana / $maxBarra) * 100;
$barraMes    = ($valorMes / $maxBarra) * 100;
$barraAnio   = ($valorAnio / $maxBarra) * 100;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ventas - DIVINE</title>

<style>

/* =========================================================
   COLORES DIVINE
========================================================= */

:root {

    --fondo: #f1fbfa;

    --fondo2: #e8f8f6;

    --blanco: #ffffff;

    --texto: #183b3d;

    --texto2: #577274;

    --verde: #58c4b8;

    --verde-oscuro: #0d4749;

    --verde-claro: #bfece5;

    --verde-palido: #e0f6f2;

    --azul: #79b9bd;

    --amarillo: #dce9a5;

    --rosa: #eeb0c6;

    --morado: #c7a8df;

    --borde: #d9efed;

    --sombra: 0 8px 30px rgba(39, 107, 105, .07);

}


/* =========================================================
   GENERAL
========================================================= */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

}


body {

    font-family: Arial, sans-serif;

    min-height: 100vh;

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(151, 225, 218, .25),
            transparent 28%
        ),
        var(--fondo);

    color: var(--texto);

}


/* =========================================================
   CONTENEDOR
========================================================= */

.contenedor {

    width: 94%;

    max-width: 1250px;

    margin: 40px auto;

}


/* =========================================================
   ENCABEZADO
========================================================= */

.encabezado {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 24px;

}


.izquierda-cabecera {

    display: flex;

    align-items: center;

    gap: 14px;

}


.menu-icono {

    width: 42px;

    height: 42px;

    border-radius: 12px;

    background: var(--verde-oscuro);

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 18px;

}


.titulo {

    font-size: 24px;

    font-weight: 700;

    letter-spacing: -.8px;

    color: var(--verde-oscuro);

}


.subtitulo {

    color: var(--texto2);

    font-size: 11px;

    margin-top: 3px;

}


.usuario {

    display: flex;

    align-items: center;

    gap: 10px;

}


.usuario-info {

    text-align: right;

}


.usuario-nombre {

    font-size: 11px;

    font-weight: 700;

    color: var(--texto);

}


.usuario-rol {

    font-size: 8px;

    color: var(--texto2);

    text-transform: uppercase;

}


.avatar {

    width: 42px;

    height: 42px;

    border-radius: 50%;

    background: linear-gradient(
        135deg,
        #7ccbc3,
        #4ba7a4
    );

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 700;

    font-size: 14px;

    box-shadow: 0 5px 15px rgba(57, 146, 143, .2);

}


/* =========================================================
   TITULO DEL DASHBOARD
========================================================= */

.dashboard-titulo {

    margin-bottom: 18px;

}


.dashboard-titulo h1 {

    font-size: 18px;

    color: var(--verde-oscuro);

    font-weight: 700;

}


.dashboard-titulo p {

    font-size: 10px;

    color: var(--texto2);

    margin-top: 4px;

}


/* =========================================================
   TARJETAS PRINCIPALES
========================================================= */

.estadisticas {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 13px;

    margin-bottom: 16px;

}


.card {

    min-height: 135px;

    padding: 17px;

    border-radius: 17px;

    border: 1px solid rgba(255,255,255,.7);

    position: relative;

    overflow: hidden;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    box-shadow: var(--sombra);

    transition: .3s ease;

}


.card:hover {

    transform: translateY(-3px);

}


.card:nth-child(1) {

    background: #c9f0ea;

}


.card:nth-child(2) {

    background: #bce8e4;

}


.card:nth-child(3) {

    background: #f4b8ca;

}


.card:nth-child(4) {

    background: #c9d9f0;

}


.card::after {

    content: "";

    position: absolute;

    width: 75px;

    height: 75px;

    border-radius: 50%;

    background: rgba(255,255,255,.20);

    right: -20px;

    bottom: -25px;

}


.card-arriba {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

}


.card-icono {

    width: 28px;

    height: 28px;

    border-radius: 8px;

    background: rgba(255,255,255,.6);

    color: var(--verde-oscuro);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 13px;

    font-weight: 700;

}


.card-menu {

    width: 25px;

    height: 25px;

    border-radius: 50%;

    background: rgba(255,255,255,.35);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 13px;

}


.card-titulo {

    margin-top: 8px;

    font-size: 9px;

    color: #527070;

    font-weight: 600;

}


.card-valor {

    font-size: 23px;

    font-weight: 700;

    color: var(--verde-oscuro);

    margin-top: 3px;

}


.card-cambio {

    font-size: 8px;

    color: #568783;

    margin-top: 2px;

}


/* =========================================================
   GRÁFICAS
========================================================= */

.graficas {

    display: grid;

    grid-template-columns: 1fr 1.15fr;

    gap: 16px;

    margin-bottom: 16px;

}


.panel {

    background: rgba(255,255,255,.72);

    border: 1px solid var(--borde);

    border-radius: 17px;

    padding: 18px;

    box-shadow: var(--sombra);

}


.panel-cabecera {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 14px;

}


.encabezado h1 {

    color: var(--vino-oscuro);

    font-size: 35px;

    color: var(--verde-oscuro);

}


.panel-subtitulo {

    font-size: 8px;

    color: var(--texto2);

    margin-top: 3px;

}


.filtro {

    background: var(--verde-palido);

    border: none;

    padding: 7px 10px;

    border-radius: 9px;

    color: var(--verde-oscuro);

    font-size: 8px;

    font-family: inherit;

}


/* =========================================================
   DONUT
========================================================= */

.donut-contenedor {

    min-height: 205px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 25px;

}


.donut {

    width: 165px;

    height: 165px;

    border-radius: 50%;

    background:
        conic-gradient(
            var(--verde) 0deg
            <?php echo ($porDia * 3.6); ?>deg,

            var(--amarillo)
            <?php echo ($porDia * 3.6); ?>deg
            <?php echo (($porDia + $porSemana) * 3.6); ?>deg,

            var(--rosa)
            <?php echo (($porDia + $porSemana) * 3.6); ?>deg
            <?php echo (($porDia + $porSemana + $porMes) * 3.6); ?>deg,

            var(--azul)
            <?php echo (($porDia + $porSemana + $porMes) * 3.6); ?>deg
            360deg
        );

    position: relative;

    display: flex;

    align-items: center;

    justify-content: center;

    box-shadow: 0 8px 20px rgba(69, 152, 148, .12);

}


.donut::before {

    content: "";

    width: 105px;

    height: 105px;

    border-radius: 50%;

    background: var(--blanco);

    position: absolute;

}


.donut-centro {

    position: relative;

    z-index: 2;

    text-align: center;

}


.donut-centro small {

    display: block;

    font-size: 8px;

    color: var(--texto2);

}


.donut-centro strong {

    display: block;

    font-size: 18px;

    color: var(--verde-oscuro);

    margin-top: 3px;

}


.leyenda {

    display: flex;

    flex-direction: column;

    gap: 10px;

}


.leyenda-item {

    display: flex;

    align-items: center;

    gap: 7px;

    font-size: 8px;

    color: var(--texto2);

}


.punto {

    width: 8px;

    height: 8px;

    border-radius: 50%;

}


.punto.verde {

    background: var(--verde);

}


.punto.amarillo {

    background: var(--amarillo);

}


.punto.rosa {

    background: var(--rosa);

}


.punto.azul {

    background: var(--azul);

}


/* =========================================================
   BARRAS VERTICALES
========================================================= */

.grafico-barras {

    height: 220px;

    display: flex;

    align-items: flex-end;

    justify-content: space-around;

    gap: 15px;

    padding: 10px 5px 0;

}


.columna {

    height: 100%;

    flex: 1;

    display: flex;

    flex-direction: column;

    justify-content: flex-end;

    align-items: center;

    gap: 7px;

}


.valor-barra {

    font-size: 7px;

    color: var(--texto2);

    white-space: nowrap;

}


.barrita {

    width: 42px;

    max-width: 80%;

    border-radius: 12px 12px 5px 5px;

    min-height: 8px;

    animation: subir .9s ease both;

}


.columna:nth-child(1) .barrita {

    height: <?php echo max(8, $barraDia * 1.55); ?>px;

    background: #efcba0;

}


.columna:nth-child(2) .barrita {

    height: <?php echo max(8, $barraSemana * 1.55); ?>px;

    background: #d69fda;

}


.columna:nth-child(3) .barrita {

    height: <?php echo max(8, $barraMes * 1.55); ?>px;

    background: #b9d983;

}


.columna:nth-child(4) .barrita {

    height: <?php echo max(8, $barraAnio * 1.55); ?>px;

    background: #84c7c1;

}


.nombre-barra {

    font-size: 8px;

    color: var(--texto2);

}


@keyframes subir {

    from {

        transform: scaleY(0);

        transform-origin: bottom;

    }

    to {

        transform: scaleY(1);

        transform-origin: bottom;

    }

}


/* =========================================================
   RESUMEN
========================================================= */

.resumen {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 16px;

    margin-bottom: 16px;

}


.tarjeta {

    background: rgba(255,250,248,0.94);

    background: white;

    border: 1px solid var(--borde);

    border-radius: 16px;

    padding: 16px;

    box-shadow: var(--sombra);

}


.tarjeta:hover {

    transform: translateY(-5px);

    align-items: center;

    justify-content: space-between;

}


.tarjeta .icono {

    font-size: 9px;

    color: var(--texto2);

    text-transform: uppercase;

    font-weight: 700;

}


.tarjeta h3 {

    font-size: 17px;

    color: var(--verde-oscuro);

}


.tarjeta .monto {

    color: var(--vino-oscuro);

    height: 7px;

    background: #edf7f6;

    border-radius: 10px;

    overflow: hidden;

    margin-top: 14px;

}


.progreso span {

    display: block;

    height: 100%;

    background: linear-gradient(
        90deg,
        #72cfc4,
        #42aaa3
    );

    border-radius: 10px;

}


.resumen-info {

    display: flex;

    justify-content: space-between;

    margin-top: 7px;

    font-size: 8px;

    color: #91a2a3;

}


/* =========================================================
   HISTORIAL
========================================================= */

.historial {

    background: white;

    border: 1px solid var(--borde);

    border-radius: 17px;

    padding: 18px;

    box-shadow: var(--sombra);

}


.historial-cabecera {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 15px;

}


.historial-titulo {

    display: flex;

    align-items: center;

    gap: 9px;

}


.historial-icono {

    width: 33px;

    height: 33px;

    border-radius: 9px;

    background: var(--verde-palido);

    color: var(--verde-oscuro);

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 13px;

}


.historial h2 {

    font-size: 13px;

    color: var(--verde-oscuro);

}


.historial-descripcion {

    font-size: 8px;

    color: var(--texto2);

    margin-top: 2px;

}


.registros {

    background: var(--verde-palido);

    color: var(--verde-oscuro);

    padding: 6px 10px;

    border-radius: 20px;

    font-size: 8px;

    font-weight: 700;

}


/* =========================================================
   TABLA
========================================================= */

.contenedor-tabla {

    background: rgba(255,250,248,0.96);

    border: 1px solid var(--borde);

    border-radius: 25px;

    padding: 25px;

    box-shadow:
        0 10px 30px rgba(143,83,98,0.15);

    overflow-x: auto;

}


.titulo-tabla {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 20px;

}


.titulo-tabla h2 {

    color: var(--vino-oscuro);

    font-size: 24px;

}


.titulo-tabla span {

    color: var(--gris);

    font-size: 14px;

}


/* =========================================================
   TABLA
========================================================= */

table {

    width: 100%;

    min-width: 720px;

    border-collapse: collapse;

    overflow: hidden;


#tabla-ingresos th {

    text-align: left;

    padding: 10px 11px;

    color: #91a2a3;

    font-size: 7px;

    text-transform: uppercase;

    letter-spacing: .8px;

    border-bottom: 1px solid #eaf3f2;

}


thead {

    padding: 12px 11px;

    border-bottom: 1px solid #f0f6f5;

    font-size: 9px;

    color: #52696a;

}


#tabla-ingresos tbody tr {

    transition: .2s ease;

}


#tabla-ingresos tbody tr:hover {

    background: #f5fbfa;

}


#tabla-ingresos td:first-child {

    color: var(--verde-oscuro);

    font-weight: 700;

}


/* =========================================================
   ESTADO
========================================================= */

.estado {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 5px 8px;

    border-radius: 20px;

    background: #e5f7ef;

    color: #3c9c75;

    font-size: 7px;

    font-weight: 700;

}


.estado::before {

    content: "";

    width: 5px;

    height: 5px;

    background: #4eb889;

    border-radius: 50%;

}


/* =========================================================
   PRECIO
========================================================= */

.precio {

    color: var(--verde-oscuro) !important;

    font-weight: 700;

}


/* =========================================================
   BOTÓN MOSTRAR
========================================================= */

a.ver1 {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 10px;

    border-radius: 8px;

    background: var(--verde-palido);

    color: var(--verde-oscuro);

    text-decoration: none;

    font-size: 7px;

    font-weight: 700;

    transition: .2s ease;

}


a.ver1::after {

    content: "↗";

    font-size: 9px;

}


a.ver1:hover {

    background: var(--verde-oscuro);

    color: white;

}


th {

    padding: 15px 12px;

    font-size: 14px;

    padding: 40px !important;

    color: #91a2a3 !important;


td {

    padding: 14px 12px;

    text-align: center;

    border-bottom: 1px solid var(--borde);

    font-size: 14px;

}


tbody tr {

    transition: 0.2s;

}


tbody tr:hover {

    background: var(--rosa-palido);

}


/* =========================================================
   ESTADOS
========================================================= */

.estado {

    animation: aparecer .5s ease both;

}


.estado-completado {

    background: #ead8de;

    color: var(--vino-oscuro);

}


.estado-pendiente {

    background: #f5e8c8;

    color: #856d35;

        transform: translateY(12px);


.estado-cancelado {

    background: #f1d4d4;

    color: #9b4b4b;

}


/* =========================================================
   SEPARADORES DE HOY
========================================================= */

.separador-ventas td {

    padding: 0;

    border: none;

}


.separador-contenido {

    margin: 20px 0;

    padding: 15px;

    background:

        linear-gradient(
            135deg,
            var(--rosa-palido),
            #fff
        );

    border:

        1px solid var(--rosa-claro);

    border-radius: 15px;

    color: var(--vino-oscuro);

    font-weight: bold;

    font-size: 16px;

    letter-spacing: 1px;

}


.separador-otras td {

    padding-top: 25px;

}


.separador-otras .separador-contenido {

    background: #f8f1f2;

    color: var(--gris);

    border-color: var(--borde);

}


/* =========================================================
   VENTA DE HOY
========================================================= */

.venta-hoy {

    background: rgba(247,233,236,0.45);

}


/* =========================================================
   SIN VENTAS
========================================================= */

.sin-ventas {

    padding: 45px;

    text-align: center;

    color: var(--gris);

}


.sin-ventas .emoji {

    font-size: 45px;

    margin-bottom: 10px;

}


.sin-ventas h3 {

    color: var(--vino);

    margin-bottom: 5px;

}


/* =========================================================
   BOTÓN VOLVER
========================================================= */

.volver {

    display: inline-block;

    margin-top: 20px;

    padding: 12px 25px;

    background: var(--vino);

    color: white;

    text-decoration: none;

    border-radius: 20px;

    font-weight: bold;

    transition: 0.3s;

}


.volver:hover {

    background: var(--vino-oscuro);

    transform: translateY(-2px);

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 950px) {

    .resumen {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media(max-width: 650px) {

    .contenedor {

        padding: 13px;

    }

    .cabecera {

        align-items: flex-start;

    }

    .usuario-info {

        display: none;

    }

    .titulo {

        font-size: 19px;

    }

    .estadisticas {

        grid-template-columns: 1fr 1fr;

        gap: 9px;

    }

    .card {

        min-height: 120px;

        padding: 13px;

    }

    .card-valor {

        font-size: 18px;

    }

    .donut-contenedor {

        flex-direction: column;

        gap: 15px;

    }

    .donut {

        width: 135px;

        height: 135px;

    }

    .donut::before {

        width: 85px;

        height: 85px;

    }

    .leyenda {

        flex-direction: row;

        flex-wrap: wrap;

        justify-content: center;

    }

    .resumen {

        grid-template-columns: 1fr;

    }

}

    .contenedor-tabla {

@media(max-width: 400px) {

    .estadisticas {

        grid-template-columns: 1fr;

    }

    .titulo {

        font-size: 17px;

    }

    .usuario .avatar {

        width: 35px;

        height: 35px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =====================================================
         ENCABEZADO
    ====================================================== -->

    <div class="encabezado">

        <div class="izquierda-cabecera">

            <div class="menu-icono">
                ☰
            </div>

            <div>

                <div class="titulo">
                    DIVINE SALES
                </div>

                <div class="subtitulo">
                    Panel de control de ventas
                </div>

            </div>

        </div>


        <div class="usuario">

            <div class="usuario-info">

                <div class="usuario-nombre">
                    <?php
                    echo isset($_SESSION['nombre'])
                        ? htmlspecialchars($_SESSION['nombre'])
                        : 'Usuario';
                    ?>
                </div>

                <div class="usuario-rol">
                    <?php echo htmlspecialchars($rol); ?>
                </div>

            </div>

            <div class="avatar">

                <?php

                if (isset($_SESSION['nombre']) && $_SESSION['nombre'] != '') {

                    echo strtoupper(
                        substr(
                            $_SESSION['nombre'],
                            0,
                            1
                        )
                    );

                } else {

                    echo "U";

                }

                ?>

            </div>

        </div>

    </header>


    <!-- =====================================================
         TITULO
    ====================================================== -->

    <div class="dashboard-titulo">

        <h1>
            Resultados de ventas
        </h1>

        <p>
            Resumen general de las ventas realizadas
        </p>

    </div>


    <!-- =====================================================
         ESTADÍSTICAS
    ====================================================== -->

    <section class="estadisticas">


        <!-- HOY -->

        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        $
                    </div>

                    <div class="card-menu">
                        •••
                    </div>

                </div>

                <div class="card-titulo">
                    Ventas de hoy
                </div>

            </div>


            <div>

                <div class="card-valor">

                    $<?php echo number_format($totalventadia, 2); ?>

                </div>

                <div class="card-cambio">
                    Total del día
                </div>

            </div>

        </article>


        <!-- 7 DÍAS -->

        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        ▦
                    </div>

                    <div class="card-menu">
                        •••
                    </div>

                </div>

                <div class="card-titulo">
                    Últimos 7 días
                </div>

            </div>


            <div>

                <div class="card-valor">

                    $<?php echo number_format($totalventasemana, 2); ?>

                </div>

                <div class="card-cambio">
                    Ventas acumuladas
                </div>

            </div>

        </article>


        <!-- 30 DÍAS -->

        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        %
                    </div>

                    <div class="card-menu">
                        •••
                    </div>

                </div>

                <div class="card-titulo">
                    Últimos 30 días
                </div>

            </div>


            <div>

                <div class="card-valor">

                    $<?php echo number_format($totalventames, 2); ?>

                </div>

                <div class="card-cambio">
                    Rendimiento mensual
                </div>

            </div>

        </article>


        <!-- AÑO -->

        <article class="card">

            <div>

                <div class="card-arriba">

                    <div class="card-icono">
                        ✦
                    </div>

                    <div class="card-menu">
                        •••
                    </div>

                </div>

                <div class="card-titulo">
                    Último año
                </div>

            </div>


            <div>

                <div class="card-valor">

                    $<?php echo number_format($totalventaanio, 2); ?>

                </div>

                <div class="card-cambio">
                    Total acumulado
                </div>

            </div>

        </article>


    </section>


    <!-- =====================================================
         GRÁFICAS
    ====================================================== -->

    <section class="graficas">


        <!-- =================================================
             GRÁFICO TORTA
        ================================================== -->

        <article class="panel">

            <div class="panel-cabecera">

                <div>

                    <div class="panel-titulo">
                        Distribución de ventas
                    </div>

                    <div class="panel-subtitulo">
                        Comparación por período
                    </div>

                </div>

                <select class="filtro">

                    <option>
                        Este mes
                    </option>

                </select>

            </div>


            <div class="donut-contenedor">


                <div class="donut">

                    <div class="donut-centro">

                        <small>
                            Total
                        </small>

                        <strong>
                            $<?php echo number_format($totalGrafico, 0); ?>
                        </strong>

                    </div>

                </div>


                <div class="leyenda">


                    <div class="leyenda-item">

                        <span class="punto verde"></span>

                        Hoy

                    </div>


                    <div class="leyenda-item">

                        <span class="punto amarillo"></span>

                        7 días

                    </div>


                    <div class="leyenda-item">

                        <span class="punto rosa"></span>

                        30 días

                    </div>


                    <div class="leyenda-item">

                        <span class="punto azul"></span>

                        Año

                    </div>


                </div>


            </div>

        </article>


        <!-- =================================================
             GRÁFICO DE BARRAS
        ================================================== -->

        <article class="panel">

            <div class="panel-cabecera">

                <div>

                    <div class="panel-titulo">
                        Resumen de ventas
                    </div>

                    <div class="panel-subtitulo">
                        Rendimiento por período
                    </div>

                </div>

                <select class="filtro">

                    <option>
                        Ventas
                    </option>

                </select>

            </div>


            <div class="grafico-barras">


                <div class="columna">

                    <div class="valor-barra">

                        $<?php
                        echo number_format(
                            $valorDia,
                            0
                        );
                        ?>

                    </div>

                    <div class="barrita"></div>

                    <div class="nombre-barra">
                        Hoy
                    </div>

                </div>


                <div class="columna">

                    <div class="valor-barra">

                        $<?php
                        echo number_format(
                            $valorSemana,
                            0
                        );
                        ?>

                    </div>

                    <div class="barrita"></div>

                    <div class="nombre-barra">
                        7 días
                    </div>

                </div>


                <div class="columna">

                    <div class="valor-barra">

                        $<?php
                        echo number_format(
                            $valorMes,
                            0
                        );
                        ?>

                    </div>

                    <div class="barrita"></div>

                    <div class="nombre-barra">
                        30 días
                    </div>

                </div>


                <div class="columna">

                    <div class="valor-barra">

                        $<?php
                        echo number_format(
                            $valorAnio,
                            0
                        );
                        ?>

                    </div>

                    <div class="barrita"></div>

                    <div class="nombre-barra">
                        Año
                    </div>

                </div>


            </div>

        </article>


    </section>


    <!-- =====================================================
         RESUMEN
    ====================================================== -->

    <div class="resumen">


        <div class="tarjeta">

            <div class="icono">
                🌸
            </div>

            <h3>Ventas de hoy</h3>

            <div class="monto">
                Bs <?= number_format($totalHoy, 2) ?>
            </div>

        </div>


        <div class="tarjeta">

            <div class="icono">
                📅
            </div>

            <h3>Últimos 7 días</h3>

            <div class="monto">
                Bs <?= number_format($totalSemana, 2) ?>
            </div>

        </div>


        <div class="tarjeta">

            <div class="icono">
                💕
            </div>

            <h3>Últimos 30 días</h3>

            <div class="monto">
                Bs <?= number_format($totalMes, 2) ?>
            </div>

        </div>


        <div class="tarjeta">

            <div class="icono">
                ✨
            </div>

            <h3>Total general</h3>

            <div class="monto">
                Bs <?= number_format($totalGeneral, 2) ?>
            </div>

        </div>


    </div>


    <!-- =====================================================
         HISTORIAL DE VENTAS
    ====================================================== -->

    <div class="contenedor-tabla">


        <div class="titulo-tabla">

            <h2>✨ Ventas registradas</h2>

            <div class="historial-titulo">

                <div class="historial-icono">
                    ♡
                </div>

                <div>

                    <h2>
                        Historial de ventas
                    </h2>

                    <div class="historial-descripcion">
                        Últimas ventas registradas
                    </div>

                </div>

            </div>


            <div class="registros">

                <?php echo $totalRegistros; ?> registros

            </div>


        </div>


        <?php if ($resultado && $resultado->num_rows > 0): ?>


        <table>


            <thead>

                <tr>

                    <th>ID Venta</th>

                    <th>Pedido</th>

                    <th>Fecha</th>

                    <th>Método</th>

                    <th>Estado</th>

                    <th>Total</th>

                </tr>

            </thead>


            <tbody>


            <?php

            $fechaHoy = date('Y-m-d');

            $mostroHoy = false;

            $mostroOtras = false;


                        echo "<td>";
                        echo htmlspecialchars(
                            $fila["PEDIDOS_ID"]
                        );
                        echo "</td>";


                /*
                   SI ES LA PRIMERA VENTA DE HOY,
                   MOSTRAR EL SEPARADOR
                */

                if ($esHoy && !$mostroHoy):

                        echo htmlspecialchars(
                            $fila["estado"]
                        );

            ?>

                <tr class="separador-ventas">

                    <td colspan="6">

                        <div class="separador-contenido">

                            ✨ VENTAS DE HOY ✨

                        </div>

                    </td>

                </tr>


            <?php

                        echo htmlspecialchars(
                            $fila["metodo"]
                        );

                        echo "</td>";


                /*
                   SI YA PASAMOS DE HOY
                   MOSTRAR SEPARADOR DE OTRAS VENTAS
                */

                if (!$esHoy && !$mostroOtras):

                    $mostroOtras = true;

            ?>

                <tr class="separador-otras">

                    <td colspan="6">

                        <div class="separador-contenido">

                            📋 OTRAS VENTAS

                        </div>

                    </td>

                </tr>


            <?php

                        echo htmlspecialchars(
                            $fila["fecha"]
                        );

            ?>


                        echo "<td>";

                        echo "<a
                                class='ver1'
                                href='readventas1.php?idpedidos=" .
                                urlencode($idPedido) .
                                "'
                              >
                                Mostrar
                              </a>";

                        echo "</td>";


                    <!-- ID VENTA -->

                    <td>

                        <strong>
                            #<?= htmlspecialchars($fila['id']) ?>
                        </strong>

                    </td>


                    <!-- PEDIDO -->

                    <td>

                        #<?= htmlspecialchars($fila['PEDIDOS_ID']) ?>

                    </td>


                    <!-- FECHA -->

                    <td>

                        <?= date(
                            'd/m/Y H:i',
                            strtotime($fila['fecha'])
                        ) ?>

                        <?php if ($esHoy): ?>

                            <br>

                            <small
                                style="
                                color:var(--vino);
                                font-weight:bold;
                                "
                            >
                                HOY 💗
                            </small>

                        <?php endif; ?>

                    </td>


                    <!-- MÉTODO -->

                    <td>

                        <?= htmlspecialchars(
                            $fila['metodo']
                        ) ?>

                    </td>


                    <!-- ESTADO -->

                    <td>


                        <?php

                        $estado = $fila['estado'];

                        if (
                            strtolower($estado)
                            == 'completado'
                        ) {

                            echo '<span class="estado estado-completado">
                                    ✓ Completado
                                  </span>';

                        } elseif (
                            strtolower($estado)
                            == 'pendiente'
                        ) {

                            echo '<span class="estado estado-pendiente">
                                    ⏳ Pendiente
                                  </span>';

                        } else {

                            echo '<span class="estado estado-cancelado">
                                    ' .
                                    htmlspecialchars($estado)
                                    .
                                  '</span>';

                        }

                        ?>


                    </td>


                    <!-- TOTAL -->

                    <td>

                        <strong
                            style="
                            color:var(--vino-oscuro);
                            "
                        >

                            Bs
                            <?= number_format(
                                $fila['costototal'],
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
                    🌸
                </div>

                <h3>
                    No hay ventas registradas
                </h3>

                <p>
                    Todavía no existen ventas asociadas
                    a pedidos completados.
                </p>

            </div>


        <?php endif; ?>


        <a
            href="../REPORTES/reportes.php"
            class="volver"
        >
            ← Volver a reportes
        </a>


    </div>


</div>


</body>

</html>

<?php

$conn->close();

?>