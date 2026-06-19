<?php

$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";


$conn = new mysqli($servidor,$usuario,$contraseña,$nombreBD);


if($conn->connect_error){

    echo '<div class="mensaje error">
    ❌ NO TE PUDISTE CONECTAR CON LA BD UnU
    </div>';

}


$idPedido = $_POST['idPedido'];

$nombre = $_POST['nombre'];

$fecha = $_POST['fecha'];

$estado = $_POST['estado'];

$nombrevendedor = $_POST['nombrevendedor'];



$sql = "UPDATE PEDIDOS SET

nombre='$nombre',
fecha='$fecha',
estado='$estado',
nombrevendedor='$nombrevendedor'

WHERE ID='$idPedido'";




if($conn->query($sql) === TRUE){

    echo '<div class="mensaje exito">
    ✔ PEDIDO ACTUALIZADO EXITOSAMENTE
    </div>';


}else{

    echo '<div class="mensaje error">
    ⚠ ERROR AL ACTUALIZAR PEDIDO
    </div>';

}



$conn->close();

?>


<div class="botones">

<a href="../totu.php" class="boton">
⬅ Volver al inicio
</a>


<a href="readtodopedido.php" class="boton">
Ver pedidos ➡
</a>

</div>