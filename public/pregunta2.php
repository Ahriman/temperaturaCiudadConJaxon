<?php

    // Preparamos Jaxon:
    require ('./miPhpJaxon.php');

    use function Jaxon\jaxon;

    // Procesar la solicitud
    if($jaxon->canProcessRequest())  $jaxon->processRequest();

?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forecast Weather using OpenWeatherMap with PHP</title>
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
            crossorigin="anonymous"
        >
        <script type="text/javascript" src="../js/script.js"></script>
    </head>
<body>

    <div class="container-fluid">
        <form onsubmit='getTempCiudad(); return false;'>
            <div class="form-group">
                <label for='nombre_ciudad'>Nombre ciudad</label>
                <input id='nombre_ciudad' name='nombre_ciudad' type="text">
                <br>
                <input type='submit' onclick='getTempCiudad(); return false;' value='Obtener temperatura'>
            </div>
        </form>
    </div>

    <p class="mt-3" id='p_temp_ciudad'></p>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" 
        crossorigin="anonymous">
    </script>
</body>
<!-- Añade el CSS y JavaScript con Jaxon -->
<?php
    $jaxon = jaxon();
    echo $jaxon->getCss(), "\n", $jaxon->getJs(), "\n", $jaxon->getScript(), "\n";
    echo "<!-- HTTP comment  -->\n"
?>
</html>