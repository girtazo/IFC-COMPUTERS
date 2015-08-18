<?php
	header("Content-type:text/xml");
	// BIBLIOTECAS
	require_once "../Bibliotecas/autocarga.php";
	require_once "../Bibliotecas/Formulario.php";

	session_start();

	print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	print("<xml>");
	if( isset( $_SESSION["usuario"] ) ) {
		$pedido = recoge("pedido");
		print("<pedido>".$pedido."</pedido>");
		$pedido = pedido::recogePedido( "id", $pedido );
		if( !($pedido->pagado || $pedido->enviado) ) {
			$pedido->elimina();
		} else {
			print("<error>Ha sido pagado<error>");
		}
	}
	print("</xml>");
?>