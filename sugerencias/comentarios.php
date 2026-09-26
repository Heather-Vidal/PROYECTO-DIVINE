
<?php

$archivo = 'mensajes.txt';

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Opiniones | DIVINE</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet"
>

<style>

/* =========================================================
   PALETA
========================================================= */

:root {

    --crema: #fbf6f1;
    --blanco: #fffdfb;
    --vino: #50343b;
    --vino-claro: #74545c;
    --rosa: #c77d91;
    --rosa-claro: #f2dce2;
    --dorado: #b69a6a;
    --dorado-claro: #dfcda7;
    --borde: #eadbd7;
    --sombra: rgba(77, 49, 57, .13);

}


/* =========================================================
   RESET
========================================================= */

* {

    box-sizing: border-box;
    margin: 0;
    padding: 0;

}


/* =========================================================
   BODY
========================================================= */

body {

    min-height: 100vh;

    font-family: 'DM Sans', sans-serif;

    color: var(--vino);

    padding: 45px 20px;

    background:

        linear-gradient(

            rgba(249, 239, 238, .90),

            rgba(248, 241, 235, .96)

        ),

        url("../imagenes/mezcla.jpg")

        center / cover fixed no-repeat;

}


/* =========================================================
   CONTENEDOR
========================================================= */

.contenedor {

    width: 100%;

    max-width: 1100px;

    margin: auto;

    background: rgba(255,253,251,.94);

    border: 1px solid rgba(255,255,255,.9);

    border-radius: 30px;

    overflow: hidden;

    box-shadow:

        0 30px 80px rgba(77,49,57,.18);

}


/* =========================================================
   PORTADA
========================================================= */

.portada {

    min-height: 350px;

    position: relative;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 60px 25px;

    overflow: hidden;

    background:

        linear-gradient(

            rgba(70, 42, 49, .35),

            rgba(70, 42, 49, .58)

        ),

        url("../imagenes/mezcla.jpg")

        center / cover no-repeat;

}


/* brillo */

.portada::before {

    content: "";

    position: absolute;

    width: 500px;

    height: 500px;

    border-radius: 50%;

    background: rgba(255,255,255,.08);

    top: -300px;

    right: -100px;

}


/* círculo inferior */

.portada::after {

    content: "";

    position: absolute;

    width: 350px;

    height: 350px;

    border-radius: 50%;

    border: 1px solid rgba(255,255,255,.15);

    bottom: -250px;

    left: -100px;

}


/* =========================================================
   CONTENIDO PORTADA
========================================================= */

.portada-contenido {

    position: relative;

    z-index: 2;

}


.mini-titulo {

    color: #e8cfa0;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 5px;

    text-transform: uppercase;

    margin-bottom: 13px;

}


.titulo {

    font-family: 'Playfair Display', serif;

    color: white;

    font-size: clamp(43px, 7vw, 70px);

    font-weight: 600;

    line-height: 1;

}


.titulo span {

    color: #efd3dc;

}


.linea {

    width: 70px;

    height: 1px;

    background: #e1c58f;

    margin: 22px auto;

}


.subtitulo {

    max-width: 540px;

    margin: auto;

    color: rgba(255,255,255,.87);

    font-size: 14px;

    line-height: 1.8;

}


/* =========================================================
   CONTENIDO
========================================================= */

.contenido {

    padding: 45px 55px 50px;

}


/* =========================================================
   CABECERA DE PUBLICACIONES
========================================================= */

.cabecera-publicaciones {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 30px;

}


/* CONTENEDOR DE BOTONES */

.botones-cabecera {

    display: flex;

    align-items: center;

    gap: 10px;

    flex-wrap: wrap;

}


/* =========================================================
   TÍTULO
========================================================= */

.seccion-titulo {

    font-family: 'Playfair Display', serif;

    font-size: 29px;

    color: var(--vino);

}


.seccion-descripcion {

    margin-top: 5px;

    color: #927b80;

    font-size: 13px;

}


/* =========================================================
   BOTONES
========================================================= */

.volver {

    text-decoration: none;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding: 13px 22px;

    border-radius: 30px;

    background: var(--vino);

    color: white;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: .4px;

    box-shadow:

        0 8px 20px rgba(80,52,59,.18);

    transition: .3s ease;

}


.volver:hover {

    background: var(--rosa);

    transform: translateY(-3px);

    box-shadow:

        0 12px 25px rgba(199,125,145,.25);

}


/* =========================================================
   LÍNEA DECORATIVA
========================================================= */

.decoracion {

    display: flex;

    align-items: center;

    gap: 15px;

    margin-bottom: 30px;

}


.decoracion::before,

.decoracion::after {

    content: "";

    height: 1px;

    flex: 1;

    background: var(--borde);

}


.decoracion span {

    color: var(--dorado);

    font-size: 15px;

}


/* =========================================================
   PUBLICACIONES
========================================================= */

.publicaciones {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 22px;

}


/* =========================================================
   TARJETA
========================================================= */

