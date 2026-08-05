<?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eliminar Cliente - DIVINE</title>

<!-- TIPOGRAFÍA -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f8eef0;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    color:#333;
    padding:30px;
}

.contenedor{
    width:100%;
    max-width:700px;
    background:#ffffff;
    border-radius:30px;
    box-shadow:0 20px 40px rgba(0,0,0,.12);
    overflow:hidden;
    animation:entrada .8s ease;
}

.encabezado{
    grid-area:encabezado;
    background:linear-gradient(135deg,#ebbcc6,#c7909d);
    color:#fff;
    text-align:center;
    font-size:38px;
    font-family:"Playfair Display",serif;
    letter-spacing:4px;
    padding:30px;
}

.contenido{
    grid-area:contenido;
    padding:45px;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
}

.icono{
    width:150px;
    margin-bottom:25px;
    transition:.4s;
}

.icono:hover{
    transform:scale(1.08);
}

.mensaje{
    width:100%;
    max-width:480px;
    padding:20px;
    border-radius:18px;
    font-size:18px;
    font-weight:bold;
    margin-top:15px;
    box-shadow:0 8px 18px rgba(0,0,0,.08);
}

.exito{
    background:#d89aa7;
    color:#fff;
}

.error{
    background:#d9534f;
    color:#fff;
}

.botones{
    grid-area:botones;
    padding:35px;
    display:flex;
    justify-content:center;
    background:#fff7f9;
}

.boton{
    text-decoration:none;
    background:#c96f84;
    color:#fff;
    padding:15px 40px;
    border-radius:50px;
    font-weight:bold;
    font-size:17px;
    transition:.35s;
    box-shadow:0 8px 20px rgba(201,111,132,.35);
}

.boton:hover{
    background:#b45d72;
    transform:translateY(-4px);
}

@keyframes entrada{
    from{
        opacity:0;
        transform:translateY(40px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

@media(max-width:700px){

    .contenedor{
        width:95%;
    }

    .encabezado{
        font-size:30px;
        padding:25px;
    }

    .contenido{
        padding:30px 20px;
    }

    .icono{
        width:120px;
    }

    .botones{
        padding:25px;
    }

    .boton{
        width:100%;
        text-align:center;
    }
}
</style>
</head>

<body>
  <div class="contenedor">
    
    <div class="encabezado">Cliente Eliminado</div>

    <div class="contenido">
      
      <!-- Imagen como en los otros ejemplos -->
      <img src="../imagenes/personaform.png" class="icono">

<?php
if($conn->connect_error){
  echo "<div class='mensaje error'>❌ OCURRIÓ UN ERROR AL CONECTAR A LA BASE DE DATOS</div>";
} else {
    $CI = $_GET['CI'] ?? '';

    if($CI){
        $sql="DELETE FROM CLIENTE WHERE CI=$CI";

        if ($conn->query($sql)=== TRUE){
            echo "<div class='mensaje exito'>✔ EL CLIENTE HA SIDO ELIMINADO CON ÉXITO</div>";
        } else {
            echo "<div class='mensaje error'>⚠ ERROR AL ELIMINAR: ".$conn->error."</div>";
        }
    } else {
        echo "<div class='mensaje error'>❌ CI no especificado</div>";
    }
}

$conn->close();
?>
    </div>

    <div class="botones">
      <a href="readtodocliente.php" class="boton">⬅ Volver a clientes</a>
    </div>

  </div>
</body>
</html>
