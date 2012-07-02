<?php
include '../../app/inicio.php';

// Obtenemos todos los contactos
$contactos = Contacto::obtenerTodos(CUENTA_ID);
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
                    <div id="filtrar" class="btnsFiltro">
                        <div class="first selected" id="todos">Todos</div>
                        <div id="personas">Personas</div>
                        <div id="empresas">Empresas</div>
                        <div id="grupos" class="last">Grupos</div>
                    </div>
                    <div class="paginas">
                        <a href="javascript:;" id="firstPage">Primera página</a>
                        <a href="javascript:;" id="prevPage">Página anterior</a>
                        <a href="javascript:;" id="nextPage">Página siguiente</a>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10 registerList">
                    <div class="auxiliaryToolbar">
                        <a href="javascript:;" class="eliminar">Eliminar el contacto seleccionado</a>
                        <div class="seleccion">
                            <a href="javascript:;" class="select_all">Seleccionar todos</a> | <a href="javascript:;" class="undo_select">Deshacer selección</a> 
                        </div>
                    </div>
                    <div id="contactos">
                        <!--Lista de contactos-->
                    </div>
                    <div class="auxiliaryToolbar">
                        <a href="javascript:;" class="eliminar">Eliminar el contacto seleccionado</a>
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
var intervalo;
var tipo = 'todos';
var pagina = 1;
var nombreBuscado = '';

function actualizarSeleccion(fade) {
    if (fade == 'off') {
        fade = false;
    } else {
        fade = true;
    }
    var seleccionados = $(".check_contacto:checked").length;
    if (seleccionados >= 1) {
        if (seleccionados == 1) {
            $('.auxiliaryToolbar > .eliminar').text('Eliminar el contacto seleccionado');
        } else {
            $('.auxiliaryToolbar > .eliminar').text('Eliminar los ' + seleccionados + ' contactos seleccionados');
        }
        if (fade) {
            $('.auxiliaryToolbar').fadeIn();
        } else {
            $('.auxiliaryToolbar').show();
        }
    } else {
        if (fade) {
            $('.auxiliaryToolbar').fadeOut();
        } else {
            $('.auxiliaryToolbar').hide();
        }
    }
}
function cargarContactos(filtroNombre, filtroTipo, filtroPagina) {
    $('#contactos').fadeTo('fast', 0.10, function() {
        $('#contactos').load('/contactos/ajax/ajaxListarContactos.php', {'nombre':filtroNombre, 'tipo':filtroTipo, 'pagina':filtroPagina}, function(respuesta, estado) {
            if (estado == 'success') {
                //Ocultando seleccion
                actualizarSeleccion('off');
                //Mostrando resultados
                $('#contactos').fadeTo("fast", 1);
                //Calculando altura
                var alto = $('#contactos').height()+185;
                $("#Toolbar").css({"height": alto+'px'});
                //Paginando
                if ($('.ultimaPagina').length) {
                    var ultima = true;
                } else {
                    var ultima = false;
                }
                if (filtroPagina == 1) {
                    if (ultima) {
                        $('#firstPage, #prevPage, #nextPage').hide();
                    } else {
                        $('#firstPage, #prevPage').hide();
                        $('#nextPage').show();
                    }
                } else if (filtroPagina == 2) {
                    $('#firstPage').hide();
                    if (ultima) {
                        $('#nextPage').hide();
                        $('#prevPage').show();
                    } else {
                        $('#prevPage, #nextPage').show();
                    }
                } else if (ultima) {
                    $('#nextPage').hide();
                    $('#firstPage, #prevPage').show();
                } else {
                    $('#firstPage, #prevPage, #nextPage').show();
                }
            } else {
                alert('Ocurrió un error al cargar el listado')
            }
        });
    });
}
function paginar(paso)
{
    if (paso == 0) {
        pagina = 1;
    } else {
        pagina += paso;
    }
    cargarContactos('', tipo, pagina);
}
function buscarNombre() {
    tipo = 'todos'; pagina = 1;
    var nombre = $('#buscar_contacto').val();
    if (nombre != '') {
        cargarContactos(nombre, null, pagina);
    } else {
        cargarContactos('', tipo, pagina);
    }
    $('#filtrar > div').removeClass('selected');
    $('#todos').addClass('selected');
}
$(document).on("ready", function() {
    cargarContactos('', 'todos', 1);

    $('.check_contacto').live('click', function() {
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

    $('#filtrar > div').click(function() {
        tipo = $(this).attr('id');
        pagina = 1;
        cargarContactos('', tipo, pagina);
        $('#buscar_contacto').val('');
        $('#filtrar > div').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#firstPage').click(function() {
        paginar(0);
    });
    $('#prevPage').click(function() {
        paginar(-1);
    });
    $('#nextPage').click(function() {
        paginar(1);
    });

    $('#buscar_contacto').keyup(function(evento) {
        var nombre = $(this).val();
        if (nombreBuscado != nombre) {
            nombreBuscado = nombre;
            clearTimeout(intervalo);
            intervalo = setTimeout('buscarNombre()', 600);
        } else if (evento.which = 13) {
            clearTimeout(intervalo);
            buscarNombre();
        }

    });

    $('.eliminar').click(function () {
        var seleccionados = $(".check_contacto:checked").length;
        if (seleccionados == 1) {
            var mensaje = 'Está seguro que desea eliminar permanentemente el contacto seleccionado?';
        } else {
            var mensaje = 'Está seguro que desea eliminar permanentemente los ' + seleccionados + ' contacto seleccionado?';
        }

        if (confirm(mensaje)) {
            console.log('si');
        }
    });
});
</script>
</body>
</html>