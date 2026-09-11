<?php 
$archivo = 'mensajes.txt'; 
?> 
 
<!DOCTYPE html> 
<html lang="es"> 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Publicaciones</title> 

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>  

    * { 
      box-sizing: border-box; 
    } 
 
    body {  
      font-family: Arial, sans-serif;  
      margin: 0; 
      padding: 40px 20px; 
      background-image: url("../imagenes/mezcla.jpg"); 
      background-repeat: no-repeat; 
      background-size: 140%;      
      min-height: 100vh; 
    } 
 
    .contenedor { 
      max-width: 850px; 
      margin: auto; 
      background: #4b2b38; 
      padding: 30px; 
      border-radius: 20px; 
      box-shadow: 0 8px 25px rgba(190, 80, 120, 0.18); 
    } 
 
    h1 {  
      text-align: center; 
      color: #c2185b; 
      font-size: 32px; 
      margin-bottom: 10px; 
    } 
 
    .subtitulo { 
      text-align: center; 
      color: #9c5873; 
      margin-bottom: 25px; 
    } 
 
    .volver { 
      display: inline-block; 
      text-decoration: none; 
      background: #c78299; 
      color: black; 
      padding: 10px 18px; 
      border-radius: 25px; 
      font-weight: bold; 
      transition: 0.3s; 
    } 
 
    .volver:hover { 
      background: #e46ea1; 
      transform: translateY(-2px); 
    } 
 
    hr { 
      border: none; 
      height: 2px; 
      background: #f8bbd0; 
      margin: 25px 0; 
    } 
 
    .post {  
      margin-bottom: 15px;  
      padding: 16px 20px;  
      background: #ce728e; 
      border: 1px solid #f3b6ca; 
      border-left: 5px solid #c75b7f; 
      border-radius: 12px; 
      color: #542c3b; 
      box-shadow: 0 3px 10px rgba(233, 30, 99, 0.08); 
      transition: 0.3s; 
    } 
 
    .post:hover { 
      background: #ff699d; 
      transform: translateX(4px); 
    } 
 
    .sin-publicaciones { 
      text-align: center; 
      padding: 25px; 
      background: #fff0f5; 
      border-radius: 12px; 
      color: #a05270; 
      font-size: 16px; 
    }


    /* ============================= */
    /* ALERTA SWEETALERT - DIVINE */
    /* ============================= */

    .alerta-divine {
      border-radius: 25px !important;
      background: #fff0f5 !important;
      border: 2px solid #e6a4b8 !important;
      box-shadow: 0 10px 30px rgba(75, 43, 56, 0.35) !important;
      padding: 30px !important;
    }

    .titulo-alerta {
      color: #8f4561 !important;
      font-family: Georgia, serif !important;
      font-size: 27px !important;
      font-weight: bold !important;
    }

    .texto-alerta {
      color: #704052 !important;
      font-size: 16px !important;
    }

    .boton-alerta {
      background: #c78299 !important;
      color: white !important;
      border-radius: 25px !important;
      padding: 10px 30px !important;
      font-weight: bold !important;
      border: none !important;
      transition: 0.3s !important;
    }

    .boton-alerta:hover {
      background: #a95773 !important;
      transform: translateY(-2px);
    }

    .swal2-icon.swal2-success {
      border-color: #c78299 !important;
      color: #c78299 !important;
    }

    .swal2-icon.swal2-success [class^='swal2-success-line'] {
      background-color: #c78299 !important;
    }

    .swal2-icon.swal2-success .swal2-success-ring {
      border-color: #e6a4b8 !important;
    }

  </style>  
</head>  
  
<body>  

  <?php 
  if (isset($_GET['guardado']) && $_GET['guardado'] == '1') { 
  ?> 

  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Comentario guardado!',
      text: 'Tu comentario se guardó correctamente. 💌',
      confirmButtonText: 'Aceptar',

      background: '#fff0f5',
      color: '#542c3b',

      customClass: {
        popup: 'alerta-divine',
        title: 'titulo-alerta',
        htmlContainer: 'texto-alerta',
        confirmButton: 'boton-alerta'
      },

      showConfirmButton: true,

      allowOutsideClick: false,
      allowEscapeKey: true
    });
  </script>

  <?php 
  } 
  ?> 


  <div class="contenedor"> 
 
    <h1>Publicaciones</h1> 
 
    <p class="subtitulo">
      Comentarios y sugerencias de nuestros clientes
    </p> 
 
    <a class="volver" href="publicar.php">
      ← Volver a comentar
    </a>  
 
    <hr>  
  
    <?php  

    if (file_exists($archivo)) {  

        $lineas = file(
          $archivo, 
          FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        ); 

        $lineas = array_reverse($lineas);  
  
        foreach ($lineas as $linea) {  

            echo '<div class="post">' 
                 . htmlspecialchars($linea) 
                 . '</div>'; 

        }  

    } else {  

        echo '<div class="sin-publicaciones">
                💌 No hay publicaciones aún.
              </div>'; 

    }  

    ?>  
 
  </div> 
  
</body>  
</html>