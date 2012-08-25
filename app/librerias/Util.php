<?php
/**
 * @author Federico Michell
 * @version 1.0
 * 
 * Funciones utiles para todo el portal
 */

//===============================================================
//= FUNCIONES PARA DEPURAR CODIGO
//===============================================================

/**
 * Muestra el contenido detallado de una variable
 * 
 * @version 1.0
 * @return void
 */
function util_depurar_var($valor, $tiempo_inicial = null)
{
	echo "\r\n<div style=\"border: solid 2px #CCC; padding: 5px\">\r\n";
	echo "<pre>\r\n";
	var_export($valor);
	//print_r($valor);
	echo "\r\n</pre>\r\n";
	if ($tiempo_inicial) echo "Ejecutado en " . round((microtime(true)-$tiempo_inicial)*1000, 3) . " ms.\r\n";
	echo "</div>\r\n";
}

/**
 * Muestra el contenido detallado de todas las variables pasadas
 * 
 * @version 1.0
 * @return void
 */
function util_mostrar_variables_pasadas() {
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
	echo "<title>Variables Pasadas</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<table width=\"100\" border=\"0\" cellpadding=\"5\" cellspacing=\"5\" summary=\"Listado de variables pasadas\">\n";
	echo "	<caption style=\"font-size: 16px; font-weight: bold;\">\n";
	echo "		Variables Pasadas\n";
	echo "	</caption>\n";
	foreach ( $_POST as $indice => $valor ) {
		echo "	<tr align=\"left\" valign=\"top\">\n";
		echo "		<th nowrap=\"nowrap\" bgcolor=\"#EEE\" scope=\"row\">\$_POST[\"" . $indice . "\"]</th>\n";
		if (is_array($valor) || is_object($valor)) {
			echo "		<td nowrap=\"nowrap\" bgcolor=\"#EEE\"><pre>";
			echo trim(var_dump($valor));
			echo "</pre></td>\n";
		} else {
			echo "		<td nowrap=\"nowrap\" bgcolor=\"#EEE\">";
			echo trim(var_dump($valor));
			echo "</td>\n";
		}
		echo "	</tr>\n";
	}	
	foreach ( $_GET as $indice => $valor ) {
		echo "	<tr align=\"left\" valign=\"top\">\n";
		echo "		<th nowrap=\"nowrap\" bgcolor=\"#EEE\" scope=\"row\">\$_GET[\"" . $indice . "\"]</th>\n";
		if (is_array($valor) || is_object($valor)) {
			echo "		<td nowrap=\"nowrap\" bgcolor=\"#EEE\"><pre>";
			echo trim(var_dump($valor));
			echo "</pre></td>\n";
		} else {
			echo "		<td nowrap=\"nowrap\" bgcolor=\"#EEE\">";
			echo trim(var_dump($valor));
			echo "</td>\n";
		}
		echo "	</tr>\n";
	}	
	foreach ( $_FILES as $indice => $valor ) {
		echo "	<tr align=\"left\" valign=\"top\">\n";
		echo "		<th nowrap=\"nowrap\" bgcolor=\"#EEE\" scope=\"row\">\$_FILES[\"" . $indice . "\"]</th>\n";
		if (is_array($valor) || is_object($valor)) {
			echo "		<td nowrap=\"nowrap\" bgcolor=\"#EEE\"><pre>";
			echo trim(var_dump($valor));
			echo "</pre></td>\n";
		} else {
			echo "		<td nowrap=\"nowrap\" bgcolor=\"#EEE\">";
			echo trim(var_dump($valor));
			//echo trim(var_export($valor, true));
			echo "</td>\n";
		}
		echo "	</tr>\n";
	}
	echo "</table>\n";
	echo "</body>\n";
	echo "</html>\n";
	exit();
}

//===============================================================
//= FUNCIONES DE CODIFICACION
//===============================================================

/**
 * Detecta la codificacion del texto
 * 
 * @version 1.0
 * @param mixed $valor
 * @return mixed
 */
function util_detecta_codificacion($valor)
{
	return mb_detect_encoding($valor.'a', 'ASCII,UTF-8,ISO-8859-1,ISO-8859-15');	//ASCII,
	$c = 0;
	$ascii = true;
	for ($i = 0; $i < strlen($valor); $i++) {
		$byte = ord($valor[$i]);
		if ($c > 0) {
			if (($byte>>6) != 0x2) {
				return 'ISO-8859-1';
			} else {
				$c--;
			}
		} elseif ($byte&0x80) {
			$ascii = false;
			if (($byte>>5) == 0x6) {
				$c = 1;
			} elseif (($byte>>4) == 0xE) {
				$c = 2;
			} elseif (($byte>>3) == 0x1E) {
				$c = 3;
			} else {
				return 'ISO-8859-1';
			}
		}
	}
	return ($ascii) ? 'ASCII' : 'UTF-8';
}

