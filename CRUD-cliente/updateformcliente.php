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
    die("Ocurrió un error de conexión");
}

$CI = $_GET['CI'] ?? '';

$stmt = $conn->prepare("SELECT * FROM CLIENTE WHERE CI = ?");
$stmt->bind_param("s", $CI);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $CI = $fila['CI'];
    $nombre = $fila['nombre'];
    $direccion = $fila['direccion'];
    $celular = $fila['celular'];
    $rol = $fila['rol'];
    $estado = $fila['estado'];

} else {

    die("Cliente no encontrado");

}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Editar Cliente | DIVINE</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =====================================================
   GENERAL
===================================================== */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {

    min-height: 100vh;

    font-family: "DM Sans", sans-serif;

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(226, 175, 192, .30),
            transparent 28%
        ),

        radial-gradient(
            circle at 90% 90%,
            rgba(201, 151, 171, .20),
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #fffafa,
            #f8edf2,
            #fff7f9
        );

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 35px 18px;

    color: #58434d;

}


/* =====================================================
   CONTENEDOR
===================================================== */

.contenedor {

    width: 100%;

    max-width: 900px;

    background:
        rgba(255,255,255,.88);

    border:
        1px solid rgba(255,255,255,.95);

    border-radius: 30px;

    box-shadow:
        0 25px 70px
        rgba(120,70,92,.15);

    backdrop-filter: blur(15px);

    overflow: hidden;

    display: grid;

    grid-template-columns: 35% 65%;

}


/* =====================================================
   PANEL IZQUIERDO
===================================================== */

.lateral {

    position: relative;

    min-height: 650px;

    padding: 45px 30px;

    background:
        linear-gradient(
            160deg,
            #63384d,
            #87536a 55%,
            #a86d83
        );

    color: white;

    display: flex;

    flex-direction: column;

    justify-content: center;

    align-items: center;

    text-align: center;

    overflow: hidden;

}


/* círculos decorativos */

.lateral::before {

    content: "";

    position: absolute;

    width: 260px;

    height: 260px;

    border:
        1px solid
        rgba(255,255,255,.12);

    border-radius: 50%;

    top: -100px;

    left: -100px;

}


.lateral::after {

    content: "";

    position: absolute;

    width: 300px;

    height: 300px;

    border:
        1px solid
        rgba(255,255,255,.10);

    border-radius: 50%;

    bottom: -150px;

    right: -140px;

}


/* =====================================================
   LOGO
===================================================== */

.logo {

    width: 82px;

    height: 82px;

    border-radius: 50%;

    display: flex;

    justify-content: center;

    align-items: center;

    background:
        rgba(255,255,255,.13);

    border:
        1px solid
        rgba(255,255,255,.35);

    font-family:
        "Playfair Display",
        serif;

    font-size: 42px;

    margin-bottom: 25px;

    position: relative;

    z-index: 2;

    box-shadow:
        0 12px 30px
        rgba(0,0,0,.12);

}


.lateral h1 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 38px;

    letter-spacing: 3px;

    font-weight: 600;

    position: relative;

    z-index: 2;

}


.lateral .subtitulo {

    margin-top: 8px;

    color: #efd8e1;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: 3px;

    position: relative;

    z-index: 2;

}


.decoracion {

    margin-top: 35px;

    font-size: 25px;

    color: #e9bdcd;

    letter-spacing: 12px;

    position: relative;

    z-index: 2;

}


.mensaje {

    margin-top: 25px;

    max-width: 230px;

    color: #ead9df;

    font-size: 13px;

    line-height: 1.7;

    position: relative;

    z-index: 2;

}


/* =====================================================
   FORMULARIO
===================================================== */

.formulario {

    padding: 45px 45px 40px;

}


.encabezado {

    margin-bottom: 28px;

}


.etiqueta {

    color: #b27a91;

    font-size: 10px;

    font-weight: 600;

    letter-spacing: 3px;

    text-transform: uppercase;

}


.encabezado h2 {

    margin-top: 6px;

    color: #63384d;

    font-family:
        "Playfair Display",
        serif;

    font-size: 36px;

    font-weight: 600;

}


.encabezado p {

    margin-top: 7px;

    color: #a28f98;

    font-size: 13px;

}


/* =====================================================
   CAMPOS
===================================================== */

.grupo-campos {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;

}


.campo {

    display: flex;

    flex-direction: column;

    gap: 7px;

}


.campo.completo {

    grid-column: 1 / -1;

}


.campo label {

    color: #684c5a;

    font-size: 12px;

    font-weight: 600;

}


.campo input {

    width: 100%;

    height: 47px;

    padding: 0 15px;

    border:
        1px solid #ead5dd;

    border-radius: 13px;

    background: #fffafd;

    color: #58434d;

    font-family: "DM Sans", sans-serif;

    font-size: 13px;

    outline: none;

    transition: .25s ease;

}


.campo input:hover {

    border-color: #d7adbd;

}


.campo input:focus {

    border-color: #a96a83;

    background: white;

    box-shadow:
        0 0 0 4px
        rgba(169,106,131,.10);

}


/* CI */

.campo input[name="CI"] {

    background: #f7f0f3;

    color: #8d7781;

}


/* =====================================================
   ERROR
===================================================== */

label.error {

    color: #c35e70 !important;

    font-size: 10px !important;

    font-weight: 400 !important;

    margin-top: -2px;

}


/* =====================================================
   BOTÓN
===================================================== */

.acciones {

    margin-top: 28px;

    padding-top: 22px;

    border-top:
        1px solid #eee1e6;

}


