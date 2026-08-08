<?php

session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli(  $servidor,  $usuario,  $contrasena,  $bd );


if ($conn->connect_error) {

    die(  "Error de conexión: " . $conn->connect_error  );
}


/* ==========================================
   RECIBIR DATOS DEL FORMULARIO
========================================== */

$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$estado = $_POST["estado"];
$telefono = $_POST["telefono"];
$direccion = $_POST["direccion"];


if (isset($_SESSION['nombre'])) {

    $nombrevendedor = $_SESSION['nombre'];

} else {

    $nombrevendedor = "DIVINE";

}

$sql = "INSERT INTO PEDIDOS  ( nombre, fecha,    estado,    telefono,    direccion,   nombrevendedor )
        VALUES  (      '$nombre',     '$fecha',     '$estado',     '$telefono',     '$direccion',     '$nombrevendedor'
        )";


 

if ($conn->query($sql)) {
+

    header(
        "Location: formcarrito.php?idPedido="
        . $conn->insert_id
    );
    exit();

} else {   echo "Error: " . $conn->error; }

$conn->close();

?>