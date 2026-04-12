 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
  echo"OCURRIÓ UN ERROR SORRY UnU";
}

$sql="SELECT * FROM PRODUCTO";
$resultado=$conn-> query($sql);

if($resultado->num_rows > 0){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Productos DIVINE</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />
<style>
body {
  font-family: 'Playfair Display', serif; /* Tipografía elegante */
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
  max-width: 1000px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 25px;
  grid-template-areas:
    "imagen titulo"
    "imagen lista"
    "imagen lista"
    "imagen lista";
}

.imagen {
  grid-area: imagen;
  background: url("https://i.pinimg.com/736x/23/fd/c5/23fdc5871b591de154e3e9b889036562.jpg") center center / cover no-repeat;
  border-radius: 20px;
  min-height: 400px;
}

.titulo {
  grid-area: titulo;
  text-align: left;
  color: #364e63;
  font-size: 28px;
  font-weight: 700;
  margin: 0;
  letter-spacing: 1px;
  align-self: end;
   border-bottom: 3px solid #c5a46d;
  padding-bottom: 8px;
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
  box-shadow: 0 4px 10px rgba(54,78,99,0.2);
  transition: all 0.3s ease;
}

.item:hover {
  background: #e0d5b0;
  transform: translateY(-6px); /* sube un poquito al pasar el mouse */
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
  padding: 10px 20px;
  cursor: pointer;
  font-weight: 600;
  font-size: 15px;
  transition: all 0.3s ease;
}

.botones button:hover {
  background: #c5a46d;
  color: #364e63;
  transform: scale(1.05);
}

.volver {
  grid-column: span 2;
  text-align: center;
  margin-top: 25px;
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
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.25s ease;
}

.volver a:hover {
  background-color: #c5a46d;
  color: #364e63;
  transform: scale(1.05);
}

/* Versión para celular */
@media (max-width: 768px) {
  .contenedor {
    grid-template-columns: 1fr;
    grid-template-rows: auto auto auto;
    grid-template-areas:
      "imagen"
      "titulo"
      "lista";
    padding: 25px;
  }

  .imagen {
    min-height: 200px;
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
    <h2 class="titulo">LISTA DE PRODUCTOS DIVINE</h2>
    <div class="lista">
<?php
while($fila=$resultado->fetch_assoc()){
  echo "<div class='item'>";
  echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
  echo "<p><span>Cantidad:</span> ".$fila['cantidad']."</p>";
  echo "<p><span>Precio:</span> ".$fila['precio']."</p>";
  echo "<p><span>Costo:</span> ".$fila['costo']."</p>";
  echo "<p><span>Categoría:</span> ".$fila['categoria']."</p>";
  echo "<p><span>Código:</span> ".$fila['codigo']."</p>";
  $codigo=$fila['codigo'];
  echo "<div class='botones'>";
  echo "<a href='readunoprodu.php?codigo=$codigo'><button>Mostrar</button></a>";
  echo "<a href='updateformprodu.php?codigo=$codigo'><button>Editar</button></a>";
  echo "<a href='deleteprodu.php?codigo=$codigo'><button>Eliminar</button></a>";
  echo "</div>";
  echo "</div>";
}
?>
    </div>
    <div class="volver">
      <a href="paginaprinc2.php">⬅ Volver al inicio</a>
    </div>
  </div>
</body>
</html>
<?php
}
$conn->close();
?>
