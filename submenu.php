<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* 1. RESETEO GLOBAL (Limpio de posiciones que rompen el layout) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        header {
            background: transparent;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            width: 100%; 
        }

        a {
            font-family: "Lora", serif;
            font-optical-sizing: auto;
            text-decoration: none;
            color:inherit;
        }

        div.logo {
            display: flex;
            align-items: center;
        }

        div.logo img {
            width: 160px;
            display: block;
        }

        nav {
            display: flex;
        }

        .menu {
            list-style: none;
            display: flex;
            align-items: center;
        }

        .menu li {
            position: relative;
        }

        .menu li a {
            display: block;
            padding: 15px 20px;
            font-size: 20px;
            transition: 0.3s all;
            border-radius: 10px;
        }

        .menu li a:hover {
            color: #000;
            transform: translateY(3px);
        }

        /* Contenedor de iconos de la derecha */
        .iconos-derecha {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        /* 2. SUBMENÚ (Heredado y corregido con z-index correcto) */
        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,.2);
            z-index: 9999;
            padding: 10px 0;
            list-style: none;
        }

        .submenu li {
            width: 100%;
        }

        .submenu li a {
            display: block;
           color:inherit;
            padding: 12px 20px;
            font-size: 18px; /* Un toque más pequeño para jerarquía visual */
        }

        .submenu li a:hover {
            transform: none; /* Evita que el texto del submenú se mueva de lado */
        }

        .menu li:hover > .submenu {
            display: block;
        }
        .menu a,
.logo a,
.iconos-derecha a {
    color: inherit;
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

        <nav>
            <ul class="menu">
                <li><a href="totu.php">Inicio</a></li>
                <li>
                    <a href="produccomp.html">Productos</a>
                    <ul class="submenu">
                        <li><a href="#skin">Skin Care</a></li>
                        <li><a href="#">Mascarillas</a></li>
                    </ul>
                </li>
                <li><a href="submenuppopu.php">Historia</a></li>
                <li><a href="#ofertas">Ofertas</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li><a href="#consulta">Consulta Personal</a></li>
            </ul>
        </nav>

        <div class="iconos-derecha">
            <a href="#">
                <img src="./imagenes/lupa-removebg-preview.png" alt="Buscar" width="25">
            </a>
            <a href="./CRUD-CARRITO-PEDIDO/formpedido.php">
                <img src="./imagenes/carrito.png" alt="Carrito" width="25">
            </a>
            <a href="formcliente.php">
                <img src="./imagenes/persona.png" alt="Perfil" width="25">
            </a>
        </div> 
    </header>

</body>
</html>