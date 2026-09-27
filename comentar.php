
<?php

// ==========================================
// INICIAR SESIÓN
// ==========================================

session_start();


// ==========================================
// ARCHIVO DE COMENTARIOS
// ==========================================

$archivo = 'mensajes.txt';


// ==========================================
// GUARDAR COMENTARIO
// ==========================================
// Esta parte funciona aunque el administrador
// no tenga la sesión iniciada.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $autor = trim($_POST['autor'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');


    // ==========================================
    // VALIDAR CAMPOS
    // ==========================================

    if ($autor === '' || $contenido === '') {

        header("Location: contactanos.php?error=1");
        exit();

    }


    // ==========================================
    // FECHA
    // ==========================================

    $fecha = date("Y-m-d H:i:s");


    // ==========================================
    // CREAR ENTRADA
    // ==========================================

    $entrada = "$fecha | $autor: $contenido" . PHP_EOL;


    // ==========================================
    // ABRIR ARCHIVO
    // ==========================================

    $f = fopen($archivo, 'a');

    if ($f === false) {

        header("Location: contactanos.php?error=2");
        exit();

    }


    // ==========================================
    // ESCRIBIR
    // ==========================================

    if (fwrite($f, $entrada) === false) {

        fclose($f);

        header("Location: contactanos.php?error=2");
        exit();

    }


    // ==========================================
    // CERRAR
    // ==========================================

    fclose($f);


    // ==========================================
    // REDIRECCIÓN
    // ==========================================

    header("Location: contactanos.php?comentario=ok");
    exit();
}


// ==========================================
// VALIDAR ADMINISTRADOR
// ==========================================

if (
    !isset($_SESSION['rol']) ||
    $_SESSION['rol'] !== 'administrador'
) {

    echo "

    <!DOCTYPE html>

    <html lang='es'>

    <head>

        <meta charset='UTF-8'>

        <meta
            name='viewport'
            content='width=device-width, initial-scale=1.0'
        >

        <title>Acceso denegado | DIVINE</title>

        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    </head>

    <body>

        <script>

            Swal.fire({

                icon: 'warning',

                title: 'ACCESO DENEGADO',

                text: 'Solo el administrador puede ver los comentarios.',

                confirmButtonText: 'Volver',

                confirmButtonColor: '#8b4568',

                background: '#fff8fb',

                color: '#63334d',

                iconColor: '#b76b8c',

                customClass: {

                    popup: 'divine-alert'

                }

            }).then(() => {

                window.location.href = 'contactanos.php';

            });

        </script>

    </body>

    </html>

    ";

    exit();
}


// ==========================================
// LEER COMENTARIOS
// ==========================================

$mensajes = [];

