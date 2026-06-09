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

body{
    font-family: 'Poppins', sans-serif;
    background: #e9e5dd;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 0;
    margin: 0;
}

/* FORMULARIO */
form{
    background: #f5e9d8;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    max-width: 600px;
    width: 85%;

    display: grid;
    grid-template-columns: 1fr;
    gap: 25px;
}

/* IMAGEN */
.imagen{
    background: url("https://cdn-icons-png.flaticon.com/512/3106/3106921.png") center/contain no-repeat;
    height: 220px;
}

/* TITULO */
h2{
    margin: 0;
    text-align: center;
    color: #364e63;
    font-size: 32px;
    font-family: "Playfair Display", serif;
}

legend{
    text-align: center;
    color: #c5a46d;
    font-size: 20px;
    font-weight: bold;
}

/* CAMPOS */
.grupo-campos{
    display: flex;
    flex-direction: column;
    gap: 18px;
}

label{
    color: #364e63;
    font-weight: 500;
    margin-bottom: -10px;
}

/* AQUÍ ESTABA EL ERROR */
input[type="text"],
input[type="number"],
input[type="date"]{

    padding: 14px;
    border: 1px solid #ccb899;
    border-radius: 10px;
    font-size: 15px;
    background: white;
    outline: none;
    transition: 0.3s;
}

/* EFECTO */
input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus{

    border-color: #364e63;
    box-shadow: 0 0 10px rgba(54,78,99,0.3);
    transform: scale(1.01);
}

/* BOTON */
input[type="submit"]{

    padding: 14px;
    background: #364e63;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 5px 12px rgba(0,0,0,0.25);
}

input[type="submit"]:hover{
    background: #c5a46d;
    transform: scale(1.03);
}

/* RESPONSIVE */
@media(max-width:768px){

    form{
        padding: 25px;
    }

    .imagen{
        height: 180px;
    }
}

</style>
</head>

<body>

<form action="updatecliente.php" method="POST">

    <div class="imagen"></div>

    <h2>MODIFICAR CLIENTE</h2>

    <legend>DATOS A EDITAR</legend>

    <div class="grupo-campos">

        <label>CI:</label>
        <input type="number" name="CI" value="<?= $CI ?>" required>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $nombre ?>" required>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?= $direccion ?>" required>

        <label>Teléfono:</label>
        <input type="number" name="celular" value="<?= $celular ?>" required>

        <label>Rol:</label>
        <input type="text" name="rol" value="<?= $rol ?>" required>

        <label>Estado:</label>
        <input type="text" name="estado" value="<?= $estado ?>" required>

    </div>

    <input type="submit" value="Guardar Cambios">

</form>
<script>

$(document).ready(function(){
    $("#formCliente").validate({
            rules:{
            CI:{
                required:true,
                number:true,
                minlength:7,
                
            },

            nombre:{
                required:true,
                minlength:3,
            },

            direccion:{
                required:true,
                minlength:5,
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
                minlength:"El CI debe tener al menos 7 dígitos",
                maxlength:"El CI no puede superar 12 dígitos"
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
        },
    });
});

</script>

</body>
</html>