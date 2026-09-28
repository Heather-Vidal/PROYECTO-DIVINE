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
// FUNCIÓN PARA MOSTRAR ERRORES COMO ALERTA
// ==========================================
 
function alertaError($mensaje) {
 
   echo "
   <script>
 
       alert(" . json_encode($mensaje) . ");
 
       history.back();
 
   </script>
   ";
 
   exit();
 
}
 
 
// ==========================================
// VERIFICAR CONEXIÓN
// ==========================================
 
if ($conn->connect_error) {
 
   // No se muestra el detalle técnico del error al usuario
   alertaError(
       "❌ Error de conexión con la base de datos."
   );
}
 
 
// ==========================================
// RECIBIR DATOS DE LA VENTA
// ==========================================
 
$PEDIDOS_ID = trim($_POST["PEDIDOS_ID"] ?? '');
$estado = trim($_POST["estado"] ?? '');
$metodo = trim($_POST["metodo"] ?? '');
$costototal = trim($_POST["costototal"] ?? '');
 
 
// ==========================================
// VALIDAR DATOS
// ==========================================
 
// PEDIDOS_ID es int y costototal es double en la base de datos
if ($PEDIDOS_ID === '' || !ctype_digit($PEDIDOS_ID)) {
 
   alertaError("❌ El pedido no es válido.");
 
}
 
if ($estado === '') {
 
   alertaError("❌ El estado no fue recibido.");
 
}
 
if ($metodo === '') {
 
   alertaError("❌ Debe seleccionar un método de pago.");
 
}
 
if ($costototal === '' || !is_numeric($costototal)) {
 
   alertaError("❌ El costo total no es válido.");
 
}
 
// Convertir a los tipos que corresponden
$PEDIDOS_ID = (int) $PEDIDOS_ID;
$costototal = (float) $costototal;
 
 
// =========================================
// BUSCAR LOS PRODUCTOS DEL PEDIDO
// ==========================================
 
// Consulta preparada: el dato va separado de la consulta SQL
$sqlCarrito = "
   SELECT PRODUCTO_codigo, cantidad
   FROM CARRITO
   WHERE PEDIDOS_ID = ?
";
 
$stmtCarrito = $conn->prepare($sqlCarrito);
 
 
// ==========================================
// VERIFICAR CONSULTA
// ==========================================
 
if (!$stmtCarrito) {
 
   alertaError(
       "❌ Error al buscar los productos."
   );
 
}
 
// i = entero
$stmtCarrito->bind_param("i", $PEDIDOS_ID);
 
$stmtCarrito->execute();
 
$resultadoCarrito = $stmtCarrito->get_result();
 
// Se guardan los productos del pedido para usarlos más abajo
$productosPedido = $resultadoCarrito->fetch_all(MYSQLI_ASSOC);
 
$stmtCarrito->close();
 
 
// ==========================================
// VERIFICAR QUE EL PEDIDO TENGA PRODUCTOS
// ==========================================
 
if (count($productosPedido) == 0) {
 
   alertaError(
       "❌ Este pedido no tiene productos."
   );
 
}
 
 
// ==========================================
// VERIFICAR EL STOCK
// ==========================================
 
$hayStock = true;
 
$mensajeError = "";
 
foreach ($productosPedido as $producto) {
 
   // Código del producto
   $codigo = (int) $producto["PRODUCTO_codigo"];
 
   // Cantidad solicitada
   $cantidad = (int) $producto["cantidad"];
 
 
   // ======================================
   // BUSCAR PRODUCTO
   // ======================================
 
   $sqlProducto = "
       SELECT nombre, stock
       FROM PRODUCTO
       WHERE codigo = ?
   ";
 
   $stmtProducto = $conn->prepare($sqlProducto);
 
   if (!$stmtProducto) {
 
       alertaError(
           "❌ Error al consultar el producto."
       );
 
   }
 
   // i = entero
   $stmtProducto->bind_param("i", $codigo);
 
   $stmtProducto->execute();
 
   $resultadoProducto = $stmtProducto->get_result();
 
 
   // ======================================
   // VERIFICAR QUE EL PRODUCTO EXISTA
   // ======================================
 
   if ($resultadoProducto->num_rows == 0) {
 
       $hayStock = false;
 
       $mensajeError =
           "❌ El producto con código "
           . $codigo
           . " no existe.";
 
       $stmtProducto->close();
 
       break;
 
   }
 
 
   // ======================================
   // OBTENER DATOS DEL PRODUCTO
   // ======================================
 
   $datosProducto =
       $resultadoProducto->fetch_assoc();
 
   $stmtProducto->close();
 
 
   $nombreProducto =
       $datosProducto["nombre"];
 
 
   $stockActual =
       $datosProducto["stock"];
 
 
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
 
   alertaError($mensajeError);
 
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
       ?,
       ?,
       ?,
       ?
   )";
 
   $stmtVenta = $conn->prepare($sql);
 
   if (!$stmtVenta) {
 
       throw new Exception(
           "❌ Error al preparar el registro de la venta."
       );
 
   }
 
   // s = texto, d = decimal, i = entero
   // estado=s, metodo=s, costototal=d, PEDIDOS_ID=i
   $stmtVenta->bind_param(
       "ssdi",
       $estado,
       $metodo,
       $costototal,
       $PEDIDOS_ID
   );
 
   if (!$stmtVenta->execute()) {
 
       throw new Exception(
           "❌ Error al registrar la venta."
       );
 
   }
 
   $stmtVenta->close();
 
 
   // ======================================
   // DESCONTAR STOCK
   // ======================================
 
   // Consulta preparada una sola vez, se usa para cada producto
   $sqlStock = "
       UPDATE PRODUCTO
       SET stock = stock - ?
       WHERE codigo = ?
   ";
 
   $stmtStock = $conn->prepare($sqlStock);
 
   if (!$stmtStock) {
 
       throw new Exception(
           "❌ Error al preparar la actualización del stock."
       );
 
   }
 
   foreach ($productosPedido as $producto) {
 
 
       $codigo =
           (int) $producto["PRODUCTO_codigo"];
 
 
       $cantidad =
           (int) $producto["cantidad"];
 
 
       // ==================================
       // ACTUALIZAR STOCK
       // ==================================
 
       // i = entero
       // cantidad=i, codigo=i
       $stmtStock->bind_param(
           "ii",
           $cantidad,
           $codigo
       );
 
       if (!$stmtStock->execute()) {
 
           throw new Exception(
               "❌ Error al actualizar el stock."
           );
 
       }
 
   }
 
   $stmtStock->close();
 
 
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
 
   alertaError(
       "❌ No se pudo registrar la venta."
       . "\n\n"
       . $e->getMessage()
   );
 
}
 
 
// ==========================================
// CERRAR CONEXIÓN
// ==========================================
 
$conn->close();
 
?>