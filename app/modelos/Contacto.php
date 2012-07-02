<?php
require_once 'CamposContacto.php';

class Contacto
{	
    // METODOS ESTATICOS
    
    // -->
    
    /**
     * @static insertarContacto
     * Insertar un nuevo contacto en la BD
     * 
     * @param int $cuentaId
     * @param int $tipo [1 Persona | 2 Empresa]
     * @param string $nombre
     * @param string $apellidos
     * @param int $sexo [1 Masculino | 2 Femenino]
     * @param string $titulo
     * @param string $descripcion
     * @param string $empresaId
     * @return string $usuarioId
     */ 
    static protected function insertarContacto ($cuentaId, $tipo, $nombre = null, $apellidos = null, $sexo = null, $titulo = null, $descripcion = null, $empresaId = null)
    {
        // Definimos variables generales
        $contactoId     = uniqid('ct');
        $ahora          = date('Y-m-d H:i:s');
        
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();
        
        // Iniciamos consulta
        $bd->insertar('contactos', array(
                      'cuenta_id:texto'     => $cuentaId,
                      'contacto_id:texto'   => $contactoId,
                      'tipo:entero'         => $tipo,
                      'nombre:texto'        => $nombre,
                      'apellidos:texto'     => $apellidos,
                      'sexo:entero'         => $sexo,
                      'titulo:texto'        => $titulo,
                      'descripcion:texto'   => $descripcion,
                      'empresa_id:texto'    => $empresaId,
                      'fecha_creacion:fecha' => $ahora,
                      'fecha_modificacion:fecha' => $ahora));
        
        $resultado = $bd->ejecutar();
        
        if ($resultado)
            return $contactoId;
        else
            return $resultado;
    }
    
    /**
     * @static insertarInfo
     * Inserta un nuevo detalle de contacto en la BD
     * 
     * @param int $cuentaId
     * @param string $contactoId
     * @param int $tipo
     * @param string $valor
     * @param string $valorText
     * @param string $modo
     * @param string $servicios
     * @param int $principal
     * @param string $ciudad
     * @param string $estado
     * @param int $paisId
     * @param string $cpostal
     * @return boolean
     */
    static protected function insertarInfo ($cuentaId, $contactoId, $tipo, $valor = null, $valorText = null, $modo = null, $servicios = null, $principal = 0, 
                                            $ciudad = null, $estado = null, $paisId = null, $cpostal = null)
    {
        // Definimos variables generales
        $ahora = date('Y-m-d H:i:s');
        
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();
        
        // Iniciamos consulta
        $bd->insertar('contactos_info', array(
                      'cuenta_id:texto'         => $cuentaId,
                      'contacto_id:texto'       => $contactoId,
                      'tipo:entero'             => $tipo,
                      'valor:texto'             => $valor,
                      'valor_text:texto'        => $valorText,
                      'modo:entero'             => $modo,
                      'servicio:entero'        => $servicios,
                      'ciudad:texto'            => $ciudad,
                      'estado:texto'            => $estado,
                      'pais_id:entero'          => $paisId,
                      'cpostal:texto'           => $cpostal,
                      'fecha_creacion:fecha'    => $ahora,
                      'fecha_modificacion:fecha' => $ahora));

        return $bd->ejecutar();
    }

