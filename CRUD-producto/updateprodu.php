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

    // Usar UTF-8 correctamente
    $conn->set_charset("utf8mb4");
}


/* =====================================================
   PROCESAR ACTUALIZACIÓN
   ===================================================== */

if (!$conn->connect_error) {


    /* =================================================
       RECIBIR DATOS DEL FORMULARIO
       ================================================= */

    $nombre = trim($_POST['nombre'] ?? '');

    $descripcion = trim($_POST['descripcion'] ?? '');

    $categoria = trim($_POST['categoria'] ?? '');

    $precio = $_POST['precio'] ?? '';

    $costo = $_POST['costo'] ?? '';

    $stock = $_POST['stock'] ?? '';

    $codigo = filter_input(
        INPUT_POST,
        'codigo',
        FILTER_VALIDATE_INT
    );


    /* =================================================
       VALIDAR CÓDIGO
       ================================================= */

    if ($codigo === false || $codigo === null) {

        $mensaje =
            "El código del producto no es válido.";

        $tipoMensaje =
            "error";

    } else {


        /* =================================================
           VALIDAR DATOS
           ================================================= */

        if ($nombre === '') {

            $mensaje =
                "El nombre del producto es obligatorio.";

            $tipoMensaje =
                "error";

        } elseif (!is_numeric($precio)) {

            $mensaje =
                "El precio no es válido.";

            $tipoMensaje =
                "error";

        } elseif (!is_numeric($costo)) {

            $mensaje =
                "El costo no es válido.";

            $tipoMensaje =
                "error";

        } elseif (
            filter_var(
                $stock,
                FILTER_VALIDATE_INT
            ) === false
        ) {

            $mensaje =
                "El stock no es válido.";

            $tipoMensaje =
                "error";

        } else {


            /* =================================================
               CONVERTIR TIPOS
               ================================================= */

            $precio = (float)$precio;

            $costo = (float)$costo;

            $stock = (int)$stock;


            /* =================================================
               ACTUALIZAR PRODUCTO
               CONSULTA PREPARADA
               ================================================= */

            $sql = "UPDATE PRODUCTO
                    SET
                        nombre = ?,
                        descripcion = ?,
                        categoria = ?,
                        precio = ?,
                        costo = ?,
                        stock = ?
                    WHERE codigo = ?";


            $stmt = $conn->prepare($sql);


            if ($stmt === false) {

                $mensaje =
                    "No se pudo preparar la actualización.";

                $tipoMensaje =
                    "error";

            } else {


                /* =================================================
                   ASIGNAR PARÁMETROS
                   ================================================= */

                $stmt->bind_param(
                    "sssddii",
                    $nombre,
                    $descripcion,
                    $categoria,
                    $precio,
                    $costo,
                    $stock,
                    $codigo
                );


                /* =================================================
                   EJECUTAR ACTUALIZACIÓN
                   ================================================= */

                if ($stmt->execute()) {


                    /* =================================================
                       COMPROBAR SI SE SELECCIONÓ UNA NUEVA IMAGEN
                       ================================================= */

                    if (
                        isset($_FILES['fileToUpload'])
                        &&
                        $_FILES['fileToUpload']['error']
                        !== UPLOAD_ERR_NO_FILE
                    ) {


                        /* =================================================
                           COMPROBAR ERROR DE CARGA
                           ================================================= */

                        if (
                            $_FILES['fileToUpload']['error']
                            !== UPLOAD_ERR_OK
                        ) {

                            $mensaje =
                                "El producto se actualizó, pero ocurrió un error al cargar la nueva imagen.";

                            $tipoMensaje =
                                "error";

                        } else {


                            /* =================================================
                               INFORMACIÓN DEL ARCHIVO
                               ================================================= */

                            $archivo =
                                $_FILES['fileToUpload'];

                            $nombreOriginal =
                                $archivo['name'];

                            $tmp =
                                $archivo['tmp_name'];

                            $tamaño =
                                $archivo['size'];


                            /* =================================================
                               COMPROBAR TAMAÑO
                               Máximo: 5 MB
                               ================================================= */

                            $tamañoMaximo =
                                5 * 1024 * 1024;


                            if ($tamaño > $tamañoMaximo) {

                                $mensaje =
                                    "El producto se actualizó, pero la imagen supera el tamaño máximo permitido de 5 MB.";

                                $tipoMensaje =
                                    "error";

                            } else {


                                /* =================================================
                                   EXTENSIÓN
                                   ================================================= */

                                $extension =
                                    strtolower(
                                        pathinfo(
                                            $nombreOriginal,
                                            PATHINFO_EXTENSION
                                        )
                                    );


                                /* =================================================
                                   EXTENSIONES PERMITIDAS
                                   ================================================= */

                                $extensionesPermitidas = [

                                    'jpg',
                                    'jpeg',
                                    'png',
                                    'gif'

                                ];


                                if (
                                    !in_array(
                                        $extension,
                                        $extensionesPermitidas,
                                        true
                                    )
                                ) {

                                    $mensaje =
                                        "El producto se actualizó, pero la imagen no es válida. Usa JPG, JPEG, PNG o GIF.";

                                    $tipoMensaje =
                                        "error";

                                } else {


                                    /* =================================================
                                       COMPROBAR QUE SEA REALMENTE UNA IMAGEN
                                       ================================================= */

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


                                        /* =================================================
                                           COMPROBAR MIME REAL
                                           ================================================= */

                                        $mimePermitidos = [

                                            'image/jpeg',
                                            'image/png',
                                            'image/gif'

                                        ];


                                        if (
                                            !in_array(
                                                $informacionImagen['mime'],
                                                $mimePermitidos,
                                                true
                                            )
                                        ) {

                                            $mensaje =
                                                "El producto se actualizó, pero el tipo de imagen no está permitido.";

                                            $tipoMensaje =
                                                "error";

                                        } else {


                                            /* =================================================
                                               CARPETA DE IMÁGENES
                                               ================================================= */

                                            $directorio =
                                                "../PRODUCTO-img/";


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


                                            /* =================================================
                                               NOMBRE BASE
                                               ================================================= */

                                            $nombreBase =
                                                "p-" . $codigo;


                                            /* =================================================
                                               BUSCAR IMAGEN ANTERIOR
                                               ================================================= */

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

                                                    unlink(
                                                        $imagenAnterior
                                                    );
                                                }
                                            }


                                            /* =================================================
                                               GENERAR NUEVO NOMBRE
                                               ================================================= */

                                            $nuevoNombre =
                                                $directorio
                                                .
                                                $nombreBase
                                                .
                                                "."
                                                .
                                                $extension;


                                            /* =================================================
                                               MOVER IMAGEN
                                               ================================================= */

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
                            }
                        }

                    } else {


                        /* =================================================
                           NO SE CAMBIÓ LA IMAGEN
                           ================================================= */

                        $mensaje =
                            "¡Producto actualizado correctamente! La imagen anterior se conservó.";

                        $tipoMensaje =
                            "exito";
                    }


                } else {


                    /* =================================================
                       ERROR EN LA ACTUALIZACIÓN
                       ================================================= */

                    $mensaje =
                        "No se pudo actualizar el producto.";

                    $tipoMensaje =
                        "error";
                }


                $stmt->close();
            }
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

/* =========================
   ESTILO GENERAL DIVINE
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


body{

    font-family:'Segoe UI',sans-serif;

    background:#f8eef0;

    color:#333;

    display:flex;

    justify-content:center;

    align-items:center;

    min-height:100vh;

    padding:40px 20px;
}


/* =========================
   CONTENEDOR PRINCIPAL
========================= */

.contenedor{

    width:85%;

    max-width:750px;

    background:white;

    padding:50px;

    border-radius:30px;

    box-shadow:
        0 20px 40px
        rgba(0,0,0,.10);

    display:grid;

    grid-template-columns:1fr;

    grid-template-areas:

        "encabezado"
        "contenido"
        "botones";

    gap:30px;

    text-align:center;

    animation:
        contenedorEntrada
        1s
        ease-out;

    transition:.4s ease;
}


.contenedor:hover{

    box-shadow:
        0 25px 50px
        rgba(0,0,0,.13);
}


/* =========================
   ENCABEZADO
========================= */

.encabezado{

    grid-area:encabezado;

    font-family:Georgia,serif;

    font-size:45px;

    font-weight:bold;

    color:#bf7485;

    letter-spacing:6px;

    text-transform:uppercase;

    padding-bottom:20px;

    border-bottom:
        3px solid
        #d89aa7;
}


/* =========================
   CONTENIDO
========================= */

.contenido{

    grid-area:contenido;

    background:#f8eef0;

    padding:35px 30px;

    border-radius:25px;

    border-left:
        8px solid
        #d89aa7;

    box-shadow:
        0 12px 25px
        rgba(0,0,0,.08);

    font-size:18px;

    line-height:1.8;

    color:#666;

    animation:
        contenidoEntrada
        .8s
        ease-out;
}


/* =========================
   MENSAJES
========================= */

.mensaje{

    padding:25px;

    border-radius:20px;

    font-weight:bold;

    font-size:18px;

    line-height:1.7;

    box-shadow:
        0 8px 20px
        rgba(0,0,0,.10);

    animation:
        mensajeEntrada
        .7s
        ease-out;
}


/* =========================
   ÉXITO
========================= */

.exito{

    background:
        linear-gradient(
            135deg,
            #ebbcc6,
            #c7909d
        );

    color:white;

    box-shadow:
        0 8px 20px
        rgba(201,111,132,.35);
}


/* =========================
   ERROR
========================= */

.error{

    background:#b45d72;

    color:white;

    box-shadow:
        0 8px 20px
        rgba(180,93,114,.35);
}


/* =========================
   BOTONES
========================= */

.botones{

    grid-area:botones;

    display:flex;

    justify-content:center;

    align-items:center;

    gap:20px;

    flex-wrap:wrap;
}


/* =========================
   BOTÓN
========================= */

.boton{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    background:#c96f84;

    color:white;

    padding:15px 35px;

    border-radius:50px;

    text-decoration:none;

    font-weight:bold;

    font-size:17px;

    box-shadow:
        0 8px 20px
        rgba(201,111,132,.35);

    transition:.4s;
}


.boton:hover{

    background:#b45d72;

    transform:
        translateY(-3px);

    box-shadow:
        0 12px 25px
        rgba(180,93,114,.40);
}


/* =========================
   ANIMACIONES
========================= */

@keyframes contenedorEntrada{

    from{

        opacity:0;

        transform:
            scale(1.04);
    }

    to{

        opacity:1;

        transform:
            scale(1);
    }
}


@keyframes contenidoEntrada{

    from{

        opacity:0;

        transform:
            translateY(35px);
    }

    to{

        opacity:1;

        transform:
            translateY(0);
    }
}


@keyframes mensajeEntrada{

    from{

        opacity:0;

        transform:
            translateY(20px);
    }

    to{

        opacity:1;

        transform:
            translateY(0);
    }
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:900px){

    .contenedor{

        width:90%;

        padding:40px 30px;
    }
}


@media(max-width:600px){

    body{

        padding:
            20px 15px;
    }


    .contenedor{

        width:100%;

        padding:
            30px 20px;

        border-radius:25px;

        gap:25px;
    }


    .encabezado{

        font-size:30px;

        letter-spacing:3px;

        padding-bottom:15px;
    }


    .contenido{

        padding:
            25px 20px;

        font-size:16px;
    }


    .mensaje{

        padding:
            20px 15px;

        font-size:16px;
    }


    .botones{

        flex-direction:column;

        width:100%;
    }


    .boton{

        width:100%;

        padding:
            14px 20px;
    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =========================
         ENCABEZADO
    ========================== -->

    <div class="encabezado">

        DIVINE

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenido">


        <?php

        if ($mensaje !== '') {

        ?>

            <div
                class="mensaje <?php
                    echo htmlspecialchars(
                        $tipoMensaje,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                ?>"
            >

                <?php

                if ($tipoMensaje === "exito") {

                    echo "✔ ";

                } else {

                    echo "⚠ ";

                }


                echo htmlspecialchars(
                    $mensaje,
                    ENT_QUOTES,
                    'UTF-8'
                );

                ?>

            </div>

        <?php

        }

        ?>


    </div>


    <!-- =========================
         BOTONES
    ========================== -->

    <div class="botones">


        <a
            href="readtodoprodu.php"
            class="boton"
        >

            ⬅ Volver 

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
