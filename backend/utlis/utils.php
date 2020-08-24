<?php

function rs2json($rsText, $cantidadRegisros = 0) {
    $cantidadRegisros++; //para no modificar el resto de los codigos simplemente se suma
    $resultado = '{"data": ' . $rsText . '}';
    return $resultado;
}

//*******************************************************
//valida que el usuario tenga acceso al sistema 1 o alguno de los 
//sistemas, sino retorna un -1
//*******************************************************
function validateMainAccess($access, $tipo) {
    $result = false;
    foreach ($access as $a) {
        if (intval($a['TIPO']) === intval($tipo)) {
            $result = true;
        }
    }
    return $result;
}

//*******************************************************
//se obtienes los cf a los que se tiene acceso por tipo
//*******************************************************
function obtenerArregloXTipo($access, $tipo) {
    $datos = array();
    foreach ($access as $a) {
        if (intval($a['TIPO']) === $tipo){
            array_push($datos, intval($a['CF_DIR']));
        }
    }
    return $datos;
}

//*******************************************************
//si obtiene los tipos de usuario que tiene asoaciado 
//*******************************************************
function obtenerTiposXUsuario($access) {
    $datos = array();
    foreach ($access as $a) {
        array_push($datos, intval($a['TIPO']));
    }
    $datos = array_unique($datos);
    return $datos;
}

//*******************************************************
//metodo que obtiene los cf o div del arreglo de accesos
//*******************************************************
function validaPermisosTramitar($access, $tipo, $cf) {
    $result = false;
    foreach ($access as $a) {
        if (intval($a['TIPO']) === $tipo && 
            intval($a['CF_DIR']) === $cf && 
            ($a['TRAMITA'] === 1 || $a['TRAMITA'] === "1")) {
            $result = true;
        }
    }
    return $result;
}

//*******************************************************
//CURL 
//*******************************************************

function curl_call($method, $url, $data) {
    $error = true;
    $cantidadIntentos = 0;

    while ($error === true && $cantidadIntentos <= 3) {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        //OPTIONS
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if (!$result) {
            $result = '{"resp":"null"}';
        } else {
            $error = false;
        }
        curl_close($curl);
        $cantidadIntentos++;
    }
    return $result;
}

function getIP() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

/**
 * Count the number of working days between two dates.
 *
 * This function calculate the number of working days between two given dates,
 * taking account of the Public festivities, Easter and Easter Morning days,
 * the day of the Patron Saint (if any) and the working Saturday.
 *
 * @param   string  $date1    Start date ('YYYY-MM-DD' format)
 * @param   string  $date2    Ending date ('YYYY-MM-DD' format)
 * @param   boolean $workSat  TRUE if Saturday is a working day
 * @param   string  $patron   Day of the Patron Saint ('MM-DD' format)
 * @param   boolean $workSun  TRUE if Sunday is a working day
 * @return  integer           Number of working days ('zero' on error)
 *
 * @author Massimo Simonini <massiws@gmail.com>
 */

function getDiasLaborales($date1, $date2, $workSat = FALSE, $workSun = FALSE, $patron = NULL) {
    
    $date1 = str_replace("/","-", $date1);
    $date2 = str_replace("/","-", $date2);
    
    if (!defined('SATURDAY')) {
        define('SATURDAY', 6);
    }
    if (!defined('SUNDAY')) {
        define('SUNDAY', 0);
    }
    // Array of all public festivities

    $publicHolidays = array('01-01', '04-11', '04-10', '04-09', '05-01', '07-25', '08-02', '08-15', '09-15', '12-01' , '12-25');
    
    $publicHolidays = array('01-01', '04-11', '04-10', '04-09', '05-01', '07-25', '08-02', '08-15', '09-15', '12-01' , '12-25');

    // The Patron day (if any) is added to public festivities
    if ($patron) {
        $publicHolidays[] = $patron;
    }
    /*
     * Array of all Easter Mondays in the given interval
     */
    $yearStart = date('Y', strtotime($date1));
    $yearEnd = date('Y', strtotime($date2));
    /*for ($i = $yearStart; $i <= $yearEnd; $i++) {
        $easter = date('Y/m/d', easter_date($i));
        list($y, $m, $g) = explode("-", $easter);
        $monday = mktime(0, 0, 0, date($m), (date($g) + 1), date($y));
        $easterMondays[] = $monday;
    }*/
    $start = strtotime($date1);
    $end = strtotime($date2);
    $workdays = 0;
    for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
        $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
        $day = (int)$day;
        $mmgg = date('m-d', $i);
        if (    !in_array($mmgg, $publicHolidays) &&
                //!in_array($i, $easterMondays) &&
                !($day === 6 && ($workSat === "false" || $workSat === false)) &&
                !($day === 0 && ($workSun === "false" || $workSun === false))) {
            $workdays++;
        }
    }
    return intval($workdays);
}

/**
 * Get final date from initial date plus a days number.
 *
 * This function calculate the final date with working days.
 *
 * @param   string  $date1    Start date ('YYYY-MM-DD' format)
 * @param   string  $date2    Ending date ('YYYY-MM-DD' format)
 * @param   boolean $workSat  TRUE if Saturday is a working day
 * @param   string  $patron   Day of the Patron Saint ('MM-DD' format)
 * @param   boolean $workSun  TRUE if Sunday is a working day
 * @return  integer           Number of working days ('zero' on error)
 *
 * @author ChGari <cgaritaf@ice.go.cr>
 */

function getFinalDate($date1, $days, $workSat = FALSE, $workSun = FALSE, $patron = NULL) {
    
    $date1 = str_replace("/","-", $date1);
    
    if (!defined('SATURDAY')) {
        define('SATURDAY', 6);
    }
    if (!defined('SUNDAY')) {
        define('SUNDAY', 0);
    }
    // Array of all public festivities
    $publicHolidays = array('01-01', '04-11', '04-10', '04-09', '05-01', '07-25', '08-02', '08-15', '09-15', '10-12' , '12-25');
    if ($patron) {
        $publicHolidays[] = $patron;
    }
   
    $yearStart = date('Y', strtotime($date1));
    
    $start      = strtotime($date1);
    $end        = 0;
    $workdays   = 0;
    $i          = 0;
    for ($i = $start; $workdays <= $days; $i = strtotime("+1 day", $i)) {
        if($workdays === $days){
            break;
        }
        $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
        $day = (int)$day;
        $mmgg = date('m-d', $i);
        if (    !in_array($mmgg, $publicHolidays) &&
                !($day === 6 && ($workSat === "false" || $workSat === false)) &&
                !($day === 0 && ($workSun === "false" || $workSun === false))) {
            $workdays++;
        }
        
    }
    
    $end = $i;
    
    $finalDate = date('Y-m-d',$end);
    return  $finalDate;
}


function utf8_string_array_encode(&$array){
    $func = function(&$value,&$key){
        if(is_string($value)){
            $value = utf8_encode($value);
        }
        if(is_string($key)){
            $key = utf8_encode($key);
        }
        if(is_array($value)){
            utf8_string_array_encode($value);
        }
    };
    array_walk($array,$func);
    return $array;
}

function fillInfoWithSpaces_left($length,$text){
    return str_pad($text,$length," ",STR_PAD_LEFT);
}

function fillInfoWithSpaces_right($length,$text){
    return str_pad($text,$length," ",STR_PAD_RIGHT);
}