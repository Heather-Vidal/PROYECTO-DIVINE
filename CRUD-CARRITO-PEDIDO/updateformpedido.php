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
<html>
<head>
<title>Actualizar Pedido</title>
</head>

<body>


<h2>EDITAR PEDIDO</h2>


<form action="updatepedido.php" method="POST">


<input type="hidden" name="idPedido" value="<?= $idPedido ?>">


Nombre:

<input type="text" name="nombre" value="<?= $nombre ?>" required>

<br><br>


Fecha:

<input type="date" name="fecha" value="<?= $fecha ?>" required>

<br><br>



Estado:

<input type="text" name="estado" value="<?= $estado ?>" required>

<br><br>



Nombre Vendedor:

<input type="text" name="nombrevendedor" 
value="<?= $vendedor ?>" readonly>


<br><br>


<input type="submit" value="Actualizar">


</form>


</body>
</html>