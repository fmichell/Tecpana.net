<?php
/**
 * @autor: Federico
 * @fechaCreacion: 07-23-12
 * @fechaModificacion: 07-23-12
 * @version: 1.0
 * @descripcion:
 */
include_once '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Etiqueta.php';

if (isset($_GET['etiqueta']) and !empty($_GET['etiqueta']) and
    isset($_GET['contacto']) and !empty($_GET['contacto'])) {

    // Generamos etiqueta seo
    $etiquetaSeo = util_preparar_var($_GET['etiqueta'], 'seo');
    // Verificamos si la etiqueta existe
    $etiquetaId = Etiqueta::obtenerEtiquetaSeo(CUENTA_ID, $etiquetaSeo);

    // Si la etiqueta no existe la creamos
    if (!$etiquetaId) {
        $etiquetaId = Etiqueta::crearEtiqueta(CUENTA_ID, $_GET['etiqueta']);
    } else {
        $etiquetaId = $etiquetaId['etiqueta_id'];
    }

    $resultado = Contacto::agregarEtiqueta(CUENTA_ID, $_GET['contacto'], $etiquetaId);

    if ($resultado)
        die('1');
    elseif ($resultado === 0)
        die('2');
    else
        die('0');
}
die('0');