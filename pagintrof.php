 <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Divine</title>
  <style>
    body {
      display: grid;
      grid-template-rows: 100vh 50vh;
      grid-template-columns: 50%;
      grid-template-areas: 
        "dos tres";
      margin: 0;
      position: relative; /* Importante para posicionar el link central */
    }

  
    #a {
      background-color: pink;
      grid-area: dos;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #b {
      background-color: aliceblue;
      grid-area: tres;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #a video,
    #b video {
      width: 100%;
      height: 100%;
      object-fit: cover;  
      cursor: pointer; 
    }

    /* Estilos para el link central */
    #link {
      position: absolute;
      top: 35%; /* dejo igual que tu código original */
      left: 50%;
      transform: translate(-50%, -50%);
      text-decoration: none;
    }

    #link h1 {
      color: #e6dbd8;
      font-size: 4em;
      font-weight: bold;
       margin: 0;
      text-align: center;
      cursor: pointer;
      position: relative; /* necesario para la línea animada */
    }

    /* Agregado: línea animada debajo del h1 */
    

    /* Pantalla negra de transición */
    .pantalla-negra {
      position: fixed;
      bottom: -100%;
      left: 0;
      width: 100%;
      height: 100%;
      background: black;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 2em;
      font-weight: bold;
      color: white;
      transition: bottom  1s ease;
      
    }

    .pantalla-negra.activa {
      bottom: 0;
      animation: fadeIn 1s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
@media (max-width: 768px) {

  body {
    display: grid;
    grid-template-columns: 100%;
    grid-template-rows: 50vh 50vh;
    grid-template-areas:
      "dos"
      "tres";
    
  }
  #hola h1{
     position: absolute;
     top: 50px;
     left: 50px;
  }
  #a {
    height: 50vh;
    
  }
  #b {
    height: 50vh;
    
  }
  #link {
   top: 50%;              /* Lo pongo realmente al centro vertical */
    left: 50%;
    transform: translate(-50%, -50%);
  }
  #link h1 {
    font-size: 2.5em;
  }
  
  video {
   width: 100%;
    height: 100%;      /* SIN espacio blanco */
    object-fit: cover; 
  }
}
  </style>
</head>
<body>
  
  <section id="a">
    <video class="video" autoplay loop muted playsinline>
      <source src="skincare.mp4" type="video/mp4">
    </video>
  </section>

  <section id="b">
    <video class="video" autoplay loop muted playsinline>
      <source src="cabellito.mp4" type="video/mp4">
    </video>
  </section>

  <!-- Link central DIVINE -->
  <a href="paginaprinc2.php" id="link">
    <h1 class="hola">DIVINE</h1>
  </a>

  <!-- Pantalla negra de transición -->
  <div class="pantalla-negra" id="transicion">
    <h1>DIVINE</h1>
  </div>

  <script>
    const linkH1 = document.getElementById("link");
    const transicion = document.getElementById("transicion");
    const videos = document.querySelectorAll(".video");

    // Click en link
    linkH1.addEventListener("click", (e) => {
      e.preventDefault();
      transicion.classList.add("activa");
      setTimeout(() => {
        transicion.classList.remove("activa"); // Evita que se quede congelado
        window.location.href = linkH1.href;
      }, 1000);
    });

    // Click en videos: solo animación
    videos.forEach(video => {
      video.addEventListener("click", () => {
        transicion.classList.add("activa");
        video.pause();
        setTimeout(() => {
          transicion.classList.remove("activa");
        }, 1000);
      });
    });
  </script>
</body>
</html>