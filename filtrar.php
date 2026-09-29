 <?php

/* ======================================================
   DIVINE - ASISTENTE IA + PRODUCTOS REALES

   REGLAS:

   1. Pregunta general
      -> SOLO IA
      -> NO consulta MySQL
      -> NO necesita productos

   2. Solicitud de productos
      -> IA + MYSQL

   3. Pregunta mixta
      -> IA + MYSQL
      -> Si no hay productos, LA IA IGUAL RESPONDE
====================================================== */

ini_set("display_errors", 0);
ini_set("log_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");


/* ======================================================
   OPTIONS
====================================================== */

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit();
}


/* ======================================================
   CONFIGURACIÓN NVIDIA
====================================================== */

$api_url = "https://integrate.api.nvidia.com/v1/chat/completions";


/*
=========================================================
   🔴 PON TU API KEY SOLAMENTE AQUÍ

   ESTA ES LA ÚNICA LÍNEA DEL ARCHIVO
   DONDE DEBES PONERLA.

   NO LA PONGAS OTRA VEZ ABAJO.
=========================================================
*/

$api_key = " ";


$modelo = "openai/gpt-oss-20b";


/* ======================================================
   VERIFICAR API KEY
====================================================== */

$api_key = trim($api_key);

if (
    $api_key === "" ||
    $api_key === "PEGA_AQUI_TU_API_KEY"
) {

    responderJSON([
        "ok" => false,
        "error" => "La API Key de NVIDIA no está configurada.",
        "detalle" => "Coloca tu API Key en la variable \$api_key al inicio del archivo."
    ], 500);
}


/* ======================================================
   VERIFICAR MÉTODO
====================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    responderJSON([
        "ok" => false,
        "error" => "Método no permitido. Usa POST."
    ], 405);
}


/* ======================================================
   FUNCIÓN JSON
====================================================== */

function responderJSON($datos, $codigo = 200)
{
    http_response_code($codigo);

    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

    exit();
}


/* ======================================================
   NORMALIZAR TEXTO
====================================================== */

function normalizarTexto($texto)
{
    $texto = mb_strtolower(
        trim($texto),
        "UTF-8"
    );

    $buscar = [
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "ü",
        "ñ"
    ];

    $reemplazar = [
        "a",
        "e",
        "i",
        "o",
        "u",
        "u",
        "n"
    ];

    return str_replace(
        $buscar,
        $reemplazar,
        $texto
    );
}


/* ======================================================
   LLAMAR A NVIDIA
====================================================== */

function llamarNvidia(
    $api_url,
    $api_key,
    $modelo,
    $messages,
    $temperature = 0.7
) {

    $payload = [
        "model" => $modelo,
        "messages" => $messages,
        "temperature" => $temperature,
        "max_tokens" => 1000
    ];


    $ch = curl_init($api_url);


    curl_setopt_array($ch, [

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_POST => true,

        CURLOPT_POSTFIELDS =>
            json_encode(
                $payload,
                JSON_UNESCAPED_UNICODE
            ),

        CURLOPT_HTTPHEADER => [

            "Content-Type: application/json",

            "Authorization: Bearer " . $api_key

        ],

        CURLOPT_TIMEOUT => 60,

        CURLOPT_CONNECTTIMEOUT => 15

    ]);


    $respuesta = curl_exec($ch);

    $curl_error = curl_error($ch);

    $http_code = curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );


    curl_close($ch);


    /* ==================================================
       ERROR CURL
    ================================================== */

    if (
        $respuesta === false ||
        $curl_error !== ""
    ) {

        return [

            "ok" => false,

            "error" =>
                "No se pudo conectar con NVIDIA.",

            "detalle" =>
                $curl_error

        ];
    }


    /* ==================================================
       DECODIFICAR
    ================================================== */

    $data = json_decode(
        $respuesta,
        true
    );


    if (!is_array($data)) {

        return [

            "ok" => false,

            "error" =>
                "NVIDIA no devolvió una respuesta JSON válida.",

            "codigo" =>
                $http_code,

            "respuesta" =>
                $respuesta

        ];
    }


    /* ==================================================
       ERROR DE NVIDIA
    ================================================== */

    if (
        $http_code < 200 ||
        $http_code >= 300
    ) {

        $detalle =
            "Error desconocido de NVIDIA.";


        if (
            isset(
                $data["error"]["message"]
            )
        ) {

            $detalle =
                $data["error"]["message"];

        } elseif (
            isset($data["error"]) &&
            is_string($data["error"])
        ) {

            $detalle =
                $data["error"];
        }


        return [

            "ok" => false,

            "error" =>
                "NVIDIA devolvió un error.",

            "codigo" =>
                $http_code,

            "detalle" =>
                $detalle

        ];
    }


    /* ==================================================
       OBTENER TEXTO DE IA
    ================================================== */

    $texto =
        $data["choices"][0]["message"]["content"]
        ?? "";


    if (trim($texto) === "") {

        return [

            "ok" => false,

            "error" =>
                "NVIDIA no devolvió contenido."

        ];
    }


    return [

        "ok" => true,

        "texto" =>
            trim($texto),

        "data" =>
            $data

    ];
}


