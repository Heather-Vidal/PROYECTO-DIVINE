<?php

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

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
/>

<title>Carrito Actualizado - DIVINE</title>

<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap"
    rel="stylesheet"
/>

<style>

body {
    font-family: "Playfair Display", serif;
    background: linear-gradient(
        135deg,
        #f7dfe7,
        #d6b0bf
    );

    display: flex;
    justify-content: center;
    align-items: center;

    min-height: 100vh;
    margin: 0;

    color: #2b2b2b;
}


.contenedor {
    background: #fff;

    padding: 40px;

    border-radius: 25px;

    box-shadow:
        0 15px 35px rgba(0,0,0,0.15);

    width: 90%;
    max-width: 700px;

    display: grid;

    grid-template-columns: 1fr;

    gap: 30px;

    text-align: center;
}


/* TITULO */

.encabezado {
    font-size: 36px;

    font-weight: 700;

    color: #c96f84;

    letter-spacing: 2px;

    text-transform: uppercase;

    border-bottom:
        3px solid #c96f84;

    padding-bottom: 10px;
}


/* CONTENIDO */

.contenido {
    background: #fff5f8;

    border-radius: 20px;

    padding: 30px 25px;

    box-shadow:
        0 6px 15px rgba(0,0,0,0.08);

    font-size: 18px;
}


/* MENSAJES */

.mensaje {
    border-radius: 12px;

    padding: 18px;

    font-weight: 600;

    margin-bottom: 15px;
}


.exito {
    background-color: #c96f84;

    color: white;

    box-shadow:
        0 6px 18px rgba(201,111,132,0.6);
}


.error {
    background-color: #b84a63;

    color: white;

    box-shadow:
        0 6px 18px rgba(184,74,99,0.6);
}


/* BOTONES */

.botones {
    display: flex;

    justify-content: center;

    gap: 25px;
}


.boton {
    text-decoration: none;

    background: #c96f84;

    color: white;

    padding: 14px 38px;

    border-radius: 30px;

    font-weight: 700;

    font-size: 17px;

    box-shadow:
        0 6px 18px rgba(201,111,132,0.4);

    transition: 0.3s;
}


.boton:hover {
    background: #b65e73;

    transform: scale(1.05);
}


@media (max-width: 600px) {

    .botones {
        flex-direction: column;

        gap: 15px;
    }

}

</style>

</head>


<body>


<div class="contenedor">


<div class="encabezado">
    DIVINE
</div>


<div class="contenido">


<?php

/* =========================================================
   VERIFICAR CONEXIÓN
========================================================= */

if ($conn->connect_error) {

    echo '
        <div class="mensaje error">
            ❌ ERROR DE CONEXIÓN CON BD
        </div>
    ';

    exit;
}


/* =========================================================
   RECIBIR DATOS DEL FORMULARIO
========================================================= */

$idPedido = $_POST['idPedido'] ?? null;

$codigo = $_POST['codigo'] ?? null;

$cantidad = $_POST['cantidad'] ?? null;


/* =========================================================
   VALIDAR ID DEL PEDIDO
   EVITA VALORES NO NUMÉRICOS
========================================================= */

if (
    $idPedido === null ||
    filter_var(
        $idPedido,
        FILTER_VALIDATE_INT
    ) === false ||
    (int)$idPedido <= 0
) {

    echo '
        <div class="mensaje error">
            ⚠ ID DEL PEDIDO NO VÁLIDO
        </div>
    ';

    $conn->close();

    exit;
}


/* =========================================================
   CONVERTIR ID DEL PEDIDO A ENTERO
========================================================= */

$idPedido = (int)$idPedido;


/* =========================================================
   VALIDAR CÓDIGO DEL PRODUCTO
========================================================= */

if (
    $codigo === null ||
    !is_string($codigo) ||
    trim($codigo) === ''
) {

    echo '
        <div class="mensaje error">
            ⚠ CÓDIGO DEL PRODUCTO NO VÁLIDO
        </div>
    ';

    $conn->close();

    exit;
}


