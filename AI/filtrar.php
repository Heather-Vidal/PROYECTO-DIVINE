<?php

/* ======================================================
   DIVINE - ASISTENTE IA + PRODUCTOS REALES
   VERSION: PREGUNTAS ABIERTAS SIN BD

   REGLA PRINCIPAL:
   - Pregunta abierta/general -> SOLO IA.
   - Solicitud explícita de productos -> BD.
   - Pregunta general + solicitud explícita de productos -> IA + BD.

   La IA NO decide si debe consultar la BD.
   PHP determina primero la intención mediante reglas.
====================================================== */

ini_set("display_errors", 0);
ini_set("log_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit();
}

/* ======================================================
   CONFIGURACIÓN NVIDIA
====================================================== */

$api_url = "https://integrate.api.nvidia.com/v1/chat/completions";
$api_key = " "; // <-- COLOCA AQUÍ TU API KEY REAL
$modelo = "openai/gpt-oss-20b";

if (trim($api_key) === "") {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "La API Key de NVIDIA está vacía."
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "ok" => false,
        "error" => "Método no permitido. Usa POST."
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

/* ======================================================
   FUNCIONES
====================================================== */

function responderJSON($datos, $codigo = 200)
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit();
}

function normalizarTexto($texto)
{
    $texto = mb_strtolower(trim($texto), "UTF-8");

    $buscar = [
        "á", "é", "í", "ó", "ú", "ü", "ñ"
    ];

    $reemplazar = [
        "a", "e", "i", "o", "u", "u", "n"
    ];

    return str_replace($buscar, $reemplazar, $texto);
}

function llamarNvidia($api_url, $api_key, $modelo, $messages, $temperature = 0.7)
{
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
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer " . $api_key
        ],
        CURLOPT_TIMEOUT => 60,
        CURLOPT_CONNECTTIMEOUT => 15
    ]);

    $respuesta = curl_exec($ch);
    $curl_error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($respuesta === false || $curl_error !== "") {
        return [
            "ok" => false,
            "error" => "No se pudo conectar con NVIDIA.",
            "detalle" => $curl_error
        ];
    }

    $data = json_decode($respuesta, true);

    if (!is_array($data)) {
        return [
            "ok" => false,
            "error" => "NVIDIA no devolvió una respuesta JSON válida.",
            "codigo" => $http_code,
            "respuesta" => $respuesta
        ];
    }

    if ($http_code < 200 || $http_code >= 300) {
        $detalle = "Error desconocido de NVIDIA.";

        if (isset($data["error"]["message"])) {
            $detalle = $data["error"]["message"];
        } elseif (isset($data["error"]) && is_string($data["error"])) {
            $detalle = $data["error"];
        }

        return [
            "ok" => false,
            "error" => "NVIDIA devolvió un error.",
            "codigo" => $http_code,
            "detalle" => $detalle
        ];
    }

    $texto = $data["choices"][0]["message"]["content"] ?? "";

    if (trim($texto) === "") {
        return [
            "ok" => false,
            "error" => "NVIDIA no devolvió contenido."
        ];
    }

    return [
        "ok" => true,
        "texto" => trim($texto),
        "data" => $data
    ];
}

/* ======================================================
   RECIBIR MENSAJE
====================================================== */

$input = file_get_contents("php://input");
$datos = json_decode($input, true);

if (!is_array($datos)) {
    $datos = $_POST;
}

$mensaje = "";

foreach (["busqueda", "mensaje", "pregunta", "consulta"] as $campo) {
    if (isset($datos[$campo]) && trim((string)$datos[$campo]) !== "") {
        $mensaje = trim((string)$datos[$campo]);
        break;
    }
}

if ($mensaje === "") {
    responderJSON([
        "ok" => false,
        "error" => "No se recibió ninguna pregunta."
    ], 400);
}

/* ======================================================
   DETECCIÓN DE INTENCIÓN

   IMPORTANTE:
   AQUÍ NO SE USA IA PARA DECIDIR SI CONSULTAR LA BD.

   Solo se consulta la BD cuando el usuario utiliza una
   expresión que realmente pide productos, disponibilidad,
   precios, compra o artículos de DIVINE.
====================================================== */

