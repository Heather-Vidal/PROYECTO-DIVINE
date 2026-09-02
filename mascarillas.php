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


/* ==================================================
   CONSULTAR PRODUCTOS SKIN HAIR
================================================== */

$sql = "SELECT * FROM producto WHERE categoria='SkinHair'";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Skin Hair</title>


<!-- ==================================================
     FUENTES
================================================== -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap"
rel="stylesheet"
>


<style>

/* ==================================================
   VARIABLES
================================================== */

:root {

    --rosa: #b86f80;

    --rosa-oscuro: #945565;

    --rosa-claro: #dcaab6;

    --rosa-palido: #f8e9ed;

    --rosa-suave: #fdf4f6;

    --crema: #fffaf8;

    --blanco: #ffffff;

    --texto: #4c3e42;

    --gris: #817276;

    --borde: #ead8dd;

    --dorado: #b7966d;

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

    font-family: "DM Sans", sans-serif;

    overflow-x: hidden;

}


/* ==================================================
   DECORACIÓN DE FONDO
================================================== */

body::before {

    content: "";

    position: fixed;

    width: 400px;

    height: 400px;

    border-radius: 50%;

    background: rgba(220,170,182,.12);

    top: 10%;

    left: -250px;

    filter: blur(10px);

    pointer-events: none;

    z-index: -1;

}


body::after {

    content: "";

    position: fixed;

    width: 350px;

    height: 350px;

    border-radius: 50%;

    background: rgba(183,150,109,.08);

    bottom: 5%;

    right: -200px;

    filter: blur(10px);

    pointer-events: none;

    z-index: -1;

}


/* ==================================================
   HERO
================================================== */

.hero {

    min-height: 650px;

    position: relative;

    display: flex;

    align-items: center;

    padding: 70px 8%;

    overflow: hidden;

    background:

    linear-gradient(

        90deg,

        rgba(255,250,248,.97) 0%,

        rgba(255,250,248,.90) 38%,

        rgba(255,250,248,.38) 72%,

        rgba(255,250,248,.08) 100%

    ),

    url("https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg");

    background-size: cover;

    background-position: center;

    animation: aparecerHero 1.2s ease;

}


/* decoración */

.hero::before {

    content: "";

    position: absolute;

    width: 240px;

    height: 240px;

    border: 1px solid rgba(184,111,128,.25);

    border-radius: 50%;

    right: 7%;

    bottom: -100px;

}


.hero::after {

    content: "HAIR CARE";

    position: absolute;

    right: 7%;

    top: 50%;

    transform: rotate(90deg);

    font-size: .7rem;

    letter-spacing: 7px;

    color: rgba(184,111,128,.65);

}


/* ==================================================
   CONTENIDO HERO
================================================== */

.hero-content {

    max-width: 590px;

    position: relative;

    z-index: 2;

}


.hero-etiqueta {

    display: inline-flex;

    align-items: center;

    gap: 12px;

    color: var(--rosa);

    font-size: .72rem;

    font-weight: 600;

    letter-spacing: 4px;

    text-transform: uppercase;

    margin-bottom: 25px;

}


.hero-etiqueta::before {

    content: "";

    width: 45px;

    height: 1px;

    background: var(--rosa);

}


.hero h1 {

    font-family: "Playfair Display", serif;

    font-size: clamp(4rem, 8vw, 7.5rem);

    font-weight: 400;

    line-height: .9;

    letter-spacing: 5px;

    color: var(--rosa);

}


.hero h1 span {

    display: block;

    font-size: .38em;

    color: var(--texto);

    letter-spacing: 8px;

    margin-top: 20px;

    font-family: "DM Sans", sans-serif;

    font-weight: 300;

}


.hero-frase {

    margin-top: 35px;

    max-width: 480px;

    font-family: "Playfair Display", serif;

    font-style: italic;

    font-size: 1.25rem;

    line-height: 1.7;

    color: #68585d;

}


.hero-descripcion {

    margin-top: 18px;

    max-width: 470px;

    color: var(--gris);

    font-size: .93rem;

    line-height: 1.8;

}


/* ==================================================
   BOTÓN HERO
================================================== */

.hero-btn {

    display: inline-flex;

    align-items: center;

    gap: 15px;

    margin-top: 32px;

    padding: 14px 26px;

    border: 1px solid var(--rosa);

    color: var(--rosa);

    text-decoration: none;

    font-size: .78rem;

    font-weight: 600;

    letter-spacing: 1.5px;

    text-transform: uppercase;

    transition: .35s ease;

}