/*
   Limpiamos espacios externos.
   NO usamos esto para "proteger" SQL.
   La protección real se hace mediante
   prepare() y bind_param().
*/

$codigo = trim($codigo);


/* =========================================================
   VALIDAR LONGITUD DEL CÓDIGO
========================================================= */

if (strlen($codigo) > 100) {

    echo '
        <div class="mensaje error">
            ⚠ CÓDIGO DEL PRODUCTO DEMASIADO LARGO
        </div>
    ';

    $conn->close();

    exit;
}


/* =========================================================
   VALIDAR CANTIDAD
========================================================= */

if (
    $cantidad === null ||
    filter_var(
        $cantidad,
        FILTER_VALIDATE_INT
    ) === false
) {

    echo '
        <div class="mensaje error">
            ⚠ CANTIDAD NO VÁLIDA
        </div>
    ';

    $conn->close();

    exit;
}


/* =========================================================
   CONVERTIR CANTIDAD A ENTERO
========================================================= */

$cantidad = (int)$cantidad;


/* =========================================================
   VALIDAR CANTIDAD POSITIVA
========================================================= */

if ($cantidad <= 0) {

    echo '
        <div class="mensaje error">
            ⚠ LA CANTIDAD DEBE SER MAYOR A 0
        </div>
    ';

    $conn->close();

    exit;
}


/* =========================================================
   BUSCAR EL PRODUCTO
   PREPARED STATEMENT
========================================================= */

$sqlProducto = "
    SELECT
        codigo,
        precio,
        stock
    FROM PRODUCTO
    WHERE codigo = ?
    LIMIT 1
";


$stmtProducto = $conn->prepare(
    $sqlProducto
);


if (!$stmtProducto) {

    echo '
        <div class="mensaje error">
            ⚠ ERROR AL PREPARAR LA CONSULTA
        </div>
    ';

    $conn->close();

    exit;
}


/*
   "s" porque codigo es texto.
*/

$stmtProducto->bind_param(
    "s",
    $codigo
);


if (!$stmtProducto->execute()) {

    echo '
        <div class="mensaje error">
            ⚠ ERROR AL CONSULTAR EL PRODUCTO
        </div>
    ';

    $stmtProducto->close();

    $conn->close();

    exit;
}


$resultadoProducto =
    $stmtProducto->get_result();


/* =========================================================
   VERIFICAR QUE EL PRODUCTO EXISTA
========================================================= */

if ($resultadoProducto->num_rows === 0) {

    echo '
        <div class="mensaje error">
            ⚠ EL PRODUCTO NO EXISTE
        </div>
    ';

    $stmtProducto->close();

    $conn->close();

    exit;
}


/* =========================================================
   OBTENER DATOS DEL PRODUCTO
========================================================= */

$producto =
    $resultadoProducto->fetch_assoc();


$precioUnitario =
    (float)$producto['precio'];


$stockDisponible =
    (int)$producto['stock'];


$stmtProducto->close();


/* =========================================================
   VERIFICAR STOCK
========================================================= */

if ($cantidad > $stockDisponible) {

    echo '
        <div class="mensaje error">
            ⚠ NO HAY SUFICIENTE STOCK
            <br>
            Stock disponible: '
            . htmlspecialchars(
                (string)$stockDisponible,
                ENT_QUOTES,
                'UTF-8'
            )
            . '
        </div>
    ';

    $conn->close();

    exit;
}


/* =========================================================
   VERIFICAR QUE EL PEDIDO EXISTA
========================================================= */

$sqlPedido = "
    SELECT ID
    FROM PEDIDOS
    WHERE ID = ?
    LIMIT 1
";


$stmtPedido =
    $conn->prepare($sqlPedido);


if (!$stmtPedido) {

    echo '
        <div class="mensaje error">
            ⚠ ERROR AL PREPARAR LA CONSULTA DEL PEDIDO
        </div>
    ';

    $conn->close();

    exit;
}


