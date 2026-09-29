<?php

session_start();

/* =====================================================
   VERIFICAR SI HAY UNA SESIÓN INICIADA
===================================================== */

if (!isset($_SESSION['nombre']) || empty($_SESSION['nombre'])) {

    header("Location: ../SESIONES/loginformcliente.php");
    exit();

}


/* =====================================================
   DATOS DE LA SESIÓN
===================================================== */

$nombreUsuario = $_SESSION['nombre'];
$rol = strtolower(trim($_SESSION['rol'] ?? ''));


/* =====================================================
   VERIFICAR ROL
===================================================== */

if ($rol != "administrador" && $rol != "vendedor") {

    header("Location: ../totu.php");
    exit();

}


/* =====================================================
   DETERMINAR PERFIL SEGÚN EL ROL
===================================================== */

if ($rol == "administrador") {

    $perfilUsuario = "../admin.php";

} else {

    $perfilUsuario = "../perfilvendedor.php";

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Formulario Productos DIVINE</title>


<!-- =====================================================
     JQUERY
===================================================== -->

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>


<!-- =====================================================
     JQUERY VALIDATE
===================================================== -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>


<!-- =====================================================
     FUENTES
===================================================== -->

<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500&display=swap"
    rel="stylesheet"
>


<style>

/* =====================================================
   CONFIGURACIÓN GENERAL
===================================================== */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

    font-family: 'Segoe UI', sans-serif;

}


/* =====================================================
   FONDO
===================================================== */

body {

    background:

        linear-gradient(

            rgba(0,0,0,.30),

            rgba(0,0,0,.30)

        ),

        url(

            "https://i.pinimg.com/736x/b0/c0/79/b0c07926edeca5c51deb5337f2735d36.jpg"

        );

    background-position: center;

    background-repeat: no-repeat;

    background-size: cover;

    display: flex;

    justify-content: center;

    align-items: center;

    min-height: 100vh;

    margin: 0;

    padding: 30px;

}


/* =====================================================
   FORMULARIO
===================================================== */

form {

    width: 650px;

    padding: 40px;

    min-height: 300px;

    background: rgba(255,255,255,0.5);

    backdrop-filter: blur(8px);

    border-radius: 15px;

    box-shadow:

        0 15px 35px

        rgba(0,0,0,.15);

    display: flex;

    flex-direction: column;

}


/* =====================================================
   IMAGEN SUPERIOR
===================================================== */

.imagen {

    width: 100%;

    height: 200px;

    background:

        url(

            "https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg"

        )

        center center / cover

        no-repeat;

    border-radius: 20px;

    margin-bottom: 25px;

}


/* =====================================================
   TITULOS
===================================================== */

h2 {

    text-align: center;

    color: #bf7485;

    margin-bottom: 15px;

    font-size: 28px;

    font-family:

        'Playfair Display',

        serif;

}


legend {

    text-align: center;

    color: #bf7485;

    font-size: 20px;

    font-weight: bold;

    margin-bottom: 20px;

    font-family:

        'Playfair Display',

        serif;

}


/* =====================================================
   CAMPOS
===================================================== */

.grupo-campos {

    display: flex;

    flex-direction: column;

}


label {

    color: #666;

    font-weight: 600;

    margin-bottom: 8px;

    margin-top: 15px;

}


input[type="text"],

input[type="number"],

select {

    width: 100%;

    padding: 12px 15px;

    border: 2px solid #f0d6dc;

    border-radius: 15px;

    outline: none;

    margin-bottom: 18px;

    transition: .3s;

    font-size: 15px;

    background: rgba(255,255,255,.85);

}


input[type="text"]:focus,

input[type="number"]:focus,

select:focus {

    border-color: #c96f84;

    box-shadow:

        0 0 10px

        rgba(201,111,132,.25);

}


/* =====================================================
   CARGA DE IMAGEN
===================================================== */

.carga-imagen {

    width: 100%;

    margin-top: 5px;

    margin-bottom: 22px;

}


.carga-imagen-titulo {

    display: block;

    color: #666;

    font-weight: 600;

    margin-bottom: 10px;

}


input[type="file"] {

    display: none;

}


/* =====================================================
   SELECTOR DE ARCHIVO
===================================================== */