.hero-btn span {

    transition: .35s ease;

}


.hero-btn:hover {

    background: var(--rosa);

    color: white;

}


.hero-btn:hover span {

    transform: translateX(5px);

}


/* ==================================================
   FRASE DESTACADA
================================================== */

.mensaje {

    padding: 70px 25px;

    text-align: center;

    background: var(--rosa-palido);

    position: relative;

}


.mensaje::before {

    content: "✦";

    position: absolute;

    left: 12%;

    top: 30px;

    color: var(--rosa-claro);

    font-size: 22px;

}


.mensaje::after {

    content: "✦";

    position: absolute;

    right: 12%;

    bottom: 30px;

    color: var(--rosa-claro);

    font-size: 22px;

}


.mensaje-pequeno {

    color: var(--rosa);

    text-transform: uppercase;

    letter-spacing: 4px;

    font-size: .7rem;

    font-weight: 600;

    margin-bottom: 15px;

}


.mensaje h2 {

    max-width: 750px;

    margin: auto;

    font-family: "Playfair Display", serif;

    font-size: clamp(1.8rem, 4vw, 3rem);

    line-height: 1.35;

    font-weight: 400;

    color: var(--texto);

}


.mensaje h2 em {

    color: var(--rosa);

}


/* ==================================================
   SECCIÓN PRODUCTOS
================================================== */

.section {

    max-width: 1450px;

    margin: auto;

    padding: 100px 50px;

}


/* ==================================================
   ENCABEZADO
================================================== */

.encabezado {

    text-align: center;

    margin-bottom: 65px;

}


.encabezado-pequeno {

    color: var(--rosa);

    font-size: .7rem;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: 4px;

    margin-bottom: 16px;

}


.titulo {

    font-family: "Playfair Display", serif;

    font-size: clamp(2.2rem, 4vw, 3.3rem);

    font-weight: 400;

    color: var(--texto);

}


.subtitulo {

    max-width: 600px;

    margin: 18px auto 0;

    color: var(--gris);

    font-size: .9rem;

    line-height: 1.8;

}


.linea-decorativa {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 10px;

    margin-top: 25px;

}


.linea-decorativa::before,

.linea-decorativa::after {

    content: "";

    width: 45px;

    height: 1px;

    background: var(--rosa-claro);

}


.linea-decorativa span {

    color: var(--rosa);

    font-size: 12px;

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

    background: var(--blanco);

    border: 1px solid var(--borde);

    position: relative;

    overflow: hidden;

    box-shadow:

    0 10px 35px rgba(100,70,80,.05);

    transition:

    transform .45s ease,

    box-shadow .45s ease;

}


.card:hover {

    transform: translateY(-10px);

    box-shadow:

    0 25px 55px rgba(100,70,80,.14);

}


/* ==================================================
   ETIQUETA PRODUCTO
================================================== */

.etiqueta-producto {

    position: absolute;

    top: 18px;

    left: 18px;

    z-index: 5;

    background: rgba(255,255,255,.92);

    backdrop-filter: blur(8px);

    padding: 8px 13px;

    color: var(--rosa);

    font-size: .65rem;

    text-transform: uppercase;

    letter-spacing: 1.5px;

    font-weight: 600;

}


/* ==================================================
   IMAGEN
================================================== */

.imagen-producto {

    height: 330px;

    overflow: hidden;

    background:

    linear-gradient(

        135deg,

        #f8e9ed,

        #fffaf8

    );

    position: relative;

}


.imagen-producto::after {

    content: "DIVINE";

    position: absolute;

    bottom: 15px;

    right: 18px;

    color: rgba(255,255,255,.85);

    font-family: "Playfair Display", serif;

    font-size: .8rem;

    letter-spacing: 3px;

}


.imagen-producto img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: transform .8s cubic-bezier(.2,.7,.2,1);

}


.card:hover .imagen-producto img {

    transform: scale(1.07);

}


/* ==================================================
   INFORMACIÓN
================================================== */

.info {

    padding: 28px 26px 25px;

}


/* ==================================================
   NOMBRE
================================================== */

.info h3 {

    font-family: "Playfair Display", serif;

    font-size: 1.45rem;

    font-weight: 500;

    color: var(--texto);

    text-align: center;

    margin-bottom: 13px;

    line-height: 1.35;

}


/* ==================================================
   DESCRIPCIÓN
================================================== */

.descripcion {

    color: var(--gris);

    font-size: .86rem;

    line-height: 1.75;

    min-height: 52px;

    text-align: center;

    margin-bottom: 20px;

}


