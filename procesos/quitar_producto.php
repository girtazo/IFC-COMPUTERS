<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

$producto = recogeMatriz("producto");
session_start();
print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
if( ! $producto = producto::recogeProducto( $producto ) ) {
	print $producto->respuestaxml;
} else {
	$cesta = $_SESSION["cesta"];
	$vacio = $cesta->actualizar( $producto ,-1 );
	$_SESSION["cesta"] = $cesta;
	print "<total>".$cesta->total."</total>";
}
?>