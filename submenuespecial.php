<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    overflow:hidden;
    border-radius:25px;

    transition:
        width .5s ease,
        background .3s ease,
        box-shadow .3s ease;
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


    /* ==================================================
       ENLACES PRINCIPALES
    ================================================== */

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


    /* ==================================================
       SUBMENÚ EN CELULAR
    ================================================== */

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


    /* CUANDO ESTÁ ACTIVO */

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


    /* ==================================================
       BUSCADOR
    ================================================== */

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
        width:160px;
    }

    .buscador-contenedor:hover input{
        width:120px;
        font-size:13px;
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


    /* SUBMENÚ LATERAL */

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

        <a href="pagintrof.php">

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


                    <!-- BOTÓN PARA SUBMENÚ -->

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
                            Mascarillas
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


<<<<<<< HEAD
            <!-- OFERTAS -->
=======
>>>>>>> 293c97a9fb704da34b4eec7167bc24bfe59d405f

            <li>

                <a href="#ofertas">
                    Ofertas
                </a>

            </li>


<<<<<<< HEAD
            <!-- CONTACTO -->
=======
>>>>>>> 293c97a9fb704da34b4eec7167bc24bfe59d405f

            <li>

                <a href="#contacto">
                    Contacto
                </a>

            </li>


<<<<<<< HEAD
            <!-- MIS PEDIDOS -->

            <li>

                <a href="CONSULTA-pedido/formreadpedido.php">
                    Mis Pedidos
                </a>

            </li>

=======

            <li>
>>>>>>> 293c97a9fb704da34b4eec7167bc24bfe59d405f

                <a href="./CONSULTA-pedido/formreadpedido.php">

                    Consulta 

                </a>

            </li>


        </ul>


    </nav>


<<<<<<< HEAD
=======

>>>>>>> 293c97a9fb704da34b4eec7167bc24bfe59d405f
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
                >


                <button
                    class="boton-buscar"
                    onclick="buscar()"
                    type="button"
                >

                    <img
                        src="./imagenes/lupa-removebg-preview.png"
                        alt="Buscar"
                    >

                </button>





















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
        document.getElementById("productosMenu");

    const boton =
        productos.querySelector(".boton-submenu");


    productos.classList.toggle("submenu-abierto");

    boton.classList.toggle("activo");

}


/* ==================================================
   BUSCAR PRODUCTO
================================================== */

function buscar(){

    var nombre =
        document
        .getElementById("textoBuscar")
        .value;


    if(nombre.trim() === ""){
        return;
    }


    fetch(
        "buscar_producto.php?nombre="
        +
        encodeURIComponent(nombre)
    )

    .then(
        res => res.json()
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
