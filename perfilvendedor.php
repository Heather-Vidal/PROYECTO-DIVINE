<?php

session_start();

/* =========================================================
   VALIDAR SESIÓN
========================================================= */

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] == null) {
    header("Location: ./SESIONES/loginformcliente.php");
    exit();
}


/* =========================================================
   VALIDAR ROL
========================================================= */

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "vendedor") {

    echo "<script>
            alert('ACCESO DENEGADO: Solo los vendedores pueden entrar a esta página.');
            window.location.href = './SESIONES/loginformcliente.php';
          </script>";

    exit();
}


/* =========================================================
   DATOS DE SESIÓN
========================================================= */

$nombreUsuario = $_SESSION['nombre'];
$inicial = strtoupper(substr($nombreUsuario, 0, 1));


/* =========================================================
   CONEXIÓN A BASE DE DATOS
========================================================= */

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);

if ($conn->connect_error) {
    die("Error de conexión con la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8");


/* =========================================================
   VARIABLE SEGURA DEL VENDEDOR
========================================================= */

$nombreVendedor = $conn->real_escape_string($_SESSION['nombre']);


/* =========================================================
   CONTAR VENTAS DEL VENDEDOR
   SOLO VENTAS COMPLETADAS
========================================================= */

$sqlVentas = "
    SELECT COUNT(*) AS total_ventas
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON v.PEDIDOS_ID = p.ID
    WHERE p.nombrevendedor = '$nombreVendedor'
      AND LOWER(TRIM(v.estado)) = 'completado'
      AND LOWER(TRIM(p.estado)) = 'completado'
";

$resultadoVentas = $conn->query($sqlVentas);

$totalVentas = 0;

if ($resultadoVentas) {

    $filaVentas = $resultadoVentas->fetch_assoc();

    $totalVentas = $filaVentas['total_ventas'] ?? 0;
}


/* =========================================================
   CONTAR PEDIDOS DEL VENDEDOR
========================================================= */

$sqlPedidos = "
    SELECT COUNT(*) AS total_pedidos
    FROM PEDIDOS
    WHERE nombrevendedor = '$nombreVendedor'
";

$resultadoPedidos = $conn->query($sqlPedidos);

$totalPedidos = 0;

if ($resultadoPedidos) {

    $filaPedidos = $resultadoPedidos->fetch_assoc();

    $totalPedidos = $filaPedidos['total_pedidos'] ?? 0;
}


/* =========================================================
   RESUMEN DEL DÍA
========================================================= */


/* ---------------------------------------------------------
   PEDIDOS PENDIENTES
--------------------------------------------------------- */

$sqlPendientes = "
    SELECT COUNT(*) AS cantidad
    FROM PEDIDOS
    WHERE nombrevendedor = '$nombreVendedor'
      AND LOWER(TRIM(estado)) = 'pendiente'
";

$resultadoPendientes = $conn->query($sqlPendientes);

$pedidosPendientes = 0;

if ($resultadoPendientes) {

    $filaPendientes = $resultadoPendientes->fetch_assoc();

    $pedidosPendientes = $filaPendientes['cantidad'] ?? 0;
}


/* ---------------------------------------------------------
   VENTAS COMPLETADAS DE HOY
--------------------------------------------------------- */

$sqlVentasHoy = "
    SELECT
        COUNT(v.id) AS cantidad,
        COALESCE(SUM(v.costototal), 0) AS total
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON v.PEDIDOS_ID = p.ID
    WHERE p.nombrevendedor = '$nombreVendedor'
      AND LOWER(TRIM(v.estado)) = 'completado'
      AND LOWER(TRIM(p.estado)) = 'completado'
      AND DATE(v.fecha) = CURDATE()
";

$resultadoVentasHoy = $conn->query($sqlVentasHoy);

$ventasHoy = 0;
$dineroHoy = 0;

if ($resultadoVentasHoy) {

    $filaVentasHoy = $resultadoVentasHoy->fetch_assoc();

    $ventasHoy = $filaVentasHoy['cantidad'] ?? 0;

    $dineroHoy = $filaVentasHoy['total'] ?? 0;
}


/* ---------------------------------------------------------
   PRODUCTOS CON STOCK BAJO
--------------------------------------------------------- */

$sqlStockBajo = "
    SELECT COUNT(*) AS cantidad
    FROM PRODUCTO
    WHERE stock <= 5
";

$resultadoStockBajo = $conn->query($sqlStockBajo);

$productosStockBajo = 0;

if ($resultadoStockBajo) {

    $filaStockBajo = $resultadoStockBajo->fetch_assoc();

    $productosStockBajo = $filaStockBajo['cantidad'] ?? 0;
}


/* =========================================================
   ÚLTIMA VENTA
========================================================= */

$sqlUltimaVenta = "
    SELECT
        v.id,
        v.costototal,
        v.fecha,
        p.nombre,
        p.nombrevendedor
    FROM VENTAS v
    INNER JOIN PEDIDOS p
        ON v.PEDIDOS_ID = p.ID
    WHERE p.nombrevendedor = '$nombreVendedor'
      AND LOWER(TRIM(v.estado)) = 'completado'
      AND LOWER(TRIM(p.estado)) = 'completado'
    ORDER BY v.id DESC
    LIMIT 1
";

$resultadoUltimaVenta = $conn->query($sqlUltimaVenta);

$ultimaVenta = null;

if ($resultadoUltimaVenta) {

    $ultimaVenta = $resultadoUltimaVenta->fetch_assoc();
}


/* =========================================================
   ÚLTIMO PEDIDO
========================================================= */

$sqlUltimoPedido = "
    SELECT
        ID,
        nombre,
        estado,
        fecha
    FROM PEDIDOS
    WHERE nombrevendedor = '$nombreVendedor'
    ORDER BY ID DESC
    LIMIT 1
";

$resultadoUltimoPedido = $conn->query($sqlUltimoPedido);

$ultimoPedido = null;

if ($resultadoUltimoPedido) {

    $ultimoPedido = $resultadoUltimoPedido->fetch_assoc();
}


/* =========================================================
   PRODUCTO CON MENOR STOCK
========================================================= */

$sqlUltimoStock = "
    SELECT
        codigo,
        nombre,
        stock
    FROM PRODUCTO
    WHERE stock <= 5
    ORDER BY stock ASC
    LIMIT 1
";

$resultadoUltimoStock = $conn->query($sqlUltimoStock);

$ultimoStock = null;

if ($resultadoUltimoStock) {

    $ultimoStock = $resultadoUltimoStock->fetch_assoc();
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Beauty Glow Executive Center</title>


<link
    href="https://fonts.cdnfonts.com/css/bestigia"
    rel="stylesheet"
>

<link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* =========================================================
   COLORES
========================================================= */

:root{

--pink-soft:#fdf0f4;

--pink-light:#fbe3eb;

--pink-medium:#f2a6bf;

--pink-accent:#e06d92;

--pink-dark:#8c3b58;

--rose-gold:#d4989d;

--berry:#5c1d33;

--white:#ffffff;

--shadow:0 12px 30px rgba(180,100,130,0.12);

}


/* =========================================================
   GENERAL
========================================================= */

*{

margin:0;

padding:0;

box-sizing:border-box;

font-family:'Poppins',sans-serif;

}


.fuente{

font-family:'Bestigia',sans-serif;

font-weight:400;

font-style:normal;

}


body{

background:

linear-gradient(

135deg,

#fdf0f4 0%,

#fae1ea 50%,

#f7d5e1 100%

);

min-height:100vh;

color:var(--berry);

}


.container{

padding:30px;

max-width:1600px;

margin:auto;

}


/* =========================================================
   HERO
========================================================= */

.hero{

background:

linear-gradient(

135deg,

#e06d92 0%,

#be4b73 100%

);

border-radius:35px;

padding:35px;

box-shadow:

0 15px 35px rgba(188,75,115,0.25);

margin-bottom:25px;

text-align:center;

color:var(--white);

}


.hero h1{

font-size:42px;

color:var(--white);

text-shadow:

0 2px 4px rgba(0,0,0,0.1);

}


.hero p{

color:#fce7ef;

font-weight:500;

margin-top:5px;

}


/* =========================================================
   GRID PRINCIPAL
========================================================= */

.grid-top{

display:grid;

grid-template-columns:420px 1fr;

gap:25px;

margin-bottom:25px;

}


/* =========================================================
   TARJETAS
========================================================= */

.profile-card,
.ai-card,
.card,
.metric{

background:

linear-gradient(

145deg,

#ffffff 0%,

#fdf3f6 100%

);

border:

1px solid #f3c2d4;

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

border:5px solid #f2a6bf;

box-shadow:

0 8px 20px rgba(224,109,146,0.25);

}


.profile-header h2{

margin-top:15px;

color:var(--berry);

}


.badge{

display:inline-block;

margin-top:10px;

padding:8px 18px;

background:#fbe3eb;

border:1px solid #f2a6bf;

border-radius:25px;

font-size:13px;

font-weight:600;

color:var(--pink-dark);

}


.quote{

margin-top:20px;

padding:15px;

background:#fdf0f4;

border-left:4px solid var(--pink-accent);

border-radius:12px;

font-style:italic;

color:var(--pink-dark);

}


.profile-card p{

margin-top:15px;

font-weight:500;

color:var(--berry);

}


/* =========================================================
   PROGRESO
========================================================= */

.progress{

margin-top:20px;

}


.progress p{

font-size:14px;

margin-bottom:6px;

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

background:

linear-gradient(

90deg,

#f2a6bf 0%,

#e06d92 100%

);

}


/* =========================================================
   ESTADÍSTICAS
========================================================= */

.profile-stats{

display:grid;

grid-template-columns:1fr 1fr;

gap:15px;

margin-top:20px;

}


.profile-stats a{

background:#fce8f0;

padding:20px 15px;

border-radius:20px;

text-align:center;

text-decoration:none;

color:var(--berry);

display:block;

border:1px solid #f7d5e1;

transition:.3s;

}


.profile-stats a:hover{

transform:translateY(-6px);

background:#f2a6bf;

color:var(--white);

box-shadow:

0 8px 20px rgba(224,109,146,0.3);

}


.profile-stats strong{

font-size:30px;

display:block;

margin-bottom:4px;

}


/* =========================================================
   RESUMEN DEL DÍA
========================================================= */

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

border:1px solid #f7d5e1;

padding:20px;

border-radius:20px;

}


/* =========================================================
   TARJETAS DEL RESUMEN
========================================================= */

.resumen-grid{

display:grid;

grid-template-columns:

repeat(4,1fr);

gap:15px;

}


.resumen-item{

background:white;

border:1px solid #f3c2d4;

border-radius:18px;

padding:20px;

text-align:center;

transition:.3s;

}


.resumen-item:hover{

transform:translateY(-5px);

box-shadow:

0 10px 20px rgba(224,109,146,0.15);

}


.resumen-icon{

font-size:30px;

margin-bottom:8px;

}


.resumen-item strong{

display:block;

font-size:28px;

color:var(--pink-dark);

}


.resumen-item span{

font-size:13px;

font-weight:600;

color:#9a6074;

}


.dinero{

font-size:23px !important;

}


/* =========================================================
   CARDS
========================================================= */

.card{

border-radius:30px;

padding:25px;

}


.card h3{

color:var(--berry);

margin-bottom:12px;

}


/* =========================================================
   MOVIMIENTOS
========================================================= */

.live-item{

padding:15px 18px;

margin-bottom:10px;

background:#fdf0f4;

border:1px solid #fae1ea;

border-radius:14px;

color:var(--pink-dark);

font-size:14px;

display:flex;

align-items:center;

gap:12px;

}


/* =========================================================
   BOTÓN PRODUCTOS CON STOCK BAJO
========================================================= */

.stock-bajo-link{

text-decoration:none;

color:inherit;

cursor:pointer;

transition:all .3s ease;

position:relative;

}


.stock-bajo-link:hover{

transform:translateY(-4px);

background:#fbe3eb;

border-color:#e06d92;

box-shadow:

0 10px 25px rgba(224,109,146,0.20);

}


.stock-bajo-link::after{

content:"Ver productos →";

margin-left:auto;

padding:8px 14px;

background:#8c3b58;

color:white;

border-radius:20px;

font-size:12px;

font-weight:600;

white-space:nowrap;

transition:.3s;

}


.stock-bajo-link:hover::after{

background:#e06d92;

transform:translateX(3px);

}


/* =========================================================
   CONTENIDO DE MOVIMIENTOS
========================================================= */

.live-icon{

font-size:22px;

min-width:30px;

text-align:center;

}


.live-content{

flex:1;

}


.live-content strong{

color:var(--berry);

}


.live-content small{

display:block;

margin-top:3px;

color:#9a6074;

}


/* =========================================================
   BOTONES
========================================================= */

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

box-shadow:

0 15px 30px rgba(188,75,115,0.2);

border-color:var(--pink-accent);

}


