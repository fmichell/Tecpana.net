<?php
class Contacto
{
	public static $arrayTipo = array(1 => 'telefono', 2 => 'email', 3 => 'direccion', 4 => 'mensajeria', 5 => 'sitioweb');
	public static $arrayModoTelefono = array(1 => 'Celular', 2 => 'Fijo');
	public static $arrayModoGeneral = array(1 => 'Personal', 2 => 'Trabajo', 3 => 'Otro');
	public static $arrayModoDireccion = array(1 => 'Casa', 2 => 'Trabajo', 3 => 'Otro');
	
    /**
     * string cuentaId
     */
	private $_cuentaId;
    /**
     * string contactoId
     */
	private $_contactoId;
    /**
     * int tipo [1 persona | 2 empresa]
     */
	private $_tipo;
    /**
     * string razonSocial
     */
	private $_razonSocial;
    /**
     * string nombre
     */
	private $_nombre;
    /**
     * string apellidos
     */
	private $_apellidos;
    /**
     * int sexo [1 masculino | 2 femenino]
     */
	private $_sexo;
    /**
     * string titulo
     */
	private $_titulo;
    /**
     * string descripcion
     */
	private $_descripcion;
    /**
     * string empresaId
     */
	private $_empresaId;
    /**
     * date-time fechaCreacion
     */
	private $_fechaCreacion;
    /**
     * date-time fechaActualizacion
     */
	private $_fechaActualizacion;
    /**
     * array telefonos
     */
	private $_telefonos = array();
    /**
     * array emails
     */
	private $_emails = array();
    /**
     * array direcciones
     */
	private $_direcciones = array();
    /**
     * array mensajeria
     */
	private $_mensajerias = array();
    /**
     * array web
     */
	private $_webs = array();
	
	private static function _cargarContactos ($cuentaId, $ids = null, $filtroTipo = null, $ordenar = null)
	{
		$conexion = GestorMySQL::obtenerInstancia();
		
		if ($ids) {
			if (is_array($ids)) {
				$ids = array_unique($ids);
				$arrayId = array();
				foreach ($ids as $id) {
					$id = str_replace(' ', '', $id);
					if (!empty($id)) {
						$arrayId[] = $conexion->escaparValor($id, 'texto');
					}
				}
				$filtroIds = ' AND contacto_id IN (' . implode(',', $arrayId) . ')';
			} else {
				$filtroIds = sprintf (' AND contacto_id = %s', $conexion->escaparValor($ids, 'texto'));
			}
		} else {
			$filtroIds = null;
		}
		
		$consulta = sprintf('SELECT contacto_id, tipo, razon_social, nombre, apellidos, sexo, titulo, descripcion, fecha_creacion, fecha_actualizacion
							 FROM contactos WHERE cuenta_id = %u%s',
							 $conexion->escaparValor($cuentaId, 'entero'),
							 $filtroIds);
	 	
	 	$conexion->sql($consulta);
	 	
	 	if ($filtroTipo == 'PERSONAS') {
	 		$conexion->donde(array('tipo:entero' => 1));
	 	} elseif ($filtroTipo == 'EMPRESAS') {
	 		$conexion->donde(array('tipo:entero' => 2));
	 	}
	 	
	 	$resultado = $conexion->obtener(null, 'contacto_id');
	 	
 		return $resultado;
	}
	
	private static function _cargarContactosInfo ($cuentaId, $ids = null)
	{
		$conexion = GestorMySQL::obtenerInstancia();
		
		if ($ids) {
			if (is_array($ids)) {
				$ids = array_unique($ids);
				$arrayId = array();
				foreach ($ids as $id) {
					$id = str_replace(' ', '', $id);
					if (!empty($id)) {
						$arrayId[] = $conexion->escaparValor($id, 'texto');
					}
				}
				$filtroIds = ' AND contacto_id IN (' . implode(',', $arrayId) . ')';
			} else {
				$filtroIds = sprintf (' AND contacto_id = %s', $conexion->escaparValor($ids, 'texto'));
			}
		} else {
			$filtroIds = null;
		}
		
		$consulta = sprintf('SELECT info_id, contacto_id, tipo, valor_1, valor_2, modo, proveedor, ciudad, estado, pais_id, cpostal, principal, fecha_creacion, fecha_modificacion
							 FROM contactos_info WHERE cuenta_id = %u%s ORDER BY principal',
							 $conexion->escaparValor($cuentaId, 'entero'),
							 $filtroIds);
	 	$resultado = $conexion->obtenerGrupos($consulta, 'contacto_id');
	 	return $resultado;
	}
	
	private static function _ordernarContactosInfo ($infos)
	{
		$arrayRetorno = array();
		
		foreach ($infos as $info) {
			switch ($info['tipo']) {
				case 1:
					$info['modo_str'] = self::$arrayModoTelefono[$info['modo']];
					break;
				case 2:
					$info['modo_str'] = self::$arrayModoEmail[$info['modo']];
					break;
				case 3:
					$info['modo_str'] = self::$arrayModoDireccion[$info['modo']];
					break;
			}
			$arrayRetorno[ self::$arrayTipo[ $info['tipo'] ] ][] = $info;
		}
		
		return $arrayRetorno;
	}
	
