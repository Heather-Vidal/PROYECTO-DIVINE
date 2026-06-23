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
<title>Panel Administrativo - Divine Beauty</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

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

body{
    background:linear-gradient(
    135deg,
    #fff7fa,
    #fdeef3,
    #fffafc
    );
    min-height:100vh;
    overflow-x:hidden;
}

/* FONDOS DECORATIVOS */

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
}

.logo{
    font-size:1.5rem;
    font-weight:700;
    color:var(--rosa-oscuro);
}

nav{
    display:flex;
    gap:25px;
}

nav a{
    text-decoration:none;
    color:var(--texto);
    transition:.3s;
}

nav a:hover{
    color:var(--rosa);
}

.admin-btn{
    background:var(--rosa);
    color:white;
    border:none;
    padding:12px 22px;
    border-radius:30px;
    cursor:pointer;
    transition:.4s;
}

.admin-btn:hover{
    background:var(--rosa-oscuro);
    transform:translateY(-3px);
}

/* CONTENEDOR */

.contenedor{
    display:flex;
    gap:30px;
    padding:40px;
}

/* PERFIL */

.sidebar{
    width:320px;
}

.perfil{
    background:linear-gradient(
    180deg,
    var(--rosa),
    var(--rosa-oscuro)
    );

    color:white;

    border-radius:35px;
    padding:35px;
    text-align:center;

    box-shadow:0 20px 40px rgba(217,108,141,.3);

    animation:slideLeft 1s ease;
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

/* PANEL */

.panel{
    flex:1;
}

/* BIENVENIDA */

.bienvenida{
    background:white;
    padding:30px;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
    animation:fadeUp .8s ease;
}

.bienvenida h1{
    color:var(--rosa-oscuro);
}

.bienvenida p{
    color:var(--texto);
    margin-top:10px;
}

/* ESTADÍSTICAS */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:20px;
    margin-top:25px;
}

.stat{
    background:white;
    padding:25px;
    text-align:center;
    border-radius:25px;
    transition:.4s;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.stat:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 40px rgba(217,108,141,.25);
}

.stat h2{
    color:var(--rosa);
    font-size:2rem;
}

.stat p{
    color:var(--texto);
}

/* MÓDULOS */

.modulos{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
    margin-top:30px;
}

.modulo{
    background:white;
    padding:25px;
    border-radius:25px;
    transition:.4s;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.modulo:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 40px rgba(217,108,141,.25);
}

.modulo h3{
    color:var(--rosa-oscuro);
    margin-bottom:20px;
}

.links{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.links a{
    text-decoration:none;
    background:var(--rosa-claro);
    color:var(--rosa-oscuro);
    padding:10px 16px;
    border-radius:30px;
    transition:.3s;
}

.links a:hover{
    background:var(--rosa);
    color:white;
}

/* MENSAJE */

.mensaje{
    margin-top:30px;

    background:linear-gradient(
    135deg,
    var(--rosa),
    #f48fb1
    );

    color:white;

    padding:40px;

    border-radius:30px;

    box-shadow:0 15px 40px rgba(217,108,141,.3);

    animation:fadeUp 1s ease;
}

.mensaje p{
    margin-top:15px;
    line-height:1.8;
}

/* FOOTER */


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

@media(max-width:900px){

    .contenedor{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
    }

    nav{
        display:none;
    }

    footer{
        flex-direction:column;
        text-align:center;
        gap:10px;
    }
}
/* =========================
   TABLETS
========================= */
@media screen and (max-width: 1024px){

    .contenedor{
        flex-direction: column;
        padding: 25px;
        gap: 25px;
    }

    .sidebar{
        width: 100%;
    }

    .perfil{
        padding: 30px;
    }

    .perfil img{
        width: 120px;
        height: 120px;
    }

    .panel{
        width: 100%;
    }

    .modulos{
        grid-template-columns: repeat(2,1fr);
    }

    .bienvenida h1{
        font-size: 1.8rem;
    }

    .mensaje{
        padding: 30px;
    }
}


/* =========================
   CELULARES
========================= */
@media screen and (max-width: 767px){

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

    .modulos{
        grid-template-columns:1fr;
        gap:18px;
    }

    .modulo{
        padding:20px;
        border-radius:20px;
    }

    .modulo h3{
        font-size:1.05rem;
        text-align:center;
    }

    .links{
        justify-content:center;
    }

    .links a{
        width:100%;
        text-align:center;
        padding:12px;
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

    nav{
        display:none;
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
.perfil{
    position: relative;
    overflow: hidden;
}

/* Brillo animado */
.perfil::before{
    content:"";
    position:absolute;
    top:0;
    left:-150%;
    width:70%;
    height:100%;

    background:linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,.35),
        transparent
    );

    transform:skewX(-25deg);

    animation: brillo 5s infinite;
}

@keyframes brillo{
    0%{
        left:-150%;
    }

    100%{
        left:200%;
    }
}
</style>
</head>

<body>

<?php include 'submenu.php'; ?>

<div class="contenedor">

    <aside class="sidebar">

        <div class="perfil">
            <img src="./imagenes/admin.jpg" alt="Administrador">
            <h2><?php echo $_SESSION['nombre']?></h2>
            <div class="cargo">
                <?php echo $_SESSION['rol']?> GENERAL
            </div>
        <div class="info">
<p>CONTACTO: <?php echo $_SESSION['celular']?></p>
<p>DIRECCIÓN: <?php echo $_SESSION['direccion']?></p>
<em>
<p>" <?php echo $_SESSION['estado']?>"</p>
</em>
<div class="botones-perfil">
<a href="./SESIONES/logincerrarcliente.php"
class="btn-cerrar">
Cerrar sesión
</a>
</div>

</div>

        </div>

    </aside>

    <main class="panel">

        <section class="bienvenida">

            <h1>Bienvenida, <?php echo $_SESSION['nombre']?> </h1>

            <p>
                Administra usuarios, productos, pedidos,
                ventas y reportes desde un solo lugar.
            </p>

        </section>

     
      

        <section class="modulos">

            <div class="modulo">
                <h3>Gestionar Usuarios</h3>

                <div class="links">
                    <a href="formcliente.php">Crear</a>
                    <a href="updatecliente.php">Editar</a>
                    <a href="deletecliente.php">Eliminar</a>
                </div>
            </div>

            <div class="modulo">
                <h3> Gestionar Productos</h3>

                <div class="links">
                    <a href="formularioprodu.php">Registrar</a>
                    <a href="update.php">Editar</a>
                    <a href="deleteprodu.php">Eliminar</a>
                </div>
            </div>

            <div class="modulo">
                <h3> Asignar Roles</h3>

                <div class="links">
                    <a href="#">Administrador</a>
                    <a href="perfilvendedor.php">Vendedor</a>
                </div>
            </div>

            <div class="modulo">
                <h3> Visualizar Reportes</h3>
            </div>

            <div class="modulo">
                <h3> Supervisar Ventas y Pedidos</h3>
            </div>

        </section>

        <section class="mensaje">

            <h2>Panel Administrativo Empresarial</h2>

            <p>
                Gestionando la excelencia en cada proceso de Divine Beauty.
                Nuestro objetivo es garantizar una administración eficiente,
                supervisar operaciones y ofrecer una experiencia de calidad.
            </p>

        </section>

    </main>
 
</div>
 
 <?php include 'submenpiepag.php'; ?>
</body>
</html>


 