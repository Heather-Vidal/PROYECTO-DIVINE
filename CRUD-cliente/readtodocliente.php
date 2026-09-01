<?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
  echo"OCURRIÓ UN ERROR SORRY UnU";
}

$sql="SELECT * FROM CLIENTE";
$resultado=$conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Clientes DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
<!-- LIBRERÍA SWEETALERT2 NECESARIA PARA LAS ALERTAS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

body {
  font-family: 'Playfair Display', serif;
  background: url("../imagenes/fondu.jpg") center center / cover no-repeat;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #8f4973;
}


/* CONTENEDOR */

.contenedor {
  background: url("/imagenes/fondu.jpg") center center / cover no-repeat;
  padding: 40px;
  border-radius: 25px;
  box-shadow: 0 10px 25px rgba(124, 81, 106, 0.54);
  width: 90%;
  max-width: 1000px;

  display: grid;

  grid-template-columns: 1fr 1fr;

  grid-gap: 25px;

  grid-template-areas:
    "imagen titulo"
    "imagen lista"
    "imagen lista";
}


/* IMAGEN */

.imagen {
  grid-area: imagen;
  background: url("../imagenes/pelito.jpg")
  center center / cover no-repeat;
  border-radius: 20px;
  min-height: 400px;
}


/* TITULO */

.titulo {
  grid-area: titulo;
  text-align: left;
  color: #ff50a5;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 1px;
  margin: 0;
  align-self: end;
  border-bottom: 3px solid #cc438a;
  padding-bottom: 6px;
  width: fit-content;
}


/* LISTA */

.lista {
  grid-area: lista;

  display: flex;

  flex-direction: column;

  gap: 15px;
}


/* TARJETA DE CLIENTE */

.item {
  background: #3f1d23;
  padding: 20px;
  border-radius: 20px;
  box-shadow: 0 4px 10px rgba(96, 31, 31, 0.44);
  transition: 0.3s ease;
}


.item:hover {
  background: #f1dee9;
  transform: translateY(-5px);
}


.item p {
  margin: 6px 0;
  color: #ff4f92;
  font-size: 16px;
}


.item span {
  font-weight: bold;
  color: #ff48a3;
}


/* BOTONES */

.botones {
  margin-top: 15px;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}


.boton {
  background: #e873a0;
  color: #ffffff;
  border: none;
  border-radius: 25px;
  padding: 10px 22px;
  cursor: pointer;
  font-family: 'Playfair Display', serif;
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
  display: inline-block;
  transition: 0.3s ease;
   box-shadow: 0 3px 8px rgba(255, 1, 166, 0.3);
}


.boton:hover {
  background: #ed1da0;

  color: #fcfcfc;

  transform: scale(1.05);

  box-shadow: 0 6px 15px rgba(255, 77, 175, 0.8);
}


/* CONTENEDOR BOTÓN VOLVER */

.volver {
  grid-column: span 2;

  text-align: center;

  margin-top: 20px;
}


/* BOTÓN VOLVER */

.boton-volver {
  background: #593145;

  color: #ff0884;

  border: none;

  border-radius: 30px;

  padding: 14px 38px;

  font-family: 'Playfair Display', serif;

  font-weight: 700;

  font-size: 17px;

  cursor: pointer;

  box-shadow: 0 4px 15px rgba(69, 20, 36, 0.6);

  transition: 0.3s ease;
}


.boton-volver:hover {
  background: #ff8bd8;

  color: #ffffff;

  transform: scale(1.06);

  box-shadow: 0 6px 18px rgba(124, 73, 105, 0.8);
}


/* RESPONSIVE */

@media (max-width: 768px) {

  .contenedor {

    grid-template-columns: 1fr;

    grid-template-areas:
      "imagen"
      "titulo"
      "lista";

    padding: 25px;
  }


  .imagen {
    min-height: 220px;
  }


  .titulo {
    text-align: center;

    margin: auto;
  }


  .volver {
    grid-column: auto;
  }

}

</style>

</head>


<body>

<div class="contenedor">


  <!-- IMAGEN -->

  <div class="imagen"></div>


  <!-- TITULO -->

  <h2 class="titulo">
    LISTA DE CLIENTES
  </h2>


  <!-- LISTA DE CLIENTES -->

  <div class="lista">

<?php

if($resultado->num_rows > 0){

  while($fila=$resultado->fetch_assoc()){

    $CI=$fila['CI'];

?>

    <div class="item">

      <p>
        <span>CI:</span>
        <?php echo $fila['CI']; ?>
      </p>

      <p>
        <span>Nombre:</span>
        <?php echo $fila['nombre']; ?>
      </p>

      <p>
        <span>Dirección:</span>
        <?php echo $fila['direccion']; ?>
      </p>

      <p>
        <span>Celular:</span>
        <?php echo $fila['celular']; ?>
      </p>

      <p>
        <span>Rol:</span>
        <?php echo $fila['rol']; ?>
      </p>

      <p>
        <span>Estado:</span>
        <?php echo $fila['estado']; ?>
      </p>


      <!-- BOTONES -->

      <div class="botones">

        <a class="boton" href="readunocliente.php?CI=<?php echo $CI; ?>">
          Detalles
        </a>

        <a class="boton" href="updateformcliente.php?CI=<?php echo $CI; ?>">
          Editar
        </a>

<?php
        echo "
                    <a
                        href='#'
                        onclick='confirmarEliminacion($CI)'
                    >

                        <button class='boton'>

                            Eliminar

                        </button>

                    </a>

                    ";
?>
      </div>
    </div>
<?php
  }
} else {
  echo "<p>No hay clientes registrados.</p>";
}
?>
  </div>
  <!-- BOTÓN VOLVER -->
  <div class="volver">
    <button
      class="boton-volver"
      type="button"
      onclick="history.back()">

      ⬅ Volver atrás
    </button>
  </div>
</div>

<script>
  function confirmarEliminacion(CI) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#532e4e",
        cancelButtonColor: "#2B140D",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location =
                "deletecliente.php?CI=" + CI;
        }
    });
}
</script>

</body>
</html>
<?php
$conn->close();
?>