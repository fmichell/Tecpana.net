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
var mismo = 1;
function ajustarAlturaWorkspace() {
    var alto = getWindowHeight();
    $("#Content").css({"min-height": alto+'px'});
    $("#Toolbar").css({"height": $("#Content").height()+'px'});
}
function cambiarParamUrl(datos, ventana, divisor)
{
    var temp, url_nuevo, partes, parametros, base, encontrado, url;

    if (typeof(datos) != "object") return false;
    if (vacio(ventana)) ventana=window;
    url = ventana.location.href;
    if (divisor == undefined) divisor = "?";

    if (url.indexOf(divisor) == -1) {
        base = url;
        parametros = [];
    } else {
        partes = url.split(divisor);
        base = partes[0];
        parametros = partes[1].split("&");
    }

    for (var n in datos)
    {
        encontrado = false;
        for (var i in parametros){
            temp = parametros[i];
            if (temp.indexOf(n+"=") == 0) {
                encontrado = true;
                if (datos[n] == "") {
                    parametros.splice(i, 1);
                } else {
                    parametros[i] = n+"="+datos[n];
                }
            }
        }
        if (!encontrado && datos[n] != "") {
            parametros.push(n+"="+datos[n]);
        }
    }

    if (parametros.length == 0) {
        url_nuevo = base;
    } else {
        url_nuevo = base+divisor+parametros.join("&");
    }
    ventana.location.href = url_nuevo;
}
function vacio(valor){var llave;if(valor===""||valor===0||valor==="0"||valor===null||valor===false||valor===undefined)return true;if(typeof valor=='object'){for(llave in valor){return false}return true}return false}

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
function mostrarMenu() {
    $("#hm_trigger_element").addClass('active');
    $("#hm_trigger").addClass("active").focus();
    $("#SettingsMenu").css({"visibility":"visible"});
    $("a:first", "#SettingsMenu").focus();
    $('html').on('click', ocultarMenu);
}
function ocultarMenu(event) {
    $("#hm_trigger").removeClass("active");
    $("#hm_trigger_element").removeClass('active');
    $("#SettingsMenu").css({"visibility":"hidden"});
    $('html').off('click', ocultarMenu);
    event.stopPropagation();
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
    $("#hm_trigger_element").hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
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
            $('input.valor', elemento).val('');
        }
    });
}).on('click', '#hm_trigger_element:not(.active)', mostrarMenu);


