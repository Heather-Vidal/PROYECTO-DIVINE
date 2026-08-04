<?php
session_start();
if($_SESSION['nombre'] == null){
    header("Location: loginformcliente.php");
}
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$inicial = strtoupper(substr($nombreUsuario, 0, 1));
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
    --bg:#F9F3F5;
    --card:#FFFFFF;
    --primary:#C97A92;
    --primary-dark:#B96582;
    --text:#5C5356;
    --text-light:#8A7A80;
    --border:#E9C8D2;
    --shadow:0 10px 30px rgba(185,120,145,.12);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}

/* CONTENEDOR PRINCIPAL */

.container{
    width:90%;
    margin:auto;
    padding:30px;
}

/* HEADER */

.header{
    background:var(--card);
    border-radius:25px;
    border:1px solid var(--border);
    box-shadow:var(--shadow);
    padding:35px;
    text-align:center;
    margin-bottom:30px;
}

.header h1{
    font-family:'Playfair Display',serif;
    font-size:3rem;
    color:var(--primary-dark);
    font-weight:700;
}

.header p{
    color:var(--text-light);
    margin-top:8px;
}

/* TARJETAS */

.card,
.profile-card,
.action-card,
.stat-card{
    background:var(--card);
    border-radius:22px;
    border:1px solid var(--border);
    box-shadow:var(--shadow);
}

/* PERFIL */

.profile-card{
    padding:30px;
    text-align:center;
}

.profile-img{
    width:140px;
    height:140px;
    border-radius:50%;
    border:6px solid #F5D9E3;
    object-fit:cover;
}

.profile-card h2{
    margin-top:15px;
    font-size:2rem;
    color:var(--primary-dark);
}

.profile-card .role{
    display:inline-block;
    margin-top:10px;
    padding:8px 20px;
    border-radius:30px;
    background:#F7E7EC;
    color:var(--primary-dark);
    font-weight:600;
}

.estado{
    margin-top:20px;
    padding:15px;
    border-radius:15px;
    background:#FFF8FA;
    border:1px solid var(--border);
    color:var(--primary-dark);
    font-style:italic;
}

.contacto{
    margin-top:15px;
    color:var(--text-light);
}

/* PROGRESO */

.progress{
    width:100%;
    height:10px;
    background:#F2DEE5;
    border-radius:20px;
    overflow:hidden;
    margin:15px 0;
}

.progress-bar{
    height:100%;
    background:var(--primary);
    border-radius:20px;
}

/* ESTADÍSTICAS */

.stats{
    display:flex;
    gap:15px;
    margin-top:20px;
}

.stat-card{
    flex:1;
    padding:18px;
    text-align:center;
}

.stat-card h2{
    color:var(--primary-dark);
    font-size:2rem;
}

.stat-card p{
    color:var(--text-light);
}

/* BOTÓN */

button,
.btn{
    width:100%;
    margin-top:20px;
    padding:14px;
    border:none;
    border-radius:30px;
    background:var(--primary);
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

button:hover,
.btn:hover{
    background:var(--primary-dark);
    transform:translateY(-2px);
}

/* TARJETAS DE ACCIONES */

.action-card{
    text-align:center;
    padding:40px;
    transition:.3s;
    cursor:pointer;
}

.action-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(180,120,140,.18);
}

.action-card i,
.action-card svg{
    font-size:70px;
    color:var(--primary-dark);
    margin-bottom:20px;
}

.action-card h3{
    color:var(--primary-dark);
    font-size:1.3rem;
}

/* HISTORIAL */

.history-card{
    background:var(--card);
    border-radius:22px;
    border:1px solid var(--border);
    box-shadow:var(--shadow);
    padding:40px;
}

.history-card h2{
    color:var(--primary-dark);
    margin-bottom:20px;
}

/* INPUTS */

input,
select,
textarea{
    width:100%;
    padding:12px 15px;
    border-radius:12px;
    border:1px solid var(--border);
    background:#FFF;
    color:var(--text);
    outline:none;
    transition:.3s;
}

input:focus,
select:focus,
textarea:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(201,122,146,.15);
}

/* TABLAS */

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#F7E7EC;
    color:var(--primary-dark);
}

th,
td{
    padding:15px;
    border-bottom:1px solid #F0DDE4;
}

tr:hover{
    background:#FFF7FA;
}

/* SCROLL */

::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-thumb{
    background:var(--primary);
    border-radius:20px;
}

::-webkit-scrollbar-track{
    background:#F6EEF1;
}
</style>
</head>
<body>
<?php include 'submenu.php'; ?>
<div class="container">
<main class="bodycito">
    <section class="bodycito_sec1">
<div class="hero">
<h1  class="fuente">Hola!! <?php echo $_SESSION['nombre']?> - <?php echo $_SESSION['celular']?></h1>  
<p>Perfil personal -  DIVINE</p>
</div>
<div class="grid-top">
<div class="profile-card">
<div class="profile-header">
 <?php echo $inicial; ?>
<img src="">
<h2> <?php echo $_SESSION['nombre']?> </h2>
<div class="badge">
 <?php echo $_SESSION['rol']?> - DIVINE
</div>
</div>
<div class="quote">
" <?php echo $_SESSION['estado']?>  "
</div>
<p>CONTACTO: <?php echo $_SESSION['celular']?>  </p>
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

<a href="./CRUD-CARRITO-PEDIDO/readtodopedido.php" class="metric button-card">

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
 <?php include 'submenpiepag.php'; ?>
</body>
</html>
