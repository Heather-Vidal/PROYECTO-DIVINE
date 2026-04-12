<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DIVINE</title>

  <style>
    /* === PANTALLA NEGRA === */
    .pantalla-negra {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: black;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 2em;
      font-weight: bold;
      z-index: 9999;
    }
    .pantalla-negra-activa {
      animation: bajarPantalla 1s ease forwards;
    }
    @keyframes bajarPantalla {
      from { top: 0; }
      to { top: 100%; }
    }

    /* ===== BODY ===== */
    body {
      display: grid;
      grid-template-columns: 100%;
      grid-template-rows: 80px 50px auto auto;
      grid-template-areas:
        "cabeza"
        "nav"
        "main"
        "mu";
      font-family: "Lora", serif;
      background-color: #ffffff;
    }

    /* ===== HEADER ===== */
    header.encabezado {
      grid-area: cabeza;
      background: #364e63;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      font-weight: 700;
      color: rgb(221, 193, 143);
      font-family: "Playfair Display", serif;
      letter-spacing: 2px;
      text-transform: uppercase;
      box-shadow: 0 2px 10px rgba(0,0,0,0.4);
    }

    /* ===== NAV ===== */
    nav.navegacion {
      grid-area: nav;
      background: #f5e9d8;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      gap: 180px;
      padding: 10px 0;
    }

    nav.navegacion a {
      color: #2b2b2b;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    nav.navegacion a:hover {
      color: #c5a46d;
      transform: scale(1.05);
    }

    /* ===== MENU DESPLEGABLE ===== */
    .desplegable {
      position: relative;
    }

    /* Mostrar el menú cuando se hace hover en el contenedor */
    .desplegable:hover .menu-desplegable {
      display: block;
    }

    .boton-desplegable {
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .flecha {
      transition: transform 0.3s ease;
      font-size: 12px;
    }

    .desplegable:hover .flecha {
      transform: rotate(180deg);
    }

    .menu-desplegable {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #ffffff;
      min-width: 180px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      border-radius: 8px;
      z-index: 10;
      padding: 8px 0;
      border: 1px solid #c5a46d;
    }

    .menu-desplegable a {
      padding: 10px 15px;
      color: #2b2b2b;
      text-decoration: none;
      transition: 0.3s;
      display: block;
    }

    .menu-desplegable a:hover {
      background-color: #f5e9d8;
      color: #c5a46d;
    }

    /* ===== MAIN ===== */
    main.principal {
      grid-area: main;
      background: #e9e5dd;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-bottom: 70px;
    }

    .seccion-hero {
      width: 100%;
      height: 380px;
      padding: 70px 60px;
      border-bottom-left-radius: 60px;
      border-bottom-right-radius: 60px;
      position: relative;
      overflow: hidden;
    }

    .seccion-hero img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 110%;
      height: 120%;
      object-fit: cover;
      object-position: center;
      opacity: 0.3;
    }

    .seccion-hero h2,
    .seccion-hero p,
    .seccion-hero a {
      position: relative;
      z-index: 1;
    }

    .seccion-hero h2 { font-size: 45px; margin: 0; }
    .seccion-hero p { margin-top: 12px; max-width: 370px; font-size: 17px; }

    .boton-hero {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 28px;
      border-radius: 40px;
      color: #2a2a2a;
      font-weight: bold;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(114, 37, 37, 0.25);
    }

    /* ===== CARACTERÍSTICAS ===== */
    .caracteristicas {
      margin-top: 70px;
      width: 85%;
      background: #364e63;
      padding: 40px 30px;
      border-radius: 30px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      box-shadow: 0 8px 22px rgba(0,0,0,0.25);
    }

    .caja-caracteristica {
      border-radius: 15px;
      overflow: hidden;
      background: #ada5a5f3;
      height: 200px;
    }

    .caja-caracteristica img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* ===== TARJETAS ===== */
    .tarjetas {
      margin-top: 70px;
      width: 85%;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
    }

    .tarjeta {
      background: #ffffff;
      border-radius: 25px;
      overflow: hidden;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      transition: 0.3s ease;
      height: 350px;
      display: flex;
      flex-direction: column;
    }

    .tarjeta:hover { transform: scale(1.05); }
    .tarjeta img { width: 100%; height: 100%; object-fit: cover; }

   footer.pie {
  background-color: #364e63;
  color: #c5a46d;
  padding: 20px 10px;
  grid-area: mu;
  font-family: "Playfair Display", serif;
}