/**
 * Codifica una cadena a UTF-8 o ISO-8859-1
 * 
 * @version 1.0
 * @param mixed $valor Valor a codificar
 * @param string $codificacion Codificacion a usar
 * @return mixed
 */
function util_codificar($valor, $codificacion = 'UTF-8')
{
	if (is_array($valor)) {
		foreach($mixto as $indice => $cont) {
			$salida[util_codificar($indice, $codificacion)] = util_codificar($cont, $codificacion);
		}
		return $salida;
	} else {
		$codificacion_detectada = util_detecta_codificacion($valor);
		
		if ( $codificacion_detectada == $codificacion ) {
			return $valor;
		} else if ( $codificacion_detectada == 'ISO-8859-1' && $codificacion == 'UTF-8' ) {
			return utf8_encode($valor);
		} else if ( $codificacion_detectada == 'UTF-8' && $codificacion == 'ISO-8859-1' ) {
			return utf8_decode($valor);
		} else {
			return iconv($codificacion_detectada, $codificacion . '//TRANSLIT//IGNORE', $valor);
		}
	}
}

// FUNCIONES PARA MANIPULAR TEXTOS

/**
 * Convierte los acentos a letras normales
 *
 * @version 1.0
 * @param string $valor
 * @return string
 */
function util_quitar_acentos($valor)
{
    return str_replace(
        array('Á','À','Ä','á','à','ä','É','È','Ë','é','è','ë','Í','Ì','Ï','í','ì','ï','Ó','Ò','Ö','ó','ò','ö','Ú','Ù','Ü','ú','ù','ü', 'ñ', 'Ñ'),
        array('A','A','A','a','a','a','E','E','E','e','e','e','I','I','I','i','i','i','O','O','O','o','o','o','U','U','U','u','u','u', 'n', 'N'),
        $valor);
}

/**
 * util_conv_seo()
 *
 * @version 1.2
 * @param string $texto Texto a formatear
 * @return string Retorna el texto con formato SEO
 */
function util_conv_seo($texto)
{
    $codi = util_detecta_codificacion($texto);
    if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
    $valor = html_entity_decode($texto, ENT_QUOTES, $codi);
    $texto = util_codificar($texto, 'UTF-8');
    $texto = util_quitar_acentos($texto);
    $texto = util_codificar($texto, 'ASCII');
    $texto = str_replace(array("'", '"', '~', '.'), '', $texto);
    $texto = strtolower($texto);
    $texto = trim( preg_replace('/[^ A-Za-z0-9_]/', ' ', $texto) );
    $texto = preg_replace("/[ \t\n\r]+/", '-', $texto);
    $texto = preg_replace("/[ -]+/", '-', $texto);
    return $texto;
}

/**
 * util_conv_seoc()
 *
 * @version 1.0
 * @param string $texto Texto a formatear
 * @return string Retorna el texto con formato SEO
 */
function util_conv_seoc($texto)
{
    return str_replace('-', '', util_conv_seo($texto));
}

/**
 * Convierte un texto a palablas claves
 *
 * @version 1.0
 * @param string $valor
 * @return string Retorna los keyword encontrados
 */
