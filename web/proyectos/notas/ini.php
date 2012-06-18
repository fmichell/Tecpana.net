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
    <title>Notas del proyecto - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
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
        <section id="Content" class="wToolbar">
            <!--Workspace begins-->
            <section id="Workspace" class="colum">
                <!--Workspace Header begins-->
                <div class="workspaceHeader interior10">
                    <header>
                        <div class="floatLeft">
                            <h1>Proyecto &raquo; Construcción de tuplan.net CRM</h1>
                            <div class="linea10"></div>
                            <h2 class="subtitulo">Creado el 15 de mayo del 2011 por <a href="#">Federico Michell Vijil</a></h2>
                        </div>
                        <div class="mainBoton"><a href="/proyectos/<?php echo $proyecto_id ?>/editar" class="botong botong_naranja">Editar proyecto</a></div>
                        <div class="linea20"></div>
                    </header>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div class="opciones">
                        <ul>
                            <li><a href="/proyectos/<?php echo $proyecto_id ?>/perfil">Perfil del proyecto</a></li>
                            <li><a href="/proyectos/<?php echo $proyecto_id ?>/plan">Plan de trabajo</a></li>
                            <li><a href="/proyectos/<?php echo $proyecto_id ?>/notas" class="activo">Notas</a></li>
                        </ul>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10 registerList">
                    <div class="linea10"></div>
                    <div class="comentForm formulario">
                        <div class="comentArea"><textarea name="coment" id="coment" class="comentTextArea" rows="10" cols="30" placeholder="Agregar una nota o comentario"></textarea></div>
                        <div class="linea10"></div>
                        <div class="floatLeft" style="width:60%">
                            <a href="javascript:;" class="fondoAzul" id="addArchivo">Agregar un archivo al comentario</a>
                            <div id="inputArchivos" style="display:none;">
                                <div class="elemento ejemplo"><input type="file" name="archivos[]" size="40" /></div>
                                <div class="listado"></div>
                                <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                            </div>
                        </div>
                        <div class="floatRight" style="width:30%;">
                            <a href="#" class="boton_gris floatRight">Agregar comentario</a>
                        </div>
                    </div>
                    <div class="linea10 separador"></div>
                    <article>
                        <div class="coment">
                            <div class="userThumb colum"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a></div>
                            <div class="desc colum">
                                <div class="remitente"><a href="#" class="nombre">Federico Michell Vijil</a> &mdash; 15 Ene, 2011 - 12:50 pm</div>
                                <div class="detalle">
                                    <p>Consectetur adipiscing elit. Nullam et sapien vitae leo varius dignissim. Nulla vel turpis in sem posuere feugiat. Sed eu elit ac nulla commodo fringilla. Integer convallis tempor posuere. Vivamus imperdiet nisi non nibh luctus sit amet venenatis felis sodales. Quisque nec malesuada nunc. Ut pretium eleifend tempor. Sed et ipsum quis diam viverra cursus. Nullam in ligula eget neque lobortis fringilla in quis orci. Aenean nulla nulla, adipiscing vel commodo vitae, posuere rhoncus metus. Praesent et rutrum nisi.</p>
                                    <p>Ut et ipsum sed est elementum interdum. Vivamus elementum odio ac ipsum faucibus ornare ac semper nisi. Sed lorem urna, laoreet rutrum rhoncus elementum, rutrum at elit. Nam a lacus purus, sit amet faucibus ipsum.</p>
                                    <p>Donec eu urna nec mauris mattis pharetra ut non metus. Duis convallis ligula gravida ante ultricies sed condimentum risus euismod. In imperdiet, nibh in molestie rhoncus, mauris mi placerat quam, vel volutpat quam nisl nec nisl. Aliquam a euismod justo. Aliquam sodales faucibus gravida. In in viverra quam. Vestibulum commodo molestie tellus, eu aliquet tortor vulputate non. Suspendisse potenti. Nam urna felis, malesuada ac fermentum nec, egestas nec purus.</p>
                                </div>
                            </div>
                            <div class="clear"><!--empty--></div>
                        </div>
                    </article>
                    <article>
                        <div class="coment">
                            <div class="userThumb colum"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a></div>
                            <div class="desc colum">
                                <div class="remitente"><a href="#" class="nombre">Federico Michell Vijil</a> &mdash; 15 Ene, 2011 - 12:50 pm</div>
                                <div class="detalle">
                                    <p>Consectetur adipiscing elit. Nullam et sapien vitae leo varius dignissim. Nulla vel turpis in sem posuere feugiat. Sed eu elit ac nulla commodo fringilla. Integer convallis tempor posuere. Vivamus imperdiet nisi non nibh luctus sit amet venenatis felis sodales. Quisque nec malesuada nunc. Ut pretium eleifend tempor. Sed et ipsum quis diam viverra cursus. Nullam in ligula eget neque lobortis fringilla in quis orci. Aenean nulla nulla, adipiscing vel commodo vitae, posuere rhoncus metus. Praesent et rutrum nisi.</p>
                                    <p>Ut et ipsum sed est elementum interdum. Vivamus elementum odio ac ipsum faucibus ornare ac semper nisi. Sed lorem urna, laoreet rutrum rhoncus elementum, rutrum at elit. Nam a lacus purus, sit amet faucibus ipsum.</p>
                                    <p>Donec eu urna nec mauris mattis pharetra ut non metus. Duis convallis ligula gravida ante ultricies sed condimentum risus euismod. In imperdiet, nibh in molestie rhoncus, mauris mi placerat quam, vel volutpat quam nisl nec nisl. Aliquam a euismod justo. Aliquam sodales faucibus gravida. In in viverra quam. Vestibulum commodo molestie tellus, eu aliquet tortor vulputate non. Suspendisse potenti. Nam urna felis, malesuada ac fermentum nec, egestas nec purus.</p>
                                </div>
                            </div>
                            <div class="clear"><!--empty--></div>
                        </div>
                    </article>
                    <article class="last-child">
                        <div class="coment">
                            <div class="userThumb colum"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a></div>
                            <div class="desc colum">
                                <div class="remitente"><a href="#" class="nombre">Federico Michell Vijil</a> &mdash; 15 Ene, 2011 - 12:50 pm</div>
                                <div class="detalle">
                                    <p>Consectetur adipiscing elit. Nullam et sapien vitae leo varius dignissim. Nulla vel turpis in sem posuere feugiat. Sed eu elit ac nulla commodo fringilla. Integer convallis tempor posuere. Vivamus imperdiet nisi non nibh luctus sit amet venenatis felis sodales. Quisque nec malesuada nunc. Ut pretium eleifend tempor. Sed et ipsum quis diam viverra cursus. Nullam in ligula eget neque lobortis fringilla in quis orci. Aenean nulla nulla, adipiscing vel commodo vitae, posuere rhoncus metus. Praesent et rutrum nisi.</p>
                                    <p>Ut et ipsum sed est elementum interdum. Vivamus elementum odio ac ipsum faucibus ornare ac semper nisi. Sed lorem urna, laoreet rutrum rhoncus elementum, rutrum at elit. Nam a lacus purus, sit amet faucibus ipsum.</p>
                                    <p>Donec eu urna nec mauris mattis pharetra ut non metus. Duis convallis ligula gravida ante ultricies sed condimentum risus euismod. In imperdiet, nibh in molestie rhoncus, mauris mi placerat quam, vel volutpat quam nisl nec nisl. Aliquam a euismod justo. Aliquam sodales faucibus gravida. In in viverra quam. Vestibulum commodo molestie tellus, eu aliquet tortor vulputate non. Suspendisse potenti. Nam urna felis, malesuada ac fermentum nec, egestas nec purus.</p>
                                </div>
                            </div>
                            <div class="clear"><!--empty--></div>
                        </div>
                    </article>
                </div>
                <!--Workspace Area ends-->
            </section>
            <!--Workspace ends-->
            <!--Toolbar begins-->
            <section id="Toolbar" class="colum">
                <div class="interior10">
                    <div class="recuadro">
                        <h3>Herramientas</h3>
                        <ul>
                            <li><a href="#">Imprimir</a></li>
                            <li><a href="#">Exportar a excel</a></li>
                            <li><a href="#">Exportar a pdf</a></li>
                        </ul>
                    </div>
                </div>
            </section>
            <!--Toolbar ends-->
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
$(document).ready(function() {
    $('#addArchivo').click(function() {
        $(this).hide();
        $('#inputArchivos').show();
        $('.nuevo a').trigger('click');
    });
    
    $('.nuevo a').click(function() {
        var inputArchivos = $('#inputArchivos');
        var ejemplo = $('.ejemplo', inputArchivos);
        var listado = $('.listado', inputArchivos);
        
        var registro = $(ejemplo).clone(true).appendTo(listado).removeClass("ejemplo").fadeIn();
    });
});
</script>      
</body>
</html>