.metric{

padding:20px;

text-align:center;

}


/* =========================================================
   IMÁGENES
========================================================= */

.registro,
.historial,
.actualizar{

width:90px;

height:90px;

display:flex;

justify-content:center;

align-items:center;

margin:auto;

background:#fbe3eb;

border-radius:50%;

padding:15px;

transition:.3s;

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
.button-card:hover .actualizar{

background:var(--pink-accent);

}


.button-card:hover img{

transform:scale(1.1);

filter:brightness(0) invert(1);

}


.metric p{

margin-top:12px;

font-weight:700;

color:var(--berry);

}


/* =========================================================
   CERRAR SESIÓN
========================================================= */

.logout-box{

margin-top:20px;

text-align:center;

}


.logout-btn{

display:block;

width:100%;

padding:14px;

background:

linear-gradient(

135deg,

#e06d92,

#be4b73

);

color:white;

text-decoration:none;

font-weight:600;

border-radius:18px;

transition:.3s;

box-shadow:

0 8px 20px rgba(190,75,115,0.25);

}


.logout-btn:hover{

transform:translateY(-3px);

background:

linear-gradient(

135deg,

#be4b73,

#8c3b58

);

}


/* =========================================================
   BRILLO
========================================================= */

.profile-card{

position:relative;

overflow:hidden;

}


.profile-card::before{

content:'';

position:absolute;

top:0;

left:-180%;

width:70%;

height:100%;

background:

linear-gradient(

90deg,

transparent,

rgba(255,255,255,0.6),

transparent

);

transform:skewX(-25deg);

animation:shineCard 6s infinite;

pointer-events:none;

}


@keyframes shineCard{

0%{

left:-180%;

}

100%{

left:220%;

}

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1200px){

.resumen-grid{

grid-template-columns:1fr 1fr;

}

}


@media(max-width:1024px){

.container{

padding:20px;

}

.grid-top{

grid-template-columns:1fr;

}

.profile-card{

max-width:600px;

margin:auto;

}

.hero h1{

font-size:34px;

}

.metrics{

grid-template-columns:1fr 1fr;

}

.button-card{

height:180px;

}

}


@media(max-width:768px){

.container{

padding:15px;

}

.hero{

padding:25px 15px;

}

.hero h1{

font-size:28px;

}

.hero p{

font-size:14px;

}

.profile-header img{

width:140px;

height:140px;

}

.profile-card{

width:100%;

padding:30px 20px;

border-radius:20px;

}


.profile-stats{

grid-template-columns:1fr 1fr;

gap:10px;

}


.profile-stats a{

padding:15px 10px;

}


.profile-stats strong{

font-size:26px;

}


.resumen-grid{

grid-template-columns:1fr 1fr;

gap:10px;

}


.resumen-item{

padding:15px 10px;

}


.resumen-item strong{

font-size:24px;

}


.metrics{

grid-template-columns:1fr;

}


.button-card{

width:100%;

height:170px;

}


.registro,
.historial,
.actualizar{

width:75px;

height:75px;

}


.card,
.ai-card{

padding:20px;

}


/* BOTÓN STOCK BAJO EN CELULAR */

.stock-bajo-link{

align-items:flex-start;

}


.stock-bajo-link::after{

font-size:11px;

padding:6px 9px;

}

}

</style>

</head>


<body>


<?php include 'submenu.php'; ?>


<div class="container">


<main class="bodycito">


<section class="bodycito_sec1">


<!-- =====================================================
     BIENVENIDA
====================================================== -->

<div class="hero">

<h1 class="fuente">

Bienvenido

<?php echo htmlspecialchars($_SESSION['nombre']); ?>

-

<?php echo htmlspecialchars($_SESSION['celular']); ?>

</h1>


<p>

Perfil personal - DIVINE

</p>

</div>


<!-- =====================================================
     PERFIL
====================================================== -->

<div class="grid-top">


<div class="profile-card">


<div class="profile-header">


<img
src="./imagenes/vendee.png"
alt="Perfil"
>


<h2>

<?php echo htmlspecialchars($_SESSION['nombre']); ?>

</h2>


<div class="badge">

<?php echo htmlspecialchars($_SESSION['rol']); ?>

- DIVINE

</div>


</div>


<div class="quote">

"

<?php echo htmlspecialchars($_SESSION['estado']); ?>

"

</div>


<p>

CONTACTO:

<?php echo htmlspecialchars($_SESSION['celular']); ?>

</p>


<div class="progress">

<p>

Desempeño General 97%

</p>


<div class="progress-bar">

<div class="progress-fill"></div>

</div>

</div>


<!-- =====================================================
     ESTADÍSTICAS
====================================================== -->

<div class="profile-stats">


<a
href="./CRUD-ventas/readtodoventa.php"
class="stat-card"
>

<strong>

<?php echo $totalVentas; ?>

</strong>

Ventas

</a>


<a
href="./CRUD-CARRITO-PEDIDO/readtodopedido.php"
class="stat-card"
>

<strong>

<?php echo $totalPedidos; ?>

</strong>

Pedidos

</a>


</div>


<!-- CERRAR SESIÓN -->

<div class="logout-box">

<a
href="./SESIONES/logincerrarcliente.php"
class="logout-btn"
>

Cerrar Sesión

</a>

</div>


</div>


<!-- =====================================================
     BOTONES PRINCIPALES
====================================================== -->

<div class="metrics">


<a
href="./CRUD-producto/formularioprodu.php"
class="metric button-card"
>

<div class="registro">

<img
src="./imagenes/registro.svg"
alt="Registrar"
>

</div>

<p>

Registrar producto

</p>

</a>


<a
href="./CRUD-CARRITO-PEDIDO/readtodopedido.php"
class="metric button-card"
>

<div class="historial">

<img
src="./imagenes/pedido.svg"
alt="Pedido"
>

</div>

<p>

Actualizar pedido

</p>

</a>


<a
href="./CRUD-ventas/readtodoventa.php"
class="metric button-card"
>

<div class="actualizar">

<img
src="./imagenes/historial2.svg"
alt="Historial"
>

</div>

<p>

Historial de ventas

</p>

</a>


</div>


</div>


<!-- =====================================================
     RESUMEN DEL DÍA
====================================================== -->

<div class="ai-card">

<h2>

Resumen del Día ✨

</h2>


<div class="ai-box">


<div class="resumen-grid">


<!-- PEDIDOS PENDIENTES -->

<div class="resumen-item">

<div class="resumen-icon">
🛒
</div>

<strong>

<?php echo $pedidosPendientes; ?>

</strong>

<span>

Pedidos pendientes

</span>

</div>


<!-- VENTAS DE HOY -->

<div class="resumen-item">

<div class="resumen-icon">
💰
</div>

<strong>

<?php echo $ventasHoy; ?>

</strong>

<span>

Ventas completadas hoy

</span>

</div>


<!-- DINERO DE HOY -->

<div class="resumen-item">

<div class="resumen-icon">
💵
</div>

<strong class="dinero">

Bs.

<?php

echo number_format(
    (float)$dineroHoy,
    2,
    '.',
    ','
);

?>

</strong>

<span>

Total vendido hoy

</span>

</div>


<!-- STOCK BAJO -->

<div class="resumen-item">

<div class="resumen-icon">
📦
</div>

<strong>

<?php echo $productosStockBajo; ?>

</strong>

<span>

Productos con stock bajo

</span>

</div>


</div>

</div>

</div>


<!-- =====================================================
     ÚLTIMOS MOVIMIENTOS
====================================================== -->

<div
class="card"
style="margin-top:25px; margin-bottom:25px;"
>


<h3>

Últimos Movimientos ✨

</h3>


<!-- =====================================================
     ÚLTIMA VENTA
====================================================== -->

<?php if ($ultimaVenta != null): ?>

<div class="live-item">

<div class="live-icon">
💰
</div>

<div class="live-content">

<strong>
Última venta completada
</strong>

<small>

Cliente:

<?php

echo htmlspecialchars(
    $ultimaVenta['nombre']
);

?>

· Total:

Bs.

<?php

echo number_format(
    (float)$ultimaVenta['costototal'],
    2,
    '.',
    ','
);

?>

· Fecha:

<?php

echo htmlspecialchars(
    $ultimaVenta['fecha']
);

?>

</small>

</div>

</div>

<?php else: ?>

<div class="live-item">

<div class="live-icon">
💰
</div>

<div class="live-content">

<strong>
Sin ventas completadas
</strong>

<small>
No existen ventas completadas para este vendedor.
</small>

</div>

</div>

<?php endif; ?>


<!-- =====================================================
     ÚLTIMO PEDIDO
====================================================== -->

<?php if ($ultimoPedido != null): ?>

<div class="live-item">

<div class="live-icon">
🛒
</div>

<div class="live-content">

<strong>
Último pedido registrado
</strong>

<small>

Pedido #<?php

echo htmlspecialchars(
    $ultimoPedido['ID']
);

?>

· Cliente:

<?php

echo htmlspecialchars(
    $ultimoPedido['nombre']
);

?>

· Estado:

<?php

echo htmlspecialchars(
    $ultimoPedido['estado']
);

?>

</small>

</div>

</div>

<?php else: ?>

<div class="live-item">

<div class="live-icon">
🛒
</div>

<div class="live-content">

<strong>
Sin pedidos registrados
</strong>

<small>
No existen pedidos registrados para este vendedor.
</small>

</div>

</div>

<?php endif; ?>


<!-- =====================================================
     PRODUCTO CON STOCK BAJO
====================================================== -->

<?php if ($ultimoStock != null): ?>

<a
href="./CRUD-producto/stock_bajo.php"
class="live-item stock-bajo-link"
>

<div class="live-icon">
📦
</div>

<div class="live-content">

<a href="./CRUD-producto/stock_bajo.php">PRODUCTOS CON STOCK BAJO</a>
<small>

<?php

echo htmlspecialchars(
    $ultimoStock['nombre']
);

?>

· Código:

<?php

echo htmlspecialchars(
    $ultimoStock['codigo']
);

?>

· Stock:

<?php

echo htmlspecialchars(
    $ultimoStock['stock']
);

?>

 unidades

</small>

</div>

</a>

<?php else: ?>

<div class="live-item">

<div class="live-icon">
📦
</div>

<div class="live-content">

<strong>
Stock disponible
</strong>

<small>
Actualmente no existen productos con stock bajo.
</small>

</div>

</div>

<?php endif; ?>


<!-- =====================================================
     ACTIVIDAD DEL VENDEDOR
====================================================== -->

<div class="live-item">

<div class="live-icon">
📊
</div>

<div class="live-content">

<strong>
Actividad del vendedor
</strong>

<small>

Tienes

<?php echo $totalPedidos; ?>

pedidos registrados y

<?php echo $totalVentas; ?>

ventas completadas.

</small>

</div>

</div>


</div>


</section>

</main>

</div>


<?php include 'submenpiepag.php'; ?>


</body>

</html>