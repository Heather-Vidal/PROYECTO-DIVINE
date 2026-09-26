<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}


// ======================================================
// API KEY
// ======================================================

// PON AQUÍ TU NUEVA API KEY.
// NO USES LA API KEY QUE PUBLICASTE ANTES.

$gemini_api_key = "TU_NUEVA_CLAVE_AQUI";

if (
    empty($gemini_api_key) ||
    $gemini_api_key === "TU_NUEVA_CLAVE_AQUI"
) {
    http_response_code(500);

    echo json_encode([
        "error" => "Debes colocar tu nueva API Key de Gemini en filtrar.php."
    ]);

    exit();
}


// ======================================================
// SOLO POST
// ======================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        "error" => "Método no permitido. Usa POST."
    ]);

    exit();
}


// ======================================================
// PRODUCTOS
// ======================================================

$productos = [

    [
        "id" => 1,
        "nombre" => "MacBook Air",
        "categoria" => "laptop",
        "precio" => 999,
        "color" => "gris"
    ],

    [
        "id" => 2,
        "nombre" => "Lenovo IdeaPad",
        "categoria" => "laptop",
        "precio" => 450,
        "color" => "negro"
    ],

    [
        "id" => 3,
        "nombre" => "iPhone 15",
        "categoria" => "telefono",
        "precio" => 799,
        "color" => "negro"
    ],

    [
        "id" => 4,
        "nombre" => "Samsung Galaxy S24",
        "categoria" => "telefono",
        "precio" => 850,
        "color" => "blanco"
    ]

];


// ======================================================
// RECIBIR DATOS
// ======================================================

$input = file_get_contents("php://input");

if ($input === false || trim($input) === "") {

    http_response_code(400);

    echo json_encode([
        "error" => "No se recibieron datos."
    ]);

    exit();
}


$datos = json_decode($input, true);

if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($datos)
) {

    http_response_code(400);

    echo json_encode([
        "error" => "El JSON recibido no es válido.",
        "detalle" => json_last_error_msg()
    ]);

    exit();
}


$busqueda = isset($datos["busqueda"])
    ? trim((string)$datos["busqueda"])
    : "";


if ($busqueda === "") {

    http_response_code(400);

    echo json_encode([
        "error" => "Debes escribir algo para buscar."
    ]);

    exit();
}


// ======================================================
// GEMINI
// ======================================================

$modelo = "gemini-2.5-flash";

$url =
    "https://generativelanguage.googleapis.com/v1beta/models/"
    . $modelo
    . ":generateContent";


// ======================================================
// PROMPT
// ======================================================

$prompt = <<<PROMPT
Analiza esta búsqueda de productos.

Extrae solamente:

categoria:
- "laptop"
- "telefono"
- ""

precio_maximo:
- número entero
- 0 si no existe precio máximo

color:
- color indicado
- "" si no existe color

No inventes información.

Ejemplo:

laptop negra de menos de 600

Debe producir:

{
  "categoria": "laptop",
  "precio_maximo": 600,
  "color": "negro"
}

Búsqueda:

$busqueda
PROMPT;


// ======================================================
// PETICIÓN
// ======================================================

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

                "color" => [
                    "type" => "STRING"
                ]

            ],

            "required" => [
                "categoria",
                "precio_maximo",
                "color"
            ]
        ]
    ]
];


$json = json_encode(
    $payload,
    JSON_UNESCAPED_UNICODE
);


if ($json === false) {

    http_response_code(500);

    echo json_encode([
        "error" => "No se pudo crear el JSON para Gemini.",
        "detalle" => json_last_error_msg()
    ]);

    exit();
}


// ======================================================
// CURL
// ======================================================

if (!function_exists("curl_init")) {

    http_response_code(500);

    echo json_encode([
        "error" => "cURL no está instalado o habilitado en PHP."
    ]);

    exit();
}


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

$http_code =
    curl_getinfo($ch, CURLINFO_HTTP_CODE);

$curl_error =
    curl_error($ch);


curl_close($ch);


// ======================================================
// ERROR DE CONEXIÓN
// ======================================================

if ($respuesta === false) {

    http_response_code(500);

    echo json_encode([
        "error" => "No se pudo conectar con Gemini.",
        "detalle" => $curl_error
    ]);

    exit();
}


// ======================================================
// RESPUESTA GEMINI
// ======================================================

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
    ]);

    exit();
}


// ======================================================
// ERROR API
// ======================================================

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

    ]);

    exit();
}


// ======================================================
// OBTENER TEXTO
// ======================================================

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

    ]);

    exit();
}


$texto =
    $data["candidates"][0]["content"]["parts"][0]["text"];


// ======================================================
// DECODIFICAR FILTROS
// ======================================================

$filtros =
    json_decode($texto, true);


if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($filtros)
) {

    http_response_code(500);

    echo json_encode([

        "error" =>
            "La respuesta de Gemini no contiene filtros JSON válidos.",

        "respuestaGemini" => $texto

    ]);

    exit();
}


// ======================================================
// NORMALIZAR
// ======================================================

$categoria = isset($filtros["categoria"])
    ? strtolower(trim((string)$filtros["categoria"]))
    : "";


$color = isset($filtros["color"])
    ? strtolower(trim((string)$filtros["color"]))
    : "";


$precio = isset($filtros["precio_maximo"])
    ? intval($filtros["precio_maximo"])
    : 0;


if ($categoria === "null") {
    $categoria = "";
}


if ($color === "null") {
    $color = "";
}


if (
    $categoria !== "laptop" &&
    $categoria !== "telefono"
) {

    $categoria = "";
}


if ($precio < 0) {
    $precio = 0;
}


// ======================================================
// FILTROS
// ======================================================

$filtros_finales = [

    "categoria" => $categoria,

    "precio_maximo" => $precio,

    "color" => $color

];


// ======================================================
// BUSCAR PRODUCTOS
// ======================================================

$resultados = array_filter(

    $productos,

    function ($producto) use ($filtros_finales) {


        if (
            $filtros_finales["categoria"] !== "" &&
            strtolower($producto["categoria"])
            !==
            $filtros_finales["categoria"]
        ) {

            return false;
        }


        if (
            $filtros_finales["color"] !== "" &&
            strtolower($producto["color"])
            !==
            $filtros_finales["color"]
        ) {

            return false;
        }


        if (
            $filtros_finales["precio_maximo"] > 0 &&
            $producto["precio"] >
            $filtros_finales["precio_maximo"]
        ) {

            return false;
        }


        return true;
    }
);


// ======================================================
// RESPUESTA
// ======================================================

echo json_encode(

    [

        "ok" => true,

        "busqueda" => $busqueda,

        "filtrosAplicados" =>
            $filtros_finales,

        "productos" =>
            array_values($resultados)

    ],

    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT

);

exit();

?>
