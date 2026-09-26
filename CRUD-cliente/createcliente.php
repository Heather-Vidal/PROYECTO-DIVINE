
<?php

// ==========================================
// CONEXIÓN A LA BASE DE DATOS
// ==========================================

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);


// ==========================================
// VERIFICAR CONEXIÓN
// ==========================================

if ($conn->connect_error) {
    die("Error de conexión con la base de datos: " . $conn->connect_error);
}


// ==========================================
// CONFIGURAR UTF-8
// ==========================================

$conn->set_charset("utf8mb4");


// ==========================================
// FUNCIÓN PARA PROTEGER TEXTO HTML
// ==========================================

function limpiarHTML($texto)
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}


// ==========================================
// VARIABLES
// ==========================================

$mensaje = "";
$tipoMensaje = "";


// ==========================================
// RECIBIR DATOS DEL FORMULARIO
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ------------------------------------------
    // DATOS VISIBLES
    // ------------------------------------------

    // Acepta CI o ci
    $CI = trim($_POST['CI'] ?? $_POST['ci'] ?? '');

    // Nombre
    $nombre = trim($_POST['nombre'] ?? '');

    // Dirección
    $direccion = trim($_POST['direccion'] ?? '');

    // ------------------------------------------
    // TELÉFONO
    // ------------------------------------------
    // Tu formulario puede estar usando:
    // name="telefono"
    // o
    // name="celular"

    $celular = trim(
        $_POST['telefono']
        ?? $_POST['celular']
        ?? ''
    );


    // ------------------------------------------
    // DATOS OCULTOS / HIDDEN
    // ------------------------------------------

    $rol = trim($_POST['rol'] ?? '');

    $estado = trim($_POST['estado'] ?? '');


    // ==========================================
    // VALIDAR DATOS RECIBIDOS
    // ==========================================

    if ($CI === '') {

        $mensaje = "El CI no fue recibido.";
        $tipoMensaje = "error";

    }

    elseif ($nombre === '') {

        $mensaje = "El nombre no fue recibido.";
        $tipoMensaje = "error";

    }

    elseif ($direccion === '') {

        $mensaje = "La dirección no fue recibida.";
        $tipoMensaje = "error";

    }

    elseif ($celular === '') {

        $mensaje = "El teléfono no fue recibido. Verifica que el formulario tenga name=\"telefono\" o name=\"celular\".";
        $tipoMensaje = "error";

    }

    elseif ($rol === '') {

        $mensaje = "El rol no fue recibido. Verifica el campo hidden del formulario.";
        $tipoMensaje = "error";

    }

    elseif ($estado === '') {

        $mensaje = "El estado no fue recibido. Verifica el campo hidden del formulario.";
        $tipoMensaje = "error";

    }

    else {


        // ==========================================
        // VERIFICAR SI EL CI YA EXISTE
        // ==========================================

        $consultaCI = $conn->prepare(
            "SELECT CI FROM CLIENTE WHERE CI = ?"
        );


        if (!$consultaCI) {

            $mensaje = "Error al preparar la consulta del CI: "
                     . $conn->error;

            $tipoMensaje = "error";

        }

        else {

            $consultaCI->bind_param(
                "s",
                $CI
            );

            $consultaCI->execute();

            $consultaCI->store_result();


            // ==========================================
            // SI EL CI YA EXISTE
            // ==========================================

            if ($consultaCI->num_rows > 0) {

                $mensaje = "El CI ingresado ya está registrado.";
                $tipoMensaje = "error";

            }

            else {


                // ==========================================
                // INSERTAR CLIENTE
                // ==========================================

                $sql = "INSERT INTO CLIENTE
                        (CI, nombre, direccion, celular, rol, estado)
                        VALUES (?, ?, ?, ?, ?, ?)";


                $stmt = $conn->prepare($sql);


                // ==========================================
                // VERIFICAR PREPARACIÓN
                // ==========================================

                if (!$stmt) {

                    $mensaje = "Error al preparar el registro: "
                             . $conn->error;

                    $tipoMensaje = "error";

                }

                else {


                    // ==========================================
                    // ENVIAR LOS 6 DATOS
                    // ==========================================

                    $stmt->bind_param(
                        "ssssss",
                        $CI,
                        $nombre,
                        $direccion,
                        $celular,
                        $rol,
                        $estado
                    );


                    // ==========================================
                    // EJECUTAR INSERT
                    // ==========================================

                    if ($stmt->execute()) {

                        $mensaje =
                            "✔ USUARIO REGISTRADO CORRECTAMENTE";

                        $tipoMensaje = "exito";

                    }

                    else {

                        $mensaje =
                            "Error al registrar el usuario: "
                            . $stmt->error;

                        $tipoMensaje = "error";
                    }


                    $stmt->close();
                }
            }


            $consultaCI->close();
        }
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Registro - DIVINE</title>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap"
    rel="stylesheet"
>


<style>

/* ==========================================
   RESETEO
   ========================================== */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;

    font-family: 'Segoe UI', sans-serif;

}


