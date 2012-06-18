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
    <title>Plan de trabajo - <?php echo SISTEMA_NOMBRE ?></title>
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
                            <li><a href="/proyectos/<?php echo $proyecto_id ?>/plan" class="activo">Plan de trabajo</a></li>
                            <li><a href="/proyectos/<?php echo $proyecto_id ?>/notas">Notas</a></li>
                        </ul>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10 registerList">
                    <fieldset class="plan_trabajo">
                        <legend>Nombre de la lista</legend>
                        <div class="titLista">Nombre de la lista
                            <a href="javascript:;" class="icono16 toggleLista toggleListaVisible floatRight" title="Ocultar lista"><!--ocultar lista--></a>
                        </div>
                        <div class="grupo_tareas">
                            <article class="wCheckbox">
                                <div class="task">
                                    <div class="check colum"><input type="checkbox" /></div>
                                    <div class="userThumb colum"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Federico Michell</div></div>
                                    <div class="desc colum">
                                        <p><span class="referencia"><a href="#">Creación de aplicación web tuplan.net</a> &gt; <a href="#">Formulario de login</a> &gt; </span><span class="titulo">Lorem ipsum dolor sit amet</span> &mdash; Consectetur adipiscing elit. Nullam et sapien vitae leo varius dignissim. Nulla vel turpis in sem posuere feugiat. Sed eu elit ac nulla commodo fringilla. Integer convallis tempor posuere. Vivamus imperdiet nisi non nibh luctus sit amet venenatis felis sodales. Quisque nec malesuada nunc. Ut pretium eleifend tempor. Sed et ipsum quis diam viverra cursus. Nullam in ligula eget neque lobortis fringilla in quis orci. Aenean nulla nulla, adipiscing vel commodo vitae, posuere rhoncus metus. Praesent et rutrum nisi.</p>
                                        <p>Ut et ipsum sed est elementum interdum. Vivamus elementum odio ac ipsum faucibus ornare ac semper nisi. Sed lorem urna, laoreet rutrum rhoncus elementum, rutrum at elit. Nam a lacus purus, sit amet faucibus ipsum.</p>
                                        <p>Donec eu urna nec mauris mattis pharetra ut non metus. Duis convallis ligula gravida ante ultricies sed condimentum risus euismod. In imperdiet, nibh in molestie rhoncus, mauris mi placerat quam, vel volutpat quam nisl nec nisl. Aliquam a euismod justo. Aliquam sodales faucibus gravida. In in viverra quam. Vestibulum commodo molestie tellus, eu aliquet tortor vulputate non. Suspendisse potenti. Nam urna felis, malesuada ac fermentum nec, egestas nec purus.</p>
                                    </div>
                                    <div class="clear"><!--empty--></div>
                                    <div class="info"><div class="icono16 floatLeft" style="margin-right:5px;"><img src="/media/imgs/green_calendar.png" alt="Calendario" /></div> Fecha de entrega: <span class="rojo negrita">Hace 2 dias</span> <div class="floatRight"><a href="#">Comentarios (33)</a> - <a href="tareas_detalle.html">Ver detalles</a></div></div>
                                </div>
                            </article>
                            <article class="wCheckbox last-child">
                                <div class="task">
                                    <div class="check colum"><input type="checkbox" /></div>
                                    <div class="userThumb colum"><a href="#"><img src="/media/imgs/famaleThumb.jpg" alt="Mujer" /></a><div class="tooltipNombre">Federico Michell</div></div>
                                    <div class="desc colum">
                                        <p><span class="titulo">Cras interdum commodo sodales</span> &mdash; Aliquam sapien tellus, faucibus condimentum ultricies non, semper eu ligula. Integer eu velit lectus. Duis ullamcorper dapibus urna, in cursus orci iaculis nec. Duis vel porttitor justo. Pellentesque ultricies pharetra odio, ac dictum arcu consectetur vel. Duis massa ipsum, viverra in fringilla quis, vehicula sed arcu. Maecenas nulla nulla, egestas ac scelerisque vel, tempor a tellus. Suspendisse potenti. In hac habitasse platea dictumst. Ut at neque dolor, ac euismod mauris.</p>
                                    </div>
                                    <div class="clear"><!--empty--></div>
                                    <div class="info"><div class="icono16 floatLeft" style="margin-right:5px;"><img src="/media/imgs/green_calendar.png" alt="Calendario" /></div> Fecha de entrega: <span class="negrita rojo">Hoy</span> <div class="floatRight"><a href="#">Sin comentarios</a> - <a href="#">Ver detalles</a></div></div>
                                </div>
                            </article>
                        </div>
                    </fieldset>
                    <fieldset class="plan_trabajo">
                        <legend>Nombre de la lista</legend>
                        <div class="titLista">Nombre de la lista
                            <a href="javascript:;" class="icono16 toggleLista toggleListaVisible floatRight" title="Ocultar lista"><!--ocultar lista--></a>
                        </div>
                        <div class="grupo_tareas">
                            <article class="wCheckbox">
                                <div class="task">
                                    <div class="check colum"><input type="checkbox" /></div>
                                    <div class="userThumb colum"><a href="#"><img src="/media/imgs/businessThumb.jpg" alt="Empresa" /></a><div class="tooltipNombre">Federico Michell</div></div>
                                    <div class="desc colum">
                                        <p><span class="titulo">Cras interdum commodo sodales aliquam</span> &mdash; Sapien tellus, faucibus condimentum ultricies non, semper eu ligula. Integer eu velit lectus. Duis ullamcorper dapibus urna, in cursus orci iaculis nec. Duis vel porttitor justo. Pellentesque ultricies pharetra odio, ac dictum arcu consectetur vel. Duis massa ipsum, viverra in fringilla quis, vehicula sed arcu. Maecenas nulla nulla, egestas ac scelerisque vel, tempor a tellus. Suspendisse potenti. In hac habitasse platea dictumst. Ut at neque dolor, ac euismod mauris. Nunc eu imperdiet massa. Ut justo erat, suscipit sed pulvinar sit amet, lobortis sed ipsum. Praesent vel enim elit. Integer accumsan hendrerit eros ut mattis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam id metus risus, tempus accumsan augue. Etiam et lacus eros.</p>
                                    </div>
                                    <div class="clear"><!--empty--></div>
                                    <div class="info"><div class="icono16 floatLeft" style="margin-right:5px;"><img src="/media/imgs/green_calendar.png" alt="Calendario" /></div> Fecha de entrega: <span class="negrita">Mañana</span> <div class="floatRight"><a href="#">Sin comentarios</a> - <a href="#">Ver detalles</a></div></div>
                                </div>
                            </article>
                            <article class="wCheckbox last-child">
                                <div class="task">
                                    <div class="check colum"><input type="checkbox" /></div>
                                    <div class="userThumb colum"><a href="#"><img src="/media/imgs/famaleThumb.jpg" alt="Mujer" /></a><div class="tooltipNombre">Federico Michell</div></div>
                                    <div class="desc colum">
                                        <p><span class="titulo">Cras interdum commodo sodales</span> &mdash; Aliquam sapien tellus, faucibus condimentum ultricies non, semper eu ligula. Integer eu velit lectus. Duis ullamcorper dapibus urna, in cursus orci iaculis nec. Duis vel porttitor justo. Pellentesque ultricies pharetra odio, ac dictum arcu consectetur vel. Duis massa ipsum, viverra in fringilla quis, vehicula sed arcu. Maecenas nulla nulla, egestas ac scelerisque vel, tempor a tellus. Suspendisse potenti. In hac habitasse platea dictumst. Ut at neque dolor, ac euismod mauris. Nunc eu imperdiet massa. Ut justo erat, suscipit sed pulvinar sit amet, lobortis sed ipsum. Praesent vel enim elit. Integer accumsan hendrerit eros ut mattis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam id metus risus, tempus accumsan augue. Etiam et lacus eros.</p>
                                    </div>
                                    <div class="clear"><!--empty--></div>
                                    <div class="info"><div class="icono16 floatLeft" style="margin-right:5px;"><img src="/media/imgs/green_calendar.png" alt="Calendario" /></div> Fecha de entrega: <span class="negrita">15 de octubre</span> <div class="floatRight"><a href="#">Sin comentarios</a> - <a href="#">Ver detalles</a></div></div>
                                </div>
                            </article>
                        </div>
                    </fieldset>
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
    $('.toggleLista').click(function() {
        var fieldset = $(this).closest('fieldset');
        if ( $(this).hasClass('toggleListaVisible') ) {
            $(this).removeClass('toggleListaVisible').addClass('toggleListaOculta');
        } else {
            $(this).removeClass('toggleListaOculta').addClass('toggleListaVisible');
        }
        $('.grupo_tareas', fieldset).toggle('fast');
        return false;
    });
});
</script>
</body>
</html>