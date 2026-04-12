 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
  echo"OCURRiO UN ERROR SORRY UnU";
}

$sql="SELECT * FROM CLIENTE";
$resultado=$conn-> query($sql);

if($resultado->num_rows > 0){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Clientes DIVINE</title>

<!-- TIPOGRAFÍA ELEGANTE -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>
body {
  font-family: 'Playfair Display', serif;
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
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
  width: 90%;
  max-width: 1000px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 25px;
  grid-template-areas:
    "imagen titulo"
    "imagen lista"
    "imagen lista";
}

.imagen {
  grid-area: imagen;
  background: url("https://i.pinimg.com/1200x/8a/80/67/8a80676d930e8249245bebd93d768ea1.jpg") center center / cover no-repeat;
  border-radius: 20px;
  min-height: 400px;
   opacity: 1;
}

.titulo {
  grid-area: titulo;
  text-align: left;
  color: #364e63;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 1px;
  margin: 0;
  align-self: end;
  border-bottom: 3px solid #c5a46d;
  padding-bottom: 6px;
  width: fit-content;
}

.lista {
  grid-area: lista;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.item {
  background: #f5e9d8;
  padding: 20px;
  border-radius: 20px;
  box-shadow: 0 4px 10px rgba(54,78,99,0.25);
  transition: 0.3s ease;
}

.item:hover {
  background: #e0d5b0;
  transform: translateY(-5px);
}

.item p {
  margin: 6px 0;
  color: #2b2b2b;
  font-size: 16px;
}

.item span {
  font-weight: bold;
  color: #364e63;
}

.botones {
  margin-top: 10px;
  display: flex;
  gap: 10px;
}

.botones button {
  background: #364e63;
  color: #c5a46d;
  border: none;
  border-radius: 25px;
  padding: 10px 22px;
  cursor: pointer;
  font-weight: 600;
  font-size: 15px;
  transition: 0.3s ease;
  box-shadow: 0 3px 8px rgba(54,78,99,0.3);
}

.botones button:hover {
  background: #c5a46d;
  color: #364e63;
  transform: scale(1.05);
  box-shadow: 0 6px 15px rgba(197,164,109,0.8);
}

.volver {
  grid-column: span 2;
  text-align: center;
  margin-top: 20px;
}

.volver a {
  text-decoration: none;
  background: #364e63;
  color: #c5a46d;
  padding: 14px 38px;
  border-radius: 30px;
  font-weight: 700;
  font-size: 17px;
  box-shadow: 0 4px 15px rgba(54,78,99,0.6);
  transition: 0.3s ease;
}

.volver a:hover {
  background: #c5a46d;
  color: #364e63;
  transform: scale(1.06);
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .contenedor {
    grid-template-columns: 1fr;
    grid-template-areas:
      "imagen"
      "titulo"
      "lista";
    padding: 25px;
  }

  .imagen {
    min-height: 220px;
  }

  .titulo {
    text-align: center;
  }
}
</style>
</head>

<body>
  <div class="contenedor">
    <div class="imagen"></div>
    <h2 class="titulo">LISTA DE CLIENTES</h2>
    <div class="lista">

<?php
while($fila=$resultado->fetch_assoc()){
  echo "<div class='item'>";
  echo "<p><span>DNI:</span> ".$fila['dni']."</p>";
  echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
  echo "<p><span>Apellido:</span> ".$fila['apellido']."</p>";
  echo "<p><span>Direccion:</span> ".$fila['direccion']."</p>";
  echo "<p><span>Fecha de Nacimiento:</span> ".$fila['nacimiento']."</p>";
  echo "<p><span>Telefono:</span> ".$fila['telefono']."</p>";

  $dni=$fila['dni'];

  echo "<div class='botones'>";
  echo "<a href='readunocliente.php? dni=$dni '><button>Mostrar</button></a>";
  echo "<a href='updateformcliente.php? dni=$dni '><button>Editar</button></a>";
  echo "<a href='deletecliente.php? dni=$dni '><button>Eliminar</button></a>";
  echo "</div>";

  echo "</div>";
}
?>
    </div>

    <div class='volver'>
      <a href="paginaprinc2.php">⬅ Volver al inicio</a>
    </div>

  </div>
</body>
</html>

<?php
}
?>