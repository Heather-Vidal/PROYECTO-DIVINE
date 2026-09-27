<?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

/* ==================================================
   CONEXIÓN A LA BASE DE DATOS
================================================== */

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);

if ($conn->connect_error) {

    die(
        "OCURRIÓ UN ERROR AL CONECTAR CON LA BASE DE DATOS: "
        . $conn->connect_error
    );

}

$conn->set_charset("utf8mb4");


/* ==================================================
   CONSULTAR PRODUCTOS
================================================== */

$sql = "SELECT * FROM PRODUCTO";

$resultado = $conn->query($sql);

if (!$resultado) {

    die(
        "Error al consultar los productos: "
        . $conn->error
    );

}


/* ==================================================
   CREAR LISTA DE IMÁGENES PARA AJAX
   UTILIZANDO EL MISMO SISTEMA DE ESTE ARCHIVO
================================================== */

$imagenesAjax = [];

$resultadoImagenes = $conn->query(
    "SELECT codigo FROM PRODUCTO"
);

if ($resultadoImagenes) {

    while ($productoImagen = $resultadoImagenes->fetch_assoc()) {

        $codigoImagen = $productoImagen['codigo'];

        $directorioImagen = "./PRODUCTO-img/";

        $nombreArchivoImagen = "p-" . $codigoImagen;

        $extensionesImagen = [
            "jpg",
            "jpeg",
            "png",
            "gif"
        ];

        foreach ($extensionesImagen as $extensionImagen) {

            $rutaImagen =
                $directorioImagen .
                $nombreArchivoImagen .
                "." .
                $extensionImagen;

            if (file_exists($rutaImagen)) {

                $imagenesAjax[$codigoImagen] = $rutaImagen;

                break;
            }

        }

    }

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

<title>DIVINE | Beauty Store</title>


<style>

/* ==================================================
   VARIABLES
================================================== */

:root {

    --rosa: #b86f80;
    --rosa-oscuro: #9f596b;
    --rosa-claro: #d9a6b2;
    --rosa-palido: #f7e9ec;

    --crema: #fffaf8;

    --texto: #4d4143;
    --gris: #817679;

    --borde: #ead7dc;

    --blanco: #ffffff;

}


/* ==================================================
   RESET
================================================== */

* {

    margin: 0;
    padding: 0;

    box-sizing: border-box;

}


/* ==================================================
   BODY
================================================== */

body {

    background: var(--crema);

    color: var(--texto);

    font-family: 'Segoe UI', sans-serif;

}


/* ==================================================
   HERO
================================================== */

.hero {

    min-height: 520px;

    background:

        linear-gradient(
            to right,
            rgba(255,250,248,.88),
            rgba(255,250,248,.35),
            rgba(255,250,248,.05)
        ),

        url("./imagenes/catalogo.jpg");

    background-size: cover;

    background-position: center;

    display: flex;

    align-items: center;

    padding: 60px 8%;

    animation: aparecerHero 1s ease;

}


.hero-content {

    max-width: 520px;

}


.hero-linea {

    width: 60px;

    height: 2px;

    background: var(--rosa);

    margin-bottom: 25px;

}


.hero h1 {

    font-family: Georgia, serif;

    font-size: clamp(3.5rem, 7vw, 6rem);

    font-weight: 400;

    letter-spacing: 12px;

    color: var(--rosa);

    line-height: 1;

}


.hero p {

    margin-top: 25px;

    font-size: 1.05rem;

    letter-spacing: 1px;

    color: #66595c;

    line-height: 1.8;

    max-width: 420px;

}


/* ==================================================
   RESULTADOS AJAX
================================================== */

#productos {

    max-width: 1450px;

    margin: 0 auto;

    padding: 35px 50px 5px;

    display: grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(280px, 1fr)
        );

    gap: 30px;

}


/* ==================================================
   TARJETA AJAX
================================================== */

#productos .resultado-busqueda {

    position: relative;

    background: #ffffff;

    border: 1px solid var(--borde);

    border-radius: 22px;

    overflow: hidden;

    box-shadow:
        0 10px 30px rgba(100,70,80,.08);

    transition:
        transform .35s ease,
        box-shadow .35s ease;

    animation:
        aparecerResultado .5s ease both;

}


#productos .resultado-busqueda:hover {

    transform: translateY(-8px);

    box-shadow:
        0 20px 45px rgba(100,70,80,.15);

}


/* ==================================================
   IMAGEN AJAX
================================================== */

#productos .resultado-imagen {

    width: 100%;

    height: 280px;

    overflow: hidden;

    position: relative;

    background:

        linear-gradient(
            135deg,
            #f9e9ed,
            #f3d8df
        );

}


