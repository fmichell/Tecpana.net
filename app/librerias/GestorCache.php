<?php

/**
 * @name GestorCache
 * @author Nestor Picado Rivera
 * @copyright Nestor Picado Rivera
 * @version 0.4 (2012-03-13)
 */
class GestorCache
{
    private static $_instancias = array();
    private $_instancia;
    /** @var Memcached */
    public $mc;

    /**
     * Constructor ocultado a proposito
     *
     * @param string $instancia
     * @return GestorCache
     */
    private function __construct($instancia)
    {
        $this->_instancia = $instancia;
        $this->mc = new Memcached();
        $this->mc->setOption(Memcached::OPT_NO_BLOCK, true);
        $this->mc->setOption(Memcached::OPT_TCP_NODELAY, true);
        $this->mc->setOption(Memcached::OPT_CONNECT_TIMEOUT, 10); // 50
//        $this->mc->setOption(Memcached::OPT_RETRY_TIMEOUT, 1);
        $this->mc->setOption(Memcached::OPT_POLL_TIMEOUT, 20);
        $this->mc->setOption(Memcached::OPT_REMOVE_FAILED_SERVERS, true);
    }

    /**
     * @return void
     */
    public function __clone()
    {
        throw new Exception('GestorCache | No puedes clonar esta instancia de clase.');
    }

    /**
     * @return void
     */
    public function __wakeup()
    {
        throw new Exception('GestorCache | No puedes deserializar esta instancia de clase.');
    }

    /**
     * @return void
     */
    public function __sleep()
    {
        throw new Exception('GestorCache | No puedes serializar esta instancia de clase.');
    }

    /**
     * Establece las configuraciones generales
     *
     * @param array $config
     * @return GestorCache
     */
    public function configurar(array $config)
    {
        if (!empty($config['consistente'])) {
            $this->mc->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
            $this->mc->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
        }

        if (!empty($config['compresion'])) {
            $this->mc->setOption(Memcached::OPT_COMPRESSION, $config['compresion']);
        }

        if (!empty($config['replicas'])) {
            $this->mc->setOption(Memcached::OPT_NUMBER_OF_REPLICAS, $config['replicas']);
        }

        if (!empty($config['otros'])) {
            if (!is_array($config['otros'])) {
                throw new Exception('GestorCache | La opcion [otros] debe ser un arreglo.');
            }
            foreach ($config['otros'] as $llave => $valor) {
                $this->mc->setOption($llave, $valor);
            }
        }

        if (!empty($config['servidores'])) {
            foreach ($config['servidores'] as $llave => $servidor) {
                $conexion = @fsockopen($servidor[0], $servidor[1], $errno, $errstr, 0.02);
                if (!$conexion) {
                    unset($config['servidores'][$llave]);
                } else {
                    fclose($conexion);
                }
            }
            $this->mc->addServers($config['servidores']);
        }

        return $this;
    }

    /**
     * Obtiene instancias unicas del gestor
     *
     * @param string $instancia Nombre de la instancia
     * @return GestorCache
     */
    public static function obtenerInstancia($instancia = 'prod')
    {
        if (isset(self::$_instancias[$instancia])) {
            return self::$_instancias[$instancia];
        } else {
            self::$_instancias[$instancia] = new self($instancia);
            return self::$_instancias[$instancia];
        }
    }

    /**
     * Guarda datos de una llave
     *
     * @param string $llave
     * @param mixed $datos
     * @param int $expiracion
     * @return boolean
     */
    public function guardar($llave, $datos, $expiracion = 0)
    {
        return $this->mc->set($llave, $datos, $expiracion);
    }

    /**
     * Obtiene datos de una llave
     *
     * @param string $llave
     * @return mixed
     */
    public function obtener($llave)
    {
        return $this->mc->get($llave);
    }

    /**
     * Retorna el codigo del resultado de la ultima operacion
     *
     * @return int
     */
    public function obtenerCodigo()
    {
        return $this->mc->getResultCode();
    }

    /**
     * Elimina una llave
     *
     * @param string $llave
     * @return mixed
     */
    public function eliminar($llave)
    {
        return $this->mc->delete($llave);
    }
}
