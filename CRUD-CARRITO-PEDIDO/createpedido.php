<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$estado = $_POST["estado"];
$telefono = $_POST["telefono"];
$direccion = $_POST["direccion"];
$nombrevendedor = $_POST["nombrevendedor"];

$sql = "INSERT INTO pedidos (nombre,fecha,estado,telefono,direccion,nombrevendedor) VALUES ('$nombre', '$fecha', '$estado', '$telefono', '$direccion', '$nombrevendedor')";

if($conn->query($sql)){
    header("location: formcarrito.php?idPedido=".$conn->insert_id);
}else{
    echo "Error: " . $conn->error;
}

$conn->close();

?>