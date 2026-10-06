 <?php

session_start();


// ==================================================
// DATOS DE SESIÓN
// ==================================================

$nombreUsuario = $_SESSION['nombre'] ?? '';
$rol = $_SESSION['rol'] ?? '';


// ==================================================
// CONEXIÓN A LA BASE DE DATOS
// ==================================================

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);

if ($conn->connect_error) {

    die("OCURRIÓ UN ERROR AL CONECTAR CON LA BASE DE DATOS");

}

$conn->set_charset("utf8mb4");


// ==================================================
// CONSULTAR PEDIDOS
// ==================================================

if ($rol == "vendedor") {

    $nombreSeguro = $conn->real_escape_string($nombreUsuario);

    $sql = "
        SELECT *
        FROM PEDIDOS
        WHERE nombrevendedor = '$nombreSeguro'
        ORDER BY ID DESC
    ";

} else {

    $sql = "
        SELECT *
        FROM PEDIDOS
        ORDER BY ID DESC
    ";

}


$resultado = $conn->query($sql);


if (!$resultado) {

    die(
        "ERROR EN LA CONSULTA: " .
        $conn->error
    );

}


// ==================================================
// MENSAJE
// ==================================================

$mensaje = $_GET['mensaje'] ?? null;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>DIVINE | Pedidos</title>


<!-- ==================================================
     SWEETALERT2
================================================== -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>

/* ==================================================
   VARIABLES
================================================== */

:root {

    --rosa: #b86f80;
    --rosa-claro: #d9a6b2;
    --rosa-palido: #f7e9ec;
    --crema: #fffaf8;
    --texto: #57494c;
    --gris: #817679;
    --borde: #e3c5cd;
    --vino: #8f5362;
    --vino-oscuro: #713d4d;

}


/* ==================================================
   RESET
================================================== */

* {

    margin: 0;
    padding: 0;
    box-sizing: border-box;

}


/* ==================================================
   BODY
================================================== */

body {

    min-height: 100vh;

    font-family: 'Segoe UI', sans-serif;

    color: var(--texto);

    background:

        linear-gradient(
            rgba(255,250,248,.78),
            rgba(247,233,236,.90)
        ),

        url("../imagenes/fondote.png");

    background-size: cover;

    background-position: center;

    background-attachment: fixed;

}


/* ==================================================
   ENCABEZADO
================================================== */

.header {

    text-align: center;

    padding: 45px 20px 35px;

    background:

        linear-gradient(
            rgba(184,111,128,.88),
            rgba(143,83,98,.94)
        );

    color: white;

    box-shadow:
        0 10px 35px rgba(100,70,80,.20);

}


.header-pequeno {

    font-size: .78rem;

    text-transform: uppercase;

    letter-spacing: 5px;

    margin-bottom: 15px;

    opacity: .9;

}


.header h1 {

    font-family: Georgia, serif;

    font-size: clamp(2.4rem,5vw,4rem);

    font-weight: 400;

    letter-spacing: 5px;

}


.header-linea {

    width: 55px;

    height: 2px;

    background: white;

    margin: 22px auto 0;

    opacity: .75;

}


/* ==================================================
   CONTENEDOR
================================================== */

.contenedor {

    width: 90%;

    max-width: 1100px;

    margin: 60px auto;

}


/* ==================================================
   TÍTULO LISTA
================================================== */

.titulo-lista {

    text-align: center;

    margin-bottom: 38px;

}


.titulo-lista p {

    color: var(--rosa);

    font-size: .8rem;

    text-transform: uppercase;

    letter-spacing: 3px;

    margin-bottom: 10px;

}


.titulo-lista h2 {

    font-family: Georgia, serif;

    font-size: 2rem;

    font-weight: 400;

    color: var(--texto);

}


/* ==================================================
   LISTA
================================================== */

.lista {

    display: flex;

    flex-direction: column;

    gap: 28px;

}


/* ==================================================
   TARJETA PEDIDO
================================================== */

.item {

    background: rgba(250,243,244,.94);

    border: 1px solid rgba(184,111,128,.25);

    border-radius: 24px;

    padding: 30px 32px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 35px;

    box-shadow:

        0 12px 35px rgba(100,70,80,.13),

        inset 0 1px 0 rgba(255,255,255,.8);

    transition:

        transform .35s ease,

        box-shadow .35s ease,

        background .35s ease;

    animation: aparecer .6s ease;

}


.item:hover {

    transform: translateY(-6px);

    background: rgba(248,236,239,.98);

    box-shadow:

        0 20px 45px rgba(100,70,80,.18);

}


