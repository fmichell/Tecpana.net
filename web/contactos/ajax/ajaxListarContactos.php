<?php
/**
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 22-Jun-12
 * @fechaModificacion: 27-Jun-12
 * @version: 1.0
 * @descripcion: Carga y filtra el listado de contactos.
 */
include_once '../../../app/inicio.php';
// Cargamos a todos los contactos en un arraglo independiente
// a los resultados de filtros o busquedas para que sirva de helper
$listaContactos = Contacto::obtenerTodosSinInfo(CUENTA_ID);

// Definimos vista
if ((isset($_POST['vista'])) and ($_POST['vista'] == 'iconos')) {
    $vista = 'iconos';
} else {
    $vista = 'lista';
}

if (isset($_POST['nombre']) and !empty($_POST['nombre'])) {
    // Obtenemos los contactos filtrados
    $contactos = Contacto::buscar(CUENTA_ID, $_POST['nombre']);
    $tabla = new Tabla($contactos);
} else {
    // Obtenemos todos los contactos
    $contactos = Contacto::obtenerTodos(CUENTA_ID);
    // Creamos objeto tabla y aplicamos filtros
    $tabla = new Tabla($contactos);
    if (isset($_POST['tipo']) and !empty($_POST['tipo'])) {
        switch ($_POST['tipo']) {
            case 'todos':
                break;
            case 'personas':
                $tabla->filtrar('{tipo} = 1');
                break;
            case 'empresas':
                $tabla->filtrar('{tipo} = 2');
                break;
            case 'grupos':
                break;
            default:
                break;
        }
    }
}
// Obtenemos resultado
$contactos = $tabla->obtener();

// Paginamos
$contactosXPagina = ($vista == 'iconos') ? 50 : 15;
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
    // Obtenemos info del contacto
    $infos = $trabajo = array();
    if (isset($contacto['telefono'])) {
        $telefono = current($contacto['telefono']);
        $infos['telefono'] = $telefono['valor'];
    }
    if (isset($contacto['email'])) {
        $email = current($contacto['email']);
        $infos['email'] = $email['valor'];
    }
    if (isset($contacto['web'])) {
        $web = current($contacto['web']);
        $infos['web'] = $web['valor'];
    }
    if ($contacto['tipo'] == 1) {
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
    }

    // Obtenemos foto de perfil
    // TODO: Agregar foto del contacto
    $thumbnail = array('uri' => '/media/imgs/maleThumb.jpg', 'alt' => $contacto['nombre_completo']);
    if ($contacto['tipo'] == 1) {
        // Si es persona
        if ($contacto['sexo'] == 1) {
            // Si es hombre
            $thumbnail['uri'] = '/media/imgs/maleThumb.jpg';
        } else {
            // Si es mujer
            $thumbnail['uri'] = '/media/imgs/famaleThumb.jpg';
        }
    } elseif ($contacto['tipo'] == 2) {
        // Si es empresa
        $thumbnail['uri'] = '/media/imgs/businessThumb.jpg';
    }

    // Si es el ultimo elemento, agregamos la class CSS last-child al elemento article
    if ($contactoId == $ultimo['contacto_id']) {
        $last_child = 'last-child';
    }

    // Mostramos a los contactos
    if ($vista == 'iconos') {
        ?>
        <a href="/contactos/<?php echo $contactoId ?>/info" class="contacto">
            <div class="userThumb floatLeft"><img src="<?php echo $thumbnail['uri'] ?>" alt="<?php echo $thumbnail['alt'] ?>" /></div>
            <div class="nombre"><?php echo $contacto['nombre_completo'] ?></div>
        </a>
        <?php
    } elseif ($vista == 'lista') {
        ?>
        <article class="wCheckbox <?php echo $last_child ?>">
            <div class="contact">
                <div class="check colum"><input type="checkbox" class="check_contacto" /></div>
                <div class="userThumb colum">
                    <a href="/contactos/<?php echo $contactoId ?>/info"><img src="<?php echo $thumbnail['uri'] ?>" alt="<?php echo $thumbnail['alt'] ?>" /></a>
               </div>
                <div class="desc colum">
                    <div class="nombre"><a href="/contactos/<?php echo $contactoId ?>/info"><?php echo $contacto['nombre_completo'] ?></a></div>
                    <?php
                    $i = 1;
                    foreach ($infos as $tipo => $info) {
                        if ($tipo == 'telefono') {
                            ?><div class="detalle">Tel: <?php echo $info ?></div><?php
                        } elseif ($tipo == 'email') {
                            ?><div class="detalle"><a href="mailto:<?php echo $info ?>">Email: <?php echo $info ?></a></div><?php
                        } elseif ($tipo == 'web') {
                            ?><div class="detalle"><a href="<?php echo $info ?>" target="_blank">Web: <?php echo $info ?></a></div><?php
                        }

                        if ($i >= 2) break;

                        $i++;
                    } ?>
                </div>

                <?php
                // Mostrando info de trabajo (solo personas)
                if (isset($trabajo['cargo']) and isset($trabajo['empresa'])) {
                    ?>
                    <div class="info colum">
                        <?php echo $trabajo['cargo'] ?> en <a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a>
                    </div>
                    <?php
                } elseif (isset($trabajo['empresa'])) {
                    ?>
                    <div class="info colum">
                        <a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a>
                    </div>
                    <?php
                } elseif (isset($trabajo['profesion'])) {
                    ?><div class="info colum"><?php echo $trabajo['profesion'] ?></div><?php
                } ?>
                <div class="clear"><!--empty--></div>
            </div>
        </article>
        <?php
    }
}
// Si es una vista de iconos agregamos clear al final de cada pagina
if ($vista == 'iconos') { ?><div class="clear"><!--empty--></div><?php }
// Si es la ultima pagina se carga este div
if ($pagina == $ultimaPagina) { ?><div class="ultimaPagina"><!--Ultima pagina--></div><?php }
?>