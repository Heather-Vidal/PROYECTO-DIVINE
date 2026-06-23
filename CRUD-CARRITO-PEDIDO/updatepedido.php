  <?php

$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn = new mysqli($servidor,$usuario,$contraseña,$nombreBD);

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

if ($conn->connect_error) {
    echo '<div class="mensaje error">❌ ERROR DE CONEXIÓN CON BD</div>';
}

$idPedido = $_POST['idPedido'];
$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$nombrevendedor = $_POST['nombrevendedor'];

$sql = "UPDATE PEDIDOS SET
        nombre='$nombre',
        fecha='$fecha',
        estado='$estado',
        nombrevendedor='$nombrevendedor'
        WHERE ID='$idPedido'";

if ($conn->query($sql) === TRUE) {

    echo '<div class="mensaje exito">✔ PEDIDO ACTUALIZADO EXITOSAMENTE</div>';

} else {

    echo '<div class="mensaje error">⚠ ERROR AL ACTUALIZAR PEDIDO</div>';

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