<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"

>

<title>DIVINE Beauty Assistant</title>

<style>

@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Montserrat:wght@300;400;500;600;700&display=swap');


/* =========================================================
   VARIABLES
========================================================= */

:root {

    --negro: #191718;
    --negro-2: #292426;
    --negro-3: #40383a;

    --crema: #f8f4ef;
    --crema-2: #eee8e0;

    --blanco: #ffffff;

    --champagne: #c5a36a;
    --champagne-claro: #e5d5b8;

    --rosa-sutil: #cdaab1;

    --gris: #81797a;
    --gris-claro: #b5adae;

    --borde: rgba(25,23,24,.10);
}


/* =========================================================
   RESET
========================================================= */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body {
    font-family: "Montserrat", sans-serif;
}


/* =========================================================
   BOTÓN FLOTANTE
========================================================= */

#divineBoton {

    position: fixed;

    right: 28px;
    bottom: 28px;

    width: 72px;
    height: 72px;

    border-radius: 50%;

    background: rgba(255,255,255,.82);

    border: 1px solid rgba(255,255,255,.95);

    box-shadow:
        0 12px 35px rgba(0,0,0,.16),
        inset 0 0 0 1px rgba(197,163,106,.18);

    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: grab;

    z-index: 99999;

    opacity: .62;

    transition: .35s ease;

    touch-action: none;
    user-select: none;
}

#divineBoton:hover {

    opacity: 1;

    transform:
        scale(1.08)
        translateY(-3px);

    box-shadow:
        0 18px 45px rgba(0,0,0,.22),
        0 0 0 5px rgba(197,163,106,.08);
}

#divineBoton:active {
    cursor: grabbing;
}

#divineBoton img {

    width: 56px;
    height: 56px;

    object-fit: contain;

    pointer-events: none;
}

#divineBoton::after {

    content: "✦";

    position: absolute;

    top: 5px;
    right: 8px;

    width: 15px;
    height: 15px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: var(--champagne);

    color: white;

    font-size: 8px;

    border: 2px solid white;
}


/* =========================================================
   VENTANA PRINCIPAL — MÁS GRANDE
========================================================= */

#divineChat {

    position: fixed;

    right: 27px;
    bottom: 115px;

    /*
       ANTES:
       width: 405px;
       height: 635px;

       AHORA:
       caja más grande y cómoda
    */

    width: 480px;
    height: 720px;

    max-width: calc(100vw - 30px);
    max-height: calc(100vh - 135px);

    min-height: 550px;

    background: var(--crema);

    border:
        1px solid rgba(255,255,255,.95);

    border-radius: 30px;

    overflow: hidden;

    display: flex;
    flex-direction: column;

    z-index: 99998;

    box-shadow:
        0 30px 75px rgba(0,0,0,.25),
        0 5px 20px rgba(0,0,0,.08);

    opacity: 0;

    visibility: hidden;

    transform:
        translateY(18px)
        scale(.95);

    transform-origin: bottom right;

    transition:
        opacity .3s ease,
        transform .35s cubic-bezier(.2,.8,.2,1),
        visibility .3s ease;
}
#lh{
    color: white;
}
#divineChat.abierto {

    opacity: 1;

    visibility: visible;

    transform:
        translateY(0)
        scale(1);
}


/* =========================================================
   HEADER
========================================================= */

.divine-header {

    position: relative;

    min-height: 88px;

    padding: 17px 21px;

    background:
        linear-gradient(
            135deg,
            #171516,
            #292426
        );

    color: white;

    display: flex;

    align-items: center;

    justify-content: space-between;

    flex-shrink: 0;
}

.divine-header::after {

    content: "";

    position: absolute;

    left: 21px;
    right: 21px;

    bottom: 0;

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            var(--champagne),
            transparent
        );

    opacity: .8;
}


/* =========================================================
   INFORMACIÓN HEADER
========================================================= */

.divine-header-info {

    display: flex;

    align-items: center;

    gap: 13px;
}

.divine-header-logo {

    width: 51px;
    height: 51px;

    border-radius: 50%;

    background: white;

    display: flex;

    align-items: center;
    justify-content: center;

    border:
        1px solid rgba(197,163,106,.65);

    box-shadow:
        0 4px 15px rgba(0,0,0,.25);
}

