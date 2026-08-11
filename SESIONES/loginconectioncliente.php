<?php
session_start();

/* Eliminar datos de una sesión anterior */
session_unset();

$conexion = mysqli_connect("localhost","root","","DIVINE");

if(!$conexion){
    die("Error de conexión");
}

$nombre = $_POST['nombre'];
$CI = $_POST['CI'];

$sql = "SELECT * FROM CLIENTE
        WHERE nombre='$nombre'
        AND CI='$CI'";

$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    // Crear la nueva sesión

// Comprobar si el usuario está bloqueado
if($fila['estado'] == "BLOQUEADO"){

    session_unset();
    session_destroy();

    echo "
    <h2 style='color:red;text-align:center;margin-top:50px;'>
        Tu cuenta se encuentra bloqueada.
    </h2>

    <div style='text-align:center;margin-top:20px;'>
        <a href='loginformcliente.php'>
            Volver al inicio de sesión
        </a>
    </div>
    ";

    exit();
}

// Crear la nueva sesión
$_SESSION['CI'] = $fila['CI'];
$_SESSION['nombre'] = $fila['nombre'];
$_SESSION['direccion'] = $fila['direccion'];
$_SESSION['estado'] = $fila['estado'];
$_SESSION['celular'] = $fila['celular'];
$_SESSION['rol'] = $fila['rol'];

if($_SESSION['rol'] == "vendedor"){

    header("Location: ../perfilvendedor.php");
    exit();

}


elseif($_SESSION['rol'] == "administrador"){

    header("Location: ../admin.php");
    exit();

}


else{

    echo "Este rol no existe.";

}

<<<<<<< Updated upstream
}else{
=======
  


else{
>>>>>>> Stashed changes

    // Destruir completamente cualquier sesión
    session_unset();
    session_destroy();

   
}


mysqli_close($conexion);
?>
<style>

@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Poppins',sans-serif;
    background:
    radial-gradient(circle at top left,#f8d7df 0%,transparent 35%),
    radial-gradient(circle at bottom right,#e8d5c4 0%,transparent 35%),
    linear-gradient(135deg,#fffaf5,#f6e8e3);
    overflow:hidden;
}

body::before{

    content:"";
    position:absolute;
    width:350px;
    height:350px;
    background:#efd0d8;
    border-radius:50%;
    top:-120px;
    right:-120px;
    opacity:.45;
    animation:mover 8s infinite alternate;

}

body::after{

    content:"";
    position:absolute;
    width:300px;
    height:300px;
    background:#e9d7c8;
    border-radius:50%;
    bottom:-120px;
    left:-100px;
    opacity:.45;
    animation:mover 10s infinite alternate-reverse;

}

.card{

    width:440px;
    padding:45px;
    text-align:center;
    border-radius:35px;
    background:rgba(255,255,255,.75);
    backdrop-filter:blur(20px);
    box-shadow:
    0 25px 60px rgba(130,90,100,.25);
    border:1px solid rgba(255,255,255,.8);

    animation:aparecer 1s ease;
    position:relative;
    z-index:2;

}

/* icono */

.icono{

    width:95px;
    height:95px;
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;

    background:

    linear-gradient(135deg,#d9a6b5,#c47b92);

    color:white;
    font-size:45px;
    box-shadow:
    0 15px 30px rgba(196,123,146,.35);
    margin-bottom:25px;
    animation:flotar 3s infinite;

}

h2{

    font-family:'Playfair Display',serif;
    font-size:38px;
    color:#9b596c;
    margin-bottom:18px;
}
p{
    color:#777;
    font-size:15px;
    line-height:1.8;
    margin-bottom:25px;
}

.error{

    background:#fff1f4;
    color:#ad526d;
    padding:18px;
    border-radius:20px;
    border:1px solid #efd0d8;
    font-weight:600;
    margin-bottom:30px;
}

.boton{
    display:block;

    width:100%;

    padding:16px;

    border-radius:50px;

    text-decoration:none;
    color:white;
    font-weight:600;
    font-size:16px;
    background:

    linear-gradient(135deg,#c98ca0,#a9617c);
    box-shadow:
    0 12px 25px rgba(169,97,124,.35);
    transition:.4s;
}
.boton:hover{

    transform:translateY(-5px);
    background:
    linear-gradient(135deg,#a9617c,#8c4d66);
    box-shadow:
    0 20px 35px rgba(169,97,124,.45);
}
@keyframes aparecer{

from{
opacity:0;
transform:translateY(50px) scale(.9);

}

to{

opacity:1;
transform:translateY(0) scale(1);
}

}

@keyframes flotar{

0%,100%{
transform:translateY(0);
}
50%{
transform:translateY(-10px);

}
}

@keyframes mover{
from{
transform:translate(0,0);
}
to{
transform:translate(40px,30px);
}

}

@media(max-width:500px){
.card{
width:90%;
padding:35px 25px;
}
h2{
font-size:32px;
}

}

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="card">

    <div class="icono">
        🔒
    </div>

    <h2>
       sesion cerrada
    </h2>

    <div class="error">
        usuario o contraseña incorrecta.
    </div>

    <p>
      vuelvelo a intentar.
    </p>

    <a href="loginformcliente.php" class="boton">
        Iniciar sesión nuevamente
    </a>

</div>
</body>
</html>