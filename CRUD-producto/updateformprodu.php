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

    echo "OCURRIÓ UN ERROR SORRYYYYYYYYYYYY UnU";

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
   BUSCAR IMAGEN ACTUAL DEL PRODUCTO
   ===================================================== */
$nombreArchivo = "p-" . $codigo;
/*
    IMPORTANTE:
    LA CARPETA AHORA ES PRODUCTO-img
*/
$directorio = "../PRODUCTO-img/";
$extensiones = [
    "jpg",
    "jpeg",
    "png",
    "gif"
];
$imagenProducto = null;
$nombreImagenActual = null;
/* =====================================================
   BUSCAR LA EXTENSIÓN QUE REALMENTE EXISTE
   ===================================================== */
foreach ($extensiones as $extension) {
    $ruta =
       $directorio
        . $nombreArchivo
        . "."
        . $extension;
    if (file_exists($ruta)) {
        $imagenProducto = $ruta;
        $nombreImagenActual =
            $nombreArchivo
            . "."
            . $extension;
        break;
    }
}
/* =====================================================
   SI NO ENCUENTRA IMAGEN
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
    Modificar Producto DIVINE
</title>


<script
    src="https://code.jquery.com/jquery-3.6.3.min.js">
</script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js">
</script>
<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap"
    rel="stylesheet"
>
<style>
/* ====================================================
   GENERAL
   ===================================================== */
* {
    box-sizing:
        border-box;
}
body {
    font-family:
        'Inter',
        sans-serif;
    background:
        #e9e5dd;
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
    background:
        #f5e9d8;
    padding:
        50px;
    border-radius:
        25px;
    border:
        2px solid #c5a46d;
    box-shadow:
        0 15px 40px
        rgba(8,8,8,0.15);
    max-width:
        850px;
    width:
        100%;
    display:
        grid;
    grid-template-columns:
        1fr 1fr;
    gap:
        30px;
    grid-template-areas:
        "imagen titulo"
        "imagen leyenda"
        "imagen campos"
        "imagen boton";
}
/* =====================================================
   IMAGEN ACTUAL GRANDE
   ===================================================== */
.imagen {
    grid-area:
        imagen;
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

    border-radius:
        20px;

    min-height:
        420px;

    border:
        3px solid #c5a46d;

    box-shadow:

        inset 0 0 20px
        rgba(0,0,0,0.10),

        0 10px 25px
        rgba(54,78,99,0.20);

    transition:
        0.3s ease;

}


/* =====================================================
   TÍTULO
   ===================================================== */

h2 {

    grid-area:
        titulo;

    margin:
        0 0 8px;

    font-size:
        36px;

    color:
        #364e63;

    font-family:
        "Playfair Display",
        serif;

    letter-spacing:
        1px;

    border-bottom:
        3px solid #c5a46d;

    padding-bottom:
        8px;

    width:
        fit-content;

}
/* =====================================================
   LEYENDA
   ===================================================== */
legend {
    grid-area:
        leyenda;
    font-weight:
        bold;
    color:
        #c5a46d;
    font-size:
        18px;
    font-family:
        "Playfair Display",
        serif;
}
/* =====================================================
   CAMPOS
   ===================================================== */
.grupo-campos {
    grid-area:
        campos;
    display:
        flex;
    flex-direction:
        column;
    gap:
        14px;
}
label {
    color:
        #364e63;
    font-size:
        15px;
    font-weight:
        600;
}
input[type="text"],
input[type="number"] {
    padding:
        14px 16px;
    border-radius:
        12px;
    border:
        1.5px solid #c5a46d;
    background:
        #ffffff;
    font-size:
        15px;
    outline:
        none;
    transition:
        0.35s ease;
}
input[type="text"]:focus,
input[type="number"]:focus {
    border-color:
        #364e63;

    box-shadow:
        0 0 12px
        rgba(54,78,99,0.30);

}
/* =====================================================
   BLOQUE DE IMAGEN
   ===================================================== */

.carga-imagen {

    display:
        flex;

    flex-direction:
        column;

    gap:
        10px;

    margin-top:
        10px;

}
/* =====================================================
   IMAGEN ACTUAL
   ===================================================== */

