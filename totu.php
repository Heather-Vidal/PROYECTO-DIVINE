
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Divine Beauty</title>

<style>



@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Montserrat:wght@300;400;500;600&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html{
    scroll-behavior: smooth;
}

body{
    background: #f5f0eb;
    color: #302527;
    font-family: 'Montserrat', sans-serif;
    overflow-x: hidden;
}



.pantalla-negra{
    position: fixed;
    inset: 0;
    background: #302124;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.pantalla-negra h1{
    color: #f7e8df;
    font-family: 'DM Serif Display', serif;
    font-size: clamp(55px, 10vw, 130px);
    font-weight: 400;
    letter-spacing: 18px;
}

.pantalla-negra-activa{
    animation: salirIntro 1.3s cubic-bezier(.77,0,.18,1) forwards;
}

@keyframes salirIntro{
    from{
        transform: translateY(0);
    }
    to{
        transform: translateY(-100%);
    }
}



header{
    width: 92%;
    height: 82px;
    position: absolute;
    top: 25px;
    left: 4%;
    z-index: 100;
    
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;

    padding: 0 28px;

    background: rgba(255,255,255,.75);
    backdrop-filter: blur(15px);

    border: 1px solid rgba(105,70,70,.12);
    border-radius: 50px;

    box-shadow: 0 15px 45px rgba(55,35,35,.08);
}




.logo{
    display: flex;
    align-items: center;
}

.logo img{
    width: 130px;
    transition: .4s;
}

.logo img:hover{
    transform: rotate(-3deg) scale(1.05);
}


nav{
    display: flex;
    justify-content: center;
}

.menu{
    display: flex;
    list-style: none;
    gap: 5px;
}

.menu li{
    position: relative;
}

.menu li a{
    text-decoration: none;
    color: #392b2e;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;

    padding: 12px 14px;
    display: block;

    transition: .3s;
}

.menu li a:hover{
    color: #9a5c67;
}


.submenu{
    display: none;
    position: absolute;
    top: 45px;
    left: 0;

    width: 190px;
    padding: 10px;

    list-style: none;

    background: #fffaf7;
    border-radius: 15px;

    box-shadow: 0 20px 40px rgba(50,30,30,.15);
}

.submenu li a{
    text-transform: none;
    letter-spacing: 0;
    font-size: 13px;
    border-radius: 8px;
}

.submenu li a:hover{
    background: #f1ded9;
}

.menu li:hover .submenu{
    display: block;
}



