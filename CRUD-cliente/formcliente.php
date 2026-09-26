
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear cuenta | DIVINE</title>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <!-- JQUERY VALIDATE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

    <!-- FUENTES -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">


    <style>

        /* =========================================================
           CONFIGURACIÓN GENERAL
        ========================================================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {

            min-height: 100vh;

            font-family: 'DM Sans', sans-serif;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 35px 20px;

            background:
                linear-gradient(
                    rgba(250, 241, 243, 0.82),
                    rgba(244, 229, 234, 0.88)
                ),
                url("../imagenes/fondote.png");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            position: relative;

            overflow-x: hidden;
        }


        /* =========================================================
           DECORACIONES DEL FONDO
        ========================================================= */

        body::before {

            content: "";

            position: fixed;

            width: 480px;
            height: 480px;

            border-radius: 50%;

            background: rgba(226, 170, 190, 0.20);

            top: -240px;
            left: -220px;

            filter: blur(4px);

            z-index: -1;
        }


        body::after {

            content: "";

            position: fixed;

            width: 420px;
            height: 420px;

            border-radius: 50%;

            background: rgba(214, 169, 185, 0.20);

            right: -200px;
            bottom: -200px;

            filter: blur(5px);

            z-index: -1;
        }


        /* =========================================================
           TARJETA PRINCIPAL
        ========================================================= */

        form {

            position: relative;

            width: 100%;
            max-width: 980px;

            min-height: 610px;

            padding: 38px;

            display: grid;

            grid-template-columns: 0.95fr 1.25fr;

            grid-template-rows: auto auto 1fr auto;

            grid-template-areas:

                "imagen titulo"
                "imagen leyenda"
                "imagen campos"
                "imagen boton";

            column-gap: 55px;

            background: rgba(255, 251, 252, 0.94);

            border: 1px solid rgba(255, 255, 255, 0.95);

            border-radius: 34px;

            box-shadow:

                0 35px 80px rgba(102, 58, 75, 0.18),

                0 8px 25px rgba(102, 58, 75, 0.08);

            backdrop-filter: blur(18px);

            overflow: hidden;
        }


        /* Línea superior */

        form::before {

            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 4px;

            background:
                linear-gradient(
                    90deg,
                    #c68aa0,
                    #ead0d9,
                    #c68aa0
                );
        }


        /* =========================================================
           IMAGEN
        ========================================================= */

        .imagen {

            grid-area: imagen;

            min-height: 530px;

            border-radius: 28px;

            position: relative;

            display: flex;

            justify-content: center;
            align-items: center;

            background:
                linear-gradient(
                    145deg,
                    rgba(238, 204, 215, 0.75),
                    rgba(255, 246, 249, 0.90)
                );

            background-image:

                linear-gradient(
                    rgba(255, 232, 240, 0.10),
                    rgba(255, 232, 240, 0.10)
                ),

                url("../imagenes/persona.png");

            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;

            box-shadow:

                inset 0 0 0 1px rgba(255,255,255,0.8),

                0 15px 35px rgba(105, 59, 77, 0.10);

            overflow: hidden;
        }


        /* Marco interior */

        .imagen::before {

            content: "";

            position: absolute;

            inset: 17px;

            border-radius: 23px;

            border: 1px solid rgba(167, 104, 128, 0.25);

            pointer-events: none;
        }


        /* Texto inferior */

        .imagen::after {

            content: "BELLEZA  •  CUIDADO  •  DIVINE";

            position: absolute;

            bottom: 20px;

            left: 50%;

            transform: translateX(-50%);

            width: 82%;

            padding: 10px 5px;

            text-align: center;

            border-radius: 50px;

            background: rgba(255,255,255,0.78);

            color: #8a5368;

            font-size: 9px;

            font-weight: 600;

            letter-spacing: 2px;

            backdrop-filter: blur(10px);
        }


        /* =========================================================
           TÍTULO
        ========================================================= */

        h2 {

            grid-area: titulo;

            margin-top: 5px;

            font-family: "Playfair Display", serif;

            font-size: 41px;

            font-weight: 600;

            color: #693c50;

            letter-spacing: 0.5px;

            line-height: 1.2;

            position: relative;

            width: fit-content;

            padding-bottom: 13px;
        }


        h2::after {

            content: "";

            position: absolute;

            left: 0;

            bottom: 0;

            width: 65px;

            height: 3px;

            border-radius: 20px;

            background:
                linear-gradient(
                    90deg,
                    #c76f91,
                    #e4a9bd
                );
        }


        /* =========================================================
           SUBTÍTULO
        ========================================================= */

        legend {

            grid-area: leyenda;

            display: block;

            margin-top: 5px;

            margin-bottom: 12px;

            font-family: "Playfair Display", serif;

            font-size: 17px;

            font-weight: 500;

            color: #a16d81;

            letter-spacing: 1.7px;
        }


        /* =========================================================
           CAMPOS
        ========================================================= */

        .grupo-campos {

            grid-area: campos;

            display: flex;

            flex-direction: column;

            gap: 4px;

            position: relative;

            z-index: 2;
        }


        /* =========================================================
           LABELS
        ========================================================= */

        label {

            color: #795266;

            font-size: 13px;

            font-weight: 600;

            margin-top: 7px;

            letter-spacing: 0.2px;
        }


        /* =========================================================
           INPUTS
        ========================================================= */

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {

            width: 100%;

            height: 47px;

            padding: 12px 16px;

            border: 1px solid #e4c4cf;

            border-radius: 13px;

            background: rgba(255,255,255,0.95);

            color: #603d4d;

            font-family: 'DM Sans', sans-serif;

            font-size: 13px;

            outline: none;

            transition: all 0.3s ease;
        }


        /* Placeholder */

        input::placeholder {

            color: #bca2ae;

            font-weight: 300;
        }


        /* Focus */

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {

            border-color: #c47a98;

            background: #ffffff;

            box-shadow:

                0 0 0 4px rgba(196, 122, 152, 0.10),

                0 6px 16px rgba(102, 58, 75, 0.07);

            transform: translateY(-1px);
        }


        /* =========================================================
           INPUTS OCULTOS
        ========================================================= */

        input[type="hidden"] {

            display: none;
        }


        /* =========================================================
           MENSAJES DE ERROR
        ========================================================= */

        label.error {

            color: #b4466d;

            font-size: 11px;

            font-weight: 500;

            margin-top: 2px;

            margin-bottom: 1px;
        }


        input.error,
        select.error {

            border-color: #ce7595;

            background: #fff8fa;

            box-shadow:

                0 0 0 3px rgba(206,117,149,0.08);
        }


        /* =========================================================
           CONTENEDOR DE BOTONES
        ========================================================= */

        .botones {

            grid-area: boton;

            display: flex;

            flex-direction: column;

            gap: 9px;

            position: relative;

            z-index: 3;
        }


        /* =========================================================
           BOTÓN REGISTRAR
        ========================================================= */

        input[type="submit"] {

            width: 100%;

            height: 52px;

            margin-top: 17px;

            border: none;

            border-radius: 14px;

            background:

                linear-gradient(
                    135deg,
                    #67394f,
                    #8b4c68
                );

            color: white;

            font-family: 'DM Sans', sans-serif;

            font-size: 14px;

            font-weight: 600;

            letter-spacing: 1.7px;

            cursor: pointer;

            box-shadow:

                0 10px 25px rgba(103,57,79,0.22);

            transition: all 0.3s ease;
        }


        input[type="submit"]:hover {

            background:

                linear-gradient(
                    135deg,
                    #8b4c68,
                    #b66c8a
                );

            transform: translateY(-3px);

            box-shadow:

                0 15px 30px rgba(103,57,79,0.28);
        }


        input[type="submit"]:active {

            transform: translateY(0);
        }


        /* =========================================================
           BOTÓN INICIO
        ========================================================= */

        .btn-inicio {

            width: 100%;

            height: 48px;

            border: 1px solid #d4a8b8;

            border-radius: 14px;

            background: rgba(255,255,255,0.78);

            color: #75475c;

            font-family: 'DM Sans', sans-serif;

            font-size: 13px;

            font-weight: 600;

            letter-spacing: 1.6px;

            cursor: pointer;

            transition: all 0.3s ease;
        }


        .btn-inicio:hover {

            background: #f5e0e7;

            border-color: #bd7795;

            color: #653b50;

            transform: translateY(-2px);

            box-shadow:

                0 8px 18px rgba(103,57,79,0.10);
        }


        .btn-inicio:active {

            transform: translateY(0);
        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 800px) {

            body {

                padding: 25px 15px;
            }


            form {

                max-width: 620px;

                min-height: auto;

                padding: 35px;

                grid-template-columns: 1fr;

                grid-template-areas:

                    "imagen"
                    "titulo"
                    "leyenda"
                    "campos"
                    "boton";

                gap: 10px;
            }


            .imagen {

                min-height: 290px;

                margin-bottom: 12px;
            }


            h2 {

                font-size: 35px;
            }
        }


        /* =========================================================
           CELULAR
        ========================================================= */

        @media (max-width: 500px) {

            body {

                padding: 15px 10px;
            }


            form {

                padding: 27px 21px;

                border-radius: 25px;
            }


            .imagen {

                min-height: 220px;

                border-radius: 21px;
            }


            .imagen::after {

                font-size: 7px;

                letter-spacing: 1.5px;
            }


            h2 {

                width: 100%;

                text-align: center;

                font-size: 29px;
            }


            h2::after {

                left: 50%;

                transform: translateX(-50%);
            }


            legend {

                text-align: center;

                font-size: 15px;
            }


            input[type="submit"] {

                height: 49px;

                font-size: 13px;
            }


            .btn-inicio {

                height: 46px;

                font-size: 12px;
            }
        }

    </style>

