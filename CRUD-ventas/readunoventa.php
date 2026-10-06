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
    die("Error de conexión a la base de datos.");
}

$conn->set_charset("utf8mb4");


/* =========================================================
   SESIÓN
   ========================================================= */

$rolUsuario = $_SESSION['rol'] ?? '';


/* =========================================================
   RECIBIR ID
   ========================================================= */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("ID de venta no válido.");
}


/* =========================================================
   CONSULTAR VENTA
   ========================================================= */

$stmt = $conn->prepare(
    "SELECT * FROM VENTAS WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();


/* =========================================================
   COMPROBAR VENTA
   ========================================================= */

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>DIVINE | Detalle de venta</title>


<!-- =====================================================
     FUENTES
     ===================================================== -->

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
   VARIABLES
   ========================================================= */

:root {

    --vino: #74384d;
    --vino-oscuro: #592a3b;
    --vino-claro: #92536a;

    --rosa: #c9879e;
    --rosa-suave: #efd4de;
    --rosa-claro: #f7e8ed;
    --rosa-palido: #fdf7f9;

    --champagne: #d8c0a5;
    --champagne-claro: #f6eee7;

    --texto: #49363e;
    --texto-suave: #907b83;

    --blanco: #ffffff;

    --borde: #ead8df;

    --verde: #5e8a70;
    --verde-fondo: #edf6f0;

    --rojo: #a94e61;

    --sombra:
        0 25px 65px rgba(89,42,59,.14);

    --sombra-suave:
        0 10px 30px rgba(89,42,59,.08);
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

    font-family:
        "DM Sans",
        Arial,
        sans-serif;

    color: var(--texto);

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 35px 20px;

    background:

        radial-gradient(
            circle at 5% 5%,
            rgba(239,212,222,.90),
            transparent 28%
        ),

        radial-gradient(
            circle at 95% 5%,
            rgba(216,192,165,.28),
            transparent 25%
        ),

        radial-gradient(
            circle at 90% 90%,
            rgba(239,212,222,.65),
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #fffafb,
            #fdf3f7
        );

}


/* =========================================================
   DECORACIÓN DE FONDO
   ========================================================= */

body::before {

    content: "";

    position: fixed;

    width: 330px;
    height: 330px;

    border-radius: 50%;

    left: -180px;
    bottom: -140px;

    background:
        radial-gradient(
            circle,
            rgba(201,135,158,.18),
            transparent 70%
        );

    pointer-events: none;

}


body::after {

    content: "";

    position: fixed;

    width: 280px;
    height: 280px;

    border-radius: 50%;

    right: -150px;
    top: -120px;

    background:
        radial-gradient(
            circle,
            rgba(216,192,165,.20),
            transparent 70%
        );

    pointer-events: none;

}


/* =========================================================
   CONTENEDOR
   ========================================================= */

.contenedor {

    width: 100%;

    max-width: 760px;

    padding: 30px;

    position: relative;

    overflow: hidden;

    border-radius: 32px;

    border:
        1px solid
        rgba(234,216,223,.95);

    background:
        rgba(255,255,255,.90);

    box-shadow:
        var(--sombra);

    backdrop-filter:
        blur(18px);

    animation:
        aparecer .65s ease both;

}


/* =========================================================
   BARRA SUPERIOR
   ========================================================= */

.contenedor::before {

    content: "";

    position: absolute;

    top: 0;
    left: 0;
    right: 0;

    height: 5px;

    background:

        linear-gradient(
            90deg,
            var(--rosa),
            var(--vino),
            var(--champagne)
        );

}


/* =========================================================
   ENCABEZADO
   ========================================================= */

.encabezado {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 24px;

}


.marca {

    display: flex;

    align-items: center;

    gap: 12px;

}


.logo {

    width: 48px;
    height: 48px;

    border-radius: 15px;

    display: flex;

    align-items: center;
    justify-content: center;

    color: white;

    font-family:
        "Playfair Display",
        serif;

    font-size: 23px;

    background:

        linear-gradient(
            145deg,
            #dca9ba,
            #74384d
        );

    box-shadow:
        0 10px 22px
        rgba(116,56,77,.22);

}


.nombre-marca {

    color: var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size: 23px;

    font-weight: 700;

    letter-spacing: 1.5px;

}


.submarca {

    margin-top: 2px;

    color: var(--texto-suave);

    font-size: 8px;

    letter-spacing: 1px;

    text-transform: uppercase;

}


.etiqueta-venta {

    padding:
        8px 13px;

    border-radius: 30px;

    color: var(--vino-claro);

    background:
        var(--rosa-palido);

    border:
        1px solid
        var(--borde);

    font-size: 8px;

    font-weight: 700;

    letter-spacing: 1px;

    text-transform: uppercase;

}


/* =========================================================
   DECORACIÓN
   ========================================================= */

.imagen {

    height: 155px;

    margin-bottom: 25px;

    border-radius: 24px;

    display: flex;

    align-items: center;

    justify-content: center;

    position: relative;

    overflow: hidden;

    border:
        1px solid
        #ead2da;

    background:

        linear-gradient(
            135deg,
            #f4dce4,
            #ead0d9 50%,
            #f3e7de
        );

}


.imagen::before {

    content: "♡";

    position: absolute;

    font-family:
        "Playfair Display",
        serif;

    font-size: 125px;

    line-height: 1;

    color:
        rgba(255,255,255,.58);

}


.imagen::after {

    content: "DIVINE";

    position: absolute;

    bottom: 18px;

    color:
        rgba(116,56,77,.55);

    font-family:
        "Playfair Display",
        serif;

    font-size: 14px;

    font-weight: 600;

    letter-spacing: 8px;

}


/* =========================================================
   TÍTULO
   ========================================================= */

.titulo {

    color: var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size: 29px;

    font-weight: 600;

    text-align: center;

    letter-spacing: 1px;

}


.descripcion {

    margin-top: 7px;

    margin-bottom: 25px;

    color: var(--texto-suave);

    font-size: 10px;

    text-align: center;

}


/* =========================================================
   TARJETA DE INFORMACIÓN
   ========================================================= */

.item {

    padding: 8px;

    border-radius: 23px;

    border:
        1px solid
        var(--borde);

    background:

        linear-gradient(
            145deg,
            #ffffff,
            #fff9fb
        );

    box-shadow:
        var(--sombra-suave);

}


/* =========================================================
   DATO
   ========================================================= */

.dato {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding:
        16px 17px;

    border-bottom:
        1px solid
        #f2e5e9;

}


.dato:last-child {

    border-bottom: none;

}


.dato-izquierda {

    display: flex;

    align-items: center;

    gap: 12px;

}


.icono {

    width: 35px;
    height: 35px;

    flex-shrink: 0;

    border-radius: 11px;

    display: flex;

    align-items: center;
    justify-content: center;

    color: var(--vino-claro);

    background:
        var(--rosa-claro);

    font-size: 13px;

}


.etiqueta {

    color: var(--texto-suave);

    font-size: 9px;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: .7px;

}


.valor {

    color: var(--texto);

    font-size: 12px;

    font-weight: 600;

    text-align: right;

}


/* =========================================================
   ESTADO
   ========================================================= */

.estado {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding:
        7px 12px;

    border-radius: 30px;

    color: var(--verde);

    background:
        var(--verde-fondo);

    font-size: 9px;

    font-weight: 700;

}


.estado::before {

    content: "";

    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #76a584;

    box-shadow:
        0 0 0 3px
        rgba(118,165,132,.12);

}


/* =========================================================
   TOTAL
   ========================================================= */

.total-contenedor {

    margin-top: 15px;

    padding:
        18px 20px;

    border-radius: 19px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    background:

        linear-gradient(
            135deg,
            #f9edf1,
            #f5e6dc
        );

    border:
        1px solid
        #ead6dc;

}


.total-label {

    color: var(--vino-claro);

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 1px;

}


.total {

    color: var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size: 25px;

    font-weight: 700;

}


/* =========================================================
   BOTONES
   ========================================================= */

.botones {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 12px;

    margin-top: 23px;

}


.boton {

    min-height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    padding:
        12px 18px;

    border-radius: 16px;

    text-decoration: none;

    font-size: 10px;

    font-weight: 700;

    letter-spacing: .5px;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background .25s ease;

}


/* =========================================================
   EDITAR
   ========================================================= */

.boton-editar {

    color: white;

    background:

        linear-gradient(
            135deg,
            #9d5871,
            #71384d
        );

    border:
        1px solid
        #71384d;

    box-shadow:
        0 9px 20px
        rgba(113,56,77,.18);

}


.boton-editar:hover {

    transform:
        translateY(-3px);

    color: white;

    background:

        linear-gradient(
            135deg,
            #b76c86,
            #85455c
        );

    box-shadow:
        0 14px 28px
        rgba(113,56,77,.28);

}


.boton-editar .boton-icono {

    width: 27px;
    height: 27px;

    border-radius: 9px;

    display: flex;

    align-items: center;
    justify-content: center;

    background:
        rgba(255,255,255,.16);

    font-size: 14px;

}


/* =========================================================
   ELIMINAR
   ========================================================= */

.boton-eliminar {

    color: var(--rojo);

    background:

        linear-gradient(
            135deg,
            #fff7f9,
            #f7e1e7
        );

    border:
        1px solid
        #e5c0ca;

}


.boton-eliminar:hover {

    transform:
        translateY(-3px);

    color: white;

    background:

        linear-gradient(
            135deg,
            #ca7085,
            #a64f66
        );

    border-color:
        #a64f66;

    box-shadow:
        0 12px 25px
        rgba(166,79,102,.25);

}


.boton-eliminar .boton-icono {

    width: 27px;
    height: 27px;

    border-radius: 9px;

    display: flex;

    align-items: center;
    justify-content: center;

    background:
        rgba(166,79,102,.08);

    font-size: 14px;

}


/* =========================================================
   VOLVER
   ========================================================= */

.navegacion {

    margin-top: 13px;

}


.boton-volver {

    width: 100%;

    min-height: 47px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    border-radius: 15px;

    color: var(--vino-claro);

    background: white;

    border:
        1px solid
        var(--borde);

    text-decoration: none;

    font-size: 10px;

    font-weight: 700;

    transition:
        .25s ease;

}


.boton-volver:hover {

    color: white;

    background:
        var(--vino);

    border-color:
        var(--vino);

    transform:
        translateY(-2px);

    box-shadow:
        0 9px 20px
        rgba(116,56,77,.18);

}


/* =========================================================
   MODAL DE CONFIRMACIÓN
   ========================================================= */

.modal {

    position: fixed;

    inset: 0;

    z-index: 9999;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 20px;

    background:
        rgba(73,54,62,.38);

    backdrop-filter:
        blur(9px);

    -webkit-backdrop-filter:
        blur(9px);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity .3s ease,
        visibility .3s ease;

}


/* Modal abierto */

.modal.activo {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}


/* =========================================================
   TARJETA DEL MODAL
   ========================================================= */

.modal-contenido {

    width: 100%;

    max-width: 430px;

    position: relative;

    padding: 34px 30px 28px;

    text-align: center;

    border-radius: 30px;

    border:
        1px solid
        rgba(255,255,255,.75);

    background:

        linear-gradient(
            145deg,
            #ffffff 0%,
            #fff8fa 60%,
            #fdf0f4 100%
        );

    box-shadow:
        0 30px 80px
        rgba(89,42,59,.25);

    transform:
        translateY(25px)
        scale(.94);

    transition:
        transform .35s cubic-bezier(.2,.8,.2,1);

    overflow: hidden;

}


.modal.activo .modal-contenido {

    transform:
        translateY(0)
        scale(1);

}


/* Línea superior */

.modal-contenido::before {

    content: "";

    position: absolute;

    top: 0;
    left: 0;
    right: 0;

    height: 5px;

    background:

        linear-gradient(
            90deg,
            var(--rosa),
            var(--vino),
            var(--champagne)
        );

}


/* Decoración */

.modal-contenido::after {

    content: "♡";

    position: absolute;

    right: -18px;

    top: -40px;

    font-family:
        "Playfair Display",
        serif;

    font-size: 150px;

    color:
        rgba(201,135,158,.08);

    pointer-events: none;

}


/* =========================================================
   ICONO DEL MODAL
   ========================================================= */

.modal-icono {

    width: 70px;
    height: 70px;

    margin:
        0 auto 18px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 22px;

    color: var(--rojo);

    background:

        linear-gradient(
            145deg,
            #fff1f5,
            #f8dfe7
        );

    border:
        1px solid
        #ebc8d2;

    box-shadow:
        0 12px 25px
        rgba(166,79,102,.12);

    font-size: 28px;

    animation:
        latido 2s ease-in-out infinite;

}


/* =========================================================
   TEXTO MODAL
   ========================================================= */

.modal-titulo {

    position: relative;

    z-index: 1;

    color: var(--vino);

    font-family:
        "Playfair Display",
        serif;

    font-size: 27px;

    font-weight: 600;

    margin-bottom: 9px;

}


.modal-texto {

    position: relative;

    z-index: 1;

    max-width: 330px;

    margin:
        0 auto;

    color: var(--texto-suave);

    font-size: 11px;

    line-height: 1.7;

}


.modal-venta {

    display: inline-block;

    margin-top: 12px;

    padding:
        7px 12px;

    border-radius: 20px;

    color: var(--vino-claro);

    background:
        var(--rosa-claro);

    border:
        1px solid
        var(--borde);

    font-size: 10px;

    font-weight: 700;

}


/* =========================================================
   BOTONES DEL MODAL
   ========================================================= */

.modal-botones {

    position: relative;

    z-index: 2;

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 11px;

    margin-top: 25px;

}


.modal-boton {

    min-height: 48px;

    border-radius: 15px;

    padding:
        10px 16px;

    font-family:
        "DM Sans",
        Arial,
        sans-serif;

    font-size: 10px;

    font-weight: 700;

    cursor: pointer;

    transition:
        .25s ease;

}


/* Cancelar */

.modal-cancelar {

    color: var(--vino-claro);

    background: white;

    border:
        1px solid
        var(--borde);

}


.modal-cancelar:hover {

    color: white;

    background:
        var(--vino-claro);

    border-color:
        var(--vino-claro);

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 18px
        rgba(116,56,77,.16);

}


/* Confirmar */

.modal-confirmar {

    color: white;

    background:

        linear-gradient(
            135deg,
            #bd667e,
            #9f4c64
        );

    border:
        1px solid
        #9f4c64;

    box-shadow:
        0 8px 20px
        rgba(159,76,100,.18);

}


.modal-confirmar:hover {

    background:

        linear-gradient(
            135deg,
            #cf7890,
            #a84e68
        );

    transform:
        translateY(-2px);

    box-shadow:
        0 12px 25px
        rgba(159,76,100,.27);

}


/* =========================================================
   ANIMACIONES
   ========================================================= */

@keyframes aparecer {

    from {

        opacity: 0;

        transform:
            translateY(18px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


@keyframes latido {

    0%,
    100% {

        transform:
            scale(1);

    }

    50% {

        transform:
            scale(1.05);

    }

}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width:600px) {

    body {

        padding:
            18px 12px;

        align-items:
            flex-start;

    }


    .contenedor {

        padding: 20px;

        border-radius: 25px;

    }


    .etiqueta-venta {

        display: none;

    }


    .imagen {

        height: 125px;

    }


    .titulo {

        font-size: 24px;

    }


    .dato {

        align-items:
            flex-start;

        flex-direction:
            column;

        gap: 8px;

    }


    .valor {

        padding-left: 47px;

        text-align:
            left;

    }


    .total-contenedor {

        flex-direction:
            column;

        align-items:
            flex-start;

    }


    .botones {

        grid-template-columns:
            1fr;

    }


    .modal-contenido {

        padding:
            30px 22px 23px;

        border-radius: 26px;

    }


    .modal-titulo {

        font-size: 24px;

    }


    .modal-botones {

        grid-template-columns:
            1fr;

    }

}


@media(max-width:380px) {

    .contenedor {

        padding: 16px;

    }


    .nombre-marca {

        font-size: 20px;

    }


    .titulo {

        font-size: 22px;

    }


    .total {

        font-size: 22px;

    }

}

</style>

</head>


<body>


<!-- =====================================================
     CONTENEDOR PRINCIPAL
     ===================================================== -->

<div class="contenedor">


    <!-- =====================================================
         ENCABEZADO
         ===================================================== -->

    <div class="encabezado">

        <div class="marca">

            <div class="logo">
                D
            </div>

            <div>

                <div class="nombre-marca">
                    DIVINE
                </div>

                <div class="submarca">
                    Gestión de ventas
                </div>

            </div>

        </div>


        <div class="etiqueta-venta">

            Venta #<?= htmlspecialchars(
                $fila['id']
            ) ?>

        </div>

    </div>


    <!-- =====================================================
         DECORACIÓN
         ===================================================== -->

    <div class="imagen"></div>


    <!-- =====================================================
         TÍTULO
         ===================================================== -->

    <h1 class="titulo">
        Detalle de la venta
    </h1>


    <p class="descripcion">

        Información completa de la transacción registrada en DIVINE.

    </p>


    <!-- =====================================================
         INFORMACIÓN
         ===================================================== -->

    <div class="item">


        <!-- Número -->

        <div class="dato">

            <div class="dato-izquierda">

                <div class="icono">
                    #
                </div>

                <div class="etiqueta">
                    Número de venta
                </div>

            </div>

            <div class="valor">

                #<?= htmlspecialchars(
                    $fila['id']
                ) ?>

            </div>

        </div>


        <!-- Estado -->

        <div class="dato">

            <div class="dato-izquierda">

                <div class="icono">
                    ✓
                </div>

                <div class="etiqueta">
                    Estado
                </div>

            </div>

            <div class="valor">

                <span class="estado">

                    <?= htmlspecialchars(
                        $fila['estado']
                    ) ?>

                </span>

            </div>

        </div>


        <!-- Método -->

        <div class="dato">

            <div class="dato-izquierda">

                <div class="icono">
                    $
                </div>

                <div class="etiqueta">
                    Método de pago
                </div>

            </div>

            <div class="valor">

                <?= htmlspecialchars(
                    $fila['metodo']
                ) ?>

            </div>

        </div>


        <!-- Pedido -->

        <div class="dato">

            <div class="dato-izquierda">

                <div class="icono">
                    №
                </div>

                <div class="etiqueta">
                    Número del pedido
                </div>

            </div>

            <div class="valor">

                #<?= htmlspecialchars(
                    $fila['PEDIDOS_ID']
                ) ?>

            </div>

        </div>


    </div>


    <!-- =====================================================
         TOTAL
         ===================================================== -->

    <div class="total-contenedor">

        <div class="total-label">
            Total de la venta
        </div>

        <div class="total">

            Bs.
            <?= number_format(
                (float)$fila['costototal'],
                2
            ) ?>

        </div>

    </div>


    <!-- =====================================================
         BOTONES ADMINISTRADOR
         ===================================================== -->

    <?php if ($rolUsuario === "administrador"): ?>

        <div class="botones">


            <!-- EDITAR -->

            <a
                href="updateformventa.php?id=<?= (int)$fila['id'] ?>"
                class="boton boton-editar"
            >

                <span class="boton-icono">
                    ✎
                </span>

                <span>
                    Editar venta
                </span>

            </a>


            <!-- ELIMINAR -->

            <a
                href="#"
                class="boton boton-eliminar"
                onclick="abrirModalEliminar(event)"
            >

                <span class="boton-icono">
                    ✕
                </span>

                <span>
                    Eliminar venta
                </span>

            </a>


        </div>

    <?php endif; ?>


    <!-- =====================================================
         VOLVER
         ===================================================== -->

    <div class="navegacion">

        <a
            href="readtodoventa.php"
            class="boton-volver"
        >

            ←

            <span>
                Volver a las ventas
            </span>

        </a>

    </div>


