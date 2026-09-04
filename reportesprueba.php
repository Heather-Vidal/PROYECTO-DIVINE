<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$baseDeDatos = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $baseDeDatos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el rol actual desde la sesión
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

if ($rol == 'administrador') {
    $sql = "SELECT v.id, v.estado, v.metodo, v.costototal, v.PEDIDOS_ID, p.fecha 
            FROM VENTAS v 
            INNER JOIN PEDIDOS p ON p.ID = v.PEDIDOS_ID 
            WHERE v.estado = 'Entregado'";
} elseif ($rol == 'vendedor') {
    $nombre = $_SESSION['nombre'];
    $sql = "SELECT v.id, v.estado, v.metodo, v.costototal, v.PEDIDOS_ID, p.fecha 
            FROM VENTAS v 
            INNER JOIN PEDIDOS p ON p.ID = v.PEDIDOS_ID 
            WHERE p.nombrevendedor = '$nombre'";
} else {
    $sql = "SELECT * FROM VENTAS WHERE 1=0";
}

$result = $conn->query($sql);

// Función reutilizable para consultar los totales por rango de fechas
function obtenerTotal($conn, $intervalo = null) {
    if ($intervalo === 'HOY') {
        $where = "WHERE p.fecha = CURDATE()";
    } elseif ($intervalo) {
        $where = "WHERE p.fecha >= DATE_SUB(CURDATE(), INTERVAL $intervalo)";
    } else {
        $where = "";
    }

    $query = "SELECT SUM(v.costototal) as total 
              FROM VENTAS v 
              INNER JOIN PEDIDOS p ON p.ID = v.PEDIDOS_ID $where";
              
    $res = $conn->query($query)->fetch_assoc();
    return $res['total'] ?? 0;
}

