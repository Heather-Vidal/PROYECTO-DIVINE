 <?php

$conn = new mysqli("localhost","root","","DIVINE");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$idpedido = $_GET['idPedido'] ?? null;

if (!$idpedido) {
    die("No llegó el id del pedido");
}

$sql = "SELECT CARRITO.PRODUCTO_codigo,
               PRODUCTO.nombre,
               CARRITO.cantidad,
               CARRITO.costototal
        FROM CARRITO
        INNER JOIN PRODUCTO
        ON CARRITO.PRODUCTO_codigo = PRODUCTO.codigo
        WHERE CARRITO.PEDIDOS_ID = '$idpedido'";

$resultado = $conn->query($sql);

echo "<h2>Mi Carrito</h2>";

echo "<table border='1'>";

echo "
<tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Total</th>
    <th>Eliminar</th>
</tr>
";

$totalGeneral = 0;

while($fila = $resultado->fetch_assoc()){

    echo "<tr>";

    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$fila['cantidad']."</td>";
    echo "<td>".$fila['costototal']."</td>";

    echo "<td>
            <a href='deletecarrito.php?idPedido=".$idpedido."&codigo=".$fila['PRODUCTO_codigo']."'
               onclick=\"return confirm('¿Eliminar este producto del carrito?');\">
                <button>Eliminar</button>
            </a>
          </td>";

    echo "</tr>";

    $totalGeneral += $fila['costototal'];
}

echo "</table>";

echo "<h3>Total general: ".$totalGeneral."</h3>";

echo "<br><br>";

echo "<a href='formcarrito.php?idPedido=".$idpedido."'>
        <button>Seguir comprando</button>
      </a>";

echo " ";

echo "<a href='finalizarpedido.php?idPedido=".$idpedido."'>
        <button>Finalizar compra</button>
      </a>";

$conn->close();

?>