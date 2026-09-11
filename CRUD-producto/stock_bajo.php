 
<?php

session_start();

/* =========================================================
   VALIDAR SESIÓN
========================================================= */

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] == null) {

    header("Location: ../SESIONES/loginformcliente.php");
    exit();

}


/* =========================================================
   DATOS DE SESIÓN
========================================================= */

$nombreUsuario = $_SESSION['nombre'];
$rol = $_SESSION['rol'] ?? '';



/* =========================================================
   CONEXIÓN A BASE DE DATOS
========================================================= */

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

    die(
        "Error de conexión con la base de datos: "
        . $conn->connect_error
    );

}


$conn->set_charset("utf8");



/* =========================================================
   CONSULTAR PRODUCTOS CON STOCK BAJO
=========================================================

   STOCK BAJO = 5 O MENOS

========================================================= */

$sql = "

    SELECT *

    FROM PRODUCTO

    WHERE stock <= 5

    ORDER BY stock ASC, nombre ASC

";


$resultado = $conn->query($sql);


if (!$resultado) {

    die(
        "Error en la consulta: "
        . $conn->error
    );

}



/* =========================================================
   CONTADORES
========================================================= */

$totalProductos = $resultado->num_rows;

$agotados = 0;

$stockCritico = 0;

$stockBajo = 0;



/* =========================================================
   CALCULAR ESTADÍSTICAS
========================================================= */

$productos = [];