.post {

    position: relative;

    min-height: 190px;

    padding: 30px 28px;

    background: var(--blanco);

    border: 1px solid var(--borde);

    border-radius: 20px;

    box-shadow:

        0 8px 25px var(--sombra);

    transition: .35s ease;

    overflow: hidden;

}


/* línea lateral */

.post::before {

    content: "";

    position: absolute;

    left: 0;

    top: 0;

    bottom: 0;

    width: 4px;

    background:

        linear-gradient(

            to bottom,

            var(--rosa),

            var(--dorado)

        );

}


/* comillas decorativas */

.post::after {

    content: "“";

    position: absolute;

    top: -15px;

    right: 18px;

    font-family: 'Playfair Display', serif;

    font-size: 100px;

    color: rgba(199,125,145,.10);

}


.post:hover {

    transform: translateY(-7px);

    border-color: #dcc0c4;

    box-shadow:

        0 18px 40px rgba(77,49,57,.15);

}


/* =========================================================
   CÍRCULO DEL ROL
========================================================= */

.rol-circulo {

    position: absolute;

    top: 16px;

    right: 16px;

    width: 34px;

    height: 34px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background:

        linear-gradient(

            135deg,

            var(--rosa),

            var(--vino)

        );

    color: white;

    font-size: 13px;

    font-weight: 700;

    font-family: 'DM Sans', sans-serif;

    box-shadow:

        0 5px 12px rgba(80,52,59,.20);

    z-index: 5;

}


/* =========================================================
   COLORES SEGÚN ROL
========================================================= */

.rol-administrador {

    background:

        linear-gradient(

            135deg,

            #8c3b58,

            #50343b

        );

}


.rol-vendedor {

    background:

        linear-gradient(

            135deg,

            #c77d91,

            #9b5269

        );

}


.rol-cliente {

    background:

        linear-gradient(

            135deg,

            #d4989d,

            #b67880

        );

}


/* =========================================================
   PARTE SUPERIOR
========================================================= */

.post-top {

    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 22px;

    position: relative;

    z-index: 2;

}


.icono {

    width: 38px;

    height: 38px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: var(--rosa-claro);

    color: var(--rosa);

    font-family: 'Playfair Display', serif;

    font-size: 20px;

}


.opinion {

    color: #9a7c84;

    font-size: 10px;

    letter-spacing: 2px;

    text-transform: uppercase;

    font-weight: 700;

}


/* =========================================================
   TEXTO
========================================================= */

.post-texto {

    position: relative;

    z-index: 2;

    color: #634b52;

    font-family: 'Playfair Display', serif;

    font-size: 18px;

    line-height: 1.65;

}


/* =========================================================
   PIE
========================================================= */

.post-pie {

    display: flex;

    align-items: center;

    gap: 5px;

    margin-top: 22px;

    color: var(--dorado);

    font-size: 11px;

    letter-spacing: 1px;

}


/* =========================================================
   SIN PUBLICACIONES
========================================================= */

.sin-publicaciones {

    grid-column: 1 / -1;

    text-align: center;

    padding: 65px 25px;

    border: 1px dashed #dcbec8;

    border-radius: 20px;

    background:

        linear-gradient(

            135deg,

            #fffaf9,

            #f9eff2

        );

    color: #987d85;

}


.sin-icono {

    font-family: 'Playfair Display', serif;

    font-size: 55px;

    color: var(--rosa);

    margin-bottom: 10px;

}


.sin-publicaciones h3 {

    font-family: 'Playfair Display', serif;

    font-size: 24px;

    color: var(--vino);

    margin-bottom: 5px;

}


.sin-publicaciones p {

    font-size: 13px;

}


/* =========================================================
   FOOTER
========================================================= */

.footer {

    text-align: center;

    margin-top: 45px;

    padding-top: 25px;

    border-top: 1px solid var(--borde);

    color: #a18c91;

    font-size: 11px;

    letter-spacing: 1px;

}


.footer span {

    color: var(--rosa);

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 800px) {

    body {

        padding: 20px 12px;

    }


    .contenido {

        padding: 35px 25px;

    }


    .publicaciones {

        grid-template-columns: 1fr;

    }


    .cabecera-publicaciones {

        align-items: flex-start;

        flex-direction: column;

    }


    .botones-cabecera {

        width: 100%;

    }


    .volver {

        flex: 1;

    }

}


@media (max-width: 500px) {

    .contenedor {

        border-radius: 20px;

    }


    .portada {

        min-height: 310px;

        padding: 45px 20px;

    }


    .contenido {

        padding: 30px 17px;

    }


    .titulo {

        font-size: 43px;

    }


    .post {

        padding: 25px 21px;

    }


    .post-texto {

        font-size: 17px;

    }


    .rol-circulo {

        width: 31px;

        height: 31px;

        font-size: 12px;

        top: 12px;

        right: 12px;

    }


    .botones-cabecera {

        flex-direction: column;

        width: 100%;

    }


    .volver {

        width: 100%;

    }

}

