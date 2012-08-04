<?php
/**
 * @autor: Federico Michell Vijil (@fmichell)
 * @fechaCreacion: 29-07-2012
 * @fechaModificacion: 29-07-2012
 * @version: 1.0
 * @descripcion: Clase para controlar usuarios y sesiones de usuario
 */
class Usuario
{
    // Arreglo catálogo de perfiles
    static public $arrayPerfiles = array(   1 => 'Responsable de cuenta',
                                            2 => 'Administador',
                                            3 => 'Usuario',
                                            4 => 'Usuario externo');

    static public function obtenerTodos ($cuentaId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('contacto_id, usuario, perfil_id, estado, zona_tiempo, fecha_creacion, fecha_actualizacion', 'usuarios');
        $bd->donde(array('cuenta_id:entero' => $cuentaId,
                         'estado:entero'    => array('>',0)));

        return $bd->obtener(null, 'contacto_id');
    }

    static public function convertirUsuario ($cuentaId, $contactoId, $perfilId)
    {
        // Cargamos los datos del contacto a convertir
        $contacto = Contacto::obtener($cuentaId, $contactoId);
        if (!$contacto)
            return false;

        // Obtenermos correo electrónico del contacto
        if (!isset($contacto['email']))
            return false;
        else
            $email = current($contacto['email']);
        // Generamos contraseña temporal
        $password = md5(uniqid('pw'));
        // Definimos el estado inicial en 3 (invitado pero inactivo)
        $status = 3;

        $hoy = date('Y-m-d H:i:s');

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->insertar('usuarios', array(
            'cuenta_id:entero'          => $cuentaId,
            'contacto_id:texto'         => $contacto['contacto_id'],
            'usuario:texto'             => $email['valor'],
            'contrasena:texto'          => $password,
            'perfil_id:entero'          => $perfilId,
            'estado:entero'             => $status,
            'fecha_creacion:fecha'       => $hoy,
            'fecha_actualizacion:fecha' => $hoy
        ));

        if ($bd->ejecutar()) {
            return $email['valor'];
        } else {
            return false;
        }
    }

    static public function editarPerfil ($cuentaId, $usuarioId, $perfilId)
    {
        $hoy = date('Y-m-d H:i:s');

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->actualizar('usuarios', array(
            'perfil_id:entero' => $perfilId,
            'fecha_actualizacion:fecha' => $hoy))
           ->donde(array('cuenta_id:entero' => $cuentaId, 'contacto_id:texto' => $usuarioId));

        return $bd->ejecutar();
    }

    static private function _editarEstado ($cuentaId, $usuarioId, $estadoId)
    {
        $hoy = date('Y-m-d H:i:s');

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->actualizar('usuarios', array(
            'estado:entero' => $estadoId,
            'fecha_actualizacion:fecha' => $hoy))
            ->donde(array('cuenta_id:entero' => $cuentaId, 'contacto_id:texto' => $usuarioId));

        return $bd->ejecutar();
    }

    static public function eliminar ($cuentaId, $usuarioId)
    {
        return self::_editarEstado($cuentaId, $usuarioId, 0);
    }

    static public function activar ($cuentaId, $usuarioId)
    {
        return self::_editarEstado($cuentaId, $usuarioId, 1);
    }

    static public function desactivar ($cuentaId, $usuarioId)
    {
        return self::_editarEstado($cuentaId, $usuarioId, 2);
    }
}