/* ======================================================
   RECIBIR MENSAJE
====================================================== */

$input =
    file_get_contents("php://input");


$datos =
    json_decode(
        $input,
        true
    );


if (!is_array($datos)) {

    $datos = $_POST;
}


$mensaje = "";


foreach (
    [
        "busqueda",
        "mensaje",
        "pregunta",
        "consulta"
    ] as $campo
) {

    if (
        isset($datos[$campo]) &&
        trim((string)$datos[$campo]) !== ""
    ) {

        $mensaje =
            trim((string)$datos[$campo]);

        break;
    }
}


/* ======================================================
   VALIDAR MENSAJE
====================================================== */

if ($mensaje === "") {

    responderJSON([

        "ok" => false,

        "error" =>
            "No se recibió ninguna pregunta."

    ], 400);
}


/* ======================================================
   NORMALIZAR
====================================================== */

$q =
    normalizarTexto($mensaje);


/* ======================================================
   DETECTAR SOLICITUD REAL DE PRODUCTOS
====================================================== */

$solicitaProductos = [

    "producto",
    "productos",

    "crema",
    "cremas",

    "serum",
    "serums",

    "suero",
    "sueros",

    "shampoo",
    "champu",

    "acondicionador",

    "mascarilla",

    "aceite",
    "aceites",

    "gel",

    "tonico",
    "tonicos",

    "limpiador",
    "limpiadores",

    "protector solar",

    "bloqueador",

    "disponible",
    "disponibles",

    "disponibilidad",

    "stock",

    "precio",
    "precios",

    "cuanto cuesta",
    "cuanto cuestan",

    "cuanto vale",
    "cuanto valen",

    "que tienen",
    "que venden",

    "que ofrece divine",

    "que productos tienen",

    "productos tienen",

    "quiero comprar",

    "quiero una crema",

    "quiero un shampoo",

    "quiero un serum",

    "busco un producto",

    "busco una crema",

    "busco un shampoo",

    "busco un serum",

    "muestrame productos",

    "mostrame productos",

    "ensename productos",

    "tienen algo para",

    "tienen productos para",

    "venden productos para",

    "producto de divine",

    "productos de divine"

];


$haySolicitudProducto = false;


foreach (
    $solicitaProductos as $frase
) {

    if (
        mb_strpos(
            $q,
            $frase,
            0,
            "UTF-8"
        ) !== false
    ) {

        $haySolicitudProducto = true;

        break;
    }
}


/* ======================================================
   DETECTAR CONSEJO
====================================================== */

$solicitaConsejo = [

    "que hago",

    "como hago",

    "como cuidar",

    "como puedo cuidar",

    "que rutina",

    "rutina",

    "consejo",

    "consejos",

    "explicame",

    "explicacion",

    "por que",

    "porque",

    "como puedo",

    "que deberia hacer",

    "que puedo hacer",

    "que me recomiendas",

    "como debo",

    "que deberia usar",

    "que puedo usar",

    "que podria usar",

    "que seria bueno"

];


$haySolicitudConsejo = false;


foreach (
    $solicitaConsejo as $frase
) {

    if (
        mb_strpos(
            $q,
            $frase,
            0,
            "UTF-8"
        ) !== false
    ) {

        $haySolicitudConsejo = true;

        break;
    }
}


/* ======================================================
   DETERMINAR TIPO
====================================================== */

if (!$haySolicitudProducto) {

    $tipo = "pregunta";

} elseif ($haySolicitudConsejo) {

    $tipo = "mixta";

} else {

    $tipo = "producto";
}


/* ======================================================
   🔥 PREGUNTA ABIERTA
====================================================== */

