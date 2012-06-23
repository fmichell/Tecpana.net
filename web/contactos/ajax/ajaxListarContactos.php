<?php
/**
 * @autor: Federico Michell Vijil
 * @fechaCreacion: 22-Jun-12
 * @fechaModificacion: 22-Jun-12
 * @version: 1.0
 * @descripcion: Carga y filtra el listado de contactos.
 */
// Obtenemos todos los contactos
$contactos = Contacto::obtenerTodos(CUENTA_ID);

foreach ($contactos as $contactoId => $contacto) {
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
            $trabajo['cargo'] = $contacto['descripcion'];
        }
        if ($contacto['empresa_id']) {
            $trabajo['empresa'] = $contactos[$contacto['empresa_id']]['nombre_completo'];
        }
    }
?>
<article class="wCheckbox">
    <div class="contact">
        <div class="check colum"><input type="checkbox" class="check_contacto" /></div>
        <div class="userThumb colum">
            <a href="/contactos/<?php echo $contactoId ?>/info"><img src="/media/imgs/maleThumb.jpg" alt="Hombre" /></a>
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
        } elseif (isset($trabajo['cargo'])) {
            ?><div class="info colum"><?php echo $trabajo['cargo'] ?></div><?php
        } elseif (isset($trabajo['empresa'])) {
            ?><a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a><?php
        } ?>
        <div class="clear"><!--empty--></div>
    </div>
</article>
<?php
}
?>