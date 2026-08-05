  <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registro - DIVINE</title>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #e9e5dd;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #5e3045;
}

.contenedor {
  position: relative;
  background: rgba(255, 212, 234, 0.9);
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
  width: 90%;
  max-width: 650px;
  display: grid;
  grid-template-columns: 1fr;
  grid-template-areas:
    "encabezado"
    "contenido"
    "botones";
  gap: 25px;
}

.encabezado {
  grid-area: encabezado;
  margin: 0;
  font-size: 32px;
  color: #8b4f6b;
  font-family: "Playfair Display", serif;
  letter-spacing: 1px;
  border-bottom: 3px solid #fc63af;
  padding-bottom: 10px;
  text-align: center;
}

.contenido {
  grid-area: contenido;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.icono {
  width: 180px;
  margin-bottom: 20px;
}

.mensaje {
  width: 100%;
  max-width: 450px;
  padding: 16px;
  border-radius: 10px;
  font-size: 17px;
  font-weight: bold;
  margin-top: 10px;
  box-sizing: border-box;
}

.exito {
  background: #c56d99;
  color: #fff;
  box-shadow: 0 5px 12px rgba(197,109,153,.4);
}

.error {
  background: #b53737;
  color: #fff;
  box-shadow: 0 5px 12px rgba(181,55,55,.4);
}

.botones {
  grid-area: botones;
  display: flex;
  justify-content: center;
}

.boton {
  text-decoration: none;
  padding: 14px 35px;
  background: #63364b;
  color: #fff;
  border-radius: 10px;
  font-size: 17px;
  font-weight: bold;
  letter-spacing: 1px;
  transition: .3s;
  box-shadow: 0 5px 12px rgba(0,0,0,.25);
}

.boton:hover {
  background: #c56d99;
  transform: scale(1.03);
}

@media (max-width:768px){

  .contenedor{
    padding:25px;
  }

  .icono{
    width:140px;
  }

  .encabezado{
    font-size:28px;
  }

  .boton{
    width:100%;
    text-align:center;
  }
}
</style>

</head>

<body>

<form action="createcliente.php" method="POST">

  <div class="imagen"></div>

  <h2>CREA TU CUENTA</h2>

  <legend>DATOS PERSONALES:</legend>

  <div class="grupo-campos">

    <label for="CI"> CI: </label>
    <input type="number" name="CI"  >

    <label for="nombre"> Nombre: </label>
    <input type="text" name="nombre"  >

    <label for="direccion"> Dirección: </label>
    <input type="text" name="direccion"  >

 <label for="celular"> Teléfono: </label>
    <input type="number" name="celular"  >
 

    <label for="rol"> Rol: </label>
<select name="rol"  >
  <option value="">Seleccione un rol</option>
  <option value="cliente">cliente</option>
  <option value="vendedor">vendedor</option>
  <option value="administrador">administrador</option>
</select>
 

    <label for="estado"> Estado: </label>
    <input type="text" name="estado"  >
  </div>

  <input type="submit" value="Registrar">

</form>
<script>

$(document).ready(function () {

  $("form").validate({

    rules: {

      CI: {
        required: true,
        number: true,
        minlength: 7
      },

      nombre: {
        required: true,
        minlength: 3
      },

      direccion: {
        required: true,
        minlength: 5
      },

      celular: {
        required: true,
        number: true,
        minlength: 7,
        maxlength: 8
      },

      rol: {
        required: true
      },

      estado: {
        required: true,
        minlength: 3,
         maxlength: 44
      }

    },

    messages: {

      CI: {
        required: "Ingrese su CI",
        number: "Solo números",
        minlength: "Mínimo 7 dígitos"
      },

      nombre: {
        required: "Ingrese su nombre",
        minlength: "Mínimo 3 caracteres"
      },

      direccion: {
        required: "Ingrese su dirección",
        minlength: "Mínimo 5 caracteres"
      },

      celular: {
        required: "Ingrese su teléfono",
        number: "Solo números",
        minlength: "Mínimo 7 dígitos",
        maxlength: "Máximo 8 dígitos"
      },

      rol: {
        required: "Seleccione un rol"
      },

      estado: {
        required: "Ingrese el estado",
        minlength: "Mínimo 3 caracteres",
          maxlength: "límite de dígitos exedido"
      }

    }

  });

});
</script>
</body>
</html>