if ($tipo === "pregunta") {


    $systemPrompt = <<<SYSTEM

Eres el asistente virtual de DIVINE.

DIVINE es un emprendimiento relacionado con belleza,
skincare y cuidado del cabello.

Tu función es responder preguntas generales de manera
natural, clara, amable y útil.

MUY IMPORTANTE:

Esta pregunta NO solicita productos de DIVINE.

Por lo tanto:

- NO debes consultar una base de datos.
- NO necesitas información de productos.
- NO debes depender de un array de productos.
- NO debes decir que no encontraste productos.
- NO debes pedir que el usuario busque un producto.
- NO debes inventar productos de DIVINE.

Puedes responder preguntas generales sobre:

- cuidado de la piel
- skincare
- cabello
- cuero cabelludo
- rutinas capilares
- rutinas faciales
- hidratación
- limpieza
- protección solar
- frizz
- cabello seco
- cabello graso
- hábitos de cuidado
- ingredientes cosméticos y su función general

Si el usuario pregunta:

"¿Cómo puedo cuidar mi cabello?"

RESPONDE DIRECTAMENTE.

Si pregunta:

"¿Cómo cuidar mi piel?"

RESPONDE DIRECTAMENTE.

Si pregunta:

"¿Qué puedo hacer para el frizz?"

RESPONDE DIRECTAMENTE.

NO conviertas una pregunta general en una búsqueda
de productos.

Responde siempre en español.

Sé natural, clara, amable y útil.

SYSTEM;


    $resultadoIA = llamarNvidia(

        $api_url,

        $api_key,

        $modelo,

        [

            [
                "role" => "system",

                "content" =>
                    $systemPrompt
            ],

            [
                "role" => "user",

                "content" =>
                    $mensaje
            ]

        ],

        0.7

    );


    /* ==================================================
       ERROR IA
    ================================================== */

    if (!$resultadoIA["ok"]) {

        responderJSON([

            "ok" => false,

            "tipo" => "pregunta",

            "busqueda" =>
                $mensaje,

            "error" =>
                $resultadoIA["error"],

            "detalle" =>
                $resultadoIA["detalle"] ?? null

        ], 500);
    }


    /* ==================================================
       🔥 AQUÍ ESTÁ EL CAMBIO IMPORTANTE
       
       NO enviamos:
       
       "productos" => []
       
       porque una pregunta general NO necesita
       productos.
    ================================================== */

    responderJSON([

        "ok" => true,

        "tipo" => "pregunta",

        "busqueda" =>
            $mensaje,

        "respuesta" =>
            $resultadoIA["texto"],

        "cantidad" => 0,

        "tiene_productos" =>
            false,

        "fuente" =>
            "ia"

    ]);
}


/* ======================================================
   DESDE AQUÍ:
   SOLAMENTE PRODUCTO O MIXTA
====================================================== */


/* ======================================================
   BASE DE DATOS
====================================================== */

$servidor = "localhost";

$usuario = "root";

$contrasena = "";

$nombreBD = "DIVINE";


$conn = new mysqli(

    $servidor,

    $usuario,

    $contrasena,

    $nombreBD

);


if ($conn->connect_error) {

    responderJSON([

        "ok" => false,

        "error" =>
            "No se pudo conectar con la base de datos DIVINE.",

        "detalle" =>
            $conn->connect_error

    ], 500);
}


$conn->set_charset("utf8mb4");


/* ======================================================
   CATEGORÍA
====================================================== */

$categoria = "";


if (
    preg_match(
        '/\b(skincare|skin care|facial|piel|rostro|cara)\b/iu',
        $mensaje
    )
) {

    $categoria = "SkinCare";
}


if (
    preg_match(
        '/\b(skinhair|skin hair|cabello|pelo|capilar|cuero cabelludo|shampoo|champu|acondicionador)\b/iu',
        $mensaje
    )
) {

    $categoria = "SkinHair";
}


/* ======================================================
   PRECIO MÁXIMO
====================================================== */

$precioMaximo = 0;


if (
    preg_match(
        '/(?:menos de|menor de|hasta|maximo|maxima|por menos de|menos de bs\.?|hasta bs\.?)\s*([0-9]+(?:[.,][0-9]+)?)/iu',
        $mensaje,
        $matchPrecio
    )
) {

    $precioMaximo =
        (float)str_replace(
            ",",
            ".",
            $matchPrecio[1]
        );
}


/* ======================================================
   TÉRMINO DE BÚSQUEDA
====================================================== */

$termino = "";


