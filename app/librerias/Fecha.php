<?php
/**
 * @name Manejador de Fechas
 * @author Nestor Picado
 * @copyright Nestor Picado Rivera
 * @version 1.0
 **/
class Fecha extends DateTime
{
    /*
     * Retorna la fecha actual en formato para MYSQL
     *
     * @param bool $sinUTC
     * @param bool $conHora
     * @return string
     */
    static public function obtenerFechaSQL ($sinUTC = false, $conHora = true)
    {
        if ($sinUTC) {
            if ($conHora)
                return date('Y-m-d H:i:s');
            else
                return date('Y-m-d');
        } else {
            if ($conHora)
                return gmdate('Y-m-d H:i:s');
            else
                return gmdate('Y-m-d');
        }
    }

    /*
     * Obtiene una marca de tiempo Unix para una fecha SQL específica
     *
     * @param string $fechaSQL
     * @param bool $sinUTC
     * @return int
     */
    static public function obtenerMarcaUnix ($fechaSQL, $sinUTC = false)
    {
        // Separamos la fecha de la hora
        list($fecha, $hora) = explode(' ', $fechaSQL);
        // Separamos los elementos de la fecha
        list($ano, $mes, $dia) = explode('-', $fecha);
        // Separamos los elementos de la hora
        list($hora, $minutos, $segundos) = explode(':', $hora);

        // Generamos la marca de tiempo Unix
        if ($sinUTC)
            $marca = mktime($hora, $minutos, $segundos, $mes, $dia, $ano);
        else
            $marca = gmmktime($hora, $minutos, $segundos, $mes, $dia, $ano);

        // Retornamos fecha
        return $marca;
    }

    /**
     * Obtiene la fecha en el formato deseado
     *
     * @param string $fecha
     * @param int $tipo
     * @param string $opciones
     * @param bool $sinUTC
     * @return string
     */
    public function mostrar ($fecha = null, $tipo = 1, $opciones = '', $sinUTC = false)
    {
        if (is_null($fecha)) {
            $fecha = self::obtenerFechaSQL($sinUTC);
            $fecha = self::obtenerMarcaUnix($fecha, true);
        } else {
            $fecha = self::obtenerMarcaUnix($fecha, $sinUTC);
        }

        $this->setTimestamp($fecha);

        if ( strpos($opciones, 'ncorto') === false ) {
            $dias   = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
            $meses  = array(null,'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        } else {
            $dias   = array('Dom','Lun','Mar','Mié','Jue','Vie','Sáb');
            $meses  = array(null,'Ene','Feb','Mar','Abr','May','Juno','Jul','Ago','Sep','Oct','Nov','Dic');
        }
        if ( strpos($opciones, '+hora') === false ) {
            $hora   = '';
        } else {
            $hora   = $this->format(' h:i A');
        }
        $mes_nombre = $meses[intval($this->format('m'))];
        $dia        = $this->format('d');
        $dia_nombre = $dias[intval($this->format('w'))];
        $ano        = $this->format('Y');
        $mismo_dia  = $this->format('Y-m-d') == date('Y-m-d');
        $mismo_ano  = $ano == date('Y');

        if ( $tipo == 1 ) {                                                                 // Lunes 12 de Enero
            return $dia_nombre . ' ' . $dia . ' de '. $mes_nombre . $hora;
        } elseif ( $tipo == 2 ) {                                                           // 12/Enero/2010
            return  $dia . '/' . $mes_nombre . '/' . $ano . $hora;
        } elseif ( $tipo == 3 ) {                                                           // Lunes 12/Enero
            return $dia_nombre . ' ' . $dia . '/' . $mes_nombre . $hora;
        } elseif ( $tipo == 4 ) {                                                           // [Enero 12][, 2010]
            $temp = '';
            if ( !$mismo_dia ) $temp .= $mes_nombre . ' ' . $dia;
            if ( !$mismo_dia && !$mismo_ano ) $temp .= ', ' . $ano;
            return $temp . $hora;
        } elseif ( $tipo == 5 ) {                                                           // 12 de Enero del 2010
            return $dia . ' de ' . $mes_nombre . ' del ' . $ano;
        } elseif ( $tipo == 6 ) {
        }
    }

    /**
     * Obtiene el periodo relativo a la fecha especificada
     *
     * @param DateTime|string $fecha_origen
     * @return string
     */
    public function obtenerRelativo($fecha_origen = 'NOW')
    {
        if ( !($fecha_origen instanceOf DateTime) ) {
            $fecha_origen = new DateTime($fecha_origen);
        }
        $diferencia_real = $this->diff($fecha_origen);
        //util_depurar_var($diferencia_real);
        $this->setTime(0,0,0);
        $fecha_origen->setTime(0,0,0);
        $diferencia = $this->diff($fecha_origen);
        //util_depurar_var($diferencia_real->invert);
        /*if ( $diferencia_real->invert ) {
            $prefijo = 'en ';
        } else {
            $prefijo = 'hace ';
        }*/
        $prefijo = 'hace ';
        // Por años
        if ( $diferencia->y == 1 ) {
            return $prefijo . '1 año';
        } elseif ( $diferencia->y > 1 ) {
            return $prefijo . $diferencia->y . ' años';
            // Por meses
        } elseif ( $diferencia->m == 1 ) {
            return $prefijo . '1 mes';
        } elseif ( $diferencia->m > 1 ) {
            return $prefijo . $diferencia->m . ' meses';
            // Por días
        } elseif ( $diferencia->d == 1 ) {
            /*if ( $diferencia->invert ) {
                 return 'mañana';
             } else {
                 return 'ayer';
             }*/
            return 'ayer';
            //return $prefijo . '1 día';
        } elseif ( $diferencia->d > 1 ) {
            return $prefijo . $diferencia->days . ' días';
            // Por horas
        } elseif ( $diferencia_real->h == 1 ) {
            return $prefijo . '1 hora';
        } elseif ( $diferencia_real->h > 1 ) {
            return $prefijo . $diferencia_real->h . ' horas';
            // Por minutos
        } elseif ( $diferencia_real->i == 1 ) {
            return $prefijo . '1 minuto';
        } elseif ( $diferencia_real->i > 1 ) {
            return $prefijo . $diferencia_real->i . ' minutos';
        } else {
            return 'ahorita';
        }
    }

    public static function obtenerZonas()
    {
        $zonas = timezone_identifiers_list();

        $arrayRetorno = array();

        foreach ($zonas as $zona) {
            $partes = explode('/', $zona);

            $continente = $partes[0];
            $continente = str_replace('_', ' ', $continente);

            unset($partes[0]);

            $pais = implode('/', $partes);
            $pais = str_replace('_', ' ', $pais);

            $arrayRetorno[$continente][$zona] = $pais;
        }

        return $arrayRetorno;
    }
}