<?php

/* =========================================================
   CONEXIÓN
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

    die(
        "Error al conectar con la base de datos."
    );
}

$conn->set_charset("utf8mb4");


/* =========================================================
   FUNCIÓN PARA MOSTRAR MENSAJES
========================================================= */

function alertaError($mensaje)
{
    ?>

    <!DOCTYPE html>

    <html lang="es">

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>DIVINE</title>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>


    <body>

        <script>

        Swal.fire({

            title: "No se pudo completar",

            text: <?php echo json_encode($mensaje); ?>,

            icon: "error",

            iconColor: "#b86f80",

            confirmButtonText: "Entendido",

            confirmButtonColor: "#8b4e5e",

            background: "#fffdfb",

            color: "#604e53"

        }).then(function() {

            history.back();

        });

        </script>

    </body>

    </html>

    <?php

    exit();
}


/* =========================================================
   RECIBIR DATOS
========================================================= */

$PEDIDOS_ID = trim(
    $_POST["PEDIDOS_ID"] ?? ""
);

$estado = trim(
    $_POST["estado"] ?? ""
);

$metodo = trim(
    $_POST["metodo"] ?? ""
);

$costototal = trim(
    $_POST["costototal"] ?? ""
);


/* =========================================================
   VALIDAR PEDIDO
========================================================= */

if (
    $PEDIDOS_ID === ""
    ||
    !ctype_digit((string)$PEDIDOS_ID)
) {

    alertaError(
        "El pedido recibido no es válido."
    );
}


$PEDIDOS_ID = (int)$PEDIDOS_ID;


/* =========================================================
   VALIDAR ESTADO
========================================================= */

if ($estado === "") {

    $estado = "En proceso";
}


/* =========================================================
   VALIDAR MÉTODO
========================================================= */

$metodosPermitidos = [

    "Efectivo",
    "QR",
    "Tarjeta"

];

if (
    $metodo === ""
    ||
    !in_array(
        $metodo,
        $metodosPermitidos,
        true
    )
) {

    alertaError(
        "Debes seleccionar un método de pago válido."
    );
}


/* =========================================================
   VALIDAR TOTAL
========================================================= */

if (
    $costototal === ""
    ||
    !is_numeric($costototal)
) {

    alertaError(
        "El costo total recibido no es válido."
    );
}


$costototal = (float)$costototal;


/* =========================================================
   BUSCAR PEDIDO
========================================================= */

$sqlPedido = "

    SELECT
        ID,
        nombre,
        estado

    FROM PEDIDOS

    WHERE ID = ?

    LIMIT 1

";


$stmtPedido = $conn->prepare(
    $sqlPedido
);


if (!$stmtPedido) {

    alertaError(
        "No se pudo consultar el pedido."
    );
}


$stmtPedido->bind_param(
    "i",
    $PEDIDOS_ID
);


$stmtPedido->execute();


$resultadoPedido =
    $stmtPedido->get_result();


if (
    $resultadoPedido->num_rows === 0
) {

    $stmtPedido->close();

    alertaError(
        "El pedido no existe."
    );
}


$pedido =
    $resultadoPedido->fetch_assoc();


$stmtPedido->close();


/* =========================================================
   VERIFICAR SI YA EXISTE UNA VENTA
========================================================= */

$sqlVentaExistente = "

    SELECT
        id

    FROM VENTAS

    WHERE PEDIDOS_ID = ?

    LIMIT 1

";


$stmtVentaExistente =
    $conn->prepare(
        $sqlVentaExistente
    );


if (!$stmtVentaExistente) {

    alertaError(
        "No se pudo verificar si la venta ya existe."
    );
}


$stmtVentaExistente->bind_param(
    "i",
    $PEDIDOS_ID
);


$stmtVentaExistente->execute();


$resultadoVentaExistente =
    $stmtVentaExistente->get_result();


if (
    $resultadoVentaExistente->num_rows > 0
) {

    $stmtVentaExistente->close();

    alertaError(
        "Este pedido ya tiene una venta registrada."
    );
}


$stmtVentaExistente->close();


/* =========================================================
   OBTENER PRODUCTOS DEL CARRITO
========================================================= */

$sqlCarrito = "

    SELECT

        c.PRODUCTO_codigo,

        c.PEDIDOS_ID,

        c.cantidad,

        c.costototal,

        p.nombre,

        p.stock,

        p.precio

    FROM CARRITO c

    INNER JOIN PRODUCTO p

        ON c.PRODUCTO_codigo = p.codigo

    WHERE c.PEDIDOS_ID = ?

    ORDER BY p.nombre ASC

";


$stmtCarrito =
    $conn->prepare(
        $sqlCarrito
    );


if (!$stmtCarrito) {

    alertaError(
        "No se pudieron consultar los productos del pedido."
    );
}


$stmtCarrito->bind_param(
    "i",
    $PEDIDOS_ID
);


$stmtCarrito->execute();


$resultadoCarrito =
    $stmtCarrito->get_result();


$productosPedido = [];


while (
    $producto =
    $resultadoCarrito->fetch_assoc()
) {

    $productosPedido[] =
        $producto;
}


$stmtCarrito->close();


/* =========================================================
   VERIFICAR QUE HAYA PRODUCTOS
========================================================= */

if (
    count($productosPedido) === 0
) {

    alertaError(
        "Este pedido no tiene productos en el carrito."
    );
}


/* =========================================================
   CALCULAR TOTAL REAL DESDE EL CARRITO
========================================================= */

$totalReal = 0;


