<?php
session_start();

/* Eliminar datos de una sesión anterior */
session_unset();

$conexion = mysqli_connect("localhost","root","","DIVINE");

if(!$conexion){
    die("Error de conexión");
}

$nombre = $_POST['nombre'];
$CI = $_POST['CI'];

$sql = "SELECT * FROM CLIENTE 
        WHERE nombre='$nombre' 
        AND CI='$CI'";

$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    // Crear la nueva sesión
    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['estado'] = $fila['estado'];
    $_SESSION['celular'] = $fila['celular'];
    $_SESSION['rol'] = $fila['rol'];

    if($_SESSION['rol'] == "vendedor"){

        header("Location: ../perfilvendedor.php");
        exit();

    }elseif($_SESSION['rol'] == "administrador"){

        header("Location: ../admin.php");
        exit();

    }else{

        echo "este rol no existe.";

    }

}else{

    // Destruir completamente cualquier sesión
    session_unset();
    session_destroy();

    echo "
    <h2 style='color:red;text-align:center;margin-top:50px;'>
        Usuario o contraseña incorrectos
    </h2>

    <div style='text-align:center;margin-top:20px;'>
        <a href='loginformcliente.php'>
          Iniciar sesión nuevamente
        </a>
    </div>
    ";
}

mysqli_close($conexion);
?>