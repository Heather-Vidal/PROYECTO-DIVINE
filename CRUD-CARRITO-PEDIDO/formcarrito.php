<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";


/* ==========================================
   CONEXIÓN A LA BASE DE DATOS
========================================== */

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);


if ($conn->connect_error) {

    die(
        "Error de conexión: "
        . $conn->connect_error
    );

}


session_start();


/* ==========================================
   OBTENER ID DEL PEDIDO
========================================== */

if (!isset($_GET['idPedido'])) {

    die("No se recibió el ID del pedido.");

}


$id_pedido = $_GET['idPedido'];


/* ==========================================
   CONSULTAR TODOS LOS PRODUCTOS
========================================== */

$sql = "SELECT * FROM PRODUCTO";

$resultado = $conn->query($sql);


if (!$resultado) {

    die(
        "Error al consultar los productos: "
        . $conn->error
    );

}


/* ==========================================
   CALCULAR TOTAL DEL PEDIDO
========================================== */

$sqlTotal = "
    SELECT SUM(costototal) AS total
    FROM carrito
    WHERE PEDIDOS_ID = '$id_pedido'
";


$resultadoTotal = $conn->query($sqlTotal);


if (!$resultadoTotal) {

    die(
        "Error al calcular el total del pedido: "
        . $conn->error
    );

}


$res = $resultadoTotal->fetch_assoc();


/*
   Si existen productos en el carrito,
   obtiene el total.

   Si no existen productos,
   el total será 0.
*/

$total = $res['total'] ?? 0;

?>


<?php

$productoEliminado = false;