while ($fila = $resultado->fetch_assoc()) {

    $productos[] = $fila;

    $stock = (int)$fila["stock"];


    if ($stock <= 0) {

        $agotados++;

    }
    elseif ($stock <= 2) {

        $stockCritico++;

    }
    else {

        $stockBajo++;

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


<title>

Productos con Stock Bajo | DIVINE

</title>



<!-- =====================================================
     FUENTES
====================================================== -->

<link
href="https://fonts.cdnfonts.com/css/bestigia"
rel="stylesheet"
>


<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet"
>



<style>


/* =========================================================
   VARIABLES
========================================================= */

:root{

    --rosa-suave:#fdf0f4;

    --rosa-claro:#fbe3eb;

    --rosa:#f2a6bf;

    --rosa-fuerte:#e06d92;

    --vino:#8c3b58;

    --vino-oscuro:#5c1d33;

    --crema:#fffafc;

    --blanco:#ffffff;

    --borde:#f3c2d4;

    --texto:#5c1d33;

    --gris:#987383;

    --verde:#6c9a78;

    --rojo:#c94b67;

    --amarillo:#c79545;

    --sombra:
        0 12px 30px
        rgba(180,100,130,.13);

}



/* =========================================================
   GENERAL
========================================================= */

*{

    margin:0;

    padding:0;

    box-sizing:border-box;

    font-family:'Poppins',sans-serif;

}


body{

    min-height:100vh;

    background:

    linear-gradient(

        135deg,

        #fdf0f4 0%,

        #fae1ea 50%,

        #f7d5e1 100%

    );

    color:var(--texto);

}


.container{

    width:100%;

    max-width:1500px;

    margin:auto;

    padding:35px;

}



/* =========================================================
   ENCABEZADO
========================================================= */

.encabezado{

    background:

    linear-gradient(

        135deg,

        #e06d92,

        #be4b73

    );

    border-radius:35px;

    padding:40px 30px;

    text-align:center;

    color:white;

    box-shadow:

        0 18px 40px

        rgba(188,75,115,.25);

    margin-bottom:25px;

    position:relative;

    overflow:hidden;

}


.encabezado::before{

    content:"";

    position:absolute;

    width:250px;

    height:250px;

    border-radius:50%;

    background:

        rgba(255,255,255,.08);

    top:-120px;

    left:-80px;

}


.encabezado::after{

    content:"";

    position:absolute;

    width:300px;

    height:300px;

    border-radius:50%;

    background:

        rgba(255,255,255,.06);

    bottom:-170px;

    right:-80px;

}


.encabezado h1{

    position:relative;

    z-index:2;

    font-family:'Bestigia',sans-serif;

    font-size:48px;

    font-weight:400;

    margin-bottom:8px;

}


.encabezado p{

    position:relative;

    z-index:2;

    color:#ffe9f1;

    font-size:15px;

}



/* =========================================================
   BOTÓN VOLVER
========================================================= */

.volver{

    display:inline-flex;

    align-items:center;

    gap:8px;

    margin-bottom:20px;

    padding:12px 20px;

    background:white;

    color:var(--vino);

    border:1px solid var(--borde);

    border-radius:15px;

    text-decoration:none;

    font-weight:600;

    box-shadow:var(--sombra);

    transition:.3s;

}


.volver:hover{

    transform:translateY(-3px);

    background:var(--rosa-fuerte);

    color:white;

}



/* =========================================================
   INFORMACIÓN DEL USUARIO
========================================================= */

.usuario{

    background:rgba(255,255,255,.75);

    border:1px solid var(--borde);

    border-radius:20px;

    padding:15px 20px;

    margin-bottom:25px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:10px;

}


.usuario span{

    font-size:14px;

    color:var(--gris);

}


.usuario strong{

    color:var(--vino);

}



/* =========================================================
   ESTADÍSTICAS
========================================================= */

.estadisticas{

    display:grid;

    grid-template-columns:

        repeat(3,1fr);

    gap:18px;

    margin-bottom:30px;

}


.estadistica{

    background:

        linear-gradient(

            145deg,

            #ffffff,

            #fdf3f6

        );

    border:1px solid var(--borde);

    border-radius:25px;

    padding:22px;

    text-align:center;

    box-shadow:var(--sombra);

    transition:.3s;

}


.estadistica:hover{

    transform:translateY(-5px);

}


.estadistica-icono{

    font-size:30px;

    margin-bottom:8px;

}


.estadistica strong{

    display:block;

    font-size:32px;

    color:var(--vino);

}


.estadistica span{

    font-size:13px;

    color:var(--gris);

    font-weight:600;

}



/* =========================================================
   BARRA DE BÚSQUEDA
========================================================= */

.herramientas{

    background:white;

    border:1px solid var(--borde);

    border-radius:25px;

    padding:20px;

    margin-bottom:25px;

    box-shadow:var(--sombra);

}


.herramientas h2{

    font-family:'Bestigia',sans-serif;

    font-size:28px;

    color:var(--vino);

    margin-bottom:15px;

}


.busqueda{

    width:100%;

    padding:15px 20px;

    border-radius:15px;

    border:1px solid var(--borde);

    outline:none;

    font-size:14px;

    color:var(--texto);

    background:#fffafd;

    transition:.3s;

}


.busqueda:focus{

    border-color:var(--rosa-fuerte);

    box-shadow:

        0 0 0 4px

        rgba(224,109,146,.10);

}



/* =========================================================
   ENCABEZADO DE PRODUCTOS
========================================================= */

.titulo-productos{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

    flex-wrap:wrap;

    gap:10px;

}


.titulo-productos h2{

    font-family:'Bestigia',sans-serif;

    font-size:34px;

    color:var(--vino-oscuro);

}


.titulo-productos span{

    background:var(--rosa-claro);

    color:var(--vino);

    border:1px solid var(--borde);

    padding:8px 15px;

    border-radius:20px;

    font-size:13px;

    font-weight:600;

}



/* =========================================================
   GRID DE PRODUCTOS
========================================================= */

.grid{

    display:grid;

    grid-template-columns:

        repeat(4,1fr);

    gap:22px;

}



/* =========================================================
   TARJETA
========================================================= */

.card{

    background:

        linear-gradient(

            145deg,

            #ffffff 0%,

            #fdf3f6 100%

        );

    border:1px solid var(--borde);

    border-radius:28px;

    overflow:hidden;

    box-shadow:var(--sombra);

    transition:.35s;

    position:relative;

}


.card:hover{

    transform:translateY(-8px);

    box-shadow:

        0 20px 40px

        rgba(180,80,120,.20);

}



/* =========================================================
   ETIQUETA STOCK
========================================================= */

.etiqueta{

    position:absolute;

    top:15px;

    right:15px;

    z-index:5;

    padding:7px 12px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

    background:white;

    box-shadow:

        0 5px 12px

        rgba(0,0,0,.08);

}


.etiqueta.agotado{

    color:white;

    background:var(--rojo);

}


.etiqueta.critico{

    color:white;

    background:#d47b72;

}


.etiqueta.bajo{

    color:white;

    background:var(--amarillo);

}



/* =========================================================
   IMAGEN DEL PRODUCTO
========================================================= */

.imagen{

    width:100%;

    height:250px;

    background:

        linear-gradient(

            135deg,

            #fbe3eb,

            #fdf0f4

        );

    display:flex;

    justify-content:center;

    align-items:center;

    overflow:hidden;

    border-bottom:

        1px solid var(--borde);

}


.imagen img{

    width:100%;

    height:100%;

    object-fit:contain;

    padding:20px;

    transition:.4s;

}


.card:hover .imagen img{

    transform:scale(1.06);

}



/* =========================================================
   PLACEHOLDER
========================================================= */

.placeholder{

    width:100%;

    height:100%;

    display:flex;

    justify-content:center;

    align-items:center;

    flex-direction:column;

    color:#b98598;

    font-size:14px;

    font-weight:600;

}


.placeholder-icon{

    font-size:45px;

    margin-bottom:8px;

}



/* =========================================================
   INFORMACIÓN
========================================================= */

.informacion{

    padding:22px;

}


.codigo{

    display:inline-block;

    background:var(--rosa-claro);

    color:var(--vino);

    border:1px solid var(--borde);

    padding:5px 10px;

    border-radius:10px;

    font-size:11px;

    font-weight:700;

    margin-bottom:10px;

}


.informacion h3{

    font-size:18px;

    color:var(--vino-oscuro);

    margin-bottom:7px;

}


.categoria{

    font-size:12px;

    color:var(--gris);

    margin-bottom:15px;

}



/* =========================================================
   PRECIO
========================================================= */

.precio{

    font-size:20px;

    font-weight:700;

    color:var(--rosa-fuerte);

    margin-bottom:15px;

}



/* =========================================================
   STOCK
========================================================= */

.stock-box{

    padding:13px;

    border-radius:15px;

    background:#fff;

    border:1px solid var(--borde);

    display:flex;

    justify-content:space-between;

    align-items:center;

}


.stock-box span{

    font-size:12px;

    color:var(--gris);

    font-weight:600;

}


.stock-numero{

    font-size:20px;

    font-weight:700;

}


.stock-numero.agotado{

    color:var(--rojo);

}


.stock-numero.critico{

    color:#d47b72;

}


.stock-numero.bajo{

    color:var(--amarillo);

}



/* =========================================================
   MENSAJE CUANDO NO HAY PRODUCTOS
========================================================= */

.sin-productos{

    grid-column:1/-1;

    background:white;

    border:1px solid var(--borde);

    border-radius:30px;

    padding:60px 30px;

    text-align:center;

    box-shadow:var(--sombra);

}


.sin-productos .icono{

    font-size:65px;

    margin-bottom:15px;

}


.sin-productos h2{

    font-family:'Bestigia',sans-serif;

    font-size:35px;

    color:var(--vino);

    margin-bottom:10px;

}


.sin-productos p{

    color:var(--gris);

    font-size:14px;

}



/* =========================================================
   ANIMACIÓN
========================================================= */

.animar{

    animation:

        aparecer .6s ease forwards;

}


@keyframes aparecer{

    from{

        opacity:0;

        transform:translateY(20px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}



/* =========================================================
   FOOTER
========================================================= */

.footer-info{

    margin-top:35px;

    padding:25px;

    background:

        rgba(255,255,255,.75);

    border:1px solid var(--borde);

    border-radius:25px;

    text-align:center;

    color:var(--gris);

    font-size:13px;

}


.footer-info strong{

    color:var(--vino);

}



/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1200px){

    .grid{

        grid-template-columns:

            repeat(3,1fr);

    }

}


@media(max-width:900px){

    .grid{

        grid-template-columns:

            repeat(2,1fr);

    }

    .estadisticas{

        grid-template-columns:

            repeat(3,1fr);

    }

}


@media(max-width:650px){

    .container{

        padding:15px;

    }


    .encabezado{

        padding:30px 20px;

        border-radius:25px;

    }


    .encabezado h1{

        font-size:36px;

    }


    .estadisticas{

        grid-template-columns:1fr;

    }


    .grid{

        grid-template-columns:1fr;

    }


    .imagen{

        height:280px;

    }


    .titulo-productos h2{

        font-size:28px;

    }


    .usuario{

        flex-direction:column;

        align-items:flex-start;

    }

}

</style>

</head>



<body>



<?php include '../submenu.php'; ?>



<div class="container">



<!-- =====================================================
     BOTÓN VOLVER
====================================================== -->

<a
    href="javascript:history.back()"
    class="volver"
>

    ← Volver

</a>



<!-- =====================================================
     ENCABEZADO
====================================================== -->

<div class="encabezado">

    <h1>

        Control de Stock

    </h1>


    <p>

        Productos que necesitan atención y reposición

    </p>

</div>



<!-- =====================================================
     USUARIO
====================================================== -->

<div class="usuario">

    <span>

        Sesión iniciada como:

        <strong>

            <?php

            echo htmlspecialchars(
                $nombreUsuario
            );

            ?>

        </strong>

    </span>


    <span>

        Rol:

        <strong>

            <?php

            echo htmlspecialchars(
                $rol
            );

            ?>

        </strong>

    </span>

</div>



<!-- =====================================================
     ESTADÍSTICAS
====================================================== -->

<div class="estadisticas">



<!-- TOTAL -->

<div class="estadistica">

    <div class="estadistica-icono">

        📦

    </div>


    <strong>

        <?php

        echo $totalProductos;

        ?>

    </strong>


    <span>

        Productos con stock bajo

    </span>

</div>



<!-- AGOTADOS -->

<div class="estadistica">

    <div class="estadistica-icono">

        🚨

    </div>


    <strong>

        <?php

        echo $agotados;

        ?>

    </strong>


    <span>

        Productos agotados

    </span>

</div>



<!-- CRÍTICOS -->

<div class="estadistica">

    <div class="estadistica-icono">

        ⚠️

    </div>


    <strong>

        <?php

        echo $stockCritico;

        ?>

    </strong>


    <span>

        Stock crítico

    </span>

</div>



</div>



<!-- =====================================================
     BÚSQUEDA
====================================================== -->

<div class="herramientas">

    <h2>

        Buscar producto

    </h2>


    <input

        type="text"

        id="buscador"

        class="busqueda"

        placeholder="Busca por nombre, código o categoría..."

        onkeyup="buscarProductos()"

    >

</div>



<!-- =====================================================
     TÍTULO
====================================================== -->

<div class="titulo-productos">

    <h2>

        Stock bajo ✦

    </h2>


    <span>

        <?php

        echo $totalProductos;

        ?>

        productos encontrados

    </span>

</div>



<!-- =====================================================
     GRID
====================================================== -->

<div class="grid" id="contenedorProductos">



<?php



/* =========================================================
   VERIFICAR SI EXISTEN PRODUCTOS
========================================================= */

if (count($productos) > 0) {



    foreach ($productos as $fila) {



        /* ==================================================
           OBTENER STOCK
        ================================================== */

        $stock = (int)$fila["stock"];



        /* ==================================================
           OBTENER CÓDIGO
        ================================================== */

        $codigo = $fila["codigo"];



        /* ==================================================
           BUSCAR IMAGEN
           
           FORMATO:
           
           p-CODIGO.jpg
           p-CODIGO.jpeg
           p-CODIGO.png
           p-CODIGO.gif
        ================================================== */

        $directorio = "../PRODUCTO-img/";

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



        /* ==================================================
           ESTADO DEL STOCK
        ================================================== */

        if ($stock <= 0) {

            $claseStock = "agotado";

            $textoStock = "AGOTADO";

        }

        elseif ($stock <= 2) {

            $claseStock = "critico";

            $textoStock = "STOCK CRÍTICO";

        }

        else {

            $claseStock = "bajo";

            $textoStock = "STOCK BAJO";

        }



        ?>



        <!-- ==================================================
             TARJETA PRODUCTO
        ================================================== -->

        <div

            class="card animar producto"

            data-nombre="<?php

                echo htmlspecialchars(

                    strtolower(

                        $fila["nombre"]

                    )

                );

            ?>"

            data-codigo="<?php

                echo htmlspecialchars(

                    strtolower(

                        $codigo

                    )

                );

            ?>"

            data-categoria="<?php

                echo htmlspecialchars(

                    strtolower(

                        $fila["categoria"] ?? ""

                    )

                );

            ?>"

        >



            <!-- ==================================================
                 ETIQUETA
            ================================================== -->

            <div class="etiqueta <?php echo $claseStock; ?>">

                <?php

                echo $textoStock;

                ?>

            </div>



            <!-- ==================================================
                 IMAGEN
            ================================================== -->

            <div class="imagen">



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

                                $fila["nombre"]

                            );

                        ?>"

                    >



                <?php

                } else {

                ?>



                    <div class="placeholder">

                        <div class="placeholder-icon">

                            🧴

                        </div>

                        Imagen del producto

                    </div>



                <?php

                }

                ?>



            </div>



            <!-- ==================================================
                 INFORMACIÓN
            ================================================== -->

            <div class="informacion">



                <span class="codigo">

                    Código:

                    <?php

                    echo htmlspecialchars(

                        $codigo

                    );

                    ?>

                </span>



                <h3>

                    <?php

                    echo htmlspecialchars(

                        $fila["nombre"]

                    );

                    ?>

                </h3>



                <div class="categoria">

                    Categoría:

                    <?php

                    echo htmlspecialchars(

                        $fila["categoria"] ?? "Sin categoría"

                    );

                    ?>

                </div>



                <div class="precio">

                    Bs.

                    <?php

                    echo number_format(

                        (float)$fila["precio"],

                        2,

                        ".",

                        ","

                    );

                    ?>

                </div>



                <!-- ==================================================
                     STOCK
                ================================================== -->

                <div class="stock-box">

                    <span>

                        Existencias

                    </span>


                    <span

                        class="stock-numero <?php

                            echo $claseStock;

                        ?>"

                    >

                        <?php

                        echo $stock;

                        ?>

                    </span>

                </div>



            </div>



        </div>



        <?php

    }



} else {



?>



    <!-- ==================================================
         SIN PRODUCTOS
    ================================================== -->

    <div class="sin-productos">

        <div class="icono">

            ✨

        </div>


        <h2>

            ¡Stock en orden!

        </h2>


        <p>

            Actualmente no existen productos con

            5 unidades o menos de stock.

        </p>

    </div>



<?php

}

?>



</div>



<!-- =====================================================
     INFORMACIÓN FINAL
====================================================== -->

<div class="footer-info">

    <strong>

        DIVINE · Control de inventario

    </strong>

    <br><br>

    Esta sección muestra automáticamente los productos

    que tienen <strong>5 unidades o menos</strong>

    disponibles.

    <br>

    Las imágenes se cargan desde la carpeta

    <strong>PRODUCTO-img</strong>

    utilizando el código de cada producto.



</div>



</div>



<?php include '../submenpiepag.php'; ?>



<script>

/* =========================================================
   BUSCADOR DE PRODUCTOS
========================================================= */

function buscarProductos(){

    let texto =

        document

        .getElementById("buscador")

        .value

        .toLowerCase()

        .trim();


    let productos =

        document.querySelectorAll(

            ".producto"

        );


    productos.forEach(

        function(producto){

            let nombre =

                producto.dataset.nombre || "";


            let codigo =

                producto.dataset.codigo || "";


            let categoria =

                producto.dataset.categoria || "";


            if(

                nombre.includes(texto) ||

                codigo.includes(texto) ||

                categoria.includes(texto)

            ){

                producto.style.display = "";

            }

            else{

                producto.style.display = "none";

            }

        }

    );

}

</script>



</body>

</html>
 