/*
   "i" porque idPedido es entero.
*/

$stmtPedido->bind_param(
    "i",
    $idPedido
);


if (!$stmtPedido->execute()) {

    echo '
        <div class="mensaje error">
            ⚠ ERROR AL VERIFICAR EL PEDIDO
        </div>
    ';

    $stmtPedido->close();

    $conn->close();

    exit;
}


$resultadoPedido =
    $stmtPedido->get_result();


/* =========================================================
   VERIFICAR PEDIDO
========================================================= */

if ($resultadoPedido->num_rows === 0) {

    echo '
        <div class="mensaje error">
            ⚠ EL PEDIDO NO EXISTE
        </div>
    ';

    $stmtPedido->close();

    $conn->close();

    exit;
}


$stmtPedido->close();


/* =========================================================
   CALCULAR NUEVO COSTO TOTAL
========================================================= */

$costototal =
    $precioUnitario * $cantidad;


/* =========================================================
   ACTUALIZAR CARRITO
   PREPARED STATEMENT
========================================================= */

$sqlUpdate = "
    UPDATE CARRITO

    SET
        cantidad = ?,
        costototal = ?

    WHERE
        PEDIDOS_ID = ?
        AND PRODUCTO_codigo = ?
";


$stmtUpdate =
    $conn->prepare($sqlUpdate);


if (!$stmtUpdate) {

    echo '
        <div class="mensaje error">
            ⚠ ERROR AL PREPARAR LA ACTUALIZACIÓN
        </div>
    ';

    $conn->close();

    exit;
}


/*
   Tipos:

   i = cantidad
   d = costototal
   i = idPedido
   s = codigo
*/

$stmtUpdate->bind_param(
    "idis",
    $cantidad,
    $costototal,
    $idPedido,
    $codigo
);


/* =========================================================
   EJECUTAR ACTUALIZACIÓN
========================================================= */

if ($stmtUpdate->execute()) {

    if ($stmtUpdate->affected_rows > 0) {

        echo '
            <div class="mensaje exito">
                ✔ CARRITO ACTUALIZADO EXITOSAMENTE
            </div>
        ';

    } else {

        /*
           affected_rows = 0 también puede significar
           que los datos enviados son exactamente iguales
           a los que ya estaban guardados.

           Por eso comprobamos que la fila exista.
        */

        $sqlExiste = "
            SELECT 1
            FROM CARRITO
            WHERE
                PEDIDOS_ID = ?
                AND PRODUCTO_codigo = ?
            LIMIT 1
        ";


        $stmtExiste =
            $conn->prepare($sqlExiste);


        if ($stmtExiste) {

            $stmtExiste->bind_param(
                "is",
                $idPedido,
                $codigo
            );


            $stmtExiste->execute();


            $resultadoExiste =
                $stmtExiste->get_result();


            if ($resultadoExiste->num_rows > 0) {

                echo '
                    <div class="mensaje exito">
                        ✔ EL CARRITO YA TENÍA
                        ESOS DATOS
                    </div>
                ';

            } else {

                echo '
                    <div class="mensaje error">
                        ⚠ NO SE ENCONTRÓ EL PRODUCTO
                        EN ESTE PEDIDO
                    </div>
                ';
            }


            $stmtExiste->close();

        } else {

            echo '
                <div class="mensaje error">
                    ⚠ NO SE PUDO VERIFICAR
                    EL CARRITO
                </div>
            ';
        }
    }

} else {

    echo '
        <div class="mensaje error">
            ⚠ ERROR AL ACTUALIZAR EL CARRITO
        </div>
    ';
}


/* =========================================================
   CERRAR
========================================================= */

$stmtUpdate->close();

$conn->close();

?>


</div>


<div class="botones">


<a
    href="formcarrito.php?idPedido=<?php
        echo urlencode((string)$idPedido);
    ?>"
    class="boton"
>
    Seguir comprando ➡
</a>


</div>


</div>


</body>
</html>