.imagen-actual {
    display:
        flex;
    align-items:
        center;
    gap:
        12px;
    padding:
        10px;
    background:
        rgba(255,255,255,0.55);
    border:
        1px solid #c5a46d;
    border-radius:
        15px;
}
.miniatura-actual {
    width:
        65px;
    height:
        65px;
    border-radius:
        12px;
    object-fit:
        cover;
    border:
        2px solid #c5a46d;
}
.info-imagen {
    display:
        flex;
    flex-direction:
        column;
    gap:
        4px;
}
.info-titulo {
    color:
        #364e63;
    font-size:
        12px;
    font-weight:
        700;
}
.info-nombre {
    color:
        #777;
    font-size:
        13px;
    word-break:
        break-all;
}
/* =====================================================
   INPUT FILE
   ===================================================== */
input[type="file"] {
    display:
        none;
}
/* =====================================================
   SELECTOR DE NUEVA IMAGEN
   ===================================================== */
.selector-archivo {
    width:
        100%;
    min-height:
        120px;
    border:
        2px dashed #c5a46d;
    border-radius:
        18px;
    background:
        rgba(255,255,255,0.55);
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
    padding:
        18px;
    transition:
        0.3s ease;
}
.selector-archivo:hover {
    background:
        #fff8ed;
    border-color:
        #364e63;
    transform:
        translateY(-2px);
    box-shadow:
        0 8px 20px
        rgba(54,78,99,0.15);
}
/* =====================================================
   ICONO
   ===================================================== */
.icono-archivo {
    font-size:
        34px;
    margin-bottom:
        6px;
}
/* =====================================================
   TEXTO
   ===================================================== */
.texto-archivo {
    color:
        #364e63;
    font-weight:
        700;
    font-size:
        16px;
}
.texto-secundario {
    color:
        #777;
    font-size:
        12px;
    margin-top:
        5px;
}
/* =====================================================
   NUEVA IMAGEN SELECCIONADA
   ===================================================== */
.nueva-imagen {
    display:
        none;
    align-items:
        center;
    gap:
        12px;
    padding:
        10px;
    background:
        rgba(197,164,109,0.15);
    border:
        1px solid #c5a46d;
    border-radius:
        15px;
}
.miniatura-nueva {
    width:
        65px;
    height:
        65px;
    object-fit:
        cover;
    border-radius:
        12px;
    border:
        2px solid #364e63;
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
        #364e63;
    font-size:
        12px;
    font-weight:
        700;
}
.nueva-nombre {
    color:
        #777;
    font-size:
        13px;
    word-break:
        break-all;
}
/* =====================================================
   BOTÓN ACTUALIZAR
   ===================================================== */
input[type="submit"] {
    grid-area:
        boton;
    margin-top:
        15px;
    padding:
        16px;
    background:
        #364e63;
    color:
        #f5e9d8;
    border:
        2px solid #364e63;
    border-radius:
        14px;
    font-size:
        19px;
    font-family:
        "Playfair Display",
        serif;
    cursor:
        pointer;
    transition:
        0.35s ease;
    font-weight:
        700;
}
input[type="submit"]:hover {
    background:
        #c5a46d;
    color:
        #364e63;
    border-color:
        #c5a46d;
    transform:
        scale(1.04);
}
/* =====================================================
   ERRORES
   ===================================================== */
.error {
    color:
        #b94b4b;
    font-size:
        13px;
}
/* =====================================================
   RESPONSIVE
   ===================================================== */
@media (max-width:768px) {
    form {
        grid-template-columns:
            1fr;
        grid-template-areas:
            "imagen"
            "titulo"
            "leyenda"
            "campos"
            "boton";
        padding:
            25px;
    }
    .imagen {
        min-height:
            250px;
    }
    h2 {
        text-align:
            center;
        width:
            100%;
        font-size:
            28px;
    }
}
</style>
</head>
<body>
<form
    action="updateprodu.php"
    method="POST"
    enctype="multipart/form-data"
