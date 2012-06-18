<?php
include '../../../app/inicio.php';

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $contacto_id = $_GET['id'];
} else {
    header ('location: /contactos');
}
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
                <form method="post" action="contacto_persona.html" name="frmAgregarContacto" id="frmAgregarContacto" class="frmContacto">
                    <!--Workspace Header begins-->
                    <div class="workspaceHeader interior10">
                        <div class="userPic">
                            <img src="/media/imgs/businessContact.jpg" alt="Empresa" id="picEmpresa" />
                            <a href="#">Subir foto</a>
                        </div>
                        <div class="floatLeft">
                            <input type="text" class="bigText ancho465es" placeholder="Nombre" id="nombre" /><br />
                            <input type="text" class="bigText ancho465es" placeholder="Razón Social" id="razon_social" /><br />
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
                            <dd><textarea type="text" name="giro" cols="10" rows="5" class="ancho465es"></textarea></dd>
                            <dt><label for="productos">Productos y/o servicios</label></dt>
                            <dd><textarea type="text" name="productos" cols="10" rows="5" class="ancho465es"></textarea></dd>
                            <dt><label for="telefono">Teléfono(s)</label></dt>
                            <dd>
                                <div class="elemento ejemplo">
                                    <input type="tel" name="telefono[]" class="ancho300es valor" />
                                    <select name="telefonoTipo[]" class="ancho85es">
                                        <option value="1" selected="selected">General</option>
                                        <option value="2">Móvil</option>
                                        <option value="3">Casa</option>
                                        <option value="4">Trabajo</option>
                                        <option value="5">Fax</option>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="listado">
                                    <div class="elemento">
                                        <input type="tel" name="telefono[]" class="ancho300es valor" />
                                        <select name="telefonoTipo[]" class="ancho85es">
                                            <option value="1" selected="selected">General</option>
                                            <option value="2">Móvil</option>
                                            <option value="3">Casa</option>
                                            <option value="4">Trabajo</option>
                                            <option value="5">Fax</option>
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
                                    <select name="emailTipo[]" class="ancho85es">
                                        <option value="1" selected="selected">General</option>
                                        <option value="2">Trabajo</option>
                                        <option value="3">Personal</option>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="listado">
                                    <div class="elemento">
                                        <input type="email" name="email[]" class="ancho300es valor" />
                                        <select name="emailTipo[]" class="ancho85es">
                                            <option value="1" selected="selected">General</option>
                                            <option value="2">Trabajo</option>
                                            <option value="3">Personal</option>
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
                                    <select name="mensajeriaModo[]" style="width:109px">
                                        <option value="1" selected="selected">MSN</option>
                                        <option value="2">Skype</option>
                                        <option value="3">GoogleTalk</option>
                                        <option value="4">Yahoo</option>
                                        <option value="5">AIM</option>
                                        <option value="6">ICQ</option>
                                        <option value="7">Jabber</option>
                                    </select>
                                    <select name="mensajeriaTipo[]" class="ancho85es">
                                        <option value="1" selected="selected">General</option>
                                        <option value="2">Trabajo</option>
                                        <option value="3">Personal</option>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                
                                <div class="listado">
                                    <div class="elemento">
                                        <input type="text" name="mensajeria[]" style="width:218px;" class="valor" />
                                        <select name="mensajeriaModo[]" style="width:109px">
                                            <option value="1" selected="selected">MSN</option>
                                            <option value="2">Skype</option>
                                            <option value="3">GoogleTalk</option>
                                            <option value="4">Yahoo</option>
                                            <option value="5">AIM</option>
                                            <option value="6">ICQ</option>
                                            <option value="7">Jabber</option>
                                        </select>
                                        <select name="mensajeriaTipo[]" class="ancho85es">
                                            <option value="1" selected="selected">General</option>
                                            <option value="2">Trabajo</option>
                                            <option value="3">Personal</option>
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
                                    <select name="webTipo[]" class="ancho85es">
                                        <option value="1" selected="selected">General</option>
                                        <option value="2">Trabajo</option>
                                        <option value="3">Personal</option>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="listado">
                                    <div class="elemento">
                                        <input type="url" name="web[]" class="ancho300es valor" />
                                        <select name="webTipo[]" class="ancho85es">
                                            <option value="1" selected="selected">General</option>
                                            <option value="2">Trabajo</option>
                                            <option value="3">Personal</option>
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
                                    <select name="rsocialesModo[]" style="width:109px">
                                        <option value="1" selected="selected">Facebook</option>
                                        <option value="2">Twitter</option>
                                        <option value="3">Google+</option>
                                    </select>
                                    <select name="rsocialesTipo[]" class="ancho85es">
                                        <option value="1" selected="selected">General</option>
                                        <option value="2">Trabajo</option>
                                        <option value="3">Personal</option>
                                    </select>
                                    <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                    <div class="clear"><!--vacio--></div>
                                </div>
                                <div class="listado">
                                    <div class="elemento">
                                        <input type="text" name="rsociales[]" style="width:218px;" class="valor" />
                                        <select name="rsocialesModo[]" style="width:109px">
                                            <option value="1" selected="selected">Facebook</option>
                                            <option value="2">Twitter</option>
                                            <option value="3">Google+</option>
                                        </select>
                                        <select name="rsocialesTipo[]" class="ancho85es">
                                            <option value="1" selected="selected">General</option>
                                            <option value="2">Trabajo</option>
                                            <option value="3">Personal</option>
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
                                    <div class="linea">
                                        <input type="text" name="direccion[]" class="ancho465es direccion valor" placeholder="Dirección" />
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <div class="linea">
                                        <input type="text" name="ciudad[]" class="ancho465es ciudad" placeholder="Ciudad/población" />
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                    <div class="linea">
                                        <input type="text" name="barrio[]" class="ancho300es barrio" placeholder="Barrio/vecindario" />
                                        <select name="direccionTipo[]" class="ancho85es">
                                            <option value="1" selected="selected">General</option>
                                            <option value="2">Trabajo</option>
                                            <option value="3">Personal</option>
                                        </select>
                                        <a href="javascript:;" class="botonCerrarGris eliminar"><!--cerrar--></a>
                                        <div class="clear"><!--vacio--></div>
                                    </div>
                                </div>
                                <div class="listado">
                                    <div class="elemento">
                                        <div class="linea">
                                            <input type="text" name="direccion[]" class="ancho465es direccion valor" placeholder="Dirección" />
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <div class="linea">
                                            <input type="text" name="ciudad[]" class="ancho465es ciudad" placeholder="Ciudad/población" />
                                            <div class="clear"><!--vacio--></div>
                                        </div>
                                        <div class="linea">
                                            <input type="text" name="barrio[]" class="ancho300es barrio" placeholder="Barrio/vecindario" />
                                            <select name="direccionTipo[]" class="ancho85es">
                                                <option value="1" selected="selected">General</option>
                                                <option value="2">Trabajo</option>
                                                <option value="3">Personal</option>
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
                        <a class="boton_gris floatLeft btnForm" href="#">Agregar Contacto</a>
                        <a class="boton_gris floatLeft btnForm" href="#">Cancelar</a>
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
</body>
</html>