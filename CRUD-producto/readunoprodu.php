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
    die("Ocurrió un error al conectar con la base de datos.");
}


// =====================================================
// RECIBIR CÓDIGO
// =====================================================

$codigo = isset($_GET['codigo']) ? intval($_GET['codigo']) : 0;


// =====================================================
// CONSULTAR PRODUCTO
// =====================================================

$stmt = $conn->prepare(
    "SELECT * FROM PRODUCTO WHERE codigo = ?"
);

$stmt->bind_param("i", $codigo);
$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows > 0) {


// =====================================================
// BUSCAR IMAGEN DEL PRODUCTO
// =====================================================

$nombreArchivo = "p-" . $codigo;

$directorio = "../PRODUCTO-img/";

$extensiones = [
    "jpg",
    "jpeg",
    "png",
    "gif"
];

$imagenProducto = null;


foreach ($extensiones as $extension) {

    $ruta =
        $directorio .
        $nombreArchivo .
        "." .
        $extension;

    if (file_exists($ruta)) {

        $imagenProducto = $ruta;

        break;
    }
}


// =====================================================
// IMAGEN DE RESPALDO
// =====================================================

if ($imagenProducto === null) {

    $imagenProducto =
        "https://i.pinimg.com/1200x/43/31/47/433147cd3e9cdb74e27685ddbace85e8.jpg";
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<title>
    Producto | DIVINE
</title>


<!-- FUENTES -->

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* =====================================================
   VARIABLES
   ===================================================== */

:root {

    --rosa: #d99aaa;
    --rosa-claro: #f6dfe4;
    --rosa-muy-claro: #fff7f8;

    --crema: #fffaf5;

    --dorado: #c8a56a;
    --dorado-claro: #e8d1a4;

    --vino: #744653;

    --texto: #40343a;

    --blanco: #ffffff;

    --sombra:
        0 20px 50px rgba(116, 70, 83, 0.15);
}


/* =====================================================
   RESET
   ===================================================== */

* {
    box-sizing: border-box;
}


body {

    margin: 0;

    min-height: 100vh;

    font-family:
        "DM Sans",
        sans-serif;

    color: var(--texto);

    background:

        radial-gradient(
            circle at top left,
            #f9dce4 0%,
            transparent 35%
        ),

        radial-gradient(
            circle at bottom right,
            #f0dfc0 0%,
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #fff8f5,
            #f7e8e5
        );

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 40px 20px;

}


/* =====================================================
   CONTENEDOR PRINCIPAL
   ===================================================== */

.contenedor {

    width: 100%;

    max-width: 1050px;

    background:
        rgba(255, 255, 255, 0.88);

    backdrop-filter:
        blur(12px);

    border:
        1px solid rgba(255,255,255,0.8);

    border-radius:
        35px;

    box-shadow:
        var(--sombra);

    padding:
        35px;

    display:
        grid;

    grid-template-columns:
        0.95fr 1.05fr;

    gap:
        45px;

    position:
        relative;

    overflow:
        hidden;

}


/* decoración */

.contenedor::before {

    content: "♡";

    position: absolute;

    top: -25px;

    right: 35px;

    font-size: 130px;

    color:
        rgba(217,154,170,0.10);

    font-family:
        Georgia,
        serif;

}


/* =====================================================
   IMAGEN
   ===================================================== */

.imagen {

    min-height:
        520px;

    border-radius:
        28px;

    background-image:
        url('<?php echo htmlspecialchars($imagenProducto); ?>');

    background-position:
        center;

    background-size:
        cover;

    background-repeat:
        no-repeat;

    box-shadow:
        0 15px 35px
        rgba(116,70,83,0.20);

    position:
        relative;

    overflow:
        hidden;

    transition:
        transform 0.4s ease;

}


.imagen:hover {

    transform:
        scale(1.02);

}


/* capa sobre la imagen */

.imagen::after {

    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(70,35,45,0.20),
            transparent 45%
        );

}


/* =====================================================
   INFORMACIÓN
   ===================================================== */

.informacion {

    display:
        flex;

    flex-direction:
        column;

    justify-content:
        center;

    position:
        relative;

    z-index:
        2;

}


/* pequeño encabezado */

.subtitulo {

    color:
        var(--rosa);

    font-size:
        13px;

    font-weight:
        600;

    letter-spacing:
        4px;

    text-transform:
        uppercase;

    margin-bottom:
        10px;

}


/* =====================================================
   TÍTULO
   ===================================================== */

.titulo {

    font-family:
        "Playfair Display",
        serif;

    color:
        var(--vino);

    font-size:
        clamp(34px, 5vw, 52px);

    line-height:
        1.1;

    margin:
        0 0 15px;

    font-weight:
        600;

}


.linea {

    width:
        70px;

    height:
        3px;

    background:
        linear-gradient(
            90deg,
            var(--rosa),
            var(--dorado)
        );

    border-radius:
        20px;

    margin-bottom:
        30px;

}


/* =====================================================
   TARJETA DE DATOS
   ===================================================== */

.item {

    background:
        rgba(255,248,248,0.9);

    border:
        1px solid
        rgba(217,154,170,0.25);

    border-radius:
        24px;

    padding:
        25px;

    box-shadow:
        0 10px 30px
        rgba(116,70,83,0.08);

}


/* =====================================================
   DATOS
   ===================================================== */

.item p {

    margin:
        0;

    padding:
        14px 0;

    border-bottom:
        1px solid
        rgba(200,165,106,0.18);

    display:
        flex;

    justify-content:
        space-between;

    gap:
        20px;

    font-size:
        15px;

    line-height:
        1.5;

}


.item p:last-child {

    border-bottom:
        none;

}


.item span {

    color:
        var(--vino);

    font-weight:
        600;

    min-width:
        110px;

}


.item p {

    color:
        #66565d;

}


/* =====================================================
   PRECIO
   ===================================================== */

.item p:nth-of-type(4) {

    background:
        linear-gradient(
            90deg,
            #fff1f4,
            #fffaf5
        );

    margin:
        5px -10px;

    padding:
        15px 10px;

    border-radius:
        12px;

}


.item p:nth-of-type(4) span {

    color:
        var(--rosa);

}


.item p:nth-of-type(4) {

    font-size:
        18px;

    font-weight:
        600;

}


/* =====================================================
   BOTONES
   ===================================================== */

.botones {

    display:
        flex;

    gap:
        12px;

    margin-top:
        25px;

}


.boton {

    flex:
        1;

    text-align:
        center;

    text-decoration:
        none;

    padding:
        13px 20px;

    border-radius:
        30px;

    font-size:
        14px;

    font-weight:
        600;

    transition:
        all 0.3s ease;

}


/* editar */

.boton:first-child {

    background:
        var(--vino);

    color:
        white;

    border:
        1px solid var(--vino);

}


.boton:first-child:hover {

    background:
        var(--rosa);

    border-color:
        var(--rosa);

    transform:
        translateY(-3px);

    box-shadow:
        0 8px 20px
        rgba(217,154,170,0.35);

}


/* eliminar */

.boton:last-child {

    background:
        transparent;

    color:
        #a45b69;

    border:
        1px solid #d9a3ad;

}


.boton:last-child:hover {

    background:
        #f9e1e5;

    transform:
        translateY(-3px);

}


/* =====================================================
   NAVEGACIÓN
   ===================================================== */

.navegacion {

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        center;

    margin-top:
        20px;

    gap:
        15px;

}


.boton2 {

    text-decoration:
        none;

    color:
        var(--vino);

    font-size:
        14px;

    font-weight:
        600;

    padding:
        10px 5px;

    transition:
        all 0.3s ease;

}


.boton2:hover {

    color:
        var(--rosa);

    transform:
        translateX(-3px);

}


.boton2:first-child:hover {

    transform:
        translateY(-2px);

}


/* =====================================================
   DETALLE DORADO
   ===================================================== */

.decoracion {

    display:
        flex;

    align-items:
        center;

    gap:
        10px;

    margin:
        20px 0;

    color:
        var(--dorado);

    font-size:
        18px;

}


.decoracion::before,
.decoracion::after {

    content: "";

    height:
        1px;

    flex:
        1;

    background:
        linear-gradient(
            90deg,
            transparent,
            var(--dorado-claro)
        );

}


.decoracion::after {

    background:
        linear-gradient(
            90deg,
            var(--dorado-claro),
            transparent
        );

}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 850px) {

    .contenedor {

        grid-template-columns:
            1fr;

        max-width:
            600px;

        padding:
            25px;

        gap:
            30px;

    }


    .imagen {

        min-height:
            380px;

    }

}