$q = normalizarTexto($mensaje);

/* ------------------------------------------------------
   PALABRAS / FRASES QUE SÍ SIGNIFICAN "QUIERO PRODUCTOS"
------------------------------------------------------ */

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
    "productos de divine",
    "de divine"
];

$haySolicitudProducto = false;

foreach ($solicitaProductos as $frase) {
    if (mb_strpos($q, $frase, 0, "UTF-8") !== false) {
        $haySolicitudProducto = true;
        break;
    }
}

/* ------------------------------------------------------
   PALABRAS QUE INDICAN QUE ADEMÁS QUIERE EXPLICACIÓN,
   RUTINA O CONSEJO.
------------------------------------------------------ */

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

foreach ($solicitaConsejo as $frase) {
    if (mb_strpos($q, $frase, 0, "UTF-8") !== false) {
        $haySolicitudConsejo = true;
        break;
    }
}

/* ======================================================
   DECISIÓN FINAL

   PREGUNTA:
   No hay solicitud explícita de productos.

   PRODUCTO:
   Sí solicita productos.

   MIXTA:
   Solicita productos + también quiere explicación/consejo.
====================================================== */

if (!$haySolicitudProducto) {
    $tipo = "pregunta";
} elseif ($haySolicitudConsejo) {
    $tipo = "mixta";
} else {
    $tipo = "producto";
}

/* ======================================================
   CASO PREGUNTA ABIERTA

   ESTE BLOQUE NO CONECTA A MYSQL.
   ESTE BLOQUE NO CONSULTA PRODUCTOS.
   ESTE BLOQUE USA SOLAMENTE LA IA.
====================================================== */

if ($tipo === "pregunta") {

    $systemPrompt = <<<SYSTEM
Eres el asistente virtual de DIVINE, una tienda especializada en cuidado de la piel y del cabello.

Tu función principal es responder preguntas abiertas y generales de forma útil, natural y conversacional.

MUY IMPORTANTE:
Esta conversación NO necesita consultar la base de datos cuando el usuario no está pidiendo productos de DIVINE.

Puedes responder directamente utilizando tus conocimientos generales sobre:
- cuidado facial
- cuidado de la piel
- tipos de piel
- rutinas de skincare
- hidratación
- limpieza facial
- protección solar
- cabello
- cuero cabelludo
- tipos de cabello
- rutinas capilares
- hábitos de cuidado
- ingredientes cosméticos y su función general

Si el usuario pregunta algo como:
"Tengo piel grasa, ¿qué hago?"
"¿Cómo cuido mi piel?"
"¿Qué rutina puedo hacer?"
"¿Por qué tengo la piel seca?"
"¿Cómo puedo cuidar mi cabello?"
"¿Qué hago para el frizz?"
"¿Para qué sirve el ácido hialurónico?"

DEBES RESPONDER LA PREGUNTA DIRECTAMENTE.

NO digas que no tienes información en la base de datos.
NO digas que necesitas buscar productos.
NO pidas al usuario que formule la pregunta como búsqueda de productos.
NO inventes productos de DIVINE.

Si el usuario pregunta por síntomas o problemas de salud, proporciona orientación general y evita presentar un diagnóstico médico como una certeza. Si hay síntomas graves, persistentes o una reacción importante, recomienda consultar con un profesional de salud.

Si el usuario solamente quiere consejo, responde con consejo. No conviertas automáticamente la conversación en una recomendación de productos.

Responde siempre en español.
Sé clara, amable, natural y útil.
SYSTEM;

    $resultadoIA = llamarNvidia(
        $api_url,
        $api_key,
        $modelo,
        [
            [
                "role" => "system",
                "content" => $systemPrompt
            ],
            [
                "role" => "user",
                "content" => $mensaje
            ]
        ],
        0.7
    );

    if (!$resultadoIA["ok"]) {
        responderJSON([
            "ok" => false,
            "tipo" => "pregunta",
            "busqueda" => $mensaje,
            "error" => $resultadoIA["error"],
            "detalle" => $resultadoIA["detalle"] ?? null
        ], 500);
    }

    responderJSON([
        "ok" => true,
        "tipo" => "pregunta",
        "busqueda" => $mensaje,
        "respuesta" => $resultadoIA["texto"],
        "productos" => [],
        "cantidad" => 0,
        "fuente" => "ia"
    ]);
}

