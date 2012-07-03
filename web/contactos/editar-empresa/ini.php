<?php
include '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Empresa.php';
include_once SISTEMA_RAIZ . '/modelos/CamposContacto.php';

// Obteniendo el id del contacto
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $contacto_id = $_GET['id'];
} else {
    header ('location: /contactos');
}

if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'editar')) {
    // Editamos contacto
    $resultado = Empresa::editar(CUENTA_ID, $contacto_id, $_POST['razon_social'], $_POST['giro']);
    $infos = Contacto::prepararInfo($_POST);

    if (!$resultado) {
        die('Ocurrio un error');
    } else {
        // Eliminamos la info existente
        $resultado = Contacto::eliminarInfoContacto(CUENTA_ID, $contacto_id);
        // Insertamos info
        // Insertamos productos y/o servicios
        if (isset($infos['productos'])) {
            Empresa::agregarProductos(CUENTA_ID, $contacto_id, $infos['productos']);
        }
        // Insertamos telefono
        if (isset($infos['telefono'])) {
            foreach ($infos['telefono'] as $telefono) {
                Empresa::agregarTelefono(CUENTA_ID, $contacto_id, $telefono['valor'], $telefono['modo']);
            }
        }
        // Insertamos email
        if (isset($infos['email'])) {
            foreach ($infos['email'] as $email) {
                Empresa::agregarEmail(CUENTA_ID, $contacto_id, $email['valor']);
            }
        }
        // Insertamos mensajeria
        if (isset($infos['mensajeria'])) {
            foreach ($infos['mensajeria'] as $mensajeria) {
                Empresa::agregarMensajeria(CUENTA_ID, $contacto_id, $mensajeria['valor'], $mensajeria['servicios']);
            }
        }
        // Insertamos web
        if (isset($infos['web'])) {
            foreach ($infos['web'] as $web) {
                Empresa::agregarWeb(CUENTA_ID, $contacto_id, $web['valor']);
            }
        }
        // Insertamos redes sociales
        if (isset($infos['rsociales'])) {
            foreach ($infos['rsociales'] as $rsociales) {
                Empresa::agregarRSociales(CUENTA_ID, $contacto_id, $rsociales['valor'], $rsociales['servicios']);
            }
        }
        // Insertamos direccion
        if (isset($infos['direccion'])) {
            foreach ($infos['direccion'] as $direccion) {
                Empresa::agregarDireccion(CUENTA_ID, $contacto_id, $direccion['valor'], $direccion['ciudad'], $direccion['estado'], $direccion['pais'], $direccion['cpostal']);
            }
        }
    }
}

// Obteniendo datos del contacto
$contacto = Contacto::obtener(CUENTA_ID, $contacto_id);

