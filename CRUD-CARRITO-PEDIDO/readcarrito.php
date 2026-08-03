<?php
$conn = new mysqli("localhost","root","","DIVINE");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$idpedido = $_GET['idPedido'] ?? null;

if (!$idpedido) {
    die("No llegó el id del pedido");
}

$sql = "SELECT CARRITO.PRODUCTO_codigo,
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
        rgba(247,233,236,.62),
        rgba(232,205,213,.72)
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
        rgba(184,111,128,.88),
        rgba(143,83,98,.94)
    );

    color:white;

    box-shadow:
    0 10px 35px rgba(100,70,80,.20);

    animation:aparecerHeader .7s ease;
}


.header-pequeno{
    font-size:.78rem;
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
    width:90%;
    max-width:1000px;
    margin:60px auto;
    padding-bottom:40px;
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
    font-size:.8rem;
    text-transform:uppercase;
    letter-spacing:3px;
    margin-bottom:10px;
}


.encabezado h2{
    font-family:Georgia,serif;
    font-size:2.1rem;
    font-weight:400;
    color:var(--texto);
}


.linea-decorativa{
    width:45px;
    height:2px;
    background:var(--rosa-claro);
    margin:20px auto 0;
}


/* ==================================================
   PRODUCTO
================================================== */

.item{
    width:100%;
    max-width:800px;
    margin:0 auto 22px;

    padding:25px 28px;

    border-radius:22px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:30px;

    background:
    linear-gradient(
        135deg,
        rgba(250,243,244,.93),
        rgba(244,224,230,.93)
    );

    border:1px solid rgba(184,111,128,.30);

    box-shadow:
    0 10px 30px rgba(100,70,80,.12),
    inset 0 1px 0 rgba(255,255,255,.75);

    transition:
    transform .3s ease,
    box-shadow .3s ease,
    background .3s ease;

    animation:aparecer .6s ease;
}


.item:hover{
    transform:translateY(-5px);

    background:
    linear-gradient(
        135deg,
        rgba(248,236,239,.97),
        rgba(241,218,225,.97)
    );

    box-shadow:
    0 18px 40px rgba(100,70,80,.18);
}


/* ==================================================
   INFORMACIÓN
================================================== */

.info{
    flex:1;
    min-width:0;
}


/* ==================================================
   NOMBRE DEL PRODUCTO
================================================== */

.nombre{
    display:inline-block;

    color:var(--vino-oscuro);

    font-family:Georgia,serif;

    font-size:1.35rem;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:1.5px;

    line-height:1.3;

    margin-bottom:16px;

    padding-bottom:7px;

    border-bottom:2px solid rgba(184,111,128,.35);
}


/* ==================================================
   CAJAS DE DATOS
================================================== */

.detalle{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
}


.detalle-caja{
    min-width:145px;

    padding:11px 16px;

    border-radius:13px;

    background:
    linear-gradient(
        135deg,
        rgba(255,250,251,.72),
        rgba(247,230,234,.72)
    );

    border:1px solid rgba(184,111,128,.22);

    box-shadow:
    0 4px 12px rgba(100,70,80,.06);

    color:var(--gris);

    font-size:.88rem;

    transition:
    transform .25s ease,
    box-shadow .25s ease;
}


.detalle-caja:hover{
    transform:translateY(-2px);

    box-shadow:
    0 7px 16px rgba(100,70,80,.10);
}


.detalle-caja strong{
    color:var(--vino-oscuro);

    font-size:.95rem;

    font-weight:700;

    margin-left:3px;
}


/* ==================================================
   BOTONES DE ACCIÓN
================================================== */

.acciones-item{
    display:flex;
    gap:10px;
    align-items:center;
    flex-shrink:0;
}


.acciones-item a{
    text-decoration:none;
}


/* ==================================================
   BOTÓN MODIFICAR
================================================== */

.btn-edit{
    border:none;

    padding:12px 20px;

    border-radius:30px;

    cursor:pointer;

    color:white;

    font-size:.82rem;

    font-weight:600;

    letter-spacing:.3px;

    background:
    linear-gradient(
        135deg,
        #c58a73,
        #a96c59
    );

    box-shadow:
    0 6px 16px rgba(169,108,89,.22);

    transition:
    transform .3s ease,
    box-shadow .3s ease,
    filter .3s ease;
}


.btn-edit:hover{
    transform:translateY(-3px);

    filter:brightness(1.08);

    box-shadow:
    0 10px 22px rgba(169,108,89,.30);
}


/* ==================================================
   BOTÓN ELIMINAR
================================================== */

.btn-delete{
    border:none;

    padding:12px 20px;

    border-radius:30px;

    cursor:pointer;

    color:white;

    font-size:.82rem;

    font-weight:600;

    letter-spacing:.3px;

    background:
    linear-gradient(
        135deg,
        #b87986,
        #965565
    );

    box-shadow:
    0 6px 16px rgba(150,85,101,.22);

    transition:
    transform .3s ease,
    box-shadow .3s ease,
    filter .3s ease;
}


.btn-delete:hover{
    transform:translateY(-3px);

    filter:brightness(1.08);

    box-shadow:
    0 10px 22px rgba(150,85,101,.30);
}


/* ==================================================
   TOTAL
================================================== */