>
    <!-- =================================================
         IMAGEN GRANDE ACTUAL
         ================================================= -->
    <div
        class="imagen"
        id="imagenPrincipal"
    ></div>
    <!-- =================================================
         TÍTULO
         ================================================= -->
    <h2>
        MODIFICACIÓN DE PRODUCTO DIVINE
    </h2>
    <legend>
        PRODUCTO A MODIFICAR:
    </legend>
    <div class="grupo-campos">
        <!-- =================================================
             NOMBRE
             ================================================= -->
        <label>
            Nombre:
        </label>

        <input
            type="text"
            name="nombre"
            value="<?= htmlspecialchars($nombre) ?>"
            required
        >


        <!-- =================================================
             DESCRIPCIÓN
             ================================================= -->

        <label>

            Descripción:

        </label>

        <input
            type="text"
            name="descripcion"
            value="<?= htmlspecialchars($descripcion) ?>"
            required
        >





        <label>

            Categoría:

        </label>

        <input
            type="text"
            name="categoria"
            value="<?= htmlspecialchars($categoria) ?>"
            required
        >


        <!-- =================================================
             PRECIO
             ================================================= -->

        <label>

            Precio:

        </label>

        <input
            type="number"
            name="precio"
            value="<?= htmlspecialchars($precio) ?>"
            required
        >


        <!-- =================================================
             COSTO
             ================================================= -->

        <label>

            Costo:

        </label>

        <input
            type="number"
            name="costo"
            value="<?= htmlspecialchars($costo) ?>"
            required
        >


        <!-- =================================================
             STOCK
             ================================================= -->

        <label>

            Stock:

        </label>

        <input
            type="number"
            name="stock"
            value="<?= htmlspecialchars($stock) ?>"
            required
        >


        <!-- =================================================
             CÓDIGO
             ================================================= -->

        <label>

            Código:

        </label>

        <input
            type="number"
            name="codigo"
            value="<?= htmlspecialchars($codigo) ?>"
            required
        >


        <!-- =================================================
             IMAGEN
             ================================================= -->

        <div class="carga-imagen">


            <label>

                Imagen del producto:

            </label>


            <!-- =============================================
                 IMAGEN ACTUAL
                 ============================================= -->

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


            <!-- =============================================
                 SELECTOR DE NUEVA IMAGEN
                 ============================================= -->

            <label
                for="fileToUpload"
                class="selector-archivo"
            >


                <div class="icono-archivo">

                    📷

                </div>


                <div class="texto-archivo">

                    Seleccionar nueva imagen

                </div>


                <div class="texto-secundario">

                    Haz clic aquí para reemplazarla

                </div>


            </label>


            <input
                type="file"
                id="fileToUpload"
                name="fileToUpload"
                accept="image/*"
            >


            <!-- =============================================
                 PREVIEW DE LA NUEVA IMAGEN
                 ============================================= -->

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

                        NUEVA IMAGEN SELECCIONADA

                    </div>


                    <div
                        class="nueva-nombre"
                        id="nombreNuevaImagen"
                    >

                    </div>


                </div>


            </div>


        </div>


    </div>


    <!-- =================================================
         BOTÓN ACTUALIZAR
         ================================================= -->

    <input
        type="submit"
        value="Actualizar"
    >


</form>


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


                        /*
                            MINIATURA
                        */

                        miniaturaNueva.src =
                            evento.target.result;


                        /*
                            CAMBIAR TEMPORALMENTE
                            LA IMAGEN GRANDE
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

</script>


<script>

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
                    "Por favor, ingresa un número válido para el precio.",

                min:
                    "El precio no puede ser negativo."

            },


            costo: {

                required:
                    "Por favor, ingresa el costo del producto.",

                number:
                    "Por favor, ingresa un número válido para el costo.",

                min:
                    "El costo no puede ser negativo."

            },


            stock: {

                required:
                    "Por favor, ingresa la cantidad en stock del producto.",

                number:
                    "Por favor, ingresa un número válido para el stock.",

                min:
                    "El stock no puede ser negativo."

            },


            codigo: {

                required:
                    "Por favor, ingresa el código del producto.",

                number:
                    "Por favor, ingresa un número válido para el código.",

                min:
                    "El código no puede ser negativo."
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