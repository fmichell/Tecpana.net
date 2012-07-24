<?php
/**
 * @autor: Federico
 * @fechaCreacion: 07-23-12
 * @fechaModificacion: 07-23-12
 * @version: 1.0
 * @descripcion:
 */
class Etiqueta
{
    static public function crearEtiqueta ($cuentaId, $etiqueta)
    {
        // Definimos variables generales
        $ahora      = date('Y-m-d H:i:s');

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Preparamos etiqueta SEO
        $etiquetaSEO = util_preparar_var($etiqueta, 'seo');

        // Iniciamos consulta
        $bd->insertar('etiquetas', array(
                      'cuenta_id:entero'            => $cuentaId,
                      'etiqueta_seo:texto'          => $etiquetaSEO,
                      'etiqueta:texto'              => $etiqueta,
                      'fecha_creacion:fecha'        => $ahora,
                      'fecha_modificacion:fecha'    => $ahora));

        $resultado = $bd->ejecutar();

        if ($resultado)
            return $bd->obtenerUltimoId();
        else
            return $resultado;
    }

    static public function agregarEtiqueta ($cuentaId, $contactoId, $etiquetaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $consulta = sprintf('INSERT IGNORE INTO contactos_etiquetas (cuenta_id, contacto_id, etiqueta_id) VALUES (%u, %s, %u)',
                            $bd->escaparValor($cuentaId, 'entro'),
                            $bd->escaparValor($contactoId, 'texto'),
                            $bd->escaparValor($etiquetaId, 'entero'));
        return $bd->ejecutar($consulta);
    }

    static public function obtenerEtiquetasContactoFull ($cuentaId, $contactoId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $consulta = sprintf('SELECT etiquetas.etiqueta_id, etiquetas.etiqueta_seo, etiquetas.etiqueta
                             FROM contactos_etiquetas USE INDEX (POR_CONTACTO) INNER JOIN etiquetas ON contactos_etiquetas.etiqueta_id = etiquetas.etiqueta_id
                             WHERE contactos_etiquetas.cuenta_id = %u AND contactos_etiquetas.contacto_id = %s',
                            $bd->escaparValor($cuentaId, 'entero'),
                            $bd->escaparValor($contactoId, 'texto'));

        return $bd->obtener($consulta, 'etiqueta_id');
    }

    static public function obtenerEtiquetasContacto ($cuentaId, $contactoId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $consulta = sprintf('SELECT etiqueta_id FROM contactos_etiquetas USE INDEX (POR_CONTACTO) WHERE cuenta_id = %u AND contacto_id = %s',
                            $bd->escaparValor($cuentaId, 'entero'),
                            $bd->escaparValor($contactoId, 'texto'));


        return $bd->obtener($consulta, 'etiqueta_id');
    }

    static public function obtenerEtiquetas ($cuentaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('etiqueta_id, etiqueta_seo, etiqueta', 'etiquetas')->donde(array('cuenta_id:entero' => $cuentaId));

        return $bd->obtener(null, 'etiqueta_id');
    }
}