/* ==================================================
   INFORMACIÓN
================================================== */

.info {

    flex: 1;

    min-width: 0;

}


/* ==================================================
   NÚMERO DE PEDIDO
================================================== */

.id {

    display: inline-flex;

    align-items: center;

    background:

        linear-gradient(
            135deg,
            var(--vino),
            var(--rosa)
        );

    color: white;

    padding: 12px 22px;

    border-radius: 14px;

    font-size: 1.05rem;

    font-weight: 700;

    letter-spacing: 1.5px;

    margin-bottom: 22px;

    box-shadow:

        0 7px 18px rgba(143,83,98,.25);

    border: 1px solid rgba(255,255,255,.35);

    transition:

        transform .3s ease,

        box-shadow .3s ease;

}


.item:hover .id {

    transform: translateY(-2px);

    box-shadow:

        0 10px 22px rgba(143,83,98,.32);

}


/* ==================================================
   DATOS
================================================== */

.datos {

    display: grid;

    grid-template-columns:
        repeat(2,minmax(180px,1fr));

    gap: 14px 25px;

}


/* ==================================================
   CAJAS DE INFORMACIÓN
================================================== */

.info p {

    margin: 0;

    background: rgba(255,250,251,.72);

    border: 1px solid rgba(184,111,128,.15);

    border-radius: 12px;

    padding: 10px 14px;

    color: var(--gris);

    font-size: .92rem;

    line-height: 1.5;

    box-shadow:

        0 3px 10px rgba(100,70,80,.04);

    transition:

        background .3s ease,

        transform .3s ease;

}


.info p:hover {

    background: rgba(255,255,255,.9);

    transform: translateX(3px);

}


.info span {

    color: var(--vino-oscuro);

    font-weight: 700;

}


/* ==================================================
   ESTADO
================================================== */

.estado {

    display: inline-flex;

    align-items: center;

    margin-top: 22px;

    padding: 11px 20px;

    border-radius: 14px;

    background:

        linear-gradient(
            135deg,
            #fff0f3,
            #f5dce2
        );

    color: var(--vino-oscuro);

    font-size: .88rem;

    font-weight: 700;

    text-transform: capitalize;

    letter-spacing: .3px;

    border: 1px solid rgba(184,111,128,.3);

    box-shadow:

        0 5px 15px rgba(184,111,128,.12);

    transition:

        transform .3s ease,

        box-shadow .3s ease;

}


.estado:hover {

    transform: translateY(-2px);

    box-shadow:

        0 8px 20px rgba(184,111,128,.20);

}


/* ==================================================
   BOTONES
================================================== */

.botones {

    display: flex;

    flex-direction: column;

    gap: 10px;

    min-width: 125px;

}


.botones a {

    text-decoration: none;

}


.botones button {

    width: 100%;

    min-width: 120px;

    padding: 12px 18px;

    border: none;

    border-radius: 11px;

    color: white;

    cursor: pointer;

    font-size: .85rem;

    font-weight: 600;

    transition:

        transform .25s ease,

        box-shadow .25s ease;

}


.botones button:hover {

    transform: translateY(-3px);

    box-shadow:

        0 7px 17px rgba(100,70,80,.20);

}


/* ==================================================
   ACEPTAR
================================================== */

.btn-aceptar {

    background: var(--vino);

}


/* ==================================================
   RECHAZAR
================================================== */

.btn-rechazar {

    background: #b87986;

}


/* ==================================================
   DETALLES
================================================== */

.btn-detalles {

    background: var(--vino);

}


/* ==================================================
   EDITAR
================================================== */

.btn-editar {

    background: var(--rosa);

}


/* ==================================================
   ELIMINAR
================================================== */

.btn-eliminar {

    background: #b87986;

}


/* ==================================================
   SWEETALERT2
================================================== */

.swal2-popup {

    width: 430px !important;

    max-width: 90% !important;

    border-radius: 25px !important;

    background: #fffaf9 !important;

    border: 1px solid #ead1d8 !important;

    box-shadow:
        0 25px 70px rgba(82,43,57,.25) !important;

    padding: 30px !important;

}


.swal2-title {

    font-family: Georgia, serif !important;

    color: #713d4d !important;

    font-size: 30px !important;

    font-weight: 500 !important;

}


.swal2-html-container {

    color: #817679 !important;

    font-family: 'Segoe UI', sans-serif !important;

    font-size: 14px !important;

    line-height: 1.7 !important;

}


