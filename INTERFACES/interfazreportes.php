 
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Supervisar - DIVINE</title>

<style>

/* ==================================================
   VARIABLES DE COLOR DIVINE
================================================== */

:root{

    --rosa:#b86f80;
    --rosa-claro:#d9a6b2;
    --rosa-palido:#f7e9ec;

    --crema:#fffaf8;
    --crema-oscuro:#fdf1f3;

    --texto:#57494c;
    --gris:#817679;

    --borde:#e3c5cd;

    --vino:#8f5362;
    --vino-oscuro:#713d4d;

    --blanco:#ffffff;

}


/* ==================================================
   RESET
================================================== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


/* ==================================================
   BODY
================================================== */

body{

    min-height:100vh;

    font-family:'Segoe UI', sans-serif;

    color:var(--texto);

    display:flex;

    justify-content:center;

    align-items:center;

    overflow:auto;

    position:relative;

    padding:40px 20px;

    background:

    linear-gradient(
        rgba(219,175,158,.72),
        rgba(247,233,236,.94)
    ),

    url("./imagenes/fondote.png");

    background-size:cover;

    background-position:center;

    background-attachment:fixed;

}


/* ==================================================
   DECORACIONES DEL FONDO
================================================== */

body::before{

    content:"";

    position:fixed;

    width:480px;

    height:480px;

    border-radius:50%;

    background:

    radial-gradient(
        circle,
        rgba(184,111,128,.22),
        rgba(184,111,128,0)
    );

    top:-230px;

    left:-190px;

    pointer-events:none;

}


body::after{

    content:"";

    position:fixed;

    width:500px;

    height:500px;

    border-radius:50%;

    background:

    radial-gradient(
        circle,
        rgba(113,61,77,.18),
        rgba(113,61,77,0)
    );

    bottom:-250px;

    right:-190px;

    pointer-events:none;

}


/* ==================================================
   PANEL PRINCIPAL
================================================== */

.panel{

    position:relative;

    z-index:2;

    width:850px;

    max-width:95%;

    padding:55px 60px;

    text-align:center;

    background:

    linear-gradient(
        145deg,
        rgba(255,250,248,.97),
        rgba(247,233,236,.95)
    );

    border:

    1px solid
    rgba(184,111,128,.30);

    border-radius:35px;

    box-shadow:

    0 30px 70px
    rgba(100,70,80,.25),

    inset 0 1px 0
    rgba(255,255,255,.95);

    backdrop-filter:blur(15px);

    animation:

    aparecer .8s ease;

}


/* ==================================================
   BRILLO SUPERIOR
================================================== */

.brillo{

    position:absolute;

    width:180px;

    height:180px;

    border-radius:50%;

    background:

    radial-gradient(
        circle,
        rgba(255,255,255,.65),
        rgba(255,255,255,0)
    );

    top:-80px;

    right:-70px;

    pointer-events:none;

}


/* ==================================================
   DECORACIÓN
================================================== */

.decoracion{

    width:75px;

    height:4px;

    margin:0 auto 25px;

    border-radius:20px;

    background:

    linear-gradient(
        90deg,
        var(--vino),
        var(--rosa-claro),
        var(--vino)
    );

    box-shadow:

    0 4px 12px
    rgba(184,111,128,.28);

}


/* ==================================================
   TEXTO PEQUEÑO
================================================== */

.pequeno{

    color:var(--rosa);

    font-size:.76rem;

    text-transform:uppercase;

    letter-spacing:5px;

    margin-bottom:12px;

    font-weight:700;

}


/* ==================================================
   TÍTULO
================================================== */

h1{

    font-family:Georgia,serif;

    font-size:clamp(
        2.1rem,
        5vw,
        3.5rem
    );

    font-weight:400;

    color:var(--vino-oscuro);

    letter-spacing:2px;

    margin-bottom:16px;

}


/* ==================================================
   SUBTÍTULO
================================================== */

.subtitulo{

    color:var(--gris);

    font-size:.95rem;

    line-height:1.7;

    max-width:530px;

    margin:0 auto 42px;

}


/* ==================================================
   CONTENEDOR DE BOTONES
================================================== */

.botones{

    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:18px;

    width:100%;

}


/* ==================================================
   BOTÓN GENERAL
================================================== */

.boton{

    position:relative;

    overflow:hidden;

    min-height:175px;

    padding:25px 18px;

    border-radius:22px;

    text-decoration:none;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    gap:14px;

    font-size:.92rem;

    font-weight:600;

    letter-spacing:.4px;

    transition:

    transform .3s ease,

    box-shadow .3s ease,

    border .3s ease;

}


