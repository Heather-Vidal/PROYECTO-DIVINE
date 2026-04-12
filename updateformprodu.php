 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
  echo"OCURRiO UN ERROR SORRYYYYYYYYYYYY UnU";
}

$codigo=$_GET['codigo'];
$sql="SELECT * FROM PRODUCTO WHERE codigo=$codigo";
$resultado=$conn-> query($sql);

if($resultado->num_rows > 0){
    while($fila=$resultado->fetch_assoc()){
        $nombre=$fila['nombre'];
        $cantidad=$fila['cantidad'];
        $precio=$fila['precio'];
        $costo=$fila['costo'];
        $categoria=$fila['categoria'];
        $codigo=$fila['codigo'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Producto DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Inter', sans-serif;
  background: #e9e5dd;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
}

/* FORMULARIO */
form {
  background: #f5e9d8;
  padding: 50px;
  border-radius: 25px;
  border: 2px solid #c5a46d;
  box-shadow: 0 15px 40px rgba(8, 8, 8, 0.15);
  max-width: 800px;
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 30px;
  grid-template-areas:
    "imagen titulo"
    "imagen leyenda"
    "imagen campos"
    "imagen boton";
  transition: transform 0.35s ease;
}

/* IMAGEN */
.imagen {
  grid-area: imagen;
  background: url("https://i.pinimg.com/736x/23/fd/c5/23fdc5871b591de154e3e9b889036562.jpg") center center / cover no-repeat;
  border-radius: 20px;
  min-height: 420px;
  filter: brightness(0.9) saturate(1.1);
  box-shadow: inset 0 0 20px rgba(0,0,0,0.1);
}

/* TITULO */
h2 {
  grid-area: titulo;
  margin: 0 0 8px;
  font-size: 36px;
  color: #364e63;
  font-family: "Playfair Display", serif;
  letter-spacing: 1px;
  border-bottom: 3px solid #c5a46d;
  padding-bottom: 8px;
  width: fit-content;
}

/* LEYENDA */
legend {
  grid-area: leyenda;
  font-weight: bold;
  color: #c5a46d;
  font-size: 18px;
  font-family: "Playfair Display", serif;
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
  font-weight: 600;
}

input[type="text"],
input[type="number"] {
  padding: 14px 16px;
  border-radius: 12px;
  border: 1.5px solid #c5a46d;
  background: #ffffff;
  font-size: 15px;
  outline: none;
  transition: 0.35s ease, box-shadow 0.35s ease;
}

input[type="text"]:focus,
input[type="number"]:focus {
  border-color: #364e63;
  box-shadow: 0 0 12px rgba(54,78,99,0.55), 0 0 6px rgba(197,164,109,0.35);
}

/* BOTON */
input[type="submit"] {
  grid-area: boton;
  margin-top: 15px;
  padding: 16px;
  background: #364e63;
  color: #f5e9d8;
  border: 2px solid #364e63;
  border-radius: 14px;
  font-size: 19px;
  font-family: "Playfair Display", serif;
  cursor: pointer;
  transition: 0.35s ease, transform 0.25s ease;
  font-weight: 700;
  box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}

input[type="submit"]:hover {
  background: #c5a46d;
  color: #364e63;
  border-color: #c5a46d;
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(77,103,127,0.35);
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
  .imagen { min-height: 230px; }
  h2, legend { text-align: center; }
  input[type="submit"] { width: 100%; }
}
</style>
</head>

<body>

<form action="updateprodu.php" method="POST">
  <div class="imagen"></div>

  <h2>MODIFICACIÓN DE PRODUCTO DIVINE</h2>

  <legend>PRODUCTO A MODIFICAR:</legend>

  <div class="grupo-campos">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $nombre ?>" required>

    <label>Cantidad:</label>
    <input type="number" name="cantidad" value="<?= $cantidad ?>" required>

    <label>Precio:</label>
    <input type="number" name="precio" value="<?= $precio ?>" required>

    <label>Costo:</label>
    <input type="number" name="costo" value="<?= $costo ?>" required>

    <label>Categoría:</label>
    <input type="text" name="categoria" value="<?= $categoria ?>" required>

    <label>Código:</label>
    <input type="number" name="codigo" value="<?= $codigo ?>" required>

  </div>

  <input type="submit" value="Actualizar">
</form>

</body>
</html>
