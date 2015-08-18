<?php
	header("Content-type:text/xml");
	// BIBLIOTECAS
	require_once "../Bibliotecas/autocarga.php";
	require_once "../Bibliotecas/Formulario.php";

	$usuario = recogeMatriz("registro");

	print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	if( ! isset( $_SESSION["usuario"] ) ) {
		$usuario = new usuario( 
		$usuario["correo"], 
		$usuario["password"], 
		$usuario["nombre"], 
		$usuario["apellidos"], 
		$usuario["dni"], 
		$usuario["codigo_postal"], 
		$usuario["direccion"], 
		$usuario["telefono_fijo"], 
		$usuario["telefono_movil"], 
		$usuario["boletin"],
		1,0);
		print("<xml>");
		print($usuario->respuestaxml);
		print("<aviso><p>".$usuario->nombre." te has registrado satisfactoriamente ahora puede acceder a multitud de ofertas de nuestra web y poder realizar pedidos</p></aviso>");
		print("</xml>");
		
	}
?>