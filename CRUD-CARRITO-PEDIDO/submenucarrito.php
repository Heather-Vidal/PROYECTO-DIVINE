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
   RESET
================================================== */

*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}


/* ==================================================
   BODY
================================================== */

body{

    overflow-x:hidden;

    padding-top:80px;

}


/* ==================================================
   HEADER
================================================== */

header{

    background:transparent;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:10px 40px;

    width:100%;

    position:fixed;

    top:0;

    left:0;

    z-index:10000;

}


/* ==================================================
   ENLACES
================================================== */

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
   NAVEGACIÓN
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
   SUBMENÚ
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


/* ==================================================
   CONTENEDOR BUSCADOR
================================================== */

.buscador-contenedor{

    display:flex;

    align-items:center;

    width:40px;

    height:40px;

    overflow:hidden;

    border-radius:25px;

    transition:
        width .5s ease,
        background .3s ease,
        box-shadow .3s ease;

}


/* ==================================================
   BUSCADOR AL PASAR MOUSE
================================================== */

.buscador-contenedor:hover{

    width:260px;

    background:white;

    box-shadow:
        0 5px 20px rgba(0,0,0,.15);

}


/* ==================================================
   INPUT BUSCADOR
================================================== */

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


/* ==================================================
   INPUT CUANDO SE EXPANDE
================================================== */

.buscador-contenedor:hover input{

    width:190px;

    opacity:1;

    padding:
        0 10px 0 15px;

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

    transform:
        scale(1.1);

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

    transform:
        scale(1.1);

}


/* ==================================================
   CONTENEDOR DEL CARRITO
================================================== */

.carrito-contenedor{

    position:relative;

    width:30px;

    height:30px;

    display:flex;

    justify-content:center;

    align-items:center;

}


/* ==================================================
   ESTRELLITA DEL CARRITO
================================================== */

.estrellita-carrito{

    position:absolute;

    top:-10px;

    right:-10px;

    width:18px;

    height:18px;

    background:#c96f84;

    color:white;

    border-radius:50%;

    display:none;

    justify-content:center;

    align-items:center;

    font-size:12px;

    font-weight:bold;

    box-shadow:
        0 2px 8px rgba(201,111,132,.5);

    animation:
        aparecerEstrella .5s ease,
        pulsarEstrella 1.5s infinite;

}


.estrellita-carrito.activa{

    display:flex;

}


/* ==================================================
   CONTADOR DEL CARRITO
================================================== */

.contador-carrito{

    position:absolute;

    top:-12px;

    left:-10px;

    min-width:18px;

    height:18px;

    padding:2px 5px;

    background:#713d4d;

    color:white;

    border-radius:20px;

    font-size:10px;

    font-weight:bold;

    display:none;

    justify-content:center;

    align-items:center;

}


.contador-carrito.activo{

    display:flex;

}


/* ==================================================
   ANIMACIÓN ESTRELLA
================================================== */

@keyframes aparecerEstrella{

    from{

        opacity:0;

        transform:
            scale(0);

    }

    to{

        opacity:1;

        transform:
            scale(1);

    }

}


