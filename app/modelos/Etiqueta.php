<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 07-23-12
 * @fechaModificacion: 07-23-12
 * @version: 1.0
 * @descripcion: Clase etiquetas
 */
class Etiqueta
{
    static public function crearEtiqueta ($cuentaId, $etiqueta)
    {
        // Definimos variables generales
        $ahora      = Fecha::obtenerFechaSQL();

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

    static public function obtenerEtiquetas ($cuentaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('etiqueta_id, etiqueta_seo, etiqueta', 'etiquetas')->donde(array('cuenta_id:entero' => $cuentaId));

        return $bd->obtener(null, 'etiqueta_id');
    }

    static public function obtenerEtiquetaSeo ($cuentaId, $etiquetaSeo)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('etiqueta_id, etiqueta', 'etiquetas')->donde(array(
                                                            'cuenta_id:entero' => $cuentaId,
                                                            'etiqueta_seo:texto' => $etiquetaSeo));
        return $bd->obtenerFila();
    }

    static public function sugerir ($cuentaId, $etiqueta = null)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Declaramos arraglo de filtros
        $filtros = array();

        // Generamos filtro cuenta_id y tipo
        $filtros[] = 'cuenta_id = ' . $bd->escaparValor($cuentaId, 'entero');

        // Filtramos por nombre
        if (empty($etiqueta)) {
            return null;
        } else {
            $etiqueta = trim($etiqueta);
            $narray = explode(' ', $etiqueta);
            foreach ($narray as $indice => $valor) {
                $narray[$indice] = '+' . $bd->escaparValor($valor) . '*';
            }
            $etiquetaFormatiada = implode(' ', $narray);
            $filtros[] = sprintf('MATCH (etiqueta) AGAINST (%s IN BOOLEAN MODE)',
                $bd->escaparValor($etiquetaFormatiada, 'texto'));
        }

        // Generamos filtro
        $filtros = implode(' AND ', $filtros);

        // Generamos consulta
        $consulta = sprintf("SELECT etiqueta_id AS id, etiqueta AS label, etiqueta AS value
                             FROM etiquetas WHERE %s",
            $filtros);

        return $bd->obtener($consulta, 'etiqueta_id');
    }

    static public function obtenerPorLetras ($cuentaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $consulta = sprintf('SELECT etiquetas.etiqueta_id, etiquetas.etiqueta_seo, etiquetas.etiqueta
                             FROM etiquetas INNER JOIN contactos_etiquetas ON etiquetas.etiqueta_id = contactos_etiquetas.etiqueta_id
                             WHERE etiquetas.cuenta_id = %u AND contactos_etiquetas.cuenta_id = %u
                             GROUP BY etiqueta_id, etiqueta_seo, etiqueta
                             ORDER BY etiqueta',
                            $bd->escaparValor($cuentaId, 'entero'),
                            $bd->escaparValor($cuentaId, 'entero'));

        $etiquetas = $bd->obtener($consulta, 'etiqueta_id');

        // Agrupamos las etiquetas por la letra inicial
        $retorno = array();
        foreach ($etiquetas as $etiqueta) {
            $letraInicio = substr($etiqueta['etiqueta'], 0, 1);
            $letraInicio = strtoupper($letraInicio);

            $retorno[$letraInicio][] = $etiqueta;
        }

        return $retorno;
    }
}