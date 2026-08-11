  <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);                 
 
if($conn->connect_error){
  echo"OCURRiO UN ERROR SORRYYYYYYYYYYYY UnU";
}

$CI=$_GET['CI'];
$sql="SELECT * FROM CLIENTE WHERE CI=$CI";
$resultado=$conn-> query($sql);

if($resultado->num_rows > 0){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detalle del Cliente - DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>
body {
  font-family: "Playfair Display", serif;
   background-image:url('../imagenes/dudu.png');
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #ffffff;
}

.contenedor {
  background: #ff8b8bc9;
  padding: 40px;
  border-radius: 25px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  width: 90%;
  max-width: 600px;
  display: grid;
  grid-template-columns: 1fr;
  grid-gap: 30px;
}
.imagen {
  background: url("../imagenes/persona.png") center / contain no-repeat;
  border-radius: 20px;
  min-height: 200px;  
}

.titulo {
  text-align: center;
  color: #4b3441;
  font-size: 30px;
  font-weight: 700;
  margin: 0;
  letter-spacing: 2px;

  border-bottom: 3px solid #a01c1c;
  width: fit-content;
  margin: 0 auto;
  padding-bottom: 6px;
}
.item {
  background: #97383896;
  padding: 25px;
  border-radius: 20px;
  box-shadow: 0 4px 10px rgba(211, 0, 0, 0.37);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover */
.item:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 22px rgba(255, 0, 0, 0.38);
}

.item p {
  margin: 10px 0;
  font-size: 17px;
  color: #462b33;
}

.item span {
  font-weight: 700;
  color: #351c25;
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

.boton {
  background: #97383896;;
  color: #571731;
  padding: 10px 22px;
  border-radius: 28px;
  font-size: 16px;
  font-weight: 700;
  text-decoration: none;
  transition: 0.3s ease;
}

.boton:hover {
  background: #9b5c61;
  color: #422b35;
  transform: scale(1.05);
  box-shadow: 0 5px 20px rgba(207, 64, 64, 0.7);
}

.navegacion {
  margin-top: 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.boton2 {
  background: #97383896;;
  color: #493039;
  padding: 12px 28px;
  border-radius: 28px;
  font-size: 17px;
  font-weight: 700;
  text-decoration: none;
  transition: 0.3s ease;
}

.boton2:hover {
  background: #773838;
  color: #2b1515;
  transform: scale(1.04);
  box-shadow: 0 5px 20px rgba(27, 15, 16, 0.7);
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

    <h2 class="titulo">DETALLE DEL CLIENTE</h2>

    <div class="item">
<?php
while($fila=$resultado->fetch_assoc()){
  echo "<p><span>CI:</span> ".$fila['CI']."</p>";
  echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
  echo "<p><span>Direccion:</span> ".$fila['direccion']."</p>";
  echo "<p><span>Telefono:</span> ".$fila['celular']."</p>";
  echo "<p><span>Rol:</span> ".$fila['rol']."</p>";
  echo "<p><span>Estado:</span> ".$fila['estado']."</p>";

  $CI=$fila['CI'];


$estado = $fila['estado'];





}
?>
    </div>

    <!-- ACCIONES DEL CLIENTE -->
    <div class="botones">
      <a class="boton" href="updateformcliente.php?CI=<?php echo $CI; ?>">Editar</a>
      <a class="boton" href="deletecliente.php?CI=<?php echo $CI; ?>">Eliminar</a>


    <?php
    if ($estado == 'ACTIVO') {
        echo '<a class="boton" href="../BLOQUEOS-usuario/bloquear.php?CI=' . $CI . '">Bloquear</a>';
    } else {
        echo '<a class="boton" href="../BLOQUEOS-usuario/desbloquear.php?CI=' . $CI . '">Desbloquear</a>';
    }
    ?>

    </div>

    <!-- NAVEGACIÓN GLOBAL -->
    <div class="navegacion">
      <a class="boton2" href="readtodocliente.php">Ver clientes</a>
    
<button class="boton2" type="button" onclick="history.back()">⬅ Volver atrás</button>

    </div>

  </div>
</body>
</html>

<?php
}
$conn->close();
?>