.selector-archivo {

    width: 100%;

    min-height: 135px;

    border: 2px dashed #d98ca0;

    border-radius: 20px;

    background: rgba(255,245,248,.75);

    display: flex;

    flex-direction: column;

    justify-content: center;

    align-items: center;

    text-align: center;

    cursor: pointer;

    padding: 20px;

    transition: all .3s ease;

}


.selector-archivo:hover {

    border-color: #bf5e78;

    background: rgba(255,235,241,.95);

    transform: translateY(-2px);

    box-shadow:

        0 8px 20px

        rgba(191,94,120,.18);

}


.icono-archivo {

    font-size: 38px;

    margin-bottom: 8px;

}


.texto-archivo {

    color: #bf7485;

    font-size: 17px;

    font-weight: bold;

}


.texto-secundario {

    color: #999;

    font-size: 13px;

    margin-top: 5px;

}


.nombre-archivo {

    display: none;

    margin-top: 12px;

    padding: 7px 14px;

    border-radius: 20px;

    background: #d98ca0;

    color: white;

    font-size: 13px;

    max-width: 90%;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

}


/* =====================================================
   BOTÓN ENVIAR
===================================================== */

input[type="submit"] {

    width: 100%;

    background:

        linear-gradient(

            135deg,

            #c96f84,

            #b95670

        );

    color: white;

    border: none;

    padding: 16px;

    border-radius: 50px;

    font-size: 17px;

    font-weight: bold;

    cursor: pointer;

    transition: all .3s ease;

    box-shadow:

        0 8px 20px

        rgba(201,111,132,.35);

    letter-spacing: .5px;

}


input[type="submit"]:hover {

    background:

        linear-gradient(

            135deg,

            #b95670,

            #a84761

        );

    transform: translateY(-3px);

    box-shadow:

        0 12px 25px

        rgba(180,93,114,.45);

}


input[type="submit"]:active {

    transform: translateY(0);

    box-shadow:

        0 5px 12px

        rgba(180,93,114,.30);

}


/* =====================================================
   BOTÓN VOLVER
===================================================== */

.btn-volver {

    width: 100%;

    background: rgba(255,255,255,.75);

    color: #bf7485;

    text-decoration: none;

    padding: 15px;

    border: 2px solid #e0a5b3;

    border-radius: 50px;

    font-size: 17px;

    font-weight: bold;

    text-align: center;

    cursor: pointer;

    transition: all .3s ease;

    margin-top: 15px;

    box-shadow:

        0 5px 15px

        rgba(201,111,132,.15);

}


.btn-volver:hover {

    background: #e0a5b3;

    color: white;

    transform: translateY(-3px);

    box-shadow:

        0 10px 20px

        rgba(201,111,132,.30);

}


/* =====================================================
   MENSAJES DE ERROR
===================================================== */

.error {

    color: #d85a5a;

    font-size: 14px;

    font-family:

        'Playfair Display',

        serif;

    margin-top: -10px;

    margin-bottom: 8px;

}


/* =====================================================
   ERROR DE IMAGEN
===================================================== */

label.error {

    display: block;

    width: 100%;

    color: #d85a5a;

    font-size: 14px;

    font-weight: 600;

    margin-top: 8px;

    margin-bottom: 10px;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 700px) {

    body {

        padding: 15px;

    }


    form {

        width: 100%;

        padding: 25px;

    }


    .imagen {

        height: 160px;

    }


    h2 {

        font-size: 23px;

    }

}


@media (max-width: 450px) {

    body {

        padding: 10px;

        align-items: flex-start;

    }


    form {

        padding: 20px;

        border-radius: 12px;

        margin-top: 10px;

    }


    .imagen {

        height: 130px;

        border-radius: 15px;

    }


    h2 {

        font-size: 20px;

        line-height: 1.3;

    }


    legend {

        font-size: 17px;

    }


    input[type="text"],

    input[type="number"],

    select {

        font-size: 14px;

        padding: 11px 13px;

    }


    .selector-archivo {

        min-height: 120px;

    }


    .icono-archivo {

        font-size: 32px;

    }


    .texto-archivo {

        font-size: 15px;

    }


    input[type="submit"],

    .btn-volver {

        font-size: 15px;

        padding: 13px;

    }

}

</style>

</head>


<body>


<form

    id="formprodu"

    action="createprodu.php"

    method="POST"

    enctype="multipart/form-data"

