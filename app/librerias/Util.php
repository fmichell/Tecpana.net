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