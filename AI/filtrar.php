 <?php


/* ======================================================
   CONFIGURACIÓN GENERAL
====================================================== */


ini_set("display_errors", 0);

ini_set("log_errors", 1);

error_reporting(E_ALL);


header(
    "Access-Control-Allow-Origin: *"
);


header(
    "Access-Control-Allow-Headers: Content-Type, Authorization"
);


header(
    "Access-Control-Allow-Methods: POST, OPTIONS"
);


header(
    "Content-Type: application/json; charset=UTF-8"
);


/* ======================================================
   OPTIONS
====================================================== */


if (
    $_SERVER["REQUEST_METHOD"] === "OPTIONS"
) {

    http_response_code(204);

    exit();

}


/* ======================================================
   CONFIGURACIÓN DE NVIDIA
====================================================== */


/*
   PON AQUÍ TU API KEY.

   NO COLOQUES LA API KEY REAL EN EL FRONTEND.
*/


$api_url =
    "https://integrate.api.nvidia.com/v1/chat/completions";

$api_key =
    "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";

$modelo =
    "openai/gpt-oss-20b";


/* ======================================================
   VALIDAR API KEY
====================================================== */


if (
    trim($api_key) === "" ||
    $api_key === "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"
) {

    http_response_code(500);


    echo json_encode(

        [

            "ok" => false,

            "error" =>
                "La API Key de NVIDIA no está configurada."

        ],

        JSON_UNESCAPED_UNICODE

    );


    exit();

}


/* ======================================================
   SOLO POST
====================================================== */


