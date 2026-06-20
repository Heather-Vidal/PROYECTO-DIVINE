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
<html>
<head>
<meta charset="UTF-8">
<title>Carrito - DIVINE</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background: linear-gradient(135deg,#f7dfe7,#d6b0bf);
    min-height:100vh;
}

/* HEADER */
.header{
    text-align:center;
    padding:55px 20px;
    background: linear-gradient(135deg,#c96f84,#8f3f55);
    color:white;
}

.header h1{
    font-size:3rem;
    letter-spacing:2px;
}

.header p{
    opacity:0.85;
    margin-top:5px;
}

/* CONTENEDOR */
.container{
    max-width:850px;
    margin:40px auto;
    padding:20px;
}

/* ITEM PRODUCTO */
.item{
    background:white;
    padding:18px 20px;
    border-radius:18px;
    margin-bottom:14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 8px 22px rgba(0,0,0,0.08);
    border-left:5px solid #c96f84;
    transition:0.25s;
}

.item:hover{
    transform:translateY(-3px);
}

.info{
    flex:1;
}

.nombre{
    font-size:17px;
    font-weight:700;
    color:#8f3f55;
    text-transform:uppercase;
}

.detalle{
    font-size:14px;
    color:#666;
    margin-top:4px;
}

/* BOTÓN ELIMINAR */
.btn-delete{
    background:#ff4d4d;
    color:white;
    border:none;
    padding:9px 13px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    transition:0.2s;
}

.btn-delete:hover{
    background:#d93636;
}

/* NUEVO BOTÓN MODIFICAR */
.btn-edit{
    background:#ffb84d;
    color:white;
    border:none;
    padding:9px 13px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    transition:0.2s;
}

.btn-edit:hover{
    background:#e6a63d;
}

/* CONTENEDOR BOTONES */
.acciones-item{
    display:flex;
    gap:10px;
    align-items:center;
}

/* TOTAL */
.total-box{
    width:260px;
    margin:30px auto 0 auto;
    background:white;
    padding:15px;
    border-radius:14px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    border:2px solid #c96f84;
}

.total-title{
    font-size:14px;
    letter-spacing:2px;
    color:#8f3f55;
    font-weight:700;
}

.total-value{
    font-size:22px;
    font-weight:800;
    color:#8f3f55;
    margin-top:5px;
}

/* BOTONES */
.actions{
    display:flex;
    justify-content:center;
    gap:12px;
    margin-top:30px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 18px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    background:linear-gradient(135deg,#c96f84,#a84d65);
    font-weight:600;
    transition:0.25s;
    box-shadow:0 8px 18px rgba(0,0,0,0.12);
}

.btn:hover{
    transform:translateY(-2px);
}
</style>
</head>

<body>

<div class="header">
    <h1>MI CARRITO</h1>
    <p>Revisa tus productos antes de finalizar</p>
</div>

<div class="container">

<?php while($fila = $resultado->fetch_assoc()){
    $totalGeneral += $fila['costototal'];
?>

<div class="item">

    <div class="info">
        <div class="nombre">
            <?php echo strtoupper($fila['nombre']) ?>
        </div>

        <div class="detalle">
            Cantidad: <?php echo $fila['cantidad'] ?> • Total: Bs. <?php echo $fila['costototal'] ?>
        </div>
    </div>

    <div class="acciones-item">

        <!-- MODIFICAR -->
        <a href="updateformcarrito.php?idPedido=<?php echo $idpedido ?>&codigo=<?php echo $fila['PRODUCTO_codigo'] ?>&cantidad=<?php echo $fila['cantidad'] ?>">
            <button class="btn-edit">Modificar</button>
        </a>

        <!-- ELIMINAR -->
        <a href="deletecarrito.php?idPedido=<?php echo $idpedido ?>&codigo=<?php echo $fila['PRODUCTO_codigo'] ?>">
            <button class="btn-delete">Eliminar</button>
        </a>

    </div>

</div>

<?php } ?>

<!-- TOTAL -->
<div class="total-box">
    <div class="total-title">TOTAL</div>
    <div class="total-value">Bs. <?php echo $totalGeneral ?></div>
</div>

<!-- BOTONES -->
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

<?php $conn->close(); ?>