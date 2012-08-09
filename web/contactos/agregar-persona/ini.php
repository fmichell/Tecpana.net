<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: alrededor del 23-06-2012
 * @fechaModificacion: 28-07-2012
 * @version: 1.0
 * @descripcion: Formulario para agregar persona
 */
include '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Persona.php';
include SISTEMA_RAIZ . '/modelos/Empresa.php';
include_once SISTEMA_RAIZ . '/modelos/CamposContacto.php';

// Verificamos la sesion y los permisos
Usuario::verificarSesion();

if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'guardar')) {
    // Capturamos empresa
    if (empty($_POST['empresa'])) {
        $empresa = false; $empresaId = null;
    } else {
        if ($_POST['empresa_id'] == 'nueva') {
            // Si la empresa es nueva, la creamos
            $empresaId = Empresa::agregar(CUENTA_ID, $_POST['empresa']);
        } else {
            // Si la empresa existe, primero verificamos que asi sea
            $tmpEmpresa = Contacto::obtener(CUENTA_ID, $_POST['empresa_id']);
            if ($tmpEmpresa['nombre_completo'] == $_POST['empresa']) {
                // Si existe la tomamos
                $empresaId = $tmpEmpresa['contacto_id'];
            } else {
                // Si no existe la creamos
                $empresaId = Empresa::agregar(CUENTA_ID, $_POST['empresa']);
            }
        }
        // Si todo esta correcto, definimos empresa = true
        if ($empresaId) {
            $empresa = true;
        } else {
            $empresa = false;
            $empresaId = null;
        }
    }

    // Insertamos contacto
    $resultado = Persona::agregar(CUENTA_ID, $_POST['nombre'], $_POST['apellidos'], $_POST['sexo'], $_POST['titulo'], $_POST['profesion'], $empresaId);
    $infos = Contacto::prepararInfo($_POST);

    if (!$resultado) {
        die('Ocurrio un error');
    } else {
        $contacto_id = &$resultado;
        // Insertamos info
        // Insertamos el cargo
        if (isset($infos['cargo'])) {
            Persona::agregarCargo(CUENTA_ID, $contacto_id, $infos['cargo']);
        }
        // Insertamos telefono
        if (isset($infos['telefono'])) {
            foreach ($infos['telefono'] as $telefono) {
                Persona::agregarTelefono(CUENTA_ID, $contacto_id, $telefono['valor'], $telefono['modo']);
            }
        }
        // Insertamos email
        if (isset($infos['email'])) {
            foreach ($infos['email'] as $email) {
                Persona::agregarEmail(CUENTA_ID, $contacto_id, $email['valor'], $email['modo']);
            }
        }
        // Insertamos mensajeria
        if (isset($infos['mensajeria'])) {
            foreach ($infos['mensajeria'] as $mensajeria) {
                Persona::agregarMensajeria(CUENTA_ID, $contacto_id, $mensajeria['valor'], $mensajeria['modo'], $mensajeria['servicios']);
            }
        }
        // Insertamos web
        if (isset($infos['web'])) {
            foreach ($infos['web'] as $web) {
                Persona::agregarWeb(CUENTA_ID, $contacto_id, $web['valor'], $web['modo']);
            }
        }
        // Insertamos redes sociales
        if (isset($infos['rsociales'])) {
            foreach ($infos['rsociales'] as $rsociales) {
                Persona::agregarRSociales(CUENTA_ID, $contacto_id, $rsociales['valor'], $rsociales['modo'], $rsociales['servicios']);
            }
        }
        // Insertamos direccion
        if (isset($infos['direccion'])) {
            foreach ($infos['direccion'] as $direccion) {
                Persona::agregarDireccion(CUENTA_ID, $contacto_id, $direccion['valor'], $direccion['ciudad'], $direccion['estado'], $direccion['pais'], $direccion['cpostal'], $direccion['modo']);
            }
        }
    }

    // Redireccionamos a info
    header('location: /contactos/' . $contacto_id . '/info');
    exit;
}

