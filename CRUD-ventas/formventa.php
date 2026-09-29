 <?php

/* =========================================================
   CONEXIÓN A LA BASE DE DATOS
========================================================= */

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$nombreBD = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $nombreBD
);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


/* =========================================================
   RECIBIR ID DEL PEDIDO
========================================================= */

if (!isset($_GET["idPedido"]) || $_GET["idPedido"] === "") {
    die("No se recibió el ID del pedido.");
}

$idPedido = $_GET["idPedido"];

if (!ctype_digit((string)$idPedido)) {
    die("El ID del pedido no es válido.");
}

$idPedido = (int)$idPedido;


/* =========================================================
   BUSCAR PEDIDO
========================================================= */

$sqlPedido = "
    SELECT
        ID,
        nombre,
        estado,
        telefono,
        direccion,
        fecha
    FROM PEDIDOS
    WHERE ID = ?
";

$stmtPedido = $conn->prepare($sqlPedido);

if (!$stmtPedido) {
    die("Error al preparar la consulta del pedido.");
}

$stmtPedido->bind_param("i", $idPedido);
$stmtPedido->execute();

$resultadoPedido = $stmtPedido->get_result();

if ($resultadoPedido->num_rows === 0) {
    $stmtPedido->close();
    die("El pedido no existe.");
}

$pedido = $resultadoPedido->fetch_assoc();

$stmtPedido->close();


/* =========================================================
   VERIFICAR SI EL PEDIDO YA TIENE UNA VENTA
========================================================= */

$sqlVentaExistente = "
    SELECT id
    FROM VENTAS
    WHERE PEDIDOS_ID = ?
    LIMIT 1
";

$stmtVentaExistente = $conn->prepare($sqlVentaExistente);

if (!$stmtVentaExistente) {
    die("Error al verificar la venta.");
}

$stmtVentaExistente->bind_param("i", $idPedido);
$stmtVentaExistente->execute();

$resultadoVentaExistente = $stmtVentaExistente->get_result();

if ($resultadoVentaExistente->num_rows > 0) {

    $stmtVentaExistente->close();

    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Venta existente | DIVINE</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>

    <script>
        Swal.fire({
            title: "Venta ya registrada",
            text: "Este pedido ya tiene una venta registrada.",
            icon: "info",
            iconColor: "#b86f80",
            confirmButtonText: "Ir a ventas",
            confirmButtonColor: "#8b4e5e",
            background: "#fffdfb",
            color: "#604e53"
        }).then(function() {
            window.location.href = "readtodoventa.php";
        });
    </script>

    </body>
    </html>
    ';

    exit();
}

$stmtVentaExistente->close();


/* =========================================================
   OBTENER PRODUCTOS DEL CARRITO
========================================================= */

$sqlProductos = "
    SELECT
        c.PRODUCTO_codigo,
        c.PEDIDOS_ID,
        c.cantidad,
        c.costototal,

        p.nombre,
        p.descripcion,
        p.precio,
        p.stock,
        p.categoria

    FROM CARRITO c

    INNER JOIN PRODUCTO p
        ON c.PRODUCTO_codigo = p.codigo

    WHERE c.PEDIDOS_ID = ?

    ORDER BY p.nombre ASC
";

$stmtProductos = $conn->prepare($sqlProductos);

if (!$stmtProductos) {
    die(
        "Error al preparar la consulta de productos: "
        . $conn->error
    );
}

$stmtProductos->bind_param("i", $idPedido);

$stmtProductos->execute();

$resultadoProductos = $stmtProductos->get_result();

$productos = [];

while ($fila = $resultadoProductos->fetch_assoc()) {
    $productos[] = $fila;
}

$stmtProductos->close();


/* =========================================================
   COMPROBAR PRODUCTOS
========================================================= */

if (count($productos) === 0) {
    die("Este pedido no tiene productos registrados en el carrito.");
}


/* =========================================================
   CALCULAR TOTAL
========================================================= */

