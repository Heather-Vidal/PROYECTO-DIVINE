```php
<?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("Error de conexión");
}

$CI = $_GET['CI'];

$sql = "UPDATE CLIENTE 
        SET estado = 'BLOQUEADO' 
        WHERE CI = '$CI'";

if (mysqli_query($conexion, $sql)) {

    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Usuario bloqueado - DIVINE</title>

        <style>

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', Arial, sans-serif;
                background: linear-gradient(135deg, #fce4ec, #f8cbd8, #f5b6c8);
                min-height: 100vh;

                display: flex;
                justify-content: center;
                align-items: center;
            }

            .contenedor {
                width: 90%;
                max-width: 500px;
                background: #fff8fa;
                padding: 45px 35px;
                border-radius: 25px;
                text-align: center;

                box-shadow: 0 10px 30px rgba(190, 100, 130, 0.25);
                border: 2px solid #f3c1cf;
            }

            .icono {
                width: 75px;
                height: 75px;
                margin: 0 auto 20px;

                background: #e8a0b5;
                color: white;

                border-radius: 50%;

                display: flex;
                justify-content: center;
                align-items: center;

                font-size: 35px;
            }

            h2 {
                color: #c45b7a;
                font-size: 26px;
                margin-bottom: 15px;
            }

            p {
                color: #7d5663;
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 25px;
            }

            .ci {
                color: #c45b7a;
                font-weight: bold;
            }

            .estado {
                display: inline-block;
                background: #f3c1cf;
                color: #a83f60;
                padding: 8px 18px;
                border-radius: 20px;
                font-weight: bold;
                margin-bottom: 25px;
            }

            .boton {
                display: inline-block;
                text-decoration: none;

                background: #d96b8a;
                color: white;

                padding: 12px 28px;
                border-radius: 25px;

                font-size: 15px;
                font-weight: bold;

                transition: 0.3s;
            }

            .boton:hover {
                background: #bd5272;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(189, 82, 114, 0.3);
            }

            .marca {
                margin-top: 25px;
                color: #d58ca1;
                font-size: 14px;
                font-weight: bold;
                letter-spacing: 2px;
            }

        </style>
    </head>

    <body>

        <div class='contenedor'>

            <div class='icono'>
                ✓
            </div>

            <h2>Usuario bloqueado correctamente</h2>

            <p>
                El estado del usuario con CI
                <span class='ci'>$CI</span>
                ahora es:
            </p>

            <div class='estado'>
                BLOQUEADO
            </div>

            <br>

            <a class='boton' href='./CRUD-cliente/readunocliente.php'>
                ← Volver atrás
            </a>

            <div class='marca'>
                DIVINE
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
        <title>Error - DIVINE</title>

        <style>

            body {
                font-family: Arial, sans-serif;
                background: #fce4ec;
                min-height: 100vh;

                display: flex;
                justify-content: center;
                align-items: center;
            }

            .error {
                background: #fff8fa;
                padding: 40px;
                border-radius: 25px;
                text-align: center;

                box-shadow: 0 10px 25px rgba(190, 100, 130, 0.2);
                border: 2px solid #f3c1cf;
            }

            h2 {
                color: #c94f70;
                margin-bottom: 15px;
            }

            p {
                color: #805866;
            }

        </style>
    </head>

    <body>

        <div class='error'>
            <h2>♡ Error al bloquear el usuario</h2>
            <p>No se pudo actualizar el estado del usuario.</p>
        </div>

    </body>
    </html>
    ";

}

mysqli_close($conexion);

?>
```
