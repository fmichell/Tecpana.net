<?php
class Contacto
{	
    // METODOS ESTATICOS
    
    // -->
    
    /**
     * Insertar un nuevo contacto en la BD
     * 
     * @param string $cuentaId
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
     * Inserta un nuevo detalle de contacto en la BD
     * 
     * @param string $cuentaId
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
     * Recibe los datos completos del POST, filtra solo los que sean Info y los ordena
     *
     * @param array $arrayInfo
     * @return array
     */
    static public function prepararInfo ($arrayInfo)
    {
        $campos = array_keys(CamposContacto::$tiposInfo);
        $retorno = array();

        foreach ($arrayInfo as $llaveCampo => $campo) {
            // Si el campo no esta definido en el arreglo de campos lo omitimos
            // Estamos asumiendo que si no esta es porque es un modo, servicio u otro especial
            if (!in_array($llaveCampo, $campos))
                continue;

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

}