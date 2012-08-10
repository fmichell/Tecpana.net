<?php
class Cuenta
{
    static public function obtenerPorSubdominio ($subdominio)
    {
        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('cuenta_id, nombre, subdominio, estado, zona_tiempo, fecha_inicio, fecha_vence', 'cuentas')
           ->donde(array('subdominio:texto' => $subdominio));

        return $bd->obtenerFila();
    }
}