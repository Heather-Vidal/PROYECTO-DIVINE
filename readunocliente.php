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
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detalle del Cliente - DIVINE</title>

<!-- TIPOGRAFÍA -->
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
  max-width: 600px;
  display: grid;
  grid-template-columns: 1fr;
  grid-gap: 30px;
}

/* Imagen decorativa */
.imagen {
  background: url("https://cdn-icons-png.flaticon.com/512/3106/3106921.png") center / contain no-repeat;
  border-radius: 20px;
  min-height: 200px;  
}

/* Título elegante */
.titulo {
  text-align: center;
  color: #364e63;
  font-size: 30px;
  font-weight: 700;
  margin: 0;
  letter-spacing: 2px;

  border-bottom: 3px solid #c5a46d;
  width: fit-content;
  margin: 0 auto;
  padding-bottom: 6px;
}

/* Caja del cliente */
.item {
  background: #f5e9d8;
  padding: 25px;
  border-radius: 20px;
  box-shadow: 0 4px 10px rgba(54,78,99,0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover */
.item:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 22px rgba(54,78,99,0.4);
}

.item p {
  margin: 10px 0;
  font-size: 17px;
  color: #2b2b2b;
}

.item span {
  font-weight: 700;
  color: #364e63;
}

/* Botones tipo PRODUCTO */
.botones {
  margin-top: 20px;
  text-align: center;
  display: flex;
  justify-content: center;
  gap: 15px;
  flex-wrap: wrap;
}

/* Botones estilos */
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

/* NAV estilo del código de producto */
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

/* MEDIA QUERY copiado del estilo de PRODUCTO */
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

    <h2 class="titulo">DETALLE DEL CLIENTE</h2>

    <div class="item">
<?php
while($fila=$resultado->fetch_assoc()){
  echo "<p><span>DNI:</span> ".$fila['dni']."</p>";
  echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
  echo "<p><span>Apellido:</span> ".$fila['apellido']."</p>";
  echo "<p><span>Dirección:</span> ".$fila['direccion']."</p>";
  echo "<p><span>Fecha de Nacimiento:</span> ".$fila['nacimiento']."</p>";
  echo "<p><span>Teléfono:</span> ".$fila['telefono']."</p>";

  $dni=$fila['dni'];
}
?>
    </div>

    <!-- ACCIONES DEL CLIENTE -->
    <div class="botones">
      <a class="boton" href="updateformcliente.php?dni=<?php echo $dni; ?>">Editar</a>
      <a class="boton" href="deletecliente.php?dni=<?php echo $dni; ?>">Eliminar</a>
    </div>

    <!-- NAVEGACIÓN GLOBAL -->
    <div class="navegacion">
      <a class="boton2" href="readtodocliente.php">Ver clientes</a>
      <a class="boton2" href="paginaprinc2.php">⬅ Volver al inicio</a>
    </div>

  </div>
</body>
</html>

<?php
}
$conn->close();
?>