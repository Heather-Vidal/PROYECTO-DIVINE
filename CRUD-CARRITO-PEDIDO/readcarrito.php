<?php

// =====================================================
// CONEXIÓN A LA BASE DE DATOS
// =====================================================

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

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


// =====================================================
// RECIBIR ID DEL PEDIDO
// =====================================================

$idpedido = $_GET['idPedido'] ?? null;

if (!$idpedido) {
    die("No llegó el id del pedido");
}


// =====================================================
// CONSULTAR PRODUCTOS
// =====================================================

$sql = "SELECT
            CARRITO.PRODUCTO_codigo,
            PRODUCTO.nombre,
            CARRITO.cantidad,
            CARRITO.costototal
        FROM CARRITO
        INNER JOIN PRODUCTO
        ON CARRITO.PRODUCTO_codigo = PRODUCTO.codigo
        WHERE CARRITO.PEDIDOS_ID = '$idpedido'";

$resultado = $conn->query($sql);

$totalGeneral = 0;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Mi Carrito</title>


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

    --borde:#dcb9c3;

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

    font-family:'Segoe UI',sans-serif;

    color:var(--texto);

    background:

    linear-gradient(
        rgba(247,233,236,.68),
        rgba(232,205,213,.78)
    ),

    url("../imagenes/fondote.png");

    background-size:cover;

    background-position:center;

    background-attachment:fixed;

}


/* ==================================================
   HEADER
================================================== */

.header{

    text-align:center;

    padding:45px 20px 35px;

    background:

    linear-gradient(
        135deg,
        rgba(184,111,128,.94),
        rgba(143,83,98,.97)
    );

    color:white;

    box-shadow:

    0 10px 35px rgba(100,70,80,.20);

}


.header-pequeno{

    font-size:.75rem;

    text-transform:uppercase;

    letter-spacing:5px;

    margin-bottom:12px;

    opacity:.9;

}


.header h1{

    font-family:Georgia,serif;

    font-size:clamp(2.4rem,5vw,4rem);

    font-weight:400;

    letter-spacing:5px;

}


.header-linea{

    width:55px;

    height:2px;

    background:white;

    margin:20px auto 0;

    opacity:.75;

}


/* ==================================================
   CONTENEDOR
================================================== */

.container{

    width:92%;

    max-width:1100px;

    margin:55px auto 70px;

}


/* ==================================================
   ENCABEZADO
================================================== */

.encabezado{

    text-align:center;

    margin-bottom:40px;

}


.encabezado-pequeno{

    color:var(--rosa);

    font-size:.78rem;

    text-transform:uppercase;

    letter-spacing:4px;

    margin-bottom:10px;

}


.encabezado h2{

    font-family:Georgia,serif;

    font-size:2.2rem;

    font-weight:400;

    color:var(--texto);

}


.linea-decorativa{

    width:50px;

    height:2px;

    background:var(--rosa-claro);

    margin:18px auto 0;

}


/* ==================================================
   TARJETA DEL PRODUCTO
================================================== */

.item{

    width:100%;

    max-width:950px;

    min-height:250px;

    margin:0 auto 25px;

    padding:25px;

    display:grid;

    grid-template-columns:210px 1fr 150px;

    align-items:center;

    gap:30px;

    border-radius:28px;

    background:

    linear-gradient(
        135deg,
        rgba(255,250,251,.96),
        rgba(244,224,230,.96)
    );

    border:1px solid rgba(184,111,128,.28);

    box-shadow:

    0 12px 35px rgba(100,70,80,.12),

    inset 0 1px 0 rgba(255,255,255,.90);

    transition:

    transform .3s ease,
    box-shadow .3s ease;

}


.item:hover{

    transform:translateY(-5px);

    box-shadow:

    0 20px 45px rgba(100,70,80,.18);

}


/* ==================================================
   IMAGEN DEL PRODUCTO
   AHORA OCUPA TODA LA CAJA
================================================== */

.imagen-producto{

    width:210px;

    height:210px;

    padding:0;

    margin:0;

    border-radius:24px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#ffffff;

    border:1px solid rgba(184,111,128,.25);

    box-shadow:

    0 8px 22px rgba(100,70,80,.10);

    overflow:hidden;

}


/* ==================================================
   IMAGEN OCUPANDO TODA LA CAJA
================================================== */

.imagen-producto img{

    width:100%;

    height:100%;

    display:block;

    object-fit:cover;

    border-radius:23px;

}


/* ==================================================
   INFORMACIÓN
================================================== */

.info{

    min-width:0;

    display:flex;

    flex-direction:column;

    justify-content:center;

}


/* ==================================================
   NOMBRE
================================================== */

.nombre{

    display:block;

    color:var(--vino-oscuro);

    font-family:Georgia,serif;

    font-size:1.55rem;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:1.5px;

    line-height:1.3;

    margin-bottom:25px;

    padding-bottom:12px;

    border-bottom:2px solid rgba(184,111,128,.28);

}


/* ==================================================
   DATOS
================================================== */

.detalle{

    display:grid;

    grid-template-columns:repeat(2, minmax(130px,1fr));

    gap:16px;

    width:100%;

}


