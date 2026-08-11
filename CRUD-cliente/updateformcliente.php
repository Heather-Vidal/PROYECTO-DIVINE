 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn = new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
    die("Ocurrió un error de conexión");
}

$CI = $_GET['CI'];

$sql = "SELECT * FROM CLIENTE WHERE CI='$CI'";             
$resultado = $conn->query($sql);

if($resultado->num_rows > 0){
    while($fila = $resultado->fetch_assoc()){

        $CI = $fila['CI'];
        $nombre = $fila['nombre'];
        $direccion = $fila['direccion'];
        $celular = $fila['celular'];
        $rol = $fila['rol'];
        $estado = $fila['estado'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Cliente - DIVINE</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>

body {
    font-family: 'Poppins', sans-serif;
    background: #f8eff1; /* Fondo rosa empolvado claro */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 0;
    margin: 0;
}

/* FORMULARIO */
form {
    background: #ffffff; /* Blanco limpio como las tarjetas de la imagen */
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(166, 91, 113, 0.12);
    max-width: 600px;
    width: 85%;

    display: grid;
    grid-template-columns: 1fr;
    gap: 25px;
}

/* IMAGEN */
.imagen {
    background: url("https://cdn-icons-png.flaticon.com/512/3106/3106921.png") center/contain no-repeat;
    height: 180px;
}

/* TITULO */
h2 {
    margin: 0;
    text-align: center;
    color: #a65b71; /* Tono rosa vino principal de DIVINE */
    font-size: 32px;
    font-family: "Playfair Display", serif;
    letter-spacing: 1px;
}

legend {
    text-align: center;
    color: #c87588; /* Rosa medio */
    font-size: 18px;
    font-weight: 500;
}

/* CAMPOS */
.grupo-campos {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

label {
    color: #5a4e53; /* Gris neutro cálido para lectura cómoda */
    font-weight: 500;
    margin-bottom: -10px;
    font-size: 14px;
}

input[type="text"],
input[type="number"],
input[type="date"] {
    padding: 14px;
    border: 1px solid #e2c2c9; /* Borde rosa suave */
    border-radius: 10px;
    font-size: 15px;
    background: #faf6f7;
    outline: none;
    transition: all 0.3s ease;
    color: #4a3f43;
}

/* EFECTO FOCUS */
input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus {
    border-color: #a65b71;
    background: #ffffff;
    box-shadow: 0 0 10px rgba(166, 91, 113, 0.2);
    transform: scale(1.01);
}

/* MENSAJES DE ERROR DE VALIDACIÓN */
label.error {
    color: #b84156;
    font-size: 12px;
    margin-top: 2px;
    margin-bottom: 0;
    font-weight: 400;
}

/* BOTON */
input[type="submit"] {
    padding: 14px;
    background: #c87588; /* Color similar al botón "Descubrir Productos" */
    color: white;
    border: none;
    border-radius: 25px; /* Bordes más redondeados estilo marca cosmética */
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(200, 117, 136, 0.3);
}

input[type="submit"]:hover {
    background: #a65b71; /* Tono más oscuro al pasar el cursor */
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(166, 91, 113, 0.4);
}

/* RESPONSIVE */
@media(max-width: 768px) {
    form {
        padding: 25px;
    }

    .imagen {
        height: 150px;
    }
}

</style>
</head>

<body>

<form action="updatecliente.php" method="POST" id="formcliente">

    <div class="imagen"></div>

    <h2>MODIFICAR CLIENTE</h2>

    <legend>DATOS A EDITAR</legend>

    <div class="grupo-campos">

        <label>CI:</label>
        <input type="number" name="CI" value="<?= $CI ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $nombre ?>">

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?= $direccion ?>">

        <label>Teléfono:</label>
        <input type="number" name="celular" value="<?= $celular ?>">

        <label>Rol:</label>
        <input type="text" name="rol" value="<?= $rol ?>">

        <label>Estado:</label>
        <input type="text" name="estado" value="<?= $estado ?>">
    </div>

    <input type="submit" value="Guardar Cambios">

</form>

<script>
$(document).ready(function(){
    $("#formcliente").validate({
        rules:{
            CI:{
                required:true,
                number:true,
                minlength:7
            },
            nombre:{
                required:true,
                minlength:3
            },
            direccion:{
                required:true,
                minlength:5
            },
            celular:{
                required:true,
                number:true,
                minlength:8,
                maxlength:8
            },
            rol:{
                required:true,
                minlength:3
            },
            estado:{
                required:true,
                minlength:3
            }
        },
        messages:{
            CI:{
                required:"Ingrese el CI",
                number:"Solo se permiten números",
                minlength:"El CI debe tener al menos 7 dígitos"
            },
            nombre:{
                required:"Ingrese el nombre",
                minlength:"Debe tener al menos 3 caracteres"
            },
            direccion:{
                required:"Ingrese la dirección",
                minlength:"La dirección es demasiado corta"
            },
            celular:{
                required:"Ingrese el teléfono",
                number:"Solo se permiten números",
                minlength:"Debe tener 8 dígitos",
                maxlength:"Debe tener 8 dígitos"
            },
            rol:{
                required:"Ingrese el rol",
                minlength:"Debe tener al menos 3 caracteres"
            },
            estado:{
                required:"Ingrese el estado",
                minlength:"Debe tener al menos 3 caracteres"
            }
        }
    });
});
</script>

</body>
</html>