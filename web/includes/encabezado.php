    <!--Header begins-->
    <header id="HeaderWrapper" class="mainWrapper">
        <div id="Logo">
            <h1><a href="/" title="ir a inicio"><?php echo $_SESSION['SUBDOMINIO'] ?>.<span>tecpana</span>.net</a></h1>
        </div>
        <div id="HeaderMenu">
            <ul>
                <li id="hm_trigger_element">
                    <div id="hm_trigger">Bienvenido <?php echo $_SESSION['USUARIO_NOMBRE'] ?></div>
                    <div id="SettingsMenu" class="interior10">
                        <ul>
                            <li><a href="/contactos/<?php echo $_SESSION['USUARIO_ID'] ?>/info" id="prueba">Mi Perfil</a></li>
                            <li><a href="/usuarios">Usuarios</a></li>
                            <li><a href="#">Configuración</a></li>
                            <li class="separador" style="margin: 3px 0"><!--separador--></li>
                            <li><a href="/login/logout">Salir</a></li>
                        </ul>
                    </div>
                </li>
                <li><div class="divisor"><!--divisor--></div></li>
                <li><a href="#">Ayuda</a></li>
            </ul>
        </div>
    </header>
    <!--Header ends-->