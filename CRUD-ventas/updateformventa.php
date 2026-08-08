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


// ==================================================
// RECIBIR ID
// ==================================================

$id = $_GET['id'] ?? null;


if ($id === null || !is_numeric($id)) {

    die(
        "No se recibió un ID de venta válido."
    );

}


// ==================================================
// BUSCAR VENTA
// ==================================================

$sql = "

    SELECT *

    FROM VENTAS

    WHERE id = $id

";


$resultado = $conn->query($sql);


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


<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet"
>


<style>

/* ==================================================
   GENERAL
   ================================================== */

* {

    box-sizing:border-box;

}


body {

    margin:0;

    min-height:100vh;

    font-family:
        'DM Sans',
        sans-serif;

    background:

        radial-gradient(
            circle at 10% 10%,
            #f9dfe7 0,
            transparent 28%
        ),

        radial-gradient(
            circle at 90% 85%,
            #f4d4de 0,
            transparent 30%
        ),

        #fcf8f9;

    display:flex;

    justify-content:center;

    align-items:center;

    padding:45px 20px;

    color:#4b3b41;
    
background: linear-gradient(rgba(255,255,255,.35), rgba(255,255,255,.35)), url("../imagenes/fondote.png") center / cover no-repeat fixed;
}


/* ==================================================
   CONTENEDOR PRINCIPAL
   ================================================== */

.contenedor {

    width:100%;

    max-width:850px;

    background:#ffffff;

    border-radius:32px;

    overflow:hidden;

    box-shadow:

        0 25px 70px
        rgba(133,76,93,.15);

    border:
        1px solid #f1e0e5;

}


/* ==================================================
   CABECERA
   ================================================== */

.cabecera {

    padding:35px 45px;

    background:

        linear-gradient(
            120deg,
            #fff8fa,
            #fcecf1
        );

    border-bottom:
        1px solid #f1dce2;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

}


.marca {

    display:flex;

    align-items:center;

    gap:16px;

}


.icono {

    width:55px;

    height:55px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#c9788d;

    color:white;

    font-size:24px;

    box-shadow:

        0 8px 20px
        rgba(201,120,141,.25);

}


.marca h1 {

    margin:0;

    font-family:
        'Playfair Display',
        serif;

    color:#925365;

    font-size:28px;

}


.marca p {

    margin:5px 0 0;

    color:#9d858d;

    font-size:13px;

}


/* ==================================================
   ID
   ================================================== */

.id-badge {

    padding:10px 16px;

    border-radius:30px;

    background:#fff;

    border:
        1px solid #edccd5;

    color:#b46378;

    font-size:13px;

    font-weight:700;

}


/* ==================================================
   CONTENIDO
   ================================================== */

.contenido {

    padding:40px 45px 35px;

}


/* ==================================================
   TÍTULO
   ================================================== */

.titulo-seccion {

    margin-bottom:28px;

}


.titulo-seccion h2 {

    margin:0;

    color:#4b3b41;

    font-family:
        'Playfair Display',
        serif;

    font-size:25px;

}


.titulo-seccion p {

    margin:7px 0 0;

    color:#9a858c;

    font-size:13px;

}


/* ==================================================
   GRID
   ================================================== */

.informacion {

    display:grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap:18px;

}


/* ==================================================
   TARJETA DE DATO
   ================================================== */

.campo {

    padding:18px 20px;

    border:
        1px solid #f0e0e5;

    border-radius:18px;

    background:#fffafa;

}


.campo.completo {

    grid-column:
        1 / -1;

}


/* ==================================================
   LABEL
   ================================================== */

.campo-label {

    display:block;

    margin-bottom:9px;

    color:#9b8189;

    font-size:12px;

    font-weight:600;

    text-transform:uppercase;

    letter-spacing:.8px;

}


/* ==================================================
   VALOR
   ================================================== */

.campo-valor {

    color:#55444a;

    font-size:16px;

    font-weight:600;

}


/* ==================================================
   ID
   ================================================== */

.valor-id {

    color:#b46479;

}


/* ==================================================
   PEDIDO
   ================================================== */

.valor-pedido {

    color:#765766;

}


/* ==================================================
   TOTAL
   ================================================== */

.valor-total {

    color:#a9546b;

    font-family:
        'Playfair Display',
        serif;

    font-size:23px;

}


/* ==================================================
   SELECT
   ================================================== */

select {

    width:100%;

    padding:14px 16px;

    border:
        1.5px solid #e9cbd4;

    border-radius:14px;

    background:#fff;

    color:#59474e;

    font-family:
        'DM Sans',
        sans-serif;

    font-size:14px;

    font-weight:600;

    outline:none;

    cursor:pointer;

    transition:.25s;

}


select:hover {

    border-color:#ce8396;

}