// Obteniendo listas generales
$campos = CamposContacto::$tiposInfo;
$paises = CamposContacto::obtenerPaises();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Agregar persona - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../../includes/cabezera.php' ?>
    <link rel="stylesheet" type="text/css" href="/media/css/form.css" />
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
    <section id="Content">
        <!--Workspace begins-->
        <section id="Workspace" class="colum formulario">
            <form method="post" action="" name="frmAgregarContacto" id="frmAgregarContacto" class="frmContacto">
                <input type="hidden" name="submitForm" value="guardar" />
                <!--Workspace Header begins-->
                <div class="workspaceHeader interior10">
                    <div class="userPic">
                        <img src="/media/imgs/maleContact.jpg" alt="Hombre" id="picHombre" />
                        <img src="/media/imgs/famaleContact.jpg" alt="Mujer" id="picMujer" />
                        <a href="#">Subir foto</a>
                    </div>
                    <div class="floatLeft">
                        <input type="text" class="bigText ancho465es" name="nombre" id="nombre" placeholder="Nombres" /><br />
                        <input type="text" class="bigText ancho465es" name="apellidos" id="apellidos" placeholder="Apellidos" /><br />
                        <select name="sexo" id="sexo" class="ancho85es">
                            <option value="1" selected="selected">Hombre</option>
                            <option value="2">Mujer</option>
                        </select>
                    </div>
                    <div class="linea5"></div>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar"><!--TODO--></div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10">
                    <div class="linea10"></div>
                    <dl class="horizontal">
                        <dt><label for="titulo">Título</label></dt>
                        <dd><input type="text" name="titulo" id="titulo" class="ancho85es" /></dd>
                        <dt><label for="profesion">Profesión</label></dt>
                        <dd><input type="text" name="profesion" id="profesion" class="ancho465es" /></dd>
                        <dt><label for="empresa">Empresa</label></dt>
                        <dd><input type="text" name="empresa" id="empresa" class="ancho465es" />
                            <input type="hidden" name="empresa_id" id="empresa_id" value="nueva">
                        </dd>
                    </dl>
                    <dl class="horizontal" id="divCargo" style="display: none">
                        <dt><label for="cargo">Cargo</label></dt>
                        <dd><input type="text" name="cargo" id="cargo" class="ancho465es" /></dd>
                    </dl>
                    <dl class="horizontal">
                        <dt><label for="telefono">Teléfono(s)</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="tel" name="telefono[]" class="ancho300es valor" />
                                <select name="telefonoModo[]" class="ancho85es">
                                    <?php foreach ($campos['telefono']['modo'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <div class="elemento">
                                    <input type="tel" name="telefono[]" id="telefono" class="ancho300es valor" />
                                    <select name="telefonoModo[]" class="ancho85es">
                                        <?php foreach ($campos['telefono']['modo'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="email">Email(s)</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="email" name="email[]" class="ancho300es valor" />
                                <select name="emailModo[]" class="ancho85es">
                                    <?php foreach ($campos['email']['modo'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <div class="elemento">
                                    <input type="email" name="email[]" id="email" class="ancho300es valor" />
                                    <select name="emailModo[]" class="ancho85es">
                                        <?php foreach ($campos['email']['modo'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="mensajeria">Mensajería</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="text" name="mensajeria[]" style="width:218px;" class="valor" />
                                <select name="mensajeriaServicios[]" style="width:109px">
                                    <?php foreach ($campos['mensajeria']['servicios'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <select name="mensajeriaModo[]" class="ancho85es">
                                    <?php foreach ($campos['mensajeria']['modo'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <div class="elemento">
                                    <input type="text" name="mensajeria[]" id="mensajeria" style="width:218px;" class="valor" />
                                    <select name="mensajeriaServicios[]" style="width:109px">
                                        <?php foreach ($campos['mensajeria']['servicios'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="mensajeriaModo[]" class="ancho85es">
                                        <?php foreach ($campos['mensajeria']['modo'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>

                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="web">Sitio(s) web</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="url" name="web[]" class="ancho300es valor" />
                                <select name="webModo[]" class="ancho85es">
                                    <?php foreach ($campos['web']['modo'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <div class="elemento">
                                    <input type="url" name="web[]" id="web" class="ancho300es valor" />
                                    <select name="webModo[]" class="ancho85es">
                                        <?php foreach ($campos['web']['modo'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="rsociales">Redes sociales</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="text" name="rsociales[]" style="width:218px;" class="valor" />
                                <select name="rsocialesServicios[]" style="width:109px">
                                    <?php foreach ($campos['rsociales']['servicios'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <select name="rsocialesModo[]" class="ancho85es">
                                    <?php foreach ($campos['rsociales']['modo'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <div class="elemento">
                                    <input type="text" name="rsociales[]" id="rsociales" style="width:218px;" class="valor" />
                                    <select name="rsocialesServicios[]" style="width:109px">
                                        <?php foreach ($campos['rsociales']['servicios'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="rsocialesModo[]" class="ancho85es">
                                        <?php foreach ($campos['rsociales']['modo'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="direccion">Dirección(es)</label></dt>
                        <dd class="elementoDireccion">
                            <div class="elemento ejemplo">
                                <div class="linea10"></div>
                                <div class="linea">
                                    <textarea name="direcccion[]" class="ancho465es direccion valor" cols="60" rows="2" placeholder="Dirección"></textarea>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="linea">
                                    <input type="text" name="ciudad[]" class="ancho465es ciudad" placeholder="Ciudad/población" />
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="linea">
                                    <input type="text" name="estado[]" class="ancho300es estado" placeholder="Estado/departamento" />
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="linea">
                                    <select name="pais[]" class="pais" style="width: 334px">
                                        <?php foreach($paises as $pais) { ?>
                                        <option value="<?php echo $pais['id'] ?>"><?php echo $pais['pais'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="direccionModo[]" class="ancho85es">
                                        <?php foreach ($campos['direccion']['modo'] as $llave => $valor) { ?>
                                        <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>
                            <div class="listado">
                                <div class="elemento">
                                    <div class="linea">
                                        <textarea name="direcccion[]" id="direccion" class="ancho465es direccion valor" cols="60" rows="2" placeholder="Dirección"></textarea>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <div class="linea">
                                        <input type="text" name="ciudad[]" class="ancho465es ciudad" placeholder="Ciudad/población" />
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <div class="linea">
                                        <input type="text" name="estado[]" class="ancho300es estado" placeholder="Estado/departamento" />
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <div class="linea">
                                        <select name="pais[]" class="pais" style="width: 334px">
                                            <?php foreach($paises as $pais) { ?>
                                            <option value="<?php echo $pais['id'] ?>"><?php echo $pais['pais'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <select name="direccionModo[]" class="ancho85es">
                                            <?php foreach ($campos['direccion']['modo'] as $llave => $valor) { ?>
                                            <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                            <?php } ?>
                                        </select>
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otra</a></div>
                        </dd>
                    </dl>
                    <div class="linea10"></div>
                    <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnSubmit">Agregar Contacto</a>
                    <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnCancel">Cancelar</a>
                    <div class="linea10"></div>
                </div>
                <!--Workspace Area ends-->
            </form>
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
include '../../includes/pie.php';
?>
<script type="text/javascript">
$(document).on("ready", function() {
    //$('#nombre').focus();
    $('#sexo').change(function() {
        if ($(this).val() == 1) {
            $('#picMujer').hide();
            $('#picHombre').show();
        } else if ($(this).val() == 2) {
            $('#picHombre').hide();
            $('#picMujer').show();
        }
    });
    $("#empresa").keyup(function(evento) {
        var valor = $(this).val();
        var long = valor.length;
        if (long == 0) {
            $('#divCargo').fadeOut();
            $('#cargo').val('');
        } else if (long == 1) {
            $('#divCargo').fadeIn();
        } else {
            return false;
        }
    });
    $( "#empresa" ).autocomplete({
        source: "/contactos/ajax/ajaxSugerirEmpresa.php",
        minLength: 2,
        select: function( event, ui ) {
            ui.item ? $('#empresa_id').val(ui.item.id) : $('#empresa_id').val('nueva');
        },
        change: function( event, ui ) {
            ui.item ? $('#empresa_id').val(ui.item.id) : $('#empresa_id').val('nueva');
        }
    });
    $("#btnSubmit").click(function() {
        $("#frmAgregarContacto").submit();
    });
    $("#btnCancel").click(function() {
        var respuesta = confirm('Está seguro que desea cancelar?');
        if (respuesta) {
            window.location.href = '/contactos';
        } else {
            return false;
        }
    });
});
</script>
</body>
</html>