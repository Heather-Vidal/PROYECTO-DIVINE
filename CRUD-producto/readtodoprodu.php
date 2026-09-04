 <?php
$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);

if($conn->connect_error){
  echo"OCURRIÓ UN ERROR SORRY UnU";
}
$sql="SELECT * FROM PRODUCTO";
$resultado=$conn-> query($sql);

  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Productos DIVINE</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f8eff1; /* Fondo rosa empolvado claro */
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  color: #4a3f43;
}

.contenedor {
  background: #ffffff; /* Blanco estilo tarjeta */
  padding: 40px;
  border-radius: 25px;
  box-shadow: 0 10px 30px rgba(166, 91, 113, 0.12);
  width: 90%;
  max-width: 1000px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 25px;
  grid-template-areas:
    "imagen titulo"
    "imagen lista"
    "imagen lista"
    "imagen lista";
}

.imagen {
  grid-area: imagen;
  background: url("../imagenes/coqui.png") center center / cover no-repeat;
  border-radius: 20px;
  min-height: 400px;
  box-shadow: inset 0 0 0 1px rgba(226, 194, 201, 0.4);
}

.titulo {
  grid-area: titulo;
  font-family: 'Playfair Display', serif;
  text-align: left;
  color: #a65b71; /* Tono rosa vino principal */
  font-size: 28px;
  font-weight: 700;
  margin: 0;
  letter-spacing: 1px;
  align-self: end;
  border-bottom: 3px solid #c87588; /* Detalle rosa medio */
  padding-bottom: 8px;
  width: fit-content;
}

.lista {
  grid-area: lista;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.item {
  background: #faf6f7; /* Rosa suave interior */
  padding: 20px;
  border-radius: 20px;
  border: 1px solid #e2c2c9;
  box-shadow: 0 4px 12px rgba(166, 91, 113, 0.08);
  transition: all 0.3s ease;
}

.item:hover {
  background: #f8eff1;
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(166, 91, 113, 0.15);
}

.item p {
  margin: 6px 0;
  color: #5a4e53;
  font-size: 15px;
}

.item span {
  font-weight: 600;
  color: #a65b71; /* Resaltado de etiquetas en rosa vino */
}

.botones {
  margin-top: 15px;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.botones button {
  background: #c87588; /* Tono rosa del botón "Descubrir Productos" */
  color: #ffffff;
  border: none;
  border-radius: 25px;
  padding: 8px 18px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
  transition: all 0.3s ease;
  box-shadow: 0 3px 10px rgba(200, 117, 136, 0.25);
}

.botones button:hover {
  background: #a65b71;
  transform: translateY(-2px);
  box-shadow: 0 5px 12px rgba(166, 91, 113, 0.35);
}

.volver {
  grid-column: span 2;
  display: flex;
  justify-content: center;
  gap: 15px;
  flex-wrap: wrap;
  margin-top: 25px;
}

.volver a {
  text-decoration: none;
  background: #a65b71; /* Tono vino para botones de navegación */
  color: #ffffff;
  padding: 12px 32px;
  border-radius: 30px;
  font-weight: 500;
  font-size: 16px;
  box-shadow: 0 4px 15px rgba(166, 91, 113, 0.3);
  transition: all 0.3s ease;
}

.volver a:hover {
  background: #c87588;
  transform: scale(1.03);
  box-shadow: 0 6px 20px rgba(200, 117, 136, 0.4);
}

@media (max-width: 768px) {
  .contenedor {
    grid-template-columns: 1fr;
    grid-template-rows: auto auto auto;
    grid-template-areas:
      "imagen"
      "titulo"
      "lista";
    padding: 25px;
  }

  .imagen {
    min-height: 200px;
  }

  .titulo {
    text-align: center;
    margin: 0 auto;
  }

  .volver {
    grid-column: span 1;
  }
}
</style>
</head>
<body>

  <div class="contenedor">
    <div class="imagen"></div>
    <h2 class="titulo">LISTA DE PRODUCTOS DIVINE</h2>
    
    <div class="lista">
<?php
if($resultado->num_rows > 0){
  while($fila=$resultado->fetch_assoc()){
    echo "<div class='item'>";
    echo "<p><span>Nombre:</span> ".$fila['nombre']."</p>";
    echo "<p><span>Descripcion:</span> ".$fila['descripcion']."</p>";
        echo "<p><span>Categoría:</span> ".$fila['categoria']."</p>";
    echo "<p><span>Precio:</span> ".$fila['precio']."</p>";
    echo "<p><span>Costo:</span> ".$fila['costo']."</p>";
    echo "<p><span>Stock:</span> ".$fila['stock']."</p>";
    echo "<p><span>Código:</span> ".$fila['codigo']."</p>";
    $codigo=$fila['codigo'];
    echo "<div class='botones'>";
    echo "<a href='readunoprodu.php?codigo=$codigo'><button>Detalles</button></a>";
    echo "<a href='updateformprodu.php?codigo=$codigo'><button>Editar</button></a>";
    echo "<a href='#'onclick='confirmarEliminacion($codigo)'><button>Eliminar</button></a>";
    echo "</div>";
    echo "</div>";
  }
?>

    </div>

    <div class="volver">
      <a href="javascript:history.back()">← Volver atrás</a>
      <a href="formularioprodu.php">＋ Registrar producto</a>
    </div>

  </div>
<script>
  function confirmarEliminacion(codigo) {
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
                "deleteprodu.php?codigo=" + codigo;
        }
    });
}
</script>
</body>
</html>
<?php
}
$conn->close();
?>


