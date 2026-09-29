<?php

session_start();

/* =========================================================
   VALIDAR SESIÓN
========================================================= */

if (!isset($_SESSION['nombre']) || empty($_SESSION['nombre'])) {

    header("Location: ../SESIONES/loginform.php");

    exit();

}


/* =========================================================
   DATOS DE SESIÓN
========================================================= */

$nombreUsuario = trim($_SESSION['nombre']);

$rol = strtolower(trim($_SESSION['rol'] ?? ''));


/* =========================================================
   VALIDAR ROL
========================================================= */

if ($rol !== 'administrador' && $rol !== 'vendedor') {

    header("Location: ../SESIONES/loginform.php");

    exit();

}


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
        "OCURRIÓ UN ERROR AL CONECTAR CON LA BASE DE DATOS: "
        . $conn->connect_error
    );

}

$conn->set_charset("utf8mb4");


/* =========================================================
   CONSULTA DE VENTAS
========================================================= */

/*
    ADMINISTRADOR:
    Puede ver TODAS las ventas.

    VENDEDOR:
    Solamente puede ver las ventas correspondientes
    a los pedidos donde nombrevendedor sea igual
    al nombre guardado en su sesión.
*/

if ($rol === 'administrador') {

    $sql = "

        SELECT

            v.id AS id_venta,

            v.estado AS estado_venta,

            v.metodo,

            v.costototal,

            v.PEDIDOS_ID,

            v.fecha,

            p.ID AS id_pedido,

            p.nombre AS cliente,

            p.fecha AS fecha_pedido,

            p.estado AS estado_pedido,

            p.nombrevendedor,

            p.telefono,

            p.direccion

        FROM VENTAS v

        INNER JOIN PEDIDOS p

            ON v.PEDIDOS_ID = p.ID

        ORDER BY v.id DESC

    ";

    $stmt = $conn->prepare($sql);

} else {

    /*
        VENDEDOR:
        La venta solamente aparece si el nombre del vendedor
        registrado en PEDIDOS coincide con el nombre de su sesión.
    */

    $sql = "

        SELECT

            v.id AS id_venta,

            v.estado AS estado_venta,

            v.metodo,

            v.costototal,

            v.PEDIDOS_ID,

            v.fecha,

            p.ID AS id_pedido,

            p.nombre AS cliente,

            p.fecha AS fecha_pedido,

            p.estado AS estado_pedido,

            p.nombrevendedor,

            p.telefono,

            p.direccion

        FROM VENTAS v

        INNER JOIN PEDIDOS p

            ON v.PEDIDOS_ID = p.ID

        WHERE p.nombrevendedor = ?

        ORDER BY v.id DESC

    ";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("s", $nombreUsuario);

    }

}


/* =========================================================
   COMPROBAR PREPARACIÓN
========================================================= */

if (!$stmt) {

    die(

        "ERROR EN LA CONSULTA: " .

        htmlspecialchars($conn->error)

    );

}


/* =========================================================
   EJECUTAR CONSULTA
========================================================= */

if (!$stmt->execute()) {

    die(

        "ERROR AL EJECUTAR LA CONSULTA: " .

        htmlspecialchars($stmt->error)

    );

}


$resultado = $stmt->get_result();


/* =========================================================
   CONTAR VENTAS
========================================================= */

$totalVentas = $resultado->num_rows;


/* =========================================================
   CERRAR STATEMENT
========================================================= */

