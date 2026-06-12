<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Divine Beauty</title>

<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.pantalla-negra{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.pantalla-negra h1{
    color: white;
    font-size: 80px;
    font-family: "Lora", serif;
    letter-spacing: 8px;
}

.pantalla-negra-activa{
    animation: bajarPantalla 1.2s ease forwards;
}

@keyframes bajarPantalla{
    from{
        top: 0;
    }
    to{
        top: 100%;
    }
}

body{
    background: #EBE8D9;
    color: #111;
    font-family: Arial, sans-serif;

    display: grid;
    grid-template-rows: 100px 730px auto 100px;
    grid-template-columns: 50% 50%;
    grid-template-areas:
        "uno uno"
        "dos tres"
        "main main"
        "cua cua";
    gap: 7px;
}

/* ===== HEADER ===== */
header{
    grid-area: uno;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 10px; 
}
a{
    font-family: "Lora", serif;
  font-optical-sizing: auto;
}
div.logo{
    display: flex;
    align-items: center;
    justify-content: center;
}
div.logo img{
    width: 160px;
 margin-top: 15px;
}

nav{
    display: flex;
    gap: 35px;
}

nav a{
    text-decoration: none;
    color: #111;
     font-size: 20px;
    transition: 0.3s all;
    border-radius: 10px;
    display: block;
}

nav a:hover{
    color: #000;
transform: translateY(3px);}

/* ===== SECCIÓN IZQUIERDA ===== */
section{
    grid-area: dos;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 0 30px;
}

h1{
    font-size: 72px;
    line-height: 1.05;
    font-weight: 900;
    margin-top: -20px;
}

.color{
    font-style: italic;
    font-family: Georgia, serif;
    font-weight: 400;
}

.sub{
    font-size: 18px;
    margin-bottom: 30px;
    max-width: 500px;
}

.box{
    position: relative;
    background: #d6c8b3;
    padding: 20px;
    border-radius: 15px;
    width: 380px;
    height: 250px;
    display:flex;
    align-items: center;
    padding-left:160px;
    margin-top: 100px;
}

.box h2{

    margin-bottom: 10px;
}

.box p{
    margin-bottom: 55px;
    z-index: 5;
}

.box a{
    z-index: 5;
    text-decoration: none;
    background: #111;
    color: white;
    padding: 10px 15px;
    border-radius: 10px;
    display: inline-block;
    margin-bottom:10px;
    position: relative;
    bottom:30px;
}
.box img{
    z-index: 10;
    position: absolute;
    width: 170px;
    bottom:10px;
    left: 20px;
}

.derecha{
    grid-area: tres;
    display: flex;
    justify-content: right;
    align-items: right;
}
.derecha img{
    width: 100%;
    max-width: 885px;
    border-radius: 15px;
}
main.principal{
    grid-area: main;
    background: #e9e5dd;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 70px 0;
}

.caracteristicas{
    border-radius: 30px;
    width: 95%;
    background: #ddc9b7;
    padding:  40px 30px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    box-shadow: 0 8px 22px rgba(0,0,0,0.25);
}
.caja-caracteristica{
    overflow: hidden;
    background: #ada5a5f3;
    height: 400px;
    border-radius: 15px;}
.caja-caracteristica img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s;
}
.caja-caracteristica:hover img{
    transform: scale(1.1);
}
.tarjetas{
    margin-top: 70px;
    width: 85%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}
.tarjeta{
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

.tarjeta:hover{
    transform: scale(1.05);
}

.tarjeta img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ===== FOOTER ===== */
footer.pie{
    grid-area: cua;
    background-color: #d6c8b3;
    color: #000000;
    padding: 20px 10px;
    font-family: Georgia, serif;
}

.footer-contenedor{
    display: flex;
    justify-content: center;
    gap: 130px;
    margin-bottom: 25px;
}
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
</style>
</head>

<body>
<section class="pantalla-negra" id="pantallaNegra">
    <h1>DIVINE</h1>
   </section>
<!-- HEADER -->
<header>
    <div class="logo">
        <a href="pagintrof.php"> <img src="./imagenes/DIVINE-removebg-preview.png" alt="Logo" width="145"></a>
    </div>

    <nav>
        <a href="totu.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="#ofertas">Ofertas</a>
        <a href="#contacto">Contacto</a>
        <a href="#consulta">Consulta Personal</a>
        <a href="perfilvendedor.php">Vendedor</a>
        <a href="admin.php">Administrador</a>
        <a href="#">
            <img src="./imagenes/lupa-removebg-preview.png" lt="carrito" width="25">
        </a>
        <a href="#">
            <img src="./imagenes/carrito.png" alt="carrito" width="25">
        </a>
        <a href="./CRUD-cliente/formcliente.php">
            <img src="./imagenes/persona.png" alt="persona" width="25">
        </a>
    </nav>
</header>

<!-- SECCIÓN IZQUIERDA -->
<section>
    <h1>
        Glow Starts <br>
        With <span class="color">Natural Beauty</span>
    </h1>

    <p class="sub">
        Productos inspirados en la elegancia de la naturaleza
        para cuidar tu piel y cabello.
    </p>

    <section class="box">
        <h2>ESENCIAS</h2>
        <center><p>Producto a base de esencias naturales.</p></center>
        <img src="./imagenes/crema.png" alt="cremca" width="80px">
        <a href="./CRUD-producto/formularioprodu.php">Añadir Producto</a>
    </section>
</section>

<section class="derecha">
    <img src="./imagenes/productos.png" alt="Beauty Products">
</section>

<main class="principal">

    <section class="caracteristicas">
        <div class="caja-caracteristica">
            <img src="./imagenes/productosblancos.jpg" alt="">
        </div>
        <div class="caja-caracteristica">
            <img src="./imagenes/producs.jpg" alt="">
        </div>
        <div class="caja-caracteristica">
            <img src=" ./imagenes/productos01.jpg" alt="">
        </div>
        <div class="caja-caracteristica">
            <img src=" ./imagenes/coco.jpg" alt="">
        </div>
    </section>

    <section class="tarjetas">
        <div class="tarjeta">
            <img src="./imagenes/cabellolacio.jpg" alt="">
        </div>
        <div class="tarjeta">
            <img src="./imagenes/rosa.jpg" alt="">
        </div>
        <div class="tarjeta">
            <img src="./imagenes/castaño.jpg" alt="">
        </div>
    </section>

</main>

<footer class="pie">
    <div class="footer-contenedor">
        <p>© 2026 Divine Beauty</p>
        <p>Contacto</p>
        <p>Instagram</p>
    </div>
</footer>
 <script>
    window.onload = function() {
      setTimeout(() => {
        document.getElementById("pantallaNegra").classList.add("pantalla-negra-activa");
      }, 800);
    };
  </script>
</body>
</html>