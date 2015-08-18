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
	$cesta->actualizar( $producto );
	$_SESSION["peso"] = $_SESSION["peso"]+$producto->peso;
	$_SESSION["cesta"] = $cesta;
	$_SESSION["coste_envio"] = 0;
	print "<total>".$cesta->total."</total>";
}
?>