foreach (
    $productosPedido
    as $producto
) {

    $cantidad =
        (int)$producto["cantidad"];

    $subtotal =
        (float)$producto["costototal"];


    if ($cantidad <= 0) {

        alertaError(
            "La cantidad de uno de los productos no es válida."
        );
    }


    $totalReal += $subtotal;
}


/*
 * Se utiliza el total calculado directamente
 * desde la base de datos.
 */

$costototal = $totalReal;


/* =========================================================
   INICIAR TRANSACCIÓN
========================================================= */

$conn->begin_transaction();


try {


    /* =====================================================
       1. VERIFICAR STOCK DE TODOS LOS PRODUCTOS
    ====================================================== */

    foreach (
        $productosPedido
        as $producto
    ) {


        $codigo =
            (int)$producto["PRODUCTO_codigo"];


        $cantidad =
            (int)$producto["cantidad"];


        $stockActual =
            (int)$producto["stock"];


        $nombreProducto =
            $producto["nombre"];


        if (
            $cantidad <= 0
        ) {

            throw new Exception(
                "La cantidad del producto "
                . $nombreProducto
                . " no es válida."
            );
        }


        if (
            $stockActual < $cantidad
        ) {

            throw new Exception(

                "No hay suficiente stock de "
                . $nombreProducto
                . ". "
                . "Disponible: "
                . $stockActual
                . " | Solicitado: "
                . $cantidad

            );
        }

    }


    /* =====================================================
       2. INSERTAR VENTA
    ====================================================== */

    $sqlVenta = "

        INSERT INTO VENTAS
        (
            estado,
            metodo,
            costototal,
            PEDIDOS_ID
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?
        )

    ";


    $stmtVenta =
        $conn->prepare(
            $sqlVenta
        );


    if (!$stmtVenta) {

        throw new Exception(
            "No se pudo preparar el registro de la venta."
        );
    }


    $stmtVenta->bind_param(

        "ssdi",

        $estado,

        $metodo,

        $costototal,

        $PEDIDOS_ID

    );


    if (
        !$stmtVenta->execute()
    ) {

        throw new Exception(
            "No se pudo registrar la venta."
        );
    }


    $idVenta =
        $conn->insert_id;


    $stmtVenta->close();


    /* =====================================================
       3. DESCONTAR STOCK
    ====================================================== */

    $sqlStock = "

        UPDATE PRODUCTO

        SET stock = stock - ?

        WHERE codigo = ?

        AND stock >= ?

    ";


    $stmtStock =
        $conn->prepare(
            $sqlStock
        );


    if (!$stmtStock) {

        throw new Exception(
            "No se pudo preparar la actualización del stock."
        );
    }


    foreach (
        $productosPedido
        as $producto
    ) {


        $codigo =
            (int)$producto["PRODUCTO_codigo"];


        $cantidad =
            (int)$producto["cantidad"];


        $stmtStock->bind_param(

            "iii",

            $cantidad,

            $codigo,

            $cantidad

        );


        if (
            !$stmtStock->execute()
        ) {

            throw new Exception(
                "No se pudo actualizar el stock del producto."
            );
        }


        /*
         * Si affected_rows es 0 significa que el stock
         * cambió entre la comprobación anterior y este UPDATE.
         */

        if (
            $stmtStock->affected_rows !== 1
        ) {

            throw new Exception(

                "No fue posible descontar el stock "
                . "del producto con código "
                . $codigo
                . "."

            );
        }

    }


    $stmtStock->close();


    /* =====================================================
       4. CAMBIAR ESTADO DEL PEDIDO
    ====================================================== */

    $nuevoEstadoPedido =
        "En proceso";


    $sqlPedidoEstado = "

        UPDATE PEDIDOS

        SET estado = ?

        WHERE ID = ?

    ";


    $stmtPedidoEstado =
        $conn->prepare(
            $sqlPedidoEstado
        );


    if (!$stmtPedidoEstado) {

        throw new Exception(
            "No se pudo actualizar el estado del pedido."
        );
    }


    $stmtPedidoEstado->bind_param(

        "si",

        $nuevoEstadoPedido,

        $PEDIDOS_ID

    );


    if (
        !$stmtPedidoEstado->execute()
    ) {

        throw new Exception(
            "No se pudo actualizar el estado del pedido."
        );
    }


    $stmtPedidoEstado->close();


    /* =====================================================
       5. CONFIRMAR TRANSACCIÓN
    ====================================================== */

    $conn->commit();


    /* =====================================================
       6. CERRAR CONEXIÓN
    ====================================================== */

    $conn->close();


    /* =====================================================
       7. MOSTRAR ÉXITO
    ====================================================== */

    ?>

    <!DOCTYPE html>

    <html lang="es">

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>Venta registrada | DIVINE</title>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>


    <body>

        <script>

        Swal.fire({

            title: "¡Venta registrada!",

            html:

                "La venta del pedido " +

                "<strong>#<?php echo $PEDIDOS_ID; ?></strong>" +

                " fue registrada correctamente." +

                "<br><br>" +

                "El stock de los productos fue actualizado.",

            icon: "success",

            iconColor: "#b86f80",

            confirmButtonText: "Ver ventas",

            confirmButtonColor: "#8b4e5e",

            background: "#fffdfb",

            color: "#604e53",

            allowOutsideClick: false

        }).then(function() {

            window.location.href =
                "readtodoventa.php";

        });

        </script>

    </body>

    </html>

    <?php

    exit();


} catch (Exception $e) {


    /* =====================================================
       DESHACER TODO
    ====================================================== */

    $conn->rollback();


    $conn->close();


    alertaError(
        $e->getMessage()
    );
}

?>