.footer-contenedor {
  display: flex;
  justify-content: center;
  gap: 130px; 
  margin-bottom: 25px;
}

.columna h3 {
  font-size: 22px;
  margin-bottom: 10px;
  font-weight: bold;
}

.columna p {
  margin: 6px 0;
  font-size: 16px;
  cursor: pointer;
}

.copy {
  text-align: center;
  font-size: 15px;
  margin-top: 20px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
  .caracteristicas { grid-template-columns: repeat(2, 1fr); }
  .tarjetas { grid-template-columns: 1fr; }
  nav.navegacion { gap: 70px;}
}

@media (max-width: 600px) {
  nav.navegacion { gap: 40px; font-size: 15px; }
  .seccion-hero h2 { font-size: 32px; }
  .caracteristicas { grid-template-columns: 1fr; }
}

.usuario {
  position: absolute;
  top: 15px;
  right: 25px;
  display: flex;
  align-items: center;
  cursor: pointer;
  transition: 0.3s;
}
.usuario:hover {
  transform: scale(1.1);
}

.foto-usuario {
  width: 50px;
  height: 60px;
  object-fit: cover;
}

@media (max-width: 600px) {
  .foto-usuario { width: 50px; height: 50px; }
  .usuario { top: 15px; right: 25px; }
}
  </style>
</head>

<body>
  <!-- PANTALLA NEGRA -->
  <div class="pantalla-negra" id="pantallaNegra">
    <h1>DIVINE</h1>
  </div>

  <a href="formcliente.php" class="usuario">
    <img src="https://cdn-icons-png.flaticon.com/512/166/166277.png" alt="Perfil" class="foto-usuario">
  </a>

  <header class="encabezado"><h1>DIVINE</h1></header>

  <nav class="navegacion">
    <a href="paginaprinc2.php">Inicio</a>

    <div class="desplegable">
      <span class="boton-desplegable">
       <a href="productos.html"> Productos </a> <span class="flecha">&#9660;</span>
      </span>
      <div class="menu-desplegable">
        <a href="mascarillas.html">Mascarillas capilares</a>
        <a href="skincare.html">Skincare</a>
      </div>
    </div>

    <a>Ofertas</a>
    <a>Contacto</a>
    <a>Consulta Personal</a>
  </nav>

  <main class="principal">
    <section class="seccion-hero">
      <h2>Belleza Natural</h2>
      <p>Productos inspirados en la elegancia de la naturaleza para cuidar tu piel y cabello.</p>
      <a class="boton-hero" href="formularioprodu.php">Añadir Producto</a>
      <img src="https://i.pinimg.com/1200x/43/81/39/43813927a9f156b69ff0a9be2ae381cd.jpg">
    </section>

    <section class="caracteristicas">
      <div class="caja-caracteristica"><img src="https://i.pinimg.com/736x/07/9a/16/079a161ed785efc26d2451d8fd3d3451.jpg"></div>
      <div class="caja-caracteristica"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4PvJpjnUGDjkF_Mw-VHV10iYUkdZ940gkQw&s"></div>
      <div class="caja-caracteristica"><img src="https://i.pinimg.com/736x/98/dc/17/98dc175ff91df602482d6eca3acc90c5.jpg"></div>
      <div class="caja-caracteristica"><img src="https://i.pinimg.com/1200x/be/a0/39/bea039dbfc9b87ecaa7c13b1af851a7e.jpg"></div>
    </section>

    <section class="tarjetas">
      <div class="tarjeta"><img src="https://i.pinimg.com/1200x/e6/43/3a/e6433ab7609c3c63d5d7ca0a50bb0bf6.jpg"></div>
      <div class="tarjeta"><img src="https://i.pinimg.com/736x/db/bc/fc/dbbcfc1f163cbf1256cda735f1a8c7a2.jpg"></div>
      <div class="tarjeta"><img src="https://i.pinimg.com/1200x/a3/cb/06/a3cb06cc6ce57637c7f4aff1fc6f1109.jpg"></div>
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

    <p class="copy">© 2025 DIVINE — Belleza natural hecha con amor</p>
  </footer>

  <!-- SCRIPT -->
  <script>
    window.onload = function() {
      setTimeout(() => {
        document.getElementById("pantallaNegra").classList.add("pantalla-negra-activa");
      }, 800);
    };
  </script>
</body>
</html>
