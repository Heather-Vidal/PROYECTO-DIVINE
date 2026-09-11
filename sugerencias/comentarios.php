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
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Georgia, "Times New Roman", serif;
      min-height: 100vh;
      padding: 50px 20px;

      background:
        linear-gradient(
          rgba(255, 237, 246, 0.90),
          rgba(239, 226, 243, 0.95)
        ),
        url("../imagenes/mezcla.jpg");

      background-size: cover;
      background-position: center;
      background-attachment: fixed;

      color: #634b58;
    }

    /* CONTENEDOR */

    .contenedor {
      width: 100%;
      max-width: 1050px;
      margin: auto;

      padding: 45px 50px;

      background: rgba(255, 253, 254, 0.97);

      border: 1px solid rgba(216, 170, 192, 0.45);

      border-radius: 32px;

      box-shadow:
        0 25px 70px rgba(111, 70, 93, 0.18),
        0 8px 25px rgba(111, 70, 93, 0.08);

      position: relative;
      overflow: hidden;
    }

    .contenedor::before {
      content: "♡";

      position: absolute;
      top: -45px;
      right: 20px;

      font-size: 150px;

      color: rgba(207, 147, 173, 0.09);

      font-family: Arial, sans-serif;
    }

    .contenedor::after {
      content: "✿";

      position: absolute;
      bottom: -50px;
      left: 20px;

      font-size: 130px;

      color: rgba(207, 147, 173, 0.08);
    }

    /* TITULO */

    h1 {
      text-align: center;

      color: #a66f87;

      font-size: 42px;

      font-weight: normal;

      letter-spacing: 1px;

      margin-bottom: 8px;

      position: relative;
      z-index: 2;
    }

    h1::after {
      content: "♡  ✦  ♡";

      display: block;

      margin-top: 12px;

      color: #d49bb3;

      font-family: Arial, sans-serif;

      font-size: 17px;

      letter-spacing: 6px;
    }

    /* SUBTITULO */

    .subtitulo {
      text-align: center;

      color: #9b7d8c;

      font-family: Arial, sans-serif;

      font-size: 15px;

      margin: 10px auto 30px;

      position: relative;
      z-index: 2;
    }

    /* BOTON */

    .volver {
      display: block;

      width: fit-content;

      margin: auto;

      padding: 14px 32px;

      text-decoration: none;

      color: #674655;

      font-family: Arial, sans-serif;

      font-size: 14px;

      font-weight: bold;

      background: linear-gradient(
        135deg,
        #efcedb,
        #d9a7bd
      );

      border-radius: 50px;

      box-shadow:
        0 8px 22px rgba(174, 119, 142, 0.22);

      transition: 0.3s ease;

      position: relative;
      z-index: 3;
    }

    .volver:hover {
      transform: translateY(-4px);

      color: white;

      background: linear-gradient(
        135deg,
        #d9a7bd,
        #bd819d
      );

      box-shadow:
        0 12px 30px rgba(174, 119, 142, 0.30);
    }

    /* LINEA */

    hr {
      border: none;

      height: 1px;

      margin: 40px 0 30px;

      background: linear-gradient(
        to right,
        transparent,
        #dfb9c9,
        transparent
      );
    }

    /* PUBLICACIONES */

    .publicaciones {
      display: flex;

      flex-direction: column;

      gap: 22px;

      position: relative;

      z-index: 2;
    }

    /* PUBLICACION */

    .post {
      display: grid;

      grid-template-columns: 250px 1fr;

      gap: 18px;

      padding: 18px;

      background:
        linear-gradient(
          135deg,
          #fffafb,
          #f9eef5
        );

      border: 1px solid #ecd2df;

      border-radius: 24px;

      box-shadow:
        0 8px 25px rgba(126, 82, 105, 0.08);

      position: relative;

      overflow: hidden;

      transition: all 0.3s ease;
    }

    /* LINEA SUPERIOR */

    .post::before {
      content: "";

      position: absolute;

      top: 0;
      left: 0;

      width: 100%;
      height: 4px;

      background: linear-gradient(
        to right,
        #d29bb2,
        #f1cedd,
        #d29bb2
      );
    }

    .post:hover {
      transform: translateY(-5px);

      border-color: #d8adbf;

      box-shadow:
        0 15px 35px rgba(126, 82, 105, 0.14);
    }

    /* CAJA ROSA DEL CLIENTE */

    .usuario {
      min-height: 120px;

      padding: 16px 18px;

      background:
        linear-gradient(
          145deg,
          #f5dce7,
          #eed1df
        );

      border: 1px solid #e3bdcd;

      border-radius: 20px;

      display: flex;

      flex-direction: row;

      align-items: center;

      justify-content: flex-start;

      text-align: left;

      box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.8);
    }

    /* CIRCULO CON INICIAL */

    .avatar {
      width: 50px;
      height: 50px;

      min-width: 50px;

      border-radius: 50%;

      display: flex;

      align-items: center;
      justify-content: center;

      margin-right: 13px;

      background: #fff8fb;

      color: #b47791;

      font-family: Georgia, serif;

      font-size: 22px;

      font-weight: bold;

      box-shadow:
        0 5px 15px rgba(128, 77, 101, 0.12);
    }

    /* NOMBRE */

    .nombre {
      color: #70485a;

      font-family: Georgia, "Times New Roman", serif;

      font-size: 18px;

      font-weight: bold;

      line-height: 1.2;

      word-break: break-word;

      margin-bottom: 4px;
    }

    /* FECHA */

    .fecha {
      color: #a78393;

      font-family: Arial, sans-serif;

      font-size: 9px;

      letter-spacing: 0.3px;

      opacity: 0.85;
    }

    /* CAJA COMENTARIO */

    .comentario {
      min-height: 120px;

      padding: 25px 30px;

      display: flex;

      align-items: center;

      background: rgba(255,255,255,0.82);

      border: 1px solid #ead4df;

      border-radius: 20px;

      position: relative;
    }

    /* COMILLA */

    .comentario::before {
      content: "“";

      position: absolute;

      top: 5px;
      left: 20px;

      font-family: Georgia, serif;

      font-size: 55px;

      line-height: 1;

      color: #e4bdce;

      opacity: 0.8;
    }

    /* TEXTO */

    .post-texto {
      width: 100%;

      padding-left: 22px;

      color: #705765;

      font-family: Arial, sans-serif;

      font-size: 15px;

      line-height: 1.8;

      word-break: break-word;
    }

    /* SIN PUBLICACIONES */

    .sin-publicaciones {
      text-align: center;

      padding: 50px 25px;

      background:
        linear-gradient(
          135deg,
          #fff7fa,
          #f8eef5
        );

      border: 1px dashed #dcb3c5;

      border-radius: 22px;

      color: #a17c8e;

      font-family: Arial, sans-serif;

      font-size: 15px;
    }

    .sin-publicaciones::before {
      content: "♡";

      display: block;

      font-size: 45px;

      color: #d5a0b5;

      margin-bottom: 10px;
    }

    /* RESPONSIVE */

    @media (max-width: 700px) {

      body {
        padding: 25px 12px;
      }

      .contenedor {
        padding: 30px 18px;

        border-radius: 24px;
      }

      h1 {
        font-size: 32px;
      }

      .subtitulo {
        font-size: 14px;

        line-height: 1.5;

        padding: 0 10px;
      }

      .volver {
        padding: 12px 25px;
      }

      /* PUBLICACION */

      .post {
        grid-template-columns: 1fr;

        gap: 12px;

        padding: 14px;

        border-radius: 20px;
      }

      /* CAJA ROSA */

      .usuario {
        min-height: 75px;

        padding: 12px 15px;

        flex-direction: row;

        justify-content: flex-start;

        text-align: left;
      }

      /* CIRCULO */

      .avatar {
        width: 45px;
        height: 45px;

        min-width: 45px;

        font-size: 20px;

        margin-right: 12px;
      }

      /* NOMBRE */

      .nombre {
        font-size: 17px;

        margin-bottom: 3px;
      }

      /* FECHA */

      .fecha {
        font-size: 9px;
      }

      /* COMENTARIO */

      .comentario {
        min-height: 110px;

        padding: 20px 18px;
      }

      .post-texto {
        padding-left: 15px;

        font-size: 14px;
      }
    }
