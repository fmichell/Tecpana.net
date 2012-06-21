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
                      'servicios:entero'        => $servicios,
                      'ciudad:texto'            => $ciudad,
                      'estado:texto'            => $estado,
                      'pais_id:entero'          => $paisId,
                      'cpostal:texto'           => $cpostal,
                      'fecha_creacion:fecha'    => $ahora,
                      'fecha_modificacion:fecha' => $ahora));
                      
        return $bd->ejecutar();
    }
    
    
}