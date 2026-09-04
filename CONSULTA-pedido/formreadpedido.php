<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PEDIDO</title>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    /* Fondo sin imagen */
    background:linear-gradient(135deg, #fff5f7, #f8dfe5);
}

/* TARJETA PRINCIPAL */
.contenedor{
    width:430px;
    padding:45px 40px;

    background:#ffffff;
    border:1px solid #f1d1d9;
    border-radius:22px;

    box-shadow:
        0 20px 45px rgba(191,116,133,.20),
        0 5px 15px rgba(0,0,0,.05);
}

/* TÍTULO */
h2{
    text-align:center;
    color:#bf7485;
    font-size:30px;
    margin-bottom:35px;
    font-weight:700;
}

/* DECORACIÓN DEL TÍTULO */
h2::after{
    content:"";
    display:block;
    width:55px;
    height:4px;
    background:#c96f84;
    border-radius:10px;
    margin:10px auto 0;
}

/* ETIQUETAS */
label{
    display:block;
    margin-bottom:8px;
    color:#666;
    font-size:15px;
    font-weight:600;
}

/* CAMPOS */
input[type="text"],
input[type="number"]{
    width:100%;
    padding:14px 16px;

    border:2px solid #f0d6dc;
    border-radius:12px;

    outline:none;
    margin-bottom:22px;

    font-size:15px;
    color:#555;
    background:#fffafb;

    transition:.3s;
}

input[type="text"]:focus,
input[type="number"]:focus{
    border-color:#c96f84;
    background:#fff;
    box-shadow:0 0 0 4px rgba(201,111,132,.12);
}

/* BOTÓN */
input[type="submit"]{
    width:100%;
    padding:15px;

    border:none;
    border-radius:12px;

    background:#c96f84;
    color:white;

    font-size:16px;
    font-weight:bold;

    cursor:pointer;

    transition:.3s;

    box-shadow:0 8px 18px rgba(201,111,132,.25);
}

input[type="submit"]:hover{
    background:#b45d72;
    transform:translateY(-2px);
    box-shadow:0 12px 22px rgba(201,111,132,.30);
}

input[type="submit"]:active{
    transform:translateY(0);
}

/* ERRORES */
.error{
    color:#d85a5a;
    font-size:13px;
    margin-bottom:10px;
}

/* RESPONSIVE */
@media(max-width:500px){

    .contenedor{
        width:90%;
        padding:35px 25px;
    }

    h2{
        font-size:26px;
    }
}

</style>

</head>

<body>

<div class="contenedor">

    <h2>Consultar Pedido</h2>

    <form action="mostrarestadopedido.php">

        <label>Ingrese el nombre del producto:</label>
        <input type="text" name="Nombre" required>

        <label>Cantidad:</label>
        <input type="number" name="Cantidad" min="1" required>

        <input type="submit" value="Consultar Pedido">

    </form>

</div>

</body>
</html>