$totalVenta = 0;
$cantidadTotal = 0;

foreach ($productos as $producto) {

    $totalVenta += (float)$producto["costototal"];

    $cantidadTotal += (int)$producto["cantidad"];
}


/* =========================================================
   DATOS SEGUROS PARA MOSTRAR
========================================================= */

$nombreCliente = htmlspecialchars(
    $pedido["nombre"] ?? "",
    ENT_QUOTES,
    "UTF-8"
);

$estadoPedido = htmlspecialchars(
    $pedido["estado"] ?? "",
    ENT_QUOTES,
    "UTF-8"
);

$telefonoCliente = htmlspecialchars(
    $pedido["telefono"] ?? "",
    ENT_QUOTES,
    "UTF-8"
);

$direccionCliente = htmlspecialchars(
    $pedido["direccion"] ?? "",
    ENT_QUOTES,
    "UTF-8"
);

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrar venta | DIVINE</title>


    <!-- FUENTES -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- JQUERY -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- SWEETALERT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>

        :root {

            --crema: #f5eee9;
            --crema-claro: #fffaf7;
            --blanco: #ffffff;

            --rosa: #b86f80;
            --rosa-suave: #d8a6b1;
            --rosa-claro: #efd9de;
            --rosa-palido: #f8ecef;

            --vino: #874d5c;
            --vino-oscuro: #643944;

            --dorado: #b59a78;

            --texto: #59494e;
            --texto-suave: #95868b;

            --borde: #eee1dd;

            --sombra:
                0 25px 70px rgba(91, 62, 68, 0.13);
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            min-height: 100vh;

            font-family: "DM Sans", sans-serif;

            color: var(--texto);

            background:

                radial-gradient(
                    circle at 8% 10%,
                    rgba(216,166,177,.22),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 95% 90%,
                    rgba(181,154,120,.16),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    #f3ebe6,
                    #fcf8f5,
                    #f1e8e3
                );

            padding: 35px 18px 50px;
        }


        .contenedor {

            width: 100%;

            max-width: 1150px;

            margin: auto;

            background: rgba(255,255,255,.96);

            border-radius: 32px;

            overflow: hidden;

            border: 1px solid rgba(255,255,255,.9);

            box-shadow: var(--sombra);
        }


        /* =====================================================
           CABECERA
        ====================================================== */

        .cabecera {

            position: relative;

            padding: 42px 48px;

            background:

                linear-gradient(
                    135deg,
                    #fffdfb,
                    #faeef1
                );

            border-bottom: 1px solid var(--borde);

            overflow: hidden;
        }


        .cabecera::before {

            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            right: -90px;
            top: -110px;

            border-radius: 50%;

            background:
                rgba(184,111,128,.08);
        }


        .cabecera::after {

            content: "♡";

            position: absolute;

            right: 55px;
            bottom: -35px;

            font-family: "Playfair Display", serif;

            font-size: 140px;

            color: rgba(184,111,128,.08);
        }


        .mini-marca {

            position: relative;

            z-index: 2;

            display: flex;

            align-items: center;

            gap: 11px;

            margin-bottom: 14px;
        }


        .mini-icono {

            width: 43px;
            height: 43px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            color: white;

            font-size: 21px;

            background:

                linear-gradient(
                    135deg,
                    var(--rosa),
                    var(--vino)
                );

            box-shadow:
                0 9px 23px rgba(184,111,128,.24);
        }


        .mini-marca span {

            font-size: 11px;

            letter-spacing: 3px;

            font-weight: 700;

            color: var(--rosa);
        }


        .cabecera h1 {

            position: relative;

            z-index: 2;

            font-family: "Playfair Display", serif;

            font-size: 44px;

            font-weight: 600;

            color: var(--vino-oscuro);

            margin-bottom: 8px;
        }


        .cabecera p {

            position: relative;

            z-index: 2;

            max-width: 650px;

            color: var(--texto-suave);

            font-size: 14px;

            line-height: 1.7;
        }


        /* =====================================================
           DATOS
        ====================================================== */

        .datos {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;

            padding: 25px 48px;

            background: white;
        }


        .dato {

            display: flex;

            align-items: center;

            gap: 13px;

            padding: 17px;

            border-radius: 18px;

            background: var(--crema-claro);

            border: 1px solid var(--borde);

            transition: .25s;
        }


        .dato:hover {

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(91,63,68,.06);
        }


        .dato-icono {

            width: 43px;
            height: 43px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: var(--rosa-palido);

            color: var(--rosa);

            font-size: 17px;
        }


        .dato small {

            display: block;

            margin-bottom: 4px;

            color: #a09296;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 1px;
        }


        .dato strong {

            color: var(--vino);

            font-size: 14px;
        }


        /* =====================================================
           CONTENIDO
        ====================================================== */

        .contenido {

            padding: 5px 48px 45px;
        }


        .titulo {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin: 14px 0 20px;
        }


        .titulo h2 {

            font-family: "Playfair Display", serif;

            color: var(--vino-oscuro);

            font-size: 28px;

            font-weight: 600;
        }


        .cantidad-total {

            padding: 9px 15px;

            border-radius: 20px;

            background: var(--rosa-palido);

            color: var(--vino);

            font-size: 11px;

            font-weight: 700;
        }


        /* =====================================================
           TABLA
        ====================================================== */

        .tabla {

            width: 100%;

            overflow-x: auto;

            border-radius: 22px;

            border: 1px solid var(--borde);

            box-shadow:
                0 10px 28px rgba(91,63,68,.06);
        }


        table {

            width: 100%;

            min-width: 780px;

            border-collapse: collapse;

            background: white;
        }


        th {

            padding: 17px;

            text-align: left;

            background:

                linear-gradient(
                    90deg,
                    #f8edef,
                    #fdf9f6
                );

            color: var(--vino);

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 1px;

            border-bottom: 1px solid var(--borde);
        }


        td {

            padding: 17px;

            border-bottom: 1px solid #f2ebe8;

            font-size: 13px;

            vertical-align: middle;
        }


        tbody tr {

            transition: .2s;
        }


        tbody tr:hover {

            background: #fdfaf8;
        }


        tbody tr:last-child td {

            border-bottom: none;
        }


        /* =====================================================
           PRODUCTO
        ====================================================== */

        .producto {

            display: flex;

            align-items: center;

            gap: 13px;
        }


        .producto-imagen {

            width: 58px;
            height: 58px;

            flex-shrink: 0;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #f8e9ec,
                    #f5eee9
                );

            border: 1px solid #ecdedb;

            color: var(--rosa);

            font-size: 23px;

            overflow: hidden;
        }


        .producto-imagen img {

            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .producto-nombre {

            color: #614d52;

            font-weight: 700;

            margin-bottom: 4px;
        }


        .producto-codigo {

            color: #a39396;

            font-size: 10px;
        }


        .cantidad {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-width: 39px;

            height: 35px;

            padding: 0 11px;

            border-radius: 11px;

            background: var(--rosa-palido);

            color: var(--vino);

            font-weight: 700;
        }


        .stock {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 11px;

            border-radius: 10px;

            background: #f5f1ed;

            color: #75676a;

            font-size: 11px;

            font-weight: 600;
        }


        .stock-punto {

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #91ad82;
        }


        .precio {

            color: #8c7a7f;

            white-space: nowrap;
        }


        .subtotal {

            color: var(--vino);

            font-weight: 700;

            white-space: nowrap;
        }


        /* =====================================================
           INFERIOR
        ====================================================== */

        .parte-inferior {

            display: grid;

            grid-template-columns:
                1fr 340px;

            gap: 25px;

            margin-top: 25px;
        }


        .pago {

            padding: 27px;

            border-radius: 24px;

            border: 1px solid var(--borde);

            background:

                linear-gradient(
                    145deg,
                    #ffffff,
                    #faf5f1
                );
        }


        .pago h3 {

            font-family: "Playfair Display", serif;

            color: var(--vino-oscuro);

            font-size: 23px;

            margin-bottom: 5px;
        }


        .pago p {

            color: var(--texto-suave);

            font-size: 12px;

            line-height: 1.6;

            margin-bottom: 20px;
        }


        select {

            width: 100%;

            height: 53px;

            border: 1px solid #e5d9d5;

            border-radius: 15px;

            padding: 0 15px;

            background: white;

            color: var(--texto);

            font-family: "DM Sans", sans-serif;

            font-size: 13px;

            outline: none;

            cursor: pointer;
        }


        select:focus {

            border-color: var(--rosa);

            box-shadow:
                0 0 0 4px rgba(184,111,128,.09);
        }


        /* =====================================================
           RESUMEN
        ====================================================== */

        .resumen {

            position: relative;

            overflow: hidden;

            padding: 28px;

            border-radius: 25px;

            color: white;

            background:

                linear-gradient(
                    145deg,
                    #bf788a,
                    #774452
                );

            box-shadow:
                0 17px 35px rgba(119,68,82,.23);
        }


        .resumen::before {

            content: "";

            position: absolute;

            width: 190px;
            height: 190px;

            right: -85px;
            top: -90px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.08);
        }


        .resumen-titulo {

            position: relative;

            font-size: 10px;

            text-transform: uppercase;

            letter-spacing: 1.5px;

            color: rgba(255,255,255,.72);

            margin-bottom: 7px;
        }


        .total {

            position: relative;

            font-family: "Playfair Display", serif;

            font-size: 36px;

            margin-bottom: 20px;
        }


        .resumen-linea {

            position: relative;

            display: flex;

            justify-content: space-between;

            gap: 15px;

            padding: 10px 0;

            border-bottom: 1px solid rgba(255,255,255,.15);

            font-size: 12px;
        }


        .resumen-linea:last-child {

            border-bottom: none;
        }


        .resumen-linea span {

            color: rgba(255,255,255,.72);
        }


        .resumen-linea strong {

            color: white;
        }


        /* =====================================================
           BOTONES
        ====================================================== */

        .acciones {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

            margin-top: 28px;
        }


        .btn-volver {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            min-height: 51px;

            padding: 0 23px;

            border-radius: 15px;

            border: 1px solid #e3d8d4;

            background: white;

            color: #77686c;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;

            transition: .25s;
        }


        .btn-volver:hover {

            color: var(--vino);

            border-color: var(--rosa-suave);

            transform: translateY(-2px);
        }


        .btn-registrar {

            min-height: 53px;

            padding: 0 29px;

            border: none;

            border-radius: 16px;

            background:

                linear-gradient(
                    135deg,
                    #c17b8c,
                    #894c5c
                );

            color: white;

            font-family: "DM Sans", sans-serif;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 11px 24px rgba(137,76,92,.24);

            transition: .25s;
        }


        .btn-registrar:hover {

            transform: translateY(-3px);

            box-shadow:
                0 15px 29px rgba(137,76,92,.30);
        }


        .pie {

            padding-top: 25px;

            text-align: center;

            color: #a29497;

            font-size: 11px;
        }


        .pie span {

            color: var(--rosa);
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 850px) {

            .datos {

                grid-template-columns: 1fr;

                padding-left: 25px;
                padding-right: 25px;
            }


            .cabecera {

                padding-left: 25px;
                padding-right: 25px;
            }


            .contenido {

                padding-left: 25px;
                padding-right: 25px;
            }


            .parte-inferior {

                grid-template-columns: 1fr;
            }
        }


        @media (max-width: 600px) {

            body {

                padding: 12px;
            }


            .contenedor {

                border-radius: 23px;
            }


            .cabecera h1 {

                font-size: 32px;
            }


            .titulo {

                display: block;
            }


            .cantidad-total {

                display: inline-block;

                margin-top: 8px;
            }


            .acciones {

                flex-direction: column-reverse;
            }


            .btn-volver,
            .btn-registrar {

                width: 100%;
            }
        }

    </style>

