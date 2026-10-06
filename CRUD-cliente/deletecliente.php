
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

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>DIVINE | Cliente eliminado</title>


<!-- =====================================================
     FUENTES
===================================================== -->

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;500;600&display=swap"
    rel="stylesheet"
>


<style>

/* =====================================================
   RESET
===================================================== */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

}


/* =====================================================
   BODY
===================================================== */

body {

    min-height: 100vh;

    font-family: "Montserrat", sans-serif;

    background:
        linear-gradient(
            135deg,
            rgba(68, 39, 51, .92),
            rgba(112, 70, 87, .82)
        ),
        url("../imagenes/dudu.png") center / cover fixed;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 30px;

    color: #49313b;

}


/* =====================================================
   CONTENEDOR PRINCIPAL
===================================================== */

.contenedor {

    width: 100%;

    max-width: 650px;

    background: #fffaf8;

    border-radius: 24px;

    overflow: hidden;

    border: 1px solid rgba(221, 181, 173, .65);

    box-shadow:
        0 30px 80px rgba(29, 17, 23, .42);

    animation: aparecer .7s ease;

}


/* =====================================================
   ENCABEZADO
===================================================== */

.encabezado {

    position: relative;

    padding: 38px 30px 34px;

    text-align: center;

    background:
        linear-gradient(
            145deg,
            #6e4054,
            #8c596c
        );

    color: #fff;

}


/* detalle superior */

.encabezado::before {

    content: "";

    position: absolute;

    top: 18px;

    left: 50%;

    transform: translateX(-50%);

    width: 45px;

    height: 1px;

    background: #dfb89f;

}


.mini-titulo {

    font-size: 10px;

    letter-spacing: 5px;

    text-transform: uppercase;

    color: #e6c7ba;

    margin-bottom: 8px;

}


.titulo {

    font-family: "Cormorant Garamond", serif;

    font-size: 42px;

    font-weight: 600;

    letter-spacing: 1px;

    margin: 0;

}


.subtitulo {

    margin-top: 8px;

    font-size: 12px;

    font-weight: 300;

    letter-spacing: 1px;

    color: #f3e5e0;

}


/* =====================================================
   CONTENIDO
===================================================== */

.contenido {

    padding: 48px 45px 42px;

    display: flex;

    flex-direction: column;

    align-items: center;

    text-align: center;

    background: #fffaf8;

}


/* =====================================================
   ICONO
===================================================== */

.icono-contenedor {

    width: 125px;

    height: 125px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        linear-gradient(
            145deg,
            #f8e8e7,
            #f1d9dc
        );

    border: 1px solid #e4c4c6;

    box-shadow:
        0 0 0 10px rgba(216, 173, 181, .10),
        0 15px 30px rgba(93, 55, 69, .12);

    margin-bottom: 28px;

    animation: flotar 3s ease-in-out infinite;

}


.icono {

    width: 88px;

    height: 88px;

    object-fit: contain;

}


@keyframes flotar {

    0%,
    100% {

        transform: translateY(0);

    }

    50% {

        transform: translateY(-5px);

    }

}


/* =====================================================
   DECORACIÓN
===================================================== */

.decoracion {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    margin-bottom: 22px;

}


.decoracion::before,
.decoracion::after {

    content: "";

    width: 45px;

    height: 1px;

    background: #d5a98f;

}


.decoracion span {

    color: #b8788e;

    font-size: 13px;

}


/* =====================================================
   MENSAJE
===================================================== */

.mensaje {

    width: 100%;

    max-width: 480px;

    padding: 21px 25px;

    border-radius: 14px;

    font-size: 13px;

    line-height: 1.7;

    letter-spacing: .3px;

    border: 1px solid;

    box-shadow:
        0 8px 25px rgba(76, 43, 55, .07);

    animation: mensajeEntrada .6s ease;

}


/* ÉXITO */

.exito {

    background: #f4ebe8;

    color: #704b59;

    border-color: #dfc9c7;

}


/* ERROR */

.error {

    background: #f8e9eb;

    color: #874c5d;

    border-color: #e4c4cb;

}


.mensaje strong {

    font-weight: 600;

}


/* =====================================================
   PARTE INFERIOR
===================================================== */

.botones {

    padding: 25px 35px 30px;

    display: flex;

    justify-content: center;

    background: #f8efed;

    border-top: 1px solid #eadbd8;

}


/* =====================================================
   BOTÓN
===================================================== */