.swal2-icon.swal2-warning {

    border-color: #d58da1 !important;

    color: #b86f80 !important;

}


.swal2-icon.swal2-question {

    border-color: #d39aaa !important;

    color: #a85c76 !important;

}


.swal2-confirm {

    background:

        linear-gradient(
            135deg,
            #b86f80,
            #8f5362
        ) !important;

    color: white !important;

    border: none !important;

    border-radius: 12px !important;

    padding: 12px 23px !important;

    font-size: 13px !important;

    font-weight: 600 !important;

    box-shadow:
        0 7px 18px rgba(143,83,98,.25) !important;

}


.swal2-confirm:hover {

    background:

        linear-gradient(
            135deg,
            #a85d71,
            #7f4656
        ) !important;

}


.swal2-cancel {

    background: #f1e1e5 !important;

    color: #713d4d !important;

    border: none !important;

    border-radius: 12px !important;

    padding: 12px 23px !important;

    font-size: 13px !important;

    font-weight: 600 !important;

}


.swal2-cancel:hover {

    background: #e8d1d8 !important;

}


.swal2-actions {

    gap: 10px !important;

    margin-top: 20px !important;

}


/* ==================================================
   SIN PEDIDOS
================================================== */

.vacio {

    background: rgba(250,243,244,.94);

    border: 1px solid var(--borde);

    border-radius: 22px;

    padding: 70px 30px;

    text-align: center;

    color: var(--gris);

    box-shadow:

        0 12px 35px rgba(100,70,80,.10);

}


/* ==================================================
   VOLVER
================================================== */

.volver {

    text-align: center;

    margin-top: 45px;

    padding-bottom: 30px;

}


.volver a {

    display: inline-block;

    text-decoration: none;

    color: white;

    background: var(--vino);

    padding: 14px 32px;

    border-radius: 30px;

    font-size: .9rem;

    font-weight: 600;

    letter-spacing: .3px;

    box-shadow:

        0 7px 20px rgba(100,70,80,.18);

    transition:

        background .3s ease,

        transform .3s ease,

        box-shadow .3s ease;

}


.volver a:hover {

    background: var(--rosa);

    transform: translateY(-3px);

    box-shadow:

        0 10px 25px rgba(100,70,80,.25);

}


/* ==================================================
   ANIMACIÓN
================================================== */

