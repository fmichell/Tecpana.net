<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 31-Jul-12
 * @fechaModificacion: 31-Jul-12
 * @version: 1.0
 * @descripcion: Edita el perfil del usuario, lo desactiva o lo elimina en dependencia de los parametros recibidos.
 *               Se ejecuta por ajax desde el archivo /usuarios/ini.php
 *               Las posibles opciones son:
 *               1 = Editar perfil
 *               2 = Activar usuario
 *               3 = Desactivar usuario
 *               4 = Eliminar usuario
 */
include_once '../../../app/inicio.php';

if (isset($_GET['op']) and !empty($_GET['op']) and isset($_GET['us']) and !empty($_GET['us'])) {
    // Obtenermos id del usuario
    $usuarioId = $_GET['us'];

    if ($_GET['op'] == 1) {
        // Editamos perfil
        if (!isset($_GET['pf']) or empty($_GET['pf']))
            die('0');

        $resultado = Usuario::editarPerfil(CUENTA_ID, $usuarioId, $_GET['pf']);

        // Si el resultado es true, retornamos un valor codificado JSON (solo válido para perfil)
        if ($resultado) {
            $arrayRespuesta = array('estado' => 1, 'perfil' => Usuario::$arrayPerfiles[$_GET['pf']]);
        } else {
            $arrayRespuesta = array('estado' => 0, 'error' => 'Ocurrió un error al actualizar el perfil');
        }
        die(json_encode($arrayRespuesta));
    } elseif ($_GET['op'] == 2) {
        // Activamos usuario
        $resultado = Usuario::activar(CUENTA_ID, $usuarioId);
    } elseif ($_GET['op'] == 3) {
        // Desactivamos usuario
        $resultado = Usuario::desactivar(CUENTA_ID, $usuarioId);
    } elseif ($_GET['op'] == 4) {
        // Eliminamos usuario
        $resultado = Usuario::eliminar(CUENTA_ID, $usuarioId);
    } elseif ($_GET['op'] == 5) {
        // Convertir contacto en usuario
        if (!isset($_GET['pf']) or empty($_GET['pf']))
            die('0');

        $resultado = Usuario::convertirUsuario(CUENTA_ID, $usuarioId, $_GET['pf']);

        // Si el resultado es false ocurrio un error, de lo contrario esta bien
        if ($resultado === false) {
            $mensaje = 'Ocurrió un error al convertir al contacto.\n';
            $mensaje.= 'Verfique que el contacto tenga una dirección de correo electrónico.';
            $arrayRespuesta = array('estado' => 0, 'error' => $mensaje);
        } else {
            $mensaje = 'Se ha enviado un correo electrónico a ' . $resultado . ' con las instrucciones de acceso.';
            $arrayRespuesta = array('estado' => 1, 'mensaje' => $mensaje);
        }
        die(json_encode($arrayRespuesta));
    }

    if ($resultado)
        die('1');
    else
        die('0');
}
die('0');