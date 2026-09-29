
<style>
 

.carrito-divine{

    position:fixed;

    top:20px;
    right:30px;

    z-index:99999;

    display:flex;

    align-items:center;
    justify-content:center;
}

 

.boton-carrito-divine{

    position:relative;

    width: 20px;
    height: 200px;
    display:flex;

    justify-content:center;
    align-items:center;

    cursor:pointer;

    background:transparent;

    border:none;

    padding:0;

    transition:
        transform .3s ease;
}


.boton-carrito-divine:hover{

    transform:
        scale(1.08);
}

 

.boton-carrito-divine img{

    width:80px;
    height:80px;

    object-fit:contain;

    display:block;

    transition:
        transform .3s ease;
}


.boton-carrito-divine:hover img{

    transform:
        scale(1.1);
}


/* ==================================================
   CONTADOR
================================================== */

.contador-carrito{

    position:absolute;

    top:-12px;
    left:-10px;

    min-width:18px;
    height:18px;

    padding:2px 5px;

    background:#713d4d;

    color:white;

    border-radius:20px;

    font-family:Arial,sans-serif;

    font-size:10px;

    font-weight:bold;

    display:none;

    justify-content:center;
    align-items:center;

    line-height:1;
}


.contador-carrito.activo{

    display:flex;
}


/*
Compatibilidad con el nombre
del archivo independiente.
*/

.contador-carrito-divine{

    position:absolute;

    top:-12px;
    left:-10px;

    min-width:18px;
    height:18px;

    padding:2px 5px;

    background:#713d4d;

    color:white;

    border-radius:20px;

    font-family:Arial,sans-serif;

    font-size:10px;

    font-weight:bold;

    display:none;

    justify-content:center;
    align-items:center;

    line-height:1;
}


.contador-carrito-divine.activo{

    display:flex;
}


/* ==================================================
   ESTRELLITA
================================================== */

.estrellita-carrito{

    position:absolute;

    top:-10px;
    right:-10px;

    width:18px;
    height:18px;

    background:#c96f84;

    color:white;

    border-radius:50%;

    display:none;

    justify-content:center;
    align-items:center;

    font-family:Arial,sans-serif;

    font-size:12px;

    font-weight:bold;

    box-shadow:
        0 2px 8px rgba(201,111,132,.5);

    animation:
        aparecerEstrella .5s ease,
        pulsarEstrella 1.5s infinite;
}


.estrellita-carrito.activa{

    display:flex;
}


/* Compatibilidad */

.estrellita-carrito-divine{

    position:absolute;

    top:-10px;
    right:-10px;

    width:18px;
    height:18px;

    background:#c96f84;

    color:white;

    border-radius:50%;

    display:none;

    justify-content:center;
    align-items:center;

    font-family:Arial,sans-serif;

    font-size:12px;

    font-weight:bold;

    box-shadow:
        0 2px 8px rgba(201,111,132,.5);

    animation:
        aparecerEstrella .5s ease,
        pulsarEstrella 1.5s infinite;
}


.estrellita-carrito-divine.activa{

    display:flex;
}


/* ==================================================
   ANIMACIÓN ESTRELLA
================================================== */

@keyframes aparecerEstrella{

    from{

        opacity:0;

        transform:
            scale(0);
    }

    to{

        opacity:1;

        transform:
            scale(1);
    }
}


@keyframes pulsarEstrella{

    0%{

        transform:
            scale(1);
    }

    50%{

        transform:
            scale(1.18);
    }

    100%{

        transform:
            scale(1);
    }
}


/* ==================================================
   MODAL
================================================== */

.modal-carrito{

    position:fixed;

    top:0;
    left:0;

    width:100vw;
    height:100vh;

    background:
        rgba(0,0,0,.45);

    display:none;

    justify-content:center;
    align-items:center;

    z-index:100000;

    padding:20px;
}


.modal-carrito.activo{

    display:flex;
}

 

.modal-carrito[style*="display: block"]{

    display:flex !important;
}

 
.modal-carrito-divine{

    position:fixed;

    top:0;
    left:0;

    width:100vw;
    height:100vh;

    background:
        rgba(0,0,0,.45);

    display:none;

    justify-content:center;
    align-items:center;

    z-index:100000;

    padding:20px;
}


