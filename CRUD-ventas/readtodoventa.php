<?php

session_start();


// ==========================================
// DATOS DE SESIÓN
// ==========================================

$nombreUsuario = $_SESSION['nombre'] ?? '';
$rol = $_SESSION['rol'] ?? '';


// ==========================================
// CONEXIÓN A LA BASE DE DATOS
// ==========================================

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";


$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);


if ($conn->connect_error) {

    die(
        "Error de conexión: "
        . $conn->connect_error
    );

}


// ==========================================
// CONSULTAR VENTAS
// ==========================================

if ($rol == "vendedor") {


    // ======================================
    // VENDEDOR
    // SOLO SUS VENTAS
    // ======================================

    $sql = "
        SELECT
            VENTAS.*,
            PEDIDOS.nombre,
            PEDIDOS.nombrevendedor

        FROM VENTAS

        INNER JOIN PEDIDOS
            ON VENTAS.PEDIDOS_ID = PEDIDOS.ID

        WHERE PEDIDOS.nombrevendedor = '$nombreUsuario'

        ORDER BY VENTAS.id DESC
    ";


} else {


    // ======================================
    // ADMINISTRADOR
    // TODAS LAS VENTAS
    // ======================================

    $sql = "
        SELECT
            VENTAS.*,
            PEDIDOS.nombre,
            PEDIDOS.nombrevendedor

        FROM VENTAS

        INNER JOIN PEDIDOS
            ON VENTAS.PEDIDOS_ID = PEDIDOS.ID

        ORDER BY VENTAS.id DESC
    ";

}


$resultado = $conn->query($sql);


if (!$resultado) {

    die(
        "Error en la consulta: "
        . $conn->error
    );

}


// ==========================================
// MENSAJES
// ==========================================

$mensaje = $_GET['mensaje'] ?? '';

$error = $_GET['error'] ?? '';

?>


<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Ventas</title>


<style>


/* ==========================================
   CONFIGURACIÓN GENERAL
   ========================================== */

*{

    margin:0;

    padding:0;

    box-sizing:border-box;

    font-family:'Segoe UI',sans-serif;

}


body{

    min-height:100vh;

    background:

    linear-gradient(
        rgba(0,0,0,.25),
        rgba(0,0,0,.25)
    ),

    url('../imagenes/fondote.png');

    background-position:center;

    background-repeat:no-repeat;

    background-size:cover;

    background-attachment:fixed;

    padding:45px 25px;

}


/* ==========================================
   CONTENEDOR PRINCIPAL
   ========================================== */

.contenedor{

    width:95%;

    max-width:1400px;

    margin:auto;

    background:rgba(255,255,255,.78);

    backdrop-filter:blur(12px);

    -webkit-backdrop-filter:blur(12px);

    padding:40px;

    border-radius:35px;

    box-shadow:
        0 20px 50px rgba(0,0,0,.15);

    border:
        1px solid rgba(255,255,255,.7);

}


/* ==========================================
   ENCABEZADO
   ========================================== */

.encabezado{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:35px;

    gap:20px;

}


.titulo{

    display:flex;

    align-items:center;

    gap:15px;

}


.icono{

    width:55px;

    height:55px;

    border-radius:18px;

    background:#fdf5f7;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:27px;

    box-shadow:
        0 8px 20px rgba(201,111,132,.15);

}


h1{

    color:#bf7485;

    font-size:31px;

    letter-spacing:.5px;

}


.subtitulo{

    color:#888;

    font-size:14px;

    margin-top:4px;

}


/* ==========================================
   CONTADOR
   ========================================== */

.contador{

    background:#c96f84;

    color:white;

    padding:11px 20px;

    border-radius:50px;

    font-weight:600;

    box-shadow:
        0 8px 20px rgba(201,111,132,.25);

}


/* ==========================================
   TABLA
   ========================================== */

.tabla-contenedor{

    overflow-x:auto;

    border-radius:22px;

    box-shadow:
        0 10px 30px rgba(0,0,0,.07);

}


table{

    width:100%;

    min-width:1100px;

    border-collapse:collapse;

    background:rgba(255,255,255,.92);

}


/* ==========================================
   CABECERA
   ========================================== */

thead{

    background:#c96f84;

    color:white;

}


th{

    padding:17px 15px;

    font-size:13px;

    text-transform:uppercase;

    letter-spacing:.6px;

    font-weight:600;

}


th:first-child{

    border-radius:20px 0 0 0;

}


