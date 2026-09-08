```php
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

    die(
        "Error de conexión: "
        . $conn->connect_error
    );

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

$nombre = isset($_SESSION['nombre'])
    ? $_SESSION['nombre']
    : '';


/* =========================================================
   PROTEGER NOMBRE DEL VENDEDOR
========================================================= */

$nombreSeguro = $conn->real_escape_string($nombre);


/* =========================================================
   CONSULTAR TODAS LAS VENTAS COMPLETADAS
=========================================================

   MUY IMPORTANTE:

   LA FECHA SE TOMA DE:

       VENTAS.fecha

   NO DE:

       PEDIDOS.fecha

   Y solamente aparecen ventas donde:

       VENTAS.estado = Completado

   Y además:

       PEDIDOS.estado = Completado
========================================================= */


if ($rol == "administrador") {

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

        WHERE
            LOWER(TRIM(v.estado)) = 'completado'

            AND

            LOWER(TRIM(p.estado)) = 'completado'

        ORDER BY

            DATE(v.fecha) = CURDATE() DESC,

            v.fecha DESC,

            v.id DESC
    ";

} elseif ($rol == "vendedor") {

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

        WHERE
            LOWER(TRIM(v.estado)) = 'completado'

            AND

            LOWER(TRIM(p.estado)) = 'completado'

            AND

            p.nombrevendedor = '$nombreSeguro'

        ORDER BY

            DATE(v.fecha) = CURDATE() DESC,

            v.fecha DESC,

            v.id DESC
    ";

} else {

    header("Location: ../SESIONES/loginform.php");
    exit();

}


/* =========================================================
   EJECUTAR CONSULTA DE VENTAS
========================================================= */

$resultado = $conn->query($sql);

if (!$resultado) {

    die(
        "Error al consultar las ventas: "
        . $conn->error
    );

}


/* =========================================================
   VENTAS DE HOY
=========================================================

   AQUÍ TAMBIÉN SE USA:

       v.fecha

   NO p.fecha
========================================================= */

$sqlHoy = "
    SELECT

        COUNT(v.id) AS cantidad,

        COALESCE(
            SUM(v.costototal),
            0
        ) AS total

    FROM VENTAS v

    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID

    WHERE

        LOWER(TRIM(v.estado)) = 'completado'

        AND

        LOWER(TRIM(p.estado)) = 'completado'

        AND

        DATE(v.fecha) = CURDATE()
";


/* =========================================================
   SI ES VENDEDOR
========================================================= */

if ($rol == "vendedor") {

    $sqlHoy .= "

        AND p.nombrevendedor = '$nombreSeguro'

    ";

}


/* =========================================================
   EJECUTAR
========================================================= */

$resultadoHoy = $conn->query($sqlHoy);

if (!$resultadoHoy) {

    die(
        "Error al calcular las ventas de hoy: "
        . $conn->error
    );

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
=========================================================

   CUENTA TODAS LAS VENTAS COMPLETADAS.

   NO IMPORTA SI SON DE HOY, AYER,
   LA SEMANA PASADA, ETC.

   TAMBIÉN SE COMPRUEBA QUE PEDIDOS
   ESTÉ EN COMPLETADO.
========================================================= */

$sqlTotal = "
    SELECT

        COUNT(v.id) AS cantidad,

        COALESCE(
            SUM(v.costototal),
            0
        ) AS total

    FROM VENTAS v

    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID

    WHERE

        LOWER(TRIM(v.estado)) = 'completado'

        AND

        LOWER(TRIM(p.estado)) = 'completado'
";


if ($rol == "vendedor") {

    $sqlTotal .= "

        AND p.nombrevendedor = '$nombreSeguro'

    ";

}


$resultadoTotal = $conn->query($sqlTotal);

if (!$resultadoTotal) {

    die(
        "Error al calcular el total general: "
        . $conn->error
    );

}

$filaTotal = $resultadoTotal->fetch_assoc();


$cantidadTotal = isset($filaTotal['cantidad'])
    ? (int)$filaTotal['cantidad']
    : 0;


$totalGeneral = isset($filaTotal['total'])
    ? (float)$filaTotal['total']
    : 0;


/* =========================================================
   TOTAL ÚLTIMOS 7 DÍAS
=========================================================

   TAMBIÉN SE USA v.fecha
========================================================= */

$sqlSemana = "
    SELECT

        COALESCE(
            SUM(v.costototal),
            0
        ) AS total

    FROM VENTAS v

    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID

    WHERE

        LOWER(TRIM(v.estado)) = 'completado'

        AND

        LOWER(TRIM(p.estado)) = 'completado'

        AND

        DATE(v.fecha)
        >= DATE_SUB(
            CURDATE(),
            INTERVAL 6 DAY
        )

        AND

        DATE(v.fecha)
        <= CURDATE()
";


if ($rol == "vendedor") {

    $sqlSemana .= "

        AND p.nombrevendedor = '$nombreSeguro'

    ";

}


$resultadoSemana = $conn->query($sqlSemana);

if (!$resultadoSemana) {

    die(
        "Error al calcular las ventas de los últimos 7 días: "
        . $conn->error
    );

}

$filaSemana = $resultadoSemana->fetch_assoc();


$totalSemana = isset($filaSemana['total'])
    ? (float)$filaSemana['total']
    : 0;


/* =========================================================
   TOTAL ÚLTIMOS 30 DÍAS
========================================================= */

$sqlMes = "
    SELECT

        COALESCE(
            SUM(v.costototal),
            0
        ) AS total

    FROM VENTAS v

    INNER JOIN PEDIDOS p
        ON p.ID = v.PEDIDOS_ID

    WHERE

        LOWER(TRIM(v.estado)) = 'completado'

        AND

        LOWER(TRIM(p.estado)) = 'completado'

        AND

        DATE(v.fecha)
        >= DATE_SUB(
            CURDATE(),
            INTERVAL 29 DAY
        )

        AND

        DATE(v.fecha)
        <= CURDATE()
";


if ($rol == "vendedor") {

    $sqlMes .= "

        AND p.nombrevendedor = '$nombreSeguro'

    ";

}


$resultadoMes = $conn->query($sqlMes);

if (!$resultadoMes) {

    die(
        "Error al calcular las ventas de los últimos 30 días: "
        . $conn->error
    );

}

$filaMes = $resultadoMes->fetch_assoc();


$totalMes = isset($filaMes['total'])
    ? (float)$filaMes['total']
    : 0;


/* =========================================================
   DATOS PARA GRÁFICO
========================================================= */

$valorDia = $totalHoy;

$valorSemana = $totalSemana;

$valorMes = $totalMes;

$valorAnio = $totalGeneral;


$totalGrafico =
    $valorDia
    + $valorSemana
    + $valorMes
    + $valorAnio;


if ($totalGrafico > 0) {

    $porDia =
        ($valorDia / $totalGrafico) * 100;

    $porSemana =
        ($valorSemana / $totalGrafico) * 100;

    $porMes =
        ($valorMes / $totalGrafico) * 100;

    $porAnio =
        ($valorAnio / $totalGrafico) * 100;

} else {

    $porDia = 25;
    $porSemana = 25;
    $porMes = 25;
    $porAnio = 25;

}


/* =========================================================
   BARRAS
========================================================= */

$maxBarra = max(
    $valorDia,
    $valorSemana,
    $valorMes,
    $valorAnio,
    1
);


$barraDia =
    ($valorDia / $maxBarra) * 100;


$barraSemana =
    ($valorSemana / $maxBarra) * 100;


$barraMes =
    ($valorMes / $maxBarra) * 100;


$barraAnio =
    ($valorAnio / $maxBarra) * 100;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Ventas - DIVINE</title>


<style>

/* =========================================================
   COLORES
========================================================= */

:root {

    --fondo: #f1fbfa;

    --blanco: #ffffff;

    --texto: #183b3d;

    --gris: #718486;

    --rosa: #eeb0c6;

    --rosa-claro: #f5dbe4;

    --rosa-palido: #faedf2;

    --vino: #b86f89;

    --vino-oscuro: #7f4058;

    --verde: #58c4b8;

    --verde-claro: #dff2ec;

    --borde: #d9efed;

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
            rgba(151,225,218,.25),
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

    background: white;

    border: 1px solid var(--borde);

    border-radius: 25px;

    padding: 30px;

    text-align: center;

    margin-bottom: 25px;

    box-shadow:
        0 10px 30px rgba(143,83,98,.15);

}


.encabezado h1 {

    color: var(--vino-oscuro);

    font-size: 35px;

    margin-bottom: 8px;

}


.encabezado p {

    color: var(--gris);

    font-size: 15px;

}


/* =========================================================
   RESUMEN PRINCIPAL
========================================================= */

.resumen-principal {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

    margin-bottom: 25px;

}


/* =========================================================
   TARJETA GRANDE
========================================================= */

.tarjeta-grande {

    position: relative;

    overflow: hidden;

    border-radius: 28px;

    padding: 30px;

    text-align: center;

    min-height: 220px;

    display: flex;

    flex-direction: column;

    justify-content: center;

    align-items: center;

    box-shadow:
        0 12px 30px rgba(143,83,98,.15);

}


/* =========================================================
   HOY
========================================================= */

.tarjeta-hoy {

    background:

        linear-gradient(
            135deg,
            #fff1f6,
            #f8fffe
        );

    border: 2px solid var(--rosa);

}


.tarjeta-hoy::before {

    content: "✨";

    position: absolute;

    left: 25px;

    top: 20px;

    font-size: 35px;

}


.tarjeta-hoy::after {

    content: "💗";

    position: absolute;

    right: 25px;

    bottom: 20px;

    font-size: 35px;

}


/* =========================================================
   TOTAL GENERAL
========================================================= */

.tarjeta-general {

    background:

        linear-gradient(
            135deg,
            #f0fbfa,
            #fff7fa
        );

    border: 2px solid var(--verde);

}


.tarjeta-general::before {

    content: "📊";

    position: absolute;

    left: 25px;

    top: 20px;

    font-size: 32px;

}


.tarjeta-general::after {

    content: "✨";

    position: absolute;

    right: 25px;

    bottom: 20px;

    font-size: 32px;

}


/* =========================================================
   TEXTOS TARJETAS GRANDES
========================================================= */

.etiqueta-grande {

    color: var(--vino-oscuro);

    font-size: 18px;

    font-weight: bold;

    letter-spacing: 1px;

    margin-bottom: 10px;

}


.monto-grande {

    color: var(--vino);

    font-size: 42px;

    font-weight: bold;

    margin-bottom: 12px;

}


.cantidad-grande {

    background: var(--rosa-claro);

    color: var(--vino-oscuro);

    padding: 9px 20px;

    border-radius: 25px;

    font-size: 16px;

    font-weight: bold;

}


.tarjeta-general .cantidad-grande {

    background: var(--verde-claro);

    color: #287363;

}


.detalle-grande {

    margin-top: 10px;

    color: var(--gris);

    font-size: 13px;

}


/* =========================================================
   RESUMEN SECUNDARIO
========================================================= */

.resumen {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 16px;

    margin-bottom: 25px;

}


.tarjeta {

    background: white;

    border: 1px solid var(--borde);

    border-radius: 22px;

    padding: 22px;

    text-align: center;

    box-shadow:
        0 8px 20px rgba(143,83,98,.10);

    transition: .3s;

}


.tarjeta:hover {

    transform: translateY(-4px);

}


.tarjeta .icono {

    font-size: 28px;

    margin-bottom: 8px;

}


.tarjeta h3 {

    color: var(--vino);

    font-size: 15px;

    margin-bottom: 7px;

}


.tarjeta .monto {

    color: var(--vino-oscuro);

    font-size: 23px;

    font-weight: bold;

}


/* =========================================================
   CONTENEDOR TABLA
========================================================= */

.contenedor-tabla {

    background: white;

    border: 1px solid var(--borde);

    border-radius: 25px;

    padding: 25px;

    box-shadow:
        0 10px 30px rgba(143,83,98,.15);

    overflow-x: auto;

}


/* =========================================================
   TITULO TABLA
========================================================= */

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

    border-collapse: collapse;

    border-radius: 15px;

    overflow: hidden;

}


thead {

    background: var(--vino);

    color: white;

}


th {

    padding: 15px 12px;

    font-size: 14px;

    text-align: center;

}


td {

    padding: 14px 12px;

    text-align: center;

    border-bottom:
        1px solid var(--borde);

    font-size: 14px;

}


tbody tr {

    transition: .2s;

}


tbody tr:hover {

    background: var(--rosa-palido);

}


/* =========================================================
   SEPARADOR HOY
========================================================= */

.separador-hoy td {

    padding: 0;

    border: none;

}


.separador-hoy-contenido {

    margin: 25px 0 15px 0;

    padding: 18px;

    text-align: left;

    background:

        linear-gradient(
            90deg,
            var(--rosa-claro),
            #fff
        );

    border-left:
        7px solid var(--vino);

    border-radius: 15px;

    color: var(--vino-oscuro);

    font-size: 20px;

    font-weight: bold;

    letter-spacing: 1px;

}


/* =========================================================
   SEPARADOR ANTERIORES
========================================================= */

.separador-anteriores td {

    padding: 0;

    border: none;

}


.separador-anteriores-contenido {

    margin: 30px 0 15px 0;

    padding: 18px;

    text-align: left;

    background:

        linear-gradient(
            90deg,
            #edf8f6,
            #fff
        );

    border-left:
        7px solid var(--verde);

    border-radius: 15px;

    color: var(--texto);

    font-size: 18px;

    font-weight: bold;

    letter-spacing: .5px;

}


/* =========================================================
   FILAS DE HOY
========================================================= */

.venta-hoy {

    background:
        rgba(247,233,236,.55);

}


.venta-hoy td {

    border-bottom:
        1px solid var(--rosa-claro);

}


/* =========================================================
   INDICADOR HOY
========================================================= */

.indicador-hoy {

    display: inline-block;

    margin-top: 6px;

    padding: 5px 11px;

    border-radius: 15px;

    background: var(--rosa-claro);

    color: var(--vino-oscuro);

    font-size: 11px;

    font-weight: bold;

}


/* =========================================================
   ESTADO
========================================================= */

.estado {

    display: inline-block;

    padding: 7px 14px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: bold;

}


.estado-completado {

    background: var(--verde-claro);

    color: #287363;

}


/* =========================================================
   SIN VENTAS
========================================================= */

.sin-ventas {

    padding: 50px;

    text-align: center;

    color: var(--gris);

}


.sin-ventas .emoji {

    font-size: 50px;

    margin-bottom: 10px;

}


.sin-ventas h3 {

    color: var(--vino);

    margin-bottom: 7px;

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

    transition: .3s;

}


.volver:hover {

    background: var(--vino-oscuro);

    transform: translateY(-2px);

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 800px) {

    .resumen-principal {

        grid-template-columns: 1fr;

    }

    .resumen {

        grid-template-columns: 1fr;

    }

}


@media (max-width: 600px) {

    .contenedor {

        width: 96%;

        margin: 20px auto;

    }

    .encabezado h1 {

        font-size: 27px;

    }

    .monto-grande {

        font-size: 32px;

    }

    .tarjeta-hoy::before,
    .tarjeta-hoy::after,
    .tarjeta-general::before,
    .tarjeta-general::after {

        display: none;

    }

    .contenedor-tabla {

        padding: 15px;

    }

    .titulo-tabla {

        flex-direction: column;

        align-items: flex-start;

        gap: 8px;

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

        <h1>
            💗 Historial de Ventas
        </h1>

        <p>
            Consulta las ventas completadas registradas
            en DIVINE
        </p>

    </div>


    <!-- =====================================================
         RESUMEN PRINCIPAL
    ====================================================== -->

    <div class="resumen-principal">


        <!-- =================================================
             VENTAS DE HOY
        ================================================== -->

        <div class="tarjeta-grande tarjeta-hoy">

            <div class="etiqueta-grande">

                ✨ VENTAS DE HOY ✨

            </div>


            <!-- DINERO DE HOY -->

            <div class="monto-grande">

                Bs
                <?= number_format(
                    $totalHoy,
                    2
                ) ?>

            </div>


            <!-- CANTIDAD DE VENTAS DE HOY -->

            <div class="cantidad-grande">

                💗

                <?= $cantidadHoy ?>

                <?=
                    $cantidadHoy == 1
                    ? 'VENTA HOY'
                    : 'VENTAS HOY'
                ?>

            </div>


            <div class="detalle-grande">

                Ventas completadas registradas
                el día de hoy

            </div>

        </div>


        <!-- =================================================
             TOTAL GENERAL
        ================================================== -->

        <div class="tarjeta-grande tarjeta-general">

            <div class="etiqueta-grande">

                📊 TOTAL GENERAL

            </div>


            <!-- DINERO TOTAL -->

            <div class="monto-grande">

                Bs
                <?= number_format(
                    $totalGeneral,
                    2
                ) ?>

            </div>


            <!-- CANTIDAD TOTAL -->

            <div class="cantidad-grande">

                ✨

                <?= $cantidadTotal ?>

                <?=
                    $cantidadTotal == 1
                    ? 'VENTA COMPLETADA'
                    : 'VENTAS COMPLETADAS'
                ?>

            </div>


            <div class="detalle-grande">

                Total acumulado de todas las
                ventas completadas

            </div>

        </div>


    </div>


    <!-- =====================================================
         RESUMEN DE PERIODOS
    ====================================================== -->

    <div class="resumen">


        <!-- 7 DÍAS -->

        <div class="tarjeta">

            <div class="icono">
                📅
            </div>

            <h3>
                Últimos 7 días
            </h3>

            <div class="monto">

                Bs
                <?= number_format(
                    $totalSemana,
                    2
                ) ?>

            </div>

        </div>


        <!-- 30 DÍAS -->

        <div class="tarjeta">

            <div class="icono">
                💕
            </div>

            <h3>
                Últimos 30 días
            </h3>

            <div class="monto">

                Bs
                <?= number_format(
                    $totalMes,
                    2
                ) ?>

            </div>

        </div>


    </div>


    <!-- =====================================================
         TABLA
    ====================================================== -->

    <div class="contenedor-tabla">


        <div class="titulo-tabla">

            <h2>
                ✨ Ventas completadas
            </h2>

            <span>
                Solo aparecen ventas con ambos estados
                en "Completado"
            </span>

        </div>


        <?php if (
            $resultado
            &&
            $resultado->num_rows > 0
        ): ?>


        <table>


            <thead>

                <tr>

                    <th>
                        ID Venta
                    </th>

                    <th>
                        Pedido
                    </th>

                    <th>
                        Fecha de venta
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

            /* =================================================
               FECHA DE HOY

               SE COMPARA CON v.fecha
            ================================================= */

            $fechaHoy = date('Y-m-d');


            /* =================================================
               CONTROL DE SEPARADORES
            ================================================= */

            $mostroHoy = false;

            $mostroAnteriores = false;


            /* =================================================
               RECORRER RESULTADOS
            ================================================= */

            while (
                $fila =
                    $resultado->fetch_assoc()
            ):


                /* =============================================
                   FECHA DE LA VENTA

                   IMPORTANTE:
                   ESTA FECHA VIENE DE VENTAS.fecha
                ============================================= */

                $fechaVenta = date(
                    'Y-m-d',
                    strtotime(
                        $fila['fecha']
                    )
                );


                /* =============================================
                   COMPROBAR SI LA VENTA ES DE HOY
                ============================================= */

                $esHoy =
                    ($fechaVenta == $fechaHoy);


                /* =============================================
                   MOSTRAR SEPARADOR HOY
                ============================================= */

                if (
                    $esHoy
                    &&
                    !$mostroHoy
                ):

                    $mostroHoy = true;

            ?>

                <tr class="separador-hoy">

                    <td colspan="6">

                        <div
                            class="separador-hoy-contenido"
                        >

                            💗 ✨ HOY ✨ 💗

                        </div>

                    </td>

                </tr>


            <?php

                endif;


                /* =============================================
                   MOSTRAR SEPARADOR ANTERIORES
                ============================================= */

                if (
                    !$esHoy
                    &&
                    !$mostroAnteriores
                ):

                    $mostroAnteriores = true;

            ?>

                <tr class="separador-anteriores">

                    <td colspan="6">

                        <div
                            class="separador-anteriores-contenido"
                        >

                            📋 VENTAS COMPLETADAS ANTERIORES

                        </div>

                    </td>

                </tr>


            <?php

                endif;

            ?>


                <!-- =========================================
                     VENTA
                ========================================== -->

                <tr
                    class="<?= $esHoy
                        ? 'venta-hoy'
                        : '' ?>"
                >


                    <!-- ID -->

                    <td>

                        <strong>

                            #

                            <?= htmlspecialchars(
                                $fila['id']
                            ) ?>

                        </strong>

                    </td>


                    <!-- PEDIDO -->

                    <td>

                        #

                        <?= htmlspecialchars(
                            $fila['PEDIDOS_ID']
                        ) ?>

                    </td>


                    <!-- FECHA DE VENTAS -->

                    <td>

                        <?= date(
                            'd/m/Y H:i',
                            strtotime(
                                $fila['fecha']
                            )
                        ) ?>


                        <?php if ($esHoy): ?>

                            <br>

                            <span
                                class="indicador-hoy"
                            >

                                HOY 💗

                            </span>

                        <?php endif; ?>

                    </td>


                    <!-- MÉTODO -->

                    <td>

                        <?= htmlspecialchars(
                            $fila['metodo'] ?? ''
                        ) ?>

                    </td>


                    <!-- ESTADO -->

                    <td>

                        <span
                            class="estado estado-completado"
                        >

                            ✓ Completado

                        </span>

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


            <!-- =================================================
                 SIN VENTAS
            ================================================== -->

            <div class="sin-ventas">

                <div class="emoji">
                    🌸
                </div>

                <h3>
                    No hay ventas completadas
                </h3>

                <p>
                    No existen ventas donde tanto
                    VENTAS como PEDIDOS tengan el estado
                    "Completado".
                </p>

            </div>


        <?php endif; ?>


        <!-- =================================================
             VOLVER
        ================================================== -->

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
```
 