#productos .resultado-imagen img {

    width: 100%;

    height: 100%;

    display: block;

    object-fit: cover;

    transition:
        transform .6s ease;

}


#productos
.resultado-busqueda:hover
.resultado-imagen img {

    transform: scale(1.06);

}


/* ==================================================
   CORAZÓN SOBRE LA IMAGEN
================================================== */

#productos .resultado-imagen::after {

    content: "♡";

    position: absolute;

    top: 15px;

    right: 15px;

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background:
        rgba(255,255,255,.92);

    color: var(--rosa);

    font-size: 22px;

    box-shadow:
        0 5px 15px rgba(100,70,80,.13);

    z-index: 2;

}


/* ==================================================
   INFORMACIÓN AJAX
================================================== */

#productos .resultado-info {

    padding: 24px 25px 25px;

}


#productos .resultado-etiqueta {

    display: block;

    text-align: center;

    margin-bottom: 8px;

    color: var(--rosa);

    font-size: .68rem;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 3px;

}


#productos .resultado-info h3 {

    font-family: Georgia, serif;

    color: #57494c;

    font-size: 1.4rem;

    font-weight: 700;

    text-align: center;

    margin-bottom: 12px;

    line-height: 1.3;

}


#productos .resultado-descripcion {

    color: var(--gris);

    font-size: .88rem;

    line-height: 1.7;

    min-height: 50px;

    margin-bottom: 18px;

}


/* ==================================================
   PARTE INFERIOR AJAX
================================================== */

#productos .resultado-abajo {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding-top: 5px;

}


/* ==================================================
   PRECIO AJAX
================================================== */

#productos .resultado-precio {

    font-family: Georgia, serif;

    font-size: 1.4rem;

    font-weight: 600;

    color: var(--rosa);

    white-space: nowrap;

}


/* ==================================================
   BOTÓN AJAX
================================================== */

#productos .resultado-boton {

    display: flex;

    align-items: center;

    justify-content: center;

    min-height: 44px;

    padding: 0 18px;

    border-radius: 10px;

    background: var(--rosa);

    color: white;

    text-decoration: none;

    font-size: .82rem;

    font-weight: 600;

    letter-spacing: .2px;

    border: 1px solid var(--rosa);

    transition:
        background .3s ease,
        color .3s ease,
        transform .3s ease,
        box-shadow .3s ease;

}


#productos .resultado-boton:hover {

    background: transparent;

    color: var(--rosa);

    transform: translateY(-2px);

    box-shadow:
        0 7px 18px rgba(184,111,128,.12);

}


/* ==================================================
   MENSAJE SIN RESULTADOS
================================================== */

#productos .busqueda-vacia {

    grid-column: 1 / -1;

    padding: 55px 30px;

    text-align: center;

    background: rgba(255,255,255,.92);

    border: 1px solid var(--borde);

    border-radius: 22px;

    color: var(--gris);

    box-shadow:
        0 8px 25px rgba(100,70,80,.06);

}


#productos .busqueda-vacia-icono {

    width: 65px;

    height: 65px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: var(--rosa-palido);

    color: var(--rosa);

    font-size: 31px;

}


#productos .busqueda-vacia h3 {

    font-family: Georgia, serif;

    color: #57494c;

    font-size: 1.45rem;

    margin-bottom: 8px;

}


#productos .busqueda-vacia p {

    font-size: .9rem;

    color: var(--gris);

}


/* ==================================================
   SECCIÓN
================================================== */

.section {

    max-width: 1450px;

    margin: auto;

    padding: 90px 50px;

}


/* ==================================================
   ENCABEZADO
================================================== */

.encabezado {

    text-align: center;

    margin-bottom: 60px;

}


.encabezado-pequeno {

    color: var(--rosa);

    font-size: .8rem;

    text-transform: uppercase;

    letter-spacing: 4px;

    margin-bottom: 15px;

}


.titulo {

    font-family: Georgia, serif;

    font-size: 2.5rem;

    font-weight: 400;

    color: #57494c;

}


.linea-decorativa {

    width: 45px;

    height: 2px;

    background: var(--rosa-claro);

    margin: 22px auto 0;

}


/* ==================================================
   GRID DE PRODUCTOS
================================================== */

.grid {

    display: grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(280px, 1fr)
        );

    gap: 35px;

}


/* ==================================================
   TARJETA NORMAL
================================================== */

.card {

    background: #ffffff;

    border-radius: 18px;

    overflow: hidden;

    border: 1px solid var(--borde);

    box-shadow:
        0 8px 30px rgba(100,70,80,.06);

    transition:
        transform .45s ease,
        box-shadow .45s ease;

}


.card:hover {

    transform: translateY(-8px);

    box-shadow:
        0 20px 45px rgba(100,70,80,.13);

}


