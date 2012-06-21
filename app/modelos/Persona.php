<?php
require_once 'CamposContacto.php';

class Persona extends Contacto
{
	// Agregar empresa
    static public function agregar ($cuentaId, $nombre, $apellidos = null, $sexo = null, $titulo = null, $cargo = null, $empresaId = null)
    {
        return parent::insertarContacto($cuentaId, 1, $nombre, $apellidos, $sexo, $titulo, $cargo, $empresaId);
    }
    
    // Agregar info
    static public function agregarTelefono ($cuentaId, $contactoId, $telefono, $modo, $principal = 0)
    {
        $tipo = CamposContacto::$tiposInfo['telefono']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $telefono, null, $modo, null, $principal);
    }
    
    static public function agregarEmail ($cuentaId, $contactoId, $email, $modo, $principal = 0)
    {
        $tipo = CamposContacto::$tiposInfo['email']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $email, null, $modo, null, $principal);
    }
    
    static public function agregarMensajeria ($cuentaId, $contactoId, $usuario, $servicios, $principal = 0)
    {
        $tipo = CamposContacto::$tiposInfo['mensajeria']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $usuario, null, null, $servicios, $principal);
    }
    
    static public function agregarWeb ($cuentaId, $contactoId, $url)
    {
        $tipo = CamposContacto::$tiposInfo['web']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $url, null, null);
    }
    
    static public function agregarRSociales ($cuentaId, $contactoId, $valor, $servicios)
    {
        $tipo = CamposContacto::$tiposInfo['rsociales']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $valor, null, null, $servicios);
    }
    
    static public function agregarDireccion ($cuentaId, $contactoId, $direccion, $ciudad, $estado, $pais, $cpostal)
    {
        $tipo = CamposContacto::$tiposInfo['direccion']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, null, $direccion, null, null, 0, $ciudad, $estado, $pais, $cpostal);
    }
}