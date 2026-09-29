<?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("Error de conexión");
}

$CI = $_GET['CI'] ?? '';

$sql = "UPDATE CLIENTE
        SET rol = 'vendedor'
        WHERE CI = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $CI);

if (mysqli_stmt_execute($stmt)) {

    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Rol actualizado</title>

        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap' rel='stylesheet'>

        <style>

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;

                font-family: 'Poppins', sans-serif;

                background:
                    radial-gradient(
                        circle at 15% 15%,
                        rgba(226, 190, 201, 0.45) 0%,
                        transparent 28%
                    ),
                    radial-gradient(
                        circle at 85% 85%,
                        rgba(198, 164, 177, 0.30) 0%,
                        transparent 30%
                    ),
                    linear-gradient(
                        135deg,
                        #fbf5f6,
                        #f7edef,
                        #f3e8eb
                    );
            }

            /* =========================
               FONDO DECORATIVO
            ========================= */

            .decoracion {
                position: absolute;
                inset: 0;
                pointer-events: none;
            }

            .corazon,
            .estrella {
                position: absolute;
                color: rgba(157, 91, 112, 0.22);
                animation: flotar 7s ease-in-out infinite;
            }

            .corazon:nth-child(1) {
                top: 10%;
                left: 12%;
                font-size: 35px;
            }

            .corazon:nth-child(2) {
                top: 75%;
                left: 15%;
                font-size: 25px;
                animation-delay: 1s;
            }

            .corazon:nth-child(3) {
                top: 18%;
                right: 13%;
                font-size: 28px;
                animation-delay: 2s;
            }

            .corazon:nth-child(4) {
                bottom: 12%;
                right: 15%;
                font-size: 40px;
                animation-delay: 3s;
            }

            .estrella:nth-child(5) {
                top: 30%;
                left: 25%;
                font-size: 18px;
                animation-delay: 1.5s;
            }

            .estrella:nth-child(6) {
                bottom: 25%;
                right: 25%;
                font-size: 20px;
                animation-delay: 2.5s;
            }

            @keyframes flotar {

                0%, 100% {
                    transform: translateY(0) rotate(0deg);
                }

                50% {
                    transform: translateY(-18px) rotate(8deg);
                }

            }

            /* =========================
               TARJETA
            ========================= */

            .alerta {
                position: relative;

                width: 90%;
                max-width: 460px;

                padding: 48px 38px;

                text-align: center;

                background: rgba(255, 252, 253, 0.88);

                backdrop-filter: blur(22px);
                -webkit-backdrop-filter: blur(22px);

                border: 1px solid rgba(255, 255, 255, 0.95);

                border-radius: 28px;

                box-shadow:
                    0 25px 70px rgba(119, 76, 89, 0.15),
                    0 5px 20px rgba(119, 76, 89, 0.06),
                    inset 0 1px 0 rgba(255,255,255,0.95);

                animation: aparecer 0.8s cubic-bezier(.17,.67,.3,1.3);
            }

            @keyframes aparecer {

                0% {
                    opacity: 0;
                    transform: translateY(40px) scale(.88);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }

            }

            /* =========================
               CÍRCULO
            ========================= */

            .circulo {
                width: 105px;
                height: 105px;

                margin: 0 auto 25px;

                display: flex;
                justify-content: center;
                align-items: center;

                border-radius: 50%;

                background:
                    linear-gradient(
                        145deg,
                        #fffdfd,
                        #f2dfe5
                    );

                border: 2px solid #d6aebc;

                box-shadow:
                    0 12px 30px rgba(137, 83, 102, 0.16),
                    inset 0 0 20px rgba(255,255,255,.9);

                animation: latido 2.5s ease-in-out infinite;
            }

            @keyframes latido {

                0%, 100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.04);
                }

            }

            .check {
                color: #9c5b70;

                font-size: 54px;
                font-weight: 300;

                animation: aparecerCheck .7s .4s both;
            }

            @keyframes aparecerCheck {

                from {
                    opacity: 0;
                    transform: scale(0) rotate(-30deg);
                }

                to {
                    opacity: 1;
                    transform: scale(1) rotate(0);
                }

            }

            /* =========================
               TEXTO
            ========================= */

            h2 {
                font-family: 'Playfair Display', serif;

                font-size: 34px;
                font-weight: 600;

                color: #754554;

                margin-bottom: 12px;

                letter-spacing: -0.3px;
            }

            .subtitulo {
                color: #9b7a84;

                font-size: 14px;
                font-weight: 400;

                margin-bottom: 10px;
            }

            .mensaje {
                color: #69575e;

                font-size: 15px;
                line-height: 1.8;
            }

            .ci {
                display: inline-block;

                margin: 10px 0 3px;

                color: #875166;

                font-weight: 600;

                letter-spacing: 0.5px;
            }

            .rol {
                color: #9c5b70;

                font-weight: 600;
            }

            /* =========================
               BOTÓN
            ========================= */

            .boton {
                position: relative;

                display: inline-block;

                margin-top: 28px;

                padding: 13px 34px;

                color: #fff;

                text-decoration: none;

                font-size: 14px;
                font-weight: 500;

                letter-spacing: 0.2px;

                border-radius: 50px;

                background:
                    linear-gradient(
                        135deg,
                        #a96b7f,
                        #8d5268
                    );

                box-shadow:
                    0 9px 22px rgba(120, 69, 85, 0.22);

                transition: all .3s ease;

                overflow: hidden;
            }

            .boton::before {
                content: '';

                position: absolute;

                top: 0;
                left: -100%;

                width: 100%;
                height: 100%;

                background:
                    linear-gradient(
                        90deg,
                        transparent,
                        rgba(255,255,255,.35),
                        transparent
                    );

                transition: .5s;
            }

            .boton:hover::before {
                left: 100%;
            }

            .boton:hover {
                transform: translateY(-3px);

                background:
                    linear-gradient(
                        135deg,
                        #b4778a,
                        #96596f
                    );

                box-shadow:
                    0 13px 28px rgba(120, 69, 85, 0.30);
            }

            /* =========================
               DETALLE
            ========================= */

            .detalle {
                margin-top: 26px;

                font-family: 'Playfair Display', serif;

                color: #bd929f;

                font-size: 13px;

                letter-spacing: 1.2px;
            }

            /* =========================
               RESPONSIVE
            ========================= */

            @media (max-width: 500px) {

                .alerta {
                    padding: 38px 25px;
                }

                h2 {
                    font-size: 28px;
                }

                .circulo {
                    width: 90px;
                    height: 90px;
                }

                .check {
                    font-size: 45px;
                }

            }

        </style>
    </head>

    <body>

        <div class='decoracion'>

            <span class='corazon'>♡</span>
            <span class='corazon'>♡</span>
            <span class='corazon'>♡</span>
            <span class='corazon'>♡</span>

            <span class='estrella'>✦</span>
            <span class='estrella'>✧</span>

        </div>


        <div class='alerta'>

            <div class='circulo'>
                <span class='check'>✓</span>
            </div>

            <h2>¡Todo listo!</h2>

            <p class='subtitulo'>
                Actualización realizada correctamente
            </p>

            <p class='mensaje'>

                El usuario con CI

                <br>

                <span class='ci'>$CI</span>

                <br>

                ahora forma parte del equipo como

                <span class='rol'>Vendedor</span>.

            </p>

            <a href='updaterol.php' class='boton'>
                Volver
            </a>

            <div class='detalle'>
                ✦ Gracias por confiar en nosotros ✦
            </div>

        </div>

    </body>
    </html>
    ";

} else {

    echo "
    <!DOCTYPE html>
    <html lang='es'>

    <head>

        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>

        <style>

            body {
                margin: 0;

                min-height: 100vh;

                display: flex;
                align-items: center;
                justify-content: center;

                font-family: 'Poppins', Arial, sans-serif;

                background:
                    linear-gradient(
                        135deg,
                        #fbf5f6,
                        #f3e8eb
                    );
            }

            .error {

                width: 90%;
                max-width: 430px;

                background: rgba(255,255,255,.90);

                padding: 45px 35px;

                border-radius: 28px;

                text-align: center;

                box-shadow:
                    0 25px 60px rgba(119,76,89,.15);
            }

            .icono {

                font-size: 55px;

                color: #9c5b70;

                margin-bottom: 10px;
            }

            h2 {

                color: #754554;

                font-family: Georgia, serif;

                font-size: 28px;

                margin-bottom: 12px;
            }

            p {

                color: #75646b;

                margin-bottom: 25px;
            }

            a {

                display: inline-block;

                padding: 12px 30px;

                border-radius: 30px;

                background:
                    linear-gradient(
                        135deg,
                        #a96b7f,
                        #8d5268
                    );

                color: white;

                text-decoration: none;

                transition: .3s;
            }

            a:hover {

                transform: translateY(-2px);

                box-shadow:
                    0 8px 20px rgba(120,69,85,.25);
            }

        </style>

    </head>

    <body>

        <div class='error'>

            <div class='icono'>♡</div>

            <h2>Ups... algo salió mal</h2>

            <p>
                No pudimos actualizar el rol del usuario.
            </p>

            <a href='../admin.php'>
                Volver
            </a>

        </div>

    </body>

    </html>
    ";
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);

?>