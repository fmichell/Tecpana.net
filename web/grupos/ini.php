<?php
include '../../app/inicio.php';

// Obtenemos todos los contactos
$contactos = Contacto::obtenerTodos(CUENTA_ID);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Grupos - <?php echo SISTEMA_NOMBRE ?></title>
    <?php include '../includes/cabezera.php' ?>
</head>
<body>
<?php
// Cargamos la cabezera de la pagina
include '../includes/encabezado.php';
?>

<div class="mainWrapper">
    <!--MainWrapper begins-->
    <div id="MainWrapper">
        <?php
        // Cargamos el menu principal
        include '../includes/menu-principal.php';
        ?>

        <!--Content begins-->
        <section id="Content">
            <!--Workspace begins-->
            <section id="Workspace" class="colum">
                <!--Workspace Header begins-->
                <div class="workspaceHeader interior10">
                    <header>
                        <h1 class="floatLeft">Grupos</h1>
                        <div class="mainBoton"><a href="/contactos/agregar" class="botong botong_azul abrirDialog">Crear grupo</a></div>
                        <div class="linea20"></div>
                    </header>
                </div>
                <!--Workspace Header ends-->
                <!--Workspace Toolbar begins-->
                <div class="workspaceToolbar">
                    <div id="filtrar" class="btnsFiltro">
                        <div class="first selected">Todos</div>
                        <div>Personas</div>
                        <div>Empresas</div>
                        <div class="last">Grupos</div>
                    </div>
                </div>
                <!--Workspace Toolbar ends-->
                <!--Workspace Area begins-->
                <div class="workspaceArea interior10">
                    <div id="contactos" class="contactosIcons">
                        <!--Lista de contactos-->
                    </div>
                    <div id="grupos">
                        <!--Lista de contactos-->
                    </div>
                </div>
                <!--Workspace Area ends-->
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
include '../includes/pie.php';
?>
<script type="text/javascript">
var intervalo;
var tipo = 'todos';
var nombreBuscado = '';

function cargarContactos(filtroNombre, filtroTipo) {
    $('#contactos').fadeTo('fast', 0.10, function() {
        $('#contactos').load('/grupos/ajax/ajaxListarContactos.php', {'nombre':filtroNombre, 'tipo':filtroTipo}, function(respuesta, estado) {
            if (estado == 'success') {
                //Mostrando resultados
                $('#contactos').fadeTo("fast", 1);
            } else {
                alert('Ocurrió un error al cargar el listado')
            }
        });
    });
}
$(document).on("ready", function() {
    cargarContactos('', 'todos');
});
</script>
</body>
</html>