<?php
class Empresa extends Contacto
{
	public function agregar ($cuentaId, $nombre, $razonSocial = null, $descripcion = null)
	{
		return parent::agregarContacto($cuentaId, 2, $razonSocial, $nombre, null, null, null, $descripcion);
	}
	
	public function actualizar ($cuentaId, $contactoId, $nombre, $razonSocial = null, $descripcion = null)
	{
		return parent::actualizarContacto($cuentaId, $contactoId, $razonSocial, $nombre, null, null, null, $descripcion);
	}
}