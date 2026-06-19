<?php
    session_start();
    $vendedor=$_SESSION['nombre'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Pedido</title>
</head>
<body>

<h2>AGREGA EL PRODUCTO</h2>

<form action="createpedido.php" method="POST">

    Nombre:
    <input type="text" name="nombre" ><br><br>

    Fecha:
    <input type="date" name="fecha" ><br><br>

    <input type="hidden" name="estado" value="En Proceso">

    Nombre Vendedor:
    <input type="text" name="nombrevendedor" value="<?php echo $vendedor?>" readonly><br><br>

    <input type="submit" value="Nuevo Pedido">

</form>

</body>
</html>