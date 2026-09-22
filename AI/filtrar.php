<?php

// ======================================================
// CONFIGURACIÓN GENERAL
// ======================================================

// No mostrar errores PHP como HTML
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Headers para permitir conexión desde el frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

// Responder correctamente a petición OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}


// ======================================================
// MANEJO DE ERRORES FATALES DE PHP
// ======================================================

register_shutdown_function(function () {

    $error = error_get_last();

    if (
        $error !== null &&
        (
            $error['type'] === E_ERROR ||
            $error['type'] === E_PARSE ||
            $error['type'] === E_COMPILE_ERROR ||
            $error['type'] === E_CORE_ERROR
        )
    ) {

        http_response_code(500);

        echo json_encode([
            "error" => "Error interno de PHP",
            "detalle" => $error['message'],
            "linea" => $error['line']
        ]);

        exit();
    }
});


// ======================================================
// API KEY DE GEMINI
// ======================================================

// ⚠️ COLOCA AQUÍ TU API KEY REAL DE GOOGLE AI STUDIO
$gemini_api_key = "AQ.Ab8RN6JlYgfG5BAY_Z3nhVoa3AHjbMzMDc4nAKgrekwvjO45hg";


// Comprobar que sí se colocó una API Key
if (
    empty($gemini_api_key) ||
    $gemini_api_key === "AQ.Ab8RN6JlYgfG5BAY_Z3nhVoa3AHjbMzMDc4nAKgrekwvjO45hg"
) {

    http_response_code(500);

    echo json_encode([
        "error" => "No has colocado tu API Key de Gemini en filtrar.php."
    ]);

    exit();
}


// ======================================================
// PRODUCTOS DE EJEMPLO
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
// SOLO ACEPTAR POST
// ======================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        "error" => "Método no permitido. Debes usar POST."
    ]);

    exit();
}


// ======================================================
// LEER INFORMACIÓN ENVIADA POR JAVASCRIPT
// ======================================================

$input_json = file_get_contents("php://input");

if ($input_json === false || empty($input_json)) {

    http_response_code(400);

    echo json_encode([
        "error" => "No se recibieron datos desde index.html."
    ]);

    exit();
}


$input_data = json_decode($input_json, true);


// Comprobar JSON
if (json_last_error() !== JSON_ERROR_NONE) {

    http_response_code(400);

    echo json_encode([
        "error" => "El JSON recibido no es válido.",
        "detalle" => json_last_error_msg()
    ]);

    exit();
}


// Obtener búsqueda
$busqueda = isset($input_data["busqueda"])
    ? trim($input_data["busqueda"])
    : "";


// Comprobar búsqueda
if ($busqueda === "") {

    http_response_code(400);

    echo json_encode([
        "error" => "Debes escribir algo para buscar."
    ]);

    exit();
}


// ======================================================
// URL CORRECTA DE GEMINI
// ======================================================

$modelo = "gemini-2.5-flash";

$url =
    "https://generativelanguage.googleapis.com/v1beta/models/"
    . $modelo
    . ":generateContent?key="
    . urlencode($gemini_api_key);


// ======================================================
// PROMPT QUE RECIBIRÁ GEMINI
// ======================================================

$prompt = '
Analiza la búsqueda de un usuario para una tienda.

Debes extraer exactamente estos campos:

categoria:
- laptop
- telefono
- o cadena vacía si no menciona categoría

precio_maximo:
- número entero
- 0 si no menciona precio máximo

color:
- color mencionado
- cadena vacía si no menciona color

Búsqueda del usuario:
"' . $busqueda . '"
';


// ======================================================
// DATOS ENVIADOS A GEMINI
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


// Convertir datos a JSON
$json_payload = json_encode($payload);

if ($json_payload === false) {

    http_response_code(500);

    echo json_encode([
        "error" => "PHP no pudo convertir la petición a JSON."
    ]);

    exit();
}


// ======================================================
// CONEXIÓN CON GEMINI USANDO CURL
// ======================================================

if (!function_exists("curl_init")) {

    http_response_code(500);

    echo json_encode([
        "error" => "Tu instalación de PHP no tiene habilitado cURL."
    ]);

    exit();
}


$ch = curl_init();

