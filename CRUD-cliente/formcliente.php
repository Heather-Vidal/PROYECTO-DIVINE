 
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro - DIVINE</title>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <!-- JQUERY VALIDATE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

    <!-- FUENTES -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>

        /* =====================================================
           CONFIGURACIÓN GENERAL
        ===================================================== */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;

            font-family: 'Poppins', sans-serif;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 40px 20px;

            background-color: #e9e5dd;

            background-image: url("../imagenes/fondote.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            position: relative;
        }

        /* Capa suave sobre el fondo */
        body::before {
            content: "";
            position: fixed;
            inset: 0;

            background: rgba(255, 255, 255, 0.18);

            z-index: -1;
        }


        /* =====================================================
           FORMULARIO PRINCIPAL
        ===================================================== */

        form {
            position: relative;

            width: 100%;
            max-width: 900px;

            min-height: 560px;

            padding: 42px 48px;

            display: grid;

            grid-template-columns: 0.9fr 1.4fr;

            grid-template-rows: auto auto 1fr auto;

            grid-template-areas:
                "imagen titulo"
                "imagen leyenda"
                "imagen campos"
                "imagen boton";

            column-gap: 45px;
            row-gap: 10px;

            background: rgba(255, 212, 234, 0.94);

            border: 1px solid rgba(255, 255, 255, 0.8);

            border-radius: 28px;

            box-shadow:
                0 25px 60px rgba(90, 45, 68, 0.25),
                0 5px 15px rgba(0, 0, 0, 0.08);

            backdrop-filter: blur(5px);

            overflow: hidden;
        }


        /* Decoraciones */
        form::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.20);

            top: -90px;
            right: -60px;
        }

        form::after {
            content: "";

            position: absolute;

            width: 120px;
            height: 120px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.15);

            bottom: -65px;
            left: -45px;
        }


        /* =====================================================
           IMAGEN
        ===================================================== */

        .imagen {
            grid-area: imagen;

            min-height: 430px;

            border-radius: 22px;

            background-image:
                linear-gradient(
                    rgba(139, 79, 107, 0.08),
                    rgba(139, 79, 107, 0.08)
                ),
                url("../imagenes/persona.png");

            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;

            position: relative;

            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        /* Marco decorativo */
        .imagen::before {
            content: "";

            position: absolute;

            width: 85%;
            height: 85%;

            border: 1px solid rgba(139, 79, 107, 0.25);

            border-radius: 25px;

            pointer-events: none;
        }


        /* =====================================================
           TÍTULO
        ===================================================== */

        h2 {
            grid-area: titulo;

            margin: 5px 0 2px;

            font-family: "Playfair Display", serif;

            font-size: 36px;

            font-weight: 700;

            color: #713b55;

            letter-spacing: 1.5px;

            line-height: 1.2;

            position: relative;

            width: fit-content;

            padding-bottom: 10px;
        }

        h2::after {
            content: "";

            position: absolute;

            left: 0;
            bottom: 0;

            width: 75px;
            height: 3px;

            border-radius: 10px;

            background: #d85b94;
        }


        /* =====================================================
           LEYENDA
        ===================================================== */

        legend {
            grid-area: leyenda;

            display: block;

            margin-top: 4px;
            margin-bottom: 10px;

            color: #8b4f6b;

            font-family: "Playfair Display", serif;

            font-size: 18px;

            font-weight: 600;

            letter-spacing: 1px;
        }


        /* =====================================================
           GRUPO DE CAMPOS
        ===================================================== */

        .grupo-campos {
            grid-area: campos;

            display: flex;

            flex-direction: column;

            gap: 6px;

            position: relative;

            z-index: 2;
        }


        /* =====================================================
           LABELS
        ===================================================== */

        label {
            color: #864763;

            font-size: 14px;

            font-weight: 500;

            margin-top: 5px;

            letter-spacing: 0.2px;
        }


        /* =====================================================
           INPUTS
        ===================================================== */

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {

            width: 100%;

            padding: 13px 15px;

            border: 1px solid #d5a5ba;

            border-radius: 11px;

            font-family: 'Poppins', sans-serif;

            font-size: 14px;

            color: #5e3045;

            background: rgba(255, 255, 255, 0.96);

            outline: none;

            transition:
                border-color 0.3s ease,
                box-shadow 0.3s ease,
                transform 0.2s ease;
        }


        /* Placeholder */
        input::placeholder {
            color: #b89aaa;
        }


        /* Focus */
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {

            border-color: #b94f7e;

            box-shadow:
                0 0 0 3px rgba(216, 91, 148, 0.13);

            transform: translateY(-1px);
        }


        /* =====================================================
           OCULTOS
        ===================================================== */

        input[type="hidden"] {
            display: none;
        }


        /* =====================================================
           MENSAJES DE VALIDACIÓN
        ===================================================== */

        label.error {
            color: #b3295d;

            font-size: 12px;

            font-weight: 500;

            margin-top: 2px;
            margin-bottom: 2px;
        }

        input.error,
        select.error {

            border-color: #c94c75;

            background: #fff8fa;

            box-shadow: 0 0 0 2px rgba(201, 76, 117, 0.08);
        }


        /* =====================================================
           BOTÓN
        ===================================================== */

        input[type="submit"] {

            grid-area: boton;

            position: relative;

            z-index: 3;

            width: 100%;

            margin-top: 12px;

            padding: 14px 20px;

            border: none;

            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #63364b,
                #7d415e
            );

            color: #ffffff;

            font-family: 'Poppins', sans-serif;

            font-size: 16px;

            font-weight: 600;

            letter-spacing: 1px;

            cursor: pointer;

            box-shadow:
                0 8px 18px rgba(99, 54, 75, 0.28);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease;
        }

        input[type="submit"]:hover {

            background: linear-gradient(
                135deg,
                #b85d87,
                #c96b98
            );

            transform: translateY(-2px);

            box-shadow:
                0 10px 22px rgba(99, 54, 75, 0.30);
        }

        input[type="submit"]:active {
            transform: translateY(0);
        }


        /* =====================================================
           RESPONSIVE - TABLET
        ===================================================== */

        @media (max-width: 800px) {

            body {
                padding: 25px 15px;
            }

            form {

                max-width: 600px;

                min-height: auto;

                padding: 35px;

                grid-template-columns: 1fr;

                grid-template-rows: auto;

                grid-template-areas:
                    "imagen"
                    "titulo"
                    "leyenda"
                    "campos"
                    "boton";

                gap: 12px;
            }

            .imagen {

                min-height: 260px;

                margin-bottom: 8px;
            }

            h2 {
                font-size: 32px;
            }

            legend {
                margin-bottom: 8px;
            }
        }


        /* =====================================================
           RESPONSIVE - CELULAR
        ===================================================== */

        @media (max-width: 500px) {

            body {
                padding: 15px 10px;
            }

            form {

                padding: 28px 22px;

                border-radius: 22px;
            }

            .imagen {

                min-height: 210px;
            }

            h2 {

                font-size: 27px;

                text-align: center;

                width: 100%;
            }

            h2::after {

                left: 50%;

                transform: translateX(-50%);
            }

            legend {

                text-align: center;

                font-size: 16px;
            }

            input[type="submit"] {

                font-size: 15px;

                padding: 13px;
            }
        }

    </style>

</head>


<body>


    <!-- =====================================================
         FORMULARIO DE REGISTRO
    ====================================================== -->

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
            <label for="CI">CI:</label>

            <input
                type="number"
                id="CI"
                name="CI"
                placeholder="Ingrese su número de CI"
            >


            <!-- NOMBRE -->
            <label for="nombre">Nombre:</label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Ingrese su nombre completo"
            >


            <!-- DIRECCIÓN -->
            <label for="direccion">Dirección:</label>

            <input
                type="text"
                id="direccion"
                name="direccion"
                placeholder="Ingrese su dirección"
            >


            <!-- TELÉFONO -->
            <label for="celular">Teléfono:</label>

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


        <!-- BOTÓN -->
        <input
            type="submit"
            value="Registrar"
        >

    </form>



    <!-- =====================================================
         VALIDACIÓN JQUERY
    ====================================================== -->

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
                        minlength: "El teléfono debe tener mínimo 6 dígitos",
                        maxlength: "El teléfono debe tener máximo 11 dígitos"
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
 