<?php
/**
 * @autor: Federico
 * @fechaCreacion: 08-24-12
 * @fechaModificacion: 08-24-12
 * @version: 1.0
 * @descripcion: Información del perfil del usuario (Solo usuarios)
 */
include '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Etiqueta.php';

// Obtenemos el id del contacto
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $contacto_id = $_GET['id'];
} else {
    header ('location: /contactos');
    exit;
}

// Cargamos a todos los contactos
$contactos = Contacto::obtenerTodos(CUENTA_ID);
// Obtenemos contacto seleccionado
if (isset($contactos[$contacto_id])) {
    $contacto = $contactos[$contacto_id];
    $usuario  = Usuario::obtener(CUENTA_ID, $contacto_id);
} else {
    header ('location: /contactos');
    exit;
}

// Obtenemos foto de perfil
$fotoPerfil = Contacto::obtenerFotos($contacto['foto'], $contacto['tipo'], $contacto['sexo']);

// Cargamos etiquetas del contacto
$etiquetas = Contacto::obtenerEtiquetas(CUENTA_ID, $contacto_id);
// Definiendo submenu activo
$subMenu = 'perf';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo $contacto['nombre_completo'] ?> - <?php echo SISTEMA_NOMBRE ?></title>
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
        <header class="infoHeader">
            <?php include '../includes/cabecera-contacto.php' ?>
            <div class="mainBoton">
                <a href="/contactos/<?php echo $contacto_id ?>/editar-perfil" class="botong botong_azul">Editar perfil</a>
            </div>
            <div class="linea5"></div>
        </header>
    </div>
    <!--Workspace Header ends-->
    <!--Workspace Toolbar begins-->
    <div class="workspaceToolbar">
        <?php include '../includes/menu-usuario.php'; ?>
    </div>
    <!--Workspace Toolbar ends-->
    <!--Workspace Area begins-->
    <div class="workspaceArea interior10 contactInfo">
        <div class="linea10"></div>
        <dl class="horizontal">
            <dt>Usuario:</dt>
            <dd><div class="elemento"><?php echo $usuario['usuario'] ?></div></dd>
            <dt>Perfil:</dt>
            <dd><div class="elemento"><?php echo Usuario::$arrayPerfiles[$usuario['perfil_id']] ?></div></dd>
            <dt>Zona tiempo:</dt>
            <dd><div class="elemento"><?php echo $usuario['zona_tiempo'] ?></div></dd>
            <dt>Usario desde:</dt>
            <dd><div class="elemento"><?php echo $usuario['fecha_creacion'] ?></div></dd>
            <dt>Última actualización:</dt>
            <dd><div class="elemento"><?php echo $usuario['fecha_actualizacion'] ?></div></dd>
        </dl>
    </div>
    <!--Workspace Area ends-->
</section>
<!--Workspace ends-->
<!--Toolbar begins-->
<section id="Toolbar" class="colum">
    <div class="interior10">
        <!-- Solo visible en pantallas menores de 1024 -->
        <div class="mainBoton">
            <a href="/contactos/<?php echo $contacto_id ?>/editar-perfil" class="botong botong_azul">Editar perfil</a>
        </div>
        <!-- Fin -->

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
<script type="text/javascript">
    $(document).on("ready", function() {
        $("#editarEtiquetas").click(function() {
            var etiquetas = $(this).closest(".etiquetasContacto");
            var agregar = $(etiquetas).find(".agregarEtiqueta");

            $(this).hide();
            $(etiquetas).addClass("editState");
            $(agregar).show();
            $("#valEtiqueta").focus();
        });
        $("#addEtiqueta").click(function() {
            var etiqueta = $("#valEtiqueta").val();
            var contacto = $(this).attr('rel');

            $.getJSON('/contactos/ajax/ajaxAgregarEtiqueta.php', {'etiqueta':etiqueta, 'contacto':contacto}, function(data) {
                if (data['resultado'] == '1') {
                    var newEtiqueta = "<li><a href='/contactos/etiqueta/" + data['seo'] + "' data-etiqueta='" + data['id'] + "' data-contacto='" + data['contacto'] + "'>"+etiqueta+"</a>, </li>";

                    $("#valEtiqueta").val('');
                    $(newEtiqueta).insertBefore("#editarEtiquetas");
                } else if (data['resultado'] == '2') {
                    $("#valEtiqueta").val('');
                } else {
                    alert('Ocurrió un error al agregar la etiqueta');
                }
            });
        });
        $("#valEtiqueta").autocomplete({
            source: "/contactos/ajax/ajaxSugerirEtiqueta.php",
            minLength: 2,
            select: function( event, ui ) {
                ui.item ? $('#etiqueta_id').val(ui.item.id) : $('#etiqueta_id').val('nueva');
            },
            change: function( event, ui ) {
                ui.item ? $('#etiqueta_id').val(ui.item.id) : $('#etiqueta_id').val('nueva');
            }
        });
        $("#valEtiqueta").keyup(function(event) {
            if (event.keyCode == 13) {
                $("#addEtiqueta").click();
            }
        });

        $(document).on('click', '.editState ul a:not(#editarEtiquetas)',function(event) {
            event.preventDefault();
            var etiqueta = $(this).data("etiqueta");
            var contacto = $(this).data("contacto");
            var elemento = $(this).parent();

            $.get('/contactos/ajax/ajaxEliminarEtiqueta.php', {'etiqueta':etiqueta, 'contacto':contacto}, function(respuesta) {
                if (respuesta == '1') {
                    $(elemento).remove();
                } else {
                    alert('Ocurrió un error al eliminar la etiqueta');
                }
            });
        });

        $("#cancelEtiquetas").click(function() {
            var etiquetas = $(this).closest(".etiquetasContacto");
            var agregar = $(etiquetas).find(".agregarEtiqueta");

            var cantidad = $('li', '.editState').length;
            if (cantidad == 1) {
                var labelText = 'Agregar etiquetas';
            } else {
                var labelText = 'Editar etiquetas';
            }

            $(etiquetas).removeClass("editState");
            $(agregar).hide();
            $("#editarEtiquetas").text(labelText).show();
        });
    });
</script>
</body>
</html>