/* ==================================================
   CAJAS DE DATOS
================================================== */

.detalle-caja{

    min-height:90px;

    padding:16px;

    border-radius:18px;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    text-align:center;

    background:

    rgba(255,255,255,.68);

    border:1px solid rgba(184,111,128,.20);

    box-shadow:

    0 5px 15px rgba(100,70,80,.06);

    color:var(--gris);

    font-size:.78rem;

    text-transform:uppercase;

    letter-spacing:1px;

}


.detalle-caja strong{

    display:block;

    margin-top:7px;

    color:var(--vino-oscuro);

    font-size:1.25rem;

    font-weight:700;

    letter-spacing:0;

}


/* ==================================================
   BOTONES
================================================== */

.acciones-item{

    display:flex;

    flex-direction:column;

    justify-content:center;

    gap:13px;

}


.acciones-item a{

    width:100%;

    text-decoration:none;

}


/* ==================================================
   BOTONES GENERALES
================================================== */

.btn-edit,
.btn-delete{

    width:100%;

    border:none;

    padding:13px 15px;

    border-radius:30px;

    color:white;

    cursor:pointer;

    font-size:.78rem;

    font-weight:600;

    letter-spacing:.4px;

    transition:

    transform .25s ease,
    box-shadow .25s ease,
    filter .25s ease;

}


/* ==================================================
   MODIFICAR
================================================== */

.btn-edit{

    background:

    linear-gradient(
        135deg,
        #c58a73,
        #a96c59
    );

    box-shadow:

    0 7px 17px rgba(169,108,89,.20);

}


.btn-edit:hover{

    transform:translateY(-3px);

    filter:brightness(1.07);

    box-shadow:

    0 11px 23px rgba(169,108,89,.30);

}


/* ==================================================
   ELIMINAR
================================================== */

.btn-delete{

    background:

    linear-gradient(
        135deg,
        #b87986,
        #965565
    );

    box-shadow:

    0 7px 17px rgba(150,85,101,.20);

}


.btn-delete:hover{

    transform:translateY(-3px);

    filter:brightness(1.07);

    box-shadow:

    0 11px 23px rgba(150,85,101,.30);

}


/* ==================================================
   TOTAL
================================================== */

.total-box{

    width:350px;

    max-width:100%;

    margin:50px auto 0;

    padding:28px 35px;

    border-radius:25px;

    text-align:center;

    background:

    linear-gradient(
        135deg,
        rgba(255,250,251,.97),
        rgba(244,224,230,.97)
    );

    border:1px solid rgba(184,111,128,.30);

    box-shadow:

    0 14px 35px rgba(100,70,80,.13);

}


.total-title{

    color:var(--rosa);

    font-size:.72rem;

    text-transform:uppercase;

    letter-spacing:4px;

    font-weight:700;

    margin-bottom:10px;

}


.total-value{

    color:var(--vino-oscuro);

    font-family:Georgia,serif;

    font-size:2.2rem;

    font-weight:700;

}


/* ==================================================
   BOTONES FINALES
================================================== */

.actions{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:18px;

    margin-top:35px;

    flex-wrap:wrap;

}


.btn{

    min-width:200px;

    padding:14px 25px;

    border-radius:30px;

    text-align:center;

    text-decoration:none;

    color:white;

    background:

    linear-gradient(
        135deg,
        var(--vino),
        var(--rosa)
    );

    font-weight:600;

    font-size:.86rem;

    box-shadow:

    0 8px 20px rgba(100,70,80,.18);

    transition:

    transform .3s ease,
    box-shadow .3s ease;

}


.btn:hover{

    transform:translateY(-4px);

    box-shadow:

    0 13px 28px rgba(100,70,80,.25);

}


/* ==================================================
   CARRITO VACÍO
================================================== */

.carrito-vacio{

    max-width:850px;

    margin:auto;

    padding:70px 30px;

    text-align:center;

    border-radius:28px;

    background:

    rgba(255,250,251,.94);

    border:1px solid var(--borde);

    box-shadow:

    0 15px 40px rgba(100,70,80,.12);

}


.carrito-vacio h3{

    color:var(--vino-oscuro);

    font-family:Georgia,serif;

    font-size:1.7rem;

    margin-bottom:10px;

}


.carrito-vacio p{

    color:var(--gris);

    font-size:.9rem;

}


/* ==================================================
   TABLET
================================================== */

@media(max-width:850px){

    .item{

        grid-template-columns:180px 1fr;

        gap:25px;

    }


    .imagen-producto{

        width:180px;

        height:180px;

    }


    .info{

        width:100%;

    }


    .acciones-item{

        grid-column:1 / -1;

        flex-direction:row;

        justify-content:center;

    }


    .acciones-item a{

        max-width:180px;

    }

}


/* ==================================================
   CELULAR
================================================== */