.boton {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    min-width: 220px;

    padding: 13px 27px;

    text-decoration: none;

    background:
        linear-gradient(
            135deg,
            #875066,
            #6e4054
        );

    color: #fff;

    border-radius: 30px;

    font-size: 11px;

    font-weight: 600;

    letter-spacing: 1px;

    text-transform: uppercase;

    box-shadow:
        0 8px 20px rgba(102, 58, 76, .20);

    transition: .3s ease;

}


.boton:hover {

    transform: translateY(-3px);

    background:
        linear-gradient(
            135deg,
            #9b6077,
            #7a475e
        );

    box-shadow:
        0 12px 25px rgba(102, 58, 76, .28);

}


/* =====================================================
   PIE DECORATIVO
===================================================== */

.pie {

    text-align: center;

    padding: 0 20px 27px;

    background: #f8efed;

    color: #aa8790;

    font-family: "Cormorant Garamond", serif;

    font-size: 16px;

    font-style: italic;

}


/* =====================================================
   ANIMACIONES
===================================================== */

@keyframes aparecer {

    from {

        opacity: 0;

        transform: translateY(30px) scale(.98);

    }

    to {

        opacity: 1;

        transform: translateY(0) scale(1);

    }

}


@keyframes mensajeEntrada {

    from {

        opacity: 0;

        transform: translateY(10px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 600px) {

    body {

        padding: 15px;

    }


    .contenedor {

        border-radius: 20px;

    }


    .encabezado {

        padding: 32px 20px 30px;

    }


    .titulo {

        font-size: 35px;

    }


    .contenido {

        padding: 38px 22px 35px;

    }


    .icono-contenedor {

        width: 110px;

        height: 110px;

    }


    .icono {

        width: 76px;

        height: 76px;

    }


    .botones {

        padding: 22px 20px 25px;

    }


    .boton {

        width: 100%;

        min-width: 0;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =================================================
         ENCABEZADO
    ================================================== -->

    <div class="encabezado">

        <div class="mini-titulo">
            DIVINE · CLIENTES
        </div>

        <h1 class="titulo">
            Cliente eliminado
        </h1>

        <div class="subtitulo">
            Gestión de clientes
        </div>

    </div>



    <!-- =================================================
         CONTENIDO
    ================================================== -->

    <div class="contenido">


        <!-- ICONO -->

        <div class="icono-contenedor">

            <img
                src="../imagenes/personaform.png"
                class="icono"
                alt="Cliente"
            >

        </div>



        <!-- DECORACIÓN -->

        <div class="decoracion">

            <span>✦</span>

        </div>



<?php

/* =====================================================
   VERIFICAR CONEXIÓN
===================================================== */

if ($conn->connect_error) {

    echo "
        <div class='mensaje error'>
            <strong>Ocurrió un error</strong><br>
            No fue posible conectar con la base de datos.
        </div>
    ";

} else {


    /* =================================================
       OBTENER CI
    ================================================= */

    $CI = $_GET['CI'] ?? '';


    if ($CI !== '') {


        /* =============================================
           VALIDAR CI
        ============================================= */

        $CI = $conn->real_escape_string($CI);


        /* =============================================
           ELIMINAR CLIENTE
        ============================================= */

        $sql = "DELETE FROM CLIENTE WHERE CI='$CI'";


        if ($conn->query($sql) === TRUE) {

            if ($conn->affected_rows > 0) {

                echo "
                    <div class='mensaje exito'>
                        <strong>Cliente eliminado correctamente</strong>
                        <br>
                        El cliente ha sido eliminado del sistema DIVINE.
                    </div>
                ";

            } else {

                echo "
                    <div class='mensaje error'>
                        <strong>Cliente no encontrado</strong>
                        <br>
                        No se encontró ningún cliente con ese número de identificación.
                    </div>
                ";

            }


        } else {

            echo "
                <div class='mensaje error'>
                    <strong>No se pudo eliminar el cliente</strong>
                    <br>
                    Ocurrió un error al realizar la operación.
                </div>
            ";

        }


    } else {

        echo "
            <div class='mensaje error'>
                <strong>CI no especificado</strong>
                <br>
                No se recibió la identificación del cliente.
            </div>
        ";

    }

}


/* =====================================================
   CERRAR CONEXIÓN
===================================================== */

$conn->close();

?>


    </div>



    <!-- =================================================
         BOTÓN VOLVER
    ================================================== -->

    <div class="botones">

        <a
            href="readtodocliente.php"
            class="boton"
        >
            <span>←</span>
            Volver a clientes
        </a>

    </div>



    <!-- =================================================
         PIE
    ================================================== -->

    <div class="pie">

        "Elegancia en cada detalle."

    </div>


</div>


</body>

</html>