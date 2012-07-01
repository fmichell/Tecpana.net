<?php
/**
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 28-Jun-12
 * @fechaModificacion: 28-Jun-12
 * @version: 1.0
 * @descripcion: Carga el listado de empresas para el autocompletar de crear empresas
 */
include_once '../../../app/inicio.php';

if (isset($_GET['term']) and !empty($_GET['term'])) {
    $contactos = Contacto::sugerir(CUENTA_ID, $_GET['term']);
    echo json_encode($contactos);
}