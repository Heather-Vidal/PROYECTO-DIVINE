<?php

session_start();
require_once "conexion.php";

/* ==========================================
   RECIBIR DATOS DEL FORMULARIO
========================================== */

$nombre    = trim($_POST["nombre"]    ?? "");
$fecha     = trim($_POST["fecha"]     ?? "");
$estado    = trim($_POST["estado"]    ?? "");
$telefono  = trim($_POST["telefono"]  ?? "");
$direccion = trim($_POST["direccion"] ?? "");


/* Whitelist para el estado: solo se aceptan estos 3 valores */
$estadosValidos = ["Pendiente", "Rechazado", "Completado"];
if (!in_array($estado, $estadosValidos, true)) {
    die("Estado no válido. Valor recibido: [" . $estado . "] longitud: " . strlen($estado));
}

if (isset($_SESSION['nombre'])) {
    $nombrevendedor = $_SESSION['nombre'];
} else {
    $nombrevendedor = "DIVINE";
}

/* ==========================================
   INSERT CON PREPARED STATEMENT
========================================== */

$sql = "INSERT INTO PEDIDOS (nombre, fecha, estado, telefono, direccion, nombrevendedor)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param(
    "ssssss",
    $nombre,
    $fecha,
    $estado,
    $telefono,
    $direccion,
    $nombrevendedor
);

if ($stmt->execute()) {

    $idNuevo = (int) $conn->insert_id;
    $stmt->close();
    $conn->close();

    header("Location: formcarrito.php?idPedido=" . urlencode($idNuevo));
    exit();

} else {
    echo "Error: " . $stmt->error;
    $stmt->close();
}

$conn->close();

?>