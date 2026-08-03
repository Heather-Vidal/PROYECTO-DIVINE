 <?php

include "conexion.php";


$nombre=$_GET["nombre"];



$sql="SELECT * FROM producto WHERE nombre='$nombre'";


$resultado=$conn->query($sql);



$productos=[];



while($fila=$resultado->fetch_assoc()){


$productos[]=$fila;


}



echo json_encode($productos);


?>