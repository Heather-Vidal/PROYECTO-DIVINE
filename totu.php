
<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Divine Beauty</title>

<style>

/* =========================================================
   FUENTES
========================================================= */

@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Montserrat:wght@300;400;500;600&display=swap');


/* =========================================================
   GENERAL
========================================================= */

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html{
    scroll-behavior: smooth;
}

body{
    background: #f5f0eb;
    color: #302527;
    font-family: 'Montserrat', sans-serif;
    overflow-x: hidden;
}


/* =========================================================
   PANTALLA NEGRA
========================================================= */

.pantalla-negra{
    position: fixed;
    inset: 0;
    background: #302124;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.pantalla-negra h1{
    color: #f7e8df;
    font-family: 'DM Serif Display', serif;
    font-size: clamp(55px, 10vw, 130px);
    font-weight: 400;
    letter-spacing: 18px;
}

.pantalla-negra-activa{
    animation: salirIntro 1.3s cubic-bezier(.77,0,.18,1) forwards;
}

@keyframes salirIntro{

    from{
        transform: translateY(0);
    }

    to{
        transform: translateY(-100%);
    }

}


/* =========================================================
   HEADER
========================================================= */

header{
    width: 92%;
    height: 82px;

    position: absolute;
    top: 25px;
    left: 4%;

    z-index: 1000;

    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;

    padding: 0 28px;

    background: rgba(255,255,255,.75);
    backdrop-filter: blur(15px);

    border: 1px solid rgba(105,70,70,.12);
    border-radius: 50px;

    box-shadow: 0 15px 45px rgba(55,35,35,.08);
}


/* =========================================================
   LOGO
========================================================= */

.logo{
    display: flex;
    align-items: center;
}

.logo img{
    width: 130px;
    transition: .4s;
}

.logo img:hover{
    transform: rotate(-3deg) scale(1.05);
}


/* =========================================================
   MENÚ DESKTOP
========================================================= */

nav{
    display: flex;
    justify-content: center;
}

.menu{
    display: flex;
    list-style: none;
    gap: 5px;
}

.menu li{
    position: relative;
}

.menu li a{
    text-decoration: none;
    color: #392b2e;

    font-size: 12px;
    font-weight: 500;

    text-transform: uppercase;
    letter-spacing: 1px;

    padding: 12px 14px;
    display: block;

    transition: .3s;
}

.menu li a:hover{
    color: #9a5c67;
}


/* =========================================================
   SUBMENÚ DESKTOP
========================================================= */

.submenu{
    display: none;

    position: absolute;
    top: 45px;
    left: 0;

    width: 190px;

    padding: 10px;

    list-style: none;

    background: #fffaf7;

    border-radius: 15px;

    box-shadow: 0 20px 40px rgba(50,30,30,.15);
}

.submenu li a{
    text-transform: none;
    letter-spacing: 0;
    font-size: 13px;

    border-radius: 8px;
}

.submenu li a:hover{
    background: #f1ded9;
}

.menu li:hover .submenu{
    display: block;
}


/* =========================================================
   ICONOS DERECHA
========================================================= */

