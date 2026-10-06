
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

if ($conn->connect_error) {
    die("Error de conexión.");
}


/* =====================================================
   OBTENER CI DEL CLIENTE
===================================================== */

$CI = $_GET['CI'] ?? '';

$CI = $conn->real_escape_string($CI);


/* =====================================================
   BUSCAR CLIENTE
===================================================== */

$sql = "SELECT * FROM CLIENTE WHERE CI='$CI'";

$resultado = $conn->query($sql);


if ($resultado && $resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $CI = $fila['CI'];

    $estado = $fila['estado'];

    $nombreCliente = $fila['nombre'];

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<title>DIVINE | Cliente</title>


<!-- =====================================================
     FUENTES
===================================================== -->

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap"
    rel="stylesheet"
>


<!-- =====================================================
     SWEET ALERT 2
===================================================== -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>

/* =====================================================
   GENERAL
===================================================== */

* {
    box-sizing: border-box;
}


body {

    margin: 0;

    min-height: 100vh;

    font-family: "Montserrat", sans-serif;

    background:
        linear-gradient(
            120deg,
            rgba(35,20,29,.92),
            rgba(82,43,57,.82)
        ),
        url("../imagenes/dudu.png") center/cover fixed;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 30px;

    color: #fff;

}


/* =====================================================
   CONTENEDOR
===================================================== */

.contenedor {

    width: 100%;

    max-width: 950px;

    min-height: 580px;

    display: grid;

    grid-template-columns: 35% 65%;

    background: rgba(42,25,34,.94);

    border: 1px solid rgba(220,176,144,.45);

    box-shadow:
        0 30px 80px rgba(0,0,0,.55);

    border-radius: 8px;

    overflow: hidden;

    position: relative;

}


/* =====================================================
   LADO IZQUIERDO
===================================================== */

.lado-izquierdo {

    background:
        linear-gradient(
            145deg,
            rgba(105,54,73,.95),
            rgba(45,26,36,.98)
        );

    display: flex;

    flex-direction: column;

    justify-content: center;

    align-items: center;

    text-align: center;

    padding: 45px 30px;

    border-right:
        1px solid rgba(218,170,136,.35);

}


.marca {

    font-family: "Cormorant Garamond", serif;

    font-size: 21px;

    letter-spacing: 8px;

    color: #dcb090;

    margin-bottom: 35px;

}


.imagen {

    width: 190px;

    height: 190px;

    border-radius: 50%;

    background:
        url("../imagenes/persona.png") center/contain no-repeat,
        linear-gradient(
            145deg,
            #b8758b,
            #5a3344
        );

    border: 1px solid #dcb090;

    box-shadow:
        0 0 0 10px rgba(220,176,144,.06),
        0 15px 40px rgba(0,0,0,.4);

    margin-bottom: 30px;

}


.frase {

    font-family: "Cormorant Garamond", serif;

    font-size: 22px;

    color: #ead6cb;

    line-height: 1.5;

}


.decoracion {

    width: 55px;

    height: 1px;

    background: #dcb090;

    margin: 20px auto;

}


/* =====================================================
   LADO DERECHO
===================================================== */

.lado-derecho {

    padding: 50px 55px;

    background: #fffaf8;

    color: #442b35;

}


.pequeno-titulo {

    color: #a36b7d;

    font-size: 11px;

    letter-spacing: 4px;

    text-transform: uppercase;

    margin-bottom: 8px;

}


.titulo {

    font-family: "Cormorant Garamond", serif;

    font-size: 46px;

    font-weight: 600;

    color: #472c38;

    margin: 0;

}


.linea {

    width: 70px;

    height: 2px;

    background: #b57a68;

    margin: 15px 0 35px;

}


/* =====================================================
   INFORMACIÓN
===================================================== */

.informacion {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 16px;

}


.item {

    background: #f8eeed;

    border: 1px solid #ead8d7;

    padding: 18px 20px;

    border-radius: 4px;

    transition: .3s;

}


.item:hover {

    transform: translateY(-3px);

    border-color: #c79691;

    box-shadow:
        0 8px 20px rgba(82,43,57,.10);

}


.etiqueta {

    display: block;

    color: #a36b7d;

    font-size: 10px;

    letter-spacing: 2px;

    text-transform: uppercase;

    margin-bottom: 7px;

}


.valor {

    color: #472c38;

    font-size: 14px;

    font-weight: 500;

    word-break: break-word;

}


/* =====================================================
   ESTADOS
===================================================== */

.estado {

    display: inline-block;

    padding: 5px 12px;

    border-radius: 2px;

    font-size: 10px;

    letter-spacing: 1px;

    font-weight: 600;

}


.activo {

    background: #dce9df;

    color: #45634e;

}


.inactivo {

    background: #ead5d8;

    color: #824b57;

}


/* =====================================================
   BOTONES
===================================================== */

.botones {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

    margin-top: 30px;

}


.boton {

    text-decoration: none;

    border: none;

    padding: 12px 19px;

    font-family: "Montserrat", sans-serif;

    font-size: 11px;

    letter-spacing: 1px;

    font-weight: 600;

    border-radius: 3px;

    cursor: pointer;

    transition: .3s;

}


.editar {

    background: #7d465b;

    color: white;

}


.editar:hover {

    background: #5f3044;

    transform: translateY(-2px);

}


.eliminar {

    background: #ead8d8;

    color: #743c49;

}


.eliminar:hover {

    background: #ddc0c2;

    transform: translateY(-2px);

}


.bloquear {

    background: #b2876d;

    color: white;

}


.bloquear:hover {

    background: #91684f;

    transform: translateY(-2px);

}


.desbloquear {

    background: #718875;

    color: white;

}


.desbloquear:hover {

    background: #536b58;

    transform: translateY(-2px);

}


/* =====================================================
   NAVEGACIÓN
===================================================== */

.navegacion {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-top: 30px;

    padding-top: 22px;

    border-top: 1px solid #ead8d7;

}


.boton2 {

    text-decoration: none;

    color: #8b596b;

    font-size: 11px;

    letter-spacing: 1px;

    transition: .3s;

}


.boton2:hover {

    color: #472c38;

}


/* =====================================================
   SWEET ALERT DIVINE
===================================================== */

.swal2-popup {

    width: 430px !important;

    border-radius: 24px !important;

    background: #fffaf9 !important;

    border: 1px solid #ead1d8 !important;

    box-shadow:
        0 25px 70px rgba(70,35,49,.28) !important;

    padding: 30px 30px 25px !important;

}


.swal2-title {

    font-family:
        "Cormorant Garamond",
        serif !important;

    color: #4d2c39 !important;

    font-size: 32px !important;

    font-weight: 600 !important;

    margin-top: 5px !important;

}


.swal2-html-container {

    font-family:
        "Montserrat",
        sans-serif !important;

    color: #765b66 !important;

    font-size: 13px !important;

    line-height: 1.7 !important;

}


/* =====================================================
   ICONO
===================================================== */

.swal2-icon.swal2-warning {

    border-color: #d58ca3 !important;

    color: #b85d7b !important;

}


.swal2-icon.swal2-question {

    border-color: #c98aa0 !important;

    color: #a75b76 !important;

}


/* =====================================================
   BOTÓN CONFIRMAR
===================================================== */

.swal2-confirm {

    background:
        linear-gradient(
            135deg,
            #c16b88,
            #984f6c
        ) !important;

    color: #fff !important;

    border: none !important;

    border-radius: 12px !important;

    padding: 12px 23px !important;

    font-family:
        "Montserrat",
        sans-serif !important;

    font-size: 11px !important;

    font-weight: 600 !important;

    letter-spacing: .5px !important;

    box-shadow:
        0 7px 18px rgba(152,79,108,.25) !important;

}


.swal2-confirm:hover {

    background:
        linear-gradient(
            135deg,
            #ad5a78,
            #843f5b
        ) !important;

}


/* =====================================================
   BOTÓN CANCELAR
===================================================== */

.swal2-cancel {

    background: #f1e1e5 !important;

    color: #75485a !important;

    border: none !important;

    border-radius: 12px !important;

    padding: 12px 23px !important;

    font-family:
        "Montserrat",
        sans-serif !important;

    font-size: 11px !important;

    font-weight: 600 !important;

    letter-spacing: .5px !important;

}


.swal2-cancel:hover {

    background: #e8d1d8 !important;

}


/* =====================================================
   ESPACIADO BOTONES SWEET ALERT
===================================================== */

.swal2-actions {

    gap: 10px !important;

    margin-top: 20px !important;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width:750px) {

    .contenedor {

        grid-template-columns: 1fr;

    }


    .lado-izquierdo {

        padding: 35px 20px;

    }


    .imagen {

        width: 140px;

        height: 140px;

    }


    .lado-derecho {

        padding: 35px 25px;

    }


    .titulo {

        font-size: 38px;

    }

}


@media (max-width:500px) {

    body {

        padding: 15px;

    }


    .informacion {

        grid-template-columns: 1fr;

    }


    .boton {

        flex: 1;

        text-align: center;

    }


    .navegacion {

        flex-direction: column;

        gap: 15px;

    }


    .swal2-popup {

        width: calc(100% - 30px) !important;

        padding: 25px 20px !important;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =================================================
         LADO IZQUIERDO
    ================================================== -->

    <div class="lado-izquierdo">


        <div class="marca">
            DIVINE
        </div>


        <div class="imagen"></div>


        <div class="decoracion"></div>


        <div class="frase">
            "Elegancia en cada detalle."
        </div>


    </div>



    <!-- =================================================
         LADO DERECHO
    ================================================== -->

    <div class="lado-derecho">


        <div class="pequeno-titulo">
            Perfil del cliente
        </div>


        <h1 class="titulo">
            Información
        </h1>


        <div class="linea"></div>



        <div class="informacion">


            <!-- IDENTIFICACIÓN -->

            <div class="item">

                <span class="etiqueta">
                    Identificación
                </span>

                <span class="valor">
                    <?php
                    echo htmlspecialchars(
                        $fila['CI'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>



            <!-- NOMBRE -->

            <div class="item">

                <span class="etiqueta">
                    Nombre completo
                </span>

                <span class="valor">
                    <?php
                    echo htmlspecialchars(
                        $fila['nombre'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>



            <!-- DIRECCIÓN -->

            <div class="item">

                <span class="etiqueta">
                    Dirección
                </span>

                <span class="valor">
                    <?php
                    echo htmlspecialchars(
                        $fila['direccion'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>



            <!-- TELÉFONO -->

            <div class="item">

                <span class="etiqueta">
                    Teléfono
                </span>

                <span class="valor">
                    <?php
                    echo htmlspecialchars(
                        $fila['celular'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>



            <!-- ROL -->

            <div class="item">

                <span class="etiqueta">
                    Rol
                </span>

                <span class="valor">
                    <?php
                    echo htmlspecialchars(
                        $fila['rol'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </span>

            </div>



            <!-- ESTADO -->

            <div class="item">

                <span class="etiqueta">
                    Estado
                </span>


                <?php if ($estado == 'ACTIVO') { ?>

                    <span class="estado activo">
                        ACTIVO
                    </span>

                <?php } else { ?>

                    <span class="estado inactivo">

                        <?php
                        echo htmlspecialchars(
                            $estado,
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </span>

                <?php } ?>


            </div>


        </div>



        <!-- =================================================
             BOTONES
        ================================================== -->

        <div class="botones">


            <!-- EDITAR -->

            <a
                class="boton editar"
                href="updateformcliente.php?CI=<?php echo urlencode($CI); ?>"
            >
                EDITAR
            </a>



            <!-- ELIMINAR -->

            <a
                class="boton eliminar"
                href="deletecliente.php?CI=<?php echo urlencode($CI); ?>"
                onclick="confirmarEliminar(event, this.href);"
            >
                ELIMINAR
            </a>



            <?php if ($estado == 'ACTIVO') { ?>


                <!-- =========================================
                     BLOQUEAR
                ========================================== -->

                <a
                    class="boton bloquear"
                    href="../BLOQUEOS-usuario/bloquear.php?CI=<?php echo urlencode($CI); ?>"
                    onclick="confirmarBloquear(event, this.href);"
                >
                    BLOQUEAR
                </a>


            <?php } else { ?>


                <!-- =========================================
                     DESBLOQUEAR
                ========================================== -->

                <a
                    class="boton desbloquear"
                    href="../BLOQUEOS-usuario/desbloquear.php?CI=<?php echo urlencode($CI); ?>"
                    onclick="confirmarDesbloquear(event, this.href);"
                >
                    DESBLOQUEAR
                </a>


            <?php } ?>


        </div>



        <!-- =================================================
             VOLVER
        ================================================== -->

        <div class="navegacion">

            <a
                class="boton2"
                href="readtodocliente.php"
            >
                ← VER TODOS LOS CLIENTES
            </a>

        </div>


    </div>

</div>



<script>

/* =====================================================
   NOMBRE DEL CLIENTE
===================================================== */

const nombreCliente = <?php
echo json_encode(
    $nombreCliente,
    JSON_UNESCAPED_UNICODE |
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_QUOT |
    JSON_HEX_AMP
);
?>;


/* =====================================================
   ELIMINAR
===================================================== */

function confirmarEliminar(event, url) {

    event.preventDefault();

    Swal.fire({

        icon: "warning",

        iconColor: "#c46884",

        title: "¿Eliminar cliente?",

        html:
            "¿Estás segura de que quieres eliminar a<br>" +
            "<strong style='color:#a65370;'>" +
            nombreCliente +
            "</strong>?" +
            "<br><br>" +
            "<span style='font-size:12px;color:#987782;'>" +
            "Esta acción no se puede deshacer." +
            "</span>",

        showCancelButton: true,

        confirmButtonText: "Sí, eliminar",

        cancelButtonText: "Cancelar",

        reverseButtons: true,

        allowOutsideClick: false,

        buttonsStyling: true

    }).then((resultado) => {

        if (resultado.isConfirmed) {

            window.location.href = url;

        }

    });

}


/* =====================================================
   BLOQUEAR
===================================================== */

function confirmarBloquear(event, url) {

    event.preventDefault();

    Swal.fire({

        icon: "warning",

        iconColor: "#c98269",

        title: "¿Bloquear cliente?",

        html:
            "¿Estás segura de que quieres bloquear a<br>" +
            "<strong style='color:#a65370;'>" +
            nombreCliente +
            "</strong>?" +
            "<br><br>" +
            "<span style='font-size:12px;color:#987782;'>" +
            "El cliente quedará bloqueado y no podrá utilizar su cuenta." +
            "</span>",

        showCancelButton: true,

        confirmButtonText: "Sí, bloquear",

        cancelButtonText: "Cancelar",

        reverseButtons: true,

        allowOutsideClick: false,

        buttonsStyling: true

    }).then((resultado) => {

        if (resultado.isConfirmed) {

            window.location.href = url;

        }

    });

}


/* =====================================================
   DESBLOQUEAR
===================================================== */

function confirmarDesbloquear(event, url) {

    event.preventDefault();

    Swal.fire({

        icon: "question",

        iconColor: "#b15f7b",

        title: "¿Desbloquear cliente?",

        html:
            "¿Estás segura de que quieres desbloquear a<br>" +
            "<strong style='color:#a65370;'>" +
            nombreCliente +
            "</strong>?" +
            "<br><br>" +
            "<span style='font-size:12px;color:#987782;'>" +
            "El cliente podrá volver a utilizar su cuenta." +
            "</span>",

        showCancelButton: true,

        confirmButtonText: "Sí, desbloquear",

        cancelButtonText: "Cancelar",

        reverseButtons: true,

        allowOutsideClick: false,

        buttonsStyling: true

    }).then((resultado) => {

        if (resultado.isConfirmed) {

            window.location.href = url;

        }

    });

}

</script>


</body>

</html>


<?php

} else {

    echo "Cliente no encontrado.";

}

$conn->close();

?>
