<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);

if ($conn->connect_error) {
    die("Error de conexión.");
}

$CI = $_GET['CI'] ?? '';
$CI = $conn->real_escape_string($CI);

$sql = "SELECT * FROM CLIENTE WHERE CI='$CI'";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $CI = $fila['CI'];
    $estado = $fila['estado'];
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>DIVINE | Cliente</title>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

/* =========================
   GENERAL
========================= */

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    min-height: 100vh;

    font-family: "Montserrat", sans-serif;

    background:
        linear-gradient(
            120deg,
            rgba(35, 20, 29, .92),
            rgba(82, 43, 57, .82)
        ),
        url("../imagenes/dudu.png") center / cover fixed;

    display: flex;

    align-items: center;
    justify-content: center;

    padding: 30px;

    color: #fff;

}


/* =========================
   CONTENEDOR
========================= */

.contenedor {

    width: 100%;

    max-width: 950px;

    min-height: 580px;

    display: grid;

    grid-template-columns: 35% 65%;

    background: rgba(42, 25, 34, .94);

    border: 1px solid rgba(220, 176, 144, .45);

    box-shadow:
        0 30px 80px rgba(0,0,0,.55);

    border-radius: 8px;

    overflow: hidden;

    position: relative;

}


/* =========================
   LADO IZQUIERDO
========================= */

.lado-izquierdo {

    background:
        linear-gradient(
            145deg,
            rgba(105, 54, 73, .95),
            rgba(45, 26, 36, .98)
        );

    display: flex;

    flex-direction: column;

    justify-content: center;

    align-items: center;

    text-align: center;

    padding: 45px 30px;

    border-right: 1px solid rgba(218, 170, 136, .35);

}


.marca {

    font-family: "Cormorant Garamond", serif;

    font-size: 21px;

    letter-spacing: 8px;

    color: #dcb090;

    margin-bottom: 35px;

}


.imagen {

    width: 190px;

    height: 190px;

    border-radius: 50%;

    background:
        url("../imagenes/persona.png") center / contain no-repeat,
        linear-gradient(
            145deg,
            #b8758b,
            #5a3344
        );

    border: 1px solid #dcb090;

    box-shadow:
        0 0 0 10px rgba(220,176,144,.06),
        0 15px 40px rgba(0,0,0,.4);

    margin-bottom: 30px;

}


.frase {

    font-family: "Cormorant Garamond", serif;

    font-size: 22px;

    color: #ead6cb;

    line-height: 1.5;

}


.decoracion {

    width: 55px;

    height: 1px;

    background: #dcb090;

    margin: 20px auto;

}


/* =========================
   LADO DERECHO
========================= */

.lado-derecho {

    padding: 50px 55px;

    background: #fffaf8;

    color: #442b35;

}


.pequeno-titulo {

    color: #a36b7d;

    font-size: 11px;

    letter-spacing: 4px;

    text-transform: uppercase;

    margin-bottom: 8px;

}


.titulo {

    font-family: "Cormorant Garamond", serif;

    font-size: 46px;

    font-weight: 600;

    color: #472c38;

    margin: 0;

}


.linea {

    width: 70px;

    height: 2px;

    background: #b57a68;

    margin: 15px 0 35px;

}


/* =========================
   INFORMACIÓN
========================= */

.informacion {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 16px;

}


.item {

    background: #f8eeed;

    border: 1px solid #ead8d7;

    padding: 18px 20px;

    border-radius: 4px;

    transition: .3s;

}


.item:hover {

    transform: translateY(-3px);

    border-color: #c79691;

    box-shadow:
        0 8px 20px rgba(82,43,57,.10);

}


.etiqueta {

    display: block;

    color: #a36b7d;

    font-size: 10px;

    letter-spacing: 2px;

    text-transform: uppercase;

    margin-bottom: 7px;

}


.valor {

    color: #472c38;

    font-size: 14px;

    font-weight: 500;

    word-break: break-word;

}


/* =========================
   ESTADO
========================= */

.estado {

    display: inline-block;

    padding: 5px 12px;

    border-radius: 2px;

    font-size: 10px;

    letter-spacing: 1px;

    font-weight: 600;

}


.activo {

    background: #dce9df;

    color: #45634e;

}


.inactivo {

    background: #ead5d8;

    color: #824b57;

}


/* =========================
   BOTONES
========================= */

.botones {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

    margin-top: 30px;

}


.boton {

    text-decoration: none;

    border: none;

    padding: 12px 19px;

    font-family: "Montserrat", sans-serif;

    font-size: 11px;

    letter-spacing: 1px;

    font-weight: 600;

    border-radius: 3px;

    cursor: pointer;

    transition: .3s;

}


/* Editar */

.editar {

    background: #7d465b;

    color: white;

}


.editar:hover {

    background: #5f3044;

    transform: translateY(-2px);

}


/* Eliminar */

