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
    font-family: 'Poppins', sans-serif;
    background: #e9e5dd;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 40px 0;
    color: #63364b;

    background-image: url('../imagenes/fondote.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .contenedor {
    background: rgba(255, 212, 234, 0.92);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
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
    font-family: "Playfair Display", serif;
    font-size: 36px;
    font-weight: 700;
    color: #8b4f6b;
    letter-spacing: 2px;
    text-transform: uppercase;

    border-bottom: 3px solid #fc63af;
    padding-bottom: 10px;

    width: fit-content;
    margin: 0 auto;
  }

  .contenido {
    grid-area: contenido;

    background: rgba(255, 255, 255, 0.75);
    border-radius: 15px;
    padding: 30px 25px;

    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);

    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: #63364b;
  }

  .mensaje {
    border-radius: 10px;
    padding: 20px;
    font-weight: 600;
    margin-bottom: 15px;

    font-family: 'Poppins', sans-serif;
  }

  .exito {
    background-color: #c56d99;
    color: #ffffff;
    box-shadow: 0 5px 12px rgba(197, 109, 153, 0.45);
  }

  .error {
    background-color: #8b4f6b;
    color: #ffffff;
    box-shadow: 0 5px 12px rgba(139, 79, 107, 0.45);
  }

  .botones {
    grid-area: botones;
    display: flex;
    justify-content: center;
    gap: 20px;
  }

  .boton {
    text-decoration: none;

    background: #63364b;
    color: #ffffff;

    padding: 14px 30px;
    border-radius: 10px;

    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 15px;

    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.25);

    transition: 0.3s;

    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .boton:hover {
    background-color: #c56d99;
    color: #ffffff;

    transform: scale(1.03);

    box-shadow: 0 6px 15px rgba(197, 109, 153, 0.5);
  }

  @media (max-width: 600px) {

    .contenedor {
      padding: 25px;
      width: 80%;
    }

    .encabezado {
      font-size: 30px;
    }

    .botones {
      flex-direction: column;
      gap: 15px;
    }

    .boton {
      width: 100%;
      box-sizing: border-box;
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
      $descripcion = $_POST['descripcion'];
      $precio = $_POST['precio'];
      $costo = $_POST['costo'];
      $stock = $_POST['stock'];
      $codigo = $_POST['codigo'];

      $sql = "INSERT INTO PRODUCTO (nombre,descripcion,precio,costo,stock,codigo)
       VALUES('$nombre', '$descripcion','$precio','$costo','$stock','$codigo')";




   //Define a que carpeta irá el archivo
    $target_dir = "../PRODUCTO-img/";
    //recuperar el tipo de archivo (extension)
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
    //Define el nombre del archivo P-[codigo del producto]
    $newFileName = "P-".$codigo.".".$imageFileType;
    //ruta comppleta de carpeta+nombre donde se guardara el archivo
    $target_file = $target_dir . $newFileName;
    //variable que funcionara como "bandera" si el valor es 1 se puede subir, si es 0 algo pasó
    $uploadOk = 1;
    echo $target_file;

    // Verificar si el archivo existe
    if (file_exists($target_file)) {
        echo "Lo sentimos, ya subiste este archivo.";
        $uploadOk = 0;
    }
    // Validar extensiones permitidas
    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" &&$imageFileType != "gif")
    {
        echo "Solo se permiten imágenes JPG, JPEG, PNG o GIF.<br>";
        $uploadOk = 0;
    }
    //subir archivo
    if ($uploadOk == 0) {
        echo "Ocurrió algun error.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " se subió.";
            header("Location: readtodoprodu.php");
    echo "Producto registrado correctamente";
        } else {
            echo "No se pudo subir tu archivo.";
        }
    }
 















      if ($conn->query($sql) === TRUE) {
          echo '<div class="mensaje exito"> ✔ PRODUCTO GUARDADO EXITOSAMENTE</div>';
      } else {
          echo '<div class="mensaje error"> ⚠  ERROR: ' . $sql . '<br>' . $conn->error . '</div>';
      }

      $conn->close();
      ?>
    </div>

    <div class="botones">
      <a href="../totu.php" class="boton">⬅ Volver al inicio</a>
      <a href="readtodoprodu.php" class="boton">Ver productos ➡</a>
    </div>
  </div>
</body>
</html>
