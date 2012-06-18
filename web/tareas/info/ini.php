<?php
include '../../../app/inicio.php';

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $tarea_id = $_GET['id'];
} else {
    header ('location /tareas');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de tarea - <?php echo SISTEMA_NOMBRE ?></title>
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
                            <h1>Tarea &raquo; Lorem ipsum dolor sit amet</h1>
                            <div class="linea10"></div>
                            <h2 class="subtitulo">Creado el 15 de mayo del 2011 por <a href="#">Federico Michell Vijil</a></h2>
                        </div>
                        <div class="mainBoton"><a href="/tareas/<?php echo $tarea_id ?>/editar" class="botong botong_verde">Editar tarea</a></div>
                        <div class="linea20"></div>
                    </header>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div class="opciones">
                        <ul>
                            <li><a href="/tareas/<?php echo $tarea_id ?>/info" class="activo">Detalles de la tarea</a></li>
                            <li><a href="/tareas/<?php echo $tarea_id ?>/comentarios">Comentarios</a></li>
                        </ul>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10 proyectInfo">
                    <div class="linea10"></div>
                    <div class="caracteristicas">
                        <p><strong>Asignada el 15 de Mayo por</strong> <a href="#">Federico Michell Vijil</a></p>
                        <div class="linea5"></div>
                        <p><strong>Planificada para realizarse del:</strong> 15 Ene 2011 al 31 Jun 2011 (3 meses)</p>
                        <div class="linea5"></div>
                        <p><strong>Estado:</strong> Completada</p>
                        <div class="linea5"></div>
                        <p><strong>Priodidad:</strong> Alta</p>
                        <div class="linea5"></div>
                        <p><strong>% Avance:</strong> 85%</p>
                    </div>
                        
                    <div class="linea20 separador"></div>
                    <div class="linea20"></div>
                        
                    <div class="contactosInvolucrados">
                        <p><strong>Contactos involucrados:</strong></p>
                        <div class="linea5"></div>
                        <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Federico Michell</div></div>
                        <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Ruperto Mendiola</div></div>
                        <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Farah Prado</div></div>
                        <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Hermenegildo Rodriguez</div></div>
                        <div class="userThumb"><a href="#"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a><div class="tooltipNombre">Francisco Meneses</div></div>
                        <div class="addInvolucrados floatLeft"><a href="contacto_involucrados.html" class="abrirInvolucrados" title="Involucrar a un contacto"><img src="/media/imgs/addInvolucrados.png" alt="Involucrar a contacto" /></a></div>
                    </div>
                        
                    <div class="linea10 separador"></div>
                    <div class="linea20"></div>

                    <article class="descripcion">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet mollis cursus. <strong>Integer justo ante, molestie ut malesuada vitae, adipiscing ut eros</strong>. Nunc id nulla non mi sollicitudin volutpat sagittis quis nisi. Sed auctor, nunc vel interdum consequat, orci neque volutpat diam, quis feugiat tortor nunc in neque. Nam mollis, tellus vitae bibendum congue, orci risus lobortis dolor, eget faucibus tellus ipsum non arcu. Pellentesque faucibus arcu erat. Fusce risus nulla, viverra a tempor vel, condimentum id tellus. In eleifend purus in lorem tempus euismod. Phasellus id risus non mi aliquet euismod semper eu nunc. Aliquam ac mi sed nulla blandit tempus. Ut fermentum, turpis ultrices molestie condimentum, nibh orci luctus mi, id tincidunt eros magna vitae erat. Aenean lacinia sem elit. Nam odio lacus, sagittis ac sollicitudin sit amet, venenatis vel orci. Sed bibendum nibh non diam posuere tempus. Sed eget dui sed dolor pretium congue at suscipit dolor. Integer aliquam commodo lacinia. Morbi eleifend congue nibh, nec luctus erat pharetra aliquet. <a href="#">Duis sed purus ante</a>, et semper dolor. Aliquam ipsum mauris, <em>iaculis et semper vitae</em>, semper vitae ipsum.</p>
                        
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet mollis cursus. Integer justo ante, molestie ut malesuada vitae, adipiscing ut eros. Nunc id nulla non mi sollicitudin volutpat sagittis quis nisi. Sed auctor, nunc vel interdum consequat, orci neque volutpat diam, quis feugiat tortor nunc in neque. Nam mollis, tellus vitae bibendum congue, orci risus lobortis dolor, eget faucibus tellus ipsum non arcu. Pellentesque faucibus arcu erat. Fusce risus nulla, viverra a tempor vel, condimentum id tellus. In eleifend purus in lorem tempus euismod. Phasellus id risus non mi aliquet euismod semper eu nunc. Aliquam ac mi sed nulla blandit tempus. Ut fermentum, turpis ultrices molestie condimentum, nibh orci luctus mi, id tincidunt eros magna vitae erat. Aenean lacinia sem elit. Nam odio lacus, sagittis ac sollicitudin sit amet, venenatis vel orci. Sed bibendum nibh non diam posuere tempus. Sed eget dui sed dolor pretium congue at suscipit dolor. Integer aliquam commodo lacinia. Morbi eleifend congue nibh, nec luctus erat pharetra aliquet. Duis sed purus ante, et semper dolor. Aliquam ipsum mauris, iaculis et semper vitae, semper vitae ipsum.</p>
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
</body>
</html>