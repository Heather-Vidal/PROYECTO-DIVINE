<?php
    session_start();
    $vendedor=$_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nuevo Pedido</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f8eef0;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.contenedor{
    background:white;
    padding:40px;
    width:450px;
    border-radius:30px;
    box-shadow:0 15px 35px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    color:#bf7485;
    margin-bottom:30px;
    font-size:30px;
}

label{
    display:block;
    margin-bottom:8px;
    color:#666;
    font-weight:600;
}

input[type="text"],
input[type="date"]{
    width:100%;
    padding:12px 15px;
    border:2px solid #f0d6dc;
    border-radius:15px;
    outline:none;
    margin-bottom:20px;
    transition:.3s;
    font-size:15px;
}

input[type="text"]:focus,
input[type="date"]:focus{
    border-color:#c96f84;
    box-shadow:0 0 10px rgba(201,111,132,.2);
}

input[readonly]{
    background:#fdf5f7;
    color:#bf7485;
    font-weight:bold;
}

input[type="submit"]{
    width:100%;
    background:#c96f84;
    color:white;
    border:none;
    padding:15px;
    border-radius:50px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
    box-shadow:0 8px 20px rgba(201,111,132,.35);
}

input[type="submit"]:hover{
    background:#b45d72;
    transform:translateY(-3px);
}

</style>

</head>
<body>

<div class="contenedor">

    <h2>AGREGA EL PRODUCTO</h2>

    <form action="createpedido.php" method="POST">

        <label>Nombre:</label>
        <input type="text" name="nombre">

        <label>Fecha:</label>
        <input type="date" name="fecha">

        <input type="hidden" name="estado" value="En Proceso">

        <label>Nombre Vendedor:</label>
        <input type="text" name="nombrevendedor" value="<?php echo $vendedor?>" readonly>

        <input type="submit" value="Nuevo Pedido">

    </form>

</div>

</body>
</html>