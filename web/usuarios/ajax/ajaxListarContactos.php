<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 29-Jul-12
 * @fechaModificacion: 29-Jul-12
 * @version: 1.0
 * @descripcion: Carga y filtra el listado de usuarios y personas.
 */
include_once '../../../app/inicio.php';
include_once SISTEMA_RAIZ . '/modelos/Persona.php';
// Cargamos a todos los contactos en un arraglo independiente
// a los resultados de filtros o busquedas para que sirva de helper
$listaContactos = Contacto::obtenerTodosSinInfo(CUENTA_ID);
$usuarios = Usuario::obtenerTodos(CUENTA_ID);

$vista = 'personas';

if (isset($_POST['nombre']) and !empty($_POST['nombre'])) {
    // Obtenemos los contactos filtrados
    $contactos = Contacto::buscar(CUENTA_ID, $_POST['nombre']);
    $tabla = new Tabla($contactos);
} else {
    // Obtenemos todas las personas
    $contactos = Persona::obtenerPersonas(CUENTA_ID);

    // Filtramos por tipo
    if (isset($_POST['tipo']) and ($_POST['tipo'] == 'usuarios')) {
        $vista = 'usuarios';
        $contactos = array_intersect_key($contactos, $usuarios);
    }

    // Creamos objeto tabla y aplicamos filtros
    $tabla = new Tabla($contactos);
}
// Obtenemos resultado
$contactos = $tabla->obtener();

// Paginamos
$contactosXPagina = 15;
if (isset($_POST['pagina']) and !empty($_POST['pagina'])) {
    $pagina = $_POST['pagina'];
    $posicion =  ($pagina - 1) * $contactosXPagina;
} else {
    $pagina = 1;
    $posicion = 0;
}
$totalContactos = $tabla->obtenerCantidad();
// Calculando ultima pagina
$ultimaPagina = ceil($totalContactos/$contactosXPagina);
// Limitando resultados
$tabla->limitar($posicion, $contactosXPagina);
// Obtenemos resultado
$contactos = $tabla->obtener();

// Obtenemos el ultimo elemento para luego aplicarle la clase CSS last-child
$ultimo = end($contactos); $last_child = null;

// Declaramos objeto fecha
$fecha = new Fecha();

