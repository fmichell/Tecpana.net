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
        $resultado = 1;
    elseif ($resultado === 0)
        $resultado = 2;
    else
        $resultado = 0;

    $retorno = array('resultado' => $resultado, 'id' => $etiquetaId, 'seo' => $etiquetaSeo, 'contacto' => $_GET['contacto']);
    $retorno = json_encode($retorno);

    die($retorno);
}
die('0');