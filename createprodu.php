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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Guardar Producto - DIVINE</title>

<!-- Tipografía -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet" />

<style>
  body {
    font-family: "Playfair Display", serif;
    background-color: #f5e9d8;
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
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
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

  .encabezado {
    grid-area: encabezado;
    font-size: 36px;
    font-weight: 700;
    color: #364e63;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-bottom: 3px solid #c5a46d;
    padding-bottom: 10px;
  }

  .contenido {
    grid-area: contenido;
    background: #f5e9d8;
    border-radius: 20px;
    padding: 30px 25px;
    box-shadow: 0 4px 10px rgba(54, 78, 99, 0.2);
    font-size: 18px;
    color: #2b2b2b;
  }

  .mensaje {
    border-radius: 12px;
    padding: 20px;
    font-weight: 600;
    margin-bottom: 15px;
  }

  .exito {
    background-color: #c5a46d;
    color: white;
    box-shadow: 0 4px 12px rgba(197, 164, 109, 0.7);
  }

  .error {
    background-color: #b53737;
    color: white;
    box-shadow: 0 4px 12px rgba(181, 55, 55, 0.7);
  }

  .botones {
    grid-area: botones;
    display: flex;
    justify-content: center;
    gap: 25px;
  }

  .boton {
    text-decoration: none;
    background: #364e63;
    color: #c5a46d;
    padding: 14px 38px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 17px;
    box-shadow: 0 4px 15px rgba(54, 78, 99, 0.6);
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.25s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .boton:hover {
    background-color: #c5a46d;
    color: #364e63;
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(197, 164, 109, 0.9);
  }

  @media (max-width: 600px) {
    .contenedor {
      padding: 25px;
    }
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
          echo '<div class="mensaje error">❌ NO TE PUDISTE CONECTAR CON LA BD UnU</div>';
      } else {
          echo " ";
      }

      $nombre = $_POST['nombre'];
      $cantidad = $_POST['cantidad'];
      $precio = $_POST['precio'];
      $costo = $_POST['costo'];
      $categoria = $_POST['categoria'];
      $codigo = $_POST['codigo'];

      $sql = "INSERT INTO PRODUCTO (nombre,cantidad,precio,costo,categoria,codigo)
       VALUES('$nombre', '$cantidad','$precio','$costo','$categoria','$codigo')";

      if ($conn->query($sql) === TRUE) {
          echo '<div class="mensaje exito"> ✔ PRODUCTO GUARDADO EXITOSAMENTE</div>';
      } else {
          echo '<div class="mensaje error"> ⚠  ERROR: ' . $sql . '<br>' . $conn->error . '</div>';
      }

      $conn->close();
      ?>
    </div>

    <div class="botones">
      <a href="paginaprinc2.php" class="boton">⬅ Volver al inicio</a>
      <a href="readtodoprodu.php" class="boton">Ver productos ➡</a>
    </div>
  </div>
</body>
</html>
