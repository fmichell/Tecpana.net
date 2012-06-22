<?php
abstract class CamposContacto
{
    static public $tiposInfo = array(
                                        // Personas
                                        'telefono'      => array(
                                                        'id' => 1,
                                                        'titulo' => 'Teléfono(s)',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Celular',
                                                                    '3' => 'Casa',
                                                                    '4' => 'Trabajo',
                                                                    '5' => 'Fax')
                                                            ),
                                        'email'         => array(
                                                        'id' => 2,
                                                        'titulo' => 'Email(s)',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Trabajo',
                                                                    '3' => 'Personal')
                                                            ),
                                        'mensajeria'    => array(
                                                        'id' => 3,
                                                        'titulo' => 'Mensajería',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Trabajo',
                                                                    '3' => 'Personal'),
                                                        'servicios' => array(
                                                                    '1' => 'MSN',
                                                                    '2' => 'Skype',
                                                                    '3' => 'GoogleTalk',
                                                                    '4' => 'Yahoo',
                                                                    '5' => 'AIM',
                                                                    '6' => 'ICQ',
                                                                    '7' => 'Jabber')
                                                            ),
                                        'web'           => array(
                                                        'id' => 4,
                                                        'titulo' => 'Sitio(s) web',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Trabajo',
                                                                    '3' => 'Personal')
                                                            ),
                                        'rsociales'     => array(
                                                        'id' => 5,
                                                        'titulo' => 'Redes sociales',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Trabajo',
                                                                    '3' => 'Personal'),
                                                        'servicios' => array(
                                                                    '1' => 'Facebook',
                                                                    '2' => 'Twitter',
                                                                    '3' => 'Google+')
                                                            ),
                                        'direccion'     => array(
                                                        'id' => 6,
                                                        'titulo' => 'Dirección(es)',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Trabajo',
                                                                    '3' => 'Personal')
                                                            ),
                                        // Empresas
                                        'productos'     => array(
                                                        'id' => 7,
                                                        'titulo' => 'Productos y/o servicios'),
                                        'telefono_e'    => array(
                                                        'id' => 8,
                                                        'titulo' => 'Teléfono(s)',
                                                        'modo' => array(
                                                                    '1' => 'General',
                                                                    '2' => 'Celular',
                                                                    '3' => 'Fax')
                                                            ),
                                        'email_e'       => array(
                                                        'id' => 9,
                                                        'titulo' => 'Email(s)'),
                                        'mensajeria_e'  => array(
                                                        'id' => 10,
                                                        'titulo' => 'Mensajería',
                                                        'servicios' => array(
                                                                    '1' => 'MSN',
                                                                    '2' => 'Skype',
                                                                    '3' => 'GoogleTalk',
                                                                    '4' => 'Yahoo',
                                                                    '5' => 'AIM',
                                                                    '6' => 'ICQ',
                                                                    '7' => 'Jabber')
                                                            ),
                                        'web_e'         => array(
                                                        'id' => 11,
                                                        'titulo' => 'Sitio(s) web'),
                                        'rsociales_e'   => array(
                                                        'id' => 12,
                                                        'titulo' => 'Redes sociales',
                                                        'servicios' => array(
                                                                    '1' => 'Facebook',
                                                                    '2' => 'Twitter',
                                                                    '3' => 'Google+')
                                                            ),
                                        'direccion_e'     => array(
                                                        'id' => 13,
                                                        'titulo' => 'Dirección(es)')
                                );

    static public function obtenerPaises ()
    {
        $bd = GestorMySQL::obtenerInstancia();

        $consulta = "SELECT id, pais FROM paises ORDER BY pais";

        return $bd->obtener($consulta, 'id');
    }
}