function util_conv_keywords($valor)
{
    $codi = util_detecta_codificacion($valor);
    if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
    $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
    $codi = util_detecta_codificacion($valor);
    if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
    $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
    $valor = util_codificar($valor, 'UTF-8');
    $valor = util_quitar_acentos($valor);
    $valor = str_replace(array('ñ','Ñ'), array('n','N'), $valor);
    $valor = util_codificar($valor, 'ASCII');
    $valor = str_replace(array('"'), 'pulg ', $valor);
    $valor = str_replace(array('. ', ' .'), ' ', $valor);
    $valor = trim( preg_replace('/[^ A-Za-z0-9_\-\+\.]/', ' ', $valor), " ." );
    $valor = strtolower($valor);
    $valor = preg_replace("/[ \t\n\r]+/", ' ', $valor);

    $palablas_excluidas = 'el,la,los,les,las,de,del,a,ante,con,en,para,por,y,o,u,tu,te,ti,le,que,al,ha,un,han,lo,su,una,estas,esto,este,'
        . 'es,tras,suya,a,acá,ahí,ajena,ajenas,ajeno,ajenos,al,algo,algún,alguna,algunas,alguno,algunos,allá,alli,ambos,ampleamos,ante,antes,'
        . 'aquel,aquella,aquellas,aquello,aquellos,aqui,aquí,arriba,,asi,atras,aun,aunque,bajo,bastante,bien,cabe,cada,casi,cierta,ciertas,cierto,'
        . 'ciertos,como,cómo,con,conmigo,conseguimos,conseguir,consigo,consigue,consiguen,consigues,contigo,contra,cual,cuales,cualquier,cualquiera,'
        . 'cualquieras,cuancuán,cuando,cuanta,cuánta,cuantas,cuántas,cuanto,cuánto,cuantos,cuántos,de,dejar,del,demás,demas,demasiada,demasiadas,'
        . 'demasiado,demasiados,,dentro,desde,donde,dos,ella,ellas,,ello,ellos,empleais,emplean,emplear,empleas,empleo,en,encima,entonces,'
        . 'entre,era,eramos,eran,eras,eres,es,esa,esas,ese,eso,esos,esta,estaba,estado,estais,estamos,estan,estar,estas,este,esto,estos,estoy,etc,'
        . 'fin,fue,fueron,fui,fuimos,gueno,ha,hace,haceis,hacemos,hacen,hacer,haces,hacia,hago,hasta,incluso,intenta,intentais,intentamos,intentan,'
        . 'intentar,intentas,intento,ir,jamás,junto,juntos,la,largo,las,lo,los,mas,me,menos,mi,mia,mias,mientras,mio,mios,mis,misma,'
        . 'mismas,mismo,mismos,modo,mucha,muchas,muchísima,muchísimas,muchísimo,muchísimos,mucho,muchos,muy,nada,ni,ningun,ninguna,ningunas,ninguno,'
        . 'ningunos,no,nos,nosotras,nosotros,nuestra,nuestras,nuestro,nuestros,nunca,os,otra,otras,otro,otros,para,parecer,pero,poca,pocas,poco,'
        . 'pocos,podeis,podemos,poder,podria,podriais,podriamos,podrian,podrias,por,por,qué,porque,primero,primero,desde,puede,pueden,puedo,pues,'
        . 'que,qué,querer,quien,quienes,quienes,quiera,quienquiera,quiza,quizas,sabe,sabeis,sabemos,saben,saber,sabes,se,segun,ser,si,'
        . 'siempre,siendo,sin,sino,so,sobre,sois,solamente,solo,somos,soy,sr,sra,sres,esta,su,sus,suya,suyas,suyo,suyos,tal,tales,tambien,'
        . 'tampoco,tan,tanta,tantas,tanto,tantos,te,teneis,tenemos,tener,tengo,ti,tiempo,tiene,tienen,toda,todas,todo,todos,tomar,trabaja,'
        . 'trabajais,trabajamos,trabajan,trabajar,trabajas,trabajo,tras,tú,tu,tus,tuya,tuyo,tuyos,ultimo,un,una,unas,uno,unos,usa,usais,usamos,'
        . 'usan,usar,usas,uso,usted,ustedes,va,vais,valor,vamos,van,varias,varios,vaya,verdad,verdadera,vosotras,vosotros,voy,vuestra,vuestras,'
        . 'vuestro,vuestros,y,ya,yo,como,hacer,se,tengo';

    $final = array();
    $valor = explode(' ', $valor);
    foreach ($valor as $palabla) {
        if ( strpos($palablas_excluidas, $palabla) === false ) {
            $final[] = $palabla;
        }
    }

    return implode(',', $final);
}

