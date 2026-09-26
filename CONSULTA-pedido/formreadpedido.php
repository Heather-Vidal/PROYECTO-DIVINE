<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Ver Estado del Pedido</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


<style>

/* =========================================================
   RESET
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


/* =========================================================
   BODY
========================================================= */

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    font-family:'DM Sans', sans-serif;

    background:
        linear-gradient(
            rgba(253,244,247,.55),
            rgba(162,50,85,.55)
        ),
        url("../imagenes/fondu.png");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:fixed;

    position:relative;

    overflow:hidden;
}


/* =========================================================
   DECORACIÓN DEL FONDO
========================================================= */

body::before{

    content:"";

    position:absolute;

    width:330px;
    height:330px;

    border-radius:50%;

    background:rgba(255,255,255,.32);

    top:-130px;
    left:-100px;

    filter:blur(2px);

    pointer-events:none;
}


body::after{

    content:"";

    position:absolute;

    width:280px;
    height:280px;

    border-radius:50%;

    background:rgba(201,111,132,.10);

    bottom:-120px;
    right:-80px;

    filter:blur(3px);

    pointer-events:none;
}


/* =========================================================
   TARJETA PRINCIPAL
========================================================= */

.contenedor{

    position:relative;

    z-index:2;

    width:440px;

    padding:45px 42px 42px;

    background:rgba(255,255,255,.88);

    backdrop-filter:blur(12px);
    -webkit-backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,.9);

    border-radius:30px;

    box-shadow:
        0 30px 70px rgba(130,72,88,.18),
        0 8px 25px rgba(130,72,88,.10);

    text-align:center;

    animation:aparecer .7s ease;
}


/* =========================================================
   ANIMACIÓN
========================================================= */

@keyframes aparecer{

    from{
        opacity:0;
        transform:translateY(25px) scale(.97);
    }

    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}


/* =========================================================
   DETALLE SUPERIOR
========================================================= */

.detalle-superior{

    display:flex;

    align-items:center;
    justify-content:center;

    gap:12px;

    margin-bottom:20px;
}


.linea{

    width:55px;
    height:1px;

    background:#dca9b6;
}


.corazon{

    width:42px;
    height:42px;

    display:flex;

    align-items:center;
    justify-content:center;

    background:#f9e1e7;

    border:1px solid #d92054;

    border-radius:50%;

    color:#c96f84;

    font-size:19px;

    box-shadow:
        0 5px 15px rgba(201,111,132,.15);
}


/* =========================================================
   MARCA
========================================================= */

.marca{

    font-family:'Playfair Display', serif;

    font-size:15px;

    letter-spacing:5px;

    color:#b66a7d;

    margin-bottom:8px;

    font-weight:600;
}


/* =========================================================
   TÍTULO
========================================================= */

h2{

    font-family:'Playfair Display', serif;

    color:#8f4f62;

    font-size:31px;

    line-height:1.2;

    margin-bottom:13px;

    font-weight:700;
}


.subtitulo{

    color:#8b7a7f;

    font-size:14px;

    line-height:1.6;

    margin:0 auto 30px;

    max-width:310px;
}


/* =========================================================
   FORMULARIO
========================================================= */

.formulario{

    text-align:left;

    background:#fffafa;

    border:1px solid #f3dce2;

    border-radius:20px;

    padding:24px;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.9),
        0 8px 20px rgba(130,72,88,.06);
}


/* =========================================================
   LABEL
========================================================= */

label{

    display:block;

    color:#65565b;

    font-size:14px;

    font-weight:700;

    margin-bottom:9px;
}


.label-icon{

    color:#c96f84;

    margin-right:6px;

    font-size:13px;
}


/* =========================================================
   INPUT
========================================================= */

.input-contenedor{

    position:relative;

    margin-bottom:22px;
}


.input-icon{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#c98a9a;

    font-size:16px;

    pointer-events:none;
}


input[type="number"]{

    width:100%;

    height:52px;

    padding:0 16px 0 43px;

    border:1.5px solid #edd4dc;

    border-radius:14px;

    outline:none;

    font-family:'DM Sans', sans-serif;

    font-size:15px;

    color:#5b4f53;

    background:#ffffff;

    transition:
        border-color .25s ease,
        box-shadow .25s ease,
        transform .25s ease;
}