	private static function _cargar ($cuentaId, $ids = null) 
	{
		$contactos = self::_cargarContactos($cuentaId, $ids);
		$contactosInfo = self::_cargarContactosInfo($cuentaId, $ids);
		
		foreach ($contactosInfo as $contactoId => $infos) {
			$contactos[$contactoId] += self::_ordernarContactosInfo($infos);
		}
		
		return $contactos;
	}
	
	public static function obtener ($cuentaId, $ids)
	{
		$contactos = self::_cargar($cuentaId, $ids);
		
		if (is_array($ids))
			return $contactos;
		else
			return current($contactos);
	}
	
	public static function obtenerTodos ($cuentaId)
	{
		return self::_cargar($cuentaId);
	}
	
	protected static function agregarContacto ($cuentaId, $tipo, $razonSocial = null, $nombre = null, $apellidos = null, $sexo = null, $titulo = null, $descripcion = null, $empresaId = null)
	{
		$idContacto = uniqid('ct');
		$ahora = date('Y-m-d H:i:s');
		$conexion = GestorMySQL::obtenerInstancia();
		
		$conexion->insertar('contactos', array(
							'cuenta_id:entero' => $cuentaId,
							'contacto_id:texto' => $idContacto,
							'tipo:entero' => $tipo,
							'razon_social:texto' => $razonSocial,
							'nombre:texto' => $nombre,
							'apellidos:texto' => $apellidos,
							'sexo:entero' => $sexo,
							'titulo:texto' => $titulo,
							'descripcion:texto' => $descripcion,
							'empresa_id:texto' => $empresaId,
							'fecha_creacion:fecha' => $ahora,
							'fecha_actualizacion:fecha' => $ahora));
		return $conexion->ejecutar();
	}
	
	private static function _agregarInfo ($cuentaId, $contactoId, $tipo, $valor1, $modo, $valor2 = null, $proveedor = null, $principal = null, $paisId = null, $ciudad = null, $estado = null, $cpostal = null)
	{
		$ahora = date('Y-m-d H:i:s');
		$conexion = GestorMySQL::obtenerInstancia();
		
		$conexion->insertar('contactos_info', array(
							'cuenta_id:entero' => $cuentaId,
							'contacto_id:texto' => $contactoId,
							'tipo:entero' => $tipo,
							'valor_1:texto' => $valor1,
							'valor_2:texto' => $valor2,
							'modo:entero' => $modo,
							'proveedor:entero' => $proveedor,
							'ciudad:texto' => $ciudad,
							'estado:texto' => $estado,
							'pais_id:entero' => $paisId,
							'cpostal:texto' => $cpostal,
							'principal:entero' => $principal,
							'fecha_creacion:fecha' => $ahora,
							'fecha_modificacion:fecha' => $ahora));
		return $conexion->ejecutar();
	}
	
	public static function agregarTelefono ($cuentaId, $contactoId, $valor1, $modo, $valor2 = null, $proveedor = null, $paisId = null, $principal = null)
	{
		return self::_agregarInfo($cuentaId, $contactoId, array_keys(self::$arrayTipo, 'telefono'), $valor1, $modo, $valor2, $proveedor, $principal, $paisId);
	}
	
	public static function agregarEmail ($cuentaId, $contactoId, $valor1, $modo, $principal)
	{
		return self::_agregarInfo($cuentaId, $contactoId, array_keys(self::$arrayTipo, 'email'), $valor1, $modo, null, null, $principal);
	}
	
	public static function agregarDireccion ($cuentaId, $contactoId, $valor1, $valor2 = null, $modo, $ciudad, $estado, $cpostal, $paisId, $principal = null)
	{
		return self::_agregarInfo($cuentaId, $contactoId, array_keys(self::$arrayTipo, 'direccion'), $valor1, $modo, $valor2, null, $principal, $paisId, $ciudad, $estado, $cpostal);
	}
	
	protected static function actualizarContacto ($cuentaId, $contactoId, $razonSocial = null, $nombre = null, $apellidos = null, $sexo = null, $titulo = null, $descripcion = null, $empresaId = null)
	{
		$ahora = date('Y-m-d H:i:s');
		$conexion = GestorMySQL::obtenerInstancia();
		
		$conexion->actualizar('contactos', array(
							  'razon_social:texto' => $razonSocial,
							  'nombre:texto' => $nombre,
							  'apellidos:texto' => $apellidos,
							  'sexo:entero' => $sexo,
							  'titulo:texto' => $titulo,
							  'descripcion:texto' => $descripcion,
							  'empresaId:texto' => $empresaId));
  		$conexion->donde(array(
		  					  'cuenta_id:entero' => $cuentaId,
							  'contacto_id:texto' => $contactoId));
  		return $conexion->ejecutar();	
	}
}