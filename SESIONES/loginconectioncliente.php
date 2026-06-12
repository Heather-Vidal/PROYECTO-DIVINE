<?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);
if($conn->connect_error){
    echo '<div class="mensaje error">❌ No se pudo conectar con la base de datos</div>';
}

$CI= $_POST['CI'];
$nombre= $_POST['nombre'];
$sql="SELECT * FROM CLIENTE WHERE nombre= '$nombre' AND CI='$CI'";
$resultado= $conn->query($sql);

if($resultado->num_rows > 0){
   session_start();
   $_SESSION['nombre'] = $nombre;
    header("Location:  perfilvendedor.php");
} else {
    echo  'Usuario o contraseña incorrectos ';
}
?>