<?php

$conexion = mysqli_connect("localhost", "root", "", "DIVINE");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$CI = $_GET['CI'] ?? '';

if ($CI == '') {
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DIVINE | Error</title>

        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: "Poppins", sans-serif;
                background: #f7eee9;
                padding: 20px;
            }

            .card {
                width: 100%;
                max-width: 500px;
                background: #fffafa;
                padding: 45px 35px;
                border-radius: 25px;
                text-align: center;
                box-shadow: 0 15px 40px rgba(90, 35, 55, 0.15);
            }

            .logo {
                font-family: "Playfair Display", serif;
                color: #8b3657;
                font-size: 24px;
                letter-spacing: 5px;
                margin-bottom: 25px;
            }

            .icon {
                width: 75px;
                height: 75px;
                margin: 0 auto 20px;
                border-radius: 50%;
                background: #f7dce5;
                color: #8b3657;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 35px;
                font-weight: bold;
            }

            h1 {
                font-family: "Playfair Display", serif;
                color: #70263f;
                font-size: 32px;
                margin-bottom: 15px;
            }

            p {
                color: #76656c;
                line-height: 1.7;
                margin-bottom: 25px;
            }

            .boton {
                display: inline-block;
                background: #8b3657;
                color: white;
                text-decoration: none;
                padding: 13px 25px;
                border-radius: 25px;
                transition: 0.3s;
            }

            .boton:hover {
                background: #70263f;
                transform: translateY(-2px);
            }
        </style>
    </head>

    <body>

        <div class="card">

            <div class="logo">DIVINE</div>

            <div class="icon">!</div>

            <h1>Datos incompletos</h1>

            <p>
                No se recibió el CI del usuario que deseas actualizar.
            </p>

            <a href="readroles.php" class="boton">
                ← Volver
            </a>

        </div>

    </body>
    </html>
    ';

    mysqli_close($conexion);
    exit();
}


/* =========================================================
   ACTUALIZAR EL ROL
   ========================================================= */

$sql = "UPDATE CLIENTE SET rol = 'vendedor' WHERE CI = ?";

$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {

    $error = true;

} else {

    mysqli_stmt_bind_param($stmt, "i", $CI);

    $resultado = mysqli_stmt_execute($stmt);

    $error = !$resultado;
}


/* =========================================================
   MOSTRAR RESULTADO
   ========================================================= */

