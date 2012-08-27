<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: alrededor del 23-06-2012
 * @fechaModificacion: 28-07-2012
 * @version: 1.0
 * @descripcion: Cuadro de dialogo para seleccionar el tipo de contacto que se desea crear [Persona | Empresa]
 */
include '../../../app/inicio.php';

// Declaramos ventana
$ventana = true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Agregar contacto - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
</head>
<body class="dialog">
<!--Header begins-->
<header id="HeaderVentanaGeneral">
    <h1>Agregar contacto <button class="fuiBotonCerrar" id="cerrar">Cerrar</button></h1>
</header>
<!--Header ends-->

<div class="interior5">
<!--MainWrapper begins-->
<div id="MainWrapperVentana">
    <!--Content begins-->
    <section id="Content">
        <!--Workspace begins-->
        <section id="Workspace">
            <p><span style="float: left; margin-right: .3em;" class="icono_info"></span>Por favor seleccione el tipo de contacto que desea agregar.</p>
            <div class="linea10 separador"></div>
            <div class="linea10"></div>
            <div class="floatRight">
                <button class="fuiBoton" id="irPersona">Persona</button>
                <button class="fuiBoton" id="irEmpresa">Empresa</button>
            </div>
        </section>
        <!--Workspace ends-->
    </section>
    <!--Content ends-->
</div>
<!--MainWrapper ends-->
</div>
<script type="text/javascript">
$(document).on("ready", function() {
    $('#irPersona').click(function() {
        parent.location.href = '/contactos/agregar-persona';
    });
    $('#irEmpresa').click(function() {
        parent.location.href = '/contactos/agregar-empresa';
    });
    $('#cerrar').click(function() {
        parent.$.fancybox.close();
    });
});
</script>
</body>
</html>