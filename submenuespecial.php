<?php
/* =========================================================
   CONEXIÓN A LA BASE DE DATOS
========================================================= */

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$connBuscador = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);

if ($connBuscador->connect_error) {
    die("Error de conexión con la base de datos.");
}

$connBuscador->set_charset("utf8mb4");


/* =========================================================
   FUNCIÓN PARA BUSCAR LA IMAGEN REAL DEL PRODUCTO
========================================================= */

function obtenerImagenProducto($codigo)
{
    $directorioWeb = "./PRODUCTO-img/";
    $directorioFisico = __DIR__ . "/PRODUCTO-img/";

    $nombreArchivo = "p-" . $codigo;

    $extensiones = [
        "jpg",
        "jpeg",
        "png",
        "gif",
        "webp"
    ];

    foreach ($extensiones as $extension) {

        $rutaFisica =
            $directorioFisico .
            $nombreArchivo .
            "." .
            $extension;

        if (file_exists($rutaFisica)) {

            return
                $directorioWeb .
                $nombreArchivo .
                "." .
                $extension;
        }
    }

    return "./imagenes/DIVINE-removebg-preview.png";
}


/* =========================================================
   BUSCAR PRODUCTO
========================================================= */

$resultadoBuscador = null;
$busquedaRealizada = false;