.total-box{
    width:320px;

    margin:45px auto 0;

    padding:25px 30px;

    border-radius:24px;

    text-align:center;

    background:
    linear-gradient(
        135deg,
        rgba(250,243,244,.96),
        rgba(244,224,230,.96)
    );

    border:1px solid rgba(184,111,128,.35);

    box-shadow:
    0 14px 35px rgba(100,70,80,.15);

    transition:
    transform .3s ease,
    box-shadow .3s ease;
}


.total-box:hover{
    transform:translateY(-4px);

    box-shadow:
    0 18px 40px rgba(100,70,80,.20);
}


.total-title{
    color:var(--rosa);

    font-size:.75rem;

    text-transform:uppercase;

    letter-spacing:4px;

    font-weight:700;

    margin-bottom:10px;
}


.total-value{
    color:var(--vino-oscuro);

    font-family:Georgia,serif;

    font-size:2.1rem;

    font-weight:700;
}


/* ==================================================
   BOTONES FINALES
================================================== */

.actions{
    display:flex;

    justify-content:center;

    gap:15px;

    margin-top:38px;

    flex-wrap:wrap;
}


.btn{
    min-width:190px;

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

    font-size:.88rem;

    letter-spacing:.2px;

    box-shadow:
    0 8px 20px rgba(100,70,80,.18);

    transition:
    transform .3s ease,
    box-shadow .3s ease,
    filter .3s ease;
}


.btn:hover{
    transform:translateY(-4px);

    filter:brightness(1.08);

    box-shadow:
    0 12px 27px rgba(100,70,80,.25);
}


/* ==================================================
   CARRITO VACÍO
================================================== */

.carrito-vacio{
    max-width:800px;

    margin:0 auto;

    background:
    rgba(250,243,244,.93);

    border:1px solid var(--borde);

    border-radius:22px;

    padding:65px 30px;

    text-align:center;

    color:var(--gris);

    box-shadow:
    0 12px 35px rgba(100,70,80,.12);
}


.carrito-vacio h3{
    font-family:Georgia,serif;

    color:var(--vino-oscuro);

    font-size:1.6rem;

    margin-bottom:10px;
}


.carrito-vacio p{
    font-size:.9rem;
}


/* ==================================================
   ANIMACIONES
================================================== */

@keyframes aparecer{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}


@keyframes aparecerHeader{

    from{
        opacity:0;
        transform:translateY(-15px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:768px){

    .header{
        padding:40px 20px 30px;
    }


    .header h1{
        font-size:2.5rem;
        letter-spacing:3px;
    }


    .container{
        width:92%;
        margin:40px auto;
    }


    .item{
        flex-direction:column;
        align-items:stretch;
        padding:24px 20px;
    }


    .nombre{
        display:block;
        text-align:center;
    }


    .detalle{
        justify-content:center;
    }


    .acciones-item{
        justify-content:center;
        width:100%;
        margin-top:5px;
    }


    .btn-edit,
    .btn-delete{
        padding:11px 15px;
    }


    .total-box{
        width:90%;
        max-width:320px;
    }

}


@media(max-width:450px){

    .detalle{
        flex-direction:column;
        align-items:stretch;
    }


    .detalle-caja{
        text-align:center;
    }


    .acciones-item{
        flex-direction:column;
    }


    .acciones-item a{
        width:100%;
    }


    .btn-edit,
    .btn-delete{
        width:100%;
    }


    .actions{
        flex-direction:column;
        align-items:center;
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

```
<div class="header-pequeno">
    Gestión de compra
</div>

<h1>
    MI CARRITO
</h1>

<div class="header-linea"></div>
```

</div>

<!-- ==================================================
     CONTENIDO
================================================== -->

<div class="container">

```
<div class="encabezado">

    <div class="encabezado-pequeno">
        Pedido seleccionado
    </div>

    <h2>
        Revisa tus productos
    </h2>

    <div class="linea-decorativa"></div>

</div>
```

<?php

$hayProductos = false;

while($fila = $resultado->fetch_assoc()){

    $hayProductos = true;

    $totalGeneral += $fila['costototal'];

?>

<!-- ==================================================
     PRODUCTO
================================================== -->

<div class="item">


<div class="info">


    <div class="nombre">

        <?php echo strtoupper($fila['nombre']); ?>

    </div>


    <div class="detalle">


        <div class="detalle-caja">

            Cantidad:

            <strong>
                <?php echo $fila['cantidad']; ?>
            </strong>

        </div>


        <div class="detalle-caja">

            Total:

            <strong>
                Bs. <?php echo $fila['costototal']; ?>
            </strong>

        </div>


    </div>


</div>


<div class="acciones-item">


    <a href="updateformcarrito.php?idPedido=<?php echo $idpedido ?>&codigo=<?php echo $fila['PRODUCTO_codigo'] ?>&cantidad=<?php echo $fila['cantidad'] ?>">

        <button class="btn-edit" type="button">
            Modificar
        </button>

    </a>


    <a href="deletecarrito.php?idPedido=<?php echo $idpedido ?>&codigo=<?php echo $fila['PRODUCTO_codigo'] ?>">

        <button class="btn-delete" type="button">
            Eliminar
        </button>

    </a>


</div>


</div>

<?php

}


if(!$hayProductos){

?>

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
     BOTONES
================================================== -->

<div class="actions">


<a class="btn" href="formcarrito.php?idPedido=<?php echo $idpedido ?>">

    Seguir comprando

</a>


<a class="btn" href="readtodopedido.php?idPedido=<?php echo $idpedido ?>">

    Finalizar compra

</a>


</div>

</div>

</body>

</html>

<?php

$conn->close();

?>
