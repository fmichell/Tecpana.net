<?php
/**
 * @autor: Federico
 * @fechaCreacion: 08-24-12
 * @fechaModificacion: 08-24-12
 * @version: 1.0
 * @descripcion: Formulario para editar perfil de usuario
 */
include '../../../app/inicio.php';

// Verificamos la sesion y los permisos
Usuario::verificarSesion();

// Obteniendo el id del contacto
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $contacto_id = $_GET['id'];
} else {
    header ('location: /contactos');
    exit;
}

// Verificamos que el usuario en linea solo pueda cambiar su propia contraseña
if ($contacto_id != $_SESSION['USUARIO_ID'])
    header ('location: /contactos');

// Editamos información del perfil de usuario
if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'editar') and !empty($_POST['id_contacto'])) {
    // Capturamos el id del contacto que viene del formulario
    $contacto_id = $_POST['id_contacto'];

    $resultado = Usuario::editarInfoPerfil(CUENTA_ID, $contacto_id, $_POST['usuario'], $_POST['notificaciones'], $_POST['zona']);
    if (!$resultado) {
        die('Ocurrio un error');
    } else {
        // Redireccionamos a info
        header('location: /contactos/' . $contacto_id . '/perfil');
        exit;
    }
}
// Obteniendo datos del contacto
$contacto = Contacto::obtener(CUENTA_ID, $contacto_id);
$usuario  = Usuario::obtener(CUENTA_ID, $contacto_id);
// Obtenemos foto del contacto
$profilePic = Contacto::obtenerFotos($contacto['foto'], $contacto['tipo'], $contacto['sexo']);

$zonas = Fecha::obtenerZonas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Información de la cuenta <?php echo $contacto['nombre_completo'] ?> - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/form.css" />
</head>
<body>
<?php
// Cargamos la cabezera de la pagina
include '../../includes/encabezado.php';
?>

<div class="mainWrapper">
<!--MainWrapper begins-->
<div id="MainWrapper">
    <?php
    // Cargamos el menu principal
    include '../../includes/menu-principal.php';
    ?>

    <!--Content begins-->
    <section id="Content">
        <!--Workspace begins-->
        <section id="Workspace" class="colum formulario">
            <!--Workspace Header begins-->
            <div class="workspaceHeader interior10">
                <header>
                    <h1>Información de la cuenta &raquo; <?php echo $contacto['nombre_completo'] ?></h1>
                    <div class="linea30"></div>
                </header>
            </div>
            <!--Workspace Header ends-->

            <!--Workspace Toolbar begins-->
            <div class="workspaceToolbar">
                <div class="opciones">
                    <ul>
                        <li><a href="/contactos/<?php echo $contacto_id ?>/editar-persona/">Información de contacto</a></li>
                        <li>
                            <a href="/contactos/<?php echo $contacto_id ?>/agregar-foto/">
                                <?php echo ($profilePic['hayProfile']) ? 'Cambiar foto' : 'Subir foto' ?>
                            </a>
                        </li>
                        <li><a class="activo" href="/contactos/<?php echo $contacto_id ?>/editar-perfil/">Información de la cuenta</a></li>
                        <li><a href="/contactos/<?php echo $contacto_id ?>/cambiar-contrasena/">Cambiar contraseña</a></li>
                    </ul>
                </div>
            </div>
            <!--Workspace Toolbar ends-->

            <!--Workspace Area Info begins-->
            <div class="workspaceArea interior10">
                <form method="post" action="" name="frmEditarPerfil" id="frmEditarPerfil" class="frmPerfil">
                    <input type="hidden" name="submitForm" value="editar" />
                    <input type="hidden" name="id_contacto" value="<?php echo $contacto_id ?>" />
                    <div class="linea10"></div>
                    <div class="linea30"><strong>Información de la cuenta</strong></div>
                    <dl class="vertical">
                        <dt><label for="usuario">Email para inicio de sesión</label></dt>
                        <dd>
                            <select name="usuario" id="usuario" class="ancho250es">
                                <?php foreach ($contacto['email'] as $email) {
                                    $selected = ($usuario['usuario'] == $email['valor']) ? 'selected="selected"' : '';
                                    ?>
                                <option value="<?php echo $email['valor'] ?>" <?php echo $selected ?>><?php echo $email['valor'] ?></option>
                                    <?php
                                } ?>
                            </select>
                        </dd>
                        <dt><label for="notificaciones">Email para recibir notificaciones</label></dt>
                        <dd>
                            <select name="notificaciones" id="notificaciones" class="ancho250es">
                                <?php foreach ($contacto['email'] as $email) {
                                $selected = ($usuario['correo_notificacion'] == $email['valor']) ? 'selected="selected"' : '';
                                ?>
                                <option value="<?php echo $email['valor'] ?>" <?php echo $selected ?>><?php echo $email['valor'] ?></option>
                                <?php
                            } ?>
                            </select>
                        </dd>
                        <dt><label for="zona">Zona tiempo</label></dt>
                        <dd>
                            <select name="zona" id="zona" class="ancho250es zonas">
                                <?php foreach ($zonas as $continente => $zona) { ?>
                                <optgroup label="<?php echo $continente ?>">
                                    <?php foreach ($zona as $llave => $etiqueta) {
                                        $selected = ($usuario['zona_tiempo'] == $llave) ? 'selected="selected"' : '';
                                        ?>
                                    <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $etiqueta ?></option>
                                        <?php
                                    } ?>
                                </optgroup>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>

                    <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnSubmit">Guardar cambios</a>
                    <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnCancel" data-contacto="<?php echo $contacto_id ?>">Cancelar</a>
                    <div class="linea10"></div>
                </form>
            </div>
            <!--Workspace Area Info ends-->
        </section>
        <!--Workspace ends-->
        <div class="clear"><!--empy--></div>
    </section>
    <!--Content ends-->
</div>
<!--MainWrapper ends-->
</div>
<?php
// Cargamos el pie de pagina
include '../../includes/pie.php';
?>
<script type="text/javascript">
$(document).on("ready", function() {
    $("#btnSubmit").click(function() {
        $("#frmEditarPerfil").submit();
    });
    $("#btnCancel").click(function() {
        var contacto = $(this).data("contacto");

        var respuesta = confirm('Está seguro que desea cancelar?');
        if (respuesta) {
            window.location.href = '/contactos/' + contacto + '/perfil';
        } else {
            return false;
        }
    });
});
</script>
</body>
</html>