.divine-header-logo img {

    width: 42px;
    height: 42px;

    object-fit: contain;
}

.divine-header-text h2 {

    margin: 0;

    font-family:
        "DM Serif Display",
        serif;

    font-size: 24px;

    font-weight: 400;
}

.divine-header-text span {

    display: block;

    margin-top: 3px;

    color:
        var(--champagne);

    font-size: 7.5px;

    letter-spacing: 2px;

    text-transform: uppercase;

    font-weight: 600;
}


/* =========================================================
   CERRAR
========================================================= */

#cerrarDivine {

    width: 36px;
    height: 36px;

    border:
        1px solid rgba(255,255,255,.12);

    border-radius: 50%;

    background:
        rgba(255,255,255,.06);

    color: #ddd;

    font-size: 21px;

    cursor: pointer;

    display: flex;

    align-items: center;
    justify-content: center;

    transition: .25s ease;
}

#cerrarDivine:hover {

    background: white;

    color: var(--negro);

    transform: rotate(90deg);
}


/* =========================================================
   CONTENIDO
========================================================= */

.divine-contenido {

    flex: 1;

    min-height: 0;

    overflow-y: auto;

    padding: 23px;

    background:
        linear-gradient(
            180deg,
            #faf7f3,
            #f7f2ec
        );

    scroll-behavior: smooth;
}

.divine-contenido::-webkit-scrollbar {
    width: 5px;
}

.divine-contenido::-webkit-scrollbar-thumb {

    background:
        #cbbca8;

    border-radius: 20px;
}


/* =========================================================
   PRESENTACIÓN
========================================================= */

.divine-presentacion {

    position: relative;

    padding:
        28px
        24px
        25px;

    margin-bottom: 18px;

    min-height: 160px;

    border-radius: 22px;

    background:
        linear-gradient(
            135deg,
            #211e1f,
            #322b2e
        );

    color: white;

    overflow: hidden;

    box-shadow:
        0 12px 30px rgba(0,0,0,.13);
}

.divine-presentacion::before {

    content: "";

    position: absolute;

    width: 190px;
    height: 190px;

    right: -75px;
    top: -95px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(197,163,106,.25),
            transparent 70%
        );
}

.divine-presentacion::after {

    content: "";

    position: absolute;

    left: 24px;
    bottom: 0;

    width: 80px;
    height: 2px;

    background:
        linear-gradient(
            90deg,
            var(--champagne),
            transparent
        );
}

.divine-presentacion-marca {

    position: relative;

    display: flex;

    align-items: center;

    gap: 7px;

    margin-bottom: 11px;

    color:
        var(--champagne-claro);

    font-size: 7px;

    font-weight: 700;

    letter-spacing: 2.2px;

    text-transform: uppercase;
}

.divine-presentacion-marca::before {

    content: "✦";

    color:
        var(--champagne);

    font-size: 10px;
}

.divine-presentacion h1 {

    position: relative;

    margin: 0 0 8px;

    font-family:
        "DM Serif Display",
        serif;

    font-weight: 400;

    font-size: 31px;

    line-height: 1.05;
}

.divine-presentacion p {

    position: relative;

    margin: 0;

    max-width: 350px;

    color:
        rgba(255,255,255,.72);

    font-size: 9.5px;

    line-height: 1.7;
}


/* =========================================================
   BIENVENIDA
========================================================= */

.divine-bienvenida {

    position: relative;

    padding:
        17px
        19px
        17px
        22px;

    margin-bottom: 17px;

    background: white;

    border:
        1px solid var(--borde);

    border-radius:
        7px
        19px
        19px
        19px;

    color:
        var(--negro-3);

    font-size: 10.5px;

    line-height: 1.75;

    box-shadow:
        0 5px 17px rgba(0,0,0,.04);
}

.divine-bienvenida strong {
    color: var(--negro);
}

.divine-bienvenida::before {

    content: "✦";

    position: absolute;

    top: -8px;
    left: -5px;

    width: 18px;
    height: 18px;

    border-radius: 50%;

    background:
        var(--champagne);

    color: white;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 8px;
}


/* =========================================================
   SUGERENCIAS
========================================================= */

.divine-sugerencias {

    display: flex;

    flex-wrap: wrap;

    gap: 7px;

    margin-bottom: 20px;
}

