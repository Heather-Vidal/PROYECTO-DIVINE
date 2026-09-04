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


/* ==================================================
   CONSULTAR SOLAMENTE PRODUCTOS DE SKINCARE
================================================== */

$sql = "SELECT * FROM producto WHERE categoria='SkinCare'";

$resultado = $conn->query($sql);


if (!$resultado) {

    die(
        "Error al consultar los productos: "
        . $conn->error
    );

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
    DIVINE | Skincare
</title>


<style>

/* ==================================================
   VARIABLES
================================================== */

:root {

    --rosa: #b86f80;

    --rosa-oscuro: #914d61;

    --rosa-claro: #e7b8c3;

    --rosa-palido: #f9edef;

    --crema: #fffaf7;

    --blanco: #ffffff;

    --texto: #4d4143;

    --gris: #817679;

    --borde: #ead7dc;

    --verde: #809b89;

}


/* ==================================================
   RESET
================================================== */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

}


html {

    scroll-behavior: smooth;

}


body {

    background: var(--crema);

    color: var(--texto);

    font-family:
        'Segoe UI',
        sans-serif;

    min-height: 100vh;

}


/* ==================================================
   HERO
================================================== */

.hero {

    min-height: 650px;

    position: relative;

    display: flex;

    align-items: center;

    overflow: hidden;

    background:

        linear-gradient(
            100deg,
            rgba(255,250,247,.98) 0%,
            rgba(255,250,247,.91) 35%,
            rgba(255,250,247,.50) 65%,
            rgba(255,250,247,.15) 100%
        ),

        url("https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg");

    background-size: cover;

    background-position: center;

    animation:
        aparecerHero
        1s
        ease;

}


/* ==================================================
   DECORACIÓN HERO
================================================== */

.hero::before {

    content: "";

    position: absolute;

    width: 420px;

    height: 420px;

    border-radius: 50%;

    background:
        rgba(231,184,195,.22);

    right: -100px;

    top: -100px;

}


.hero::after {

    content: "";

    position: absolute;

    width: 250px;

    height: 250px;

    border-radius: 50%;

    border:
        1px solid
        rgba(184,111,128,.20);

    right: 12%;

    bottom: -100px;

}


/* ==================================================
   CONTENIDO HERO
================================================== */

.hero-content {

    position: relative;

    z-index: 2;

    max-width: 650px;

    margin-left: 9%;

    padding: 50px 0;

}


.hero-mini {

    display: inline-flex;

    align-items: center;

    gap: 10px;

    color: var(--rosa);

    font-size: .75rem;

    text-transform: uppercase;

    letter-spacing: 4px;

    font-weight: 700;

    margin-bottom: 20px;

}


.hero-mini::before {

    content: "";

    width: 35px;

    height: 1px;

    background: var(--rosa);

}


.hero h1 {

    font-family:
        Georgia,
        serif;

    font-size:
        clamp(
            4rem,
            9vw,
            7.5rem
        );

    font-weight: 400;

    letter-spacing: 12px;

    color: var(--rosa);

    line-height: .95;

}


.hero h2 {

    font-family:
        Georgia,
        serif;

    font-size:
        clamp(
            1.7rem,
            3vw,
            2.8rem
        );

    font-weight: 400;

    color: var(--texto);

    margin-top: 20px;

}


.hero p {

    margin-top: 25px;

    max-width: 510px;

    color: #6d6063;

    font-size: 1rem;

    line-height: 1.9;

}


.hero-frase {

    margin-top: 30px;

    padding-left: 18px;

    border-left:
        3px solid
        var(--rosa);

    color: var(--rosa-oscuro);

    font-family:
        Georgia,
        serif;

    font-size: 1.05rem;

    font-style: italic;

}


/* ==================================================
   BOTÓN HERO
================================================== */

.hero-boton {

    display: inline-flex;

    margin-top: 35px;

    padding:
        14px
        30px;

    border-radius: 30px;

    background: var(--rosa);

    color: white;

    text-decoration: none;

    font-size: .88rem;

    font-weight: 600;

    letter-spacing: .5px;

    transition:
        .3s ease;

    box-shadow:
        0 10px 25px
        rgba(184,111,128,.22);

}


.hero-boton:hover {

    background:
        var(--rosa-oscuro);

    transform:
        translateY(-3px);

    box-shadow:
        0 15px 30px
        rgba(184,111,128,.30);

}


/* ==================================================
   FRASE DECORATIVA
================================================== */

.frase-seccion {

    padding:
        75px
        30px
        30px;

    text-align: center;

}


.frase-pequena {

    color: var(--rosa);

    font-size: .72rem;

    text-transform: uppercase;

    letter-spacing: 4px;

    font-weight: 700;

    margin-bottom: 15px;

}


