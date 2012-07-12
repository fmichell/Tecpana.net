<?php
include '../../../app/inicio.php';

$ventana = true;
$contacto_id = $_GET['id'];

if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'cargar')) {
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
                <input type="hidden" name="uriPerfil" id="uriPerfil" value="<?php echo $tmpFoto['uri'] ?>">
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

        $('#cropbox').Jcrop({
            aspectRatio: 1,
            onSelect: updateCoords,
            minSize: [128, 128],
            maxSize: [500, 500],
            setSelect: [ 10, 10, 128, 128 ]
        });
    });
</script>
</body>
</html>