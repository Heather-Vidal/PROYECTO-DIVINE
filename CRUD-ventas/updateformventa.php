<?php

// ==================================================
// CONEXIÓN
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


// ==================================================
// COMPROBAR CONEXIÓN
// ==================================================

if ($conn->connect_error) {

    die(
        "Error al conectar con la base de datos: "
        . $conn->connect_error
    );

}

$conn->set_charset("utf8mb4");


// ==================================================
// RECIBIR ID
// ==================================================

$id = $_GET['id'] ?? null;

if ($id === null || !is_numeric($id)) {

    die("No se recibió un ID de venta válido.");

}

$id = (int)$id;


// ==================================================
// BUSCAR VENTA
// ==================================================

$stmt = $conn->prepare("
    SELECT *
    FROM VENTAS
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();


// ==================================================
// COMPROBAR CONSULTA
// ==================================================

if (!$resultado) {

    die(
        "Error al consultar la venta: "
        . $conn->error
    );

}


// ==================================================
// COMPROBAR SI EXISTE
// ==================================================

if ($resultado->num_rows == 0) {

    die(
        "La venta que intentas modificar no existe."
    );

}


// ==================================================
// GUARDAR DATOS
// ==================================================

$fila = $resultado->fetch_assoc();

$idVenta = $fila['id'];
$estado = $fila['estado'];
$metodo = $fila['metodo'];
$costoTotal = $fila['costototal'];
$idPedido = $fila['PEDIDOS_ID'];

$stmt->close();

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Modificar Venta · DIVINE
</title>


<!-- ==================================================
     GOOGLE FONTS
     ================================================== -->

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
>


<!-- ==================================================
     SWEET ALERT 2
     ================================================== -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>

/* ==================================================
   VARIABLES
   ================================================== */

:root {

    --rosa-principal: #c86f89;

    --rosa-oscuro: #a9516c;

    --rosa-suave: #f8e3e9;

    --rosa-muy-suave: #fff7f9;

    --rosa-borde: #efd5dc;

    --rosa-texto: #805463;

    --texto: #514047;

    --texto-suave: #9b858d;

    --blanco: #ffffff;

}


/* ==================================================
   RESET
   ================================================== */

* {

    box-sizing: border-box;

}


html {

    scroll-behavior: smooth;

}


body {

    margin: 0;

    min-height: 100vh;

    font-family:
        'DM Sans',
        sans-serif;

    color: var(--texto);

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 40px 20px;

    position: relative;

    overflow-x: hidden;

    background:

        linear-gradient(
            rgba(255, 247, 249, .78),
            rgba(255, 247, 249, .78)
        ),

        url("../imagenes/fondote.png")
        center / cover
        no-repeat fixed;

}


/* ==================================================
   DECORACIONES DEL FONDO
   ================================================== */

body::before {

    content: "";

    position: fixed;

    width: 380px;

    height: 380px;

    border-radius: 50%;

    background:
        rgba(225, 157, 177, .18);

    filter: blur(20px);

    top: -160px;

    left: -120px;

    pointer-events: none;

}


body::after {

    content: "";

    position: fixed;

    width: 420px;

    height: 420px;

    border-radius: 50%;

    background:
        rgba(240, 190, 205, .18);

    filter: blur(25px);

    right: -180px;

    bottom: -180px;

    pointer-events: none;

}


/* ==================================================
   CONTENEDOR
   ================================================== */

.contenedor {

    width: 100%;

    max-width: 900px;

    position: relative;

    z-index: 2;

    background:
        rgba(255,255,255,.94);

    border:

        1px solid
        rgba(255,255,255,.9);

    border-radius: 34px;

    overflow: hidden;

    box-shadow:

        0 35px 90px
        rgba(117, 65, 82, .18),

        0 8px 25px
        rgba(117, 65, 82, .07);

    animation:

        aparecer .7s ease;

}


/* ==================================================
   ANIMACIÓN
   ================================================== */

@keyframes aparecer {

    from {

        opacity: 0;

        transform:
            translateY(20px)
            scale(.98);

    }

    to {

        opacity: 1;

        transform:
            translateY(0)
            scale(1);

    }

}


/* ==================================================
   CABECERA
   ================================================== */

.cabecera {

    padding: 34px 45px;

    background:

        linear-gradient(
            135deg,
            #fffafd 0%,
            #fbe8ee 100%
        );

    border-bottom:
        1px solid
        var(--rosa-borde);

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 25px;

}


/* ==================================================
   MARCA
   ================================================== */

.marca {

    display: flex;

    align-items: center;

    gap: 17px;

}


.icono {

    width: 60px;

    height: 60px;

    flex-shrink: 0;

    border-radius: 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    background:

        linear-gradient(
            135deg,
            #d8879c,
            #b65e77
        );

    color: white;

    font-size: 25px;

    box-shadow:

        0 10px 25px
        rgba(182,94,119,.28);

    position: relative;

}


.icono::after {

    content: "";

    position: absolute;

    inset: 4px;

    border-radius: 16px;

    border:
        1px solid
        rgba(255,255,255,.3);

}


.marca h1 {

    margin: 0;

    font-family:
        'Playfair Display',
        serif;

    color: #914f64;

    font-size: 30px;

    letter-spacing: .5px;

}


.marca p {

    margin: 5px 0 0;

    color: #a0838c;

    font-size: 13px;

}


/* ==================================================
   BADGE ID
   ================================================== */

.id-badge {

    padding: 11px 18px;

    border-radius: 50px;

    background:
        rgba(255,255,255,.85);

    border:
        1px solid
        #ebcbd5;

    color:
        var(--rosa-oscuro);

    font-size: 13px;

    font-weight: 700;

    box-shadow:
        0 5px 15px
        rgba(160,81,108,.06);

}


/* ==================================================
   CONTENIDO
   ================================================== */

.contenido {

    padding:
        42px 45px 38px;

}


/* ==================================================
   TITULO
   ================================================== */

.titulo-seccion {

    margin-bottom: 30px;

}


.titulo-seccion h2 {

    margin: 0;

    color: #493a40;

    font-family:
        'Playfair Display',
        serif;

    font-size: 28px;

    font-weight: 600;

}


.titulo-seccion p {

    margin: 8px 0 0;

    color:
        var(--texto-suave);

    font-size: 13px;

}


/* ==================================================
   GRID
   ================================================== */

.informacion {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 18px;

}


/* ==================================================
   CAMPOS
   ================================================== */

.campo {

    padding: 21px;

    border:
        1px solid
        #f0dfe4;

    border-radius: 20px;

    background:

        linear-gradient(
            145deg,
            #fffefe,
            #fff9fb
        );

    box-shadow:
        0 5px 18px
        rgba(120,70,85,.035);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;

}


.campo:hover {

    transform:
        translateY(-2px);

    border-color:
        #e8c5d0;

    box-shadow:
        0 10px 25px
        rgba(120,70,85,.07);

}


.campo.completo {

    grid-column:
        1 / -1;

}


/* ==================================================
   LABEL
   ================================================== */

.campo-label {

    display: block;

    margin-bottom: 10px;

    color:
        #a0848d;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 1px;

}


/* ==================================================
   VALORES
   ================================================== */

.campo-valor {

    color:
        #55434a;

    font-size: 16px;

    font-weight: 600;

}


.valor-id {

    color:
        #b45e76;

}


.valor-pedido {

    color:
        #765564;

}


.valor-total {

    color:
        #a84f69;

    font-family:
        'Playfair Display',
        serif;

    font-size: 27px;

    font-weight: 600;

}


/* ==================================================
   SELECT
   ================================================== */

.select-wrapper {

    position: relative;

}


select {

    width: 100%;

    appearance: none;

    -webkit-appearance: none;

    padding: 14px 45px 14px 16px;

    border:
        1.5px solid
        #e9ccd5;

    border-radius: 15px;

    background:
        #fff;

    color:
        #59474e;

    font-family:
        'DM Sans',
        sans-serif;

    font-size: 14px;

    font-weight: 600;

    outline: none;

    cursor: pointer;

    transition:
        .25s ease;

}


.select-wrapper::after {

    content: "⌄";

    position: absolute;

    right: 17px;

    top: 50%;

    transform:
        translateY(-55%);

    color:
        #b9677d;

    font-size: 19px;

    pointer-events: none;

}


select:hover {

    border-color:
        #ce8396;

}


select:focus {

    border-color:
        #bd6b80;

    box-shadow:

        0 0 0 4px
        rgba(189,107,128,.10);

}


/* ==================================================
   ESTADO ACTUAL
   ================================================== */

.estado-actual {

    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 7px;

    margin-top: 11px;

    color:
        #a18a92;

    font-size: 11px;

}


.estado-actual strong {

    color:
        #875466;

}


.punto {

    width: 8px;

    height: 8px;

    border-radius: 50%;

    background:
        #ca7188;

    box-shadow:
        0 0 0 4px
        rgba(202,113,136,.10);

}


/* ==================================================
   SEPARADOR
   ================================================== */

.separador {

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #efdce2,
            transparent
        );

    margin:
        32px 0 25px;

}