function util_quitar_palabras_vacias($valor)
{
    $palablas_vacias = 'el,la,los,les,las,de,del,a,ante,con,en,para,por,y,o,u,tu,te,ti,le,que,al,ha,un,han,lo,su,una,estas,esto,este,'
        . 'es,tras,suya,a,acá,ahí,ajena,ajenas,ajeno,ajenos,al,algo,algún,alguna,algunas,alguno,algunos,allá,alli,ambos,ampleamos,ante,antes,'
        . 'aquel,aquella,aquellas,aquello,aquellos,aqui,aquí,arriba,,asi,atras,aun,aunque,bajo,bastante,bien,cabe,cada,casi,cierta,ciertas,cierto,'
        . 'ciertos,como,cómo,con,conmigo,conseguimos,conseguir,consigo,consigue,consiguen,consigues,contigo,contra,cual,cuales,cualquier,cualquiera,'
        . 'cualquieras,cuancuán,cuando,cuanta,cuánta,cuantas,cuántas,cuanto,cuánto,cuantos,cuántos,de,dejar,del,demás,demas,demasiada,demasiadas,'
        . 'demasiado,demasiados,,dentro,desde,donde,dos,ella,ellas,,ello,ellos,empleais,emplean,emplear,empleas,empleo,en,encima,entonces,'
        . 'entre,era,eramos,eran,eras,eres,es,esa,esas,ese,eso,esos,esta,estaba,estado,estais,estamos,estan,estar,estas,este,esto,estos,estoy,etc,'
        . 'fin,fue,fueron,fui,fuimos,gueno,ha,hace,haceis,hacemos,hacen,hacer,haces,hacia,hago,hasta,incluso,intenta,intentais,intentamos,intentan,'
        . 'intentar,intentas,intento,ir,jamás,junto,juntos,la,largo,las,lo,los,mas,me,menos,mi,mia,mias,mientras,mio,mios,mis,misma,'
        . 'mismas,mismo,mismos,modo,mucha,muchas,muchísima,muchísimas,muchísimo,muchísimos,mucho,muchos,muy,nada,ni,ningun,ninguna,ningunas,ninguno,'
        . 'ningunos,no,nos,nosotras,nosotros,nuestra,nuestras,nuestro,nuestros,nunca,os,otra,otras,otro,otros,para,parecer,pero,poca,pocas,poco,'
        . 'pocos,podeis,podemos,poder,podria,podriais,podriamos,podrian,podrias,por,por,qué,porque,primero,primero,desde,puede,pueden,puedo,pues,'
        . 'que,qué,querer,quien,quienes,quienes,quiera,quienquiera,quiza,quizas,sabe,sabeis,sabemos,saben,saber,sabes,se,segun,ser,si,'
        . 'siempre,siendo,sin,sino,so,sobre,sois,solamente,solo,somos,soy,sr,sra,sres,esta,su,sus,suya,suyas,suyo,suyos,tal,tales,tambien,'
        . 'tampoco,tan,tanta,tantas,tanto,tantos,te,teneis,tenemos,tener,tengo,ti,tiempo,tiene,tienen,toda,todas,todo,todos,tomar,trabaja,'
        . 'trabajais,trabajamos,trabajan,trabajar,trabajas,trabajo,tras,tú,tu,tus,tuya,tuyo,tuyos,ultimo,un,una,unas,uno,unos,usa,usais,usamos,'
        . 'usan,usar,usas,uso,usted,ustedes,va,vais,valor,vamos,van,varias,varios,vaya,verdad,verdadera,vosotras,vosotros,voy,vuestra,vuestras,'
        . 'vuestro,vuestros,y,ya,yo,como,hacer,se,tengo';

    $final = array();
    $valor = explode(' ', $valor);
    foreach ($valor as $palabla) {
        if ( strpos($palablas_vacias, $palabla) === false ) {
            $final[] = $palabla;
        }
    }

    return implode(' ', $final);
}

function util_conv_terminos($valor)
{
    $codi = util_detecta_codificacion($valor);
    if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
    $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
    $codi = util_detecta_codificacion($valor);
    if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
    $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
    $codi = util_detecta_codificacion($valor);
    if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
    $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
    $valor = util_codificar($valor, 'UTF-8');
    $valor = strip_tags($valor);
    $valor = util_quitar_acentos($valor);
    $valor = str_replace(array('ñ','Ñ'), array('n','N'), $valor);
    $valor = str_replace(array('. ', ' .'), ' ', $valor);
    $valor = trim( preg_replace('/[^ A-Za-z0-9_\-\+\.\ñ\Ñ]/', ' ', $valor), " ." );
    $valor = mb_strtolower($valor, 'UTF-8');
    $valor = str_replace(array('. ', ' .', ' - '), ' ', $valor);
    $valor = preg_replace("/[ \t\n\r]+/", ' ', $valor);

    return $valor;
}

// FUNCIONES PARA MANIPULAR VARIABLES

