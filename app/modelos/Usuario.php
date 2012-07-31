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
        $bd->donde(array('cuenta_id:entero' => $cuentaId));

        return $bd->obtener(null, 'contacto_id');
    }


}
