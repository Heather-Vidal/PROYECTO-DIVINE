<?php

/* ======================================================
   DIVINE - ASISTENTE IA + PRODUCTOS REALES
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

$api_url = "https://integrate.api.nvidia.com/v1/chat/completions";

/* COLOCA TU API KEY SOLAMENTE AQUÍ */
$api_key = "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";

$modelo = "openai/gpt-oss-20b";

function responderJSON($datos, $codigo = 200)
{
    http_response_code($codigo);
    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    exit();
}

$api_key = trim($api_key);

if ($api_key === "" || $api_key === "PEGA_AQUI_TU_API_KEY") {
    responderJSON([
        "ok" => false,
        "error" => "La API Key de NVIDIA no está configurada.",
        "detalle" => "Coloca tu API Key en la variable $api_key."
    ], 500);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    responderJSON([
        "ok" => false,
        "error" => "Método no permitido. Usa POST."
    ], 405);
}

function normalizarTexto($texto)
{
    $texto = mb_strtolower(trim($texto), "UTF-8");

    $buscar = ["á", "é", "í", "ó", "ú", "ü", "ñ"];
    $reemplazar = ["a", "e", "i", "o", "u", "u", "n"];

    return str_replace($buscar, $reemplazar, $texto);
}

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
        CURLOPT_POSTFIELDS => json_encode(
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
        $detalle = $data["error"]["message"]
            ?? (is_string($data["error"] ?? null)
                ? $data["error"]
                : "Error desconocido de NVIDIA.");

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

/* RECIBIR MENSAJE */
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

$q = normalizarTexto($mensaje);

/* DETECTAR SOLICITUDES DE PRODUCTOS */
$solicitaProductos = [
    "producto",
    "productos",
    "que me recomiendas",
    "que me recomendas",
    "recomiendame",
    "recomiendame algo",
    "recomendarme",
    "del catalogo",
    "del catálogo",
    "tengo la piel seca",
    "tengo piel seca",
    "tengo la piel grasa",
    "tengo piel grasa",
    "piel sensible",
    "cabello seco",
    "cabello maltratado",
    "cabello danado",
    "cabello dañado",
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

foreach ($solicitaProductos as $frase) {
    if (mb_strpos($q, normalizarTexto($frase), 0, "UTF-8") !== false) {
        $haySolicitudProducto = true;
        break;
    }
}
/* DETECTAR CONSEJO */
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
    if (mb_strpos($q, normalizarTexto($frase), 0, "UTF-8") !== false) {
        $haySolicitudConsejo = true;
        break;
    }
}

/* DETECTAR RECOMENDACIONES POR NECESIDAD */
$esRecomendacion = preg_match(
    '/\b(recomiend|recomend|del catalogo|tengo la piel|tengo piel|piel seca|piel grasa|piel sensible|cabello seco|cabello maltratado|cabello danado|frizz|caspa|manchas|acne)\b/iu',
    $mensaje
) === 1;

if ($esRecomendacion) {
    $haySolicitudProducto = true;
}

if (!$haySolicitudProducto) {
    $tipo = "pregunta";
} elseif ($haySolicitudConsejo || $esRecomendacion) {
    $tipo = "mixta";
} else {
    $tipo = "producto";
}

/* PREGUNTAS GENERALES: SOLO IA */
if ($tipo === "pregunta") {

    $systemPrompt = <<<SYSTEM
Eres el asistente virtual de DIVINE.

DIVINE es un emprendimiento relacionado con belleza,
skincare y cuidado del cabello.

Responde preguntas generales de manera natural,
clara, amable y útil.

Puedes hablar sobre:
- Cuidado de la piel.
- Skincare.
- Cabello y cuero cabelludo.
- Rutinas faciales y capilares.
- Hidratación y limpieza.
- Protección solar.
- Frizz y cabello seco.
- Ingredientes cosméticos y su función general.

Si el usuario pregunta cómo cuidar su cabello,
cómo cuidar su piel o qué hacer con el frizz,
responde directamente.

No conviertas una pregunta general en una búsqueda
de productos.

No inventes productos de DIVINE.

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
        "cantidad" => 0,
        "tiene_productos" => false,
        "fuente" => "ia"
    ]);
}

/* CONEXIÓN CON LA BASE DE DATOS */
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

/* DETECTAR CATEGORÍA */
$categoria = "";

if (preg_match('/\b(skincare|skin care|facial|piel|rostro|cara)\b/iu', $mensaje)) {
    $categoria = "SkinCare";
}

if (preg_match('/\b(skinhair|skin hair|cabello|pelo|capilar|cuero cabelludo|shampoo|champu|acondicionador)\b/iu', $mensaje)) {
    $categoria = "SkinHair";
}

/* DETECTAR PRECIO MÁXIMO */
$precioMaximo = 0;

if (preg_match(
    '/(?:menos de|menor de|hasta|maximo|maxima|por menos de|menos de bs\.?|hasta bs\.?)\s*([0-9]+(?:[.,][0-9]+)?)/iu',
    $mensaje,
    $matchPrecio
)) {
    $precioMaximo = (float)str_replace(",", ".", $matchPrecio[1]);
}

/* DETECTAR NECESIDAD DEL CLIENTE */
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