/* ==================================================
   SEPARADOR
================================================== */

.separador {

    width: 100%;

    height: 1px;

    background: var(--borde);

    margin-bottom: 20px;

}


/* ==================================================
   PRECIO
================================================== */

.precio-contenedor {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 20px;

}


.precio-label {

    font-size: .68rem;

    text-transform: uppercase;

    letter-spacing: 1.5px;

    color: #a09296;

}


.precio {

    font-family: "Playfair Display", serif;

    font-size: 1.5rem;

    color: var(--rosa);

}


/* ==================================================
   BOTÓN CARRITO
================================================== */

.btn-carrito {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 10px;

    width: 100%;

    height: 50px;

    border-radius: 0;

    background: var(--rosa);

    color: white;

    font-size: .76rem;

    font-weight: 600;

    letter-spacing: 1px;

    text-transform: uppercase;

    text-decoration: none;

    border: 1px solid var(--rosa);

    transition: .35s ease;

}


.btn-carrito::after {

    content: "→";

    font-size: 17px;

    transition: .3s ease;

}


.btn-carrito:hover {

    background: var(--rosa-oscuro);

    border-color: var(--rosa-oscuro);

}


.btn-carrito:hover::after {

    transform: translateX(5px);

}


/* ==================================================
   STOCK
================================================== */

