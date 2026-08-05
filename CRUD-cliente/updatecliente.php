 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Cliente - DIVINE</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
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
    background:white;
    border-radius:30px;
    box-shadow:0 20px 40px rgba(0,0,0,.12);
    overflow:hidden;
    animation:entrada .8s ease;
}

.encabezado{
    background:linear-gradient(135deg,#ebbcc6,#c7909d);
    color:white;
    text-align:center;
    font-size:38px;
    font-family:Georgia,serif;
    letter-spacing:5px;
    padding:30px;
}

.contenido{
    padding:45px;
    text-align:center;
}

.icono{
    width:140px;
    margin-bottom:25px;
    transition:.4s;
}

.icono:hover{
    transform:scale(1.08);
}

.mensaje{
    padding:20px;
    border-radius:18px;
    font-size:18px;
    font-weight:bold;
    margin-top:15px;
    box-shadow:0 8px 18px rgba(0,0,0,.08);
}

.exito{
    background:#d89aa7;
    color:white;
}

.error{
    background:#d9534f;
    color:white;
}

.botones{
    padding:35px;
    display:flex;
    justify-content:center;
    gap:20px;
    background:#fff7f9;
    flex-wrap:wrap;
}

.boton{
    text-decoration:none;
    background:#c96f84;
    color:white;
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
    width:110px;
}

.botones{
    padding:25px;
    flex-direction:column;
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
    
    <div class="encabezado">Modificado!</div>

    <div class="contenido">

      <img src="https://cdn-icons-png.flaticon.com/512/3106/3106921.png" class="icono">

<?php

if($conn->connect_error){
    echo '<div class="mensaje error">❌ No se pudo conectar con la base de datos</div>';
}

$CI= $_POST['CI'];
$nombre= $_POST['nombre'];
$direccion= $_POST['direccion'];
$celular= $_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];

$sql="UPDATE CLIENTE SET nombre='$nombre',direccion='$direccion',celular='$celular',rol='$rol',estado='$estado' WHERE CI=$CI";

if ($conn->query($sql)=== TRUE){
    echo '<div class="mensaje exito">✔ El cliente se modificó exitosamente</div>';
} else {
    echo '<div class="mensaje error">❌ No se pudo guardar la modificación</div>';
}

?>

    </div>

    <div class="botones">
      <a href="paginaprinc2.php" class="boton">⬅ Volver al inicio</a>
      <a href="readtodocliente.php" class="boton">Ver clientes ➡</a>
    </div>

  </div>

</body>
</html>