if (
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {

    http_response_code(405);


    echo json_encode(

        [

            "ok" => false,

            "error" =>
                "Método no permitido. Usa POST."

        ],

        JSON_UNESCAPED_UNICODE

    );


    exit();

}


/* ======================================================
   BASE DE DATOS DIVINE
====================================================== */


$servidor =
    "localhost";


$usuario =
    "root";


$contrasena =
    "";


$nombreBD =
    "divine";


/* ======================================================
   CONEXIÓN MYSQL
====================================================== */


$conn = new mysqli(

    $servidor,

    $usuario,

    $contrasena,

    $nombreBD

);


/* ======================================================
   COMPROBAR CONEXIÓN
====================================================== */


if (
    $conn->connect_error
) {

    http_response_code(500);


    echo json_encode(

        [

            "ok" => false,

            "error" =>
                "No se pudo conectar con la base de datos DIVINE.",

            "detalle" =>
                $conn->connect_error

        ],

        JSON_UNESCAPED_UNICODE

    );


    exit();

}


/* ======================================================
   UTF8
====================================================== */


$conn->set_charset(
    "utf8mb4"
);


/* ======================================================
   RECIBIR JSON
====================================================== */


$input =
    file_get_contents(
        "php://input"
    );


/* ======================================================
   VALIDAR INPUT
====================================================== */


if (trim($api_key) === "") {

    http_response_code(500);

    echo json_encode(
        [
            "ok" => false,
            "error" => "La API Key de NVIDIA está vacía."
        ],
        JSON_UNESCAPED_UNICODE
    );

    exit();
}


/* ======================================================
   DECODIFICAR JSON
====================================================== */


$datos =
    json_decode(

        $input,

        true

    );


/* ======================================================
   VALIDAR JSON
====================================================== */


if (

    json_last_error() !== JSON_ERROR_NONE ||

    !is_array($datos)

) {

    http_response_code(400);


    echo json_encode(

        [

            "ok" => false,

            "error" =>
                "El JSON recibido no es válido.",

            "detalle" =>
                json_last_error_msg()

        ],

        JSON_UNESCAPED_UNICODE

    );


    $conn->close();


    exit();

}


/* ======================================================
   OBTENER MENSAJE DEL USUARIO
====================================================== */


$busqueda = "";


if (
    isset($datos["busqueda"])
) {

    $busqueda =
        trim(
            (string)$datos["busqueda"]
        );

}


/*
   También permite:

   mensaje

   pregunta

   consulta
*/


if (
    $busqueda === "" &&
    isset($datos["mensaje"])
) {

    $busqueda =
        trim(
            (string)$datos["mensaje"]
        );

}


if (
    $busqueda === "" &&
    isset($datos["pregunta"])
) {

    $busqueda =
        trim(
            (string)$datos["pregunta"]
        );

}


if (
    $busqueda === "" &&
    isset($datos["consulta"])
) {

    $busqueda =
        trim(
            (string)$datos["consulta"]
        );

}


/* ======================================================
   VALIDAR MENSAJE
====================================================== */


if (
    $busqueda === ""
) {

    http_response_code(400);


    echo json_encode(

        [

            "ok" => false,

            "error" =>
                "Debes escribir una pregunta o búsqueda."

        ],

        JSON_UNESCAPED_UNICODE

    );


    $conn->close();


    exit();

}


/* ======================================================
   FUNCIÓN PARA LLAMAR A NVIDIA
====================================================== */


function llamarNvidia(

    $api_url,

    $api_key,

    $modelo,

    $messages,

    $temperature = 0.2,

    $max_tokens = 1000

) {


    $payload = [

        "model" =>
            $modelo,

        "messages" =>
            $messages,

        "temperature" =>
            $temperature,

        "top_p" =>
            0.8,

        "max_tokens" =>
            $max_tokens,

        "stream" =>
            false

    ];


    $json =
        json_encode(

            $payload,

            JSON_UNESCAPED_UNICODE

        );


    if (
        $json === false
    ) {

        return [

            "ok" => false,

            "error" =>
                "No se pudo crear la petición para NVIDIA.",

            "detalle" =>
                json_last_error_msg()

        ];

    }


    if (
        !function_exists("curl_init")
    ) {

        return [

            "ok" => false,

            "error" =>
                "cURL no está instalado o habilitado en PHP."

        ];

    }


    $ch =
        curl_init();


    curl_setopt_array(

        $ch,

        [

            CURLOPT_URL =>
                $api_url,

            CURLOPT_POST =>
                true,

            CURLOPT_RETURNTRANSFER =>
                true,

            CURLOPT_FOLLOWLOCATION =>
                true,

            CURLOPT_HTTPHEADER =>
                [

                    "Authorization: Bearer " .
                    trim($api_key),

                    "Content-Type: application/json",

                    "Accept: application/json"

                ],

            CURLOPT_POSTFIELDS =>
                $json,

            CURLOPT_CONNECTTIMEOUT =>
                20,

            CURLOPT_TIMEOUT =>
                120

        ]

    );


    $respuesta =
        curl_exec($ch);


    $curl_error =
        curl_error($ch);


    $http_code =
        curl_getinfo(

            $ch,

            CURLINFO_HTTP_CODE

        );


    curl_close($ch);


    if (
        $respuesta === false
    ) {

        return [

            "ok" => false,

            "error" =>
                "No se pudo conectar con NVIDIA.",

            "detalle" =>
                $curl_error

        ];

    }


    $data =
        json_decode(

            $respuesta,

            true

        );


    if (
        !is_array($data)
    ) {

        return [

            "ok" => false,

            "error" =>
                "NVIDIA no devolvió JSON válido.",

            "codigo" =>
                $http_code,

            "respuesta" =>
                $respuesta

        ];

    }


    if (

        $http_code < 200 ||

        $http_code >= 300

    ) {


        $detalle =
            "Error desconocido.";


        if (

            isset(
                $data["error"]
            )

        ) {


            if (

                is_array(
                    $data["error"]
                )

            ) {


                if (

                    isset(
                        $data["error"]["message"]
                    )

                ) {

                    $detalle =
                        $data["error"]["message"];

                }

            }


            elseif (

                is_string(
                    $data["error"]
                )

            ) {

                $detalle =
                    $data["error"];

            }

        }


        return [

            "ok" => false,

            "error" =>
                "NVIDIA devolvió un error.",

            "codigo" =>
                $http_code,

            "detalle" =>
                $detalle,

            "respuesta" =>
                $data

        ];

    }


    $texto =
        "";


    if (

        isset(
            $data["choices"][0]["message"]["content"]
        )

    ) {

        $texto =

            $data["choices"][0]["message"]["content"];

    }


    if (
        trim($texto) === ""
    ) {

        return [

            "ok" => false,

            "error" =>
                "NVIDIA no devolvió contenido.",

            "respuesta" =>
                $data

        ];

    }


    return [

        "ok" =>
            true,

        "texto" =>
            trim($texto),

        "data" =>
            $data

    ];

}


/* ======================================================
   PRIMERA IA
   DETERMINAR TIPO DE PETICIÓN
====================================================== */


$promptClasificacion = <<<PROMPT

Eres el asistente inteligente de la tienda DIVINE.

DIVINE vende productos relacionados con:

- cuidado de la piel
- cuidado facial
- cuidado del cabello

La base de datos de DIVINE contiene productos reales.

Tu tarea es analizar el mensaje del usuario y determinar
qué necesita.

Debes devolver ÚNICAMENTE un objeto JSON.

NO escribas explicaciones.

FORMATO:

{
    "tipo": "producto",
    "categoria": "",
    "precio_maximo": 0,
    "termino": "",
    "necesita_respuesta": true
}

TIPOS POSIBLES:

"producto"

Se utiliza cuando el usuario está buscando productos,
productos concretos, precios, productos disponibles,
productos de una categoría o productos que puedan
ayudarle.

Ejemplos:

"quiero una crema para piel seca"

"qué shampoo tienen"

"busco aceite de argán"

"qué productos tienen para cabello"

"qué crema tienen por menos de 50"

"quiero productos para piel grasa"


"pregunta"

Se utiliza cuando el usuario quiere una explicación,
consejo general, rutina, orientación o información,
sin pedir necesariamente productos de DIVINE.

Ejemplos:

"qué puedo hacer si tengo piel grasa"

"qué rutina puedo hacer"

"cómo cuidar mi cabello"

"qué hago si mi piel se descama"

"cómo debo lavarme la cara"


"mixta"

Se utiliza cuando el usuario quiere una explicación
Y también quiere productos de DIVINE.

Ejemplos:

"tengo piel grasa, qué rutina me recomiendas
y qué productos tienen"

"qué hago para el cabello seco y qué productos
me recomiendas de DIVINE"


CATEGORÍAS:

Si se relaciona con piel:

"SkinCare"


Si se relaciona con cabello:

"SkinHair"


Si no se puede determinar:

""


PRECIO:

Si el usuario indica un precio máximo:

"menos de 50" = 50

"hasta 100" = 100

"máximo 70" = 70

Si no existe precio:

0


TERMINO:

Extrae únicamente palabras importantes para buscar
en nombre y descripción de productos.

Ejemplo:

"crema para piel seca"

resultado:

"crema piel seca"


Ejemplo:

"aceite de argán para cabello"

resultado:

"aceite argán cabello"


No incluyas palabras como:

producto
productos
quiero
necesito
busco
buscar
dame
para
una
uno
unos
unas
de
del
la
el
los
las
con
que
qué
menos
más
mas
mayor
menor
hasta
máximo
maximo
precio


IMPORTANTE:

Si es una pregunta general, NO fuerces
una búsqueda de productos.

MENSAJE DEL USUARIO:

$busqueda

PROMPT;


/* ======================================================
   LLAMAR A NVIDIA PARA CLASIFICAR
====================================================== */


$clasificacion =
    llamarNvidia(

        $api_url,

        $api_key,

        $modelo,

        [

            [

                "role" =>
                    "system",

                "content" =>
                    "Clasifica las solicitudes del usuario de DIVINE."

            ],

            [

                "role" =>
                    "user",

                "content" =>
                    $promptClasificacion

            ]

        ],

        0.0,

        500

    );


/* ======================================================
   ERROR CLASIFICACIÓN
====================================================== */


if (
    !$clasificacion["ok"]
) {

    http_response_code(
        isset($clasificacion["codigo"])
            ? $clasificacion["codigo"]
            : 500
    );


    echo json_encode(

        $clasificacion,

        JSON_UNESCAPED_UNICODE |

        JSON_PRETTY_PRINT

    );


    $conn->close();


    exit();

}


/* ======================================================
   LIMPIAR JSON DE CLASIFICACIÓN
====================================================== */


$textoClasificacion =
    trim(
        $clasificacion["texto"]
    );


$textoClasificacion =
    preg_replace(

        '/```json\s*/i',

        "",

        $textoClasificacion

    );


$textoClasificacion =
    preg_replace(

        '/```\s*/',

        "",

        $textoClasificacion

    );


$textoClasificacion =
    trim(
        $textoClasificacion
    );


/* ======================================================
   DECODIFICAR CLASIFICACIÓN
====================================================== */


$clasificacionData =
    json_decode(

        $textoClasificacion,

        true

    );


/* ======================================================
   INTENTAR EXTRAER JSON
====================================================== */


if (
    !is_array($clasificacionData)
) {


    $inicio =
        strpos(
            $textoClasificacion,
            "{"
        );


    $final =
        strrpos(
            $textoClasificacion,
            "}"
        );


    if (

        $inicio !== false &&

        $final !== false

    ) {


        $jsonLimpio =
            substr(

                $textoClasificacion,

                $inicio,

                $final - $inicio + 1

            );


        $clasificacionData =
            json_decode(

                $jsonLimpio,

                true

            );

    }

}


/* ======================================================
   VALIDAR CLASIFICACIÓN
====================================================== */


if (
    !is_array($clasificacionData)
) {

    http_response_code(500);


    echo json_encode(

        [

            "ok" => false,

            "error" =>
                "No se pudo interpretar la clasificación de NVIDIA.",

            "respuestaIA" =>
                $textoClasificacion

        ],

        JSON_UNESCAPED_UNICODE |

        JSON_PRETTY_PRINT

    );


    $conn->close();


    exit();

}


/* ======================================================
   OBTENER TIPO
====================================================== */


$tipo =

    isset(
        $clasificacionData["tipo"]
    )

    ? strtolower(
        trim(
            (string)
            $clasificacionData["tipo"]
        )
    )

    : "pregunta";


/* ======================================================
   OBTENER CATEGORÍA
====================================================== */


$categoria =

    isset(
        $clasificacionData["categoria"]
    )

    ? trim(
        (string)
        $clasificacionData["categoria"]
    )

    : "";


/* ======================================================
   OBTENER PRECIO
====================================================== */


$precio =

    isset(
        $clasificacionData["precio_maximo"]
    )

    ? intval(
        $clasificacionData["precio_maximo"]
    )

    : 0;


/* ======================================================
   OBTENER TÉRMINO
====================================================== */


$termino =

    isset(
        $clasificacionData["termino"]
    )

    ? trim(
        (string)
        $clasificacionData["termino"]
    )

    : "";


/* ======================================================
   NORMALIZAR TIPO
====================================================== */


if (

    $tipo !== "producto" &&

    $tipo !== "pregunta" &&

    $tipo !== "mixta"

) {

    $tipo =
        "pregunta";

}


/* ======================================================
   NORMALIZAR CATEGORÍA
====================================================== */


if (

    strcasecmp(
        $categoria,
        "skincare"
    ) === 0

) {

    $categoria =
        "SkinCare";

}


elseif (

    strcasecmp(
        $categoria,
        "skinhair"
    ) === 0

) {

    $categoria =
        "SkinHair";

}


else {

    $categoria =
        "";

}


/* ======================================================
   VALIDAR PRECIO
====================================================== */


if (
    $precio < 0
) {

    $precio =
        0;

}


/* ======================================================
   PRODUCTOS
====================================================== */


$productos =
    [];


/* ======================================================
   SI NECESITA PRODUCTOS
====================================================== */


if (

    $tipo === "producto" ||

    $tipo === "mixta"

) {


    /* ==================================================
       CONSULTA SQL
    ================================================== */


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


    $tipos =
        "";


    $parametros =
        [];


    /* ==================================================
       FILTRO CATEGORÍA
    ================================================== */


    if (
        $categoria !== ""
    ) {


        $sql .= "

            AND categoria = ?

        ";


        $tipos .=
            "s";


        $parametros[] =
            $categoria;

    }


    /* ==================================================
       FILTRO PRECIO
    ================================================== */


    if (
        $precio > 0
    ) {


        $sql .= "

            AND precio <= ?

        ";


        $tipos .=
            "d";


        $parametros[] =
            $precio;

    }


    /* ==================================================
       FILTRO TÉRMINOS
    ================================================== */


    if (
        $termino !== ""
    ) {


        $terminos =
            preg_split(

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

            "busco",

            "buscar",

            "dame",

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

            "qué",

            "menos",

            "más",

            "mas",

            "mayor",

            "menor",

            "hasta",

            "máximo",

            "maximo",

            "precio"

        ];


        foreach (

            $terminos as $palabra

        ) {


            $palabra =
                trim($palabra);


            if (
                $palabra === ""
            ) {

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


            /*
               Buscar la palabra en nombre
               o descripción.
            */


            $sql .= "

                AND (

                    LOWER(nombre) LIKE ?

                    OR

                    LOWER(descripcion) LIKE ?

                )

            ";


            $tipos .=
                "ss";


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


    /* ==================================================
       ORDENAR
    ================================================== */


    $sql .= "

        ORDER BY nombre ASC

    ";


    /* ==================================================
       PREPARAR
    ================================================== */


    $stmt =
        $conn->prepare($sql);


    if (
        !$stmt
    ) {

        http_response_code(500);


        echo json_encode(

            [

                "ok" => false,

                "error" =>
                    "No se pudo preparar la consulta.",

                "detalle" =>
                    $conn->error

            ],

            JSON_UNESCAPED_UNICODE

        );


        $conn->close();


        exit();

    }


    /* ==================================================
       BIND PARAMS
    ================================================== */


    if (
        $tipos !== ""
    ) {


        $bind =
            [];


        $bind[] =
            $tipos;


        foreach (

            $parametros as $indice => $valor

        ) {


            $bind[] =
                &$parametros[$indice];

        }


        call_user_func_array(

            [

                $stmt,

                "bind_param"

            ],

            $bind

        );

    }


    /* ==================================================
       EJECUTAR
    ================================================== */


    if (
        !$stmt->execute()
    ) {

        http_response_code(500);


        echo json_encode(

            [

                "ok" => false,

                "error" =>
                    "No se pudo ejecutar la búsqueda.",

                "detalle" =>
                    $stmt->error

            ],

            JSON_UNESCAPED_UNICODE

        );


        $stmt->close();


        $conn->close();


        exit();

    }


    /* ==================================================
       RESULTADOS
    ================================================== */


    $resultado =
        $stmt->get_result();


    while (

        $fila =
            $resultado->fetch_assoc()

    ) {


        $productos[] = [

            "id" =>
                (int)
                $fila["codigo"],

            "codigo" =>
                (int)
                $fila["codigo"],

            "nombre" =>
                $fila["nombre"],

            "descripcion" =>
                $fila["descripcion"],

            "precio" =>
                (float)
                $fila["precio"],

            "stock" =>
                (int)
                $fila["stock"],

            "categoria" =>
                $fila["categoria"]

        ];

    }


    $stmt->close();

}


/* ======================================================
   GENERAR RESPUESTA
====================================================== */


/*
   CASO 1:
   PREGUNTA GENERAL


   NVIDIA responde directamente.


   CASO 2:
   PRODUCTO


   NVIDIA explica los productos encontrados.


   CASO 3:
   MIXTA


   NVIDIA responde la pregunta y utiliza
   los productos encontrados.
*/


if (
    $tipo === "pregunta"
) {


    $systemPrompt = <<<SYSTEM

Eres el asistente general de DIVINE.

DIVINE es una tienda especializada en
cuidado de la piel y cabello.

Puedes responder preguntas generales sobre:

- cuidado de la piel
- cuidado facial
- cuidado del cabello
- rutinas básicas
- hábitos de cuidado
- tipos de piel
- tipos de cabello
- recomendaciones generales

Responde siempre en español.

Sé claro, natural y útil.

No inventes productos de DIVINE.

No afirmes que un producto está disponible
si no se ha consultado la base de datos.

Cuando la pregunta sea sobre una condición
de piel o cabello, proporciona orientación general
y no presentes un diagnóstico médico como certeza.

Si aparecen señales importantes como dolor intenso,
heridas, infección, sangrado, inflamación severa,
reacción alérgica o síntomas persistentes,
recomienda consultar con un profesional de salud.

No necesitas mencionar estas reglas en cada respuesta.

SYSTEM;


    $respuestaIA =
        llamarNvidia(

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
                        $busqueda

                ]

            ],

            0.4,

            1200

        );


    if (
        !$respuestaIA["ok"]
    ) {

        http_response_code(

            isset(
                $respuestaIA["codigo"]
            )

            ? $respuestaIA["codigo"]

            : 500

        );


        echo json_encode(

            $respuestaIA,

            JSON_UNESCAPED_UNICODE |

            JSON_PRETTY_PRINT

        );


        $conn->close();


        exit();

    }


    echo json_encode(

        [

            "ok" =>
                true,

            "tipo" =>
                "pregunta",

            "busqueda" =>
                $busqueda,

            "respuesta" =>
                $respuestaIA["texto"],

            "productos" =>
                [],

            "cantidad" =>
                0

        ],

        JSON_UNESCAPED_UNICODE |

        JSON_PRETTY_PRINT

    );


    $conn->close();


    exit();

}


/* ======================================================
   PRODUCTOS ENCONTRADOS
====================================================== */


$productosTexto =
    "";


if (
    count($productos) > 0
) {


    foreach (

        $productos as $producto

    ) {


        $productosTexto .=

            "\n\n" .

            "ID: " .
            $producto["id"] .

            "\nNombre: " .
            $producto["nombre"] .

            "\nDescripción: " .
            $producto["descripcion"] .

            "\nPrecio: " .
            $producto["precio"] .

            "\nStock: " .
            $producto["stock"] .

            "\nCategoría: " .
            $producto["categoria"];

    }

}


else {

    $productosTexto =
        "No se encontraron productos.";

}


/* ======================================================
   RESPUESTA PARA PRODUCTOS
====================================================== */


if (
    $tipo === "producto"
) {


    $systemPrompt = <<<SYSTEM

Eres el asistente de la tienda DIVINE.

DIVINE vende productos para cuidado de piel
y cabello.

El usuario realizó una búsqueda de productos.

Los productos que aparecen en el contexto
son los únicos productos que puedes afirmar
que existen o están disponibles.

NO inventes productos.

NO inventes precios.

NO inventes stock.

NO inventes características que no aparezcan
en los datos proporcionados.

Responde en español.

Explica brevemente por qué los productos
pueden estar relacionados con la búsqueda.

Si no hay productos encontrados,
indica claramente que no se encontraron
productos que coincidan con la búsqueda.

Productos encontrados:

$productosTexto

SYSTEM;


    $respuestaIA =
        llamarNvidia(

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
                        $busqueda

                ]

            ],

            0.3,

            1200

        );


    if (
        !$respuestaIA["ok"]
    ) {

        http_response_code(

            isset(
                $respuestaIA["codigo"]
            )

            ? $respuestaIA["codigo"]

            : 500

        );


        echo json_encode(

            $respuestaIA,

            JSON_UNESCAPED_UNICODE |

            JSON_PRETTY_PRINT

        );


        $conn->close();


        exit();

    }


    echo json_encode(

        [

            "ok" =>
                true,

            "tipo" =>
                "producto",

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

            "respuesta" =>
                $respuestaIA["texto"],

            "cantidad" =>
                count($productos),

            "productos" =>
                $productos

        ],

        JSON_UNESCAPED_UNICODE |

        JSON_PRETTY_PRINT

    );


    $conn->close();


    exit();

}


