<?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";


/* ==========================================
   CONEXIÓN A LA BASE DE DATOS
========================================== */

$conn = new mysqli(
    $servidor,
    $usuario,
    $contraseña,
    $nombreBD
);


if ($conn->connect_error) {

    die("OCURRIÓ UN ERROR AL CONECTAR CON LA BASE DE DATOS.");

}


/* ==========================================
   CONSULTAR TODOS LOS PRODUCTOS
========================================== */

$sql = "SELECT * FROM PRODUCTO";

$resultado = $conn->query($sql);


?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">
<title>

    Productos DIVINE

</title>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500;600&display=swap"
    rel="stylesheet"
>


<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
></script>


<style>


/* ==========================================
   ESTILOS GENERALES
========================================== */

* {

    box-sizing: border-box;

}


body {

    font-family: 'Poppins', sans-serif;

    background: #f8eff1;

    margin: 0;

    min-height: 100vh;

    color: #4a3f43;

    padding: 40px 20px;

}


/* ==========================================
   CONTENEDOR PRINCIPAL
========================================== */

.contenedor {

    background: #ffffff;

    width: 95%;

    max-width: 1100px;

    margin: auto;

    padding: 40px;

    border-radius: 30px;

    box-shadow:
        0 15px 40px rgba(166, 91, 113, 0.15);

}


/* ==========================================
   ENCABEZADO
========================================== */

.encabezado {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 30px;

    flex-wrap: wrap;

}


.titulo {

    font-family: 'Playfair Display', serif;

    color: #a65b71;

    font-size: 32px;

    margin: 0;

    letter-spacing: 1px;

}


.subtitulo {

    margin: 5px 0 0 0;

    color: #8b777d;

    font-size: 14px;

}


/* ==========================================
   BOTÓN AÑADIR PRODUCTO
========================================== */

.btn-agregar {

    text-decoration: none;

    background: #a65b71;

    color: white;

    padding: 13px 24px;

    border-radius: 30px;

    font-size: 15px;

    font-weight: 500;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    box-shadow:
        0 5px 15px rgba(166, 91, 113, 0.30);

    transition: all 0.3s ease;

}


.btn-agregar:hover {

    background: #c87588;

    transform: translateY(-3px);

    box-shadow:
        0 8px 20px rgba(200, 117, 136, 0.35);

}


/* ==========================================
   DECORACIÓN
========================================== */

.decoracion {

    width: 70px;

    height: 3px;

    background: #c87588;

    border-radius: 10px;

    margin-bottom: 30px;

}


/* ==========================================
   LISTA DE PRODUCTOS
========================================== */

.lista {

    display: flex;

    flex-direction: column;

    gap: 18px;

}


/* ==========================================
   TARJETA PRODUCTO
========================================== */

.item {

    background: #faf6f7;

    padding: 22px;

    border-radius: 22px;

    border: 1px solid #e2c2c9;

    box-shadow:
        0 5px 15px rgba(166, 91, 113, 0.08);

    transition: all 0.3s ease;

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 30px;

}


.item:hover {

    background: #f8eff1;

    transform: translateY(-4px);

    box-shadow:
        0 10px 25px rgba(166, 91, 113, 0.15);

}


/* ==========================================
   INFORMACIÓN DEL PRODUCTO
========================================== */

.info-producto {

    flex: 1;

    min-width: 0;

}


.item p {

    margin: 7px 0;

    font-size: 15px;

    color: #5a4e53;

}


.item span {

    font-weight: 600;

    color: #a65b71;

}

/* ESTILO PARA STOCK BAJO */
.stock-bajo {
    color: #d9534f !important;
    font-weight: 700;
}


/* ==========================================
   IMAGEN DEL PRODUCTO
========================================== */

.imagen-producto {

    width: 190px;

    height: 190px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    background: white;

    border-radius: 18px;

    border: 1px solid #ead3d8;

    overflow: hidden;

    box-shadow:
        0 5px 15px rgba(166, 91, 113, 0.10);

}