/* ==================================================
   ACCIONES
   ================================================== */

.acciones {

    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 12px;

}


/* ==================================================
   BOTÓN CANCELAR
   ================================================== */

.volver {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 13px 23px;

    border-radius: 50px;

    border:
        1px solid
        #ead4db;

    background:
        #fff;

    color:
        #986072;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

    transition:
        .25s ease;

}


.volver:hover {

    background:
        #fff5f7;

    border-color:
        #d69aaa;

    transform:
        translateY(-2px);

}


/* ==================================================
   BOTÓN ACTUALIZAR
   ================================================== */

.actualizar {

    border: none;

    padding:
        14px 27px;

    border-radius: 50px;

    background:

        linear-gradient(
            135deg,
            #cf7890,
            #b45b75
        );

    color:
        white;

    font-family:
        'DM Sans',
        sans-serif;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;

    box-shadow:

        0 10px 25px
        rgba(180,91,117,.25);

    transition:
        .25s ease;

}


.actualizar:hover {

    background:

        linear-gradient(
            135deg,
            #c66b84,
            #a9506a
        );

    transform:
        translateY(-2px);

    box-shadow:

        0 14px 30px
        rgba(180,91,117,.32);

}


.actualizar:active {

    transform:
        translateY(0);

}


/* ==================================================
   NOTA
   ================================================== */