/* ======================================================
   DESDE AQUÍ SOLAMENTE SE PERMITE CONSULTAR MYSQL
   SI EL USUARIO PIDIÓ PRODUCTOS.
====================================================== */

/* ======================================================
   BASE DE DATOS DIVINE
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
        "error" => "No se pudo conectar con la base de datos DIVINE.",
        "detalle" => $conn->connect_error
    ], 500);
}

$conn->set_charset("utf8mb4");

/* ======================================================
   EXTRAER FILTROS SENCILLOS
====================================================== */

$categoria = "";

if (preg_match('/\b(skincare|skin care|facial|piel|rostro|cara)\b/iu', $mensaje)) {
    $categoria = "SkinCare";
}

if (preg_match('/\b(skinhair|skin hair|cabello|pelo|capilar|cuero cabelludo|shampoo|champu|acondicionador)\b/iu', $mensaje)) {
    $categoria = "SkinHair";
}

$precioMaximo = 0;

if (preg_match('/(?:menos de|menor de|hasta|maximo|maxima|por menos de|menos de bs\.?|hasta bs\.?)\s*([0-9]+(?:[.,][0-9]+)?)/iu', $mensaje, $matchPrecio)) {
    $precioMaximo = (float)str_replace(",", ".", $matchPrecio[1]);
}

/* ======================================================
   CONSTRUIR TÉRMINOS DE BÚSQUEDA
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

foreach ($palabrasProblema as $problema) {
    if (mb_strpos($q, normalizarTexto($problema), 0, "UTF-8") !== false) {
        $termino = $problema;
        break;
    }
}

/* Si no encontramos un problema, buscamos categorías/tipos de producto. */
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

    foreach ($terminosProducto as $tp) {
        if (mb_strpos($q, normalizarTexto($tp), 0, "UTF-8") !== false) {
            $termino = $tp;
            break;
        }
    }
}

/* ======================================================
   CONSULTA DE PRODUCTOS
====================================================== */

$productos = [];

$sql = "SELECT codigo, nombre, descripcion, precio, stock, categoria FROM PRODUCTO WHERE 1=1";
$parametros = [];
$tipos = "";

if ($categoria !== "") {
    $sql .= " AND LOWER(categoria) = LOWER(?)";
    $tipos .= "s";
    $parametros[] = $categoria;
}

if ($precioMaximo > 0) {
    $sql .= " AND precio <= ?";
    $tipos .= "d";
    $parametros[] = $precioMaximo;
}

if ($termino !== "") {
    $sql .= " AND (LOWER(nombre) LIKE LOWER(?) OR LOWER(descripcion) LIKE LOWER(?))";
    $tipos .= "ss";
    $buscar = "%" . $termino . "%";
    $parametros[] = $buscar;
    $parametros[] = $buscar;
}

$sql .= " ORDER BY nombre ASC LIMIT 20";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $conn->close();
    responderJSON([
        "ok" => false,
        "error" => "No se pudo preparar la búsqueda de productos.",
        "detalle" => $conn->error
    ], 500);
}

if ($tipos !== "") {
    $bind = [$tipos];

    foreach ($parametros as $indice => $valor) {
        $bind[] = &$parametros[$indice];
    }

    call_user_func_array([$stmt, "bind_param"], $bind);
}

if (!$stmt->execute()) {
    $detalle = $stmt->error;
    $stmt->close();
    $conn->close();

    responderJSON([
        "ok" => false,
        "error" => "No se pudo ejecutar la búsqueda de productos.",
        "detalle" => $detalle
    ], 500);
}

$resultado = $stmt->get_result();

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = [
        "id" => (int)$fila["codigo"],
        "codigo" => (int)$fila["codigo"],
        "nombre" => $fila["nombre"],
        "descripcion" => $fila["descripcion"],
        "precio" => (float)$fila["precio"],
        "stock" => (int)$fila["stock"],
        "categoria" => $fila["categoria"]
    ];
}

