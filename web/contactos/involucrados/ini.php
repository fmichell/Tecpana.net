<?php
/**
 * @autor: Federico
 * @fechaCreacion: 08-27-12
 * @fechaModificacion: 08-27-12
 * @version: 1.0
 * @descripcion: Seleccionar contactos involucrados en una tarea o proyecto
 */
include '../../../app/inicio.php';

// Declaramos ventana
$ventana = true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Involucrar contactos - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
</head>
<body class="dialog" id="involucrarContactos">
<!--Header begins-->
<header id="HeaderVentanaGeneral">
    <h1>Involucrar contactos <button class="fuiBotonCerrar" id="cerrar">Cerrar</button></h1>
</header>
<!--Header ends-->

<div class="interior5">
    <!--MainWrapper begins-->
    <div id="MainWrapperVentana">
        <!--Content begins-->
        <section id="Content">
            <!--Workspace begins-->
            <section id="Workspace">
                <!--Workspace Filtros begins-->
                <div class="filtros">
                    <p><span style="float: left; margin-right: .3em;" class="icono_info"></span>Por favor seleccione los contactos que desea involucrar.</p>
                    <div style="width:74%; margin-right:1%;" class="floatLeft">
                        <div class="buscar"><input type="search" name="buscar_contacto" id="buscar_contacto" placeholder="Buscar contacto" /></div>
                    </div>
                    <div style="width:25%" class="floatLeft">
                        <div class="buscar">
                            <select name="filtroGrupos" id="filtroGrupos">
                                <option value="1">Familia</option>
                                <option value="2">Amigos</option>
                                <option value="3">Empresa</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"><!--vacio--></div>
                    <div class="linea10"></div>
                </div>
                <!--Workspace Filtros ends-->
                <!--Workspace Contactos begins-->
                <div id="contactos" class="contactos">
                    <!--Lista de contactos-->
                </div>
                <!--Workspace Contactos ends-->
                <!--Workspace Accion begins-->
                <div class="accion">
                    <div class="linea5"></div>
                    <div class="linea10 separador"></div>
                    <div class="linea10"></div>
                    <div class="floatRight">
                        <button class="fuiBoton" id="involucrar">Involucrar</button>
                        <button class="fuiBoton" id="cancelar">Cancelar</button>
                    </div>
                    <div class="clear"><!--vacio--></div>
                </div>
                <!--Workspace Accion ends-->
            </section>
            <!--Workspace ends-->
        </section>
        <!--Content ends-->
    </div>
    <!--MainWrapper ends-->
</div>
<script type="text/javascript">
    var intervalo;
    var nombreBuscado = '';
    function calcularAltura() {
        var iframeHeight = $('.fancybox-iframe', parent.document).height();
        var bodyMargin = 16; //8 arriba y 8 abajo
        var involucradosHead = $('#HeaderVentanaGeneral').height();
        var interiorPadding = 12; //5 arriba y 5 abajo del div interior5 y 2 de borde
        var involucradosTop = $('.filtros').height();
        var involucradosFooter = $('.accion').height();
        var contactosPadding = 12;
        var comodin = 5;
        bodyMargin+=comodin;

        var altura = iframeHeight - (bodyMargin + involucradosHead + interiorPadding + involucradosTop + contactosPadding + involucradosFooter) - 15;
        return altura;
    }
    function cargarContactos(filtroNombre) {
        $('#contactos').fadeTo('fast', 0.10, function() {
            $(this).load('/contactos/ajax/ajaxListarContactos.php', {'nombre':filtroNombre, 'vista':'iconos'}, function(respuesta, estado) {
                if (estado == 'success') {
                    calcularAnchoIconosContactos();
                    //Mostrando resultados
                    $('#contactos').fadeTo("fast", 1);
                } else {
                    alert('Ocurrió un error al cargar el listado')
                }
            });
        });
    }
    function buscarNombre() {
        var nombre = $('#buscar_contacto').val();
        if (nombre != '') {
            cargarContactos(nombre);
        } else {
            cargarContactos('');
        }
    }
    function calcularAnchoIconosContactos() {
        var anchoArea = $('.contactos').width();
        var anchoIcon = 150;
        var extra = 27; // padding + borde + margen
        var iconos = Math.floor(anchoArea / (anchoIcon + extra));
        var anchoIcon = Math.floor((anchoArea / iconos) - extra);

        $('.contacto').css({'width':anchoIcon+'px'});
    }
    $(document).on("ready", function() {
        cargarContactos('');

        $('.contactos').css({'height':calcularAltura()+'px'});

        $('#cerrar, #cancelar').click(function() {
            parent.$.fancybox.close();
        });

        $('.contacto').live('click', function(event) {
            event.preventDefault();

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $(this).addClass('selected');
            }
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

        $("#involucrar").on('click', function() {
            var involucrados = '';
            var total = $('.selected').length;

            if (total >= 1) {
                $(".selected").each(function() {
                    involucrados+= $(this).data('id');
                });
                parent.$("#ctos").html(involucrados);
                console.log(involucrados);
            } else {
                $('#cerrar').click();
            }
        });
    });
</script>
</body>
</html>