if (isset($_GET["buscar_producto"])) {

    $busquedaRealizada = true;

    $nombreBuscado = trim($_GET["buscar_producto"]);

    if ($nombreBuscado !== "") {

        $textoBusqueda = "%" . $nombreBuscado . "%";

        $sqlBuscador = "
            SELECT
                codigo,
                nombre,
                descripcion,
                precio,
                stock
            FROM PRODUCTO
            WHERE nombre LIKE ?
            ORDER BY nombre ASC
        ";

        $stmtBuscador =
            $connBuscador->prepare($sqlBuscador);

        if ($stmtBuscador) {

            $stmtBuscador->bind_param(
                "s",
                $textoBusqueda
            );

            $stmtBuscador->execute();

            $resultadoBuscador =
                $stmtBuscador->get_result();
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

<title>Cabecera Responsive</title>

<style>

/* ==================================================
   GENERAL
================================================== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    overflow-x:hidden;
}

header{
    background:transparent;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 40px;
    width:100%;
    position:relative;
    z-index:10000;
}

a{
    text-decoration:none;
    color:inherit;
    font-family:"Lora",serif;
}


/* ==================================================
   LOGO
================================================== */

.logo{
    display:flex;
    align-items:center;
}

.logo img{
    width:160px;
    display:block;
}


/* ==================================================
   MENÚ
================================================== */

nav{
    display:flex;
}

.menu{
    display:flex;
    list-style:none;
    align-items:center;
}

.menu li{
    position:relative;
}

.menu li a{
    display:block;
    padding:15px 20px;
    font-size:20px;
    transition:.3s;
    border-radius:10px;
}

.menu li a:hover{
    transform:translateY(3px);
}


/* ==================================================
   SUBMENÚ PC
================================================== */

.submenu{
    display:none;
    position:absolute;
    top:100%;
    left:0;
    min-width:220px;
    list-style:none;
    background:white;
    border-radius:12px;
    box-shadow:
        0 10px 25px rgba(0,0,0,.15);
    z-index:9999;
}

.submenu li a{
    padding:12px 20px;
    font-size:17px;
}

.menu li:hover > .submenu{
    display:block;
}


/* ==================================================
   PRODUCTOS + FLECHA
================================================== */

.productos-contenedor{
    display:flex;
    align-items:center;
}

.productos-contenedor > a{
    flex:1;
}

.boton-submenu{
    display:none;
}


/* ==================================================
   ICONOS DERECHA
================================================== */

.iconos-derecha{
    display:flex;
    gap:20px;
    align-items:center;
}


/* ==================================================
   BUSCADOR
================================================== */

.buscador{
    display:flex;
    align-items:center;
    position:relative;
}

.buscador-contenedor{
    display:flex;
    align-items:center;
    width:40px;
    height:40px;
    overflow:visible;
    border-radius:25px;
    transition:
        width .5s ease,
        background .3s ease,
        box-shadow .3s ease;
    position:relative;
}

.buscador-contenedor:hover{
    width:260px;
    background:white;
    box-shadow:
        0 5px 20px rgba(0,0,0,.15);
}

.buscador-contenedor input{
    width:0;
    opacity:0;
    border:none;
    outline:none;
    background:transparent;
    padding:0;
    font-size:15px;
    color:#444;
    transition:
        width .4s ease,
        opacity .3s ease,
        padding .4s ease;
}

.buscador-contenedor:hover input{
    width:190px;
    opacity:1;
    padding:0 10px 0 15px;
}


/* ==================================================
   BOTÓN BUSCAR
================================================== */

.boton-buscar{
    width:40px;
    min-width:40px;
    height:40px;
    border:none;
    background:transparent;
    cursor:pointer;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:0;
}

.boton-buscar img{
    width:25px;
    height:25px;
    object-fit:contain;
    transition:
        transform .3s ease;
}

.boton-buscar:hover img{
    transform:scale(1.1);
}


/* ==================================================
   CARRITO Y PERFIL
================================================== */

.iconos-derecha > a img{
    width:25px;
    height:25px;
    object-fit:contain;
    transition:
        transform .3s ease;
}

.iconos-derecha > a:hover img{
    transform:scale(1.1);
}


/* ==================================================
   RESULTADOS DEL BUSCADOR
================================================== */

.resultados-buscador{

    position:absolute;

    top:52px;

    right:0;

    width:520px;

    max-height:650px;

    overflow-y:auto;

    background:#fffaf8;

    border:1px solid #ead7dc;

    border-radius:22px;

    box-shadow:
        0 18px 50px rgba(80,50,60,.20);

    padding:18px;

    display:none;

    z-index:20000;

    animation:
        aparecerBusqueda .35s ease;
}


/* ==================================================
   MOSTRAR RESULTADOS
================================================== */

.resultados-buscador.activo{
    display:block;
}


/* ==================================================
   TARJETA RESULTADO
================================================== */

.resultado-producto{

    display:flex;

    gap:20px;

    background:#ffffff;

    border:1px solid #ead7dc;

    border-radius:18px;

    padding:16px;

    margin-bottom:14px;

    box-shadow:
        0 7px 22px rgba(100,70,80,.08);

    transition:
        transform .3s ease,
        box-shadow .3s ease;
}

.resultado-producto:last-child{
    margin-bottom:0;
}

.resultado-producto:hover{

    transform:translateY(-4px);

    box-shadow:
        0 12px 28px rgba(100,70,80,.14);
}


/* ==================================================
   IMAGEN GRANDE
================================================== */

.resultado-imagen{

    width:150px;

    min-width:150px;

    height:150px;

    border-radius:15px;

    overflow:hidden;

    background:
        linear-gradient(
            135deg,
            #f9e9ed,
            #f3d8df
        );

    display:flex;

    justify-content:center;

    align-items:center;
}

.resultado-imagen img{

    width:100%;

    height:100%;

    object-fit:cover;

    display:block;

    transition:
        transform .5s ease;
}

.resultado-producto:hover
.resultado-imagen img{

    transform:scale(1.05);
}


/* ==================================================
   INFORMACIÓN
================================================== */

.resultado-info{

    flex:1;

    display:flex;

    flex-direction:column;

    justify-content:center;
}

.resultado-etiqueta{

    color:#b86f80;

    font-size:.68rem;

    font-weight:700;

    letter-spacing:3px;

    text-transform:uppercase;

    margin-bottom:6px;
}

.resultado-info h3{

    font-family:Georgia,serif;

    font-size:1.35rem;

    color:#57494c;

    margin-bottom:8px;

    line-height:1.25;
}

.resultado-descripcion{

    color:#817679;

    font-size:.82rem;

    line-height:1.5;

    margin-bottom:10px;

    display:-webkit-box;

    -webkit-line-clamp:3;

    -webkit-box-orient:vertical;

    overflow:hidden;
}


/* ==================================================
   PRECIO
================================================== */

.resultado-precio{

    color:#b86f80;

    font-family:Georgia,serif;

    font-size:1.25rem;

    font-weight:600;

    margin-bottom:8px;
}


/* ==================================================
   STOCK
================================================== */

.resultado-stock{

    color:#817679;

    font-size:.75rem;

    margin-bottom:10px;
}

.resultado-stock strong{
    color:#b86f80;
}


/* ==================================================
   BOTÓN RESULTADO
================================================== */

.resultado-boton{

    display:inline-flex;

    justify-content:center;

    align-items:center;

    width:100%;

    min-height:38px;

    padding:0 14px;

    border-radius:9px;

    background:#b86f80;

    border:1px solid #b86f80;

    color:white;

    font-family:"Lora",serif;

    font-size:.78rem;

    font-weight:600;

    cursor:pointer;

    transition:
        background .3s ease,
        color .3s ease,
        transform .3s ease;
}

.resultado-boton:hover{

    background:transparent;

    color:#b86f80;

    transform:translateY(-2px);
}


/* ==================================================
   MENSAJE
================================================== */

.busqueda-mensaje{

    text-align:center;

    padding:30px 20px;

    color:#817679;

    font-family:"Lora",serif;

    font-size:.95rem;
}

.busqueda-mensaje-icono{

    font-size:30px;

    margin-bottom:10px;

    color:#b86f80;
}


/* ==================================================
   HAMBURGUESA
================================================== */

.hamburger{
    display:none;
    font-size:34px;
    cursor:pointer;
    z-index:10001;
}


/* ==================================================
   BOTÓN CERRAR
================================================== */

.close-menu{
    display:none;
}


/* ==================================================
   OVERLAY
================================================== */

.overlay{

    position:fixed;

    top:0;

    left:0;

    width:100%;

    height:100%;

    background:rgba(0,0,0,.45);

    opacity:0;

    visibility:hidden;

    transition:.3s;

    z-index:9998;
}

.overlay.active{

    opacity:1;

    visibility:visible;
}


/* ==================================================
   ANIMACIÓN
================================================== */

@keyframes aparecerBusqueda{

    from{

        opacity:0;

        transform:
            translateY(-8px)
            scale(.98);
    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);
    }
}


/* ==================================================
   TABLET Y CELULAR
================================================== */

@media(max-width:768px){

    header{
        padding:10px 20px;
    }


    /* LOGO */

    .logo img{
        width:120px;
    }


    /* HAMBURGUESA */

    .hamburger{
        display:block;
    }


    /* MENÚ LATERAL */

    nav{

        position:fixed;

        top:0;

        left:-300px;

        width:280px;

        height:100vh;

        background:white;

        box-shadow:
            5px 0 25px rgba(0,0,0,.15);

        transition:.4s;

        z-index:10000;

        padding-top:70px;
    }

    nav.active{
        left:0;
    }


    /* MENÚ */

    .menu{

        flex-direction:column;

        width:100%;

        align-items:flex-start;
    }

    .menu li{
        width:100%;
    }


    /* ENLACES */

    .menu li a{

        width:100%;

        padding:18px 25px;

        font-size:18px;
    }


    /* PRODUCTOS */

    .productos-contenedor{

        width:100%;

        display:flex;
    }

    .productos-contenedor > a{

        width:auto;

        flex:1;
    }


    /* BOTÓN FLECHA */

    .boton-submenu{

        display:flex;

        justify-content:center;

        align-items:center;

        width:55px;

        height:55px;

        border:none;

        background:transparent;

        font-size:22px;

        cursor:pointer;

        transition:.3s;
    }

    .boton-submenu.activo{
        transform:rotate(180deg);
    }


    /* SUBMENÚ */

    .submenu{

        display:none;

        position:absolute;

        top:0;

        left:100%;

        width:210px;

        min-width:210px;

        background:white;

        border-radius:0 12px 12px 0;

        box-shadow:
            5px 5px 20px rgba(0,0,0,.15);

        padding:5px 0;

        z-index:10002;
    }

    .menu li.submenu-abierto > .submenu{
        display:block;
    }

    .submenu li{
        width:100%;
    }

    .submenu li a{

        width:100%;

        font-size:16px;

        padding:15px 18px;
    }

    .submenu li a:hover{

        background:#f5f5f5;

        transform:none;
    }


    /* CERRAR */

    .close-menu{

        display:block;

        position:absolute;

        top:15px;

        right:20px;

        font-size:28px;

        cursor:pointer;
    }


    /* ICONOS */

    .iconos-derecha{
        gap:12px;
    }


    /* BUSCADOR */

    .buscador-contenedor{
        width:40px;
    }

    .buscador-contenedor:hover{
        width:250px;
    }

    .buscador-contenedor:hover input{
        width:190px;
    }


    /* RESULTADOS */

    .resultados-buscador{

        width:420px;

        max-width:
            calc(100vw - 30px);

        right:-40px;

        max-height:600px;
    }
    

    .resultado-producto{

        gap:14px;

        padding:13px;
    }

    .resultado-imagen{

        width:115px;

        min-width:115px;

        height:115px;
    }

    .resultado-info h3{
        font-size:1.1rem;
    }

    .resultado-descripcion{
        font-size:.76rem;
    }

    .resultado-precio{
        font-size:1.05rem;
    }

}


/* ==================================================
   CELULAR PEQUEÑO
================================================== */

@media(max-width:480px){

    header{
        padding:8px 12px;
    }


    /* LOGO */

    .logo img{
        width:95px;
    }


    /* ICONOS */

    .iconos-derecha{
        gap:6px;
    }

    .iconos-derecha > a img{

        width:20px;

        height:20px;
    }


    /* BUSCADOR */

    .buscador-contenedor{

        width:35px;

        height:35px;
    }

    .boton-buscar{

        width:35px;

        min-width:35px;

        height:35px;
    }

    .boton-buscar img{

        width:21px;

        height:21px;
    }

    .buscador-contenedor:hover{

        width:200px;
    }

    .buscador-contenedor:hover input{

        width:150px;

        font-size:13px;
    }


    /* RESULTADOS */

    .resultados-buscador{

        width:calc(100vw - 24px);

        max-width:none;

        right:-8px;

        max-height:550px;

        padding:10px;
    }

    .resultado-producto{

        flex-direction:column;

        gap:12px;
    }

    .resultado-imagen{

        width:100%;

        min-width:100%;

        height:190px;
    }

    .resultado-info h3{

        font-size:1.15rem;

    }

    .resultado-descripcion{

        font-size:.8rem;

    }


    /* HAMBURGUESA */

    .hamburger{
        font-size:28px;
    }


    /* MENÚ */

    nav{

        width:250px;

        left:-250px;
    }

    nav.active{
        left:0;
    }


    .menu li a{

        padding:15px 20px;

        font-size:16px;
    }


    /* SUBMENÚ */

    .submenu{

        width:190px;

        min-width:190px;

        left:100%;

        border-radius:0 10px 10px 0;
    }

    .submenu li a{

        font-size:14px;

        padding:13px 15px;
    }


    /* FLECHA */

    .boton-submenu{

        width:50px;

        height:50px;

        font-size:20px;
    }


    /* CERRAR */

    .close-menu{

        top:12px;

        right:15px;

        font-size:25px;
    }

}

</style>

</head>


<body>

<header>


    <!-- ==================================================
         LOGO
    ================================================== -->

    <div class="logo">

        <a href="index.php">

            <img
                src="./imagenes/DIVINE-removebg-preview.png"
                alt="Logo DIVINE"
            >

        </a>

    </div>


    <!-- ==================================================
         HAMBURGUESA
    ================================================== -->

    <div
        class="hamburger"
        onclick="toggleMenu()"
    >
        ☰
    </div>


    <!-- ==================================================
         MENÚ
    ================================================== -->

    <nav id="menuLateral">


        <!-- CERRAR -->

        <div
            class="close-menu"
            onclick="toggleMenu()"
        >
            ✕
        </div>


        <ul class="menu">


            <!-- INICIO -->

            <li>

                <a href="totu.php">
                    Inicio
                </a>

            </li>


            <!-- ==================================================
                 PRODUCTOS
            ================================================== -->

            <li id="productosMenu">

                <div class="productos-contenedor">

                    <a href="produccomp.php">
                        Productos
                    </a>


                    <!-- BOTÓN SUBMENÚ -->

                    <button
                        class="boton-submenu"
                        onclick="toggleSubmenu(event)"
                        type="button"
                    >
                        ›
                    </button>

                </div>


                <!-- SUBMENÚ -->

                <ul class="submenu">

                    <li>

                        <a href="skincare.php">
                            Skin Care
                        </a>

                    </li>

                    <li>

                        <a href="mascarillas.php">
                            Skin Hair
                        </a>

                    </li>

                </ul>

            </li>


            <!-- HISTORIA -->

            <li>

                <a href="mision-vision.php">
                    Historia
                </a>

            </li>


            <!-- CONTACTO -->

            <li>

                <a href="contactanos.php">
                    Contacto
                </a>

            </li>


            <!-- MIS PEDIDOS -->

            <li>

                <a href="CONSULTA-pedido/formreadpedido.php">
                    Consulta
                </a>

            </li>


            <!-- GESTIÓN AMBIENTAL -->

            <li>

                <a href="formulario.pdf">
                    Gestión Ambiental
                </a>

            </li>

        </ul>

    </nav>


    <!-- ==================================================
         ICONOS DERECHA
    ================================================== -->

    <div class="iconos-derecha">


        <!-- BUSCADOR -->

        <div class="buscador">

            <div class="buscador-contenedor">

                <input
                    type="text"
                    id="textoBuscar"
                    placeholder="Buscar producto..."
                    autocomplete="off"
                >


                <button
                    class="boton-buscar"
                    onclick="buscarProducto()"
                    type="button"
                >

                    <img
                        src="./imagenes/lupa-removebg-preview.png"
                        alt="Buscar"
                    >

                </button>


                <!-- ==================================================
                     RESULTADOS
                ================================================== -->

                <div
                    class="resultados-buscador"
                    id="resultadosBuscador"
                >

<?php

if ($busquedaRealizada) {

    if (
        $resultadoBuscador &&
        $resultadoBuscador->num_rows > 0
    ) {

        while (
            $producto =
            $resultadoBuscador->fetch_assoc()
        ) {

            $codigoResultado =
                $producto["codigo"];

            $imagenResultado =
                obtenerImagenProducto(
                    $codigoResultado
                );

?>

                    <div class="resultado-producto">


                        <!-- IMAGEN -->

                        <div class="resultado-imagen">

                            <img
                                src="<?php
                                echo htmlspecialchars(
                                    $imagenResultado
                                );
                                ?>"
                                alt="<?php
                                echo htmlspecialchars(
                                    $producto["nombre"]
                                );
                                ?>"
                            >

                        </div>


                        <!-- INFORMACIÓN -->

                        <div class="resultado-info">

                            <div class="resultado-etiqueta">
                                DIVINE
                            </div>

                            <h3>

                                <?php
                                echo htmlspecialchars(
                                    $producto["nombre"]
                                );
                                ?>

                            </h3>


                            <p class="resultado-descripcion">

                                <?php
                                echo htmlspecialchars(
                                    $producto["descripcion"]
                                );
                                ?>

                            </p>


                            <div class="resultado-precio">

                                Bs.
                                <?php
                                echo htmlspecialchars(
                                    $producto["precio"]
                                );
                                ?>

                            </div>


                            <div class="resultado-stock">

                                Stock:
                                <strong>

                                    <?php
                                    echo (int)
                                        $producto["stock"];
                                    ?>

                                </strong>

                            </div>


<a
    class="resultado-boton"
    href="./CRUD-producto/readunoprodu.php?codigo=<?php echo urlencode($producto['codigo']); ?>"
>
    Detalles del producto
</a>
                        </div>

                    </div>

<?php

        }

    } else {

?>

                    <div class="busqueda-mensaje">

                        <div class="busqueda-mensaje-icono">
                            ♡
                        </div>

                        No encontramos ese producto.

                    </div>

<?php

    }

}

?>

                </div>

            </div>

        </div>


        <!-- CARRITO -->

        <a href="./CRUD-CARRITO-PEDIDO/formpedido.php">

            <img
                src="./imagenes/carrito.png"
                alt="Carrito"
            >

        </a>


        <!-- PERFIL -->

        <a href="./SESIONES/loginformcliente.php">

            <img
                src="./imagenes/persona.png"
                alt="Perfil"
            >

        </a>

    </div>

</header>


<!-- ==================================================
     OVERLAY
================================================== -->

<div
    class="overlay"
    id="overlay"
    onclick="toggleMenu()"
>
</div>


<script>

/* ==================================================
   MENÚ HAMBURGUESA
================================================== */

function toggleMenu(){

    document
        .getElementById("menuLateral")
        .classList
        .toggle("active");

    document
        .getElementById("overlay")
        .classList
        .toggle("active");
}


/* ==================================================
   SUBMENÚ PRODUCTOS
================================================== */

function toggleSubmenu(event){

    event.preventDefault();

    event.stopPropagation();

    const productos =
        document.getElementById(
            "productosMenu"
        );

    const boton =
        productos.querySelector(
            ".boton-submenu"
        );

    productos
        .classList
        .toggle(
            "submenu-abierto"
        );

    boton
        .classList
        .toggle(
            "activo"
        );
}


/* ==================================================
   BUSCAR PRODUCTO
================================================== */

function buscarProducto(){

    const input =
        document.getElementById(
            "textoBuscar"
        );

    const resultados =
        document.getElementById(
            "resultadosBuscador"
        );

    const nombre =
        input.value.trim();


    /* SI ESTÁ VACÍO */

    if(nombre === ""){

        resultados.classList.remove(
            "activo"
        );

        resultados.innerHTML = "";

        return;
    }


    /* ==================================================
       RECARGAR LA MISMA PÁGINA CON EL PRODUCTO
    ================================================== */

    const url =
        window.location.pathname +
        "?buscar_producto=" +
        encodeURIComponent(
            nombre
        );

    window.location.href = url;
}


/* ==================================================
   ENTER PARA BUSCAR
================================================== */

document
    .getElementById("textoBuscar")
    .addEventListener(
        "keydown",
        function(event){

            if(event.key === "Enter"){

                event.preventDefault();

                buscarProducto();

            }

        }
    );


/* ==================================================
   MOSTRAR RESULTADOS DESPUÉS DE LA BÚSQUEDA
================================================== */

<?php

if ($busquedaRealizada) {

?>

document
    .getElementById(
        "resultadosBuscador"
    )
    .classList
    .add("activo");

<?php

}

?>


/* ==================================================
   CERRAR RESULTADOS AL HACER CLIC FUERA
================================================== */

document.addEventListener(
    "click",
    function(event){

        const buscador =
            document.querySelector(
                ".buscador"
            );

        const resultados =
            document.getElementById(
                "resultadosBuscador"
            );

        if(
            resultados &&
            !buscador.contains(event.target)
        ){

            resultados.classList.remove(
                "activo"
            );

        }

    }
);

</script>

</body>

</html>

<?php

$connBuscador->close();

?>