/* ==================================================
   BOTÓN VENTAS
================================================== */

.ventas{

    color:white;

    background:

    linear-gradient(
        145deg,
        var(--vino-oscuro),
        var(--vino),
        var(--rosa)
    );

    box-shadow:

    0 12px 28px
    rgba(113,61,77,.28);

}


/* ==================================================
   BOTÓN CLIENTES
================================================== */

.clientes{

    color:var(--vino-oscuro);

    background:

    linear-gradient(
        145deg,
        var(--rosa-claro),
        #e7c5cd
    );

    border:

    1px solid
    rgba(143,83,98,.18);

    box-shadow:

    0 12px 28px
    rgba(184,111,128,.20);

}


/* ==================================================
   BOTÓN PRODUCTOS
================================================== */

.productos{

    color:var(--vino-oscuro);

    background:

    linear-gradient(
        145deg,
        #fffaf8,
        var(--rosa-palido)
    );

    border:

    1px solid
    rgba(184,111,128,.25);

    box-shadow:

    0 12px 28px
    rgba(184,111,128,.18);

}


/* ==================================================
   HOVER
================================================== */

.boton:hover{

    transform:

    translateY(-9px)
    scale(1.02);

}


/* ==================================================
   SOMBRA VENTAS
================================================== */

.ventas:hover{

    box-shadow:

    0 20px 40px
    rgba(113,61,77,.40);

}


/* ==================================================
   SOMBRA CLIENTES
================================================== */

.clientes:hover{

    box-shadow:

    0 20px 40px
    rgba(184,111,128,.32);

}


/* ==================================================
   SOMBRA PRODUCTOS
================================================== */

.productos:hover{

    box-shadow:

    0 20px 40px
    rgba(184,111,128,.30);

}


/* ==================================================
   BRILLO DE BOTONES
================================================== */

.boton::before{

    content:"";

    position:absolute;

    width:90px;

    height:220%;

    top:-60%;

    left:-130px;

    transform:rotate(25deg);

    background:

    rgba(255,255,255,.24);

    transition:

    left .6s ease;

}


.boton:hover::before{

    left:120%;

}


/* ==================================================
   ICONOS
================================================== */

.icono{

    width:58px;

    height:58px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:18px;

    font-size:26px;

    transition:

    transform .3s ease;

}


/* ==================================================
   ICONO VENTAS
================================================== */

.ventas .icono{

    background:

    rgba(255,255,255,.16);

    color:white;

}


/* ==================================================
   ICONO CLIENTES
================================================== */

.clientes .icono{

    background:

    rgba(113,61,77,.10);

    color:var(--vino);

}


/* ==================================================
   ICONO PRODUCTOS
================================================== */

.productos .icono{

    background:

    rgba(184,111,128,.12);

    color:var(--rosa);

}


/* ==================================================
   ANIMACIÓN ICONOS
================================================== */

.boton:hover .icono{

    transform:

    translateY(-3px)
    rotate(-3deg)
    scale(1.08);

}


/* ==================================================
   TEXTO DE BOTONES
================================================== */

.nombre-boton{

    font-size:1rem;

    font-weight:700;

}


.descripcion-boton{

    font-size:.72rem;

    line-height:1.5;

    opacity:.72;

    max-width:180px;

}


/* ==================================================
   ETIQUETA SUPERIOR DEL BOTÓN
================================================== */

.etiqueta{

    position:absolute;

    top:12px;

    right:12px;

    padding:5px 9px;

    border-radius:20px;

    font-size:.58rem;

    text-transform:uppercase;

    letter-spacing:1px;

    font-weight:700;

}


.ventas .etiqueta{

    background:rgba(255,255,255,.15);

    color:white;

}


.clientes .etiqueta{

    background:rgba(113,61,77,.08);

    color:var(--vino);

}


.productos .etiqueta{

    background:rgba(184,111,128,.10);

    color:var(--rosa);

}


/* ==================================================
   FRASE INFERIOR
================================================== */

.inferior{

    margin-top:38px;

    color:#a28d92;

    font-size:.72rem;

    letter-spacing:2px;

}


/* ==================================================
   ESTADO DEL SISTEMA
================================================== */

.estado-sistema{

    margin:28px auto 0;

    width:max-content;

    max-width:100%;

    display:flex;

    align-items:center;

    gap:8px;

    padding:8px 15px;

    border-radius:30px;

    background:rgba(255,255,255,.55);

    border:1px solid rgba(184,111,128,.15);

    color:#927c82;

    font-size:.65rem;

    letter-spacing:1px;

}


