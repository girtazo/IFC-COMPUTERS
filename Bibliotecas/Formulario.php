<?php
function recoge($var) 
{
	$tmp = (isset ( $_REQUEST [$var] )) ? strip_tags ( trim ( htmlspecialchars ( $_REQUEST [$var], ENT_QUOTES, "ISO-8859-1" ) ) ) : "";
	if (get_magic_quotes_gpc ()) {
		$tmp = stripslashes ( $tmp );
	}
	return $tmp;
}
function recogeMatriz2($var)
{
	$tmpMatriz = array();
	if (isset($_REQUEST[$var]) && is_array($_REQUEST[$var])) {
		foreach ($_REQUEST[$var] as $indice => $fila) {
			$tmp = strip_tags(trim(htmlspecialchars($indice, ENT_QUOTES, "ISO-8859-1")));
			if (get_magic_quotes_gpc()) {
				$tmp = stripslashes($tmp);
			}
			$indiceLimpio = $tmp;
			if (is_array($fila)) {
				foreach ($fila as $indice2 => $valor) {
					$tmp = strip_tags(trim(htmlspecialchars($indice2, ENT_QUOTES, "ISO-8859-1")));
					if (get_magic_quotes_gpc()) {
						$tmp = stripslashes($tmp);
					}
					$indice2Limpio = $tmp;

					$tmp = strip_tags(trim(htmlspecialchars($valor, ENT_QUOTES, "ISO-8859-1")));
					if (get_magic_quotes_gpc()) {
						$tmp = stripslashes($tmp);
					}
					$valorLimpio  = $tmp;

					$tmpMatriz[$indiceLimpio][$indice2Limpio] = $valorLimpio;
				}
			}
		}
	}
	return $tmpMatriz;
}
function recogeMatriz($var) 
{
	$tmpMatriz = array ();
	if (isset ( $_REQUEST [$var] ) && is_array ( $_REQUEST [$var] )) {
		foreach ( $_REQUEST [$var] as $indice => $valor ) {
			$tmp = strip_tags ( trim ( htmlspecialchars ( $indice, ENT_QUOTES, "ISO-8859-1" ) ) );
			if (get_magic_quotes_gpc ()) {
				$tmp = stripslashes ( $tmp );
			}
			$indiceLimpio = $tmp;
				
			$tmp = strip_tags ( trim ( htmlspecialchars ( $valor, ENT_QUOTES, "ISO-8859-1" ) ) );
			if (get_magic_quotes_gpc ()) {
				$tmp = stripslashes ( $tmp );
			}
			$valorLimpio = $tmp;
				
			$tmpMatriz [$indiceLimpio] = $valorLimpio;
		}
	}
	return $tmpMatriz;
}
function guardarArchivo($nombreCampo,$ruta = "./")
{
	if( $_FILES[$nombreCampo]["name"] != "" ) {
		$rutaGuardado = $ruta . $_FILES[$nombreCampo]["name"];
		move_uploaded_file($_FILES[$nombreCampo]['tmp_name'], $rutaGuardado);
		$resultado = $_FILES[$nombreCampo]["name"];
	} else {
		$resultado = false;
	}
	return $resultado;
}
?>