.stock {

    text-align: center;

    margin-top: 15px;

    font-size: .7rem;

    color: #9a8b8f;

    letter-spacing: .4px;

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


/* ==================================================
   AGOTADO
================================================== */

.btn-agotado {

    background: #e7e1e3;

    border-color: #e7e1e3;

    color: #8d8386;

    cursor: not-allowed;

}


.btn-agotado::after {

    content: "×";

}


.btn-agotado:hover {

    background: #e7e1e3;

    border-color: #e7e1e3;

    color: #8d8386;

}


/* ==================================================
   MENSAJE SIN PRODUCTOS
================================================== */

.sin-productos {

    grid-column: 1 / -1;

    padding: 90px 30px;

    text-align: center;

    background: white;

    border: 1px solid var(--borde);

}


.sin-productos-icono {

    font-family: "Playfair Display", serif;

    font-size: 3rem;

    color: var(--rosa-claro);

    margin-bottom: 15px;

}


.sin-productos h3 {

    font-family: "Playfair Display", serif;

    font-size: 1.7rem;

    font-weight: 400;

    margin-bottom: 10px;

}


.sin-productos p {

    color: var(--gris);

    font-size: .9rem;

}


/* ==================================================
   SECCIÓN FINAL
================================================== */

.final-hair {

    padding: 100px 30px;

    text-align: center;

    background:

    linear-gradient(

        rgba(80,50,58,.68),

        rgba(80,50,58,.68)

    ),

    url("https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg");

    background-size: cover;

    background-position: center;

    color: white;

}


.final-hair .mini {

    font-size: .7rem;

    text-transform: uppercase;

    letter-spacing: 5px;

    margin-bottom: 20px;

    opacity: .85;

}


.final-hair h2 {

    font-family: "Playfair Display", serif;

    font-size: clamp(2rem, 5vw, 4rem);

    font-weight: 400;

    margin-bottom: 20px;

}


.final-hair p {

    max-width: 600px;

    margin: auto;

    line-height: 1.8;

    font-size: .92rem;

    opacity: .9;

}


/* ==================================================
   ANIMACIONES
================================================== */

.animar {

    opacity: 0;

    transform: translateY(35px);

}


.animar.activo {

    opacity: 1;

    transform: translateY(0);

    transition:

    opacity .8s ease,

    transform .8s ease;

}


/* ==================================================
   HERO ANIMATION
================================================== */

@keyframes aparecerHero {

    from {

        opacity: 0;

        transform: scale(1.03);

    }

    to {

        opacity: 1;

        transform: scale(1);

    }

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width: 768px) {

    .hero {

        min-height: 580px;

        padding: 50px 30px;

        background-position: 68% center;

    }


    .hero h1 {

        font-size: 4.2rem;

        letter-spacing: 2px;

    }


    .hero h1 span {

        letter-spacing: 5px;

    }


    .hero-frase {

        font-size: 1.05rem;

    }


    .hero::after {

        display: none;

    }


    .section {

        padding: 70px 20px;

    }


    .grid {

        grid-template-columns: 1fr;

        gap: 25px;

    }


    .imagen-producto {

        height: 300px;

    }


    .mensaje {

        padding: 60px 25px;

    }

}

</style>

</head>


<body>


<!-- ==================================================
     SUBMENÚ
================================================== -->

<?php

include 'submenuespecial.php';

?>


<script src="./AJAX/buscar.js"></script>


<div id="productos"></div>


<!-- ==================================================
     HERO SKIN HAIR
================================================== -->

<section class="hero">

    <div class="hero-content">


        <div class="hero-etiqueta">

            Cuidado capilar

        </div>


        <h1>

            DIVINE

            <span>

                SKIN HAIR

            </span>

        </h1>


        <p class="hero-frase">

            “Tu cabello también merece sentirse

            cuidado, bonito y lleno de vida.”

        </p>


        <p class="hero-descripcion">

            Descubre nuestra selección de productos

            pensados para consentir tu cabello,

            mantenerlo hidratado y darle el cuidado

            que merece todos los días.

        </p>


        <a href="#coleccion" class="hero-btn">

            Descubrir colección

            <span>→</span>

        </a>


    </div>

</section>



<!-- ==================================================
     MENSAJE ESPECIAL
================================================== -->

<section class="mensaje">


    <div class="mensaje-pequeno">

        Un momento para ti

    </div>


    <h2>

        Porque cuidar tu cabello

        también es una forma de

        <em>quererte.</em>

    </h2>


</section>



<!-- ==================================================
     PRODUCTOS
================================================== -->

<section class="section" id="coleccion">


    <div class="encabezado">


        <div class="encabezado-pequeno">

            DIVINE HAIR COLLECTION

        </div>


        <h2 class="titulo">

            Cuidado que se siente

        </h2>


        <p class="subtitulo">

            Encuentra productos seleccionados para

            acompañar tu rutina capilar y darle a tu

            cabello ese toque especial que estabas buscando.

        </p>


        <div class="linea-decorativa">

            <span>✦</span>

        </div>


    </div>



    <div class="grid">


<?php


if ($resultado->num_rows > 0) {


    while ($fila = $resultado->fetch_assoc()) {


        $codigo = $fila['codigo'];

        $stock = (int)$fila['stock'];


?>


        <!-- ==================================================
             TARJETA PRODUCTO
        ================================================== -->

        <div class="card animar">


            <div class="etiqueta-producto">

                ✦ Hair Care

            </div>


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



                <div class="separador"></div>



                <!-- PRECIO -->

                <div class="precio-contenedor">


                    <span class="precio-label">

                        Precio

                    </span>


                    <div class="precio">

                        Bs

                        <?php

                        echo htmlspecialchars(

                            $fila['precio']

                        );

                        ?>

                    </div>


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

                    href="./CRUD-CARRITO-PEDIDO/formpedido.php?codigo=<?php echo $codigo; ?>"

                    class="btn-carrito"

                >

                    Agregar al carrito

                </a>


<?php


}


?>



<?php


if ($stock <= 0) {


?>


                <div class="stock agotado">

                    Actualmente agotado

                </div>


<?php


} elseif ($stock <= 5) {


?>


                <div class="stock ultimas">

                    ✦ Últimas unidades:

                    <strong>

                        <?php

                        echo $stock;

                        ?>

                    </strong>

                    disponibles

                </div>


<?php


} else {


?>


                <div class="stock">

                    ♥ Stock disponible:

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


            <div class="sin-productos-icono">

                ✦

            </div>


            <h3>

                Tu colección está por crecer

            </h3>


            <p>

                Pronto tendremos nuevos productos

                para consentir tu cabello.

            </p>


        </div>


<?php


}


?>


    </div>

</section>



<!-- ==================================================
     MENSAJE FINAL
================================================== -->

<section class="final-hair">


    <div class="mini">

        DIVINE · SKIN HAIR

    </div>


    <h2>

        Tu cabello,

        tu momento.

    </h2>


    <p>

        Haz de tu rutina capilar un momento especial.

        Porque cada día es una oportunidad para cuidarte,

        consentirte y sentirte increíble.

    </p>


</section>



<!-- ==================================================
     PIE DE PÁGINA
================================================== -->

<?php

include 'submenpiepag.php';

?>



<script>

/* ==================================================
   ANIMACIÓN DE PRODUCTOS
================================================== */


const elementos = document.querySelectorAll('.animar');


const observador = new IntersectionObserver(

    (entradas) => {


        entradas.forEach(

            (entrada) => {


                if (entrada.isIntersecting) {


                    entrada.target.classList.add('activo');


                    observador.unobserve(

                        entrada.target

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

        observador.observe(elemento);

    }

);

</script>


</body>

</html>


<?php

$conn->close();

?>