.iconos-derecha{
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.iconos-derecha a{
    width: 38px;
    height: 38px;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 50%;

    background: #eee3de;

    transition: .3s;
}

.iconos-derecha a:hover{
    background: #c4878e;
    transform: translateY(-3px);
}

.iconos-derecha img{
    width: 19px;
}




body > section:not(.pantalla-negra):not(.derecha){
    min-height: 100vh;

    display: flex;
    flex-direction: column;
    justify-content: center;

    padding: 150px 7% 70px;

    background:
        radial-gradient(
            circle at 80% 30%,
            #e7c7c3 0,
            #e7c7c3 7%,
            transparent 7.5%
        ),
        #f5f0eb;

    position: relative;
}




body > section:not(.pantalla-negra):not(.derecha)::after{
    content: "01";
    position: absolute;

    left: 7%;
    bottom: 35px;

    font-family: 'DM Serif Display', serif;
    font-size: 18px;

    color: #aa7777;
}




h1{
    max-width: 720px;

    font-family: 'DM Serif Display', serif;
    font-size: clamp(55px, 7vw, 100px);
    font-weight: 400;

    line-height: .92;

    letter-spacing: -4px;

    color: #302527;
}

.color{
    color: #a35d68;
    font-style: italic;
    font-family: 'DM Serif Display', serif;
}



.sub{
    max-width: 430px;

    margin-top: 35px;
    margin-bottom: 35px;

    font-size: 14px;
    line-height: 1.9;

    color: #756467;
}


.box{
    width: 430px;
    min-height: 170px;

    position: relative;

    display: flex;
    flex-direction: column;
    justify-content: center;

    padding: 25px 25px 25px 150px;

    background: #dac0b9;

    border-radius: 0 80px 0 80px;

    box-shadow: 15px 20px 0 #eee1db;

    margin-top: 10px;

    overflow: hidden;
}

.box h2{
    font-family: 'DM Serif Display', serif;
    font-size: 25px;
    font-weight: 400;

    color: #38272a;

    letter-spacing: 2px;
}

.box p{
    margin: 8px 0 20px;

    font-size: 12px;
    line-height: 1.5;

    color: #624d50;
}

.box a{
    width: fit-content;

    text-decoration: none;

    background: #38272a;
    color: white;

    padding: 10px 18px;

    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;

    border-radius: 30px;

    transition: .3s;
}

.box a:hover{
    background: #9b5c67;
    transform: translateX(5px);
}

.box img{
    position: absolute;

    width: 125px;

    left: 10px;
    bottom: 5px;

    filter: drop-shadow(5px 10px 10px rgba(50,30,30,.2));
}


.derecha{
    min-height: 100vh;

    position: absolute;

    right: 0;
    top: 0;

    width: 46%;

    padding: 135px 4% 50px 20px;

    display: flex;
    justify-content: center;
    align-items: center;
}

.derecha img{
    width: 100%;
    height: 78vh;

    object-fit: cover;

    border-radius: 250px 250px 20px 20px;

    box-shadow:
        -20px 25px 0 #ddc1bc,
        -40px 50px 70px rgba(50,30,30,.18);

    transition: .7s;
}

.derecha img:hover{
    transform: translateY(-10px);
}

main.principal{
    padding: 130px 7%;

    background: #fffaf7;

    position: relative;
}



main.principal::before{
    content: "DIVINE COLLECTION";

    display: block;

    text-align: center;

    font-size: 11px;
    letter-spacing: 5px;

    color: #a56b72;

    margin-bottom: 60px;
}




.caracteristicas{
    width: 100%;

    display: grid;

    grid-template-columns:
        1.3fr
        .8fr
        .8fr
        1.3fr;

    gap: 20px;

    background: transparent;

    padding: 0;

    box-shadow: none;
}

.caja-caracteristica{
    height: 480px;

    overflow: hidden;

    position: relative;

    background: #ddd;

    border-radius: 100px 100px 15px 15px;
}

.caja-caracteristica:nth-child(2){
    margin-top: 70px;
}

.caja-caracteristica:nth-child(3){
    margin-top: 30px;
}

.caja-caracteristica:nth-child(4){
    margin-top: 100px;
}

.caja-caracteristica img{
    width: 100%;
    height: 100%;

    object-fit: cover;

    transition: .7s;
}

.caja-caracteristica:hover img{
    transform: scale(1.08);
}


.tarjetas{
    width: 90%;

    margin: 130px auto 0;

    display: grid;

    grid-template-columns: repeat(3,1fr);

    gap: 35px;
}

.tarjeta{
    height: 430px;

    position: relative;

    overflow: hidden;

    background: #eee;

    border-radius: 20px;

    box-shadow: 0 20px 45px rgba(55,35,35,.12);

    transition: .5s;
}

.tarjeta:nth-child(2){
    transform: translateY(70px);
}

.tarjeta:hover{
    transform: translateY(-12px);
}

.tarjeta:nth-child(2):hover{
    transform: translateY(55px);
}

.tarjeta img{
    width: 100%;
    height: 100%;

    object-fit: cover;

    transition: .7s;
}

.tarjeta:hover img{
    transform: scale(1.06);
}


footer{
    background: #302124;
    color: #f5e8e2;
}



@media(max-width:1100px){

    header{
        grid-template-columns: 1fr auto;
    }

    nav{
        display: none;
    }

    body > section:not(.pantalla-negra):not(.derecha){
        padding-left: 5%;
    }

    h1{
        font-size: 65px;
    }

    .derecha{
        width: 43%;
    }

    .caracteristicas{
        grid-template-columns: repeat(2,1fr);
    }

    .caja-caracteristica,
    .caja-caracteristica:nth-child(2),
    .caja-caracteristica:nth-child(3),
    .caja-caracteristica:nth-child(4){
        margin-top: 0;
    }

    .tarjetas{
        grid-template-columns: repeat(2,1fr);
    }

}



@media(max-width:750px){

    header{
        position: relative;

        top: auto;
        left: auto;

        width: 94%;

        margin: 15px auto;

        height: auto;

        padding: 15px;

        grid-template-columns: 1fr auto;
    }

    .iconos-derecha{
        gap: 5px;
    }

    .iconos-derecha a{
        width: 34px;
        height: 34px;
    }

    body > section:not(.pantalla-negra):not(.derecha){
        min-height: auto;

        padding: 100px 25px 70px;

        align-items: center;

        text-align: center;
    }

    h1{
        font-size: 52px;
        letter-spacing: -2px;
    }

    .sub{
        max-width: 500px;
    }

    .box{
        width: 100%;
        max-width: 430px;

        text-align: left;
    }

    .derecha{
        position: relative;

        width: 100%;

        min-height: auto;

        padding: 30px 25px 80px;
    }

    .derecha img{
        height: 550px;

        border-radius: 180px 180px 20px 20px;
    }

    main.principal{
        padding: 90px 20px;
    }

    .caracteristicas{
        grid-template-columns: 1fr 1fr;
    }

    .caja-caracteristica{
        height: 350px;
        border-radius: 60px 60px 12px 12px;
    }

    .tarjetas{
        width: 100%;

        grid-template-columns: 1fr;

        margin-top: 90px;
    }

    .tarjeta,
    .tarjeta:nth-child(2){
        height: 400px;

        transform: none;
    }

    .tarjeta:hover,
    .tarjeta:nth-child(2):hover{
        transform: translateY(-10px);
    }

}



@media(max-width:480px){

    .pantalla-negra h1{
        font-size: 45px;
        letter-spacing: 8px;
    }

    .logo img{
        width: 105px;
    }

    h1{
        font-size: 43px;
    }

    .box{
        min-height: 190px;

        padding-left: 125px;

        border-radius: 0 50px 0 50px;
    }

    .box img{
        width: 105px;
    }

    .derecha img{
        height: 420px;
    }

    .caracteristicas{
        grid-template-columns: 1fr;
    }

    .caja-caracteristica{
        height: 400px;
    }

}

</style>
</head>


<body>


<section class="pantalla-negra" id="pantallaNegra">
    <h1>DIVINE</h1>
</section>



<header>

    <div class="logo">

        <a href="pagintrof.php">

            <img
                src="./imagenes/DIVINE-removebg-preview.png"
                alt="Logo"
                width="145"
            >

        </a>

    </div>


    <nav>

        <ul class="menu">

            <li>
                <a href="totu.php">Inicio</a>
            </li>

            <li>

                <a href="produccomp.php">
                    Productos
                </a>

                <ul class="submenu">

                    <li>
                        <a href="skincare.php">
                            Skin Care
                        </a>
                    </li>

                    <li>
                        <a href="mascarillas.php">
                            Mascarillas
                        </a>
                    </li>

                </ul>

            </li>

            <li>
                <a href="mision-vision.php">
                    Historia
                </a>
            </li>

            <li>
                <a href="mision-vision.php">
                    Nosotros
                </a>
            </li>

            <li>
                <a href="#ofertas">
                    Ofertas
                </a>
            </li>

            <li>
                <a href="#contacto">
                    Contacto
                </a>
            </li>

            <li>
                <a href="#consulta">
                    Consulta Personal
                </a>
            </li>

        </ul>

    </nav>


    <div class="iconos-derecha">

        <a href="#">

            <img
                src="./imagenes/lupa-removebg-preview.png"
                alt="Buscar"
                width="25"
            >

        </a>

        <a href="./CRUD-CARRITO-PEDIDO/formpedido.php">

            <img
                src="./imagenes/carrito.png"
                alt="Carrito"
                width="25"
            >

        </a>

        <a href="./SESIONES/loginformcliente.php">

            <img
                src="./imagenes/persona.png"
                alt="Perfil"
                width="25"
            >

        </a>

    </div>

</header>



<section>

    <h1>

        Glow Starts
        <br>

        With
        <span class="color">
            Natural Beauty
        </span>

    </h1>


    <p class="sub">

        Productos inspirados en la elegancia de la naturaleza
        para cuidar tu piel y cabello.

    </p>


    <section class="box">

        <h2>
            ESENCIAS
        </h2>


        <center>

            <p>
                Producto a base de esencias naturales.
            </p>

        </center>


        <img
            src="./imagenes/crema.png"
            alt="cremca"
            width="80px"
        >


        <a href="./CRUD-producto/formularioprodu.php">

            Añadir Producto

        </a>

    </section>

</section>




<section class="derecha">

    <img
        src="./imagenes/rosafc.jpg"
        alt="Beauty Products"
    >

</section>



<main class="principal">


    <section class="caracteristicas">

        <div class="caja-caracteristica">

            <img
                src="./imagenes/productosblancos.jpg"
                alt=""
            >

        </div>


        <div class="caja-caracteristica">

            <img
                src="./imagenes/producs.jpg"
                alt=""
            >

        </div>


        <div class="caja-caracteristica">

            <img
                src="./imagenes/productos01.jpg"
                alt=""
            >

        </div>


        <div class="caja-caracteristica">

            <img
                src="./imagenes/coco.jpg"
                alt=""
            >

        </div>

    </section>


    <section class="tarjetas">


        <div class="tarjeta">

            <img
                src="./imagenes/cabellolacio.jpg"
                alt=""
            >

        </div>


        <div class="tarjeta">

            <img
                src="./imagenes/rosa.jpg"
                alt=""
            >

        </div>


        <div class="tarjeta">

            <img
                src="./imagenes/castaño.jpg"
                alt=""
            >

        </div>


    </section>

</main>




<script>

window.onload = function(){

    setTimeout(function(){

        document
            .getElementById("pantallaNegra")
            .classList.add("pantalla-negra-activa");

    },800);

};

</script>


<?php include 'submenpiepag.php'; ?>


</body>
</html>

