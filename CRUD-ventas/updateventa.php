<?php

// ==================================================
// CONEXIÓN
// ==================================================

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


// ==================================================
// COMPROBAR CONEXIÓN
// ==================================================

if ($conn->connect_error) {

    echo '<div class="mensaje error">
            ❌ NO TE PUDISTE CONECTAR CON LA BD UnU
          </div>';

}


// ==================================================
// RECIBIR DATOS DEL FORMULARIO
// ==================================================

$id = $_POST['id'];

$estado = $_POST['estado'];

$metodo = $_POST['metodo'];


// ==================================================
// ACTUALIZAR VENTA
// ==================================================

$sql = "

    UPDATE VENTAS

    SET

        estado='$estado',

        metodo='$metodo'

    WHERE id=$id

";


// ==================================================
// EJECUTAR ACTUALIZACIÓN
// ==================================================

if ($conn->query($sql) === TRUE) {

    $mensaje = "VENTA ACTUALIZADA EXITOSAMENTE";

    $tipo = "exito";

} else {

    $mensaje = "ERROR AL ACTUALIZAR LA VENTA";

    $tipo = "error";

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

<title>
    Actualización de Venta · DIVINE
</title>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
    rel="stylesheet"
>


<style>

/* ==================================================
   CUERPO
   ================================================== */

body {

    margin:0;

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    font-family:
        'Poppins',
        sans-serif;

    background:

        linear-gradient(
            135deg,
            #fff7f9,
            #f8dfe7
        );

    color:#4b3b41;

}


/* ==================================================
   CONTENEDOR
   ================================================== */

.contenedor {

    width:90%;

    max-width:700px;

    padding:40px;

    background:
        rgba(255,255,255,.96);

    border-radius:30px;

    border:
        1px solid #efd6de;

    box-shadow:

        0 20px 50px
        rgba(166,91,111,.18);

}


/* ==================================================
   ENCABEZADO
   ================================================== */

.encabezado {

    text-align:center;

    font-family:
        'Playfair Display',
        serif;

    font-size:35px;

    font-weight:700;

    letter-spacing:3px;

    color:#a75c70;

    padding-bottom:15px;

    margin-bottom:25px;

    border-bottom:
        3px solid #dfa3b3;

}


/* ==================================================
   CONTENIDO
   ================================================== */

.contenido {

    background:#fff8fa;

    border:
        1px solid #f0dbe1;

    border-radius:22px;

    padding:30px;

    text-align:center;

}


/* ==================================================
   MENSAJE
   ================================================== */

.mensaje {

    border-radius:18px;

    padding:25px;

    font-weight:600;

    margin-bottom:25px;

    font-size:18px;

}


/* ==================================================
   ÉXITO
   ================================================== */

.exito {

    background:#f3dce3;

    color:#98576b;

    border:
        1px solid #e4b9c5;

    box-shadow:

        0 8px 20px
        rgba(167,92,112,.12);

}


/* ==================================================
   ERROR
   ================================================== */

.error {

    background:#f8dddd;

    color:#a34e55;

    border:
        1px solid #edb9bd;

    box-shadow:

        0 8px 20px
        rgba(163,78,85,.12);

}


/* ==================================================
   BOTONES
   ================================================== */

.botones {

    display:flex;

    justify-content:center;

    gap:15px;

    flex-wrap:wrap;

}


/* ==================================================
   BOTÓN
   ================================================== */

.boton {

    text-decoration:none;

    background:#a75c70;

    color:white;

    padding:13px 27px;

    border-radius:30px;

    font-weight:600;

    font-size:14px;

    transition:.3s ease;

    box-shadow:

        0 7px 18px
        rgba(167,92,112,.20);

}


/* ==================================================
   HOVER
   ================================================== */

.boton:hover {

    background:#c9788d;

    transform:
        translateY(-3px);

    box-shadow:

        0 10px 23px
        rgba(167,92,112,.28);

}


/* ==================================================
   RESPONSIVE
   ================================================== */

@media(max-width:600px) {

    .contenedor {

        padding:25px;

    }


    .contenido {

        padding:22px;

    }


    .encabezado {

        font-size:28px;

    }


    .botones {

        flex-direction:column;

    }


    .boton {

        width:auto;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- ==================================================
         ENCABEZADO
         ================================================== -->

    <div class="encabezado">

        DIVINE

    </div>


    <!-- ==================================================
         CONTENIDO
         ================================================== -->

    <div class="contenido">


        <?php

        if ($tipo == "exito") {

        ?>

            <div class="mensaje exito">

                ✔

                <?php

                echo htmlspecialchars(
                    $mensaje
                );

                ?>

            </div>

        <?php

        } else {

        ?>

            <div class="mensaje error">

                ⚠

                <?php

                echo htmlspecialchars(
                    $mensaje
                );

                ?>

            </div>

        <?php

        }


        ?>


        <!-- ==================================================
             BOTONES
             ================================================== -->

        <div class="botones">


            <a
                href="readtodoventa.php"
                class="boton"
            >

                 ⬅  Volver a ventas

            </a>


        </div>


    </div>


</div>


</body>

</html>


<?php

$conn->close();

?>