</head>


<body>


<div class="contenedor">


    <!-- =====================================================
         CABECERA
    ====================================================== -->

    <div class="cabecera">

        <div class="mini-marca">

            <div class="mini-icono">
                ♡
            </div>

            <span>
                DIVINE BEAUTY STORE
            </span>

        </div>


        <h1>
            Registrar venta
        </h1>


        <p>
            Revisa los productos del pedido, verifica el stock,
            selecciona el método de pago y registra correctamente
            la venta en DIVINE.
        </p>

    </div>


    <!-- =====================================================
         INFORMACIÓN DEL PEDIDO
    ====================================================== -->

    <div class="datos">


        <div class="dato">

            <div class="dato-icono">
                #
            </div>

            <div>

                <small>
                    Número de pedido
                </small>

                <strong>
                    #<?php echo $idPedido; ?>
                </strong>

            </div>

        </div>


        <div class="dato">

            <div class="dato-icono">
                ♡
            </div>

            <div>

                <small>
                    Cliente
                </small>

                <strong>
                    <?php echo $nombreCliente; ?>
                </strong>

            </div>

        </div>


        <div class="dato">

            <div class="dato-icono">
                ✦
            </div>

            <div>

                <small>
                    Estado del pedido
                </small>

                <strong>
                    <?php echo $estadoPedido; ?>
                </strong>

            </div>

        </div>


    </div>


    <!-- =====================================================
         CONTENIDO
    ====================================================== -->

    <div class="contenido">


        <div class="titulo">

            <h2>
                Productos del pedido
            </h2>

            <div class="cantidad-total">

                <?php echo $cantidadTotal; ?>

                producto(s)

            </div>

        </div>


        <!-- =================================================
             TABLA
        ================================================== -->

        <div class="tabla">

            <table>

                <thead>

                    <tr>

                        <th>
                            Producto
                        </th>

                        <th>
                            Precio
                        </th>

                        <th>
                            Cantidad
                        </th>

                        <th>
                            Stock actual
                        </th>

                        <th>
                            Subtotal
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php foreach ($productos as $producto): ?>

                    <tr>


                        <!-- PRODUCTO -->

                        <td>

                            <div class="producto">

                                <div class="producto-imagen">

                                    ♡

                                </div>


                                <div>

                                    <div class="producto-nombre">

                                        <?php

                                        echo htmlspecialchars(
                                            $producto["nombre"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        );

                                        ?>

                                    </div>


                                    <div class="producto-codigo">

                                        Código:

                                        <?php

                                        echo htmlspecialchars(
                                            $producto["PRODUCTO_codigo"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        );

                                        ?>

                                    </div>

                                </div>

                            </div>

                        </td>


                        <!-- PRECIO -->

                        <td>

                            <span class="precio">

                                Bs.

                                <?php

                                echo number_format(
                                    (float)$producto["precio"],
                                    2
                                );

                                ?>

                            </span>

                        </td>


                        <!-- CANTIDAD -->

                        <td>

                            <span class="cantidad">

                                <?php

                                echo (int)$producto["cantidad"];

                                ?>

                            </span>

                        </td>


                        <!-- STOCK -->

                        <td>

                            <span class="stock">

                                <span class="stock-punto"></span>

                                <?php

                                echo (int)$producto["stock"];

                                ?>

                                disponibles

                            </span>

                        </td>


                        <!-- SUBTOTAL -->

                        <td>

                            <span class="subtotal">

                                Bs.

                                <?php

                                echo number_format(
                                    (float)$producto["costototal"],
                                    2
                                );

                                ?>

                            </span>

                        </td>


                    </tr>

                <?php endforeach; ?>


                </tbody>

            </table>

        </div>


        <!-- =================================================
             FORMULARIO
        ================================================== -->

        <form
            action="createventa.php"
            method="POST"
            id="formVenta"
        >


            <input
                type="hidden"
                name="PEDIDOS_ID"
                value="<?php echo $idPedido; ?>"
            >


            <input
                type="hidden"
                name="costototal"
                value="<?php echo $totalVenta; ?>"
            >


            <input
                type="hidden"
                name="estado"
                value="En proceso"
            >


            <div class="parte-inferior">


                <!-- PAGO -->

                <div class="pago">

                    <h3>
                        Método de pago
                    </h3>


                    <p>
                        Selecciona el método utilizado por el
                        cliente para realizar el pago.
                    </p>


                    <select
                        name="metodo"
                        id="metodo"
                        required
                    >

                        <option value="">
                            Seleccionar método de pago
                        </option>

                        <option value="Efectivo">
                            Efectivo
                        </option>

                        <option value="QR">
                            QR
                        </option>

                        <option value="Tarjeta">
                            Tarjeta
                        </option>

                    </select>

                </div>


                <!-- RESUMEN -->

                <div class="resumen">

                    <div class="resumen-titulo">
                        Total de la venta
                    </div>


                    <div class="total">

                        Bs.

                        <?php

                        echo number_format(
                            $totalVenta,
                            2
                        );

                        ?>

                    </div>


                    <div class="resumen-linea">

                        <span>
                            Pedido
                        </span>

                        <strong>
                            #<?php echo $idPedido; ?>
                        </strong>

                    </div>


                    <div class="resumen-linea">

                        <span>
                            Productos
                        </span>

                        <strong>
                            <?php echo $cantidadTotal; ?>
                        </strong>

                    </div>


                    <div class="resumen-linea">

                        <span>
                            Estado
                        </span>

                        <strong>
                            En proceso
                        </strong>

                    </div>

                </div>

            </div>


            <!-- BOTONES -->

            <div class="acciones">


                <a
                    href="../CRUD-CARRITO-PEDIDO/readtodopedido.php"
                    class="btn-volver"
                >

                    ←

                    Volver a pedidos

                </a>


                <button
                    type="submit"
                    class="btn-registrar"
                >

                    Registrar venta

                    &nbsp; ♡

                </button>


            </div>


        </form>


        <div class="pie">

            DIVINE

            <span>♥</span>

            Beauty Store

        </div>


    </div>

</div>


<script>

$(document).ready(function() {


    $("#formVenta").on("submit", function(e) {


        var metodo = $("#metodo").val();


        /* ==============================================
           VALIDAR MÉTODO
        ============================================== */

        if (metodo === "") {

            e.preventDefault();

            Swal.fire({

                title: "Selecciona un método",

                text:
                    "Debes seleccionar cómo se realizará el pago.",

                icon: "warning",

                iconColor: "#b86f80",

                confirmButtonText: "Entendido",

                confirmButtonColor: "#8b4e5e",

                background: "#fffdfb",

                color: "#604e53"

            });

            return;

        }


        /* ==============================================
           CONFIRMAR
        ============================================== */

        e.preventDefault();


        Swal.fire({

            title: "¿Registrar esta venta?",

            html:

                "Pedido <b>#<?php echo $idPedido; ?></b>" +

                "<br><br>" +

                "Total: <b>Bs. <?php echo number_format($totalVenta, 2); ?></b>" +

                "<br><br>" +

                "El stock de los productos será actualizado.",

            icon: "question",

            iconColor: "#b86f80",

            showCancelButton: true,

            confirmButtonText: "Sí, registrar",

            cancelButtonText: "Cancelar",

            reverseButtons: true,

            confirmButtonColor: "#8b4e5e",

            cancelButtonColor: "#b6a3a7",

            background: "#fffdfb",

            color: "#604e53"

        }).then(function(result) {


            if (result.isConfirmed) {

                $("#formVenta")[0].submit();

            }

        });

    });

});

</script>


</body>

</html>

<?php

$conn->close();

?>