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
                                            3 => 'Usuario avanzado',
                                            4 => 'Usuario',
                                            5 => 'Usuario externo');

    // Arreglo catálogo de estados
    static public $arrayEstados = array (   0 => 'Eliminado',
                                            1 => 'Activo',
                                            2 => 'Inactivo',
                                            3 => 'Esperando invitación');

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

    static public function obtener ($cuentaId, $usuarioId)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('contacto_id, usuario, perfil_id, estado, zona_tiempo, fecha_creacion, fecha_actualizacion', 'usuarios');
        $bd->donde(array('cuenta_id:entero' => $cuentaId,
                         'contacto_id:entero' => $usuarioId,
                         'estado:entero'    => array('>',0)));

        return $bd->obtenerFila(null);
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

        $ahora = Fecha::obtenerFechaSQL();

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
            'fecha_creacion:fecha'       => $ahora,
            'fecha_actualizacion:fecha' => $ahora
        ));

        if ($bd->ejecutar()) {
            return $email['valor'];
        } else {
            return false;
        }
    }

    static public function editarPerfil ($cuentaId, $usuarioId, $perfilId)
    {
        $ahora = Fecha::obtenerFechaSQL();

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->actualizar('usuarios', array(
            'perfil_id:entero' => $perfilId,
            'fecha_actualizacion:fecha' => $ahora))
           ->donde(array('cuenta_id:entero' => $cuentaId, 'contacto_id:texto' => $usuarioId));

        return $bd->ejecutar();
    }

    static private function _editarEstado ($cuentaId, $usuarioId, $estadoId)
    {
        $ahora = Fecha::obtenerFechaSQL();

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->actualizar('usuarios', array(
            'estado:entero' => $estadoId,
            'fecha_actualizacion:fecha' => $ahora))
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

    static private function _verificarUsuario ($cuentaId, $correo, $contrasena)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('contacto_id, usuario, perfil_id, zona_tiempo, estado', 'usuarios')
           ->donde(array('cuenta_id:entero' => $cuentaId,
                         'usuario:texto' => $correo,
                         'contrasena:texto' => $contrasena));
        return $bd->obtenerFila();
    }

    static public function iniciarSesion ($cuentaId, $correo, $contrasena)
    {
        // Verificamos el acceso del usuario
        $usuario = self::_verificarUsuario($cuentaId, $correo, $contrasena);
        // Verificamos que el usuario exista, tenga acceso, y no sea usuario externo
        if (!$usuario or $usuario['estado'] != 1 or $usuario['perfil_id'] == 5)
            return false;

        // Si todo esta OK, cargamos los datos del contacto
        $contacto = Contacto::obtener($cuentaId, $usuario['contacto_id']);
        if (!$contacto)
            return false;

        // Si todo esta OK, creamos la sesion
        $_SESSION['USUARIO_ID']     = $usuario['contacto_id'];
        $_SESSION['USUARIO_NOMBRE'] = $contacto['nombre_completo'];
        $_SESSION['USUARIO_PERFIL'] = $usuario['perfil_id'];
        $_SESSION['SESION_TIEMPO']  = time();

        return true;
    }

    static public function verificarSesion ($perfilesPermitidos = null)
    {
        // Si la sesion USUARIO ID esta vacia cerramos sesion
        if (!isset($_SESSION['USUARIO_ID']) or empty($_SESSION['USUARIO_ID'])) {
            header('location: /login/logout');
            exit;
        }

        $tiempoLimite = time() + (60*60); // Una hora
        $tiempoTranscurrido = time() - $_SESSION['SESION_TIEMPO'];

        // Si la sesion exedio el tiempo limite cerramos sesion
        if (!isset($_SESSION['SESION_TIEMPO']) or $tiempoTranscurrido > $tiempoLimite) {
            header('location: /login/logout');
            exit;
        } else {
            $_SESSION['SESION_TIEMPO'] = time();
        }

        if ($perfilesPermitidos)
            self::verificarAcceso($perfilesPermitidos);
    }

    static public function verificarAcceso ($perfilesPermitidos)
    {
        // Si es responsable de cuenta tiene acceso a todo sin consultar
        if ($_SESSION['USUARIO_PERFIL'] <= 1)
            return true;

        if (is_array($perfilesPermitidos)) {
            // Si es un arreglo significa que el acceso es a perfiles especificos
            if (in_array($_SESSION['USUARIO_PERFIL'], $perfilesPermitidos))
                return true;
        } else {
            // Si no es un arreglo, verificamos q el perfil del usuario sea mayor o igual al permitido
            if ($perfilesPermitidos >= $_SESSION['USUARIO_PERFIL'])
                return true;
        }

        // Si no paso ninguna de las vericaciones anteriores denegamos el acceso
        header('location: /');
        exit;
    }
}