.imagen-producto img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    display: block;

    transition: transform 0.3s ease;

}


.item:hover .imagen-producto img {

    transform: scale(1.05);

}


/* ==========================================
   CUANDO NO EXISTE IMAGEN
========================================== */

.imagen-no-disponible {

    width: 100%;

    height: 100%;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-direction: column;

    color: #a65b71;

    font-size: 13px;

    text-align: center;

    background: #f8eff1;

}


/* ==========================================
   BOTONES PRODUCTO
========================================== */

.botones {

    margin-top: 18px;

    display: flex;

    gap: 10px;

    flex-wrap: wrap;

}


.botones a {

    text-decoration: none;

}


.botones button {

    border: none;

    border-radius: 25px;

    padding: 9px 18px;

    cursor: pointer;

    color: white;

    font-family: 'Poppins', sans-serif;

    font-size: 13px;

    font-weight: 500;

    transition: all 0.3s ease;

}


/* ==========================================
   DETALLES
========================================== */

.btn-detalles {

    background: #a65b71;

}


.btn-detalles:hover {

    background: #8f4c61;

    transform: translateY(-2px);

}


/* ==========================================
   EDITAR
========================================== */

.btn-editar {

    background: #c87588;

}


.btn-editar:hover {

    background: #a65b71;

    transform: translateY(-2px);

}


/* ==========================================
   ELIMINAR
========================================== */

.btn-eliminar {

    background: #7d4b56;

}


.btn-eliminar:hover {

    background: #532e4e;

    transform: translateY(-2px);

}


/* ==========================================
   MENSAJE SIN PRODUCTOS
========================================== */

.sin-productos {

    text-align: center;

    background: #faf6f7;

    border: 2px dashed #e2c2c9;

    border-radius: 25px;

    padding: 55px 30px;

    margin-top: 10px;

}


.icono-vacio {

    font-size: 55px;

    margin-bottom: 10px;

}


.sin-productos h3 {

    font-family: 'Playfair Display', serif;

    color: #a65b71;

    font-size: 25px;

    margin: 10px 0;

}


.sin-productos p {

    color: #8b777d;

    font-size: 14px;

    margin-bottom: 25px;

}


/* ==========================================
   BOTÓN PRIMER PRODUCTO
========================================== */

.btn-primer-producto {

    display: inline-block;

    text-decoration: none;

    background: #c87588;

    color: white;

    padding: 13px 28px;

    border-radius: 30px;

    font-size: 15px;

    font-weight: 500;

    box-shadow:
        0 5px 15px rgba(200, 117, 136, 0.30);

    transition: all 0.3s ease;

}


.btn-primer-producto:hover {

    background: #a65b71;

    transform: translateY(-3px);

    box-shadow:
        0 8px 20px rgba(166, 91, 113, 0.35);

}


/* ==========================================
   BOTONES INFERIORES
========================================== */

.volver {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 15px;

    flex-wrap: wrap;

    margin-top: 35px;

    padding-top: 25px;

    border-top: 1px solid #ead9dd;

}


.volver a {

    text-decoration: none;

    padding: 12px 28px;

    border-radius: 30px;

    font-size: 14px;

    font-weight: 500;

    transition: all 0.3s ease;

}


.btn-volver {

    background: #f3e2e6;

    color: #a65b71;

}


.btn-volver:hover {

    background: #e8cbd2;

    transform: translateY(-2px);

}


.btn-registrar {

    background: #a65b71;

    color: white;

}


.btn-registrar:hover {

    background: #c87588;

    transform: translateY(-2px);

}


/* ==========================================
   RESPONSIVE
========================================== */

