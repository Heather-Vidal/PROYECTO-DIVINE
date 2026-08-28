
<?php
$archivo = 'mensajes.txt';

// Guardar mensaje si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $autor = trim($_POST['autor']);
    $contenido = trim($_POST['contenido']);

        $fecha = date("Y-m-d H:i:s");
        $entrada = "$fecha | $autor: $contenido" . PHP_EOL;

        $f = fopen($archivo, 'a');
        fwrite($f, $entrada);
        fclose($f);
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tablón de Publicaciones</title>
  <style>
    body { font-family: Arial; margin: 30px; }
    textarea { width: 100%; }
    .post { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
  </style>
</head>
<body>

  <h1>Tablón de Publicaciones</h1>

  <form method="POST">
    <input type="text" name="autor" placeholder="Tu nombre" required><br><br>
    <textarea name="contenido" rows="4" placeholder="Escribe algo..." required></textarea><br><br>
    <button type="submit">Publicar</button>
  </form>

  <hr>

  <h2>Publicaciones</h2>

  <?php
  if (file_exists($archivo)) {
      $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $lineas = array_reverse($lineas); // Mostrar las más recientes arriba

      foreach ($lineas as $linea) {
          echo '<div class="post">' . htmlspecialchars($linea) . '</div>';
      }
  } else {
      echo '<p>No hay publicaciones aún.</p>';
  }
  ?>
</body>
</html>
