<?php

/**
 * @name Gestor de MySQL
 * @author Nestor Picado Rivera
 * @copyright Nestor Picado Rivera
 * @version 0.97 (2012-01-18)
 */
class GestorMySQL
{
    /** @var array */
    private static $_instancias = array();
    /** @var string */
    public $instancia = null;
    /** @var null|string */
    private $_sql = null;
    /** @var mysqli */
    private $_conexion = null;
    /** @var bool */
    private $_conectado = false;
    /** @var null|int */
    private $_cache_tiempo = null;
    /** @var null|string */
    private $_cache_llave = null;
    /** @var bool */
    private $_cache_activado = true;
    /** @var bool */
    private $_cache_sobrescribir = false;
    /** @var GestorCache */
    public $gestor_cache;
    /** @var array */
    private $_config = array(
        'servidores' => array(
            array(
                'host'  => null,
                'peso'  => null
            )
        ),
        'usuario'       => null,
        'contrasena'    => null,
        'basedatos'     => null,
        'charset'       => null,    // utf8, latin1, ascii
        'auto_cache'    => null,    // segundos
        'depurar'       => false
    );

    // TODO Falta funcionalidad de logging

    /**
     * Constructor ocultado a proposito
     *
     * @param string $instancia
     * @return GestorMySQL
     */
    private function __construct($instancia)
    {
        $this->instancia = $instancia;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        throw new Exception('GestorMySQL | No puedes clonar esta instancia de clase.');
    }

    /**
     * @return void
     */
    public function __wakeup()
    {
        throw new Exception('GestorMySQL | No puedes deserializar esta instancia de clase.');
    }

    /**
     * @return void
     */
    public function __sleep()
    {
        throw new Exception('GestorMySQL | No puedes serializar esta instancia de clase.');
    }

    /**
     * @return void
     */
    function __destruct()
    {
        $this->desconectar();
    }

    /**
     * Imprime mensajes con formato funcional
     *
     * @param string $mensaje
     */
    private function notificar($mensaje)
    {
        echo '<div style="font-weight: bold; font-family: verdana, arial, helvetica, sans-serif; ';
        echo 'font-size: 13px; color: #000; background-color: #E6E6FF; border: solid 1px #99F; ';
        echo 'padding: 4px 6px; margin: 10px; position: relative;">' . $mensaje . '</div>';
    }

    /**
     * Establece las configuraciones de conexion
     *
     * @param array $configuraciones
     * @return GestorMySQL
     */
    public function configurar(array $configuraciones)
    {
        $this->_config = array_merge($this->_config, $configuraciones);
        return $this;
    }

    /**
     * Obtiene instancias unicas de este gestor
     *
     * @throws Exception
     * @param string $instancia Nombre de la instancia a obtener
     * @param array|null $configuracion Configuraciones de conexion
     * @return GestorMySQL
     */
    public static function obtenerInstancia($instancia = 'produccion', $configuracion = null)
    {
        if (isset(self::$_instancias[$instancia])) {
            return self::$_instancias[$instancia];
        } else {
            self::$_instancias[$instancia] = new self($instancia);
            if ($configuracion) {
                self::$_instancias[$instancia]->configurar($configuracion);
            }
            return self::$_instancias[$instancia];
        }
    }

