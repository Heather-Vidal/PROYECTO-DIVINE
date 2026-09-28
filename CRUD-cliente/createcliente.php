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
    // No se muestra el detalle técnico del error al usuario
    die("Error de conexión con la base de datos.");
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
 
    // DATOS VISIBLES
 
    $CI = trim($_POST['CI'] ?? $_POST['ci'] ?? '');
 
    $nombre = trim($_POST['nombre'] ?? '');
 
    $direccion = trim($_POST['direccion'] ?? '');
 
    $celular = trim(
        $_POST['telefono']
        ?? $_POST['celular']
        ?? ''
    );
 
    // DATOS OCULTOS
 
    $rol = trim($_POST['rol'] ?? '');
 
    $estado = trim($_POST['estado'] ?? '');
 
    // ==========================================
    // VALIDAR DATOS
    // ==========================================
 
    if ($CI === '') {
 
        $mensaje = "El CI no fue recibido.";
        $tipoMensaje = "error";
 
    } elseif (!ctype_digit($CI)) {
 
        // CI y celular son columnas numéricas (int) en la base de datos
        $mensaje = "El CI debe contener solo números.";
        $tipoMensaje = "error";
 
    } elseif ($nombre === '') {
 
        $mensaje = "El nombre no fue recibido.";
        $tipoMensaje = "error";
 
    } elseif ($direccion === '') {
 
        $mensaje = "La dirección no fue recibida.";
        $tipoMensaje = "error";
 
    } elseif ($celular === '') {
 
        $mensaje = "El teléfono no fue recibido. Verifica que el formulario tenga name=\"telefono\" o name=\"celular\".";
        $tipoMensaje = "error";
 
    } elseif (!ctype_digit($celular)) {
 
        $mensaje = "El teléfono debe contener solo números.";
        $tipoMensaje = "error";
 
    } elseif ($rol === '') {
 
        $mensaje = "El rol no fue recibido. Verifica el campo hidden del formulario.";
        $tipoMensaje = "error";
 
    } elseif ($estado === '') {
 
        $mensaje = "El estado no fue recibido. Verifica el campo hidden del formulario.";
        $tipoMensaje = "error";
 
    } else {
 
        // Convertir a entero los datos que deben ser numéricos
        $CI = (int) $CI;
        $celular = (int) $celular;
 
        // ==========================================
        // VERIFICAR SI EL CI YA EXISTE
        // ==========================================
 
        $consultaCI = $conn->prepare(
            "SELECT CI FROM CLIENTE WHERE CI = ?"
        );
 
        if (!$consultaCI) {
 
            $mensaje = "Error al preparar la consulta del CI.";
 
            $tipoMensaje = "error";
 
        } else {
 
            // i = entero
            $consultaCI->bind_param(
                "i",
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
 
            } else {
 
                // ==========================================
                // INSERTAR CLIENTE
                // ==========================================
 
                $sql = "INSERT INTO CLIENTE
                        (CI, nombre, direccion, celular, rol, estado)
                        VALUES (?, ?, ?, ?, ?, ?)";
 
                $stmt = $conn->prepare($sql);
 
                if (!$stmt) {
 
                    $mensaje = "Error al preparar el registro.";
 
                    $tipoMensaje = "error";
 
                } else {
 
                    // i = entero, s = texto
                    // CI=i, nombre=s, direccion=s, celular=i, rol=s, estado=s
                    $stmt->bind_param(
                        "ississ",
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
 
                        $mensaje = "USUARIO REGISTRADO CORRECTAMENTE";
                        $tipoMensaje = "exito";
 
                    } else {
 
                        // No se muestra el detalle técnico del error al usuario
                        $mensaje = "Error al registrar el usuario.";
 
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
 
<title>Registro | DIVINE</title>
 
<!-- FUENTES -->
 
<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
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
}
 
 
/* ==========================================
   BODY
========================================== */
 
body {
 
    min-height: 100vh;
 
    display: flex;
 
    justify-content: center;
 
    align-items: center;
 
    padding: 40px 20px;
 
    font-family: 'Poppins', sans-serif;
 
    background:
        radial-gradient(
            circle at 10% 20%,
            rgba(255, 225, 238, 0.95) 0%,
            transparent 30%
        ),
 
        radial-gradient(
            circle at 90% 80%,
            rgba(236, 207, 222, 0.9) 0%,
            transparent 35%
        ),
 
        linear-gradient(
            135deg,
            #f8f1f4,
            #eadce3,
            #f7eef2
        );
 
    position: relative;
 
    overflow-x: hidden;
}
 
 
/* ==========================================
   DECORACIONES DEL FONDO
========================================== */
 
body::before {
 
    content: "";
 
    position: fixed;
 
    width: 320px;
 
    height: 320px;
 
    border-radius: 50%;
 
    background: rgba(255,255,255,0.35);
 
    top: -120px;
 
    left: -100px;
 
    filter: blur(2px);
 
    pointer-events: none;
}
 
 
body::after {
 
    content: "";
 
    position: fixed;
 
    width: 250px;
 
    height: 250px;
 
    border-radius: 50%;
 
    background: rgba(255,255,255,0.3);
 
    bottom: -100px;
 
    right: -70px;
 
    pointer-events: none;
}
 
 
/* ==========================================
   CONTENEDOR PRINCIPAL
========================================== */
 
.contenedor {
 
    width: 100%;
 
    max-width: 650px;
 
    position: relative;
 
    background: rgba(255,255,255,0.72);
 
    border: 1px solid rgba(255,255,255,0.85);
 
    border-radius: 32px;
 
    padding: 50px 45px 42px;
 
    text-align: center;
 
    box-shadow:
        0 25px 70px rgba(84, 51, 68, 0.18),
        0 8px 25px rgba(84, 51, 68, 0.08);
 
    backdrop-filter: blur(18px);
 
    -webkit-backdrop-filter: blur(18px);
 
    animation: aparecer 0.8s ease forwards;
 
    overflow: hidden;
}
 
 
/* ==========================================
   DETALLE SUPERIOR
========================================== */
 
.contenedor::before {
 
    content: "";
 
    position: absolute;
 
    top: 0;
 
    left: 50%;
 
    transform: translateX(-50%);
 
    width: 130px;
 
    height: 4px;
 
    background: linear-gradient(
        90deg,
        transparent,
        #b77b98,
        transparent
    );
 
    border-radius: 20px;
}
 
 
/* ==========================================
   BRILLO
========================================== */
 
.contenedor::after {
 
    content: "";
 
    position: absolute;
 
    width: 180px;
 
    height: 180px;
 
    border-radius: 50%;
 
    background: rgba(255, 225, 238, 0.45);
 
    top: -100px;
 
    right: -70px;
 
    pointer-events: none;
}
 
 
/* ==========================================
   ICONO
========================================== */
 
.icono {
 
    width: 125px;
 
    height: 125px;
 
    object-fit: contain;
 
    margin-bottom: 18px;
 
    padding: 12px;
 
    background: rgba(255,255,255,0.55);
 
    border-radius: 50%;
 
    border: 1px solid rgba(183,123,152,0.2);
 
    box-shadow:
        0 10px 25px rgba(115, 72, 93, 0.12);
 
    transition:
        transform 0.4s ease,
        box-shadow 0.4s ease;
 
    position: relative;
 
    z-index: 2;
}
 
 
.icono:hover {
 
    transform: translateY(-5px) scale(1.04);
 
    box-shadow:
        0 15px 30px rgba(115, 72, 93, 0.18);
}
 
 
/* ==========================================
   PEQUEÑO TEXTO
========================================== */
 
.subtitulo {
 
    font-size: 11px;
 
    letter-spacing: 4px;
 
    text-transform: uppercase;
 
    color: #a06f88;
 
    margin-bottom: 8px;
 
    font-weight: 500;
}
 
 
/* ==========================================
   TITULO
========================================== */
 
.encabezado {
 
    font-family: "Playfair Display", serif;
 
    font-size: 48px;
 
    font-weight: 600;
 
    letter-spacing: 5px;
 
    color: #4d3041;
 
    margin-bottom: 8px;
 
    position: relative;
 
    z-index: 2;
}
 
 
/* ==========================================
   LINEA DECORATIVA
========================================== */
 
.linea {
 
    display: flex;
 
    align-items: center;
 
    justify-content: center;
 
    gap: 10px;
 
    margin: 8px auto 30px;
 
    color: #b77b98;
 
    font-size: 13px;
}
 
 
.linea span {
 
    width: 65px;
 
    height: 1px;
 
    background: linear-gradient(
        90deg,
        transparent,
        #c99aae
    );
}
 
 
.linea span:last-child {
 
    background: linear-gradient(
        90deg,
        #c99aae,
        transparent
    );
}
 
 
/* ==========================================
   CONTENIDO
========================================== */
 
.contenido {
 
    position: relative;
 
    z-index: 2;
 
    background: rgba(255,255,255,0.72);
 
    border: 1px solid rgba(255,255,255,0.9);
 
    border-radius: 22px;
 
    padding: 30px 25px;
 
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.8),
        0 8px 25px rgba(84,51,68,0.07);
 
}
 
 
/* ==========================================
   TEXTO DE BIENVENIDA
========================================== */
 
.texto {
 
    font-size: 14px;
 
    color: #806071;
 
    line-height: 1.8;
 
    margin-bottom: 22px;
}
 
 
/* ==========================================
   MENSAJE
========================================== */
 
.mensaje {
 
    position: relative;
 
    border-radius: 17px;
 
    padding: 23px 20px;
 
    font-size: 14px;
 
    font-weight: 500;
 
    letter-spacing: 0.3px;
 
    animation: mensajeEntrada 0.5s ease;
}
 
 
/* ==========================================
   EXITO
========================================== */
 
.exito {
 
    background:
        linear-gradient(
            135deg,
            #c58aa5,
            #a96787
        );
 
    color: white;
 
    box-shadow:
        0 10px 25px rgba(169,103,135,0.28);
}
 
 
/* ==========================================
   ERROR
========================================== */
 
.error {
 
    background:
        linear-gradient(
            135deg,
            #8e6377,
            #70495d
        );
 
    color: white;
 
    box-shadow:
        0 10px 25px rgba(112,73,93,0.25);
}
 
 
/* ==========================================
   ICONO DEL MENSAJE
========================================== */
 
.exito::before {
 
    content: "✓";
 
    display: block;
 
    margin: 0 auto 8px;
 
    width: 34px;
 
    height: 34px;
 
    line-height: 32px;
 
    border: 1px solid rgba(255,255,255,0.6);
 
    border-radius: 50%;
 
    font-size: 17px;
}
 
 
.error::before {
 
    content: "!";
 
    display: block;
 
    margin: 0 auto 8px;
 
    width: 34px;
 
    height: 34px;
 
    line-height: 32px;
 
    border: 1px solid rgba(255,255,255,0.6);
 
    border-radius: 50%;
 
    font-size: 17px;
}
 
 
/* ==========================================
   BOTONES
========================================== */
 
.botones {
 
    position: relative;
 
    z-index: 3;
 
    display: flex;
 
    justify-content: center;
 
    margin-top: 28px;
}
 
 
.boton {
 
    position: relative;
 
    overflow: hidden;
 
    min-width: 220px;
 
    padding: 14px 28px;
 
    border-radius: 50px;
 
    text-decoration: none;
 
    color: white;
 
    background:
        linear-gradient(
            135deg,
            #633d52,
            #8f5d75
        );
 
    font-size: 13px;
 
    font-weight: 500;
 
    letter-spacing: 0.7px;
 
    box-shadow:
        0 10px 25px rgba(99,61,82,0.25);
 
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
 
    display: inline-flex;
 
    justify-content: center;
 
    align-items: center;
 
    gap: 10px;
}
 
 
.boton::before {
 
    content: "";
 
    position: absolute;
 
    top: 0;
 
    left: -100%;
 
    width: 60%;
 
    height: 100%;
 
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.25),
        transparent
    );
 
    transform: skewX(-20deg);
 
    transition: left 0.6s ease;
}
 
 
.boton:hover::before {
 
    left: 130%;
}
 
 
.boton:hover {
 
    transform: translateY(-3px);
 
    box-shadow:
        0 15px 30px rgba(99,61,82,0.32);
}
 
 
/* ==========================================
   FRASE INFERIOR
========================================== */
 
.frase {
 
    margin-top: 25px;
 
    font-family: "Playfair Display", serif;
 
    font-size: 14px;
 
    font-style: italic;
 
    color: #9a7184;
 
    letter-spacing: 0.4px;
}
 
 
/* ==========================================
   PIE
========================================== */
 
.pie {
 
    margin-top: 13px;
 
    font-size: 10px;
 
    letter-spacing: 2px;
 
    text-transform: uppercase;
 
    color: #b18a9b;
}
 
 
/* ==========================================
   ANIMACIONES
========================================== */
 
@keyframes aparecer {
 
    from {
 
        opacity: 0;
 
        transform: translateY(35px) scale(0.97);
    }
 
    to {
 
        opacity: 1;
 
        transform: translateY(0) scale(1);
    }
}
 
 
@keyframes mensajeEntrada {
 
    from {
 
        opacity: 0;
 
        transform: scale(0.95);
    }
 
    to {
 
        opacity: 1;
 
        transform: scale(1);
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
 
        padding: 38px 22px 32px;
 
        border-radius: 25px;
    }
 
    .icono {
 
        width: 105px;
 
        height: 105px;
    }
 
    .encabezado {
 
        font-size: 38px;
 
        letter-spacing: 4px;
    }
 
    .contenido {
 
        padding: 24px 16px;
    }
 
    .boton {
 
        width: 100%;
 
        min-width: unset;
    }
}
 
 
@media (max-width: 400px) {
 
    .encabezado {
 
        font-size: 32px;
    }
 
    .subtitulo {
 
        font-size: 9px;
 
        letter-spacing: 3px;
    }
 
    .frase {
 
        font-size: 13px;
    }
}
 
</style>
 
</head>
 
 
<body>
 
 
<div class="contenedor">
 
 
    <!-- ICONO -->
 
    <img
        src="../imagenes/persona.png"
        class="icono"
        alt="Usuario"
    >
 
 
    <!-- SUBTITULO -->
 
    <div class="subtitulo">
 
        Cuidado • Belleza • Elegancia
 
    </div>
 
 
    <!-- TITULO -->
 
    <div class="encabezado">
 
        DIVINE
 
    </div>
 
 
    <!-- LINEA DECORATIVA -->
 
    <div class="linea">
 
        <span></span>
 
        ✦
 
        <span></span>
 
    </div>
 
 
    <!-- CONTENIDO -->
 
    <div class="contenido">
 
 
        <?php if ($mensaje !== ""): ?>
 
            <div class="mensaje <?= limpiarHTML($tipoMensaje) ?>">
 
                <?= limpiarHTML($mensaje) ?>
 
            </div>
 
        <?php else: ?>
 
            <div class="texto">
 
                Bienvenido a DIVINE.  
                Tu registro está a un paso de formar parte
                de nuestra experiencia de belleza y cuidado personal.
 
            </div>
 
        <?php endif; ?>
 
 
    </div>
 
 
    <!-- BOTÓN -->
 
    <div class="botones">
 
        <a
            href="../SESIONES/loginformcliente.php"
            class="boton"
        >
 
            <span>←</span>
 
            Volver a Iniciar Sesión
 
        </a>
 
    </div>
 
 
    <!-- FRASE -->
 
    <div class="frase">
 
        “La belleza comienza con el cuidado de ti misma.”
 
    </div>
 
 
    <!-- PIE -->
 
    <div class="pie">
 
        DIVINE · Beauty & Care
 
    </div>
 
 
</div>
 
 
</body>
 
</html>