function util_validar_email($email)
{
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex+1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);

        if ($localLen < 1 || $localLen > 64)
        {
            // local part length exceeded
            $isValid = false;
        }
        else if ($domainLen < 1 || $domainLen > 255)
        {
            // domain part length exceeded
            $isValid = false;
        }
        else if ($local[0] == '.' || $local[$localLen-1] == '.')
        {
            // local part starts or ends with '.'
            $isValid = false;
        }
        else if (preg_match('/\\.\\./', $local))
        {
            // local part has two consecutive dots
            $isValid = false;
        }
        else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
        {
            // character not valid in domain part
            $isValid = false;
        }
        else if (preg_match('/\\.\\./', $domain))
        {
            // domain part has two consecutive dots
            $isValid = false;
        }
        else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
        {
            // character not valid in local part unless
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/',
                str_replace("\\\\","",$local)))
            {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
        {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}

function util_validar_var($valor, $tipo)
{
    if ($tipo == 'email') {
        return (bool) preg_match('/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/', $valor);
    } else if ($tipo == 'numero') {
        return is_numeric($valor);
    } else if ($tipo == 'url') {
        return (bool) preg_match('/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/', $valor);
    } else if ($tipo == 'alfanumerico') {
        return (bool) preg_match('/^([-a-z0-9])+$/i', $valor);
    } else if ($tipo == 'ip') {
        return (bool) preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $valor);
    } else if ($tipo == 'fecha') {	// DD/MM/YYYY o similar
        $separador = "[\/\-\.]";
        $reg = "#^(((0?[1-9]|1\d|2[0-8]){$separador}(0?[1-9]|1[012])|(29|30){$separador}(0?[13456789]|1[012])|31{$separador}(0?[13578]|1[02])){$separador}(19|[2-9]\d)\d{2}|29{$separador}0?2{$separador}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";
        return (bool) preg_match($reg, $valor);
    }
}

/**
 * Prepara variables para su impresion
 *
 * @version 1.7
 * @param mixed $valor
 * @param string $tipo
 * @param array $opciones
 * @return string
 */
