<?php

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


if ($conn->connect_error) {

    echo "OCURRIÓ UN ERROR SORRYYYYYYYYYYYY UnU";

}


// ==========================================
// RECIBIR ID DE LA VENTA
// ==========================================

$id = $_GET['id'];


// ==========================================
// CONSULTAR LA VENTA
// ==========================================

$sql = "SELECT * FROM VENTAS WHERE id=$id";

$resultado = $conn->query($sql);


// ==========================================
// COMPROBAR SI EXISTE
// ==========================================

if ($resultado->num_rows > 0) {

?>
<?php

session_start();

$rolUsuario = $_SESSION['rol'] ?? '';

?>
<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<title>
    Detalle de la Venta - DIVINE
</title>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
/>


<style>


/* ==========================================
   CUERPO
   ========================================== */

body {

    font-family:
        "Playfair Display",
        serif;

    background:
        linear-gradient(
            135deg,
            #fceff3,
            #f7dce4,
            #fff8fa
        );

    display:flex;

    justify-content:center;

    align-items:center;

    min-height:100vh;

    margin:0;

    color:#4a3940;

}


/* ==========================================
   CONTENEDOR
   ========================================== */

.contenedor {

    background:
        rgba(255,255,255,.94);

    padding:40px;

    border-radius:30px;

    box-shadow:
        0 18px 45px
        rgba(160,95,115,.20);

    width:90%;

    max-width:700px;

    display:grid;

    grid-template-columns:1fr;

    gap:25px;

    border:
        1px solid #f1d5de;

}


/* ==========================================
   IMAGEN / DECORACIÓN
   ========================================== */

.imagen {

    background:
        linear-gradient(
            135deg,
            #f8dce5,
            #efd0da
        );

    border-radius:22px;

    min-height:180px;

    display:flex;

    justify-content:center;

    align-items:center;

    position:relative;

    overflow:hidden;

}


/* Decoración */

.imagen::before {

    content:"♡";

    font-size:120px;

    color:
        rgba(255,255,255,.65);

    position:absolute;

}


.imagen::after {

    content:"DIVINE";

    position:absolute;

    bottom:20px;

    font-size:22px;

    letter-spacing:8px;

    color:#9d6070;

}


/* ==========================================
   TITULO
   ========================================== */

.titulo {

    text-align:center;

    color:#a75c70;

    font-size:32px;

    font-weight:700;

    margin:0;

    letter-spacing:2px;

    border-bottom:
        3px solid #dfa3b3;

    padding-bottom:10px;

    width:fit-content;

    margin-left:auto;

    margin-right:auto;

}


/* ==========================================
   TARJETA DE DATOS
   ========================================== */

.item {

    background:
        linear-gradient(
            145deg,
            #fff8fa,
            #fcecef
        );

    padding:27px;

    border-radius:22px;

    box-shadow:
        0 6px 18px
        rgba(167,92,112,.12);

    transition:
        transform .3s ease,
        box-shadow .3s ease;

    border:
        1px solid #f1d5de;

}


/* ==========================================
   EFECTO
   ========================================== */

.item:hover {

    transform:
        translateY(-5px);

    box-shadow:
        0 12px 28px
        rgba(167,92,112,.18);

}


/* ==========================================
   DATOS
   ========================================== */

.item p {

    margin:

        12px 0;

    padding:

        12px 15px;

    background:
        rgba(255,255,255,.72);

    border-radius:13px;

    color:#5b4a50;

    font-size:17px;

    border-left:
        4px solid #dfa3b3;

}


/* ==========================================
   NOMBRES DE CAMPOS
   ========================================== */

.item span {

    font-weight:bold;

    color:#a75c70;

}


/* ==========================================
   TOTAL
   ========================================== */

.total {

    font-size:20px !important;

    color:#a34f67 !important;

}


/* ==========================================
   ESTADO
   ========================================== */

.estado {

    display:inline-block;

    padding:
        6px 14px;

    border-radius:30px;

    background:#f7dce4;

    color:#a75c70 !important;

    font-weight:bold;

}


/* ==========================================
   BOTONES
   ========================================== */

.botones {

    margin-top:20px;

    text-align:center;

    display:flex;

    justify-content:center;

    gap:15px;

}


/* ==========================================
   BOTÓN PRINCIPAL
   ========================================== */

.boton {

    background:#a75c70;

    color:#fff5f7;

    padding:
        11px 24px;

    border-radius:28px;

    font-size:16px;

    font-weight:700;

    text-decoration:none;

    transition:.3s ease;

    border:
        1px solid #a75c70;

}


/* ==========================================
   HOVER
   ========================================== */

.boton:hover {

    background:#dfa3b3;

    color:#7d4556;

    transform:
        scale(1.05);

    box-shadow:
        0 6px 20px
        rgba(167,92,112,.35);

}


/* ==========================================
   BOTÓN ELIMINAR
   ========================================== */

.boton.eliminar {

    background:#f3d5dc;

    color:#a04f62;

    border:
        1px solid #e7b8c5;

}


.boton.eliminar:hover {

    background:#c96d82;

    color:white;

    box-shadow:
        0 6px 20px
        rgba(201,109,130,.35);

}


/* ==========================================
   NAVEGACIÓN
   ========================================== */

.navegacion {

    margin-top:20px;

    text-align:center;

    display:flex;

    flex-direction:column;

    gap:12px;

}


/* ==========================================
   BOTONES DE NAVEGACIÓN
   ========================================== */

.boton2 {

    background:#fff;

    color:#a75c70;

    padding:
        12px 28px;

    border-radius:28px;

    font-size:17px;

    font-weight:700;

    text-decoration:none;

    transition:.3s ease;

    border:
        1px solid #e9c5cf;

}


.boton2:hover {

    background:#a75c70;

    color:white;

    transform:
        scale(1.04);

    box-shadow:
        0 5px 20px
        rgba(167,92,112,.3);

}


/* ==========================================
   RESPONSIVE
   ========================================== */

@media (max-width:768px) {

    .contenedor {

        padding:25px;

    }


    .imagen {

        min-height:150px;

    }


    .titulo {

        font-size:26px;

    }


    .botones {

        flex-direction:column;

    }


    .boton {

        width:auto;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- ======================================
         DECORACIÓN
         ====================================== -->

    <div class="imagen"></div>


    <!-- ======================================
         TÍTULO
         ====================================== -->

    <h2 class="titulo">

        DETALLE DE LA VENTA

    </h2>


    <!-- ======================================
         DATOS
         ====================================== -->

    <div class="item">

<?php

while ($fila = $resultado->fetch_assoc()) {


    echo "

    <p>

        <span>
            Número de venta:
        </span>

        "

        . htmlspecialchars(
            $fila['id']
        )

        . "

    </p>
    ";


    echo "

    <p>

        <span>
            Estado:
        </span>

        <span class='estado'>

        "

        . htmlspecialchars(
            $fila['estado']
        )

        . "

        </span>

    </p>
    ";


    echo "

    <p>

        <span>
            Método de pago:
        </span>

        "

        . htmlspecialchars(
            $fila['metodo']
        )

        . "

    </p>
    ";


    echo "

    <p>

        <span>
            Costo total:
        </span>

        <span class='total'>

            Bs. "

        . htmlspecialchars(
            $fila['costototal']
        )

        . "

        </span>

    </p>
    ";


    echo "

    <p>

        <span>
            Número del pedido:
        </span>

        "

        . htmlspecialchars(
            $fila['PEDIDOS_ID']
        )

        . "

    </p>
    ";


    $id = $fila['id'];

}

?>

    </div>


    <!-- ======================================
         BOTONES
         ====================================== -->

   <?php

if ($rolUsuario == "administrador") {

?>

    <div class="botones">

        <a
            href="updateformventa.php?id=<?php echo $fila['id']; ?>"
            class="boton boton-editar"
        >
            ✎ Editar
        </a>


        <a
            href="deleteventa.php?id=<?php echo $fila['id']; ?>"
            class="boton boton-eliminar"
        >
            ✕ Eliminar
        </a>

    </div>

<?php

}

?>


    <!-- ======================================
         NAVEGACIÓN
         ====================================== -->

    <div class="navegacion">


        <a
            href="readtodoventa.php"
            class="boton2"
        >

          ⬅  Ver ventas

        </a>




    </div>


</div>


</body>

</html>


<?php

}


// ==========================================
// CERRAR CONEXIÓN
// ==========================================

$conn->close();

?>