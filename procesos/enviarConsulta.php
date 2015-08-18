<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$consulta = recogeMatriz("contacto");
print "<xml>";
print("+".$consulta["correo"]."+");
print("mail(\"$consulta[correo]\", \"Comprobación Email\", \"Si lees el mensaje, terminaste correctamente la configuración\")");
mail("$consulta[correo]", "Comprobación Email", "Si lees el mensaje, terminaste correctamente la configuración");
$mensaje = mail("$consulta[correo]","Prueba",$consulta["consulta"],"From: Remitente");
print_r($mensaje);
print "</xml>";
?>