if (isset($_GET['eliminado']) && $_GET['eliminado'] == '1') {
    $productoEliminado = true;
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
    DIVINE | Seleccionar productos
</title>


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
    min-height: 100vh;
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

    url("../imagenes/fondote.png");

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

    margin-bottom: 35px;

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
   TOTAL DEL PEDIDO
================================================== */

.total {

    width: fit-content;

    min-width: 220px;

    margin: 0 auto 55px;

    padding: 15px 30px;

    background: white;

    border: 1px solid var(--borde);

    border-radius: 30px;

    text-align: center;

    color: #57494c;

    font-family: Georgia, serif;

    font-size: 1.2rem;

    box-shadow:
        0 8px 25px rgba(100,70,80,.08);

}


.total strong {

    color: var(--rosa);

    font-size: 1.4rem;

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

.imagen {

    height: 300px;

    overflow: hidden;

    background: var(--rosa-palido);

    position: relative;

}


.imagen img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition:
        transform .7s ease;

}


.card:hover
.imagen img {

    transform:
        scale(1.06);

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
   INFORMACIÓN
================================================== */

.info {

    padding: 27px 25px 25px;

    text-align: center;

}


/* ==================================================
   NOMBRE
================================================== */

.nombre-producto {

    font-family: Georgia, serif;

    font-size: 1.4rem;

    font-weight: 700;

    color: #57494c;

    text-align: center;

    margin-bottom: 14px;

    line-height: 1.3;

    text-transform: uppercase;

    letter-spacing: 1px;

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

    font-weight: 600;

}


/* ==================================================
   STOCK
================================================== */

.stock {

    text-align: center;

    margin-bottom: 20px;

    font-size: .82rem;

    color: #9a8b8f;

    letter-spacing: .3px;

}


.stock strong {

    color: var(--rosa);

    font-weight: 600;

}


/* ==================================================
   ÚLTIMAS UNIDADES
================================================== */

.stock.ultimas {

    color: #a57c55;

}


.stock.ultimas strong {

    color: #a57c55;

}


/* ==================================================
   AGOTADO
================================================== */

.stock.agotado {

    color: #999;

}


.stock.agotado strong {

    color: #999;

}


/* ==================================================
   CANTIDAD
================================================== */

.cantidad {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 12px;

    margin-bottom: 18px;

}


.cantidad button {

    width: 42px;

    height: 42px;

    border: none;

    border-radius: 50%;

    background: var(--rosa);

    color: white;

    font-size: 20px;

    cursor: pointer;

    transition: .3s ease;

}


.cantidad button:hover {

    background: #a65f70;

    transform: scale(1.08);

}


.cantidad button:disabled {

    background: #d8cdd0;

    cursor: not-allowed;

    transform: none;

}


.cantidad input {

    width: 70px;

    height: 42px;

    border: 1px solid var(--borde);

    border-radius: 10px;

    background: var(--rosa-palido);

    text-align: center;

    font-size: 16px;

    font-weight: 600;

    color: var(--texto);

    outline: none;

}


.cantidad input:focus {

    border-color: var(--rosa);

}


/* ==================================================
   BOTÓN AGREGAR
================================================== */

.btn {

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

    border: 1px solid var(--rosa);

    cursor: pointer;

    transition:
        background .3s ease,
        color .3s ease,
        transform .3s ease;

}


.btn:hover {

    background: transparent;

    color: var(--rosa);

    transform:
        translateY(-2px);

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
   BOTONES FINALES
================================================== */

.botones {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 18px;

    flex-wrap: wrap;

    margin-top: 65px;

}


.final {

    display: flex;

    justify-content: center;

    align-items: center;

    min-height: 48px;

    padding: 13px 25px;

    background: var(--rosa);

    color: white;

    border-radius: 8px;

    text-decoration: none;

    font-size: .9rem;

    font-weight: 600;

    border: 1px solid var(--rosa);

    transition:
        background .3s ease,
        color .3s ease,
        transform .3s ease;

}


.final:hover {

    background: transparent;

    color: var(--rosa);

    transform:
        translateY(-2px);

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


    .imagen {

        height:
            280px;

    }


    .botones {

        flex-direction:
            column;

    }


    .final {

        width: 100%;

        max-width: 350px;

    }

}
<style>

.fondo-mensaje {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(80, 30, 50, 0.35);
    z-index: 999;
}

.mensaje-exito {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    width: 380px;
    padding: 35px;

    background: #fff8fa;

    border-radius: 25px;

    text-align: center;

    box-shadow: 0 15px 40px rgba(0,0,0,0.25);

    z-index: 1000;

    border: 2px solid #e7a6b8;
}

.icono-exito {

    width: 65px;
    height: 65px;

    margin: 0 auto 15px;

    border-radius: 50%;

    background: #e8a7b9;

    color: white;

    font-size: 40px;
    font-weight: bold;

    display: flex;
    align-items: center;
    justify-content: center;
}

.mensaje-exito h2 {

    margin: 10px 0;

    color: #8d4058;

    font-size: 25px;

}

.mensaje-exito p {

    color: #6f555d;

    font-size: 16px;

    margin-bottom: 25px;

}

.mensaje-exito button {

    border: none;

    background: #c97991;

    color: white;

    padding: 12px 35px;

    border-radius: 25px;

    font-size: 16px;

    cursor: pointer;

    transition: 0.3s;

}

.mensaje-exito button:hover {

    background: #a95670;

    transform: scale(1.05);

}

</style>
</style>

</head>


<body>


<?php

include 'submenucarrito.php';

?>


<script>

const idPedido = <?php echo $id_pedido; ?>;

</script>


<script src="../AJAX/scriptventanacarrito.js"></script>

<script src="../AJAX/buscar.js"></script>



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

            Selecciona tus productos favoritos
            y comienza a crear tu pedido.

        </p>


    </div>


</section>



<!-- ==================================================
     PRODUCTOS
================================================== -->

<section class="section">


    <div class="encabezado">


        <div class="encabezado-pequeno">

            Tu pedido

        </div>


        <h2 class="titulo">

            Comienza a armar tu carrito

        </h2>


        <div class="linea-decorativa"></div>


    </div>



    <!-- ==================================================
         TOTAL
    ================================================== -->

    <div class="total">

        Total:

        <strong>

            Bs.
            <?php echo $total; ?>

        </strong>

    </div>



    <!-- ==================================================
         GRID DE PRODUCTOS
    ================================================== -->

    <div class="grid">


<?php


if ($resultado->num_rows > 0) {


    while ($fila = $resultado->fetch_assoc()) {


        /*
         * OBTENER STOCK DEL PRODUCTO
         */

        $stock = (int)$fila["stock"];


?>


        <!-- ==================================================
             TARJETA PRODUCTO
        ================================================== -->

        <div class="card animar">


            <!-- ==================================================
                 IMAGEN
            ================================================== -->

            <div class="imagen">


<?php

if (
    isset($fila["imagen"])
    &&
    $fila["imagen"] != ""
) {

?>


                <img

                    src="<?php

                    echo htmlspecialchars(
                        $fila["imagen"]
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

                    Imagen del producto

                </div>


<?php

}

?>


            </div>



            <!-- ==================================================
                 INFORMACIÓN
            ================================================== -->

            <div class="info">


                <!-- NOMBRE -->

                <h3 class="nombre-producto">

<?php

echo htmlspecialchars(

    strtoupper(
        $fila["nombre"]
    )

);

?>

                </h3>



                <!-- DESCRIPCIÓN -->

                <p class="descripcion">

<?php

echo htmlspecialchars(
    $fila["descripcion"]
);

?>

                </p>



                <!-- PRECIO -->

                <div class="precio">

                    Bs.

<?php

echo htmlspecialchars(
    $fila["precio"]
);

?>

                </div>



                <!-- ==================================================
                     STOCK
                ================================================== -->

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

echo $stock;

?>

                    </strong>

                    disponibles

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



                <!-- ==================================================
                     FORMULARIO
                ================================================== -->

<?php

/*
 * SI EL PRODUCTO ESTÁ AGOTADO
 * NO MOSTRAMOS EL FORMULARIO.
 */

if ($stock <= 0) {

?>


                <div class="btn btn-agotado">

                    Producto agotado

                </div>


<?php

} else {

?>


                <form

                    action="createcarrito.php"

                    method="post"

                >


                    <!-- ==================================================
                         CÓDIGO DEL PRODUCTO
                    ================================================== -->

                    <input

                        type="hidden"

                        name="codigo"

                        value="<?php

                        echo $fila["codigo"];

                        ?>"

                    >



                    <!-- ==================================================
                         ID DEL PEDIDO
                    ================================================== -->

                    <input

                        type="hidden"

                        name="idpedido"

                        value="<?php

                        echo $id_pedido;

                        ?>"

                    >



                    <!-- ==================================================
                         PRECIO
                    ================================================== -->

                    <input

                        type="hidden"

                        name="precio"

                        value="<?php

                        echo $fila["precio"];

                        ?>"

                    >



                    <!-- ==================================================
                         CANTIDAD
                    ================================================== -->

                    <div class="cantidad">


                        <button

                            type="button"

                            onclick="
                                cambiarCantidad(
                                    this,
                                    -1,
                                    <?php echo $stock; ?>
                                )
                            "

                        >

                            −

                        </button>



                        <input

                            type="number"

                            name="cantidad"

                            value="0"

                            min="0"

                            max="<?php echo $stock; ?>"

                            required

                        >



                        <button

                            type="button"

                            onclick="
                                cambiarCantidad(
                                    this,
                                    1,
                                    <?php echo $stock; ?>
                                )
                            "

                        >

                            +

                        </button>


                    </div>



                    <!-- ==================================================
                         AGREGAR
                    ================================================== -->

                    <button

                        type="submit"

                        class="btn"

                    >

                        Agregar al carrito

                    </button>


                </form>


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



    <!-- ==================================================
         BOTONES FINALES
    ================================================== -->

    <div class="botones">


        <a

            class="final"

            href="readunopedido.php?idPedido=<?php

            echo $id_pedido;

            ?>"

        >

            Finalizar compra

        </a>


    </div>


</section>



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



<!-- ==================================================
     CONTROL DE CANTIDAD SEGÚN STOCK
================================================== -->

<script>


function cambiarCantidad(
    boton,
    cambio,
    stock
) {


    const contenedor =
        boton.parentElement;


    const input =
        contenedor.querySelector(
            'input[name="cantidad"]'
        );


    let cantidad =
        parseInt(input.value) || 0;


    cantidad =
        cantidad + cambio;


    /*
     * NO PERMITIR MENOS DE 0
     */

    if (cantidad < 0) {

        cantidad = 0;

    }


    /*
     * NO PERMITIR SUPERAR EL STOCK
     */

    if (cantidad > stock) {

        cantidad = stock;

    }


    input.value = cantidad;


    /*
     * CONTROLAR BOTONES
     */

    const botones =
        contenedor.querySelectorAll(
            'button'
        );


    /*
     * BOTÓN MENOS
     */

    botones[0].disabled =
        cantidad <= 0;


    /*
     * BOTÓN MÁS
     */

    botones[1].disabled =
        cantidad >= stock;

}


</script>



<!-- ==================================================
     MANTENER POSICIÓN DEL SCROLL
================================================== -->

<script>


if (

    window.location.href.includes(
        "idPedido"
    )

) {


    const scroll =

        sessionStorage.getItem(
            "scrollY"
        );


    if (scroll) {


        window.scrollTo(

            0,

            parseInt(scroll)

        );


    }

}


window.addEventListener(

    "scroll",

    () => {


        sessionStorage.setItem(

            "scrollY",

            window.scrollY

        );


    }

);


</script>

<?php if ($productoEliminado): ?>

<div class="mensaje-exito">

    <div class="icono-exito">
        ✓
    </div>

    <h2>¡Producto eliminado!</h2>

    <p>
        El producto fue eliminado exitosamente.
    </p>

    <button onclick="cerrarMensaje()">
        Aceptar
    </button>

</div>

<div class="fondo-mensaje"></div>

<script>

function cerrarMensaje() {
    document.querySelector(".mensaje-exito").style.display = "none";
    document.querySelector(".fondo-mensaje").style.display = "none";
}

</script>

<?php endif; ?>
</body>

</html>


<?php

$conn->close();

?>