@media(max-width:600px){

    .container{

        width:94%;

        margin-top:35px;

    }


    .item{

        display:flex;

        flex-direction:column;

        align-items:center;

        padding:22px 18px;

        gap:22px;

    }


    .imagen-producto{

        width:190px;

        height:190px;

    }


    .info{

        width:100%;

        align-items:center;

    }


    .nombre{

        width:100%;

        text-align:center;

        font-size:1.3rem;

    }


    .detalle{

        width:100%;

        grid-template-columns:repeat(2,1fr);

    }


    .acciones-item{

        width:100%;

        flex-direction:row;

    }


    .acciones-item a{

        max-width:none;

    }

}


/* ==================================================
   CELULAR PEQUEÑO
================================================== */

@media(max-width:400px){

    .imagen-producto{

        width:160px;

        height:160px;

    }


    .detalle{

        grid-template-columns:1fr;

    }


    .acciones-item{

        flex-direction:column;

    }


    .acciones-item a{

        max-width:none;

    }


    .total-box{

        width:100%;

    }


    .actions{

        flex-direction:column;

    }


    .btn{

        width:100%;

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
        Gestión de compra
    </div>


    <h1>
        MI CARRITO
    </h1>


    <div class="header-linea"></div>

</div>


<!-- ==================================================
     CONTENIDO
================================================== -->

<div class="container">


    <div class="encabezado">

        <div class="encabezado-pequeno">
            Pedido seleccionado
        </div>


        <h2>
            Revisa tus productos
        </h2>


        <div class="linea-decorativa"></div>

    </div>


<?php

$hayProductos = false;


while($fila = $resultado->fetch_assoc()){

    $hayProductos = true;

    $totalGeneral += $fila['costototal'];


    // =====================================================
    // CÓDIGO DEL PRODUCTO
    // =====================================================

    $codigo = $fila['PRODUCTO_codigo'];


    // =====================================================
    // BUSCAR IMAGEN
    // =====================================================

    $nombreArchivo = "p-" . $codigo;

    $directorio = "../PRODUCTO-img/";


    $extensiones = [

        "jpg",
        "jpeg",
        "png",
        "gif"

    ];


    $imagenProducto = null;


    foreach($extensiones as $extension){

        $ruta =
            $directorio .
            $nombreArchivo .
            "." .
            $extension;


        if(file_exists($ruta)){

            $imagenProducto = $ruta;

            break;

        }

    }


    // =====================================================
    // IMAGEN DE RESPALDO
    // =====================================================

    if($imagenProducto === null){

        $imagenProducto =
            "https://i.pinimg.com/1200x/43/31/47/433147cd3e9cdb74e27685ddbace85e8.jpg";

    }

?>


<!-- ==================================================
     TARJETA DEL PRODUCTO
================================================== -->

<div class="item">


    <!-- ==================================================
         IMAGEN
    ================================================== -->

    <div class="imagen-producto">

        <img
            src="<?php echo htmlspecialchars($imagenProducto); ?>"
            alt="<?php echo htmlspecialchars($fila['nombre']); ?>"
        >

    </div>


    <!-- ==================================================
         INFORMACIÓN
    ================================================== -->

    <div class="info">


        <div class="nombre">

            <?php echo strtoupper($fila['nombre']); ?>

        </div>


        <div class="detalle">


            <div class="detalle-caja">

                Cantidad

                <strong>

                    <?php echo $fila['cantidad']; ?>

                </strong>

            </div>


            <div class="detalle-caja">

                Total

                <strong>

                    Bs. <?php echo $fila['costototal']; ?>

                </strong>

            </div>


        </div>


    </div>


    <!-- ==================================================
         ACCIONES
    ================================================== -->

    <div class="acciones-item">


        <a
            href="updateformcarrito.php?idPedido=<?php echo $idpedido; ?>&codigo=<?php echo $fila['PRODUCTO_codigo']; ?>&cantidad=<?php echo $fila['cantidad']; ?>"
        >

            <button
                class="btn-edit"
                type="button"
            >

                Modificar

            </button>

        </a>


        <a
            href="deletecarrito.php?idPedido=<?php echo $idpedido; ?>&codigo=<?php echo $fila['PRODUCTO_codigo']; ?>"
        >

            <button
                class="btn-delete"
                type="button"
            >

                Eliminar

            </button>

        </a>


    </div>


</div>


<?php

}


if(!$hayProductos){

?>


<!-- ==================================================
     CARRITO VACÍO
================================================== -->

<div class="carrito-vacio">

    <h3>
        Tu carrito está vacío
    </h3>

    <p>
        Todavía no has agregado productos a este pedido.
    </p>

</div>


<?php

}

?>


<!-- ==================================================
     TOTAL
================================================== -->

<div class="total-box">


    <div class="total-title">

        Total de la compra

    </div>


    <div class="total-value">

        Bs. <?php echo $totalGeneral; ?>

    </div>


</div>


<!-- ==================================================
     BOTONES FINALES
================================================== -->

<div class="actions">


    <a
        class="btn"
        href="formcarrito.php?idPedido=<?php echo $idpedido; ?>"
    >

        Seguir comprando

    </a>


    <a
        class="btn"
        href="readunopedido.php?idPedido=<?php echo $idpedido; ?>"
    >

        Finalizar compra

    </a>


</div>


</div>


</body>

</html>


<?php

$conn->close();

?>