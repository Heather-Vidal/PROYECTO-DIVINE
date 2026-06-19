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

.hero{
height:500px;
background:linear-gradient(
rgba(216,154,167,.25),
rgba(216,154,167,.25)
),
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
height:55px;
margin-bottom:15px;
}

.precio{
font-size:1.3rem;
font-weight:bold;
color:#c96f84;
margin-bottom:15px;
}

.btn-carrito{
display:block;
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:#c96f84;
color:white;
font-weight:600;
cursor:pointer;
text-align:center;
text-decoration:none;
}

.btn-carrito:hover{
background:#b85f73;
}

@media(max-width:768px){
.hero h1{font-size:2.5rem;}
.hero{height:400px;}
}

</style>
</head>
<?php include 'submenu.php'; ?>

<body>

<section class="hero">
<div class="hero-content">
<h1>DIVINE</h1>
<p>Productos premium para el cuidado de tu piel</p>
</div>
</section>

<section class="section">

<h2 class="titulo">Nuestros Productos</h2>

<div class="grid">

<div class="card">
<img src="./imagenes/coco.jpg" alt="">
<div class="info">
<h3>Peptide Lip Tint</h3>
<p class="descripcion">Brillo hidratante con color suave para uso diario.</p>
<div class="precio">$18</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/cremademanos.jpg" alt="">
<div class="info">
<h3>Lip Treatment</h3>
<p class="descripcion">Tratamiento nutritivo para labios suaves.</p>
<div class="precio">$20</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/cremanaranja.jpg" alt="">
<div class="info">
<h3>Barrier Cream</h3>
<p class="descripcion">Crema facial hidratante para todo tipo de piel.</p>
<div class="precio">$25</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/cremarosa.jpg" alt="">
<div class="info">
<h3>Glow Serum</h3>
<p class="descripcion">Suero iluminador para una piel radiante.</p>
<div class="precio">$30</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/Aceitedericino.avif" alt="">
<div class="info">
<h3>Hydrating Mist</h3>
<p class="descripcion">Refresca e hidrata la piel al instante.</p>
<div class="precio">$15</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/pepino.jpg" alt="">
<div class="info">
<h3>Night Repair</h3>
<p class="descripcion">Reparación intensiva durante la noche.</p>
<div class="precio">$32</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/naranja.jpg" alt="">
<div class="info">
<h3>Cleanser</h3>
<p class="descripcion">Limpieza suave y profunda para el rostro.</p>
<div class="precio">$17</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedealmendra.avif" alt="">
<div class="info">
<h3>Eye Cream</h3>
<p class="descripcion">Reduce bolsas y líneas de expresión.</p>
<div class="precio">$28</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedeargan.avif" alt="">
<div class="info">
<h3>Peptide Balm</h3>
<p class="descripcion">Bálsamo nutritivo con efecto glow.</p>
<div class="precio">$19</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/Aceitemultivitamínico.avif" alt="">
<div class="info">
<h3>Face Oil</h3>
<p class="descripcion">Aceite facial ligero y revitalizante.</p>
<div class="precio">$29</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedejojoba.avif" alt="">
<div class="info">
<h3>Soft Blush</h3>
<p class="descripcion">Rubor cremoso de acabado natural.</p>
<div class="precio">$22</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

<div class="card">
<img src="./imagenes/aceitedecoco.avif" alt="">
<div class="info">
<h3>Makeup Base</h3>
<p class="descripcion">Base ligera para un acabado uniforme.</p>
<div class="precio">$27</div>
<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">Agregar al carrito</a>
</div>
</div>

</div>

</section>
<?php include 'submenpiepag.php'; ?>

</body>
</html>