/* ==========================================
   CUERPO
   ========================================== */

body {

    background: #e9e5dd;

    display: flex;

    justify-content: center;

    align-items: center;

    min-height: 100vh;

    padding: 40px 20px;

}


/* ==========================================
   CONTENEDOR
   ========================================== */

.contenedor {

    background: rgba(255, 212, 234, 0.92);

    padding: 40px;

    border-radius: 20px;

    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.25);

    width: 90%;

    max-width: 700px;

    text-align: center;

    animation: entrada 0.7s ease;

}


/* ==========================================
   ICONO
   ========================================== */

.icono {

    width: 140px;

    margin-bottom: 20px;

    transition: 0.4s;

}


.icono:hover {

    transform: scale(1.08);

}


/* ==========================================
   ENCABEZADO
   ========================================== */

.encabezado {

    font-family: "Playfair Display", serif;

    font-size: 36px;

    font-weight: 700;

    color: #493148;

    letter-spacing: 2px;

    text-transform: uppercase;

    border-bottom: 3px solid #fc63af;

    padding-bottom: 10px;

    width: fit-content;

    margin: 0 auto 25px auto;

}


/* ==========================================
   CONTENIDO
   ========================================== */

.contenido {

    background: rgba(255, 255, 255, 0.75);

    border-radius: 15px;

    padding: 30px 25px;

    box-shadow:
        0 5px 12px rgba(0, 0, 0, 0.15);

    font-size: 16px;

    color: #63364b;

}


/* ==========================================
   MENSAJE
   ========================================== */

.mensaje {

    border-radius: 10px;

    padding: 20px;

    font-weight: 600;

    margin-bottom: 15px;

}


/* ==========================================
   ÉXITO
   ========================================== */

.exito {

    background-color: #c56d99;

    color: white;

    box-shadow:
        0 5px 12px rgba(197, 109, 153, 0.45);

}


/* ==========================================
   ERROR
   ========================================== */

.error {

    background-color: #8b4f6b;

    color: white;

    box-shadow:
        0 5px 12px rgba(139, 79, 107, 0.45);

}


/* ==========================================
   BOTONES
   ========================================== */

.botones {

    display: flex;

    justify-content: center;

    gap: 20px;

    margin-top: 25px;

}


.boton {

    text-decoration: none;

    background: #63364b;

    color: white;

    padding: 14px 30px;

    border-radius: 10px;

    font-weight: 600;

    font-size: 15px;

    box-shadow:
        0 5px 12px rgba(0, 0, 0, 0.25);

    transition: 0.3s;

    display: inline-flex;

    align-items: center;

    justify-content: center;

}


.boton:hover {

    background-color: #c56d99;

    color: white;

    transform: scale(1.03);

    box-shadow:
        0 6px 15px rgba(197, 109, 153, 0.5);

}


/* ==========================================
   ANIMACIÓN
   ========================================== */

@keyframes entrada {

    from {

        opacity: 0;

        transform: translateY(40px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


/* ==========================================
   RESPONSIVE
   ========================================== */

@media (max-width: 700px) {

    body {

        padding: 25px 15px;

    }


    .contenedor {

        width: 95%;

        padding: 25px;

    }


    .encabezado {

        font-size: 30px;

    }


    .icono {

        width: 110px;

    }


    .contenido {

        padding: 25px 15px;

    }


    .botones {

        flex-direction: column;

        gap: 15px;

    }


    .boton {

        width: 100%;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =====================================
         ICONO
         ===================================== -->

    <img
        src="../imagenes/persona.png"
        class="icono"
        alt="Usuario"
    >


    <!-- =====================================
         TITULO
         ===================================== -->

    <div class="encabezado">

        DIVINE

    </div>


    <!-- =====================================
         MENSAJE
         ===================================== -->

    <div class="contenido">

        <?php if ($mensaje !== ""): ?>

            <div class="mensaje <?= limpiarHTML($tipoMensaje) ?>">

                <?= limpiarHTML($mensaje) ?>

            </div>

        <?php endif; ?>

    </div>


    <!-- =====================================
         BOTONES
         ===================================== -->

    <div class="botones">

        <a
            href="../SESIONES/loginformcliente.php"
            class="boton"
        >
            ⬅ Iniciar Sesión
        </a>


       
    </div>


</div>


</body>

</html>