.divine-sugerencia {

    padding:
        8px
        12px;

    background:
        rgba(255,255,255,.8);

    border:
        1px solid rgba(197,163,106,.22);

    border-radius: 30px;

    color:
        var(--negro-3);

    font-size: 8px;

    cursor: pointer;

    transition: .25s ease;
}

.divine-sugerencia:hover {

    background:
        var(--negro);

    color: white;

    border-color:
        var(--negro);

    transform:
        translateY(-1px);
}


/* =========================================================
   STATUS
========================================================= */

#status {

    display: none;

    padding:
        10px
        13px;

    margin-bottom: 13px;

    border-radius: 11px;

    font-size: 9px;

    line-height: 1.5;

    white-space: pre-line;
}

#status.error {

    display: block;

    color: #934d58;

    background: #fff0f2;

    border:
        1px solid #efd0d5;
}

#status.exito {

    display: block;

    color: #596c5e;

    background: #f2f7f3;

    border:
        1px solid #d9e5dc;
}


/* =========================================================
   RESPUESTA IA
========================================================= */

.respuesta-ia {

    position: relative;

    margin-bottom: 21px;

    animation:
        aparecerRespuesta .4s ease;
}

@keyframes aparecerRespuesta {

    from {

        opacity: 0;

        transform:
            translateY(8px);
    }

    to {

        opacity: 1;

        transform:
            translateY(0);
    }
}

.respuesta-label {

    display: flex;

    align-items: center;

    gap: 7px;

    margin:
        0 0 8px 5px;

    color:
        var(--gris);

    font-size: 7.5px;

    font-weight: 700;

    letter-spacing: 1.6px;

    text-transform: uppercase;
}

.respuesta-label::before {

    content: "✦";

    width: 18px;
    height: 18px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        var(--negro);

    color:
        var(--champagne);

    font-size: 7px;
}

.respuesta-burbuja {

    position: relative;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #fcfaf7
        );

    padding:
        19px
        19px
        19px
        21px;

    border:
        1px solid
        rgba(197,163,106,.22);

    border-radius:
        7px
        21px
        21px
        21px;

    color:
        var(--negro-3);

    font-size: 11px;

    line-height: 1.85;

    box-shadow:
        0 9px 25px
        rgba(0,0,0,.055);
}

.respuesta-burbuja::before {

    content: "";

    position: absolute;

    left: 0;
    top: 16px;
    bottom: 16px;

    width: 3px;

    border-radius: 5px;

    background:
        linear-gradient(
            180deg,
            var(--champagne),
            var(--rosa-sutil)
        );
}

.respuesta-burbuja strong {

    color:
        var(--negro);

    font-weight: 700;
}


/* =========================================================
   PRODUCTOS
========================================================= */

.productos-titulo {

    display: flex;

    align-items: center;

    gap: 8px;

    margin:
        23px
        0
        12px;

    font-family:
        "DM Serif Display",
        serif;

    font-size: 22px;

    font-weight: 400;

    color:
        var(--negro);
}

.productos-titulo::after {

    content: "";

    height: 1px;

    flex: 1;

    background:
        linear-gradient(
            90deg,
            var(--champagne-claro),
            transparent
        );
}


/* =========================================================
   PRODUCTO
========================================================= */

.producto {

    position: relative;

    padding:
        18px
        17px
        16px
        20px;

    margin-bottom: 12px;

    background: white;

    border:
        1px solid var(--borde);

    border-radius: 19px;

    box-shadow:
        0 7px 22px rgba(0,0,0,.045);

    overflow: hidden;

    transition: .25s ease;
}

.producto:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 12px 28px
        rgba(0,0,0,.08);
}

.producto::before {

    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 3px;

    background:
        linear-gradient(
            180deg,
            var(--champagne),
            var(--rosa-sutil)
        );
}

.producto h3 {

    margin:
        0
        0
        9px;

    font-family:
        "DM Serif Display",
        serif;

    font-weight: 400;

    color:
        var(--negro);

    font-size: 19px;
}

.producto p {

    margin:
        5px
        0;

    color:
        var(--gris);

    font-size: 9.5px;

    line-height: 1.6;
}

.producto p b {
    color: var(--negro-3);
}

