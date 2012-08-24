<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 08-08-2012
 * @fechaModificacion: 08-08-2012
 * @version: 1.0
 * @descripcion: Formulario de inicio de sesión
 */
include '../../app/inicio.php';
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
            <div class="mensaje">Nombre de usuario o contraseña inválido</div>
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
        function login() {
            $(".loginRecuadro").addClass('opaco');
            var us = $('#correo').val();
            var pw = $('#contrasena').val();
            $.post('/login/ajax/ajaxLogin.php', {'us':us, 'pw':pw}, function(respuesta, estado) {
                if (estado == 'success') {
                    if (respuesta == 1) {
                        document.location.href = '/';
                    } else {
                        setTimeout(function() {
                            $('.mensaje').text('Nombre de usuario o contraseña inválido').fadeIn();
                            $(".loginRecuadro").removeClass('opaco');
                            $("#correo").focus();
                        }, 700);
                    }
                } else {
                    setTimeout(function() {
                        $('.mensaje').text('Ocurrió un error al iniciar la sesión').fadeIn();
                        $(".loginRecuadro").removeClass('opaco');
                    }, 700);
                }
            });
        }
        $(document).on("ready", function() {
            $("#correo").focus();
            $("#correo").keyup(function(event){
                if (event.keyCode == 13) {
                    $("#contrasena").focus();
                }
            });
            $("#contrasena").keyup(function(event){
                if (event.keyCode == 13) {
                    $("#btnSubmitLogin").click();
                }
            });
            $("#btnSubmitLogin").on("click", function() {
                login();
            });
        });
    </script>
</body>
</html>