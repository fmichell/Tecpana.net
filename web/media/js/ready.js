/*
 * JS Document
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 25-Jun-2011
 * @fechaModificacion: 27-Dic-2011
 * @version: 1.0
 * @description: Script inicial
 * @media: Screen
 * @coments: Jquery and JqueryUI are needed
 */
function getWindowHeight() {
    var windowHeight = $(window).height() - ($("#HeaderWrapper").height()+1) - ($("#FooterWrapper").height()) - 40;
    return windowHeight;
}
function ajustarAlturaWorkspace() {
    var alto = getWindowHeight();
    $("#Content").css({"min-height": alto+'px'});
    $("#Toolbar").css({"height": $("#Content").height()+'px'});
}
/*function ajustarAnchuraTitulos() {
    var anchoWorkspace = $(".workspaceHeader").width();
    var anchoMainBoton = $(".mainBoton").width();
    var anchoH1 = anchoWorkspace;
    if (anchoWorkspace > 1 && anchoMainBoton > 1) {
        anchoH1 = anchoWorkspace - anchoMainBoton - 15;
        $("h1", ".workspaceHeader").css({"width":anchoH1+'px'});
    }
}*/
function mandejarTextboxTooltip(elemento, tooltip) {
    $(elemento).css('color','#999');
    
    $(elemento).focusin(function() {
        if ($(this).val() == tooltip) {
            $(this).val('');
            $(this).css('color','#333');
        }
    });
    
    $(elemento).focusout(function() {
        if ($(this).val() == '') {
            $(this).val(tooltip);
            $(this).css('color','#999');
        }
    });
}
$(document).on("ready", function() {
    //Ajustando tamano del workspace
    ajustarAlturaWorkspace();
    //Configurando datepicker
    $.datepicker.setDefaults( $.datepicker.regional[ "es" ] );
    $(".selectDate").datepicker({"dateFormat" : "dd M yy"});
    //Configurando UI Button
    $('.fuiBotonCerrar').button({
        icons: {
            primary: "ui-icon-closethick"
        },
        text: false
    });
    $('.fuiBoton').button();
    //Configurando header menu
    $("#hm_trigger").click(function() {
        $("#hm_trigger").addClass("active").focus();
        $("#SettingsMenu").css({"visibility":"visible"});
        return false;
    });
    $("#hm_trigger").blur(function() {
        $("#hm_trigger").removeClass("active");
        $("#SettingsMenu").css({"visibility":"hidden"});
        return false;
    });
    //Definiendo ancho del h1 en la cabecera
    //ajustarAnchuraTitulos();
    //Tooltip nombre contactos
    $('.userThumb').hover(
        function() {
            var ancho = $('.tooltipNombre', this).width();
            var left = '-'+Math.ceil((ancho-40)/2)+'px';
            $('.tooltipNombre', this).css({'visibility':'visible', 'left':left});
        },
        function() {
            $('.tooltipNombre', this).css({'visibility':'hidden'});
        }
    );
    //Ventana agregar involucrados
    $('.abrirInvolucrados').fancybox({
        width: '85%',
        height: '85%',
        type: 'iframe',
        autoSize: false,
        padding: 0,
        closeBtn: false,
        scrolling: 'no',
        helpers: {
            title: null,
            overlay: {
                css : {
                    'background-color' : '#000' 
                },
                opacity : 0.1
            }
        }
    });
    //Abrir cuadro de dialogo
    $('.abrirDialog').fancybox({
        width: 400,
        height: 160,
        type: 'iframe',
        autoSize: false,
        padding: 0,
        closeBtn: false,
        scrolling: 'no',
        helpers: {
            title: null,
            overlay: {
                css : {
                    'background-color' : '#000' 
                },
                opacity : 0.1
            }
        }
    });
    //Para formularios dinamicos
    $('.nuevo a').click(function() {
        var elemento = $(this).closest('dd');
        var ejemplo = $('.ejemplo', elemento);
        var listado = $('.listado', elemento);
        
        var registro = $(ejemplo).clone(true).appendTo(listado).removeClass("ejemplo").fadeIn();
        
        $('.valor', registro).focus();
    });
    $('.eliminar').click(function() {
        var listado = $(this).closest('.listado');
        var elemento = $(this).closest('.elemento');
        var n = $('.elemento', listado).length;
        
        if (n > 1) {
            $(this).closest('.elemento').remove();
        } else {
            $('input .valor', elemento).val('');
        }       
        return false;
    });
});