<?php

$servidor="localhost";
$usuario="root";
$contraseña="";
$nombreBD="DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);

if($conn->connect_error){
    echo "OCURRiO UN ERROR SORRYYYYYYYYYYYY UnU";
}

// =====================================================
// RECIBIR CÓDIGO
// =====================================================

$codigo = $_GET['codigo'] ?? null;

// =====================================================
// CONSULTAR PRODUCTO
// =====================================================

$sql = "SELECT * FROM PRODUCTO WHERE codigo=$codigo";
$resultado = $conn->query($sql);

if($resultado && $resultado->num_rows > 0){

// =====================================================
// BUSCAR IMAGEN DEL PRODUCTO
// =====================================================

$nombreArchivo = "p-" . $codigo;
$directorio = "../PRODUCTO-img/";

$extensiones = [
    "jpg",
    "jpeg",
    "png",
    "gif"
];

$imagenProducto = null;

foreach($extensiones as $extension){
    $ruta = $directorio . $nombreArchivo . "." . $extension;

    if(file_exists($ruta)){
        $imagenProducto = $ruta;
        break;
    }
}

// =====================================================
// SI NO ENCUENTRA IMAGEN USA UNA DE RESPALDO
// =====================================================

if($imagenProducto === null){
    $imagenProducto = "https://i.pinimg.com/1200x/43/31/47/433147cd3e9cdb74e27685ddbace85e8.jpg";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Detalle del Producto - DIVINE</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet"/>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

/* =====================================================
   VARIABLES - PALETA ROSA PASTEL
   ===================================================== */

:root {
    --rosa-principal: #f8a5c2;
    --rosa-claro: #fde8ed;
    --rosa-fondo: #fff0f3;
    --rosa-oscuro: #d87093;
    --texto-oscuro: #5c3c48;
    --gris-suave: #a4b0be;
    --borde: #f3d1dc;
    --blanco: #ffffff;
}

body {
    font-family: "Playfair Display", serif;
    background: linear-gradient(135deg, #fff0f3 0%, #fde8ed 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    color: var(--texto-oscuro);
}

.contenedor {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 25px;
    border: 1px solid var(--borde);
    box-shadow: 0 15px 35px rgba(248, 165, 194, 0.2);
    width: 90%;
    max-width: 700px;
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 25px;
}


/* =====================================================
   IMAGEN REAL DEL PRODUCTO
   ===================================================== */

.imagen {
    background-image: url('<?php echo htmlspecialchars($imagenProducto); ?>');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 20px;
    min-height: 300px;
    border: 1px solid var(--borde);
}


/* =====================================================
   TÍTULO
   ===================================================== */

.titulo {
    text-align: center;
    color: var(--rosa-oscuro);
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    letter-spacing: 2px;
    border-bottom: 3px solid var(--rosa-principal);
    padding-bottom: 10px;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
}


/* =====================================================
   INFORMACIÓN
   ===================================================== */

.item {
    background: var(--rosa-fondo);
    padding: 25px;
    border-radius: 20px;
    border: 1px solid var(--borde);
    box-shadow: 0 4px 15px rgba(248, 165, 194, 0.15);
    transition: transform 0.3s ease;
}

.item:hover {
    transform: translateY(-3px);
}

.item p {
    margin: 10px 0;
    color: var(--texto-oscuro);
    font-size: 17px;
}

.item span {
    font-weight: bold;
    color: var(--rosa-oscuro);
}


/* =====================================================
   BOTONES
   ===================================================== */

.botones {
    margin-top: 10px;
    text-align: center;
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.boton {
    background: var(--rosa-principal);
    color: white;
    padding: 10px 24px;
    border-radius: 28px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
}

.boton:hover {
    background: var(--rosa-oscuro);
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(216, 112, 147, 0.4);
}

.boton-eliminar {
    background: #880c73;
}

.boton-eliminar:hover {
    background: #7a456f;
}


/* =====================================================
   NAVEGACIÓN
   ===================================================== */

.navegacion {
    margin-top: 10px;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.boton2 {
    background: white;
    color: var(--rosa-oscuro);
    border: 1px solid var(--borde);
    padding: 12px 28px;
    border-radius: 28px;
    font-size: 17px;
    font-weight: 700;
    text-decoration: none;
    transition: 0.3s ease;
}

.boton2:hover {
    background: var(--rosa-claro);
    transform: scale(1.02);
    box-shadow: 0 5px 15px rgba(248, 165, 194, 0.3);
}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 768px) {
    .contenedor {
        padding: 25px;
    }

    .imagen {
        min-height: 200px;
    }
}

</style>

</head>

<body>

<div class="contenedor">

    <div class="imagen"></div>

    <h2 class="titulo">
        DETALLE DEL PRODUCTO
    </h2>

    <div class="item">

<?php
while($fila = $resultado->fetch_assoc()){
?>
        <p><span>Nombre:</span> <?php echo htmlspecialchars($fila['nombre']); ?></p>
        <p><span>Descripción:</span> <?php echo htmlspecialchars($fila['descripcion']); ?></p>
        <p><span>Categoría:</span> <?php echo htmlspecialchars($fila['categoria']); ?></p>
        <p><span>Precio:</span> Bs. <?php echo htmlspecialchars($fila['precio']); ?></p>
        <p><span>Costo:</span> Bs. <?php echo htmlspecialchars($fila['costo']); ?></p>
        <p><span>Stock:</span> <?php echo htmlspecialchars($fila['stock']); ?></p>
        <p><span>Código:</span> <?php echo htmlspecialchars($fila['codigo']); ?></p>
<?php
    $codigo = $fila['codigo'];
}
?>

    </div>

    <div class="botones">

        <a href="updateformprodu.php?codigo=<?php echo $codigo; ?>" class="boton">
            Editar
        </a>

        <button type="button" class="boton boton-eliminar" onclick="confirmarEliminacion('<?php echo $codigo; ?>')">
            Eliminar
        </button>

    </div>

    <div class="navegacion">

        <a href="readtodoprodu.php" class="boton2">
            Ver productos
        </a>

        <a href="../totu.php" class="boton2">
            ⬅ Volver al inicio
        </a>

    </div>

</div>

<script>
function confirmarEliminacion(codigo) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d87093",
        cancelButtonColor: "#a4b0be",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "deleteprodu.php?codigo=" + codigo;
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