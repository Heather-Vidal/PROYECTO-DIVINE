<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Formulario Productos DIVINE
</title>


<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500&display=swap"
    rel="stylesheet"
>


<style>


/* =====================================================
   CONFIGURACIÓN GENERAL
   ===================================================== */

* {

    margin:
        0;

    padding:
        0;

    box-sizing:
        border-box;

    font-family:
        'Segoe UI',
        sans-serif;

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

    background-position:
        center;

    background-repeat:
        no-repeat;

    background-size:
        cover;

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

    padding:
        30px;

}


/* =====================================================
   FORMULARIO
   ===================================================== */

form {

    width:
        650px;

    padding:
        40px;

    min-height:
        300px;

    background:
        rgba(255,255,255,0.5);

    backdrop-filter:
        blur(8px);

    border-radius:
        15px;

    box-shadow:
        0 15px 35px
        rgba(0,0,0,.15);

    display:
        flex;

    flex-direction:
        column;

}


/* =====================================================
   IMAGEN DECORATIVA
   ===================================================== */

.imagen {

    width:
        100%;

    height:
        200px;

    background:

        url(
            "https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg"
        )

        center center / cover
        no-repeat;

    border-radius:
        20px;

    margin-bottom:
        25px;

}


/* =====================================================
   TÍTULO
   ===================================================== */

h2 {

    text-align:
        center;

    color:
        #bf7485;

    margin-bottom:
        15px;

    font-size:
        28px;

    font-family:
        'Playfair Display',
        serif;

}


/* =====================================================
   LEYENDA
   ===================================================== */

legend {

    text-align:
        center;

    color:
        #bf7485;

    font-size:
        20px;

    font-weight:
        bold;

    margin-bottom:
        20px;

    font-family:
        'Playfair Display',
        serif;

}


/* =====================================================
   CAMPOS
   ===================================================== */

.grupo-campos {

    display:
        flex;

    flex-direction:
        column;

}


label {

    color:
        #666;

    font-weight:
        600;

    margin-bottom:
        8px;

}


input[type="text"],
input[type="number"] {

    width:
        100%;

    padding:
        12px 15px;

    border:
        2px solid #f0d6dc;

    border-radius:
        15px;

    outline:
        none;

    margin-bottom:
        18px;

    transition:
        .3s;

    font-size:
        15px;

    background:
        rgba(255,255,255,.85);

}


input[type="text"]:focus,
input[type="number"]:focus {

    border-color:
        #c96f84;

    box-shadow:
        0 0 10px
        rgba(201,111,132,.25);

}


/* =====================================================
   CARGA DE IMAGEN
   ===================================================== */

.carga-imagen {

    width:
        100%;

    margin-top:
        5px;

    margin-bottom:
        22px;

}


/* TÍTULO DEL CAMPO */

.carga-imagen-titulo {

    display:
        block;

    color:
        #666;

    font-weight:
        600;

    margin-bottom:
        10px;

}


/* =====================================================
   INPUT ORIGINAL OCULTO
   ===================================================== */

input[type="file"] {

    display:
        none;

}


/* =====================================================
   CAJA PARA SELECCIONAR ARCHIVO
   ===================================================== */

.selector-archivo {

    width:
        100%;

    min-height:
        135px;

    border:
        2px dashed #d98ca0;

    border-radius:
        20px;

    background:
        rgba(255,245,248,.75);

    display:
        flex;

    flex-direction:
        column;

    justify-content:
        center;

    align-items:
        center;

    text-align:
        center;

    cursor:
        pointer;

    padding:
        20px;

    transition:
        all .3s ease;

}


/* HOVER */

.selector-archivo:hover {

    border-color:
        #bf5e78;

    background:
        rgba(255,235,241,.95);

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(191,94,120,.18);

}


/* =====================================================
   ICONO
   ===================================================== */

.icono-archivo {

    font-size:
        38px;

    margin-bottom:
        8px;

}


/* =====================================================
   TEXTO PRINCIPAL
   ===================================================== */

.texto-archivo {

    color:
        #bf7485;

    font-size:
        17px;

    font-weight:
        bold;

}


/* =====================================================
   TEXTO SECUNDARIO
   ===================================================== */

.texto-secundario {

    color:
        #999;

    font-size:
        13px;

    margin-top:
        5px;

}


/* =====================================================
   NOMBRE DEL ARCHIVO
   ===================================================== */

.nombre-archivo {

    display:
        none;

    margin-top:
        12px;

    padding:
        7px 14px;

    border-radius:
        20px;

    background:
        #d98ca0;

    color:
        white;

    font-size:
        13px;

    max-width:
        90%;

    overflow:
        hidden;

    text-overflow:
        ellipsis;

    white-space:
        nowrap;

}


