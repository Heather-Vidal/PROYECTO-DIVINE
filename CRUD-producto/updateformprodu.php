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
    echo "Ocurrió un error al conectar con la base de datos.";
    exit();
}

/* =====================================================
   RECIBIR CÓDIGO
   ===================================================== */

$codigo = $_GET['codigo'] ?? null;

if ($codigo === null) {
    echo "No se recibió el código del producto.";
    exit();
}

/* =====================================================
   BUSCAR PRODUCTO
   ===================================================== */

$sql = "SELECT * FROM PRODUCTO WHERE codigo=$codigo";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $nombre = $fila['nombre'];
        $descripcion = $fila['descripcion'];
        $categoria = $fila['categoria'];
        $precio = $fila['precio'];
        $costo = $fila['costo'];
        $stock = $fila['stock'];
        $codigo = $fila['codigo'];
    }

} else {

    echo "Producto no encontrado.";
    exit();

}

/* =====================================================
   BUSCAR IMAGEN ACTUAL
   ===================================================== */

$nombreArchivo = "p-" . $codigo;

$directorio = "../PRODUCTO-img/";

$extensiones = [
    "jpg",
    "jpeg",
    "png",
    "gif"
];

$imagenProducto = null;
$nombreImagenActual = null;

foreach ($extensiones as $extension) {

    $ruta =
        $directorio .
        $nombreArchivo .
        "." .
        $extension;

    if (file_exists($ruta)) {

        $imagenProducto = $ruta;

        $nombreImagenActual =
            $nombreArchivo .
            "." .
            $extension;

        break;
    }
}

/* =====================================================
   IMAGEN POR DEFECTO
   ===================================================== */

if ($imagenProducto === null) {

    $imagenProducto =
        "https://i.pinimg.com/736x/23/fd/c5/23fdc5871b591de154e3e9b889036562.jpg";

    $nombreImagenActual =
        "No hay imagen cargada";
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
    Editar producto | DIVINE
</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =====================================================
   PALETA
   =====================================================

   Rosa empolvado:
   #D8A7B1

   Rosa claro:
   #F5E5E8

   Crema:
   #FFF9F5

   Champagne:
   #D8B58A

   Vino:
   #6D3948

   Café:
   #49343A

   ===================================================== */


/* =====================================================
   RESET
   ===================================================== */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}


/* =====================================================
   BODY
   ===================================================== */

body {

    min-height: 100vh;

    font-family:
        "DM Sans",
        sans-serif;

    background:
        linear-gradient(
            135deg,
            #fff9f5 0%,
            #f8e8eb 45%,
            #f3dce2 100%
        );

    color:
        #49343A;

    padding:
        40px 20px;

    position:
        relative;

    overflow-x:
        hidden;
}


/* =====================================================
   DECORACIONES DEL FONDO
   ===================================================== */

body::before {

    content: "";

    position: fixed;

    width: 400px;

    height: 400px;

    border-radius: 50%;

    background:
        rgba(216,167,177,0.18);

    top: -150px;

    left: -150px;

    filter:
        blur(10px);

    z-index: -1;
}


body::after {

    content: "";

    position: fixed;

    width: 350px;

    height: 350px;

    border-radius: 50%;

    background:
        rgba(216,181,138,0.13);

    right: -120px;

    bottom: -120px;

    filter:
        blur(10px);

    z-index: -1;
}


/* =====================================================
   CONTENEDOR PRINCIPAL
   ===================================================== */

.contenedor {

    width:
        100%;

    max-width:
        1150px;

    margin:
        auto;

}


/* =====================================================
   ENCABEZADO
   ===================================================== */

.encabezado {

    text-align:
        center;

    margin-bottom:
        30px;

}


.marca {

    font-size:
        14px;

    letter-spacing:
        5px;

    color:
        #A76D7B;

    font-weight:
        700;

    text-transform:
        uppercase;

    margin-bottom:
        8px;

}


.encabezado h1 {

    font-family:
        "Playfair Display",
        serif;

    font-size:
        clamp(32px, 5vw, 48px);

    color:
        #6D3948;

    font-weight:
        600;

}


.subtitulo {

    margin-top:
        8px;

    color:
        #8B7078;

    font-size:
        14px;

}


/* =====================================================
   TARJETA PRINCIPAL
   ===================================================== */

