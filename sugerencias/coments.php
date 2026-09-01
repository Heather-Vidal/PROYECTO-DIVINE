<?php
$archivo = 'mensajes.txt';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Publicaciones</title>
  <style>
    body { font-family: Arial; margin: 30px; }
    .post { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
  </style>
</head>
<body>

  <h1>Publicaciones</h1>
  <p><a href="publicar.php">← Volver a comentar</a></p>
  <hr>

  <?php
  if (file_exists($archivo)) {
      $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $lineas = array_reverse($lineas);

      foreach ($lineas as $linea) {
          echo '<div class="post">' . htmlspecialchars($linea) . '</div>';
      }
  } else {
      echo '<p>No hay publicaciones aún.</p>';
  }
  ?>

</body>
</html>