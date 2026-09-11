<?php
session_start();

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] == null) {
    header("Location: loginformcliente.php");
    exit();
}
?>
<?php

 
if (
    !isset($_SESSION['rol']) ||
    $_SESSION['rol'] != "administrador"
) {

    echo "<script>
        alert('ACCESO DENEGADO: Solo los administradores pueden entrar a esta página.');
        window.location.href = 'SESIONES/loginformcliente.php';
    </script>";

    exit();
}

 

?>
<?php
/* =========================================================
   DATOS PARA INFORMES DEL ADMINISTRADOR
   Las ventas se cuentan cuando el PEDIDO está Aceptado.
========================================================= */
$servidor = "localhost"; $usuario = "root"; $contraseña = ""; $nombreBD = "DIVINE";
$conn = new mysqli($servidor,$usuario,$contraseña,$nombreBD);
if ($conn->connect_error) { die("Error de conexión con la base de datos: " . $conn->connect_error); }
$conn->set_charset("utf8");

$totalClientes=0; $clientesActivos=0; $totalProductos=0; $stockBajo=0; $totalPedidos=0; $pedidosPendientes=0; $pedidosAceptados=0; $totalVentas=0; $dineroVentas=0; $clienteFrecuente=null; $productoStock=null;

$sql="SELECT COUNT(*) AS total FROM CLIENTE"; if($r=$conn->query($sql)) $totalClientes=(int)($r->fetch_assoc()['total']??0);
$sql="SELECT COUNT(*) AS total FROM CLIENTE WHERE LOWER(TRIM(estado))='activo'"; if($r=$conn->query($sql)) $clientesActivos=(int)($r->fetch_assoc()['total']??0);
$sql="SELECT COUNT(*) AS total FROM PRODUCTO"; if($r=$conn->query($sql)) $totalProductos=(int)($r->fetch_assoc()['total']??0);
$sql="SELECT COUNT(*) AS total FROM PRODUCTO WHERE stock<=5"; if($r=$conn->query($sql)) $stockBajo=(int)($r->fetch_assoc()['total']??0);
$sql="SELECT codigo,nombre,stock FROM PRODUCTO WHERE stock<=5 ORDER BY stock ASC,nombre ASC LIMIT 1"; if($r=$conn->query($sql)) $productoStock=$r->fetch_assoc();
$sql="SELECT COUNT(*) AS total FROM PEDIDOS"; if($r=$conn->query($sql)) $totalPedidos=(int)($r->fetch_assoc()['total']??0);
$sql="SELECT COUNT(*) AS total FROM PEDIDOS WHERE LOWER(TRIM(estado))='pendiente'"; if($r=$conn->query($sql)) $pedidosPendientes=(int)($r->fetch_assoc()['total']??0);
$sql="SELECT COUNT(*) AS total FROM PEDIDOS WHERE LOWER(TRIM(estado))='aceptado'"; if($r=$conn->query($sql)) $pedidosAceptados=(int)($r->fetch_assoc()['total']??0);

$sql="SELECT COUNT(v.id) AS cantidad,COALESCE(SUM(v.costototal),0) AS total FROM VENTAS v INNER JOIN PEDIDOS p ON v.PEDIDOS_ID=p.ID WHERE LOWER(TRIM(p.estado))='aceptado'";
if($r=$conn->query($sql)){ $f=$r->fetch_assoc(); $totalVentas=(int)($f['cantidad']??0); $dineroVentas=(float)($f['total']??0); }

$sql="SELECT p.nombre,COUNT(*) AS cantidad FROM PEDIDOS p WHERE LOWER(TRIM(p.estado))='aceptado' GROUP BY p.nombre ORDER BY cantidad DESC,p.nombre ASC LIMIT 1";
if($r=$conn->query($sql)) $clienteFrecuente=$r->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panel Administrativo - Divine Beauty</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


<style>

/* =========================
   CONFIGURACIÓN GENERAL
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

:root{

    --rosa:#d96c8d;
    --rosa-oscuro:#b84f72;
    --rosa-claro:#fde7ef;

    --blanco:#ffffff;
    --crema:#fff8fa;

    --texto:#5b4b52;

}


/* =========================
   BODY
========================= */

body{

    background:
    linear-gradient(
        135deg,
        #fff7fa,
        #fdeef3,
        #fffafc
    );

    min-height:100vh;

    overflow-x:hidden;

}


