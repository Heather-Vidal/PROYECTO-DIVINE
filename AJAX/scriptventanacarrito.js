function abrirCarrito(){

    // Abrir la ventana emergente
    document.getElementById("ventanaCarrito").style.display = "block";

    // Cargar directamente readcarrito.php
    fetch("readcarrito.php?idPedido=" + idPedido)

    .then(res => res.text())

    .then(data => {

        document.getElementById("contenidoCarrito").innerHTML = data;

    })


    .catch(error => {

        console.error("Error al cargar el carrito:", error);

        document.getElementById("contenidoCarrito").innerHTML =
            "<p>Error al cargar el carrito.</p>";

    });

}


function cerrarCarrito(){

    document.getElementById("ventanaCarrito").style.display = "none";

}