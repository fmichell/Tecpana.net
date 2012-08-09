<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 08-08-2012
 * @fechaModificacion: 08-08-2012
 * @version: 1.0
 * @descripcion: Metodo para cerrar sesion
 */
// Eliminamos las sesiones existentes
session_start();
$_SESSION = array();
session_destroy();
header('location: /login');
exit();