$palabrasProblema = [

    "piel grasa",

    "piel seca",

    "piel sensible",

    "piel mixta",

    "acne",

    "manchas",

    "poros",

    "arrugas",

    "hidratacion",

    "deshidratada",

    "cabello seco",

    "cabello graso",

    "cabello danado",

    "cabello dañado",

    "frizz",

    "caspa",

    "caida del cabello",

    "caida cabello",

    "puntas secas",

    "puntas abiertas"

];


foreach (
    $palabrasProblema as $problema
) {

    if (
        mb_strpos(
            $q,
            normalizarTexto($problema),
            0,
            "UTF-8"
        ) !== false
    ) {

        $termino = $problema;

        break;
    }
}


/* ======================================================
   SI NO HAY PROBLEMA, BUSCAR PRODUCTO
====================================================== */

if ($termino === "") {

    $terminosProducto = [

        "serum",

        "crema",

        "shampoo",

        "champu",

        "acondicionador",

        "mascarilla",

        "aceite",

        "tonico",

        "limpiador",

        "bloqueador",

        "protector solar",

        "gel"

    ];


    foreach (
        $terminosProducto as $tp
    ) {

        if (
            mb_strpos(
                $q,
                normalizarTexto($tp),
                0,
                "UTF-8"
            ) !== false
        ) {

            $termino = $tp;

            break;
        }
    }
}


/* ======================================================
   CONSULTA MYSQL
====================================================== */

$productos = [];


$sql = "

    SELECT

        codigo,

        nombre,

        descripcion,

        precio,

        stock,

        categoria

    FROM PRODUCTO

    WHERE 1=1

";


$parametros = [];

$tipos = "";


/* ======================================================
   CATEGORÍA
====================================================== */

if ($categoria !== "") {

    $sql .=
        " AND LOWER(categoria) = LOWER(?)";

    $tipos .= "s";

    $parametros[] =
        $categoria;
}


/* ======================================================
   PRECIO
====================================================== */

if ($precioMaximo > 0) {

    $sql .=
        " AND precio <= ?";

    $tipos .= "d";

    $parametros[] =
        $precioMaximo;
}


/* ======================================================
   TÉRMINO
====================================================== */

if ($termino !== "") {

    $sql .= "

        AND (

            LOWER(nombre) LIKE LOWER(?)

            OR

            LOWER(descripcion) LIKE LOWER(?)

        )

    ";


    $tipos .= "ss";


    $buscar =
        "%" . $termino . "%";


    $parametros[] =
        $buscar;


    $parametros[] =
        $buscar;
}


/* ======================================================
   ORDEN
====================================================== */

$sql .=
    " ORDER BY nombre ASC LIMIT 20";


/* ======================================================
   PREPARAR
====================================================== */

$stmt =
    $conn->prepare($sql);


if (!$stmt) {

    $conn->close();

    responderJSON([

        "ok" => false,

        "error" =>
            "No se pudo preparar la búsqueda de productos.",

        "detalle" =>
            $conn->error

    ], 500);
}


/* ======================================================
   BIND
====================================================== */

if ($tipos !== "") {

    $bind = [];

    $bind[] =
        $tipos;


    foreach (
        $parametros as $indice => $valor
    ) {

        $bind[] =
            &$parametros[$indice];
    }


    call_user_func_array(

        [$stmt, "bind_param"],

        $bind

    );
}


/* ======================================================
   EJECUTAR
====================================================== */

if (!$stmt->execute()) {

    $detalle =
        $stmt->error;


    $stmt->close();

    $conn->close();


    responderJSON([

        "ok" => false,

        "error" =>
            "No se pudo ejecutar la búsqueda de productos.",

        "detalle" =>
            $detalle

    ], 500);
}


/* ======================================================
   OBTENER RESULTADOS
====================================================== */

$resultado =
    $stmt->get_result();


while (
    $fila =
    $resultado->fetch_assoc()
) {

    $productos[] = [

        "id" =>
            (int)$fila["codigo"],

        "codigo" =>
            (int)$fila["codigo"],

        "nombre" =>
            $fila["nombre"],

        "descripcion" =>
            $fila["descripcion"],

        "precio" =>
            (float)$fila["precio"],

        "stock" =>
            (int)$fila["stock"],

        "categoria" =>
            $fila["categoria"]

    ];
}


$stmt->close();

$conn->close();


/* ======================================================
   CONTEXTO PRODUCTOS
====================================================== */

$contextoProductos = "";