th:last-child{

    border-radius:0 20px 0 0;

}


/* ==========================================
   FILAS
   ========================================== */

tbody tr{

    transition:.25s;

}


tbody tr:hover{

    background:#fff7f9;

    transform:scale(1.002);

}


td{

    padding:17px 15px;

    text-align:center;

    border-bottom:1px solid #f4e1e5;

    color:#666;

    font-size:14px;

}


/* ==========================================
   ID VENTA
   ========================================== */

.id-venta{

    color:#bf7485;

    font-weight:700;

}


/* ==========================================
   PEDIDO
   ========================================== */

.id-pedido{

    display:inline-block;

    background:#fdf0f3;

    color:#bf7485;

    padding:6px 12px;

    border-radius:50px;

    font-weight:700;

}


/* ==========================================
   CLIENTE
   ========================================== */

.cliente{

    color:#555;

    font-weight:600;

}


/* ==========================================
   VENDEDOR
   ========================================== */

.vendedor{

    color:#bf7485;

    font-weight:700;

    white-space:nowrap;

}


.vendedor .yo{

    display:inline-block;

    margin-left:5px;

    padding:4px 8px;

    border-radius:20px;

    background:#fdf0f3;

    color:#b45d72;

    font-size:11px;

    font-weight:700;

}


/* ==========================================
   ESTADO
   ========================================== */

.estado{

    display:inline-block;

    padding:7px 14px;

    border-radius:50px;

    background:#fff2f5;

    color:#bf7485;

    font-size:13px;

    font-weight:700;

}


/* ==========================================
   MÉTODO DE PAGO
   ========================================== */

.metodo{

    color:#666;

    font-weight:600;

}


.metodo::before{

    content:"";

    display:inline-block;

    width:7px;

    height:7px;

    background:#d992a2;

    border-radius:50%;

    margin-right:7px;

}


/* ==========================================
   TOTAL
   ========================================== */

.total{

    color:#bf7485;

    font-size:16px;

    font-weight:700;

    white-space:nowrap;

}


/* ==========================================
   ACCIONES
   ========================================== */

.acciones{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:8px;

    flex-wrap:wrap;

}


.btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:9px 14px;

    border-radius:50px;

    text-decoration:none;

    font-size:13px;

    font-weight:600;

    transition:.3s;

    border:none;

    white-space:nowrap;

}


/* ==========================================
   BOTÓN DETALLES
   VISIBLE PARA TODOS
   ========================================== */

.btn-detalles{

    background:#eee6f8;

    color:#765b96;

}


.btn-detalles:hover{

    background:#765b96;

    color:white;

    transform:translateY(-2px);

    box-shadow:
        0 6px 15px rgba(118,91,150,.25);

}


/* ==========================================
   BOTÓN MODIFICAR
   SOLO ADMINISTRADOR
   ========================================== */

.btn-editar{

    background:#f8dce2;

    color:#a8586b;

}


.btn-editar:hover{

    background:#c96f84;

    color:white;

    transform:translateY(-2px);

    box-shadow:
        0 6px 15px rgba(201,111,132,.25);

}


/* ==========================================
   BOTÓN ELIMINAR
   SOLO ADMINISTRADOR
   ========================================== */

.btn-eliminar{

    background:#f9e1e1;

    color:#c15b5b;

}


.btn-eliminar:hover{

    background:#d85a5a;

    color:white;

    transform:translateY(-2px);

    box-shadow:
        0 6px 15px rgba(216,90,90,.25);

}


/* ==========================================
   SIN VENTAS
   ========================================== */

.sin-ventas{

    background:white;

    border-radius:25px;

    padding:55px 20px;

    text-align:center;

    color:#888;

}


.sin-ventas-icono{

    font-size:45px;

    margin-bottom:15px;

    opacity:.6;

}


.sin-ventas h2{

    color:#bf7485;

    margin-bottom:8px;

}


.sin-ventas p{

    color:#999;

}


/* ==========================================
   BOTÓN VOLVER
   ========================================== */

.volver{

    display:inline-flex;

    align-items:center;

    gap:7px;

    margin-top:30px;

    padding:12px 22px;

    border-radius:50px;

    background:white;

    color:#bf7485;

    text-decoration:none;

    font-weight:600;

    box-shadow:
        0 6px 18px rgba(0,0,0,.08);

    transition:.3s;

}


.volver:hover{

    background:#c96f84;

    color:white;

    transform:translateY(-2px);

}


/* ==========================================
   MENSAJE DE ÉXITO
   ========================================== */

