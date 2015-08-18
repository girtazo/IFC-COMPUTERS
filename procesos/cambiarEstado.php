<?php
	header("Content-type:text/xml");
	// BIBLIOTECAS
	require_once "../Bibliotecas/autocarga.php";
	require_once "../Bibliotecas/Formulario.php";

	session_start();

	print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	print("<xml>");
	if( isset( $_SESSION["usuario"] ) ) {
		$dato = recogeMatriz2("actualiza");
		foreach ($dato as $campo => $valor) {
			foreach ($valor as $id => $valor) {
				print("<campo>".$campo."</campo>");
				print("<valor>".$valor."</valor>");
				print("<id>".$id."</id>");
				$pedido = pedido::recogePedido( "id", $id );
				$pedido->$campo = $valor;
			}
		}
	}
	print("</xml>");
?>