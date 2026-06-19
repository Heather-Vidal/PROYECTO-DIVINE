<?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);

if ($conn->connect_error) {
    die("OCURRIÓ UN ERROR SORRY UnU");
}

$idPedido = $_GET['idPedido'] ?? null;

if (!$idPedido) {
    die("No llegó el ID del pedido");
}

$sql = "DELETE FROM PEDIDOS WHERE ID = '$idPedido'";

if ($conn->query($sql) === TRUE) {
    header("Location: readtodopedido.php");
    exit();
} else {
    echo "Error al eliminar: " . $conn->error;
}

$conn->close();

?>