.mensaje-exito{

    position:fixed;

    top:30px;

    right:30px;

    z-index:9999;

    min-width:340px;

    max-width:450px;

    display:flex;

    align-items:center;

    gap:15px;

    padding:18px 20px;

    background:rgba(255,255,255,.96);

    backdrop-filter:blur(12px);

    border-radius:20px;

    border-left:5px solid #c96f84;

    box-shadow:
        0 15px 40px rgba(0,0,0,.15);

    animation:mensajeEntrada .4s ease;

}


/* ==========================================
   MENSAJE DE ERROR
   ========================================== */

.mensaje-error{

    position:fixed;

    top:30px;

    right:30px;

    z-index:9999;

    min-width:340px;

    max-width:450px;

    display:flex;

    align-items:center;

    gap:15px;

    padding:18px 20px;

    background:rgba(255,255,255,.96);

    backdrop-filter:blur(12px);

    border-radius:20px;

    border-left:5px solid #d85a5a;

    box-shadow:
        0 15px 40px rgba(0,0,0,.15);

    animation:mensajeEntrada .4s ease;

}


/* ==========================================
   ICONO MENSAJE
   ========================================== */

.mensaje-icono{

    min-width:45px;

    width:45px;

    height:45px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#f8dce2;

    color:#bf7485;

    font-size:22px;

    font-weight:bold;

}


/* ==========================================
   TEXTO MENSAJE
   ========================================== */

.mensaje-exito strong,
.mensaje-error strong{

    display:block;

    color:#bf7485;

    font-size:16px;

    margin-bottom:3px;

}


.mensaje-exito p,
.mensaje-error p{

    margin:0;

    color:#777;

    font-size:13px;

}


/* ==========================================
   BOTÓN CERRAR MENSAJE
   ========================================== */

.mensaje-exito button,
.mensaje-error button{

    margin-left:auto;

    border:none;

    background:transparent;

    color:#999;

    font-size:23px;

    cursor:pointer;

    line-height:1;

    transition:.2s;

}


.mensaje-exito button:hover{

    color:#bf7485;

}


.mensaje-error button:hover{

    color:#d85a5a;

}


/* ==========================================
   ANIMACIÓN MENSAJE
   ========================================== */

@keyframes mensajeEntrada{

    from{

        opacity:0;

        transform:
            translateX(40px);

    }

    to{

        opacity:1;

        transform:
            translateX(0);

    }

}


/* ==========================================
   RESPONSIVE
   ========================================== */

@media(max-width:700px){

    body{

        padding:25px 12px;

    }


    .contenedor{

        width:100%;

        padding:25px 15px;

        border-radius:25px;

    }


    .encabezado{

        flex-direction:column;

        align-items:flex-start;

    }


    h1{

        font-size:25px;

    }


    .contador{

        align-self:flex-start;

    }


    th,
    td{

        padding:13px 10px;

    }


    .acciones{

        flex-direction:column;

    }


    .btn{

        width:100%;

    }


    .mensaje-exito,
    .mensaje-error{

        top:20px;

        right:15px;

        left:15px;

        min-width:auto;

    }

}

</style>

</head>


<body>


<!-- ==========================================
     MENSAJE DE ÉXITO
     ========================================== -->

<?php if ($mensaje != "") { ?>

    <div class="mensaje-exito">

        <div class="mensaje-icono">

            ✓

        </div>

        <div>

            <strong>

                ¡Listo!

            </strong>

            <p>

                <?php

                echo htmlspecialchars($mensaje);

                ?>

            </p>

        </div>

        <button
            type="button"
            onclick="this.parentElement.remove();"
        >

            ×

        </button>

    </div>

<?php } ?>


<!-- ==========================================
     MENSAJE DE ERROR
     ========================================== -->

<?php if ($error != "") { ?>

    <div class="mensaje-error">

        <div class="mensaje-icono">

            !

        </div>

        <div>

            <strong>

                Ocurrió un problema

            </strong>

            <p>

                <?php

                echo htmlspecialchars($error);

                ?>

            </p>

        </div>

        <button
            type="button"
            onclick="this.parentElement.remove();"
        >

            ×

        </button>

    </div>

<?php } ?>