function util_preparar_var($valor, $tipo, $opciones = null)
{
    if ( isset($opciones['codificacion']) ) {
        $codificacion = $opciones['codificacion'];
    } else {
        $codificacion = 'UTF-8';
    }

    //----------------------------------------	TEXTO
    if ($tipo == 'texto')
    {
        $codi = util_detecta_codificacion($valor);
        if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
        $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
        $valor = util_codificar($valor, 'ISO-8859-1');

        if ( isset($opciones['corte']) ) {
            if (strlen($valor) > $opciones['corte']) {
                $valor = trim(substr($valor, 0, $opciones['corte'])) . ' ...';
            }
        }

        if ( isset($opciones['justificar']) ) {
            $valor = util_justificar_texto($valor, $opciones['justificar']);
        }

        //$valor = mb_convert_encoding(&$s, 'HTML-ENTITIES', 'UTF-8');
        $valor = htmlentities($valor, ENT_QUOTES, 'ISO-8859-1');
        $valor = util_codificar($valor, $codificacion);
        return $valor;
    }

    //----------------------------------------	MONEDA
    if ($tipo == 'moneda')
    {
        $valor = filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return number_format($valor, 2, '.', ',');
    }

    //----------------------------------------	HTML SIMPLE
    if ($tipo == 'html')
    {
        $codi = util_detecta_codificacion($valor);
        if ( mb_strpos($valor, '&lt;', 0 , $codi) !== false && mb_strpos($valor, '&lt;/', 0 , $codi) !== false && mb_strpos($valor, '&gt;', 0, $codi) !== false ) {
            if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
            $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
        }
        $codi = util_detecta_codificacion($valor);

        $cods = array('ASCII' => 'ascii', 'ISO-8859-1' => 'latin1', 'UTF-8' => 'utf8');
        $tidy_config = array(
            'indent' => true,
            'clean' => true,
            'output-xhtml' => true,
            'show-body-only' => true,
            'preserve-entities' => true
        );

        $valor = tidy_repair_string($valor, $tidy_config, $cods[$codi]);
        return util_codificar($valor, $codificacion);
    }

    //----------------------------------------	HTML PROCESADO Y LIMPIO
    if ($tipo == 'html_limpio')
    {
        $codi = util_detecta_codificacion($valor);
        if ( mb_strpos($valor, '&lt;', 0 , $codi) !== false && mb_strpos($valor, '&lt;/', 0 , $codi) !== false && mb_strpos($valor, '&gt;', 0, $codi) !== false ) {
            if ( $codi == 'ASCII') $codi = 'ISO-8859-1';
            $valor = html_entity_decode($valor, ENT_QUOTES, $codi);
        }
        $codi = util_detecta_codificacion($valor);

        $valor = str_replace('  ? ' , '  &bull; ', $valor);
        $valor = str_replace('>? ' , '>&bull; ', $valor);

        $cods = array('ASCII' => 'ascii', 'ISO-8859-1' => 'latin1', 'UTF-8' => 'utf8');
        $tidy_config = array(
            //'indent' => true,
            'clean' => true,
            'output-xhtml' => true,
            'show-body-only' => true,
            'wrap' => 0,
            'preserve-entities' => true,
            'word-2000' => true
        );

        $valor = tidy_repair_string($valor, $tidy_config, $cods[$codi]);

        $valor = util_codificar($valor, 'ISO-8859-1');
        $valor = str_replace('  ? ' , '  &bull; ', $valor);
        $valor = str_replace('>? ' , '>&bull; ', $valor);
        //$valor = util_eliminar_dom_tags($valor, array('style', 'script', 'applet', 'noframes', 'noscript', 'iframe', 'frameset', 'frame'));
        //$valor = util_eliminar_tags($valor, array('style', 'script', 'applet', 'noframes', 'noscript', 'iframe', 'frameset', 'frame'));
        $valor = util_eliminar_solo_tags($valor, array('span', 'font'));
        $valor = util_eliminar_atributos($valor, array('class', 'style', 'id'));
        $valor = util_codificar($valor, $codificacion);
        return $valor;
    }

    //----------------------------------------	TEXTO SEO
    if ($tipo == 'seo')
    {
        $valor = util_codificar($valor, $codificacion);
        return util_conv_seo($valor, $codificacion);
    }

    //----------------------------------------	NUMERO ENTERO
    if ($tipo == 'entero')
    {
        $valor = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
        return intval($valor, 10);
    }

    //----------------------------------------	NUMERO FLOTANTE
    if ($tipo == 'flotante' || $tipo == 'real')
    {
        $valor = filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if (isset($opciones['decimales'])) {
            $valor = round($valor, $opciones['decimales']);
        }
        return $valor;
    }

    //----------------------------------------	TEXTO TITULO
    if ($tipo == 'titulo')
    {
        $valor = util_codificar($valor, $codificacion);
        $palabras_omitidas = array('de','un','una','uno','el','la','lo','las','los','de','y','o','ni','pero','es','e','si','entonces','sino','cuando','al','desde','por','para','en','off','dentro','afuera','sobre','a','adentro','con');
        $palabras = explode(' ', $valor);
        foreach ($palabras as $llave => $palabra) {
            $palabra = mb_strtolower($palabra, $codificacion);
            if ( $llave == 0 || !in_array($palabra, $palabras_omitidas) ) {
                $palabras[$llave] = mb_convert_case($palabra, MB_CASE_TITLE, $codificacion);
            } else {
                $palabras[$llave] = $palabra;
            }
        }
        $temp = implode(' ', $palabras);
        return htmlentities($temp, ENT_COMPAT, $codificacion);
    }

    //----------------------------------------	ID
    if ($tipo == 'id')
    {
        $valor = trim( preg_replace('/[^ A-Za-z0-9_\-]/', '', $valor) );
        return preg_replace("/[ \t\n\r]+/", '', $valor);
    }

    //----------------------------------------	FECHA
    if ($tipo == 'fecha')
    {

    }

    //----------------------------------------	URL
    if ($tipo == 'url')
    {
        $valor = util_codificar($valor, $codificacion);
        return filter_var($valor, FILTER_SANITIZE_URL);
    }

    //----------------------------------------	CAMPO GET DENTRO DE URL
    if ($tipo == 'url_campo')
    {
        $valor = util_codificar($valor, $codificacion);
        return urlencode($valor);
    }

    //----------------------------------------	EMAIL
    if ($tipo == 'email')
    {
        $valor = util_codificar($valor, $codificacion);
        $valor = str_replace(array(' at ', '[at]'), '@', $valor);
        $valor = str_replace(array(' dot ', '[dot]'), '.', $valor);
        return filter_var($valor, FILTER_SANITIZE_EMAIL);
    }
}

function util_limpiar_html($valor, $codificacion = 'UTF-8')
{
    $tidy_config = array('indent' => true, 'clean' => true, 'output-xhtml' => true, 'show-body-only' => true, 'wrap' => 0);
    $cods = array('ASCII' => 'ascii', 'ISO-8859-1' => 'latin1', 'UTF-8' => 'utf8');
    $valor = html_entity_decode($valor, ENT_COMPAT, $codificacion);
    $tidy = tidy_parse_string($valor, $tidy_config, $cods[$codificacion]);
    $tidy->cleanRepair();
    return util_eliminar_tags($tidy, array('style', 'script', 'applet', 'noframes', 'noscript', 'iframe', 'frameset', 'frame'));

}

/**
 * util_mostrar_peso()
 * Muestra el peso definido de manera formal
 *
 * @version 1.1
 * @param float $peso
 * @param integer $decimales
 * @return string
 */