.punto{

    width:7px;

    height:7px;

    border-radius:50%;

    background:#72b693;

    box-shadow:

    0 0 0 4px
    rgba(114,182,147,.12);

}


/* ==================================================
   ANIMACIÓN
================================================== */

@keyframes aparecer{

    from{

        opacity:0;

        transform:

        translateY(35px)
        scale(.96);

    }

    to{

        opacity:1;

        transform:

        translateY(0)
        scale(1);

    }

}


/* ==================================================
   RESPONSIVE TABLET
================================================== */

@media(max-width:800px){

    .panel{

        padding:45px 30px;

    }


    .botones{

        grid-template-columns:

        repeat(2,1fr);

    }


    .productos{

        grid-column:

        span 2;

    }

}


/* ==================================================
   RESPONSIVE CELULAR
================================================== */

@media(max-width:600px){

    body{

        padding:25px 12px;

        align-items:flex-start;

    }


    .panel{

        width:100%;

        max-width:500px;

        padding:42px 20px;

        border-radius:27px;

        margin:auto;

    }


    h1{

        font-size:2.15rem;

        line-height:1.15;

    }


    .pequeno{

        letter-spacing:3px;

    }


    .subtitulo{

        font-size:.86rem;

        margin-bottom:30px;

    }


    .botones{

        grid-template-columns:1fr;

        gap:14px;

    }


    .productos{

        grid-column:auto;

    }


    .boton{

        min-height:145px;

    }


    .inferior{

        margin-top:28px;

    }

}


/* ==================================================
   CELULARES PEQUEÑOS
================================================== */

@media(max-width:380px){

    .panel{

        padding:35px 16px;

    }


    h1{

        font-size:1.9rem;

    }


    .icono{

        width:50px;

        height:50px;

        font-size:23px;

    }


    .boton{

        min-height:135px;

    }

}

</style>

</head>


<body>


<!-- ==================================================
     PANEL PRINCIPAL
================================================== -->

<div class="panel">


    <!-- BRILLO DECORATIVO -->

    <div class="brillo"></div>


    <!-- LÍNEA DECORATIVA -->

    <div class="decoracion"></div>


    <!-- TEXTO SUPERIOR -->

    <div class="pequeno">

        Panel de supervisión

    </div>


    <!-- TÍTULO -->

    <h1>

        ¿Qué reporte deseas supervisar?

    </h1>


    <!-- DESCRIPCIÓN -->

    <p class="subtitulo">

        Selecciona una opción para consultar
        y administrar la información de
        <strong>DIVINE</strong>.

    </p>


    <!-- ==================================================
         BOTONES
    ================================================== -->

    <div class="botones">


        <!-- ==============================================
             VENTAS
        =============================================== -->

        <a
            href="../REPORTES/reportes.php"
            class="boton ventas"
        >

            <span class="etiqueta">

                Reporte

            </span>


            <span class="icono">

                ✦

            </span>


            <span class="nombre-boton">

                Ventas totales

            </span>


            <span class="descripcion-boton">

                Consulta el historial
                y las ventas realizadas.

            </span>

        </a>


        <!-- ==============================================
             CLIENTES
        =============================================== -->

        <a
            href="../REPORTES/clientefrecuente.php"
            class="boton clientes"
        >

            <span class="etiqueta">

                Clientes

            </span>


            <span class="icono">

                ♡

            </span>


            <span class="nombre-boton">

                Clientes frecuentes

            </span>


            <span class="descripcion-boton">

                Consulta los clientes
                con mayor frecuencia de compra.

            </span>

        </a>


        <!-- ==============================================
             ESTADO DE PRODUCTOS
        =============================================== -->

        <a
            href="../REPORTES/reporteproductoventa.php"
            class="boton productos"
        >

            <span class="etiqueta">

                Inventario

            </span>


            <span class="icono">

                ♢

            </span>


            <span class="nombre-boton">

                Estado de productos

            </span>


            <span class="descripcion-boton">

                Consulta el stock y el producto más vendido.

            </span>

        </a>


    </div>


    <!-- ==================================================
         ESTADO DEL SISTEMA
    ================================================== -->

    <div class="estado-sistema">

        <span class="punto"></span>

        Sistema DIVINE activo

    </div>


    <!-- ==================================================
         TEXTO INFERIOR
    ================================================== -->

    <div class="inferior">

        DIVINE · BEAUTY & CARE

    </div>


</div>


</body>

</html>
 