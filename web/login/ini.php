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
<body id="Login">
    <div class="mainWrapper">
        <section id="MainWrapperLogin">
            <div class="mensaje"><span>Nombre de usuario o contraseña inválido</span></div>
            <h1 id="LoginCuenta"><?php echo $_SESSION['SUBDOMINIO'] ?>.tecpana.net</h1>
            <div class="loginRecuadro">
                <form method="post" action="" name="frmLogin" id="frmLogin">
                    <div class="interior25">
                        <div class="linea">
                            <label for="correo">Tu correo electrónico</label>
                        </div>
                        <div class="linea">
                            <input type="email" name="correo" id="correo" style="width: 320px;" />
                        </div>
                        <div class="linea20"></div>
                        <div class="linea">
                            <label for="contrasena">Tu contraseña</label>
                        </div>
                        <div class="linea">
                            <input type="password" name="contrasena" id="contrasena" style="width: 209px;" />
                            <a href="javascript:;" id="btnSubmitLogin" class="btnSubmitLogin">Iniciar sesión</a>
                            <input type="hidden" name="submitLogin" id="submitLogin" value="submit" />
                        </div>
                    </div>
                    <div class="separadorLogin"></div>
                    <div class="interior25" style="font-size: 0.8em;">
                        <div class="linea" style="line-height: 0.8em;">
                            <label><input type="checkbox"> Mantener la sesión abierta</label> &bull; <a href="/login/recordar">Recordar contraseña</a>
                        </div>
                    </div>
                </form>
                <div class="ajaxLoader"><img src="/media/imgs/ajax-loader.gif" /></div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(document).on("ready", function() {
            $("#btnSubmitLogin").on("click", function() {
                $(".loginRecuadro").addClass('opaco');

            });
        });
    </script>
</body>
</html>