<?php
/**
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 02-Jul-12
 * @fechaModificacion: 02-Jul-12
 * @version: 1.0
 * @descripcion: Carga y filtra el listado de contactos.
 */
include_once '../../../app/inicio.php';
// Cargamos a todos los contactos en un arraglo independiente
// a los resultados de filtros o busquedas para que sirva de helper
$listaContactos = Contacto::obtenerTodosSinInfo(CUENTA_ID);

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
            default:
                break;
        }
    }
}
// Obtenemos resultado
$contactos = $tabla->obtener();

foreach ($contactos as $contactoId => $contacto) {
    $contactoId = $contacto['contacto_id'];
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
    ?>
<a href="/contactos/<?php echo $contactoId ?>/info" class="contacto">
    <div class="userThumb floatLeft"><img src="<?php echo $thumbnail['uri'] ?>" alt="<?php echo $thumbnail['alt'] ?>" /></div>
    <div class="nombre"><?php echo $contacto['nombre_completo'] ?></div>
</a>
<?php
}
?>
<div class="clear"><!--empy--></div>