/* =========================
   FONDOS DECORATIVOS
========================= */

body::before{

    content:'';

    position:fixed;

    width:500px;
    height:500px;

    border-radius:50%;

    background:#f7bfd0;

    filter:blur(180px);

    opacity:.4;

    top:-150px;
    right:-100px;

    animation:float 10s infinite ease-in-out;

    pointer-events:none;

}


body::after{

    content:'';

    position:fixed;

    width:400px;
    height:400px;

    border-radius:50%;

    background:#f48fb1;

    filter:blur(180px);

    opacity:.25;

    bottom:-100px;
    left:-100px;

    animation:float 12s infinite ease-in-out;

    pointer-events:none;

}


/* =========================
   CONTENEDOR PRINCIPAL
========================= */

.contenedor{

    display:flex;

    gap:30px;

    padding:40px;

    position:relative;

    z-index:1;

}


/* =========================
   PERFIL
========================= */

.sidebar{

    width:320px;

    flex-shrink:0;

}


.perfil{

    background:
    linear-gradient(
        180deg,
        var(--rosa),
        var(--rosa-oscuro)
    );

    color:white;

    border-radius:35px;

    padding:35px;

    text-align:center;

    box-shadow:
    0 20px 40px rgba(217,108,141,.3);

    animation:slideLeft 1s ease;

    position:relative;

    overflow:hidden;

}


.perfil img{

    width:140px;
    height:140px;

    border-radius:50%;

    object-fit:cover;

    border:5px solid rgba(255,255,255,.4);

    transition:.5s;

}


.perfil img:hover{

    transform:scale(1.08);

}


.perfil h2{

    margin-top:20px;

}


.cargo{

    margin-top:15px;

    background:white;

    color:var(--rosa-oscuro);

    padding:10px 18px;

    border-radius:30px;

    font-weight:600;

    display:inline-block;

}


.info{

    margin-top:25px;

    line-height:2;

}


/* =========================
   BOTÓN CERRAR SESIÓN
========================= */

.botones-perfil{

    margin-top:30px;

    display:flex;

    justify-content:center;

}


.botones-perfil a{

    text-decoration:none;

    padding:13px 22px;

    border-radius:30px;

    font-weight:600;

    display:inline-block;

    transition:.3s;

}


.btn-cerrar{

    background:#ff4d6d;

    color:white;

}


.btn-cerrar:hover{

    background:#e63956;

    transform:translateY(-3px);

}


/* =========================
   PANEL PRINCIPAL
========================= */

.panel{

    flex:1;

    min-width:0;

}


/* =========================
   BIENVENIDA
========================= */

.bienvenida{

    background:white;

    padding:30px;

    border-radius:25px;

    box-shadow:
    0 10px 25px rgba(0,0,0,.05);

    animation:fadeUp .8s ease;

}


.bienvenida h1{

    color:var(--rosa-oscuro);

}


.bienvenida p{

    color:var(--texto);

    margin-top:10px;

}


/* =========================
   MÓDULOS
========================= */

.modulos{

    display:grid;

    /*
       6 columnas permiten hacer:

       3 tarjetas arriba
       2 tarjetas centradas abajo
    */

    grid-template-columns:
    repeat(6, 1fr);

    gap:30px;

    margin-top:30px;

}


/* =========================
   TARJETAS / BOTONES
========================= */

.modulo{

    background:white;

    min-height:230px;

    border-radius:30px;

    box-shadow:
    0 10px 25px rgba(0,0,0,.05);

    transition:
    transform .4s ease,
    box-shadow .4s ease;

    overflow:hidden;

}


/* PRIMERA FILA */

.modulo:nth-child(1){

    grid-column:
    span 2;

}


.modulo:nth-child(2){

    grid-column:
    span 2;

}


.modulo:nth-child(3){

    grid-column:
    span 2;

}


/* SEGUNDA FILA CENTRADA */

.modulo:nth-child(4){

    grid-column:
    2 / span 2;

}


.modulo:nth-child(5){

    grid-column:
    4 / span 2;

}


/* =========================
   ENLACE COMPLETO
========================= */

.modulo a{

    width:100%;
    height:100%;

    min-height:230px;

    padding:25px;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    text-align:center;

    text-decoration:none;

    color:var(--texto);

    cursor:pointer;

}


/* =========================
   IMÁGENES DE LOS BOTONES
========================= */

