<?php
/**
 * @author Federico Michell
 * @copyright Federico Michell
 **/
// INICIAMOS RELOJ
$tInicial = microtime(true);

// DEFINIMOS ENCABEZADOS GENERALES

//session_cache_limiter('private');
header('X-Powered-By: Iliux', true);
header('Content-type: text/html; charset=UTF-8');
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');

// DEFINIMOS CONSTANTES GENERALES
$local = $desarrollo = $produccion = $ventana = false;
define('SISTEMA_NOMBRE', 'Tecpana.Net');
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    define('SISTEMA_URL', 'http://tuplan.net/');
    $local = true;
} elseif ($_SERVER['HTTP_HOST'] == 'tecpana.net' or $_SERVER['HTTP_HOST'] == 'www.tecpana.net') {
    $produccion = true;
    define('SISTEMA_URL', 'http://tecpana.net/');
} else {
    $desarrollo = true;
    define('SISTEMA_URL', 'http://d.tecpana.net/');
}
if ($produccion) {
    define('COOKIE_DOMAIN', '.tecpana.com');
} else {
    define('COOKIE_DOMAIN', '');
}
define('SISTEMA_RAIZ', dirname(__FILE__));
define('NL', PHP_EOL);
$url_path = explode('?', $_SERVER["REQUEST_URI"]);
$url_path = $url_path[0];
define('SISTEMA_URL_PATH', $url_path);

// PREPARAMOS CAMINO DE INCLUSION

set_include_path(SISTEMA_RAIZ . PATH_SEPARATOR . get_include_path());


// INICIAMOS ZONAHORARIA

date_default_timezone_set('America/Managua');

// DEFINIENDO MANEJO DE ERRORES
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
} else {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

/*
 * INICIAMOS Y PREPARAMOS SESSION
 */
if ($produccion) {
$sessionParams = session_get_cookie_params();
session_set_cookie_params(
    $sessionParams["lifetime"],
    $sessionParams["path"],
    COOKIE_DOMAIN,
    $sessionParams["secure"],
    $sessionParams["httponly"]);
}
session_start();

/*
 * CARGAMOS E INICIAMOS LIBRERIAS Y FUNCIONES NECESARIAS
 */
include 'librerias/Util.php';
include 'librerias/GestorMySQL.php';
include 'librerias/GestorCache.php';
include 'librerias/Tabla.php';
include 'modelos/Contacto.php';

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    //Para conexion local
    $bd = GestorMySQL::obtenerInstancia('produccion', array(
        'servidores' => array(
            array(
                'host' => 'localhost',
                'peso' => 1
            )
        ),
        'usuario' => 'root',
        'contrasena' => '',
        'basedatos' => 'tecpananet',
        'charset' => 'UTF-8',
        'depurar' => false
    ));
} else {
    /*
    //Para produccion / desarrollo
    $cache = GestorCache::obtenerInstancia();
    $cache->configurar(array(
    //    'consistente' => true,
        'servidores' => array(
            array('10.0.0.16', 11213),
            array('10.0.0.17', 11213),
        )
    ));
    $bd = GestorMySQL::obtenerInstancia('produccion', array(
        'servidores' => array(
            array(
                'host' => '10.0.0.50', // alt01.plazavip
                'peso' => 1
            )
        ),
        'usuario' => 'sitio_latinshare',
        'contrasena' => 'ej60BOX1hYAF0LWuZFEN',
        'basedatos' => 'latinshare',
        'charset' => 'UTF-8',
        'depurar' => false
    ));
    $bd->gestor_cache = &$cache;
    */
    die('Error de conexion con la BD. Revisar inicio.php.');
}

// Declaramos Cuenta Id
$_SESSION['CUENTA_ID'] = 1;
define('CUENTA_ID', $_SESSION['CUENTA_ID']);