<?php
/**
 * @autor: Federico
 * @fechaCreacion: 08-24-12
 * @fechaModificacion: 08-24-12
 * @version: 1.0
 * @descripcion: Opciones de menu dispobles para el usuario
 *               Se muestra en /contactos/info, /contactos/perfil, contactos/tareas, /contactos/comentarios
 */
?>
<div class="opciones">
    <ul>
        <li><a <?php if ($subMenu == 'info') echo 'class="activo"'; ?> href="/contactos/<?php echo $contacto_id ?>/info">Información del contacto</a></li>
        <?php if ($_SESSION['USUARIO_ID'] == $contacto_id) { // Opción solo disponible para el propio usuario ?>
        <li><a <?php if ($subMenu == 'perf') echo 'class="activo"'; ?> href="/contactos/<?php echo $contacto_id ?>/perfil">Perfil</a></li>
        <?php } ?>
        <?php if ($contacto['tipo'] == 1) { // Opción solo disponible para personas ?>
        <li><a <?php if ($subMenu == 'tare') echo 'class="activo"'; ?> href="/contactos/<?php echo $contacto_id ?>/tareas">Tareas Pendientes</a></li>
        <?php } ?>
        <li><a <?php if ($subMenu == 'come') echo 'class="activo"'; ?> href="/contactos/<?php echo $contacto_id ?>/comentarios">Comentarios</a></li>
    </ul>
</div>