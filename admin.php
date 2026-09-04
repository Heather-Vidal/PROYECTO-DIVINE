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
        window.location.href = '../SESIONES/loginformcliente.php';
    </script>";

    exit();
}

 

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

                <a href="./REPORTES/reportes.php">

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

                <a href="interfazventas-pedido.php">

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


    </main>


</div>


<?php include 'submenpiepag.php'; ?>


</body>

</html>