.modulo img{

    width:100px;

    height:100px;

    object-fit:contain;

    margin-bottom:20px;

    transition:
    transform .4s ease;

}


/* =========================
   TÍTULO DEL BOTÓN
========================= */

.modulo h3{

    color:var(--rosa-oscuro);

    font-size:1.2rem;

    font-weight:600;

}


/* =========================
   EFECTO HOVER
========================= */

.modulo:hover{

    transform:
    translateY(-10px);

    box-shadow:
    0 20px 40px
    rgba(217,108,141,.25);

}


.modulo:hover img{

    transform:
    scale(1.1);

}


/* =========================
   MENSAJE INFERIOR
========================= */

.mensaje{

    margin-top:30px;

    background:
    linear-gradient(
        135deg,
        var(--rosa),
        #f48fb1
    );

    color:white;

    padding:40px;

    border-radius:30px;

    box-shadow:
    0 15px 40px
    rgba(217,108,141,.3);

    animation:fadeUp 1s ease;

}


.mensaje p{

    margin-top:15px;

    line-height:1.8;

}



/* =========================
   INFORMES DEL ADMINISTRADOR
========================= */
/* =========================
   INFORMES DEL ADMINISTRADOR
========================= */
.informes-admin-section{
    margin-top:32px;
    padding:30px;
    background:rgba(255,255,255,.72);
    border:1px solid rgba(227,197,205,.75);
    border-radius:32px;
    box-shadow:0 18px 45px rgba(143,83,98,.08);
    backdrop-filter:blur(8px);
}

.informe-cabecera{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:24px;
}

.informe-titulo{
    margin:0;
    color:var(--rosa-oscuro);
    font-size:1.35rem;
    font-weight:700;
}

.informe-subtitulo{
    margin-top:5px;
    color:#8a727a;
    font-size:.84rem;
}

.informe-badge{
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:9px 14px;
    border-radius:30px;
    background:#fff;
    border:1px solid #ead7dc;
    color:var(--vino);
    font-size:.78rem;
    font-weight:600;
    white-space:nowrap;
}

.informes-admin{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
}

