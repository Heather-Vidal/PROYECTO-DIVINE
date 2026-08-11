<?php

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


/* =====================================================
   COMPROBAR CONEXIÓN
   ===================================================== */

if ($conn->connect_error) {

    $mensaje = "NO TE PUDISTE CONECTAR CON LA BD UnU";

    $tipoMensaje = "error";

} else {

    $mensaje = "";
    $tipoMensaje = "";

}


/* =====================================================
   PROCESAR ACTUALIZACIÓN
   ===================================================== */

if (!$conn->connect_error) {


    /* =================================================
       RECIBIR DATOS DEL FORMULARIO
       ================================================= */

    $nombre =
        $_POST['nombre']
        ?? '';

    $descripcion =
        $_POST['descripcion']
        ?? '';

    $precio =
        $_POST['precio']
        ?? '';

    $costo =
        $_POST['costo']
        ?? '';

    $stock =
        $_POST['stock']
        ?? '';

    $codigo =
        $_POST['codigo']
        ?? '';


    /* =================================================
       VALIDAR CÓDIGO
       ================================================= */

    if ($codigo === '') {

        $mensaje =
            "No se recibió el código del producto.";

        $tipoMensaje =
            "error";

    } else {


        /* =============================================
           ACTUALIZAR DATOS DEL PRODUCTO
           ============================================= */

        $sql = "UPDATE PRODUCTO
                SET
                    nombre='$nombre',
                    descripcion='$descripcion',
                    precio='$precio',
                    costo='$costo',
                    stock='$stock'
                WHERE codigo=$codigo";


        if ($conn->query($sql) === TRUE) {


            /* =============================================
               COMPROBAR SI SE SELECCIONÓ UNA NUEVA IMAGEN
               ============================================= */

            if (
                isset($_FILES['fileToUpload'])
                &&
                $_FILES['fileToUpload']['error']
                    !== UPLOAD_ERR_NO_FILE
            ) {


                /* =========================================
                   COMPROBAR SI HUBO ERROR EN LA CARGA
                   ========================================= */

                if (
                    $_FILES['fileToUpload']['error']
                    !== UPLOAD_ERR_OK
                ) {

                    $mensaje =
                        "El producto se actualizó, pero ocurrió un error al cargar la nueva imagen.";

                    $tipoMensaje =
                        "error";

                } else {


                    /* =====================================
                       INFORMACIÓN DEL ARCHIVO
                       ===================================== */

                    $archivo =
                        $_FILES['fileToUpload'];


                    $nombreOriginal =
                        $archivo['name'];


                    $tmp =
                        $archivo['tmp_name'];


                    $tamaño =
                        $archivo['size'];


                    /* =====================================
                       EXTENSIÓN
                       ===================================== */

                    $extension =
                        strtolower(
                            pathinfo(
                                $nombreOriginal,
                                PATHINFO_EXTENSION
                            )
                        );


                    /* =====================================
                       EXTENSIONES PERMITIDAS
                       ===================================== */

                    $extensionesPermitidas = [

                        'jpg',

                        'jpeg',

                        'png',

                        'gif'

                    ];


                    if (
                        !in_array(
                            $extension,
                            $extensionesPermitidas
                        )
                    ) {

                        $mensaje =
                            "El producto se actualizó, pero la imagen no es válida. Usa JPG, JPEG, PNG o GIF.";

                        $tipoMensaje =
                            "error";

                    } else {


                        /* =================================
                           COMPROBAR QUE SEA UNA IMAGEN
                           ================================= */

                        $informacionImagen =
                            getimagesize($tmp);


                        if (
                            $informacionImagen === false
                        ) {

                            $mensaje =
                                "El producto se actualizó, pero el archivo seleccionado no es una imagen válida.";

                            $tipoMensaje =
                                "error";

                        } else {


                            /* =================================
                               CARPETA DE IMÁGENES
                               ================================= */

                            $directorio =
                                "../PRODUCTO-img/";


                            /*
                                Si por alguna razón la carpeta
                                no existe, intentamos crearla.
                            */

                            if (
                                !is_dir(
                                    $directorio
                                )
                            ) {

                                mkdir(
                                    $directorio,
                                    0755,
                                    true
                                );

                            }


                            /* =================================
                               NOMBRE BASE DE LA IMAGEN
                               ================================= */

                            $nombreBase =
                                "p-" . $codigo;


                            /* =================================
                               BUSCAR IMAGEN ANTERIOR
                               ================================= */

                            $extensionesAnteriores = [

                                'jpg',

                                'jpeg',

                                'png',

                                'gif'

                            ];


                            foreach (
                                $extensionesAnteriores
                                as $extensionAnterior
                            ) {


                                $imagenAnterior =

                                    $directorio
                                    .
                                    $nombreBase
                                    .
                                    "."
                                    .
                                    $extensionAnterior;


                                if (
                                    file_exists(
                                        $imagenAnterior
                                    )
                                ) {


                                    /*
                                        ELIMINAMOS LA IMAGEN
                                        ANTERIOR
                                    */

                                    unlink(
                                        $imagenAnterior
                                    );

                                }

                            }


                            /* =================================
                               NUEVO NOMBRE
                               ================================= */

                            $nuevoNombre =

                                $directorio
                                .
                                $nombreBase
                                .
                                "."
                                .
                                $extension;


                            /* =================================
                               MOVER NUEVA IMAGEN
                               ================================= */

                            if (
                                move_uploaded_file(
                                    $tmp,
                                    $nuevoNombre
                                )
                            ) {

                                $mensaje =
                                    "¡Producto e imagen actualizados correctamente!";

                                $tipoMensaje =
                                    "exito";

                            } else {

                                $mensaje =
                                    "El producto se actualizó, pero no se pudo guardar la nueva imagen.";

                                $tipoMensaje =
                                    "error";

                            }

                        }

                    }

                }


            } else {


                /* =========================================
                   NO SE CAMBIÓ LA IMAGEN
                   ========================================= */

                $mensaje =
                    "¡Producto actualizado correctamente! La imagen anterior se conservó.";

                $tipoMensaje =
                    "exito";

            }


        } else {


            /* =============================================
               ERROR EN LA ACTUALIZACIÓN
               ============================================= */

            $mensaje =
                "ERROR AL ACTUALIZAR EL PRODUCTO: "
                .
                $conn->error;

            $tipoMensaje =
                "error";

        }

    }

}