@keyframes pulsarEstrella{

    0%{

        transform:
            scale(1);

    }

    50%{

        transform:
            scale(1.18);

    }

    100%{

        transform:
            scale(1);

    }

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
   OVERLAY MENÚ
================================================== */

.overlay{

    position:fixed;

    top:0;

    left:0;

    width:100%;

    height:100%;

    background:
        rgba(0,0,0,.45);

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
   ⭐ VENTANA DEL CARRITO
   CORREGIDO Y CENTRADO
================================================== */

.modal-carrito{

    position:fixed;

    top:0;

    left:0;

    width:100vw;

    height:100vh;

    background:
        rgba(0,0,0,.45);

    display:none;

    justify-content:center;

    align-items:center;

    z-index:20000;

    padding:20px;

}


/* ==================================================
   CARRITO ACTIVO
================================================== */

.modal-carrito.activo{

    display:flex;

}


/*
   ESTA REGLA TAMBIÉN PERMITE QUE TU JAVASCRIPT
   ACTUAL PUEDA USAR style.display = "block".
*/

.modal-carrito[style*="display: block"]{

    display:flex !important;

}


/* ==================================================
   CAJA DEL CARRITO
================================================== */

.carrito-ventana{

    width:90%;

    max-width:1000px;

    height:auto;

    max-height:85vh;

    overflow-y:auto;

    overflow-x:hidden;

    background:white;

    border-radius:25px;

    padding:30px;

    box-shadow:
        0 20px 60px rgba(0,0,0,.30);

    animation:
        aparecerCarrito .3s ease;

}


/* ==================================================
   ANIMACIÓN CARRITO
================================================== */

@keyframes aparecerCarrito{

    from{

        opacity:0;

        transform:
            translateY(30px)
            scale(.95);

    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);

    }

}


/* ==================================================
   CABECERA DEL CARRITO
================================================== */

.carrito-cabecera{

    display:flex;

    justify-content:space-between;

    align-items:center;

    border-bottom:
        1px solid #eee;

    padding-bottom:15px;

    margin-bottom:20px;

}


.carrito-cabecera h2{

    color:#713d4d;

    font-family:
        Georgia,
        serif;

    font-weight:400;

}


/* ==================================================
   BOTÓN CERRAR CARRITO
================================================== */

.cerrar-carrito{

    border:none;

    background:#f7e9ec;

    color:#713d4d;

    width:35px;

    height:35px;

    border-radius:50%;

    cursor:pointer;

    font-size:20px;

    transition:.3s;

}


.cerrar-carrito:hover{

    background:#713d4d;

    color:white;

    transform:
        rotate(90deg);

}


/* ==================================================
   CONTENIDO CARRITO
================================================== */

#contenidoCarrito{

    min-height:100px;

    width:100%;

}


/* ==================================================
   PRODUCTO DEL CARRITO
================================================== */

.producto-carrito{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:15px;

    padding:15px;

    margin-bottom:10px;

    background:#fdf5f7;

    border-radius:15px;

    border:
        1px solid #f0d6dc;

}


.producto-carrito-info{

    flex:1;

}


.producto-carrito-nombre{

    color:#713d4d;

    font-weight:bold;

    margin-bottom:5px;

}


.producto-carrito-datos{

    color:#777;

    font-size:14px;

}


.producto-carrito-total{

    color:#b45d72;

    font-weight:bold;

}


/* ==================================================
   MENSAJE CARRITO VACÍO
================================================== */

.carrito-vacio{

    text-align:center;

    padding:35px 20px;

    color:#777;

}


/* ==================================================
   BOTÓN ACTUALIZAR
================================================== */

.boton-actualizar-carrito{

    width:100%;

    margin-top:20px;

    padding:13px;

    border:none;

    border-radius:25px;

    background:#c96f84;

    color:white;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

}


.boton-actualizar-carrito:hover{

    background:#b45d72;

    transform:
        translateY(-2px);

}


/* ==================================================
   TABLET Y CELULAR
================================================== */

@media(max-width:768px){

    body{

        padding-top:65px;

    }


    header{

        padding:
            10px 20px;

        background:white;

        box-shadow:
            0 3px 15px rgba(0,0,0,.08);

    }


    .logo img{

        width:120px;

    }


    .hamburger{

        display:block;

    }


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


    .menu{

        flex-direction:column;

        width:100%;

        align-items:flex-start;

    }


    .menu li{

        width:100%;

    }


    .menu li a{

        width:100%;

        padding:
            18px 25px;

        font-size:18px;

    }


    .submenu{

        display:block;

        position:static;

        box-shadow:none;

        background:#f7f7f7;

        margin-left:15px;

        margin-right:15px;

        border-radius:10px;

    }


    .submenu li a{

        font-size:15px;

        padding:
            12px 18px;

    }


    .close-menu{

        display:block;

        position:absolute;

        top:15px;

        right:20px;

        font-size:28px;

        cursor:pointer;

    }


    .iconos-derecha{

        gap:12px;

    }


    /* BUSCADOR EN CELULAR */

    .buscador-contenedor{

        width:40px;

    }


    .buscador-contenedor:hover{

        width:200px;

    }


    .buscador-contenedor:hover input{

        width:150px;

    }


    .iconos-derecha > a img{

        width:22px;

        height:22px;

    }


    /* ==================================================
       CARRITO EN CELULAR
    ================================================== */

    .modal-carrito{

        padding:
            12px;

    }


    .carrito-ventana{

        width:96%;

        max-width:none;

        max-height:90vh;

        padding:20px;

        border-radius:20px;

    }

}


/* ==================================================
   CARRITO EN PANTALLAS MUY PEQUEÑAS
================================================== */

