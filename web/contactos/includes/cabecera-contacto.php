<?php
/**
 * @autor: Federico
 * @fechaCreacion: 08-24-12
 * @fechaModificacion: 08-24-12
 * @version: 1.0
 * @descripcion: Cabecera de las pantallas de la sección de contactos. Se muestra la foto del usuario, su nombre,
 *               cargo y etiquetas.
 */
?>
<div class="userPic"><img src="<?php echo $fotoPerfil['uriProfile'] ?>" alt="<?php echo $contacto['nombre_completo'] ?>" /></div>
<div class="floatLeft infoContacto">
    <h1><?php echo $contacto['nombre_completo'] ?></h1>
    <?php if (!empty($contacto['descripcion'])) { ?>
    <div class="linea5"></div>
    <h2 class="subtitulo"><?php echo $contacto['descripcion'] ?></h2>
    <?php } ?>
    <?php if (isset($trabajo['cargo']) and isset($trabajo['empresa'])) { ?>
    <div class="linea5"></div>
    <h2 class="subtitulo"><?php echo $trabajo['cargo'] ?> en <a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a></h2>
    <?php } elseif (isset($trabajo['empresa'])) { ?>
    <div class="linea5"></div>
    <h2 class="subtitulo">Trabaja en <a href="/contactos/<?php echo $contacto['empresa_id'] ?>/info"><?php echo $trabajo['empresa'] ?></a></h2>
    <?php } ?>

    <!--Etiquetas-->
    <div class="etiquetasContacto">
        <ul>
            <?php
            if (!empty($etiquetas)) {
                foreach ($etiquetas as $etiquetaId => $etiqueta) {
                    ?>
                    <li><a href="/contactos/etiqueta/<?php echo $etiqueta['etiqueta_seo'] ?>"
                           data-etiqueta="<?php echo $etiqueta['etiqueta_id'] ?>"
                           data-contacto="<?php echo $contacto_id ?>">
                        <?php echo $etiqueta['etiqueta'] ?>
                    </a>,
                    </li><?php
                }
            } ?>
            <li><a href="javascript:;" class="gris" id="editarEtiquetas">
                <?php echo (empty($etiquetas)) ? 'Agregar etiquetas' : 'Editar etiquetas'; ?>
            </a>
            </li>
        </ul>
        <div class="agregarEtiqueta" style="display: none">
            <label for="valEtiqueta">Agregar una nueva etiqueta:</label>
            <input type="text" name="valEtiqueta" id="valEtiqueta" />
            <input type="hidden" name="etiqueta_id" id="etiqueta_id" value="nueva">
            <a href="javascript:;" class="boton_gris" id="addEtiqueta" rel="<?php echo $contacto_id ?>">Agregar etiqueta</a>
            <a href="javascript:;" class="boton_gris" id="cancelEtiquetas">Cerrar</a>
        </div>
    </div>
</div>