.nota {

    margin-top: 22px;

    padding: 15px 18px;

    border-radius: 16px;

    background:
        linear-gradient(
            135deg,
            #fff7f9,
            #fffafb
        );

    border:
        1px solid
        #f1dfe4;

    color:
        #947d85;

    font-size: 12px;

    line-height: 1.6;

}


.nota span {

    color:
        #b25e76;

    font-weight: 700;

}


/* ==================================================
   SWEET ALERT PERSONALIZADO
   ================================================== */

.swal2-popup {

    border-radius: 26px !important;

    padding: 2em !important;

    font-family:
        'DM Sans',
        sans-serif !important;

    box-shadow:
        0 25px 70px
        rgba(100,55,70,.20) !important;

}


.swal2-title {

    font-family:
        'Playfair Display',
        serif !important;

    color:
        #694552 !important;

}


.swal2-html-container {

    color:
        #917983 !important;

    font-size: 14px !important;

}


.swal2-confirm {

    border-radius: 50px !important;

    padding:
        12px 25px !important;

    background:
        linear-gradient(
            135deg,
            #cf7890,
            #b45b75
        ) !important;

    box-shadow:
        0 8px 20px
        rgba(180,91,117,.22) !important;

}


.swal2-cancel {

    border-radius: 50px !important;

    padding:
        12px 25px !important;

}


/* ==================================================
   RESPONSIVE
   ================================================== */

