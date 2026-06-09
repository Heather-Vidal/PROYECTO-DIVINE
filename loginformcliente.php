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
    background:#e9e5dd;
    font-family:'Poppins',sans-serif;
}

form{
    background:#f5e9d8;
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
        "imagen boton";

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
    color:#364e63;
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
    color:#364e63;
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

label.error{
    color:red;
    font-size:13px;
    opacity: 0.7;
}

@media(max-width:768px){

    form{
        grid-template-columns:1fr;
        grid-template-areas:
            "imagen"
            "titulo"
            "campos"
            "boton";
    }

    .imagen{
        min-height:180px;
    }
}

</style>
</head>
<body>

<form id="loginForm" action="loginconectioncliente.php" method="POST">

    <div class="imagen"></div>

    <h2>INICIAR SESIÓN</h2>

    <div class="campos">

        <label>Usuario</label>
        <input type="text" name="usuario" id="usuario">

        <label>CI</label>
        <input type="password" name="CI" id="password">

    </div>

    <input type="submit" value="Ingresar">

</form>

<script>

$("#loginForm").validate({

    rules:{
        usuario:{
            required:true,
            minlength:4
        },

        password:{
            required:true,
            minlength:6
        }
    },

    messages:{
        usuario:{
            required:"Ingrese su usuario",
            minlength:"Mínimo 4 caracteres"
        },

        password:{
            required:"Ingrese su contraseña",
            minlength:"Mínimo 6 caracteres"
        }
    }

});

</script>

</body>
</html>