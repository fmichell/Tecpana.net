<?php
include '../../app/inicio.php';

// Obtenemos todos los contactos
$contactos = Contacto::obtenerTodos(CUENTA_ID);
//util_depurar_var($contactos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Contactos - <?php echo SISTEMA_NOMBRE ?></title>
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
                        <h1 class="floatLeft">Contactos</h1>
                        <div class="mainBoton"><a href="/contactos/agregar" class="botong botong_azul abrirDialog">Agregar contacto</a></div>
                        <div class="linea20"></div>
                        <div class="buscar"><input type="search" name="buscar_contacto" id="buscar_contacto" placeholder="Buscar empresa o contacto" class="bigText" /></div>
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
                    <div class="auxiliaryToolbar">
                        <a href="#" class="eliminar">Eliminar el contacto seleccionado</a>
                        <div class="seleccion">
                            <a href="javascript:;" class="select_all">Seleccionar todos</a> | <a href="javascript:;" class="undo_select">Deshacer selección</a> 
                        </div>
                    </div>
                    <?php include 'ajax/ajaxListarContactos.php'; ?>
                    <div class="auxiliaryToolbar">
                        <a href="#" class="eliminar">Eliminar el contacto seleccionado</a>
                        <div class="seleccion">
                            <a href="javascript:;" class="select_all">Seleccionar todos</a> | <a href="javascript:;" class="undo_select">Deshacer selección</a> 
                        </div>
                    </div>
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
                    <div class="recuadro">
                        <h3>Etiquetas</h3>
                        <ul class="listLabels">
                            <li><span class="letter">A</span>
                                <div class="labels"><a href="#">Animales</a>, <a href="#">Amor</a>, <a href="#">Anfetaminas</a>, <a href="#">Arena</a>, <a href="#">Agua</a></div>
                            </li>
                            <li><span class="letter">E</span>
                                <div class="labels"><a href="#">Entregas</a>, <a href="#">Elechos</a>, <a href="#">Estado</a>, <a href="#">Estereos</a>, <a href="#">Esquina</a></div>
                            </li>
                            <li><span class="letter">P</span>
                                <div class="labels"><a href="#">Putas</a>, <a href="#">Playos</a>, <a href="#">Proxenetas</a>, <a href="#">Pedales</a>, <a href="#">Pantuflas</a>, <a href="#">Pavos</a>, <a href="#">Paquetería</a></div>
                            </li>
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
<script type="text/javascript">
function actualizarSeleccion() {
    var seleccionados = $(".check_contacto:checked").length;
    if (seleccionados >= 1) {
        if (seleccionados == 1) {
            $('.auxiliaryToolbar > .eliminar').text('Eliminar el contacto seleccionado');
        } else {
            $('.auxiliaryToolbar > .eliminar').text('Eliminar los ' + seleccionados + ' contactos seleccionados');
        }
        $('.auxiliaryToolbar').fadeIn();
    } else {
        $('.auxiliaryToolbar').fadeOut();
    }
}
$(document).on("ready", function() {
    $('.check_contacto').click(function() {
        actualizarSeleccion();
    });
    
    $('.select_all').click(function() {
        $('.check_contacto').attr('checked', true);
        actualizarSeleccion();
    });
    
    $('.undo_select').click(function() {
        $('.check_contacto').attr('checked', false);
        actualizarSeleccion();
    });
});
</script>
</body>
</html>