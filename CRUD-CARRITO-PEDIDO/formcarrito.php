 <?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor,$usuario,$contrasena,$bd);

if($conn->connect_error){
die("Error de conexión: ".$conn->connect_error);
}

session_start();

$id_pedido=$_GET['idPedido'];

$sql="SELECT * FROM producto";
$resultado=$conn->query($sql);

$sqlTotal="SELECT sum(costototal) FROM carrito where PEDIDOS_ID='$id_pedido'";
$resultadoTotal=$conn->query($sqlTotal);

$res=$resultadoTotal->fetch_assoc();

$total=$res['sum(costototal)'];

if($res['sum(costototal)']==null){
$total=0;
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>DIVINE</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI';
}

body{
background: linear-gradient(
rgb(229, 214, 230),
rgba(227, 211, 227, 0.9)
);

background-position:center;
background-size:cover;
background-attachment:fixed;
min-height:100vh;
}

/* HERO */
.hero{
height:420px;
background:
linear-gradient(
rgba(216,154,167,.25),
rgba(216,154,167,.25)
),
url("../imagenes/fondote.png");

background-size:cover;
background-position:center;
display:flex;
justify-content:center;
align-items:center;
}

.hero-content{
background:rgba(255,255,255,.75);
padding:40px;
border-radius:25px;
backdrop-filter:blur(10px);
text-align:center;
}

.hero h1{
font-size:4rem;
color:#bf7485;
}

/* SECTION */
.section{
max-width:1400px;
margin:auto;
padding:60px;
}

.titulo{
text-align:center;
color:#bf7485;
font-size:2rem;
margin-bottom:20px;
}

.total{
text-align:center;
font-size:22px;
color:#c96f84;
margin-bottom:40px;
}

/* GRID */
.grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:30px;
}

/* CARD */
.card{
background:white;
border-radius:25px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.08);
transition:.3s;
}

.card:hover{
transform:translateY(-8px);
}

.imagen{
height:270px;
background:#efe4e7;
display:flex;
justify-content:center;
align-items:center;
overflow:hidden;
}

.imagen img{
width:100%;
height:100%;
object-fit:cover;
}

.placeholder{
font-size:18px;
color:#bf7485;
}

/* INFO CENTRADA */
.info{
padding:22px;
text-align:center;
}

/* PRODUCTO EN MAYÚSCULAS */
.nombre-producto{
color:#bf7485;
margin-bottom:12px;
text-transform:uppercase;
font-size:18px;
letter-spacing:1px;
}

/* DESCRIPCIÓN */
.descripcion{
color:#666;
margin-bottom:15px;
min-height:60px;
}

/* PRECIO */
.precio{
font-size:22px;
font-weight:bold;
color:#c96f84;
margin-bottom:18px;
}

/* CANTIDAD MEJORADA */
.cantidad{
display:flex;
gap:12px;
align-items:center;
justify-content:center;
margin-bottom:15px;
}

.cantidad button{
width:45px;
height:45px;
border:none;
background:#c96f84;
color:white;
border-radius:50%;
cursor:pointer;
font-size:20px;
transition:0.2s;
}

.cantidad button:hover{
background:#b65e73;
}

.cantidad input{
width:75px;
height:45px;
text-align:center;
border:none;
background:#f6eff0;
border-radius:10px;
font-weight:bold;
font-size:16px;
}

/* BOTÓN */
.btn{
width:100%;
padding:14px;
border:none;
background:#c96f84;
color:white;
border-radius:12px;
cursor:pointer;
transition:0.3s;
font-weight:600;
}

.btn:hover{
background:#b65e73;
}

/* BOTONES ABAJO */
.botones{
display:flex;
justify-content:center;
gap:20px;
margin-top:50px;
}

.final{
padding:15px 25px;
background:#c96f84;
color:white;
border-radius:15px;
text-decoration:none;
transition:0.3s;
}

.final:hover{
background:#b65e73;
}

</style>

</head>

<body>

<section class="hero">

<div class="hero-content">

<h1>DIVINE</h1>

<p>Selecciona productos</p>

</div>

</section>

<section class="section">

<h2 class="titulo">COMIENZA A ARMAR TU CARRITO:</h2>

<div class="total">
Total: <?php echo $total ?>
</div>

<div class="grid">

<?php while($fila=$resultado->fetch_assoc()){ ?>

<div class="card">

<div class="imagen">

<?php if(isset($fila["imagen"]) && $fila["imagen"]!=""){ ?>
<img src="<?php echo $fila["imagen"] ?>">
<?php } else { ?>
<div class="placeholder">Imagen aquí</div>
<?php } ?>

</div>

<div class="info">

<h3 class="nombre-producto">
<?php echo strtoupper($fila["nombre"]) ?>
</h3>

<p class="descripcion"><?php echo $fila["descripcion"] ?></p>

<div class="precio">
Bs. <?php echo $fila["precio"] ?>
</div>

<form action="createcarrito.php" method="post">

<input type="hidden" name="codigo" value="<?php echo $fila["codigo"] ?>">
<input type="hidden" name="idpedido" value="<?php echo $id_pedido ?>">
<input type="hidden" name="precio" value="<?php echo $fila["precio"] ?>">

<div class="cantidad">

<button type="button" onclick="this.nextElementSibling.stepDown()">−</button>

<input type="number" name="cantidad" value="0" min="0">

<button type="button" onclick="this.previousElementSibling.stepUp()">+</button>

</div>

<button class="btn">Agregar al carrito</button>

</form>

</div>

</div>

<?php } ?>

</div>

<div class="botones">

<a class="final" href="formpedido.php">Generar Nuevo Pedido</a>

<a class="final" href="readcarrito.php?idPedido=<?php echo $id_pedido ?>">
Ver productos agregados
</a>

</div>

</section>
<script>
if (window.location.href.includes("idPedido")) {
    const scroll = sessionStorage.getItem("scrollY");
    if (scroll) window.scrollTo(0, scroll);
}

window.addEventListener("scroll", () => {
    sessionStorage.setItem("scrollY", window.scrollY);
});
</script>
</body>
</html>

<?php
$conn->close();
?>