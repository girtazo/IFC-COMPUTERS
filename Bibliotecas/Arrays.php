<?php
function limpiezaArray($array)
{
	$vacio = true;
	$arrayNuevo = Array();
	foreach ($array as $indice => $valor) {
		if( $valor != null ) {
			$arrayNuevo[$indice] = $valor;
			$vacio = false;
		}
	}
	if($vacio) {
		$arrayNuevo = false;
	}
	return $arrayNuevo;
}
?>