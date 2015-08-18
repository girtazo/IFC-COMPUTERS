<?php
	header("Content-type:text/xml");
	// BIBLIOTECAS
	require_once "../Bibliotecas/autocarga.php";
	require_once "../Bibliotecas/Formulario.php";

	session_start();
	$campo = recogeMatriz("actualiza");

	print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	print("<xml>");
	if( isset( $_SESSION["usuario"] ) ) {
		$usuario = usuario::recogeUsuario( "correo", $_SESSION["usuario"]->correo );
		foreach ($campo as $indice => $valor) {
			$usuario->$indice = $valor;
			$_SESSION["usuario"] = $usuario;
			print("<campo>".$indice."</campo>");
			print("<valor>".$usuario->$indice."</valor>");
			print($usuario->respuestaxml);
		}
	}
	print("</xml>");
?>