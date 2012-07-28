<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 07-26-12
 * @fechaModificacion: 07-26-12
 * @version: 1.0
 * @descripcion: Elimina una etiqueta a un contacto.
 *               Ejecutado por ajax desde detalle de contacto (info)
 */
include_once '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Etiqueta.php';

if (isset($_GET['etiqueta']) and !empty($_GET['etiqueta']) and
    isset($_GET['contacto']) and !empty($_GET['contacto'])) {

    // Eliminamos la etiqueta del contacto
    $resultado = Contacto::eliminarEtiqueta(CUENTA_ID, $_GET['contacto'], $_GET['etiqueta']);

    if ($resultado)
        die('1');
    else
        die('0');
}
die('0');