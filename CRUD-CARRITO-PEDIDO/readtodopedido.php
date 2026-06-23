 <?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);

if ($conn->connect_error) {
    die("OCURRIÓ UN ERROR SORRY UnU");
}

$sql = "SELECT * FROM PEDIDOS";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pedidos DIVINE</title>

<style>

body{
margin:0;
font-family:'Segoe UI', sans-serif;
background: linear-gradient(135deg,#f7dfe7,#d6b0bf);
}

/* HEADER */
.header{
text-align:center;
padding:50px 20px;
background: linear-gradient(135deg,#8f3f55,#c96f84);
color:white;
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.header h1{
font-size:2.8rem;
letter-spacing:2px;
}

/* CONTENEDOR */
.contenedor{
max-width:900px;
margin:40px auto;
padding:20px;
}

/* LISTA */
.lista{
display:flex;
flex-direction:column;
gap:15px;
}

/* CARD PEDIDO */
.item{
background:white;
border-radius:20px;
padding:18px 20px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 8px 22px rgba(0,0,0,0.08);
border-left:6px solid #c96f84;
transition:0.25s;
}

.item:hover{
transform:translateY(-4px);
}

/* INFO */
.info{
flex:1;
}

.id{
font-size:18px;
font-weight:800;
color:#8f3f55;
margin-bottom:5px;
}

.info p{
margin:4px 0;
font-size:14px;
color:#555;
}

.info span{
font-weight:bold;
color:#8f3f55;
}

/* BOTONES */
.botones{
display:flex;
flex-direction:column;
gap:8px;
}

.botones a button{
border:none;
padding:9px 14px;
border-radius:10px;
cursor:pointer;
font-weight:600;
transition:0.2s;
color:white;
}

/* VER */
.botones a:nth-child(1) button{
background:#8f3f55;
}

/* EDITAR */
.botones a:nth-child(2) button{
background:#c96f84;
}

/* ELIMINAR */
.botones a:nth-child(3) button{
background:#ff4d6d;
}

.botones button:hover{
transform:scale(1.05);
}

/* VACÍO */
.vacio{
text-align:center;
color:#8f3f55;
font-weight:600;
margin-top:40px;
}

/* BACK */
.volver{
text-align:center;
margin-top:40px;
}

.volver a{
text-decoration:none;
background:#8f3f55;
color:white;
padding:12px 20px;
border-radius:12px;
display:inline-block;
transition:0.3s;
}

.volver a:hover{
background:#c96f84;
transform:scale(1.05);
}

</style>

</head>

<body>

<div class="header">
<h1>LISTA DE PEDIDOS</h1>
</div>

<div class="contenedor">

<div class="lista">

<?php
if($resultado && $resultado->num_rows > 0){

while($fila = $resultado->fetch_assoc()){

$idPedido = $fila['ID'];

echo "<div class='item'>";

echo "<div class='info'>";

echo "<div class='id'>PEDIDO #".$idPedido."</div>";

echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
echo "<p><span>Fecha:</span> ".$fila['fecha']."</p>";
echo "<p><span>Estado:</span> ".$fila['estado']."</p>";
echo "<p><span>Vendedor:</span> ".$fila['nombrevendedor']."</p>";

echo "</div>";

echo "<div class='botones'>";

echo "<a href='readcarrito.php?idPedido=$idPedido'><button>Ver</button></a>";
echo "<a href='updateformpedido.php?idPedido=$idPedido'><button>Editar</button></a>";
echo "<a href='deletepedido.php?idPedido=$idPedido'><button>Eliminar</button></a>";

echo "</div>";

echo "</div>";
}

}else{
echo "<div class='vacio'>No hay pedidos registrados</div>";
}
?>

</div>

<div class="volver">
<a href="../perfilvendedor.php">⬅ Volver al perfil</a>
</div>

</div>
 

</body>
</html>

<?php $conn->close(); ?>