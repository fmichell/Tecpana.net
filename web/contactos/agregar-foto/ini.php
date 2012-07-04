<?php
include '../../../app/inicio.php';

$ventana = true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Agregar Foto - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/form.css" />
</head>
<body class="formIframe">
<!--MainWrapper begins-->
<div id="MainWrapperIframe">
    <!--Content begins-->
    <section id="Content">
        <!--Workspace begins-->
        <section id="Workspace" class="formulario">
            <form method="post" action="" name="frmAddFoto" id="frmAddFoto" class="frmContacto" enctype="multipart/form-data">
                <dl class="horizontal">
                    <dt><label for="foto">Seleccionar foto</label></dt>
                    <dd><input type="file" name="foto" id="foto"></dd>
                </dl>
                <div class="linea10"></div>
                <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnSubmit">Cargar imagen</a>
                <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnCancelar">Cancelar</a>
                <div class="linea10"></div>
            </form>
        </section>
        <!--Workspace ends-->
    </section>
    <!--Content begins-->
</div>
<!--MainWrapper ends-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#btnCancelar').click(function() {
            $('input').val('');
            parent.$('#contactPict').hide();
            parent.$('#contactInfo').fadeIn();
        });
    });
</script>
</body>
</html>