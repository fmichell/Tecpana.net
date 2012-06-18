<?php
class Persona extends Contacto
{
	public static function agregar ($cuentaId, $nombre, $apellidos = null, $sexo = null, $titulo = null, $descripcion = null, $empresaId = null)
	{
		return parent::agregarContacto($cuentaId, 1, null, $nombre, $apellidos, $sexo, $titulo, $descripcion, $empresaId);
	}
	
	public static function actualizar ($cuentaId, $contactoId, $nombre, $apellidos = null, $sexo = null, $titulo = null, $descripcion = null, $empresaId = null)
	{
		return parent::actualizarContacto($cuentaId, $contactoId, null, $nombre, $apellidos, $sexo, $titulo, $descripcion, $empresaId);
	}
}