$stmt->close();

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


    <!-- =====================================================
         FUENTES
    ====================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         SWEETALERT2
    ====================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: 'DM Sans', sans-serif;

            background:

                radial-gradient(

                    circle at top left,

                    rgba(205, 157, 174, 0.16),

                    transparent 35%

                ),

                linear-gradient(

                    135deg,

                    #f8f1eb,

                    #eee1d8

                );

            min-height: 100vh;

            color: #51454a;

        }


        /* =================================================
           CONTENEDOR PRINCIPAL
        ================================================= */

        .contenedor {

            width: 94%;

            max-width: 1450px;

            margin: 40px auto;

        }


        /* =================================================
           ENCABEZADO
        ================================================= */

        .encabezado {

            background:

                linear-gradient(

                    135deg,

                    #9d6073,

                    #b8798d

                );

            border-radius: 28px;

            padding: 30px 35px;

            color: white;

            box-shadow:

                0 18px 45px

                rgba(104, 69, 80, 0.18);

            position: relative;

            overflow: hidden;

            margin-bottom: 25px;

        }


        .encabezado::before {

            content: "";

            position: absolute;

            width: 230px;

            height: 230px;

            border-radius: 50%;

            background:

                rgba(255,255,255,0.08);

            right: -80px;

            top: -100px;

        }


        .encabezado::after {

            content: "";

            position: absolute;

            width: 140px;

            height: 140px;

            border-radius: 50%;

            background:

                rgba(255,255,255,0.06);

            right: 120px;

            bottom: -80px;

        }


        .encabezado-contenido {

            position: relative;

            z-index: 2;

        }


        .marca {

            font-family:

                'Playfair Display',

                serif;

            font-size: 18px;

            letter-spacing: 3px;

            text-transform: uppercase;

            opacity: 0.9;

            margin-bottom: 8px;

        }


        .titulo {

            font-family:

                'Playfair Display',

                serif;

            font-size: 38px;

            font-weight: 600;

            margin-bottom: 8px;

        }


        .subtitulo {

            font-size: 14px;

            opacity: 0.88;

        }


        /* =================================================
           INFORMACIÓN DEL USUARIO
        ================================================= */

        .usuario {

            margin-top: 22px;

            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 9px 15px;

            background:

                rgba(255,255,255,0.15);

            border:

                1px solid

                rgba(255,255,255,0.18);

            border-radius: 30px;

            font-size: 13px;

        }


        .usuario strong {

            font-weight: 700;

        }


        /* =================================================
           TARJETA PRINCIPAL
        ================================================= */

        .tarjeta {

            background:

                rgba(255,255,255,0.91);

            border-radius: 28px;

            padding: 28px;

            box-shadow:

                0 15px 45px

                rgba(95, 69, 78, 0.10);

            border:

                1px solid

                rgba(151, 111, 123, 0.10);

            backdrop-filter: blur(10px);

        }


        /* =================================================
           BARRA SUPERIOR
        ================================================= */

        .barra {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 25px;

            flex-wrap: wrap;

        }


        .barra h2 {

            font-family:

                'Playfair Display',

                serif;

            color: #704653;

            font-size: 25px;

        }


        .contador {

            background: #f5e7e4;

            color: #875565;

            padding: 10px 18px;

            border-radius: 30px;

            font-size: 14px;

            font-weight: 600;

        }


        /* =================================================
           TABLA
        ================================================= */

        .tabla-contenedor {

            width: 100%;

            overflow-x: auto;

            border-radius: 20px;

            border:

                1px solid

                #eadbd7;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 1250px;

            background: white;

        }


        thead {

            background:

                linear-gradient(

                    135deg,

                    #f5e8e5,

                    #f0dfdb

                );

        }


        th {

            padding: 17px 15px;

            text-align: left;

            color: #704653;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 0.7px;

            font-weight: 700;

            white-space: nowrap;

        }


        td {

            padding: 17px 15px;

            border-top:

                1px solid

                #f0e5e2;

            color: #62565b;

            font-size: 14px;

            vertical-align: middle;

        }


        tbody tr {

            transition: 0.2s ease;

        }


        tbody tr:hover {

            background: #fdf8f7;

        }


        .numero {

            font-weight: 700;

            color: #8f5365;

        }


        .cliente {

            font-weight: 600;

            color: #5b4a50;

        }


        .vendedor {

            color: #80606a;

            font-weight: 500;

        }


        .total {

            font-size: 16px;

            font-weight: 700;

            color: #814c5d;

            white-space: nowrap;

        }


        .metodo {

            display: inline-block;

            padding: 7px 12px;

            border-radius: 20px;

            background: #f7ece9;

            color: #7b5260;

            font-size: 12px;

            font-weight: 600;

        }


        /* =================================================
           ESTADOS
        ================================================= */

        .estado {

            display: inline-block;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 700;

        }


        .estado-aceptado {

            background: #f6eadf;

            color: #986b45;

        }


        .estado-proceso {

            background: #eee8f5;

            color: #725582;

        }


        .estado-completado {

            background: #e6f2e8;

            color: #50765a;

        }


        .estado-rechazado {

            background: #f8e5e5;

            color: #9a5555;

        }


        .estado-pendiente {

            background: #f4eee3;

            color: #8c744b;

        }


        .estado-normal {

            background: #f1ebec;

            color: #76666b;

        }


        /* =================================================
           BOTONES DE ACCIONES
        ================================================= */

        .acciones {

            display: flex;

            align-items: center;

            gap: 7px;

            white-space: nowrap;

        }


        .btn-accion {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

            padding: 8px 11px;

            border-radius: 12px;

            text-decoration: none;

            font-size: 12px;

            font-weight: 600;

            border: none;

            cursor: pointer;

            transition:

                transform 0.2s ease,

                box-shadow 0.2s ease,

                background 0.2s ease;

        }


        .btn-accion:hover {

            transform: translateY(-2px);

        }


        /* DETALLES */

        .btn-detalles {

            background: #f1e5ed;

            color: #81566c;

        }


        .btn-detalles:hover {

            background: #e7d6e0;

            box-shadow:

                0 5px 12px

                rgba(129, 86, 108, 0.15);

        }


        /* EDITAR */

        .btn-editar {

            background: #eee5f2;

            color: #765780;

        }


        .btn-editar:hover {

            background: #e1d5e8;

            box-shadow:

                0 5px 12px

                rgba(118, 87, 128, 0.15);

        }


        /* ELIMINAR */

        .btn-eliminar {

            background: #f6e3e3;

            color: #995d63;

        }


        .btn-eliminar:hover {

            background: #efd2d4;

            box-shadow:

                0 5px 12px

                rgba(153, 93, 99, 0.15);

        }


        .icono-btn {

            font-size: 14px;

            line-height: 1;

        }


        /* =================================================
           SIN RESULTADOS
        ================================================= */

        .sin-resultados {

            text-align: center;

            padding: 70px 20px;

        }


        .sin-icono {

            width: 75px;

            height: 75px;

            margin: 0 auto 18px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #f4e6e5;

            color: #9d6474;

            font-size: 32px;

        }


        .sin-resultados h3 {

            font-family:

                'Playfair Display',

                serif;

            color: #704653;

            font-size: 24px;

            margin-bottom: 8px;

        }


        .sin-resultados p {

            color: #897b80;

            font-size: 14px;

        }


        /* =================================================
           BOTÓN VOLVER
        ================================================= */

        .volver {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-top: 25px;

            text-decoration: none;

            background:

                linear-gradient(

                    135deg,

                    #9d6073,

                    #b7798c

                );

            color: white;

            padding: 12px 20px;

            border-radius: 30px;

            font-size: 13px;

            font-weight: 600;

            box-shadow:

                0 8px 20px

                rgba(143, 83, 101, 0.20);

            transition: 0.25s ease;

        }


        .volver:hover {

            transform:

                translateY(-2px);

            box-shadow:

                0 12px 25px

                rgba(143, 83, 101, 0.28);

        }


        /* =================================================
           RESPONSIVE
        ================================================= */

        @media (max-width: 700px) {

            .contenedor {

                width: 95%;

                margin: 20px auto;

            }

            .encabezado {

                padding: 25px 22px;

                border-radius: 22px;

            }

            .titulo {

                font-size: 30px;

            }

            .tarjeta {

                padding: 18px;

                border-radius: 22px;

            }

            .barra h2 {

                font-size: 22px;

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

        <div class="encabezado-contenido">

            <div class="marca">

                DIVINE

            </div>

            <div class="titulo">

                Registro de Ventas

            </div>

            <div class="subtitulo">

                <?php if ($rol === 'administrador'): ?>

                    Visualización general de todas las ventas registradas.

                <?php else: ?>

                    Visualización de las ventas correspondientes a tu cuenta.

                <?php endif; ?>

            </div>


            <div class="usuario">

                <span>♡</span>

                <span>

                    Sesión:

                    <strong>

                        <?php

                        echo htmlspecialchars($nombreUsuario);

                        ?>

                    </strong>

                </span>

                <span>•</span>

                <span>

                    <?php

                    echo htmlspecialchars(ucfirst($rol));

                    ?>

                </span>

            </div>

        </div>

    </div>


    <!-- =====================================================
         TARJETA PRINCIPAL
    ====================================================== -->

    <div class="tarjeta">


        <div class="barra">

            <h2>

                Ventas registradas

            </h2>

            <div class="contador">

                <?php

                echo $totalVentas;

                ?>

                <?php

                echo ($totalVentas == 1)

                    ? ' venta'

                    : ' ventas';

                ?>

            </div>

        </div>


        <?php if ($totalVentas > 0): ?>


            <div class="tabla-contenedor">

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

                                Cliente

                            </th>

                            <th>

                                Vendedor

                            </th>

                            <th>

                                Teléfono

                            </th>

                            <th>

                                Método

                            </th>

                            <th>

                                Total

                            </th>

                            <th>

                                Estado

                            </th>

                            <th>

                                Fecha

                            </th>

                            <th>

                                Acciones

                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php while ($venta = $resultado->fetch_assoc()): ?>


                        <?php

                        /* =================================================
                           ESTADO DE LA VENTA
                        ================================================= */

                        $estadoVenta =

                            trim(

                                $venta['estado_venta'] ?? ''

                            );

                        $estadoClase =

                            'estado-normal';

                        $estadoNormalizado =

                            strtolower(

                                $estadoVenta

                            );


                        if (

                            $estadoNormalizado === 'aceptado'

                        ) {

                            $estadoClase =

                                'estado-aceptado';

                        } elseif (

                            $estadoNormalizado === 'en proceso'

                            ||

                            $estadoNormalizado === 'enproceso'

                        ) {

                            $estadoClase =

                                'estado-proceso';

                        } elseif (

                            $estadoNormalizado === 'completado'

                        ) {

                            $estadoClase =

                                'estado-completado';

                        } elseif (

                            $estadoNormalizado === 'rechazado'

                        ) {

                            $estadoClase =

                                'estado-rechazado';

                        } elseif (

                            $estadoNormalizado === 'pendiente'

                        ) {

                            $estadoClase =

                                'estado-pendiente';

                        }

                        ?>


                        <tr>


                            <!-- =========================================
                                 ID VENTA
                            ========================================== -->

                            <td>

                                <span class="numero">

                                    #

                                    <?php

                                    echo (int)

                                        $venta['id_venta'];

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 ID PEDIDO
                            ========================================== -->

                            <td>

                                <span class="numero">

                                    #

                                    <?php

                                    echo (int)

                                        $venta['PEDIDOS_ID'];

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 CLIENTE
                            ========================================== -->

                            <td>

                                <span class="cliente">

                                    <?php

                                    echo htmlspecialchars(

                                        $venta['cliente']

                                        ?? 'Sin nombre'

                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 VENDEDOR
                            ========================================== -->

                            <td>

                                <span class="vendedor">

                                    <?php

                                    echo htmlspecialchars(

                                        $venta['nombrevendedor']

                                        ?? 'Sin vendedor'

                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 TELÉFONO
                            ========================================== -->

                            <td>

                                <?php

                                echo htmlspecialchars(

                                    $venta['telefono']

                                    ?? 'Sin teléfono'

                                );

                                ?>

                            </td>


                            <!-- =========================================
                                 MÉTODO
                            ========================================== -->

                            <td>

                                <span class="metodo">

                                    <?php

                                    echo htmlspecialchars(

                                        $venta['metodo']

                                        ?? 'Sin método'

                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 TOTAL
                            ========================================== -->

                            <td>

                                <span class="total">

                                    Bs.

                                    <?php

                                    echo number_format(

                                        (float)(

                                            $venta['costototal']

                                            ?? 0

                                        ),

                                        2,

                                        '.',

                                        ','

                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 ESTADO
                            ========================================== -->

                            <td>

                                <span

                                    class="estado <?php echo $estadoClase; ?>"

                                >

                                    <?php

                                    echo htmlspecialchars(

                                        $estadoVenta !== ''

                                            ? $estadoVenta

                                            : 'Sin estado'

                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =========================================
                                 FECHA
                            ========================================== -->

                            <td>

                                <?php

                                echo htmlspecialchars(

                                    $venta['fecha']

                                    ?? ''

                                );

                                ?>

                            </td>


                            <!-- =========================================
                                 ACCIONES
                            ========================================== -->

                            <td>

                                <div class="acciones">


                                    <!-- =================================
                                         DETALLES
                                         LO PUEDEN VER AMBOS ROLES
                                    ================================== -->

                                    <a

                                        href="readunoventa.php?id=<?php echo (int)$venta['id_venta']; ?>"

                                        class="btn-accion btn-detalles"

                                        title="Ver detalles de la venta"

                                    >

                                        <span class="icono-btn">

                                            ♡

                                        </span>

                                        Detalles

                                    </a>


                                    <!-- =================================
                                         SOLO ADMINISTRADOR
                                         EDITAR
                                    ================================== -->

                                    <?php if ($rol === 'administrador'): ?>


                                        <a

                                            href="updateformventa.php?id=<?php echo (int)$venta['id_venta']; ?>"

                                            class="btn-accion btn-editar"

                                            title="Editar venta"

                                        >

                                            <span class="icono-btn">

                                                ✎

                                            </span>

                                            Editar

                                        </a>


                                        <!-- =============================
                                             SOLO ADMINISTRADOR
                                             ELIMINAR
                                        ============================== -->

                                        <a

                                            href="deleteventa.php?id=<?php echo (int)$venta['id_venta']; ?>"

                                            class="btn-accion btn-eliminar"

                                            title="Eliminar venta"

                                            onclick="confirmarEliminacion(event, <?php echo (int)$venta['id_venta']; ?>)"

                                        >

                                            <span class="icono-btn">

                                                🗑

                                            </span>

                                            Eliminar

                                        </a>


                                    <?php endif; ?>


                                </div>

                            </td>


                        </tr>


                    <?php endwhile; ?>


                    </tbody>

                </table>

            </div>


        <?php else: ?>


            <div class="sin-resultados">

                <div class="sin-icono">

                    ♡

                </div>

                <h3>

                    No hay ventas registradas

                </h3>

                <p>

                    <?php if ($rol === 'administrador'): ?>

                        Actualmente no existen ventas registradas

                        en el sistema.

                    <?php else: ?>

                        No existen ventas registradas a tu nombre.

                    <?php endif; ?>

                </p>

            </div>


        <?php endif; ?>


        <!-- =================================================
             BOTÓN VOLVER
        ================================================== -->

        <?php if ($rol === 'administrador'): ?>


            <a

                href="../admin.php"

                class="volver"

            >

                ← Volver al administrador

            </a>


        <?php else: ?>


            <a

                href="../perfilvendedor.php"

                class="volver"

            >

                ← Volver al vendedor

            </a>


        <?php endif; ?>


    </div>


</div>


<!-- =====================================================
     SWEETALERT PARA ELIMINAR
====================================================== -->

<script>

function confirmarEliminacion(event, idVenta) {

    event.preventDefault();

    const enlace = event.currentTarget;

    Swal.fire({

        title: '¿Eliminar esta venta?',

        html:
            'La venta <strong>#' +
            idVenta +
            '</strong> será eliminada del registro.',

        icon: 'warning',

        iconColor: '#b76e83',

        showCancelButton: true,

        confirmButtonText: 'Sí, eliminar',

        cancelButtonText: 'Cancelar',

        reverseButtons: true,

        focusCancel: true,

        background: '#fff9f8',

        color: '#604b53',

        buttonsStyling: false,

        customClass: {

            popup: 'sweet-divine',

            title: 'sweet-titulo',

            htmlContainer: 'sweet-texto',

            confirmButton: 'sweet-confirmar',

            cancelButton: 'sweet-cancelar'

        }

    }).then((resultado) => {

        if (resultado.isConfirmed) {

            window.location.href = enlace.href;

        }

    });

}

</script>


<!-- =====================================================
     ESTILOS DEL SWEETALERT
====================================================== -->

<style>

    .sweet-divine {

        border-radius: 28px !important;

        padding: 30px !important;

        box-shadow:

            0 20px 60px

            rgba(126, 79, 96, 0.22) !important;

        border:

            1px solid

            rgba(183, 110, 131, 0.15) !important;

    }


    .sweet-titulo {

        font-family:

            'Playfair Display',

            serif !important;

        color: #704653 !important;

        font-size: 28px !important;

        font-weight: 600 !important;

    }


    .sweet-texto {

        font-family:

            'DM Sans',

            sans-serif !important;

        color: #806d74 !important;

        font-size: 14px !important;

        line-height: 1.6 !important;

    }


    .sweet-confirmar {

        border: none !important;

        outline: none !important;

        background:

            linear-gradient(

                135deg,

                #a9657b,

                #c18498

            ) !important;

        color: white !important;

        padding: 11px 22px !important;

        border-radius: 14px !important;

        font-family:

            'DM Sans',

            sans-serif !important;

        font-size: 13px !important;

        font-weight: 700 !important;

        cursor: pointer !important;

        margin: 0 5px !important;

        box-shadow:

            0 7px 18px

            rgba(169, 101, 123, 0.25) !important;

        transition: 0.2s ease !important;

    }


    .sweet-confirmar:hover {

        transform: translateY(-2px) !important;

        box-shadow:

            0 10px 22px

            rgba(169, 101, 123, 0.32) !important;

    }


    .sweet-cancelar {

        border: none !important;

        outline: none !important;

        background: #f2e5e5 !important;

        color: #8b626b !important;

        padding: 11px 22px !important;

        border-radius: 14px !important;

        font-family:

            'DM Sans',

            sans-serif !important;

        font-size: 13px !important;

        font-weight: 600 !important;

        cursor: pointer !important;

        margin: 0 5px !important;

        transition: 0.2s ease !important;

    }


    .sweet-cancelar:hover {

        background: #ead7d9 !important;

        transform: translateY(-2px) !important;

    }

</style>


</body>

</html>


<?php

$conn->close();

?>