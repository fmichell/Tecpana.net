<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: alrededor del 23-06-2012
 * @fechaModificacion: 28-07-2012
 * @version: 1.0
 * @descripcion: Métodos espécificos para las Personas. Hereda desde Contactos.
 */
require_once 'CamposContacto.php';

class Persona extends Contacto
{
	// Agregar empresa
    static public function agregar ($cuentaId, $nombre, $apellidos = null, $sexo = null, $titulo = null, $profesion = null, $empresaId = null)
    {
        return parent::insertarContacto($cuentaId, 1, $nombre, $apellidos, $sexo, $titulo, $profesion, $empresaId);
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

    static public function agregarCargo ($cuentaId, $contactoId, $cargo)
    {
        $tipo = CamposContacto::$tiposInfo['cargo']['id'];
        return self::insertarInfo($cuentaId, $contactoId, $tipo, $cargo);
    }

    // Editar persona
    static public function editar ($cuentaId, $contactoId, $nombre, $apellidos = null, $sexo = null, $titulo = null, $profesion = null, $empresaId = null)
    {
        return parent::editarContacto($cuentaId, $contactoId, 1, $nombre, $apellidos, $sexo, $titulo, $profesion, $empresaId);
    }
}