/* ======================================================
   RESPUESTA MIXTA
====================================================== */


if (
    $tipo === "mixta"
) {


    $systemPrompt = <<<SYSTEM

Eres el asistente inteligente de DIVINE.

DIVINE es una tienda de productos para
cuidado de la piel y cabello.

El usuario realizó una pregunta que combina
una consulta general con una posible búsqueda
de productos.

Debes responder primero la parte general
de la pregunta de forma clara y útil.

Después, si existen productos encontrados,
puedes mencionar los productos disponibles
en DIVINE.

IMPORTANTE:

Los productos proporcionados en el contexto
son los únicos productos reales de DIVINE.

NO inventes productos.

NO inventes precios.

NO inventes stock.

NO inventes características que no estén
en la información proporcionada.

Puedes dar consejos generales sobre cuidado
de piel y cabello.

No presentes diagnósticos médicos como certezas.

Si aparecen síntomas intensos, persistentes,
dolor, heridas, infección, sangrado,
inflamación severa o una posible reacción
alérgica, recomienda consultar con un profesional
de salud.

Responde siempre en español.

PRODUCTOS DISPONIBLES:

$productosTexto

SYSTEM;


    $respuestaIA =
        llamarNvidia(

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
                        $busqueda

                ]

            ],

            0.4,

            1500

        );


    if (
        !$respuestaIA["ok"]
    ) {

        http_response_code(

            isset(
                $respuestaIA["codigo"]
            )

            ? $respuestaIA["codigo"]

            : 500

        );


        echo json_encode(

            $respuestaIA,

            JSON_UNESCAPED_UNICODE |

            JSON_PRETTY_PRINT

        );


        $conn->close();


        exit();

    }


    echo json_encode(

        [

            "ok" =>
                true,

            "tipo" =>
                "mixta",

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

            "respuesta" =>
                $respuestaIA["texto"],

            "cantidad" =>
                count($productos),

            "productos" =>
                $productos

        ],

        JSON_UNESCAPED_UNICODE |

        JSON_PRETTY_PRINT

    );


    $conn->close();


    exit();

}


/* ======================================================
   RESPUESTA DE SEGURIDAD
====================================================== */


echo json_encode(

    [

        "ok" =>
            true,

        "tipo" =>
            $tipo,

        "busqueda" =>
            $busqueda,

        "respuesta" =>
            "No pude determinar el tipo de consulta.",

        "productos" =>
            $productos,

        "cantidad" =>
            count($productos)

    ],

    JSON_UNESCAPED_UNICODE |

    JSON_PRETTY_PRINT

);


$conn->close();


exit();

?>
