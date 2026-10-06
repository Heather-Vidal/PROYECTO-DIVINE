
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

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>DIVINE | Cliente modificado</title>


<!-- =====================================================
     FUENTES
===================================================== -->

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap"
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
            rgba(67, 39, 51, .94),
            rgba(113, 70, 87, .84)
        ),
        url("../imagenes/dudu.png") center / cover fixed;

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 30px;

    color: #49313b;

}


/* =====================================================
   CONTENEDOR
===================================================== */

.contenedor {

    width: 100%;

    max-width: 650px;

    background: #fffaf8;

    border-radius: 24px;

    overflow: hidden;

    border: 1px solid rgba(221,181,173,.65);

    box-shadow:
        0 30px 80px rgba(29,17,23,.45);

    animation: entrada .7s ease;

}


/* =====================================================
   ENCABEZADO
===================================================== */

.encabezado {

    position: relative;

    background:
        linear-gradient(
            145deg,
            #6e4054,
            #8d596d
        );

    color: white;

    text-align: center;

    padding: 38px 30px 34px;

}


/* Línea decorativa superior */

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


/* pequeño título */

.mini-titulo {

    font-size: 10px;

    letter-spacing: 5px;

    text-transform: uppercase;

    color: #e5c5b9;

    margin-bottom: 8px;

}


/* título */

.titulo {

    font-family: "Cormorant Garamond", serif;

    font-size: 43px;

    font-weight: 600;

    letter-spacing: 1px;

}


/* subtítulo */

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

    text-align: center;

    background: #fffaf8;

}


/* =====================================================
   ICONO
===================================================== */

.icono-contenedor {

    width: 125px;

    height: 125px;

    margin: 0 auto 28px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        linear-gradient(
            145deg,
            #f8e8e7,
            #f0dadd
        );

    border: 1px solid #e2c4c6;

    box-shadow:
        0 0 0 10px rgba(216,173,181,.10),
        0 15px 35px rgba(93,55,69,.13);

    animation: flotar 3s ease-in-out infinite;

}


.icono {

    width: 88px;

    height: 88px;

    object-fit: contain;

    transition: .3s;

}


.icono-contenedor:hover .icono {

    transform: scale(1.07);

}


/* =====================================================
   ANIMACIÓN ICONO
===================================================== */

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

    margin-bottom: 23px;

}


.decoracion::before,
.decoracion::after {

    content: "";

    width: 48px;

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

    margin: 0 auto;

    padding: 22px 25px;

    border-radius: 15px;

    font-size: 13px;

    line-height: 1.7;

    letter-spacing: .2px;

    border: 1px solid;

    box-shadow:
        0 8px 25px rgba(76,43,55,.07);

    animation: mensaje .6s ease;

}


/* =====================================================
   ÉXITO
===================================================== */

.exito {

    background: #f2ebe8;

    color: #704b59;

    border-color: #ddc8c5;

}


.exito::first-letter {

    color: #9c6578;

}


/* =====================================================
   ERROR
===================================================== */

.error {

    background: #f8e9eb;

    color: #874c5d;

    border-color: #e4c4cb;

}


/* =====================================================
   TEXTO DESTACADO
===================================================== */

.mensaje strong {

    font-weight: 600;

}


/* =====================================================
   BOTONES
===================================================== */

.botones {

    padding: 25px 35px 30px;

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 13px;

    flex-wrap: wrap;

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

    gap: 8px;

    min-width: 205px;

    padding: 13px 25px;

    text-decoration: none;

    background:
        linear-gradient(
            135deg,
            #875066,
            #6e4054
        );

    color: #fff;

    border-radius: 30px;

    font-size: 10px;

    font-weight: 600;

    letter-spacing: 1px;

    text-transform: uppercase;

    box-shadow:
        0 8px 20px rgba(102,58,76,.20);

    transition: .3s ease;

}


.boton:hover {

    transform: translateY(-3px);

    background:
        linear-gradient(
            135deg,
            #9a6077,
            #7a475e
        );

    box-shadow:
        0 12px 25px rgba(102,58,76,.28);

}


/* Segundo botón */

.boton.secundario {

    background: #eadbdd;

    color: #75485a;

    border: 1px solid #dbc1c8;

    box-shadow: none;

}


.boton.secundario:hover {

    background: #e2cbd2;

    color: #5f3949;

    box-shadow:
        0 8px 18px rgba(102,58,76,.12);

}


/* =====================================================
   PIE
===================================================== */