@keyframes aparecer {

    from {

        opacity: 0;

        transform: translateY(20px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:768px) {

    .header {

        padding: 50px 20px 40px;

    }


    .header h1 {

        font-size: 2.5rem;

        letter-spacing: 3px;

    }


    .contenedor {

        width: 92%;

        margin: 40px auto;

    }


    .item {

        flex-direction: column;

        align-items: stretch;

        padding: 25px 20px;

    }


    .id {

        font-size: 1rem;

        padding: 11px 18px;

    }


    .datos {

        grid-template-columns: 1fr;

        gap: 10px;

    }


    .botones {

        display: grid;

        grid-template-columns: repeat(3,1fr);

        gap: 8px;

        min-width: 0;

        margin-top: 10px;

    }


    .botones button {

        min-width: 0;

        padding: 10px 5px;

        font-size: .78rem;

    }

}


@media(max-width:450px) {

    .botones {

        grid-template-columns: 1fr;

    }


    .botones button {

        width: 100%;

    }


    .titulo-lista h2 {

        font-size: 1.7rem;

    }

}


/* ==================================================
   MODAL MENSAJE
================================================== */

.modal-mensaje {

    position: fixed;

    top: 0;

    left: 0;

    width: 100%;

    height: 100%;

    background: rgba(0,0,0,0.45);

    display: flex;

    justify-content: center;

    align-items: center;

    z-index: 9999;

}


.mensaje-contenido {

    width: 400px;

    max-width: 90%;

    background: white;

    padding: 35px;

    border-radius: 20px;

    text-align: center;

    box-shadow:

        0 10px 40px rgba(0,0,0,0.25);

    animation: aparecer .3s ease;

}


.icono-exito {

    width: 65px;

    height: 65px;

    margin: 0 auto 15px;

    border-radius: 50%;

    background: #dff5df;

    color: #3c9b3c;

    font-size: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: bold;

}


.mensaje-contenido h2 {

    margin-bottom: 10px;

}


.mensaje-contenido p {

    font-size: 17px;

    margin-bottom: 25px;

}


.mensaje-contenido button {

    padding: 10px 30px;

    border: none;

    border-radius: 10px;

    cursor: pointer;

    font-size: 16px;

    transition: .3s ease;

}


.mensaje-contenido button:hover {

    background-color: #b77f8a;

    color: black;

    transform: scale(1.05);

}

</style>

</head>


<body>


<?php if ($mensaje): ?>

<div class="modal-mensaje">

    <div class="mensaje-contenido">

        <div class="icono-exito">
            ✓
        </div>

        <h2>
            ¡Pedido actualizado!
        </h2>

        <p>

            <?php

            echo htmlspecialchars(
                $mensaje,
                ENT_QUOTES,
                'UTF-8'
            );

            ?>

        </p>

        <button onclick="cerrarMensaje()">
            Aceptar
        </button>

    </div>

</div>

<?php endif; ?>


<!-- ==================================================
     ENCABEZADO
================================================== -->

<div class="header">

    <div class="header-pequeno">
        Administración de pedidos
    </div>

    <h1>
        PEDIDOS DIVINE
    </h1>

    <div class="header-linea"></div>

</div>


<!-- ==================================================
     CONTENEDOR
================================================== -->

<div class="contenedor">


    <div class="titulo-lista">

        <p>
            Gestión de pedidos
        </p>

        <h2>
            Lista de pedidos registrados
        </h2>

    </div>


    <div class="lista">


<?php

if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $idPedido = $fila['ID'];

        $nombrePedido = $fila['nombre'];

?>



        <!-- ==================================================
             TARJETA DEL PEDIDO
        ================================================== -->

        <div class="item">


            <div class="info">


                <div class="id">

                    PEDIDO #

                    <?php

                    echo htmlspecialchars(
                        $idPedido,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>

                </div>


                <div class="datos">


                    <p>

                        <span>
                            Nombre:
                        </span>

                        <?php

                        echo htmlspecialchars(
                            $fila['nombre'],
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </p>


                    <p>

                        <span>
                            Fecha:
                        </span>

                        <?php

                        echo htmlspecialchars(
                            $fila['fecha'],
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </p>


                    <p>

                        <span>
                            Teléfono:
                        </span>

                        <?php

                        echo htmlspecialchars(
                            $fila['telefono'],
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </p>


                    <p>

                        <span>
                            Dirección:
                        </span>

                        <?php

                        echo htmlspecialchars(
                            $fila['direccion'],
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </p>


                    <p>

                        <span>
                            Vendedor:
                        </span>

                        <?php

                        echo htmlspecialchars(
                            $fila['nombrevendedor'],
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        ?>

                    </p>


                </div>


                <div class="estado">

                    Estado:

                    <?php

                    echo htmlspecialchars(
                        $fila['estado'],
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>

                </div>


                <br>
                <br>


                <!-- ==================================================
                     ACEPTAR / RECHAZAR
                ================================================== -->

                <div class="botones">


                    <!-- ACEPTAR -->

                    <button
                        type="button"
                        class="btn-aceptar"
                        onclick="aceptarPedido(<?php echo (int)$idPedido; ?>)"
                    >
                        Aceptar
                    </button>


                    <!-- RECHAZAR -->

                    <button
                        type="button"
                        class="btn-rechazar"
                        onclick="confirmarRechazo(<?php echo (int)$idPedido; ?>)"
                    >
                        Rechazar
                    </button>


                </div>


            </div>


            <!-- ==================================================
                 BOTONES DERECHOS
            ================================================== -->

            <div class="botones">


                <!-- DETALLES -->

                <a
                    href="readunopedido.php?idPedido=<?php echo urlencode($idPedido); ?>"
                >

                    <button
                        type="button"
                        class="btn-detalles"
                    >
                        Detalles
                    </button>

                </a>


                <?php if ($rol == "administrador") { ?>


                    <!-- EDITAR -->

                    <a
                        href="updateformpedido.php?idPedido=<?php echo urlencode($idPedido); ?>"
                    >

                        <button
                            type="button"
                            class="btn-editar"
                        >
                            Editar
                        </button>

                    </a>


                    <!-- ==================================================
                         ELIMINAR
                    ================================================== -->

                    <button
                        type="button"
                        class="btn-eliminar"
                        onclick="confirmarEliminacion(
                            <?php echo (int)$idPedido; ?>,
                            <?php echo htmlspecialchars(
                                json_encode(
                                    $nombrePedido,
                                    JSON_UNESCAPED_UNICODE
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>
                        )"
                    >
                        Eliminar
                    </button>


                <?php } ?>


            </div>


        </div>



<?php

    }

} else {

?>

        <div class="vacio">

            No hay pedidos registrados en este momento.

        </div>

<?php

}

?>


    </div>


<?php

// ==================================================
// RUTA VOLVER
// ==================================================

$rol = $_SESSION['rol'] ?? '';

if ($rol === 'vendedor') {

    $rutaVolver = '../perfilvendedor.php';

} elseif ($rol === 'administrador') {

    $rutaVolver = '../admin.php';

} else {

    $rutaVolver = '../SESIONES/loginformcliente.php';

}

?>


<div class="volver">

    <a href="<?php echo htmlspecialchars($rutaVolver); ?>">

        Volver al perfil

    </a>

</div>


</div>


<script>


/* ==================================================
   CERRAR MENSAJE
================================================== */

function cerrarMensaje() {

    const modal = document.querySelector(
        ".modal-mensaje"
    );

    if (modal) {

        modal.style.display = "none";

    }

}


/* ==================================================
   ACEPTAR PEDIDO
================================================== */

function aceptarPedido(idPedido) {

    Swal.fire({

        title: "¿Aceptar este pedido?",

        html: `
            <div style="
                color:#817679;
                font-size:14px;
                line-height:1.7;
            ">

                El pedido

                <strong style="color:#8f5362;">
                    #${idPedido}
                </strong>

                cambiará su estado a

                <strong style="color:#8f5362;">
                    Aceptado
                </strong>.

            </div>
        `,

        icon: "question",

        iconColor: "#b86f80",

        showCancelButton: true,

        confirmButtonText: "Sí, aceptar",

        cancelButtonText: "Cancelar",

        reverseButtons: true,

        allowOutsideClick: false,

        focusCancel: true

    }).then(function(result) {

        if (result.isConfirmed) {

            window.location.href =
                "actualizarestadopedido.php?idPedido="
                + encodeURIComponent(idPedido)
                + "&estado=Aceptado";

        }

    });

}


/* ==================================================
   RECHAZAR PEDIDO
================================================== */

function confirmarRechazo(idPedido) {

    Swal.fire({

        title: "¿Deseas rechazar este pedido?",

        html: `
            <div style="
                color:#817679;
                font-size:14px;
                line-height:1.7;
            ">

                El pedido

                <strong style="color:#8f5362;">
                    #${idPedido}
                </strong>

                cambiará su estado a

                <strong style="color:#8f5362;">
                    Rechazado
                </strong>.

            </div>
        `,

        icon: "warning",

        iconColor: "#c56f86",

        showCancelButton: true,

        confirmButtonText: "Sí, rechazar",

        cancelButtonText: "Cancelar",

        reverseButtons: true,

        allowOutsideClick: false,

        focusCancel: true

    }).then(function(result) {

        if (result.isConfirmed) {

            window.location.href =
                "actualizarestadopedido.php?idPedido="
                + encodeURIComponent(idPedido)
                + "&estado=Rechazado";

        }

    });

}


/* ==================================================
   ELIMINAR PEDIDO
================================================== */

function confirmarEliminacion(idPedido, nombreCliente) {

    Swal.fire({

        title: "¿Eliminar este pedido?",

        html: `
            <div style="
                color:#817679;
                font-size:14px;
                line-height:1.7;
            ">

                ¿Estás seguro de que quieres

                <strong style="color:#a9536d;">
                    eliminar este pedido?
                </strong>

                <br>
                <br>

                <div style="
                    background:#f8eaee;
                    border:1px solid #e6cbd3;
                    border-radius:14px;
                    padding:14px;
                ">

                    <div style="
                        color:#713d4d;
                        font-weight:700;
                        font-size:15px;
                    ">

                        Pedido #${idPedido}

                    </div>


                    <div style="
                        color:#8b727b;
                        font-size:12px;
                        margin-top:4px;
                    ">

                        Cliente: ${nombreCliente}

                    </div>

                </div>

                <br>

                <span style="
                    color:#a47784;
                    font-size:12px;
                ">

                    Esta acción no se puede deshacer.

                </span>

            </div>
        `,

        icon: "warning",

        iconColor: "#c15f7b",

        showCancelButton: true,

        confirmButtonText: "Sí, eliminar",

        cancelButtonText: "Cancelar",

        reverseButtons: true,

        allowOutsideClick: false,

        focusCancel: true

    }).then(function(result) {

        if (result.isConfirmed) {

            window.location.href =
                "deletepedido.php?idPedido="
                + encodeURIComponent(idPedido);

        }

    });

}


</script>


</body>

</html>


<?php

$conn->close();

?>