.modal-carrito-divine.activo{

    display:flex;
}


.modal-carrito-divine[style*="display: block"]{

    display:flex !important;
}

 
.carrito-ventana{

    width:95%;

    max-width:1200px;

    min-height:400px;

    max-height:90vh;

    overflow-y:auto;

    overflow-x:hidden;

    background:white;

    border-radius:25px;

    padding:35px;

    box-shadow:
        0 20px 60px rgba(0,0,0,.30);

    animation:
        aparecerCarrito .3s ease;
}


.carrito-ventana-divine{

    width:95%;

    max-width:1200px;

    min-height:400px;

    max-height:90vh;

    overflow-y:auto;

    overflow-x:hidden;

    background:white;

    border-radius:25px;

    padding:35px;

    box-shadow:
        0 20px 60px rgba(0,0,0,.30);

    animation:
        aparecerCarrito .3s ease;
}

 

@keyframes aparecerCarrito{

    from{

        opacity:0;

        transform:
            translateY(30px)
            scale(.95);
    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);
    }
}
 
.carrito-cabecera{

    display:flex;

    justify-content:space-between;
    align-items:center;

    border-bottom:
        1px solid #eee;

    padding-bottom:15px;

    margin-bottom:20px;
}


.carrito-cabecera h2{

    color:#713d4d;

    font-family:
        Georgia,
        serif;

    font-size:28px;

    font-weight:400;

    margin:0;
}


 

.carrito-cabecera-divine{

    display:flex;

    justify-content:space-between;
    align-items:center;

    border-bottom:
        1px solid #eee;

    padding-bottom:15px;

    margin-bottom:20px;
}


.carrito-cabecera-divine h2{

    color:#713d4d;

    font-family:
        Georgia,
        serif;

    font-size:28px;

    font-weight:400;

    margin:0;
}

 
.cerrar-carrito{

    border:none;

    background:#f7e9ec;

    color:#713d4d;

    width:42px;
    height:42px;

    border-radius:50%;

    cursor:pointer;

    font-size:25px;

    display:flex;

    justify-content:center;
    align-items:center;

    transition:.3s;
}


.cerrar-carrito:hover{

    background:#713d4d;

    color:white;

    transform:
        rotate(90deg);
}

 

.cerrar-carrito-divine{

    border:none;

    background:#f7e9ec;

    color:#713d4d;

    width:42px;
    height:42px;

    border-radius:50%;

    cursor:pointer;

    font-size:25px;

    display:flex;

    justify-content:center;
    align-items:center;

    transition:.3s;
}


.cerrar-carrito-divine:hover{

    background:#713d4d;

    color:white;

    transform:
        rotate(90deg);
}

 
#contenidoCarrito{

    min-height:150px;

    width:100%;
}


 

#contenidoCarritoDivine{

    min-height:150px;

    width:100%;
}

 
.producto-carrito{

    display:flex;

    justify-content:space-between;
    align-items:center;

    gap:15px;

    padding:20px;

    margin-bottom:12px;

    background:#fdf5f7;

    border-radius:15px;

    border:
        1px solid #f0d6dc;
}


.producto-carrito-info{

    flex:1;
}


.producto-carrito-nombre{

    color:#713d4d;

    font-weight:bold;

    font-size:17px;

    margin-bottom:5px;
}


.producto-carrito-datos{

    color:#777;

    font-size:14px;
}


.producto-carrito-total{

    color:#b45d72;

    font-weight:bold;

    font-size:17px;
}

 

.producto-carrito-divine{

    display:flex;

    justify-content:space-between;
    align-items:center;

    gap:15px;

    padding:20px;

    margin-bottom:12px;

    background:#fdf5f7;

    border-radius:15px;

    border:
        1px solid #f0d6dc;
}


.producto-carrito-info-divine{

    flex:1;
}


.producto-carrito-nombre-divine{

    color:#713d4d;

    font-weight:bold;

    margin-bottom:5px;
}


.producto-carrito-datos-divine{

    color:#777;

    font-size:14px;
}


.producto-carrito-total-divine{

    color:#b45d72;

    font-weight:bold;
}

 
.carrito-vacio{

    text-align:center;

    padding:50px 20px;

    color:#777;
}


