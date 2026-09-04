<?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

if ($conn->connect_error) {
    die("Error de conexión");
}

/* Recibir ID del pedido */
$idPedido = $_GET["idPedido"];

/* Buscar el pedido */
$sql = "SELECT * FROM PEDIDOS
        WHERE ID = '$idPedido'
        LIMIT 1";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Estado del Pedido</title>

</head>

<body>

<h2>Estado del Pedido</h2>

<?php

if ($resultado && $resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();
?>
    <p>
        <strong>Pedido:</strong>
        <?php echo $fila["ID"]; ?>
    </p>

    <p>
        <strong>Cliente:</strong>
        <?php echo $fila["nombre"]; ?>
    </p>

    <p>
        <strong>Fecha:</strong>
        <?php echo $fila["fecha"]; ?>
    </p>

    <p>
        <strong>Estado:</strong>
        <?php echo $fila["estado"]; ?>
    </p>

<?php

} else {

?>

    <p>
        No se encontró el pedido.
    </p>

<?php

}

?>

<br>

<a href="formulario_pedido.php">
    Volver al formulario
</a>

</body>

</html>

<?php
$conn->close();
?>