curl_setopt_array($ch, [

    CURLOPT_URL => $url,

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_POST => true,

    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],

    CURLOPT_POSTFIELDS => $json_payload,

    CURLOPT_TIMEOUT => 30,

    CURLOPT_CONNECTTIMEOUT => 10

]);


$response = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$curl_error = curl_error($ch);

curl_close($ch);


// ======================================================
// ERROR DE CONEXIÓN
// ======================================================

if ($response === false) {

    http_response_code(500);

    echo json_encode([
        "error" => "No se pudo conectar con la API de Gemini.",
        "detalle" => $curl_error
    ]);

    exit();
}


// ======================================================
// CONVERTIR RESPUESTA DE GOOGLE
// ======================================================

$data = json_decode($response, true);


if (json_last_error() !== JSON_ERROR_NONE) {

    http_response_code(500);

    echo json_encode([
        "error" => "Gemini devolvió una respuesta que no es JSON.",
        "respuesta" => $response
    ]);

    exit();
}


// ======================================================
// ERRORES DEVUELTOS POR GOOGLE
// ======================================================

if ($http_code < 200 || $http_code >= 300) {

    $mensajeGoogle = "Error desconocido de Gemini.";

    if (isset($data["error"]["message"])) {
        $mensajeGoogle = $data["error"]["message"];
    }

    http_response_code($http_code);

    echo json_encode([
        "error" => "Error de la API de Gemini",
        "codigo" => $http_code,
        "detalle" => $mensajeGoogle
    ]);

    exit();
}


// ======================================================
// COMPROBAR QUE GEMINI HAYA GENERADO RESPUESTA
// ======================================================

if (
    !isset($data["candidates"][0]["content"]["parts"][0]["text"])
) {

    http_response_code(500);

    echo json_encode([
        "error" => "Gemini no devolvió una respuesta utilizable.",
        "respuesta_completa" => $data
    ]);

    exit();
}


// Obtener JSON generado por Gemini
$texto_json =
    $data["candidates"][0]["content"]["parts"][0]["text"];


// ======================================================
// CONVERTIR FILTROS DE GEMINI
// ======================================================

$filtros_ai = json_decode($texto_json, true);


if (
    json_last_error() !== JSON_ERROR_NONE ||
    !is_array($filtros_ai)
) {

    http_response_code(500);

    echo json_encode([
        "error" => "Gemini respondió, pero sus filtros no son JSON válido.",
        "respuestaGemini" => $texto_json
    ]);

    exit();
}


// ======================================================
// NORMALIZAR LOS FILTROS
// ======================================================

$categoria = isset($filtros_ai["categoria"])
    ? trim(strtolower($filtros_ai["categoria"]))
    : "";


$color = isset($filtros_ai["color"])
    ? trim(strtolower($filtros_ai["color"]))
    : "";


$precio_maximo = isset($filtros_ai["precio_maximo"])
    ? intval($filtros_ai["precio_maximo"])
    : 0;


// Evitar valores "null"
if ($categoria === "null") {
    $categoria = "";
}

if ($color === "null") {
    $color = "";
}


// Guardar filtros normalizados
$filtros_ai = [

    "categoria" => $categoria,

    "precio_maximo" => $precio_maximo,

    "color" => $color

];


// ======================================================
// FILTRAR LOS PRODUCTOS
// ======================================================

$resultado = array_filter(

    $productos,

    function ($producto) use ($filtros_ai) {


        // FILTRO CATEGORÍA
        if (
            $filtros_ai["categoria"] !== "" &&
            strtolower($producto["categoria"])
            !==
            $filtros_ai["categoria"]
        ) {

            return false;
        }


        // FILTRO COLOR
        if (
            $filtros_ai["color"] !== "" &&
            strtolower($producto["color"])
            !==
            $filtros_ai["color"]
        ) {

            return false;
        }


        // FILTRO PRECIO
        if (
            $filtros_ai["precio_maximo"] > 0 &&
            $producto["precio"] >
            $filtros_ai["precio_maximo"]
        ) {

            return false;
        }


        return true;
    }

);


// ======================================================
// RESPUESTA FINAL
// ======================================================

http_response_code(200);

echo json_encode(

    [

        "ok" => true,

        "busqueda" => $busqueda,

        "filtrosAplicados" => $filtros_ai,

        "productos" => array_values($resultado)

    ],

    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT

);

exit();

?>