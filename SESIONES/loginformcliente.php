 <!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio de Sesión - DIVINE</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>

*{
box-sizing:border-box;
}

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    background-image:url('../fondoo.png');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    font-family:'Poppins',sans-serif;
}

form{

background: rgba(255, 182, 219, 0.9);
width:850px;

max-width:95%;

padding:40px;

border-radius:20px;

box-shadow:0 10px 25px rgba(0,0,0,.25);

display:grid;

grid-template-columns:280px 1fr;

grid-template-areas:
"imagen titulo"
"imagen campos"
"imagen boton"
"extra extra";

gap:25px;

}

.imagen{

grid-area:imagen;

background:url("https://cdn-icons-png.flaticon.com/512/3106/3106921.png")
center/contain no-repeat;

min-height:300px;

}

h2{

grid-area:titulo;

margin:0;

color:#8b4f6b;

font-family:'Playfair Display',serif;

font-size:32px;

border-bottom:3px solid #c5a46d;

padding-bottom:10px;

width:fit-content;

}

.campos{

grid-area:campos;

display:flex;

flex-direction:column;

gap:15px;

}

label{

color:#8b4f6b;

font-weight:500;

}

input[type="text"],
input[type="password"]{

width:100%;

padding:12px;

border:1px solid #ccb899;

border-radius:8px;

font-size:15px;

}

input:focus{

outline:none;

border-color:#364e63;

box-shadow:0 0 8px rgba(54,78,99,.3);

}

input[type="submit"]{

grid-area:boton;

padding:14px;

border:none;

border-radius:10px;

background:#364e63;

color:white;

font-size:18px;

font-weight:bold;

cursor:pointer;

transition:.3s;

}

input[type="submit"]:hover{

background:#c5a46d;

}

.botones-extra{

grid-area:extra;

display:flex;

justify-content:center;

gap:15px;

flex-wrap:wrap;

}

.btn-crear{

background:#a85a35;

color:white;

padding:12px 25px;

border:none;

border-radius:8px;

cursor:pointer;

font-size:16px;

transition:.3s;

}

.btn-crear:hover{

background:#c47e2f;

}

label.error{

color:red;

font-size:13px;

opacity:.7;

}

@media(max-width:768px){

form{

grid-template-columns:1fr;

grid-template-areas:
"imagen"
"titulo"
"campos"
"boton"
"extra";

}

.imagen{

min-height:180px;

}

.botones-extra{

flex-direction:column;

}

}

</style>

</head>

<body>

<form id="Form" action="loginconectioncliente.php" method="POST">

<div class="imagen"></div>

<h2>INICIAR SESIÓN</h2>

<div class="campos">

<label>Usuario</label> <input type="text" name="nombre" id="usuario">

<label>CI</label> <input type="password" name="CI" id="password">

</div>

<input type="submit" value="Ingresar">

<div class="botones-extra">

<button
type="button"
class="btn-crear"
 
onclick="window.location.href='../totu.php'">

⬅ Volver a Inicio
</button>

<button
type="button"
class="btn-crear"
onclick="window.location.href='../CRUD-cliente/formcliente.php'">

Crear cuenta
</button>

</div>

</form>

<script>

$("#Form").validate({

rules:{

nombre:{
required:true,
minlength:4
},

CI:{
required:true,
minlength:6
}

},

messages:{

nombre:{
required:"Ingrese su usuario",
minlength:"Mínimo 4 caracteres"
},

CI:{
required:"Ingrese su contraseña",
minlength:"Mínimo 6 caracteres"
}

}

});

</script>

</body>
</html>
