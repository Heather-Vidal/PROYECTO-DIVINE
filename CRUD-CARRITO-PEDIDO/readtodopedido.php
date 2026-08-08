<?php

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "DIVINE";

$conn = new mysqli($servidor, $usuario, $contraseña, $nombreBD);

if ($conn->connect_error) {
    die("OCURRIÓ UN ERROR AL CONECTAR CON LA BASE DE DATOS");
}

$sql = "SELECT * FROM PEDIDOS";
$resultado = $conn->query($sql);

?>
<?php

$mensaje = $_GET['mensaje'] ?? null;

?>
<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DIVINE | Pedidos</title>

<style>

:root{
    --rosa:#b86f80;
    --rosa-claro:#d9a6b2;
    --rosa-palido:#f7e9ec;
    --crema:#fffaf8;
    --texto:#57494c;
    --gris:#817679;
    --borde:#e3c5cd;
    --vino:#8f5362;
    --vino-oscuro:#713d4d;
}


/* RESET */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


/* BODY */

body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    color:var(--texto);

    background:
    linear-gradient(
        rgba(255,250,248,.78),
        rgba(247,233,236,.90)
    ),
    url("../imagenes/fondote.png");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}


/* ==================================================
   ENCABEZADO
================================================== */

.header{
    text-align:center;
    padding:45px 20px 35px;

    background:
    linear-gradient(
        rgba(184,111,128,.88),
        rgba(143,83,98,.94)
    );

    color:white;

    box-shadow:
    0 10px 35px rgba(100,70,80,.20);
}

.header-pequeno{
    font-size:.78rem;
    text-transform:uppercase;
    letter-spacing:5px;
    margin-bottom:15px;
    opacity:.9;
}


.header h1{
    font-family:Georgia,serif;
    font-size:clamp(2.4rem,5vw,4rem);
    font-weight:400;
    letter-spacing:5px;
}


.header-linea{
    width:55px;
    height:2px;
    background:white;
    margin:22px auto 0;
    opacity:.75;
}


/* ==================================================
   CONTENEDOR
================================================== */

.contenedor{
    width:90%;
    max-width:1100px;
    margin:60px auto;
}


/* ==================================================
   TÍTULO LISTA
================================================== */

.titulo-lista{
    text-align:center;
    margin-bottom:38px;
}


.titulo-lista p{
    color:var(--rosa);
    font-size:.8rem;
    text-transform:uppercase;
    letter-spacing:3px;
    margin-bottom:10px;
}


.titulo-lista h2{
    font-family:Georgia,serif;
    font-size:2rem;
    font-weight:400;
    color:var(--texto);
}


/* ==================================================
   LISTA
================================================== */

.lista{
    display:flex;
    flex-direction:column;
    gap:28px;
}


/* ==================================================
   TARJETA PEDIDO
================================================== */

.item{
    background:rgba(250,243,244,.94);

    border:1px solid rgba(184,111,128,.25);

    border-radius:24px;

    padding:30px 32px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:35px;

    box-shadow:
    0 12px 35px rgba(100,70,80,.13),

    inset 0 1px 0 rgba(255,255,255,.8);

    transition:
    transform .35s ease,
    box-shadow .35s ease,
    background .35s ease;

    animation:aparecer .6s ease;
}


.item:hover{
    transform:translateY(-6px);

    background:rgba(248,236,239,.98);

    box-shadow:
    0 20px 45px rgba(100,70,80,.18);
}


/* ==================================================
   INFORMACIÓN
================================================== */

.info{
    flex:1;
    min-width:0;
}


/* ==================================================
   NÚMERO DE PEDIDO DESTACADO
================================================== */

.id{
    display:inline-flex;

    align-items:center;

    background:
    linear-gradient(
        135deg,
        var(--vino),
        var(--rosa)
    );

    color:white;

    padding:12px 22px;

    border-radius:14px;

    font-size:1.05rem;

    font-weight:700;

    letter-spacing:1.5px;

    margin-bottom:22px;

    box-shadow:
    0 7px 18px rgba(143,83,98,.25);

    border:1px solid rgba(255,255,255,.35);

    transition:
    transform .3s ease,
    box-shadow .3s ease;
}


.item:hover .id{
    transform:translateY(-2px);

    box-shadow:
    0 10px 22px rgba(143,83,98,.32);
}


/* ==================================================
   DATOS
================================================== */

.datos{
    display:grid;

    grid-template-columns:
    repeat(2,minmax(180px,1fr));

    gap:14px 25px;
}