    /**
     * @static prepararInfo
     * Recibe los datos completos del POST, filtra solo los que sean Info y los ordena
     *
     * @param array $arrayInfo
     * @return array
     */
    static public function prepararInfo (array $arrayInfo)
    {
        $campos = array_keys(CamposContacto::$tiposInfo);
        $retorno = array();

        foreach ($arrayInfo as $llaveCampo => $campo) {
            // Si el campo no esta definido en el arreglo de campos lo omitimos
            // Estamos asumiendo que si no esta es porque es un modo, servicio u otro especial
            if (!in_array($llaveCampo, $campos))
                continue;

            if (!is_array($campo)) {
                if (!empty($campo))
                    $retorno[$llaveCampo] = $campo;
                continue;
            }

            foreach ($campo as $llave => $valor) {
                // Si el valor esta vacio lo omitimos
                if (empty($valor))
                    continue;

                // Capturando valor general
                $retorno[$llaveCampo][$llave]['valor'] = $valor;

                // Campurando valores de modo y servicios
                $llaveModo = $llaveCampo . 'Modo';
                if (isset($arrayInfo[$llaveModo][$llave]) and !empty($arrayInfo[$llaveModo][$llave]))
                    $retorno[$llaveCampo][$llave]['modo'] = $arrayInfo[$llaveModo][$llave];

                $llaveServicios = $llaveCampo . 'Servicios';
                if (isset($arrayInfo[$llaveServicios][$llave]) and !empty($arrayInfo[$llaveServicios][$llave]))
                    $retorno[$llaveCampo][$llave]['servicios'] = $arrayInfo[$llaveServicios][$llave];

                // Capturando valores para campos especiales
                // Direccion
                if ($llaveCampo == 'direccion') {
                    // Capturamos ciudad
                    $retorno[$llaveCampo][$llave]['ciudad'] = $arrayInfo['ciudad'][$llave];
                    // Capturamos estado
                    $retorno[$llaveCampo][$llave]['estado'] = $arrayInfo['estado'][$llave];
                    // Capturamos pais
                    $retorno[$llaveCampo][$llave]['pais'] = $arrayInfo['pais'][$llave];
                    // Capturamos cpostal
                    $retorno[$llaveCampo][$llave]['cpostal'] = null;
                }
            }
        }

        return $retorno;
    }

    // -->

    /**
     * @static _cargarContactos
     * Obtiene el listado de contactos por Cuenta Id, y los filtra por id o por tipo
     *
     * @param int $cuentaId
     * @param [string | array | null] $ids
     * @param string $filtroTipo [PERSONAS | EMPRESAS]
     * @param null $ordenar
     * @return bool|array
     */
    static private function _cargarContactos ($cuentaId, $ids = null, $filtroTipo = null, $ordenar = null)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Declaramos arraglo de filtros
        $filtros = array();

        // Generamos filtro cuentaId
        $filtros[] = 'cuenta_id = ' . $bd->escaparValor($cuentaId, 'entero');

        // Generamos filtro ids
        if ($ids) {
            if (is_array($ids)) {
                // Verificamos que no hayan valores repetidos
                $ids = array_unique($ids);
                $tmp = array();
                foreach ($ids as $id) {
                    // Limpiamos el valor, lo escapamos y lo guardamos en un arreglo temporal
                    $id = trim($id);
                    if (!empty($id)) {
                        $tmp[] = $bd->escaparValor($id, 'texto');
                    }
                }
                $filtros[] = 'contacto_id IN (' . implode(',', $tmp) . ')';
            } else {
                $filtros[] = sprintf('contacto_id = %s', $bd->escaparValor($ids, 'texto'));
            }
        }

        // Generamos filtro tipo
        if ($filtroTipo == 'PERSONAS') {
            $filtros[] = 'tipo = 1';
        } elseif ($filtroTipo == 'EMPRESAS') {
            $filtros[] = 'tipo = 2';
        }

        // Generamos filtro
        $filtros = implode(' AND ', $filtros);

        // Generamos consulta
        $consulta = sprintf("SELECT contacto_id, tipo, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo, nombre, apellidos, sexo, titulo, descripcion, empresa_id
                             FROM contactos WHERE %s",
                             $filtros);

