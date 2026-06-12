<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DIVINE — Maquetado sin header</title>

  <style>
    body {
      margin: 0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: #faf7f6;
      color-scheme: light;
      display: flex;
      justify-content: center;
      padding: 40px 16px;
    }
    .contenedor {
      width: 100%;
      max-width: 1200px;
    }
    .hero {
      position: relative;
      border-radius: 18px;
      overflow: hidden;
      min-height: 420px;
      display: grid;
      align-items: center;
    }
    .hero-video {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,0.22), rgba(0,0,0,0.16));
      mix-blend-mode: multiply;
      z-index: 1;
    }

    .hero-contenido {
      position: relative;
      padding: 30px;
      display: flex;
      gap: 32px;
      align-items: center;
      color: white;
      z-index: 2;
    }

    .hero-izquierda {
      max-width: 58%;
    }

    h1 {
      margin: 0 0 12px 0;
      font-size: clamp(28px, 4vw, 44px);
      line-height: 1.02;
      letter-spacing: -0.02em;
      text-shadow: 0 6px 20px rgba(0,0,0,0.35);
    }

    .texto-principal {
      margin: 0 0 20px 0;
      font-size: 16px;
      color: rgba(255,255,255,0.92);
      max-width: 48ch;
    }

    .fila-botones {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .btn {
      appearance: none;
      border: 0;
      padding: 12px 18px;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      background: #8aa27a;
      color: white;
      box-shadow: 0 6px 18px rgba(136,162,122,0.18);
    }

    .btn-fantasma {
      background: transparent;
      border: 1px solid rgba(255,255,255,0.18);
      color: rgba(255,255,255,0.95);
    }

    .hero-derecha {
      margin-left: auto;
      width: 36%;
      display: flex;
      justify-content: flex-end;
    }

    .tarjeta-muestra {
      width: 220px;
      background: rgba(255,255,255,0.85);
      color: #111;
      padding: 18px;
      border-radius: 14px;
      box-shadow: 0 8px 30px rgba(12,12,12,0.12);
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .tarjeta-muestra:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(12,12,12,0.18);
    }

    .tarjeta-muestra img {
      width: 100%;
      border-radius: 10px;
      display: block;
    }

    .tarjeta-muestra h4 {
      margin: 10px 0 6px 0;
      font-size: 16px;
    }

    .tarjeta-muestra p {
      margin: 0;
      font-size: 13px;
      color: #666;
    }

    /* CARACTERÍSTICAS */
    .rejilla {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 18px;
      margin-top: 22px;
    }

    .caracteristica {
      background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.82));
      border-radius: 12px;
      padding: 18px;
      min-height: 120px;
      box-shadow: 0 6px 18px rgba(12,12,12,0.06);
      transition: transform .2s ease;
    }

    .caracteristica:hover { transform: translateY(-6px); }

    .caracteristica p { margin: 0; color: #666; font-size: 14px; }
 
h2 {
  grid-column: 1 / -1; 
  margin: 5px 0 5px 0;
  font-size: 22px;
  color: #333;
}
.titulo-productos {
z-index: 3;
   font-family: "Playfair Display", serif;
      letter-spacing: 2px;
      text-transform: uppercase;
   opacity: 0.;
  margin: 24px 0 12px 0;
  font-size: 100px;
  color: #ffffff;
}

    .productos {
      margin-top: 28px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
    }

    .producto {
      border-radius: 12px;
      overflow: hidden;
      background: white;
      cursor: pointer;
      transition: transform .18s ease, box-shadow .18s ease;
      box-shadow: 0 6px 20px rgba(12,12,12,0.06);
    }

    .producto:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(12,12,12,0.12);
    }

    .producto img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      display: block;
    }

    .producto-meta {
      padding: 12px;
    }

    .producto-meta p {
      margin: 0;
      font-size: 13px;
      color: #666;
    }
    footer {
      margin-top: 28px;
      text-align: center;
      color: #666;
      font-size: 13px;
      padding: 16px 8px;
    }
    @media (max-width:900px) {
      .hero { min-height: 360px; }
      .hero-contenido { padding: 28px; }
      .hero-izquierda { max-width: 100%; }
      .hero-derecha { display: none; }
      .rejilla { grid-template-columns: 1fr 1fr; }
      .productos { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width:520px) {
      .contenedor { padding: 0; }
      .hero { border-radius: 12px; }
      .rejilla { grid-template-columns: 1fr; }
      .productos { grid-template-columns: 1fr; }
      h1 { font-size: 22px; }
    }
  </style>

</head>
<body>

  <div class="contenedor">

    <!-- HERO -->
    <section class="hero">

      <video class="hero-video" autoplay muted loop playsinline>
        <source src="carita.mp4" type="video/mp4">
      </video>

      <div class="hero-contenido">
         
        <div class="hero-izquierda">
         
          <h1>DIVINE — Belleza en cada detalle</h1>
          <p class="texto-principal">
            Crea una experiencia visual simple y elegante utilizando un video como fondo.
          </p>
          <div class="fila-botones"></div>
        </div>

        <div class="hero-derecha">
          <div class="tarjeta-muestra">
            <img src="./imagenes/producto0.jpg">
            <h4>Tratamiento nutritivo</h4>
            <p>Formato 50ml — Hidratación profunda</p>
          </div>
        </div>

      </div>
    </section>
    <div class="rejilla">

      <div class="caracteristica">
        <h3>Ingredientes naturales</h3>
        <p>Formulaciones con extractos botánicos y sin parabenos.</p>
      </div>

      <div class="caracteristica">
        <h3>Envío seguro</h3>
        <p>Empaque reciclable y despacho rápido a todo el país.</p>
      </div>

      <div class="caracteristica">
        <h3>Soporte personalizado</h3>
        <p>Asesoría de rutina según tu tipo de piel y cabello.</p>
      </div>

    </div>
    <section class="productos">
 <h2> ZONA DE HAIRCARE</h2> 
 <article class="producto">
          <img src="./imagenes/coco.jpg ">
          <div class="producto-meta">
            <h4>Aceite de coco</h4>
            <p>Brillo extenso y luminoso</p>
          </div>
        </article>
                    
        <article class="producto">
          <img src="./imagenes/aceitedealmendra.avif">
          <div class="producto-meta">
            <h4>Aceite de Almendras</h4>
            <p>Brillo y control del frizz</p>
          </div>
        </article>

        <article class="producto">
          <img src="./imagenes/serum.avif">
          <div class="producto-meta">
            <h4>Aceite de Jojoba</h4>
            <p>Acabado suave y luminoso</p>
          </div>
        </article>

        <article class="producto">
          <img src="./imagenes/aceitedeargan.avif">
          <div class="producto-meta">
            <h4>Aceite de Argán</h4>
            <p>Reparación profunda — 30 ml</p>
          </div>
        </article>

        <article class="producto">
          <img src="./imagenes/Aceitemultivitamínico.avif">
          <div class="producto-meta">
            <h4>Aceite Multivitaminico</h4>
            <p>Hidratación intensa</p>
          </div>
        </article>

        <article class="producto">
          <img src="./imagenes/Aceitedericino.avif">
          <div class="producto-meta">
            <h4>Aceite de Ricino</h4>
            <p>Fortalecimiento del cuero cabelludo</p>
          </div>
        </article>
 <h2> ZONA DE SKINCARE</h2> 
 
      <article class="producto">
        <img src="./imagenes/crema.jpg">
        <div class="producto-meta">
          <h4>Serum revitalizante</h4>
          <p>30 ml — Acción reparadora</p>
        </div>
      </article>

      <article class="producto">
        <img src="./imagenescremademanos.jpg">
        <div class="producto-meta">
          <h4>Crema nutritiva</h4>
          <p>Piel suave y radiante</p>
        </div>
      </article>

      <article class="producto">
        <img src="./imagenes/cremanaranja.jpg">
        <div class="producto-meta">
          <h4>Aceite facial</h4>
          <p>Brillo y control de frizz</p>
        </div>
      </article>

      <article class="producto">
        <img src="./imagenes/cremarosa.jpg">
        <div class="producto-meta">
          <h4>Loción iluminadora</h4>
          <p>Acabado glow natural</p>
        </div>
      </article>

      <article class="producto">
        <img src="./imagenes/naranja.jpg">
        <div class="producto-meta">
          <h4>Mascarilla de escencias</h4>
          <p>Limpieza profunda</p>
        </div>
      </article>

      <article class="producto">
        <img src="./imagenes/pepino.jpg">
        <div class="producto-meta">
          <h4>Mascarilla detox</h4>
          <p>Limpieza profunda</p>
        </div>
      </article>

    </section>

    <footer>
      <p>© 2025 DIVINE — Belleza natural hecha con amor</p>
      <p>Síguenos en 
        <a href="https://www.instagram.com/divine_productss" target="_blank">Instagram</a>
      </p>
    </footer>

  </div>

</body>
</html>
