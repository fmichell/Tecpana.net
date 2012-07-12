<?php

class TablaException extends Exception
{
	public function __construct($mensaje, $codigo = 0) {
		parent::__construct('Tabla | ' . $mensaje, $codigo);
	}
}

/**
 * @name Simulador de tabla
 * @author Nestor Picado Rivera
 * @copyright Nestor Picado Rivera
 * @version 1.0 (2010-09-06)
 */
class Tabla
{
	public $tabla = null;
	private $_tablaInicio = null;

    /**
     * Constructor general
     *
     * @param array $datos
     * @return Librerias_Tabla
     */
	public function __construct($datos)
	{
		$this->tabla = $datos;
		$this->_tablaInicio = $datos;
	}
	
	/**
	 * Inicia la tabla con los datos de origen o con los especificados.
	 * 
	 * @param array $datos
     * @return Librerias_Tabla
	 */
	public function iniciar($datos = null)
	{
		if ( $datos ) {
			$this->tabla = $datos;
			$this->_tablaInicio = $datos;
		} else {
			$this->tabla = $this->_tablaInicio;
		}
		return $this;
	}
	
	/**
	 * Obtiene los datos de la tabla procesada.
	 * 
	 * @return array
	 */
	public function obtener()
	{
		return $this->tabla;
	}
	
	/**
	 * Obtiene la cantidad de registros en la tabla procesada.
	 * 
	 * @return int
	 */
	public function obtenerCantidad()
	{
		return count($this->tabla);
	}
	
	/**
	 * Obtiene valores de la columna especificada.
	 * 
	 * @param string $columna
	 * @param bool $soloUnicos
	 * @return
	 */
	public function obtenerColumna($columna, $soloUnicos = false)
	{
		if ( empty($columna) ) throw new TablaException('El parametro "columna" es invalido.');
		if ( !$this->tabla ) return null;
		
		$fila_temp = array_shift($this->tabla);
		if ( !array_key_exists($columna, $fila_temp) ) {
			throw new TablaException('No existe la columna "' . $columna . '" dentro de la tabla.');
		}
		array_unshift($this->tabla, $fila_temp);
		
		$final = array();
		foreach ($this->tabla as $fila) {
			$final[] = $fila[$columna];
		}
		if ($soloUnicos) $final = array_values( array_unique($final) );
		
		return $final;
	}
	
	/**
	 * Filtra la tabla segun condiciones especificadas.
	 * 
	 * @param string $condiciones
     * @return Librerias_Tabla
	 */
	public function filtrar($condiciones)
	{
		if ( empty($condiciones) ) throw new TablaException('El parametro [condiciones] introducido es incorrecto.');
		if ( !$this->tabla ) return $this;

		$columnas = array();
		$condiciones = str_replace(array(' = ', '(', ')', ' OR '), array(' == ', ' ( ', ' ) ', ' || '), $condiciones);
		$condiciones = explode(' ', trim($condiciones));
		
		foreach($condiciones as $termino) {
			if ($termino !== '') {
				if ( strpos($termino, '{') === 0 &&  substr($termino, -1, 1) == '}' ) {
					$columna = trim($termino, '{}');
					$columnas[] = $columna;
					$temp[] = '$fila[\'' . $columna . '\']';
				} else {
					$temp[] = $termino;
				}
			}
		}
		$condiciones = implode(' ', $temp);

		if (!$columnas) {
			throw new TablaException('No introdujo columnas en el parametro [condiciones].');
		} else {
			//$fila_temp = array_shift($this->tabla);
            $fila_temp = current($this->tabla);

			foreach ($columnas as $columna) {
				if ( !array_key_exists($columna, $fila_temp) ) throw new TablaException('No existe la columna {' . $columna . '} dentro de la tabla.');
			}
			//array_unshift($this->tabla, $fila_temp);
		}

		$final = array();
		foreach ($this->tabla as $llave => $fila) {
			eval('$cond = ' . $condiciones . ';');
			if ( $cond ) $final[$llave] = $fila;
		}
		$this->tabla = $final;
		return $this;
	}
			
