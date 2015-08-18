<?php
function tab($numero)
{
	$tabulaciones = "";
	for ($i=0; $i < $numero; $i++) { 
		$tabulaciones .="\t";
	}
	return $tabulaciones;
}
function obtenerPagina() {
	global $parametro;
	if( $_SERVER["REQUEST_URI"] == "/" ) {
		$cadena = "/inicio";
	} else {
		$cadena = $_SERVER["REQUEST_URI"];
	}
	$cadena = substr( $cadena, 1 );
	$parametros = false;
	$parametro = array();
	$pagina = "";
	$numero = 0;
	for ( $i = 0; $i < strlen( $cadena ); $i++ ) { 
		if( substr( $cadena, $i , 1 ) == "/" ) {
			$parametros = true;
			$numero++;
			$parametro[$numero] = "";
		} else {
			if( $parametros ) {
				$parametro[$numero] .= substr( $cadena, $i , 1 );
			} else {
				$pagina .= substr( $cadena, $i , 1 );
			}
		}
	}
	$pagina = strtolower($pagina);
	return $pagina;
}
?>