.producto-precio {

    margin-top: 11px;

    padding-top: 10px;

    border-top:
        1px solid #eee8e0;

    color:
        var(--negro);

    font-weight: 700;

    font-size: 13px;
}

.producto-precio::before {

    content: "PRECIO  ";

    color:
        var(--champagne);

    font-size: 7px;

    letter-spacing: 1px;
}


/* =========================================================
   SIN RESULTADOS
========================================================= */

.sin-resultados {

    background:
        white;

    border:
        1px solid var(--borde);

    border-radius: 18px;

    padding: 19px;

    color:
        var(--gris);

    font-size: 10px;

    line-height: 1.7;

    box-shadow:
        0 7px 20px
        rgba(0,0,0,.04);
}

.sin-resultados strong {

    color:
        var(--negro);

    font-family:
        "DM Serif Display",
        serif;

    font-size: 18px;

    font-weight: 400;
}


/* =========================================================
   INPUT
========================================================= */

.divine-input-area {

    padding:
        14px
        18px
        16px;

    background:
        var(--crema);

    border-top:
        1px solid rgba(0,0,0,.07);

    flex-shrink: 0;
}

.divine-input-box {

    display: flex;

    align-items: center;

    gap: 8px;

    padding:
        6px
        6px
        6px
        17px;

    background:
        white;

    border:
        1px solid
        rgba(25,23,24,.10);

    border-radius: 22px;

    box-shadow:
        0 7px 22px
        rgba(0,0,0,.06);

    transition: .25s ease;
}

.divine-input-box:focus-within {

    border-color:
        var(--champagne);

    box-shadow:
        0 8px 25px
        rgba(197,163,106,.13);
}

#busquedaInput {

    flex: 1;

    min-width: 0;

    border: none;

    outline: none;

    background: transparent;

    font-family:
        "Montserrat",
        sans-serif;

    color:
        var(--negro);

    font-size: 10.5px;
}

#busquedaInput::placeholder {
    color: #aaa1a2;
}

#botonBuscar {

    width: 41px;
    height: 41px;

    flex-shrink: 0;

    border: none;

    border-radius: 50%;

    background:
        var(--negro);

    color: white;

    cursor: pointer;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 15px;

    transition: .25s ease;
}

#botonBuscar:hover {

    background:
        var(--champagne);

    transform:
        scale(1.07);
}

#botonBuscar:disabled {

    opacity: .5;

    cursor:
        not-allowed;

    transform:
        none;
}


/* =========================================================
   FOOTER
========================================================= */

.divine-footer-text {

    text-align: center;

    margin-top: 8px;

    color:
        #aaa1a2;

    font-size: 7px;

    letter-spacing: 1.2px;
}


/* =========================================================
   ANIMACIÓN PENSANDO
========================================================= */

.pensando {

    display: flex;

    align-items: center;

    gap: 4px;
}

.pensando span {

    width: 5px;
    height: 5px;

    border-radius: 50%;

    background:
        var(--champagne);

    animation:
        divineDot 1.2s infinite ease-in-out;
}

.pensando span:nth-child(2) {
    animation-delay: .15s;
}

.pensando span:nth-child(3) {
    animation-delay: .30s;
}

@keyframes divineDot {

    0%,
    80%,
    100% {

        opacity: .3;

        transform:
            translateY(0);
    }

    40% {

        opacity: 1;

        transform:
            translateY(-3px);
    }
}


/* =========================================================
   CELULAR
========================================================= */

@media (max-width: 600px) {

    #divineChat {

        right: 8px;

        bottom: 86px;

        width:
            calc(100vw - 16px);

        height:
            calc(100vh - 100px);

        min-height: 0;

        max-height: none;

        border-radius: 25px;
    }

    #divineBoton {

        right: 17px;

        bottom: 17px;

        width: 66px;
        height: 66px;
    }

    #divineBoton img {

        width: 51px;
        height: 51px;
    }

    .divine-contenido {

        padding: 17px;
    }

    .divine-presentacion {

        padding:
            24px
            20px
            22px;

        min-height: 145px;
    }

    .divine-presentacion h1 {

        font-size: 26px;
    }

    .divine-presentacion p {

        font-size: 9px;
    }

    .respuesta-burbuja {

        font-size: 10px;

        line-height: 1.75;
    }
}


/* =========================================================
   PANTALLAS MUY PEQUEÑAS
========================================================= */

