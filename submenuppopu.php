<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DIVINE - Sobre Nosotros</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f8eef0;
    color:#333;
}

/* HERO */

.hero{
    width:85%;
    margin:70px auto;
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:50px;
    align-items:center;
}

.imagen-principal{
    height:650px;
    border-radius:35px;
    overflow:hidden;
    box-shadow:0 20px 40px rgba(0,0,0,.15);
    transition:.5s;
}

.imagen-principal:hover{
    transform:scale(1.02);
}

.imagen-principal img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.titulo-divine{
    font-size:80px;
    color:#bf7485;
    letter-spacing:8px;
    font-family:Georgia, serif;
    margin-bottom:15px;
}

.descripcion{
    font-size:18px;
    line-height:2;
    color:#666;
    margin:25px 0;
}

.btn-divine{
    display:inline-block;
    background:#c96f84;
    color:white;
    padding:15px 35px;
    border-radius:50px;
    text-decoration:none;
    font-weight:bold;
    transition:.4s;
    box-shadow:0 8px 20px rgba(201,111,132,.35);
    margin-bottom:35px;
}

.btn-divine:hover{
    background:#b45d72;
    transform:translateY(-3px);
}

/* MISION Y VISION */

.mision-vision{
    display:flex;
    flex-direction:column;
    gap:20px;
}

.caja-info{
    background:white;
    padding:25px;
    border-radius:25px;
    box-shadow:0 12px 25px rgba(0,0,0,.08);
    border-left:8px solid #d89aa7;
    transition:.4s;
}

.caja-info:hover{
    transform:translateY(-8px);
}

.caja-info h3{
    color:#bf7485;
    font-size:24px;
    margin-bottom:12px;
}

.caja-info p{
    line-height:1.8;
    color:#666;
}

/* OBJETIVOS */

.historia-objetivos{
    width:85%;
    margin:80px auto;
}

.bloque-objetivos{
    background:white;
    padding:50px;
    border-radius:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.bloque-objetivos h2{
    text-align:center;
    color:#bf7485;
    font-size:40px;
    margin-bottom:40px;
}

.bloque-objetivos ul{
    list-style:none;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.bloque-objetivos li{
    background:white;
    padding:25px;
    padding-left:60px;
    border-radius:20px;
    position:relative;
    border:1px solid rgba(216,154,167,.2);
    box-shadow:0 5px 15px rgba(0,0,0,.05);
    transition:.3s;
}

.bloque-objetivos li::before{
    content:"✓";
    position:absolute;
    left:20px;
    top:20px;
    width:30px;
    height:30px;
    border-radius:50%;
    background:#d89aa7;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

.bloque-objetivos li:hover{
    transform:translateY(-5px);
}

/* FOOTER */

.footer-divine{
    background:linear-gradient(
        135deg,
        #d89aa7,
        #bf7485
    );
    color:white;
    padding:70px 10%;
    margin-top:80px;
}

.redes{
    text-align:center;
    margin-bottom:50px;
}

.redes a{
    text-decoration:none;
    color:white;
    font-size:35px;
    margin:0 15px;
    transition:.4s;
}

.redes a:hover{
    color:#ffe7ed;
    transform:translateY(-5px);
}

.footer-contenido{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:40px;
}

.footer-box{
    background:rgba(255,255,255,.12);
    padding:25px;
    border-radius:20px;
}

.footer-box h3{
    color:white;
    margin-bottom:15px;
}

.footer-box p{
    line-height:1.8;
}

.copyright{
    text-align:center;
    margin-top:50px;
    padding-top:25px;
    border-top:1px solid rgba(255,255,255,.2);
}

/* RESPONSIVE */

@media(max-width:900px){

.hero{
    grid-template-columns:1fr;
}

.imagen-principal{
    height:450px;
}

.logo-divine{
    font-size:55px;
    text-align:center;
}

.contenido-principal{
    text-align:center;
}

.footer-contenido{
    grid-template-columns:1fr;
}

.bloque-objetivos{
    padding:30px;
}

}

</style>

</head>

<body>
<?php include 'submenu.php'; ?>

<section class="hero">

    <div class="imagen-principal">
        <img src="./imagenes/divineprod.jpg" alt="DIVINE">
        <img src="" alt="">
    </div>

    <div class="contenido-principal">

        <h1 class="titulo-divine">DIVINE</h1>

        <a href="produccomp.php" class="btn-divine">
            Descubrir Productos
        </a>

        <p class="descripcion">
            A principios del año 2024, nace Divine, una marca boliviana de cosméticos naturales que se inspira en la riqueza de la naturaleza y la diversidad cultural del país. Divine se compromete a ofrecer productos de alta calidad que combinan ingredientes naturales con innovación científica para el cuidado del cabello y la piel, promoviendo la sostenibilidad y el bienestar.
        </p>

        <div class="mision-vision">

            <div class="caja-info">
                <h3> Misión</h3>

                <p>
                    Brindar productos naturales y de calidad que ayuden a cuidar la piel y el cabello fortaleciendo el bienestar y la confianza de nuestros clientes. Ofrecer soluciones capilares y de skincare de origen natural que garanticen resultados visibles y un cuidado respetuoso de la salud.
                </p>
            </div>

            <div class="caja-info">
                <h3> Visión</h3>

                <p>
                    Ser una marca referente en Bolivia por la calidad, innovación y compromiso con la belleza natural. Nos proyectamos en constante evolución, expandiendo nuestro catálogo y alcance para democratizar el acceso a una cosmética natural, efectiva y de calidad superior.
                </p>
            </div>

        </div>

    </div>

</section>

<section class="historia-objetivos">

    <div class="bloque-objetivos">

        <h2>Nuestros Objetivos</h2>

        <ul>
            <li>Ofrecer productos de alta calidad para el cuidado personal.</li>
            <li>Promover el uso de ingredientes naturales y responsables.</li>
            <li>Garantizar la satisfacción y confianza de nuestros clientes.</li>
            <li>Innovar constantemente en nuestros productos y servicios.</li>
            <li>Posicionarnos como una marca líder en belleza natural.</li>
        </ul>

    </div>

</section>

<footer class="footer-divine">

    <div class="redes">
        <img src="./imagenes/face.png" width="50" height="50" alt="Facebook">
        <img src="./imagenes/watsi.png" width="50" height="50" alt="WhatsApp">
        <img src="./imagenes/instagram.png" width="50" height="50" alt="Instagram">
    </div>

    <div class="footer-contenido">

        <div class="footer-box">
            <h3> Contacto</h3>
            <p>Celular: 70000000</p>
            <p>WhatsApp: 70000000</p>
            <p>Correo: divine@gmail.com</p>
        </div>

        <div class="footer-box">
            <h3> Ubicación</h3>
            <p>
                Cochabamba - Bolivia<br>
                Zona Central<br>
                Calle Principal Nº 123
            </p>
        </div>

        <div class="footer-box">
            <h3> Redes Sociales</h3>
            <p>Instagram: @divine</p>
            <p>Facebook: Divine Bolivia</p>
            <p>TikTok: @divine.oficial</p>
        </div>

    </div>

    <div class="copyright">
        © 2025 DIVINE - Todos los derechos reservados
    </div>

</footer>

</body>
</html>

