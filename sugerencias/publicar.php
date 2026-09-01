<?php
$archivo = 'mensajes.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $autor = trim($_POST['autor']);
    $contenido = trim($_POST['contenido']);

    $fecha = date("Y-m-d H:i:s");
    $entrada = "$fecha | $autor: $contenido" . PHP_EOL;

    $f = fopen($archivo, 'a');
    fwrite($f, $entrada);
    fclose($f);

    // Redirige a la página donde se muestran los comentarios
    header("Location: comentarios.php");
    exit; // importante: detener la ejecución después del redirect
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"> 
  <title>Publicar comentario</title>
    <link rel="stylesheet" href="estilos.css">
  <style>
    body { font-family: Arial; margin: 30px; }
    textarea { width: 100%; }
  </style>
</head>
<body>
<?php include '../menus.php' ?>
  <h1>Escribe tu comentario</h1>

  <form method="POST">
    <input type="text" name="autor" placeholder="Tu nombre" required><br><br>
    <textarea name="contenido" rows="4" placeholder="Escribe algo..." required></textarea><br><br>
    <button type="submit">Publicar</button>
  </form>

</body>
</html>