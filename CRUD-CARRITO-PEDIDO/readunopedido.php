<?php

$conn = new mysqli("localhost","root","","DIVINE");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


/* OBTENER ID DEL PEDIDO */

$id_pedido = $_GET['idPedido'] ?? null;

if (!$id_pedido) {
    die("No llegó el id del pedido");
}


/* CONSULTAR INFORMACIÓN DEL PEDIDO */

$sqlPedido = "SELECT *
              FROM PEDIDOS
              WHERE ID = '$id_pedido'";

$resultadoPedido = $conn->query($sqlPedido);

if ($resultadoPedido->num_rows == 0) {
    die("El pedido no existe");
}

$pedido = $resultadoPedido->fetch_assoc();


/* CONSULTAR PRODUCTOS DEL PEDIDO */

$sqlProductos = "SELECT CARRITO.PRODUCTO_codigo,
                        PRODUCTO.nombre,
                        PRODUCTO.descripcion,
                        PRODUCTO.precio,
                        CARRITO.cantidad,
                        CARRITO.costototal
 FROM CARRITO
 INNER JOIN PRODUCTO
   ON CARRITO.PRODUCTO_codigo = PRODUCTO.codigo
 WHERE CARRITO.PEDIDOS_ID = '$id_pedido'";


$resultadoProductos = $conn->query($sqlProductos);


/* CALCULAR TOTAL */

$totalGeneral = 0;
$productos = array();

while($fila = $resultadoProductos->fetch_assoc()){

    $totalGeneral += $fila['costototal'];

    $productos[] = $fila;

}


/* ==================================================
   INFORMACIÓN COMPLETA PARA EL QR
================================================== */

$textoQR = "DIVINE\n";
$textoQR .= "DETALLE DEL PEDIDO\n";
$textoQR .= "-------------------------\n";
$textoQR .= "Pedido: #" . $id_pedido . "\n";
$textoQR .= "Cliente: " . $pedido['nombre'] . "\n";
$textoQR .= "Fecha: " . $pedido['fecha'] . "\n";
$textoQR .= "Telefono: " . $pedido['telefono'] . "\n";
$textoQR .= "Direccion: " . $pedido['direccion'] . "\n";
$textoQR .= "Vendedor: " . $pedido['nombrevendedor'] . "\n";
$textoQR .= "Estado: " . $pedido['estado'] . "\n";
$textoQR .= "-------------------------\n";
$textoQR .= "PRODUCTOS\n";


/* AGREGAR CADA PRODUCTO AL QR */

foreach($productos as $producto){

    $textoQR .= "\n";
    $textoQR .= "Producto: " . $producto['nombre'] . "\n";
    $textoQR .= "Descripcion: " . $producto['descripcion'] . "\n";
    $textoQR .= "Cantidad: " . $producto['cantidad'] . "\n";
    $textoQR .= "Precio: Bs. " . number_format($producto['precio'], 2) . "\n";
    $textoQR .= "Subtotal: Bs. " . number_format($producto['costototal'], 2) . "\n";

}


/* AGREGAR TOTAL FINAL */

$textoQR .= "\n";
$textoQR .= "-------------------------\n";
$textoQR .= "TOTAL: Bs. " . number_format($totalGeneral, 2);


/* CREAR DATOS DEL QR */

$qrData = rawurlencode($textoQR);


/* URL PARA GENERAR EL QR */

$qrURL = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=" . $qrData;

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
DIVINE | Detalle del Pedido
</title>

<style>


/* ==================================================
   VARIABLES
================================================== */

:root{

    --rosa:#b86f80;

    --rosa-claro:#d9a6b2;

    --rosa-palido:#f7e9ec;

    --crema:#fffaf8;

    --texto:#57494c;

    --gris:#817679;

    --borde:#e3c5cd;

    --vino:#8f5362;

    --vino-oscuro:#713d4d;

}


/* ==================================================
   RESET
================================================== */

*{

    margin:0;

    padding:0;

    box-sizing:border-box;

}


/* ==================================================
   BODY
================================================== */

body{

    min-height:100vh;

    font-family:
    'Segoe UI',
    sans-serif;

    color:
    var(--texto);


    background:

    linear-gradient(

        rgba(
            255,
            250,
            248,
            .80
        ),

        rgba(
            247,
            233,
            236,
            .92
        )

    ),

    url("../imagenes/fondote.png");


    background-size:
    cover;


    background-position:
    center;


    background-attachment:
    fixed;

}


/* ==================================================
   HEADER
================================================== */

