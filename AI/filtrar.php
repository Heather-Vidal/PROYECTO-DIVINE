
<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

/* ======================================================
   PETICIONES OPTIONS
====================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

/* ======================================================
   API KEY DE GEMINI
====================================================== */

/*
   COLOCA AQUÍ TU NUEVA API KEY DE GEMINI.

   NO coloques la API Key que publicaste anteriormente.
*/

$gemini_api_key = "      ";

/* ======================================================
   VALIDAR API KEY
====================================================== */



/* ======================================================
   SOLO POST
====================================================== */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        "error" => "Método no permitido. Usa POST."
    ], JSON_UNESCAPED_UNICODE);

    exit();
}

/* ======================================================
   CONEXIÓN A LA BASE DE DATOS DIVINE
====================================================== */

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$nombreBD = "divine";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $nombreBD
);

/* ======================================================
   COMPROBAR CONEXIÓN
====================================================== */

if ($conn->connect_error) {

    http_response_code(500);

    echo json_encode([
        "error" => "No se pudo conectar con la base de datos DIVINE.",
        "detalle" => $conn->connect_error
    ], JSON_UNESCAPED_UNICODE);

    exit();
}

/* ======================================================
   UTF-8
====================================================== */

$conn->set_charset("utf8mb4");

/* ======================================================
   RECIBIR DATOS
====================================================== */

$input = file_get_contents("php://input");

