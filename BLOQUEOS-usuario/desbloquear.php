<?php

/* =========================================================
   CONEXIÓN
========================================================= */

$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "DIVINE"
);

if (!$conexion) {
    die("Error de conexión");
}

mysqli_set_charset($conexion, "utf8");


/* =========================================================
   OBTENER CI
========================================================= */

$CI = $_GET['CI'] ?? '';


/* =========================================================
   ACTUALIZAR ESTADO
========================================================= */

if ($CI === '') {

    $exito = false;

    $mensaje = "No se recibió el CI del usuario.";

} else {

    $sql = "UPDATE CLIENTE
            SET estado = 'ACTIVO'
            WHERE CI = '$CI'";

    if (mysqli_query($conexion, $sql)) {

        $exito = true;

    } else {

        $exito = false;

        $mensaje = "Error al desbloquear el usuario.";

    }

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

    <title>
        Usuario desbloqueado | DIVINE
    </title>


    <!-- =====================================================
         FUENTES
    ====================================================== -->

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
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    >


    <style>


        /* =====================================================
           RESET
        ===================================================== */

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }


        /* =====================================================
           BODY
        ===================================================== */

        body {

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            font-family:
                'Montserrat',
                sans-serif;

            background:

                radial-gradient(
                    circle at 10% 20%,
                    rgba(
                        210,
                        163,
                        178,
                        .18
                    ),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 90% 80%,
                    rgba(
                        210,
                        163,
                        178,
                        .13
                    ),
                    transparent 30%
                ),

                #fdf9f9;

            overflow: hidden;

        }


        /* =====================================================
           DECORACIONES
        ===================================================== */

        .decoracion {

            position: fixed;

            inset: 0;

            pointer-events: none;

        }


        .flor {

            position: absolute;

            color: #d8b8c2;

            opacity: .45;

            animation:
                flotar
                7s
                ease-in-out
                infinite;

        }


        .flor:nth-child(1) {

            top: 12%;

            left: 12%;

            font-size: 30px;

        }


        .flor:nth-child(2) {

            bottom: 15%;

            left: 18%;

            font-size: 22px;

            animation-delay: 2s;

        }


        .flor:nth-child(3) {

            top: 16%;

            right: 14%;

            font-size: 24px;

            animation-delay: 1s;

        }


        .flor:nth-child(4) {

            bottom: 13%;

            right: 16%;

            font-size: 32px;

            animation-delay: 3s;

        }


        .estrella {

            position: absolute;

            color: #c7a48f;

            opacity: .45;

            animation:
                brillo
                3s
                ease-in-out
                infinite;

        }


        .estrella:nth-child(5) {

            top: 30%;

            left: 23%;

        }


        .estrella:nth-child(6) {

            bottom: 27%;

            right: 23%;

            animation-delay: 1.5s;

        }


        /* =====================================================
           ANIMACIÓN FLORES
        ===================================================== */

        @keyframes flotar {

            0%,
            100% {

                transform:
                    translateY(0);

            }

            50% {

                transform:
                    translateY(-15px);

            }

        }


        /* =====================================================
           ANIMACIÓN ESTRELLAS
        ===================================================== */

        @keyframes brillo {

            0%,
            100% {

                opacity: .25;

                transform:
                    scale(.9);

            }

            50% {

                opacity: .7;

                transform:
                    scale(1.15);

            }

        }


        /* =====================================================
           TARJETA
        ===================================================== */

        .alerta {

            position: relative;

            z-index: 2;

            width: 90%;

            max-width: 460px;

            padding:
                48px 38px;

            text-align: center;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .88
                );

            border:
                1px solid
                #eadadd;

            border-radius: 24px;

            box-shadow:
                0 20px 60px
                rgba(
                    125,
                    87,
                    98,
                    .12
                );

            animation:
                entrada
                .7s
                ease;

        }


        /* =====================================================
           ANIMACIÓN TARJETA
        ===================================================== */

        @keyframes entrada {

            from {

                opacity: 0;

                transform:
                    translateY(25px);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0);

            }

        }


        /* =====================================================
           CÍRCULO
        ===================================================== */

        .circulo {

            width: 92px;

            height: 92px;

            margin:
                0 auto 25px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background:
                #f7edef;

            border:
                1px solid
                #dfc3cb;

            box-shadow:
                0 8px 25px
                rgba(
                    173,
                    117,
                    133,
                    .12
                );

            animation:
                suave
                2.5s
                ease-in-out
                infinite;

        }


        /* =====================================================
           ANIMACIÓN CÍRCULO
        ===================================================== */

        @keyframes suave {

            0%,
            100% {

                transform:
                    translateY(0);

            }

            50% {

                transform:
                    translateY(-5px);

            }

        }


        /* =====================================================
           CHECK
        ===================================================== */

        .check {

            font-size: 42px;

            color:
                #a86f7f;

            font-weight: 300;

        }


        /* =====================================================
           TÍTULO
        ===================================================== */

        h2 {

            font-family:
                'DM Serif Display',
                serif;

            font-size: 32px;

            font-weight: 400;

            color:
                #8f5f6d;

            margin-bottom: 12px;

        }


        /* =====================================================
           SUBTÍTULO
        ===================================================== */

        .subtitulo {

            color:
                #9b858a;

            font-size: 13px;

            letter-spacing: .3px;

            margin-bottom: 18px;

        }


        /* =====================================================
           MENSAJE
        ===================================================== */

        .mensaje {

            color:
                #74686b;

            font-size: 14px;

            line-height: 1.8;

        }


        /* =====================================================
           CI
        ===================================================== */

        .ci {

            display: inline-block;

            margin:
                7px 0;

            color:
                #956372;

            font-weight: 600;

        }


        /* =====================================================
           ESTADO
        ===================================================== */

        .estado {

            color:
                #a56e7d;

            font-weight: 600;

        }


        /* =====================================================
           BOTÓN
        ===================================================== */

        .boton {

            display: inline-block;

            margin-top: 28px;

            padding:
                12px 30px;

            border-radius: 30px;

            background:
                #a87583;

            color:
                white;

            text-decoration: none;

            font-size: 13px;

            font-weight: 500;

            letter-spacing: .2px;

            box-shadow:
                0 7px 18px
                rgba(
                    168,
                    117,
                    131,
                    .20
                );

            transition:
                all .3s ease;

        }


        .boton:hover {

            background:
                #946472;

            transform:
                translateY(-2px);

            box-shadow:
                0 10px 22px
                rgba(
                    168,
                    117,
                    131,
                    .25
                );

        }


        /* =====================================================
           DETALLE
        ===================================================== */

        .detalle {

            margin-top: 25px;

            color:
                #b99ba2;

            font-family:
                Georgia,
                serif;

            font-size: 12px;

            letter-spacing: 1px;

        }


        /* =====================================================
           ERROR
        ===================================================== */

        .circulo-error {

            background:
                #faf0f2;

            border-color:
                #e1c1c9;

        }


        .check-error {

            color:
                #a87583;

        }


        .titulo-error {

            color:
                #956372;

        }


        /* =====================================================
           CELULAR
        ===================================================== */

        @media (max-width: 500px) {

            .alerta {

                width: 90%;

                padding:
                    38px 25px;

            }


            h2 {

                font-size:
                    28px;

            }


            .circulo {

                width:
                    82px;

                height:
                    82px;

            }


            .check {

                font-size:
                    36px;

            }


            .mensaje {

                font-size:
                    13px;

            }

        }


    </style>

