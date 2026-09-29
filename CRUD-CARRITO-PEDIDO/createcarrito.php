<?php

/* =========================================================
   CONEXIÓN A LA BASE DE DATOS
========================================================= */

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


/* =========================================================
   VERIFICAR CONEXIÓN
========================================================= */

if ($conn->connect_error) {

    die("Error de conexión con la base de datos.");

}


/* =========================================================
   CONFIGURAR UTF-8
========================================================= */

$conn->set_charset("utf8mb4");


/* =========================================================
   VERIFICAR QUE LA PETICIÓN SEA POST
========================================================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    $conn->close();

    die("Método de solicitud no permitido.");

}


/* =========================================================
   RECIBIR DATOS
========================================================= */

$codigo = $_POST["codigo"] ?? null;

$idpedido = $_POST["idpedido"] ?? null;

$cantidad = $_POST["cantidad"] ?? null;


/*
   IMPORTANTE:

   NO confiamos en $_POST["precio"].

   El precio será obtenido directamente
   desde la tabla PRODUCTO.
*/


/* =========================================================
   VALIDAR DATOS OBLIGATORIOS
========================================================= */

if (
    $codigo === null ||
    $idpedido === null ||
    $cantidad === null
) {

    $conn->close();

    die("Datos incompletos.");

}


/* =========================================================
   VALIDAR CÓDIGO DEL PRODUCTO
========================================================= */

if (!is_string($codigo)) {

    $conn->close();

    die("Código de producto inválido.");

}


$codigo = trim($codigo);


if ($codigo === "") {

    $conn->close();

    die("Código de producto inválido.");

}


/*
   Limitar longitud para evitar entradas
   absurdamente grandes.
*/

if (strlen($codigo) > 100) {

    $conn->close();

    die("Código de producto demasiado largo.");

}


/* =========================================================
   VALIDAR ID DEL PEDIDO
========================================================= */

if (
    filter_var(
        $idpedido,
        FILTER_VALIDATE_INT
    ) === false
) {

    $conn->close();

    die("ID de pedido inválido.");

}


$idpedido = (int)$idpedido;


if ($idpedido <= 0) {

    $conn->close();

    die("ID de pedido inválido.");

}


/* =========================================================
   VALIDAR CANTIDAD
========================================================= */

if (
    filter_var(
        $cantidad,
        FILTER_VALIDATE_INT
    ) === false
) {

    $conn->close();

    header(
        "Location: formcarrito.php?idPedido="
        . urlencode((string)$idpedido)
    );

    exit();

}


$cantidad = (int)$cantidad;


/* =========================================================
   LA CANTIDAD DEBE SER MAYOR A 0
========================================================= */

if ($cantidad <= 0) {

    $conn->close();

    header(
        "Location: formcarrito.php?idPedido="
        . urlencode((string)$idpedido)
    );

    exit();

}


/* =========================================================
   INICIAR TRANSACCIÓN
========================================================= */

$conn->begin_transaction();


