<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: alrededor del 23-06-2012
 * @fechaModificacion: 25-08-2012
 * @version: 1.0
 * @descripcion: Formulario para cargar foto del contacto
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

if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'cargar') and !empty($_POST['id_contacto'])) {
    // Capturamos el id del contacto que viene del formulario
    $contacto_id = $_POST['id_contacto'];

    if ($_FILES['foto']['name']) {
        $mediaInput = array(
            'name' => $_FILES['foto']['name'],
            'type' => $_FILES['foto']['type'],
            'size' => $_FILES['foto']['size'],
            'tmp_name' => $_FILES['foto']['tmp_name']
        );

        $tmpFoto = Contacto::subirFotoPerfil($mediaInput, $contacto_id);
        $uriTmpFoto = '/media/profile/tmp/' . $tmpFoto['nombre'];
    } else {
        if (isset($_POST['uriPerfil'])) {
            $mediaInput = array(
                'uri' => $_POST['uriPerfil'],
                'x'   => $_POST['x'],
                'y'   => $_POST['y'],
                'w'   => $_POST['w'],
                'h'   => $_POST['h']
            );
            $resultado = Contacto::cargarFotoPerfil($mediaInput, $contacto_id);
        }
        if (isset($resultado) and ($resultado['estado'] == true)) {
            header('location: /contactos/' . $contacto_id . '/info');
        }
    }
}

// Obteniendo datos del contacto
$contacto = Contacto::obtener(CUENTA_ID, $contacto_id);
// Obtenemos foto del contacto
$profilePic = Contacto::obtenerFotos($contacto['foto'], $contacto['tipo'], $contacto['sexo']);

if ($contacto['tipo'] == 1) {
    $fotoTipo = 'foto';
} else {
    $fotoTipo = 'logotipo';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo ($profilePic['hayProfile']) ? 'Cambiar '.$fotoTipo.' de ' : 'Subir '.$fotoTipo.' de ' ?> <?php echo $contacto['nombre_completo'] ?> - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/form.css" />
    <script type="text/javascript" src="/media/js/jcrop/js/jquery.Jcrop.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/media/js/jcrop/css/jquery.Jcrop.css" />
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
                        <h1><?php echo ($profilePic['hayProfile']) ? 'Cambiar ' . $fotoTipo : 'Subir ' . $fotoTipo ?> &raquo; <?php echo $contacto['nombre_completo'] ?></h1>
                        <div class="linea30"></div>
                    </header>
                </div>
                <!--Workspace Header ends-->

                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div class="opciones">
                        <ul>
                            <?php if ($contacto['tipo'] == 1) { ?>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/editar-persona/">Información de contacto</a></li>
                            <?php } else { ?>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/editar-empresa/">Información de contacto</a></li>
                            <?php } ?>
                            <li>
                                <a class="activo" href="/contactos/<?php echo $contacto_id ?>/agregar-foto/">
                                    <?php echo ($profilePic['hayProfile']) ? 'Cambiar ' . $fotoTipo : 'Subir ' . $fotoTipo ?>
                                </a>
                            </li>
                            <?php if ($contacto_id == $_SESSION['USUARIO_ID']) { ?>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/editar-perfil/">Información de la cuenta</a></li>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/cambiar-contrasena/">Cambiar contraseña</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->

                <!--Workspace Area Info begins-->
                <div class="workspaceArea interior10">
                    <div class="linea10"></div>
                    <form method="post" action="" name="frmAddFoto" id="frmAddFoto" class="frmContacto" enctype="multipart/form-data">
                        <input type="hidden" name="submitForm" value="cargar" />
                        <input type="hidden" name="id_contacto" value="<?php echo $contacto_id ?>" />
                        <dl class="horizontal">
                            <dt><label for="foto">Seleccionar foto</label></dt>
                            <dd><input type="file" name="foto" id="foto"></dd>
                            <?php if (isset($_GET['hayProfile'])) { ?>
                            <dt>&nbsp</dt>
                            <dd>ó <a href="javascript:;" class="rojo negrita" id="eliFoto">Eliminar la foto actual</a>.</dd>
                            <?php } ?>
                        </dl>

                        <?php if (isset($uriTmpFoto) and !empty($uriTmpFoto)) { ?>
                        <div class="linea"><img src="<?php echo $uriTmpFoto ?>" id="cropbox"></div>
                        <input type="hidden" name="uriPerfil" id="uriPerfil" value="<?php echo $tmpFoto['uri'] ?>">
                        <?php } ?>

                        <!-- Cordenas -->
                        <input type="hidden" id="x" name="x" />
                        <input type="hidden" id="y" name="y" />
                        <input type="hidden" id="w" name="w" />
                        <input type="hidden" id="h" name="h" />

                        <div class="linea10"></div>
                        <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnSubmit">Cargar imagen</a>
                        <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnCancel" data-contacto="<?php echo $contacto_id ?>">Cancelar</a>
                        <div class="linea30 clear"></div>
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
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
    function checkCoords()
    {
        if (parseInt($('#w').val())) return true;
        alert('Por favor seleccione un area de la imagen');
        return false;
    };
    $(document).on("ready", function() {
        $('#cropbox').Jcrop({
            aspectRatio: 1,
            onSelect: updateCoords,
            minSize: [128, 128],
            maxSize: [500, 500],
            setSelect: [ 10, 10, 128, 128 ]
        });

        $('#eliFoto').click(function() {
            var confirmar = confirm('Está seguro que desea eliminar permanentemente la foto de perfil?');
            if (confirmar) {
                var contacto_id = '<?php echo $contacto_id ?>';
                $.get('/contactos/ajax/ajaxEliminarFoto.php', {'contactoId':contacto_id}, function(respuesta) {
                    if (respuesta == 0) {
                        alert('Ocurrio un error al eliminar la foto');
                    } else {
                        parent.$('#picContacto').attr('src', respuesta);
                    }
                });
            }
        });
        $("#btnSubmit").click(function() {
            $("#frmAddFoto").submit();
        });
        $("#btnCancel").click(function() {
            var contacto = $(this).data("contacto");

            var respuesta = confirm('Está seguro que desea cancelar?');
            if (respuesta) {
                window.location.href = '/contactos/' + contacto + '/info';
            } else {
                return false;
            }
        });
    });
</script>
</body>
</html>