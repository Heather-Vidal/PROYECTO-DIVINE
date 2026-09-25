<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión");
}

$conn->set_charset("utf8mb4");


/* ==============================
   RECIBIR Y VALIDAR DATOS
   ============================== */

$codigo = $_POST["codigo"] ?? null;
$idpedido = $_POST["idpedido"] ?? null;
$cantidad = $_POST["cantidad"] ?? 0;
$precio = $_POST["precio"] ?? 0;


/* Verificar datos obligatorios */

if ($codigo === null || $idpedido === null) {
    die("Datos incompletos");
}


/* Validar que código e ID tengan el formato esperado */

$codigo = trim($codigo);

if ($codigo === "") {
    die("Código de producto inválido");
}

if (!filter_var($idpedido, FILTER_VALIDATE_INT) || $idpedido <= 0) {
    die("ID de pedido inválido");
}


/* Validar cantidad */

if (!is_numeric($cantidad) || $cantidad <= 0) {
    header("Location: formcarrito.php?idPedido=" . urlencode($idpedido));
    exit();
}

$cantidad = (int)$cantidad;


/* Validar precio */

if (!is_numeric($precio) || $precio < 0) {
    die("Precio inválido");
}

$precio = (float)$precio;


/* ==============================
   BUSCAR SI EL PRODUCTO YA EXISTE
   ============================== */

$check = "SELECT cantidad
          FROM CARRITO
          WHERE PRODUCTO_codigo = ?
          AND PEDIDOS_ID = ?";

$stmt = $conn->prepare($check);

if (!$stmt) {
    die("Error al preparar la consulta");
}

$stmt->bind_param("si", $codigo, $idpedido);
$stmt->execute();

$result = $stmt->get_result();


/* ==============================
   SI EL PRODUCTO YA EXISTE
   ============================== */

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $nuevaCantidad = (int)$row["cantidad"] + $cantidad;

    $nuevoTotal = $precio * $nuevaCantidad;


    $update = "UPDATE CARRITO
               SET cantidad = ?,
                   costototal = ?
               WHERE PRODUCTO_codigo = ?
               AND PEDIDOS_ID = ?";

    $stmtUpdate = $conn->prepare($update);

    if (!$stmtUpdate) {
        die("Error al preparar la actualización");
    }

    $stmtUpdate->bind_param(
        "idsi",
        $nuevaCantidad,
        $nuevoTotal,
        $codigo,
        $idpedido
    );

    $stmtUpdate->execute();

    $stmtUpdate->close();


/* ==============================
   SI EL PRODUCTO ES NUEVO
   ============================== */

} else {

    $total = $precio * $cantidad;


    $sql = "INSERT INTO CARRITO
            (
                PRODUCTO_codigo,
                PEDIDOS_ID,
                cantidad,
                costototal
            )
            VALUES
            (?, ?, ?, ?)";

    $stmtInsert = $conn->prepare($sql);

    if (!$stmtInsert) {
        die("Error al preparar el registro");
    }

    $stmtInsert->bind_param(
        "siid",
        $codigo,
        $idpedido,
        $cantidad,
        $total
    );

    $stmtInsert->execute();

    $stmtInsert->close();
}


/* ==============================
   CERRAR Y REDIRIGIR
   ============================== */

$stmt->close();
$conn->close();

header("Location: formcarrito.php?idPedido=" . urlencode($idpedido));
exit();

?>
```