/* ==================================================
   IMAGEN NORMAL
================================================== */

.imagen-producto {

    height: 300px;

    overflow: hidden;

    background: var(--rosa-palido);

    position: relative;

}


.imagen-producto img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    display: block;

    transition:
        transform .7s ease;

}


.card:hover
.imagen-producto img {

    transform: scale(1.06);

}


/* ==================================================
   PLACEHOLDER
================================================== */

.placeholder {

    width: 100%;

    height: 100%;

    display: flex;

    justify-content: center;

    align-items: center;

    color: var(--rosa);

    font-family: Georgia, serif;

    font-size: 1rem;

}


/* ==================================================
   INFORMACIÓN NORMAL
================================================== */

.info {

    padding: 27px 25px 25px;

}


.info h3 {

    font-family: Georgia, serif;

    font-size: 1.4rem;

    font-weight: 700;

    color: #57494c;

    text-align: center;

    margin-bottom: 14px;

    line-height: 1.3;

}


.descripcion {

    color: var(--gris);

    font-size: .9rem;

    line-height: 1.7;

    min-height: 50px;

    margin-bottom: 20px;

}


.precio {

    font-family: Georgia, serif;

    font-size: 1.5rem;

    color: var(--rosa);

    margin-bottom: 20px;

}


/* ==================================================
   BOTÓN CARRITO NORMAL
================================================== */

.btn-carrito {

    display: flex;

    justify-content: center;

    align-items: center;

    width: 100%;

    height: 48px;

    border-radius: 8px;

    background: var(--rosa);

    color: white;

    font-size: .9rem;

    font-weight: 600;

    letter-spacing: .5px;

    text-decoration: none;

    border: 1px solid var(--rosa);

    transition:
        background .3s ease,
        color .3s ease,
        transform .3s ease;

}


.btn-carrito:hover {

    background: transparent;

    color: var(--rosa);

    transform: translateY(-2px);

}


/* ==================================================
   STOCK
================================================== */

.stock {

    text-align: center;

    margin-top: 14px;

    font-size: .78rem;

    color: #9a8b8f;

    letter-spacing: .3px;

}


.stock strong {

    color: var(--rosa);

    font-weight: 600;

}


.stock.ultimas {

    color: #a57c55;

}


.stock.ultimas strong {

    color: #a57c55;

}


.stock.agotado {

    color: #999;

}


/* ==================================================
   BOTÓN AGOTADO
================================================== */

.btn-agotado {

    background: #e2dfe0;

    border-color: #e2dfe0;

    color: #888;

    cursor: not-allowed;

}


.btn-agotado:hover {

    background: #e2dfe0;

    border-color: #e2dfe0;

    color: #888;

    transform: none;

}


/* ==================================================
   SIN PRODUCTOS
================================================== */

.sin-productos {

    grid-column: 1 / -1;

    padding: 80px 30px;

    text-align: center;

    background: white;

    border: 1px solid var(--borde);

    border-radius: 18px;

    color: var(--gris);

}


/* ==================================================
   ANIMACIÓN RESULTADOS
================================================== */

@keyframes aparecerResultado {

    from {

        opacity: 0;

        transform:
            translateY(20px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


/* ==================================================
   ANIMACIONES PRODUCTOS
================================================== */

.animar {

    opacity: 0;

    transform:
        translateY(25px);

}


.animar.activo {

    opacity: 1;

    transform:
        translateY(0);

    transition:
        opacity .7s ease,
        transform .7s ease;

}


/* ==================================================
   ANIMACIÓN HERO
================================================== */

@keyframes aparecerHero {

    from {

        opacity: 0;

        transform:
            scale(1.02);

    }

    to {

        opacity: 1;

        transform:
            scale(1);

    }

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width: 768px) {

    .hero {

        min-height: 500px;

        padding:
            50px 30px;

        background-position:
            65% center;

    }


    .hero h1 {

        font-size: 3.5rem;

        letter-spacing: 8px;

    }


    .hero p {

        font-size: .95rem;

    }


    .section {

        padding:
            65px 20px;

    }


    .titulo {

        font-size:
            2rem;

    }


    .grid {

        grid-template-columns:
            1fr;

        gap:
            25px;

    }


    .imagen-producto {

        height:
            280px;

    }


    #productos {

        padding:
            25px 20px 10px;

        grid-template-columns:
            1fr;

        gap:
            25px;

    }


    #productos .resultado-imagen {

        height:
            280px;

    }


    #productos .resultado-abajo {

        flex-direction:
            column;

        align-items:
            stretch;

    }


    #productos .resultado-precio {

        text-align:
            center;

    }


    #productos .resultado-boton {

        width:
            100%;

    }

}

</style>

</head>


<body>


<?php