/* SI NO HAY UNA NECESIDAD, BUSCAR EL TIPO DE PRODUCTO */
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

/* CONSULTAR PRODUCTOS REALES */
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

/* Para recomendaciones, se deja que la IA compare las descripciones. */
if ($termino !== "" && !$esRecomendacion) {
    $sql .= "
        AND (
            LOWER(nombre) LIKE LOWER(?)
            OR LOWER(descripcion) LIKE LOWER(?)
        )
    ";

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
    $bind = [];
    $bind[] = $tipos;

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
/* PREPARAR CONTEXTO DE PRODUCTOS PARA LA IA */
$contextoProductos = "";

if (count($productos) === 0) {
    $contextoProductos = "NO SE ENCONTRARON PRODUCTOS DE DIVINE.";
} else {
    foreach ($productos as $producto) {
        $contextoProductos .= "\n";
        $contextoProductos .= "Nombre: " . $producto["nombre"] . "\n";
        $contextoProductos .= "Descripción: " . $producto["descripcion"] . "\n";

        $contextoProductos .= "Precio: Bs. " .
            number_format($producto["precio"], 2, ".", "") . "\n";

        $contextoProductos .= "Stock: " . $producto["stock"] . "\n";
        $contextoProductos .= "Categoría: " . $producto["categoria"] . "\n";
    }
}

/* PROMPT PARA BUSCAR Y RECOMENDAR PRODUCTOS */
if ($tipo === "producto") {

    $systemPrompt = <<<SYSTEM
Eres el asistente virtual de belleza y productos de DIVINE.

Tu tarea es comprender la necesidad real del cliente y razonar
qué productos del catálogo podrían ayudarle. No dependas de que
escriba el nombre exacto de un producto.

Cuando el cliente describa una necesidad, por ejemplo piel seca,
piel sensible, manchas, cabello reseco o frizz:

1. Identifica si habla de la piel o del cabello.
2. Revisa las descripciones, categorías y datos de los productos.
3. Selecciona únicamente productos que tengan una relación
   razonable con esa necesidad.
4. Explica brevemente por qué podrían ser una opción, usando
   únicamente la información disponible.
5. Si no hay información suficiente, no inventes beneficios.
   Da consejos generales seguros e indica que no encontraste
   una opción específica en el catálogo.

Los únicos productos reales que puedes mencionar son los que
aparecen en el contexto proporcionado.

NO inventes productos, precios, stock, nombres, marcas,
ingredientes, características ni beneficios.

Si no hay productos encontrados, dilo claramente.

No afirmes que un producto cura enfermedades ni hagas diagnósticos.

Responde en español, de forma natural, amable y clara.
SYSTEM;

    $userPrompt =
        "MENSAJE DEL USUARIO:\n" .
        $mensaje .
        "\n\nPRODUCTOS REALES DE DIVINE:\n" .
        $contextoProductos;

} else {

    /* PROMPT PARA CONSEJO + PRODUCTOS */
    $systemPrompt = <<<SYSTEM
Eres el asistente virtual de DIVINE.

El usuario necesita un consejo general y también información
sobre productos de DIVINE.

Comprende la necesidad descrita y compárala con las descripciones
y categorías de los productos reales proporcionados.

Recomienda únicamente los productos que tengan una relación
razonable con la necesidad del cliente. No dependas de coincidencias
exactas de palabras.

Explica brevemente el motivo de cada recomendación sin inventar
ingredientes, efectos ni beneficios.

DEBES RESPONDER LAS DOS PARTES:

1. Primero, da una explicación o consejo general útil.
2. Después, menciona los productos reales de DIVINE que podrían
   ser adecuados, si los hay.

Si no existen productos relacionados, no detengas la respuesta.
Responde el consejo general e indica que no encontraste productos
específicos de DIVINE para esa necesidad.

NO inventes productos, precios, stock, ingredientes ni beneficios.

Los datos de los productos deben salir exclusivamente del
contexto proporcionado.

Responde siempre en español, de forma natural, amable y clara.
SYSTEM;

    $userPrompt =
        "MENSAJE DEL USUARIO:\n" .
        $mensaje .
        "\n\nPRODUCTOS REALES DE DIVINE:\n" .
        $contextoProductos;
}

/* LLAMAR A LA IA */
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

/* VERIFICAR RESPUESTA DE LA IA */
if (!$resultadoIA["ok"]) {
    responderJSON([
        "ok" => false,
        "tipo" => $tipo,
        "busqueda" => $mensaje,
        "error" => $resultadoIA["error"],
        "detalle" => $resultadoIA["detalle"] ?? null
    ], 500);
}

/* RESPUESTA FINAL */
$respuestaFinal = $resultadoIA["texto"];

responderJSON([
    "ok" => true,
    "tipo" => $tipo,
    "busqueda" => $mensaje,
    "respuesta" => $respuestaFinal,
    "productos" => $productos,
    "cantidad" => count($productos),
    "tiene_productos" => count($productos) > 0,
    "filtrosAplicados" => [
        "categoria" => $categoria,
        "precio_maximo" => $precioMaximo,
        "termino" => $termino
    ],
    "fuente" => "ia+base_datos"
]);

?> 