try {


    /* =====================================================
       VERIFICAR QUE EL PEDIDO EXISTA
    ===================================================== */

    $sqlPedido = "
        SELECT ID
        FROM PEDIDOS
        WHERE ID = ?
        LIMIT 1
    ";


    $stmtPedido = $conn->prepare($sqlPedido);


    if (!$stmtPedido) {

        throw new Exception(
            "Error al preparar la consulta del pedido."
        );

    }


    $stmtPedido->bind_param(
        "i",
        $idpedido
    );


    if (!$stmtPedido->execute()) {

        $stmtPedido->close();

        throw new Exception(
            "Error al verificar el pedido."
        );

    }


    $resultadoPedido =
        $stmtPedido->get_result();


    if ($resultadoPedido->num_rows === 0) {

        $stmtPedido->close();

        throw new Exception(
            "El pedido no existe."
        );

    }


    $stmtPedido->close();


    /* =====================================================
       OBTENER PRODUCTO, PRECIO Y STOCK
       
       EL PRECIO VIENE DE LA BASE DE DATOS.
       
       NO SE USA EL PRECIO ENVIADO POR EL NAVEGADOR.
    ===================================================== */

    $sqlProducto = "
        SELECT
            codigo,
            precio,
            stock
        FROM PRODUCTO
        WHERE codigo = ?
        LIMIT 1
    ";


    $stmtProducto =
        $conn->prepare($sqlProducto);


    if (!$stmtProducto) {

        throw new Exception(
            "Error al preparar la consulta del producto."
        );

    }


    $stmtProducto->bind_param(
        "s",
        $codigo
    );


    if (!$stmtProducto->execute()) {

        $stmtProducto->close();

        throw new Exception(
            "Error al consultar el producto."
        );

    }


    $resultadoProducto =
        $stmtProducto->get_result();


    /* =====================================================
       VERIFICAR QUE EL PRODUCTO EXISTA
    ===================================================== */

    if ($resultadoProducto->num_rows === 0) {

        $stmtProducto->close();

        throw new Exception(
            "El producto no existe."
        );

    }


    $producto =
        $resultadoProducto->fetch_assoc();


    $precioReal =
        (float)$producto["precio"];


    $stockDisponible =
        (int)$producto["stock"];


    $stmtProducto->close();


    /* =====================================================
       VERIFICAR STOCK
    ===================================================== */

    if ($stockDisponible <= 0) {

        throw new Exception(
            "El producto está agotado."
        );

    }


    if ($cantidad > $stockDisponible) {

        throw new Exception(
            "No hay suficiente stock disponible."
        );

    }


    /* =====================================================
       BUSCAR SI EL PRODUCTO YA EXISTE EN EL PEDIDO
    ===================================================== */

    $sqlBuscar = "
        SELECT
            cantidad
        FROM CARRITO
        WHERE
            PRODUCTO_codigo = ?
            AND PEDIDOS_ID = ?
        LIMIT 1
    ";


    $stmtBuscar =
        $conn->prepare($sqlBuscar);


    if (!$stmtBuscar) {

        throw new Exception(
            "Error al preparar la consulta del carrito."
        );

    }


    $stmtBuscar->bind_param(
        "si",
        $codigo,
        $idpedido
    );


    if (!$stmtBuscar->execute()) {

        $stmtBuscar->close();

        throw new Exception(
            "Error al consultar el carrito."
        );

    }


    $resultadoCarrito =
        $stmtBuscar->get_result();


    /* =====================================================
       SI EL PRODUCTO YA EXISTE
    ===================================================== */

    if ($resultadoCarrito->num_rows > 0) {


        $row =
            $resultadoCarrito->fetch_assoc();


        $cantidadActual =
            (int)$row["cantidad"];


        /*
           SUMAR LA NUEVA CANTIDAD
        */

        $nuevaCantidad =
            $cantidadActual + $cantidad;


        /* =================================================
           VERIFICAR QUE LA NUEVA CANTIDAD
           NO SUPERE EL STOCK
        ================================================= */

        if ($nuevaCantidad > $stockDisponible) {

            $stmtBuscar->close();

            throw new Exception(
                "No puedes agregar esa cantidad. "
                . "El stock disponible es de "
                . $stockDisponible
                . " unidades."
            );

        }


        /*
           CALCULAR TOTAL CON EL PRECIO REAL
           DE LA BASE DE DATOS.
        */

        $nuevoTotal =
            $precioReal * $nuevaCantidad;


        $stmtBuscar->close();


        /* =================================================
           ACTUALIZAR CARRITO
        ================================================= */

        $sqlUpdate = "
            UPDATE CARRITO

            SET
                cantidad = ?,
                costototal = ?

            WHERE
                PRODUCTO_codigo = ?
                AND PEDIDOS_ID = ?
        ";


        $stmtUpdate =
            $conn->prepare($sqlUpdate);


        if (!$stmtUpdate) {

            throw new Exception(
                "Error al preparar la actualización."
            );

        }


        /*
           i = cantidad
           d = total
           s = código
           i = pedido
        */

        $stmtUpdate->bind_param(
            "idsi",
            $nuevaCantidad,
            $nuevoTotal,
            $codigo,
            $idpedido
        );


        if (!$stmtUpdate->execute()) {

            $stmtUpdate->close();

            throw new Exception(
                "Error al actualizar el carrito."
            );

        }


        $stmtUpdate->close();


    } else {


        /* =================================================
           EL PRODUCTO ES NUEVO
        ================================================= */


        $stmtBuscar->close();


        /*
           CALCULAR TOTAL CON PRECIO REAL
        */

        $total =
            $precioReal * $cantidad;


        /* =================================================
           INSERTAR PRODUCTO
        ================================================= */

        $sqlInsert = "
            INSERT INTO CARRITO
            (
                PRODUCTO_codigo,
                PEDIDOS_ID,
                cantidad,
                costototal
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ";


        $stmtInsert =
            $conn->prepare($sqlInsert);


        if (!$stmtInsert) {

            throw new Exception(
                "Error al preparar el registro."
            );

        }


        /*
           s = código
           i = pedido
           i = cantidad
           d = total
        */

        $stmtInsert->bind_param(
            "siid",
            $codigo,
            $idpedido,
            $cantidad,
            $total
        );


        if (!$stmtInsert->execute()) {

            $stmtInsert->close();

            throw new Exception(
                "Error al agregar el producto."
            );

        }


        $stmtInsert->close();

    }


    /* =====================================================
       CONFIRMAR TRANSACCIÓN
    ===================================================== */

    $conn->commit();


    /* =====================================================
       CERRAR CONEXIÓN
    ===================================================== */

    $conn->close();


    /* =====================================================
       REDIRECCIONAR AL CARRITO
    ===================================================== */

    header(
        "Location: formcarrito.php?idPedido="
        . urlencode((string)$idpedido)
    );

    exit();


} catch (Exception $e) {


    /* =====================================================
       CANCELAR CUALQUIER CAMBIO
    ===================================================== */

    $conn->rollback();


    $conn->close();


    /*
       Para el usuario mostramos un mensaje sencillo.
       No mostramos directamente errores internos de SQL.
    */

    die(
        "No se pudo agregar el producto al carrito: "
        . htmlspecialchars(
            $e->getMessage(),
            ENT_QUOTES,
            "UTF-8"
        )
    );

}

?>