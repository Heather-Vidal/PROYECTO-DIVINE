<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 5px;
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
    gap: 70px;
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
*{
    margin:0px;
    padding:0px;
}
    </style>
</head>
<body>
 <header>
<div class="logo">
    <a href="pagintrof.php">
        <img src="./imagenes/DIVINE-removebg-preview.png" alt="Logo" width="145">
    </a>
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
            <img src="./imagenes/lupa-removebg-preview.png" alt="carrito" width="25">
        </a>
        <a href="#">
            <img src="./imagenes/carrito.png" alt="carrito" width="25">
        </a>
        <a href="formcliente.php">
            <img src="./imagenes/persona.png" alt="persona" width="25">
        </a>
    </nav>
</header>
    <section>
        Mision
        Brindar productos naturales que cuiden el cabello y <br>
        la piel, promoviendo la belleza auténtica y saludable.
 Queremos que cada persona se sienta segura, cómoda y conectada <br>
 con su propio bienestar, usando ingredientes naturales <br>
 que realmente funcionan.y vision
    </section>
    <footer class="pie">
    <div class="footer-contenedor">
        <p>© 2026 Divine Beauty</p>
        <p>Contacto</p>
        <p>Instagram</p>
    </div>
</footer>
</body>
</html>