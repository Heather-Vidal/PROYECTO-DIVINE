<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Divine</title>

  <style>

    /* =====================================================
       TIPOGRAFÍAS
    ===================================================== */

    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Montserrat:wght@300;400;500;600&display=swap');


    /* =====================================================
       CUERPO
    ===================================================== */

    body {
      display: grid;

      grid-template-rows: 100vh;

      grid-template-columns: 50% 50%;

      grid-template-areas:
        "dos tres";

      margin: 0;

      position: relative;

      overflow: hidden;

      background-color: #f5f0eb;

      font-family: 'Montserrat', sans-serif;
    }


    /* =====================================================
       VIDEO IZQUIERDO
    ===================================================== */

    #a {
      background-color: #e7c7c3;

      grid-area: dos;

      display: flex;

      justify-content: center;

      align-items: center;

      overflow: hidden;
    }


    /* =====================================================
       VIDEO DERECHO
    ===================================================== */

    #b {
      background-color: #eee3de;

      grid-area: tres;

      display: flex;

      justify-content: center;

      align-items: center;

      overflow: hidden;
    }


    /* =====================================================
       VIDEOS
    ===================================================== */

    #a video,
    #b video {

      width: 100%;

      height: 100%;

      object-fit: cover;

      cursor: pointer;

      transition: transform .7s ease;
    }


    #a video:hover,
    #b video:hover {

      transform: scale(1.03);

    }


    /* =====================================================
       LINK CENTRAL DIVINE
    ===================================================== */

    #link {

      position: absolute;

      top: 50%;

      left: 50%;

      transform: translate(-50%, -50%);

      text-decoration: none;

      z-index: 20;
    }


    #link h1 {

      color: #f7e8df;

      font-family: 'DM Serif Display', serif;

      font-size: clamp(55px, 8vw, 120px);

      font-weight: 400;

      letter-spacing: 12px;

      line-height: 1;

      margin: 0;

      text-align: center;

      cursor: pointer;

      position: relative;

      text-shadow: 0 8px 25px rgba(48, 37, 39, .25);

      transition:
        transform .4s ease,
        letter-spacing .4s ease;
    }


    #link h1:hover {

      transform: scale(1.04);

      letter-spacing: 16px;
    }


    /* =====================================================
       PANTALLA NEGRA
       COMIENZA ABAJO
    ===================================================== */

    .pantalla-negra {

      position: fixed;

      bottom: -100%;

      left: 0;

      width: 100%;

      height: 100vh;

      background: #302124;

      display: flex;

      justify-content: center;

      align-items: center;

      z-index: 9999;

      font-size: 2em;

      font-weight: bold;

      color: white;

      transition: bottom 1s cubic-bezier(.77,0,.18,1);

      overflow: hidden;
    }


    /* =====================================================
       PANTALLA NEGRA ACTIVA
       SUBE DESDE ABAJO
    ===================================================== */

    .pantalla-negra.activa {

      bottom: 0;

    }


    /* =====================================================
       DIVINE DE LA TRANSICIÓN
    ===================================================== */

    .pantalla-negra h1 {

      color: #f7e8df;

      font-family: 'DM Serif Display', serif;

      font-size: clamp(55px, 10vw, 130px);

      font-weight: 400;

      letter-spacing: 18px;

      line-height: 1;

      margin: 0;

      opacity: 0;

      animation: aparecerDivine .7s ease forwards;

      animation-delay: .35s;
    }


    /* =====================================================
       ANIMACIÓN DEL TEXTO
    ===================================================== */

    @keyframes aparecerDivine {

      from {

        opacity: 0;

        transform: translateY(25px);

      }

      to {

        opacity: 1;

        transform: translateY(0);

      }

    }


    /* =====================================================
       CELULAR
    ===================================================== */

    @media (max-width: 768px) {

      body {

        display: grid;

        grid-template-columns: 100%;

        grid-template-rows: 50vh 50vh;

        grid-template-areas:
          "dos"
          "tres";

        overflow: hidden;
      }


      #a {

        height: 50vh;

      }


      #b {

        height: 50vh;

      }


      #link {

        left: 50%;

        top: 50%;

        transform: translate(-50%, -50%);

      }


      #link h1 {

        font-size: 2.8em;

        letter-spacing: 7px;

      }


      #link h1:hover {

        letter-spacing: 9px;

      }


      video {

        width: 100%;

        height: 100%;

        object-fit: cover;

      }


      .pantalla-negra h1 {

        font-size: 2.8em;

        letter-spacing: 9px;

      }

    }


    /* =====================================================
       CELULAR PEQUEÑO
    ===================================================== */

    @media (max-width: 480px) {

      #link h1 {

        font-size: 2.4em;

        letter-spacing: 5px;

      }


      .pantalla-negra h1 {

        font-size: 2.4em;

        letter-spacing: 7px;

      }

    }

  </style>
</head>


<body>


  <!-- =====================================================
       VIDEO SKINCARE
  ===================================================== -->

  <section id="a">

    <video
      class="video"
      autoplay
      loop
      muted
      playsinline
    >

      <source
        src="skincare.mp4"
        type="video/mp4"
      >

    </video>

  </section>


  <!-- =====================================================
       VIDEO CABELLO
  ===================================================== -->

  <section id="b">

    <video
      class="video"
      autoplay
      loop
      muted
      playsinline
    >

      <source
        src="cabellito.mp4"
        type="video/mp4"
      >

    </video>

  </section>


  <!-- =====================================================
       DIVINE CENTRAL
  ===================================================== -->

  <a
    href="totu.php"
    id="link"
  >

    <h1 class="hola">
      DIVINE
    </h1>

  </a>


  <!-- =====================================================
       PANTALLA DE TRANSICIÓN
  ===================================================== -->

  <div
    class="pantalla-negra"
    id="transicion"
  >

    <h1>
      DIVINE
    </h1>

  </div>


  <!-- =====================================================
       JAVASCRIPT
  ===================================================== -->

  <script>

    const linkH1 = document.getElementById("link");

    const transicion = document.getElementById("transicion");

    const videos = document.querySelectorAll(".video");


    /* =====================================================
       CLICK EN DIVINE
    ===================================================== */

    linkH1.addEventListener("click", (e) => {

      e.preventDefault();

      /* La pantalla negra sube desde abajo */

      transicion.classList.add("activa");


      /* Después de 1 segundo entra a totu.php */

      setTimeout(() => {

        window.location.href = linkH1.href;

      }, 1000);

    });


    /* =====================================================
       CLICK EN LOS VIDEOS
    ===================================================== */

    videos.forEach(video => {

      video.addEventListener("click", () => {

        /* La pantalla negra sube desde abajo */

        transicion.classList.add("activa");


        /* Pausar video */

        video.pause();


        /* Después de 1 segundo desaparece */

        setTimeout(() => {

          transicion.classList.remove("activa");

        }, 1000);

      });

    });

  </script>

</body>
</html>