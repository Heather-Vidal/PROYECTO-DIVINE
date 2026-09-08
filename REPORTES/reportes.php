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

    --rosa: #b86f80;

    --rosa-claro: #d9a6b2;

    --rosa-palido: #f7e9ec;

    --crema: #fffaf8;

    --texto: #57494c;

    --gris: #817679;

    --borde: #e3c5cd;

    --vino: #8f5362;

    --vino-oscuro: #713d4d;

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

        linear-gradient(
            rgba(255,250,248,0.88),
            rgba(247,233,236,0.94)
        ),

        url("../imagenes/fondote.png");

    background-size: cover;

    background-position: center;

    background-attachment: fixed;

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

    background: rgba(255,250,248,0.94);

    border: 1px solid var(--borde);

    border-radius: 25px;

    padding: 30px;

    text-align: center;

    box-shadow:

        0 10px 30px rgba(143,83,98,0.18);

    margin-bottom: 25px;

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
   TARJETAS DE RESUMEN
========================================================= */

.resumen {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 18px;

    margin-bottom: 25px;

}


.tarjeta {

    background: rgba(255,250,248,0.94);

    border: 1px solid var(--borde);

    border-radius: 22px;

    padding: 23px;

    text-align: center;

    box-shadow:
        0 8px 20px rgba(143,83,98,0.12);

    transition: 0.3s;

}


.tarjeta:hover {

    transform: translateY(-5px);

    box-shadow:
        0 12px 25px rgba(143,83,98,0.20);

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

    border-collapse: collapse;

    overflow: hidden;

    border-radius: 15px;

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

    display: inline-block;

    padding: 6px 13px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: bold;

}


.estado-completado {

    background: #ead8de;

    color: var(--vino-oscuro);

}


.estado-pendiente {

    background: #f5e8c8;

    color: #856d35;

}


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

@media (max-width: 900px) {

    .resumen {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media (max-width: 600px) {

    .contenedor {

        width: 96%;

        margin: 20px auto;

    }


    .resumen {

        grid-template-columns: 1fr;

    }


    .encabezado h1 {

        font-size: 27px;

    }


    .contenedor-tabla {

        padding: 15px;

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

        <h1>💗 Historial de Ventas</h1>

        <p>
            Consulta y supervisa las ventas registradas en DIVINE
        </p>

    </div>


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
         TABLA DE VENTAS
    ====================================================== -->

    <div class="contenedor-tabla">


        <div class="titulo-tabla">

            <h2>✨ Ventas registradas</h2>

            <span>
                Solo pedidos completados
            </span>

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


            while ($fila = $resultado->fetch_assoc()):

                $fechaVenta = date(
                    'Y-m-d',
                    strtotime($fila['fecha'])
                );

                $esHoy = ($fechaVenta == $fechaHoy);


                /*
                   SI ES LA PRIMERA VENTA DE HOY,
                   MOSTRAR EL SEPARADOR
                */

                if ($esHoy && !$mostroHoy):

                    $mostroHoy = true;

            ?>

                <tr class="separador-ventas">

                    <td colspan="6">

                        <div class="separador-contenido">

                            ✨ VENTAS DE HOY ✨

                        </div>

                    </td>

                </tr>


            <?php

                endif;


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

                endif;

            ?>


                <tr class="<?= $esHoy ? 'venta-hoy' : '' ?>">


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