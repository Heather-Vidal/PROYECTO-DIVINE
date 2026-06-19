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

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>
/* TU CSS AQUÍ SIN CAMBIOS */
</style>

</head>

<body>
<div class="contenedor">

    <div class="imagen"></div>

    <h2 class="titulo">LISTA DE PEDIDOS</h2>

    <div class="lista">

<?php
if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $idPedido = $fila['idPedido']; // lo definimos aquí, pero SOLO para botones

        echo "<div class='item'>";

        echo "<p><span>ID Pedido:</span> " . $idPedido . "</p>";
        echo "<p><span>Nombre:</span> " . $fila['nombre'] . "</p>";
        echo "<p><span>Fecha:</span> " . $fila['fecha'] . "</p>";
        echo "<p><span>Estado:</span> " . $fila['estado'] . "</p>";
        echo "<p><span>Vendedor:</span> " . $fila['nombrevendedor'] . "</p>";

        echo "<div class='botones'>";

        echo "<a href='readcarrito.php?idPedido=$idPedido'><button>Ver carrito</button></a>";
        echo "<a href='updatepedido.php?idPedido=$idPedido'><button>Editar</button></a>";
        echo "<a href='deletepedido.php?idPedido=$idPedido'><button>Eliminar</button></a>";

        echo "</div>";

        echo "</div>";
    }

} else {
    echo "<p>No hay pedidos registrados.</p>";
}
?>

    </div>

    <div class="volver">
        <a href="../totu.php">⬅ Volver al inicio</a>
    </div>

</div>
</body>
</html>

<?php
$conn->close();
?>