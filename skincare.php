<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Productos Faciales</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:linear-gradient(135deg,#f8edf1,#ead7df);
}

/* HEADER */

header{
background:
linear-gradient(
135deg,
#bf7485,
#d89aa7
);

padding:80px 20px;

text-align:center;

color:white;

box-shadow:0 8px 25px rgba(191,116,133,.3);
}

header h1{
font-size:3.3rem;
font-weight:300;
letter-spacing:4px;
margin-bottom:12px;
text-transform:uppercase;
}

header p{
font-size:1.2rem;
color:#fff3f5;
}

/* CONTENEDOR */

.contenedor{
max-width:1200px;
margin:60px auto;
padding:20px;
}

h2{
text-align:center;
font-size:2rem;
color:#bf7485;
margin-bottom:45px;
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

border-radius:25px;

overflow:hidden;

box-shadow:
0 10px 25px rgba(0,0,0,.10);

transition:.35s;

text-align:center;

padding-bottom:20px;

}

.card:hover{

transform:
translateY(-10px);

box-shadow:
0 20px 40px rgba(191,116,133,.18);

}

.card img{

width:100%;

height:250px;

object-fit:cover;

transition:.4s;

}

.card:hover img{

transform:scale(1.04);

}

.card h3{

color:#9e5567;

font-size:22px;

margin-top:18px;

}

.precio{

color:#c96f84;

font-size:1.5rem;

font-weight:bold;

margin:14px 0;

}

/* CONTROLES */

.controles{

display:flex;

justify-content:center;

align-items:center;

gap:15px;

margin:18px 0;

}

.btn-cantidad{

width:42px;

height:42px;

border:none;

border-radius:50%;

background:#d89aa7;

color:white;

font-size:20px;

cursor:pointer;

transition:.3s;

}

.btn-cantidad:hover{

background:#bf7485;

transform:scale(1.08);

}

.cantidad{

font-size:20px;

font-weight:bold;

color:#9e5567;

min-width:30px;

}

/* BOTON */

.btn-carrito{

display:block;

width:82%;

margin:auto;

padding:14px;

border:none;

border-radius:14px;

background:

linear-gradient(
135deg,
#c96f84,
#bf7485
);

color:white;

font-size:15px;

font-weight:700;

cursor:pointer;

transition:.3s;

text-decoration:none;

}

.btn-carrito:hover{

transform:translateY(-3px);

background:

linear-gradient(
135deg,
#b45d72,
#9e5567
);

}

/* RESPONSIVE */

@media(max-width:900px){

.grid{

grid-template-columns:
repeat(2,1fr);

}

}

@media(max-width:780px){

.grid{

grid-template-columns:1fr;

}

.card img{

height:320px;

}

header h1{

font-size:2.5rem;

}

}

/* =========================
   ✨ ENTRADA PRODUCTOS (KEYFRAMES)
========================= */

.card {
  animation: aparecerProducto 0.8s ease forwards;
  opacity: 0; /* estado inicial obligatorio */
}

/* animación principal */
@keyframes aparecerProducto {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* delays escalonados SOLO con CSS */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }
.card:nth-child(5) { animation-delay: 0.5s; }
.card:nth-child(6) { animation-delay: 0.6s; }
.card:nth-child(7) { animation-delay: 0.7s; }
.card:nth-child(8) { animation-delay: 0.8s; }
.card:nth-child(9) { animation-delay: 0.9s; }
.card:nth-child(10) { animation-delay: 1s; }
.card:nth-child(11) { animation-delay: 1.1s; }
.card:nth-child(12) { animation-delay: 1.2s; }

/* hover premium */
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 18px 35px rgba(191,116,133,.18);
}

/* botón suave */
.btn-carrito {
  transition: 0.3s ease;
}

.btn-carrito:hover {
  transform: scale(1.03);
}
</style>
</head>

<body>

<?php include 'submenu.php'; ?>

<header>

<h1>PRODUCTOS FACIALES</h1>

<p>Cuidado suave para cada detalle de tu piel</p>

</header>

<section class="contenedor">

<h2>Nuestra colección</h2>

<div class="grid" id="productos"></div>

</section>

<script>

const productos=[

{
nombre:"Serum revitalizante",
precio:"Bs 40",
img:"./imagenes/crema.jpg"
},

{
nombre:"Crema nutritiva",
precio:"Bs 30",
img:"./imagenes/cremademanos.jpg"
},

{
nombre:"Aceite facial",
precio:"Bs 27",
img:"./imagenes/cremanaranja.jpg"
},

{
nombre:"Loción iluminadora",
precio:"Bs 40",
img:"./imagenes/cremarosa.jpg"
},

{
nombre:"Mascarilla de escencias",
precio:"Bs 52",
img:"./imagenes/naranja.jpg"
},

{
nombre:"Mascarilla detox",
precio:"Bs 38",
img:"./imagenes/pepino.jpg"
}

];

const contenedor=
document.getElementById("productos");

productos.forEach((p)=>{

const card=
document.createElement("div");

card.className=
"card";

card.innerHTML=`

<img src="${p.img}">

<h3>${p.nombre}</h3>

<p class="precio">
${p.precio}
</p>

<div class="controles">

<button class="btn-cantidad menos">
−
</button>

<span class="cantidad">
1
</span>

<button class="btn-cantidad mas">
+
</button>

</div>

<a href="./CRUD-CARRITO-PEDIDO/formpedido.php" class="btn-carrito">
Agregar al carrito
</a>

`;

contenedor.appendChild(card);

});

/* CONTADOR */

document.addEventListener("click",(e)=>{

if(e.target.classList.contains("mas")){

let n=
e.target
.previousElementSibling;

n.innerText=
parseInt(
n.innerText
)+1;

}

if(
e.target.classList.contains("menos")
){

let n=
e.target
.nextElementSibling;

if(
parseInt(n.innerText)>1
){

n.innerText=
parseInt(
n.innerText
)-1;

}

}

});

</script>

<?php include 'submenpiepag.php'; ?>

</body>
</html>