</head>


<body>


    <!-- =====================================================
         DECORACIONES
    ====================================================== -->

    <div class="decoracion">

        <span class="flor">
            ♡
        </span>

        <span class="flor">
            ✿
        </span>

        <span class="flor">
            ♡
        </span>

        <span class="flor">
            ✿
        </span>


        <span class="estrella">
            ✦
        </span>

        <span class="estrella">
            ✧
        </span>

    </div>


    <?php if ($exito): ?>


        <!-- =================================================
             MENSAJE DE ÉXITO
        ================================================== -->

        <div class="alerta">


            <div class="circulo">

                <span class="check">
                    ✓
                </span>

            </div>


            <h2>
                Usuario desbloqueado
            </h2>


            <p class="subtitulo">

                El usuario ha sido desbloqueado correctamente

            </p>


            <p class="mensaje">

                El usuario con CI

                <br>

                <span class="ci">

                    <?php
                    echo htmlspecialchars($CI);
                    ?>

                </span>

                <br>

                ahora se encuentra en estado

                <span class="estado">
                    ACTIVO
                </span>.

            </p>


         
         <a 
    href="../CRUD-cliente/readunocliente.php?CI=<?php echo urlencode($CI); ?>" 
    class="boton"
>
    Volver atrás
</a>


            <div class="detalle">

                ✦ Usuario habilitado nuevamente ✦

            </div>


        </div>


    <?php else: ?>


        <!-- =================================================
             MENSAJE DE ERROR
        ================================================== -->

        <div class="alerta">


            <div
                class="
                    circulo
                    circulo-error
                "
            >

                <span
                    class="
                        check
                        check-error
                    "
                >

                    !

                </span>

            </div>


            <h2 class="titulo-error">

                Error al desbloquear

            </h2>


            <p class="subtitulo">

                No se pudo completar la actualización

            </p>


            <p class="mensaje">

                <?php
                echo htmlspecialchars(
                    $mensaje
                );
                ?>

            </p>


            <a
                href="vendedoresRead.php"
                class="boton"
            >
                Volver a vendedores
            </a>


            <div class="detalle">

                ✦ DIVINE ✦

            </div>


        </div>


    <?php endif; ?>


</body>

</html>


<?php

mysqli_close($conexion);

?>