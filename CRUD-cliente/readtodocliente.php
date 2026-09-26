<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['nombre'])) {
    header("Location: loginformcliente.php");
    exit();
}

// Verificar que sea administrador
if ($_SESSION['rol'] != "administrador") {
    echo "<script>
            alert('No tienes permisos para acceder a esta página.');
            window.location.href = './SESIONES/loginformcliente.php';
          </script>";
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "DIVINE");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener clientes
$sql = "SELECT * FROM CLIENTE";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes | DIVINE</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            color: #4a3339;

            background:
                radial-gradient(circle at 10% 10%, rgba(255, 220, 228, 0.75), transparent 30%),
                radial-gradient(circle at 90% 15%, rgba(244, 211, 220, 0.65), transparent 28%),
                radial-gradient(circle at 50% 100%, rgba(255, 236, 229, 0.8), transparent 35%),
                #fffaf8;

            overflow-x: hidden;
        }

        /* =========================
           DECORACIONES DE FONDO
        ========================= */

        body::before {
            content: "";
            position: fixed;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: rgba(218, 164, 178, 0.10);
            top: -160px;
            left: -150px;
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: rgba(173, 111, 128, 0.07);
            bottom: -230px;
            right: -180px;
            z-index: -1;
        }

        /* =========================
           CONTENEDOR
        ========================= */

        .pagina {
            width: 100%;
            min-height: 100vh;
            padding: 45px 7%;
        }

        /* =========================
           TOP BAR
        ========================= */

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .marca {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo {
            width: 52px;
            height: 52px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(
                145deg,
                #c98b9d,
                #9e6274
            );

            color: white;
            font-family: 'Cormorant Garamond', serif;
            font-size: 27px;
            font-weight: 600;

            box-shadow:
                0 10px 25px rgba(145, 85, 103, 0.22);
        }

        .nombre-marca {
            line-height: 1;
        }

        .nombre-marca h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            letter-spacing: 4px;
            color: #6d414e;
            font-weight: 600;
        }

        .nombre-marca span {
            display: block;
            font-size: 8px;
            letter-spacing: 4px;
            color: #ae7b89;
            margin-top: 4px;
        }

        .usuario {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 18px;
            border: 1px solid rgba(177, 123, 137, 0.20);
            border-radius: 30px;

            background: rgba(255,255,255,0.55);
            backdrop-filter: blur(12px);

            font-size: 12px;
            color: #77535d;
        }

        .usuario-icono {
            width: 31px;
            height: 31px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f3dce2;
            color: #8f5969;
            font-size: 13px;
        }

        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 30px;

            margin-bottom: 42px;
        }

        .titulo-area {
            max-width: 700px;
        }

        .mini-titulo {
            display: flex;
            align-items: center;
            gap: 12px;

            color: #b07787;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 4px;
            text-transform: uppercase;

            margin-bottom: 10px;
        }

        .mini-titulo::before {
            content: "";
            width: 35px;
            height: 1px;
            background: #c98b9d;
        }

        .titulo-area h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(48px, 6vw, 76px);
            line-height: 0.9;
            font-weight: 500;
            color: #593842;
        }

        .titulo-area h1 em {
            color: #b87789;
            font-weight: 400;
        }

        .descripcion {
            margin-top: 17px;
            max-width: 570px;

            font-size: 13px;
            line-height: 1.8;
            color: #8a6b72;
            font-weight: 400;
        }

        /* =========================
           CONTADOR
        ========================= */

        .contador {
            min-width: 170px;
            padding: 18px 22px;

            border-radius: 18px;

            background: rgba(255,255,255,0.72);
            border: 1px solid rgba(193, 139, 153, 0.18);

            box-shadow:
                0 15px 45px rgba(111, 70, 82, 0.08);

            text-align: center;
        }

        .contador-numero {
            display: block;

            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            color: #9d6374;
            line-height: 1;
        }

        .contador-texto {
            display: block;
            margin-top: 6px;

            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #a7838c;
        }

        /* =========================
           LISTA DE CLIENTES
        ========================= */

        .clientes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 24px;
        }

        /* =========================
           TARJETA
        ========================= */

        .cliente {
            position: relative;

            padding: 27px;

            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(15px);

            border: 1px solid rgba(187, 130, 146, 0.18);
            border-radius: 27px;

            box-shadow:
                0 20px 55px rgba(99, 58, 70, 0.08);

            overflow: hidden;

            transition:
                transform 0.35s ease,
                box-shadow 0.35s ease,
                border-color 0.35s ease;
        }

        .cliente::before {
            content: "";
            position: absolute;

            width: 130px;
            height: 130px;

            border-radius: 50%;

            background: rgba(230, 187, 198, 0.17);

            top: -65px;
            right: -55px;
        }

        .cliente:hover {
            transform: translateY(-7px);

            border-color: rgba(177, 110, 128, 0.30);

            box-shadow:
                0 28px 65px rgba(99, 58, 70, 0.13);
        }

        /* =========================
           PARTE SUPERIOR TARJETA
        ========================= */

        .cliente-top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            position: relative;
            z-index: 2;

            margin-bottom: 22px;
        }

        .avatar {
            width: 62px;
            height: 62px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    145deg,
                    #f2d6de,
                    #e7bdc9
                );

            border: 5px solid #fff;

            box-shadow:
                0 7px 20px rgba(137, 78, 96, 0.15);

            font-family: 'Cormorant Garamond', serif;
            font-size: 27px;
            color: #92596a;
        }

        .cliente-numero {
            font-size: 9px;
            letter-spacing: 2px;
            color: #b18c94;
        }

        /* =========================
           INFORMACIÓN
        ========================= */

        .cliente h3 {
            position: relative;
            z-index: 2;

            font-family: 'Cormorant Garamond', serif;
            font-size: 29px;
            font-weight: 600;

            color: #5d3d46;

            margin-bottom: 20px;
        }

        .dato {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 12px;

            font-size: 11px;
            color: #80656d;
        }

        .dato-icono {
            width: 31px;
            height: 31px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #f8e9ed;
            color: #a66779;

            font-size: 12px;
        }

        .dato-texto {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* =========================
           LINEA
        ========================= */

        .separador {
            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #ead4da,
                    transparent
                );

            margin: 23px 0;
        }

        /* =========================
           BOTONES
        ========================= */

        .acciones {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
        }

        .btn {
            border: none;
            text-decoration: none;

            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            font-family: 'Montserrat', sans-serif;
            font-size: 9px;
            font-weight: 600;

            letter-spacing: 0.5px;

            cursor: pointer;

            transition:
                transform 0.25s ease,
                background 0.25s ease,
                box-shadow 0.25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-ver {
            background: #f5e4e9;
            color: #92596a;
        }

        .btn-ver:hover {
            background: #edd1da;
        }

        .btn-editar {
            background: #eadde0;
            color: #76525c;
        }

        .btn-editar:hover {
            background: #dfcbd1;
        }

        .btn-eliminar {
            background: #f2d9dc;
            color: #a05c69;
        }

        .btn-eliminar:hover {
            background: #eac3ca;
        }

        /* =========================
           BOTÓN VOLVER
        ========================= */

        .volver-area {
            display: flex;
            justify-content: center;

            margin-top: 48px;
            padding-bottom: 15px;
        }

        .btn-volver {
            position: relative;

            display: flex;
            align-items: center;
            gap: 12px;

            padding: 14px 28px;

            border: 1px solid rgba(167, 105, 121, 0.25);
            border-radius: 30px;

            background: rgba(255,255,255,0.70);

            color: #805562;

            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            font-weight: 600;

            letter-spacing: 1.5px;

            cursor: pointer;

            box-shadow:
                0 12px 30px rgba(105, 61, 73, 0.07);

            transition: all 0.3s ease;
        }

        .btn-volver:hover {
            background: #a96c7e;
            color: white;

            transform: translateY(-3px);

            box-shadow:
                0 15px 35px rgba(144, 82, 101, 0.20);
        }

        /* =========================
           SIN CLIENTES
        ========================= */

        .sin-clientes {
            grid-column: 1 / -1;

            padding: 70px 20px;

            text-align: center;

            border-radius: 30px;

            background: rgba(255,255,255,0.70);
            border: 1px solid rgba(185, 129, 144, 0.15);
        }

        .sin-clientes .icono {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .sin-clientes h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 500;
            color: #704751;
        }

        .sin-clientes p {
            margin-top: 8px;
            font-size: 12px;
            color: #a0848b;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 850px) {

            .pagina {
                padding: 30px 5%;
            }

            .encabezado {
                flex-direction: column;
                align-items: flex-start;
            }

            .contador {
                width: 100%;
            }

        }

        @media (max-width: 600px) {

            .topbar {
                align-items: flex-start;
            }

            .usuario {
                display: none;
            }

            .nombre-marca h2 {
                font-size: 26px;
            }

            .titulo-area h1 {
                font-size: 52px;
            }

            .clientes {
                grid-template-columns: 1fr;
            }

            .cliente {
                padding: 23px;
            }

            .acciones {
                grid-template-columns: 1fr;
            }

            .btn {
                height: 42px;
            }
        }

    </style>
</head>

<body>

<div class="pagina">

    <!-- =========================
         TOP BAR
    ========================== -->

    <div class="topbar">

        <div class="marca">

            <div class="logo">
                D
            </div>

            <div class="nombre-marca">
                <h2>DIVINE</h2>
                <span>BEAUTY & CARE</span>
            </div>

        </div>

        <div class="usuario">

            <div class="usuario-icono">
                ♡
            </div>

            <span>
                <?php echo htmlspecialchars($_SESSION['nombre']); ?>
            </span>

        </div>

    </div>


    <!-- =========================
         ENCABEZADO
    ========================== -->

    <div class="encabezado">

        <div class="titulo-area">

            <div class="mini-titulo">
                Gestión de clientes
            </div>

            <h1>
                Nuestros <em>clientes</em>
            </h1>

            <p class="descripcion">
                Administra de manera sencilla y elegante la información
                de las personas registradas en DIVINE. Consulta sus datos,
                actualiza su información o elimina registros cuando sea necesario.
            </p>

        </div>


        <div class="contador">

            <span class="contador-numero">
                <?php echo $resultado->num_rows; ?>
            </span>

            <span class="contador-texto">
                Clientes registrados
            </span>

        </div>

    </div>


    <!-- =========================
         CLIENTES
    ========================== -->

    <div class="clientes">

        <?php

        if ($resultado->num_rows > 0) {

            $numero = 1;

            while ($fila = $resultado->fetch_assoc()) {

                $CI = $fila['CI'];
                $nombre = $fila['nombre'];
                $direccion = $fila['direccion'];
                $celular = $fila['celular'];

                // Primera letra para el avatar
                $inicial = strtoupper(substr($nombre, 0, 1));
        ?>

        <div class="cliente">

            <!-- Parte superior -->

            <div class="cliente-top">

                <div class="avatar">
                    <?php echo htmlspecialchars($inicial); ?>
                </div>

                <div class="cliente-numero">
                    CLIENTE #<?php echo str_pad($numero, 2, '0', STR_PAD_LEFT); ?>
                </div>

            </div>


            <!-- Nombre -->

            <h3>
                <?php echo htmlspecialchars($nombre); ?>
            </h3>


            <!-- Datos -->

            <div class="dato">

                <div class="dato-icono">
                    ♙
                </div>

                <div class="dato-texto">
                    CI: <?php echo htmlspecialchars($CI); ?>
                </div>

            </div>


            <div class="dato">

                <div class="dato-icono">
                    ♧
                </div>

                <div class="dato-texto">
                    <?php echo htmlspecialchars($direccion); ?>
                </div>

            </div>


            <div class="dato">

                <div class="dato-icono">
                    ☎
                </div>

                <div class="dato-texto">
                    <?php echo htmlspecialchars($celular); ?>
                </div>

            </div>


            <div class="separador"></div>


            <!-- Acciones -->

            <div class="acciones">

                <a
                    href="readunocliente.php?CI=<?php echo urlencode($CI); ?>"
                    class="btn btn-ver">
                    VER
                </a>

                <a
                    href="updateformcliente.php?CI=<?php echo urlencode($CI); ?>"
                    class="btn btn-editar">
                    EDITAR
                </a>

                <button
                    type="button"
                    class="btn btn-eliminar"
                    onclick="confirmarEliminacion('<?php echo htmlspecialchars($CI, ENT_QUOTES); ?>')">
                    ELIMINAR
                </button>

            </div>

        </div>

        <?php

                $numero++;

            }

        } else {

        ?>

            <div class="sin-clientes">

                <div class="icono">
                    ♡
                </div>

                <h2>
                    Aún no hay clientes registrados
                </h2>

                <p>
                    Los clientes que registres aparecerán aquí.
                </p>

            </div>

        <?php

        }

        ?>

    </div>


    <!-- =========================
         VOLVER
    ========================== -->

    <div class="volver-area">

        <button
            class="btn-volver"
            onclick="window.location.href='../admin.php';">

            ←
            VOLVER AL PERFIL

        </button>

    </div>

</div>


<script>

function confirmarEliminacion(CI) {

    Swal.fire({

        title: '¿Eliminar cliente?',

        text: 'Esta acción eliminará el registro del cliente.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Sí, eliminar',

        cancelButtonText: 'Cancelar',

        reverseButtons: true,

        background: '#fffaf8',

        color: '#593842',

        confirmButtonColor: '#a96c7e',

        cancelButtonColor: '#d9c3c9',

        customClass: {

            popup: 'divine-alert'

        }

    }).then((resultado) => {

        if (resultado.isConfirmed) {

            window.location.href =
                'deletecliente.php?CI=' + encodeURIComponent(CI);

        }

    });

}

</script>

</body>
</html>

<?php
$conexion->close();
?>