// Obteniendo listas generales
$campos = CamposContacto::$tiposInfo;
$paises = CamposContacto::obtenerPaises();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar empresa - <?php echo SISTEMA_NOMBRE ?></title>
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
            <form method="post" action="" name="frmEditarContacto" id="frmEditarContacto" class="frmContacto">
                <input type="hidden" name="submitForm" value="editar" />
                <!--Workspace Header begins-->
                <div class="workspaceHeader interior10">
                    <div class="userPic">
                        <img src="/media/imgs/businessContact.jpg" alt="Empresa" id="picEmpresa" />
                        <a href="#">Subir logotipo</a>
                    </div>
                    <div class="floatLeft">
                        <input type="text" value="<?php echo $contacto['nombre'] ?>" name="razon_social" id="razon_social" class="bigText ancho465es" placeholder="Razón Social" /><br />
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
                        <dt><label for="giro">Giro de la empresa</label></dt>
                        <dd><textarea type="text" name="giro" id="giro" cols="10" rows="5" class="ancho465es"><?php
                            echo $contacto['descripcion'] ?></textarea></dd>
                        <dt><label for="productos">Productos y/o servicios</label></dt>
                        <dd><textarea type="text" name="productos" id="productos" cols="10" rows="5" class="ancho465es"><?php
                            if (isset($contacto['productos'])) {
                                $productos = current($contacto['productos']);
                                echo $productos['valor_text'];
                            }
                            ?>
                            </textarea></dd>
                        <dt><label for="telefono">Teléfono(s)</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="tel" name="telefono[]" class="ancho300es valor" />
                                <select name="telefonoModo[]" class="ancho85es">
                                    <?php foreach ($campos['telefono_e']['modo'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <?php
                                if (isset($contacto['telefono'])) {
                                    foreach ($contacto['telefono'] as $telefono) {
                                        ?>
                                        <div class="elemento">
                                            <input type="tel" value="<?php echo $telefono['valor'] ?>" name="telefono[]" class="ancho300es valor" />
                                            <select name="telefonoModo[]" class="ancho85es">
                                                <?php
                                                foreach ($campos['telefono_e']['modo'] as $llave => $valor) {
                                                    $selected = ($telefono['modo_id'] == $llave) ? 'selected="selected"' : '';
                                                    ?>
                                                <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $valor ?></option>
                                                    <?php
                                                } ?>
                                            </select>
                                            <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="elemento">
                                        <input type="tel" name="telefono[]" id="telefono" class="ancho300es valor" />
                                        <select name="telefonoModo[]" class="ancho85es">
                                            <?php foreach ($campos['telefono_e']['modo'] as $llave => $valor) { ?>
                                            <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                            <?php } ?>
                                        </select>
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="email">Email(s)</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="email" name="email[]" class="ancho435es valor" />
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <?php
                                if (isset($contacto['email'])) {
                                    foreach ($contacto['email'] as $email) {
                                        ?>
                                        <div class="elemento">
                                            <input type="email" value="<?php echo $email['valor'] ?>" name="email[]" class="ancho435es valor" />
                                            <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="elemento">
                                        <input type="email" name="email[]" id="email" class="ancho435es valor" />
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="mensajeria">Mensajería</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="text" name="mensajeria[]" class="ancho300es valor" />
                                <select name="mensajeriaServicios[]" class="ancho85es">
                                    <?php foreach ($campos['mensajeria_e']['servicios'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <?php
                                if (isset($contacto['mensajeria'])) {
                                    foreach ($contacto['mensajeria'] as $mensajeria) {
                                        ?>
                                        <div class="elemento">
                                            <input type="text" value="<?php echo $mensajeria['valor'] ?>" name="mensajeria[]" class="ancho300es valor" />
                                            <select name="mensajeriaServicios[]" class="ancho85es">
                                                <?php
                                                foreach ($campos['mensajeria_e']['servicios'] as $llave => $valor) {
                                                    $selected = ($mensajeria['servicio_id'] == $llave) ? 'selected="selected"' : '';
                                                    ?>
                                                <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $valor ?></option>
                                                    <?php
                                                } ?>
                                            </select>
                                            <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="elemento">
                                        <input type="text" name="mensajeria[]" id="mensajeria" class="ancho300es valor" />
                                        <select name="mensajeriaServicios[]" class="ancho85es">
                                            <?php foreach ($campos['mensajeria_e']['servicios'] as $llave => $valor) { ?>
                                            <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                            <?php } ?>
                                        </select>
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="web">Sitio(s) web</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="url" name="web[]" class="ancho435es valor" />
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <?php
                                if (isset($contacto['web'])) {
                                    foreach ($contacto['web'] as $web) {
                                        ?>
                                        <div class="elemento">
                                            <input type="url" value="<?php echo $web['valor'] ?>" name="web[]" class="ancho435es valor" />
                                            <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="elemento">
                                        <input type="url" name="web[]" id="web" class="ancho435es valor" />
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="rsociales">Redes sociales</label></dt>
                        <dd>
                            <div class="elemento ejemplo">
                                <input type="text" name="rsociales[]" class="ancho300es valor" />
                                <select name="rsocialesServicios[]" class="ancho85es">
                                    <?php foreach ($campos['rsociales_e']['servicios'] as $llave => $valor) { ?>
                                    <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                    <?php } ?>
                                </select>
                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                <div class="clear"><!--vacio--></div>
                            </div>
                            <div class="listado">
                                <?php
                                if (isset($contacto['rsociales'])) {
                                    foreach ($contacto['rsociales'] as $rsociales) {
                                        ?>
                                        <div class="elemento">
                                            <input type="text" value="<?php echo $rsociales['valor'] ?>" name="rsociales[]" class="ancho300es valor" />
                                            <select name="rsocialesServicios[]" class="ancho85es">
                                                <?php
                                                foreach ($campos['rsociales_e']['servicios'] as $llave => $valor) {
                                                    $selected = ($rsociales['servicio_id'] == $llave) ? 'selected="selected"' : '';
                                                    ?>
                                                <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $valor ?></option>
                                                    <?php
                                                } ?>
                                            </select>
                                            <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="elemento">
                                        <input type="text" name="rsociales[]" id="rsociales" class="ancho300es valor" />
                                        <select name="rsocialesServicios[]" class="ancho85es">
                                            <?php foreach ($campos['rsociales_e']['servicios'] as $llave => $valor) { ?>
                                            <option value="<?php echo $llave ?>"><?php echo $valor ?></option>
                                            <?php } ?>
                                        </select>
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otro</a></div>
                        </dd>
                        <dt><label for="direccion">Dirección(es)</label></dt>
                        <dd class="elementoDireccion">
                            <div class="elemento ejemplo">
                                <div class="linea10"></div>
                                <div class="linea">
                                    <input type="text" name="direccion[]" class="ancho465es direccion valor" placeholder="Dirección" />
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
                                    <select name="pais[]" class="pais" style="width: 435px">
                                        <?php foreach($paises as $pais) { ?>
                                        <option value="<?php echo $pais['id'] ?>"><?php echo $pais['pais'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                            </div>
                            <div class="listado">
                                <?php
                                if (isset($contacto['direccion'])) {
                                    $i = 1;
                                    foreach ($contacto['direccion'] as $direccion) {
                                        ?>
                                        <div class="elemento">
                                            <?php if ($i > 1) { ?>
                                            <div class="linea10"></div>
                                            <?php } ?>
                                            <div class="linea">
                                                <input type="text" value="<?php echo $direccion['valor_text'] ?>" name="direccion[]" class="ancho465es direccion valor" placeholder="Dirección" />
                                                <div class="clear"><!--vacio--></div>
                                            </div>
                                            <div class="linea">
                                                <input type="text" value="<?php echo $direccion['ciudad'] ?>" name="ciudad[]" class="ancho465es ciudad" placeholder="Ciudad/población" />
                                                <div class="clear"><!--vacio--></div>
                                            </div>
                                            <div class="linea">
                                                <input type="text" value="<?php echo $direccion['estado'] ?>" name="estado[]" class="ancho300es estado" placeholder="Estado/departamento" />
                                                <div class="clear"><!--vacio--></div>
                                            </div>
                                            <div class="linea">
                                                <select name="pais[]" class="pais" style="width: 435px">
                                                    <?php
                                                    foreach($paises as $pais) {
                                                        $selected = ($direccion['pais_id'] == $pais['id']) ? 'selected="selected"' : '';
                                                        ?>
                                                    <option value="<?php echo $pais['id'] ?>" <?php echo $selected ?>><?php echo $pais['pais'] ?></option>
                                                        <?php
                                                    } ?>
                                                </select>
                                                <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                                <div class="clear"><!--vacio--></div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    ?>
                                    <div class="elemento">
                                        <div class="linea">
                                            <input type="text" name="direccion[]" id="direccion" class="ancho465es direccion valor" placeholder="Dirección" />
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
                                            <select name="pais[]" class="pais" style="width: 435px">
                                                <?php foreach($paises as $pais) { ?>
                                                <option value="<?php echo $pais['id'] ?>"><?php echo $pais['pais'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"><!--vacio--></div>
                            <div class="nuevo"><a href="javascript:;" class="fondoAzul">Agregar otra</a></div>
                        </dd>
                    </dl>
                    <div class="linea10"></div>
                    <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnSubmit">Guardar cambios</a>
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
        $("#btnSubmit").click(function() {
            $("#frmEditarContacto").submit();
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