if (!$error) {

?>

<!DOCTYPE html>

<html lang="es">

<head>

 
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Rol actualizado</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {

        min-height: 100vh;

        display: flex;
        justify-content: center;
        align-items: center;

        padding: 20px;

        font-family: "Poppins", sans-serif;

        background:
            radial-gradient(
                circle at 10% 10%,
                rgba(241, 180, 201, 0.45),
                transparent 30%
            ),
            radial-gradient(
                circle at 90% 90%,
                rgba(128, 48, 78, 0.15),
                transparent 30%
            ),
            #f7eee9;
    }


    .card {

        width: 100%;
        max-width: 540px;

        background: rgba(255, 255, 255, 0.96);

        border-radius: 28px;

        padding: 45px 35px;

        text-align: center;

        box-shadow:
            0 20px 50px rgba(91, 35, 55, 0.15);

        border: 1px solid #f5dce5;

    }


    .logo {

        font-family: "Playfair Display", serif;

        color: #8b3657;

        font-size: 23px;

        letter-spacing: 6px;

        margin-bottom: 25px;

    }


    .icono {

        width: 90px;
        height: 90px;

        margin: 0 auto 25px;

        border-radius: 50%;

        background: #f7dce5;

        border: 7px solid #fff0f4;

        color: #8b3657;

        display: flex;

        justify-content: center;
        align-items: center;

        font-size: 42px;

        font-weight: 600;

        box-shadow:
            0 10px 25px rgba(139, 54, 87, 0.15);

    }


    h1 {

        font-family: "Playfair Display", serif;

        font-size: 36px;

        color: #70263f;

        margin-bottom: 12px;

    }


    .descripcion {

        color: #76656c;

        font-size: 14px;

        line-height: 1.7;

        margin-bottom: 25px;

    }


    .usuario {

        width: 100%;

        max-width: 360px;

        margin: 0 auto 28px;

        padding: 18px;

        border-radius: 18px;

        background: #fff4f7;

        border: 1px solid #f1d3de;

    }


    .usuario-titulo {

        display: block;

        color: #a06a7f;

        font-size: 11px;

        text-transform: uppercase;

        letter-spacing: 2px;

        margin-bottom: 6px;

    }


    .ci {

        color: #70263f;

        font-size: 20px;

        font-weight: 600;

    }


    .rol {

        display: inline-block;

        margin-top: 8px;

        padding: 5px 14px;

        border-radius: 20px;

        background: #8b3657;

        color: white;

        font-size: 11px;

        font-weight: 500;

        letter-spacing: 1px;

    }


    .boton {

        display: inline-block;

        padding: 13px 28px;

        background: #8b3657;

        color: white;

        text-decoration: none;

        border-radius: 25px;

        font-size: 14px;

        font-weight: 500;

        box-shadow:
            0 8px 20px rgba(139, 54, 87, 0.22);

        transition: all 0.3s ease;

    }


    .boton:hover {

        background: #70263f;

        transform: translateY(-3px);

        box-shadow:
            0 12px 25px rgba(139, 54, 87, 0.28);

    }


    .pie {

        margin-top: 25px;

        color: #b18b99;

        font-size: 10px;

        letter-spacing: 2px;

    }


    @media (max-width: 600px) {

        .card {
            padding: 35px 22px;
        }

        h1 {
            font-size: 30px;
        }

    }

</style>
 

</head>

<body>

 
<div class="card">

    <div class="logo">
        DIVINE
    </div>

    <div class="icono">
        ✓
    </div>

    <h1>
        ¡Rol actualizado!
    </h1>

    <p class="descripcion">
        El usuario fue actualizado correctamente y ahora
        tiene permisos como vendedor dentro del sistema.
    </p>

    <div class="usuario">

        <span class="usuario-titulo">
            Usuario actualizado
        </span>

        <div class="ci">
            CI <?php echo htmlspecialchars($CI); ?>
        </div>

        <span class="rol">
            VENDEDOR
        </span>

    </div>

    <a href="updaterol.php" class="boton">
        ← Volver a administrar roles
    </a>

    <div class="pie">
        DIVINE · BEAUTY STORE
    </div>

</div>
 

</body>

</html>

<?php

} else {

?>

<!DOCTYPE html>

<html lang="es">

<head>

```
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Error</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {

        min-height: 100vh;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 20px;

        font-family: "Poppins", sans-serif;

        background: #f7eee9;
    }


    .card {

        width: 100%;
        max-width: 500px;

        padding: 45px 35px;

        background: white;

        border-radius: 28px;

        text-align: center;

        box-shadow:
            0 20px 50px rgba(91, 35, 55, 0.15);
    }


    .logo {

        font-family: "Playfair Display", serif;

        color: #8b3657;

        font-size: 23px;

        letter-spacing: 6px;

        margin-bottom: 25px;
    }


    .icono {

        width: 85px;
        height: 85px;

        margin: 0 auto 25px;

        border-radius: 50%;

        background: #f8dce5;

        color: #9a3b5e;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 40px;

        font-weight: bold;
    }


    h1 {

        font-family: "Playfair Display", serif;

        color: #70263f;

        font-size: 32px;

        margin-bottom: 15px;
    }


    p {

        color: #76656c;

        line-height: 1.7;

        font-size: 14px;

        margin-bottom: 28px;
    }


    .boton {

        display: inline-block;

        padding: 13px 28px;

        background: #8b3657;

        color: white;

        text-decoration: none;

        border-radius: 25px;

        transition: 0.3s;
    }


    .boton:hover {

        background: #70263f;

        transform: translateY(-2px);
    }

</style>
```

</head>

<body>

 
<div class="card">

    <div class="logo">
        DIVINE
    </div>

    <div class="icono">
        !
    </div>

    <h1>
        No se pudo actualizar
    </h1>

    <p>
        Ocurrió un error al intentar cambiar el rol del usuario.
        Verifica que el CI sea correcto y vuelve a intentarlo.
    </p>

    <a href="updaterol.php" class="boton">
        ← Volver a administrar roles
    </a>

</div>
 

</body>

</html>

<?php

}

if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);

?>