.eliminar {

    background: #ead8d8;

    color: #743c49;

}


.eliminar:hover {

    background: #ddc0c2;

    transform: translateY(-2px);

}


/* Bloquear */

.bloquear {

    background: #b2876d;

    color: white;

}


.bloquear:hover {

    background: #91684f;

}


/* Desbloquear */

.desbloquear {

    background: #718875;

    color: white;

}


.desbloquear:hover {

    background: #536b58;

}


/* =========================
   NAVEGACIÓN
========================= */

.navegacion {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-top: 30px;

    padding-top: 22px;

    border-top: 1px solid #ead8d7;

}


.boton2 {

    text-decoration: none;

    color: #8b596b;

    font-size: 11px;

    letter-spacing: 1px;

    transition: .3s;

}


.boton2:hover {

    color: #472c38;

}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 750px) {

    .contenedor {

        grid-template-columns: 1fr;

    }

    .lado-izquierdo {

        padding: 35px 20px;

    }

    .imagen {

        width: 140px;

        height: 140px;

    }

    .lado-derecho {

        padding: 35px 25px;

    }

    .titulo {

        font-size: 38px;

    }

}


@media (max-width: 500px) {

    body {

        padding: 15px;

    }

    .informacion {

        grid-template-columns: 1fr;

    }

    .boton {

        flex: 1;

        text-align: center;

    }

    .navegacion {

        flex-direction: column;

        gap: 15px;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =========================
         LADO IZQUIERDO
    ========================== -->

    <div class="lado-izquierdo">

        <div class="marca">
            DIVINE
        </div>


        <div class="imagen"></div>


        <div class="decoracion"></div>


        <div class="frase">
            "Elegancia en cada detalle."
        </div>

    </div>



    <!-- =========================
         LADO DERECHO
    ========================== -->

    <div class="lado-derecho">


        <div class="pequeno-titulo">
            Perfil del cliente
        </div>


        <h1 class="titulo">
            Información
        </h1>


        <div class="linea"></div>



        <div class="informacion">


            <div class="item">

                <span class="etiqueta">
                    Identificación
                </span>

                <span class="valor">
                    <?php echo htmlspecialchars($fila['CI']); ?>
                </span>

            </div>


            <div class="item">

                <span class="etiqueta">
                    Nombre completo
                </span>

                <span class="valor">
                    <?php echo htmlspecialchars($fila['nombre']); ?>
                </span>

            </div>


            <div class="item">

                <span class="etiqueta">
                    Dirección
                </span>

                <span class="valor">
                    <?php echo htmlspecialchars($fila['direccion']); ?>
                </span>

            </div>


            <div class="item">

                <span class="etiqueta">
                    Teléfono
                </span>

                <span class="valor">
                    <?php echo htmlspecialchars($fila['celular']); ?>
                </span>

            </div>


            <div class="item">

                <span class="etiqueta">
                    Rol
                </span>

                <span class="valor">
                    <?php echo htmlspecialchars($fila['rol']); ?>
                </span>

            </div>


            <div class="item">

                <span class="etiqueta">
                    Estado
                </span>

                <?php if ($estado == 'ACTIVO') { ?>

                    <span class="estado activo">
                        ACTIVO
                    </span>

                <?php } else { ?>

                    <span class="estado inactivo">
                        <?php echo htmlspecialchars($estado); ?>
                    </span>

                <?php } ?>

            </div>


        </div>



        <!-- ACCIONES -->

        <div class="botones">


            <a
                class="boton editar"
                href="updateformcliente.php?CI=<?php echo urlencode($CI); ?>"
            >
                EDITAR
            </a>


            <a
                class="boton eliminar"
                href="deletecliente.php?CI=<?php echo urlencode($CI); ?>"
                onclick="return confirm('¿Deseas eliminar este cliente?');"
            >
                ELIMINAR
            </a>


            <?php

            if ($estado == 'ACTIVO') {

                echo '
                <a
                    class="boton bloquear"
                    href="../BLOQUEOS-usuario/bloquear.php?CI=' . urlencode($CI) . '"
                >
                    BLOQUEAR
                </a>';

            } else {

                echo '
                <a
                    class="boton desbloquear"
                    href="../BLOQUEOS-usuario/desbloquear.php?CI=' . urlencode($CI) . '"
                >
                    DESBLOQUEAR
                </a>';

            }

            ?>


        </div>



        <!-- NAVEGACIÓN -->

        <div class="navegacion">

            <a
                class="boton2"
                href="readtodocliente.php"
            >
                ← VER TODOS LOS CLIENTES
            </a>


            <button
                class="boton2"
                type="button"
                onclick="history.back()"
            >
                VOLVER ATRÁS →
            </button>

        </div>


    </div>


</div>


</body>

</html>


<?php

} else {

    echo "Cliente no encontrado.";

}

$conn->close();

?>
