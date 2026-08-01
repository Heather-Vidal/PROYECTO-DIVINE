<?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("Error de conexión");
}

$CI = $_GET['CI'];

$sql = "UPDATE CLIENTE 
        SET estado = 'BLOQUEADO' 
        WHERE CI = '$CI'";

if (mysqli_query($conexion, $sql)) {

    echo "
    <h2 style='color:green; text-align:center; margin-top:50px;'>
        Usuario bloqueado correctamente
    </h2>

    <p style='text-align:center;'>
        El estado del usuario con CI $CI ahora es BLOQUEADO.
    </p>

    <div style='text-align:center; margin-top:20px;'>
        <a href='./CRUD-cliente/readunocliente.php'>Volver a vendedores</a>
    </div>
    ";

} else {

    echo "
    <h2 style='color:red; text-align:center; margin-top:50px;'>
        Error al bloquear el usuario
    </h2>
    ";

}

mysqli_close($conexion);

?>