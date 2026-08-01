    <style>
        header{
            background:transparent;
            backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    height: 100px;
   }

a{
    font-family: "Lora", serif;
  font-optical-sizing: auto;
}
div.logo{
    display: flex;
    align-items: center;
    justify-content: center;
    position:absolute;
    width: 100px;
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
.btn-menu{
    position:absolute;
    left:20px;
    font-size:30px;
    border:none;
    background:none;
    cursor:pointer;
}

.menu-lateral{
    position:fixed;
    top:0;
    left:-400px;
    width:380px;
    height:100%;
    background:white;
    transition:0.5s;
    z-index:9999;
    padding-top:30px;
}

.menu-lateral a{
    display:block;
    padding:20px 30px;
    text-decoration:none;
    color:#333;
    font-size:22px;
}

.cerrar{
    display:block;
    padding:20px 30px;
    cursor:pointer;
    font-size:20px;
}
*{
    margin:0px;
    padding:0px;
}
    </style>
 <header>

    <button class="btn-menu" onclick="abrirMenu()">☰</button>

    <div class="logo">
            <a href="pagintrof.php">

        <img src="./imagenes/DIVINE-removebg-preview.png" alt="">
    </div>

</header>

<div id="menuLateral" class="menu-lateral">

    <span class="cerrar" onclick="cerrarMenu()">✕ Fechar</span>

    <a href="totu.php">Inicio</a>
    <a href="productos.php">Productos</a>
    <a href="#">Ofertas</a>
    <a href="#">Contacto</a>
    <a href="#">Consulta Personal</a>
    <a href="perfilvendedor.php">Vendedor</a>

</div>
            <img src="./imagenes/lupa-removebg-preview.png" alt="carrito" width="25">
        </a>
        <a href="#">
            <img src="./imagenes/carrito.png" alt="carrito" width="25">
        </a>
        <a href="formcliente.php">
            <img src="./imagenes/persona.png" alt="persona" width="25">
        </a>
    </nav>
    <script>
function abrirMenu(){
    document.getElementById("menuLateral").style.left = "0";
}

function cerrarMenu(){
    document.getElementById("menuLateral").style.left = "-400px";
}
</script>
</header>
   