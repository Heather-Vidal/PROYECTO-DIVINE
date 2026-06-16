<?php
session_start();
if($_SESSION['nombre'] == null){
    header("Location: loginformcliente.php");
}
?>


 <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Beauty Glow Executive Center</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

:root{

--cream:#faf6f0;
--ivory:#fffaf3;
--champagne:#d8c3a5;
--gold:#b89968;
--coffee:#6d5745;
--soft:#f4e8d8;

--shadow:0 15px 35px rgba(90,60,30,.18);

}



*{

margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;

}




body{

background:

linear-gradient(
135deg,
#f3e3d0,
#fff9ef,
#e8d1b3
);


min-height:100vh;

color:var(--coffee);

}




.container{

padding:30px;

max-width:1600px;

margin:auto;

}




.hero{


background:

linear-gradient(
135deg,
#fffaf3,
#efd8b8
);


border-radius:35px;

padding:35px;

box-shadow:var(--shadow);

margin-bottom:25px;

text-align:center;

}




.hero h1{

font-size:42px;

color:#63452c;

}




.hero p{

color:#8b6848;

}





.grid-top{

display:grid;

grid-template-columns:420px 1fr;

gap:25px;

margin-bottom:25px;

}






.profile-card,
.ai-card,
.card,
.metric{


background:

linear-gradient(
145deg,
#fffaf3,
#ead5b8
);


border:1px solid #d4b37d;

box-shadow:var(--shadow);

}





.profile-card{

border-radius:30px;

padding:30px;

}




.profile-header{

text-align:center;

}





.profile-header img{

width:170px;

height:170px;

border-radius:50%;

object-fit:cover;


border:6px solid #c9a267;

}





.profile-header h2{

margin-top:15px;

}





.badge{


display:inline-block;

margin-top:10px;

padding:8px 16px;

background:#dfc39a;

border-radius:25px;

font-size:13px;

font-weight:600;

color:#5d422b;


}





.quote{

margin-top:20px;

padding:15px;

background:#f7ead8;

border-radius:15px;

font-style:italic;

}





.progress{

margin-top:20px;

}





.progress-bar{

height:12px;

background:#dec7a7;

border-radius:20px;

overflow:hidden;

}





.progress-fill{

height:100%;

width:98%;


background:

linear-gradient(
90deg,
#c69b5d,
#98703d
);


}




.profile-stats{


display:grid;

grid-template-columns:repeat(3,1fr);

gap:10px;

margin-top:20px;


}




.profile-stats div{


background:#f8ead8;

padding:15px;

border-radius:15px;

text-align:center;


}





.profile-stats strong{

font-size:24px;

display:block;

}








.ai-card{


border-radius:30px;

padding:30px;

}





.ai-card h2{

margin-bottom:20px;

color:#65452c;

}





.ai-box{


background:#f8ead8;

padding:25px;

border-radius:20px;

line-height:2;

}





.ai-recommendation{


margin-top:20px;

padding:20px;

background:#fff0dc;

border-left:5px solid var(--gold);

border-radius:15px;

}





.grid-middle{

display:grid;

grid-template-columns:1fr 1fr;

gap:25px;

margin-bottom:25px;

}






.card{


border-radius:30px;

padding:25px;

}





.card h3{

color:#65452c;

}





.goal-bar{

height:18px;

background:#dec7a7;

border-radius:20px;

overflow:hidden;

}




.goal-fill{

height:100%;

width:80%;


background:

linear-gradient(
90deg,
#c69b5d,
#98703d
);


}





.live-item{


padding:12px;

margin-bottom:10px;

background:#f8ead8;

border-radius:12px;

}









/* BOTONES */

.metrics{


display:grid;

grid-template-columns:repeat(3,1fr);

gap:18px;

width:100%;

margin-bottom:25px;


}





.button-card{


height:190px;


text-decoration:none;

color:inherit;


display:flex;

flex-direction:column;

align-items:center;

justify-content:center;


border-radius:25px;


transition:.3s;


}





.button-card:hover{


transform:translateY(-8px);


box-shadow:

0 20px 45px rgba(90,60,30,.28);


}





/* CENTRAR LOS DOS DE ABAJO */

.button-card:nth-child(4){


grid-column:1;

justify-self:end;

}



.button-card:nth-child(5){


grid-column:2;

justify-self:start;

}





.metric{


padding:20px;

text-align:center;

}




.circle{


width:95px;

height:95px;

border-radius:50%;


display:flex;

align-items:center;

justify-content:center;


font-size:25px;

font-weight:700;



background:

conic-gradient(

#b89968 0deg,

#b89968 340deg,

#ead9bf 340deg,

#ead9bf 360deg

);


color:#563d25;


}





.metric p{

margin-top:12px;

font-weight:700;

color:#65452c;


}







.footer{


text-align:center;

padding:40px;


color:#806047;


}






@media(max-width:1000px){


.grid-top{

grid-template-columns:1fr;

}




.grid-middle{

grid-template-columns:1fr;

}




.metrics{


grid-template-columns:1fr;


}



.button-card:nth-child(4),

.button-card:nth-child(5){


grid-column:auto;

justify-self:center;


}



}


</style>
</head>
<body>
<<<<<<< HEAD

