<?php 
$archivo = 'mensajes.txt'; 
?> 
 
<!DOCTYPE html> 
<html lang="es"> 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publicaciones</title> 
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style> 
    * {
      box-sizing: border-box;
    }

    body { 
      font-family: "Georgia", "Times New Roman", serif;
      margin: 0;
      padding: 50px 20px;
      min-height: 100vh;

      background:
        linear-gradient(
          rgba(255, 240, 246, 0.88),
          rgba(242, 232, 245, 0.94)
        ),
        url("../imagenes/mezcla.jpg");

      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;

      color: #654b59;
    }

    /* CONTENEDOR PRINCIPAL */
    .contenedor {
      width: 100%;
      max-width: 900px;
      margin: auto;
      padding: 45px 50px;

      background: rgba(255, 252, 253, 0.97);
      border: 1px solid rgba(218, 174, 193, 0.45);
      border-radius: 30px;

      box-shadow:
        0 20px 60px rgba(126, 82, 105, 0.18),
        0 5px 18px rgba(126, 82, 105, 0.08);

      position: relative;
      overflow: hidden;
    }

    /* DECORACIÓN */
    .contenedor::before {
      content: "♡";
      position: absolute;
      top: -35px;
      right: 20px;
      font-size: 130px;
      color: rgba(221, 170, 192, 0.10);
      font-family: Arial, sans-serif;
    }

    .contenedor::after {
      content: "✿";
      position: absolute;
      bottom: -35px;
      left: 20px;
      font-size: 100px;
      color: rgba(221, 170, 192, 0.08);
    }

    /* TÍTULO */
    h1 { 
      text-align: center;
      color: #a8758b;
      font-size: 40px;
      font-weight: normal;
      letter-spacing: 1px;
      margin: 0 0 8px;

      position: relative;
      z-index: 2;
    }

    h1::after {
      content: "♡  ✦  ♡";
      display: block;
      font-family: Arial, sans-serif;
      font-size: 17px;
      letter-spacing: 5px;
      color: #d5a0b5;
      margin-top: 10px;
    }

    /* SUBTÍTULO */
    .subtitulo {
      text-align: center;
      color: #a58b98;
      font-family: Arial, sans-serif;
      font-size: 15px;
      letter-spacing: 0.3px;
      margin: 0 0 28px;

      position: relative;
      z-index: 2;
    }

    /* BOTÓN COMENTAR */
    .volver {
      display: block;
      width: fit-content;
      margin: auto;

      text-decoration: none;

      background: linear-gradient(
        135deg,
        #e9c4d3,
        #d8a5ba
      );

      color: #684957;

      padding: 13px 30px;
      border-radius: 30px;

      font-family: Arial, sans-serif;
      font-size: 14px;
      font-weight: bold;

      box-shadow:
        0 6px 18px rgba(174, 119, 142, 0.22);

      transition: all 0.3s ease;

      position: relative;
      z-index: 2;
    }

    .volver:hover {
      background: linear-gradient(
        135deg,
        #d9afc1,
        #c997ad
      );

      color: white;

      transform: translateY(-4px);

      box-shadow:
        0 10px 25px rgba(174, 119, 142, 0.30);
    }

    /* LÍNEA */
    hr {
      border: none;
      height: 1px;

      background: linear-gradient(
        to right,
        transparent,
        #dfb9c9,
        transparent
      );

      margin: 38px 0 30px;
    }

    /* CONTENEDOR DE COMENTARIOS */
    .publicaciones {
      display: flex;
      flex-direction: column;
      gap: 20px;

      position: relative;
      z-index: 2;
    }

    /* CADA COMENTARIO */
    .post { 
      position: relative;

      padding: 24px 28px 24px 58px;

      background:
        linear-gradient(
          135deg,
          rgba(255, 249, 251, 0.98),
          rgba(250, 240, 246, 0.98)
        );

      border: 1px solid #ecd3df;
      border-radius: 20px;

      color: #6e5260;

      font-family: Arial, sans-serif;
      font-size: 15px;
      line-height: 1.7;

      box-shadow:
        0 7px 20px rgba(126, 82, 105, 0.08);

      transition: all 0.3s ease;

      overflow: hidden;
    }

    /* Corazón de cada comentario */
    .post::before {
      content: "♡";

      position: absolute;
      left: 20px;
      top: 22px;

      width: 27px;
      height: 27px;

      display: flex;
      align-items: center;
      justify-content: center;

      background: #f1d5e0;
      color: #bd829b;

      border-radius: 50%;

      font-size: 17px;
      font-family: Arial, sans-serif;
    }

    /* Detalle superior */
    .post::after {
      content: "";

      position: absolute;
      top: 0;
      left: 0;

      width: 100%;
      height: 4px;

      background: linear-gradient(
        to right,
        #d9a9bc,
        #efcbd9,
        #d9a9bc
      );
    }

    /* EFECTO AL PASAR EL MOUSE */
    .post:hover {
      transform: translateY(-5px);

      background:
        linear-gradient(
          135deg,
          #fffafd,
          #fdf1f6
        );

      border-color: #dcb2c4;

      box-shadow:
        0 12px 28px rgba(126, 82, 105, 0.14);
    }

    .post:hover::before {
      background: #dfb4c7;
      color: white;
      transform: scale(1.08);
    }

    /* TEXTO DEL COMENTARIO */
    .post-texto {
      position: relative;
      z-index: 2;
    }

    /* CUANDO NO HAY PUBLICACIONES */
    .sin-publicaciones {
      text-align: center;
      padding: 40px 25px;

      background:
        linear-gradient(
          135deg,
          #fff7fa,
          #f8eef5
        );

      border: 1px dashed #ddb8c8;
      border-radius: 20px;

      color: #a17c8e;

      font-family: Arial, sans-serif;
      font-size: 15px;

      position: relative;
      z-index: 2;
    }

    .sin-publicaciones::before {
      content: "♡";
      display: block;

      font-size: 35px;
      color: #d5a0b5;

      margin-bottom: 8px;
    }

    /* RESPONSIVE */
    @media (max-width: 600px) {

      body {
        padding: 25px 12px;
      }

      .contenedor {
        padding: 30px 18px;
        border-radius: 23px;
      }

      h1 {
        font-size: 31px;
      }

      .subtitulo {
        font-size: 14px;
        line-height: 1.5;
        padding: 0 10px;
      }

      .volver {
        padding: 11px 24px;
      }

      .post {
        padding: 22px 18px 22px 52px;
        font-size: 14px;
        line-height: 1.6;
        border-radius: 17px;
      }

      .post::before {
        left: 17px;
        top: 20px;
      }
    }
  </style> 
</head> 
 
<body> 
 <script>
<?php
if (isset($_GET['guardado']) && $_GET['guardado'] == '1') {
?>
    Swal.fire({
        icon: 'success',
        title: '¡Comentario guardado!',
        text: 'Tu comentario se guardó correctamente.',
        confirmButtonText: 'Aceptar'
    });
<?php
}
?>
</script>
  <div class="contenedor">

    <h1>Publicaciones</h1>

    <p class="subtitulo">
      Comentarios y sugerencias de nuestros clientes
    </p>

    <a class="volver" href="publicar.php">
      ♡ Comentar
    </a> 

    <hr> 
 
    <div class="publicaciones">

      <?php 
      if (file_exists($archivo)) { 

          $lineas = file(
              $archivo, 
              FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
          ); 

          $lineas = array_reverse($lineas); 
 
          foreach ($lineas as $linea) { 
              echo '<div class="post">';
              echo '<div class="post-texto">';
              echo htmlspecialchars($linea);
              echo '</div>';
              echo '</div>';
          } 

      } else { 

          echo '<div class="sin-publicaciones">';
          echo 'No hay publicaciones aún.';
          echo '</div>';

      } 
      ?> 

    </div>

  </div>
 
</body> 
</html>
