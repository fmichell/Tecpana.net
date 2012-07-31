<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 29-07-2012
 * @fechaModificacion: 29-07-2012
 * @version: 1.0
 * @descripcion: Página de inicio de la sección de usuarios
 */
include '../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Etiqueta.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuarios - <?php echo SISTEMA_NOMBRE ?></title>
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
        <section id="Content">
            <!--Workspace begins-->
            <section id="Workspace" class="colum">
                <!--Workspace Header begins-->
                <div class="workspaceHeader interior10">
                    <header>
                        <h1 class="floatLeft" id="tituloSeccion">Usuarios</h1>
                        <div class="linea20"></div>
                        <div class="buscar"><input type="search" name="buscar_contacto" id="buscar_contacto" placeholder="Buscar usuario o persona" class="bigText" /></div>
                    </header>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div id="filtrar" class="btnsFiltro">
                        <div class="first selected" id="usuarios">Usuarios</div>
                        <div id="personas" class="last">Personas</div>
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
                    <div id="users">
                        <!--Lista de contactos-->
                    </div>
                </div>
                <!--Workspace Area ends-->
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
include '../includes/pie.php';
?>
<script type="text/javascript">
    var intervalo;
    var tipo = 'usuarios';
    var pagina = 1;
    var nombreBuscado = '';

    function cargarContactos(filtroNombre, filtroTipo, filtroPagina) {
        $('#users').fadeTo('fast', 0.10, function() {

            $(this).load('/usuarios/ajax/ajaxListarContactos.php', {'nombre':filtroNombre, 'tipo':filtroTipo, 'pagina':filtroPagina}, function(respuesta, estado) {
                if (estado == 'success') {
                    //Mostrando resultados
                    $('#users').fadeTo("fast", 1);
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
        cargarContactos('', 'usuarios', 1);

        $('#filtrar > div').click(function() {
            tipo = $(this).attr('id');
            pagina = 1;
            if (tipo == 'personas') {
                $("#tituloSeccion").html("Contactos &raquo; Personas");
            } else {
                $("#tituloSeccion").text("Usuarios");
            }
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
    }).on('click', '.opcionesUsuario a', function(event) {
        event.preventDefault();
        var opcion = $(this).data("tipo");
        var info = $(this).closest('.info');

            if (opcion == 'editar') {
                $(info).find('.opcionesUsuario').hide();
                $(info).find('.perfiles').fadeIn();
            }
    });
</script>
</body>
</html>