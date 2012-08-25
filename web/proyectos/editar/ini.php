<?php
include '../../../app/inicio.php';

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $proyecto_id = $_GET['id'];
} else {
    header ('location /proyectos');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Proyecto - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/form.css" />
    <script type="text/javascript" src="/media/js/ckeditor/ckeditor.js"></script>
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
                <form method="post" action="" name="frmAgregarProyecto" id="frmAgregarProyecto" class="frmProyecto">
                    <!--Workspace Header begins-->
                    <div class="workspaceHeader interior10">
                        <input type="text" class="bigText ancho98di" placeholder="Nombre del proyecto" id="nombre" required /><br />
                        <dl class="horizontal">
                            <dt>Planificado para realizarse del:</dt>
                            <dd>
                                <input type="date" class="selectDate ancho90es" />&nbsp;&nbsp;al&nbsp;&nbsp;<input type="date" class="selectDate ancho90es" />&nbsp;&nbsp;(5d)
                            </dd>
                            <dt><label for="categoria">Categoría:</label></dt>
                            <dd><input type="text" name="categoria" id="categoria" class="ancho250es" /></dd>
                            <dt><label for="estado">Estado:</label></dt>
                            <dd>
                                <select name="estado" id="estado" class="ancho250es">
                                    <option value="1" selected="selected">Activo</option>
                                    <option value="2">En espera</option>
                                    <option value="3">Finalizado</option>
                                </select>
                            </dd>
                        </dl>
                        <div class="contactosInvolucrados">
                            <p>Contactos involucrados:</p>
                            <div class="linea5"></div>
                            <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Federico Michell</div></div>
                            <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Ruperto Mendiola</div></div>
                            <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Farah Prado</div></div>
                            <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Hermenegildo Rodriguez</div></div>
                            <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Francisco Meneses</div></div>
                            <div class="addInvolucrados floatLeft"><a href="contacto_involucrados.html" class="abrirInvolucrados" title="Involucrar a un contacto"><img src="/media/imgs/addInvolucrados.png" alt="Involucrar a contacto" /></a></div>
                        </div>
                        <div class="linea5"></div>
                    </div>
                    <!--Workspace Header ends-->
                    <!--Workspace Toolbar begins-->
                    <div class="workspaceToolbar"><!--TODO--></div>
                    <!--Workspace Toolbar ends-->
                    <!--Workspace Area begins-->
                    <div class="workspaceArea interior10">
                        <div class="linea10"></div>
                        <dl class="vertical">
                            <dt><label for="descripcion">Antecedentes, descripción o breve reseña:</label>
                            <div class="linea10"></div>
                            </dt>
                            <dd><textarea name="descripcion" id="descripcion" rows="100" cols="10" class="ancho98di"></textarea></dd>
                        </dl>
                        <div class="linea10"></div>
                        <a class="boton_gris floatLeft btnForm" href="#">Guardar cambios</a>
                        <a class="boton_gris floatLeft btnForm" href="#">Cancelar</a>
                        <div class="linea10"></div>
                    </div>
                    <!--Workspace Area ends-->
                </form>
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
    CKEDITOR.replace( 'descripcion', {toolbar : 'tbProyect'});
</script>
</body>
</html>