.carrito-vacio-divine{

    text-align:center;

    padding:50px 20px;

    color:#777;
}

 
.boton-actualizar-carrito{

    width:100%;

    margin-top:20px;

    padding:15px;

    border:none;

    border-radius:25px;

    background:#c96f84;

    color:white;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;
}


.boton-actualizar-carrito:hover{

    background:#b45d72;

    transform:
        translateY(-2px);
}


/* Compatibilidad */

.boton-actualizar-carrito-divine{

    width:100%;

    margin-top:20px;

    padding:15px;

    border:none;

    border-radius:25px;

    background:#c96f84;

    color:white;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;
}


.boton-actualizar-carrito-divine:hover{

    background:#b45d72;

    transform:
        translateY(-2px);
}


/* ==================================================
   SCROLL
================================================== */

.carrito-ventana::-webkit-scrollbar,
.carrito-ventana-divine::-webkit-scrollbar{

    width:8px;
}


.carrito-ventana::-webkit-scrollbar-track,
.carrito-ventana-divine::-webkit-scrollbar-track{

    background:#f7e9ec;

    border-radius:10px;
}


.carrito-ventana::-webkit-scrollbar-thumb,
.carrito-ventana-divine::-webkit-scrollbar-thumb{

    background:#c96f84;

    border-radius:10px;
}


/* ==================================================
   TABLET / CELULAR
================================================== */

@media(max-width:768px){

    .carrito-divine{

        top:12px;
        right:15px;
    }


    .boton-carrito-divine{

        width:42px;
        height:42px;
    }


    .boton-carrito-divine img{

        width:27px;
        height:27px;
    }


    .modal-carrito,
    .modal-carrito-divine{

        padding:12px;
    }


    .carrito-ventana,
    .carrito-ventana-divine{

        width:96%;

        max-width:none;

        max-height:90vh;

        min-height:350px;

        padding:20px;

        border-radius:20px;
    }


    .carrito-cabecera h2,
    .carrito-cabecera-divine h2{

        font-size:23px;
    }


    .cerrar-carrito,
    .cerrar-carrito-divine{

        width:38px;
        height:38px;

        font-size:22px;
    }
}


/* ==================================================
   CELULAR PEQUEÑO
================================================== */

@media(max-width:480px){

    .producto-carrito,
    .producto-carrito-divine{

        flex-direction:column;

        align-items:flex-start;
    }


    .carrito-ventana,
    .carrito-ventana-divine{

        width:100%;

        max-height:92vh;

        padding:18px;

        border-radius:18px;
    }


    .carrito-cabecera h2,
    .carrito-cabecera-divine h2{

        font-size:20px;
    }
}

</style>


<!-- ==================================================
     ÍCONO DEL CARRITO
================================================== -->

<div class="carrito-divine">

    <button
        type="button"
        class="boton-carrito-divine"
        onclick="abrirCarrito(event)"
        title="Ver carrito"
    >

        <img
            src="../imagenes/carrito.png"
            alt="Carrito"
        >


        <!-- ESTRELLITA -->

        <span
            id="estrellitaCarrito"
            class="estrellita-carrito"
        >
            ✦
        </span>


        <!-- CONTADOR -->

        <span
            id="contadorCarrito"
            class="contador-carrito"
        >
            0
        </span>

    </button>

</div>


<!-- ==================================================
     VENTANA DEL CARRITO
================================================== -->

<div
    class="modal-carrito"
    id="ventanaCarrito"
>

    <div class="carrito-ventana">


        <!-- CABECERA -->

        <div class="carrito-cabecera">

            <h2>
                Mi carrito
            </h2>


            <button
                type="button"
                class="cerrar-carrito"
                onclick="cerrarCarrito()"
            >

                ×

            </button>

        </div>


        <!-- CONTENIDO -->

        <div id="contenidoCarrito">

            <div class="carrito-vacio">

                Cargando carrito...

            </div>

        </div>


        <!-- ACTUALIZAR -->

        <button
            type="button"
            class="boton-actualizar-carrito"
            onclick="abrirCarrito()"
        >

            ↻ Actualizar carrito

        </button>

    </div>

</div>


<script>

/* ==================================================
   ABRIR CARRITO
================================================== */

