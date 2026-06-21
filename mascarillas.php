 <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos Capilares</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:
linear-gradient(
135deg,
#f8eef2,
#ead4dc
);
}

/* HEADER */

header{

background:
linear-gradient(
135deg,
#bf7485,
#d996a6
);

text-align:center;

padding:90px 20px;

box-shadow:
0 10px 30px rgba(0,0,0,.18);

position:relative;

overflow:hidden;

}

header::after{

content:"";

position:absolute;

bottom:-70px;

left:50%;

transform:translateX(-50%);

width:220px;

height:220px;

background:
rgba(255,255,255,.10);

border-radius:50%;

}

header h1{

font-size:4rem;

font-weight:700;

color:white;

letter-spacing:4px;

text-transform:uppercase;

margin-bottom:15px;

text-shadow:
0 4px 15px rgba(0,0,0,.18);

}

header p{

color:#ffeaf0;

font-size:1.2rem;

letter-spacing:1px;

}

/* CONTENEDOR */

.contenedor{

max-width:1300px;

margin:60px auto;

padding:20px;

}

.contenedor h2{

text-align:center;

color:#b85d76;

font-size:2.3rem;

margin-bottom:50px;

font-weight:700;

}

/* GRID */

.grid{

display:grid;

grid-template-columns:
repeat(3,1fr);

gap:35px;

}

/* CARD */

.card{

background:white;

border-radius:30px;

overflow:hidden;

box-shadow:
0 15px 35px rgba(191,116,133,.15);

transition:.35s;

text-align:center;

}

.card:hover{

transform:
translateY(-10px);

box-shadow:
0 20px 45px rgba(191,116,133,.25);

}

.card img{

width:100%;

height:260px;

object-fit:cover;

transition:.4s;

}

.card:hover img{

transform:scale(1.06);

}

.card h3{

margin:18px;

color:#b85d76;

font-size:22px;

}

.precio{

color:#d17a91;

font-size:1.6rem;

font-weight:bold;

margin-bottom:15px;

}

/* CONTROLES */

.controles{

display:flex;

justify-content:center;

align-items:center;

gap:15px;

margin:20px;

}

.btn-cantidad{

width:45px;

height:45px;

border:none;

border-radius:50%;

background:#c96f84;

color:white;

font-size:22px;

cursor:pointer;

transition:.3s;

}

.btn-cantidad:hover{

background:#b45d72;

transform:scale(1.1);

}

.cantidad{

font-size:22px;

font-weight:bold;

color:#b45d72;

}

/* BOTÓN */

.btn-carrito{

display:block;

width:85%;

margin:0 auto 25px;

padding:15px;

border:none;

border-radius:18px;

background:

linear-gradient(
135deg,
#c96f84,
#e18ea3
);

color:white;

font-size:16px;

font-weight:700;

cursor:pointer;

transition:.35s;

text-decoration:none;

}

.btn-carrito:hover{

transform:
translateY(-4px);

background:

linear-gradient(
135deg,
#b85d76,
#d77f96
);

}

/* RESPONSIVE */

@media(max-width:900px){

.grid{
grid-template-columns:
repeat(2,1fr);
}

}

@media(max-width:760px){

.grid{
grid-template-columns:1fr;
}

header h1{
font-size:2.6rem;
}

}

/* =========================
   ✨ ANIMACIÓN PRODUCTOS CAPILARES
========================= */

.card {
  opacity: 0;
  animation: aparecer 0.8s ease forwards;
}

/* animación base */
@keyframes aparecer {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ESCALONADO (solo CSS puro) */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }
.card:nth-child(5) { animation-delay: 0.5s; }
.card:nth-child(6) { animation-delay: 0.6s; }

/* hover premium */
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 20px 45px rgba(191,116,133,.25);
}

/* imagen suave */
.card img {
  transition: transform 0.4s ease;
}

.card:hover img {
  transform: scale(1.06);
}

</style>
</head>

<body>

<?php include 'submenu.php'; ?>

 

<section class="contenedor">

<h2>Nuestra Colección</h2>

<div class="grid">

<?php

$productos=[

["aceitedecoco.avif","Aceite de Coco","35"],
["aceitedeargan.avif","Aceite de Argán","48"],
["aceitedealmendra.avif","Aceite de Almendras","28"],
["aceitedejojoba.avif","Aceite de Jojoba","40"],
["Aceitemultivitamínico.avif","Aceite Multivitamínico","52"],
["Aceitedericino.avif","Aceite de Ricino","38"]

];

foreach($productos as $p){

?>

<div class="card">

<img src="./imagenes/<?php echo $p[0] ?>">

<h3><?php echo $p[1] ?></h3>

<p class="precio">

Bs <?php echo $p[2] ?>

</p>

<div class="controles">

<button class="btn-cantidad">−</button>

<span class="cantidad">

1

</span>

<button class="btn-cantidad">+</button>

</div>

<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">

Agregar al carrito

</a>

</div>

<?php } ?>

</div>

</section>

<?php include 'submenpiepag.php'; ?>

</body>
</html>