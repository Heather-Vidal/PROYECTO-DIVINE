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

/* FONDO IGUAL */
body{
background:
linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)),
url('../imagenes/fondote.png');

background-position:center;
background-repeat:no-repeat;
background-size:cover;

display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
}

/* TARJETA */
.contenedor{
background:rgba(255,255,255,.78);
backdrop-filter:blur(10px);

padding:40px;
width:450px;

border-radius:30px;
box-shadow:0 15px 35px rgba(0,0,0,.15);
}

/* TITULO */
h2{
text-align:center;
color:#bf7485;
margin-bottom:25px;
font-size:28px;
letter-spacing:1px;
}

/* LABEL */
label{
display:block;
margin-bottom:6px;
color:#666;
font-weight:600;
}

/* INPUTS */
input[type="text"],
input[type="date"]{
width:100%;
padding:12px 15px;
border:2px solid #f0d6dc;
border-radius:15px;
outline:none;
margin-bottom:18px;
transition:.3s;
font-size:15px;
}

input:focus{
border-color:#c96f84;
box-shadow:0 0 10px rgba(201,111,132,.25);
}

/* READONLY */
input[readonly]{
background:#fdf5f7;
color:#bf7485;
font-weight:bold;
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
}

/* ERRORES VALIDACIÓN */
.error{
color:#d85a5a;
font-size:13px;
margin-top:-12px;
margin-bottom:10px;
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

<label>Fecha:</label>
<input type="date" name="fecha" value="<?= $fecha ?>" required>

<label>Estado:</label>
<input type="text" name="estado" value="<?= $estado ?>" required>

<label>Nombre Vendedor:</label>
<input type="text" name="nombrevendedor" value="<?= $vendedor ?>" readonly>

<input type="submit" value="Actualizar Pedido">

</form>

</div>

<script>

$(document).ready(function () {

$("form").validate({

rules: {

nombre: {
required: true,
minlength: 3,
maxlength: 40
},

fecha: {
required: true
},

estado: {
required: true,
minlength: 3
},

nombrevendedor: {
required: true
}

},

messages: {

nombre: {
required: "Ingrese el nombre del pedido",
minlength: "Mínimo 3 caracteres",
maxlength: "Máximo 40 caracteres"
},

fecha: {
required: "Seleccione una fecha"
},

estado: {
required: "Ingrese el estado del pedido",
minlength: "Muy corto"
},

nombrevendedor: {
required: "Vendedor obligatorio"
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