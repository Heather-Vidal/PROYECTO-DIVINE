<?php

$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn = new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
    die("Error de conexión");
}

$idPedido = $_GET['idPedido'];

$sql = "SELECT * FROM PEDIDOS WHERE ID='$idPedido'";
$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    $fila = $resultado->fetch_assoc();

    $nombre = $fila['nombre'];
    $fecha = $fila['fecha'];
    $telefono = $fila['telefono'];
    $direccion = $fila['direccion'];
    $estado = $fila['estado'];
    $vendedor = $fila['nombrevendedor'];

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Pedido</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<style>

/* RESET */
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

/* FONDO */
body{
background:
linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)),
url('../imagenes/fondote.png');
background-position:center;
background-repeat:no-repeat;
background-size:cover;
background-attachment:fixed;
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
padding:30px;
}

/* TARJETA */
.contenedor{
background:rgba(255,255,255,.82);
backdrop-filter:blur(12px);
padding:40px;
width:100%;
max-width:480px;
border-radius:30px;
border:1px solid rgba(255,255,255,.6);
box-shadow:0 15px 35px rgba(0,0,0,.15);
animation:aparecer .7s ease;
}

/* ANIMACIÓN */
@keyframes aparecer{
from{
opacity:0;
transform:translateY(25px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* TÍTULO */
h2{
text-align:center;
color:#bf7485;
margin-bottom:30px;
font-size:28px;
letter-spacing:2px;
font-family:Georgia,serif;
}

/* LABEL */
label{
display:block;
margin-bottom:7px;
color:#666;
font-weight:600;
font-size:14px;
}

/* INPUTS */
input[type="text"],
input[type="date"]{
width:100%;
padding:13px 16px;
border:2px solid #f0d6dc;
border-radius:15px;
outline:none;
margin-bottom:18px;
transition:.3s;
font-size:15px;
color:#555;
background:rgba(255,255,255,.9);
}

input[type="text"]:focus,
input[type="date"]:focus{
border-color:#c96f84;
box-shadow:0 0 10px rgba(201,111,132,.25);
}

/* READONLY */
input[readonly]{
background:#fdf5f7;
color:#bf7485;
font-weight:bold;
cursor:not-allowed;
}

/* SELECT */
.select-contenedor{
position:relative;
margin-bottom:20px;
}

select{
width:100%;
padding:14px 45px 14px 16px;
border:2px solid #f0d6dc;
border-radius:15px;
outline:none;
background:#fffafa;
color:#66595c;
font-size:15px;
font-weight:600;
cursor:pointer;
appearance:none;
transition:.3s;
}

select:focus{
border-color:#c96f84;
box-shadow:0 0 10px rgba(201,111,132,.25);
background:#ffffff;
}

select option{
background:#fffafa;
color:#66595c;
font-size:15px;
}

/* FLECHA */
.select-contenedor::after{
content:"⌄";
position:absolute;
right:18px;
top:50%;
transform:translateY(-60%);
color:#c96f84;
font-size:22px;
font-weight:bold;
pointer-events:none;
}

/* BOTÓN */
input[type="submit"]{
width:100%;
background:#c96f84;
color:white;
border:none;
padding:14px;
border-radius:50px;
font-size:16px;
font-weight:bold;
cursor:pointer;
transition:.3s;
box-shadow:0 8px 20px rgba(201,111,132,.35);
}

input[type="submit"]:hover{
background:#b45d72;
transform:translateY(-3px);
box-shadow:0 12px 25px rgba(201,111,132,.45);
}

/* ERRORES */
.error{
color:#d85a5a;
font-size:13px;
margin-top:-12px;
margin-bottom:10px;
display:block;
}

/* RESPONSIVE */
@media(max-width:600px){

.contenedor{
padding:30px 25px;
border-radius:25px;
}

h2{
font-size:24px;
}

}

</style>
</head>

<body>

<div class="contenedor">

<h2>EDITAR PEDIDO</h2>

<form action="updatepedido.php" method="POST">

<input type="hidden" name="idPedido" value="<?= $idPedido ?>">

<label>Nombre:</label>
<input type="text" name="nombre" value="<?= $nombre ?>" required>

<label>Teléfono:</label>
<input type="text" name="telefono" value="<?= $telefono ?>" required>

<label>Dirección:</label>
<input type="text" name="direccion" value="<?= $direccion ?>" required>

<label for="estado">Estado:</label>

<div class="select-contenedor">

<select name="estado" id="estado" required>

<option value="" disabled>Selecciona el estado del pedido</option> 

<option value="proceso" <?= ($estado == 'proceso') ? 'selected' : '' ?>>Pendiente</option>

<option value="proceso" <?= ($estado == 'proceso') ? 'selected' : '' ?>>En proceso</option>

<option value="rechazado" <?= ($estado == 'rechazado') ? 'selected' : '' ?>>Rechazado</option>

<option value="completado" <?= ($estado == 'completado') ? 'selected' : '' ?>>Completado</option>

</select>

</div>

<label>Fecha:</label>
<input type="date" name="fecha" value="<?= $fecha ?>" required>

<label>Nombre Vendedor:</label>
<input type="text" name="nombrevendedor" value="<?= $vendedor ?>" readonly>

<input type="submit" value="Actualizar Pedido">

</form>

</div>

<script>

$(document).ready(function(){

$("form").validate({

rules:{

nombre:{
required:true,
minlength:3,
maxlength:40
},

telefono:{
required:true
},

direccion:{
required:true
},

fecha:{
required:true
},

estado:{
required:true
},

nombrevendedor:{
required:true
}

},

messages:{

nombre:{
required:"Ingrese el nombre del pedido",
minlength:"Mínimo 3 caracteres",
maxlength:"Máximo 40 caracteres"
},

telefono:{
required:"Ingrese el número de teléfono"
},

direccion:{
required:"Ingrese la dirección"
},

fecha:{
required:"Seleccione una fecha"
},

estado:{
required:"Seleccione el estado del pedido"
},

nombrevendedor:{
required:"Vendedor obligatorio"
}

}

});

});

</script>

</body>
</html>

<?php
$conn->close();
?>