>


    <!-- =================================================
         IMAGEN SUPERIOR
    ================================================== -->

    <div class="imagen"></div>


    <!-- =================================================
         TÍTULO
    ================================================== -->

    <h2>

        REGISTRO DE PRODUCTOS DIVINE

    </h2>


    <legend>

        PRODUCTO:

    </legend>


    <div class="grupo-campos">


        <!-- =================================================
             NOMBRE
        ================================================== -->

        <label for="nombre">

            Nombre:

        </label>

        <input

            type="text"

            name="nombre"

            id="nombre"

        >


        <!-- =================================================
             DESCRIPCIÓN
        ================================================== -->

        <label for="descripcion">

            Descripción:

        </label>

        <input

            type="text"

            name="descripcion"

            id="descripcion"

        >


        <!-- =================================================
             CATEGORÍA
        ================================================== -->

        <label for="categoria">

            Categoría:

        </label>

        <select

            id="categoria"

            name="categoria"

        >

            <option value="">

                Seleccione una categoría

            </option>

            <option value="SkinCare">

                SkinCare

            </option>

            <option value="SkinHair">

                SkinHair

            </option>

        </select>


        <!-- =================================================
             PRECIO
        ================================================== -->

        <label for="precio">

            Precio:

        </label>

        <input

            type="number"

            name="precio"

            id="precio"

            step="any"

        >


        <!-- =================================================
             COSTO
        ================================================== -->

        <label for="costo">

            Costo:

        </label>

        <input

            type="number"

            name="costo"

            id="costo"

            step="any"

        >


        <!-- =================================================
             STOCK
        ================================================== -->

        <label for="stock">

            Stock:

        </label>

        <input

            type="number"

            name="stock"

            id="stock"

            min="0"

        >


        <!-- =================================================
             CÓDIGO
        ================================================== -->

        <label for="codigo">

            Código:

        </label>

        <input

            type="number"

            name="codigo"

            id="codigo"

            min="1"

        >


        <!-- =================================================
             IMAGEN DEL PRODUCTO
        ================================================== -->

        <div class="carga-imagen">

            <label

                class="carga-imagen-titulo"

                for="fileToUpload"

            >

                Imagen del producto:

            </label>


            <label

                for="fileToUpload"

                class="selector-archivo"

            >

                <div class="icono-archivo">

                    📷

                </div>


                <div class="texto-archivo">

                    Seleccionar imagen

                </div>


                <div class="texto-secundario">

                    Haz clic aquí para cargar una imagen

                </div>


                <div

                    class="nombre-archivo"

                    id="nombreArchivo"

                >

                </div>

            </label>


            <!--
                IMPORTANTE:
                Aunque esté oculto visualmente,
                jQuery Validate lo validará porque
                usamos ignore: []
            -->

            <input

                type="file"

                id="fileToUpload"

                name="fileToUpload"

                accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"

            >

        </div>

    </div>


    <!-- =================================================
         BOTÓN ENVIAR
    ================================================== -->

    <input

        type="submit"

        value="Enviar"

    >


    <!-- =================================================
         BOTÓN VOLVER
    ================================================== -->

    <a

        href="<?php echo htmlspecialchars($perfilUsuario); ?>"

        class="btn-volver"

    >

        Volver al perfil

    </a>


</form>


<!-- =====================================================
     MOSTRAR NOMBRE DEL ARCHIVO
===================================================== -->

<script>

document

    .getElementById("fileToUpload")

    .addEventListener(

        "change",

        function () {

            const archivo = this.files[0];

            const nombre =

                document.getElementById(

                    "nombreArchivo"

                );


            if (archivo) {

                nombre.textContent =

                    "✓ " + archivo.name;

                nombre.style.display =

                    "inline-block";

            } else {

                nombre.textContent = "";

                nombre.style.display =

                    "none";

            }

        }

    );

</script>


<!-- =====================================================
     VALIDACIÓN JQUERY
===================================================== -->

<script>