.formulario {

    background:
        rgba(255,255,255,0.82);

    backdrop-filter:
        blur(15px);

    -webkit-backdrop-filter:
        blur(15px);

    border:
        1px solid rgba(216,167,177,0.35);

    border-radius:
        32px;

    box-shadow:
        0 25px 70px
        rgba(109,57,72,0.13);

    padding:
        35px;

    display:
        grid;

    grid-template-columns:
        0.85fr 1.15fr;

    gap:
        38px;

}


/* =====================================================
   PANEL DE IMAGEN
   ===================================================== */

.panel-imagen {

    display:
        flex;

    flex-direction:
        column;

    gap:
        18px;

}


/* =====================================================
   IMAGEN PRINCIPAL
   ===================================================== */

.imagen-principal {

    min-height:
        530px;

    border-radius:
        26px;

    background-image:
        url(
            '<?php
            echo htmlspecialchars(
                $imagenProducto,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>'
        );

    background-position:
        center;

    background-size:
        cover;

    background-repeat:
        no-repeat;

    border:
        1px solid
        rgba(255,255,255,0.8);

    box-shadow:
        0 18px 40px
        rgba(109,57,72,0.18);

    position:
        relative;

    overflow:
        hidden;

    transition:
        0.4s ease;

}


.imagen-principal:hover {

    transform:
        translateY(-4px);

    box-shadow:
        0 25px 50px
        rgba(109,57,72,0.22);

}


/* =====================================================
   ETIQUETA SOBRE IMAGEN
   ===================================================== */

.badge-imagen {

    position:
        absolute;

    top:
        18px;

    left:
        18px;

    background:
        rgba(255,249,245,0.9);

    color:
        #6D3948;

    padding:
        9px 15px;

    border-radius:
        30px;

    font-size:
        11px;

    font-weight:
        700;

    letter-spacing:
        1px;

    text-transform:
        uppercase;

    box-shadow:
        0 5px 15px
        rgba(0,0,0,0.08);

}


/* =====================================================
   INFORMACIÓN DE IMAGEN
   ===================================================== */

.imagen-actual {

    display:
        flex;

    align-items:
        center;

    gap:
        14px;

    padding:
        13px;

    background:
        #FFF9F5;

    border:
        1px solid #E8D3D8;

    border-radius:
        18px;

}


.miniatura-actual {

    width:
        62px;

    height:
        62px;

    border-radius:
        14px;

    object-fit:
        cover;

    border:
        2px solid #D8A7B1;

}


.info-imagen {

    display:
        flex;

    flex-direction:
        column;

    gap:
        4px;

    min-width:
        0;

}


.info-titulo {

    font-size:
        11px;

    letter-spacing:
        1.5px;

    font-weight:
        700;

    color:
        #A76D7B;

}


.info-nombre {

    font-size:
        13px;

    color:
        #725961;

    word-break:
        break-all;

}


/* =====================================================
   PANEL FORMULARIO
   ===================================================== */

.panel-formulario {

    display:
        flex;

    flex-direction:
        column;

}


/* =====================================================
   CABECERA DEL FORMULARIO
   ===================================================== */

.titulo-formulario {

    margin-bottom:
        25px;

}


.titulo-formulario span {

    color:
        #B88996;

    font-size:
        12px;

    letter-spacing:
        2px;

    text-transform:
        uppercase;

    font-weight:
        700;

}


.titulo-formulario h2 {

    font-family:
        "Playfair Display",
        serif;

    color:
        #6D3948;

    font-size:
        30px;

    font-weight:
        600;

    margin-top:
        6px;

}


/* =====================================================
   SEPARADOR
   ===================================================== */

.separador {

    width:
        55px;

    height:
        3px;

    background:
        #D8B58A;

    border-radius:
        10px;

    margin-top:
        10px;

}


/* =====================================================
   GRUPO DE CAMPOS
   ===================================================== */

.grupo-campos {

    display:
        grid;

    grid-template-columns:
        1fr 1fr;

    gap:
        17px;

}


.campo {

    display:
        flex;

    flex-direction:
        column;

    gap:
        7px;

}


.campo-completo {

    grid-column:
        1 / -1;

}


.campo label {

    color:
        #6D3948;

    font-size:
        13px;

    font-weight:
        600;

}


.campo label::after {

    content:
        " ✦";

    color:
        #D8B58A;

    font-size:
        9px;

}


/* =====================================================
   INPUTS
   ===================================================== */

.campo input,
.campo select {

    width:
        100%;

    height:
        48px;

    padding:
        0 15px;

    border:
        1px solid #E3CDD2;

    border-radius:
        13px;

    background:
        #FFFDFC;

    color:
        #49343A;

    font-family:
        "DM Sans",
        sans-serif;

    font-size:
        14px;

    outline:
        none;

    transition:
        all 0.3s ease;

}


.campo input:hover,
.campo select:hover {

    border-color:
        #D8A7B1;

}


.campo input:focus,
.campo select:focus {

    border-color:
        #B77C8B;

    background:
        #FFFFFF;

    box-shadow:
        0 0 0 4px
        rgba(216,167,177,0.15);

}


/* =====================================================
   SECCIÓN IMAGEN
   ===================================================== */

.carga-imagen {

    grid-column:
        1 / -1;

    margin-top:
        5px;

    padding-top:
        20px;

    border-top:
        1px solid #EBDDE0;

}


.titulo-imagen {

    color:
        #6D3948;

    font-size:
        13px;

    font-weight:
        600;

    margin-bottom:
        10px;

}


/* =====================================================
   SELECTOR DE ARCHIVO
   ===================================================== */

.selector-archivo {

    width:
        100%;

    min-height:
        115px;

    border:
        2px dashed #D8A7B1;

    border-radius:
        18px;

    background:
        #FFF9F7;

    display:
        flex;

    flex-direction:
        column;

    align-items:
        center;

    justify-content:
        center;

    text-align:
        center;

    cursor:
        pointer;

    transition:
        0.3s ease;

}


.selector-archivo:hover {

    border-color:
        #B77C8B;

    background:
        #FDF1F3;

    transform:
        translateY(-2px);

}


.icono-archivo {

    width:
        45px;

    height:
        45px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        50%;

    background:
        #F5E2E6;

    color:
        #9D6170;

    font-size:
        22px;

    margin-bottom:
        7px;

}


.texto-archivo {

    color:
        #6D3948;

    font-size:
        14px;

    font-weight:
        700;

}


.texto-secundario {

    color:
        #9A8188;

    font-size:
        11px;

    margin-top:
        4px;

}


input[type="file"] {

    display:
        none;

}


/* =====================================================
   NUEVA IMAGEN
   ===================================================== */

.nueva-imagen {

    display:
        none;

    align-items:
        center;

    gap:
        13px;

    padding:
        10px;

    margin-top:
        12px;

    background:
        #FDF3F5;

    border:
        1px solid #E3C5CC;

    border-radius:
        15px;

}


.miniatura-nueva {

    width:
        60px;

    height:
        60px;

    object-fit:
        cover;

    border-radius:
        12px;

    border:
        2px solid #C8919E;

}


.info-nueva {

    display:
        flex;

    flex-direction:
        column;

    gap:
        4px;

}


.nueva-titulo {

    color:
        #9D6170;

    font-size:
        11px;

    font-weight:
        700;

    letter-spacing:
        1px;

}


.nueva-nombre {

    color:
        #786169;

    font-size:
        12px;

    word-break:
        break-all;

}


/* =====================================================
   BOTÓN
   ===================================================== */

.boton-actualizar {

    margin-top:
        25px;

    width:
        100%;

    height:
        55px;

    border:
        none;

    border-radius:
        15px;

    background:
        linear-gradient(
            135deg,
            #8C4F61,
            #B87383
        );

    color:
        white;

    font-family:
        "DM Sans",
        sans-serif;

    font-size:
        15px;

    font-weight:
        700;

    letter-spacing:
        0.5px;

    cursor:
        pointer;

    box-shadow:
        0 10px 25px
        rgba(140,79,97,0.25);

    transition:
        all 0.3s ease;

}


.boton-actualizar:hover {

    transform:
        translateY(-3px);

    box-shadow:
        0 15px 30px
        rgba(140,79,97,0.32);

}


.boton-actualizar:active {

    transform:
        translateY(0);

}


/* =====================================================
   ERRORES
   ===================================================== */

.error {

    color:
        #B04D5F;

    font-size:
        11px;

    margin-top:
        2px;

}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 900px) {

    .formulario {

        grid-template-columns:
            1fr;

    }

    .imagen-principal {

        min-height:
            400px;

    }

}