<div class="container">
=======
<main class="bodycito">
<h1>ñlmdvksl</h1>
    <section class="bodycito_sec1">
>>>>>>> c5212ac2f7f78429dea5571768b67b6521a7ece5


<div class="hero">

<h1>Hola!! Isabella </h1>

<p>Perfil personal -  DIVINE</p>

</div>





<div class="grid-top">



<div class="profile-card">


<div class="profile-header">


<img src="https://i.pravatar.cc/500?img=47">


<h2>Isabella Fernández</h2>


<div class="badge">
👑 Administradora Ejecutiva Platinum
</div>


</div>




<div class="quote">

"La belleza es confianza y la gestión es liderazgo."

</div>





<div class="progress">


<p>Desempeño General 98%</p>


<div class="progress-bar">

<div class="progress-fill"></div>

</div>


</div>






<div class="profile-stats">


<div>

<strong>356</strong>

Ventas

</div>



<div>

<strong>24</strong>

Reportes

</div>



<div>

<strong>98%</strong>

Éxito

</div>


</div>



</div>







<!-- AHORA VAN LAS 5 CAJAS ARRIBA -->

<div class="metrics">


<a href="rendimiento.html" class="metric button-card">

<div class="circle">
98%
</div>

<p>
Rendimiento
</p>

</a>




<a href="objetivos.html" class="metric button-card">

<div class="circle">
85%
</div>

<p>
Objetivos
</p>

</a>




<a href="satisfaccion.html" class="metric button-card">

<div class="circle">
92%
</div>

<p>
Satisfacción
</p>

</a>





<a href="historial.html" class="metric button-card">

<div class="circle">
📜
</div>

<p>
Historial
</p>

</a>





<a href="actualizar.html" class="metric button-card">

<div class="circle">
🔄
</div>

<p>
Actualizar
</p>

</a>


</div>



</div>









<div class="grid-middle">



<div class="card">


<h3>🎯 Objetivo del Mes</h3>


<p>Ventas alcanzadas</p>


<h2>$8,000 / $10,000</h2>



<div class="goal-bar">

<div class="goal-fill"></div>

</div>



<p style="margin-top:15px;">

80% completado

</p>



</div>







<div class="card">


<h3>🏆 Logros Desbloqueados</h3>



<div class="live-item">

✔ 100 ventas completadas

</div>



<div class="live-item">

✔ Inventario perfecto

</div>




<div class="live-item">

✔ 95% satisfacción clientes

</div>




<div class="live-item">

🎯 Próximo: 500 ventas mensuales

</div>



</div>



</div>









<!-- RESUMEN IA AHORA ABAJO -->

<div class="ai-card">


<h2>🤖 Resumen Inteligente del Día</h2>



<div class="ai-box">


📦 12 pedidos pendientes<br>

⭐ 3 reseñas sin responder<br>

⚠️ 4 productos con stock bajo<br>

👥 8 nuevos clientes registrados<br>

📈 Ventas proyectadas: +15%


</div>





<div class="ai-recommendation">


<strong>Recomendación IA:</strong><br>


Aplicar promoción al producto
"Glow Serum Premium" para incrementar ventas esta semana.


</div>



</div>









<div class="card" style="margin-bottom:25px;">



<h3>⚡ Actividad en Vivo</h3>



<div class="live-item">

Hace 2 min · María compró Glow Serum Premium

</div>



<div class="live-item">

Hace 5 min · Nuevo usuario registrado

</div>



<div class="live-item">

Hace 8 min · Pedido #458 entregado

</div>



<div class="live-item">

Hace 12 min · Nueva reseña de cliente

</div>



</div>





<div class="footer">

© 2026 Beauty Glow Executive Center • Luxury Edition ✨

</div>



</div>


</body>
</html>
/*/* ================= BOTONES ADMINISTRADOR ================= */


.metrics{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:20px;

width:100%;

margin-bottom:25px;

}




.button-card{

height:190px;

background:linear-gradient(
145deg,
#fffaf3,
#ead5b8
);

border:1px solid #d4b37d;

border-radius:25px;

box-shadow:0 15px 35px rgba(90,60,30,.18);

text-decoration:none;

color:inherit;

display:flex;

flex-direction:column;

align-items:center;

justify-content:center;

transition:.3s;

}





.button-card:hover{

transform:translateY(-8px);

box-shadow:0 25px 45px rgba(90,60,30,.25);

}





/* Historial */

.button-card:nth-child(4){

grid-column:1 / 2;

width:100%;

}





/* Actualizar */

.button-card:nth-child(5){

grid-column:2 / 3;

width:100%;

}






.metric{

width:100%;

height:190px;

padding:20px;

text-align:center;

border-radius:25px;

}




.circle{

width:95px;

height:95px;

border-radius:50%;


display:flex;

align-items:center;

justify-content:center;


font-size:25px;

font-weight:700;



background:

conic-gradient(

#b89968 0deg,

#b89968 340deg,

#ead9bf 340deg,

#ead9bf 360deg

);


color:#563d25;


}





.metric p{

margin-top:15px;

font-weight:700;

color:#65452c;

}






@media(max-width:1000px){


.metrics{

grid-template-columns:1fr;

}



.button-card:nth-child(4),

.button-card:nth-child(5){

grid-column:auto;

}


}*/