<?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("Error de conexión");
}

$CI = $_GET['CI'] ?? '';

$sql = "UPDATE CLIENTE
        SET rol = 'administrador'
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

        <link href='https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Montserrat:wght@300;400;500;600&display=swap' rel='stylesheet'>

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

                font-family: 'Montserrat', sans-serif;

                background:
                    radial-gradient(
                        circle at 10% 20%,
                        rgba(210, 163, 178, .18),
                        transparent 30%
                    ),
                    radial-gradient(
                        circle at 90% 80%,
                        rgba(210, 163, 178, .13),
                        transparent 30%
                    ),
                    #fdf9f9;

                overflow: hidden;
            }


            /* DECORACIÓN */

            .decoracion {
                position: fixed;
                inset: 0;

                pointer-events: none;
            }

            .flor {
                position: absolute;

                color: #d8b8c2;

                opacity: .45;

                animation: flotar 7s ease-in-out infinite;
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

                animation: brillo 3s ease-in-out infinite;
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


            @keyframes flotar {

                0%, 100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-15px);
                }
            }


            @keyframes brillo {

                0%, 100% {
                    opacity: .25;
                    transform: scale(.9);
                }

                50% {
                    opacity: .7;
                    transform: scale(1.15);
                }
            }


            /* TARJETA */

            .alerta {

                width: 90%;
                max-width: 460px;

                padding: 48px 38px;

                text-align: center;

                background: rgba(255, 255, 255, .88);

                border: 1px solid #eadadd;

                border-radius: 24px;

                box-shadow:
                    0 20px 60px rgba(125, 87, 98, .12);

                animation: entrada .7s ease;
            }


            @keyframes entrada {

                from {
                    opacity: 0;
                    transform: translateY(25px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }


            /* ICONO */

            .circulo {

                width: 92px;
                height: 92px;

                margin: 0 auto 25px;

                display: flex;
                align-items: center;
                justify-content: center;

                border-radius: 50%;

                background: #f7edef;

                border: 1px solid #dfc3cb;

                box-shadow:
                    0 8px 25px rgba(173, 117, 133, .12);

                animation: suave 2.5s ease-in-out infinite;
            }


            @keyframes suave {

                0%, 100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-5px);
                }
            }


            .check {

                font-size: 42px;

                color: #a86f7f;

                font-weight: 300;
            }


            /* TITULO */

            h2 {

                font-family: 'DM Serif Display', serif;

                font-size: 32px;

                font-weight: 400;

                color: #8f5f6d;

                margin-bottom: 12px;
            }


            .subtitulo {

                color: #9b858a;

                font-size: 13px;

                letter-spacing: .3px;

                margin-bottom: 18px;
            }


            .mensaje {

                color: #74686b;

                font-size: 14px;

                line-height: 1.8;
            }


            .ci {

                display: inline-block;

                margin: 7px 0;

                color: #956372;

                font-weight: 600;
            }


            .rol {

                color: #a56e7d;

                font-weight: 600;
            }


            /* BOTÓN */

            .boton {

                display: inline-block;

                margin-top: 28px;

                padding: 12px 30px;

                border-radius: 30px;

                background: #a87583;

                color: white;

                text-decoration: none;

                font-size: 13px;

                font-weight: 500;

                letter-spacing: .2px;

                box-shadow:
                    0 7px 18px rgba(168, 117, 131, .20);

                transition: all .3s ease;
            }


            .boton:hover {

                background: #946472;

                transform: translateY(-2px);

                box-shadow:
                    0 10px 22px rgba(168, 117, 131, .25);
            }


            /* DETALLE */

            .detalle {

                margin-top: 25px;

                color: #b99ba2;

                font-family: Georgia, serif;

                font-size: 12px;

                letter-spacing: 1px;
            }


            /* CELULAR */

            @media (max-width: 500px) {

                .alerta {
                    padding: 38px 25px;
                }

                h2 {
                    font-size: 28px;
                }

                .circulo {
                    width: 82px;
                    height: 82px;
                }

                .check {
                    font-size: 36px;
                }
            }

        </style>

    </head>


    <body>


        <div class='decoracion'>

            <span class='flor'>♡</span>
            <span class='flor'>✿</span>
            <span class='flor'>♡</span>
            <span class='flor'>✿</span>

            <span class='estrella'>✦</span>
            <span class='estrella'>✧</span>

        </div>


        <div class='alerta'>


            <div class='circulo'>

                <span class='check'>
                    ✓
                </span>

            </div>


            <h2>
                ¡Rol actualizado!
            </h2>


            <p class='subtitulo'>
                La actualización se realizó correctamente
            </p>


            <p class='mensaje'>

                El usuario con CI

                <br>

                <span class='ci'>
                    $CI
                </span>

                <br>

                ahora tiene el rol de

                <span class='rol'>
                    Administrador
                </span>.

            </p>


            <a
                href='updaterol.php'
                class='boton'
            >
                Volver 
            </a>


            <div class='detalle'>
                ✦ Administración actualizada ✦
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
                justify-content: center;
                align-items: center;

                font-family: Arial, sans-serif;

                background: #fdf9f9;
            }

            .error {

                width: 90%;
                max-width: 420px;

                padding: 40px 30px;

                text-align: center;

                background: white;

                border: 1px solid #eadadd;

                border-radius: 24px;

                box-shadow:
                    0 20px 50px rgba(125,87,98,.12);
            }

            .icono {

                font-size: 50px;

                color: #a87583;

                margin-bottom: 15px;
            }

            h2 {

                color: #8f5f6d;

                font-family: Georgia, serif;
            }

            p {

                color: #777;

                font-size: 14px;
            }

            a {

                display: inline-block;

                margin-top: 15px;

                padding: 11px 28px;

                border-radius: 30px;

                background: #a87583;

                color: white;

                text-decoration: none;
            }

        </style>

    </head>


    <body>

        <div class='error'>

            <div class='icono'>
                ♡
            </div>

            <h2>
                Algo salió mal
            </h2>

            <p>
                No pudimos actualizar el rol del usuario.
            </p>

            <a href='admin.php'>
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
