 <?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$codigo = $_POST["codigo"] ?? null;
$idpedido = $_POST["idpedido"] ?? null;
$cantidad = $_POST["cantidad"] ?? 0;
$precio = $_POST["precio"] ?? 0;


if(!$codigo || !$idpedido){
    die("Datos incompletos");
}


// evitar cantidad 0
if($cantidad <= 0){
    header("location: formcarrito.php?idPedido=".$idpedido);
    exit();
}


/* Revisar si el producto ya existe EN ESTE PEDIDO */
$check = "SELECT cantidad 
          FROM CARRITO
          WHERE PRODUCTO_codigo='$codigo'
          AND PEDIDOS_ID='$idpedido'";


$result = $conn->query($check);



if($result->num_rows > 0){


    // ya existe, aumentamos cantidad

    $row = $result->fetch_assoc();

    $nuevaCantidad = $row["cantidad"] + $cantidad;

    $nuevoTotal = $precio * $nuevaCantidad;


    $update = "UPDATE CARRITO
               SET cantidad='$nuevaCantidad',
               costototal='$nuevoTotal'
               WHERE PRODUCTO_codigo='$codigo'
               AND PEDIDOS_ID='$idpedido'";


    $conn->query($update);



}else{


    // producto nuevo en este pedido

    $total = $precio * $cantidad;


    $sql = "INSERT INTO CARRITO
    (
        PRODUCTO_codigo,
        PEDIDOS_ID,
        cantidad,
        costototal
    )
    VALUES
    (
        '$codigo',
        '$idpedido',
        '$cantidad',
        '$total'
    )";


    $conn->query($sql);

}



 header("Location: formcarrito.php?idPedido=".$idpedido);
 

exit();


$conn->close();

?>