<<<<<<< HEAD

  </style>
</head>

<body>

=======
    /* ESTILOS PERSONALIZADOS PARA SWEETALERT2 */
.alerta-personalizada {
  border: 1px solid rgba(218, 174, 193, 0.5) !important;
  box-shadow: 0 20px 50px rgba(126, 82, 105, 0.2) !important;
  padding: 30px !important;
}

.alerta-titulo {
  font-family: "Georgia", "Times New Roman", serif !important;
  color: #a8758b !important;
  font-size: 26px !important;
  font-weight: normal !important;
}

.alerta-boton {
  background: linear-gradient(135deg, #e9c4d3, #d8a5ba) !important;
  color: #684957 !important;
  border: none !important;
  padding: 12px 30px !important;
  border-radius: 25px !important;
  font-family: Arial, sans-serif !important;
  font-size: 14px !important;
  font-weight: bold !important;
  cursor: pointer !important;
  box-shadow: 0 5px 15px rgba(174, 119, 142, 0.2) !important;
  transition: all 0.3s ease !important;
  outline: none !important;
}

.alerta-boton:hover {
  background: linear-gradient(135deg, #d9afc1, #c997ad) !important;
  color: #ffffff !important;
  transform: translateY(-2px) !important;
  box-shadow: 0 8px 20px rgba(174, 119, 142, 0.3) !important;
}
  </style> 
</head> 
 
<body> 
<script>
>>>>>>> de3cdec8c3b49e42a70d9b25227d089d9f12254f
<?php

if (isset($_GET['guardado']) && $_GET['guardado'] == '1') {

?>
<<<<<<< HEAD

<script>

Swal.fire({

    icon: 'success',

    title: '¡Comentario guardado!',

    text: 'Tu comentario se guardó correctamente.',

    confirmButtonText: 'Aceptar',

    confirmButtonColor: '#c98da8',

    background: '#fffafd',

    color: '#684957'

});

=======
    Swal.fire({
        title: '¡Comentario guardado!',
        text: 'Tu comentario se guardó correctamente.',
        icon: 'success',
        iconColor: '#d5a0b5',
        confirmButtonText: 'Aceptar',
        background: '#fffcfd',
        color: '#654b59',
        borderRadius: '25px',
        customClass: {
            popup: 'alerta-personalizada',
            title: 'alerta-titulo',
            confirmButton: 'alerta-boton'
        },
        buttonsStyling: false
    });
<?php
}
?>
>>>>>>> de3cdec8c3b49e42a70d9b25227d089d9f12254f
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

        /*
         * FORMATO:
         * Nombre|Comentario|Fecha
         */

        $datos = explode('|', $linea, 3);

        if (count($datos) >= 2) {

            $nombre = trim($datos[0]);

            $comentario = trim($datos[1]);

            if (isset($datos[2]) && trim($datos[2]) != '') {

                $fecha = trim($datos[2]);

            } else {

                $fecha = 'Fecha no disponible';

            }

        } else {

            $nombre = 'Cliente';

            $comentario = trim($linea);

            $fecha = 'Fecha no disponible';
        }

        /*
         * INICIAL DEL NOMBRE
         */

        $inicial = mb_strtoupper(
            mb_substr($nombre, 0, 1, 'UTF-8'),
            'UTF-8'
        );

        echo '<div class="post">';

        /*
         * CAJA ROSA DEL CLIENTE
         */

        echo '<div class="usuario">';

            echo '<div class="avatar">';
                echo htmlspecialchars($inicial);
            echo '</div>';

            echo '<div>';

                echo '<div class="nombre">';
                    echo htmlspecialchars($nombre);
                echo '</div>';

                echo '<div class="fecha">';
                    echo htmlspecialchars($fecha);
                echo '</div>';

            echo '</div>';

        echo '</div>';

        /*
         * CAJA DEL COMENTARIO
         */

        echo '<div class="comentario">';

            echo '<div class="post-texto">';
                echo htmlspecialchars($comentario);
            echo '</div>';

        echo '</div>';

        echo '</div>';
    }

} else {

    echo '<div class="sin-publicaciones">';

        echo 'No hay publicaciones aún.<br>';
        echo '¡Sé la primera persona en dejar un comentario!';

    echo '</div>';
}

?>

  </div>

</div>

</body>
</html>