@media (max-height: 700px) and (min-width: 601px) {

    #divineChat {

        height:
            calc(100vh - 105px);

        min-height: 0;
    }
}

</style>

</head>

<body>

<!-- =========================================================
     BOTÓN FLOTANTE
========================================================= -->

<div
    id="divineBoton"
    title="Abrir asistente DIVINE"
>


<img
    src="./imagenes/DIVINE-removebg-preview.png"
    alt="DIVINE"
>


</div>

<!-- =========================================================
     CHAT DIVINE
========================================================= -->

<div id="divineChat">


<!-- =====================================================
     HEADER
===================================================== -->

<div class="divine-header">

    <div class="divine-header-info">

        <div class="divine-header-logo">

            <img
                src="./imagenes/DIVINE-removebg-preview.png"
                alt="DIVINE"
            >

        </div>


        <div class="divine-header-text">

            <h2>
                Divine Assistant
            </h2>

            <span>
                Intelligent Beauty
            </span>

        </div>

    </div>


    <button
        id="cerrarDivine"
        type="button"
        aria-label="Cerrar"
    >
        ×
    </button>

</div>


<!-- =====================================================
     CONTENIDO
===================================================== -->

<div
    class="divine-contenido"
    id="divineContenido"
>


    <!-- =================================================
         PRESENTACIÓN
    ================================================= -->

    <div class="divine-presentacion">

        <div class="divine-presentacion-marca">
            DIVINE BEAUTY
        </div>

        <h1 id="lh">
            Tu belleza,<br>
            a tu manera.
        </h1>

        <p>
            Descubre consejos personalizados,
            rutinas de cuidado y productos
            seleccionados para ti.
        </p>

    </div>


    <!-- =================================================
         BIENVENIDA
    ================================================= -->

    <div class="divine-bienvenida">

        Hola ✦ Soy el asistente inteligente de
        <strong>DIVINE</strong>.

        Puedes preguntarme sobre tu piel,
        cabello, rutinas de cuidado o buscar
        productos de nuestra tienda.

    </div>


    <!-- =================================================
         SUGERENCIAS
    ================================================= -->

    <div class="divine-sugerencias">

        <div
            class="divine-sugerencia"
            onclick="usarSugerencia('¿Por qué mi piel está seca?')"
        >
            ✦ Piel seca
        </div>

        <div
            class="divine-sugerencia"
            onclick="usarSugerencia('¿Qué puedo hacer para cuidar mi cabello?')"
        >
            ✦ Cuidado capilar
        </div>

        <div
            class="divine-sugerencia"
            onclick="usarSugerencia('¿Qué productos tienen para mi piel?')"
        >
            ✦ Productos
        </div>

    </div>


    <!-- =================================================
         STATUS
    ================================================= -->

    <div id="status"></div>


    <!-- =================================================
         RESPUESTA IA
    ================================================= -->

    <div id="respuestaIA"></div>


    <!-- =================================================
         PRODUCTOS
    ================================================= -->

    <div id="resultados"></div>


</div>


<!-- =====================================================
     CAJA PARA PREGUNTAR
===================================================== -->

<div class="divine-input-area">

    <div class="divine-input-box">

        <input
            type="text"
            id="busquedaInput"
            placeholder="Escribe tu pregunta..."
            autocomplete="off"
        >

        <button
            id="botonBuscar"
            type="button"
            aria-label="Enviar"
        >
            ➜
        </button>

    </div>


    <div class="divine-footer-text">
        ✦ DIVINE INTELLIGENT BEAUTY ✦
    </div>

</div>


</div>

<script>

/* =========================================================
   ELEMENTOS
========================================================= */

const divineBoton =
    document.getElementById(
        "divineBoton"
    );

const divineChat =
    document.getElementById(
        "divineChat"
    );

const cerrarDivine =
    document.getElementById(
        "cerrarDivine"
    );

const inputBusqueda =
    document.getElementById(
        "busquedaInput"
    );

const resultadosDiv =
    document.getElementById(
        "resultados"
    );

const respuestaIADiv =
    document.getElementById(
        "respuestaIA"
    );

const statusDiv =
    document.getElementById(
        "status"
    );

const botonBuscar =
    document.getElementById(
        "botonBuscar"
    );

