<?php
class Cuenta
{
    static public function obtenerPorSubdominio ()
    {
        // Obtenemos el nombre de la cuenta
        $host       = $_SERVER['HTTP_HOST'];
        $host       = explode('.', $host);
        $subdominio = current($host);

        // Iniciamos conexion con la BD
        $bd = GestorMySQL::obtenerInstancia();

        // Iniciamos consulta
        $bd->seleccionar('cuenta_id, nombre, subdominio, estado, zona_tiempo, fecha_inicio, fecha_vence', 'cuentas')
           ->donde(array('subdominio:texto' => $subdominio));

        $cuenta = $bd->obtenerFila();

        // Verificamos la cuenta
        if (!$cuenta) {
            die('La cuenta no existe o esta suspendida');
        } else {
            // Definimos constantes de la cuenta
            $_SESSION['CUENTA_ID'] = $cuenta['cuenta_id'];
            $_SESSION['SUBDOMINIO'] = $cuenta['subdominio'];
            $_SESSION['CUENTA_NOMBRE'] = $cuenta['nombre'];
            $_SESSION['ZONA_TIEMPO'] = $cuenta['zona_tiempo'];
        }
    }
}