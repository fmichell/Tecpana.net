<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 23-07-2012
 * @fechaModificacion: 23-07-2012
 * @version: 1.0
 * @descripcion: Recibe una etiqueta por ajax y la asigna al contacto. Si la etiqueta no existe la crea.
 *               Este archivo es llamado desde el detalle de contacto (/info)
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

    // Asignamos la etiqueta al contacto
    $resultado = Contacto::agregarEtiqueta(CUENTA_ID, $_GET['contacto'], $etiquetaId);

    if ($resultado)
        // La etiqueta se agrego correctamente
        $resultado = 1;
    elseif ($resultado === 0)
        // No fue necesario agregar la etiqueta porque el usuario ya la tenia asignada
        $resultado = 2;
    else
        // Ocurrio un error al agregar la etiqueta
        $resultado = 0;

    // Preparamos el arreglo con los resultados y lo retornamos
    $retorno = array('resultado' => $resultado, 'id' => $etiquetaId, 'seo' => $etiquetaSeo, 'contacto' => $_GET['contacto']);
    $retorno = json_encode($retorno);

    die($retorno);
}
die('0');