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
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detalle del Producto - DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>
body {
  font-family: "Playfair Display", serif;
  background: #f5e9d8;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #2b2b2b;
}

.contenedor {
  background: #e9e5dd;
  padding: 40px;
  border-radius: 25px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  width: 90%;
  max-width: 700px;
  display: grid;
  grid-template-columns: 1fr;
  grid-gap: 25px;
}

.imagen {
  background: url("https://i.pinimg.com/1200x/43/31/47/433147cd3e9cdb74e27685ddbace85e8.jpg") center center / cover no-repeat;
  border-radius: 20px;
  min-height: 300px;
}

.titulo {
  text-align: center;
  color: #364e63;
  font-size: 32px;
  font-weight: 700;
  margin: 0;
  letter-spacing: 2px;

  /* línea dorada */
  border-bottom: 3px solid #c5a46d;
  padding-bottom: 10px;
  width: fit-content;
  margin-left: auto;
  margin-right: auto;
}

.item {
  background: #f5e9d8;
  padding: 25px;
  border-radius: 20px;
  box-shadow: 0 4px 10px rgba(54,78,99,0.25);
  transition: transform 0.3s ease;
}

.item:hover {
  transform: translateY(-5px);
}

.item p {
  margin: 8px 0;
  color: #2b2b2b;
  font-size: 17px;
}

.item span {
  font-weight: bold;
  color: #364e63;
}

/* Botones de edición y eliminación */
.botones {
  margin-top: 20px;
  text-align: center;
  display: flex;
  justify-content: center;
  gap: 15px;
}

.boton {
  background: #364e63;
  color: #c5a46d;
  padding: 10px 22px;
  border-radius: 28px;
  font-size: 16px;
  font-weight: 700;
  text-decoration: none;
  transition: 0.3s ease;
}

.boton:hover {
  background: #c5a46d;
  color: #364e63;
  transform: scale(1.05);
  box-shadow: 0 5px 20px rgba(197,164,109,0.7);
}

/* NAV inferior: volver e ir a lista */
.navegacion {
  margin-top: 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.boton2 {
  background: #364e63;
  color: #c5a46d;
  padding: 12px 28px;
  border-radius: 28px;
  font-size: 17px;
  font-weight: 700;
  text-decoration: none;
  transition: 0.3s ease;
}

.boton2:hover {
  background: #c5a46d;
  color: #364e63;
  transform: scale(1.04);
  box-shadow: 0 5px 20px rgba(197,164,109,0.7);
}

@media (max-width: 768px) {
  .contenedor {
    padding: 25px;
  }
  .imagen {
    min-height: 200px;
  }
}
</style>
</head>

<body>
  <div class="contenedor">
    <div class="imagen"></div>
    <h2 class="titulo">DETALLE DEL PRODUCTO</h2>

    <div class="item">
<?php
while($fila=$resultado->fetch_assoc()){
  echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
  echo "<p><span>Cantidad:</span> ".$fila['cantidad']."</p>";
  echo "<p><span>Precio:</span> ".$fila['precio']."</p>";
  echo "<p><span>Costo:</span> ".$fila['costo']."</p>";
  echo "<p><span>Categoría:</span> ".$fila['categoria']."</p>";
  echo "<p><span>Codigo:</span> ".$fila['codigo']."</p>";
  $codigo=$fila['codigo'];
}
?>
    </div>

    <!-- ACCIONES DEL PRODUCTO -->
    <div class="botones">
      <a href="updateformprodu.php?codigo=<?php echo $codigo; ?>" class="boton">Editar</a>
      <a href="deleteprodu.php?codigo=<?php echo $codigo; ?>" class="boton">Eliminar</a>
    </div>

    <!-- NAVEGACIÓN GLOBAL -->
    <div class="navegacion">
      <a href="readtodoprodu.php" class="boton2">Ver productos</a>
      <a href="paginaprinc2.php" class="boton2">⬅ Volver al inicio</a>
    </div>

  </div>
</body>
</html>

<?php
}
$conn->close();
?>