.header{

    text-align:center;

    padding:
    45px 20px 35px;


    background:

    linear-gradient(

        rgba(
            184,
            111,
            128,
            .90
        ),

        rgba(
            143,
            83,
            98,
            .95
        )

    );


    color:white;


    box-shadow:

    0 10px 35px
    rgba(
        100,
        70,
        80,
        .20
    );


    animation:
    aparecerHeader
    .7s
    ease;

}


.header-pequeno{

    font-size:
    .78rem;


    text-transform:
    uppercase;


    letter-spacing:
    5px;


    margin-bottom:
    12px;


    opacity:
    .9;

}


.header h1{

    font-family:
    Georgia,
    serif;


    font-size:
    clamp(
        2.5rem,
        5vw,
        4rem
    );


    font-weight:
    400;


    letter-spacing:
    5px;

}


.header-linea{

    width:
    55px;


    height:
    2px;


    background:
    white;


    margin:
    20px
    auto
    0;


    opacity:
    .75;

}


/* ==================================================
   CONTENEDOR
================================================== */

.contenedor{

    width:
    90%;


    max-width:
    1050px;


    margin:
    55px
    auto;


    padding-bottom:
    50px;

}


/* ==================================================
   ENCABEZADO
================================================== */

.encabezado{

    text-align:
    center;


    margin-bottom:
    35px;

}


.encabezado-pequeno{

    color:
    var(--rosa);


    font-size:
    .78rem;


    text-transform:
    uppercase;


    letter-spacing:
    4px;


    margin-bottom:
    10px;

}


.encabezado h2{

    font-family:
    Georgia,
    serif;


    font-size:
    2.2rem;


    font-weight:
    400;


    color:
    var(--texto);

}


.linea-decorativa{

    width:
    45px;


    height:
    2px;


    background:
    var(--rosa-claro);


    margin:
    18px
    auto
    0;

}


/* ==================================================
   DOCUMENTO
================================================== */

.documento{

    background:
    rgba(
        255,
        250,
        248,
        .94
    );


    border:
    1px solid
    rgba(
        184,
        111,
        128,
        .25
    );


    border-radius:
    28px;


    padding:
    40px;


    box-shadow:

    0 18px 50px
    rgba(
        100,
        70,
        80,
        .14
    );


    animation:
    aparecer
    .7s
    ease;

}


/* ==================================================
   CABECERA DEL DOCUMENTO
================================================== */

.documento-header{

    display:
    flex;


    justify-content:
    space-between;


    align-items:
    center;


    gap:
    25px;


    padding-bottom:
    28px;


    border-bottom:
    1px solid
    var(--borde);

}


.marca{

    font-family:
    Georgia,
    serif;


    font-size:
    2rem;


    color:
    var(--vino);


    letter-spacing:
    4px;

}


.numero-pedido{

    text-align:
    right;

}


.numero-pedido small{

    display:
    block;


    color:
    var(--gris);


    font-size:
    .72rem;


    text-transform:
    uppercase;


    letter-spacing:
    2px;


    margin-bottom:
    5px;

}


.numero-pedido strong{

    color:
    var(--vino-oscuro);


    font-family:
    Georgia,
    serif;


    font-size:
    1.4rem;

}


/* ==================================================
   INFORMACIÓN PEDIDO
================================================== */

.informacion{

    display:
    grid;


    grid-template-columns:
    repeat(
        2,
        1fr
    );


    gap:
    16px;


    margin-top:
    30px;

}


.dato{

    background:
    rgba(
        247,
        233,
        236,
        .55
    );


    border:
    1px solid
    rgba(
        184,
        111,
        128,
        .16
    );


    border-radius:
    15px;


    padding:
    17px
    18px;


    transition:
    transform
    .3s
    ease,

    box-shadow
    .3s
    ease;

}


.dato:hover{

    transform:
    translateY(
        -3px
    );


    box-shadow:

    0 8px 20px
    rgba(
        100,
        70,
        80,
        .08
    );

}


.dato-titulo{

    color:
    var(--rosa);


    font-size:
    .7rem;


    text-transform:
    uppercase;


    letter-spacing:
    2px;


    font-weight:
    700;


    margin-bottom:
    7px;

}


.dato-valor{

    color:
    var(--texto);


    font-size:
    .95rem;


    font-weight:
    600;


    word-break:
    break-word;

}


/* ==================================================
   ESTADO
================================================== */