@media (max-width: 768px) {


    body {

        padding: 20px 10px;

    }


    .contenedor {

        width: 100%;

        padding: 25px;

        border-radius: 22px;

    }


    .encabezado {

        flex-direction: column;

        align-items: stretch;

        text-align: center;

    }


    .titulo {

        font-size: 27px;

    }


    .btn-agregar {

        justify-content: center;

    }


    .decoracion {

        margin-left: auto;

        margin-right: auto;

    }


    /* ======================================
       TARJETA EN CELULAR
    ====================================== */

    .item {

        flex-direction: column;

        align-items: stretch;

    }


    /* ======================================
       IMAGEN EN CELULAR
    ====================================== */

    .imagen-producto {

        width: 100%;

        height: 250px;

        order: -1;

    }


    .info-producto {

        width: 100%;

    }


    /* ======================================
       BOTONES
    ====================================== */

    .botones {

        flex-direction: column;

    }


    .botones a {

        width: 100%;

    }


    .botones button {

        width: 100%;

    }


    .volver {

        flex-direction: column;

    }


    .volver a {

        width: 100%;

        text-align: center;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- ==========================================
         ENCABEZADO
    =========================================== -->

    <div class="encabezado">


        <div>


            <h2 class="titulo">

                LISTA DE PRODUCTOS DIVINE

            </h2>


            <p class="subtitulo">

                Administra y controla tus productos

            </p>


        </div>


        <!-- BOTÓN AÑADIR -->

        <a

            href="formularioprodu.php"

            class="btn-agregar"

        >

            ＋ Añadir producto

        </a>


    </div>


    <div class="decoracion"></div>


    <!-- ==========================================
         LISTA
    =========================================== -->

    <div class="lista">


<?php


/* ==========================================
   COMPROBAR PRODUCTOS
========================================== */

if (

    $resultado &&

    $resultado->num_rows > 0

) {


    while (

        $fila = $resultado->fetch_assoc()

    ) {


        /* ==========================================
           DATOS DEL PRODUCTO
        ========================================== */

        $nombre = htmlspecialchars(

            $fila['nombre']

        );


        $descripcion = htmlspecialchars(

            $fila['descripcion']

        );


        $categoria = htmlspecialchars(

            $fila['categoria']

        );


        $precio = htmlspecialchars(

            $fila['precio']

        );


        $costo = htmlspecialchars(

            $fila['costo']

        );


        $stock = htmlspecialchars(

            $fila['stock']

        );


        $codigo = htmlspecialchars(

            $fila['codigo']

        );


        /* ==========================================
           BUSCAR IMAGEN SEGÚN EL CÓDIGO

           EJEMPLOS:

           p-21.jpg
           p-21.jpeg
           p-21.png
           p-21.gif

           CARPETA:

           ../PRODUCTO-img/
        ========================================== */

        $directorio = "../PRODUCTO-img/";


        $nombreArchivo = "p-" . $fila['codigo'];


        $extensiones = [

            "jpg",

            "jpeg",

            "png",

            "gif"

        ];


        $imagenProducto = null;


        foreach (

            $extensiones as $extension

        ) {


            $ruta =

                $directorio .

                $nombreArchivo .

                "." .

                $extension;


            if (

                file_exists($ruta)

            ) {


                $imagenProducto = $ruta;


                break;

            }

        }


?>


        <!-- ==========================================
             TARJETA
        =========================================== -->

        <div class="item">


            <!-- ======================================
                 INFORMACIÓN
            ======================================= -->

            <div class="info-producto">


                <p>

                    <span>

                        Nombre:

                    </span>

                    <?= $nombre ?>

                </p>


                <p>

                    <span>

                        Descripción:

                    </span>

                    <?= $descripcion ?>

                </p>


                <p>

                    <span>

                        Categoría:

                    </span>

                    <?= $categoria ?>

                </p>


                <p>

                    <span>

                        Precio:

                    </span>

                    Bs. <?= $precio ?>

                </p>


            <p>
                <span>Stock:</span>
                <strong class="<?= ($stock <= 5) ? 'stock-bajo' : '' ?>">
                    <?= $stock ?>
                </strong>
            </p>


                <p>

                    <span>

                        Stock:

                    </span>

                    <?= $stock ?>

                </p>


                <p>

                    <span>

                        Código:

                    </span>

                    <?= $codigo ?>

                </p>


                <!-- ==================================
                     BOTONES
                =================================== -->

                <div class="botones">


                    <!-- DETALLES -->

                    <a

                        href="readunoprodu.php?codigo=<?= urlencode($fila['codigo']) ?>"

                    >

                        <button

                            type="button"

                            class="btn-detalles"

                        >

                            👁 Detalles

                        </button>

                    </a>


                    <!-- EDITAR -->

                    <a

                        href="updateformprodu.php?codigo=<?= urlencode($fila['codigo']) ?>"

                    >

                        <button

                            type="button"

                            class="btn-editar"

                        >

                            ✏ Editar

                        </button>

                    </a>


                    <!-- ELIMINAR -->

                    <a

                        href="#"

                        onclick="

                            confirmarEliminacion(

                                '<?= htmlspecialchars(

                                    $fila['codigo'],

                                    ENT_QUOTES

                                ) ?>'

                            );

                            return false;

                        "

                    >

                        <button

                            type="button"

                            class="btn-eliminar"

                        >

                            🗑 Eliminar

                        </button>

                    </a>


                </div>


            </div>


            <!-- ======================================
                 IMAGEN DEL PRODUCTO
            ======================================= -->

            <div class="imagen-producto">


<?php


            /* ======================================
               SI ENCONTRÓ LA IMAGEN
            ======================================= */

            if (

                $imagenProducto !== null

            ) {


?>


                <img

                    src="<?= htmlspecialchars(

                        $imagenProducto

                    ) ?>"

                    alt="<?= $nombre ?>"

                >


<?php


            } else {


                /* ==================================
                   SI NO ENCONTRÓ LA IMAGEN
                =================================== */

?>


                <div class="imagen-no-disponible">

                    📷

                    <br>

                    Imagen no disponible

                </div>


<?php

            }


?>


            </div>


        </div>


<?php


    }


} else {


?>


        <!-- ==========================================
             NO HAY PRODUCTOS
        =========================================== -->

        <div class="sin-productos">


            <div class="icono-vacio">

                📦

            </div>


            <h3>

                No hay productos registrados

            </h3>


            <p>

                Todavía no tienes productos en tu catálogo.

                <br>

                ¡Agrega tu primer producto para comenzar!

            </p>


            <a

                href="formularioprodu.php"

                class="btn-primer-producto"

            >

                ＋ Añadir primer producto

            </a>


        </div>


<?php

}