if (
    count($productos) === 0
) {

    $contextoProductos =
        "NO SE ENCONTRARON PRODUCTOS DE DIVINE.";

} else {

    foreach (
        $productos as $producto
    ) {

        $contextoProductos .= "\n";

        $contextoProductos .=
            "Nombre: " .
            $producto["nombre"] .
            "\n";

        $contextoProductos .=
            "Descripción: " .
            $producto["descripcion"] .
            "\n";

        $contextoProductos .=
            "Precio: Bs. " .
            number_format(
                $producto["precio"],
                2,
                ".",
                ""
            ) .
            "\n";

        $contextoProductos .=
            "Stock: " .
            $producto["stock"] .
            "\n";

        $contextoProductos .=
            "Categoría: " .
            $producto["categoria"] .
            "\n";
    }
}


/* ======================================================
   PROMPT PRODUCTO
====================================================== */

if ($tipo === "producto") {

    $systemPrompt = <<<SYSTEM

Eres el asistente virtual de productos de DIVINE.

El usuario está buscando productos, precios,
disponibilidad o artículos.

Los únicos productos reales que puedes mencionar
son los que aparecen en el contexto proporcionado.

NO inventes:

- productos
- precios
- stock
- nombres
- marcas
- ingredientes
- características

Si no hay productos encontrados, dilo claramente.

Responde en español.

Sé natural, amable y clara.

SYSTEM;


    $userPrompt =

        "MENSAJE DEL USUARIO:\n" .

        $mensaje .

        "\n\nPRODUCTOS REALES DE DIVINE:\n" .

        $contextoProductos;


} else {


    /* ==================================================
       PROMPT MIXTO
    ================================================== */

    $systemPrompt = <<<SYSTEM

Eres el asistente virtual de DIVINE.

El usuario hizo una pregunta MIXTA.

Quiere:

1. Una explicación o consejo general.
2. Información sobre productos de DIVINE.

DEBES RESPONDER LAS DOS PARTES.

Primero responde el consejo general.

Después habla de los productos reales encontrados.

MUY IMPORTANTE:

Si NO existen productos:

NO detengas la respuesta.

NO respondas solamente:

"No se encontraron productos."

En ese caso debes:

1. Responder la pregunta general.
2. Informar al final que no se encontraron productos específicos de DIVINE para esa búsqueda.

NO inventes productos.

NO inventes precios.

NO inventes stock.

NO inventes ingredientes.

NO inventes beneficios específicos.

Los datos de productos deben salir exclusivamente
del contexto proporcionado.

Responde siempre en español.

SYSTEM;


    $userPrompt =

        "MENSAJE DEL USUARIO:\n" .

        $mensaje .

        "\n\nPRODUCTOS REALES DE DIVINE:\n" .

        $contextoProductos;
}


/* ======================================================
   LLAMAR IA
====================================================== */

$resultadoIA = llamarNvidia(

    $api_url,

    $api_key,

    $modelo,

    [

        [

            "role" =>
                "system",

            "content" =>
                $systemPrompt

        ],

        [

            "role" =>
                "user",

            "content" =>
                $userPrompt

        ]

    ],

    0.6

);


/* ======================================================
   ERROR IA
====================================================== */

if (!$resultadoIA["ok"]) {

    responderJSON([

        "ok" => false,

        "tipo" =>
            $tipo,

        "busqueda" =>
            $mensaje,

        "error" =>
            $resultadoIA["error"],

        "detalle" =>
            $resultadoIA["detalle"] ?? null

    ], 500);
}


/* ======================================================
   🔥 RESPUESTA FINAL
====================================================== */

$respuestaFinal = $resultadoIA["texto"];


/*
=========================================================
IMPORTANTE:

Aunque productos esté vacío:

$respuestaFinal SIGUE EXISTIENDO.

La respuesta de IA NO depende del array.
=========================================================
*/


responderJSON([

    "ok" =>
        true,

    "tipo" =>
        $tipo,

    "busqueda" =>
        $mensaje,

    "respuesta" =>
        $respuestaFinal,

    "productos" =>
        $productos,

    "cantidad" =>
        count($productos),

    "tiene_productos" =>
        count($productos) > 0,

    "filtrosAplicados" => [

        "categoria" =>
            $categoria,

        "precio_maximo" =>
            $precioMaximo,

        "termino" =>
            $termino

    ],

    "fuente" =>
        $tipo === "mixta"
            ? "ia+base_datos"
            : "ia+base_datos"

]);

?>