.frase-seccion h2 {

    font-family:
        Georgia,
        serif;

    font-size:
        clamp(
            2rem,
            4vw,
            3.2rem
        );

    font-weight: 400;

    color: var(--texto);

}


.frase-seccion h2 span {

    color: var(--rosa);

    font-style: italic;

}


.frase-seccion p {

    max-width: 650px;

    margin:
        18px
        auto
        0;

    color: var(--gris);

    line-height: 1.8;

}


/* ==================================================
   SEPARADOR
================================================== */

.separador {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 15px;

    margin:
        25px
        auto
        55px;

}


.separador::before,
.separador::after {

    content: "";

    width: 65px;

    height: 1px;

    background:
        var(--rosa-claro);

}


.separador span {

    color: var(--rosa);

    font-size: 18px;

}


/* ==================================================
   SECCIÓN PRODUCTOS
================================================== */

.section {

    max-width:
        1450px;

    margin:
        auto;

    padding:
        30px
        50px
        100px;

}


/* ==================================================
   ENCABEZADO PRODUCTOS
================================================== */

.encabezado {

    display: flex;

    justify-content:
        space-between;

    align-items:
        flex-end;

    margin-bottom:
        45px;

    gap: 20px;

}


.encabezado-izquierda {

    text-align: left;

}


.encabezado-pequeno {

    color: var(--rosa);

    font-size: .72rem;

    text-transform:
        uppercase;

    letter-spacing:
        4px;

    font-weight: 700;

    margin-bottom:
        10px;

}


.titulo {

    font-family:
        Georgia,
        serif;

    font-size:
        2.6rem;

    font-weight:
        400;

    color:
        var(--texto);

}


.encabezado-descripcion {

    max-width:
        400px;

    color:
        var(--gris);

    font-size:
        .9rem;

    line-height:
        1.7;

    text-align:
        right;

}


/* ==================================================
   GRID
================================================== */

.grid {

    display:
        grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(
                280px,
                1fr
            )
        );

    gap:
        30px;

}


/* ==================================================
   TARJETA
================================================== */

.card {

    position:
        relative;

    background:
        var(--blanco);

    border:
        1px solid
        var(--borde);

    border-radius:
        22px;

    overflow:
        hidden;

    box-shadow:
        0 12px 35px
        rgba(
            100,
            70,
            80,
            .07
        );

    transition:
        transform
        .4s ease,
        box-shadow
        .4s ease;

}


.card:hover {

    transform:
        translateY(
            -9px
        );

    box-shadow:
        0 22px 50px
        rgba(
            100,
            70,
            80,
            .14
        );

}


/* ==================================================
   ETIQUETA SKINCARE
================================================== */

.etiqueta {

    position:
        absolute;

    top: 18px;

    left: 18px;

    z-index: 5;

    padding:
        7px
        13px;

    border-radius:
        20px;

    background:
        rgba(
            255,
            250,
            248,
            .92
        );

    color:
        var(--rosa-oscuro);

    font-size:
        .65rem;

    text-transform:
        uppercase;

    letter-spacing:
        1.5px;

    font-weight:
        700;

    backdrop-filter:
        blur(6px);

}


/* ==================================================
   IMAGEN
================================================== */

.imagen-producto {

    height:
        330px;

    overflow:
        hidden;

    background:
        var(--rosa-palido);

    position:
        relative;

}


.imagen-producto::after {

    content: "";

    position:
        absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(80,40,50,.08),
            transparent 35%
        );

    pointer-events:
        none;

}


.imagen-producto img {

    width:
        100%;

    height:
        100%;

    object-fit:
        cover;

    display:
        block;

    transition:
        transform
        .7s ease;

}


.card:hover
.imagen-producto img {

    transform:
        scale(
            1.07
        );

}


/* ==================================================
   INFORMACIÓN
================================================== */

.info {

    padding:
        25px
        25px
        27px;

}


/* ==================================================
   CATEGORÍA
================================================== */

.categoria {

    color:
        var(--rosa);

    font-size:
        .68rem;

    text-transform:
        uppercase;

    letter-spacing:
        2px;

    font-weight:
        700;

    margin-bottom:
        9px;

}


/* ==================================================
   NOMBRE
================================================== */

.info h3 {

    font-family:
        Georgia,
        serif;

    font-size:
        1.45rem;

    font-weight:
        600;

    color:
        var(--texto);

    margin-bottom:
        12px;

    line-height:
        1.3;

}


/* ==================================================
   DESCRIPCIÓN
================================================== */

.descripcion {

    color:
        var(--gris);

    font-size:
        .87rem;

    line-height:
        1.7;

    min-height:
        48px;

    margin-bottom:
        20px;

}


/* ==================================================
   PARTE INFERIOR
================================================== */

.info-final {

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        15px;

    margin-bottom:
        20px;

}


/* ==================================================
   PRECIO
================================================== */

