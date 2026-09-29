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


// =====================================================
// VARIABLES PARA MENSAJES
// =====================================================

$tipoMensaje = "";
$mensaje = "";
$detalleMensaje = "";


// =====================================================
// VERIFICAR CONEXIÓN
// =====================================================

if ($conn->connect_error) {

    $tipoMensaje = "error";

    $mensaje = "No se pudo conectar con la base de datos.";

} else {


    // =================================================
    // RECIBIR DATOS
    // =================================================

    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $costo = $_POST['costo'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $codigo = $_POST['codigo'] ?? '';


    // =================================================
    // INSERTAR PRODUCTO EN LA BASE DE DATOS
    // =================================================

    $sql = "
        INSERT INTO PRODUCTO
        (
            nombre,
            descripcion,
            categoria,
            precio,
            costo,
            stock,
            codigo
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";


    $stmt = $conn->prepare($sql);


    if ($stmt) {

        $stmt->bind_param(
            "sssiiii",
            $nombre,
            $descripcion,
            $categoria,
            $precio,
            $costo,
            $stock,
            $codigo
        );


        // =================================================
        // GUARDAR PRODUCTO
        // =================================================

        if ($stmt->execute()) {


            // =================================================
            // PRODUCTO GUARDADO CORRECTAMENTE
            // AHORA SE PROCESA LA IMAGEN
            // =================================================

            $productoGuardado = true;
            $imagenGuardada = false;

            $mensaje = "PRODUCTO GUARDADO EXITOSAMENTE";


            // =================================================
            // VERIFICAR SI SE ENVIÓ UNA IMAGEN
            // =================================================

            if (
                isset($_FILES["fileToUpload"]) &&
                $_FILES["fileToUpload"]["error"] != UPLOAD_ERR_NO_FILE
            ) {


                // =================================================
                // VERIFICAR ERROR DE SUBIDA
                // =================================================

                if ($_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {


                    // =================================================
                    // DATOS DE LA IMAGEN
                    // =================================================

                    $target_dir = "../PRODUCTO-img/";


                    // =================================================
                    // OBTENER EXTENSIÓN
                    // =================================================

                    $imageFileType = strtolower(
                        pathinfo(
                            $_FILES["fileToUpload"]["name"],
                            PATHINFO_EXTENSION
                        )
                    );


                    // =================================================
                    // EXTENSIONES PERMITIDAS
                    // =================================================

                    $extensionesPermitidas = [
                        "jpg",
                        "jpeg",
                        "png",
                        "gif",
                        "webp"
                    ];


                    // =================================================
                    // VERIFICAR FORMATO
                    // =================================================

                    if (
                        in_array(
                            $imageFileType,
                            $extensionesPermitidas
                        )
                    ) {


                        // =================================================
                        // NOMBRE DE LA IMAGEN
                        // =================================================

                        $newFileName =
                            "P-" .
                            $codigo .
                            "." .
                            $imageFileType;


                        $target_file =
                            $target_dir .
                            $newFileName;


                        // =================================================
                        // VERIFICAR SI YA EXISTE
                        // =================================================

                        if (file_exists($target_file)) {

                            $imagenGuardada = false;

                            $detalleMensaje =
                                "El producto fue registrado, pero la imagen no se pudo guardar porque ya existe una imagen registrada con este código.";

                        } else {


                            // =================================================
                            // SUBIR IMAGEN
                            // =================================================

                            if (
                                move_uploaded_file(
                                    $_FILES["fileToUpload"]["tmp_name"],
                                    $target_file
                                )
                            ) {

                                $imagenGuardada = true;

                            } else {

                                $imagenGuardada = false;

                                $detalleMensaje =
                                    "El producto fue registrado, pero no se pudo guardar la imagen.";

                            }

                        }


                    } else {


                        // =================================================
                        // FORMATO NO COMPATIBLE
                        // =================================================

                        $imagenGuardada = false;

                        $detalleMensaje =
                            "La imagen no se pudo guardar porque el formato no es compatible. Solo se permiten JPG, JPEG, PNG, GIF o WEBP.";

                    }


                } else {


                    // =================================================
                    // ERROR AL SUBIR LA IMAGEN
                    // =================================================

                    $imagenGuardada = false;

                    $detalleMensaje =
                        "El producto fue registrado, pero la imagen no se pudo guardar correctamente.";

                }


            } else {


                // =================================================
                // NO SE SELECCIONÓ IMAGEN
                // =================================================

                $imagenGuardada = false;

                $detalleMensaje =
                    "El producto fue registrado correctamente, pero no se añadió ninguna imagen.";

            }


            // =================================================
            // DETERMINAR MENSAJE FINAL
            // =================================================

            if ($imagenGuardada === true) {

                $tipoMensaje = "exito-completo";

                $mensaje =
                    "PRODUCTO E IMAGEN REGISTRADOS EXITOSAMENTE";

                $detalleMensaje =
                    "El producto y su imagen fueron guardados correctamente en DIVINE.";

            } else {

                /*
                 * IMPORTANTE:
                 * EL PRODUCTO SÍ FUE GUARDADO.
                 * SOLO LA IMAGEN TUVO UN PROBLEMA.
                 */

                $tipoMensaje = "exito-parcial";

            }


        } else {


            // =================================================
            // ERROR AL GUARDAR PRODUCTO
            // =================================================

            $tipoMensaje = "error";

            $mensaje =
                "NO SE PUDO GUARDAR EL PRODUCTO";

            $detalleMensaje =
                "Ocurrió un problema al registrar el producto en la base de datos.";

        }


        $stmt->close();


    } else {


        // =================================================
        // ERROR AL PREPARAR CONSULTA
        // =================================================

        $tipoMensaje = "error";

        $mensaje =
            "NO SE PUDO GUARDAR EL PRODUCTO";

        $detalleMensaje =
            "Ocurrió un problema al procesar la información.";

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

<title>Guardar Producto - DIVINE</title>


<!-- =====================================================
     TIPOGRAFÍAS
     ===================================================== -->

<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* =====================================================
   CONFIGURACIÓN GENERAL
   ===================================================== */

*{

    margin:0;

    padding:0;

    box-sizing:border-box;

}


body{

    font-family:'Poppins',sans-serif;

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    padding:40px 15px;

    color:#63364b;

    background:

        linear-gradient(
            rgba(0,0,0,.20),
            rgba(0,0,0,.20)
        ),

        url('../imagenes/fondote.png');

    background-size:cover;

    background-position:center;

    background-repeat:no-repeat;

}


/* =====================================================
   CONTENEDOR
   ===================================================== */

.contenedor{

    width:92%;

    max-width:700px;

    background:rgba(255,212,234,.92);

    backdrop-filter:blur(10px);

    -webkit-backdrop-filter:blur(10px);

    padding:40px;

    border-radius:28px;

    box-shadow:

        0 20px 50px rgba(0,0,0,.25);

    border:

        1px solid rgba(255,255,255,.7);

    display:grid;

    grid-template-columns:1fr;

    grid-template-areas:

        "encabezado"

        "contenido"

        "botones";

    gap:25px;

    text-align:center;

}


/* =====================================================
   ENCABEZADO
   ===================================================== */

.encabezado{

    grid-area:encabezado;

    font-family:"Playfair Display",serif;

    font-size:38px;

    font-weight:700;

    color:#493148;

    letter-spacing:3px;

    text-transform:uppercase;

    border-bottom:3px solid #fc63af;

    padding-bottom:12px;

    width:fit-content;

    max-width:100%;

    margin:auto;

}


/* =====================================================
   CONTENIDO
   ===================================================== */

.contenido{

    grid-area:contenido;

    background:rgba(255,255,255,.80);

    border-radius:20px;

    padding:30px 25px;

    box-shadow:

        0 8px 20px rgba(0,0,0,.12);

}


/* =====================================================
   MENSAJE GENERAL
   ===================================================== */

.mensaje{

    border-radius:18px;

    padding:28px 20px;

    font-weight:500;

    font-family:'Poppins',sans-serif;

    animation:

        aparecer .5s ease;

}


/* =====================================================
   ICONO DEL MENSAJE
   ===================================================== */

.icono-mensaje{

    width:70px;

    height:70px;

    margin:0 auto 18px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:32px;

    font-weight:700;

}


/* =====================================================
   TÍTULO DEL MENSAJE
   ===================================================== */

.mensaje-titulo{

    font-size:23px;

    font-weight:700;

    margin-bottom:10px;

    letter-spacing:.5px;

}


/* =====================================================
   TEXTO PRINCIPAL
   ===================================================== */

.mensaje-texto{

    font-size:14px;

    line-height:1.7;

}


/* =====================================================
   DETALLE PEQUEÑO
   ===================================================== */

.mensaje-detalle{

    margin-top:12px;

    padding-top:12px;

    border-top:

        1px solid rgba(0,0,0,.10);

    font-size:12px;

    line-height:1.6;

    opacity:.85;

}


/* =====================================================
   ÉXITO COMPLETO
   ===================================================== */

.exito-completo{

    background:

        linear-gradient(
            135deg,
            #fff4f8,
            #fce0eb
        );

    color:#8e4565;

    border:

        1px solid #efb7ce;

    box-shadow:

        0 10px 25px rgba(197,109,153,.18);

}


.exito-completo .icono-mensaje{

    background:#c56d99;

    color:white;

    box-shadow:

        0 8px 20px rgba(197,109,153,.30);

}


/* =====================================================
   ÉXITO PARCIAL
   PRODUCTO SÍ SE GUARDÓ
   IMAGEN NO
   ===================================================== */

.exito-parcial{

    background:

        linear-gradient(
            135deg,
            #fff4f8,
            #fce0eb
        );

    color:#8e4565;

    border:

        1px solid #efb7ce;

    box-shadow:

        0 10px 25px rgba(197,109,153,.18);

}


.exito-parcial .icono-mensaje{

    background:#c56d99;

    color:white;

    box-shadow:

        0 8px 20px rgba(197,109,153,.30);

}


.exito-parcial .mensaje-detalle{

    color:#8b5b70;

}


/* =====================================================
   ERROR
   ===================================================== */

.error{

    background:

        linear-gradient(
            135deg,
            #fff4f4,
            #f9dddd
        );

    color:#8b4f6b;

    border:

        1px solid #e5b1b1;

    box-shadow:

        0 10px 25px rgba(139,79,107,.16);

}


.error .icono-mensaje{

    background:#a95c72;

    color:white;

    box-shadow:

        0 8px 20px rgba(139,79,107,.30);

}


/* =====================================================
   BOTONES
   ===================================================== */

.botones{

    grid-area:botones;

    display:flex;

    justify-content:center;

    gap:15px;

    flex-wrap:wrap;

}


.boton{

    text-decoration:none;

    background:#63364b;

    color:white;

    padding:13px 25px;

    border-radius:50px;

    font-family:'Poppins',sans-serif;

    font-weight:600;

    font-size:14px;

    box-shadow:

        0 7px 18px rgba(0,0,0,.20);

    transition:

        .3s ease;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    min-width:180px;

}


.boton:hover{

    background:#c56d99;

    color:white;

    transform:

        translateY(-3px);

    box-shadow:

        0 10px 22px rgba(197,109,153,.35);

}


/* =====================================================
   ANIMACIÓN
   ===================================================== */

@keyframes aparecer{

    from{

        opacity:0;

        transform:

            translateY(15px)
            scale(.97);

    }

    to{

        opacity:1;

        transform:

            translateY(0)
            scale(1);

    }

}


/* =====================================================
   RESPONSIVE TABLET
   ===================================================== */

@media(max-width:700px){

    body{

        padding:25px 12px;

        background-attachment:scroll;

    }


    .contenedor{

        width:100%;

        padding:28px 18px;

        border-radius:24px;

        gap:20px;

    }


    .encabezado{

        font-size:30px;

        letter-spacing:2px;

    }


    .contenido{

        padding:22px 15px;

    }


    .mensaje{

        padding:22px 15px;

    }


    .mensaje-titulo{

        font-size:19px;

    }


    .mensaje-texto{

        font-size:13px;

    }


    .mensaje-detalle{

        font-size:11px;

    }


    .botones{

        flex-direction:column;

        gap:12px;

    }


    .boton{

        width:100%;

        min-width:0;

        padding:13px 20px;

    }

}


/* =====================================================
   RESPONSIVE CELULARES PEQUEÑOS
   ===================================================== */

@media(max-width:400px){

    body{

        padding:15px 8px;

    }


    .contenedor{

        padding:22px 12px;

        border-radius:20px;

    }


    .encabezado{

        font-size:25px;

        letter-spacing:1.5px;

    }


    .contenido{

        padding:18px 10px;

    }


    .mensaje{

        padding:20px 12px;

        border-radius:15px;

    }


    .icono-mensaje{

        width:55px;

        height:55px;

        font-size:25px;

    }


    .mensaje-titulo{

        font-size:17px;

    }


    .mensaje-texto{

        font-size:12px;

    }


    .mensaje-detalle{

        font-size:10px;

    }


    .boton{

        font-size:13px;

        padding:12px 15px;

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
         CONTENIDO
         ================================================= -->

    <div class="contenido">


        <?php if ($tipoMensaje == "exito-completo") { ?>


            <!-- ==========================================
                 PRODUCTO + IMAGEN GUARDADOS
                 ========================================== -->

            <div class="mensaje exito-completo">


                <div class="icono-mensaje">

                    ✓

                </div>


                <div class="mensaje-titulo">

                    PRODUCTO E IMAGEN REGISTRADOS EXITOSAMENTE

                </div>


                <div class="mensaje-texto">

                    El producto y su imagen fueron guardados
                    correctamente en DIVINE.

                </div>


            </div>


        <?php } elseif ($tipoMensaje == "exito-parcial") { ?>


            <!-- ==========================================
                 PRODUCTO GUARDADO
                 IMAGEN NO GUARDADA
                 ========================================== -->

            <div class="mensaje exito-parcial">


                <div class="icono-mensaje">

                    ✓

                </div>


                <div class="mensaje-titulo">

                    PRODUCTO GUARDADO EXITOSAMENTE

                </div>


                <div class="mensaje-texto">

                    El producto fue registrado correctamente
                    en la base de datos.

                </div>


                <div class="mensaje-detalle">

                    <?php

                    echo htmlspecialchars(
                        $detalleMensaje,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>

                </div>


            </div>


        <?php } elseif ($tipoMensaje == "error") { ?>


            <!-- ==========================================
                 ERROR
                 ========================================== -->

            <div class="mensaje error">


                <div class="icono-mensaje">

                    ×

                </div>


                <div class="mensaje-titulo">

                    <?php

                    echo htmlspecialchars(
                        $mensaje,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>

                </div>


                <div class="mensaje-texto">

                    <?php

                    echo htmlspecialchars(
                        $detalleMensaje,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>

                </div>


            </div>


        <?php } ?>


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