function abrirCarrito(event){

    if(event){

        event.preventDefault();

    }


    const carrito =
        document.getElementById(
            "ventanaCarrito"
        );


    if(!carrito){

        return;

    }


    carrito.classList.add(
        "activo"
    );


    carrito.style.display =
        "flex";


    

    if(
        typeof cargarCarrito ===
        "function"
    ){

        cargarCarrito();

    }

}


/* ==================================================
   CERRAR CARRITO
================================================== */

function cerrarCarrito(){

    const carrito =
        document.getElementById(
            "ventanaCarrito"
        );


    if(!carrito){

        return;

    }


    carrito.classList.remove(
        "activo"
    );


    carrito.style.display =
        "none";

}


/* ==================================================
   CERRAR AL HACER CLICK AFUERA
================================================== */

document.addEventListener(
    "click",
    function(event){

        const carrito =
            document.getElementById(
                "ventanaCarrito"
            );


        if(!carrito){

            return;

        }


        if(
            carrito.classList.contains(
                "activo"
            ) &&
            event.target === carrito
        ){

            cerrarCarrito();

        }

    }
);


/* ==================================================
   CERRAR CON ESC
================================================== */

document.addEventListener(
    "keydown",
    function(event){

        if(
            event.key === "Escape"
        ){

            const carrito =
                document.getElementById(
                    "ventanaCarrito"
                );


            if(
                carrito &&
                carrito.classList.contains(
                    "activo"
                )
            ){

                cerrarCarrito();

            }

        }

    }
);


/* ==================================================
   ACTUALIZAR CONTADOR
================================================== */

function actualizarContadorCarrito(
    cantidad
){

    const contador =
        document.getElementById(
            "contadorCarrito"
        );


    if(!contador){

        return;

    }


    cantidad =
        parseInt(cantidad) || 0;


    contador.textContent =
        cantidad;


    if(
        cantidad > 0
    ){

        contador.classList.add(
            "activo"
        );

    }

    else{

        contador.classList.remove(
            "activo"
        );

    }

}


/* ==================================================
   ACTIVAR ESTRELLITA
================================================== */

function activarEstrellitaCarrito(){

    const estrella =
        document.getElementById(
            "estrellitaCarrito"
        );


    if(!estrella){

        return;

    }


    estrella.classList.add(
        "activa"
    );

}


/* ==================================================
   DESACTIVAR ESTRELLITA
================================================== */

function desactivarEstrellitaCarrito(){

    const estrella =
        document.getElementById(
            "estrellitaCarrito"
        );


    if(!estrella){

        return;

    }


    estrella.classList.remove(
        "activa"
    );

}


/* ==================================================
   ACTUALIZAR CARRITO
================================================== */

function actualizarCarrito(
    cantidad
){

    cantidad =
        parseInt(cantidad) || 0;


    actualizarContadorCarrito(
        cantidad
    );


    if(
        cantidad > 0
    ){

        activarEstrellitaCarrito();

    }

    else{

        desactivarEstrellitaCarrito();

    }

}


/* ==================================================
   FUNCIONES DEL ARCHIVO DIVINE ANTERIOR
   MANTENIDAS COMO COMPATIBILIDAD
================================================== */

function abrirCarritoDivine(event){

    abrirCarrito(event);

}


function cerrarCarritoDivine(){

    cerrarCarrito();

}


function actualizarContadorCarritoDivine(
    cantidad
){

    actualizarContadorCarrito(
        cantidad
    );

}


function activarEstrellitaCarritoDivine(){

    activarEstrellitaCarrito();

}


function desactivarEstrellitaCarritoDivine(){

    desactivarEstrellitaCarrito();

}


function actualizarCarritoDivine(
    cantidad
){

    actualizarCarrito(
        cantidad
    );

}


/* ==================================================
   COMPROBAR CARRITO
================================================== */

function comprobarCarritoDivine(){

    const carrito =
        document.getElementById(
            "ventanaCarrito"
        );


    if(!carrito){

        return;

    }


    if(
        carrito.classList.contains(
            "activo"
        )
    ){

        carrito.style.display =
            "flex";

    }

}


/* ==================================================
   CARGAR
================================================== */

document.addEventListener(
    "DOMContentLoaded",
    function(){

        comprobarCarritoDivine();

    }
);

</script>