@media (max-width: 600px) {

    body {

        padding:
            20px 12px;

    }

    .formulario {

        padding:
            20px;

        border-radius:
            24px;

    }

    .grupo-campos {

        grid-template-columns:
            1fr;

    }

    .campo-completo,
    .carga-imagen {

        grid-column:
            auto;

    }

    .imagen-principal {

        min-height:
            330px;

    }

    .encabezado h1 {

        font-size:
            34px;

    }

}


/* =====================================================
   ANIMACIÓN
   ===================================================== */

@keyframes aparecer {

    from {

        opacity:
            0;

        transform:
            translateY(15px);

    }

    to {

        opacity:
            1;

        transform:
            translateY(0);

    }

}


.formulario {

    animation:
        aparecer 0.6s ease;

}

</style>

</head>

<body>


<div class="contenedor">


    <!-- =================================================
         ENCABEZADO
         ================================================= -->

    <div class="encabezado">

        <div class="marca">
            DIVINE
        </div>

        <h1>
            Editar producto
        </h1>

        <p class="subtitulo">
            Actualiza la información y apariencia de tu producto
        </p>

    </div>


    <!-- =================================================
         FORMULARIO
         ================================================= -->

    <form
        class="formulario"
        action="updateprodu.php"
        method="POST"
        enctype="multipart/form-data"
    >


        <!-- =================================================
             PANEL DE IMAGEN
             ================================================= -->

        <div class="panel-imagen">


            <div
                class="imagen-principal"
                id="imagenPrincipal"
            >

                <div class="badge-imagen">
                    Producto DIVINE
                </div>

            </div>


            <!-- =================================================
                 IMAGEN ACTUAL
                 ================================================= -->

            <div class="imagen-actual">

                <img
                    src="<?php

                    echo htmlspecialchars(
                        $imagenProducto,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>"
                    class="miniatura-actual"
                    id="miniaturaActual"
                >

                <div class="info-imagen">

                    <div class="info-titulo">
                        IMAGEN ACTUAL
                    </div>

                    <div
                        class="info-nombre"
                        id="nombreImagenActual"
                    >

                        <?php

                        echo htmlspecialchars(
                            $nombreImagenActual
                        );

                        ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             PANEL DEL FORMULARIO
             ================================================= -->

        <div class="panel-formulario">


            <div class="titulo-formulario">

                <span>
                    Información del producto
                </span>

                <h2>
                    Detalles de tu producto
                </h2>

                <div class="separador"></div>

            </div>


            <div class="grupo-campos">


                <!-- =================================================
                     NOMBRE
                     ================================================= -->

                <div class="campo campo-completo">

                    <label for="nombre">
                        Nombre del producto
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="<?= htmlspecialchars($nombre) ?>"
                        required
                    >

                </div>


                <!-- =================================================
                     DESCRIPCIÓN
                     ================================================= -->

                <div class="campo campo-completo">

                    <label for="descripcion">
                        Descripción
                    </label>

                    <input
                        type="text"
                        id="descripcion"
                        name="descripcion"
                        value="<?= htmlspecialchars($descripcion) ?>"
                        required
                    >

                </div>


                <!-- =================================================
                     CATEGORÍA
                     ================================================= -->

                <div class="campo campo-completo">

                    <label for="categoria">
                        Categoría
                    </label>

                    <select
                        id="categoria"
                        name="categoria"
                    >

                        <option
                            value="SkinCare"
                            <?= $categoria == "SkinCare" ? "selected" : "" ?>
                        >
                            SkinCare
                        </option>

                        <option
                            value="SkinHair"
                            <?= $categoria == "SkinHair" ? "selected" : "" ?>
                        >
                            SkinHair
                        </option>

                    </select>

                </div>


                <!-- =================================================
                     PRECIO
                     ================================================= -->

                <div class="campo">

                    <label for="precio">
                        Precio
                    </label>

                    <input
                        type="number"
                        id="precio"
                        name="precio"
                        value="<?= htmlspecialchars($precio) ?>"
                        required
                    >

                </div>


                <!-- =================================================
                     COSTO
                     ================================================= -->

                <div class="campo">

                    <label for="costo">
                        Costo
                    </label>

                    <input
                        type="number"
                        id="costo"
                        name="costo"
                        value="<?= htmlspecialchars($costo) ?>"
                        required
                    >

                </div>


                <!-- =================================================
                     STOCK
                     ================================================= -->

                <div class="campo">

                    <label for="stock">
                        Stock disponible
                    </label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        value="<?= htmlspecialchars($stock) ?>"
                        required
                    >

                </div>


                <!-- =================================================
                     CÓDIGO
                     ================================================= -->

                <div class="campo">

                    <label for="codigo">
                        Código
                    </label>

                    <input
                        type="number"
                        id="codigo"
                        name="codigo"
                        value="<?= htmlspecialchars($codigo) ?>"
                        required
                    >

                </div>


                <!-- =================================================
                     IMAGEN
                     ================================================= -->

                <div class="carga-imagen">

                    <div class="titulo-imagen">
                        Imagen del producto
                    </div>


                    <label
                        for="fileToUpload"
                        class="selector-archivo"
                    >

                        <div class="icono-archivo">
                            ♡
                        </div>

                        <div class="texto-archivo">
                            Seleccionar nueva imagen
                        </div>

                        <div class="texto-secundario">
                            Haz clic para reemplazar la imagen actual
                        </div>

                    </label>


                    <input
                        type="file"
                        id="fileToUpload"
                        name="fileToUpload"
                        accept="image/*"
                    >


                    <!-- =================================================
                         PREVIEW NUEVA IMAGEN
                         ================================================= -->

                    <div
                        class="nueva-imagen"
                        id="nuevaImagen"
                    >

                        <img
                            class="miniatura-nueva"
                            id="miniaturaNueva"
                        >

                        <div class="info-nueva">

                            <div class="nueva-titulo">
                                NUEVA IMAGEN
                            </div>

                            <div
                                class="nueva-nombre"
                                id="nombreNuevaImagen"
                            ></div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 BOTÓN
                 ================================================= -->

            <input
                type="submit"
                class="boton-actualizar"
                value="Guardar cambios  ✦"
            >

        </div>

    </form>

</div>


<script>

/* =====================================================
   PREVISUALIZAR NUEVA IMAGEN
   ===================================================== */

document
    .getElementById("fileToUpload")
    .addEventListener(
        "change",
        function () {

            const archivo =
                this.files[0];

            const nuevaImagen =
                document.getElementById(
                    "nuevaImagen"
                );

            const miniaturaNueva =
                document.getElementById(
                    "miniaturaNueva"
                );

            const nombreNuevaImagen =
                document.getElementById(
                    "nombreNuevaImagen"
                );


            if (archivo) {

                /*
                    MOSTRAR NOMBRE
                */

                nombreNuevaImagen.textContent =
                    archivo.name;


                /*
                    MOSTRAR BLOQUE
                */

                nuevaImagen.style.display =
                    "flex";


                /*
                    CREAR PREVIEW
                */

                const lector =
                    new FileReader();


                lector.onload =
                    function (evento) {

                        miniaturaNueva.src =
                            evento.target.result;


                        /*
                            CAMBIAR IMAGEN PRINCIPAL
                        */

                        document
                            .getElementById(
                                "imagenPrincipal"
                            )
                            .style.backgroundImage =
                            "url('" +
                            evento.target.result +
                            "')";

                    };


                lector.readAsDataURL(
                    archivo
                );

            }

        }
    );


/* =====================================================
   VALIDACIÓN
   ===================================================== */

$(document).ready(function() {

    $("form").validate({

        rules: {

            nombre:
                "required",

            descripcion:
                "required",

            precio: {

                required:
                    true,

                number:
                    true,

                min:
                    2

            },

            costo: {

                required:
                    true,

                number:
                    true,

                min:
                    2

            },

            stock: {

                required:
                    true,

                number:
                    true,

                min:
                    2

            },

            codigo: {

                required:
                    true,

                number:
                    true,

                min:
                    5

            }

        },


        messages: {

            nombre:
                "Por favor, ingresa el nombre del producto.",

            descripcion:
                "Por favor, ingresa la descripción del producto.",

            precio: {

                required:
                    "Por favor, ingresa el precio del producto.",

                number:
                    "Por favor, ingresa un número válido.",

                min:
                    "El precio debe ser mayor o igual a 2."

            },

            costo: {

                required:
                    "Por favor, ingresa el costo del producto.",

                number:
                    "Por favor, ingresa un número válido.",

                min:
                    "El costo debe ser mayor o igual a 2."

            },

            stock: {

                required:
                    "Por favor, ingresa la cantidad en stock.",

                number:
                    "Por favor, ingresa un número válido.",

                min:
                    "El stock debe ser mayor o igual a 2."

            },

            codigo: {

                required:
                    "Por favor, ingresa el código del producto.",

                number:
                    "Por favor, ingresa un número válido.",

                min:
                    "El código debe ser mayor o igual a 5."

            }

        }

    });

});

</script>


</body>

</html>

<?php

$conn->close();

?>