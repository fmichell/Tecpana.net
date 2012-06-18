<?php
include '../../app/inicio.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Proyectos - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../includes/cabezera.php' ?>
</head>
<body>
    <?php
    // Cargamos la cabezera de la pagina
    include '../includes/encabezado.php';
    ?>

    <div class="mainWrapper">
    <!--MainWrapper begins-->
    <div id="MainWrapper">
        <?php
        // Cargamos el menu principal
        include '../includes/menu-principal.php';
        ?>
        
        <!--Content begins-->
        <section id="Content" class="wToolbar">
            <!--Workspace begins-->
            <section id="Workspace" class="colum">
                <!--Workspace Header begins-->
                <div class="workspaceHeader interior10">
                    <header>
                        <h1 class="floatLeft">Proyectos</h1>
                        <div class="mainBoton"><a href="/proyectos/agregar" class="botong botong_naranja">Crear un proyecto</a></div>
                        <div class="linea20"></div>
                        <div class="buscar"><input type="search" name="buscar_proyecto" id="buscar_proyecto" placeholder="Buscar proyecto" class="bigText" /></div>
                    </header>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div class="paginas">
                        <a href="#">&laquo; primera</a>
                        &hellip;
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        &hellip;
                        <a href="#">última &raquo;</a>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10 registerList">
                    <article>
                        <div class="proyect">
                            <div class="userThumb colum"><a href="#"><img src="/media/imgs/proyectThumb.jpg" alt="Proyecto" /></a></div>
                            <div class="desc colum">
                                <div class="titulo"><a href="/proyectos/123/perfil" class="nombre">Creación de la intranet tuplan.net</a> &mdash; Responsable: <a href="#">Federico Michell</a></div>
                                <div class="detalle">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam et sapien vitae leo varius dignissim. Nulla vel turpis in sem posuere feugiat. Sed eu elit ac nulla commodo fringilla. Integer convallis tempor posuere. Vivamus imperdiet nisi non nibh luctus sit amet venenatis felis sodales. Quisque nec malesuada nunc. Ut pretium eleifend tempor. Sed et ipsum quis diam viverra cursus. Nullam in ligula eget neque lobortis fringilla in quis orci.</p>
                                </div>
                            </div>
                            <div class="info colum">100%</div>
                            <div class="clear"><!--empty--></div>
                        </div>
                    </article>
                    <article class="last-child">
                        <div class="proyect">
                            <div class="userThumb colum"><a href="#"><img src="/media/imgs/proyectThumb.jpg" alt="Proyecto" /></a></div>
                            <div class="desc colum">
                                <div class="titulo"><a href="/proyectos/123/perfil" class="nombre">Creación de la intranet tuplan.net</a> &mdash; Responsable: <a href="#">Federico Michell</a></div>
                                <div class="detalle">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam et sapien vitae leo varius dignissim. Nulla vel turpis in sem posuere feugiat. Sed eu elit ac nulla commodo fringilla. Integer convallis tempor posuere. Vivamus imperdiet nisi non nibh luctus sit amet venenatis felis sodales. Quisque nec malesuada nunc. Ut pretium eleifend tempor. Sed et ipsum quis diam viverra cursus. Nullam in ligula eget neque lobortis fringilla in quis orci.</p>
                                </div>
                            </div>
                            <div class="info colum">100%</div>
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
    include '../includes/pie.php';
    ?>
</body>
</html>