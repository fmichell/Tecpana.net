<?php
/**
 * @autor: Federico
 * @fechaCreacion: 08-23-12
 * @fechaModificacion: 08-23-12
 * @version: 1.0
 * @descripcion: Recibe usuario y contraseña por ajax y realiza el inicio de sesión
 *               o retorna error en caso de fallo
 */
include_once '../../../app/inicio.php';

if (isset($_POST['us']) and !empty($_POST['us']) and
    isset($_POST['pw']) and !empty($_POST['pw'])) {
    $resultado = Usuario::iniciarSesion(CUENTA_ID, $_POST['us'], $_POST['pw']);
    if (!$resultado)
        die('0');
    else
        die('1');
}
die('0');
