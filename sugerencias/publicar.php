<?php
$archivo = 'mensajes.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $autor = trim($_POST['autor'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');

    if ($autor === '' || $contenido === '') {
        header("Location: publicarcomentario.php?error=1");
        exit;
    }

    $fecha = date("Y-m-d H:i:s");
    $entrada = "$fecha | $autor: $contenido" . PHP_EOL;

    $f = fopen($archivo, 'a');

    if ($f === false) {
        header("Location: publicarcomentario.php?error=1");
        exit;
    }

    if (fwrite($f, $entrada) === false) {
        fclose($f);
        header("Location: publicarcomentario.php?error=2");
        exit;
    }

    fclose($f);

    header("Location: comentarios.php?guardado=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Comparte tus palabras ♡</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>

        /* =========================================
           CONFIGURACIÓN GENERAL
        ========================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --rosa: #c9829d;
            --rosa-oscuro: #a9607d;
            --rosa-claro: #f5dce5;

            --crema: #fffaf7;
            --blanco: #ffffff;

            --texto: #57454e;
            --texto-suave: #947e88;

            --borde: rgba(255,255,255,.75);
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            min-height: 100vh;

            font-family: 'DM Sans', sans-serif;

            color: var(--texto);

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 35px 20px;

            overflow-x: hidden;

            background:

                radial-gradient(
                    circle at 12% 15%,
                    rgba(245, 196, 213, .80) 0,
                    rgba(245, 196, 213, .25) 18%,
                    transparent 38%
                ),

                radial-gradient(
                    circle at 90% 20%,
                    rgba(220, 209, 237, .80) 0,
                    rgba(220, 209, 237, .25) 20%,
                    transparent 40%
                ),

                radial-gradient(
                    circle at 50% 100%,
                    rgba(250, 219, 207, .75) 0,
                    transparent 38%
                ),

                linear-gradient(
                    135deg,
                    #fffaf8,
                    #fdf3f6 45%,
                    #f5f1fa
                );
        }


        /* =========================================
           DECORACIÓN DEL FONDO
        ========================================= */

        .luz {
            position: fixed;

            width: 450px;
            height: 450px;

            border-radius: 50%;

            filter: blur(80px);

            opacity: .25;

            pointer-events: none;
        }

        .luz-1 {
            background: #efb7ca;

            top: -220px;
            left: -180px;
        }

        .luz-2 {
            background: #cfc2e8;

            right: -220px;
            bottom: -220px;
        }


        /* =========================================
           PÉTALOS
        ========================================= */

        .petalos {
            position: fixed;

            inset: 0;

            pointer-events: none;

            overflow: hidden;

            z-index: 0;
        }

        .petalo {

            position: absolute;

            width: 14px;
            height: 20px;

            background: rgba(210, 135, 160, .25);

            border-radius: 80% 20% 80% 20%;

            transform: rotate(35deg);

            animation: caer linear infinite;

        }

        .petalo:nth-child(1) {
            left: 8%;
            animation-duration: 13s;
            animation-delay: -3s;
        }

        .petalo:nth-child(2) {
            left: 23%;
            animation-duration: 17s;
            animation-delay: -8s;
        }

        .petalo:nth-child(3) {
            left: 42%;
            animation-duration: 14s;
            animation-delay: -5s;
        }

        .petalo:nth-child(4) {
            left: 63%;
            animation-duration: 18s;
            animation-delay: -11s;
        }

        .petalo:nth-child(5) {
            left: 79%;
            animation-duration: 15s;
            animation-delay: -6s;
        }

        .petalo:nth-child(6) {
            left: 94%;
            animation-duration: 19s;
            animation-delay: -14s;
        }

        @keyframes caer {

            0% {
                top: -40px;
                opacity: 0;
                transform: translateX(0) rotate(0deg);
            }

            10% {
                opacity: .7;
            }

            50% {
                transform: translateX(70px) rotate(180deg);
            }

            90% {
                opacity: .4;
            }

            100% {
                top: 110vh;
                opacity: 0;
                transform: translateX(-80px) rotate(360deg);
            }

        }


        /* =========================================
           CONTENEDOR
        ========================================= */

        .contenedor {

            position: relative;

            z-index: 2;

            width: 100%;
            max-width: 1080px;

            min-height: 650px;

            display: grid;

            grid-template-columns: .85fr 1.15fr;

            overflow: hidden;

            border-radius: 38px;

            border: 1px solid rgba(255,255,255,.85);

            background: rgba(255,255,255,.42);

            box-shadow:

                0 40px 100px rgba(91, 61, 76, .14),

                0 15px 35px rgba(166, 116, 139, .08);

            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);

            animation: entrada .9s cubic-bezier(.2,.8,.2,1);

        }

        @keyframes entrada {

            from {
                opacity: 0;
                transform: translateY(35px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

        }


        /* =========================================
           PANEL IZQUIERDO
        ========================================= */

        .presentacion {

            position: relative;

            display: flex;

            flex-direction: column;

            justify-content: center;

            padding: 65px;

            overflow: hidden;

            background:

                linear-gradient(
                    145deg,
                    rgba(239, 193, 207, .92),
                    rgba(226, 207, 228, .88)
                );

        }

        .presentacion::before {

            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            border-radius: 50%;

            background: rgba(255,255,255,.24);

            top: -160px;
            right: -130px;

        }

        .presentacion::after {

            content: "♡";

            position: absolute;

            font-family: 'Cormorant Garamond', serif;

            font-size: 300px;

            line-height: 1;

            color: rgba(255,255,255,.17);

            bottom: -100px;
            left: -35px;

            transform: rotate(-12deg);

        }


        .mini-titulo {

            position: relative;
            z-index: 2;

            color: rgba(90,65,77,.70);

            text-transform: uppercase;

            letter-spacing: 4px;

            font-size: 11px;

            font-weight: 700;

            margin-bottom: 22px;

        }


        .titulo-lateral {

            position: relative;
            z-index: 2;

            font-family: 'Cormorant Garamond', serif;

            font-size: clamp(48px, 5vw, 72px);

            line-height: .92;

            font-weight: 600;

            color: #654e59;

            margin-bottom: 25px;

        }

        .titulo-lateral span {
            color: #a86680;
        }


        .texto-lateral {

            position: relative;
            z-index: 2;

            max-width: 360px;

            color: rgba(82,62,71,.72);

            font-size: 14px;

            line-height: 1.8;

            margin-bottom: 35px;

        }


        .frase {

            position: relative;
            z-index: 2;

            display: flex;

            align-items: center;

            gap: 13px;

            color: #765d68;

            font-family: 'Cormorant Garamond', serif;

            font-size: 20px;

            font-style: italic;

        }

        .frase::before {

            content: "";

            width: 35px;
            height: 1px;

            background: #a87589;

        }


        /* =========================================
           FORMULARIO
        ========================================= */

        .zona-formulario {

            background: rgba(255,250,248,.72);

            padding: 65px;

            display: flex;

            align-items: center;

        }

        .formulario {

            width: 100%;
            max-width: 500px;

            margin: auto;

        }


        .corazones {

            display: flex;

            align-items: center;

            gap: 8px;

            color: #cb91a7;

            font-size: 15px;

            margin-bottom: 17px;

        }

        .corazones::after {

            content: "";

            width: 55px;
            height: 1px;

            background: #e6cbd5;

        }


        h1 {

            font-family: 'Cormorant Garamond', serif;

            font-size: 52px;

            line-height: 1;

            font-weight: 600;

            color: #594650;

            margin-bottom: 13px;

        }


        .subtitulo {

            color: var(--texto-suave);

            font-size: 13px;

            line-height: 1.7;

            margin-bottom: 35px;

        }


        /* =========================================
           CAMPOS
        ========================================= */

        .campo {

            margin-bottom: 23px;

        }


        label {

            display: block;

            color: #725a66;

            font-size: 12px;

            font-weight: 700;

            letter-spacing: .7px;

            text-transform: uppercase;

            margin-bottom: 9px;

        }


        .input-wrap {

            position: relative;

        }


        .icono {

            position: absolute;

            left: 18px;

            top: 50%;

            transform: translateY(-50%);

            color: #c78ba2;

            font-size: 18px;

            transition: .3s;

        }


        input,
        textarea {

            width: 100%;

            border: 1px solid #eadde2;

            border-radius: 16px;

            outline: none;

            background: rgba(255,255,255,.76);

            color: #5c4b54;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            transition: all .3s ease;

            box-shadow: 0 4px 15px rgba(122,86,103,.025);

        }


        input {

            height: 56px;

            padding: 0 18px 0 50px;

        }


        textarea {

            min-height: 155px;

            padding: 16px 18px;

            resize: vertical;

            line-height: 1.65;

        }


        input::placeholder,
        textarea::placeholder {

            color: #b8a8af;

        }


        input:hover,
        textarea:hover {

            border-color: #dcb8c7;

            background: rgba(255,255,255,.95);

        }


        input:focus,
        textarea:focus {

            border-color: #cf91a8;

            background: #fff;

            box-shadow:

                0 0 0 4px rgba(207,145,168,.10),

                0 12px 25px rgba(139,91,113,.07);

        }


        input:focus + .icono {

            color: #b86f8c;

        }


        /* =========================================
           CONTADOR
        ========================================= */

        .inferior {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 8px;

            padding: 0 4px;

            color: #ad9ca4;

            font-size: 10px;

        }


        #contador {

            transition: .3s;

        }


        /* =========================================
           BOTÓN
        ========================================= */

        button {

            position: relative;

            overflow: hidden;

            width: 100%;

            height: 58px;

            margin-top: 5px;

            border: none;

            border-radius: 16px;

            cursor: pointer;

            color: white;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            font-weight: 700;

            letter-spacing: .3px;

            background:

                linear-gradient(
                    135deg,
                    #ce91a8,
                    #b97791
                );

            box-shadow:

                0 13px 25px rgba(176,111,138,.22),

                inset 0 1px 0 rgba(255,255,255,.25);

            transition: all .3s ease;

        }


        button::before {

            content: "";

            position: absolute;

            top: 0;
            left: -110%;

            width: 70%;
            height: 100%;

            background:

                linear-gradient(
                    100deg,
                    transparent,
                    rgba(255,255,255,.32),
                    transparent
                );

            transform: skewX(-20deg);

            transition: left .7s ease;

        }


        button:hover {

            transform: translateY(-3px);

            box-shadow:

                0 18px 35px rgba(176,111,138,.29),

                inset 0 1px 0 rgba(255,255,255,.3);

        }


        button:hover::before {

            left: 140%;

        }


        button:active {

            transform: translateY(-1px);

        }


        .boton-contenido {

            position: relative;
            z-index: 2;

            display: flex;

            justify-content: center;
            align-items: center;

            gap: 10px;

        }


        .boton-corazon {

            font-size: 17px;

            animation: latido 1.8s ease-in-out infinite;

        }


        @keyframes latido {

            0%,100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.18);
            }

        }


        /* =========================================
           PIE
        ========================================= */

        .pie {

            text-align: center;

            color: #aa979f;

            font-size: 11px;

            margin-top: 18px;

        }

        .pie span {

            color: #c77e99;

        }


        /* =========================================
           SWEET ALERT
        ========================================= */

        .swal2-popup {

            border-radius: 24px !important;

            font-family: 'DM Sans', sans-serif !important;

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 850px) {

            body {
                padding: 20px;
            }

            .contenedor {

                max-width: 570px;

                grid-template-columns: 1fr;

            }

            .presentacion {

                padding: 45px 40px;

                min-height: 310px;

            }

            .titulo-lateral {

                font-size: 55px;

            }

            .zona-formulario {

                padding: 45px 40px;

            }

        }


        @media (max-width: 520px) {

            body {
                padding: 12px;
            }

            .contenedor {

                border-radius: 27px;

            }

            .presentacion {

                padding: 38px 27px;

                min-height: 285px;

            }

            .titulo-lateral {

                font-size: 48px;

            }

            .texto-lateral {

                font-size: 13px;

            }

            .zona-formulario {

                padding: 38px 25px;

            }

            h1 {

                font-size: 43px;

            }

            textarea {

                min-height: 135px;

            }

        }

    </style>