@media (max-width: 500px) {

    body {

        padding:
            20px 12px;

    }


    .contenedor {

        padding:
            18px;

        border-radius:
            25px;

    }


    .imagen {

        min-height:
            300px;

        border-radius:
            20px;

    }


    .titulo {

        font-size:
            35px;

    }


    .item {

        padding:
            18px;

    }


    .item p {

        flex-direction:
            column;

        gap:
            4px;

    }


    .botones {

        flex-direction:
            column;

    }


    .navegacion {

        flex-direction:
            column;

        align-items:
            center;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =================================================
         IMAGEN
         ================================================= -->

    <div
        class="imagen"
        aria-label="Imagen del producto"
    ></div>


    <!-- =================================================
         INFORMACIÓN
         ================================================= -->

    <div class="informacion">


        <div class="subtitulo">
            DIVINE · COLLECTION
        </div>


        <h1 class="titulo">
            Detalle del producto
        </h1>


        <div class="linea"></div>


        <div class="item">


<?php

while ($fila = $resultado->fetch_assoc()) {

    echo "

        <p>

            <span>
                Nombre
            </span>

            "
            . htmlspecialchars($fila['nombre'])
            . "

        </p>


        <p>

            <span>
                Descripción
            </span>

            "
            . htmlspecialchars($fila['descripcion'])
            . "

        </p>


        <p>

            <span>
                Categoría
            </span>

            "
            . htmlspecialchars($fila['categoria'])
            . "

        </p>


        <p>

            <span>
                Precio
            </span>

            $"
            . htmlspecialchars($fila['precio'])
            . "

        </p>


        <p>

            <span>
                Costo
            </span>

            $"
            . htmlspecialchars($fila['costo'])
            . "

        </p>


        <p>

            <span>
                Stock
            </span>

            "
            . htmlspecialchars($fila['stock'])
            . "

        </p>


        <p>

            <span>
                Código
            </span>

            #"
            . htmlspecialchars($fila['codigo'])
            . "

        </p>

    ";

    $codigo = $fila['codigo'];
}

?>


        </div>


        <div class="decoracion">
            ♡
        </div>


        <!-- =================================================
             BOTONES
             ================================================= -->

        <div class="botones">


            <a
                href="updateformprodu.php?codigo=<?php echo $codigo; ?>"
                class="boton"
            >
                ✦ Editar producto
            </a>


            <a
                href="deleteprodu.php?codigo=<?php echo $codigo; ?>"
                class="boton"
                onclick="return confirm('¿Estás segura de que deseas eliminar este producto?');"
            >
                ♡ Eliminar
            </a>


        </div>


        <!-- =================================================
             NAVEGACIÓN
             ================================================= -->

        <div class="navegacion">


            <a
                href="readtodoprodu.php"
                class="boton2"
            >
                ← Ver productos
            </a>


            <a
                href="../totu.php"
                class="boton2"
            >
                Volver al inicio
            </a>


        </div>


    </div>

</div>


</body>

</html>


<?php

} else {

    echo "

        <div style='
            font-family:Arial;
            text-align:center;
            padding:50px;
        '>

            <h2>
                Producto no encontrado ♡
            </h2>

            <a href='readtodoprodu.php'>
                Volver a productos
            </a>

        </div>

    ";
}


$stmt->close();

$conn->close();

?>
