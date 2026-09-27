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
   CABECERA
========================================================= */

.cabecera-publicaciones {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 30px;
}


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
   DECORACIÓN
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
   TARJETA BASE
========================================================= */

.post {

    position: relative;

    min-height: 230px;

    padding: 30px 28px;

    background: var(--blanco);

    border: 1px solid var(--borde);

    border-radius: 20px;

    box-shadow:
        0 8px 25px var(--sombra);

    transition:
        transform .35s ease,
        box-shadow .35s ease,
        border-color .35s ease;

    overflow: hidden;
}


/* =========================================================
   BORDE LATERAL SEGÚN ROL
========================================================= */

.post::before {

    content: "";

    position: absolute;

    left: 0;

    top: 0;

    bottom: 0;

    width: 5px;

    background:
        linear-gradient(
            to bottom,
            var(--rosa),
            var(--dorado)
        );
}


.post::after {

    content: "“";

    position: absolute;

    top: -15px;

    right: 18px;

    font-family: 'Playfair Display', serif;

    font-size: 100px;

    color: rgba(199,125,145,.10);
}


/* =========================================================
   HOVER
========================================================= */

.post:hover {

    transform: translateY(-7px);

    box-shadow:
        0 18px 40px rgba(77,49,57,.15);
}


/* =========================================================
   TARJETA ADMINISTRADOR
========================================================= */

.post-admin {

    background:
        linear-gradient(
            145deg,
            #fffdf6,
            #f8f0dc
        );

    border-color: #dfc98f;

    box-shadow:
        0 10px 30px rgba(182,154,91,.18);
}


.post-admin::before {

    background:
        linear-gradient(
            to bottom,
            #d6b56b,
            #a9823d
        );
}


.post-admin::after {

    color: rgba(182,154,91,.13);
}


.post-admin:hover {

    border-color: #c9a75e;

    box-shadow:
        0 18px 40px rgba(182,154,91,.25);
}


/* =========================================================
   TARJETA VENDEDOR
========================================================= */

.post-vendedor {

    background:
        linear-gradient(
            145deg,
            #fcf9ff,
            #f0e8f8
        );

    border-color: #cdb8dd;

    box-shadow:
        0 10px 30px rgba(124,91,151,.15);
}


.post-vendedor::before {

    background:
        linear-gradient(
            to bottom,
            #a987c0,
            #72518e
        );
}


.post-vendedor::after {

    color: rgba(128,91,154,.12);
}


.post-vendedor:hover {

    border-color: #ae91c5;

    box-shadow:
        0 18px 40px rgba(124,91,151,.23);
}


/* =========================================================
   TARJETA CLIENTE
========================================================= */

.post-cliente {

    background:
        linear-gradient(
            145deg,
            #fffdfd,
            #fdf1f4
        );

    border-color: #ead0d7;
}


.post-cliente::before {

    background:
        linear-gradient(
            to bottom,
            #d795a7,
            #b96f84
        );
}


/* =========================================================
   CÍRCULO DEL ROL
========================================================= */

.rol-circulo {

    position: absolute;

    top: 16px;

    right: 16px;

    width: 42px;

    height: 42px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    color: white;

    font-size: 15px;

    font-weight: 700;

    font-family: 'DM Sans', sans-serif;

    box-shadow:
        0 6px 15px rgba(80,52,59,.22);

    z-index: 5;

    border: 2px solid rgba(255,255,255,.65);
}


/* =========================================================
   CÍRCULO ADMINISTRADOR
========================================================= */

.rol-administrador {

    background:
        linear-gradient(
            135deg,
            #d7b76e,
            #9d7835
        );

    box-shadow:
        0 6px 16px rgba(163,126,56,.30);
}


/* =========================================================
   CÍRCULO VENDEDOR
========================================================= */

.rol-vendedor {

    background:
        linear-gradient(
            135deg,
            #a17abb,
            #694487
        );

    box-shadow:
        0 6px 16px rgba(105,68,135,.30);
}


/* =========================================================
   CÍRCULO CLIENTE
========================================================= */

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

    margin-bottom: 10px;

    padding-right: 55px;

    position: relative;

    z-index: 2;
}


/* =========================================================
   ICONO
========================================================= */

.icono {

    width: 40px;

    height: 40px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: var(--rosa-claro);

    color: var(--rosa);

    font-family: 'Playfair Display', serif;

    font-size: 20px;

    flex-shrink: 0;
}


/* =========================================================
   ICONO ADMIN
========================================================= */

.post-admin .icono {

    background: #f1e3bb;

    color: #a27b38;
}


/* =========================================================
   ICONO VENDEDOR
========================================================= */

.post-vendedor .icono {

    background: #e5d7ef;

    color: #795396;
}


/* =========================================================
   ICONO CLIENTE
========================================================= */

.post-cliente .icono {

    background: #f4dce2;

    color: #bd7186;
}


/* =========================================================
   INFORMACIÓN USUARIO
========================================================= */

.info-usuario {

    display: flex;

    flex-direction: column;

    gap: 3px;
}


/* =========================================================
   ETIQUETA ROL
========================================================= */

.opinion {

    display: inline-flex;

    align-items: center;

    width: fit-content;

    padding: 4px 9px;

    border-radius: 20px;

    color: #8b6d76;

    background: #f5e8eb;

    font-size: 9px;

    letter-spacing: 1.5px;

    text-transform: uppercase;

    font-weight: 700;
}


/* =========================================================
   ROL ADMIN
========================================================= */

.post-admin .opinion {

    color: #896b2e;

    background: #eee0b7;
}


/* =========================================================
   ROL VENDEDOR
========================================================= */

.post-vendedor .opinion {

    color: #704d8a;

    background: #e5d8ee;
}


