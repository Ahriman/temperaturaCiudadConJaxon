// [JAXON-PHP]
function getTempCiudad() {

    let nombre_ciudad = document.getElementById('nombre_ciudad').value;
    // Llamamos por AJAX al php:
    jaxon_getTempCiudad(nombre_ciudad);
    
    return false;
}