.estado{

    display:
    inline-flex;


    align-items:
    center;


    gap:
    8px;


    margin-top:
    25px;


    padding:
    11px
    20px;


    border-radius:
    30px;


    background:
    linear-gradient(
        135deg,
        #fff0f3,
        #f5dce2
    );


    color:
    var(--vino-oscuro);


    border:
    1px solid
    rgba(
        184,
        111,
        128,
        .3
    );


    font-size:
    .85rem;


    font-weight:
    700;


    text-transform:
    capitalize;

}


.estado::before{

    content:
    "●";


    color:
    var(--rosa);


    font-size:
    .75rem;

}


/* ==================================================
   PRODUCTOS
================================================== */

.seccion-productos{

    margin-top:
    40px;

}


.titulo-seccion{

    display:
    flex;


    align-items:
    center;


    gap:
    15px;


    margin-bottom:
    20px;

}


.titulo-seccion h3{

    font-family:
    Georgia,
    serif;


    font-size:
    1.5rem;


    font-weight:
    400;


    color:
    var(--vino-oscuro);

}


.titulo-seccion-linea{

    flex:
    1;


    height:
    1px;


    background:
    var(--borde);

}


/* ==================================================
   TABLA PRODUCTOS
================================================== */

.tabla{

    width:
    100%;


    border-collapse:
    separate;


    border-spacing:
    0
    8px;

}


.tabla th{

    padding:
    10px
    15px;


    color:
    var(--rosa);


    font-size:
    .72rem;


    text-transform:
    uppercase;


    letter-spacing:
    2px;


    text-align:
    left;

}


.tabla td{

    padding:
    17px
    15px;


    background:
    rgba(
        255,
        250,
        251,
        .85
    );


    border-top:
    1px solid
    rgba(
        184,
        111,
        128,
        .12
    );


    border-bottom:
    1px solid
    rgba(
        184,
        111,
        128,
        .12
    );


    font-size:
    .9rem;

}


.tabla td:first-child{

    border-left:
    1px solid
    rgba(
        184,
        111,
        128,
        .12
    );


    border-radius:
    12px
    0
    0
    12px;

}


.tabla td:last-child{

    border-right:
    1px solid
    rgba(
        184,
        111,
        128,
        .12
    );


    border-radius:
    0
    12px
    12px
    0;

}


.producto-nombre{

    color:
    var(--vino-oscuro);


    font-family:
    Georgia,
    serif;


    font-size:
    1.05rem;


    font-weight:
    700;

}


.producto-descripcion{

    color:
    var(--gris);


    font-size:
    .78rem;


    margin-top:
    4px;

}


.cantidad{

    text-align:
    center;


    font-weight:
    600;

}


.precio{

    color:
    var(--gris);

}


.subtotal{

    color:
    var(--vino-oscuro);


    font-weight:
    700;

}


/* ==================================================
   SIN PRODUCTOS
================================================== */

.sin-productos{

    text-align:
    center;


    padding:
    35px;


    color:
    var(--gris);


    background:
    var(--rosa-palido);


    border-radius:
    15px;

}


/* ==================================================
   TOTAL
================================================== */

.total-contenedor{

    display:
    flex;


    justify-content:
    flex-end;


    margin-top:
    30px;

}


.total{

    min-width:
    280px;


    padding:
    22px
    28px;


    border-radius:
    20px;


    background:

    linear-gradient(
        135deg,
        var(--vino),
        var(--rosa)
    );


    color:
    white;


    box-shadow:

    0 12px 30px
    rgba(
        143,
        83,
        98,
        .25
    );

}


.total-label{

    font-size:
    .75rem;


    text-transform:
    uppercase;


    letter-spacing:
    3px;


    opacity:
    .85;


    margin-bottom:
    8px;

}


.total-monto{

    font-family:
    Georgia,
    serif;


    font-size:
    2rem;


    font-weight:
    700;

}


/* ==================================================
   QR
================================================== */

.qr-seccion{

    margin-top:
    40px;


    padding-top:
    35px;


    border-top:
    1px solid
    var(--borde);


    display:
    flex;


    align-items:
    center;


    justify-content:
    space-between;


    gap:
    30px;

}


.qr-info{

    flex:
    1;

}


.qr-info h3{

    font-family:
    Georgia,
    serif;


    color:
    var(--vino-oscuro);


    font-size:
    1.5rem;


    font-weight:
    400;


    margin-bottom:
    10px;

}


.qr-info p{

    color:
    var(--gris);


    font-size:
    .88rem;


    line-height:
    1.7;


    max-width:
    500px;

}


