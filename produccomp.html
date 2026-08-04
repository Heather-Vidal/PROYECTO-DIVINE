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

/* HEADER */

header{
background:#d89aa7;
padding:25px;
text-align:center;
position:sticky;
top:0;
z-index:100;
box-shadow:0 2px 15px rgba(0,0,0,.1);
}

.logo{
font-size:2rem;
font-weight:700;
color:white;
letter-spacing:3px;
}

/* HERO */

.hero{
height:500px;
background:linear-gradient(
rgba(216,154,167,.25),
rgba(216,154,167,.25)
),
url("https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=1400");
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

/* PRODUCTOS */

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

/* CARD */

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

/* CONTROLES */

.controles{
display:flex;
justify-content:center;
align-items:center;
gap:15px;
margin-bottom:15px;
}

.btn-cantidad{
width:40px;
height:40px;
border:none;
border-radius:50%;
background:#e8b8c3;
color:white;
font-size:1.3rem;
cursor:pointer;
transition:.3s;
}

.btn-cantidad:hover{
background:#c96f84;
}

.cantidad{
font-size:1.2rem;
font-weight:bold;
min-width:30px;
text-align:center;
}

.btn-carrito{
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:#c96f84;
color:white;
font-weight:600;
cursor:pointer;
transition:.3s;
}

.btn-carrito:hover{
background:#b45d72;
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
<header>
<div class="logo">RHODE BEAUTY</div>
</header>

<section class="hero">
<div class="hero-content">
<h1>Glow Collection</h1>
<p>Productos premium para el cuidado de tu piel</p>
</div>
</section>

<section class="section">

<h2 class="titulo">Nuestros Productos</h2>

<div class="grid" id="productos"></div>

</section>

<script>

const productos = [

{
nombre:"Peptide Lip Tint",
precio:"$18",
descripcion:"Brillo hidratante con color suave para uso diario.",
img:"https://picsum.photos/400/400?1"
},

{
nombre:"Lip Treatment",
precio:"$20",
descripcion:"Tratamiento nutritivo para labios suaves.",
img:"https://picsum.photos/400/400?2"
},

{
nombre:"Barrier Cream",
precio:"$25",
descripcion:"Crema facial hidratante para todo tipo de piel.",
img:"https://picsum.photos/400/400?3"
},

{
nombre:"Glow Serum",
precio:"$30",
descripcion:"Suero iluminador para una piel radiante.",
img:"https://picsum.photos/400/400?4"
},

{
nombre:"Hydrating Mist",
precio:"$15",
descripcion:"Refresca e hidrata la piel al instante.",
img:"https://picsum.photos/400/400?5"
},

{
nombre:"Night Repair",
precio:"$32",
descripcion:"Reparación intensiva durante la noche.",
img:"https://picsum.photos/400/400?6"
},

{
nombre:"Cleanser",
precio:"$17",
descripcion:"Limpieza suave y profunda para el rostro.",
img:"https://picsum.photos/400/400?7"
},

{
nombre:"Eye Cream",
precio:"$28",
descripcion:"Reduce bolsas y líneas de expresión.",
img:"https://picsum.photos/400/400?8"
},

{
nombre:"Peptide Balm",
precio:"$19",
descripcion:"Bálsamo nutritivo con efecto glow.",
img:"https://picsum.photos/400/400?9"
},

{
nombre:"Face Oil",
precio:"$29",
descripcion:"Aceite facial ligero y revitalizante.",
img:"https://picsum.photos/400/400?10"
},

{
nombre:"Soft Blush",
precio:"$22",
descripcion:"Rubor cremoso de acabado natural.",
img:"https://picsum.photos/400/400?11"
},

{
nombre:"Makeup Base",
precio:"$27",
descripcion:"Base ligera para un acabado uniforme.",
img:"https://picsum.photos/400/400?12"
}

];

const contenedor = document.getElementById("productos");

productos.forEach(producto=>{

const card = document.createElement("div");

card.classList.add("card");

card.innerHTML = `

<img src="${producto.img}" alt="${producto.nombre}">

<div class="info">

<h3>${producto.nombre}</h3>

<p class="descripcion">
${producto.descripcion}
</p>

<div class="precio">
${producto.precio}
</div>

<div class="controles">

<button class="btn-cantidad menos">-</button>

<span class="cantidad">1</span>

<button class="btn-cantidad mas">+</button>

</div>

<button class="btn-carrito">
Agregar al carrito
</button>

</div>

`;

contenedor.appendChild(card);

});

document.addEventListener("click",(e)=>{

if(e.target.classList.contains("mas")){

let cantidad =
e.target.parentElement.querySelector(".cantidad");

cantidad.textContent =
parseInt(cantidad.textContent)+1;

}

if(e.target.classList.contains("menos")){

let cantidad =
e.target.parentElement.querySelector(".cantidad");

let valor =
parseInt(cantidad.textContent);

if(valor>1){
cantidad.textContent = valor-1;
}

}

if(e.target.classList.contains("btn-carrito")){

alert("Producto agregado al carrito 🛒");

}

});

</script>

</body>
</html>