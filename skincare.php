
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
    die("OCURRIÓ UN ERROR AL CONECTAR CON LA BASE DE DATOS: " . $conn->connect_error);
}


/* CONSULTAR PRODUCTOS */

 
$sql = "SELECT * FROM producto WHERE categoria='SkinCare'";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Beauty Store</title>


<style>

/* ==================================================
   VARIABLES
================================================== */

:root {

    --rosa: #b86f80;

    --rosa-claro: #d9a6b2;

    --rosa-palido: #f7e9ec;

    --crema: #fffaf8;

    --texto: #4d4143;

    --gris: #817679;

    --borde: #ead7dc;

}


/* ==================================================
   RESET
================================================== */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

}


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

    url("https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg");

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
   SECCIÓN
================================================== */

.section {

    max-width: 1450px;

    margin: auto;

    padding: 90px 50px;

}


/* ==================================================
   ENCABEZADO SECCIÓN
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
   GRID
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
   TARJETA
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

    transform:

    translateY(-8px);

    box-shadow:

    0 20px 45px rgba(100,70,80,.13);

}


/* ==================================================
   IMAGEN
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

    transition:

    transform .7s ease;

}


.card:hover

.imagen-producto img {

    transform:

    scale(1.06);

}


/* ==================================================
   INFORMACIÓN
================================================== */

.info {

    padding: 27px 25px 25px;

}


/* ==================================================
   NOMBRE
================================================== */
.info h3 {

    font-family: Georgia, serif;

    font-size: 1.4rem;

    font-weight: 700;

    color: #57494c;

    text-align: center;

    margin-bottom: 14px;

    line-height: 1.3;

}


/* ==================================================
   DESCRIPCIÓN
================================================== */

.descripcion {

    color: var(--gris);

    font-size: .9rem;

    line-height: 1.7;

    min-height: 50px;

    margin-bottom: 20px;

}


/* ==================================================
   PRECIO
================================================== */

.precio {

    font-family: Georgia, serif;

    font-size: 1.5rem;

    color: var(--rosa);

    margin-bottom: 20px;

}


/* ==================================================
   BOTÓN CARRITO
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

    transform:

    translateY(-2px);

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


/* STOCK BAJO */

.stock.ultimas {

    color: #a57c55;

}


.stock.ultimas strong {

    color: #a57c55;

}


/* AGOTADO */

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
   ANIMACIONES
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
   HERO ANIMACIÓN
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

}

</style>

</head>
<body>

<?php

include 'submenuespecial.php';
 
?>


<script src="./AJAX/buscar.js"></script>




    <div id="productos">        </div>


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


        $codigo = $fila['codigo'];

        $stock = (int)$fila['stock'];


?>


        <!-- ==================================================
             PRODUCTO
        ================================================== -->

        <div class="card animar">


            <!-- IMAGEN -->

            <div class="imagen-producto">


                <img

                    src="./imagenes/producto-predeterminado.jpg"

                    alt="<?php

                    echo htmlspecialchars(

                        $fila['nombre']

                    );

                    ?>"

                >


            </div>



            <!-- INFORMACIÓN -->

            <div class="info">


                <!-- NOMBRE -->

                <h3>

                    <?php

                    echo htmlspecialchars(

                        $fila['nombre']

                    );

                    ?>

                </h3>



                <!-- DESCRIPCIÓN -->

                <p class="descripcion">

                    <?php

                    echo htmlspecialchars(

                        $fila['descripcion']

                    );

                    ?>

                </p>



                <!-- PRECIO -->

                <div class="precio">

                    Bs

                    <?php

                    echo htmlspecialchars(

                        $fila['precio']

                    );

                    ?>

                </div>



                <!-- BOTÓN -->

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

                    href="./CRUD-CARRITO-PEDIDO/formpedido.php?codigo=<?php echo $codigo; ?>"

                    class="btn-carrito"

                >

                    Agregar al carrito

                </a>


<?php


}


?>



                <!-- STOCK -->

<?php


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

                        echo $stock ; 

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



<script>


/* ==================================================
   ANIMACIÓN DE PRODUCTOS
================================================== */


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

        threshold:

        0.12

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
