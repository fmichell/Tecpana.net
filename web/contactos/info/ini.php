<?php
include '../../../app/inicio.php';

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $contacto_id = $_GET['id'];
} else {
    header ('location: /contactos');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de contacto - <?php echo SISTEMA_NOMBRE ?></title>
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
                        <div class="userPic"><img src="/media/imgs/maleContact.jpg" alt="Hombre" /></div>
                        <div class="floatLeft">
                            <h1>Federico Michell Vijil</h1>
                            <div class="linea5"></div>
                            <h2 class="subtitulo">Gerente General de <a href="#">tuplan.net</a></h2>
                        </div>
                        <div class="mainBoton"><a href="/contactos/<?php echo $contacto_id ?>/editar-persona" class="botong botong_azul">Editar contacto</a></div>
                        <div class="linea5"></div>
                    </header>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div class="opciones">
                        <ul>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/info" class="activo">Información del contacto</a></li>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/tareas">Tareas Pendientes</a></li>
                            <li><a href="/contactos/<?php echo $contacto_id ?>/comentarios">Comentarios</a></li>
                        </ul>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10 contactInfo">
                    <div class="linea10"></div>
                    <dl class="horizontal">
                        <dt>Teléfono(s):</dt>
                        <dd>
                            <div class="elemento">+ (505) 2265 7879 <span class="nota">Casa</span></div>
                            <div class="elemento">+ (505) 8873 3432 <span class="nota">Movil</span></div>
                        </dd>
                        <dt>Email(s):</dt>
                        <dd>
                            <div class="elemento"><a href="mailto:federicomichell@gmail.com">federicomichell@gmail.com</a> <span class="nota">Casa</span></div>
                            <div class="elemento"><a href="mailto:federico.michell@gmail.com">federico.michell@plazavip.com</a> <span class="nota">Trabajo</span></div>
                        </dd>
                        <dt>Mensajeria:</dt>
                        <dd>
                            <div class="elemento"><a href="#">federico.michell</a> en Skype <span class="nota">Personal</span></div>
                            <div class="elemento"><a href="#">federico_michell@hotmail.com</a> en MSN <span class="nota">Personal</span></div>
                        </dd>
                        <dt>Sitio(s) web:</dt>
                        <dd>
                            <div class="elemento"><a href="http://federicomichell.com" target="_blank">http://federicomichell.com</a> <span class="nota">Trabajo</span></div>
                            <div class="elemento"><a href="http://federicomichell.info" target="_blank">http://federicomichell.info</a> <span class="nota">Personal</span></div>
                        </dd>
                        <dt>Dirección(es):</dt>
                        <dd class="direccion">
                            <div class="elemento">
                                <span class="nota">Casa</span>
                                Km 15.5 Carretera Sur. Quinta Marianita.<br />Managua, Nicaragua
                            </div>
                            <div class="elemento">
                                <span class="nota">Trabajo</span>
                                BDF Metrocentro 1/2 cuadra abajo<br />Managua, Nicaragua
                            </div>
                        </dd>
                    </dl>
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