$totalventadia    = obtenerTotal($conn, 'HOY');
$totalventasemana = obtenerTotal($conn, '7 DAY');
$totalventames    = obtenerTotal($conn, '30 DAY');
$totalventaanio   = obtenerTotal($conn, '365 DAY');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingresos</title>
    <!-- Fuente elegante de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Variables de Colores Rosados */
        :root {
            --rosa-principal: #ff6b8b;
            --rosa-secundario: #ff8ea5;
            --rosa-oscuro: #d81b60;
            --rosa-pastel: #ffe6eb;
            --rosa-hover: #e91e63;
            --fondo-gradiente: linear-gradient(135deg, #fff0f3 0%, #ffe3e8 100%);
            --texto-oscuro: #4a2c35;
            --sombra-suave: 0 10px 25px rgba(255, 107, 139, 0.15);
            --sombra-fuerte: 0 15px 30px rgba(216, 27, 96, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--fondo-gradiente);
            color: var(--texto-oscuro);
            min-height: 100vh;
            padding: 20px;
        }

        /* Animación de Entrada General */
        .aparicion {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Encabezado */
        #separador-ingresos {
            text-align: center;
            margin: 20px 0 30px 0;
        }

        #titseparador-ingresos {
            color: var(--rosa-oscuro);
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            padding-bottom: 8px;
        }

        #titseparador-ingresos::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 4px;
            background: var(--rosa-principal);
            bottom: 0;
            left: 20%;
            border-radius: 10px;
        }

        /* Contenedor Principal */
        #centro-reporte {
            max-width: 1200px;
            margin: 0 auto;
            padding: 10px;
        }

        /* Tarjetas de Resumen */
        .tarjetas-ingresos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .tarjeta-ingreso {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: var(--sombra-suave);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .tarjeta-ingreso::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--rosa-principal), var(--rosa-secundario));
        }

        .tarjeta-ingreso:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--sombra-fuerte);
            background: #ffffff;
        }

        .tarjeta-ingreso h3 {
            color: #884d5c;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .tarjeta-ingreso p {
            color: var(--rosa-oscuro);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .tarjeta-ingreso p::before {
            content: '$ ';
            font-size: 1.3rem;
            color: var(--rosa-secundario);
        }

        /* Tabla de Ingresos */
        #tabla-ingresos {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            margin-top: 10px;
        }

        #tabla-ingresos th {
            background-color: var(--rosa-oscuro);
            color: white;
            padding: 16px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        #tabla-ingresos th:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        #tabla-ingresos th:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        #tabla-ingresos tr.aparicion {
            transition: all 0.3s ease;
        }

        #tabla-ingresos td {
            background-color: #ffffff;
            padding: 16px 20px;
            font-size: 0.95rem;
            text-align: center;
            color: var(--texto-oscuro);
            border-top: 1px solid rgba(255, 182, 193, 0.3);
            border-bottom: 1px solid rgba(255, 182, 193, 0.3);
        }

        #tabla-ingresos td:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            border-left: 1px solid rgba(255, 182, 193, 0.3);
            font-weight: 600;
        }

        #tabla-ingresos td:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            border-right: 1px solid rgba(255, 182, 193, 0.3);
        }

        /* Efecto Hover en las Filas */
        #tabla-ingresos tbody tr:hover td {
            background-color: var(--rosa-pastel);
            transform: scale(1.005);
            transition: all 0.2s ease;
        }

        /* Botón de Acción ("Mostrar") */
        a.ver1 {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, var(--rosa-principal), var(--rosa-oscuro));
            color: white;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(216, 27, 96, 0.2);
            transition: all 0.3s ease;
        }

        a.ver1:hover {
            background: linear-gradient(135deg, var(--rosa-secundario), var(--rosa-hover));
            box-shadow: 0 6px 15px rgba(216, 27, 96, 0.4);
            transform: translateY(-2px);
        }

        a.ver1:active {
            transform: translateY(0);
        }

        /* Mensaje de Tabla Vacía */
        .zzz {
            color: #884d5c !important;
            font-style: italic;
            font-weight: 500;
            padding: 30px !important;
        }

        /* Diseño Adaptable (Responsive) */
        @media (max-width: 768px) {
            #titseparador-ingresos {
                font-size: 1.6rem;
            }

            #tabla-ingresos th, #tabla-ingresos td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }

            a.ver1 {
                padding: 6px 12px;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
<section id="separador-ingresos" class="aparicion">
    <h1 id="titseparador-ingresos">REPORTE DE INGRESOS TOTALES</h1>
</section>

<div id="centro-reporte">

    <div class="tarjetas-ingresos aparicion">
        <div class="tarjeta-ingreso">
            <h3>Hoy</h3>
            <p><?php echo number_format($totalventadia, 2); ?></p>
        </div>
        <div class="tarjeta-ingreso">
            <h3>Última semana</h3>
            <p><?php echo number_format($totalventasemana, 2); ?></p>
        </div>
        <div class="tarjeta-ingreso">
            <h3>Último mes</h3>
            <p><?php echo number_format($totalventames, 2); ?></p>
        </div>
        <div class="tarjeta-ingreso">
            <h3>Último año</h3>
            <p><?php echo number_format($totalventaanio, 2); ?></p>
        </div>
    </div>

    <table id="tabla-ingresos">
        <thead>
            <tr class="aparicion">
                <th>ID Pedido</th>
                <th>Estado</th>
                <th>Método</th>
                <th>Costo Total</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while($fila = $result->fetch_assoc()) {
                $idPedido = $fila["PEDIDOS_ID"];
                echo "<tr class='aparicion'>";
                echo "<td>" . htmlspecialchars($fila["PEDIDOS_ID"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["estado"]) . "</td>";
                echo "<td>" . htmlspecialchars($fila["metodo"]) . "</td>";
                echo "<td>$" . number_format($fila["costototal"], 2) . "</td>";
                echo "<td>" . htmlspecialchars($fila["fecha"]) . "</td>";
                echo "<td>";
                echo "<a class='ver1' href='readunopedido.php?idpedidos=$idPedido'>Mostrar</a>";
                echo "</td>";    
                echo "</tr>";
            }
        } else {
            echo "<tr class='aparicion'><td colspan='6' class='zzz'>No hay pedidos registrados</td></tr>";
        }
        ?>
        </tbody>
    </table>

</div>

</body>
</html>