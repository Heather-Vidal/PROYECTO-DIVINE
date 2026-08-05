<?php

$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn=new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
    die("Error de conexión");
}

$sql="SELECT * FROM CLIENTE";
$resultado=$conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Administrar Roles</title>

</head>

<body>

<h1>ADMINISTRAR ROLES DE CLIENTES</h1>

<?php

if($resultado->num_rows>0){

    while($fila=$resultado->fetch_assoc()){

        $CI = $fila['CI'];
        $rol = $fila['rol'];
        $estado = $fila['estado'];

?>

<div>

<p><strong>CI:</strong> <?php echo $fila['CI']; ?></p>

<p><strong>Nombre:</strong> <?php echo $fila['nombre']; ?></p>

<p><strong>Dirección:</strong> <?php echo $fila['direccion']; ?></p>

<p><strong>Celular:</strong> <?php echo $fila['celular']; ?></p>

<p><strong>Rol actual:</strong> <?php echo $rol; ?></p>

<p><strong>Estado:</strong> <?php echo $estado; ?></p>

<!-- BOTONES PARA CAMBIAR ROL -->

<div class="botones">

<?php
if($rol != "administrador"){
?>
<a class="boton" href="admin.php?CI=<?php echo $CI; ?>">
    Hacer Administrador
</a>
<?php
}
?>

<?php
if($rol != "vendedor"){
?>
<a class="boton" href="vendedor.php?CI=<?php echo $CI; ?>">
    Hacer Vendedor
</a>
<?php
}
?>

<?php
if($rol != "cliente"){
?>
<a class="boton" href="cliente.php?CI=<?php echo $CI; ?>">
    Hacer Cliente
</a>
<?php
}
?>

</div>

<hr>

</div>

<?php

    }

}else{

    echo "No existen clientes registrados.";

}

$conn->close();

?>

<!-- NAVEGACIÓN -->

<div class="navegacion">

<a class="boton2" href="readtodocliente.php">
    Ver clientes
</a>

<button
class="boton2"
type="button"
onclick="history.back()">

⬅ Volver atrás

</button>

</div>

</body>
</html>