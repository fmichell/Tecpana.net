<?php
/**
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 24-Jul-12
 * @fechaModificacion: 24-Jul-12
 * @version: 1.0
 * @descripcion: Carga el listado de etiquetas para el autocompletar de agregar etiqueta
 */
include_once '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Etiqueta.php';

if (isset($_GET['term']) and !empty($_GET['term'])) {
    $etiquetas = Etiqueta::sugerir(CUENTA_ID, $_GET['term']);
    $resultado = json_encode($etiquetas);
    die($resultado);
}
die();