</div>


<!-- =========================================================
     MODAL DE CONFIRMACIÓN
     ========================================================= -->

<div
    class="modal"
    id="modalEliminar"
    onclick="cerrarModalExterior(event)"
>


    <div
        class="modal-contenido"
        role="dialog"
        aria-modal="true"
        aria-labelledby="tituloModal"
    >


        <!-- ICONO -->

        <div class="modal-icono">
            ♡
        </div>


        <!-- TÍTULO -->

        <h2
            class="modal-titulo"
            id="tituloModal"
        >
            ¿Eliminar esta venta?
        </h2>


        <!-- TEXTO -->

        <p class="modal-texto">

            Esta acción eliminará la venta registrada.
            Una vez eliminada, no podrás recuperar esta información.

        </p>


        <!-- NÚMERO DE VENTA -->

        <div class="modal-venta">

            Venta #<?= htmlspecialchars(
                $fila['id']
            ) ?>

        </div>


        <!-- BOTONES -->

        <div class="modal-botones">


            <button
                type="button"
                class="modal-boton modal-cancelar"
                onclick="cerrarModal()"
            >

                Cancelar

            </button>


            <button
                type="button"
                class="modal-boton modal-confirmar"
                onclick="confirmarEliminacion()"
            >

                Sí, eliminar

            </button>


        </div>


    </div>