/* =========================================================
   ROL CLIENTE
========================================================= */

.post-cliente .opinion {

    color: #a55d70;

    background: #f3dfe4;
}


/* =========================================================
   NOMBRE
========================================================= */

.nombre-usuario {

    color: var(--vino);

    font-size: 15px;

    font-weight: 700;

    line-height: 1.3;
}


/* =========================================================
   FECHA
========================================================= */

.fecha {

    position: relative;

    z-index: 2;

    color: #a18c91;

    font-size: 10px;

    letter-spacing: .5px;

    margin-top: 3px;

    margin-bottom: 15px;
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
   PIE ADMIN
========================================================= */

.post-admin .post-pie {

    color: #a17c3c;
}


/* =========================================================
   PIE VENDEDOR
========================================================= */

.post-vendedor .post-pie {

    color: #80609a;
}


/* =========================================================
   PIE CLIENTE
========================================================= */

.post-cliente .post-pie {

    color: #b87587;
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

        width: 36px;

        height: 36px;

        font-size: 13px;

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


            <div class="botones-cabecera">


                <a
                    class="volver"
                    href="../totu.php"
                >

                    ⌂ &nbsp; Inicio

                </a>


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


        /* ==================================================
           VARIABLES
        ================================================== */

        $rol = 'cliente';

        $nombre = 'Cliente';

        $fecha = 'Fecha no disponible';

        $comentario = $linea;


        /* ==================================================
           FORMATO NUEVO

           fecha | rol | nombre: comentario

           Ejemplo:

           2026-09-26 22:30:15 | administrador | María: Hola
        ================================================== */

        $patronNuevo =
            '/^(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\s*\|\s*(administrador|vendedor|cliente)\s*\|\s*(.*?)\s*:\s*(.*)$/i';


        if (preg_match($patronNuevo, $linea, $coincidencias)) {


            $fecha = trim($coincidencias[1]);

            $rol = strtolower(trim($coincidencias[2]));

            $nombre = trim($coincidencias[3]);

            $comentario = trim($coincidencias[4]);


            if ($nombre === '') {

                $nombre = 'Cliente';
            }


            if ($comentario === '') {

                $comentario = 'Sin comentario.';
            }

        }


        /* ==================================================
           FORMATO ANTERIOR

           fecha | nombre: comentario

           Si encontramos este formato, el rol no estaba
           guardado y se muestra Cliente.
        ================================================== */

        elseif (
            preg_match(
                '/^(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\s*\|\s*(.*?)\s*:\s*(.*)$/',
                $linea,
                $coincidencias
            )
        ) {


            $fecha = trim($coincidencias[1]);

            $nombre = trim($coincidencias[2]);

            $comentario = trim($coincidencias[3]);

            $rol = 'cliente';


            if ($nombre === '') {

                $nombre = 'Cliente';
            }


            if ($comentario === '') {

                $comentario = 'Sin comentario.';
            }

        }


        /* ==================================================
           FORMATO ANTIGUO

           rol | comentario
        ================================================== */

        elseif (
            preg_match(
                '/^(administrador|vendedor|cliente)\s*\|\s*(.*)$/i',
                $linea,
                $coincidencias
            )
        ) {


            $rol = strtolower(trim($coincidencias[1]));

            $comentario = trim($coincidencias[2]);

            $nombre = 'Cliente';

            $fecha = 'Fecha no disponible';

        }


        /* ==================================================
           ASEGURAR ROL VÁLIDO
        ================================================== */

        if (
            $rol !== 'administrador' &&
            $rol !== 'vendedor' &&
            $rol !== 'cliente'
        ) {

            $rol = 'cliente';
        }


        /* ==================================================
           DATOS VISUALES SEGÚN ROL
        ================================================== */

        if ($rol === 'administrador') {

            $inicialRol = 'A';

            $claseRol = 'rol-administrador';

            $clasePost = 'post-admin';

            $textoRol = 'Administrador';

        }

        elseif ($rol === 'vendedor') {

            $inicialRol = 'V';

            $claseRol = 'rol-vendedor';

            $clasePost = 'post-vendedor';

            $textoRol = 'Vendedor';

        }

        else {

            $inicialRol = 'C';

            $claseRol = 'rol-cliente';

            $clasePost = 'post-cliente';

            $textoRol = 'Cliente';

        }

?>



            <!-- =================================================
                 TARJETA
            ================================================== -->

            <article class="post <?php echo $clasePost; ?>">


                <!-- =================================================
                     CÍRCULO DEL ROL
                ================================================== -->

                <div
                    class="rol-circulo <?php echo $claseRol; ?>"
                    title="<?php echo htmlspecialchars(
                        $textoRol,
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                >

                    <?php echo $inicialRol; ?>

                </div>


                <!-- =================================================
                     USUARIO Y ROL
                ================================================== -->

                <div class="post-top">


                    <div class="icono">

                        ♡

                    </div>


                    <div class="info-usuario">


                        <!-- ROL -->

                        <div class="opinion">

                            <?php echo htmlspecialchars(
                                $textoRol,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </div>


                        <!-- NOMBRE -->

                        <div class="nombre-usuario">

                            <?php echo htmlspecialchars(
                                $nombre,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </div>


                    </div>


                </div>


                <!-- =================================================
                     FECHA
                ================================================== -->

                <div class="fecha">

                    ◷

                    <?php echo htmlspecialchars(
                        $fecha,
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                </div>


                <!-- =================================================
                     COMENTARIO
                ================================================== -->

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


                <!-- =================================================
                     PIE
                ================================================== -->

                <div class="post-pie">

                    ✦

                    <?php echo htmlspecialchars(
                        $textoRol,
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                    · Gracias por compartir

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