.pie {

    background: #f8efed;

    text-align: center;

    padding: 0 20px 27px;

    color: #aa8790;

    font-family: "Cormorant Garamond", serif;

    font-size: 16px;

    font-style: italic;

}


/* =====================================================
   ANIMACIONES
===================================================== */

@keyframes entrada {

    from {

        opacity: 0;

        transform:
            translateY(30px)
            scale(.98);

    }

    to {

        opacity: 1;

        transform:
            translateY(0)
            scale(1);

    }

}


@keyframes mensaje {

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

        font-size: 36px;

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

        flex-direction: column;

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
            ¡Modificación realizada!
        </h1>


        <div class="subtitulo">
            Información del cliente actualizada
        </div>

    </div>



    <!-- =================================================
         CONTENIDO
    ================================================== -->

    <div class="contenido">


        <!-- ICONO -->

        <div class="icono-contenedor">

            <img
                src="https://cdn-icons-png.flaticon.com/512/3106/3106921.png"
                class="icono"
                alt="Modificación realizada"
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

            <strong>No se pudo conectar</strong>

            <br>

            Ocurrió un problema al conectar con la
            base de datos de DIVINE.

        </div>
    ";

} else {


    /* =================================================
       RECIBIR DATOS
    ================================================== */

    $CI = trim($_POST['CI'] ?? '');

    $nombre = trim($_POST['nombre'] ?? '');

    $direccion = trim($_POST['direccion'] ?? '');

    $celular = trim($_POST['celular'] ?? '');

    $rol = trim($_POST['rol'] ?? '');

    $estado = trim($_POST['estado'] ?? '');



    /* =================================================
       VALIDAR DATOS NUMÉRICOS
    ================================================== */

    if (
        $CI === ''
        ||
        !ctype_digit($CI)
        ||
        $celular === ''
        ||
        !ctype_digit($celular)
    ) {

        echo "
            <div class='mensaje error'>

                <strong>Datos incorrectos</strong>

                <br>

                El CI y el celular deben contener
                únicamente números.

            </div>
        ";

    } else {


        /* =============================================
           CONVERTIR A ENTEROS
        ============================================== */

        $CI = (int)$CI;

        $celular = (int)$celular;



        /* =============================================
           CONSULTA PREPARADA
        ============================================== */

        $sql = "
            UPDATE CLIENTE

            SET
                nombre=?,
                direccion=?,
                celular=?,
                rol=?,
                estado=?

            WHERE CI=?
        ";


        $stmt = $conn->prepare($sql);



        /* =============================================
           COMPROBAR PREPARACIÓN
        ============================================== */

        if (!$stmt) {

            echo "
                <div class='mensaje error'>

                    <strong>No se pudo modificar</strong>

                    <br>

                    No fue posible preparar la modificación
                    del cliente.

                </div>
            ";

        } else {


            /* =========================================
               ASIGNAR VARIABLES
            ========================================== */

            $stmt->bind_param(
                "ssissi",
                $nombre,
                $direccion,
                $celular,
                $rol,
                $estado,
                $CI
            );



            /* =========================================
               EJECUTAR
            ========================================== */

            if ($stmt->execute()) {


                if ($stmt->affected_rows > 0) {

                    echo "
                        <div class='mensaje exito'>

                            <strong>
                                Cliente modificado exitosamente
                            </strong>

                            <br>

                            La información del cliente
                            fue actualizada correctamente
                            en DIVINE.

                        </div>
                    ";

                } else {

                    echo "
                        <div class='mensaje exito'>

                            <strong>
                                Modificación procesada
                            </strong>

                            <br>

                            Los datos ya se encontraban
                            registrados de esa manera.

                        </div>
                    ";

                }


            } else {

                echo "
                    <div class='mensaje error'>

                        <strong>
                            No se pudo guardar
                        </strong>

                        <br>

                        Ocurrió un error al modificar
                        la información del cliente.

                    </div>
                ";

            }


            /* =========================================
               CERRAR STATEMENT
            ========================================== */

            $stmt->close();

        }

    }

}


/* =====================================================
   CERRAR CONEXIÓN
===================================================== */

$conn->close();

?>


    </div>



    <!-- =================================================
         BOTONES
    ================================================== -->

    <div class="botones">


        <a
            href="../admin.php"
            class="boton"
        >

            <span>←</span>

            Volver al perfil

        </a>


        <a
            href="readtodocliente.php"
            class="boton secundario"
        >

            Ver clientes

            <span>→</span>

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