@media(max-width:480px){

    .producto-carrito{

        flex-direction:column;

        align-items:flex-start;

    }


    .carrito-ventana{

        width:100%;

        max-height:92vh;

        padding:18px;

        border-radius:18px;

    }


    .carrito-cabecera h2{

        font-size:20px;

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

        <a href="pagintrof.php">

            <img
                src="../imagenes/DIVINE-removebg-preview.png"
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


        <div
            class="close-menu"
            onclick="toggleMenu()"
        >

            ✕

        </div>


        <ul class="menu">


            <li>

                <a href="../totu.php">

                    Inicio

                </a>

            </li>



            <li>

                <a href="../produccomp.php">

                    Productos

                </a>


                <ul class="submenu">


                    <li>

                        <a href="skincare.php">

                            Skin Care

                        </a>

                    </li>


                    <li>

                        <a href="mascarillas.php">

                            Mascarillas

                        </a>

                    </li>


                </ul>

            </li>



            <li>

                <a href="../mision-vision.php">

                    Historia

                </a>

            </li>



            <li>

                <a href="#ofertas">

                    Ofertas

                </a>

            </li>



            <li>

                <a href="#contacto">

                    Contacto

                </a>

            </li>



            <li>

                <a href="#consulta">

                    Consulta Personal

                </a>

            </li>


        </ul>

    </nav>



    <!-- ==================================================
         ICONOS
    ================================================== -->

    <div class="iconos-derecha">


        <!-- ==================================================
             BUSCADOR
        ================================================== -->

        <div class="buscador">


            <div class="buscador-contenedor">


                <input
                    type="text"
                    id="textoBuscar"
                    placeholder="Buscar producto..."
                >


                <button
                    class="boton-buscar"
                    onclick="buscar()"
                    type="button"
                >

                    <img
                        src="../imagenes/lupa-removebg-preview.png"
                        alt="Buscar"
                    >

                </button>


            </div>


        </div>



        <!-- ==================================================
             CARRITO
        ================================================== -->

        <a
            href="#"
            onclick="abrirCarrito(event)"
            title="Ver carrito"
        >


            <div class="carrito-contenedor">


                <img
                    src="../imagenes/carrito.png"
                    alt="Carrito"
                >


                <!-- ESTRELLITA -->

                <span
                    id="estrellitaCarrito"
                    class="estrellita-carrito"
                >

                    ✦

                </span>


                <!-- CONTADOR -->

                <span
                    id="contadorCarrito"
                    class="contador-carrito"
                >

                    0

                </span>


            </div>


        </a>



        <!-- ==================================================
             PERFIL
        ================================================== -->

        <a href="../SESIONES/loginformcliente.php">

            <img
                src="../imagenes/persona.png"
                alt="Perfil"
            >

        </a>


    </div>


</header>



<!-- ==================================================
     OVERLAY MENÚ
================================================== -->

<div
    class="overlay"
    id="overlay"
    onclick="toggleMenu()"
>

</div>



<!-- ==================================================
     VENTANA EMERGENTE DEL CARRITO
================================================== -->

<div
    class="modal-carrito"
    id="ventanaCarrito"
>


    <div class="carrito-ventana">


        <!-- ==================================================
             CABECERA
        ================================================== -->

        <div class="carrito-cabecera">


            <h2>

                Mi carrito

            </h2>


            <button
                type="button"
                class="cerrar-carrito"
                onclick="cerrarCarrito()"
            >

                ×

            </button>


        </div>



        <!-- ==================================================
             CONTENIDO
        ================================================== -->

        <div id="contenidoCarrito">


            <div class="carrito-vacio">

                Cargando carrito...

            </div>


        </div>



        <!-- ==================================================
             BOTÓN ACTUALIZAR
        ================================================== -->

        <button
            type="button"
            class="boton-actualizar-carrito"
            onclick="abrirCarrito()"
        >

            ↻ Actualizar carrito

        </button>


    </div>


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
   BUSCAR PRODUCTO
================================================== */

function buscar(){

    var nombre =

        document
        .getElementById("textoBuscar")
        .value;


    if(
        nombre.trim() === ""
    ){

        return;

    }


    fetch(
        "buscarproducto.php?nombre="
        +
        encodeURIComponent(nombre)
    )


    .then(

        res =>
            res.json()

    )


    .then(

        data => {

            console.log(data);

        }

    )


    .catch(

        error => {

            console.error(
                "Error en la búsqueda:",
                error
            );

        }

    );

}

</script>


</body>

</html>