const divineContenido =
    document.getElementById(
        "divineContenido"
    );


/* =========================================================
   ABRIR CHAT
========================================================= */

divineBoton.addEventListener(
    "click",
    function() {

        if (moviendo) {
            return;
        }

        divineChat.classList.toggle(
            "abierto"
        );

        if (
            divineChat.classList.contains(
                "abierto"
            )
        ) {

            setTimeout(
                function() {

                    inputBusqueda.focus();

                },
                300
            );
        }

    }
);


/* =========================================================
   CERRAR
========================================================= */

cerrarDivine.addEventListener(
    "click",
    function() {

        divineChat.classList.remove(
            "abierto"
        );

    }
);


/* =========================================================
   SUGERENCIAS
========================================================= */

function usarSugerencia(
    texto
) {

    inputBusqueda.value = texto;

    inputBusqueda.focus();

    buscarConIA();

}


/* =========================================================
   ENTER
========================================================= */

inputBusqueda.addEventListener(
    "keydown",
    function(event) {

        if (
            event.key === "Enter"
        ) {

            event.preventDefault();

            buscarConIA();

        }

    }
);


/* =========================================================
   BOTÓN
========================================================= */

botonBuscar.addEventListener(
    "click",
    buscarConIA
);


/* =========================================================
   ESTADO
========================================================= */

function mostrarEstado(
    mensaje,
    tipo = ""
) {

    statusDiv.style.display =
        "block";

    statusDiv.className =
        tipo;

    statusDiv.innerText =
        mensaje;

}


function ocultarEstado() {

    statusDiv.style.display =
        "none";

    statusDiv.innerText =
        "";

    statusDiv.className =
        "";

}


/* =========================================================
   FUNCIÓN PRINCIPAL
========================================================= */

