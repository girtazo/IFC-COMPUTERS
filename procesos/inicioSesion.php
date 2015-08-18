<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$usuario = recogeMatriz("inicio");
print "<xml>";
if( ! $cuenta = usuario::recogeUsuario( "correo", $usuario["correo"] ) ) {
	print "<mensaje>no existe el usuario</mensaje>";
} else if( ! $cuenta->iniciarSesion( $usuario["password"] ) ) {
	print "<mensaje>La contraseña es incorrecta</mensaje>";
} else {
	$cesta = $_SESSION["cesta"];
	$cesta->clientes_id = $cuenta->id;
	$_SESSION["usuario"] = $cuenta;
	$_SESSION["cesta"] = $cesta;
	print "<mensaje>Inicia Sesion</mensaje>";
}
print "</xml>";
?>