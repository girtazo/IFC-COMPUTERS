<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
session_start();
if( isset( $_SESSION["usuario"] ) )
{
	$cuenta = $_SESSION["usuario"];
	$cesta = new cesta ( );
	$_SESSION["cesta"] = $cesta;
	$cuenta->cerrarSesion();
} else {
	print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	print "<mensaje>No habia sesion iniciada</mensaje>";
}
?>