<?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("error de conexion");
}

$CI = $_GET['CI'];

$sql = "UPDATE CLIENTE
        SET rol = 'vendedor'
        WHERE CI = '$CI'";

if (mysqli_query($conexion, $sql)) {

    echo "
    <h2 style='color:green; text-align:center; margin-top:50px;'>
        rol actualizado correctamente
    </h2>

    <p style='text-align:center;'>
        el usuario con ci $CI ahora es vendedor.
    </p>

    <div style='text-align:center; margin-top:20px;'>
        <a href='readtodocliente.php'>volver a administrar roles</a>
    </div>
    ";

} else {

    echo "
    <h2 style='color:red; text-align:center; margin-top:50px;'>
        error al actualizar el rol
    </h2>
    ";

}

mysqli_close($conexion);

?>