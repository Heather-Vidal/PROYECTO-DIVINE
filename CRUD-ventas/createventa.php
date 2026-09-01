<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";
$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);
// ==========================================
// VERIFICAR CONEXIÓN
// ==========================================
if ($conn->connect_error) {

    die(
        "Error de conexión: "
        . $conn->connect_error
    );
}
// ==========================================
// RECIBIR DATOS DE LA VENTA
// ==========================================
$PEDIDOS_ID = $_POST["PEDIDOS_ID"];
$estado = $_POST["estado"];
$metodo = $_POST["metodo"];
$costototal = $_POST["costototal"];
// ==========================================
// BUSCAR LOS PRODUCTOS DEL PEDIDO
// ==========================================
$sqlCarrito = "
    SELECT PRODUCTO_codigo, cantidad
    FROM CARRITO
    WHERE PEDIDOS_ID = '$PEDIDOS_ID'
";
$resultadoCarrito = $conn->query($sqlCarrito);
// ==========================================
// VERIFICAR CONSULTA
// ==========================================
if (!$resultadoCarrito) {

    die(
        "Error al buscar los productos: "
        . $conn->error
    );

}
// ==========================================
// VERIFICAR QUE EL PEDIDO TENGA PRODUCTOS
// ==========================================
if ($resultadoCarrito->num_rows == 0) {
    die(
        "❌ Este pedido no tiene productos."
    );
}
// ==========================================
// VERIFICAR EL STOCK
// ==========================================
$hayStock = true;
$mensajeError = "";
while ($producto = $resultadoCarrito->fetch_assoc()) {
    // Código del producto
    $codigo = $producto["PRODUCTO_codigo"];
    // Cantidad solicitada
    $cantidad = $producto["cantidad"];
    // ======================================
    // BUSCAR PRODUCTO
    // ======================================
    $sqlProducto = "
        SELECT nombre, stock
        FROM PRODUCTO
        WHERE codigo = '$codigo'
    ";
    $resultadoProducto = $conn->query($sqlProducto);
    if (!$resultadoProducto) {
        die(
            "Error al consultar el producto: "
            . $conn->error
        );

    }
    // ======================================
    // VERIFICAR QUE EL PRODUCTO EXISTA
    // ======================================
    if ($resultadoProducto->num_rows == 0) {
        $hayStock = false;
        $mensajeError =
            "❌ El producto con código "
            . $codigo
           . " no existe.";
        break;
    }
    // ======================================
    // OBTENER DATOS DEL PRODUCTO
    // ======================================
    $datosProducto = $resultadoProducto->fetch_assoc();
    $nombreProducto = $datosProducto["nombre"];
    $stockActual = $datosProducto["stock"];
    // ======================================
    // COMPARAR STOCK
    // ======================================
    if ($stockActual < $cantidad) {
        $hayStock = false;
        $mensajeError =
            "❌ No hay suficiente stock de "
            . $nombreProducto
            . ". Stock disponible: "
            . $stockActual
            . " | Cantidad solicitada: "
            . $cantidad;
        break;
    }
}
// ==========================================
// SI NO HAY STOCK, NO HACER NADA
// ==========================================
if (!$hayStock) {
    echo $mensajeError;
    $conn->close();
    exit();
}
// ==========================================
// INICIAR TRANSACCIÓN
// ==========================================
$conn->begin_transaction();
try {
    // ======================================
    // INSERTAR LA VENTA
    // ======================================
    $sql = "INSERT INTO VENTAS
    (
        estado,
        metodo,
        costototal,
        PEDIDOS_ID
    )
    VALUES
    (
        '$estado',
        '$metodo',
        '$costototal',
        '$PEDIDOS_ID'
    )";
    if (!$conn->query($sql)) {

        throw new Exception(
            "Error al registrar la venta: "
            . $conn->error
        );
    }
    // ======================================
    // BUSCAR PRODUCTOS DEL PEDIDO
    // ======================================
    $sqlCarrito2 = "
        SELECT PRODUCTO_codigo, cantidad
        FROM CARRITO
        WHERE PEDIDOS_ID = '$PEDIDOS_ID'
    ";
    $resultadoCarrito2 = $conn->query($sqlCarrito2);
    if (!$resultadoCarrito2) {
        throw new Exception(
            "Error al obtener los productos del pedido: "
            . $conn->error
        );
    }
    // ======================================
    // DESCONTAR STOCK
    // ======================================
    while ($producto = $resultadoCarrito2->fetch_assoc()) {
        $codigo = $producto["PRODUCTO_codigo"];
        $cantidad = $producto["cantidad"];
        // ==================================
        // ACTUALIZAR STOCK
        // ==================================
        $sqlStock = "
            UPDATE PRODUCTO
            SET stock = stock - '$cantidad'
            WHERE codigo = '$codigo'
        ";
        if (!$conn->query($sqlStock)) {
            throw new Exception(
                "Error al actualizar el stock: "
                . $conn->error
            );
        }
    }
    // ======================================
    // CONFIRMAR TODAS LAS OPERACIONES
    // ======================================
    $conn->commit();
    // ======================================
    // REDIRECCIONAR
    // ======================================
    header(
        "Location: readtodoventa.php"
    );
    exit();
} catch (Exception $e) {
    // ======================================
    // DESHACER TODO SI ALGO FALLA
    // ======================================
    $conn->rollback();
    echo "❌ No se pudo registrar la venta.";
    echo "<br><br>";
    echo $e->getMessage();
}
// ==========================================
// CERRAR CONEXIÓN
// ==========================================
$conn->close();
?>