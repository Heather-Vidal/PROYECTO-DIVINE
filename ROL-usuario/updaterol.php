<?php

// ==================================================
// CONEXIÓN
// ==================================================

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);

if ($conn->connect_error) {

    die(
        "Error de conexión: "
        . $conn->connect_error
    );

}


// ==================================================
// TRAER TODOS LOS CLIENTES
// ==================================================

$sql = "SELECT * FROM CLIENTE";

$resultado = $conn->query($sql);

if (!$resultado) {

    die(
        "Error al consultar los clientes: "
        . $conn->error
    );

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Administrar Roles de Clientes
</title>


<style>

/* ==================================================
   GENERAL
   ================================================== */

*{

    margin:0;
    padding:0;

    box-sizing:border-box;

    font-family:'Segoe UI',sans-serif;

}


body{

    min-height:100vh;

    background:

    linear-gradient(
        rgba(0,0,0,.30),
        rgba(0,0,0,.30)
    ),

    url('../imagenes/fondote.png');

    background-position:center;

    background-repeat:no-repeat;

    background-size:cover;

    background-attachment:fixed;

    padding:40px 20px;

}


/* ==================================================
   CONTENEDOR PRINCIPAL
   ================================================== */

.contenedor{

    width:100%;

    max-width:1100px;

    margin:auto;

}


/* ==================================================
   ENCABEZADO
   ================================================== */

.linea{

    width:65px;

    height:5px;

    background:#c96f84;

    border-radius:20px;

    margin-bottom:15px;

}


.mini-titulo{

    color:#f0d6dc;

    font-size:13px;

    font-weight:600;

    letter-spacing:1px;

    margin-bottom:8px;

}


h1{

    color:white;

    font-size:34px;

    margin-bottom:8px;

}


.descripcion{

    color:#f5eeee;

    font-size:15px;

    margin-bottom:35px;

}


/* ==================================================
   TARJETA DE CADA CLIENTE
   ================================================== */

.cliente{

    background:rgba(255,255,255,.82);

    backdrop-filter:blur(8px);

    -webkit-backdrop-filter:blur(8px);

    padding:30px;

    margin-bottom:25px;

    border-radius:30px;

    box-shadow:
        0 15px 35px rgba(0,0,0,.12);

}


/* ==================================================
   CABECERA DEL CLIENTE
   ================================================== */

.cliente-cabecera{

    display:flex;

    align-items:center;

    gap:15px;

    margin-bottom:25px;

}


.icono-cliente{

    width:58px;

    height:58px;

    min-width:58px;

    border-radius:18px;

    background:#fdf5f7;

    color:#c96f84;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:28px;

}


.cliente-cabecera h2{

    color:#555;

    font-size:21px;

    margin-bottom:4px;

}


.cliente-cabecera span{

    color:#999;

    font-size:13px;

}


/* ==================================================
   DATOS
   ================================================== */

.datos{

    display:grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap:15px;

    margin-bottom:20px;

}


.dato{

    background:rgba(255,255,255,.75);

    border:2px solid #f0d6dc;

    border-radius:15px;

    padding:15px;

}


.dato strong{

    display:block;

    color:#bf7485;

    font-size:13px;

    margin-bottom:7px;

}


.dato span{

    display:block;

    color:#555;

    font-size:15px;

    font-weight:600;

    word-break:break-word;

}


/* ==================================================
   ROL / ESTADO
   ================================================== */

.estado-contenedor{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:15px;

    margin-bottom:25px;

}


.estado{

    background:#fdf5f7;

    border-radius:15px;

    padding:15px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}


.estado strong{

    color:#666;

    font-size:14px;

}


.estado span{

    color:#bf7485;

    background:white;

    padding:7px 13px;

    border-radius:50px;

    font-size:13px;

    font-weight:bold;

}


/* ==================================================
   TÍTULO DE ACCIONES
   ================================================== */

.acciones-titulo{

    color:#666;

    font-weight:600;

    margin-bottom:15px;

}


/* ==================================================
   BOTONES
   ================================================== */

.botones{

    display:flex;

    gap:15px;

}


.boton{

    flex:1;

    text-decoration:none;

    text-align:center;

    padding:14px;

    border-radius:50px;

    font-size:15px;

    font-weight:bold;

    transition:.3s;

}


.boton-admin{

    background:#c96f84;

    color:white;

    box-shadow:
        0 8px 20px rgba(201,111,132,.30);

}


.boton-admin:hover{

    background:#b45d72;

    transform:translateY(-3px);

}


.boton-vendedor{

    background:#f0d6dc;

    color:#a8586b;

}


.boton-vendedor:hover{

    background:#c96f84;

    color:white;

    transform:translateY(-3px);

}


/* ==================================================
   SIN CLIENTES
   ================================================== */

.sin-clientes{

    background:rgba(255,255,255,.82);

    backdrop-filter:blur(8px);

    padding:50px 30px;

    border-radius:30px;

    text-align:center;

}


.sin-clientes .icono{

    font-size:50px;

    color:#c96f84;

    margin-bottom:15px;

}


.sin-clientes h2{

    color:#bf7485;

    margin-bottom:8px;

}


.sin-clientes p{

    color:#888;

}


/* ==================================================
   VOLVER
   ================================================== */

.boton-volver{

    display:block;

    margin:30px auto 0;

    padding:13px 28px;

    background:white;

    color:#bf7485;

    border:2px solid #f0d6dc;

    border-radius:50px;

    font-size:14px;

    font-weight:600;

    cursor:pointer;

    transition:.3s;

}


.boton-volver:hover{

    background:#c96f84;

    color:white;

    border-color:#c96f84;

    transform:translateY(-2px);

}


/* ==================================================
   RESPONSIVE
   ================================================== */

@media(max-width:850px){

    .datos{

        grid-template-columns:
            1fr 1fr;

    }

}


@media(max-width:600px){

    body{

        padding:25px 12px;

    }


    .cliente{

        padding:22px;

        border-radius:25px;

    }


    h1{

        font-size:27px;

    }


    .datos{

        grid-template-columns:1fr;

    }


    .estado-contenedor{

        grid-template-columns:1fr;

    }


    .botones{

        flex-direction:column;

    }

}

</style>

</head>


<body>


<div class="contenedor">


<!-- ==================================================
     ENCABEZADO
     ================================================== -->

<div class="linea"></div>


<div class="mini-titulo">

    DIVINE · Gestión de clientes

</div>


<h1>

    Administrar Roles de Clientes

</h1>


<p class="descripcion">

    Administra los permisos y roles de tus clientes.

</p>



<?php

// ==================================================
// MOSTRAR TODOS LOS CLIENTES
// ==================================================

if ($resultado->num_rows > 0) {


    while ($fila = $resultado->fetch_assoc()) {


        $CI = $fila['CI'];

        $rol = $fila['rol'];

        $estado = $fila['estado'];

?>


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


<?php

    }

} else {

?>

<!-- NAVEGACIÓN -->

<div class="sin-clientes">


    <div class="icono">

        ♡

    </div>


    <h2>

        No existen clientes registrados.

    </h2>


    <p>

        Cuando registres un cliente aparecerá aquí.

    </p>


</div>


<?php

}

?>


<!-- ==================================================
     VOLVER
     ================================================== -->

<button
    class="boton-volver"
    type="button"
    onclick="history.back()"
>

    ⬅

    Volver atrás

</button>


</div>


</body>

</html>


<?php

$conn->close();

?>