 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start(); // Inicia la sesión

$conexion = mysqli_connect("localhost","root","","DIVINE");

$nombre = $_POST['nombre'];
$CI = $_POST['CI'];

$sql="SELECT * FROM CLIENTE WHERE nombre= '$nombre' AND CI='$CI'";;

$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    // Guardar datos en la sesión
    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['telefono']=$fila['telefono'];
    $_SESSION['rol']=$fila['rol'];
}if($_SESSION['rol']=="vendedor"){



    header("Location:../perfilvendedor.php");

}
if($_SESSION['rol']=="administrador"){



    header("Location:../admin.php");

}else{

    echo "Usuario o contraseña incorrectos";
}

?>
</body>
</html>