/* =====================================================
   BOTÓN ENVIAR
   ===================================================== */

input[type="submit"] {

    width:
        100%;

    background:
        #c96f84;

    color:
        white;

    border:
        none;

    padding:
        15px;

    border-radius:
        50px;

    font-size:
        17px;

    font-weight:
        bold;

    cursor:
        pointer;

    transition:
        .3s;

    box-shadow:
        0 8px 20px
        rgba(201,111,132,.35);

}


input[type="submit"]:hover {

    background:
        #b45d72;

    transform:
        translateY(-3px);

}


/* =====================================================
   ERRORES
   ===================================================== */

.error {

    color:
        #d85a5a;

    font-size:
        14px;

    font-family:
        'Playfair Display',
        serif;

}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 700px) {

    body {

        padding:
            15px;

    }


    form {

        width:
            100%;

        padding:
            25px;

    }


    .imagen {

        height:
            160px;

    }


    h2 {

        font-size:
            23px;

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
         IMAGEN DECORATIVA
         ================================================= -->

    <div class="imagen"></div>


    <!-- =================================================
         TÍTULO
         ================================================= -->

    <h2>
        REGISTRO DE PRODUCTOS DIVINE
    </h2>


    <legend>
        PRODUCTO:
    </legend>


    <div class="grupo-campos">


        <!-- =================================================
             NOMBRE
             ================================================= -->

        <label for="nombre">
            Nombre:
        </label>

        <input
            type="text"
            name="nombre"
        >


        <!-- =================================================
             DESCRIPCIÓN
             ================================================= -->

        <label for="descripcion">
            Descripción:
        </label>

        <input
            type="text"
            name="descripcion"
        >


        <!-- =================================================
             PRECIO
             ================================================= -->

        <label for="precio">
            Precio:
        </label>

        <input
            type="number"
            name="precio"
        >


        <!-- =================================================
             COSTO
             ================================================= -->

        <label for="costo">
            Costo:
        </label>

        <input
            type="number"
            name="costo"
        >


        <!-- =================================================
             STOCK
             ================================================= -->

        <label for="stock">
            Stock:
        </label>

        <input
            type="number"
            name="stock"
        >


        <!-- =================================================
             CÓDIGO
             ================================================= -->

        <label for="codigo">
            Código:
        </label>

        <input
            type="number"
            name="codigo"
        >


        <!-- =================================================
             CARGAR IMAGEN
             ================================================= -->

        <div class="carga-imagen">


            <label
                class="carga-imagen-titulo"
                for="fileToUpload"
            >

                Imagen del producto:

            </label>


            <!--
                ESTE LABEL ES EL BOTÓN BONITO.
                AL HACER CLIC ABRE EL INPUT FILE.
            -->

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
                ESTE SIGUE SIENDO EL INPUT REAL.
                NO CAMBIAMOS SU NAME.
                CREATEPRODU.PHP SEGUIRÁ RECIBIENDO:
                $_FILES["fileToUpload"]
            -->

            <input
                type="file"
                id="fileToUpload"
                name="fileToUpload"
                accept="image/*"
            >


        </div>


    </div>


    <!-- =================================================
         BOTÓN ENVIAR
         ================================================= -->

    <input
        type="submit"
        value="Enviar"
    >


</form>


<script>


/* =====================================================
   MOSTRAR NOMBRE DEL ARCHIVO
   ===================================================== */

document
    .getElementById("fileToUpload")
    .addEventListener(
        "change",
        function () {


            const archivo =
                this.files[0];


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


                nombre.textContent =
                    "";


                nombre.style.display =
                    "none";


            }


        }
    );


</script>


<script>


$(document).ready(function(){


    $("#formprodu").validate({


        rules:{


            nombre:{

                required:true

            },


            descripcion:{

                required:true

            },


            precio:{

                required:true,

                number:true

            },


            costo:{

                required:true,

                number:true

            },


            stock:{

                required:true,

                number:true

            },


            codigo:{

                required:true,

                number:true

            }


        },


        messages:{


            nombre:{

                required:
                    "Ingrese el nombre del producto"

            },


            descripcion:{

                required:
                    "Ingrese la descripción"

            },


            precio:{

                required:
                    "Ingrese el precio",

                number:
                    "Solo se permiten números"

            },


            costo:{

                required:
                    "Ingrese el costo",

                number:
                    "Solo se permiten números"

            },


            stock:{

                required:
                    "Ingrese el stock",

                number:
                    "Solo se permiten números"

            },


            codigo:{

                required:
                    "Ingrese el código",

                number:
                    "Solo se permiten números"

            }


        }


    });


});


</script>


</body>

</html>