<?php
	header("Content-type:text/xml");
	// BIBLIOTECAS
	require_once "../Bibliotecas/autocarga.php";
	require_once "../Bibliotecas/Formulario.php";

	session_start();
	$password = recogeMatriz("password");
	print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	print "<xml>";
	if( isset( $_SESSION["usuario"] ) ) {
		$usuario = usuario::recogeUsuario( "id", $_SESSION["usuario"]->id );
		if( ! $usuario->verificarPassword( $password["password"], $usuario->password ) ) {
			print("<error>La contraseña actual no es correcta</error>");
		} else {
			$usuario->password = $password["npassword"];
			print ("<aviso>".$_SESSION["usuario"]->nombre." su contraseña se ha cambiado satisfactoriamente</aviso>");
		}
	}
	print "</xml>";
?>