.precio {

    font-family:
        Georgia,
        serif;

    font-size:
        1.45rem;

    color:
        var(--rosa);

    font-weight:
        600;

}


/* ==================================================
   STOCK
================================================== */

.stock {

    padding:
        7px
        11px;

    border-radius:
        20px;

    background:
        #f6f2f2;

    color:
        #817679;

    font-size:
        .68rem;

    white-space:
        nowrap;

}


.stock strong {

    color:
        var(--rosa);

}


.stock.ultimas {

    background:
        #fbf3e9;

    color:
        #a57c55;

}


.stock.ultimas strong {

    color:
        #a57c55;

}


.stock.agotado {

    background:
        #eeeeee;

    color:
        #888;

}


/* ==================================================
   BOTÓN CARRITO
================================================== */

.btn-carrito {

    display:
        flex;

    justify-content:
        center;

    align-items:
        center;

    width:
        100%;

    height:
        48px;

    border-radius:
        10px;

    background:
        var(--rosa);

    color:
        white;

    font-size:
        .85rem;

    font-weight:
        600;

    letter-spacing:
        .5px;

    text-decoration:
        none;

    border:
        1px solid
        var(--rosa);

    cursor:
        pointer;

    transition:
        .3s ease;

}


.btn-carrito:hover {

    background:
        transparent;

    color:
        var(--rosa);

    transform:
        translateY(
            -2px
        );

}


/* ==================================================
   AGOTADO
================================================== */

.btn-agotado {

    background:
        #e2dfe0;

    border-color:
        #e2dfe0;

    color:
        #888;

    cursor:
        not-allowed;

}


.btn-agotado:hover {

    background:
        #e2dfe0;

    border-color:
        #e2dfe0;

    color:
        #888;

    transform:
        none;

}


/* ==================================================
   SIN PRODUCTOS
================================================== */

.sin-productos {

    grid-column:
        1 / -1;

    padding:
        90px
        30px;

    text-align:
        center;

    background:
        white;

    border:
        1px solid
        var(--borde);

    border-radius:
        22px;

    color:
        var(--gris);

}


/* ==================================================
   MENSAJE INFERIOR
================================================== */

.mensaje-final {

    max-width:
        900px;

    margin:
        20px
        auto
        0;

    padding:
        45px
        35px;

    background:
        linear-gradient(
            135deg,
            #fff8f8,
            #f8e8ec
        );

    border:
        1px solid
        var(--borde);

    border-radius:
        25px;

    text-align:
        center;

}


.mensaje-final-icono {

    font-size:
        30px;

    margin-bottom:
        12px;

}


.mensaje-final h3 {

    font-family:
        Georgia,
        serif;

    font-size:
        1.8rem;

    font-weight:
        400;

    color:
        var(--rosa-oscuro);

}


.mensaje-final p {

    max-width:
        600px;

    margin:
        12px
        auto
        0;

    color:
        var(--gris);

    line-height:
        1.8;

    font-size:
        .9rem;

}


/* ==================================================
   ANIMACIONES
================================================== */

.animar {

    opacity:
        0;

    transform:
        translateY(
            25px
        );

}


.animar.activo {

    opacity:
        1;

    transform:
        translateY(
            0
        );

    transition:
        opacity
        .7s ease,
        transform
        .7s ease;

}


