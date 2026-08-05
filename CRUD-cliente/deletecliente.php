<?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eliminar Cliente - DIVINE</title>

<!-- TIPOGRAFÍA -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #e9e5dd;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #5e3045;
}

.contenedor {
  position: relative;
  background: rgba(255, 212, 234, 0.9);
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
  width: 90%;
  max-width: 650px;
  display: grid;
  grid-template-columns: 1fr;
  grid-template-areas:
    "encabezado"
    "contenido"
    "botones";
  gap: 25px;
}

.encabezado {
  grid-area: encabezado;
  margin: 0;
  font-size: 32px;
  color: #8b4f6b;
  font-family: "Playfair Display", serif;
  letter-spacing: 1px;
  border-bottom: 3px solid #fc63af;
  padding-bottom: 10px;
  text-align: center;
}

.contenido {
  grid-area: contenido;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.icono {
  width: 180px;
  margin-bottom: 20px;
}

.mensaje {
  width: 100%;
  max-width: 450px;
  padding: 16px;
  border-radius: 10px;
  font-size: 17px;
  font-weight: bold;
  margin-top: 10px;
  box-sizing: border-box;
}

.exito {
  background: #c56d99;
  color: #fff;
  box-shadow: 0 5px 12px rgba(197,109,153,.4);
}

.error {
  background: #b53737;
  color: #fff;
  box-shadow: 0 5px 12px rgba(181,55,55,.4);
}

.botones {
  grid-area: botones;
  display: flex;
  justify-content: center;
}

.boton {
  text-decoration: none;
  padding: 14px 35px;
  background: #63364b;
  color: #fff;
  border-radius: 10px;
  font-size: 17px;
  font-weight: bold;
  letter-spacing: 1px;
  transition: .3s;
  box-shadow: 0 5px 12px rgba(0,0,0,.25);
}

.boton:hover {
  background: #c56d99;
  transform: scale(1.03);
}

@media (max-width:768px){

  .contenedor{
    padding:25px;
  }

  .icono{
    width:140px;
  }

  .encabezado{
    font-size:28px;
  }

  .boton{
    width:100%;
    text-align:center;
  }
}
</style>
</head>

<body>
  <div class="contenedor">
    
    <div class="encabezado">Cliente Eliminado</div>

    <div class="contenido">
      
      <!-- Imagen como en los otros ejemplos -->
      <img src="../imagenes/personaform.png" class="icono">

<?php
if($conn->connect_error){
  echo "<div class='mensaje error'>❌ OCURRIÓ UN ERROR AL CONECTAR A LA BASE DE DATOS</div>";
} else {
    $CI = $_GET['CI'] ?? '';

    if($CI){
        $sql="DELETE FROM CLIENTE WHERE CI=$CI";

        if ($conn->query($sql)=== TRUE){
            echo "<div class='mensaje exito'>✔ EL CLIENTE HA SIDO ELIMINADO CON ÉXITO</div>";
        } else {
            echo "<div class='mensaje error'>⚠ ERROR AL ELIMINAR: ".$conn->error."</div>";
        }
    } else {
        echo "<div class='mensaje error'>❌ CI no especificado</div>";
    }
}

$conn->close();
?>
    </div>

    <div class="botones">
      <a href="readtodocliente.php" class="boton">⬅ Volver a clientes</a>
    </div>

  </div>
</body>
</html>