if (file_exists($archivo)) {

    $mensajes = file(
        $archivo,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Opiniones | DIVINE</title>


<!-- ==========================================
     FUENTES
=========================================== -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet"
>


<!-- ==========================================
     ICONOS
=========================================== -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>


<!-- ==========================================
     SWEETALERT2
=========================================== -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>

/* ==========================================
   RESET
========================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* ==========================================
   VARIABLES
========================================== */

:root {

    --rosa-principal: #a85c7d;

    --rosa-oscuro: #743c59;

    --rosa-claro: #f7dce7;

    --rosa-suave: #fff4f8;

    --blanco: #ffffff;

    --texto: #5d4b54;

    --gris: #8d7d84;

    --sombra:
        0 20px 60px rgba(122, 65, 91, 0.12);

    --sombra-hover:
        0 25px 70px rgba(122, 65, 91, 0.20);
}


/* ==========================================
   BODY
========================================== */

body {

    font-family: 'Montserrat', sans-serif;

    min-height: 100vh;

    color: var(--texto);

    background:

        radial-gradient(
            circle at 10% 10%,
            rgba(247, 205, 221, 0.55),
            transparent 30%
        ),

        radial-gradient(
            circle at 90% 20%,
            rgba(232, 187, 207, 0.45),
            transparent 28%
        ),

        radial-gradient(
            circle at 50% 100%,
            rgba(250, 222, 234, 0.7),
            transparent 35%
        ),

        linear-gradient(
            135deg,
            #fff9fb 0%,
            #f9edf3 50%,
            #fff7fa 100%
        );

    background-attachment: fixed;

    padding: 55px 20px;

    overflow-x: hidden;
}


/* ==========================================
   DECORACIÓN DE FONDO
========================================== */

body::before {

    content: "";

    position: fixed;

    width: 280px;

    height: 280px;

    border-radius: 50%;

    background: rgba(255,255,255,0.45);

    top: -100px;

    left: -90px;

    filter: blur(5px);

    z-index: -1;
}


body::after {

    content: "";

    position: fixed;

    width: 330px;

    height: 330px;

    border-radius: 50%;

    background: rgba(255,255,255,0.4);

    bottom: -130px;

    right: -100px;

    filter: blur(5px);

    z-index: -1;
}


/* ==========================================
   CONTENEDOR
========================================== */

.contenedor {

    width: 100%;

    max-width: 1050px;

    margin: auto;
}


/* ==========================================
   ENCABEZADO
========================================== */

.encabezado {

    text-align: center;

    margin-bottom: 38px;

    animation: aparecer 0.8s ease;
}


.mini-titulo {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 8px 18px;

    border-radius: 50px;

    background: rgba(255,255,255,0.65);

    border: 1px solid rgba(168,92,125,0.15);

    color: var(--rosa-principal);

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 2px;

    text-transform: uppercase;

    box-shadow:
        0 8px 25px rgba(120,60,90,0.07);

    margin-bottom: 18px;
}


.mini-titulo i {

    font-size: 10px;
}


.encabezado h1 {

    font-family: 'Cormorant Garamond', serif;

    font-size: clamp(48px, 7vw, 76px);

    line-height: 0.95;

    font-weight: 600;

    color: var(--rosa-oscuro);

    margin-bottom: 15px;

    letter-spacing: -1px;
}


.encabezado h1 span {

    color: var(--rosa-principal);

    font-style: italic;
}


.encabezado p {

    max-width: 600px;

    margin: auto;

    color: var(--gris);

    font-size: 14px;

    line-height: 1.7;
}


/* ==========================================
   DECORACIÓN
========================================== */

.linea-decorativa {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    margin-top: 20px;
}


.linea-decorativa::before,
.linea-decorativa::after {

    content: "";

    width: 65px;

    height: 1px;

    background:
        linear-gradient(
            to right,
            transparent,
            #c98ba5
        );
}


.linea-decorativa::after {

    background:
        linear-gradient(
            to left,
            transparent,
            #c98ba5
        );
}


.linea-decorativa i {

    color: var(--rosa-principal);

    font-size: 13px;
}


/* ==========================================
   ESTADÍSTICA
========================================== */

.estadistica {

    width: fit-content;

    margin: 0 auto 35px;

    display: flex;

    align-items: center;

    gap: 13px;

    padding: 11px 20px;

    border-radius: 50px;

    background: rgba(255,255,255,0.72);

    border: 1px solid rgba(168,92,125,0.12);

    box-shadow:
        0 10px 35px rgba(100,50,75,0.08);

    backdrop-filter: blur(12px);

    font-size: 12px;

    color: var(--gris);
}


.estadistica i {

    width: 30px;

    height: 30px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: var(--rosa-claro);

    color: var(--rosa-principal);
}


.estadistica strong {

    color: var(--rosa-oscuro);

    font-weight: 700;
}


/* ==========================================
   COMENTARIOS
========================================== */

.comentarios {

    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 22px;
}


/* ==========================================
   TARJETA
========================================== */

.comentario {

    position: relative;

    background: rgba(255,255,255,0.82);

    backdrop-filter: blur(16px);

    border: 1px solid rgba(255,255,255,0.9);

    border-radius: 25px;

    padding: 28px;

    box-shadow: var(--sombra);

    overflow: hidden;

    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease;

    animation: subir 0.65s ease both;
}


.comentario:hover {

    transform: translateY(-7px);

    box-shadow: var(--sombra-hover);
}


.comentario::before {

    content: "";

    position: absolute;

    top: 0;

    left: 0;

    width: 100%;

    height: 4px;

    background:
        linear-gradient(
            90deg,
            #d998b2,
            #a85c7d,
            #d998b2
        );
}


.comentario::after {

    content: "♡";

    position: absolute;

    top: 16px;

    right: 20px;

    font-family: 'Cormorant Garamond', serif;

    font-size: 38px;

    color: rgba(168,92,125,0.10);
}


/* ==========================================
   CABECERA COMENTARIO
========================================== */

.cabecera-comentario {

    display: flex;

    align-items: center;

    gap: 14px;

    margin-bottom: 20px;
}


.avatar {

    width: 48px;

    height: 48px;

    min-width: 48px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        linear-gradient(
            135deg,
            #f4d1df,
            #e9afc7
        );

    color: var(--rosa-oscuro);

    font-family: 'Cormorant Garamond', serif;

    font-size: 24px;

    font-weight: 700;

    box-shadow:
        0 6px 18px rgba(168,92,125,0.16);
}


.informacion-autor {

    min-width: 0;
}


.autor {

    font-size: 15px;

    font-weight: 700;

    color: var(--rosa-oscuro);

    margin-bottom: 5px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    max-width: 230px;
}


.fecha {

    font-size: 10px;

    color: #a999a1;

    letter-spacing: 0.3px;
}





/* ==========================================
   TEXTO
========================================== */

.texto {

    position: relative;

    color: #655861;

    font-size: 13px;

    line-height: 1.8;

    word-wrap: break-word;
}


.texto::before {

    content: "“";

    font-family: 'Cormorant Garamond', serif;

    font-size: 45px;

    color: #e7bdce;

    line-height: 0;

    vertical-align: -15px;

    margin-right: 4px;
}


/* ==========================================
   SIN COMENTARIOS
========================================== */

.sin-comentarios {

    grid-column: 1 / -1;

    background: rgba(255,255,255,0.78);

    backdrop-filter: blur(15px);

    border: 1px solid rgba(255,255,255,0.9);

    border-radius: 28px;

    padding: 65px 30px;

    text-align: center;

    box-shadow: var(--sombra);
}


.icono-vacio {

    width: 75px;

    height: 75px;

    margin: 0 auto 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: var(--rosa-suave);

    color: var(--rosa-principal);

    font-size: 28px;
}


.sin-comentarios h3 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 29px;

    color: var(--rosa-oscuro);

    margin-bottom: 8px;
}


.sin-comentarios p {

    color: var(--gris);

    font-size: 13px;
}


/* ==========================================
   PIE
========================================== */

.pie {

    text-align: center;

    margin-top: 35px;

    color: #a7969e;

    font-size: 10px;

    letter-spacing: 1px;
}


.pie span {

    color: var(--rosa-principal);
}


/* =====================================================
   BOTÓN VOLVER DIVINE
===================================================== */

.divine-back {

    position: fixed;

    left: 28px;

    bottom: 28px;

    width: 58px;

    height: 58px;

    border: none;

    border-radius: 50%;

    background: linear-gradient(
        145deg,
        #a96f87,
        #925f76
    );

    color: #fff8fa;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    z-index: 99999;

    box-shadow:
        0 8px 20px rgba(115, 65, 84, 0.22),
        inset 0 1px 3px rgba(255,255,255,0.35);

    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease,
        background 0.35s ease;
}


/* =====================================================
   CORAZÓN
===================================================== */

.divine-back-heart {

    width: 27px;

    height: 27px;

    fill: none;

    stroke: #fff8fa;

    stroke-width: 1.8;

    stroke-linecap: round;

    stroke-linejoin: round;

    transition:
        transform 0.35s ease,
        fill 0.35s ease,
        stroke-width 0.35s ease;
}


/* =====================================================
   FLECHA
===================================================== */

.divine-back-arrow {

    position: absolute;

    top: 56px;

    left: 50%;

    transform: translateX(-50%);

    color: #925f76;

    font-family: Arial, sans-serif;

    font-size: 31px;

    font-weight: 700;

    line-height: 1;

    text-shadow:
        0 1px 1px rgba(146, 95, 118, 0.15);

    transition:
        transform 0.3s ease,
        color 0.3s ease;
}


/* =====================================================
   HOVER
===================================================== */

.divine-back:hover {

    transform:
        translateY(-5px)
        scale(1.07);

    background: linear-gradient(
        145deg,
        #b67d93,
        #9c667e
    );

    box-shadow:
        0 13px 28px rgba(115, 65, 84, 0.30),
        inset 0 1px 3px rgba(255,255,255,0.45);
}


.divine-back:hover .divine-back-heart {

    transform: scale(1.13);

    fill: rgba(255, 245, 248, 0.22);

    stroke-width: 2;
}


.divine-back:hover .divine-back-arrow {

    transform: translateX(-55%);

    color: #925f76;
}


/* =====================================================
   TEXTO VOLVER
===================================================== */

.divine-back-text {

    position: absolute;

    top: 88px;

    left: 50%;

    transform:
        translateX(-50%)
        translateY(-5px);

    color: #925f76;

    font-family: "Poppins", Arial, sans-serif;

    font-size: 12px;

    font-weight: 500;

    letter-spacing: 0.4px;

    white-space: nowrap;

    opacity: 0;

    visibility: hidden;

    transition:
        opacity 0.3s ease,
        transform 0.3s ease;
}


.divine-back:hover .divine-back-text {

    opacity: 1;

    visibility: visible;

    transform:
        translateX(-50%)
        translateY(0);
}


/* =====================================================
   CLICK
===================================================== */

.divine-back:active {

    transform: scale(0.93);
}


/* =====================================================
   ANIMACIONES
===================================================== */

@keyframes aparecer {

    from {

        opacity: 0;

        transform: translateY(-18px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


@keyframes subir {

    from {

        opacity: 0;

        transform: translateY(25px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


/* =====================================================
   RESPONSIVE TABLET
===================================================== */

@media (max-width: 800px) {

    .comentarios {

        grid-template-columns: 1fr;

    }

}


/* =====================================================
   RESPONSIVE CELULAR
===================================================== */

@media (max-width: 600px) {

    body {

        padding:
            35px
            15px
            85px;

    }


    .encabezado {

        margin-bottom: 30px;

    }


    .encabezado h1 {

        font-size: 50px;

    }


    .encabezado p {

        font-size: 12px;

        padding: 0 10px;

    }


    .comentario {

        padding: 23px;

        border-radius: 22px;

    }


    .autor {

        max-width: 180px;

    }


    .sin-comentarios {

        padding: 50px 20px;

    }


    .divine-back {

        width: 52px;

        height: 52px;

        left: 18px;

        bottom: 18px;

    }


    .divine-back-heart {

        width: 24px;

        height: 24px;

    }


    .divine-back-arrow {

        top: 51px;

        font-size: 27px;

        font-weight: 700;

    }


    .divine-back-text {

        top: 79px;

        font-size: 11px;

    }

}


/* =====================================================
   PANTALLAS MUY PEQUEÑAS
===================================================== */

@media (max-width: 380px) {

    .encabezado h1 {

        font-size: 43px;

    }


    .comentario {

        padding: 20px;

    }


    .avatar {

        width: 43px;

        height: 43px;

        min-width: 43px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- ==========================================
         ENCABEZADO
    =========================================== -->

    <header class="encabezado">

        <div class="mini-titulo">

            <i class="fa-solid fa-sparkles"></i>

            DIVINE BEAUTY

        </div>


        <h1>

            Opiniones de

            <span>nuestros clientes</span>

        </h1>


        <p>

            Cada opinión es una parte especial de la experiencia DIVINE.

        </p>


        <div class="linea-decorativa">

            <i class="fa-solid fa-heart"></i>

        </div>

    </header>



    <!-- ==========================================
         CONTADOR
    =========================================== -->

    <div class="estadistica">

        <i class="fa-regular fa-comments"></i>

        <span>

            <strong>
                <?= count($mensajes) ?>
            </strong>

            <?= count($mensajes) === 1
                ? 'opinión recibida'
                : 'opiniones recibidas'
            ?>

        </span>

    </div>



    <!-- ==========================================
         COMENTARIOS
    =========================================== -->

    <div class="comentarios">


        <?php if (empty($mensajes)): ?>


            <!-- ======================================
                 SIN COMENTARIOS
            ======================================= -->

            <div class="sin-comentarios">

                <div class="icono-vacio">

                    <i class="fa-regular fa-heart"></i>

                </div>


                <h3>

                    Aún no tenemos opiniones

                </h3>


                <p>

                    Cuando nuestros clientes compartan sus experiencias,
                    aparecerán aquí.

                </p>

            </div>


        <?php else: ?>


            <!-- ======================================
                 LISTA DE COMENTARIOS
            ======================================= -->

            <?php foreach ($mensajes as $mensaje): ?>


                <?php

                // ==================================
                // SEPARAR FECHA Y RESTO
                // ==================================

                $partes = explode(
                    ' | ',
                    $mensaje,
                    2
                );


                $fechaMensaje =
                    $partes[0] ?? '';


                $resto =
                    $partes[1] ?? '';


                // ==================================
                // SEPARAR NOMBRE Y COMENTARIO
                // ==================================

                $datos = explode(
                    ': ',
                    $resto,
                    2
                );


                $nombreMensaje =
                    $datos[0] ?? '';


                $comentarioMensaje =
                    $datos[1] ?? '';


                // ==================================
                // INICIAL DEL USUARIO
                // ==================================

                $inicial = mb_strtoupper(

                    mb_substr(
                        trim($nombreMensaje),
                        0,
                        1,
                        'UTF-8'
                    ),

                    'UTF-8'

                );

                ?>


                <article class="comentario">


                    <!-- ==================================
                         CABECERA
                    =================================== -->

                    <div class="cabecera-comentario">


                        <div class="avatar">

                            <?= htmlspecialchars(
                                $inicial,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </div>


                        <div class="informacion-autor">


                            <div class="autor">

                                <?= htmlspecialchars(
                                    $nombreMensaje,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </div>


                            <div class="fecha">

                                <i class="fa-regular fa-clock"></i>

                                <?= htmlspecialchars(
                                    $fechaMensaje,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </div>


                        </div>


                    </div>



                    <!-- ==================================
                         TEXTO
                    =================================== -->

                    <div class="texto">

                        <?= nl2br(

                            htmlspecialchars(
                                $comentarioMensaje,
                                ENT_QUOTES,
                                'UTF-8'
                            )

                        ) ?>

                    </div>


                </article>


            <?php endforeach; ?>


        <?php endif; ?>


    </div>



    <!-- ==========================================
         PIE
    =========================================== -->

    <div class="pie">

        <span>DIVINE</span>

        · Belleza que inspira ·

        <span>♡</span>

    </div>


</div>



<!-- =================================================
     BOTÓN VOLVER DIVINE
================================================= -->

<button
    type="button"
    class="divine-back"
    onclick="history.back()"
    aria-label="Volver"
    title="Volver"
>


    <!-- CORAZÓN -->

    <svg
        class="divine-back-heart"
        viewBox="0 0 24 24"
        aria-hidden="true"
    >

        <path
            d="M20.84 8.61
               C20.84 13.42 12 19 12 19
               S3.16 13.42 3.16 8.61
               C3.16 6.12 5.13 4.5 7.35 4.5
               C9.05 4.5 10.56 5.43 12 7.12
               C13.44 5.43 14.95 4.5 16.65 4.5
               C18.87 4.5 20.84 6.12 20.84 8.61Z"
        />

    </svg>


    <!-- FLECHA -->

    <span class="divine-back-arrow">

        ←

    </span>


    <!-- TEXTO -->

    <span class="divine-back-text">

        Volver

    </span>


</button>


</body>

</html>

