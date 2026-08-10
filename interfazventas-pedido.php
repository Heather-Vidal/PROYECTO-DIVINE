
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supervisar - DIVINE</title>

    <style>

        /* ==================================================
           VARIABLES DE COLOR
        ================================================== */

        :root{
            --rosa:#b86f80;
            --rosa-claro:#d9a6b2;
            --rosa-palido:#f7e9ec;

            --crema:#fffaf8;

            --texto:#57494c;
            --gris:#817679;

            --borde:#e3c5cd;

            --vino:#8f5362;
            --vino-oscuro:#713d4d;
        }


        /* ==================================================
           RESET
        ================================================== */

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }


        /* ==================================================
           BODY
        ================================================== */

        body{

            min-height:100vh;

            font-family:'Segoe UI', sans-serif;

            color:var(--texto);

            display:flex;

            justify-content:center;

            align-items:center;

            overflow:hidden;

            position:relative;


            /* IMAGEN DE FONDO */

            background:

            linear-gradient(
                rgba(219, 175, 158, 0.78),
                rgba(247,233,236,.90)
            ),

            url("./imagenes/fondote.png");

            background-size:cover;

            background-position:center;

            background-attachment:fixed;
        }


        /* ==================================================
           DECORACIONES DEL FONDO
        ================================================== */

        body::before{

            content:"";

            position:absolute;

            width:400px;
            height:400px;

            border-radius:50%;

            background:

            radial-gradient(
                circle,
                rgba(184,111,128,.18),
                rgba(184,111,128,0)
            );

            top:-180px;
            left:-150px;
        }


        body::after{

            content:"";

            position:absolute;

            width:420px;
            height:420px;

            border-radius:50%;

            background:

            radial-gradient(
                circle,
                rgba(143,83,98,.14),
                rgba(143,83,98,0)
            );

            bottom:-200px;
            right:-150px;
        }


        /* ==================================================
           PANEL CENTRAL
        ================================================== */

        .panel{

            position:relative;

            z-index:2;

            width:680px;

            max-width:90%;

            padding:55px 60px;

            text-align:center;


            background:

            linear-gradient(
                145deg,
                rgba(255,250,248,.97),
                rgba(247,233,236,.94)
            );


            border:

            1px solid
            rgba(184,111,128,.28);


            border-radius:30px;


            box-shadow:

            0 25px 60px
            rgba(100,70,80,.20),

            inset 0 1px 0
            rgba(255,255,255,.9);


            backdrop-filter:blur(12px);


            animation:

            aparecer .8s ease;
        }


        /* ==================================================
           DECORACIÓN SUPERIOR
        ================================================== */

        .decoracion{

            width:65px;

            height:3px;

            margin:0 auto 24px;

            border-radius:10px;


            background:

            linear-gradient(
                90deg,
                var(--vino),
                var(--rosa-claro),
                var(--vino)
            );


            box-shadow:

            0 3px 10px
            rgba(184,111,128,.25);
        }


        /* ==================================================
           TEXTO PEQUEÑO
        ================================================== */

        .pequeno{

            color:var(--rosa);

            font-size:.78rem;

            text-transform:uppercase;

            letter-spacing:4px;

            margin-bottom:12px;

            font-weight:600;
        }


        /* ==================================================
           TÍTULO
        ================================================== */

        h1{

            font-family:Georgia,serif;

            font-size:clamp(
                2rem,
                5vw,
                3.2rem
            );

            font-weight:400;

            color:var(--vino-oscuro);

            letter-spacing:2px;

            margin-bottom:15px;
        }


        /* ==================================================
           SUBTÍTULO
        ================================================== */

        .subtitulo{

            color:var(--gris);

            font-size:.95rem;

            line-height:1.7;

            max-width:470px;

            margin:0 auto 42px;
        }


        /* ==================================================
           BOTONES
        ================================================== */

        .botones{

            display:flex;

            justify-content:center;

            gap:25px;
        }


        .boton{

            position:relative;

            overflow:hidden;

            width:220px;

            padding:19px 22px;

            border-radius:17px;

            text-decoration:none;

            display:flex;

            align-items:center;

            justify-content:center;

            gap:12px;

            font-size:.95rem;

            font-weight:600;

            letter-spacing:.5px;

            transition:

            transform .3s ease,

            box-shadow .3s ease,

            background .3s ease;
        }


        /* ==================================================
           BOTÓN VENTAS
        ================================================== */

        .ventas{

            color:white;


            background:

            linear-gradient(
                135deg,
                var(--vino-oscuro),
                var(--vino),
                var(--rosa)
            );


            box-shadow:

            0 10px 25px
            rgba(113,61,77,.28);
        }


        /* ==================================================
           BOTÓN PEDIDOS
        ================================================== */

        .pedidos{

            color:var(--vino-oscuro);


            background:

            linear-gradient(
                135deg,
                var(--rosa-claro),
                #e5c0c9
            );


            border:

            1px solid
            rgba(143,83,98,.18);


            box-shadow:

            0 10px 25px
            rgba(184,111,128,.25);
        }


        /* ==================================================
           HOVER
        ================================================== */

        .boton:hover{

            transform:

            translateY(-7px)
            scale(1.02);
        }


        .ventas:hover{

            box-shadow:

            0 18px 35px
            rgba(113,61,77,.38);
        }


        .pedidos:hover{

            box-shadow:

            0 18px 35px
            rgba(184,111,128,.38);
        }


        /* ==================================================
           BRILLO DE LOS BOTONES
        ================================================== */

        .boton::before{

            content:"";

            position:absolute;

            width:80px;

            height:200%;

            top:-50%;

            left:-120px;

            transform:rotate(25deg);

            background:

            rgba(255,255,255,.22);

            transition:

            left .55s ease;
        }


        .boton:hover::before{

            left:120%;
        }


        /* ==================================================
           ICONOS
        ================================================== */

        .icono{

            width:34px;

            height:34px;

            display:flex;

            align-items:center;

            justify-content:center;

            border-radius:50%;

            font-size:17px;
        }


        .ventas .icono{

            background:

            rgba(255,255,255,.16);
        }


        .pedidos .icono{

            background:

            rgba(113,61,77,.10);
        }


        /* ==================================================
           PEQUEÑA FRASE INFERIOR
        ================================================== */

        .inferior{

            margin-top:35px;

            color:#a28d92;

            font-size:.75rem;

            letter-spacing:1px;
        }


        /* ==================================================
           ANIMACIÓN
        ================================================== */

        @keyframes aparecer{

            from{

                opacity:0;

                transform:
                translateY(30px)
                scale(.97);
            }

            to{

                opacity:1;

                transform:
                translateY(0)
                scale(1);
            }
        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media(max-width:650px){

            body{

                overflow:auto;

                padding:30px 0;
            }


            .panel{

                padding:42px 25px;

                border-radius:25px;
            }


            h1{

                font-size:2.2rem;
            }


            .subtitulo{

                font-size:.88rem;

                margin-bottom:32px;
            }


            .botones{

                flex-direction:column;

                align-items:center;

                gap:15px;
            }


            .boton{

                width:100%;

                max-width:300px;
            }
        }

    </style>

</head>


<body>


    <!-- ==================================================
         PANEL PRINCIPAL
    ================================================== -->

    <div class="panel">


        <!-- Línea decorativa -->

        <div class="decoracion"></div>


        <!-- Texto pequeño -->

        <div class="pequeno">

            Panel de supervisión

        </div>


        <!-- Título -->

        <h1>

            ¿Qué deseas supervisar?

        </h1>


        <!-- Descripción -->

        <p class="subtitulo">

            Selecciona una opción para consultar
            y administrar la información de
            <strong>DIVINE</strong>.

        </p>


        <!-- ==================================================
             BOTONES
        ================================================== -->

        <div class="botones">


            <!-- VENTAS -->

            <a
                href="./CRUD-ventas/readtodoventa.php"
                class="boton ventas"
            >

                <span class="icono">

                    ✦

                </span>

                <span>

                    Ventas

                </span>

            </a>


            <!-- PEDIDOS -->

            <a
                href="./CRUD-CARRITO-PEDIDO/readtodopedido.php"
                class="boton pedidos"
            >

                <span class="icono">

                    ♡

                </span>

                <span>

                    Pedidos

                </span>

            </a>


        </div>


        <!-- Texto inferior -->

        <div class="inferior">

            DIVINE · BEAUTY & CARE

        </div>


    </div>


</body>

</html>