$(document).ready(function () {


    /* =================================================
       VALIDACIÓN PERSONALIZADA PARA IMAGEN
    ================================================= */

    $.validator.addMethod(

        "imagenValida",

        function (value, element) {


            /* -----------------------------------------
               SI NO SE SELECCIONÓ NINGÚN ARCHIVO
            ----------------------------------------- */

            if (element.files.length === 0) {

                return false;

            }


            /* -----------------------------------------
               OBTENER ARCHIVO
            ----------------------------------------- */

            const archivo = element.files[0];


            /* -----------------------------------------
               EXTENSIONES PERMITIDAS
            ----------------------------------------- */

            const extensionesPermitidas = [

                "jpg",

                "jpeg",

                "png",

                "gif",

                "webp"

            ];


            /* -----------------------------------------
               OBTENER EXTENSIÓN
            ----------------------------------------- */

            const nombreArchivo =

                archivo.name.toLowerCase();


            const extension =

                nombreArchivo

                    .split(".")

                    .pop();


            /* -----------------------------------------
               COMPROBAR EXTENSIÓN
            ----------------------------------------- */

            if (

                !extensionesPermitidas.includes(

                    extension

                )

            ) {

                return false;

            }


            /* -----------------------------------------
               COMPROBAR TAMAÑO
               MÁXIMO 5 MB
            ----------------------------------------- */

            const maximo =

                5 * 1024 * 1024;


            if (archivo.size > maximo) {

                return false;

            }


            /* -----------------------------------------
               TODO CORRECTO
            ----------------------------------------- */

            return true;

        },

        "Seleccione una imagen válida (JPG, JPEG, PNG, GIF o WEBP) de máximo 5 MB."

    );


    /* =================================================
       VALIDACIÓN DEL FORMULARIO
    ================================================= */

    $("#formprodu").validate({

        /*
         * IMPORTANTE:
         * jQuery Validate normalmente ignora
         * elementos ocultos.
         *
         * Como nuestro input file tiene
         * display:none, debemos permitir
         * que también sea validado.
         */

        ignore: [],


        /* =================================================
           REGLAS
        ================================================= */

        rules: {

            nombre: {

                required: true,

                minlength: 2

            },


            descripcion: {

                required: true,

                minlength: 3

            },


            categoria: {

                required: true

            },


            precio: {

                required: true,

                number: true,

                min: 0

            },


            costo: {

                required: true,

                number: true,

                min: 0

            },


            stock: {

                required: true,

                digits: true,

                min: 0

            },


            codigo: {

                required: true,

                digits: true,

                min: 1

            },


            fileToUpload: {

                required: true,

                imagenValida: true

            }

        },


        /* =================================================
           MENSAJES
        ================================================= */

        messages: {

            nombre: {

                required:

                    "Ingrese el nombre del producto",

                minlength:

                    "Ingrese al menos 2 caracteres"

            },


            descripcion: {

                required:

                    "Ingrese la descripción",

                minlength:

                    "Ingrese al menos 3 caracteres"

            },


            categoria: {

                required:

                    "Seleccione una categoría"

            },


            precio: {

                required:

                    "Ingrese el precio",

                number:

                    "Solo se permiten números",

                min:

                    "El precio no puede ser negativo"

            },


            costo: {

                required:

                    "Ingrese el costo",

                number:

                    "Solo se permiten números",

                min:

                    "El costo no puede ser negativo"

            },


            stock: {

                required:

                    "Ingrese el stock",

                digits:

                    "Ingrese únicamente números enteros",

                min:

                    "El stock no puede ser negativo"

            },


            codigo: {

                required:

                    "Ingrese el código",

                digits:

                    "Ingrese únicamente números enteros",

                min:

                    "El código debe ser mayor a 0"

            },


            fileToUpload: {

                required:

                    "Seleccione una imagen del producto",

                imagenValida:

                    "Seleccione una imagen válida (JPG, JPEG, PNG, GIF o WEBP) de máximo 5 MB"

            }

        },


        /* =================================================
           TIPO DE MENSAJE
        ================================================= */

        errorElement: "label",

        errorClass: "error",


        /* =================================================
           AL SELECCIONAR UNA IMAGEN
           VOLVER A VALIDARLA
        ================================================= */

        onfocusout: function(element) {

            this.element(element);

        },


        /* =================================================
           AL CAMBIAR LA IMAGEN
        ================================================= */

        onchange: function(element) {

            this.element(element);

        }

    });


    /* =====================================================
       CUANDO SE SELECCIONA UNA IMAGEN,
       VALIDAR INMEDIATAMENTE
    ===================================================== */

    $("#fileToUpload").on("change", function () {

        $("#formprodu").validate().element(this);

    });


});

</script>


</body>

</html>