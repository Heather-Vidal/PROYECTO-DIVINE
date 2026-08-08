<?php

// ==========================================
// RECIBIR DATOS DEL ARCHIVO ANTERIOR
// ==========================================

$idPedido = $_GET['idPedido'] ?? null;

$estado = $_GET['estado'] ?? null;

$costoTotal = $_GET['costoTotal'] ?? null;


// ==========================================
// VERIFICAR QUE LLEGÓ EL ID DEL PEDIDO
// ==========================================

if (!$idPedido) {

    die("No se recibió el ID del pedido.");

}


// ==========================================
// VERIFICAR ESTADO
// ==========================================

if (!$estado) {

    die("No se recibió el estado del pedido.");

}


// ==========================================
// VERIFICAR COSTO TOTAL
// ==========================================

if ($costoTotal === null) {

    die("No se recibió el costo total.");

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Registrar Venta</title>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<style>

*{

    margin:0;

    padding:0;

    box-sizing:border-box;

    font-family:'Segoe UI',sans-serif;

}


body{

    background:
    linear-gradient(
        rgba(0,0,0,.30),
        rgba(0,0,0,.30)
    ),
    url('../imagenes/fondote.png');

    background-position:center;

    background-repeat:no-repeat;

    background-size:cover;

    display:flex;

    justify-content:center;

    align-items:center;

    min-height:100vh;

    padding:20px;

}


.contenedor{

    background:rgba(255,255,255,.78);

    backdrop-filter:blur(8px);

    padding:40px;

    width:450px;

    max-width:100%;

    border-radius:30px;

    box-shadow:
        0 15px 35px rgba(0,0,0,.10);

}


h1{

    text-align:center;

    color:#bf7485;

    margin-bottom:30px;

    font-size:30px;

}


label{

    display:block;

    margin-bottom:8px;

    color:#666;

    font-weight:600;

}


input[type="text"],
input[type="number"],
select{

    width:100%;

    padding:12px 15px;

    border:2px solid #f0d6dc;

    border-radius:15px;

    outline:none;

    margin-bottom:20px;

    transition:.3s;

    font-size:15px;

    background:white;

}


input[type="text"]:focus,
input[type="number"]:focus,
select:focus{

    border-color:#c96f84;

    box-shadow:
        0 0 10px rgba(201,111,132,.2);

}


input[readonly]{

    background:#fdf5f7;

    color:#bf7485;

    font-weight:bold;

}


select{

    cursor:pointer;

}


input[type="submit"]{

    width:100%;

    background:#c96f84;

    color:white;

    border:none;

    padding:15px;

    border-radius:50px;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

    box-shadow:
        0 8px 20px rgba(201,111,132,.35);

}


input[type="submit"]:hover{

    background:#b45d72;

    transform:translateY(-3px);

}


.estado-mostrado,
.total-mostrado{

    width:100%;

    padding:12px 15px;

    border:2px solid #f0d6dc;

    border-radius:15px;

    background:#fdf5f7;

    color:#bf7485;

    margin-bottom:20px;

}


.volver{

    display:block;

    text-align:center;

    margin-top:20px;

    color:#bf7485;

    text-decoration:none;

    font-weight:600;

}


.volver:hover{

    color:#b45d72;

}


.error{

    color:#d85a5a;

    font-size:14px;

    font-weight:600;

    margin-top:-15px;

    margin-bottom:15px;

    display:block;

}


@media(max-width:500px){

    .contenedor{

        padding:30px 25px;

        border-radius:25px;

    }

    h1{

        font-size:26px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


<h1>REGISTRAR VENTA</h1>


<!-- ==================================================
     AQUÍ ESTÁ LA CONEXIÓN CON createventa.php
     ================================================== -->

<form
    action="createventa.php"
    method="POST"
>


    <!-- ==================================================
         PEDIDOS_ID

         VIENE DE actualizarestadopedido.php

         SE ENVÍA OCULTO A createventa.php
         ================================================== -->

    <input
        type="hidden"
        name="PEDIDOS_ID"
        value="<?php echo htmlspecialchars($idPedido); ?>"
    >


    <!-- ==================================================
         ESTADO

         VIENE DEL ARCHIVO ANTERIOR
         ================================================== -->

    <input
        type="hidden"
        name="estado"
        value="<?php echo htmlspecialchars($estado); ?>"
    >


    <!-- ==================================================
         COSTO TOTAL

         VIENE DEL ARCHIVO ANTERIOR
         ================================================== -->

    <input
        type="hidden"
        name="costototal"
        value="<?php echo htmlspecialchars($costoTotal); ?>"
    >


    <!-- ==================================================
         PEDIDO
         ================================================== -->

    <label>
        Pedido número:
    </label>

    <input
        type="text"
        value="<?php echo htmlspecialchars($idPedido); ?>"
        readonly
    >


    <!-- ==================================================
         ESTADO
         ================================================== -->

    <label>
        Estado actual:
    </label>

    <div class="estado-mostrado">

        <strong>

            <?php
            echo htmlspecialchars($estado);
            ?>

        </strong>

    </div>


    <!-- ==================================================
         MÉTODO DE PAGO
         ================================================== -->

    <label for="metodo">
        Método de pago:
    </label>

    <select
        id="metodo"
        name="metodo"
    >

        <option value="">
            Seleccione un método
        </option>

        <option value="Efectivo">
            Efectivo
        </option>

        <option value="Tarjeta">
            Tarjeta
        </option>

        <option value="QR">
            QR
        </option>

    </select>


    <!-- ==================================================
         COSTO TOTAL
         ================================================== -->

    <label>
        Costo total del pedido:
    </label>

    <div class="total-mostrado">

        <strong>

            Bs.

            <?php
            echo number_format(
                (float)$costoTotal,
                2
            );
            ?>

        </strong>

    </div>


    <!-- ==================================================
         BOTÓN
         ================================================== -->

    <input
        type="submit"
        value="Registrar Venta"
    >


</form>


<a
    href="javascript:history.back()"
    class="volver"
>
    ← Volver
</a>


</div>


<!-- ==================================================
     VALIDACIÓN JQUERY
     ================================================== -->

<script>

$(function(){

    $("form").validate({

        rules: {

            metodo: {

                required: true

            }

        },

        messages: {

            metodo: {

                required:
                "Seleccione un método de pago."

            }

        },

        errorClass: "error",

        errorPlacement: function(
            error,
            element
        ){

            error.insertAfter(element);

        }

    });

});

</script>


</body>

</html>