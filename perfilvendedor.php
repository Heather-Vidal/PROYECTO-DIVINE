
<?php
session_start();
if($_SESSION['nombre'] == null){
    header("Location: loginformcliente.php");
}

$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$inicial = strtoupper(substr($nombreUsuario, 0, 1));
?>
<?php

 


// ==========================================
// VALIDACIÓN DE ROL
// SOLO ADMINISTRADORES PUEDEN ENTRAR
// ==========================================

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "vendedor") {

    header("Location: ./SESIONES/loginformcliente.php");
    exit();

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
--pink-soft: #fdf0f4;
--pink-light: #fbe3eb;
--pink-medium: #f2a6bf;
--pink-accent: #e06d92;
--pink-dark: #8c3b58;
--rose-gold: #d4989d;
--berry: #5c1d33;
--white: #ffffff;
--shadow: 0 12px 30px rgba(180, 100, 130, 0.12);
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

.fuente {
  font-family: 'Bestigia', sans-serif;                                     
  font-weight: 400;
  font-style: normal;
}

body{
background: linear-gradient(135deg, #fdf0f4 0%, #fae1ea 50%, #f7d5e1 100%);
min-height:100vh;
color:var(--berry);
}

.container{
padding:30px;
max-width:1600px;
margin:auto;
}

.hero{
background: linear-gradient(135deg, #e06d92 0%, #be4b73 100%);
border-radius:35px;
padding:35px;
box-shadow: 0 15px 35px rgba(188, 75, 115, 0.25);
margin-bottom:25px;
text-align:center;
color: var(black);
}

.hero h1{
font-size:42px;
color: var(black);
text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hero p{
color: black;
font-weight: 500;
margin-top: 5px;
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
background: linear-gradient(145deg, #ffffff 0%, #fdf3f6 100%);
border: 1px solid #f3c2d4;
box-shadow: var(--shadow);
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
border: 5px solid #f2a6bf;
box-shadow: 0 8px 20px rgba(224, 109, 146, 0.25);
}

.profile-header h2{
margin-top:15px;
color: var(--berry);
}

.badge{
display:inline-block;
margin-top:10px;
padding:8px 18px;
background: #fbe3eb;
border: 1px solid #f2a6bf;
border-radius:25px;
font-size:13px;
font-weight:600;
color: var(--pink-dark);
}

.quote{
margin-top:20px;
padding:15px;
background: #fdf0f4;
border-left: 4px solid var(--pink-accent);
border-radius:12px;
font-style:italic;
color: var(--pink-dark);
}

.profile-card p {
margin-top: 15px;
font-weight: 500;
color: var(--berry);
}

.progress{
margin-top:20px;
}

.progress p {
font-size: 14px;
margin-bottom: 6px;
}

.progress-bar{
height:12px;
background:#f7d5e1;
border-radius:20px;
overflow:hidden;
}

.progress-fill{
height:100%;
width:98%;
background: linear-gradient(90deg, #f2a6bf 0%, #e06d92 100%);
}

.profile-stats{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:10px;
margin-top:20px;
}

.profile-stats a{
background:#fce8f0;
padding:15px;
border-radius:18px;
text-align:center;
text-decoration:none;
color:var(--berry);
display:block;
border: 1px solid #f7d5e1;
transition:.3s;
}

.profile-stats a:hover{
transform:translateY(-5px);
background: #f2a6bf;
color: var(--white);
box-shadow: 0 8px 20px rgba(224, 109, 146, 0.3);
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
color:var(--berry);
}

.ai-box{
background:#fdf0f4;
border: 1px solid #f7d5e1;
padding:25px;
border-radius:20px;
line-height:2;
color: var(--pink-dark);
font-weight: 500;
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
color:var(--berry);
margin-bottom: 12px;
}

.card h2 {
color: var(--pink-dark);
margin: 8px 0;
}

.goal-bar{
height:18px;
background:#f7d5e1;
border-radius:20px;
overflow:hidden;
margin-top: 10px;
}

.goal-fill{
height:100%;
width:80%;
background: linear-gradient(90deg, #f2a6bf, #be4b73);
}

.live-item{
padding:12px 16px;
margin-bottom:10px;
background:#fdf0f4;
border: 1px solid #fae1ea;
border-radius:14px;
color: var(--pink-dark);
font-size: 14.5px;
}

/* BOTONES METRICAS */

.metrics{
display:grid;
grid-template-columns:1fr 1fr;
column-gap:12px;
row-gap:6px;
width:100%;
margin-bottom:15px;
align-items:start;
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
box-shadow: 0 15px 30px rgba(188, 75, 115, 0.2);
border-color: var(--pink-accent);
}

.metrics a:nth-child(3){
grid-column:1 / 3;
width:52%;
justify-self:center;
}

.metric{
padding:20px;
text-align:center;
}

/* IMAGENES DE BOTONES */

.registro,
.historial,
.actualizar{
width:90px;
height:90px;
display:flex;
justify-content:center;
align-items:center;
margin:auto;
background: #fbe3eb;
border-radius: 50%;
padding: 15px;
transition: .3s;
}

.registro img,
.historial img,
.actualizar img{
width:100%;
height:100%;
object-fit:contain;
transition:.3s;
}

.button-card:hover .registro,
.button-card:hover .historial,
.button-card:hover .actualizar {
background: var(--pink-accent);
}

.button-card:hover img{
transform:scale(1.1);
filter: brightness(0) invert(1);
}

.metric p{
margin-top:12px;
font-weight:700;
color:var(--berry);
}

.logout-box{
margin-top:20px;
text-align:center;
}

.logout-btn{
display:block;
width:100%;
padding:14px;
background:linear-gradient(135deg, #e06d92, #be4b73);
color:white;
text-decoration:none;
font-weight:600;
border-radius:18px;
transition:.3s;
box-shadow:0 8px 20px rgba(190, 75, 115, 0.25);
}

.logout-btn:hover{
transform:translateY(-3px);
background:linear-gradient(135deg, #be4b73, #8c3b58);
box-shadow:0 12px 25px rgba(140, 59, 88, 0.35);
}

.profile-card{
position:relative;
overflow:hidden;
}

/* Efecto brillo elegante */
.profile-card::before{
content:'';
position:absolute;
top:0;
left:-180%;
width:70%;
height:100%;
background:linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.6),
    transparent
);
transform:skewX(-25deg);
animation:shineCard 6s infinite;
pointer-events:none;
}

@keyframes shineCard{
0%{ left:-180%; }
100%{ left:220%; }
}

/* RESPONSIVE */

@media(max-width:1024px){
.container{ padding:20px; }
.grid-top, .grid-middle{ grid-template-columns:1fr; }
.profile-card{ max-width:600px; margin:auto; }
.hero h1{ font-size:34px; }
.metrics{ grid-template-columns:1fr 1fr; }
.button-card{ min-width:auto; height:180px; }
}

@media (max-width:768px){
.container{ padding:15px; }
.hero{ padding:25px 15px; }
.hero h1{ font-size:28px; }
.hero p{ font-size:14px; }
.profile-header img{ width:140px; height:140px; }
.profile-card{ width:100%; padding:30px 20px; border-radius:20px; }
.profile-stats{ grid-template-columns:1fr; }
.metrics{ grid-template-columns:1fr; }
.metrics a:nth-child(3){ width:100%; margin-top:0; }
.button-card{ width:100%; height:170px; }
.registro, .historial, .actualizar{ width:75px; height:75px; }
.card, .ai-card{ padding:20px; }
}

</style>
</head>
<body>

<?php include 'submenu.php'; ?>
<div class="container">
<main class="bodycito">

    <section class="bodycito_sec1">

<div class="hero">
<h1 class="fuente">Bienvenido <?php echo $_SESSION['nombre']?> - <?php echo $_SESSION['celular']?></h1>  
<p>Perfil personal - DIVINE</p>
</div>

<div class="grid-top">

<div class="profile-card">

<div class="profile-header">
<?php echo $inicial; ?>
<img src="https://i.pravatar.cc/500?img=47" alt="Perfil">

<h2> <?php echo $_SESSION['nombre']?> </h2>

<div class="badge">
 <?php echo $_SESSION['rol']?> - DIVINE
</div>
</div>

<div class="quote">
" <?php echo $_SESSION['estado']?> "
</div>

<p>CONTACTO: <?php echo $_SESSION['celular']?> </p>

<div class="progress">
<p>Desempeño General 97%</p>
<div class="progress-bar">
<div class="progress-fill"></div>
</div>
</div>

<div class="profile-stats">
<<<<<<< Updated upstream
<a href="ventas.php" class="stat-card">
=======

<a href="./CRUD-ventas/readtodoventa.php" class="stat-card">
>>>>>>> Stashed changes
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
<img src="./imagenes/registro.svg" alt="Registrar">
</div>
<p>Registrar producto</p>
</a>

<a href="./CRUD-CARRITO-PEDIDO/readtodopedido.php" class="metric button-card">
<div class="historial">
<img src="./imagenes/pedido.svg" alt="Pedido">
</div>
<p>Actualizar pedido</p>
</a>

<a href="satisfaccion.html" class="metric button-card">
<div class="actualizar">
<img src="./imagenes/historial2.svg" alt="Historial">
</div>
<p>Historial</p>
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

<p style="margin-top:15px; font-weight:600; color:var(--pink-dark);">
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
✭ Próximo: 500 ventas mensuales
</div>
</div>

</div>

<div class="ai-card">
<h2>Resumen del Día</h2>
<div class="ai-box">
✿ 12 pedidos pendientes<br>
✿ 3 reseñas sin responder<br>
✿ 4 productos con stock bajo<br>
</div>
</div>

<div class="card" style="margin-top:25px; margin-bottom:25px;">
<h3>Últimos Movimientos</h3>

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

    </section>
</main>
</div>
</div>
 <?php include 'submenpiepag.php'; ?>
</body>
</html>
