 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor, $usuario, $contraseña, $nombreBD);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eliminar Producto - DIVINE</title>

<!-- TIPOGRAFÍA -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet"/>

<style>

/* =========================
   ESTILO DIVINE
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI', sans-serif;
    background:#f8eef0;
    color:#333;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:30px;
}

/* CONTENEDOR */

.contenedor{
    background:white;
    padding:50px;
    border-radius:30px;
    box-shadow:0 20px 40px rgba(0,0,0,.10);
    width:90%;
    max-width:700px;

    display:grid;
    grid-template-columns:1fr;

    grid-template-areas:
        "encabezado"
        "contenido"
        "botones";

    gap:30px;
    text-align:center;

    animation:entrada 1s ease-out;
}

/* ENCABEZADO */

.encabezado{
    grid-area:encabezado;

    font-family:Georgia, serif;
    font-size:40px;
    font-weight:700;

    color:#bf7485;
    letter-spacing:4px;
    text-transform:uppercase;

    padding-bottom:18px;

    border-bottom:3px solid #d89aa7;
}

/* CONTENIDO */

.contenido{
    grid-area:contenido;

    background:#f8eef0;

    border-radius:25px;
    padding:35px 30px;

    box-shadow:0 12px 25px rgba(0,0,0,.08);

    font-size:18px;

    border-left:8px solid #d89aa7;

    animation:contenidoEntrada .8s ease-out;
}

/* MENSAJES */

.mensaje{
    border-radius:20px;
    padding:25px;

    font-weight:600;
    font-size:18px;

    margin-bottom:10px;

    box-shadow:0 8px 20px rgba(0,0,0,.10);

    animation:mensajeEntrada .8s ease-out;
}

/* ÉXITO */

.exito{
    background:linear-gradient(
        135deg,
        #ebbcc6,
        #c7909d
    );

    color:white;

    box-shadow:0 8px 20px rgba(201,111,132,.35);
}

/* ERROR */

.error{
    background:#b45d72;

    color:white;

    box-shadow:0 8px 20px rgba(180,93,114,.35);
}

/* BOTONES */

.botones{
    grid-area:botones;

    display:flex;
    justify-content:center;
}

.boton{
    text-decoration:none;

    background:#c96f84;
    color:white;

    padding:15px 35px;

    border-radius:50px;

    font-weight:bold;
    font-size:17px;

    box-shadow:0 8px 20px rgba(201,111,132,.35);

    transition:.4s;

    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.boton:hover{
    background:#b45d72;

    transform:translateY(-3px);

    box-shadow:0 12px 25px rgba(180,93,114,.40);
}

/* ANIMACIONES */

@keyframes entrada{

    from{
        opacity:0;
        transform:scale(.95) translateY(30px);
    }

    to{
        opacity:1;
        transform:scale(1) translateY(0);
    }

}

@keyframes contenidoEntrada{

    from{
        opacity:0;
        transform:translateY(25px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

@keyframes mensajeEntrada{

    from{
        opacity:0;
        transform:translateY(15px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

/* RESPONSIVE */

@media (max-width:600px){

    body{
        padding:20px;
    }

    .contenedor{
        width:100%;
        padding:30px 20px;
    }

    .encabezado{
        font-size:28px;
        letter-spacing:2px;
    }

    .contenido{
        padding:25px 20px;
        font-size:16px;
    }

    .mensaje{
        padding:20px 15px;
        font-size:16px;
    }

    .botones{
        flex-direction:column;
        gap:15px;
    }

    .boton{
        width:100%;
    }

}
</style>
</head>

<body>
  <div class="contenedor">
    
    <div class="encabezado">Producto Eliminado</div>

    <div class="contenido">

<?php
if ($conn->connect_error) {
    echo "<div class='mensaje error'>❌ NO SE PUDO CONECTAR A LA BASE DE DATOS</div>";
}

$codigo = $_GET['codigo'];
$sql = "DELETE FROM PRODUCTO WHERE codigo=$codigo";

if ($conn->query($sql) === TRUE) {
    echo "<div class='mensaje exito'>✔ EL PRODUCTO HA SIDO ELIMINADO  </div>";
} else {
    echo "<div class='mensaje error'>⚠ ERROR AL ELIMINAR EL PRODUCTO</div>";
}
?>
    </div>

    <div class="botones">
      <a href="readtodoprodu.php" class="boton">⬅ Volver a productos</a>
    </div>

  </div>
</body>
</html>