.iconos-derecha{
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

.iconos-derecha a{
    width: 38px;
    height: 38px;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 50%;

    background: #eee3de;

    transition: .3s;
}

.iconos-derecha a:hover{
    background: #c4878e;
    transform: translateY(-3px);
}

.iconos-derecha img{
    width: 19px;
}


/* =========================================================
   BOTÓN HAMBURGUESA
========================================================= */

.boton-hamburguesa{
    display: none;

    width: 46px;
    height: 46px;

    border: none;
    border-radius: 50%;

    background: #38272a;

    cursor: pointer;

    align-items: center;
    justify-content: center;

    flex-direction: column;
    gap: 5px;

    box-shadow: 0 8px 20px rgba(50,30,30,.18);

    transition: .3s;

    position: relative;
    z-index: 1100;
}

.boton-hamburguesa:hover{
    background: #9b5c67;
    transform: scale(1.05);
}

.boton-hamburguesa span{
    width: 19px;
    height: 2px;

    background: #fffaf7;

    border-radius: 10px;

    transition: .3s;
}


/* ANIMACIÓN DE HAMBURGUESA A X */

.boton-hamburguesa.activo span:nth-child(1){
    transform: translateY(7px) rotate(45deg);
}

.boton-hamburguesa.activo span:nth-child(2){
    opacity: 0;
}

.boton-hamburguesa.activo span:nth-child(3){
    transform: translateY(-7px) rotate(-45deg);
}


/* =========================================================
   MENÚ MÓVIL
========================================================= */

.menu-movil{
    display: none;
}


/* =========================================================
   SECCIÓN PRINCIPAL
========================================================= */

body > section:not(.pantalla-negra):not(.derecha){
    min-height: 100vh;

    display: flex;
    flex-direction: column;
    justify-content: center;

    /*
       SUBIMOS UN POQUITO EL CONTENIDO
    */
    padding: 125px 7% 70px;

    background:
        radial-gradient(
            circle at 80% 30%,
            #e7c7c3 0,
            #e7c7c3 7%,
            transparent 7.5%
        ),
        #f5f0eb;

    position: relative;
}


/* =========================================================
   NÚMERO
========================================================= */

body > section:not(.pantalla-negra):not(.derecha)::after{
    content: "01";

    position: absolute;
    left: 7%;
    bottom: 35px;

    font-family: 'DM Serif Display', serif;
    font-size: 18px;

    color: #aa7777;
}


/* =========================================================
   TÍTULO
========================================================= */

h1{
    max-width: 720px;

    font-family: 'DM Serif Display', serif;

    font-size: clamp(55px, 7vw, 100px);

    font-weight: 400;
    line-height: .92;

    letter-spacing: -4px;

    color: #302527;
}

.color{
    color: #a35d68;

    font-style: italic;

    font-family: 'DM Serif Display', serif;
}


/* =========================================================
   TEXTO
========================================================= */

.sub{
    max-width: 430px;

    margin-top: 28px;
    margin-bottom: 28px;

    font-size: 14px;
    line-height: 1.9;

    color: #756467;
}


/* =========================================================
   CAJA ESENCIAS
========================================================= */

.box{
    align-items: center;

    width: 430px;
    height: 220px;

    position: relative;

    display: flex;
    flex-direction: column;
    justify-content: center;

    padding: 20px;

    background: #dac0b9;

    border-radius: 15px;

    box-shadow: 15px 20px 0 #eee1db;
}

.box h2{
    font-family: 'DM Serif Display', serif;

    font-size: 25px;

    font-weight: 400;

    color: #38272a;

    letter-spacing: 2px;
}

.box p{
    margin: 8px 0 20px;

    font-size: 12px;
    line-height: 1.5;

    color: #624d50;

    text-align: center;
}

.box a{
    width: fit-content;

    text-decoration: none;

    background: #38272a;
    color: white;

    padding: 10px 18px;

    font-size: 11px;
    letter-spacing: 1px;

    text-transform: uppercase;

    border-radius: 30px;

    transition: .3s;
}

.box a:hover{
    background: #9b5c67;
    transform: translateX(5px);
}

.box img{
    position: absolute;

    width: 125px;

    left: 10px;
    bottom: 5px;

    filter: drop-shadow(5px 10px 10px rgba(50,30,30,.2));
}


/* =========================================================
   IMAGEN DERECHA
========================================================= */

.derecha{
    min-height: 100vh;

    position: absolute;

    right: 0;
    top: 0;

    width: 46%;

    padding: 135px 4% 50px 20px;

    display: flex;

    justify-content: center;
    align-items: center;
}

.derecha img{
    width: 100%;
    height: 78vh;

    object-fit: cover;

    border-radius: 250px 250px 20px 20px;

    box-shadow:
        -20px 25px 0 #ddc1bc,
        -40px 50px 70px rgba(50,30,30,.18);

    transition: .7s;
}

.derecha img:hover{
    transform: translateY(-10px);
}


/* =========================================================
   PRINCIPAL
========================================================= */

main.principal{
    padding: 130px 7%;

    background: #fffaf7;

    position: relative;
}

main.principal::before{
    content: "DIVINE COLLECTION";

    display: block;

    text-align: center;

    font-size: 11px;

    letter-spacing: 5px;

    color: #a56b72;

    margin-bottom: 60px;
}


/* =========================================================
   CARACTERÍSTICAS
========================================================= */

.caracteristicas{
    width: 100%;

    display: grid;

    grid-template-columns:
        1.3fr
        .8fr
        .8fr
        1.3fr;

    gap: 20px;

    background: transparent;

    padding: 0;

    box-shadow: none;
}

.caja-caracteristica{
    height: 480px;

    overflow: hidden;

    position: relative;

    background: #ddd;

    border-radius: 100px 100px 15px 15px;
}

.caja-caracteristica:nth-child(2){
    margin-top: 70px;
}

.caja-caracteristica:nth-child(3){
    margin-top: 30px;
}

.caja-caracteristica:nth-child(4){
    margin-top: 100px;
}

.caja-caracteristica img{
    width: 100%;
    height: 100%;

    object-fit: cover;

    transition: .7s;
}

.caja-caracteristica:hover img{
    transform: scale(1.08);
}


/* =========================================================
   TARJETAS
========================================================= */

.tarjetas{
    width: 90%;

    margin: 130px auto 0;

    display: grid;

    grid-template-columns: repeat(3,1fr);

    gap: 35px;
}

.tarjeta{
    height: 430px;

    position: relative;

    overflow: hidden;

    background: #eee;

    border-radius: 20px;

    box-shadow: 0 20px 45px rgba(55,35,35,.12);

    transition: .5s;
}

.tarjeta:nth-child(2){
    transform: translateY(70px);
}

.tarjeta:hover{
    transform: translateY(-12px);
}

.tarjeta:nth-child(2):hover{
    transform: translateY(55px);
}

.tarjeta img{
    width: 100%;
    height: 100%;

    object-fit: cover;

    transition: .7s;
}

.tarjeta:hover img{
    transform: scale(1.06);
}


/* =========================================================
   FOOTER
========================================================= */

footer{
    background: #302124;
    color: #f5e8e2;
}


/* =========================================================
   TABLET
========================================================= */

@media(max-width:1100px){

    header{
        height: 75px;

        grid-template-columns: 1fr auto;

        padding: 0 20px;
    }

    nav{
        display: none;
    }

    .logo{
        justify-content: flex-start;
    }


    /*

       AHORA LOS ICONOS SÍ SE MUESTRAN
       JUNTO A LA HAMBURGUESA

    */

    .iconos-derecha{
        display: flex;

        position: absolute;

        right: 78px;
        top: 50%;

        transform: translateY(-50%);

        gap: 7px;
    }

    .iconos-derecha a{
        width: 35px;
        height: 35px;
    }

    .iconos-derecha img{
        width: 17px;
    }


    .boton-hamburguesa{
        display: flex;
    }


    /* MENÚ MÓVIL */

    .menu-movil{
        display: none;

        position: absolute;

        top: 88px;
        left: 0;

        width: 100%;

        padding: 15px;

        background: rgba(255,250,247,.98);

        backdrop-filter: blur(20px);

        border-radius: 25px;

        box-shadow: 0 20px 45px rgba(50,30,30,.16);

        border: 1px solid rgba(105,70,70,.10);

        z-index: 1000;
    }

    .menu-movil.abierto{
        display: block;

        animation: aparecerMenu .3s ease;
    }

    @keyframes aparecerMenu{

        from{
            opacity: 0;
            transform: translateY(-10px);
        }

        to{
            opacity: 1;
            transform: translateY(0);
        }

    }


    .menu-movil ul{
        list-style: none;
    }

    .menu-movil li{
        position: relative;
    }


    .menu-movil > ul > li > a{

        display: flex;

        justify-content: space-between;
        align-items: center;

        padding: 14px 15px;

        color: #392b2e;

        text-decoration: none;

        font-size: 12px;

        text-transform: uppercase;

        letter-spacing: 1px;

        border-radius: 12px;

        transition: .3s;
    }

    .menu-movil > ul > li > a:hover{
        background: #f1ded9;
        color: #9a5c67;
    }


    /* FLECHA PRODUCTOS */

    .productos-movil > a::after{

        content: "⌄";

        font-size: 17px;

        transition: .3s;
    }

    .productos-movil.abierto > a::after{
        transform: rotate(180deg);
    }


    /* SUBMENÚ MÓVIL */

    .submenu-movil{

        display: none;

        margin: 0 8px 8px;

        padding: 5px;

        background: #f7ebe7;

        border-radius: 15px;
    }

    .productos-movil.abierto .submenu-movil{

        display: block;

        animation: aparecerSub .25s ease;
    }

    @keyframes aparecerSub{

        from{
            opacity: 0;
            transform: translateY(-5px);
        }

        to{
            opacity: 1;
            transform: translateY(0);
        }

    }


    .submenu-movil a{

        display: block;

        padding: 11px 15px;

        color: #624d50;

        text-decoration: none;

        font-size: 12px;

        border-radius: 10px;

        transition: .3s;
    }

    .submenu-movil a:hover{

        background: #ead4ce;

        color: #9b5c67;
    }


    /* ICONOS DENTRO DEL MENÚ */

    .menu-iconos-movil{

        display: none;

    }


    body > section:not(.pantalla-negra):not(.derecha){

        padding-left: 5%;
        padding-top: 110px;
    }

    h1{
        font-size: 65px;
    }

    .derecha{
        width: 43%;
    }

    .caracteristicas{
        grid-template-columns: repeat(2,1fr);
    }

    .caja-caracteristica,
    .caja-caracteristica:nth-child(2),
    .caja-caracteristica:nth-child(3),
    .caja-caracteristica:nth-child(4){

        margin-top: 0;
    }

    .tarjetas{
        grid-template-columns: repeat(2,1fr);
    }

}


/* =========================================================
   CELULAR
========================================================= */

@media(max-width:750px){

    header{

        position: relative;

        top: auto;
        left: auto;

        width: 94%;

        margin: 15px auto;

        height: 68px;

        padding: 8px 10px 8px 18px;

        grid-template-columns: 1fr auto;

        border-radius: 35px;
    }


    .logo img{
        width: 110px;
    }


    /*
       ICONOS A LA DERECHA
       HAMBURGUESA AL FINAL
    */

    .iconos-derecha{

        position: absolute;

        right: 65px;

        top: 50%;

        transform: translateY(-50%);

        display: flex;

        gap: 5px;
    }

    .iconos-derecha a{

        width: 34px;
        height: 34px;

        background: #eee3de;
    }

    .iconos-derecha img{
        width: 16px;
    }


    .boton-hamburguesa{

        width: 42px;
        height: 42px;

        margin-left: auto;
    }


    .menu-movil{

        top: 78px;

        width: 100%;
    }


    /* CONTENIDO UN POQUITO MÁS ARRIBA */

    body > section:not(.pantalla-negra):not(.derecha){

        min-height: auto;

        padding: 70px 25px 70px;

        align-items: center;

        text-align: center;
    }


    h1{

        font-size: 52px;

        letter-spacing: -2px;
    }


    .sub{
        max-width: 500px;
    }


    .box{

        width: 100%;

        max-width: 430px;

        text-align: left;
    }


    .derecha{

        position: relative;

        width: 100%;

        min-height: auto;

        padding: 30px 25px 80px;
    }


    .derecha img{

        height: 550px;

        border-radius: 180px 180px 20px 20px;
    }


    main.principal{

        padding: 90px 20px;
    }


    .caracteristicas{

        grid-template-columns: 1fr 1fr;
    }


    .caja-caracteristica{

        height: 350px;

        border-radius: 60px 60px 12px 12px;
    }


    .tarjetas{

        width: 100%;

        grid-template-columns: 1fr;

        margin-top: 90px;
    }


    .tarjeta,
    .tarjeta:nth-child(2){

        height: 400px;

        transform: none;
    }


    .tarjeta:hover,
    .tarjeta:nth-child(2):hover{

        transform: translateY(-10px);
    }

}


/* =========================================================
   CELULARES PEQUEÑOS
========================================================= */

@media(max-width:360px){

    .pantalla-negra h1{

        font-size: 45px;

        letter-spacing: 8px;
    }


    .logo img{
        width: 100px;
    }


    .iconos-derecha{
        right: 60px;
        gap: 3px;
    }


    .iconos-derecha a{

        width: 31px;
        height: 31px;
    }


    .iconos-derecha img{
        width: 15px;
    }


    .boton-hamburguesa{

        width: 39px;
        height: 39px;
    }


    h1{
        font-size: 43px;
    }


    .box{

        min-height: 190px;

        padding-left: 125px;

        border-radius: 0 50px 0 50px;
    }


    .box img{
        width: 105px;
    }


    .derecha img{
        height: 420px;
    }


    .caracteristicas{
        grid-template-columns: 1fr;
    }


    .caja-caracteristica{
        height: 400px;
    }

}


/* =========================================================
   BLOQUEO CUANDO MENÚ ABIERTO
========================================================= */

body.menu-abierto{
    overflow: hidden;
}

</style>

</head>


<body>


<!-- =====================================================
     PANTALLA DE INTRODUCCIÓN
===================================================== -->

<section class="pantalla-negra" id="pantallaNegra">

    <h1>DIVINE</h1>

</section>


<!-- =====================================================
     HEADER
===================================================== -->

<header>


    <!-- LOGO -->

    <div class="logo">

        <a href="pagintrof.php">

            <img
                src="./imagenes/DIVINE-removebg-preview.png"
                alt="Logo"
                width="145"
            >

        </a>

    </div>


    <!-- =================================================
         MENÚ NORMAL
    ================================================== -->

    <nav>

        <ul class="menu">


            <li>

                <a href="totu.php">
                    Inicio
                </a>

            </li>


            <li>

                <a href="produccomp.php">
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
                            Skin Hair
                        </a>

                    </li>

                </ul>

            </li>


            <li>

                <a href="mision-vision.php">
                    Historia
                </a>

            </li>


            <li>

                <a href="contactanos.php">
                    Contacto
                </a>

            </li>


            <li>

                <a href="./sugerencias/comentarios.php">
                    Sugerencias
                </a>

            </li>


            <li>

                <a href="formulario.pdf">
                    Gestión Ambiental
                </a>

            </li>


        </ul>

    </nav>


    <!-- =================================================
         CARRITO + PERFIL
         AHORA SE MUESTRAN TAMBIÉN EN CELULAR
    ================================================== -->

    <div class="iconos-derecha">


        <a href="./CRUD-CARRITO-PEDIDO/formpedido.php">

            <img
                src="./imagenes/carrito.png"
                alt="Carrito"
            >

        </a>


        <a href="./SESIONES/loginformcliente.php">

            <img
                src="./imagenes/persona.png"
                alt="Perfil"
            >

        </a>


    </div>


    <!-- =================================================
         HAMBURGUESA
    ================================================== -->

    <button
        class="boton-hamburguesa"
        id="botonHamburguesa"
        aria-label="Abrir menú"
        aria-expanded="false"
    >

        <span></span>
        <span></span>
        <span></span>

    </button>


    <!-- =================================================
         MENÚ MÓVIL
    ================================================== -->

    <div class="menu-movil" id="menuMovil">


        <ul>


            <li>

                <a href="totu.php">
                    Inicio
                </a>

            </li>


            <li
                class="productos-movil"
                id="productosMovil"
            >

                <a
                    href="javascript:void(0);"
                    id="botonProductos"
                >
                    Productos
                </a>


                <ul class="submenu-movil">


                    <li>

                        <a href="skincare.php">
                            ✦ Skin Care
                        </a>

                    </li>


                    <li>

                        <a href="mascarillas.php">
                            ✦ Skin Hair
                        </a>

                    </li>


                </ul>

            </li>


            <li>

                <a href="mision-vision.php">
                    Historia
                </a>

            </li>


            <li>

                <a href="contactanos.php">
                    Contacto
                </a>

            </li>


            <li>

                <a href="./sugerencias/comentarios.php">
                    Sugerencias
                </a>

            </li>


            <li>

                <a href="formulario.pdf">
                    Gestión Ambiental
                </a>

            </li>


        </ul>


    </div>

</header>


<!-- =====================================================
     SECCIÓN PRINCIPAL
===================================================== -->

<section>


    <h1>

        Glow Starts

        <br>

        With

        <span class="color">
            Natural Beauty
        </span>

    </h1>


    <p class="sub">

        Productos inspirados en la elegancia de la naturaleza
        para cuidar tu piel y cabello.

    </p>


    <section class="box">


        <h2>
            ESENCIAS
        </h2>


        <p>
            Producto a base de esencias naturales.
        </p>


        <img
            src="./imagenes/crema.png"
            alt="crema"
            width="80px"
        >


        <a href="produccomp.php">
            ¡CONSULTA TU PEDIDO AQUÍ!
        </a>


    </section>


</section>


<!-- =====================================================
     IMAGEN DERECHA
===================================================== -->

<section class="derecha">


    <img
        src="./imagenes/rosafc.jpg"
        alt="Beauty Products"
    >


</section>


<!-- =====================================================
     CONTENIDO
===================================================== -->

<main class="principal">


    <section class="caracteristicas">


        <div class="caja-caracteristica">

            <img
                src="./imagenes/productosblancos.jpg"
                alt=""
            >

        </div>


        <div class="caja-caracteristica">

            <img
                src="./imagenes/producs.jpg"
                alt=""
            >

        </div>


        <div class="caja-caracteristica">

            <img
                src="./imagenes/productos01.jpg"
                alt=""
            >

        </div>


        <div class="caja-caracteristica">

            <img
                src="./imagenes/coco.jpg"
                alt=""
            >

        </div>


    </section>


    <section class="tarjetas">


        <div class="tarjeta">

            <img
                src="./imagenes/cabellolacio.jpg"
                alt=""
            >

        </div>


        <div class="tarjeta">

            <img
                src="./imagenes/rosa.jpg"
                alt=""
            >

        </div>


        <div class="tarjeta">

            <img
                src="./imagenes/castaño.jpg"
                alt=""
            >

        </div>


    </section>


</main>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>


/* =====================================================
   INTRO
===================================================== */

window.onload = function(){

    setTimeout(function(){

        document
            .getElementById("pantallaNegra")
            .classList.add("pantalla-negra-activa");

    },800);

};


/* =====================================================
   ELEMENTOS DEL MENÚ
===================================================== */

const botonHamburguesa =
    document.getElementById("botonHamburguesa");

const menuMovil =
    document.getElementById("menuMovil");

const productosMovil =
    document.getElementById("productosMovil");

const botonProductos =
    document.getElementById("botonProductos");


/* =====================================================
   ABRIR / CERRAR HAMBURGUESA
===================================================== */

botonHamburguesa.addEventListener(
    "click",
    function(){

        const abierto =
            menuMovil.classList.toggle("abierto");


        botonHamburguesa.classList.toggle(
            "activo",
            abierto
        );


        botonHamburguesa.setAttribute(
            "aria-expanded",
            abierto
        );


        document.body.classList.toggle(
            "menu-abierto",
            abierto
        );

    }
);


/* =====================================================
   SUBMENÚ PRODUCTOS
===================================================== */

botonProductos.addEventListener(
    "click",
    function(){

        productosMovil.classList.toggle(
            "abierto"
        );

    }
);


/* =====================================================
   CERRAR AL SELECCIONAR UN ENLACE
===================================================== */

const enlacesMovil =
    menuMovil.querySelectorAll(
        'a:not(#botonProductos)'
    );


enlacesMovil.forEach(
    function(enlace){

        enlace.addEventListener(
            "click",
            function(){

                menuMovil.classList.remove(
                    "abierto"
                );


                botonHamburguesa.classList.remove(
                    "activo"
                );


                botonHamburguesa.setAttribute(
                    "aria-expanded",
                    "false"
                );


                document.body.classList.remove(
                    "menu-abierto"
                );

            }
        );

    }
);


/* =====================================================
   CERRAR AL HACER CLICK FUERA
===================================================== */

document.addEventListener(
    "click",
    function(event){

        const dentroHeader =
            event.target.closest("header");


        if(!dentroHeader){

            menuMovil.classList.remove(
                "abierto"
            );


            botonHamburguesa.classList.remove(
                "activo"
            );


            botonHamburguesa.setAttribute(
                "aria-expanded",
                "false"
            );


            document.body.classList.remove(
                "menu-abierto"
            );

        }

    }
);

</script>


<?php include 'submenpiepag.php'; ?>


</body>

</html>
 