    /**
     * Cierra la conexión al servidor MySQL
     *
     * @return bool
     */
    public function desconectar()
    {
        if ($this->_conectado) {
            if (mysqli_close($this->_conexion)) {
                $this->_conectado = false;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Abre una nueva conexión al servidor MySQL
     *
     * @throws Exception
     * @param array $configuraciones
     * @return GestorMySQL
     */
    public function conectar($configuraciones = null)
    {
        // Pasamos configuraciones en caso necesario
        if ($configuraciones) {
            $this->configurar($configuraciones);
        }

        // Preparamos orden de servidores segun peso
        $pesos = array();
        foreach ($this->_config['servidores'] as $llave => $valor) {
            $pesos[$llave] = $valor['peso'];
        }
        $temp = array_sum($pesos);
        foreach ($pesos as $llave => $valor) {
            $pesos[$llave] = ($valor / $temp) * mt_rand(1, 5);
        }
        arsort($pesos);
        $pesos = array_keys($pesos);

        // Nos conectamos al servidor disponible segun orden
        $this->desconectar();
        while (!$this->_conectado && count($pesos)) {
            $llave = array_shift($pesos);
            $this->_conexion = new mysqli(
                $this->_config['servidores'][$llave]['host'],
                $this->_config['usuario'],
                $this->_config['contrasena'],
                $this->_config['basedatos']
            );
            if (!$this->_conexion->connect_error) {
                $this->_conectado = true;
            }
        }
        
        if ($this->_conectado) {
            // Definimos el conjunto de caracteres
            if ($this->_config['charset']) {
                mysqli_set_charset($this->_conexion, $this->_config['charset']);
            }
            if ($this->_config['depurar']) {
                $this->notificar('Auto-conectamos a la BD.');
            }
        } else {
            throw new Exception('GestorMySQL | No se pudo abrir una conexion al servidor MySQL.', 105);
        }
        return $this;
    }

    /**
     * Selecciona la base de datos interna
     *
     * @throws Exception
     * @param string $bd
     * @return GestorMySQL
     */
    public function seleccionarBD($bd)
    {
        if ($this->_conectado) {
            if (mysqli_select_db($this->_conexion, $bd)) {
                $this->_config['basedatos'] = $bd;
                return $this;
            } else {
                throw new Exception('GestorMySQL | No se pudo seleccionar base de datos.', 104);
            }
        } else {
            throw new Exception('GestorMySQL | No hay conexión abierta para seleccionar base de datos.', 101);
        }
    }

    /**
     * Prepara valor segun tipo especificado
     *
     * @param mixed $valor Valor a preparar
     * @param string $tipo Tipo de valor pasado: boleano, texto, entero, real o flotante, definido
     * @return string Retorna valor escapado para MySQL
     */
    public function prepararValor($valor, $tipo = null)
    {
        if (!$this->_conectado) {
            $this->conectar();
        }

        // Retornamos valor boleano en caso necesario
        if ($tipo == 'boleano') {
            return (empty($valor)) ? 0 : 1;
        }

        // Retornamos nulo en caso necesario
        if ($valor === '' || $valor === null || $valor === false) return 'NULL';

        // Retornamos segun tipo
        if ($tipo == 'texto' || $tipo == 'fecha') {
            if (PHP_VERSION < 6) $valor = get_magic_quotes_gpc() ? stripslashes($valor) : $valor;
            return "'" . $this->_conexion->real_escape_string($valor) . "'";
        } else if ($tipo == 'entero') {
            return intval($valor, 10);
        } else if ($tipo == 'real' || $tipo == 'flotante') {
            return floatval($valor);
        } else {
            if (PHP_VERSION < 6) $valor = get_magic_quotes_gpc() ? stripslashes($valor) : $valor;
            return $this->_conexion->real_escape_string($valor);
        }
    }

    /**
     * Alias de prepararValor
     *
     * @param mixed $valor Valor a preparar
     * @param string $tipo Tipo de valor pasado: boleano, texto, entero, real o flotante, definido
     * @return string Retorna valor escapado para MySQL
     */
    public function escaparValor($valor, $tipo = null)
    {
        return $this->prepararValor($valor, $tipo);
    }

    /**
     * Obtiene multiples registros
     *
     * @param string $sql Consulta SQL
     * @param string $campo_llave Campo que desea como llaves de arreglo
     * @return array Retorna un arreglo con o sin resultados
     */
    public function obtener($sql = null, $campo_llave = null)
    {
        // Validamos y escojemos la sentencia a consultar
        if (!$sql && !$this->_sql) {
            throw new Exception('GestorMySQL | La consulta SQL a ejecutar esta vacia.');
        } elseif (!$sql && $this->_sql) {
            $sql = $this->_sql;
        }

        // Se obtiene resultados desde cache en caso solicitado
        $temp = $this->obtenerCache($sql . $campo_llave);
        if (isset($temp)) return $temp;

        // Se confirma conexion a MySQL
        if (!$this->_conectado) {
            $this->conectar();
        }

        // Se obtiene resultados desde MySQL
        $ti = microtime(true);
        if ($resultado = mysqli_query($this->_conexion, $sql)) {
            $final = array();
            $fila = mysqli_fetch_assoc($resultado);
            if ($campo_llave && isset($fila[$campo_llave])) {
                while ($fila) {
                    $final[$fila[$campo_llave]] = $fila;
                    $fila = mysqli_fetch_assoc($resultado);
                }
            } else {
                while ($fila) {
                    $final[] = $fila;
                    $fila = mysqli_fetch_assoc($resultado);
                }
            }
            mysqli_free_result($resultado);

            if ($this->_config['depurar']) {
                $this->notificar('Obtenemos multiples registros desde BD con la siguiente consulta (' . round((microtime(true)-$ti)*1000, 3) . ' ms.) :' .
                    '<pre style="font-weight: normal; font-family: monospace; font-size: 12px;">' . $sql . '</pre>');
            }

            // Se guarda resultados en cache en caso solicitado
            $this->guardarCache($final);

            return $final;
        } else {
            throw new Exception('GestorMySQL | La consulta [ ' . $sql . ' ] dió el siguiente error: ' . mysqli_error($this->_conexion) . '.', 102);
        }
    }

    /**
     * Obtiene multiples registros agrupados
     *
     * @param string $sql Consulta SQL
     * @param string $campo_grupo Campo que desea agrupar
     * @param string $campo_llave Campo que desea como llaves de arreglo
     * @return array Retorna un arreglo con o sin resultados agrupados
     */
    public function obtenerGrupos($sql = null, $campo_grupo, $campo_llave = null)
    {
        // Validamos y escojemos la sentencia a consultar
        if (!$sql && !$this->_sql) {
            throw new Exception('GestorMySQL | La consulta SQL a ejecutar esta vacia.');
        } elseif (!$sql && $this->_sql) {
            $sql = $this->_sql;
        }

        // Se obtiene resultados desde cache en caso solicitado
        $temp = $this->obtenerCache($sql . $campo_grupo . $campo_llave);
        if (isset($temp)) return $temp;

        // Se confirma conexion a MySQL
        if (!$this->_conectado) {
            $this->conectar();
        }

        $ti = microtime(true);

        // Se obtiene resultados desde MySQL
        if ($resultado = mysqli_query($this->_conexion, $sql)) {
            $final = array();
            $fila = mysqli_fetch_assoc($resultado);
            if ($campo_llave && isset($fila[$campo_llave])) {
                while ($fila) {
                    $final[$fila[$campo_grupo]][$fila[$campo_llave]] = $fila;
                    $fila = mysqli_fetch_assoc($resultado);
                }
            } else {
                while ($fila) {
                    $final[$fila[$campo_grupo]][] = $fila;
                    $fila = mysqli_fetch_assoc($resultado);
                }
            }
            mysqli_free_result($resultado);

            if ($this->_config['depurar']) {
                $this->notificar('Obtenemos multiples registros agrupados desde BD con la siguiente consulta (' . round((microtime(true)-$ti)*1000, 3) . ' ms.) :' .
                    '<pre style="font-weight: normal; font-family: monospace; font-size: 12px;">' . $sql . '</pre>');
            }

            // Se guarda resultados en cache en caso solicitado
            $this->guardarCache($final);

            return $final;
        } else {
            throw new Exception('GestorMySQL | La consulta [ ' . $sql . ' ] dió el siguiente error: ' . mysqli_error($this->_conexion) . '.', 102);
        }
    }

    /**
     * Obtiene solo un registro como vector
     *
     * @param string $sql Consulta SQL
     * @return array|boolean Retorna un vector si hay resultados o falso sino hay
     */
    public function obtenerFila($sql = null)
    {
        // Validamos y escojemos la sentencia a consultar
        if (!$sql && !$this->_sql) {
            throw new Exception('GestorMySQL | La consulta SQL a ejecutar esta vacia.');
        } elseif (!$sql && $this->_sql) {
            $sql = $this->_sql;
        }

        // Se obtiene resultados desde cache en caso solicitado
        $temp = $this->obtenerCache($sql);
        if (isset($temp)) return $temp;

        // Se confirma conexion a MySQL
        if (!$this->_conectado) {
            $this->conectar();
        }

        $ti = microtime(true);

        // Se obtiene resultados desde MySQL
        if ($resultado = mysqli_query($this->_conexion, $sql)) {
            $final = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);

            if ($this->_config['depurar']) {
                $this->notificar('Obtenemos solo un registro desde BD con la siguiente consulta (' . round((microtime(true)-$ti)*1000, 3) . ' ms.) :' .
                    '<pre style="font-weight: normal; font-family: monospace; font-size: 12px;">' . $sql . '</pre>');
            }

            // Se guarda resultados en cache en caso solicitado
            $this->guardarCache($final);

            return $final;
        } else {
            throw new Exception('GestorMySQL | La consulta [ ' . $sql . ' ] dió el siguiente error: ' . mysqli_error($this->_conexion) . '.', 102);
        }
    }

    /**
     * Ejecuta una sentencia SQL
     *
     * @param string $sql Sentencia SQL a ejecutar
     * @param string $retorno
     * @return boolean|int
     */
    public function ejecutar($sql = null, $retorno = null)
    {
        // Se confirma conexion a MySQL
        if (!$this->_conectado) {
            $this->conectar();
        }

        $ti = microtime(true);

        // Validamos y escojemos la sentencia a consultar
        if (!$sql && !$this->_sql) {
            throw new Exception('GestorMySQL | La sentencia SQL a ejecutar esta vacia.');
        } elseif (!$sql && $this->_sql) {
            $sql = $this->_sql;
        }

        // Se ejecuta sentencia
        if (mysqli_query($this->_conexion, $sql)) {
            //$log = new Registrador();
            //$log->registrar($sql, 'SQL');
            if ($this->_config['depurar']) {
                $this->notificar('Ejecutamos desde BD la siguiente consulta (' . round((microtime(true)-$ti)*1000, 3) . ' ms.) :' .
                    '<pre style="font-weight: normal; font-family: monospace; font-size: 12px;">' . $sql . '</pre>');
            }

            if ($retorno == 'ultimoid') {
                return mysqli_insert_id($this->_conexion);
            } elseif ($retorno == 'afectados') {
                return mysqli_affected_rows($this->_conexion);
            }
            return true;
        } else {
            throw new Exception('GestorMySQL | La sentencia [ ' . $sql . ' ] dió el siguiente error: ' .  mysqli_error($this->_conexion) . '.', 103);
        }
    }

    /**
     * Prepara una sentencia SQL para su ejecución
     *
     * @param string $sql Sentencia SQL
     * @return mysqli_stmt
     */
    public function prepararSentencia($sql = null)
    {
        if (!$this->_conectado) {
            $this->conectar();
        }

        if (!$sql && !$this->_sql) {
            throw new Exception('GestorMySQL | La sentencia SQL a ejecutar esta vacia.');
        } elseif (!$sql && $this->_sql) {
            $sql = $this->_sql;
        }

        return mysqli_prepare($this->_conexion, $sql);
    }

    /**
     * Obtiene el id incremental generado por la ultima ejecucion
     *
     * @return int|boolean
     */
    public function obtenerUltimoId()
    {
        if ($this->_conectado) {
            return mysqli_insert_id($this->_conexion);
        } else {
            throw new Exception('GestorMySQL | No hay conexión abierta para obtener ultimo id insertado.');
        }
    }

    /**
     * Obtiene la cantidad de registros afectados por la ultima ejecucion
     *
     * @return int
     */
    public function obtenerAfectados()
    {
        if ($this->_conectado) {
            return mysqli_affected_rows($this->_conexion);
        } else {
            throw new Exception('GestorMySQL | No hay conexión abierta para obtener filas afectadas.');
        }
    }

    // METODOS SOBRE CACHE

    /**
     * Implementa cache a la proxima consulta
     *
     * @param int $segundos
     * @param string|null $llave
     * @return GestorMySQL
     */
    public function cache($segundos, $llave = null)
    {
        if (empty($this->gestor_cache)) {
            throw new Exception('GestorMySQL | El gestor de cache no fue definido.');
        }
        $this->_cache_tiempo = $segundos;
        $this->_cache_llave = $llave;
        $this->_cache_activado = true;
        return $this;
    }

    /**
     * Desactiva cache a la proxima consulta
     *
     * @return GestorMySQL
     */
    public function desactivarCache()
    {
        if (empty($this->gestor_cache)) {
            throw new Exception('GestorMySQL | El gestor de cache no fue definido.');
        }
        $this->_cache_tiempo = null;
        $this->_cache_llave = null;
        $this->_cache_activado = false;
        return $this;
    }

    /**
     * Sobrescribe cache a la proxima consulta
     *
     * @return GestorMySQL
     */
    public function sobrescribirCache()
    {
        if (empty($this->gestor_cache)) {
            throw new Exception('GestorMySQL | El gestor de cache no fue definido.');
        }
        $this->_cache_sobrescribir = true;
        return $this;
    }

    /**
     * Obtiene datos directamente desde cache y prepara banderas internas
     *
     * @param string $llave_alterna
     * @return mixed
     */
    private function obtenerCache($llave_alterna)
    {
        if (($this->_cache_tiempo || $this->_config['auto_cache']) && $this->_cache_activado)
        {
            if (empty($this->gestor_cache)) {
                throw new Exception('GestorMySQL | El gestor de cache no fue definido.');
            }
            if (empty($this->_cache_llave)) {
                $this->_cache_llave = md5($llave_alterna);
            }
            if (!$this->_cache_sobrescribir) {
                $resultado = $this->gestor_cache->obtener($this->_cache_llave);
                if ($this->gestor_cache->obtenerCodigo() == 0) {
                    if ($this->_config['depurar']) {
                        $this->notificar('Obtenemos datos desde cache "' .
                            $this->_cache_llave . '" con expiraci&oacute;n de ' .
                            ((empty($this->_cache_tiempo)) ? $this->_config['auto_cache'] : $this->_cache_tiempo) . ' seg.');
                    }
                    $this->_cache_tiempo = null;
                    $this->_cache_llave = null;
                    $this->_cache_activado = true;
                    $this->_cache_sobrescribir = false;
                    return $resultado;
                }
            }
        }
        return null;
    }

    /**
     * Guarda resultados al cache segun banderas internas
     *
     * @param mixed $datos
     * @return void
     */
    private function guardarCache(&$datos)
    {
        if ($this->_cache_tiempo && $this->_cache_activado) {
            if (empty($this->gestor_cache)) {
                throw new Exception('GestorMySQL | El gestor de cache no fue definido.');
            }
            $this->gestor_cache->guardar($this->_cache_llave, $datos, $this->_cache_tiempo);
            if ($this->_config['depurar']) {
                $this->notificar('Guardamos resultados en cache "' .
                    $this->_cache_llave . '" por ' . $this->_cache_tiempo . ' seg.');
            }
        } elseif ($this->_config['auto_cache'] && $this->_cache_activado) {
            if (empty($this->gestor_cache)) {
                throw new Exception('GestorMySQL | El gestor de cache no fue definido.');
            }
            $this->gestor_cache->guardar($this->_cache_llave, $datos, $this->_config['auto_cache']);
            if ($this->_config['depurar']) {
                $this->notificar('Guardamos resultados automaticamente en cache "' .
                    $this->_cache_llave . '" por ' . $this->_config['auto_cache'] . ' seg.');
            }
        }
        $this->_cache_tiempo = null;
        $this->_cache_llave = null;
        $this->_cache_activado = true;
        $this->_cache_sobrescribir = false;
    }

    // METODOS SECUNDARIOS

    /**
     * Descomprime texto comprimido de MySQL
     *
     * @param string $valor
     * @return string
     */
    public function descomprimir($valor)
    {
        return gzuncompress(substr($valor, 4));
    }

    // METODOS CRUD o SIMILARES

    public function iniciarTransaccion()
    {
        mysqli_autocommit($this->_conexion, false);
        return $this;
    }

    public function cerrarTransaccion()
    {
        mysqli_commit($this->_conexion);
        mysqli_autocommit($this->_conexion, true);
        return $this;
    }

    public function cancelarTransaccion()
    {
        mysqli_rollback($this->_conexion);
        mysqli_autocommit($this->_conexion, true);
        return $this;
    }

    /**
     * Inicia la consulta preparada con SELECT
     *
     * @param string $campos
     * @param string|null $tabla
     * @return GestorMySQL
     */
    public function seleccionar($campos, $tabla = null)
    {
        $this->_sql = 'SELECT ' . $campos;
        if ($tabla) $this->_sql .= ' FROM ' . $tabla;
        return $this;
    }

    /**
     * Implementa FROM a la consulta preparada
     *
     * @param string $tabla
     * @return GestorMySQL
     */
    public function de($tabla)
    {
        $this->_sql .= ' FROM ' . $tabla;
        return $this;
    }

    /**
     * Prepara los campos que filtran la consulta preparada
     *
     * @param array $campos_parametrizados
     * @return GestorMySQL
     */
    public function donde(array $campos_parametrizados)
    {
        $terminos = array();
        foreach ($campos_parametrizados as $indice => $valor)
        {
            if (is_array($valor)) {
                $operador = ' ' . $valor[0] . ' ';
                $valor = $valor[1];
            } else {
                $operador = ' = ';
            }
            $temp = explode(':', $indice);
            if (empty($temp[1])) {
                $terminos[] = $temp[0] . $operador . $this->prepararValor($valor);
            } else {
                $terminos[] = $temp[0] . $operador . $this->prepararValor($valor, $temp[1]);
            }
        }

        $this->_sql .= ' WHERE ' . implode(' AND ', $terminos);
        return $this;
    }

    /**
     * Implementa ORDER BY a la consulta preparada
     *
     * @param string $orden
     * @return GestorMySQL
     */
    public function ordenarPor($orden) //	campo1:-, camp2:+, campo3:asc, campo4:DESC
    {
        $orden = str_ireplace(array(':+', ':desc', ':-', ':asc'), array(' DESC ', ' DESC ', ' ASC ', ' ASC '), $orden);
        $this->_sql .= ' ORDER BY ' . trim($orden);
        return $this;
    }

    /**
     * Implementa LIMIT a la consulta preparada
     *
     * @param int $pos
     * @param int $limite
     * @return GestorMySQL
     */
    public function limitar($pos, $limite = null) //	0, 5
    {
        if ($limite) {
            $this->_sql .= ' LIMIT ' . $pos . ',' . $limite;
        } else {
            $this->_sql .= ' LIMIT ' . $pos;
        }
        return $this;
    }

    /**
     * Inicia consulta preparada con UPDATE
     *
     * @param string $tabla
     * @param array $campos_parametrizados
     * @return GestorMySQL
     */
    public function actualizar($tabla, array $campos_parametrizados)
    {
        $terminos = array();
        foreach ($campos_parametrizados as $indice => $valor)
        {
            $temp = explode(':', $indice);
            if (empty($temp[1])) {
                $terminos[] = $temp[0] . '=' . $valor; //$this->_bd->escaparValor($valor);
            } else {
                $terminos[] = $temp[0] . '=' . $this->prepararValor($valor, $temp[1]);
            }
        }

        $this->_sql = 'UPDATE ' . $tabla . ' SET ' . implode(', ', $terminos);
        return $this;
    }

    /**
     * Inicia consulta preparada con INSERT
     *
     * @param string $tabla Tabla
     * @param array $campos_parametrizados Campos parametrizados
     * @return GestorMySQL
     */
    public function insertar($tabla, array $campos_parametrizados)
    {
        $columnas = array();
        $valores = array();
        foreach ($campos_parametrizados as $indice => $valor)
        {
            $temp = explode(':', $indice);
            if (empty($temp[1])) {
                $columnas[] = $temp[0];
                $valores[] = $this->prepararValor($valor);
            } else {
                $columnas[] = $temp[0];
                $valores[] = $this->prepararValor($valor, $temp[1]);
            }
        }

        $this->_sql = 'INSERT INTO ' . $tabla . ' (' . implode(', ', $columnas) . ') VALUES (' . implode(', ', $valores) . ')';
        return $this;
    }

    /**
     * Inicia consulta preparada con DELETE FROM
     *
     * @param string $tabla
     * @return GestorMySQL
     */
    public function eliminar($tabla)
    {
        $this->_sql = 'DELETE FROM ' . $tabla;
        return $this;
    }

    /**
     * Introduce directamente la consulta preparada
     *
     * @param string $sql
     * @param array|null $campos_parametrizados
     * @return GestorMySQL
     */
    public function sql($sql, array $campos_parametrizados = null)
    {
        if ($campos_parametrizados) {
            foreach ($campos_parametrizados as $indice => $valor) {
                $temp = explode(':', $indice);
                if (empty($temp[1])) {
                    $valor_nuevo = $valor;
                } else {
                    $valor_nuevo = $this->prepararValor($valor, $temp[1]);
                }
                $sql = str_replace('['.$temp[0].']', $valor_nuevo, $sql);
            }
        }
        $this->_sql = $sql;
        return $this;
    }

    /**
     * Muestra la consulta preparada hasta el momento
     *
     * @return void
     */
    public function mostrarSql()
    {
        $this->notificar($this->_sql);
    }
}
