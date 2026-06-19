<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$codigo = $_POST["codigo"];
$idpedido = $_POST["idpedido"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];

/* 1. Verificar si ya existe el producto en ese pedido */
$check = "SELECT cantidad FROM CARRITO 
          WHERE PRODUCTO_codigo='$codigo' AND PEDIDOS_ID='$idpedido'";

$result = $conn->query($check);

if ($result->num_rows > 0) {

    /* 2. Si existe → actualizar cantidad */
    $row = $result->fetch_assoc();

    $nuevaCantidad = $row["cantidad"] + $cantidad;
    $nuevoTotal = $precio * $nuevaCantidad;

    $update = "UPDATE CARRITO 
               SET cantidad='$nuevaCantidad', costototal='$nuevoTotal'
               WHERE PRODUCTO_codigo='$codigo' AND PEDIDOS_ID='$idpedido'";

    $conn->query($update);

} else {

    /* 3. Si no existe → insertar normal */
    $total = $precio * $cantidad;

    $sql = "INSERT INTO CARRITO 
            (PRODUCTO_codigo, PEDIDOS_ID, cantidad, costototal)
            VALUES('$codigo','$idpedido','$cantidad','$total')";

    $conn->query($sql);
}

header("location: formcarrito.php?idPedido=".$idpedido);

?>