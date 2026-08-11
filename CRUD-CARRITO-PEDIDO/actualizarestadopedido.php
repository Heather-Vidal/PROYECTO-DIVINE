<?php

// ==================================================
// CONEXIÓN A LA BASE DE DATOS
// ==================================================

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);


// Verificar conexión

if ($conn->connect_error) {

    die(
        "Error de conexión: "
        . $conn->connect_error
    );

}


// ==================================================
// RECIBIR DATOS
// ==================================================

$idPedido = $_GET['idPedido'] ?? null;

$estado = $_GET['estado'] ?? null;


// Verificar datos

if (!$idPedido) {

    die("No se recibió el ID del pedido.");

}


if (!$estado) {

    die("No se recibió el estado del pedido.");

}


// ==================================================
// ACTUALIZAR ESTADO DEL PEDIDO
// ==================================================

$sql = "UPDATE PEDIDOS
        SET estado = ?
        WHERE ID = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "si",
    $estado,
    $idPedido
);


if ($stmt->execute()) {


    // ==================================================
    // SI EL PEDIDO FUE ACEPTADO
    // ==================================================

    if ($estado == "En proceso") {


        // ==================================================
        // CALCULAR EL COSTO TOTAL DEL CARRITO
        //
        // Este valor NO se guarda en PEDIDOS.
        // Se calcula temporalmente aquí.
        // ==================================================

        $sqlTotal = "
            SELECT COALESCE(
                SUM(costototal),
                0
            ) AS total
            FROM CARRITO
            WHERE PEDIDOS_ID = ?
        ";


        $stmtTotal = $conn->prepare($sqlTotal);

        $stmtTotal->bind_param(
            "i",
            $idPedido
        );

        $stmtTotal->execute();

        $resultadoTotal =
            $stmtTotal->get_result();


        $filaTotal =
            $resultadoTotal->fetch_assoc();


        // Variable provisional

        $costoTotal =
            (float)$filaTotal['total'];


        $stmtTotal->close();


        // ==================================================
        // ENVIAR TODO AL FORMULARIO DE VENTA
        //
        // Se envía:
        //
        // idPedido
        // estado
        // costoTotal
        // ==================================================

        header(
            "Location: ../CRUD-ventas/formventa.php"
            . "?idPedido="
            . urlencode($idPedido)
            . "&estado="
            . urlencode($estado)
            . "&costoTotal="
            . urlencode($costoTotal)
        );

        exit();

    }


    // ==================================================
    // SI EL PEDIDO FUE RECHAZADO
    // ==================================================

    if ($estado == "Rechazado") {


        $mensaje =
            "Pedido número "
            . $idPedido
            . " rechazado con éxito.";


        header(
            "Location: readtodopedido.php?mensaje="
            . urlencode($mensaje)
        );

        exit();

    }


} else {


    echo
        "Error al actualizar el pedido: "
        . $conn->error;

}


$stmt->close();

$conn->close();

?>