foreach ($contactos as $contactoId => $contacto) {
    $contactoId = $contacto['contacto_id'];
    if (isset($usuarios[$contactoId]))
        $usuario = $usuarios[$contactoId];
    else
        $usuario = null;

    // Obtenemos info del contacto
    $infos = $trabajo = array();
    if ($contacto['descripcion']) {
        $trabajo['profesion'] = $contacto['descripcion'];
    }
    if ($contacto['empresa_id']) {
        $trabajo['empresa'] = $listaContactos[$contacto['empresa_id']]['nombre_completo'];
    }
    if (isset($contacto['cargo'])) {
        $cargo = current($contacto['cargo']);
        $trabajo['cargo'] = $cargo['valor'];
    }

    // Obtenemos foto de perfil
    $fotoPerfil = Contacto::obtenerFotos($contacto['foto'], $contacto['tipo'], $contacto['sexo']);

    // Si es el ultimo elemento, agregamos la class CSS last-child al elemento article
    if ($contactoId == $ultimo['contacto_id']) {
        $last_child = 'last-child';
    }

    // Mostramos a los contactos
    ?>
    <article class="<?php echo $last_child ?>">
        <div class="contact">
            <div class="userThumb colum">
                <a href="/contactos/<?php echo $contactoId ?>/info"><img src="<?php echo $fotoPerfil['uriThumbnail'] ?>" alt="<?php echo $contacto['nombre_completo'] ?>" /></a>
            </div>
            <div class="desc colum">
                <div class="nombre"><a href="/contactos/<?php echo $contactoId ?>/info"><?php echo $contacto['nombre_completo'] ?></a></div>
                <?php
                // Mostrando info de trabajo (solo personas)
                if (isset($trabajo['cargo']) and isset($trabajo['empresa'])) {
                    ?>
                    <div class="detalle">
                        <?php echo $trabajo['cargo'] ?> en <a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a>
                    </div>
                    <?php
                } elseif (isset($trabajo['empresa'])) {
                    ?>
                    <div class="detalle">
                        <a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a>
                    </div>
                    <?php
                } elseif (isset($trabajo['profesion'])) {
                    ?><div class="detalle"><?php echo $trabajo['profesion'] ?></div><?php
                }
                // Mostrando el perfil del usuario
                if ($vista == 'usuarios') {
                    ?>
                    <div class="detalle">
                        <strong>Estado:</strong> <span class="azul"><?php echo Usuario::$arrayEstados[$usuario['estado']] ?></span>
                        <strong>Perfil:</strong> <span class="azul"><?php echo Usuario::$arrayPerfiles[$usuario['perfil_id']] ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="info colum" data-usuario="<?php echo $contactoId ?>">
                <?php
                if ($vista == 'personas') {
                    if ($usuario) {
                        ?><div class="linea20">Usuario desde <?php echo $fecha->mostrar($usuario['fecha_creacion'], 2, '+hora'); ?></div><?php
                    } else {
                        ?>
                        <a href="/usuarios/<?php echo $contactoId ?>/convertir-contacto" class="boton_gris convertir-contacto">Convertir en usuario</a>
                        <div class="linea perfiles">
                            <select class="selectorPerfil">
                                <option value="" selected="selected">Seleccione un perfil</option>
                                <?php
                                foreach(Usuario::$arrayPerfiles as $id => $perfil) {
                                    ?><option value="<?php echo $id ?>"><?php echo $perfil ?></option><?php
                                }
                                ?>
                            </select>
                            <img src="/media/imgs/check16x16.png" alt="Exito" class="icono-exito" style="display: none;">
                            <img src="/media/imgs/close16x16.png" alt="Cancelar" class="icono-cancelar" title="Cerrar">
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="linea20">Usuario desde <?php echo $fecha->mostrar($usuario['fecha_creacion'], 2, '+hora'); ?></div>
                    <div class="linea opcionesUsuario">
                        <a href="/usuarios/<?php echo $contactoId ?>/editar-perfil" class="editar-perfil">Editar perfil</a>,
                        <?php if ($usuario['estado'] == 1) { ?>
                        <a href="/usuarios/<?php echo $contactoId ?>/desactivar" class="rojo editar-estado" data-optn="desactivar">Desactivar usuario</a>
                        <?php } elseif ($usuario['estado'] == 2) { ?>
                        <a href="/usuarios/<?php echo $contactoId ?>/activar" class="editar-estado" data-optn="activar">Activar usuario</a>
                        <?php } ?>
                        <span class="rojo"> ó
                            <a href="/usuarios/<?php echo $contactoId ?>/eliminar" class="rojo editar-estado" data-optn="eliminar">Eliminar usuario</a>
                        </span>
                    </div>
                    <div class="linea perfiles">
                        <select class="selectorPerfil">
                            <?php
                            foreach(Usuario::$arrayPerfiles as $id => $perfil) {
                                $selected = ($id == $usuario['perfil_id']) ? 'selected="selected"' : '';
                                ?><option value="<?php echo $id ?>" <?php echo $selected ?>><?php echo $perfil ?></option><?php
                            }
                            ?>
                        </select>
                        <img src="/media/imgs/check16x16.png" alt="Exito" class="icono-exito" style="display: none;">
                        <img src="/media/imgs/close16x16.png" alt="Cancelar" class="icono-cancelar" title="Cerrar">
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear"><!--empty--></div>
        </div>
    </article>
    <?php
}
if (empty($contactos)) {
    ?>
    <div class="alertMessage info">No se encontraron más contactos</div>
    <?php
}
// Si es la ultima pagina se carga este div
if ( ($pagina == $ultimaPagina) or (empty($contactos)) ) { ?><div class="ultimaPagina"><!--Ultima pagina--></div><?php }
die();
?>