if ($input === false || trim($input) === "") {

    http_response_code(400);

    echo json_encode([
        "error" => "No se recibieron datos."
    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   DECODIFICAR JSON
====================================================== */

$datos = json_decode($input, true);

if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($datos)
) {

    http_response_code(400);

    echo json_encode([
        "error" => "El JSON recibido no es válido.",
        "detalle" => json_last_error_msg()
    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   OBTENER BÚSQUEDA
====================================================== */

$busqueda = isset($datos["busqueda"])
    ? trim((string)$datos["busqueda"])
    : "";

if ($busqueda === "") {

    http_response_code(400);

    echo json_encode([
        "error" => "Debes escribir algo para buscar."
    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   CONFIGURACIÓN DE GEMINI
====================================================== */



$url =
    "https://generativelanguage.googleapis.com/v1beta/models/"
    . $modelo
    . ":generateContent";

/* ======================================================
   PROMPT PARA GEMINI
====================================================== */

$prompt = <<<PROMPT

Eres un asistente de búsqueda para la tienda DIVINE.

DIVINE vende productos de cuidado facial, piel y cabello.

La base de datos tiene estas categorías:

- SkinCare
- SkinHair

Analiza la búsqueda del usuario y devuelve únicamente un JSON válido.

Debes extraer:

1. categoria:
   - "SkinCare" si busca productos para la piel.
   - "SkinHair" si busca productos para el cabello.
   - "" si no se puede determinar.

2. precio_maximo:
   - Si el usuario indica un precio máximo, devuelve ese número.
   - Si no indica precio máximo, devuelve 0.

3. termino:
   - Palabras importantes relacionadas con el producto.
   - Estas palabras se utilizarán para buscar dentro de nombre y descripcion.
   - No incluyas palabras generales como:
     "producto", "productos", "quiero", "necesito",
     "para", "una", "uno", "de", "del", "la",
     "el", "los", "las", "con", "que",
     "menos", "más", "mayor", "menor".
   - Si no existe un término útil, devuelve "".

Ejemplos:

Búsqueda:
"productos para hidratar la piel"

Respuesta:
{
    "categoria": "SkinCare",
    "precio_maximo": 0,
    "termino": "hidratar piel"
}

Búsqueda:
"productos para el cabello"

Respuesta:
{
    "categoria": "SkinHair",
    "precio_maximo": 0,
    "termino": ""
}

Búsqueda:
"aceites de menos de 70"

Respuesta:
{
    "categoria": "",
    "precio_maximo": 70,
    "termino": "aceite"
}

Búsqueda:
"productos para la piel de menos de 80"

Respuesta:
{
    "categoria": "SkinCare",
    "precio_maximo": 80,
    "termino": ""
}

Búsqueda:
"aceite de argán"

Respuesta:
{
    "categoria": "SkinHair",
    "precio_maximo": 0,
    "termino": "aceite argán"
}

No inventes productos, categorías ni precios.

Búsqueda del usuario:

$busqueda

PROMPT;

/* ======================================================
   PREPARAR PETICIÓN PARA GEMINI
====================================================== */

$payload = [

    "contents" => [

        [

            "role" => "user",

            "parts" => [

                [
                    "text" => $prompt
                ]

            ]

        ]

    ],

    "generationConfig" => [

        "temperature" => 0,

        "responseMimeType" => "application/json",

        "responseSchema" => [

            "type" => "OBJECT",

            "properties" => [

                "categoria" => [
                    "type" => "STRING"
                ],

                "precio_maximo" => [
                    "type" => "INTEGER"
                ],

                "termino" => [
                    "type" => "STRING"
                ]

            ],

            "required" => [

                "categoria",
                "precio_maximo",
                "termino"

            ]

        ]

    ]

];

/* ======================================================
   CONVERTIR PAYLOAD A JSON
====================================================== */

$json = json_encode(
    $payload,
    JSON_UNESCAPED_UNICODE
);

if ($json === false) {

    http_response_code(500);

    echo json_encode([
        "error" => "No se pudo crear el JSON para Gemini.",
        "detalle" => json_last_error_msg()
    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   COMPROBAR CURL
====================================================== */

if (!function_exists("curl_init")) {

    http_response_code(500);

    echo json_encode([
        "error" => "cURL no está instalado o habilitado en PHP."
    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   CONECTAR CON GEMINI
====================================================== */

$ch = curl_init();

curl_setopt_array($ch, [

    CURLOPT_URL => $url,

    CURLOPT_POST => true,

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPHEADER => [

        "Content-Type: application/json",

        "x-goog-api-key: " . $gemini_api_key

    ],

    CURLOPT_POSTFIELDS => $json,

    CURLOPT_CONNECTTIMEOUT => 10,

    CURLOPT_TIMEOUT => 30

]);

$respuesta = curl_exec($ch);

$http_code = curl_getinfo(
    $ch,
    CURLINFO_HTTP_CODE
);

$curl_error = curl_error($ch);

curl_close($ch);

/* ======================================================
   ERROR DE CONEXIÓN
====================================================== */

if ($respuesta === false) {

    http_response_code(500);

    echo json_encode([

        "error" => "No se pudo conectar con Gemini.",

        "detalle" => $curl_error

    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   DECODIFICAR RESPUESTA DE GEMINI
====================================================== */

$data = json_decode(
    $respuesta,
    true
);

if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($data)
) {

    http_response_code(500);

    echo json_encode([

        "error" => "Gemini no devolvió JSON válido.",

        "respuesta" => $respuesta

    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   ERROR DE LA API
====================================================== */

if ($http_code < 200 || $http_code >= 300) {

    $detalle = "Error desconocido.";

    if (
        isset($data["error"]["message"])
    ) {

        $detalle =
            $data["error"]["message"];

    }

    http_response_code($http_code);

    echo json_encode([

        "error" => "Error de la API de Gemini",

        "codigo" => $http_code,

        "detalle" => $detalle

    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   OBTENER TEXTO DE GEMINI
====================================================== */

if (
    !isset(
        $data["candidates"][0]["content"]["parts"][0]["text"]
    )
) {

    http_response_code(500);

    echo json_encode([

        "error" =>
            "Gemini no devolvió una respuesta utilizable.",

        "respuesta" => $data

    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

$texto =
    $data["candidates"][0]["content"]["parts"][0]["text"];

/* ======================================================
   DECODIFICAR FILTROS
====================================================== */

$filtros = json_decode(
    $texto,
    true
);

if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($filtros)
) {

    http_response_code(500);

    echo json_encode([

        "error" =>
            "La respuesta de Gemini no contiene filtros JSON válidos.",

        "respuestaGemini" => $texto

    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   OBTENER FILTROS
====================================================== */

$categoria = isset($filtros["categoria"])
    ? trim((string)$filtros["categoria"])
    : "";

$precio = isset($filtros["precio_maximo"])
    ? intval($filtros["precio_maximo"])
    : 0;

$termino = isset($filtros["termino"])
    ? trim((string)$filtros["termino"])
    : "";

/* ======================================================
   NORMALIZAR CATEGORÍA
====================================================== */

if (
    strcasecmp($categoria, "skincare") === 0
) {

    $categoria = "SkinCare";

} elseif (
    strcasecmp($categoria, "skinhair") === 0
) {

    $categoria = "SkinHair";

} else {

    $categoria = "";

}

/* ======================================================
   VALIDAR PRECIO
====================================================== */

if ($precio < 0) {

    $precio = 0;

}

/* ======================================================
   CONSULTA A LA BASE DE DATOS
====================================================== */

$sql = "

    SELECT
        codigo,
        nombre,
        descripcion,
        precio,
        stock,
        categoria

    FROM producto

    WHERE 1 = 1

";

$tipos = "";

$parametros = [];

/* ======================================================
   FILTRO POR CATEGORÍA
====================================================== */

if ($categoria !== "") {

    $sql .= "
        AND categoria = ?
    ";

    $tipos .= "s";

    $parametros[] = $categoria;

}

/* ======================================================
   FILTRO POR PRECIO
====================================================== */

if ($precio > 0) {

    $sql .= "
        AND precio <= ?
    ";

    $tipos .= "i";

    $parametros[] = $precio;

}

/* ======================================================
   FILTRO POR TÉRMINOS
====================================================== */

if ($termino !== "") {

    $terminos = preg_split(

        '/\s+/u',

        mb_strtolower(
            $termino,
            "UTF-8"
        ),

        -1,

        PREG_SPLIT_NO_EMPTY

    );

    $palabrasIgnoradas = [

        "producto",
        "productos",
        "quiero",
        "necesito",
        "para",
        "una",
        "uno",
        "unos",
        "unas",
        "de",
        "del",
        "la",
        "el",
        "los",
        "las",
        "con",
        "que",
        "menos",
        "más",
        "mayor",
        "menor"

    ];

    foreach ($terminos as $palabra) {

        $palabra = trim($palabra);

        if ($palabra === "") {
            continue;
        }

        if (
            mb_strlen(
                $palabra,
                "UTF-8"
            ) < 3
        ) {
            continue;
        }

        if (
            in_array(
                $palabra,
                $palabrasIgnoradas,
                true
            )
        ) {
            continue;
        }

        $sql .= "

            AND (

                LOWER(nombre) LIKE ?

                OR

                LOWER(descripcion) LIKE ?

            )

        ";

        $tipos .= "ss";

        $valorBusqueda =
            "%" .
            $palabra .
            "%";

        $parametros[] =
            $valorBusqueda;

        $parametros[] =
            $valorBusqueda;

    }

}

/* ======================================================
   ORDENAR RESULTADOS
====================================================== */

$sql .= "

    ORDER BY nombre ASC

";

/* ======================================================
   PREPARAR CONSULTA
====================================================== */

$stmt = $conn->prepare($sql);

if (!$stmt) {

    http_response_code(500);

    echo json_encode([

        "error" =>
            "No se pudo preparar la consulta a la base de datos.",

        "detalle" =>
            $conn->error

    ], JSON_UNESCAPED_UNICODE);

    $conn->close();

    exit();
}

/* ======================================================
   ASIGNAR PARÁMETROS
====================================================== */

if ($tipos !== "") {

    $bind = [];

    $bind[] = $tipos;

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
   EJECUTAR CONSULTA
====================================================== */

if (!$stmt->execute()) {

    http_response_code(500);

    echo json_encode([

        "error" =>
            "No se pudo ejecutar la búsqueda.",

        "detalle" =>
            $stmt->error

    ], JSON_UNESCAPED_UNICODE);

    $stmt->close();

    $conn->close();

    exit();
}

/* ======================================================
   OBTENER RESULTADOS
====================================================== */

$resultado = $stmt->get_result();

$productos = [];

/* ======================================================
   RECORRER PRODUCTOS
====================================================== */

while (
    $fila = $resultado->fetch_assoc()
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
            (int)$fila["precio"],

        "stock" =>
            (int)$fila["stock"],

        "categoria" =>
            $fila["categoria"]

    ];

}

/* ======================================================
   CERRAR
====================================================== */

$stmt->close();

$conn->close();

/* ======================================================
   RESPUESTA FINAL
====================================================== */

echo json_encode(

    [

        "ok" => true,

        "busqueda" =>
            $busqueda,

        "filtrosAplicados" => [

            "categoria" =>
                $categoria,

            "precio_maximo" =>
                $precio,

            "termino" =>
                $termino

        ],

        "cantidad" =>
            count($productos),

        "productos" =>
            $productos

    ],

    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT

);

exit();

?>

