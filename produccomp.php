<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beauty Store</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:#f8eef0;
}

.logo{
font-size:2rem;
font-weight:700;
color:white;
letter-spacing:3px;
}

.hero{
height:500px;
background:
linear-gradient(rgba(216,154,167,.25), rgba(216,154,167,.25)),
url("https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg");
background-size:cover;
background-position:center;
display:flex;
align-items:center;
justify-content:center;
text-align:center;
}

.hero-content{
background:rgba(255,255,255,.7);
padding:40px;
border-radius:25px;
backdrop-filter:blur(10px);
}

.hero h1{
font-size:4rem;
color:#bf7485;
}

.hero p{
margin-top:10px;
color:#666;
}

.section{
max-width:1400px;
margin:auto;
padding:60px 30px;
}

.titulo{
text-align:center;
font-size:2rem;
margin-bottom:40px;
color:#bf7485;
}

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:25px;
}

.card{
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 8px 25px rgba(0,0,0,.08);
transition:.4s;
}

.card:hover{
transform:translateY(-8px);
}

.card img{
width:100%;
height:250px;
object-fit:cover;
}

.info{
padding:20px;
}

.info h3{
color:#bf7485;
margin-bottom:10px;
}

.descripcion{
font-size:.9rem;
color:#666;
margin-bottom:15px;
}

.precio{
font-size:1.3rem;
font-weight:bold;
color:#c96f84;
margin-bottom:15px;
}

.btn-carrito{
display:inline-block;
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:#c96f84;
color:white;
font-weight:600;
text-align:center;
text-decoration:none;
transition:.3s;
}

.btn-carrito:hover{
background:#b85f73;
}

@media(max-width:768px){
.hero h1{
font-size:2.5rem;
}

.hero{
height:400px;
}
}
</style>
</head>

<body>

<section class="hero">
<div class="hero-content">
<img src="./imagenes/DIVINE-removebg-preview.png" alt="">
<p>Productos premium para el cuidado de tu piel y tu pelo</p>
</div>
</section>

<section class="section">

<h2 class="titulo">Nuestros Productos</h2>

<div class="grid">

<div class="card">
<img src="./imagenes/cremademanos.jpg" alt="">
<div class="info">
<h3>Crema de manos</h3>
<p class="descripcion">Textura suave que envuelve tus manos con hidratación ligera y delicada.</p>
<div class="precio">$18</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/coco.jpg" alt="">
<div class="info">
<h3> aceite de Coco</h3>
<p class="descripcion">Un toque tropical que nutre y suaviza con aroma dulce y natural.</p>
<div class="precio">$20</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/naranja.jpg" alt="">
<div class="info">
<h3> crema Naranja</h3>
<p class="descripcion">Energía cítrica que ilumina y refresca la piel con suavidad.</p>
<div class="precio">$25</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/pepino.jpg" alt="">
<div class="info">
<h3>Pepino</h3>
<p class="descripcion">Frescura ligera que calma y revitaliza la piel al instante.</p>
<div class="precio">$30</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedealmendra.avif" alt="">
<div class="info">
<h3>Aceite de almendra</h3>
<p class="descripcion">Hidratación profunda con una suavidad cálida y reconfortante.</p>
<div class="precio">$15</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/cremanaranja.jpg" alt="">
<div class="info">
<h3>Cremanaranja</h3>
<p class="descripcion">Crema suave con esencia cítrica que ilumina la piel delicadamente.</p>
<div class="precio">$32</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/cremarosa.jpg" alt="">
<div class="info">
<h3>Crema de rosas</h3>
<p class="descripcion">Tono floral que hidrata y deja una sensación suave y romántica.</p>
<div class="precio">$17</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedejojoba.avif" alt="">
<div class="info">
<h3>Aceite de jojoba</h3>
<p class="descripcion">Equilibrio perfecto para una piel suave, ligera y nutrida.</p>
<div class="precio">$28</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/rosa.jpg" alt="">
<div class="info">
<h3> aceite de Rosa</h3>
<p class="descripcion">Fragancia delicada que aporta frescura y suavidad natural.</p>
<div class="precio">$19</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedeargan.avif" alt="">
<div class="info">
<h3>Aceite de argan</h3>
<p class="descripcion">Nutrición intensa que deja la piel luminosa y sedosa.</p>
<div class="precio">$29</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/Aceitedericino.avif" alt="">
<div class="info">
<h3>Aceite de ricino</h3>
<p class="descripcion">Cuidado suave que fortalece y protege con delicadeza natural.</p>
<div class="precio">$22</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/Aceitemultivitamínico.avif" alt="">
<div class="info">
<h3>Aceite multivitamínico</h3>
<p class="descripcion">Vitalidad concentrada que ilumina y revitaliza tu piel.</p>
<div class="precio">$27</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

</div>
</section>

</body>
</html>