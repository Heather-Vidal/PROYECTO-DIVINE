<?php
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Deja tu mensaje | DIVINE</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <section class="form-panel">

      

        <h1>
            Deja tu mensaje
        </h1>

        <p class="descripcion">
            Escribe tu nombre y déjanos unas palabras.
            Tu mensaje será guardado con mucho cariño.
        </p>

        <!-- FORMULARIO -->

        <form action="comentar.php" method="POST">

            <div class="campo">

                <label for="autor">
                    Nombre
                </label>

                <input
                    type="text"
                    id="autor"
                    name="autor"
                    placeholder="¿Cómo te llamas?"
                    autocomplete="name"
                    required
                >

            </div>


            <div class="campo">

                <label for="contenido">
                    Mensaje
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    placeholder="Escribe algo bonito..."
                    required
                ></textarea>

            </div>


            <button type="submit">
                Publicar mi mensaje &nbsp; ♡
            </button>

        </form>


      
</body>

</html>