function util_mostrar_peso($peso, $decimales=2)
{
    if (empty($peso)) return '0 Bytes';
    $peso = intval($peso, 10);
    $tipo = array(' Bytes', ' KB', ' MB', ' GB', ' TB');
    return round($peso/pow(1024,($i = floor(log($peso, 1024)))), $decimales) . $tipo[$i];
}

function util_stripos_arreglo($valor, $buscar = array(), $posicion_inicial = 0)
{
    $resultados = array();
    foreach($buscar as $termino) {
        $posicion = stripos($valor, $termino, $posicion_inicial);
        if ( $posicion !== false ) $resultados[] = $posicion;
    }
    if ( empty($resultados) ) return false;
    return min($resultados);
}

/**
 * util_eliminar_tags()
 * Elimina los tags con todo el contenido (rapida pero no fiable)
 *
 * @version 1.0
 * @param string $textoHTML Texto a modificar
 * @param array $etiquetas Arreglo de etiquetas a eliminar
 * @return string
 */
function util_eliminar_tags($textoHTML, $etiquetas)	// Rapido pero no fiable
{
    $patrones = array(
        '/<('. implode('|', $etiquetas) .').*>.*<\/\1>/isU',	// elimino los <x>!!</x>
        //'/<('. implode('|', $etiquetas) .')[^>]+\/>/is' 		// elimino los <x/>
        '#</?('. implode('|', $etiquetas) .')[^>]*>#is' 		// elimino los <x/> o <x>
    );
    $textoHTML = preg_replace($patrones, '', $textoHTML);
    return trim($textoHTML);
}

/**
 * util_eliminar_atributos()
 * Elimina los atributos especificados dentro de los tags
 *
 * @param mixed $textoHTML
 * @param mixed $atributos
 * @return
 */
function util_eliminar_atributos($textoHTML, $atributos)
{
    //return preg_replace('/ ('. implode('|', $atributos) .')=\"[a-zA-Z0-9_\-]*\"/i', '', $textoHTML);
    return preg_replace('/ ('. implode('|', $atributos) .')=\"[^\"]*\"/i', '', $textoHTML);
}

/**
 * Elimina los tags con todo el contenido
 *
 * @version 1.1
 * @param string $textoHTML Texto a modificar
 * @param array $etiquetas Arreglo de etiquetas a eliminar
 * @return string
 */