select:focus {

    border-color:#bd6b80;

    box-shadow:

        0 0 0 4px
        rgba(189,107,128,.10);

}


/* ==================================================
   INDICADOR DE ESTADO
   ================================================== */

.estado-actual {

    display:flex;

    align-items:center;

    gap:8px;

    margin-top:10px;

    color:#9b8189;

    font-size:12px;

}


.punto {

    width:8px;

    height:8px;

    border-radius:50%;

    background:#c9788d;

}


/* ==================================================
   SEPARADOR
   ================================================== */

.separador {

    height:1px;

    background:#f0e1e5;

    margin:30px 0;

}


/* ==================================================
   BOTONES
   ================================================== */

.acciones {

    display:flex;

    justify-content:flex-end;

    align-items:center;

    gap:12px;

}


/* ==================================================
   BOTÓN VOLVER
   ================================================== */

.volver {

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:13px 22px;

    border-radius:50px;

    border:
        1px solid #ead5db;

    background:#fff;

    color:#986072;

    text-decoration:none;

    font-size:13px;

    font-weight:600;

    transition:.25s;

}


.volver:hover {

    background:#fff5f7;

    border-color:#d69aaa;

}


/* ==================================================
   BOTÓN ACTUALIZAR
   ================================================== */

.actualizar {

    border:none;

    padding:14px 27px;

    border-radius:50px;

    background:#bd6b80;

    color:white;

    font-family:
        'DM Sans',
        sans-serif;

    font-size:14px;

    font-weight:700;

    cursor:pointer;

    box-shadow:

        0 8px 20px
        rgba(189,107,128,.25);

    transition:.25s;

}


.actualizar:hover {

    background:#a9576d;

    transform:
        translateY(-2px);

    box-shadow:

        0 12px 25px
        rgba(189,107,128,.30);

}


/* ==================================================
   NOTA
   ================================================== */

.nota {

    margin-top:22px;

    padding:14px 17px;

    border-radius:14px;

    background:#fff7f9;

    border:
        1px solid #f2dfe4;

    color:#947d85;

    font-size:12px;

    line-height:1.5;

}


/* ==================================================
   RESPONSIVE
   ================================================== */

@media(max-width:650px) {

    body {

        padding:20px 12px;

        align-items:flex-start;

    }


    .cabecera {

        padding:28px 25px;

        flex-direction:column;

        align-items:flex-start;

    }


    .contenido {

        padding:30px 25px;

    }


    .informacion {

        grid-template-columns:1fr;

    }


    .campo.completo {

        grid-column:auto;

    }


    .acciones {

        flex-direction:column-reverse;

    }


    .volver,
    .actualizar {

        width:100%;

        text-align:center;

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

                Actualiza el estado y el método de pago de esta venta.

            </p>

        </div>


        <!-- ==================================================
             FORMULARIO
             ================================================== -->

        <form
            action="updateventa.php"
            method="POST"
        >


            <!-- ==============================================
                 ID OCULTO
                 ============================================== -->

            <input
                type="hidden"
                name="id"
                value="<?php
                    echo htmlspecialchars(
                        $idVenta
                    );
                ?>"
            >


            <!-- ==============================================
                 PEDIDO OCULTO
                 ============================================== -->

            <input
                type="hidden"
                name="PEDIDOS_ID"
                value="<?php
                    echo htmlspecialchars(
                        $idPedido
                    );
                ?>"
            >


            <!-- ==============================================
                 COSTO OCULTO
                 ============================================== -->

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


                <!-- ==========================================
                     ID
                     ========================================== -->

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


                <!-- ==========================================
                     PEDIDO
                     ========================================== -->

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


                <!-- ==========================================
                     ESTADO
                     ========================================== -->

                <div class="campo">


                    <label
                        class="campo-label"
                        for="estado"
                    >

                        Estado de la venta

                    </label>


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


                    <div class="estado-actual">

                        <span class="punto"></span>

                        Estado registrado actualmente:

                        <strong>

                            <?php

                            echo htmlspecialchars(
                                $estado
                            );

                            ?>

                        </strong>

                    </div>


                </div>


                <!-- ==========================================
                     MÉTODO
                     ========================================== -->

                <div class="campo">


                    <label
                        class="campo-label"
                        for="metodo"
                    >

                        Método de pago

                    </label>


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

                            Efectivo

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

                            Tarjeta

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

                            QR

                        </option>


                    </select>


                </div>


                <!-- ==========================================
                     TOTAL
                     ========================================== -->

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

                    ✓ Guardar cambios

                </button>


            </div>


            <!-- ==================================================
                 NOTA
                 ================================================== -->

            <div class="nota">

                Puedes modificar el estado y el método de pago.
                El número de venta, el pedido asociado y el costo
                total se mantienen como datos originales de la venta.

            </div>


        </form>


    </div>


</div>


</body>

</html>


<?php

$conn->close();

?>