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
 
<link href="https://fonts.cdnfonts.com/css/bestigia" rel="stylesheet">
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
.fuente {
        font-family: 'Bestigia', sans-serif;                                     
  font-weight: 400px;
  font-style: normal;
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

grid-template-columns:1fr 1fr;

gap:12px; /* antes 20 */

width:100%;

margin-bottom:18px;

align-items:start;

}



/* cajas un poco menos rectangulares */

.button-card{

height:175px; /* antes 205 */

min-width:0;

padding:18px;

}



/* historial abajo centrado pero más cerca */

.metrics{

display:grid;

grid-template-columns:1fr 1fr;

column-gap:12px; /* espacio horizontal */

row-gap:6px; /* espacio vertical ↓↓↓ */

width:100%;

margin-bottom:15px;

align-items:start;

}



/* cajas menos largas */

.button-card{

height:170px;

padding:15px;

min-width:0;

}



/* HISTORIAL */

.metrics a:nth-child(3){

grid-column:1 / 3;

width:42%;

justify-self:center;

/* acercarlo a las de arriba */
margin-top:-50px;

}



/* cajas más largas */
.button-card{

height:205px;

min-width:300px;

}



/* HISTORIAL ABAJO CENTRADO */

.metrics a:nth-child(3){

grid-column:1 / 3;

width:52%;

justify-self:center;

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

.metric{
padding:20px;
text-align:center;
}

 
/* IMAGENES DE BOTONES */

.registro,
.historial,
.actualizar{

width:100px;
height:100px;

display:flex;
justify-content:center;
align-items:center;

margin:auto;

}

.registro img,
.historial img,
.actualizar img{

width:100%;
height:100%;

object-fit:contain;

/* si quieres redondas cambia 18px por 50% */
border-radius:18px;

transition:.3s;

}

.button-card:hover img{

transform:scale(1.08);

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
.profile-stats a{
background:#f8ead8;
padding:15px;
border-radius:15px;
text-align:center;
text-decoration:none;
color:inherit;
display:block;
transition:.3s;
}

.profile-stats a:hover{
transform:translateY(-6px);
box-shadow:0 15px 30px rgba(90,60,30,.25);
}

.profile-stats strong{
font-size:24px;
display:block;
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
}
.logout-box{
    margin-top:20px;
    text-align:center;
}

.logout-btn{
    display:block;
    width:100%;
    padding:14px;

    background:linear-gradient(
        135deg,
        #b89968,
        #8b6848
    );

    color:white;
    text-decoration:none;
    font-weight:600;

    border-radius:15px;

    transition:.3s;
    box-shadow:0 8px 20px rgba(90,60,30,.20);
}

.logout-btn:hover{
    transform:translateY(-3px);

    background:linear-gradient(
        135deg,
        #c9a267,
        #9c7343
    );

    box-shadow:0 12px 25px rgba(90,60,30,.30);
}
</style>
</head>
<body>

<?php include 'submenu.php'; ?>
<div class="container">
<main class="bodycito">
 
    <section class="bodycito_sec1">



<div class="hero">

<h1  class="fuente">Hola!! <?php echo $_SESSION['nombre']?></h1>  


<p>Perfil personal -  DIVINE</p>

</div>





<div class="grid-top">



<div class="profile-card">


<div class="profile-header">


<img src="https://i.pravatar.cc/500?img=47">


<h2> <?php echo $_SESSION['nombre']?> </h2>


<div class="badge">
 <?php echo $_SESSION['rol']?> - DIVINE
</div>


</div>




<div class="quote">

" <?php echo $_SESSION['estado']?>  ¿"

</div>





<div class="progress">


<p>Desempeño General 97%</p>


<div class="progress-bar">

<div class="progress-fill"></div>

</div>


</div>






<div class="profile-stats">

<a href="ventas.php" class="stat-card">
<strong>356</strong>
Ventas
</a>

<a href=" ./CRUD-CARRITO-PEDIDO/readtodopedido.php" class="stat-card">
<strong>24</strong>
Pedidos
</a>

<a href="stock.php" class="stat-card">
<strong>98%</strong>
Stock
</a>

</div>

<div class="logout-box">
    <a href="./SESIONES/logincerrarcliente.php" class="logout-btn">
        Cerrar Sesión
    </a>
</div>

</div>


<div class="metrics">

<a href="./CRUD-producto/formularioprodu.php" class="metric button-card">

<div class="registro">

<img src="./imagenes/registro.svg">

</div>

<p>
Registrar producto
</p>

</a>

<a href="objetivos.html" class="metric button-card">

<div class="historial">

<img src="./imagenes/pedido.svg">

</div>
<p>
Actualizar pedido
</p>

</a>




<a href="satisfaccion.html" class="metric button-card">

<div class="actualizar">

<img src="./imagenes/historial2.svg">

</div>

<p>
Historial
</p>

</a>
</div>

</div>

<div class="grid-middle">

<div class="card">


<h3>╰┈➤ Objetivo del Mes</h3>


<p>Ventas alcanzadas</p>


<h2>8,000 bs / 10,000 bs</h2>



<div class="goal-bar">

<div class="goal-fill"></div>

</div>

<p style="margin-top:15px;">

80% completado

</p>



</div>


<div class="card">


<h3>♛ Logros Desbloqueados</h3>



<div class="live-item">

✔ 100 ventas completadas

</div>

<div class="live-item">

✔ Inventario perfecto

</div>

<div class="live-item">

✔ 50% pedidos realizados

</div>

<div class="live-item">

✭Próximo: 500 ventas mensuales

</div>

</div>
</div>

<!-- RESUMEN IA AHORA ABAJO -->

<div class="ai-card">

<h2>🤖 Resumen del Día</h2>
<div class="ai-box">
    
✿ 12 pedidos pendientes<br>

✿ 3 reseñas sin responder<br>

✿ 4 productos con stock bajo<br>

 

</div>

<div class="ai-recommendation">


<strong>Recomendación IA:</strong><br>


Aplicar promoción al producto
"Glow Serum Premium" para incrementar ventas esta semana.


</div>



</div>

<div class="card" style="margin-bottom:25px;">



<h3>⚡Ultimos Movimientos</h3>



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