/* ==================================================
   CAJAS DE INFORMACIÓN
================================================== */

.info p{
    margin:0;

    background:rgba(255,250,251,.72);

    border:1px solid rgba(184,111,128,.15);

    border-radius:12px;

    padding:10px 14px;

    color:var(--gris);

    font-size:.92rem;

    line-height:1.5;

    box-shadow:
    0 3px 10px rgba(100,70,80,.04);

    transition:
    background .3s ease,
    transform .3s ease;
}


.info p:hover{
    background:rgba(255,255,255,.9);

    transform:translateX(3px);
}


.info span{
    color:var(--vino-oscuro);

    font-weight:700;
}


/* ==================================================
   ESTADO DESTACADO
================================================== */

.estado{
    display:inline-flex;

    align-items:center;

    margin-top:22px;

    padding:11px 20px;

    border-radius:14px;

    background:
    linear-gradient(
        135deg,
        #fff0f3,
        #f5dce2
    );

    color:var(--vino-oscuro);

    font-size:.88rem;

    font-weight:700;

    text-transform:capitalize;

    letter-spacing:.3px;

    border:1px solid rgba(184,111,128,.3);

    box-shadow:
    0 5px 15px rgba(184,111,128,.12);

    transition:
    transform .3s ease,
    box-shadow .3s ease;
}


.estado:hover{
    transform:translateY(-2px);

    box-shadow:
    0 8px 20px rgba(184,111,128,.20);
}


/* ==================================================
   BOTONES
================================================== */

.botones{
    display:flex;

    flex-direction:column;

    gap:10px;

    min-width:125px;
}


.botones a{
    text-decoration:none;
}


.botones button{
    width:100%;

    min-width:120px;

    padding:12px 18px;

    border:none;

    border-radius:11px;

    color:white;

    cursor:pointer;

    font-size:.85rem;

    font-weight:600;

    transition:
    transform .25s ease,
    box-shadow .25s ease;
}


.botones button:hover{
    transform:translateY(-3px);

    box-shadow:
    0 7px 17px rgba(100,70,80,.20);
}


/* VER */

.botones a:nth-child(1) button{
    background:var(--vino);
}


/* EDITAR */

.botones a:nth-child(2) button{
    background:var(--rosa);
}


/* ELIMINAR */

.botones a:nth-child(3) button{
    background:#b87986;
}


/* ==================================================
   SIN PEDIDOS
================================================== */

.vacio{
    background:rgba(250,243,244,.94);

    border:1px solid var(--borde);

    border-radius:22px;

    padding:70px 30px;

    text-align:center;

    color:var(--gris);

    box-shadow:
    0 12px 35px rgba(100,70,80,.10);
}


/* ==================================================
   VOLVER
================================================== */

.volver{
    text-align:center;

    margin-top:45px;

    padding-bottom:30px;
}


.volver a{
    display:inline-block;

    text-decoration:none;

    color:white;

    background:var(--vino);

    padding:14px 32px;

    border-radius:30px;

    font-size:.9rem;

    font-weight:600;

    letter-spacing:.3px;

    box-shadow:
    0 7px 20px rgba(100,70,80,.18);

    transition:
    background .3s ease,
    transform .3s ease,
    box-shadow .3s ease;
}


.volver a:hover{
    background:var(--rosa);

    transform:translateY(-3px);

    box-shadow:
    0 10px 25px rgba(100,70,80,.25);
}


/* ==================================================
   ANIMACIÓN
================================================== */

@keyframes aparecer{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:768px){

    .header{
        padding:50px 20px 40px;
    }


    .header h1{
        font-size:2.5rem;
        letter-spacing:3px;
    }


    .contenedor{
        width:92%;
        margin:40px auto;
    }


    .item{
        flex-direction:column;
        align-items:stretch;
        padding:25px 20px;
    }


    .id{
        font-size:1rem;
        padding:11px 18px;
    }


    .datos{
        grid-template-columns:1fr;
        gap:10px;
    }


    .botones{
        display:grid;

        grid-template-columns:
        repeat(3,1fr);

        gap:8px;

        min-width:0;

        margin-top:10px;
    }


    .botones button{
        min-width:0;
        padding:10px 5px;
        font-size:.78rem;
    }

}


@media(max-width:450px){

    .botones{
        grid-template-columns:1fr;
    }


    .botones button{
        width:100%;
    }


    .titulo-lista h2{
        font-size:1.7rem;
    }

}
.modal-mensaje {
    position: fixed;
    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background: rgba(0, 0, 0, 0.45);

    display: flex;
    justify-content: center;
    align-items: center;

    z-index: 9999;
}