function util_eliminar_dom_tags($textoHTML, $etiquetas)	// Lento pero fiable
{
    $dom = new DOMDocument();
    //$dom->formatOutput = true;
    $dom->loadHTML($textoHTML);
    $dom->preserveWhiteSpace = false;
    $elementosEncontrados = array();
    foreach ($etiquetas as $etiqueta)
    {
        $elementos = $dom->getElementsByTagName($etiqueta);
        foreach($elementos as $elemento) {
            $elementosEncontrados[] = $elemento;
        }
    }
    foreach($elementosEncontrados as $elemento) {
        $elemento->parentNode->removeChild($elemento);
    }
    $textoHTML = $dom->saveHTML();

    $textoHTML = str_replace(array('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '<html><body>', '</body></html>'), '', $textoHTML);
    return trim($textoHTML);
}

/**
 * util_eliminar_solo_tags()
 * Elimina los tags sin tocar el contenido
 *
 * @version 1.0
 * @param string $textoHTML Textp a modificar
 * @param array $etiquetas Arreglo de etiquetas a eliminar
 * @return string
 */
function util_eliminar_solo_tags($textoHTML, $etiquetas)
{
    $textoHTML = preg_replace('#</?('. implode('|', $etiquetas) .')[^>]*>#is', '', $textoHTML);
    return trim($textoHTML);
}

/**
 * util_eliminar_html()
 * Función strip_tags mejorado
 *
 * @version 1.0
 * @param string $textoHTML
 * @return string
 */
function util_eliminar_html($textoHTML)
{
    $textoHTML = util_eliminar_dom_tags($textoHTML, array('head', 'style', 'script', 'object', 'embed', 'applet', 'noframes', 'noscript', 'noembed', 'iframe', 'frameset', 'frame'));
    return strip_tags($textoHTML);
}

function preparar_enlace($enlace)
{
    $temp = parse_url(trim($enlace));
    $temp2 = array();
    if (!empty($temp['scheme'])) {
        $temp2[0] = $temp['scheme'] . '://';
    }
    if (!empty($temp['pass']) && !empty($temp['user'])) {
        $temp2[1] = $temp['user'] . ':';
        $temp2[2] = rawurlencode($temp['pass']) . '@';
    } elseif (!empty($temp['user'])) {
        $temp2[1] = $temp['user'] . '@';
    }
    if (!empty($temp['port']) && !empty($temp['host'])) {
        $temp2[3] = $temp['host'] . ':';
    } elseif (!empty($temp['host'])) {
        $temp2[3] = $temp['host'];
    }
    if (!empty($temp['path'])) {
        $temp['path'] = str_replace("\\", '/', $temp['path']);
        $temp['path'] = explode('/', $temp['path']);
        foreach ($temp['path'] as $llave => $valor) {
            $temp['path'][$llave] = rawurlencode(urldecode($valor));
        }
        $temp2[4] = $temp['path'] = implode('/', $temp['path']);
    }
    if (!empty($temp['query'])) {
        $temp2[5] = '?' . $temp['query'];
    }
    if (!empty($temp['fragment'])) {
        $temp2[6] = '#' . $temp['fragment'];
    }
    return implode('', $temp2);
}

// FUNCIONES DE FECHA Y HORA
function mostrar_fecha($fecha_sql, $tipof=1, $sinUTC=false) {
    $marca = sacar_fecha_sql($fecha_sql, $sinUTC);
    $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado");
    $meses = array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $hora=date("h",$marca);
    $minutos=date("i",$marca);
    $segundos=date("s",$marca);
    $mes=date("m",$marca);
    $mes_nombre=$meses[intval(date("m",$marca))];
    $dia=date("d",$marca);
    $dia_nombre=$dias[intval(date("w",$marca))];
    $ano=date("Y",$marca);
    $pm=date("A",$marca);
    $mismodia = $dia==date("d");
    $mismomes = $mes==date("m");
    $mismoano = $ano==date("Y");
    if ($tipof==1) return $dia_nombre." ".$dia." de ".$mes_nombre;								// Lunes 12 de Enero
    if ($tipof==2) return $dia."/".$mes_nombre."/".$ano;										// 12/Enero/2010
    if ($tipof==3) {																			// Enero 12[, 2010]
        if ($mismoano) return $mes_nombre." ".$dia;
        else return $mes_nombre." ".$dia.", ".$ano;
    }
    if ($tipof==4) return $dia."/".$mes_nombre."/".$ano." ".$hora.":".$minutos." ".$pm;			// 12/Enero/2010 01:45 PM
    if ($tipof==5) {																			// Ene 12[, 2010]
        if ($mismoano) return substr($mes_nombre,0,3)." ".$dia;
        else return substr($mes_nombre,0,3)." ".$dia.", ".$ano;
    }
    if ($tipof==6) {																			// [Ene 12, ][2010 ]01:45 PM
        $temp = "";
        if (!$mismodia) $temp .= substr($mes_nombre,0,3)." ".$dia.", ";
        if (!$mismoano) $temp .= $ano." ";
        $temp .= $hora.":".$minutos." ".$pm;
        return $temp;
    }
    if ($tipof==7) {																			// 01:45 PM
        return $hora.":".$minutos." ".$pm;
    }
    if ($tipof==8) {																			// Dom 01:45 PM
        return substr($dia_nombre,0,3)." ".$hora.":".$minutos." ".$pm;
    }
    if ($tipof==9) return $dia." de ".$mes_nombre." ".$ano;                                     // 12 de Enero 2010
    if ($tipof==10) return $dia." de ".$mes_nombre." ".$ano." ".$hora.":".$minutos." ".$pm;
}

function sacar_fecha_sql($fecha_sql, $sinUTC=false)
{
    $hora=0; $minuto=0; $segundo=0; $mes=0; $dia=0; $ano=0;
    $temp = explode(' ', strval($fecha_sql));
    $fecha = $temp[0];
    if( isset($temp[1]) ) $tiempo = $temp[1];
    //list($fecha, $tiempo) = explode(' ', strval($fecha_sql));
    if ( ! empty($fecha) ) list($ano, $mes, $dia) = explode('-', $fecha);
    if ( ! empty($tiempo) ) list($hora, $minuto, $segundo) = explode(':', $tiempo);
    if ( $sinUTC ) return mktime($hora,$minuto,$segundo,$mes,$dia,$ano);
    else return gmmktime($hora,$minuto,$segundo,$mes,$dia,$ano);
}

function meter_fecha_sql($fecha, $sinUTC = false) {
    if ($sinUTC) {
        return date("Y-m-d H:i:s", $fecha);
    } else {
        return gmdate("Y-m-d H:i:s", $fecha);
    }
}