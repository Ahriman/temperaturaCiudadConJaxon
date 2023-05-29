<?php
// [JAXON-PHP]
// spl_autoload_register(function ($clase) {
//     include "../src/" . $clase . ".php";
// });
require '../vendor/autoload.php';

use Jaxon\Jaxon;
use function Jaxon\jaxon;

$jaxon = jaxon();

// Opciones de configuración Jaxon: 
$jaxon->setOption('js.app.minify', false);
$jaxon->setOption('core.decode_utf8', true);
$jaxon->setOption('core.debug.on', false);
$jaxon->setOption('core.debug.verbose', false);

/**
 * Función que obtiene la temperatura de una ciudad.
 * 
 * Devuelve una respuesta Jaxon.
 * 
 * @param string $nombre_ciudad
 * @return Jaxon/Response/Response
 */
function getTempCiudad($nombre_ciudad)  {

    $resp = jaxon()->newResponse();

    // Inicio
    // https://programacion.net/articulo/pronostico_del_tiempo_utilizando_openweathermap_mediante_php_2035

    include '../claves.inc.php';

    $apiKey = $keyOpenWeatherMap;
    $lang = 'en'; // Idioma de la descripción

    // Obtener ID de la ciudad
    $cityId = getIdCiudad($nombre_ciudad);
    
    $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=$lang&units=metric&APPID=" . $apiKey;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    curl_close($ch);
    $data = json_decode($response);
    $currentTime = time();
    // Fin

    // $texto = "La temperatura de {$data->name} es {$data->main->temp}.";
    // $resp->assign("p_temp_ciudad", "innerHTML", $texto);
    
    $resp->assign("p_temp_ciudad", "innerHTML", getHTML($data, $currentTime));

    return $resp;
}

/**
 * Función que obtiene el ID de una ciudad buscándolo en un archivo JSON dado un nombre de ciudad.
 * 
 * Devuelve una respuesta Jaxon.
 * 
 * @param string $nombre_ciudad
 * @return Jaxon/Response/Response
 */
function getIdCiudad($nombre_ciudad)  {

    $cityId = -1;
    $country = 'ES';

    // Obtener ID ciudad del JSON
    $city_list = file_get_contents('./city.list.json');
    $city_list_array  = json_decode($city_list, true);

    // Buscar ID en el JSON proporcionando el nombre de la ciudad
    for ($i=0; $i < count($city_list_array); $i++) {
        if($city_list_array[$i]['name'] === $nombre_ciudad &&
        $city_list_array[$i]['country'] === $country){
            // var_dump($city_list_array[$i]);
            $cityId = $city_list_array[$i]['id'];
            break;
        }
    }

    return $cityId;
}


function getHTML($data, $currentTime) {

    $dia = date("l g:i a", $currentTime);
    $diaMesAnho = date("jS F, Y", $currentTime);
    $descripcion = ucwords($data->weather[0]->description); // ucwords -> Primera letra en mayúsculas

    $html = <<<EOD
        <div class="report-container">
            <h2>{$data->name} Weather Status</h2>
            <div class="time">
                <div>$dia</div>
                <div>$diaMesAnho</div>
                <div>$descripcion</div>
            </div>
            <div class="weather-forecast">
                <img src="http://openweathermap.org/img/w/{$data->weather[0]->icon}.png"
                    class="weather-icon" />{$data->main->temp_max} °C<span
                    class="min-temperature">{$data->main->temp_min} °C</span>
            </div>
            <div class="time">
                <div>Humidity: {$data->main->humidity} %</div>
                <div>Wind: {$data->wind->speed} km/h</div>
            </div>
        </div>
    EOD;

    return $html;
}

// Registra la función getMontante en Jaxon
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'getTempCiudad');
