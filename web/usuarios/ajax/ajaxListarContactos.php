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
include_once SISTEMA_RAIZ . '/modelos/Usuario.php';
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
                    <div class="detalle"><strong>Perfil:</strong> <span class="azul"><?php echo Usuario::$arrayPerfiles[$usuario['perfil_id']] ?></span></div>
                    <?php
                }
                ?>
            </div>
            <div class="info colum">
                <?php
                if ($vista == 'personas') {
                    if ($usuario) {
                        echo 'Usuario desde ' . mostrar_fecha($usuario['fecha_creacion'], 4, true);
                    } else {
                        ?><a href="javascript:;" class="boton_gris">Convertir en usuario</a><?php
                    }
                } else {
                    ?>
                    <div class="linea20">Usuario desde <?php echo mostrar_fecha($usuario['fecha_creacion'], 4, true); ?></div>
                    <div class="linea opcionesUsuario">
                        <a href="/usuarios/<?php echo $contactoId ?>/editar-perfil" data-tipo="editar">Editar perfil</a>,
                        <span class="rojo">
                            <a href="/usuarios/<?php echo $contactoId ?>/desactivar" class="rojo" data-tipo="desactivar">Desactivar usuario</a> ó
                            <a href="/usuarios/<?php echo $contactoId ?>/eliminar" class="rojo" data-tipo="eliminar">Eliminar usuario</a>
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
                        <img src="/media/imgs/check16x16.png" alt="Exito">
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