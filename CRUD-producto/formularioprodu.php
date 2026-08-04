<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario Productos DIVINE</title>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>;

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

 
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:
    linear-gradient(rgba(0,0,0,.30),rgba(0,0,0,.30)),
    url("https://i.pinimg.com/736x/a7/f1/75/a7f1754c6dd1026573f44ed41b290a42.jpg");

    background-position:center;
    background-repeat:no-repeat;
    background-size:cover;

    display:flex;
    justify-content:center;
    align-items:center;

    min-height:100vh;
    margin:0;
}
/* FORMULARIO */
form{
    width:650px;       /* CAMBIA EL ANCHO DE LA CAJA */
    padding:40px;      /* CAMBIA EL ESPACIO INTERNO */
    min-height:300px;  /* CAMBIA LA ALTURA DE LA CAJA */

    background:rgba(255,255,255,0.5);
    backdrop-filter:blur(8px);

    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,.15);

    display:flex;
    flex-direction:column;
}

/* IMAGEN */
.imagen{
    width:100%;
    height:200px;
    background:url("https://i.pinimg.com/1200x/1f/26/54/1f26549252eb96e33b406c7f71b381f1.jpg") center center/cover no-repeat;
    border-radius:20px;
    margin-bottom:25px;
}

/* TITULO */
h2{
    text-align:center;
    color:#bf7485;
    margin-bottom:15px;
    font-size:28px;
    font-family:'Playfair Display',serif;
}

/* LEYENDA */
legend{
    text-align:center;
    color:#bf7485;
    font-size:20px;
    font-weight:bold;
    margin-bottom:20px;
    font-family:'Playfair Display',serif;
}

/* CAMPOS */
.grupo-campos{
    display:flex;
    flex-direction:column;
}

label{
    color:#666;
    font-weight:600;
    margin-bottom:8px;
}

input[type="text"],
input[type="number"]{
    width:100%;
    padding:12px 15px;
    border:2px solid #f0d6dc;
    border-radius:15px;
    outline:none;
    margin-bottom:18px;
    transition:.3s;
    font-size:15px;
}

input[type="text"]:focus,
input[type="number"]:focus{
    border-color:#c96f84;
    box-shadow:0 0 10px rgba(201,111,132,.25);
}

/* BOTÓN */
input[type="submit"]{
    width:100%;
    background:#c96f84;
    color:white;
    border:none;
    padding:15px;
    border-radius:50px;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
    box-shadow:0 8px 20px rgba(201,111,132,.35);
}

input[type="submit"]:hover{
    background:#b45d72;
    transform:translateY(-3px);
}

/* ERRORES */
.error{
    color:#d85a5a;
    font-size:14px;
    font-family:'Playfair Display',serif;
}

</style>
</head>
<body>

<form id="formprodu" action="createprodu.php" method="POST">
  <div class="imagen"></div>
  <h2>REGISTRO DE PRODUCTOS DIVINE</h2>
  <legend>PRODUCTO:</legend>

  <div class="grupo-campos">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre"  >
    |

    <label for="descripcion">Descripción:</label>
    <input type="text" name="descripcion"  >

    <label for="precio">Precio:</label>
    <input type="number" name="precio"  >

    <label for="costo">Costo:</label>
    <input type="number" name="costo"  >

    <label for="stock">Stock:</label>
    <input type="number" name="stock"  >

     <label for="codigo">Código:</label>
    <input type="number" name="codigo"  >
  </div>

  <input type="submit" value="Enviar">
</form>
<script>
$(document).ready(function(){

    $("#formprodu").validate({

        rules:{
            nombre:{
                required:true
            },
            descripcion:{
                required:true
            },
            precio:{
                required:true,
                number:true
            },
            costo:{
                required:true,
                number:true
            },
            stock:{
                required:true,
                number:true
            },
            codigo:{
                required:true,
                number:true
            }
        },

        messages:{
            nombre:{
                required:"Ingrese el nombre del producto"
            },
            descripcion:{
                required:"Ingrese la descripción"
            },
            precio:{
                required:"Ingrese el precio",
                number:"Solo se permiten números"
            },
            costo:{
                required:"Ingrese el costo",
                number:"Solo se permiten números"
            },
            stock:{
                required:"Ingrese el stock",
                number:"Solo se permiten números"
            },
            codigo:{
                required:"Ingrese el código",
                number:"Solo se permiten números"
            }
        }

    });

});
</script>

</body>
</html>