?>


<!DOCTYPE html>

<html lang="es">


<head>

<meta charset="UTF-8">


<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>


<title>

    Producto Modificado - DIVINE

</title>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap"
    rel="stylesheet"
/>


<style>

/* =====================================================
   CUERPO
   ===================================================== */

body {

    font-family:
        "Playfair Display",
        serif;

    background-color:
        #f5e9d8;

    display:
        flex;

    justify-content:
        center;

    align-items:
        center;

    min-height:
        100vh;

    margin:
        0;

    color:
        #2b2b2b;

}


/* =====================================================
   CONTENEDOR
   ===================================================== */

.contenedor {

    background:
        #e9e5dd;

    padding:
        40px;

    border-radius:
        25px;

    box-shadow:
        0 10px 25px
        rgba(0,0,0,0.15);

    width:
        90%;

    max-width:
        700px;

    display:
        grid;

    grid-template-columns:
        1fr;

    grid-template-areas:

        "encabezado"

        "contenido"

        "botones";

    gap:
        30px;

    text-align:
        center;

}


/* =====================================================
   ENCABEZADO
   ===================================================== */

.encabezado {

    grid-area:
        encabezado;

    font-size:
        36px;

    font-weight:
        700;

    color:
        #364e63;

    letter-spacing:
        2px;

    text-transform:
        uppercase;

    border-bottom:
        3px solid #c5a46d;

    padding-bottom:
        10px;

}


/* =====================================================
   CONTENIDO
   ===================================================== */

.contenido {

    grid-area:
        contenido;

    background:
        #f5e9d8;

    border-radius:
        20px;

    padding:
        30px 25px;

    box-shadow:
        0 4px 10px
        rgba(54,78,99,0.2);

    font-size:
        18px;

    color:
        #2b2b2b;

}


/* =====================================================
   MENSAJE
   ===================================================== */

.mensaje {

    border-radius:
        12px;

    padding:
        20px;

    font-weight:
        600;

    margin-bottom:
        15px;

}


/* =====================================================
   ÉXITO
   ===================================================== */

.exito {

    background-color:
        #c5a46d;

    color:
        white;

    box-shadow:
        0 4px 12px
        rgba(197,164,109,0.7);

}


/* =====================================================
   ERROR
   ===================================================== */

.error {

    background-color:
        #b53737;

    color:
        white;

    box-shadow:
        0 4px 12px
        rgba(181,55,55,0.7);

}


/* =====================================================
   BOTONES
   ===================================================== */

.botones {

    grid-area:
        botones;

    display:
        flex;

    justify-content:
        center;

    gap:
        25px;

}


/* =====================================================
   BOTÓN
   ===================================================== */

.boton {

    text-decoration:
        none;

    background:
        #364e63;

    color:
        #c5a46d;

    padding:
        14px 38px;

    border-radius:
        30px;

    font-weight:
        700;

    font-size:
        17px;

    box-shadow:
        0 4px 15px
        rgba(54,78,99,0.6);

    transition:
        background-color 0.3s ease,
        color 0.3s ease,
        transform 0.25s ease;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

}


.boton:hover {

    background-color:
        #c5a46d;

    color:
        #364e63;

    transform:
        scale(1.05);

    box-shadow:
        0 6px 20px
        rgba(197,164,109,0.9);

}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width:600px) {

    .contenedor {

        padding:
            25px;

    }


    .botones {

        flex-direction:
            column;

        gap:
            15px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =================================================
         ENCABEZADO
         ================================================= -->

    <div class="encabezado">

        DIVINE

    </div>


    <!-- =================================================
         MENSAJE
         ================================================= -->

    <div class="contenido">


        <?php

        if (
            $mensaje !== ''
        ) {

        ?>

            <div
                class="mensaje <?php
                    echo $tipoMensaje;
                ?>"
            >

                <?php

                if (
                    $tipoMensaje === "exito"
                ) {

                    echo "✔ ";

                } else {

                    echo "⚠ ";

                }


                echo htmlspecialchars(
                    $mensaje
                );

                ?>

            </div>

        <?php

        }

        ?>


    </div>


    <!-- =================================================
         BOTONES
         ================================================= -->

    <div class="botones">


        <a
            href="../totu.php"
            class="boton"
        >

            ⬅ Volver al inicio

        </a>


        <a
            href="readtodoprodu.php"
            class="boton"
        >

            Ver productos ➡

        </a>


    </div>


</div>


</body>

</html>


<?php

$conn->close();

?>