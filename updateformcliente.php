 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
  echo"OCURRiO UN ERROR SORRYYYYYYYYYYYY UnU";
}

$dni=$_GET['dni'];
$sql="SELECT * FROM CLIENTE WHERE dni=$dni";
$resultado=$conn-> query($sql);

if($resultado->num_rows > 0){
while($fila=$resultado->fetch_assoc()){

$dni=$fila['dni'];
$nombre=$fila['nombre'];
$apellido=$fila['apellido'];
$direccion=$fila['direccion'];
$nacimiento=$fila['nacimiento'];
$telefono=$fila['telefono'];

}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Cliente - DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>

body {
  font-family: 'Poppins', sans-serif;
  background: #e9e5dd;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 0;
  margin: 0;
}

/* FORMULARIO PRINCIPAL */
form {
  position: relative;
  background: #f5e9d8;
  padding: 40px 40px 60px 40px;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
  max-width: 600px;
  width: 85%;
  display: grid;

  grid-template-columns: 1fr 1fr;
  grid-template-areas:
    "titulo titulo"
    "imagen imagen"
    "leyenda leyenda"
    "campos campos"
    "boton boton";
  grid-gap: 30px;
}

/* IMAGEN */
.imagen {
  grid-area: imagen;
  background: url("https://cdn-icons-png.flaticon.com/512/3106/3106921.png") center / contain no-repeat;
  border-radius: 15px;
  height: 250px;
}

/* TÍTULO */
h2 {
  grid-area: titulo;
  margin: 0;
  font-size: 32px;
  color: #364e63;
  font-family: "Playfair Display", serif;
  letter-spacing: 1px;
  text-align: center;
}

/* LEYENDA */
legend {
  grid-area: leyenda;
  font-weight: bold;
  color: #c5a46d;
  font-size: 18px;
  letter-spacing: 1px;
  font-family: "Playfair Display", serif;
  text-align: center;
}

/* CAMPOS */
.grupo-campos {
  grid-area: campos;
  display: flex;
  flex-direction: column;
  gap: 18px;
}

label {
  color: #364e63;
  font-size: 15px;
  font-weight: 500;
}

input[type="text"],
input[type="int"],
input[type="date"] {
  padding: 12px 14px;
  border: 1px solid #ccb899;
  border-radius: 8px;
  font-size: 15px;
  background: #ffffff;
  transition: 0.3s;
}

input:focus {
  border-color: #364e63;
  box-shadow: 0 0 8px rgba(54,78,99,0.3);
}

/* BOTÓN */
input[type="submit"] {
  grid-area: boton;
  margin-top: 10px;
  padding: 14px;
  background: #364e63;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  letter-spacing: 1px;
  transition: 0.3s;
  box-shadow: 0 5px 12px rgba(0,0,0,0.25);
}

input[type="submit"]:hover {
  background: #c5a46d;
  transform: scale(1.03);
}

/* RESPONSIVE */
@media (max-width: 768px) {
  form {
    grid-template-columns: 1fr;
    grid-template-areas:
      "imagen"
      "titulo"
      "leyenda"
      "campos"
      "boton";
    padding: 25px;
  }

  .imagen {
    height: 220px;
  }

  input[type="submit"] {
    width: 100%;
  }
}

</style>
</head>

<body>

<form action="updatecliente.php" method="POST">

  <div class="imagen"></div>

  <h2>MODIFICAR CLIENTE</h2>

  <legend>DATOS A EDITAR:</legend>

  <div class="grupo-campos">

    <label>DNI:</label>
    <input type="text" name="dni" value="<?= $dni ?>" required>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $nombre ?>" required>

    <label>Apellido:</label>
    <input type="text" name="apellido" value="<?= $apellido ?>" required>

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?= $direccion ?>" required>

    <label>Fecha de Nacimiento:</label>
    <input type="date" name="nacimiento" value="<?= $nacimiento ?>" required>

    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?= $telefono ?>" required>

  </div>

  <input type="submit" value="Guardar Cambios">

</form>

</body>
</html>