</head>


<body>


    <!-- =========================================================
         FORMULARIO DE REGISTRO
    ========================================================= -->

    <form action="createcliente.php" method="POST">


        <!-- IMAGEN -->

        <div class="imagen"></div>


        <!-- TÍTULO -->

        <h2>CREA TU CUENTA</h2>


        <!-- SUBTÍTULO -->

        <legend>DATOS PERSONALES</legend>


        <!-- CAMPOS -->

        <div class="grupo-campos">


            <!-- CI -->

            <label for="CI">
                CI:
            </label>

            <input
                type="number"
                id="CI"
                name="CI"
                placeholder="Ingrese su número de CI"
            >


            <!-- NOMBRE -->

            <label for="nombre">
                Nombre:
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Ingrese su nombre completo"
            >


            <!-- DIRECCIÓN -->

            <label for="direccion">
                Dirección:
            </label>

            <input
                type="text"
                id="direccion"
                name="direccion"
                placeholder="Ingrese su dirección"
            >


            <!-- TELÉFONO -->

            <label for="celular">
                Teléfono:
            </label>

            <input
                type="number"
                id="celular"
                name="celular"
                placeholder="Ingrese su número de teléfono"
            >


            <!-- DATOS OCULTOS -->

            <input
                type="hidden"
                name="rol"
                value="vendedor"
            >

            <input
                type="hidden"
                name="estado"
                value="ACTIVO"
            >

        </div>


        <!-- =====================================================
             BOTONES
        ====================================================== -->

        <div class="botones">

            <!-- REGISTRAR -->

            <input
                type="submit"
                value="REGISTRAR"
            >


            <!-- INICIO -->

            <button
                type="button"
                class="btn-inicio"
                onclick="window.location.href='../SESIONES/loginformcliente.php';"
            >
                INICIO
            </button>

        </div>


    </form>



    <!-- =========================================================
         VALIDACIÓN JQUERY
    ========================================================= -->

    <script>

        $(document).ready(function () {

            $("form").validate({

                rules: {

                    CI: {

                        required: true,

                        number: true,

                        minlength: 7
                    },


                    nombre: {

                        required: true,

                        minlength: 3
                    },


                    direccion: {

                        required: true,

                        minlength: 5
                    },


                    celular: {

                        required: true,

                        number: true,

                        minlength: 7,

                        maxlength: 8
                    },


                    rol: {

                        required: true
                    },


                    estado: {

                        required: true,

                        minlength: 3,

                        maxlength: 44
                    }

                },


                messages: {

                    CI: {

                        required: "Ingrese su CI",

                        number: "Solo se permiten números",

                        minlength: "El CI debe tener mínimo 7 dígitos"
                    },


                    nombre: {

                        required: "Ingrese su nombre",

                        minlength: "El nombre debe tener mínimo 3 caracteres"
                    },


                    direccion: {

                        required: "Ingrese su dirección",

                        minlength: "La dirección debe tener mínimo 5 caracteres"
                    },


                    celular: {

                        required: "Ingrese su teléfono",

                        number: "Solo se permiten números",

                        minlength: "El teléfono debe tener mínimo 7 dígitos",

                        maxlength: "El teléfono debe tener máximo 8 dígitos"
                    },


                    rol: {

                        required: "Seleccione un rol"
                    },


                    estado: {

                        required: "Ingrese el estado",

                        minlength: "El estado debe tener mínimo 3 caracteres",

                        maxlength: "Límite de caracteres excedido"
                    }

                },


                errorClass: "error",

                errorElement: "label"

            });

        });

    </script>


</body>

</html>

