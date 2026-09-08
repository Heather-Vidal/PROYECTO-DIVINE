<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIVINE Beauty</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-principal: #EBE8D9;
            --bg-oscuro: #364e63;
            --bg-card: #ddc9b7;
            --bg-accent: #d6c8b3;
            --texto-dorado: #c5a46d;
            --texto-oscuro: #111111;
            --fuente-titulo: 'Lora', serif;
            --fuente-cuerpo: 'Montserrat', sans-serif;
            --sombra-suave: 0 10px 30px rgba(0,0,0,0.08);
            --transicion: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-principal);
            color: var(--texto-oscuro);
            font-family: var(--fuente-cuerpo);
            display: grid;
            grid-template-columns: 100%;
            grid-template-rows: auto auto auto auto auto;
            grid-template-areas:
                "cabeza"
                "nav"
                "hero"
                "main"
                "footer";
        }

        /* ===== PANTALLA INTRO ===== */
        .pantalla-negra {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            pointer-events: none;
        }

        .pantalla-negra h1 {
            color: #ffffff;
            font-size: 5rem;
            font-family: var(--fuente-titulo);
            letter-spacing: 12px;
            text-transform: uppercase;
        }

        .pantalla-negra-activa {
            animation: bajarPantalla 1.2s cubic-bezier(0.77, 0, 0.175, 1) forwards;
        }

        @keyframes bajarPantalla {
            from { transform: translateY(0); }
            to { transform: translateY(100%); }
        }

        /* ===== HEADER BANNER ===== */
        header.encabezado {
            grid-area: cabeza;
            background: var(--bg-oscuro);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        header.encabezado .logo a {
            font-size: 32px;
            font-weight: 700;
            color: var(--texto-dorado);
            font-family: var(--fuente-titulo);
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .iconos-derecha {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .iconos-derecha img {
            width: 24px;
            height: 24px;
            object-fit: contain;
            transition: var(--transicion);
        }

        .iconos-derecha img:hover {
            transform: scale(1.15);
        }

        /* ===== NAVEGACIÓN ===== */
        nav.navegacion {
            grid-area: nav;
            background: #f5e9d8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .menu li {
            position: relative;
        }

        .menu li a {
            color: #2b2b2b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transicion);
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .menu li a:hover {
            color: var(--texto-dorado);
            background: rgba(0, 0, 0, 0.03);
        }

        .flecha {
            font-size: 10px;
            transition: transform 0.3s ease;
        }

        .menu li:hover .flecha {
            transform: rotate(180deg);
        }

        /* SUBMENÚ DESPLEGABLE */
        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            list-style: none;
            min-width: 190px;
            background-color: #ffffff;
            box-shadow: var(--sombra-suave);
            border-radius: 10px;
            padding: 8px 0;
            z-index: 1000;
            border: 1px solid var(--texto-dorado);
        }

        .submenu li a {
            padding: 10px 18px;
            font-size: 0.88rem;
            border-radius: 0;
        }

        .submenu li a:hover {
            background-color: #f5e9d8;
            color: var(--texto-dorado);
        }

        .menu li:hover .submenu {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== HERO SECTION ===== */
        .seccion-hero {
            grid-area: hero;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 50px 60px;
            align-items: center;
        }

        .hero-izq h1 {
            font-size: 3.8rem;
            line-height: 1.1;
            font-weight: 700;
            font-family: var(--fuente-titulo);
            margin-bottom: 15px;
        }

        .hero-izq .color {
            font-style: italic;
            font-weight: 400;
            color: #7a6b58;
        }

        .sub {
            font-size: 1.05rem;
            margin-bottom: 30px;
            max-width: 480px;
            line-height: 1.6;
            color: #444;
        }

        .box {
            position: relative;
            background: var(--bg-accent);
            padding: 25px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            text-align: right;
            box-shadow: var(--sombra-suave);
        }

        .box h2 {
            font-family: var(--fuente-titulo);
            font-size: 1.4rem;
            margin-bottom: 6px;
        }

        .box p {
            font-size: 0.88rem;
            margin-bottom: 18px;
            color: #333;
        }

        .box a {
            background: var(--texto-oscuro);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: var(--transicion);
        }

        .box a:hover {
            background: var(--bg-oscuro);
            transform: translateY(-2px);
        }

        .box img {
            position: absolute;
            width: 150px;
            bottom: -15px;
            left: -15px;
            filter: drop-shadow(0 8px 12px rgba(0,0,0,0.15));
            transition: var(--transicion);
        }

        .box:hover img {
            transform: scale(1.05) rotate(-3deg);
        }

        .hero-der img {
            width: 100%;
            max-width: 700px;
            height: auto;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: var(--sombra-suave);
        }

        /* ===== MAIN CONTENT ===== */
        main.principal {
            grid-area: main;
            background: #e4e0cf;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            border-radius: 40px 40px 0 0;
        }

        .caracteristicas {
            border-radius: 25px;
            width: 90%;
            max-width: 1200px;
            background: var(--bg-oscuro);
            padding: 35px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            box-shadow: var(--sombra-suave);
        }

        .caja-caracteristica {
            overflow: hidden;
            height: 280px;
            border-radius: 16px;
        }

        .caja-caracteristica img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transicion);
        }

        .caja-caracteristica:hover img {
            transform: scale(1.08);
        }

        .tarjetas {
            margin-top: 50px;
            width: 90%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .tarjeta {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
            height: 340px;
        }

        .tarjeta:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }

        .tarjeta img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ===== FOOTER ===== */
        footer.pie {
            grid-area: footer;
            background-color: var(--bg-oscuro);
            color: var(--texto-dorado);
            padding: 40px 20px 20px;
            font-family: var(--fuente-titulo);
        }

        .footer-contenedor {
            display: flex;
            justify-content: center;
            gap: 120px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .columna h3 {
            font-size: 1.2rem;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .columna p {
            margin: 6px 0;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transicion);
        }

        .columna p:hover {
            color: #ffffff;
        }

        .copy {
            text-align: center;
            font-size: 0.85rem;
            margin-top: 20px;
            border-top: 1px solid rgba(197, 164, 109, 0.2);
            padding-top: 20px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .seccion-hero {
                grid-template-columns: 1fr;
            }
            .caracteristicas {
                grid-template-columns: repeat(2, 1fr);
            }
            .tarjetas {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .menu {
                flex-wrap: wrap;
                gap: 15px;
                justify-content: center;
            }
            .caracteristicas {
                grid-template-columns: 1fr;
            }
            .hero-izq h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <section class="pantalla-negra" id="pantallaNegra">
        <h1>DIVINE</h1>
    </section>

    <header class="encabezado">
        <div class="logo">
            <a href="pagintrof.php">DIVINE</a>
        </div>

        <div class="iconos-derecha">
            <a href="#">
                <img src="./imagenes/lupa-removebg-preview.png" alt="Buscar">
            </a>
            <a href="./CRUD-CARRITO-PEDIDO/formpedido.php">
                <img src="./imagenes/carrito.png" alt="Carrito">
            </a>
            <a href="./SESIONES/loginformcliente.php">
                <img src="https://cdn-icons-png.flaticon.com/512/166/166277.png" alt="Perfil">
            </a>
        </div>
    </header>

    <nav class="navegacion">
        <ul class="menu">
            <li><a href="totu.php">Inicio</a></li>
            <li>
                <a href="produccomp.php">Productos <span class="flecha">&#9660;</span></a>
                <ul class="submenu">
                    <li><a href="skincare.php">Skin Care</a></li>
                    <li><a href="mascarillas.php">Mascarillas Capilares</a></li>
                </ul>
            </li>
            <li><a href="mision-vision.php">Historia</a></li>
            <li><a href="mision-vision.php">Nosotros</a></li>
            <li><a href="#ofertas">Ofertas</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li><a href="#consulta">Consulta Personal</a></li>
        </ul>
    </nav>

    <section class="seccion-hero">
        <div class="hero-izq">
            <h1>
                Glow Starts <br>
                With <span class="color">Natural Beauty</span>
            </h1>

            <p class="sub">
                Productos inspirados en la elegancia de la naturaleza para cuidar tu piel y cabello.
            </p>

            <article class="box">
                <h2>ESENCIAS</h2>
                <p>Producto a base de esencias naturales.</p>
                <img src="./imagenes/crema.png" alt="Crema Natural">
                <a href="./CRUD-producto/formularioprodu.php">Añadir Producto</a>
            </article>
        </div>

        <div class="hero-der">
            <img src="https://i.pinimg.com/1200x/43/81/39/43813927a9f156b69ff0a9be2ae381cd.jpg" alt="Productos Divine">
        </div>
    </section>

    <main class="principal">
        <section class="caracteristicas">
            <div class="caja-caracteristica">
                <img src="https://i.pinimg.com/736x/07/9a/16/079a161ed785efc26d2451d8fd3d3451.jpg" alt="Skin Care">
            </div>
            <div class="caja-caracteristica">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4PvJpjnUGDjkF_Mw-VHV10iYUkdZ940gkQw&s" alt="Lociones">
            </div>
            <div class="caja-caracteristica">
                <img src="https://i.pinimg.com/736x/98/dc/17/98dc175ff91df602482d6eca3acc90c5.jpg" alt="Aceites">
            </div>
            <div class="caja-caracteristica">
                <img src="https://i.pinimg.com/1200x/be/a0/39/bea039dbfc9b87ecaa7c13b1af851a7e.jpg" alt="Coco Esencial">
            </div>
        </section>

        <section class="tarjetas">
            <div class="tarjeta">
                <img src="https://i.pinimg.com/1200x/e6/43/3a/e6433ab7609c3c63d5d7ca0a50bb0bf6.jpg" alt="Cuidado Capilar">
            </div>
            <div class="tarjeta">
                <img src="https://i.pinimg.com/736x/db/bc/fc/dbbcfc1f163cbf1256cda735f1a8c7a2.jpg" alt="Rosas">
            </div>
            <div class="tarjeta">
                <img src="https://i.pinimg.com/1200x/a3/cb/06/a3cb06cc6ce57637c7f4aff1fc6f1109.jpg" alt="Tratamiento Facial">
            </div>
        </section>
    </main>

    <footer class="pie">
        <div class="footer-contenedor">
            <div class="columna">
                <h3>Conócenos</h3>
                <p>Quiénes somos</p>
                <p>Nuestra historia</p>
                <p>Preguntas frecuentes</p>
            </div>

            <div class="columna">
                <h3>Estás comprando en BOLIVIA 🇧🇴</h3>
                <p>Instagram</p>
                <p>WhatsApp</p>
            </div>
        </div>

        <p class="copy">© 2026 DIVINE — Belleza natural hecha con amor</p>
    </footer>

    <script>
        window.onload = function() {
            setTimeout(() => {
                document.getElementById("pantallaNegra").classList.add("pantalla-negra-activa");
            }, 800);
        };
    </script>

    <?php include 'submenpiepag.php'; ?>

</body>
</html>