<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

$pedido = recogeMatriz("pedido");
session_start();
print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$pedido = new pedido($pedido["pago"],$pedido["envio"],$_SESSION["usuario"]->id,$_SESSION["cesta"]);
if( $pedido->pagos_id == 2 ) {
	print("<aviso><p>Has realizado el pedido, al haber seleccionado la forma de pago contrarembolso tendra que efectuar el pago cuando usted reciba el pedido en su domicilio</p></aviso>");
} else if( $pedido->pagos_id == 1 ) {
	print("<aviso><p>Has realizado el pedido, al haber seleccionado la forma de pago Transferencia bancaria tendra que realizarla en su banco con los siguientes datos: </p>
		<p>Cuenta bancaria: 0182-3204-17-0201514921 </p>
		<p>Concepto: ".$pedido->id."</p>
		<p>Importe a pagar: ".$pedido->total."€</p>
		</aviso>");
}
?>