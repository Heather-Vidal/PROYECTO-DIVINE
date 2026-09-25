<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión con la base de datos.");
}

// Configurar UTF-8
$conn->set_charset("utf8mb4");

// Función para proteger texto al mostrarlo en HTML
function limpiarHTML($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ==========================================
    // 1. RECIBIR Y VALIDAR DATOS
    // ==========================================

    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $precio = $_POST['precio'] ?? '';
    $costo = $_POST['costo'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $codigo = trim($_POST['codigo'] ?? '');

    // Comprobar campos obligatorios
    if (
        $nombre === '' ||
        $descripcion === '' ||
        $categoria === '' ||
        $codigo === ''
    ) {
        $mensaje = "Todos los campos obligatorios deben estar llenos.";
        $tipoMensaje = "error";
    }

    // Comprobar números
    elseif (
        !is_numeric($precio) ||
        !is_numeric($costo) ||
        !is_numeric($stock)
    ) {
        $mensaje = "Precio, costo y stock deben ser valores numéricos.";
        $tipoMensaje = "error";
    }

    else {

        // Convertir valores numéricos
        $precio = (float)$precio;
        $costo = (float)$costo;
        $stock = (int)$stock;

        // ==========================================
        // 2. VERIFICAR LA IMAGEN
        // ==========================================

        if (
            !isset($_FILES["fileToUpload"]) ||
            $_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK
        ) {

            $mensaje = "Debes seleccionar una imagen válida.";
            $tipoMensaje = "error";

        } else {

            $archivo = $_FILES["fileToUpload"];

            // Tamaño máximo: 5 MB
            $maxSize = 5 * 1024 * 1024;

            if ($archivo["size"] > $maxSize) {

                $mensaje = "La imagen no puede superar los 5 MB.";
                $tipoMensaje = "error";

            } else {

                // Comprobar que realmente sea una imagen
                $informacionImagen = getimagesize($archivo["tmp_name"]);

                if ($informacionImagen === false) {

                    $mensaje = "El archivo seleccionado no es una imagen válida.";
                    $tipoMensaje = "error";

                } else {

                    // ==========================================
                    // 3. VALIDAR TIPO DE IMAGEN
                    // ==========================================

                    $tiposPermitidos = [
                        "image/jpeg" => "jpg",
                        "image/png"  => "png",
                        "image/gif"  => "gif"
                    ];

                    $tipoMime = $informacionImagen["mime"];

                    if (!isset($tiposPermitidos[$tipoMime])) {

                        $mensaje = "Solo se permiten imágenes JPG, PNG o GIF.";
                        $tipoMensaje = "error";

                    } else {

                        $extension = $tiposPermitidos[$tipoMime];

                        // ==========================================
                        // 4. CREAR NOMBRE DE ARCHIVO
                        // ==========================================

                        $target_dir = "../PRODUCTO-img/";

                        // Crear carpeta si no existe
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }

                        /*
                         * No usamos directamente el nombre enviado
                         * por el usuario.
                         *
                         * Utilizamos el código del producto.
                         */
                        $codigoArchivo = preg_replace(
                            "/[^a-zA-Z0-9_-]/",
                            "",
                            $codigo
                        );

                        $newFileName = "P-" . $codigoArchivo . "." . $extension;

                        $target_file = $target_dir . $newFileName;

                        // ==========================================
                        // 5. COMPROBAR SI YA EXISTE
                        // ==========================================

                        if (file_exists($target_file)) {

                            $mensaje = "Ya existe una imagen para este producto.";
                            $tipoMensaje = "error";

                        } else {

                            // ==========================================
                            // 6. CONSULTA PREPARADA
                            // ==========================================

                            $stmt = $conn->prepare(
                                "INSERT INTO PRODUCTO
                                (nombre, descripcion, categoria, precio, costo, stock, codigo)
                                VALUES (?, ?, ?, ?, ?, ?, ?)"
                            );

                            if (!$stmt) {

                                $mensaje = "Error al preparar la consulta.";
                                $tipoMensaje = "error";

                            } else {

                                /*
                                 * Tipos de datos:
                                 *
                                 * s = string
                                 * d = decimal/double
                                 * i = integer
                                 *
                                 * nombre       = s
                                 * descripcion  = s
                                 * categoria    = s
                                 * precio       = d
                                 * costo        = d
                                 * stock        = i
                                 * codigo       = s
                                 */

                                $stmt->bind_param(
                                    "sssddis",
                                    $nombre,
                                    $descripcion,
                                    $categoria,
                                    $precio,
                                    $costo,
                                    $stock,
                                    $codigo
                                );

                                // ==========================================
                                // 7. EJECUTAR INSERT
                                // ==========================================

                                if ($stmt->execute()) {

                                    // ==========================================
                                    // 8. SUBIR IMAGEN
                                    // ==========================================

                                    if (
                                        move_uploaded_file(
                                            $archivo["tmp_name"],
                                            $target_file
                                        )
                                    ) {

                                        $mensaje = "✔ PRODUCTO GUARDADO EXITOSAMENTE";
                                        $tipoMensaje = "exito";

                                        /*
                                         * Redirigir después de guardar.
                                         * El código se ejecuta solamente
                                         * si todo salió correctamente.
                                         */
                                        header("Location: readtodoprodu.php");
                                        exit;

                                    } else {

                                        /*
                                         * Si el producto se guardó pero
                                         * la imagen falló, eliminamos el
                                         * producto para evitar información
                                         * incompleta.
                                         */
                                        $idProducto = $conn->insert_id;

                                        $deleteStmt = $conn->prepare(
                                            "DELETE FROM PRODUCTO WHERE id = ?"
                                        );

                                        if ($deleteStmt) {
                                            $deleteStmt->bind_param(
                                                "i",
                                                $idProducto
                                            );
                                            $deleteStmt->execute();
                                            $deleteStmt->close();
                                        }

                                        $mensaje = "No se pudo subir la imagen. El producto no fue guardado.";
                                        $tipoMensaje = "error";
                                    }

                                } else {

                                    $mensaje = "Error al guardar el producto.";
                                    $tipoMensaje = "error";
                                }

                                $stmt->close();
                            }
                        }
                    }
                }
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<title>Guardar Producto - DIVINE</title>

<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap"
    rel="stylesheet"
/>

<style>

body {

    font-family: 'Poppins', sans-serif;

    background: #e9e5dd;

    display: flex;

    justify-content: center;

    align-items: center;

    min-height: 100vh;

    margin: 0;

    padding: 40px 0;

    color: #63364b;

    background-image: url('../imagenes/fondote.png');

    background-size: cover;

    background-position: center;

    background-repeat: no-repeat;
}


.contenedor {

    background: rgba(255, 212, 234, 0.92);

    padding: 40px;

    border-radius: 20px;

    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.25);

    width: 90%;

    max-width: 700px;

    display: grid;

    grid-template-columns: 1fr;

    grid-template-areas:
        "encabezado"
        "contenido"
        "botones";

    gap: 30px;

    text-align: center;
}


.encabezado {

    grid-area: encabezado;

    font-family: "Playfair Display", serif;

    font-size: 36px;

    font-weight: 700;

    color: #493148;

    letter-spacing: 2px;

    text-transform: uppercase;

    border-bottom: 3px solid #fc63af;

    padding-bottom: 10px;

    width: fit-content;

    margin: 0 auto;
}


.contenido {

    grid-area: contenido;

    background: rgba(255, 255, 255, 0.75);

    border-radius: 15px;

    padding: 30px 25px;

    box-shadow:
        0 5px 12px rgba(0, 0, 0, 0.15);

    font-family: 'Poppins', sans-serif;

    font-size: 16px;

    color: #63364b;
}


.mensaje {

    border-radius: 10px;

    padding: 20px;

    font-weight: 600;

    margin-bottom: 15px;

    font-family: 'Poppins', sans-serif;
}


.exito {

    background-color: #c56d99;

    color: #ffffff;

    box-shadow:
        0 5px 12px rgba(197, 109, 153, 0.45);
}


.error {

    background-color: #8b4f6b;

    color: #ffffff;

    box-shadow:
        0 5px 12px rgba(139, 79, 107, 0.45);
}


.botones {

    grid-area: botones;

    display: flex;

    justify-content: center;

    gap: 20px;
}


.boton {

    text-decoration: none;

    background: #63364b;

    color: #ffffff;

    padding: 14px 30px;

    border-radius: 10px;

    font-family: 'Poppins', sans-serif;

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

    color: #ffffff;

    transform: scale(1.03);

    box-shadow:
        0 6px 15px rgba(197, 109, 153, 0.5);
}


@media (max-width: 600px) {

    .contenedor {

        padding: 25px;

        width: 80%;
    }

    .encabezado {

        font-size: 30px;
    }

    .botones {

        flex-direction: column;

        gap: 15px;
    }

    .boton {

        width: 100%;

        box-sizing: border-box;
    }
}

</style>

</head>

<body>

<div class="contenedor">

    <div class="encabezado">
        DIVINE
    </div>

    <div class="contenido">

        <?php if ($mensaje !== ""): ?>

            <div class="mensaje <?= limpiarHTML($tipoMensaje) ?>">
                <?= limpiarHTML($mensaje) ?>
            </div>

        <?php endif; ?>

    </div>

    <div class="botones">

        <a
            href="../totu.php"
            class="boton"
        >
            ⬅ Volver al inicio
        </a>

        <a
            href="readtodoprodu.php"
            class="boton"
        >
            Ver productos ➡
        </a>

    </div>

</div>

</body>

</html>