input[type="number"]::placeholder{

    color:#b9a9ae;
}


input[type="number"]:hover{

    border-color:#dfb7c3;
}


input[type="number"]:focus{

    border-color:#c96f84;

    box-shadow:
        0 0 0 4px rgba(201,111,132,.10),
        0 5px 15px rgba(201,111,132,.08);

    transform:translateY(-1px);
}


/* =========================================================
   BOTÓN CONSULTAR
========================================================= */

input[type="submit"]{

    width:100%;

    height:54px;

    border:none;

    border-radius:15px;

    background:
        linear-gradient(
            135deg,
            #d47f93,
            #b96076
        );

    color:#ffffff;

    font-family:'DM Sans', sans-serif;

    font-size:15px;

    font-weight:700;

    letter-spacing:.3px;

    cursor:pointer;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        filter .25s ease;

    box-shadow:
        0 10px 22px rgba(185,96,118,.25);
}


input[type="submit"]:hover{

    transform:translateY(-2px);

    filter:brightness(1.04);

    box-shadow:
        0 14px 27px rgba(185,96,118,.32);
}


input[type="submit"]:active{

    transform:translateY(0);

    box-shadow:
        0 7px 15px rgba(185,96,118,.22);
}


/* =========================================================
   MENSAJE INFERIOR
========================================================= */

.ayuda{

    display:flex;

    justify-content:center;
    align-items:center;

    gap:7px;

    margin-top:24px;

    color:#9b888e;

    font-size:12px;
}


.ayuda span{

    color:#c96f84;

    font-size:14px;
}


/* =========================================================
   ERRORES
========================================================= */

label.error{

    display:block;

    margin-top:-15px;

    margin-bottom:15px;

    color:#c95568;

    font-size:12px;

    font-weight:600;

    padding-left:4px;

    animation:errorAparece .25s ease;
}


