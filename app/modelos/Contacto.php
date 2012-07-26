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
        $consulta = sprintf("SELECT contacto_id, tipo, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo, nombre, apellidos, sexo, titulo, descripcion, foto, empresa_id
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
        $consulta = sprintf("SELECT contacto_id, tipo, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo, nombre, apellidos, sexo, titulo, descripcion, foto, empresa_id
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

    static public function obtenerEmpleados ($cuentaId, $empresaId)
    {
        $contactos = self::_cargarContactos($cuentaId, null, 'PERSONAS');

        $tabla = new Tabla($contactos);
        $tabla->filtrar("{empresa_id} = '$empresaId'");
        $contactos = $tabla->obtener();

        $ids = array_keys($contactos);
        if (!empty($ids)) {
            $contactos_infos = self::_cargarInfos($cuentaId, $ids);

            foreach ($contactos_infos as $contacto_id => $infos) {
                $contactos[$contacto_id] += self::_ordenarInfo($infos);
            }
        }

        return $contactos;
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

        if (!empty($ids)) {
            $contactos_infos = self::_cargarInfos($cuentaId, $ids);

            foreach ($contactos_infos as $contacto_id => $infos) {
                $contactos[$contacto_id] += self::_ordenarInfo($infos);
            }
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

    static public function obtenerFotos ($foto, $tipo = 1, $sexo = 1)
    {
        $path = PROFILE_PICTURES_PATH;
        $uri  = '/media/profile';
        $arrayRetorno = array('hayProfile' => false, 'hayThumbnail' => false);

        if ($tipo == 1) {
            // Buscamos foto perfil
            if (($foto) and file_exists($path . '/picture/' . $foto)) {
                $arrayRetorno['hayProfile'] = true;
                $arrayRetorno['uriProfile'] = $uri . '/picture/' . $foto;
            } else {
                // Si no hay foto cargamos fotos por defecto
                if ($sexo == 1) {
                    // Si es hombre
                    $arrayRetorno['uriProfile'] = '/media/imgs/maleContact.jpg';
                } else {
                    // Si es mujer
                    $arrayRetorno['uriProfile'] = '/media/imgs/famaleContact.jpg';
                }
            }

            // Buscamos thumbnail
            if (($foto) and file_exists($path . '/thumbnail/' . $foto)) {
                $arrayRetorno['hayThumbnail'] = true;
                $arrayRetorno['uriThumbnail'] = $uri . '/thumbnail/' . $foto;
            } else {
                // Si no hay foto cargamos fotos por defecto
                if ($sexo == 1) {
                    // Si es hombre
                    $arrayRetorno['uriThumbnail'] = '/media/imgs/maleThumb.jpg';
                } else {
                    // Si es mujer
                    $arrayRetorno['uriThumbnail'] = '/media/imgs/famaleThumb.jpg';
                }
            }
        } else {
            // Buscamos logo empresa
            if (($foto) and file_exists($path . '/picture/' . $foto)) {
                $arrayRetorno['hayProfile'] = true;
                $arrayRetorno['uriProfile'] = $uri . '/picture/' . $foto;
            } else {
                // Si no hay foto cargamos fotos por defecto
                $arrayRetorno['uriProfile'] = '/media/imgs/businessContact.jpg';
            }

            // Buscamos thumbnail
            if (($foto) and file_exists($path . '/thumbnail/' . $foto)) {
                $arrayRetorno['hayThumbnail'] = true;
                $arrayRetorno['uriThumbnail'] = $uri . '/thumbnail/' . $foto;
            } else {
                // Si no hay foto cargamos fotos por defecto
                $arrayRetorno['uriThumbnail'] = '/media/imgs/businessThumb.jpg';
            }
        }

        return $arrayRetorno;
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

    static private function _actualizarFoto ($cuentaId, $contactoId, $profilePicture)
    {
        // Definimos variables generales
        $ahora = date('Y-m-d H:i:s');

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->actualizar('contactos', array(
            'foto:texto'               => $profilePicture,
            'fecha_modificacion:fecha' => $ahora));
        $bd->donde(array(
            'cuenta_id:entero'     => $cuentaId,
            'contacto_id:texto'    => $contactoId));

        return $bd->ejecutar();
    }

    static public function eliminarFoto ($cuentaId, $contactoId, $limpiarCampo = false)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Inicializamos consulta
        $bd->seleccionar('foto', 'contactos');
        $bd->donde(array(
            'cuenta_id:entero'     => $cuentaId,
            'contacto_id:texto'    => $contactoId));

        $resultado = $bd->obtenerFila();
        if ($resultado['foto']) {
            if (file_exists(PROFILE_PICTURES_PATH . '/picture/' . $resultado['foto']))
                unlink(PROFILE_PICTURES_PATH . '/picture/' . $resultado['foto']);
            if (file_exists(PROFILE_PICTURES_PATH . '/thumbnail/' . $resultado['foto']))
                unlink(PROFILE_PICTURES_PATH . '/thumbnail/' . $resultado['foto']);

            if ($limpiarCampo) {
                $bd->actualizar('contactos', array(
                    'foto:texto'           => ''
                ));
                $bd->donde(array(
                    'cuenta_id:entero'     => $cuentaId,
                    'contacto_id:texto'    => $contactoId))->ejecutar();
            }
            return true;
        } else {
            return false;
        }
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

    static public function subirFotoPerfil ($mediaInput, $contactoId, $tipo = 'subida')
    {
        $tmp_dir = PROFILE_PICTURES_PATH . '/tmp/';

        if (move_uploaded_file($mediaInput['tmp_name'], $tmp_dir.$mediaInput['name'])) {
            $tmpFile = $tmp_dir.$mediaInput['name'];
        } else {
            return false;
        }

        if (!isset($tmpFile)) {
            return false;
        }

        // Obteniendo informacion de la foto
        $tmpFileInfo = getimagesize($tmpFile);

        // Creando foto
        switch ($tmpFileInfo['mime']) {
            case 'image/gif':
                $temp = imagecreatefromgif($tmpFile);
                break;
            case 'image/jpeg':
                $temp = imagecreatefromjpeg($tmpFile);
                break;
            case 'image/png':
                $temp = imagecreatefrompng($tmpFile);
                break;
        }

        // Obtengo tamaño de foto original
        $ancho_original = $tmpFileInfo[0];
        $alto_original  = $tmpFileInfo[1];

        // Redimencionamos la foto si es necesario
        if ($ancho_original > 500) {
            $ancho_nuevo    = 500;
            $ancho_escala   = $ancho_original / $ancho_nuevo;
            $alto_nuevo     = round($alto_original / $ancho_escala);
        } else {
            $ancho_nuevo    = $ancho_original;
            $alto_nuevo     = $alto_original;
        }

        // Creamos foto jpg
        $jpgFile = $tmp_dir.$contactoId.'.jpg';
        $foto_nueva = imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
        imagecopyresampled($foto_nueva, $temp, 0, 0, 0, 0, $ancho_nuevo, $alto_nuevo, $ancho_original, $alto_original);
        imagejpeg($foto_nueva, $jpgFile, 80);
        imagedestroy($temp);
        imagedestroy($foto_nueva);

        // Eliminamos foto original
        if (file_exists($tmpFile))
            unlink($tmpFile);

        return array('uri' => $jpgFile, 'nombre' => $contactoId.'.jpg');
    }

    static public function cargarFotoPerfil ($mediaInput, $contactoId)
    {
        // Globales
        $path = PROFILE_PICTURES_PATH;
        $name = $contactoId . '_' . time() . '.jpg';
        $uri  = '/media/profile';

        // Obtenermos la imagen original sin cortar
        $tmp_file = $mediaInput['uri'];

        // Verificamos que la imagen exista
        if (!file_exists($tmp_file)) {
            return false;
        } else {
            $tmp_img = imagecreatefromjpeg($tmp_file);
        }

        // Creamos marco basado en las dimenciones seleccionadas por el usuario
        $foto_perfil = imagecreatetruecolor($mediaInput['w'], $mediaInput['h']);
        // Recortamos la imagen basado en las cordenadas seleccionadas por el usuario
        // y la metemos dentro del cuadro creado
        imagecopyresampled($foto_perfil, $tmp_img, 0, 0, $mediaInput['x'], $mediaInput['y'], $mediaInput['w'], $mediaInput['h'], $mediaInput['w'], $mediaInput['h']);

        // Obtenemos el tamaño de la nueva foto original
        $ancho_original = $mediaInput['w'];
        $alto_original  = $mediaInput['h'];

        // Declaramos dimenciones finales de la imagen
        $profile = array('w' => 128, 'h' => 128);
        $thumb   = array('w' => 48, 'h' => 48);

        // Creamos profile pic (la grande)
        $jpgFile = $path . '/picture/' . $name;
        $profile_pic = imagecreatetruecolor($profile['w'], $profile['h']);
        imagecopyresampled($profile_pic, $foto_perfil, 0, 0, 0, 0, $profile['w'], $profile['h'], $ancho_original, $alto_original);
        imagejpeg($profile_pic, $jpgFile, 100);
        $arrayArchivos['profile'] = $uri . '/picture/' . $name;

        // Creamos thumbnail pic (la pequeña)
        $jpgFile = $path . '/thumbnail/' . $name;
        $thumbnail_pic = imagecreatetruecolor($thumb['w'], $thumb['h']);
        imagecopyresampled($thumbnail_pic, $foto_perfil, 0, 0, 0, 0, $thumb['w'], $thumb['h'], $ancho_original, $alto_original);
        imagejpeg($thumbnail_pic, $jpgFile, 100);
        $arrayArchivos['thumbnail'] = $uri . '/thumbnail/' . $name;

        // Destruimos las imagenes temporales almacenadas en memora
        imagedestroy($tmp_img);
        imagedestroy($foto_perfil);
        imagedestroy($profile_pic);
        imagedestroy($thumbnail_pic);
        unlink($tmp_file);

        // Eliminamos el archivo anterior si lo hay
        self::eliminarFoto(CUENTA_ID, $contactoId);

        // Guardamos los path's en la base de datos
        self::_actualizarFoto(CUENTA_ID, $contactoId, $name);

        // Retornamos resultado
        return array('estado' => true, 'url' => $arrayArchivos);
    }

    //-> Etiquetas
    static public function obtenerPorEtiqueta ($cuentaId, $etiquetaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('contacto_id', 'contactos_etiquetas')->donde(array(
            'cuenta_id:entero' => $cuentaId,
            'etiqueta_id:entero' => $etiquetaId));
        return $bd->obtener(null, 'contacto_id');
    }

    static public function obtenerEtiquetas ($cuentaId, $contactoId)
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

    static public function obtenerIdEtiquetas ($cuentaId, $contactoId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $consulta = sprintf('SELECT etiqueta_id FROM contactos_etiquetas USE INDEX (POR_CONTACTO) WHERE cuenta_id = %u AND contacto_id = %s',
            $bd->escaparValor($cuentaId, 'entero'),
            $bd->escaparValor($contactoId, 'texto'));


        return $bd->obtener($consulta, 'etiqueta_id');
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
        $bd->ejecutar($consulta);

        return $bd->obtenerAfectados();
    }

    static public function eliminarEtiqueta ($cuentaId, $contactoId, $etiquetaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->eliminar('contactos_etiquetas')->donde(array(
            'cuenta_id:entero' => $cuentaId,
            'contacto_id:texto' => $contactoId,
            'etiqueta_id:entero' => $etiquetaId));
        return $bd->ejecutar();
    }
}