<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 08-08-2012
 * @fechaModificacion: 08-08-2012
 * @version: 1.0
 * @descripcion: Formulario de inicio de sesión
 */
include '../../app/inicio.php';

if (isset($_POST['submitLogin'])) {
    $resultado = Usuario::iniciarSesion(CUENTA_ID, $_POST['correo'], $_POST['contrasena']);
    if (!$resultado) echo 'Usuario o contraseña inválido';
    else header('location: /');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iniciar sesión - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../includes/cabezera.php' ?>
</head>
<body>
<form method="post" action="" name="frmLogin" id="frmLogin">
    <label for="correo">Correo electrónico:</label>
    <input type="text" name="correo" id="correo" />
    <label for="contrasena">Contraseña:</label>
    <input type="text" name="contrasena" id="contrasena" />
    <input type="submit" value="Iniciar sesión" name="submitLogin" id="submitLogin">
</form>
</body>
</html>