.qr-box{

    background:
    white;


    padding:
    12px;


    border-radius:
    15px;


    border:
    1px solid
    var(--borde);


    box-shadow:

    0 8px 25px
    rgba(
        100,
        70,
        80,
        .10
    );

}


.qr-box img{

    display:
    block;


    width:
    150px;


    height:
    150px;

}


/* ==================================================
   BOTONES
================================================== */

.acciones{

    display:
    flex;


    justify-content:
    center;


    gap:
    14px;


    flex-wrap:
    wrap;


    margin-top:
    35px;

}


.btn{

    display:
    inline-flex;


    justify-content:
    center;


    align-items:
    center;


    min-width:
    170px;


    padding:
    13px
    23px;


    border-radius:
    30px;


    border:
    none;


    text-decoration:
    none;


    font-size:
    .88rem;


    font-weight:
    600;


    cursor:
    pointer;


    transition:
    transform
    .3s
    ease,

    box-shadow
    .3s
    ease,

    background
    .3s
    ease;

}


.btn:hover{

    transform:
    translateY(
        -3px
    );


    box-shadow:

    0 9px 22px
    rgba(
        100,
        70,
        80,
        .20
    );

}


.btn-volver{

    background:
    white;


    color:
    var(--vino);


    border:
    1px solid
    var(--borde);

}


.btn-imprimir{

    background:
    var(--vino);


    color:
    white;

}


.btn-pdf{

    background:
    linear-gradient(
        135deg,
        var(--rosa),
        var(--vino)
    );


    color:
    white;

}


/* ==================================================
   ANIMACIÓN
================================================== */

@keyframes aparecer{

    from{

        opacity:
        0;


        transform:
        translateY(
            20px
        );

    }


    to{

        opacity:
        1;


        transform:
        translateY(
            0
        );

    }

}


@keyframes aparecerHeader{

    from{

        opacity:
        0;


        transform:
        translateY(
            -15px
        );

    }


    to{

        opacity:
        1;


        transform:
        translateY(
            0
        );

    }

}


/* ==================================================
   IMPRESIÓN
================================================== */

@media print{


    body{

        background:
        white;

    }


    .header{

        background:
        white;


        color:
        black;


        box-shadow:
        none;


        padding:
        20px;

    }


    .header-pequeno{

        color:
        #555;

    }


    .header h1{

        color:
        #333;

    }


    .header-linea{

        background:
        #333;

    }


    .encabezado{

        margin-top:
        10px;

    }


    .documento{

        box-shadow:
        none;


        border:
        1px solid
        #ddd;


        background:
        white;

    }


    .acciones{

        display:
        none;

    }


    .qr-box{

        box-shadow:
        none;

    }


}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:768px){

    .contenedor{

        width:
        94%;


        margin:
        35px
        auto;

    }


    .documento{

        padding:
        25px
        20px;


        border-radius:
        20px;

    }


    .documento-header{

        flex-direction:
        column;


        align-items:
        center;


        text-align:
        center;

    }


    .numero-pedido{

        text-align:
        center;

    }


    .informacion{

        grid-template-columns:
        1fr;

    }


    .tabla{

        display:
        block;


        overflow-x:
        auto;

    }


    .tabla th,
    .tabla td{

        white-space:
        nowrap;

    }


    .total-contenedor{

        justify-content:
        center;

    }


    .total{

        width:
        100%;


        min-width:
        0;


        text-align:
        center;

    }


    .qr-seccion{

        flex-direction:
        column;


        text-align:
        center;

    }


    .qr-info p{

        margin:
        auto;

    }


    .acciones{

        flex-direction:
        column;

    }


    .btn{

        width:
        100%;

    }

}


</style>

</head>

<body>

<!-- ==================================================
     HEADER
================================================== -->

<div class="header">

<div class="header-pequeno">

    Comprobante de compra

</div>


<h1>

    DIVINE

</h1>


<div class="header-linea"></div>
 
</div>

<!-- ==================================================
     CONTENEDOR
================================================== -->

<div class="contenedor">

 <div class="encabezado">


    <div class="encabezado-pequeno">

        Detalle del pedido

    </div>


    <h2>

        Resumen de tu compra

    </h2>


    <div class="linea-decorativa"></div>


</div>



<!-- ==================================================
     DOCUMENTO
================================================== -->

<div class="documento">


    <!-- CABECERA -->

    <div class="documento-header">


        <div class="marca">

            DIVINE
