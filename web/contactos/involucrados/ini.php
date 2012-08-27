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
                <div class="contactos">
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Federico Joaquin Michell Vijil</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/famaleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Farah Prado</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Alvaro Diaz</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Harley Solano</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/famaleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Maria Fernanda Perez</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/famaleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Luz Cantillo Olvares</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/famaleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Esperanza Centeno</div>
                    </a>
                    <a href="javascript:;" class="contacto">
                        <div class="userThumb floatLeft"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></div>
                        <div class="nombre">Keng Chow</div>
                    </a>
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

    $(document).on("ready", function() {
        $('.contactos').css({'height':calcularAltura()+'px'});

        $('#cerrar, #cancelar').click(function() {
            parent.$.fancybox.close();
        });

        $('.contacto').click(function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $(this).addClass('selected');
            }
        });
    });
</script>
</body>
</html>