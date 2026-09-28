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
    "";

$modelo =
    "openai/gpt-oss-20b";


/* ======================================================
   VALIDAR API KEY
====================================================== */


if (
    trim($api_key) === "" ||
    $api_key != ""
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

DIVINE vende productos reales relacionados con:

cuidado de la piel

cuidado facial

cuidado del cabello

Tu tarea es ANALIZAR el mensaje del usuario y determinar qué necesita.

NO debes responder al usuario.
NO debes explicar tu decisión.
NO debes agregar texto fuera del JSON.

Debes devolver ÚNICAMENTE un objeto JSON válido.

FORMATO EXACTO:

{
"tipo": "producto",
"categoria": "",
"precio_maximo": 0,
"termino": "",
"necesita_respuesta": true
}

TIPOS POSIBLES

Debes utilizar únicamente uno de estos valores:

"producto"

"pregunta"

"mixta"

1. PRODUCTO

Usa "producto" cuando el usuario está buscando directamente productos de DIVINE.

Esto incluye:

productos concretos

productos de una categoría

productos para un problema específico

productos disponibles

productos con un precio determinado

productos que puedan ayudar con una necesidad

Ejemplos:

"quiero una crema para piel seca"

"qué shampoo tienen"

"busco aceite de argán"

"qué productos tienen para cabello"

"qué crema tienen por menos de 50"

"quiero productos para piel grasa"

"tienen algo para las manchas"

"qué serum tienen"

"muéstrame productos para cabello seco"

En estos casos se debe realizar una búsqueda de productos.

2. PREGUNTA

Usa "pregunta" cuando el usuario quiere únicamente:

una explicación

información general

un consejo

una orientación

una rutina

saber cómo hacer algo

Y NO está solicitando productos de DIVINE.

Ejemplos:

"qué puedo hacer si tengo piel grasa"

"qué rutina puedo hacer"

"cómo cuidar mi cabello"

"qué hago si mi piel se descama"

"cómo debo lavarme la cara"

"para qué sirve el ácido hialurónico"

"por qué se me cae el cabello"

"cómo hidratar la piel"

En estos casos NO se debe realizar una búsqueda de productos.

3. MIXTA

Usa "mixta" cuando el usuario:

describe un problema, necesidad, condición u objetivo relacionado con piel o cabello

y solicita una recomendación, productos o qué debería utilizar

También usa "mixta" cuando solicita una explicación o consejo Y además solicita productos de DIVINE.

IMPORTANTE:

Las siguientes expresiones indican que el usuario quiere una recomendación:

"qué me recomiendas"

"qué productos me recomiendas"

"qué puedo usar"

"qué debería usar"

"qué podría usar"

"qué sería bueno para"

"qué productos serían buenos"

"qué me puede ayudar"

"qué puedo ponerme"

"qué debería comprar"

Si estas expresiones aparecen junto con un problema, necesidad o condición de piel o cabello, utiliza "mixta".

Ejemplos:

"tengo piel grasa, qué productos me recomiendas"

"tengo la piel seca, qué me recomiendas"

"tengo manchas, qué productos puedo usar"

"mi cabello está muy seco, qué me recomiendas"

"se me cae mucho el cabello, qué productos puedo usar"

"tengo acné, qué productos me recomiendas"

"qué puedo usar para mi piel sensible"

"qué sería bueno para mi cabello dañado"

"tengo caspa, qué productos me recomiendas"

"qué hago para el cabello seco y qué productos tienen"

"cómo puedo cuidar mi piel y qué productos me recomiendas"

En estos casos:

se debe realizar una búsqueda de productos

se debe generar posteriormente una respuesta explicativa y contextualizada

los productos encontrados deben formar parte de la recomendación

REGLA PARA DIFERENCIAR PRODUCTO Y MIXTA

Si el usuario simplemente pide productos:

"quiero una crema para piel seca"

→ "producto"

Si el usuario describe un problema y pregunta qué puede usar o qué le recomiendas:

"tengo la piel seca, qué me recomiendas"

→ "mixta"

Si el usuario pide solamente información:

"cómo cuidar la piel seca"

→ "pregunta"

Si pide información Y productos:

"cómo cuidar la piel seca y qué productos me recomiendas"

→ "mixta"

CATEGORÍAS

La categoría indica qué tipo de productos se deben buscar.

Solo puedes utilizar:

"SkinCare"

"SkinHair"

""

SKINCARE

Usa "SkinCare" cuando el usuario se refiere a:

piel

rostro

cara

cuidado facial

piel seca

piel grasa

piel mixta

piel sensible

acné

manchas

arrugas

hidratación facial

limpieza facial

serum facial

crema facial

protector solar

poros

irritación facial

etc.

Ejemplos:

"crema para piel seca"

→ "SkinCare"

"algo para las manchas de la cara"

→ "SkinCare"

"qué me recomiendas para piel grasa"

→ "SkinCare"

SKINHAIR

Usa "SkinHair" cuando el usuario se refiere a:

cabello

pelo

cuero cabelludo

cabello seco

cabello graso

cabello dañado

cabello maltratado

caída del cabello

caspa

shampoo

champú

acondicionador

mascarilla capilar

aceite capilar

tratamiento capilar

etc.

Ejemplos:

"shampoo para cabello seco"

→ "SkinHair"

"qué puedo usar para el cabello dañado"

→ "SkinHair"

"tengo caspa, qué productos me recomiendas"

→ "SkinHair"

CUANDO NO SE PUEDE DETERMINAR

Si no se puede determinar si corresponde a piel o cabello:

""

No inventes una categoría.

CUANDO APARECEN PIEL Y CABELLO

Si el usuario solicita productos para piel Y cabello al mismo tiempo, utiliza:

""

No inventes una categoría.

Ejemplo:

"quiero productos para mi piel y mi cabello"

→ categoria: ""

PRECIO_MAXIMO

Extrae el precio máximo indicado explícitamente por el usuario.

El resultado debe ser siempre un número.

Ejemplos:

"menos de 50"

→ 50

"hasta 100"

→ 100

"máximo 70"

→ 70

"por debajo de 80"

→ 80

"no más de 60"

→ 60

"quiero algo de máximo $40"

→ 40

Si el usuario no indica ningún límite de precio:

→ 0

Ignora la moneda.

No escribas símbolos de moneda.

No escribas texto.

Ejemplo correcto:

"precio_maximo": 50

Ejemplo incorrecto:

"precio_maximo": "$50"

TERMINO

Extrae únicamente las palabras importantes que puedan utilizarse para buscar productos en el nombre o descripción de la base de datos.

El término debe ser corto.

Conserva las palabras que describen:

tipo de producto

problema

necesidad

zona

tipo de piel

tipo de cabello

ingrediente

característica

objetivo

Elimina palabras de relleno y palabras relacionadas con la intención de compra.

NO incluyas:

producto
productos
quiero
necesito
busco
buscar
dame
muéstrame
mostrar
tienen
tiene
hay
para
una
uno
unos
unas
un
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
por
favor
pueden
puede
podrían
podria
puedo
me
mi
mis
recomiendas
recomendar
recomiéndame
recomiendame
usar
uso
comprar
compras
quiero
necesito

EJEMPLOS

"quiero una crema para piel seca"

→ "crema piel seca"

"busco aceite de argán para cabello"

→ "aceite argán cabello"

"qué productos tienen para cabello graso"

→ "cabello graso"

"quiero una crema facial para manchas"

→ "crema facial manchas"

"qué shampoo tienen para cabello seco"

→ "shampoo cabello seco"

"tengo piel grasa, qué productos me recomiendas"

→ "piel grasa"

"tengo manchas en la cara, qué puedo usar"

→ "manchas cara"

"mi cabello está seco y dañado, qué me recomiendas"

→ "cabello seco dañado"

"qué serum tienen para hidratar la piel"

→ "serum hidratar piel"

SI EL USUARIO SOLO PIDE UNA RECOMENDACIÓN

Si el usuario dice:

"qué me recomiendas para piel seca"

El término debe contener la necesidad principal:

→ "piel seca"

No agregues palabras que no estén relacionadas con la necesidad.

SI EL USUARIO MENCIONA UN PROBLEMA

Conserva el problema como parte del término.

Ejemplos:

"tengo acné, qué productos me recomiendas"

→ "acné"

"tengo piel grasa y manchas, qué me recomiendas"

→ "piel grasa manchas"

"se me cae mucho el cabello, qué puedo usar"

→ "caída cabello"

"tengo cabello seco y con frizz"

→ "cabello seco frizz"

NO INVENTAR INFORMACIÓN

Nunca agregues información que el usuario no haya proporcionado.

No inventes:

ingredientes

marcas

productos

problemas

características

tipos de piel

tipos de cabello

precios

categorías

Ejemplo:

Usuario:

"quiero algo para mi piel"

Correcto:

{
"tipo": "producto",
"categoria": "SkinCare",
"precio_maximo": 0,
"termino": "piel",
"necesita_respuesta": true
}

No conviertas "piel" automáticamente en:

"piel seca"

"piel grasa"

"piel sensible"

SI NO EXISTE UN TÉRMINO ÚTIL

Si el usuario pide productos pero no proporciona ninguna característica útil:

"qué productos tienen?"

El término debe ser:

""

No inventes términos.

NECESITA_RESPUESTA

Usa:

true

cuando el mensaje contiene una solicitud, pregunta, necesidad o petición que requiere respuesta.

Ejemplos:

"quiero una crema"

→ true

"qué productos tienen"

→ true

"tengo piel grasa, qué me recomiendas"

→ true

"cómo cuidar mi cabello"

→ true

Usa:

false

únicamente cuando el mensaje no contiene una solicitud, pregunta o necesidad interpretable.

Ejemplos:

"hola"

→ false

"ok"

→ false

"gracias"

→ false

"perfecto"

→ false

"👍"

→ false

REGLAS DE PRIORIDAD

Cuando existan varias condiciones en el mismo mensaje, aplica estas reglas en orden:

Si solicita productos Y una recomendación, explicación o consejo relacionado con un problema → "mixta".

Si solicita productos pero no solicita explicación o consejo → "producto".

Si solicita únicamente información, explicación, consejo o rutina → "pregunta".

Si no existe una solicitud interpretable → "necesita_respuesta": false.

REGLA FINAL

Antes de devolver el JSON verifica:

"tipo" es exactamente "producto", "pregunta" o "mixta".

"categoria" es exactamente "SkinCare", "SkinHair" o "".

"precio_maximo" es un número.

"termino" contiene únicamente palabras útiles para buscar productos.

"necesita_respuesta" es true o false.

No inventaste información.

No agregaste explicaciones.

La respuesta contiene ÚNICAMENTE JSON válido.

Devuelve únicamente el objeto JSON.

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