	/**
	 * Ordena la tabla por columnas segun parametros.
	 * 
	 * @param string $orden
     * @return Librerias_Tabla
	 */
	public function ordenar($orden)
	{
		if (empty($orden)) throw new TablaException('El parametro [orden] introducido es incorrecto.');
		if ( !$this->tabla ) return $this;
		
		$columnas = array();
		$orden = str_replace(array(',', ' ASC ', ' DESC '), array(' ', ' SORT_ASC ', ' SORT_DESC '), ' ' . $orden . ' ' );
		$orden = explode(' ', trim($orden));
		
		foreach ($orden as $termino) {
			if ($termino !== '') {
				if ( strpos($termino, '{') === 0 &&  substr($termino, -1, 1) == '}' ) {
					$columna = trim($termino, '{}');
					$columnas[] = $columna;
					$orden_procesado[] = '$' . $columna;
				} else {
					$orden_procesado[] = $termino ;
				}
			}
		}
		
		if (!$columnas) {
			throw new TablaException('No introdujo columnas en el parametro [orden].');
		} else {
			$fila_temp = array_shift($this->tabla);
			foreach ($columnas as $columna) {
				if ( !array_key_exists($columna, $fila_temp) ) throw new TablaException('No existe la columna {' . $columna . '} dentro de la tabla.');
			}
			array_unshift($this->tabla, $fila_temp);
		}
		
		foreach ($this->tabla as $llave => $fila) {
			foreach ($columnas as $columna) {
				eval ('$' . $columna . '[$llave] = $fila[\'' . $columna . '\'];');
			}
		}
		
		eval('array_multisort(' . implode(', ', $orden_procesado) . ', $this->tabla);');
		return $this;
	}
	
	/**
	 * Aplica indices a filas segun valor en columna especificada.
	 * 
	 * @param string $columna
     * @return Librerias_Tabla
	 */
	public function indizar($columna)
	{
		if (empty($columna)) throw new TablaException('El parametro [columna] introducido es incorrecto.');
		if ( !$this->tabla ) return $this;
		
		$final = array();
		
		$fila_temp = array_shift($this->tabla);
		if ( !array_key_exists($columna, $fila_temp) ) {
			throw new TablaException('No existe la columna {' . $columna . '} dentro de la tabla.');
		}
		array_unshift($this->tabla, $fila_temp);
		
		foreach ($this->tabla as $fila) {
			$final[$fila[$columna]] = $fila;
		}
		
		$this->tabla = $final;
		return $this;
	}
	
	/**
	 * Agrupa filas segun valores en columna especificada.
	 * 
	 * @param string $columnaGrupo
	 * @param string $columnaLlave
     * @return Librerias_Tabla
	 */
	public function agrupar($columnaGrupo, $columnaLlave = null)
	{
		if (empty($columnaGrupo)) throw new TablaException('El parametro [columnaGrupo] introducido es incorrecto.');
		if ( !$this->tabla ) return $this;
		
		$fila_temp = array_shift($this->tabla);
		if ( !array_key_exists($columnaGrupo, $fila_temp) ) {
			throw new TablaException('No existe la columna {' . $columnaGrupo . '} dentro de la tabla.');
		}
		array_unshift($this->tabla, $fila_temp);

		$final = array();
		if ( $columnaLlave && isset($fila_temp[$columnaLlave]) ) {
			foreach ($this->tabla as $fila) {
				$final[$fila[$columnaGrupo]][$fila[$columnaLlave]] = $fila;
			}
		} else {
			foreach ($this->tabla as $fila) {
				$final[$fila[$columnaGrupo]][] = $fila;
			}
		}
		
		$this->tabla = $final;
		return $this;
	}
	
	public function unicos($columna)
	{
		
	}
	
	public function agregarRegistro($registro)
	{
		
	}
	
	public function buscar($consulta, $columna)
	{
		
	}
	
	public function sumaColumna($columna)
	{
		if (empty($columna)) throw new TablaException('El parametro [columna] introducido es incorrecto.');
		//if ( !$this->tabla ) return $this;
        if ( !$this->tabla ) return 0;
        
        $retorno = 0;
        foreach( $this->tabla as $fila ){
            if( isset( $fila[$columna] )  ){
                $retorno += (isset( $fila[$columna] )) ? $fila[$columna] : 0;
            }else{
                $retorno += $fila[$columna];
            }
        }
        return $retorno;
	}
	
	/**
	 * Limita la cantidad de filas segun parametros.
	 * 
	 * @param int $posicion | Posicion de inicio
	 * @param int $longitud | Cantidad de filas a permitir
     * @return Librerias_Tabla
	 */
	public function limitar($posicion, $longitud = null)
	{
		if ( !$this->tabla ) return $this;
		
		if ( $longitud ) {
			$this->tabla = array_slice($this->tabla, $posicion, $longitud, true); 
		} else {
			$this->tabla = array_slice($this->tabla, 0, $posicion, true); 
		}
		
		return $this;
	}
}

?>