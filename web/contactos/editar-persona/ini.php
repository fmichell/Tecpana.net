<?php
include '../../../app/inicio.php';
include SISTEMA_RAIZ . '/modelos/Persona.php';
include SISTEMA_RAIZ . '/modelos/Empresa.php';
include_once SISTEMA_RAIZ . '/modelos/CamposContacto.php';

// Obteniendo el id del contacto
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $contacto_id = $_GET['id'];
} else {
    header ('location: /contactos');
}

if (isset($_POST['submitForm']) and ($_POST['submitForm'] == 'editar')) {
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

    // Editamos contacto
    $resultado = Persona::editar(CUENTA_ID, $contacto_id, $_POST['nombre'], $_POST['apellidos'], $_POST['sexo'], $_POST['titulo'], $_POST['profesion'], $empresaId);
    $infos = Contacto::prepararInfo($_POST);

    if (!$resultado) {
        die('Ocurrio un error');
    } else {
        //$contacto_id = &$resultado;
        // Eliminamos la info existente
        $resultado = Contacto::eliminarInfoContacto(CUENTA_ID, $contacto_id);
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
}

// Obteniendo datos del contacto
$contacto = Contacto::obtener(CUENTA_ID, $contacto_id);
// Obteniendo datos laborales
if (!empty($contacto['empresa_id'])) {
    $empresa = Contacto::obtener(CUENTA_ID, $contacto['empresa_id']);
    $trabajo['empresa'] = $empresa['nombre_completo'];
    if (isset($contacto['cargo'])) {
        $cargo = current($contacto['cargo']);
        $trabajo['cargo'] = $cargo['valor'];
    }
}

// Obteniendo listas generales
$campos = CamposContacto::$tiposInfo;
$paises = CamposContacto::obtenerPaises();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar persona - <?php echo SISTEMA_NOMBRE ?></title>
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
                            <img src="/media/imgs/maleContact.jpg" alt="Hombre" id="picHombre" />
                            <img src="/media/imgs/famaleContact.jpg" alt="Mujer" id="picMujer" />
                            <a href="#">Subir foto</a>
                        </div>
                        <div class="floatLeft">
                            <input type="text" value="<?php echo $contacto['nombre'] ?>" class="bigText ancho465es" name="nombre" id="nombre" placeholder="Nombres" /><br />
                            <input type="text" value="<?php echo $contacto['apellidos'] ?>" class="bigText ancho465es" name="apellidos" id="apellidos" placeholder="Apellidos" /><br />
                            <select name="sexo" id="sexo" class="ancho85es">
                                <option value="1" <?php if ($contacto['sexo'] == 1) echo 'selected="selected"'; ?>>Hombre</option>
                                <option value="2" <?php if ($contacto['sexo'] == 2) echo 'selected="selected"'; ?>>Mujer</option>
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
                            <dd><input type="text" value="<?php echo $contacto['titulo'] ?>" name="titulo" id="titulo" class="ancho75es" /></dd>
                            <dt><label for="profesion">Profesión</label></dt>
                            <dd><input type="text" value="<?php echo $contacto['descripcion'] ?>" name="profesion" id="profesion" class="ancho465es" /></dd>
                            <dt><label for="empresa">Empresa</label></dt>
                            <dd>
                                <?php if (isset($trabajo)) { ?>
                                <input type="text" value="<?php echo $trabajo['empresa'] ?>" name="empresa" id="empresa" class="ancho465es" />
                                <input type="hidden" name="empresa_id" id="empresa_id" value="<?php echo $contacto['empresa_id'] ?>">
                                <?php } else { ?>
                                <input type="text" name="empresa" id="empresa" class="ancho465es" />
                                <input type="hidden" name="empresa_id" id="empresa_id" value="nueva">
                                <?php } ?>
                            </dd>
                        </dl>
                        <?php if (isset($trabajo)) { ?>
                        <dl class="horizontal" id="divCargo" style="">
                            <dt><label for="cargo">Cargo</label></dt>
                            <dd><input type="text" value="<?php if (isset($trabajo['cargo'])) echo $trabajo['cargo']; ?>" name="cargo" id="cargo" class="ancho465es" /></dd>
                        </dl>
                        <?php } else { ?>
                        <dl class="horizontal" id="divCargo" style="display: none">
                            <dt><label for="cargo">Cargo</label></dt>
                            <dd><input type="text" name="cargo" id="cargo" class="ancho465es" /></dd>
                        </dl>
                        <?php } ?>
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
                                    <?php
                                    // Mostramos valores de telefono si los hay
                                    if (isset($contacto['telefono'])) {
                                        foreach ($contacto['telefono'] as $telefono) {
                                            ?>
                                            <div class="elemento">
                                                <input type="tel" value="<?php echo $telefono['valor'] ?>" name="telefono[]" class="ancho300es valor" />
                                                <select name="telefonoModo[]" class="ancho85es">
                                                    <?php
                                                    foreach ($campos['telefono']['modo'] as $llave => $valor) {
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
                                                <?php foreach ($campos['telefono']['modo'] as $llave => $valor) { ?>
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
                                    <?php
                                    // Mostramos valores de email si los hay
                                    if (isset($contacto['email'])) {
                                        foreach ($contacto['email'] as $email) {
                                            ?>
                                            <div class="elemento">
                                                <input type="email" value="<?php echo $email['valor'] ?>" name="email[]" class="ancho300es valor" />
                                                <select name="emailModo[]" class="ancho85es">
                                                    <?php
                                                    foreach ($campos['email']['modo'] as $llave => $valor) {
                                                        $selected = ($email['modo_id'] == $llave) ? 'selected="selected"' : '';
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
                                            <input type="email" name="email[]" id="email" class="ancho300es valor" />
                                            <select name="emailModo[]" class="ancho85es">
                                                <?php foreach ($campos['email']['modo'] as $llave => $valor) { ?>
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
                                    <?php
                                    // Mostramos mensajeria si lo hay
                                    if (isset($contacto['mensajeria'])) {
                                        foreach ($contacto['mensajeria'] as $mensajeria) {
                                            ?>
                                            <div class="elemento">
                                                <input type="text" value="<?php echo $mensajeria['valor'] ?>" name="mensajeria[]" style="width:218px;" class="valor" />
                                                <select name="mensajeriaServicios[]" style="width:109px">
                                                    <?php
                                                    foreach ($campos['mensajeria']['servicios'] as $llave => $valor) {
                                                        $selected = ($mensajeria['servicio_id'] == $llave) ? 'selected="selected"' : '';
                                                        ?>
                                                    <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $valor ?></option>
                                                        <?php
                                                    } ?>
                                                </select>
                                                <select name="mensajeriaModo[]" class="ancho85es">
                                                    <?php
                                                    foreach ($campos['mensajeria']['modo'] as $llave => $valor) {
                                                        $selected = ($mensajeria['modo_id'] == $llave) ? 'selected="selected"' : '';
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
                                    <?php
                                    // Mostramos sitios webs si los hay
                                    if (isset($contacto['web'])) {
                                        foreach ($contacto['web'] as $web) {
                                            ?>
                                            <div class="elemento">
                                                <input type="url" value="<?php echo $web['valor'] ?>" name="web[]" class="ancho300es valor" />
                                                <select name="webModo[]" class="ancho85es">
                                                    <?php
                                                    foreach ($campos['web']['modo'] as $llave => $valor) {
                                                        $selected = ($web['modo_id'] == $llave) ? 'selected="selected"' : '';
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
                                            <input type="url" name="web[]" id="web" class="ancho300es valor" />
                                            <select name="webModo[]" class="ancho85es">
                                                <?php foreach ($campos['web']['modo'] as $llave => $valor) { ?>
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
                                    <?php
                                    // Mostramos redes sociales si las hay
                                    if (isset($contacto['rsociales'])) {
                                        foreach ($contacto['rsociales'] as $rsociales) {
                                            ?>
                                            <div class="elemento">
                                                <input type="text" value="<?php echo $rsociales['valor'] ?>" name="rsociales[]" style="width:218px;" class="valor" />
                                                <select name="rsocialesServicios[]" style="width:109px">
                                                    <?php
                                                    foreach ($campos['rsociales']['servicios'] as $llave => $valor) {
                                                        $selected = ($rsociales['servicio_id'] == $llave) ? 'selected="selected"' : '';
                                                        ?>
                                                    <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $valor ?></option>
                                                        <?php
                                                    } ?>
                                                </select>
                                                <select name="rsocialesModo[]" class="ancho85es">
                                                    <?php
                                                    foreach ($campos['rsociales']['modo'] as $llave => $valor) {
                                                        $selected = ($rsociales['modo_id'] == $llave) ? 'selected="selected"' : '';
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
                                    <?php
                                    // Mostramos direcciones si las hay
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
                                                    <select name="pais[]" class="pais" style="width: 334px">
                                                        <?php
                                                        foreach($paises as $pais) {
                                                            $selected = ($direccion['pais_id'] == $pais['id']) ? 'selected="selected"' : '';
                                                            ?>
                                                        <option value="<?php echo $pais['id'] ?>" <?php echo $selected ?>><?php echo $pais['pais'] ?></option>
                                                            <?php
                                                        } ?>
                                                    </select>
                                                    <select name="direccionModo[]" class="ancho85es">
                                                        <?php
                                                        foreach ($campos['direccion']['modo'] as $llave => $valor) {
                                                            $selected = ($direccion['modo_id'] == $llave) ? 'selected="selected"' : '';
                                                            ?>
                                                        <option value="<?php echo $llave ?>" <?php echo $selected ?>><?php echo $valor ?></option>
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
                        <a class="boton_gris floatLeft btnForm" href="javascript:;" id="btnCancelar">Cancelar</a>
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