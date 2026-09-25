<?php
$archivo = 'mensajes.txt';
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mensajes con cariño</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap');


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        /* =====================================
           CUERPO
        ===================================== */

        body {

            min-height: 100vh;

            font-family: 'Montserrat', sans-serif;

            color: #4b3440;

            background:

                linear-gradient(
                    rgba(55, 28, 40, .70),
                    rgba(76, 39, 56, .72)
                ),

                url("../imagenes/mezcla.jpg");

            background-size: cover;
            background-position: center;
            background-attachment: fixed;

            padding: 55px 20px 70px;

            position: relative;

            overflow-x: hidden;
        }


        /* =====================================
           DECORACIÓN DEL FONDO
        ===================================== */

        .flor {

            position: fixed;

            color: rgba(255, 226, 235, .30);

            font-family: Georgia, serif;

            pointer-events: none;

            z-index: 0;

            animation: flotar 6s ease-in-out infinite;
        }


        .flor-1 {

            top: 7%;
            left: 4%;

            font-size: 85px;

            transform: rotate(-20deg);
        }


        .flor-2 {

            right: 3%;
            bottom: 8%;

            font-size: 110px;

            animation-delay: 2s;

            transform: rotate(20deg);
        }


        .flor-3 {

            top: 43%;
            right: 7%;

            font-size: 35px;

            animation-delay: 1s;
        }


        .flor-4 {

            bottom: 35%;
            left: 6%;

            font-size: 30px;

            animation-delay: 3s;
        }


        @keyframes flotar {

            0%,100% {
                transform: translateY(0) rotate(-10deg);
            }

            50% {
                transform: translateY(-15px) rotate(8deg);
            }

        }


        /* =====================================
           CONTENEDOR
        ===================================== */

        .pagina {

            position: relative;

            z-index: 2;

            width: min(1050px, 100%);

            margin: auto;
        }


        /* =====================================
           CABECERA
        ===================================== */

        .cabecera {

            text-align: center;

            color: white;

            margin-bottom: 45px;
        }


        .mini-titulo {

            display: inline-flex;

            align-items: center;

            gap: 13px;

            color: #e8c1ce;

            font-size: 10px;

            font-weight: 600;

            letter-spacing: 4px;

            text-transform: uppercase;

            margin-bottom: 15px;
        }


        .mini-titulo::before,
        .mini-titulo::after {

            content: "";

            width: 38px;

            height: 1px;

            background: #d9a0b3;
        }


        .cabecera h1 {

            font-family: 'Cormorant Garamond', serif;

            font-size: clamp(55px, 8vw, 86px);

            line-height: .85;

            font-weight: 500;

            letter-spacing: -1px;

            text-shadow:
                0 8px 30px rgba(0,0,0,.25);

            margin-bottom: 20px;
        }


        .cabecera h1 span {

            color: #e7afc1;

            font-style: italic;
        }


        .cabecera p {

            max-width: 500px;

            margin: auto;

            color: #ead9df;

            font-size: 12px;

            line-height: 1.8;

            font-weight: 300;
        }


        /* =====================================
           BOTÓN
        ===================================== */

        .zona-boton {

            text-align: center;

            margin-bottom: 42px;
        }


        .boton-comentar {

            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 14px 27px;

            color: #68404f;

            text-decoration: none;

            background: #fff8fa;

            border: 1px solid rgba(255,255,255,.8);

            border-radius: 50px;

            font-size: 11px;

            font-weight: 600;

            letter-spacing: 1.2px;

            text-transform: uppercase;

            box-shadow:
                0 12px 30px rgba(31,10,22,.25);

            transition: .35s ease;
        }


        .boton-comentar .icono {

            width: 25px;
            height: 25px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #b96d87,
                    #8e4562
                );

            font-size: 14px;
        }


        .boton-comentar:hover {

            transform: translateY(-4px);

            box-shadow:
                0 17px 35px rgba(31,10,22,.32);

            background: white;
        }


        /* =====================================
           ZONA DE PUBLICACIONES
        ===================================== */

        .zona-publicaciones {

            position: relative;

            padding: 38px;

            background: rgba(255,248,250,.94);

            border-radius: 32px;

            box-shadow:
                0 30px 80px rgba(28,10,20,.35);

            backdrop-filter: blur(15px);
        }


        /* Línea decorativa */

        .titulo-publicaciones {

            display: flex;

            align-items: center;

            gap: 18px;

            margin-bottom: 30px;
        }


        .titulo-publicaciones::before {

            content: "";

            width: 45px;

            height: 1px;

            background: #c998a9;
        }


        .titulo-publicaciones h2 {

            font-family: 'Cormorant Garamond', serif;

            font-size: 30px;

            font-weight: 600;

            color: #61394a;
        }


        .titulo-publicaciones span {

            margin-left: auto;

            color: #ae8494;

            font-size: 10px;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        /* =====================================
           GRID DE COMENTARIOS
        ===================================== */

        .publicaciones {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 20px;
        }


        /* =====================================
           COMENTARIO
        ===================================== */

        .post {

            position: relative;

            padding: 27px 28px 25px;

            min-height: 155px;

            background: #fffdfd;

            border: 1px solid #eddde3;

            border-radius: 4px 22px 22px 22px;

            box-shadow:
                0 8px 22px rgba(99,52,72,.07);

            transition: .4s ease;

            overflow: hidden;
        }


        /* Pequeño doblez de papel */

        .post::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 28px;
            height: 28px;

            background:
                linear-gradient(
                    135deg,
                    #f0d8e0 50%,
                    transparent 50%
                );
        }


        /* Línea decorativa */

        .post::after {

            content: "♡";

            position: absolute;

            right: 20px;
            bottom: 13px;

            color: #e6c4cf;

            font-size: 22px;

            font-family: Georgia, serif;
        }


        .post:hover {

            transform:
                translateY(-7px)
                rotate(-.3deg);

            border-color: #d8b1bf;

            box-shadow:
                0 17px 35px rgba(99,52,72,.13);
        }


        /* =====================================
           CONTENIDO
        ===================================== */

        .post-texto {

            color: #624b56;

            font-size: 13px;

            line-height: 1.8;

            padding-right: 20px;

            white-space: normal;

            word-break: break-word;
        }


        /* =====================================
           AVISO SIN PUBLICACIONES
        ===================================== */

        .sin-publicaciones {

            grid-column: 1 / -1;

            text-align: center;

            padding: 70px 25px;

            border: 1px dashed #dcbcc9;

            border-radius: 20px;

            background:
                linear-gradient(
                    145deg,
                    #fffafb,
                    #fdf2f6
                );

            color: #9e7a89;

            font-size: 13px;
        }


        .sin-publicaciones::before {

            content: "♡";

            display: block;

            font-family: Georgia, serif;

            font-size: 55px;

            color: #d4a0b3;

            margin-bottom: 10px;
        }


        /* =====================================
           PARTE INFERIOR
        ===================================== */

        .pie {

            text-align: center;

            margin-top: 32px;

            color: #aa8795;

            font-family: 'Cormorant Garamond', serif;

            font-size: 17px;

            font-style: italic;
        }


        .pie span {

            color: #c0849b;
        }


        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 700px) {

            body {

                padding:
                    35px
                    12px
                    50px;
            }


            .cabecera {

                margin-bottom: 30px;
            }


            .cabecera h1 {

                font-size: 57px;
            }


            .zona-publicaciones {

                padding: 23px 17px;

                border-radius: 24px;
            }


            .publicaciones {

                grid-template-columns: 1fr;

                gap: 15px;
            }


            .titulo-publicaciones {

                margin-bottom: 22px;
            }


            .titulo-publicaciones span {

                display: none;
            }


            .post {

                min-height: 140px;

                padding: 24px 23px;
            }

        }


        @media (max-width: 400px) {

            .cabecera h1 {

                font-size: 49px;
            }


            .mini-titulo {

                letter-spacing: 2px;

                font-size: 9px;
            }

        }

    </style>

