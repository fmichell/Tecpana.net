<?php
/**
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 12-Jul-12
 * @fechaModificacion: 12-Jul-12
 * @version: 1.0
 * @descripcion: Elimina la foto de perfil de un contacto
 */
include_once '../../../app/inicio.php';

if (isset($_GET['contactoId']) and !empty($_GET['contactoId'])) {
    $resultado = Contacto::eliminarFoto(CUENTA_ID, $_GET['contactoId'], true);
    if ($resultado) {
        $contacto = Contacto::obtener(CUENTA_ID, $_GET['contactoId']);
        $tmpFoto = Contacto::obtenerFotos($contacto['foto'], $contacto['tipo'], $contacto['sexo']);
        if ($tmpFoto) {
            die($tmpFoto['uriProfile']);
        } else {
            die('0');
        }
    } else {
        die('0');
    }
}
die('0');