</style>

</head>


<body>


<div class="contenedor">


    <!-- =====================================================
         PORTADA
    ====================================================== -->

    <section class="portada">

        <div class="portada-contenido">

            <div class="mini-titulo">

                DIVINE BEAUTY

            </div>

            <h1 class="titulo">

                Historias <span>que inspiran</span>

            </h1>

            <div class="linea"></div>

            <p class="subtitulo">

                Descubre las experiencias, comentarios y sugerencias
                que nuestra comunidad comparte con nosotros.

            </p>

        </div>

    </section>


    <!-- =====================================================
         CONTENIDO
    ====================================================== -->

    <main class="contenido">


        <div class="cabecera-publicaciones">


            <div>

                <h2 class="seccion-titulo">

                    Opiniones de nuestra comunidad

                </h2>

                <p class="seccion-descripcion">

                    Cada palabra cuenta y nos ayuda a seguir creciendo.

                </p>

            </div>


            <!-- BOTONES -->

            <div class="botones-cabecera">


                <!-- BOTÓN INICIO -->

                <a
                    class="volver"
                    href="../totu.php"
                >

                    ⌂ &nbsp; Inicio

                </a>


                <!-- BOTÓN COMPARTIR -->

                <a
                    class="volver"
                    href="publicar.php"
                >

                    ♡ &nbsp; Compartir mi opinión

                </a>


            </div>


        </div>


        <!-- =================================================
             DECORACIÓN
        ================================================== -->

        <div class="decoracion">

            <span>✦</span>

        </div>


        <!-- =================================================
             PUBLICACIONES
        ================================================== -->

        <div class="publicaciones">


<?php

if (file_exists($archivo)) {


    $lineas = file(

        $archivo,

        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES

    );


    $lineas = array_reverse($lineas);


    foreach ($lineas as $linea) {


        /*
         * ==================================================
         * FORMATO NUEVO:
         *
         * administrador|Mi comentario
         * vendedor|Mi comentario
         * cliente|Mi comentario
         *
         * FORMATO ANTIGUO:
         *
         * Mi comentario
         *
         * Los comentarios antiguos se consideran cliente.
         * ==================================================
         */


        $rol = 'cliente';

        $comentario = $linea;


        if (strpos($linea, '|') !== false) {


            $partes = explode('|', $linea, 2);


            $rolGuardado = strtolower(trim($partes[0]));


            $comentario = $partes[1];


            if (

                $rolGuardado === 'administrador' ||

                $rolGuardado === 'vendedor' ||

                $rolGuardado === 'cliente'

            ) {

                $rol = $rolGuardado;

            }

        }


        /*
         * ==================================================
         * INICIAL SEGÚN EL ROL
         * ==================================================
         */


        if ($rol === 'administrador') {

            $inicialRol = 'D';

            $claseRol = 'rol-administrador';

        }

        elseif ($rol === 'vendedor') {

            $inicialRol = 'V';

            $claseRol = 'rol-vendedor';

        }

        else {

            $inicialRol = 'C';

            $claseRol = 'rol-cliente';

        }

?>


            <article class="post">


                <!-- CÍRCULO DEL ROL -->

                <div
                    class="rol-circulo <?php echo $claseRol; ?>"
                    title="<?php echo ucfirst($rol); ?>"
                >

                    <?php echo $inicialRol; ?>

                </div>


                <!-- PARTE SUPERIOR -->

                <div class="post-top">


                    <div class="icono">

                        ♡

                    </div>


                    <div class="opinion">

                        Opinión de cliente

                    </div>


                </div>


                <!-- COMENTARIO -->

                <div class="post-texto">

                    <?php

                    echo nl2br(

                        htmlspecialchars(

                            $comentario,

                            ENT_QUOTES,

                            'UTF-8'

                        )

                    );

                    ?>

                </div>


                <!-- PIE -->

                <div class="post-pie">

                    ✦ Gracias por compartir

                </div>


            </article>


<?php

    }


}

else {


?>


            <div class="sin-publicaciones">


                <div class="sin-icono">

                    ♡

                </div>


                <h3>

                    Aún no hay opiniones

                </h3>


                <p>

                    Sé la primera persona en compartir una experiencia.

                </p>


            </div>


<?php

}

?>


        </div>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <div class="footer">

            Hecho con <span>♥</span> para la comunidad DIVINE

        </div>


    </main>


</div>


<!-- =========================================================
     SWEETALERT
========================================================= -->

<script>

<?php

if (

    isset($_GET['guardado']) &&

    $_GET['guardado'] == '1'

) {

?>


Swal.fire({

    icon: 'success',

    title: '¡Opinión publicada!',

    text: 'Tu comentario se guardó correctamente.',

    confirmButtonText: 'Continuar',

    confirmButtonColor: '#50343b',

    background: '#fffdfb',

    color: '#50343b',

    iconColor: '#c77d91'

});


<?php

}

?>

</script>


</body>

</html>

