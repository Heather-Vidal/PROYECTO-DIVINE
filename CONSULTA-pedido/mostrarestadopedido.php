<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if ($conn->connect_error) {

    die("Error de conexión con la base de datos.");

}


/* COMPROBAR QUE SE RECIBIÓ EL ID */

if (!isset($_GET["idPedido"]) || empty($_GET["idPedido"])) {

    die("No se recibió el número del pedido.");

}


/* RECIBIR EL ID DEL PEDIDO */

$idPedido = intval($_GET["idPedido"]);


/* CONSULTAR EL PEDIDO */

$sql = "SELECT * FROM PEDIDOS WHERE ID = ? LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $idPedido);

$stmt->execute();

$resultado = $stmt->get_result();


/* COMPROBAR SI EXISTE EL PEDIDO */

$pedidoEncontrado = false;

if ($resultado && $resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $pedidoEncontrado = true;

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">
<title>Estado del Pedido</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;

    font-family:'Segoe UI', sans-serif;
}


body{

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    background:
        linear-gradient(
            135deg,
            #fff5f7,
            #f8dfe5
        );
}


/* TARJETA */

.contenedor{

    width:450px;

    padding:40px;

    background:white;

    border:1px solid #f1d1d9;

    border-radius:22px;

    box-shadow:
        0 20px 45px rgba(191,116,133,.20),
        0 5px 15px rgba(0,0,0,.05);

}


/* TÍTULO */

h2{

    text-align:center;

    color:#bf7485;

    font-size:30px;

    margin-bottom:30px;

}


h2::after{

    content:"";

    display:block;

    width:55px;

    height:4px;

    background:#c96f84;

    border-radius:10px;

    margin:10px auto 0;

}


/* INFORMACIÓN */

.informacion{

    margin-top:20px;

}


.dato{

    padding:15px;

    margin-bottom:12px;

    border-radius:12px;

    background:#fff5f7;

    border:1px solid #f1d1d9;

}


.dato strong{

    color:#bf7485;

}


.dato span{

    color:#555;

}


/* ESTADO */

.estado{

    margin-top:20px;

    padding:18px;

    text-align:center;

    border-radius:14px;

    font-size:20px;

    font-weight:bold;

}


/* ESTADO EN PROCESO */

.en-proceso{

    color:#9a7210;

    background:#fff6d8;

    border:1px solid #f0d47a;

}


/* ESTADO RECHAZADO */

.rechazado{

    color:#c0392b;

    background:#ffe5e2;

    border:1px solid #efa49b;

}


/* ESTADO COMPLETADO */

.completado{

    color:#25834d;

    background:#e4f7ec;

    border:1px solid #9bd5b4;

}


/* PEDIDO NO ENCONTRADO */

.no-encontrado{

    padding:20px;

    text-align:center;

    color:#c0392b;

    background:#ffe5e2;

    border:1px solid #efa49b;

    border-radius:12px;

}


/* BOTÓN */

.volver{

    display:block;

    margin-top:25px;

    padding:14px;

    text-align:center;

    text-decoration:none;

    border-radius:12px;

    background:#c96f84;

    color:white;

    font-weight:bold;

    transition:.3s;

}


.volver:hover{

    background:#b45d72;

    transform:translateY(-2px);

}


</style>

</head>


<body>


<div class="contenedor">

    <h2>Estado del Pedido</h2>


<?php

if ($pedidoEncontrado) {

    /*

       Convertimos el estado a minúsculas

       para poder determinar el diseño.

    */

    $estado = strtolower(trim($fila["estado"]));


    /* CLASE CSS SEGÚN EL ESTADO */

    if ($estado == "en proceso") {

        $claseEstado = "en-proceso";

    }

    elseif ($estado == "rechazado") {

        $claseEstado = "rechazado";

    }

    elseif ($estado == "completado") {

        $claseEstado = "completado";

    }

    else {

        $claseEstado = "";

    }

?>

    <div class="informacion">

        <div class="dato">

            <strong>Número de pedido:</strong>

            <span>
                <?php echo htmlspecialchars($fila["ID"]); ?>
            </span>

        </div>


        <div class="dato">

            <strong>Cliente:</strong>

            <span>
                <?php echo htmlspecialchars($fila["nombre"]); ?>
            </span>

        </div>


        <div class="dato">

            <strong>Fecha:</strong>

            <span>
                <?php echo htmlspecialchars($fila["fecha"]); ?>
            </span>

        </div>


        <div class="estado <?php echo $claseEstado; ?>">

            Estado:

            <?php echo htmlspecialchars($fila["estado"]); ?>

        </div>

    </div>

<?php

}

else {

?>

    <div class="no-encontrado">

        No se encontró ningún pedido
        con el número:

        <strong>
            <?php echo htmlspecialchars($idPedido); ?>
        </strong>

    </div>

<?php

}

?>


    <a
        href="formreadpedido.php"
        class="volver">

        ← Consultar otro pedido

    </a>


</div>


</body>

</html>


<?php

$stmt->close();

$conn->close();

?>