@keyframes errorAparece{

    from{
        opacity:0;
        transform:translateY(-3px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}


input.error{

    border-color:#d77888 !important;

    box-shadow:
        0 0 0 3px rgba(215,120,136,.08) !important;
}


/* =========================================================
   BOTÓN VOLVER DIVINE
========================================================= */

.divine-back{

    position:fixed;

    left:28px;
    bottom:28px;

    width:58px;
    height:58px;

    border:none;

    border-radius:50%;

    background:
        linear-gradient(
            145deg,
            #a96f87,
            #925f76
        );

    color:#fff8fa;

    display:flex;

    align-items:center;
    justify-content:center;

    cursor:pointer;

    z-index:99999;

    box-shadow:
        0 8px 20px rgba(115,65,84,.22),
        inset 0 1px 3px rgba(255,255,255,.35);

    transition:
        transform .35s ease,
        box-shadow .35s ease,
        background .35s ease;
}


/* =========================================================
   CORAZÓN DEL BOTÓN
========================================================= */

.divine-back-heart{

    width:27px;
    height:27px;

    fill:none;

    stroke:#fff8fa;

    stroke-width:1.8;

    stroke-linecap:round;
    stroke-linejoin:round;

    transition:
        transform .35s ease,
        fill .35s ease,
        stroke-width .35s ease;
}


/* =========================================================
   FLECHA
========================================================= */

.divine-back-arrow{

    position:absolute;

    top:56px;

    left:50%;

    transform:translateX(-50%);

    color:#925f76;

    font-family:Arial,sans-serif;

    font-size:31px;

    font-weight:700;

    line-height:1;

    text-shadow:
        0 1px 1px rgba(146,95,118,.15);

    transition:
        transform .3s ease,
        color .3s ease;
}


/* =========================================================
   HOVER DEL BOTÓN
========================================================= */

.divine-back:hover{

    transform:
        translateY(-5px)
        scale(1.07);

    background:
        linear-gradient(
            145deg,
            #b67d93,
            #9c667e
        );

    box-shadow:
        0 13px 28px rgba(115,65,84,.30),
        inset 0 1px 3px rgba(255,255,255,.45);
}


/* =========================================================
   HOVER CORAZÓN
========================================================= */

.divine-back:hover .divine-back-heart{

    transform:scale(1.13);

    fill:rgba(255,245,248,.22);

    stroke-width:2;
}


/* =========================================================
   HOVER FLECHA
========================================================= */

.divine-back:hover .divine-back-arrow{

    transform:translateX(-55%);

    color:#925f76;
}


/* =========================================================
   TEXTO VOLVER
========================================================= */

.divine-back-text{

    position:absolute;

    top:88px;

    left:50%;

    transform:
        translateX(-50%)
        translateY(-5px);

    color:#925f76;

    font-family:"Poppins",Arial,sans-serif;

    font-size:12px;

    font-weight:500;

    letter-spacing:.4px;

    white-space:nowrap;

    opacity:0;

    visibility:hidden;

    transition:
        opacity .3s ease,
        transform .3s ease;
}


/* =========================================================
   MOSTRAR TEXTO
========================================================= */

.divine-back:hover .divine-back-text{

    opacity:1;

    visibility:visible;

    transform:
        translateX(-50%)
        translateY(0);
}


/* =========================================================
   CLICK
========================================================= */

.divine-back:active{

    transform:scale(.93);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:600px){

    .divine-back{

        width:52px;
        height:52px;

        left:18px;
        bottom:18px;
    }


    .divine-back-heart{

        width:24px;
        height:24px;
    }


    .divine-back-arrow{

        top:51px;

        font-size:27px;

        font-weight:700;
    }


    .divine-back-text{

        top:79px;

        font-size:11px;
    }

}


@media(max-width:520px){

    body{

        padding:20px;

        overflow:auto;
    }


    .contenedor{

        width:100%;

        padding:35px 25px;

        border-radius:25px;
    }


    h2{

        font-size:27px;
    }


    .formulario{

        padding:20px;
    }

}

</style>

</head>


<body>


<!-- =====================================================
     TARJETA PRINCIPAL
===================================================== -->

<div class="contenedor">


    <div class="detalle-superior">

        <div class="linea"></div>

        <div class="corazon">
            ♡
        </div>

        <div class="linea"></div>

    </div>


    <div class="marca">
        DIVINE
    </div>


    <h2>
        Ver Estado del Pedido
    </h2>


    <p class="subtitulo">
        Consulta rápidamente el estado de tu pedido
        ingresando el número correspondiente.
    </p>


    <div class="formulario">

        <form
            id="formPedido"
            action="mostrarestadopedido.php"
            method="GET"
        >

            <label for="idPedido">

                <span class="label-icon">♡</span>

                Número de pedido

            </label>


            <div class="input-contenedor">

                <span class="input-icon">
                    #
                </span>

                <input
                    type="number"
                    id="idPedido"
                    name="idPedido"
                    min="1"
                    placeholder="Ej. 15"
                    autocomplete="off"
                    required
                >

            </div>


            <input
                type="submit"
                value="Consultar estado  →"
            >

        </form>

    </div>


    <div class="ayuda">

        <span>♡</span>

        Ingresa el número de tu pedido para continuar

    </div>

</div>



<!-- =====================================================
     BOTÓN VOLVER DIVINE
===================================================== -->

<button
    type="button"
    class="divine-back"
    onclick="history.back()"
    aria-label="Volver"
    title="Volver"
>

    <svg
        class="divine-back-heart"
        viewBox="0 0 24 24"
        aria-hidden="true"
    >

        <path
            d="M20.84 8.61
               C20.84 13.42 12 19 12 19
               S3.16 13.42 3.16 8.61
               C3.16 6.12 5.13 4.5 7.35 4.5
               C9.05 4.5 10.56 5.43 12 7.12
               C13.44 5.43 14.95 4.5 16.65 4.5
               C18.87 4.5 20.84 6.12 20.84 8.61Z"
        />

    </svg>


    <span class="divine-back-arrow">
        ←
    </span>


    <span class="divine-back-text">
        Volver
    </span>

</button>



<script>

$(document).ready(function(){

    $("#formPedido").validate({

        rules: {

            idPedido: {

                required: true,

                number: true,

                min: 1

            }

        },


        messages: {

            idPedido: {

                required:
                    "Ingrese el número de su pedido.",

                number:
                    "Ingrese un número válido.",

                min:
                    "El número de pedido debe ser mayor a 0."

            }

        },


        errorClass:"error",


        errorPlacement:function(error,element){

            error.insertAfter(
                element.closest(".input-contenedor")
            );

        }

    });

});

</script>


</body>
</html>