@media(max-width: 700px) {

    body {

        padding:
            20px 12px;

        align-items:
            flex-start;

    }


    .contenedor {

        border-radius:
            26px;

        margin:
            15px 0;

    }


    .cabecera {

        padding:
            28px 24px;

        flex-direction:
            column;

        align-items:
            flex-start;

    }


    .contenido {

        padding:
            30px 24px;

    }


    .informacion {

        grid-template-columns:
            1fr;

    }


    .campo.completo {

        grid-column:
            auto;

    }


    .acciones {

        flex-direction:
            column-reverse;

        align-items:
            stretch;

    }


    .volver,
    .actualizar {

        width:
            100%;

        text-align:
            center;

    }

}


@media(max-width: 420px) {

    .marca h1 {

        font-size:
            26px;

    }


    .icono {

        width:
            52px;

        height:
            52px;

        border-radius:
            17px;

    }


    .titulo-seccion h2 {

        font-size:
            24px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- ==================================================
         CABECERA
         ================================================== -->

    <div class="cabecera">


        <div class="marca">


            <div class="icono">

                ✦

            </div>


            <div>

                <h1>

                    DIVINE

                </h1>


                <p>

                    Gestión de ventas

                </p>

            </div>


        </div>


        <div class="id-badge">

            Venta #

            <?php

            echo htmlspecialchars(
                $idVenta
            );

            ?>

        </div>


    </div>


    <!-- ==================================================
         CONTENIDO
         ================================================== -->

    <div class="contenido">


        <div class="titulo-seccion">

            <h2>

                Modificar venta

            </h2>


            <p>

                Actualiza los datos permitidos de esta venta
                de manera rápida y segura.

            </p>

        </div>


        <!-- ==================================================
             FORMULARIO
             ================================================== -->

        <form
            id="formVenta"
            action="updateventa.php"
            method="POST"
        >


            <!-- ==================================================
                 DATOS OCULTOS
                 ================================================== -->

            <input
                type="hidden"
                name="id"
                value="<?php
                    echo htmlspecialchars(
                        $idVenta
                    );
                ?>"
            >


            <input
                type="hidden"
                name="PEDIDOS_ID"
                value="<?php
                    echo htmlspecialchars(
                        $idPedido
                    );
                ?>"
            >


            <input
                type="hidden"
                name="costototal"
                value="<?php
                    echo htmlspecialchars(
                        $costoTotal
                    );
                ?>"
            >


            <div class="informacion">


                <!-- ==================================================
                     ID
                     ================================================== -->

                <div class="campo">


                    <span class="campo-label">

                        ID de venta

                    </span>


                    <div class="campo-valor valor-id">

                        #

                        <?php

                        echo htmlspecialchars(
                            $idVenta
                        );

                        ?>

                    </div>


                </div>


                <!-- ==================================================
                     PEDIDO
                     ================================================== -->

                <div class="campo">


                    <span class="campo-label">

                        Pedido asociado

                    </span>


                    <div class="campo-valor valor-pedido">

                        #

                        <?php

                        echo htmlspecialchars(
                            $idPedido
                        );

                        ?>

                    </div>


                </div>


                <!-- ==================================================
                     ESTADO
                     ================================================== -->

                <div class="campo">


                    <label
                        class="campo-label"
                        for="estado"
                    >

                        Estado de la venta

                    </label>


                    <div class="select-wrapper">

                        <select
                            id="estado"
                            name="estado"
                            required
                        >


                            <option
                                value="En proceso"

                                <?php

                                if (
                                    strtolower(
                                        trim($estado)
                                    )
                                    ==
                                    "en proceso"
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                En proceso

                            </option>


                            <option
                                value="Completado"

                                <?php

                                if (
                                    strtolower(
                                        trim($estado)
                                    )
                                    ==
                                    "completado"
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                Completado

                            </option>


                            <option
                                value="Cancelado"

                                <?php

                                if (
                                    strtolower(
                                        trim($estado)
                                    )
                                    ==
                                    "cancelado"
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                Cancelado

                            </option>


                        </select>

                    </div>


                    <div class="estado-actual">

                        <span class="punto"></span>

                        Estado actual:

                        <strong>

                            <?php

                            echo htmlspecialchars(
                                $estado
                            );

                            ?>

                        </strong>

                    </div>


                </div>


                <!-- ==================================================
                     MÉTODO DE PAGO
                     ================================================== -->

                <div class="campo">


                    <label
                        class="campo-label"
                        for="metodo"
                    >

                        Método de pago

                    </label>


                    <div class="select-wrapper">

                        <select
                            id="metodo"
                            name="metodo"
                            required
                        >


                            <option
                                value=""
                                disabled

                                <?php

                                if (
                                    empty($metodo)
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                Selecciona un método

                            </option>


                            <option
                                value="Efectivo"

                                <?php

                                if (
                                    strtolower(
                                        trim($metodo)
                                    )
                                    ==
                                    "efectivo"
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                💵 Efectivo

                            </option>


                            <option
                                value="Tarjeta"

                                <?php

                                if (
                                    strtolower(
                                        trim($metodo)
                                    )
                                    ==
                                    "tarjeta"
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                💳 Tarjeta

                            </option>


                            <option
                                value="QR"

                                <?php

                                if (
                                    strtolower(
                                        trim($metodo)
                                    )
                                    ==
                                    "qr"
                                ) {

                                    echo "selected";

                                }

                                ?>
                            >

                                📱 QR

                            </option>


                        </select>

                    </div>


                </div>


                <!-- ==================================================
                     TOTAL
                     ================================================== -->

                <div class="campo completo">


                    <span class="campo-label">

                        Costo total de la venta

                    </span>


                    <div class="campo-valor valor-total">

                        Bs.

                        <?php

                        echo number_format(
                            (float)$costoTotal,
                            2
                        );

                        ?>

                    </div>


                </div>


            </div>


            <!-- ==================================================
                 SEPARADOR
                 ================================================== -->

            <div class="separador"></div>


            <!-- ==================================================
                 ACCIONES
                 ================================================== -->

            <div class="acciones">


                <a
                    href="javascript:history.back()"
                    class="volver"
                >

                    ← Cancelar

                </a>


                <button
                    type="submit"
                    class="actualizar"
                >

                    ✨ Guardar cambios

                </button>


            </div>


            <!-- ==================================================
                 NOTA
                 ================================================== -->

            <div class="nota">

                <span>♡ Nota:</span>

                Puedes modificar el estado y el método de pago.
                El número de venta, el pedido asociado y el costo
                total se mantienen como datos originales.

            </div>


        </form>


    </div>


</div>


<!-- ==================================================
     SWEET ALERT
     ================================================== -->

<script>

const formulario =
    document.getElementById("formVenta");


formulario.addEventListener(
    "submit",
    function(event) {

        event.preventDefault();


        const estado =
            document.getElementById("estado").value;

        const metodo =
            document.getElementById("metodo").value;


        Swal.fire({

            title: "¿Guardar cambios? ✨",

            html:
                `
                <div style="
                    color:#927982;
                    line-height:1.7;
                ">

                    Estás a punto de actualizar esta venta.

                    <br><br>

                    <span style="
                        color:#a95870;
                        font-weight:700;
                    ">
                        Estado:
                    </span>

                    ${estado}

                    <br>

                    <span style="
                        color:#a95870;
                        font-weight:700;
                    ">
                        Método de pago:
                    </span>

                    ${metodo}

                </div>
                `,

            icon: "question",

            iconColor: "#c8758c",

            showCancelButton: true,

            confirmButtonText:
                "Sí, guardar 💗",

            cancelButtonText:
                "No, revisar",

            reverseButtons: true,

            background: "#fffafb",

            color: "#59474e",

            buttonsStyling: true,

            customClass: {

                popup:
                    "sweet-popup",

                title:
                    "sweet-title"

            }

        }).then((resultado) => {


            if (resultado.isConfirmed) {


                Swal.fire({

                    title:
                        "Guardando cambios...",

                    html:
                        "Un momento, por favor 💕",

                    allowOutsideClick:
                        false,

                    allowEscapeKey:
                        false,

                    showConfirmButton:
                        false,

                    background:
                        "#fffafb",

                    color:
                        "#59474e",

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });


                formulario.submit();

            }

        });

    }

);

</script>


</body>

</html>


<?php

$conn->close();

?>
