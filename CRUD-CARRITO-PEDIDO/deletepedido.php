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


// PRIMERO BORRAMOS LOS PRODUCTOS DEL CARRITO DE ESE PEDIDO
$sqlCarrito = "DELETE FROM CARRITO WHERE PEDIDOS_ID = '$idPedido'";


if ($conn->query($sqlCarrito) === TRUE) {


    // DESPUÉS BORRAMOS EL PEDIDO
    $sqlPedido = "DELETE FROM PEDIDOS WHERE ID = '$idPedido'";


    if ($conn->query($sqlPedido) === TRUE) {

        header("Location: readtodopedido.php");
        exit();

    } else {

        echo "Error al eliminar pedido: " . $conn->error;

    }


} else {

    echo "Error al borrar carrito: " . $conn->error;

}


$conn->close();

?>