.mensaje-contenido {
    width: 400px;
    max-width: 90%;

    background: white;

    padding: 35px;

    border-radius: 20px;

    text-align: center;

    box-shadow: 0 10px 40px rgba(0,0,0,0.25);

    animation: aparecer 0.3s ease;
}


.icono-exito {
    width: 65px;
    height: 65px;

    margin: 0 auto 15px;

    border-radius: 50%;

    background: #dff5df;

    color: #3c9b3c;

    font-size: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: bold;
}


.mensaje-contenido h2 {
    margin-bottom: 10px;
}


.mensaje-contenido p {
    font-size: 17px;
    margin-bottom: 25px;
}


.mensaje-contenido button {
    padding: 10px 30px;

    border: none;

    border-radius: 10px;

    cursor: pointer;

    font-size: 16px;
}


@keyframes aparecer {

    from {
        opacity: 0;
        transform: scale(0.8);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }

}
.mensaje-contenido button {
    padding: 10px 30px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s ease;
}

.mensaje-contenido button:hover {
    background-color: #b77f8a;
    color: black;
    transform: scale(1.05);
}

</style>

</head>

<body>

<?php if ($mensaje): ?>

<div class="modal-mensaje">

    <div class="mensaje-contenido">

        <div class="icono-exito">
            ✓
        </div>

        <h2>¡Pedido actualizado!</h2>

        <p>
            <?php echo htmlspecialchars($mensaje); ?>
        </p>

        <button onclick="cerrarMensaje()">
            Aceptar
        </button>

    </div>

</div>

<?php endif; ?>














<div class="header">


<div class="header-pequeno">
    Administración de pedidos
</div>

<h1>
    PEDIDOS DIVINE
</h1>

<div class="header-linea"></div>


</div>

<div class="contenedor">


<div class="titulo-lista">

    <p>
        Gestión de pedidos
    </p>

    <h2>
        Lista de pedidos registrados
    </h2>

</div>


<div class="lista">

<?php

if($resultado && $resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        $idPedido = $fila['ID'];

?>

```
    <div class="item">


        <div class="info">


            <div class="id">

                PEDIDO #<?php echo $idPedido; ?>

            </div>


            <div class="datos">


                <p>
                    <span>Nombre:</span>
                    <?php echo htmlspecialchars($fila['nombre']); ?>
                </p>


                <p>
                    <span>Fecha:</span>
                    <?php echo htmlspecialchars($fila['fecha']); ?>
                </p>


                <p>
                    <span>Teléfono:</span>
                    <?php echo htmlspecialchars($fila['telefono']); ?>
                </p>


                <p>
                    <span>Dirección:</span>
                    <?php echo htmlspecialchars($fila['direccion']); ?>
                </p>


                <p>
                    <span>Vendedor:</span>
                    <?php echo htmlspecialchars($fila['nombrevendedor']); ?>
                </p>


            </div>


            <div class="estado">

                Estado:
                <?php echo htmlspecialchars($fila['estado']); ?>

            </div>
            <br> <br>



<div class="botones">

    <a href="actualizarestadopedido.php?idPedido=<?php echo $idPedido; ?>&estado=En%20proceso">
        <button type="button">Aceptar</button>
    </a>

    <a href="actualizarestadopedido.php?idPedido=<?php echo $idPedido; ?>&estado=Rechazado">
        <button type="button">Rechazar</button>
    </a>

</div>








        </div>


        <div class="botones">


            <a href="readunopedido.php?idPedido=<?php echo $idPedido; ?>">

                <button type="button">
                    Ver
                </button>

            </a>


            <a href="updateformpedido.php?idPedido=<?php echo $idPedido; ?>">

                <button type="button">
                    Editar
                </button>

            </a>


            <a href="deletepedido.php?idPedido=<?php echo $idPedido; ?>">

                <button type="button">
                    Eliminar
                </button>

            </a>


        </div>


    </div>
```

<?php

    }

}else{

?>

```
    <div class="vacio">

        No hay pedidos registrados en este momento.

    </div>
```

<?php

}

?>

```
</div>


<div class="volver">

    <a href="../perfilvendedor.php">
        Volver al perfil
    </a>

</div>
```

</div>
<script>

function cerrarMensaje() {

    document.querySelector(".modal-mensaje").style.display = "none";

}

</script>
</body>

</html>

<?php

$conn->close();

?>