</head>


<body>

    <!-- Luces decorativas -->

    <div class="luz luz-1"></div>
    <div class="luz luz-2"></div>


    <!-- Pétalos -->

    <div class="petalos">

        <span class="petalo"></span>
        <span class="petalo"></span>
        <span class="petalo"></span>
        <span class="petalo"></span>
        <span class="petalo"></span>
        <span class="petalo"></span>

    </div>


    <!-- CONTENEDOR PRINCIPAL -->

    <main class="contenedor">


        <!-- =====================================
             PRESENTACIÓN
        ====================================== -->

        <section class="presentacion">

            <div class="mini-titulo">
                Tu espacio para compartir
            </div>

            <div class="titulo-lateral">
                Tus palabras
                <br>
                tienen <span>valor.</span>
            </div>

            <p class="texto-lateral">
                A veces unas pocas palabras pueden alegrar
                el día de alguien. Escribe lo que quieras
                compartir y déjanos conocer un poquito
                de ti.
            </p>

            <div class="frase">
                Comparte. Inspira. Deja huella.
            </div>

        </section>


        <!-- =====================================
             FORMULARIO
        ====================================== -->

        <section class="zona-formulario">

            <div class="formulario">

                <div class="corazones">
                    ♡ ♡
                </div>


                <h1>
                    Déjanos unas palabras
                </h1>


                <p class="subtitulo">
                    Nos encantará saber qué piensas.
                    Tu comentario será guardado con mucho cariño.
                </p>


                <form method="POST">


                    <!-- NOMBRE -->

                    <div class="campo">

                        <label for="autor">
                            Tu nombre
                        </label>

                        <div class="input-wrap">

                            <input
                                type="text"
                                id="autor"
                                name="autor"
                                placeholder="Escribe tu nombre"
                                autocomplete="name"
                                maxlength="80"
                                required
                            >

                            <span class="icono">
                                ♡
                            </span>

                        </div>

                    </div>


                    <!-- COMENTARIO -->

                    <div class="campo">

                        <label for="contenido">
                            Tu comentario
                        </label>

                        <div class="input-wrap">

                            <textarea
                                id="contenido"
                                name="contenido"
                                maxlength="500"
                                placeholder="Escribe aquí aquello que quieras compartir..."
                                required
                            ></textarea>

                        </div>

                        <div class="inferior">

                            <span>
                                Cada palabra cuenta ♡
                            </span>

                            <span id="contador">
                                0 / 500
                            </span>

                        </div>

                    </div>


                    <!-- BOTÓN -->

                    <button type="submit">

                        <span class="boton-contenido">

                            Publicar mi comentario

                            <span class="boton-corazon">
                                ♡
                            </span>

                        </span>

                    </button>


                </form>


                <div class="pie">
                    Hecho con <span>♥</span> para compartir momentos bonitos
                </div>

            </div>

        </section>

    </main>


    <!-- =========================================
         JAVASCRIPT
    ========================================== -->

    <script>

        const textarea =
            document.getElementById('contenido');

        const contador =
            document.getElementById('contador');


        textarea.addEventListener('input', function () {

            const cantidad = this.value.length;

            contador.textContent =
                cantidad + ' / 500';


            if (cantidad >= 450) {

                contador.style.color = '#c87896';

            } else {

                contador.style.color = '#ad9ca4';

            }

        });


        /* SweetAlert para errores */

        <?php if (isset($_GET['error'])): ?>

        Swal.fire({

            icon: 'error',

            title: 'Algo salió mal ♡',

            text: 'No pudimos guardar tu comentario. Inténtalo nuevamente.',

            confirmButtonText: 'Volver a intentar',

            confirmButtonColor: '#bd7e98',

            background: '#fffaf9',

            color: '#5d4b54',

            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            }

        });

        <?php endif; ?>


    </script>

</body>

</html>
