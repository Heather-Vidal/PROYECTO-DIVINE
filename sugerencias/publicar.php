<?php 
$archivo = 'mensajes.txt'; 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $autor = trim($_POST['autor']); 
    $contenido = trim($_POST['contenido']); 
 
    $fecha = date("Y-m-d H:i:s"); 
    $entrada = "$fecha | $autor: $contenido" . PHP_EOL; 
 
    $f = fopen($archivo, 'a'); 
    fwrite($f, $entrada); 
    fclose($f); 
 
    // Redirige a la página donde se muestran los comentarios
    header("Location: comentarios.php"); 
    exit;
} 
?> 
 
<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar comentario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
              background-image: url("../imagenes/fondi.png");
                  background-repeat: no-repeat;
                  background-size:100%;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            /* Centrar el formulario */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .formulario {
            background-color: #492d3b;
            width: 90%;
            max-width: 500px;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(190, 80, 120, 0.25);
        }
        h1 {
            text-align: center;
            color: #d63384;
            margin-bottom: 25px;
            font-size: 28px;
        }
        label {
            display: block;
            color: #b02a68;
            font-weight: bold;
            margin-bottom: 8px;
        }
        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #f3b6ca;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            font-family: Arial, sans-serif;
            margin-bottom: 18px;
            transition: 0.3s;
        }
        input:focus,
        textarea:focus {
            border-color: #d63384;
            box-shadow: 0 0 6px rgba(214, 51, 132, 0.25);
        }
        textarea {
            resize: none;
        }
        button {
            width: 100%;
            padding: 13px;
            background-color: #d63384;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #b02a68;
            transform: translateY(-2px);
        }

        .decoracion {
            text-align: center;
            color: #f08aaa;
            font-size: 22px;
            margin-bottom: 10px;
        }

    </style> 
</head> 

<body> 

    <div class="formulario">

        <div class="decoracion">
            ♡ ♡ ♡
        </div>

        <h1>Escribe tu comentario</h1> 
 
        <form method="POST"> 

            <label for="autor">Nombre</label>
            <input 
                type="text" 
                id="autor"
                name="autor" 
                placeholder="Tu nombre" 
                required
            >

            <label for="contenido">Comentario</label>
            <textarea 
                id="contenido"
                name="contenido" 
                rows="5" 
                placeholder="Escribe algo..."
                required
            ></textarea>

            <button type="submit">Publicar comentario</button> 

        </form> 

    </div>
 
</body> 
</html>
