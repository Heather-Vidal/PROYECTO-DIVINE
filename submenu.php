
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cabecera Responsive</title>

<style>

/* RESET */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    overflow-x:hidden;
}

/* HEADER */

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

.logo{
    display:flex;
    align-items:center;
}

.logo img{
    width:160px;
    display:block;
}

/* MENÚ */

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

/* SUBMENÚ */

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

/* ICONOS */

.iconos-derecha{
    display:flex;
    gap:20px;
    align-items:center;
}

.iconos-derecha img{
    width:25px;
}

/* BOTÓN HAMBURGUESA */

.hamburger{
    display:none;
    font-size:34px;
    cursor:pointer;
    z-index:10001;
}

/* BOTÓN CERRAR */

.close-menu{
    display:none;
}

/* OVERLAY */

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

/* =====================
   TABLET Y CELULAR
===================== */

@media(max-width:768px){

    header{
        padding:10px 20px;
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
        padding:18px 25px;
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
        padding:12px 18px;
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

    .iconos-derecha img{
        width:22px;
    }
}

</style>
</head>
<body>

<header>

    <div class="logo">
        <a href="pagintrof.php">
            <img src="./imagenes/DIVINE-removebg-preview.png" alt="Logo">
        </a>
    </div>

    <div class="hamburger" onclick="toggleMenu()">
        ☰
    </div>

    <nav id="menuLateral">

        <div class="close-menu" onclick="toggleMenu()">
            ✕
        </div>

        <ul class="menu">

            <li>
                <a href="totu.php">Inicio</a>
            </li>

            <li>
                <a href="produccomp.php">Productos</a>

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
                <a href="mision-vision.php">
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

    <div class="iconos-derecha">

        <a href="#">
            <img
            src="./imagenes/lupa-removebg-preview.png"
            alt="Buscar">
        </a>

        <a href="./CRUD-CARRITO-PEDIDO/formpedido.php">
            <img
            src="./imagenes/carrito.png"
            alt="Carrito">
        </a>

        <a href="./SESIONES/loginformcliente.php">
            <img
            src="./imagenes/persona.png"
            alt="Perfil">
        </a>

    </div>

</header>

<div class="overlay" id="overlay"
onclick="toggleMenu()">
</div>

<script>

function toggleMenu(){

    document
    .getElementById("menuLateral")
    .classList.toggle("active");

    document
    .getElementById("overlay")
    .classList.toggle("active");
}

</script>

</body>
</html>
```