async function buscarConIA() {


    const busqueda =
        inputBusqueda.value.trim();


    resultadosDiv.innerHTML =
        "";

    respuestaIADiv.innerHTML =
        "";

    ocultarEstado();


    if (!busqueda) {

        mostrarEstado(
            "Escribe primero una pregunta.",
            "error"
        );

        inputBusqueda.focus();

        return;
    }


    /* =====================================================
       CARGANDO
    ===================================================== */

    botonBuscar.disabled =
        true;

    botonBuscar.innerHTML =
        "•";


    respuestaIADiv.innerHTML = `

        <div class="respuesta-ia">

            <div class="respuesta-label">
                DIVINE IA
            </div>

            <div class="respuesta-burbuja">

                <div class="pensando">

                    <span></span>
                    <span></span>
                    <span></span>

                    <span
                        style="
                        width:auto;
                        height:auto;
                        background:none;
                        animation:none;
                        margin-left:5px;
                        color:#81797a;
                        "
                    >
                        Pensando...
                    </span>

                </div>

            </div>

        </div>

    `;


    desplazarseAbajo();


    try {


        /* =================================================
           CONECTAR CON PHP
        ================================================= */

        const response =
            await fetch(
                "./filtrar.php",
                {
                    method:
                        "POST",

                    headers:
                        {
                            "Content-Type":
                                "application/json"
                        },

                    body:
                        JSON.stringify(
                            {
                                busqueda:
                                    busqueda
                            }
                        )
                }
            );


        const textoRespuesta =
            await response.text();


        console.log(
            "Respuesta PHP:",
            textoRespuesta
        );


        let data;


        /* =================================================
           JSON
        ================================================= */

        try {

            data =
                JSON.parse(
                    textoRespuesta
                );

        }
        catch (error) {

            respuestaIADiv.innerHTML =
                "";

            mostrarEstado(

                "El servidor PHP no devolvió JSON válido.\n\n" +
                textoRespuesta,

                "error"

            );

            return;
        }


        /* =================================================
           ERROR HTTP
        ================================================= */

        if (!response.ok) {

            let mensaje =
                "Error del servidor PHP (" +
                response.status +
                ")";


            if (data.error) {

                mensaje +=
                    "\n\n" +
                    data.error;

            }


            if (data.detalle) {

                mensaje +=
                    "\n\nDetalle:\n" +
                    data.detalle;

            }


            respuestaIADiv.innerHTML =
                "";

            mostrarEstado(
                mensaje,
                "error"
            );

            return;
        }


        /* =================================================
           ERROR PHP
        ================================================= */

        if (data.error) {

            respuestaIADiv.innerHTML =
                "";

            mostrarEstado(
                data.error,
                "error"
            );

            return;
        }


        /* =================================================
           RESPUESTA IA
        ================================================= */

        const respuestaIA =
            typeof data.respuesta === "string"
                ? data.respuesta.trim()
                : "";


        respuestaIADiv.innerHTML =
            "";


        if (
            respuestaIA !== ""
        ) {

            respuestaIADiv.innerHTML = `

                <div class="respuesta-ia">

                    <div class="respuesta-label">
                        DIVINE IA
                    </div>

                    <div class="respuesta-burbuja">

                        ${formatearRespuesta(
                            respuestaIA
                        )}

                    </div>

                </div>

            `;
        }


        /* =================================================
           PRODUCTOS
        ================================================= */

        const productos =
            Array.isArray(
                data.productos
            )
                ? data.productos
                : [];


        /* =================================================
           PREGUNTA GENERAL
        ================================================= */

        if (
            data.tipo === "pregunta"
        ) {

            if (
                respuestaIA !== ""
            ) {

                mostrarEstado(
                    "Respuesta generada correctamente.",
                    "exito"
                );

            }

            desplazarseAbajo();

            return;
        }


        /* =================================================
           PRODUCTOS
        ================================================= */

        if (
            productos.length > 0
        ) {


            const filtros =
                data.filtrosAplicados ||
                {};


            let mensaje =
                productos.length +
                " producto" +
                (
                    productos.length !== 1
                        ? "s"
                        : ""
                ) +
                " encontrado" +
                (
                    productos.length !== 1
                        ? "s"
                        : ""
                );


            if (
                filtros.categoria
            ) {

                mensaje +=
                    " · " +
                    filtros.categoria;

            }


            mostrarEstado(
                mensaje,
                "exito"
            );


            const titulo =
                document.createElement(
                    "div"
                );


            titulo.className =
                "productos-titulo";


            titulo.innerText =
                "Encontré esto para ti";


            resultadosDiv.appendChild(
                titulo
            );


            productos.forEach(
                function(prod) {


                    const div =
                        document.createElement(
                            "div"
                        );


                    div.className =
                        "producto";


                    div.innerHTML = `

                        <h3>
                            ${escapeHTML(
                                prod.nombre
                            )}
                        </h3>


                        <p>

                            <b>Código:</b>

                            ${escapeHTML(
                                prod.codigo
                            )}

                        </p>


                        <p>

                            <b>Descripción:</b>

                            ${escapeHTML(
                                prod.descripcion
                            )}

                        </p>


                        <p>

                            <b>Categoría:</b>

                            ${escapeHTML(
                                prod.categoria
                            )}

                        </p>


                        <div class="producto-precio">

                            $${formatearNumero(
                                prod.precio
                            )}

                        </div>


                        <p>

                            <b>Stock:</b>

                            ${formatearNumero(
                                prod.stock
                            )}

                        </p>

                    `;


                    resultadosDiv.appendChild(
                        div
                    );

                }
            );

        }


        /* =================================================
           SIN PRODUCTOS
        ================================================= */

        else {


            if (
                respuestaIA !== ""
            ) {

                mostrarEstado(
                    "Respuesta generada correctamente.",
                    "exito"
                );

            }

            else {

                mostrarEstado(
                    "No se encontraron productos.",
                    ""
                );


                resultadosDiv.innerHTML = `

                    <div class="sin-resultados">

                        <strong>
                            No encontré productos relacionados.
                        </strong>

                        <br>
                        <br>

                        Intenta escribir otra búsqueda
                        o pregúntame directamente qué
                        necesita tu piel o cabello.

                    </div>

                `;

            }

        }


        desplazarseAbajo();


    }

    catch (error) {


        console.error(
            "Error:",
            error
        );


        respuestaIADiv.innerHTML =
            "";


        mostrarEstado(

            "No se pudo conectar con filtrar.php.\n\n" +

            "Comprueba que Apache y PHP estén funcionando " +

            "y que filtrar.php esté en la misma carpeta.\n\n" +

            "Error técnico:\n" +

            error.message,

            "error"

        );

    }


    finally {


        botonBuscar.disabled =
            false;


        botonBuscar.innerHTML =
            "➜";

    }

}


