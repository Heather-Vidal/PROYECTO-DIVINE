```php
<?php

/* ==================================================
   CONEXIÓN
================================================== */

mysqli_report(MYSQLI_REPORT_OFF);

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");


/* ==================================================
   FUNCIÓN PARA MOSTRAR SWEETALERT
================================================== */

function mostrarAlerta($icono, $titulo, $mensaje, $redireccion = "updaterol.php")
{
    $tituloJS = json_encode(
        $titulo,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    $mensajeJS = json_encode(
        $mensaje,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    $redireccionJS = json_encode(
        $redireccion,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    echo '
    <!DOCTYPE html>
    <html lang="es">

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>DIVINE | Actualizar rol</title>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body>

        <script>

            Swal.fire({

                icon: ' . json_encode($icono) . ',

                title: ' . $tituloJS . ',

                text: ' . $mensajeJS . ',

                confirmButtonText: "Entendido",

                confirmButtonColor: "#8f5362",

                background: "#fffaf8",

                color: "#57494c",

                allowOutsideClick: false,

                allowEscapeKey: false,

                customClass: {

                    popup: "divine-alert",

                    confirmButton: "divine-button"

                }

            }).then(function() {

                window.location.href = ' . $redireccionJS . ';

            });

        </script>


        <style>

            body {

                margin: 0;

                min-height: 100vh;

                display: flex;

                align-items: center;

                justify-content: center;

                font-family: "Segoe UI", sans-serif;

                background:

                    linear-gradient(

                        rgba(255,250,248,.88),

                        rgba(247,233,236,.94)

                    ),

                    url("../imagenes/fondote.png");

                background-size: cover;

                background-position: center;

            }


            .divine-alert {

                border-radius: 25px !important;

                border: 1px solid #e3c5cd !important;

                box-shadow:

                    0 20px 60px

                    rgba(100,70,80,.20) !important;

            }


            .divine-button {

                border-radius: 25px !important;

                padding: 12px 28px !important;

                font-weight: 600 !important;

            }

        </style>

    </body>

    </html>
    ';

    exit();
}


/* ==================================================
   ERROR DE CONEXIÓN
================================================== */

if (!$conexion) {

    mostrarAlerta(
        "error",
        "Error de conexión",
        "No se pudo conectar con la base de datos. Intenta nuevamente."
    );

}


/* ==================================================
   OBTENER CI
================================================== */

$CI = $_GET['CI'] ?? '';


/* ==================================================
   VALIDAR CI
================================================== */

if ($CI === '') {

    mostrarAlerta(
        "warning",
        "CI no encontrado",
        "No se recibió el CI del usuario que deseas actualizar."
    );

}


/* ==================================================
   ACTUALIZAR ROL
================================================== */

$sql = "UPDATE CLIENTE
        SET rol = 'administrador'
        WHERE CI = '$CI'";


$resultado = mysqli_query($conexion, $sql);


/* ==================================================
   COMPROBAR ACTUALIZACIÓN
================================================== */

if ($resultado) {

    mostrarAlerta(
        "success",
        "¡Rol actualizado!",
        "El usuario con CI " . $CI . " ahora es Administrador."
    );

} else {

    mostrarAlerta(
        "error",
        "No se pudo actualizar",
        "Ocurrió un error al actualizar el rol del usuario. Intenta nuevamente."
    );

}


/* ==================================================
   CERRAR CONEXIÓN
================================================== */

mysqli_close($conexion);

?>
 
