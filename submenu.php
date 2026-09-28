
<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

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

body{
    overflow-x:hidden;
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

    position:relative;
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
   ICONOS
================================================== */

.iconos-derecha{
    display:flex;
    gap:20px;
    align-items:center;
}

.iconos-derecha img{
    width:25px;
    height:25px;
    object-fit:contain;

    transition:transform .3s ease;
}

.iconos-derecha a:hover img{
    transform:scale(1.1);
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


    /* ==================================================
       MENÚ LATERAL
    ================================================== */

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

        overflow-y:auto;
    }

    nav.active{
        left:0;
    }


    /* ==================================================
       MENÚ
    ================================================== */

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

        padding:18px 25px;

        font-size:18px;
    }


    /* ==================================================
       PRODUCTOS
    ================================================== */

    .productos-contenedor{
        width:100%;

        display:flex;
        align-items:center;
    }

    .productos-contenedor > a{
        width:auto;
        flex:1;
    }


    /* ==================================================
       BOTÓN SUBMENÚ
    ================================================== */

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


    /* ==================================================
       SUBMENÚ CELULAR
    ================================================== */

    .submenu{
        display:none;

        position:absolute;

        top:0;
        left:100%;

        width:210px;
        min-width:210px;

        margin:0;

        padding:5px 0;

        background:white;

        border-radius:0 12px 12px 0;

        box-shadow:
            5px 5px 20px rgba(0,0,0,.15);

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


    /* ==================================================
       CERRAR
    ================================================== */

    .close-menu{
        display:block;

        position:absolute;

        top:15px;
        right:20px;

        font-size:28px;

        cursor:pointer;
    }


    /* ==================================================
       ICONOS
    ================================================== */

    .iconos-derecha{
        gap:12px;
    }

    .iconos-derecha img{
        width:22px;
        height:22px;
    }

}


/* ==================================================
   CELULAR PEQUEÑO
   480px O MENOS
================================================== */

@media(max-width:480px){

    /* HEADER */

    header{
        padding:8px 12px;

        min-height:60px;
    }


    /* ==================================================
       LOGO
    ================================================== */

    .logo img{
        width:90px;
    }


    /* ==================================================
       HAMBURGUESA
    ================================================== */

    .hamburger{
        display:block;

        font-size:28px;

        line-height:1;

        margin-left:auto;

        margin-right:8px;
    }


    /* ==================================================
       ICONOS
    ================================================== */

    .iconos-derecha{
        gap:7px;
    }

    .iconos-derecha img{
        width:20px;
        height:20px;
    }


    /* ==================================================
       MENÚ LATERAL
    ================================================== */

    nav{
        width:245px;

        left:-245px;

        padding-top:65px;

        overflow-y:auto;
    }

    nav.active{
        left:0;
    }


    /* ==================================================
       ENLACES DEL MENÚ
    ================================================== */

    .menu li a{
        padding:14px 18px;

        font-size:16px;
    }


    /* ==================================================
       SUBMENÚ
    ================================================== */

    .submenu{
        width:190px;

        min-width:190px;

        left:100%;

        margin:0;

        background:white;

        border-radius:0 10px 10px 0;
    }

    .submenu li a{
        font-size:14px;

        padding:13px 15px;
    }


    /* ==================================================
       BOTÓN SUBMENÚ
    ================================================== */

    .boton-submenu{
        width:50px;
        height:50px;

        font-size:20px;
    }


    /* ==================================================
       EFECTO AL TOCAR SUBMENÚ
    ================================================== */

    .submenu li a:active{
        background:#ddd;
    }


    /* ==================================================
       BOTÓN CERRAR
    ================================================== */

    .close-menu{
        top:12px;

        right:15px;

        font-size:25px;
    }


    /* ==================================================
       OVERLAY
    ================================================== */

    .overlay{
        background:rgba(0,0,0,.50);
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
                src="./imagenes/DIVINE-removebg-preview.png"
                alt="Logo"
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


        <!-- BOTÓN CERRAR -->

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


            <!-- PRODUCTOS -->

            <li id="productosMenu">


                <div class="productos-contenedor">


                    <a href="produccomp.php">
                        Productos
                    </a>


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


            <!-- SUGERENCIAS -->

          


            <!-- CONSULTA -->

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
   ABRIR / CERRAR MENÚ
================================================== */

function toggleMenu(){

    const menu =
        document.getElementById("menuLateral");

    const overlay =
        document.getElementById("overlay");

    const hamburger =
        document.querySelector(".hamburger");


    menu.classList.toggle("active");

    overlay.classList.toggle("active");


    /* Cambiar ☰ por ✕ */

    if(menu.classList.contains("active")){

        hamburger.innerHTML = "✕";

    }else{

        hamburger.innerHTML = "☰";

    }

}


/* ==================================================
   ABRIR / CERRAR SUBMENÚ
================================================== */

function toggleSubmenu(event){

    event.preventDefault();

    event.stopPropagation();


    const productos =
        document.getElementById("productosMenu");


    const boton =
        productos.querySelector(".boton-submenu");


    productos.classList.toggle("submenu-abierto");

    boton.classList.toggle("activo");

}


</script>


</body>

</html>