</div>


<!-- =========================================================
     JAVASCRIPT DEL MODAL
     ========================================================= -->

<script>

const modal =
    document.getElementById("modalEliminar");


function abrirModalEliminar(event) {

    event.preventDefault();

    modal.classList.add("activo");

    document.body.style.overflow = "hidden";

}


function cerrarModal() {

    modal.classList.remove("activo");

    document.body.style.overflow = "";

}


function cerrarModalExterior(event) {

    if (event.target === modal) {

        cerrarModal();

    }

}


function confirmarEliminacion() {

    window.location.href =
        "deleteventa.php?id=<?= (int)$fila['id'] ?>";

}


/* =========================================================
   CERRAR CON ESC
   ========================================================= */

document.addEventListener(
    "keydown",
    function(event) {

        if (
            event.key === "Escape" &&
            modal.classList.contains("activo")
        ) {

            cerrarModal();

        }

    }
);

</script>


</body>

</html>

<?php

} else {

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>DIVINE | Venta no encontrada</title>


<style>

body {

    margin: 0;

    min-height: 100vh;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #fdf5f8;

    font-family:
        "DM Sans",
        Arial,
        sans-serif;

    color: #74384d;

}


.error {

    width: 90%;

    max-width: 450px;

    padding: 40px;

    text-align: center;

    background: white;

    border-radius: 25px;

    box-shadow:
        0 20px 50px
        rgba(116,56,77,.12);

}


.error h2 {

    margin-bottom: 10px;

    font-family:
        "Playfair Display",
        serif;

}


.error p {

    color: #907b83;

}


.error a {

    display: inline-block;

    margin-top: 15px;

    padding: 12px 24px;

    border-radius: 25px;

    background: #74384d;

    color: white;

    text-decoration: none;

}

</style>

</head>


<body>

<div class="error">

    <h2>
        Venta no encontrada
    </h2>

    <p>
        La venta solicitada no existe.
    </p>

    <a href="readtodoventa.php">
        ← Volver a las ventas
    </a>

</div>

</body>

</html>

<?php

}


$stmt->close();

$conn->close();

?>
