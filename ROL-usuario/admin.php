 <?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("error de conexion");
}

$CI = $_GET['CI'];

$sql = "UPDATE CLIENTE
        SET rol = 'administrador'
        WHERE CI = '$CI'";

if (mysqli_query($conexion, $sql)) {

    echo "
    <h2 style='color:green; text-align:center; margin-top:50px;'>
        Rol actualizado correctamente
    </h2>

    <p style='text-align:center;'>
        El usuario con CI $CI ahora es <strong>Administrador</strong>.
    </p>

    <div style='text-align:center; margin-top:20px;'>
        <a href='readroles.php'>Volver</a>
    </div>
    ";

} else {

    echo "
    <h2 style='color:red; text-align:center; margin-top:50px;'>
        Error al actualizar el rol.
    </h2>
    ";

}

mysqli_close($conexion);

?>