</head>


<body>


    <!-- FLORES DECORATIVAS -->

    <div class="flor flor-1">❀</div>
    <div class="flor flor-2">✿</div>
    <div class="flor flor-3">✦</div>
    <div class="flor flor-4">♡</div>


    <main class="pagina">


        <!-- =============================
             CABECERA
        ============================== -->

        <header class="cabecera">

            <div class="mini-titulo">
                Un espacio para compartir
            </div>


            <h1>
                Palabras <span>bonitas.</span>
            </h1>


            <p>
                Cada mensaje guarda una pequeña historia.
                Gracias por tomarte un momento para compartir
                tus palabras con nosotros.
            </p>

        </header>


        <!-- =============================
             BOTÓN
        ============================== -->

        <div class="zona-boton">

            <a
                class="boton-comentar"
                href="publicar.php"
            >

                <span class="icono">♡</span>

                Dejar un mensaje

            </a>

        </div>


        <!-- =============================
             PUBLICACIONES
        ============================== -->

        <section class="zona-publicaciones">


            <div class="titulo-publicaciones">

                <h2>
                    Mensajes
                </h2>

                <span>
                    Compartidos con cariño
                </span>

            </div>


            <div class="publicaciones">

                <?php

                if (file_exists($archivo)) {

                    $lineas = file(
                        $archivo,
                        FILE_IGNORE_NEW_LINES |
                        FILE_SKIP_EMPTY_LINES
                    );

                    $lineas = array_reverse($lineas);


                    if (count($lineas) > 0) {

                        foreach ($lineas as $linea) {

                            echo '<article class="post">';

                            echo '<div class="post-texto">';

                            echo htmlspecialchars(
                                $linea,
                                ENT_QUOTES,
                                'UTF-8'
                            );

                            echo '</div>';

                            echo '</article>';
                        }

                    } else {

                        echo '<div class="sin-publicaciones">';
                        echo 'Todavía no hay mensajes.';
                        echo '</div>';

                    }

                } else {

                    echo '<div class="sin-publicaciones">';
                    echo 'Todavía no hay mensajes.';
                    echo '</div>';

                }

                ?>

            </div>


            <div class="pie">
                Gracias por dejar <span>un poquito de ti</span> aquí ♡
            </div>


        </section>


    </main>


    <script>

        <?php

        if (
            isset($_GET['guardado']) &&
            $_GET['guardado'] == '1'
        ) {

        ?>

        Swal.fire({

            icon: 'success',

            title: '¡Mensaje publicado! ♡',

            text: 'Gracias por compartir tus palabras.',

            confirmButtonText: 'Qué bonito',

            confirmButtonColor: '#9d5874',

            background: '#fff9fb',

            color: '#563746',

            buttonsStyling: true,

            customClass: {

                popup: 'mensaje-bonito'

            }

        });

        <?php

        }

        ?>

    </script>


</body>

</html>