@keyframes aparecerHero {

    from {

        opacity:
            0;

        transform:
            scale(
                1.02
            );

    }

    to {

        opacity:
            1;

        transform:
            scale(
                1
            );

    }

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(
    max-width: 900px
) {

    .hero {

        min-height:
            600px;

        background-position:
            65%
            center;

    }


    .hero-content {

        margin-left:
            6%;

        max-width:
            600px;

    }


    .encabezado {

        flex-direction:
            column;

        align-items:
            flex-start;

    }


    .encabezado-descripcion {

        text-align:
            left;

    }

}


@media(
    max-width: 768px
) {

    .hero {

        min-height:
            600px;

        background:

            linear-gradient(
                rgba(
                    255,
                    250,
                    247,
                    .82
                ),
                rgba(
                    255,
                    250,
                    247,
                    .88
                )
            ),

            url(
                "https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg"
            );

        background-size:
            cover;

        background-position:
            center;

    }


    .hero-content {

        margin:
            auto;

        padding:
            50px
            25px;

        text-align:
            center;

    }


    .hero-mini {

        justify-content:
            center;

    }


    .hero h1 {

        font-size:
            4rem;

        letter-spacing:
            7px;

    }


    .hero h2 {

        font-size:
            1.8rem;

    }


    .hero p {

        margin-left:
            auto;

        margin-right:
            auto;

    }


    .hero-frase {

        text-align:
            left;

    }


    .section {

        padding:
            60px
            20px
            80px;

    }


    .titulo {

        font-size:
            2.1rem;

    }


    .grid {

        grid-template-columns:
            1fr;

        gap:
            25px;

    }


    .imagen-producto {

        height:
            300px;

    }


    .info-final {

        align-items:
            flex-start;

        flex-direction:
            column;

    }


    .stock {

        white-space:
            normal;

    }

}


</style>

</head>


<body>


<?php

include 'submenuespecial.php';

?>


<script src="./AJAX/buscar.js"></script>


<div id="productos"></div>


<!-- ==================================================
     HERO SKINCARE
================================================== -->

<section class="hero">


    <div class="hero-content">


        <div class="hero-mini">

            Colección exclusiva

        </div>


        <h1>

            SKINCARE

        </h1>


        <h2>

            Tu piel merece sentirse hermosa.

        </h2>


        <p>

            Descubre nuestra selección de productos
            pensados para acompañar tu rutina de
            cuidado facial y darle a tu piel el
            cariño que merece.

        </p>


        <div class="hero-frase">

            “Cuidar tu piel también es una forma
            de quererte.”

        </div>


        <a
            href="#productos-skincare"
            class="hero-boton"
        >

            Descubrir productos

        </a>


    </div>


</section>


<!-- ==================================================
     FRASE
================================================== -->

<section class="frase-seccion">


    <div class="frase-pequena">

        DIVINE SKINCARE

    </div>


    <h2>

        Una piel cuidada,

        <span>
            una sensación hermosa.
        </span>

    </h2>


    <p>

        Encuentra productos seleccionados para
        hidratar, cuidar y consentir tu piel
        todos los días.

    </p>


    <div class="separador">

        <span>✦</span>

    </div>


</section>


<!-- ==================================================
     PRODUCTOS
================================================== -->

<section
    class="section"
    id="productos-skincare"
>


    <div class="encabezado">


        <div class="encabezado-izquierda">


            <div class="encabezado-pequeno">

                Cuidado facial

            </div>


            <h2 class="titulo">

                Colección Skincare

            </h2>


        </div>


        <p class="encabezado-descripcion">

            Productos pensados para formar parte
            de tu rutina y ayudarte a disfrutar
            cada momento de cuidado personal.

        </p>


    </div>


    <!-- ==================================================
         GRID PRODUCTOS
    ================================================== -->

    <div class="grid">


<?php


if ($resultado->num_rows > 0) {


    while ($fila = $resultado->fetch_assoc()) {


        $codigo =
            $fila['codigo'];


        $stock =
            (int)$fila['stock'];


?>


        <!-- ==================================================
             TARJETA PRODUCTO
        ================================================== -->

        <div class="card animar">


            <!-- ETIQUETA -->

            <div class="etiqueta">

                Skincare

            </div>


            <!-- ==================================================
                 IMAGEN
            ================================================== -->

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


            <!-- ==================================================
                 INFORMACIÓN
            ================================================== -->

            <div class="info">


                <div class="categoria">

                    Cuidado facial

                </div>


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


                <!-- ==================================================
                     PRECIO + STOCK
                ================================================== -->

                <div class="info-final">


                    <div class="precio">

                        Bs.
                        <?php

                        echo htmlspecialchars(
                            $fila['precio']
                        );

                        ?>

                    </div>


<?php

if ($stock <= 0) {

?>

                    <div class="stock agotado">

                        Agotado

                    </div>


<?php

} elseif ($stock <= 5) {

?>

                    <div class="stock ultimas">

                        Últimas:
                        <strong>

                            <?php

                            echo $stock;

                            ?>

                        </strong>

                    </div>


<?php

} else {

?>

                    <div class="stock">

                        Stock:
                        <strong>

                            <?php

                            echo $stock;

                            ?>

                        </strong>

                    </div>


<?php

}

?>


                </div>


                <!-- ==================================================
                     BOTÓN
                ================================================== -->

<?php

if ($stock <= 0) {

?>


                <div
                    class="btn-carrito btn-agotado"
                >

                    Producto agotado

                </div>


<?php

} else {

?>


                <a

                    href="./CRUD-CARRITO-PEDIDO/formpedido.php?codigo=<?php echo $codigo; ?>"

                    class="btn-carrito"

                >

                    🛒 Agregar al carrito

                </a>


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

            No hay productos de skincare
            disponibles en este momento.

        </div>


<?php

}

?>


    </div>


    <!-- ==================================================
         MENSAJE FINAL
    ================================================== -->

    <div class="mensaje-final">


        <div class="mensaje-final-icono">

            ✦

        </div>


        <h3>

            Tu momento de cuidado comienza aquí

        </h3>


        <p>

            Porque cuidar tu piel no tiene que ser
            una obligación. Haz de tu rutina un
            pequeño momento para ti.

        </p>


    </div>


</section>


<!-- ==================================================
     PIE DE PÁGINA
================================================== -->

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