<?php

require_once "conexion.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Pedido Modificado - DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>

body {
  font-family: "Playfair Display", serif;
  background: linear-gradient(135deg,#f7dfe7,#d6b0bf);
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #2b2b2b;
}

.contenedor {
  background: #fff;
  padding: 40px;
  border-radius: 25px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  width: 90%;
  max-width: 700px;
  display: grid;
  grid-template-columns: 1fr;
  grid-template-areas:
    "encabezado"
    "contenido"
    "botones";
  gap: 30px;
  text-align: center;
}

/* TITULO */
.encabezado {
  font-size: 36px;
  font-weight: 700;
  color: #c96f84;
  letter-spacing: 2px;
  text-transform: uppercase;
  border-bottom: 3px solid #c96f84;
  padding-bottom: 10px;
}

/* CONTENIDO */
.contenido {
  background: #fff5f8;
  border-radius: 20px;
  padding: 30px 25px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.08);
  font-size: 18px;
}

/* MENSAJES */
.mensaje {
  border-radius: 12px;
  padding: 18px;
  font-weight: 600;
  margin-bottom: 15px;
}

/* EXITO ROSA */
.exito {
  background-color: #c96f84;
  color: white;
  box-shadow: 0 6px 18px rgba(201,111,132,0.6);
}

/* ERROR ROSA OSCURO */
.error {
  background-color: #b84a63;
  color: white;
  box-shadow: 0 6px 18px rgba(184,74,99,0.6);
}

/* BOTONES */
.botones {
  display: flex;
  justify-content: center;
  gap: 25px;
}

.boton {
  text-decoration: none;
  background: #c96f84;
  color: white;
  padding: 14px 38px;
  border-radius: 30px;
  font-weight: 700;
  font-size: 17px;
  box-shadow: 0 6px 18px rgba(201,111,132,0.4);
  transition: 0.3s;
}

.boton:hover {
  background: #b65e73;
  transform: scale(1.05);
}

@media (max-width: 600px) {
  .botones {
    flex-direction: column;
    gap: 15px;
  }
}

</style>
</head>

<body>

<div class="contenedor">

<div class="encabezado">DIVINE</div>

<div class="contenido">

<?php

/* ==========================================
   VALIDAR Y RECIBIR DATOS DEL FORMULARIO
========================================== */

$idPedidoCrudo = trim($_POST['idPedido'] ?? '');

if ($idPedidoCrudo === '' || !is_numeric($idPedidoCrudo)) {
    echo '<div class="mensaje error">❌ PEDIDO NO VÁLIDO</div>';
    $conn->close();
    exit();
}

$idPedido       = (int) $idPedidoCrudo;
$nombre         = trim($_POST['nombre']         ?? "");
$fecha          = trim($_POST['fecha']          ?? "");
$telefono       = trim($_POST['telefono']       ?? "");
$direccion      = trim($_POST['direccion']      ?? "");
$estado         = trim($_POST['estado']         ?? "");
$nombrevendedor = trim($_POST['nombrevendedor'] ?? "");

/* Whitelist para el estado */
$estadosValidos = ["pendiente", "rechazado", "completado"];
if (!in_array($estado, $estadosValidos, true)) {
    echo '<div class="mensaje error">❌ ESTADO NO VÁLIDO</div>';
    $conn->close();
    exit();
}

/* ==========================================
   UPDATE CON PREPARED STATEMENT
========================================== */

$sql = "UPDATE PEDIDOS SET
        nombre = ?,
        fecha = ?,
        estado = ?,
        telefono = ?,
        direccion = ?,
        nombrevendedor = ?
        WHERE ID = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo '<div class="mensaje error">⚠ ERROR AL PREPARAR LA CONSULTA</div>';
} else {

    $stmt->bind_param(
        "ssssssi",
        $nombre,
        $fecha,
        $estado,
        $telefono,
        $direccion,
        $nombrevendedor,
        $idPedido
    );

    if ($stmt->execute()) {
        echo '<div class="mensaje exito">✔ PEDIDO ACTUALIZADO EXITOSAMENTE</div>';
    } else {
        echo '<div class="mensaje error">⚠ ERROR AL ACTUALIZAR PEDIDO</div>';
    }

    $stmt->close();
}

$conn->close();

?>

</div>

<div class="botones">

<a href="../totu.php" class="boton">⬅ Volver al inicio</a>

<a href="readtodopedido.php" class="boton">Ver pedidos ➡</a>

</div>

</div>

</body>
</html>