<div class="linea-decorativa"></div>
        </div>


        <div class="numero-pedido">


            <small>

                Número de pedido

            </small>


            <strong>

                #<?php

                echo $id_pedido;

                ?>

            </strong>


        </div>


    </div>



    <!-- ==================================================
         INFORMACIÓN DEL PEDIDO
    ================================================== -->

    <div class="informacion">


        <div class="dato">


            <div class="dato-titulo">

                Cliente

            </div>


            <div class="dato-valor">

                <?php

                echo htmlspecialchars(

                    $pedido['nombre']

                );

                ?>

            </div>


        </div>



        <div class="dato">


            <div class="dato-titulo">

                Fecha

            </div>


            <div class="dato-valor">

                <?php

                echo htmlspecialchars(

                    $pedido['fecha']

                );

                ?>

            </div>


        </div>



        <div class="dato">


            <div class="dato-titulo">

                Teléfono

            </div>


            <div class="dato-valor">

                <?php

                echo htmlspecialchars(

                    $pedido['telefono']

                );

                ?>

            </div>


        </div>



        <div class="dato">


            <div class="dato-titulo">

                Dirección

            </div>


            <div class="dato-valor">

                <?php

                echo htmlspecialchars(

                    $pedido['direccion']

                );

                ?>

            </div>


        </div>



        <div class="dato">


            <div class="dato-titulo">

                Vendedor

            </div>


            <div class="dato-valor">

                <?php

                echo htmlspecialchars(

                    $pedido['nombrevendedor']

                );

                ?>

            </div>


        </div>


    </div>



    <!-- ESTADO -->


    <div class="estado">


        Estado:

        <?php

        echo htmlspecialchars(

            $pedido['estado']

        );

        ?>


    </div>



    <!-- ==================================================
         PRODUCTOS
    ================================================== -->

    <div class="seccion-productos">


        <div class="titulo-seccion">


            <h3>

                Productos del pedido

            </h3>


            <div class="titulo-seccion-linea"></div>


        </div>
 
<?php

if(count($productos) > 0){

?>

         <table class="tabla">


            <thead>


                <tr>


                    <th>

                        Producto

                    </th>


                    <th>

                        Cantidad

                    </th>


                    <th>

                        Precio

                    </th>


                    <th>

                        Subtotal

                    </th>


                </tr>


            </thead>


            <tbody>
 
<?php foreach($productos as $producto){?>

       <tr>

     <td>

    <div class="producto-nombre">

 <?php echo htmlspecialchars(strtoupper($producto['nombre']) ); ?>
 
 </div>

  <div class="producto-descripcion">

<?php echo htmlspecialchars($producto['descripcion'] ); ?>

  </div>

  </td>

 <td class="cantidad">

<?php echo $producto['cantidad']; ?>

  </td>

 <td class="precio">

Bs. <?php echo number_format($producto['precio'],2 ); ?>
   </td>
 
   <td class="subtotal">

Bs. <?php echo number_format($producto['costototal'],2 ); ?>

   </td>

                </tr>
 
<?php

}

?>

      </tbody>

     </table>
 
<?php

}else{

?>

         <div class="sin-productos">

            Este pedido todavía no tiene productos.

        </div>
 
<?php

}

?>

 </div>

     <!-- ==================================================
         TOTAL
    ================================================== -->

    <div class="total-contenedor">


  <div class="total">

             <div class="total-label">

                Total del pedido

            </div>


            <div class="total-monto">

                Bs. <?php echo number_format( $totalGeneral, 2 ); ?>

            </div>


           </div>
 
  </div>

     <!-- ==================================================
         QR
    ================================================== -->

    <div class="qr-seccion">


        <div class="qr-info">
 
 <h3>

 Código QR del pedido
 
 </h3>


            <p>

                Escanea este código para
                identificar la información
                principal de tu pedido DIVINE.

                Este código corresponde
                exclusivamente al pedido

    <strong>

        #<?php echo $id_pedido; ?>

    </strong>.


</p>


        </div>


        <div class="qr-box">


            <img

            src="<?php echo $qrURL; ?>"

            alt="QR del pedido">


        </div>


    </div>


</div>


<!-- ==================================================
     BOTONES
================================================== -->

<div class="acciones">


    <a

    href="readtodopedido.php?idPedido=<?php echo $id_pedido; ?>"

    class="btn btn-volver">

 ← Lista de pedidos

 </a>


    <button

    type="button"

    class="btn btn-imprimir"

    onclick="window.print()">

    Imprimir pedido

    </button>



    <button type="button" class="btn btn-pdf"  onclick="window.print()">  Guardar como PDF  </button>

  </div>

</div>

</body>

</html>

<?php

$conn->close();

?>