        return $bd->obtener($consulta, 'contacto_id');
    }

    /**
     * @static _cargarInfos
     * Obtiene la informacion de un contacto
     *
     * @param int $cuentaId
     * @param [null | string | array] $ids
     * @return array
     */
    static private function _cargarInfos ($cuentaId, $ids = null)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Declaramos arraglo de filtros
        $filtros = array();

        // Generamos filtro cuenta_id
        $filtros[] = 'cuenta_id = ' . $bd->escaparValor($cuentaId, 'entero');

        // Generamos filtro ids
        if ($ids) {
            if (is_array($ids)) {
                // Verificamos que no hayan valores repetidos
                $ids = array_unique($ids);
                $tmp = array();
                foreach ($ids as $id) {
                    // Limpiamos el valor, lo escapamos y lo guardamos en un arreglo temporal
                    $id = trim($id);
                    if (!empty($id)) {
                        $tmp[] = $bd->escaparValor($id, 'texto');
                    }
                }
                $filtros[] = 'contacto_id IN (' . implode(',', $tmp) . ')';
            } else {
                $filtros[] = sprintf('contacto_id = %s', $bd->escaparValor($ids, 'texto'));
            }
        }

        // Generamos filtro
        $filtros = implode(' AND ', $filtros);

        // Generamos consulta
        $consulta = sprintf('SELECT contacto_id, info_id, tipo, valor, valor_text, modo, servicio, ciudad, estado, pais_id, cpostal, principal
                             FROM contactos_info WHERE %s',
                             $filtros);

        return $bd->obtenerGrupos($consulta, 'contacto_id', 'info_id');
    }

    /**
     * @static buscarContactosPorNombre
     * Busca un contacto por Cuenta Id y nombre
     *
     * @param int $cuentaId
     * @param [null | string] $nombre
     * @return array|null
     */
    static public function buscarContactosPorNombre ($cuentaId, $nombre = null)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Declaramos arraglo de filtros
        $filtros = array();

        // Generamos filtro cuenta_id
        $filtros[] = 'cuenta_id = ' . $bd->escaparValor($cuentaId, 'entero');

        // Filtramos por nombre
        if (empty($nombre)) {
            return null;
        } else {
            $nombre = trim($nombre);
            $narray = explode(' ', $nombre);
            foreach ($narray as $indice => $valor) {
                $narray[$indice] = '+' . $bd->escaparValor($valor) . '*';
            }
            $nombreFormatiado = implode(' ', $narray);
            $filtros[] = sprintf('MATCH (nombre, apellidos) AGAINST (%s IN BOOLEAN MODE)',
                                 $bd->escaparValor($nombreFormatiado, 'texto'));
        }

        // Generamos filtro
        $filtros = implode(' AND ', $filtros);

        // Generamos consulta
        $consulta = sprintf("SELECT contacto_id, tipo, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo, nombre, apellidos, sexo, titulo, descripcion, empresa_id
                             FROM contactos WHERE %s",
                             $filtros);

        return $bd->obtener($consulta, 'contacto_id');
    }

    /**
     * @static _ordenarInfo
     * Obtiene la informacion de un contacto y la retorna ordenada
     *
     * @param array $arrayInfo
     * @return array
     */
    static private function _ordenarInfo (array $arrayInfo)
    {
        $campos = CamposContacto::$tiposInfo;
        $retorno = array();

        foreach ($arrayInfo as $id => $info) {
            $tipoId = $info['tipo'];

            foreach ($campos as $tipo => $campo) {
                if ($tipoId == $campo['id']) {
                    $info['modo_id'] = $info['modo'];
                    $info['servicio_id'] = $info['servicio'];

                    if ($info['modo']) {
                        $info['modo'] = $campo['modo'][$info['modo']];
                    }
                    if ($info['servicio']) {
                        $info['servicio'] = $campo['servicios'][$info['servicio']];
                    }
                    $retorno[$campo['llave']][$id] = $info;
                }
            }
        }

        return $retorno;
    }

    /**
     * @static _cargar
     * Carga uno o varios contactos con toda su infomacion
     *
     * @param int $cuentaId
     * @param [null | string | array] $ids
     * @return array|bool
     */
    static private function _cargar ($cuentaId, $ids = null)
    {
        $contactos = self::_cargarContactos($cuentaId, $ids);
        $contactos_infos = self::_cargarInfos($cuentaId, $ids);

        foreach ($contactos_infos as $contacto_id => $infos) {
            $contactos[$contacto_id] += self::_ordenarInfo($infos);
        }

        return $contactos;
    }

    /**
     * @static obtener
     * Obtiene uno o mas contactos por id
     *
     * @param int $cuentaId
     * @param [string | array] $ids
     * @return array|bool
     */
    static public function obtener ($cuentaId, $ids)
    {
        $contactos = self::_cargar($cuentaId, $ids);

        if (is_array($ids)) {
            return $contactos;
        } else {
            return current($contactos);
        }
    }

    /**
     * @static obtenerTodos
     * Obtiene todos los contactos de una cuenta
     *
     * @param int $cuentaId
     * @return array|bool
     */
    static public function obtenerTodos ($cuentaId)
    {
        return self::_cargar($cuentaId);
    }

    /**
     * @static obtenerTodosSinInfo
     * Obtiene la informacion basica de todos los contactos de la cuenta
     *
     * @param $cuentaId
     * @return array|bool
     */
    static public function obtenerTodosSinInfo ($cuentaId)
    {
        return self::_cargarContactos($cuentaId);
    }

    /**
     * @static buscar
     * Busca contactos por nombre y los retorna ordenados por su info
     *
     * @param int $cuentaId
     * @param [null | string] $nombre
     * @return array|null
     */
    static public function buscar ($cuentaId, $nombre = null)
    {
        $contactos = self::buscarContactosPorNombre($cuentaId, $nombre);
        $ids = array_keys($contactos);
        $contactos_infos = self::_cargarInfos($cuentaId, $ids);

        foreach ($contactos_infos as $contacto_id => $infos) {
            $contactos[$contacto_id] += self::_ordenarInfo($infos);
        }

        return $contactos;
    }

    /**
     * @static sugerir
     * Busca contactos por nombre y tipo y retorna informacion basica
     *
     * @param int $cuentaId
     * @param string|null $nombre
     * @param int $tipo
     * @return array|null
     */
    static public function sugerir ($cuentaId, $nombre = null, $tipo = 2)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Declaramos arraglo de filtros
        $filtros = array();

        // Generamos filtro cuenta_id y tipo
        $filtros[] = 'cuenta_id = ' . $bd->escaparValor($cuentaId, 'entero');
        $filtros[] = 'tipo = ' . $bd->escaparValor($tipo, 'entero');

        // Filtramos por nombre
        if (empty($nombre)) {
            return null;
        } else {
            $nombre = trim($nombre);
            $narray = explode(' ', $nombre);
            foreach ($narray as $indice => $valor) {
                $narray[$indice] = '+' . $bd->escaparValor($valor) . '*';
            }
            $nombreFormatiado = implode(' ', $narray);
            $filtros[] = sprintf('MATCH (nombre, apellidos) AGAINST (%s IN BOOLEAN MODE)',
                $bd->escaparValor($nombreFormatiado, 'texto'));
        }

        // Generamos filtro
        $filtros = implode(' AND ', $filtros);

        // Generamos consulta
        $consulta = sprintf("SELECT contacto_id AS id, CONCAT_WS(' ', nombre, apellidos) AS label, CONCAT_WS(' ', nombre, apellidos) AS value
                             FROM contactos WHERE %s",
            $filtros);

        return $bd->obtener($consulta, 'contacto_id');
    }

    //-->

    static protected function editarContacto ($cuentaId, $contactoId, $tipo, $nombre = null, $apellidos = null, $sexo = null, $titulo = null, $descripcion = null, $empresaId = null)
    {
        // Definimos variables generales
        $ahora = date('Y-m-d H:i:s');

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->actualizar('contactos', array(
                        'tipo:entero'         => $tipo,
                        'nombre:texto'        => $nombre,
                        'apellidos:texto'     => $apellidos,
                        'sexo:entero'         => $sexo,
                        'titulo:texto'        => $titulo,
                        'descripcion:texto'   => $descripcion,
                        'empresa_id:texto'    => $empresaId,
                        'fecha_modificacion:fecha' => $ahora));
        $bd->donde(array(
                        'cuenta_id:entero'     => $cuentaId,
                        'contacto_id:texto'    => $contactoId));

        $resultado = $bd->ejecutar();

        if ($resultado)
            return $contactoId;
        else
            return $resultado;
    }

    //-->

    static public function eliminarContacto ($cuentaId, $contactoId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->eliminar('contacto');

        $bd->donde(array(
            'cuenta_id:entero'     => $cuentaId,
            'contacto_id:texto'    => $contactoId));

        $resultado = $bd->ejecutar();

        if (!$resultado) {
            return false;
        } else {
            // Eliminamos info del contacto
            return $resultado = self::eliminarInfoContacto($cuentaId, $contactoId);
        }
    }

    static public function eliminarInfoContacto ($cuentaId, $contactoId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->eliminar('contactos_info');

        $bd->donde(array(
            'cuenta_id:entero'     => $cuentaId,
            'contacto_id:texto'    => $contactoId));

        return $bd->ejecutar();
    }
}