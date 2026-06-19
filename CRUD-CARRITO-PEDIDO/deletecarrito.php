<?php

$conn = new mysqli("localhost","root","","DIVINE");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$idPedido = $_GET['idPedido'] ?? null;
$codigo = $_GET['codigo'] ?? null;

if (!$idPedido || !$codigo) {
    die("Datos incompletos");
}

$sql = "DELETE FROM CARRITO
        WHERE PEDIDOS_ID = '$idPedido'
        AND PRODUCTO_codigo = '$codigo'";

$conn->query($sql);

header("Location: readcarrito.php?idPedido=".$idPedido);
exit();

?>