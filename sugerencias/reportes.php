<?php
/**
 * Reporte de Ingresos Totales - DIVINE
 * Muestra los ingresos registrados en la tabla "ventas"
 * agrupados por día, semana, mes o año.
 *
 * Requisito de la tabla "ventas":
 *   id_venta  INT
 *   fecha     DATE o DATETIME
 *   total     DECIMAL (monto de cada venta)
 *
 * Ajusta los nombres de columna en las consultas SQL si tu
 * tabla usa nombres distintos (por ejemplo "monto" en vez de "total").
 */

// ---------------------------------------------------------
// 1. Conexión a la base de datos
// ---------------------------------------------------------
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "divine_db"; // <-- cambia esto por el nombre real de tu BD

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

// ---------------------------------------------------------
// 2. Determinar qué tipo de reporte se pidió
//    (por defecto: día)
// ---------------------------------------------------------
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'dia';

// Consultas SQL según el periodo de agrupación
$consultas = [
    'dia' => "
        SELECT DATE(fecha) AS periodo,
               COUNT(*) AS cantidad_ventas,
               SUM(total) AS ingreso_total
        FROM ventas
        GROUP BY DATE(fecha)
        ORDER BY periodo DESC
    ",
    'semana' => "
        SELECT YEARWEEK(fecha, 1) AS periodo_raw,
               MIN(DATE(fecha)) AS inicio_semana,
               MAX(DATE(fecha)) AS fin_semana,
               COUNT(*) AS cantidad_ventas,
               SUM(total) AS ingreso_total
        FROM ventas
        GROUP BY YEARWEEK(fecha, 1)
        ORDER BY periodo_raw DESC
    ",
    'mes' => "
        SELECT DATE_FORMAT(fecha, '%Y-%m') AS periodo,
               COUNT(*) AS cantidad_ventas,
               SUM(total) AS ingreso_total
        FROM ventas
        GROUP BY DATE_FORMAT(fecha, '%Y-%m')
        ORDER BY periodo DESC
    ",
    'anio' => "
        SELECT YEAR(fecha) AS periodo,
               COUNT(*) AS cantidad_ventas,
               SUM(total) AS ingreso_total
        FROM ventas
        GROUP BY YEAR(fecha)
        ORDER BY periodo DESC
    ",
];

// Si el tipo pedido no existe, usar "dia" por defecto
if (!array_key_exists($tipo, $consultas)) {
    $tipo = 'dia';
}

$resultado = $conexion->query($consultas[$tipo]);

// Ingreso total general (todas las ventas, sin agrupar)
$total_general = 0;
$res_total = $conexion->query("SELECT SUM(total) AS suma FROM ventas");
if ($res_total && $fila_total = $res_total->fetch_assoc()) {
    $total_general = $fila_total['suma'] ?? 0;
}

// Etiquetas legibles para cada pestaña
$etiquetas = [
    'dia'    => 'Por Día',
    'semana' => 'Por Semana',
    'mes'    => 'Por Mes',
    'anio'   => 'Por Año',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ingresos Totales - DIVINE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #faf6f2;
            margin: 0;
            padding: 30px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #8a5a44;
        }
        .resumen {
            text-align: center;
            font-size: 1.2em;
            margin-bottom: 25px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .pestañas {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .pestañas a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 20px;
            background: #eee;
            color: #333;
            font-weight: bold;
            transition: 0.2s;
        }
        .pestañas a.activo {
            background: #8a5a44;
            color: #fff;
        }
        table {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #8a5a44;
            color: #fff;
        }
        tr:hover {
            background: #f9f2ee;
        }
        .sin-datos {
            text-align: center;
            margin-top: 30px;
            color: #999;
        }
    </style>
</head>
<body>

    <h1>Reporte de Ingresos Totales - DIVINE</h1>

    <div class="resumen">
        Ingreso total registrado (todas las ventas):<br>
        <strong>Bs. <?php echo number_format($total_general, 2); ?></strong>
    </div>

    <div class="pestañas">
        <?php foreach ($etiquetas as $clave => $texto): ?>
            <a href="?tipo=<?php echo $clave; ?>"
               class="<?php echo $tipo === $clave ? 'activo' : ''; ?>">
                <?php echo $texto; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <?php if ($tipo === 'semana'): ?>
                        <th>Semana (inicio - fin)</th>
                    <?php else: ?>
                        <th>Periodo</th>
                    <?php endif; ?>
                    <th>Cantidad de Ventas</th>
                    <th>Ingreso Total (Bs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <?php if ($tipo === 'semana'): ?>
                            <td><?php echo $fila['inicio_semana'] . " a " . $fila['fin_semana']; ?></td>
                        <?php else: ?>
                            <td><?php echo $fila['periodo']; ?></td>
                        <?php endif; ?>
                        <td><?php echo $fila['cantidad_ventas']; ?></td>
                        <td><?php echo number_format($fila['ingreso_total'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="sin-datos">No hay ventas registradas todavía.</p>
    <?php endif; ?>

</body>
</html>
<?php $conexion->close(); ?>