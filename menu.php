<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

    </style>
</head>
<body>
 <header>
    <div class="logo">
        <a href="pagintrof.php"> <img src="DIVINE-removebg-preview.png" alt="Logo" width="145"></a>
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
            <img src="https://cdn-icons-png.freepik.com/512/107/107831.png" alt="carrito" width="25">
        </a>
        <a href="formcliente.php">
            <img src="https://cdn-icons-png.flaticon.com/512/7531/7531708.png" alt="persona" width="25">
        </a>
    </nav>
</header>
</body>
</html>