?>


    </div>


    <!-- ==========================================
         BOTONES INFERIORES
    =========================================== -->

    <div class="volver">
        <a
            href="javascript:history.back()"
            class="btn-volver"
        >
            ← Volver atrás
        </a>
        <a
            href="formularioprodu.php"
            class="btn-registrar"
        >
            ＋ Registrar producto
        </a>
    </div>
</div>
<script>
function confirmarEliminacion(codigo) {
    Swal.fire({
        title: "¿Eliminar producto?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#a65b71",
        cancelButtonColor: "#532e4e",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then((result) => {
        if (
            result.isConfirmed
        ) {
            window.location.href =

                "deleteprodu.php?codigo=" +

                encodeURIComponent(codigo);
        }
    });
};
<?php
   $bajos= "SELECT * FROM PRODUCTO WHERE stock <= 3";
   $resultadoBajos = $conn->query($bajos);
   $arrayBajos = [];
   while ($filaBajos = $resultadoBajos->fetch_assoc()) {
       $arrayBajos[] = $filaBajos['nombre'];
   }
    if (count($arrayBajos) > 0) {
        $nombresBajos = implode(", ", $arrayBajos);
        echo "window.onload = function() {
            Swal.fire({
                title: '¡Atención!',
                html: 'Los siguientes productos tienen stock bajo: <br><strong>$nombresBajos</strong>',
                icon: 'warning',
                confirmButtonColor: '#a65b71',
                confirmButtonText: 'Aceptar'
            });
        };";
    }

?>

</script>
</body>
</html>
<?php
$conn->close();
?>
