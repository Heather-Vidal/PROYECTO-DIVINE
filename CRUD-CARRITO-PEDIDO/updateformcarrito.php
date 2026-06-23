<?php
$idPedido = $_POST['idPedido'] ?? $_GET['idPedido'] ?? '';
$codigo = $_POST['codigo'] ?? $_GET['codigo'] ?? '';
$cantidad = $_POST['cantidad'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Actualizar Carrito</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:
    linear-gradient(rgba(0,0,0,0.30), rgba(0,0,0,0.30)),
    url('../imagenes/fondote.png');

    background-position:center;
    background-size:cover;
    background-repeat:no-repeat;

    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.contenedor{
    background:rgba(255,255,255,.80);
    backdrop-filter:blur(10px);
    padding:40px;
    width:420px;
    border-radius:30px;
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

h2{
    text-align:center;
    color:#bf7485;
    margin-bottom:25px;
    font-size:28px;
}

label{
    display:block;
    margin-bottom:8px;
    color:#666;
    font-weight:600;
}

input[type="number"]{
    width:100%;
    padding:12px 15px;
    border:2px solid #f0d6dc;
    border-radius:15px;
    outline:none;
    margin-bottom:20px;
    transition:.3s;
    font-size:15px;
    text-align:center;
}

input[type="number"]:focus{
    border-color:#c96f84;
    box-shadow:0 0 10px rgba(201,111,132,.25);
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

.hidden{
    display:none;
}

.error{
    color:#d85a5a;
    font-size:13px;
    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="contenedor">

<h2>ACTUALIZAR CANTIDAD</h2>

<form id="formUpdate" action="updatecarrito.php" method="POST">

    <input type="hidden" name="idPedido" value="<?php echo $idPedido ?>">
    <input type="hidden" name="codigo" value="<?php echo $codigo ?>">

    <label>Nueva cantidad</label>
    <input type="number" name="cantidad" value="<?php echo $cantidad ?>" min="1">

    <input type="submit" value="Actualizar carrito">

</form>

</div>

<script>
$(document).ready(function () {

  $("#formUpdate").validate({

    rules: {
      cantidad: {
        required: true,
        min: 1,
        digits: true
      }
    },

    messages: {
      cantidad: {
        required: "Ingresa una cantidad",
        min: "Debe ser mayor a 0",
        digits: "Solo números enteros"
      }
    }

  });

});
</script>

</body>
</html>