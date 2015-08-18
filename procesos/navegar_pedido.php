<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";
require_once "../Bibliotecas/cadenas.php";

session_start();
$productos = recoge("productos");
$visulizados = 1;
$numproducto = 1;
if( $productos == "siguientes" ) {
	if( ( $_SESSION["numero_producto"] + $_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"] ) <= $_SESSION["cesta"]->productos->count() ) {
		$_SESSION["numero_producto"] = $_SESSION["numero_producto"] + $_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"];
    }
} else {
	if( ( $_SESSION["numero_producto"] - $_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"] ) >= 1 ) {
		$_SESSION["numero_producto"] = $_SESSION["numero_producto"] - $_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"];
	}
}
print "<productos>\n";
foreach ($_SESSION["cesta"]->productos as $id => $detalle_cesta) {
	if( $numproducto >= $_SESSION["numero_producto"] ) {
		if ( $visulizados <= $_SESSION["VISUALIZAR_MAXIMO_PRODUCTOS"] ) {
			$producto = producto::recogeProducto( "id", $detalle_cesta->productos_id );
			print tab(1)."<producto>\n";
			print tab(2)."<nombre>$producto->nombre</nombre>\n";
			print tab(2)."<cantidad>$detalle_cesta->cantidad</cantidad>\n";
			print tab(2)."<precio>".$detalle_cesta->precio."€</precio>\n";
			print tab(2)."<importe>".($detalle_cesta->cantidad*$detalle_cesta->precio)."€</importe>\n";
			print tab(1)."</producto>\n";
			$visulizados++;
		}
	}
	$numproducto++;
}
print "</productos>\n";
?>