/* =========================================================
   FORMATEAR RESPUESTA
========================================================= */

function formatearRespuesta(
    texto
) {


    let resultado =
        escapeHTML(
            texto
        );


    resultado =
        resultado.replace(
            /\*\*(.*?)\*\*/g,
            "<strong>$1</strong>"
        );


    resultado =
        resultado.replace(
            /\n/g,
            "<br>"
        );


    return resultado;

}


/* =========================================================
   NÚMEROS
========================================================= */

function formatearNumero(
    numero
) {


    const valor =
        Number(
            numero
        );


    if (
        Number.isNaN(
            valor
        )
    ) {

        return "0";

    }


    return valor.toLocaleString(
        "es-ES"
    );

}


/* =========================================================
   SEGURIDAD
========================================================= */

function escapeHTML(
    texto
) {


    const div =
        document.createElement(
            "div"
        );


    div.textContent =
        String(
            texto ?? ""
        );


    return div.innerHTML;

}


/* =========================================================
   SCROLL
========================================================= */

function desplazarseAbajo() {


    setTimeout(
        function() {


            divineContenido.scrollTo(
                {

                    top:
                        divineContenido.scrollHeight,

                    behavior:
                        "smooth"

                }
            );


        },
        100
    );

}


/* =========================================================
   BOTÓN MOVIBLE
========================================================= */

let moviendo =
    false;


let inicioX =
    0;

let inicioY =
    0;


let posicionInicialX =
    0;

let posicionInicialY =
    0;


divineBoton.addEventListener(
    "pointerdown",
    function(event) {


        moviendo =
            false;


        inicioX =
            event.clientX;

        inicioY =
            event.clientY;


        const rect =
            divineBoton.getBoundingClientRect();


        posicionInicialX =
            rect.left;

        posicionInicialY =
            rect.top;


        divineBoton.setPointerCapture(
            event.pointerId
        );

    }
);


divineBoton.addEventListener(
    "pointermove",
    function(event) {


        if (
            !divineBoton.hasPointerCapture(
                event.pointerId
            )
        ) {

            return;

        }


        const diferenciaX =
            event.clientX -
            inicioX;


        const diferenciaY =
            event.clientY -
            inicioY;


        if (
            Math.abs(diferenciaX) > 5 ||
            Math.abs(diferenciaY) > 5
        ) {

            moviendo =
                true;

        }


        if (
            !moviendo
        ) {

            return;

        }


        let nuevaX =
            posicionInicialX +
            diferenciaX;


        let nuevaY =
            posicionInicialY +
            diferenciaY;


        const ancho =
            divineBoton.offsetWidth;


        const alto =
            divineBoton.offsetHeight;


        nuevaX =
            Math.max(
                5,
                Math.min(
                    window.innerWidth -
                    ancho -
                    5,
                    nuevaX
                )
            );


        nuevaY =
            Math.max(
                5,
                Math.min(
                    window.innerHeight -
                    alto -
                    5,
                    nuevaY
                )
            );


        divineBoton.style.left =
            nuevaX + "px";


        divineBoton.style.top =
            nuevaY + "px";


        divineBoton.style.right =
            "auto";


        divineBoton.style.bottom =
            "auto";

    }
);


divineBoton.addEventListener(
    "pointerup",
    function(event) {


        if (
            divineBoton.hasPointerCapture(
                event.pointerId
            )
        ) {

            divineBoton.releasePointerCapture(
                event.pointerId
            );

        }

    }
);


/* =========================================================
   AJUSTAR PANTALLA
========================================================= */

window.addEventListener(
    "resize",
    function() {


        if (
            !divineBoton.style.left
        ) {

            return;

        }


        const rect =
            divineBoton.getBoundingClientRect();


        const ancho =
            divineBoton.offsetWidth;


        const alto =
            divineBoton.offsetHeight;


        const x =
            Math.max(
                5,
                Math.min(
                    window.innerWidth -
                    ancho -
                    5,
                    rect.left
                )
            );


        const y =
            Math.max(
                5,
                Math.min(
                    window.innerHeight -
                    alto -
                    5,
                    rect.top
                )
            );


        divineBoton.style.left =
            x + "px";


        divineBoton.style.top =
            y + "px";

    }
);

</script>

</body>

</html>
