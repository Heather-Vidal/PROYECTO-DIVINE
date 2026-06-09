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
$usuario= $_POST['usuario'];
$sql="SELECT * FROM CLIENTE WHERE usuario= ;
?>