<div class="contenedor">


    <!-- ==========================================
         ENCABEZADO
         ========================================== -->

    <div class="encabezado">


        <div class="titulo">


            <div class="icono">

                🧾

            </div>


            <div>

                <h1>

                    Ventas

                </h1>


                <div class="subtitulo">

                    Registro de ventas realizadas

                </div>

            </div>


        </div>


        <div class="contador">

            <?php

            echo $resultado->num_rows;

            ?>

            ventas

        </div>


    </div>


    <!-- ==========================================
         TABLA
         ========================================== -->

    <div class="tabla-contenedor">


    <?php if ($resultado->num_rows > 0): ?>


        <table>


            <thead>

                <tr>


                    <th>

                        Venta

                    </th>


                    <th>

                        Pedido

                    </th>


                    <th>

                        Cliente

                    </th>


                    <th>

                        Vendedor

                    </th>


                    <th>

                        Estado

                    </th>


                    <th>

                        Método

                    </th>


                    <th>

                        Total

                    </th>


                    <th>

                        Acciones

                    </th>


                </tr>

            </thead>


            <tbody>


            <?php while ($fila = $resultado->fetch_assoc()): ?>


                <tr>


                    <!-- ======================================
                         ID VENTA
                         ====================================== -->

                    <td class="id-venta">

                        #

                        <?php

                        echo htmlspecialchars(
                            $fila['id']
                        );

                        ?>

                    </td>


                    <!-- ======================================
                         ID PEDIDO
                         ====================================== -->

                    <td>

                        <span class="id-pedido">

                            Pedido #

                            <?php

                            echo htmlspecialchars(
                                $fila['PEDIDOS_ID']
                            );

                            ?>

                        </span>

                    </td>


                    <!-- ======================================
                         CLIENTE
                         ====================================== -->

                    <td class="cliente">

                        <?php

                        echo htmlspecialchars(
                            $fila['nombre']
                        );

                        ?>

                    </td>


                    <!-- ======================================
                         VENDEDOR
                         ====================================== -->

                    <td class="vendedor">

                        <?php

                        echo htmlspecialchars(
                            $fila['nombrevendedor']
                        );


                        if (
                            $fila['nombrevendedor']
                            == $nombreUsuario
                        ) {

                        ?>

                            <span class="yo">

                                (yo)

                            </span>

                        <?php

                        }

                        ?>

                    </td>


                    <!-- ======================================
                         ESTADO
                         ====================================== -->

                    <td>

                        <span class="estado">

                            <?php

                            echo htmlspecialchars(
                                $fila['estado']
                            );

                            ?>

                        </span>

                    </td>


                    <!-- ======================================
                         MÉTODO
                         ====================================== -->

                    <td class="metodo">

                        <?php

                        echo htmlspecialchars(
                            $fila['metodo']
                        );

                        ?>

                    </td>


                    <!-- ======================================
                         TOTAL
                         ====================================== -->

                    <td class="total">

                        Bs.

                        <?php

                        echo number_format(
                            (float)$fila['costototal'],
                            2
                        );

                        ?>

                    </td>


                    <!-- ======================================
                         ACCIONES
                         ====================================== -->

                    <td>

                        <div class="acciones">


                            <!-- ==================================
                                 DETALLES
                                 VISIBLE PARA ADMIN Y VENDEDOR
                                 ================================== -->

                            <a
                                href="readunoventa.php?id=<?php echo $fila['id']; ?>"
                                class="btn btn-detalles"
                            >

                                🔎 Detalles

                            </a>


                            <!-- ==================================
                                 MODIFICAR / ELIMINAR
                                 SOLO ADMINISTRADOR
                                 ================================== -->

                            <?php if ($rol == "administrador") { ?>


                                <a
                                    href="updateformventa.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-editar"
                                >

                                    ✏️ Modificar

                                </a>


                                <a
                                    href="deleteventa.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-eliminar"

                                    onclick="
                                        return confirm(
                                            '¿Está seguro de eliminar esta venta?'
                                        );
                                    "
                                >

                                    🗑️ Eliminar

                                </a>


                            <?php } ?>


                        </div>

                    </td>


                </tr>


            <?php endwhile; ?>


            </tbody>


        </table>


    <?php else: ?>


        <div class="sin-ventas">


            <div class="sin-ventas-icono">

                🧾

            </div>


            <h2>

                No hay ventas todavía

            </h2>


            <p>

                Cuando registres una venta aparecerá aquí.

            </p>


        </div>


    <?php endif; ?>


    </div>


    <!-- ==========================================
         VOLVER
         ========================================== -->

    <a
        href="javascript:history.back()"
        class="volver"
    >

        ← Volver

    </a>


</div>


</body>

</html>


<?php

$conn->close();

?>