$stmt->close();
$conn->close();

/* ======================================================
   PREPARAR CONTEXTO PARA LA IA
====================================================== */

$contextoProductos = "";

if (count($productos) === 0) {
    $contextoProductos = "No se encontraron productos de DIVINE que coincidan con la búsqueda.";
} else {
    foreach ($productos as $producto) {
        $contextoProductos .= "\n";
        $contextoProductos .= "Nombre: " . $producto["nombre"] . "\n";
        $contextoProductos .= "Descripción: " . $producto["descripcion"] . "\n";
        $contextoProductos .= "Precio: Bs. " . number_format($producto["precio"], 2, ".", "") . "\n";
        $contextoProductos .= "Stock: " . $producto["stock"] . "\n";
        $contextoProductos .= "Categoría: " . $producto["categoria"] . "\n";
    }
}

/* ======================================================
   RESPUESTA PRODUCTO / MIXTA
====================================================== */

if ($tipo === "producto") {

    $systemPrompt = <<<SYSTEM
Eres el asistente de productos de DIVINE.

DIVINE es una tienda de productos para cuidado de la piel y el cabello.

El usuario está solicitando productos, disponibilidad, precios o artículos de DIVINE.

Los únicos productos reales que puedes mencionar son los que aparecen en el contexto de productos proporcionado por el sistema.

NO inventes:
- productos
- nombres
- precios
- stock
- ingredientes
- marcas
- beneficios específicos
- características que no aparecen en los datos

Si no se encontraron productos, dilo claramente y no inventes alternativas de DIVINE.

Puedes explicar brevemente por qué los productos encontrados pueden relacionarse con la búsqueda, pero no conviertas una descripción general en una afirmación médica.

Responde en español y de forma natural.
SYSTEM;

    $userPrompt = "MENSAJE DEL USUARIO:\n" . $mensaje . "\n\nPRODUCTOS REALES EN DIVINE:\n" . $contextoProductos;

} else {

    $systemPrompt = <<<SYSTEM
Eres el asistente virtual de DIVINE.

El usuario hizo una consulta MIXTA: quiere orientación general sobre cuidado de piel o cabello y también quiere conocer productos de DIVINE.

Debes hacer DOS cosas:

1. Responder primero la parte general usando tus conocimientos sobre cuidado de piel o cabello.
2. Después mencionar los productos reales de DIVINE que aparecen en el contexto proporcionado.

Si NO hay productos encontrados:
- NO inventes productos.
- NO detengas la respuesta.
- Responde igualmente la parte general.
- Indica de manera natural que actualmente no se encontraron productos específicos de DIVINE que coincidan con la búsqueda.

Los productos, precios, stock y nombres deben salir exclusivamente del contexto de productos.

NO inventes ingredientes, marcas, precios, stock ni beneficios específicos.

No presentes diagnósticos médicos como certezas.

Responde en español, con un tono amable, natural y útil.
SYSTEM;

    $userPrompt = "MENSAJE DEL USUARIO:\n" . $mensaje . "\n\nPRODUCTOS REALES EN DIVINE:\n" . $contextoProductos;
}

$resultadoIA = llamarNvidia(
    $api_url,
    $api_key,
    $modelo,
    [
        [
            "role" => "system",
            "content" => $systemPrompt
        ],
        [
            "role" => "user",
            "content" => $userPrompt
        ]
    ],
    0.6
);

if (!$resultadoIA["ok"]) {
    responderJSON([
        "ok" => false,
        "tipo" => $tipo,
        "busqueda" => $mensaje,
        "error" => $resultadoIA["error"],
        "detalle" => $resultadoIA["detalle"] ?? null
    ], 500);
}

responderJSON([
    "ok" => true,
    "tipo" => $tipo,
    "busqueda" => $mensaje,
    "filtrosAplicados" => [
        "categoria" => $categoria,
        "precio_maximo" => $precioMaximo,
        "termino" => $termino
    ],
    "respuesta" => $resultadoIA["texto"],
    "productos" => $productos,
    "cantidad" => count($productos),
    "fuente" => $tipo === "mixta" ? "ia+base_datos" : "base_datos"
]);

?>
