<?php
include '../../../app/inicio.php';

$ventana = true;

if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'cargar')) {
    if ($_FILES['foto']['name']) {
        $mediaInput = array(
            'name' => $_FILES['foto']['name'],
            'type' => $_FILES['foto']['type'],
            'size' => $_FILES['foto']['size'],
            'tmp_name' => $_FILES['foto']['tmp_name']
        );

        $tmpFoto = Contacto::subirFotoPerfil($mediaInput, 'tmp'.time());
        $uriTmpFoto = '/media/profile/tmp/' . $tmpFoto['nombre'];
        //util_depurar_var($tmpFoto);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Agregar Foto - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/form.css" />
    <script type="text/javascript" src="/media/js/jcrop/js/jquery.Jcrop.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/media/js/jcrop/css/jquery.Jcrop.css" />
    <style>
        html, body {
            height: 100%;
            position: relative;
        }
    </style>
</head>
<body class="formIframe">
<!--MainWrapper begins-->
<div id="MainWrapperIframe">
    <!--Content begins-->
    <section id="Content">
        <!--Workspace begins-->
        <section id="Workspace" class="formulario">
            <form method="post" action="" name="frmAddFoto" id="frmAddFoto" class="frmContacto" enctype="multipart/form-data">
                <input type="hidden" name="submitForm" value="cargar" />
                <dl class="horizontal">
                    <dt><label for="foto">Seleccionar foto</label></dt>
                    <dd><input type="file" name="foto" id="foto"></dd>
                </dl>
                
                <?php if (isset($uriTmpFoto) and !empty($uriTmpFoto)) { ?>
                <div class="linea"><img src="<?php echo $uriTmpFoto ?>" id="cropbox"></div>
                <input type="hidden" name="uriPerfil" value="<?php echo $tmpFoto['uri'] ?>">
                <?php } ?>

                <!-- Cordenas -->
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />

                <div class="linea10"></div>
                <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnSubmit">Cargar imagen</a>
                <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnCancelar">Cancelar</a>
                <div class="linea30 clear"></div>
            </form>
        </section>
        <!--Workspace ends-->
    </section>
    <!--Content begins-->
</div>
<div class="clear"></div>
<!--MainWrapper ends-->
<script type="text/javascript">
    function calcularAlturaIframe() {
        var altura = $('#MainWrapperIframe').height();
        if (altura != 0) {
            parent.$('iframe').css('height', altura+'px');
        }
    };
    $(document).ready(function() {
        calcularAlturaIframe();

        $("#btnSubmit").click(function() {
            $("#frmAddFoto").submit();
        });
        $('#btnCancelar').click(function() {
            $('input').val('');
            parent.$('#contactPict').hide();
            parent.$('#contactInfo').fadeIn();
        });
    });
</script>
</body>
</html>