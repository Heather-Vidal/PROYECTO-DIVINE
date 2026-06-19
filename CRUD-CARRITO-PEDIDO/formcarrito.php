<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

session_start();

// obtiene el id del pedido de la URL
$id_pedido = $_GET['idPedido'];

$sql = "SELECT * FROM producto";
$resultado = $conn->query($sql);

// Para hallar el total del pedido
$sqlTotal = "SELECT sum(costototal) FROM carrito where PEDIDOS_ID='$id_pedido'";
$resultadoTotal = $conn->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();

$total = $res['sum(costototal)'];
if ($res['sum(costototal)'] == null) {
    $total = 0;
}

// Tabla que muestra todos los productos
echo "<h3>Total: ".$total."</h3>";

echo "<table border='1'>";

echo "<tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Acciones</th>
        <th colspan=2>Agregar al Carrito</th>
      </tr>";

while($fila = $resultado->fetch_assoc()){

    echo "<form action='createcarrito.php' method='post'>";
    echo "<tr>";

    echo "<td>".$fila["codigo"]."</td>";
    echo "<td>".$fila["nombre"]."</td>";
    echo "<td>".$fila["descripcion"]."</td>";
    echo "<td>".$fila["precio"]."</td>";

    echo "<td>
            <a href='producto.php?codigo=".$fila["codigo"]."'>
                <button type='button'>Mostrar</button>
            </a>
          </td>";

    echo "<input type='hidden' value=".$fila["codigo"]." name='codigo'>";
    echo "<input type='hidden' value=".$id_pedido." name='idpedido'>";
    echo "<input type='hidden' value=".$fila["precio"]." name='precio'>";

    echo "<td><input type='number' name='cantidad' value=0></td>";
    echo "<td><input type='submit' value='Agregar'></td>";

    echo "</tr>";
    echo "</form>";
}

echo "</table>";

echo "<a href='formpedido.php'>
        <button>Generar Nuevo Pedido</button>
      </a><br><br>";

/* ✅ BOTÓN CORREGIDO: ahora SÍ pasa el ID del pedido */
echo "<a href='readcarrito.php?idPedido=".$id_pedido."'>
        <button>Ver productos agregados en el carrito</button>
      </a><br><br>";

?>