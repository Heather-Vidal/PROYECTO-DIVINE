<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* 1. EL RESETEO SIEMPRE VA ARRIBA */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #fff; /* O el color de fondo que desees */
        }

        header {
            background: transparent;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px; /* Un poco más de espacio a los lados */
            width: 100%;
        }

        a {
            font-family: "Lora", serif;
            text-decoration: none;
            color: #111;
        }

        div.logo {
            display: flex;
            align-items: center;
        }

        div.logo img {
            width: 160px;
            display: block;
        }

        /* Contenedor derecho para los iconos */
        .iconos-derecha {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        nav {
            display: flex;
            align-items: center;
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 15px; 
        }

        .menu li {
            position: relative;
        }

        .menu li a {
            display: block;
            padding: 10px 15px;
            font-size: 18px;
            transition: 0.3s all;
            border-radius: 10px;
        }

        .menu li a:hover {
            color: #000;
            transform: translateY(3px);
        }

        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            list-style: none;
            min-width: 180px;
            background-color: #ffffff; 
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1); 
            z-index: 1000;
        }

        .submenu li a {
            padding: 10px 15px;
        }

        .menu li:hover .submenu {
            display: block;
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
                    <a href="#">Productos</a>
                    <ul class="submenu">
                        <li><a href="skincare.php">Skin Care</a></li>
                        <li><a href="mascarillas.php">Mascarillas</a></li>
                    </ul>
                </li>
                <li><a href="nosotros.php">Nosotros</a></li>
                <li><a href="#ofertas">Ofertas</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li><a href="#consulta">Consulta Personal</a></li>
            
            </ul>
        </nav>

        <div class="iconos-derecha">
            <a href="#">
                <img src="./imagenes/lupa-removebg-preview.png" alt="Buscar" width="25">
            </a>
            <a href="#">
                <img src="./imagenes/carrito.png" alt="Carrito" width="25">
            </a>
            <a href="formcliente.php">
                <img src="./imagenes/persona.png" alt="Perfil" width="25">
            </a>
        </div>
    </header>

</body>
</html>