include 'submenuespecial.php';

?>


<!-- ==================================================
     IMÁGENES DISPONIBLES PARA EL BUSCADOR
     SE GENERAN DESDE EL MISMO PHP
================================================== -->

<script>

const imagenesProductos =
<?php

echo json_encode(
    $imagenesAjax,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);

?>;

</script>


<!-- ==================================================
     JAVASCRIPT DEL BUSCADOR
================================================== -->

<script src="./AJAX/buscar.js"></script>


<!-- ==================================================
     RESULTADOS DEL BUSCADOR AJAX
================================================== -->

<div id="productos"></div>


<!-- ==================================================
     HERO
================================================== -->

<section class="hero">

    <div class="hero-content">

        <div class="hero-linea"></div>

        <h1>
            DIVINE
        </h1>

        <p>

            Una selección especial de productos
            para el cuidado, hidratación y
            bienestar de tu piel.

        </p>

    </div>

</section>


<!-- ==================================================
     PRODUCTOS
================================================== -->

<section class="section">


    <div class="encabezado">

        <div class="encabezado-pequeno">

            Nuestra colección

        </div>


        <h2 class="titulo">

            Productos seleccionados

        </h2>


        <div class="linea-decorativa"></div>

    </div>


    <div class="grid">


<?php

if ($resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {


        /* ==================================================
           OBTENER CÓDIGO
        ================================================== */

        $codigo = $fila['codigo'];


        /* ==================================================
           OBTENER STOCK
        ================================================== */

        $stock = (int)$fila['stock'];


        /* ==================================================
           BUSCAR IMAGEN
        ================================================== */

        $directorio = "./PRODUCTO-img/";

        $nombreArchivo = "p-" . $codigo;

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

?>


        <!-- ==================================================
             PRODUCTO
        ================================================== -->

        <div class="card animar">


            <!-- IMAGEN -->

            <div class="imagen-producto">


<?php

if ($imagenProducto !== null) {

?>

                <img

                    src="<?php

                    echo htmlspecialchars(
                        $imagenProducto
                    );

                    ?>"

                    alt="<?php

                    echo htmlspecialchars(
                        $fila['nombre']
                    );

                    ?>"

                >

<?php

} else {

?>

                <div class="placeholder">

                    Imagen del producto

                </div>

<?php

}

?>

            </div>


            <!-- INFORMACIÓN -->

            <div class="info">


                <h3>

                    <?php

                    echo htmlspecialchars(
                        $fila['nombre']
                    );

                    ?>

                </h3>


                <p class="descripcion">

                    <?php

                    echo htmlspecialchars(
                        $fila['descripcion']
                    );

                    ?>

                </p>


                <div class="precio">

                    Bs

                    <?php

                    echo htmlspecialchars(
                        $fila['precio']
                    );

                    ?>

                </div>


<?php

if ($stock <= 0) {

?>

                <div class="btn-carrito btn-agotado">

                    Producto agotado

                </div>

<?php

} else {

?>

                <a

                    href="./CRUD-CARRITO-PEDIDO/formpedido.php?codigo=<?php

                    echo htmlspecialchars(
                        $codigo
                    );

                    ?>"

                    class="btn-carrito"

                >

                    Agregar al carrito

                </a>

<?php

}


if ($stock <= 0) {

?>

                <div class="stock agotado">

                    Producto agotado

                </div>

<?php

} elseif ($stock <= 5) {

?>

                <div class="stock ultimas">

                    Últimas unidades:

                    <strong>

                        <?php

                        echo $stock;

                        ?>

                    </strong>

                    unidades disponibles

                </div>

<?php

} else {

?>

                <div class="stock">

                    Stock disponible:

                    <strong>

                        <?php

                        echo $stock;

                        ?>

                    </strong>

                    unidades

                </div>

<?php

}

?>


            </div>

        </div>


<?php

    }

} else {

?>


        <div class="sin-productos">

            No hay productos disponibles
            en este momento.

        </div>


<?php

}

?>


    </div>

</section>


<?php

include 'submenpiepag.php';

?>


<!-- ==================================================
     ANIMACIÓN DE PRODUCTOS
================================================== -->

<script>

const elementos =
    document.querySelectorAll(
        '.animar'
    );


const observador =
    new IntersectionObserver(

        (entradas) => {

            entradas.forEach(

                (entrada) => {

                    if (
                        entrada.isIntersecting
                    ) {

                        entrada
                            .target
                            .classList
                            .add(
                                'activo'
                            );

                    }

                }

            );

        },

        {
            threshold: 0.12
        }

    );


elementos.forEach(

    (elemento) => {

        observador.observe(
            elemento
        );

    }

);

</script>


</body>

</html>


<?php

$conn->close();

?>