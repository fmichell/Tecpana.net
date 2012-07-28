<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: antes del 23-06-2012
 * @fechaModificacion: 28-07-2012
 * @version: 1.0
 * @descripcion: Página principal de contactos. Muestra el listado de contactos existentes.
 */
include '../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Etiqueta.php';

// Obtenemos etiqueta si la hay
$label = null;
if (isset($_GET['etiqueta'])) {
    if (!empty($_GET['etiqueta']))
        $label = Etiqueta::obtenerEtiquetaSeo(CUENTA_ID, $_GET['etiqueta']);
    else {
        header('location: /contactos');
        exit;
    }
}
// Obtenemos listado de etiquetas
$etiquetasOrdenadas = Etiqueta::obtenerPorLetras(CUENTA_ID);
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
                    <h1 class="floatLeft" id="tituloSeccion">
                        <?php
                        if ($label) {
                            echo "Contactos &raquo; " . $label['etiqueta'];
                        } else
                            echo "Contactos";
                        ?>
                    </h1>
                    <div class="mainBoton"><a href="/contactos/agregar" class="botong botong_azul abrirDialog">Agregar contacto</a></div>
                    <div class="linea20"></div>
                    <div class="buscar"><input type="search" name="buscar_contacto" id="buscar_contacto" placeholder="Buscar empresa o contacto" class="bigText" /></div>
                </header>
            </div>
            <!--Workspace Header ends-->
            <!--Workspace Toolbar begins-->
            <div class="workspaceToolbar">
                <?php if ($label) { ?>
                <div class="btnsFiltro">
                    <div class="back" id="back" title="Desactivar etiqueta">&laquo;</div>
                </div>
                <?php } ?>
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
                <div class="clear"><!--vacio--></div>
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
                <!-- Solo visible en pantallas menores de 1024 -->
                <div class="mainBoton"><a href="/contactos/agregar" class="botong botong_azul abrirDialog">Agregar contacto</a></div>
                <!-- Fin -->

                <div class="recuadro">
                    <h3>Herramientas</h3>
                    <ul>
                        <li><a href="#">Imprimir</a></li>
                        <li><a href="#">Exportar a excel</a></li>
                        <li><a href="#">Exportar a pdf</a></li>
                    </ul>
                </div>
                <div class="recuadro">
                    <h3>Ver</h3>
                    <ul>
                        <li><a href="javascript:;" id="listview">Lista</a></li>
                        <li><a href="javascript:;" id="iconview">Iconos</a></li>
                    </ul>
                </div>
                <?php if (!empty($etiquetasOrdenadas)) { ?>
                <div class="recuadro">
                    <h3>Etiquetas</h3>
                    <ul class="listLabels">
                        <?php foreach ($etiquetasOrdenadas as $letra => $etiquetas) { ?>
                        <li><span class="letter"><?php echo $letra ?></span>
                            <div class="labels">
                                <?php
                                $tmp = array();
                                foreach ($etiquetas as $etiqueta) {
                                    $tmp[] = sprintf('<a href="/contactos/etiqueta/%s">%s</a>', $etiqueta['etiqueta_seo'], $etiqueta['etiqueta']);
                                }

                                echo implode(', ', $tmp);
                                ?>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
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
var vista = 'lista';
var etiqueta = '<?php echo ($label) ? $label['etiqueta_id'] : $label ?>';

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
function cargarContactos(filtroNombre, filtroTipo, filtroPagina, filtroEtiqueta) {
    $('#contactos').fadeTo('fast', 0.10, function() {
        if (vista == 'iconos') {
            $(this).addClass('contactosIcons');
        } else {
            $(this).removeClass('contactosIcons');
        }
        $(this).load('/contactos/ajax/ajaxListarContactos.php', {'nombre':filtroNombre, 'tipo':filtroTipo, 'pagina':filtroPagina, 'etiqueta':filtroEtiqueta, 'vista':vista}, function(respuesta, estado) {
            if (estado == 'success') {
                //Ocultando seleccion
                actualizarSeleccion('off');
                if (vista == 'iconos') {
                    calcularAnchoIconosContactos();
                }
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
function paginar(paso) {
    if (paso == 0) {
        pagina = 1;
    } else {
        pagina += paso;
    }
    cargarContactos('', tipo, pagina, etiqueta);
}
function buscarNombre() {
    tipo = 'todos'; pagina = 1;
    var nombre = $('#buscar_contacto').val();
    if (nombre != '') {
        cargarContactos(nombre, null, pagina, etiqueta);
    } else {
        cargarContactos('', tipo, pagina, etiqueta);
    }
    $('#filtrar > div').removeClass('selected');
    $('#todos').addClass('selected');
}
function calcularAnchoIconosContactos() {
    var anchoArea = $('.workspaceArea').width();
    var anchoIcon = 150;
    var extra = 27; // padding + borde + margen
    var iconos = Math.floor(anchoArea / (anchoIcon + extra));
    var anchoIcon = Math.floor((anchoArea / iconos) - extra);

    $('.contacto').css({'width':anchoIcon+'px'});
}
$(document).on("ready", function() {
    cargarContactos('', 'todos', 1, etiqueta);

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
        if (vacio(etiqueta)) {
            if (tipo == 'personas') {
                $("#tituloSeccion").html("Contactos &raquo; Personas");
            } else if (tipo == 'empresas') {
                $("#tituloSeccion").html("Contactos &raquo; Empresas");
            } else if (tipo == 'grupos') {
                $("#tituloSeccion").html("Contactos &raquo; Grupos");
            } else {
                $("#tituloSeccion").text("Contactos");
            }
        }
        cargarContactos('', tipo, pagina, etiqueta);
        $('#buscar_contacto').val('');
        $('#filtrar > div').removeClass('selected');
        $(this).addClass('selected');
    });
    $('#back').click(function() {
        window.location.href = '/contactos';
        return false;
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

    $('.eliminar').click(function() {
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

    $('#listview').click(function() {
        vista = 'lista';
        cargarContactos('', tipo, pagina, etiqueta);
    });
    $('#iconview').click(function() {
        vista = 'iconos';
        cargarContactos('', tipo, pagina, etiqueta);
    });
});
</script>
</body>
</html>