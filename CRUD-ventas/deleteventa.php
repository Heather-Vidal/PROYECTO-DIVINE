<?php

session_start();


// ==========================================
// VALIDAR ADMINISTRADOR
// ==========================================

if (
    !isset($_SESSION['rol']) ||
    $_SESSION['rol'] != "administrador"
) {

    header("Location: ../loginformcliente.php");
    exit();

}


// ==========================================
// CONEXIÓN
// ==========================================

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


if ($conn->connect_error) {

    die(
        "Error de conexión: "
        . $conn->connect_error
    );

}


// ==========================================
// RECIBIR ID
// ==========================================

$id = $_GET['id'] ?? null;


if (!$id) {

    die("No se recibió el ID de la venta.");

}


// ==========================================
// ELIMINAR VENTA
// ==========================================

$sql = "DELETE FROM VENTAS WHERE id = '$id'";


if ($conn->query($sql) === TRUE) {


    $mensaje = "La venta fue eliminada correctamente.";


    header(
        "Location: readtodoventa.php?mensaje="
        . urlencode($mensaje)
    );

    exit();


} else {


    $mensaje = "Error al eliminar la venta.";


    header(
        "Location: readtodoventa.php?error="
        . urlencode($mensaje)
    );

    exit();

}


$conn->close();

?>