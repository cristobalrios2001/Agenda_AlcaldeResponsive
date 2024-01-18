
function imprimir(nombreDiv) {
    mostrarBanner();
    imprimirContenido(nombreDiv);
    ocultarBannerDespuesDeDelay();
    recargarPagina();
}

function mostrarBanner() {
    document.getElementById("banner").removeAttribute("hidden");
}

function imprimirContenido(nombreDiv) {
    var contenido = document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal = document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}

function ocultarBannerDespuesDeDelay() {
    setTimeout(function () {
        document.getElementById("banner").setAttribute("hidden", "hidden");
    }, 500);
}

function recargarPagina() {
    setTimeout(function () {
        location.reload(window.location + 'administrador');
    }, 500);
}
