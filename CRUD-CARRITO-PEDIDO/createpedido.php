<?php 

session_start(); 
require_once "conexion.php"; 
 
/* ========================================== 
   RECIBIR DATOS DEL FORMULARIO 
========================================== */ 
 
$nombre    = trim($_POST["nombre"]    ?? ""); 
$fecha     = trim($_POST["fecha"]     ?? ""); 
$estado    = trim($_POST["estado"]    ?? ""); 
$telefono  = trim($_POST["telefono"]  ?? ""); 
$direccion = trim($_POST["direccion"] ?? ""); 
 
 
/* ========================================== 
   WHITELIST PARA EL ESTADO
========================================== */ 
 
$estadosValidos = ["Pendiente", "Rechazado", "Completado"]; 

if (!in_array($estado, $estadosValidos, true)) { 
    die("Estado no válido. Valor recibido: [" . $estado . "] longitud: " . strlen($estado)); 
} 
 
 
/* ========================================== 
   NOMBRE DEL VENDEDOR
========================================== */ 
 
if (isset($_SESSION['nombre'])) { 
    $nombrevendedor = $_SESSION['nombre']; 
} else { 
    $nombrevendedor = "DIVINE"; 
} 


/* ==========================================
   VALIDAR QUE EL CARRITO NO ESTÉ VACÍO
========================================== */

/*
   El pedido todavía no existe, por lo tanto
   primero revisamos si hay productos en el carrito
   que correspondan a este proceso.

   Si no hay ningún producto, no se permite
   registrar el pedido.
*/

/* 
   Si recibes un idPedido existente desde el formulario,
   lo podemos comprobar directamente.
*/
$idPedido = $_POST["idPedido"] ?? $_GET["idPedido"] ?? null;

if ($idPedido !== null && $idPedido !== "") {

    if (!filter_var($idPedido, FILTER_VALIDATE_INT) || $idPedido <= 0) {

        echo "<script>
                alert('⚠️ El pedido no es válido.');
                window.history.back();
              </script>";
        exit();

    }

    $sqlCarrito = "SELECT COUNT(*) AS total
                   FROM CARRITO
                   WHERE PEDIDOS_ID = ?";

    $stmtCarrito = $conn->prepare($sqlCarrito);

    if ($stmtCarrito === false) {
        die("Error al preparar la validación del carrito: " . $conn->error);
    }

    $stmtCarrito->bind_param("i", $idPedido);
    $stmtCarrito->execute();

    $resultadoCarrito = $stmtCarrito->get_result();
    $filaCarrito = $resultadoCarrito->fetch_assoc();

    $totalProductos = (int)$filaCarrito["total"];

    $stmtCarrito->close();


    /* ==========================================
       SI EL CARRITO ESTÁ VACÍO
    ========================================== */

    if ($totalProductos <= 0) {

        echo "<script>
                alert('⚠️ No puedes registrar un pedido vacío.\\n\\nAgrega al menos un producto al carrito antes de continuar.');
                window.location.href = 'formcarrito.php?idPedido=" . urlencode($idPedido) . "';
              </script>";
        exit();
    }
}


/* ========================================== 
   INSERT CON PREPARED STATEMENT 
========================================== */ 
 
$sql = "INSERT INTO PEDIDOS 
        (nombre, fecha, estado, telefono, direccion, nombrevendedor) 
        VALUES (?, ?, ?, ?, ?, ?)"; 
 
$stmt = $conn->prepare($sql); 
 
if ($stmt === false) { 
    die("Error al preparar la consulta: " . $conn->error); 
} 
 
$stmt->bind_param( 
    "ssssss", 
    $nombre, 
    $fecha, 
    $estado, 
    $telefono, 
    $direccion, 
    $nombrevendedor 
); 
 
 
/* ========================================== 
   EJECUTAR INSERT
========================================== */ 
 
if ($stmt->execute()) { 
 
    $idNuevo = (int) $conn->insert_id; 
 
    $stmt->close(); 
    $conn->close(); 
 
    header("Location: formcarrito.php?idPedido=" . urlencode($idNuevo)); 
    exit(); 
 
} else { 

    echo "Error: " . $stmt->error; 

    $stmt->close(); 
} 
 
$conn->close(); 
 
?>