.boton {

    width: 100%;

    height: 50px;

    border: none;

    border-radius: 15px;

    background:
        linear-gradient(
            135deg,
            #a86680,
            #754159
        );

    color: white;

    font-family: "DM Sans", sans-serif;

    font-size: 14px;

    font-weight: 600;

    letter-spacing: .5px;

    cursor: pointer;

    box-shadow:
        0 10px 25px
        rgba(117,65,89,.20);

    transition: .3s ease;

}


.boton:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 14px 30px
        rgba(117,65,89,.30);

    background:
        linear-gradient(
            135deg,
            #b87590,
            #814960
        );

}


.boton:active {

    transform:
        translateY(0);

}


/* =====================================================
   DECORACIÓN INFERIOR
===================================================== */

.firma {

    text-align: center;

    margin-top: 18px;

    color: #b49ca7;

    font-size: 9px;

    letter-spacing: 2px;

    text-transform: uppercase;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 800px) {

    .contenedor {

        grid-template-columns: 1fr;

        max-width: 600px;

    }

    .lateral {

        min-height: 250px;

        padding: 35px 25px;

    }

    .logo {

        width: 65px;

        height: 65px;

        font-size: 32px;

        margin-bottom: 15px;

    }

    .lateral h1 {

        font-size: 30px;

    }

    .decoracion {

        margin-top: 15px;

    }

    .mensaje {

        margin-top: 10px;

    }

}


@media(max-width: 550px) {

    body {

        padding: 15px;

    }

    .formulario {

        padding: 30px 22px;

    }

    .grupo-campos {

        grid-template-columns: 1fr;

    }

    .campo.completo {

        grid-column: auto;

    }

    .encabezado h2 {

        font-size: 30px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =========================================
         PANEL DECORATIVO
    ========================================== -->

    <div class="lateral">

        <div class="logo">
            D
        </div>

        <h1>
            DIVINE
        </h1>

        <div class="subtitulo">
            Beauty & Elegance
        </div>

        <div class="decoracion">
            ♡ ✦ ♡
        </div>

        <p class="mensaje">

            Cada detalle cuenta.
            Mantén la información de tus
            clientes actualizada y organizada.

        </p>

    </div>


    <!-- =========================================
         FORMULARIO
    ========================================== -->

    <div class="formulario">


        <div class="encabezado">

            <div class="etiqueta">
                Gestión de clientes
            </div>

            <h2>
                Editar cliente
            </h2>

            <p>
                Actualiza los datos del cliente seleccionado.
            </p>

        </div>


        <form
            action="updatecliente.php"
            method="POST"
            id="formcliente"
        >


            <div class="grupo-campos">


                <div class="campo">

                    <label for="CI">
                        C.I.
                    </label>

                    <input
                        type="number"
                        id="CI"
                        name="CI"
                        value="<?= htmlspecialchars($CI) ?>"
                    >

                </div>


                <div class="campo">

                    <label for="celular">
                        Teléfono
                    </label>

                    <input
                        type="number"
                        id="celular"
                        name="celular"
                        value="<?= htmlspecialchars($celular) ?>"
                    >

                </div>


                <div class="campo completo">

                    <label for="nombre">
                        Nombre completo
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="<?= htmlspecialchars($nombre) ?>"
                    >

                </div>


                <div class="campo completo">

                    <label for="direccion">
                        Dirección
                    </label>

                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        value="<?= htmlspecialchars($direccion) ?>"
                    >

                </div>


                <div class="campo">

                    <label for="rol">
                        Rol
                    </label>

                    <input
                        type="text"
                        id="rol"
                        name="rol"
                        value="<?= htmlspecialchars($rol) ?>"
                    >

                </div>


                <div class="campo">

                    <label for="estado">
                        Estado
                    </label>

                    <input
                        type="text"
                        id="estado"
                        name="estado"
                        value="<?= htmlspecialchars($estado) ?>"
                    >

                </div>


            </div>


            <div class="acciones">

                <input
                    type="submit"
                    value="Guardar cambios"
                    class="boton"
                >

            </div>


        </form>


        <div class="firma">
            DIVINE · Elegancia en cada detalle
        </div>


    </div>


</div>


<script>

$(document).ready(function(){

    $("#formcliente").validate({

        rules: {

            CI: {
                required: true,
                number: true,
                minlength: 7
            },

            nombre: {
                required: true,
                minlength: 3
            },

            direccion: {
                required: true,
                minlength: 5
            },

            celular: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 8
            },

            rol: {
                required: true,
                minlength: 3
            },

            estado: {
                required: true,
                minlength: 3
            }

        },

        messages: {

            CI: {
                required: "Ingrese el CI",
                number: "Solo se permiten números",
                minlength: "El CI debe tener al menos 7 dígitos"
            },

            nombre: {
                required: "Ingrese el nombre",
                minlength: "Debe tener al menos 3 caracteres"
            },

            direccion: {
                required: "Ingrese la dirección",
                minlength: "La dirección es demasiado corta"
            },

            celular: {
                required: "Ingrese el teléfono",
                number: "Solo se permiten números",
                minlength: "Debe tener 8 dígitos",
                maxlength: "Debe tener 8 dígitos"
            },

            rol: {
                required: "Ingrese el rol",
                minlength: "Debe tener al menos 3 caracteres"
            },

            estado: {
                required: "Ingrese el estado",
                minlength: "Debe tener al menos 3 caracteres"
            }

        },

        errorClass: "error"

    });

});

</script>


</body>

</html>
