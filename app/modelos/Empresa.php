<?php
require_once 'CamposContacto.php';

class Empresa extends Contacto
{
	// Agregar empresa
    static public function agregar ($cuentaId, $razonSocial, $giro = null)
    {
        return parent::insertarContacto($cuentaId, 2, $razonSocial, null, null, null, $giro);
    }
    
    // Agregar info
    static public function agregarProductos ($cuentaId, $contactoId, $productos)
    {
        $tipo = CamposContacto::$tiposInfo['productos']['id'];
        return parent::insertarInfo($cuentaId, $contactoId, $tipo, null, $productos);
    }
    
    static public function agregarTelefono ($cuentaId, $contactoId, $telefono, $modo, $principal = 0)
    {
        $tipo = CamposContacto::$tiposInfo['telefono_e']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $telefono, null, $modo, null, $principal);
    }
    
    static public function agregarEmail ($cuentaId, $contactoId, $email, $principal = 0)
    {
        $tipo = CamposContacto::$tiposInfo['email_e']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $email, null, null, null, $principal);
    }
    
    static public function agregarMensajeria ($cuentaId, $contactoId, $usuario, $modo, $servicios, $principal = 0)
    {
        $tipo = CamposContacto::$tiposInfo['mensajeria']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $usuario, null, $modo, $servicios, $principal);
    }
    
    static public function agregarWeb ($cuentaId, $contactoId, $url, $modo)
    {
        $tipo = CamposContacto::$tiposInfo['web']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $url, null, $modo);
    }
    
    static public function agregarRSociales ($cuentaId, $contactoId, $valor, $modo, $servicios)
    {
        $tipo = CamposContacto::$tiposInfo['rsociales']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $valor, null, $modo, $servicios);
    }
    
    static public function agregarDireccion ($cuentaId, $contactoId, $direccion, $ciudad, $estado, $pais, $cpostal, $modo)
    {
        $tipo = CamposContacto::$tiposInfo['direccion']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, null, $direccion, $modo, null, 0, $ciudad, $estado, $pais, $cpostal);
    }
}