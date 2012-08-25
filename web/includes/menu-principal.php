<?php
function activarMenu($seccion) {
    $url = $_SERVER['REQUEST_URI'];
    
    $posicion = strpos($url, $seccion);
    
    if ($posicion === 0) {
        echo 'class="activo"';
    }
}
?>
        <!--MainMenu begins-->
        <nav id="MainMenu">
            <ul>
                <?php //<li><a href="/"><span class="icono16 icono_inicio"><!--icono--></span>Bienvenido</a></li>-->?>
                <li><a <?php activarMenu('/contactos') ?> href="/contactos"><span class="icono16 icono_contacto"><!--icono--></span>Contactos</a></li>
                <?php //<li><a <?php activarMenu('/grupos')  href="/grupos"><span class="icono16 icono_grupos"><!--icono--></span>Grupos</a></li>?>
                <li><a <?php activarMenu('/tareas') ?> href="/tareas"><span class="icono16 icono_tareas"><!--icono--></span>Mis Tareas</a></li>
                <li><a <?php activarMenu('/proyectos') ?> href="/proyectos"><span class="icono16 icono_proyectos"><!--icono--></span>Proyectos</a></li>
            </ul>
        </nav>
        <!--MainMenu ends-->