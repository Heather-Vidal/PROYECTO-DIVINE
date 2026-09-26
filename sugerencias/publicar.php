<?php
$archivo = 'mensajes.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $autor = trim($_POST['autor']);
    $contenido = trim($_POST['contenido']);

    $fecha = date("Y-m-d H:i:s");
    $entrada = "$fecha | $autor: $contenido" . PHP_EOL;

    $f = fopen($archivo, 'a');

    if ($f === false) {
        header("Location: publicarcomentario.php?error=1");
        exit;
    }

    if (fwrite($f, $entrada) === false) {
        fclose($f);
        header("Location: comentarios.php?error=2");
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Déjanos un mensaje</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Manrope:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            min-height: 100vh;

            font-family: 'Manrope', sans-serif;

            background:
                linear-gradient(
                    120deg,
                    rgba(35, 12, 25, .88),
                    rgba(83, 28, 52, .72)
                ),
                url("../imagenes/rositafon.jpg");

            background-size: cover;
            background-position: center;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px;

            overflow: hidden;

            position: relative;
        }


        /* =========================
           LUCES DE FONDO
        ========================= */

        .luz {

            position: absolute;

            border-radius: 50%;

            filter: blur(2px);

            pointer-events: none;
        }

        .luz-1 {

            width: 320px;
            height: 320px;

            top: -120px;
            left: -80px;

            background: rgba(255, 148, 190, .18);

            box-shadow:
                0 0 100px rgba(255, 148, 190, .30);
        }

        .luz-2 {

            width: 280px;
            height: 280px;

            right: -100px;
            bottom: -80px;

            background: rgba(235, 180, 120, .15);

            box-shadow:
                0 0 100px rgba(235, 180, 120, .25);
        }


        /* =========================
           DESTELLOS
        ========================= */

        .estrella {

            position: absolute;

            color: rgba(255,255,255,.7);

            font-size: 15px;

            animation: brillo 3s infinite ease-in-out;
        }

        .e1 {
            top: 14%;
            left: 13%;
        }

        .e2 {
            top: 20%;
            right: 17%;
            animation-delay: 1s;
        }

        .e3 {
            bottom: 17%;
            left: 18%;
            animation-delay: 1.8s;
        }

        .e4 {
            bottom: 25%;
            right: 13%;
            animation-delay: .6s;
        }


        @keyframes brillo {

            0%, 100% {
                opacity: .2;
                transform: scale(.7);
            }

            50% {
                opacity: 1;
                transform: scale(1.3);
            }

        }


        /* =========================
           CONTENEDOR PRINCIPAL
        ========================= */

        .contenedor {

            width: min(1050px, 100%);

            min-height: 620px;

            display: grid;

            grid-template-columns: 42% 58%;

            background: rgba(255,255,255,.08);

            border: 1px solid rgba(255,255,255,.18);

            border-radius: 34px;

            overflow: hidden;

            box-shadow:
                0 35px 90px rgba(0,0,0,.45);

            backdrop-filter: blur(18px);

            animation: entrada .9s ease;
        }


        @keyframes entrada {

            from {
                opacity: 0;
                transform: scale(.96) translateY(25px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }

        }


        /* =========================
           PANEL IZQUIERDO
        ========================= */

        .presentacion {

            position: relative;

            padding: 60px 45px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            color: white;

            background:
                linear-gradient(
                    160deg,
                    rgba(75, 25, 48, .82),
                    rgba(40, 13, 29, .93)
                );
        }

        .presentacion::after {

            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            border: 1px solid rgba(255,190,210,.15);

            border-radius: 50%;

            right: -100px;
            bottom: -80px;
        }


        .mini-logo {

            font-size: 14px;

            letter-spacing: 4px;

            color: #e9b8c8;

            text-transform: uppercase;
        }


        .presentacion h2 {

            font-family: 'DM Serif Display', serif;

            font-size: clamp(45px, 5vw, 68px);

            font-weight: 400;

            line-height: .98;

            margin: 45px 0 25px;
        }


        .presentacion h2 span {

            color: #e5a9bd;

            font-style: italic;
        }


        .presentacion p {

            color: #d8bdc7;

            font-size: 13px;

            line-height: 1.9;

            max-width: 310px;
        }


        .frase {

            color: #d69bad;

            font-family: 'DM Serif Display', serif;

            font-style: italic;

            font-size: 18px;

            line-height: 1.5;
        }


        .firma {

            color: #a88b97;

            font-size: 10px;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-top: 10px;
        }


        /* =========================
           PANEL DEL FORMULARIO
        ========================= */

        .form-panel {

            background: #fff8fa;

            padding: 65px 65px;

            display: flex;

            flex-direction: column;

            justify-content: center;

            position: relative;
        }


        .form-panel::before {

            content: "♡";

            position: absolute;

            right: 35px;
            top: 28px;

            font-size: 55px;

            color: #f0d7df;

            font-family: Georgia, serif;

            transform: rotate(15deg);
        }


        .etiqueta {

            color: #b36a82;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-bottom: 10px;
        }


        .form-panel h1 {

            font-family: 'DM Serif Display', serif;

            font-size: 42px;

            font-weight: 400;

            color: #432536;

            margin-bottom: 10px;
        }


        .descripcion {

            color: #9b7d89;

            font-size: 12px;

            line-height: 1.7;

            margin-bottom: 32px;

            max-width: 420px;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {

            margin-bottom: 20px;
        }


        .campo label {

            display: block;

            color: #694153;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: .8px;

            margin-bottom: 8px;
        }


        .campo input,
        .campo textarea {

            width: 100%;

            border: 1px solid #ead6dc;

            background: #fff;

            color: #4a2b39;

            font-family: 'Manrope', sans-serif;

            font-size: 13px;

            border-radius: 12px;

            padding: 15px 16px;

            outline: none;

            transition: .3s ease;
        }


        .campo input {

            height: 50px;
        }


        .campo textarea {

            height: 125px;

            resize: none;

            line-height: 1.6;
        }


        .campo input::placeholder,
        .campo textarea::placeholder {

            color: #c8aeb8;
        }


        .campo input:focus,
        .campo textarea:focus {

            border-color: #c17490;

            box-shadow:
                0 0 0 4px rgba(193,116,144,.10);

            background: #fff;
        }


        /* =========================
           BOTÓN PUBLICAR
        ========================= */

        form button {

            width: 100%;

            height: 53px;

            border: 0;

            border-radius: 12px;

            background:
                linear-gradient(
                    100deg,
                    #9b4567,
                    #c06d8d
                );

            color: white;

            font-family: 'Manrope', sans-serif;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            cursor: pointer;

            position: relative;

            overflow: hidden;

            box-shadow:
                0 10px 25px rgba(145,61,94,.25);

            transition: .3s ease;
        }


        form button::after {

            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            background: rgba(255,255,255,.15);

            border-radius: 50%;

            top: -45px;
            left: -100px;

            transition: .5s;
        }


        form button:hover {

            transform: translateY(-3px);

            box-shadow:
                0 15px 30px rgba(145,61,94,.32);
        }


        form button:hover::after {

            left: 110%;
        }


        /* =========================
           DETALLE FINAL
        ========================= */

        .final {

            text-align: center;

            color: #c19ca9;

            font-size: 10px;

            letter-spacing: 1px;

            margin-top: 22px;
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


        /* =========================
           CORAZÓN
        ========================= */

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


        /* =========================
           FLECHA
        ========================= */

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


        /* =========================
           HOVER CÍRCULO
        ========================= */

        .divine-back:hover {

            transform: translateY(-5px) scale(1.07);

            background: linear-gradient(
                145deg,
                #b67d93,
                #9c667e
            );

            box-shadow:
                0 13px 28px rgba(115, 65, 84, 0.30),
                inset 0 1px 3px rgba(255,255,255,0.45);
        }


        /* =========================
           HOVER CORAZÓN
        ========================= */

        .divine-back:hover .divine-back-heart {

            transform: scale(1.13);

            fill: rgba(255, 245, 248, 0.22);

            stroke-width: 2;
        }


        /* =========================
           HOVER FLECHA
        ========================= */

        .divine-back:hover .divine-back-arrow {

            transform: translateX(-55%);

            color: #925f76;
        }


        /* =========================
           TEXTO VOLVER
        ========================= */

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


        /* =========================
           MOSTRAR VOLVER
        ========================= */

        .divine-back:hover .divine-back-text {

            opacity: 1;

            visibility: visible;

            transform:
                translateX(-50%)
                translateY(0);
        }


        /* =========================
           CLICK
        ========================= */

        .divine-back:active {

            transform: scale(0.93);
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 800px) {

            body {

                padding: 15px;

                overflow-y: auto;
            }


            .contenedor {

                grid-template-columns: 1fr;

                max-width: 550px;
            }


            .presentacion {

                min-height: 390px;

                padding: 40px 30px;
            }


            .presentacion h2 {

                margin: 30px 0 20px;

                font-size: 48px;
            }


            .form-panel {

                padding: 45px 30px;
            }

        }


        @media (max-width: 600px) {

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


        @media (max-width: 450px) {

            .presentacion h2 {

                font-size: 42px;
            }


            .form-panel h1 {

                font-size: 36px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         LUCES
    ========================= -->

    <div class="luz luz-1"></div>
    <div class="luz luz-2"></div>


    <!-- =========================
         DESTELLOS
    ========================= -->

    <span class="estrella e1">✦</span>
    <span class="estrella e2">✧</span>
    <span class="estrella e3">✦</span>
    <span class="estrella e4">✧</span>


    <!-- =========================
         CONTENEDOR
    ========================= -->

    <main class="contenedor">


        <!-- ======================
             PRESENTACIÓN
        ======================= -->

        <section class="presentacion">

            <div>

                <div class="mini-logo">
                    ♡ Un pequeño detalle
                </div>


                <h2>
                    Tus palabras<br>
                    <span>importan.</span>
                </h2>


                <p>
                    Queremos conocer lo que piensas,
                    lo que sientes y esos pequeños
                    mensajes que hacen especial este lugar.
                </p>

            </div>


            <div>

                <div class="frase">
                    “Las palabras bonitas
                    siempre encuentran
                    un lugar donde quedarse.”
                </div>

                <div class="firma">
                    Gracias por compartir ♡
                </div>

            </div>

        </section>


        <!-- ======================
             FORMULARIO
        ======================= -->

        <section class="form-panel">


            <div class="etiqueta">
                Comparte con nosotros
            </div>


            <h1>
                Deja tu mensaje
            </h1>


            <p class="descripcion">
                Escribe tu nombre y déjanos unas palabras.
                Tu mensaje será guardado con mucho cariño.
            </p>


            <form method="POST">


                <div class="campo">

                    <label for="autor">
                        Nombre
                    </label>

                    <input
                        type="text"
                        id="autor"
                        name="autor"
                        placeholder="¿Cómo te llamas?"
                        autocomplete="name"
                        required
                    >

                </div>


                <div class="campo">

                    <label for="contenido">
                        Mensaje
                    </label>

                    <textarea
                        id="contenido"
                        name="contenido"
                        placeholder="Escribe algo bonito..."
                        required
                    ></textarea>

                </div>


                <button type="submit">
                    Publicar mi mensaje &nbsp; ♡
                </button>


            </form>


            <div class="final">
                Hecho con cariño · ✦ · Para recordar
            </div>


        </section>


    </main>


    <!-- =====================================================
         BOTÓN FLOTANTE VOLVER DIVINE
         ===================================================== -->

    <button
        type="button"
        class="divine-back"
        onclick="history.back()"
        aria-label="Volver"
        title="Volver"
    >

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


        <span class="divine-back-arrow">
            ←
        </span>


        <span class="divine-back-text">
            Volver
        </span>

    </button>


    <!-- =========================
         ALERTA DE ERROR
    ========================= -->

    <script>

        <?php if (isset($_GET['error'])) { ?>

        Swal.fire({

            icon: 'error',

            title: 'No se pudo guardar ♡',

            text: 'Ocurrió un problema al guardar tu comentario. Inténtalo nuevamente.',

            confirmButtonText: 'Aceptar',

            confirmButtonColor: '#9b4567',

            background: '#fff8fa',

            color: '#432536',

            buttonsStyling: true

        });

        <?php } ?>

    </script>


</body>

</html>