.informe-card{
    min-height:190px;
    background:linear-gradient(145deg,#ffffff 0%,#fffafb 100%);
    border:1px solid #ead7dc;
    border-radius:25px;
    padding:22px;
    box-shadow:0 10px 25px rgba(143,83,98,.07);
    transition:transform .3s ease,box-shadow .3s ease,border-color .3s ease;
    position:relative;
    overflow:hidden;
}

.informe-card::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:100%;
    height:4px;
    background:linear-gradient(90deg,var(--rosa),var(--rosa-claro),#f3a8bc);
}

.informe-card::after{
    content:"";
    position:absolute;
    width:95px;
    height:95px;
    border-radius:50%;
    background:rgba(217,166,178,.13);
    right:-38px;
    bottom:-42px;
}

.informe-card:hover{
    transform:translateY(-7px);
    box-shadow:0 18px 34px rgba(143,83,98,.14);
    border-color:#d9a6b2;
}

.informe-link{
    display:block;
    text-decoration:none;
    color:inherit;
    cursor:pointer;
}

.informe-link:hover .informe-ir{
    transform:translateX(4px);
}

.informe-icon{
    width:50px;
    height:50px;
    border-radius:17px;
    background:var(--rosa-palido);
    border:1px solid #f0d4dc;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:23px;
    margin-bottom:15px;
    box-shadow:0 7px 16px rgba(184,111,128,.08);
}

.informe-card h3{
    color:var(--vino-oscuro);
    font-size:.98rem;
    font-weight:600;
    margin-bottom:7px;
}

.informe-numero{
    display:block;
    color:var(--texto);
    font-size:1.7rem;
    line-height:1.2;
    font-weight:700;
    margin-bottom:7px;
    word-break:break-word;
}

.informe-detalle{
    color:#8a727a;
    font-size:.81rem;
    line-height:1.55;
}

.informe-detalle strong{
    color:var(--vino);
}

.informe-alerta{
    background:linear-gradient(145deg,#fff8fa,#fff1f5);
    border-color:#efc6d2;
}

.informe-alerta .informe-icon{
    background:#fde1e9;
}

.informe-destacado{
    grid-column:span 2;
}

.informe-stock-boton{
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.informe-ir{
    position:relative;
    z-index:2;
    display:inline-flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-top:16px;
    padding:10px 13px;
    border-radius:14px;
    background:var(--rosa-palido);
    color:var(--vino-oscuro);
    font-size:.78rem;
    font-weight:700;
    transition:transform .25s ease,background .25s ease;
}

.informe-stock-boton:hover .informe-ir{
    background:#f3d3dc;
}

.informe-ir span{
    font-size:1rem;
}

@media screen and (max-width:1100px){
    .informes-admin{grid-template-columns:repeat(2,1fr)}
}

@media screen and (max-width:767px){
    .informes-admin-section{padding:22px}
    .informe-cabecera{align-items:flex-start;flex-direction:column}
    .informes-admin{grid-template-columns:1fr}
    .informe-destacado{grid-column:auto}
}

/* =========================
   ANIMACIONES
========================= */

@keyframes fadeUp{

    from{

        opacity:0;

        transform:
        translateY(30px);

    }

    to{

        opacity:1;

        transform:
        translateY(0);

    }

}


@keyframes slideLeft{

    from{

        opacity:0;

        transform:
        translateX(-50px);

    }

    to{

        opacity:1;

        transform:
        translateX(0);

    }

}


@keyframes float{

    0%,
    100%{

        transform:
        translateY(0);

    }

    50%{

        transform:
        translateY(-20px);

    }

}


/* =========================
   BRILLO ANIMADO DEL PERFIL
========================= */

.perfil::before{

    content:"";

    position:absolute;

    top:0;

    left:-150%;

    width:70%;

    height:100%;

    background:
    linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,.35),
        transparent
    );

    transform:
    skewX(-25deg);

    animation:
    brillo 5s infinite;

}


@keyframes brillo{

    0%{

        left:-150%;

    }

    100%{

        left:200%;

    }

}


/* =========================
   TABLETS
========================= */

@media screen and (max-width:1024px){

    .contenedor{

        flex-direction:column;

        padding:25px;

        gap:25px;

    }


    .sidebar{

        width:100%;

    }


    .perfil{

        padding:30px;

    }


    .perfil img{

        width:120px;

        height:120px;

    }


    .panel{

        width:100%;

    }


    /*
       En tablet mantenemos
       3 arriba y 2 abajo
    */

    .modulos{

        grid-template-columns:
        repeat(6,1fr);

    }


    .bienvenida h1{

        font-size:1.8rem;

    }


    .mensaje{

        padding:30px;

    }

}


/* =========================
   CELULARES
========================= */

@media screen and (max-width:767px){

    body::before,
    body::after{

        display:none;

    }


    .contenedor{

        padding:15px;

        gap:20px;

    }


    .sidebar{

        width:100%;

    }


    .perfil{

        padding:25px 20px;

        border-radius:25px;

    }


    .perfil img{

        width:100px;

        height:100px;

    }


    .perfil h2{

        font-size:1.2rem;

    }


    .cargo{

        font-size:.9rem;

        padding:8px 15px;

    }


    .info{

        font-size:.9rem;

        line-height:1.8;

    }


    .bienvenida{

        padding:20px;

        border-radius:20px;

    }


    .bienvenida h1{

        font-size:1.5rem;

    }


    .bienvenida p{

        font-size:.95rem;

    }


    /*
       En celular se colocan
       una debajo de otra
    */

    .modulos{

        grid-template-columns:1fr;

        gap:18px;

    }


    .modulo:nth-child(1),
    .modulo:nth-child(2),
    .modulo:nth-child(3),
    .modulo:nth-child(4),
    .modulo:nth-child(5){

        grid-column:
        auto;

    }


    .modulo{

        min-height:210px;

        border-radius:20px;

    }


    .modulo a{

        min-height:210px;

        padding:20px;

    }


    .modulo img{

        width:80px;

        height:80px;

        margin-bottom:15px;

    }


    .modulo h3{

        font-size:1.05rem;

    }


    .mensaje{

        padding:25px 20px;

        border-radius:20px;

        text-align:center;

    }


    .mensaje h2{

        font-size:1.3rem;

    }


    .mensaje p{

        font-size:.95rem;

    }


    .botones-perfil{

        flex-direction:column;

        gap:10px;

    }


    .btn-cerrar{

        width:100%;

        text-align:center;

    }

}


/* =========================
   CELULARES PEQUEÑOS
========================= */

@media screen and (max-width:480px){

    .perfil img{

        width:85px;

        height:85px;

    }


    .perfil h2{

        font-size:1.1rem;

    }


    .bienvenida h1{

        font-size:1.3rem;

    }


    .modulo h3{

        font-size:1rem;

    }


    .mensaje h2{

        font-size:1.15rem;

    }

}

</style>

</head>


<body>


<?php include 'submenuespecial.php'; ?>


<div class="contenedor">


    <!-- =========================
         PERFIL DEL USUARIO
    ========================== -->

    <aside class="sidebar">

        <div class="perfil">

            <img
                src="./imagenes/admin.jpg"
                alt="Administrador"
            >


            <h2>
                <?php
                echo $_SESSION['nombre'];
                ?>
            </h2>


            <div class="cargo">

                <?php
                echo $_SESSION['rol'];
                ?>

                GENERAL

            </div>


            <div class="info">

                <p>
                    CONTACTO:
                    <?php
                    echo $_SESSION['celular'];
                    ?>
                </p>


                <p>
                    DIRECCIÓN:
                    <?php
                    echo $_SESSION['direccion'];
                    ?>
                </p>


                <em>

                    <p>
                        "
                        <?php
                        echo $_SESSION['estado'];
                        ?>
                        "
                    </p>

                </em>


                <div class="botones-perfil">

                    <a
                        href="./SESIONES/logincerrarcliente.php"
                        class="btn-cerrar"
                    >

                        Cerrar sesión

                    </a>

                </div>

            </div>

        </div>

    </aside>


    <!-- =========================
         PANEL PRINCIPAL
    ========================== -->

    <main class="panel">


        <!-- BIENVENIDA -->

        <section class="bienvenida">
<center>
            <h1>

                Hola!!,
                <?php
                echo $_SESSION['nombre'];
                ?>

            </h1>

</center>
            <p>

                Administra usuarios, productos, pedidos,
                ventas y reportes desde un solo lugar.

            </p>

        </section>



        <!-- =========================
             MÓDULOS
        ========================== -->

        <section class="modulos">


            <!-- 1. GESTIONAR USUARIOS -->

            <div class="modulo">

                <a href="./CRUD-cliente/readtodocliente.php">
                <img src="./imagenes/gestion.svg"   alt="Gestionar Usuarios" >
                <h3>  Gestionar Usuarios  </h3>

                </a>

            </div>



            <!-- 2. GESTIONAR PRODUCTOS -->

            <div class="modulo">

                <a href="./CRUD-producto/readtodoprodu.php">

                    <img
                        src="./imagenes/registro.svg"
                        alt="Gestionar Productos"
                    >

                    <h3>
                        Gestionar Productos
                    </h3>

                </a>

            </div>



            <!-- 3. ASIGNAR ROLES -->

            <div class="modulo">

                <a href="./ROL-usuario/updaterol.php">

                    <img
                        src="./imagenes/roles.svg"
                        alt="Asignar Roles"
                    >

                    <h3>
                        Asignar Roles
                    </h3>

                </a>

            </div>



            <!-- 4. VISUALIZAR REPORTES -->

            <div class="modulo">

                <a href="./INTERFACES/interfazreportes.php">

                    <img
                        src="./imagenes/reportes.svg"
                        alt="Visualizar Reportes"
                    >

                    <h3>
                        Visualizar Reportes
                    </h3>

                </a>

            </div>



            <!-- 5. SUPERVISAR VENTAS Y PEDIDOS -->

            <div class="modulo">

                <a href="./INTERFACES/interfazventas-pedido.php">

                    <img
                        src="./imagenes/ventas.svg"
                        alt="Supervisar Ventas y Pedidos"
                    >

                    <h3>
                        Supervisar Ventas y Pedidos
                    </h3>

                </a>

            </div>


        </section>



        <!-- =========================
             MENSAJE INFORMATIVO
        ========================== -->

        <section class="mensaje">

            <h2>
                Panel Administrativo Empresarial
            </h2>


            <p>

                Gestionando la excelencia en cada proceso
                de Divine Beauty.

                Nuestro objetivo es garantizar una
                administración eficiente,

                supervisar operaciones y ofrecer una
                experiencia de calidad.

            </p>

        </section>


    

        <!-- =========================
             INFORMES Y ALERTAS DEL ADMINISTRADOR
        ========================== -->
        <section class="informes-admin-section">

            <div class="informe-cabecera">
                <div>
                    <h2 class="informe-titulo">Informes importantes del negocio ✨</h2>
                    <p class="informe-subtitulo">Resumen general para supervisar DIVINE de un vistazo.</p>
                </div>
                <div class="informe-badge">📊 Panel de control</div>
            </div>

            <div class="informes-admin">

                <div class="informe-card">
                    <div class="informe-icon">👥</div>
                    <h3>Clientes registrados</h3>
                    <span class="informe-numero"><?php echo $totalClientes; ?></span>
                    <p class="informe-detalle"><strong><?php echo $clientesActivos; ?></strong> clientes activos actualmente.</p>
                </div>

                <div class="informe-card">
                    <div class="informe-icon">📦</div>
                    <h3>Productos registrados</h3>
                    <span class="informe-numero"><?php echo $totalProductos; ?></span>
                    <p class="informe-detalle">Productos disponibles en el catálogo de DIVINE.</p>
                </div>

                <!-- STOCK BAJO: TARJETA CONVERTIDA EN BOTÓN -->
                <a href="./CRUD-producto/stock_bajo.php" class="informe-card informe-alerta informe-link informe-stock-boton">
                    <div>
                        <div class="informe-icon">⚠️</div>
                        <h3>Stock bajo</h3>
                        <span class="informe-numero"><?php echo $stockBajo; ?></span>
                        <p class="informe-detalle">Productos con <strong>5 unidades o menos</strong> que requieren revisión.</p>
                    </div>
                    <div class="informe-ir">
                        <span>Revisar productos con stock bajo</span>
                        <span>→</span>
                    </div>
                </a>

                <div class="informe-card">
                    <div class="informe-icon">🛍️</div>
                    <h3>Pedidos aceptados</h3>
                    <span class="informe-numero"><?php echo $pedidosAceptados; ?></span>
                    <p class="informe-detalle"><strong><?php echo $pedidosPendientes; ?></strong> pedidos permanecen pendientes.</p>
                </div>

                <div class="informe-card informe-destacado">
                    <div class="informe-icon">💰</div>
                    <h3>Ventas registradas</h3>
                    <span class="informe-numero"><?php echo $totalVentas; ?></span>
                    <p class="informe-detalle">Ventas relacionadas con pedidos <strong>Aceptados</strong>. Recaudación total: <strong>Bs. <?php echo number_format($dineroVentas,2,'.',','); ?></strong>.</p>
                </div>

                <div class="informe-card informe-destacado">
                    <div class="informe-icon">🏆</div>
                    <h3>Cliente con más pedidos aceptados</h3>
                    <?php if($clienteFrecuente): ?>
                        <span class="informe-numero"><?php echo htmlspecialchars($clienteFrecuente['nombre']); ?></span>
                        <p class="informe-detalle"><strong><?php echo (int)$clienteFrecuente['cantidad']; ?></strong> pedido(s) aceptado(s). Es el cliente con mayor frecuencia de compra.</p>
                    <?php else: ?>
                        <span class="informe-numero">Sin datos</span>
                        <p class="informe-detalle">Todavía no existen pedidos aceptados.</p>
                    <?php endif; ?>
                </div>

                <div class="informe-card informe-destacado <?php echo $productoStock ? 'informe-alerta' : ''; ?>">
                    <div class="informe-icon">📊</div>
                    <h3>Producto que requiere atención</h3>
                    <?php if($productoStock): ?>
                        <span class="informe-numero"><?php echo htmlspecialchars($productoStock['nombre']); ?></span>
                        <p class="informe-detalle">Código: <strong><?php echo htmlspecialchars($productoStock['codigo']); ?></strong> · Stock actual: <strong><?php echo (int)$productoStock['stock']; ?> unidades</strong>.</p>
                    <?php else: ?>
                        <span class="informe-numero">Stock estable</span>
                        <p class="informe-detalle">No hay productos con stock igual o menor a 5.</p>
                    <?php endif; ?>
                </div>

                <div class="informe-card">
                    <div class="informe-icon">📋</div>
                    <h3>Total de pedidos</h3>
                    <span class="informe-numero"><?php echo $totalPedidos; ?></span>
                    <p class="informe-detalle">Todos los pedidos registrados, sin importar su estado.</p>
                </div>

            </div>
        </section>

</main>


</div>


<?php include 'submenpiepag.php'; ?>


</body>

</html>