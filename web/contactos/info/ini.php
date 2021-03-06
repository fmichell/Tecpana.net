<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 23-Jun-12
 * @fechaModificacion: 23-Jun-12
 * @version: 1.0
 * @descripcion: Muestra información detallada de un contacto
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
} else {
    header ('location: /contactos');
    exit;
}

// Obtenemos foto de perfil
$fotoPerfil = Contacto::obtenerFotos($contacto['foto'], $contacto['tipo'], $contacto['sexo']);

// Cargamos empleados de la empresa
$empleados = Contacto::obtenerEmpleados(CUENTA_ID, $contacto_id);
// Obtenemos foto del empleado
foreach ($empleados as $empleado_id => $empleado) {
    $tmpFoto = Contacto::obtenerFotos($empleado['foto'], 1, $empleado['sexo']);
    $empleados[$empleado_id]['uri'] = $tmpFoto['uriThumbnail'];
}
// Cargamos etiquetas del contacto
$etiquetas = Contacto::obtenerEtiquetas(CUENTA_ID, $contacto_id);
// Cargamos algunos datos varios
$paises = CamposContacto::obtenerPaises();
// Definiendo submenu activo
$subMenu = 'info';
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
                        <?php if ($contacto['tipo'] == 1) { ?>
                        <a href="/contactos/<?php echo $contacto_id ?>/editar-persona" class="botong botong_azul">Editar información</a>
                        <?php } elseif ($contacto['tipo'] == 2) { ?>
                        <a href="/contactos/<?php echo $contacto_id ?>/editar-empresa" class="botong botong_azul">Editar información</a>
                        <?php } ?>
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
                <?php
                if (isset($contacto['telefono'])) {
                    ?>
                    <dt>Teléfono(s):</dt>
                    <dd>
                        <?php foreach ($contacto['telefono'] as $telefono) { ?>
                        <div class="elemento"><?php echo $telefono['valor'] ?> <span class="nota"><?php echo $telefono['modo'] ?></span></div>
                        <?php } ?>
                    </dd>
                    <?php
                }
                if (isset($contacto['email'])) {
                    ?>
                    <dt>Email(s):</dt>
                    <dd>
                        <?php foreach ($contacto['email'] as $email) { ?>
                        <div class="elemento">
                            <a href="mailto:<?php echo $email['valor'] ?>"><?php echo $email['valor'] ?></a>
                            <span class="nota"><?php echo $email['modo'] ?></span>
                        </div>
                        <?php } ?>
                    </dd>
                    <?php
                }
                if (isset($contacto['mensajeria'])) {
                    ?>
                    <dt>Mensajeria:</dt>
                    <dd>
                        <?php foreach ($contacto['mensajeria'] as $mensajeria) { ?>
                        <div class="elemento">
                            <a href="<?php echo $mensajeria['valor'] ?>" target="_blank"><?php echo $mensajeria['valor'] ?></a>
                            <?php if ($mensajeria['servicio']) echo 'en ' . $mensajeria['servicio']; ?>
                            <span class="nota"><?php echo $mensajeria['modo'] ?></span>
                        </div>
                        <?php } ?>
                    </dd>
                    <?php
                }
                if (isset($contacto['web'])) {
                    ?>
                    <dt>Sitio(s) web:</dt>
                    <dd>
                        <?php foreach ($contacto['web'] as $web) { ?>
                        <div class="elemento">
                            <a href="<?php echo $web['valor'] ?>" target="_blank"><?php echo $web['valor'] ?></a>
                            <span class="nota"><?php echo $web['modo'] ?></span>
                        </div>
                        <?php } ?>
                    </dd>
                    <?php
                }
                if (isset($contacto['rsociales'])) {
                    ?>
                    <dt>Redes sociales:</dt>
                    <dd>
                        <?php foreach ($contacto['rsociales'] as $rsociales) { ?>
                        <div class="elemento">
                            <a href="<?php echo $rsociales['valor'] ?>" target="_blank"><?php echo $rsociales['valor'] ?></a>
                            <?php if ($rsociales['servicio']) echo 'en ' . $rsociales['servicio']; ?>
                            <span class="nota"><?php echo $rsociales['modo'] ?></span>
                        </div>
                        <?php } ?>
                    </dd>
                    <?php
                }
                if (isset($contacto['direccion'])) {
                    ?>
                    <dt>Dirección(es):</dt>
                    <dd class="direccion">
                        <?php foreach ($contacto['direccion'] as $direccion) { ?>
                        <div class="elemento">
                            <span class="nota"><?php echo $direccion['modo'] ?></span>
                            <?php
                            echo $direccion['valor_text'] . '<br />';
                            $tmp = array($direccion['ciudad'], $direccion['estado'], $paises[$direccion['pais_id']]['pais']);
                            echo implode(', ', array_filter($tmp));
                            ?>
                        </div>
                        <?php } ?>
                    </dd>
                    <?php
                }
                ?>
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
                    <?php if ($contacto['tipo'] == 1) { ?>
                    <a href="/contactos/<?php echo $contacto_id ?>/editar-persona" class="botong botong_azul">Editar información</a>
                    <?php } elseif ($contacto['tipo'] == 2) { ?>
                    <a href="/contactos/<?php echo $contacto_id ?>/editar-empresa" class="botong botong_azul">Editar información</a>
                    <?php } ?>
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
                <?php if (isset($empleados) and !empty($empleados)) { ?>
                <div class="recuadro empleadosList">
                    <h3>Personas en la empresa</h3>
                    <ul>
                        <?php foreach ($empleados as $empleado) { ?>
                        <li>
                            <div class="userThumb floatLeft">
                                <img alt="<?php echo $empleado['nombre_completo'] ?>" src="<?php echo $empleado['uri'] ?>">
                            </div>
                            <a href="/contactos/<?php echo $empleado['contacto_id'] ?>/info"><?php echo $empleado['nombre_completo'] ?></a><br />
                            <?php
                            if (isset($empleado['cargo'])) {
                                $cargo = current($empleado['cargo']);
                                ?><div class="nota"><?php echo $cargo['valor'] ?></div><?php
                            } ?>
                            <div class="clear"><!--empy--></div>
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