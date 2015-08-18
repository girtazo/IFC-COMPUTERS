<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

session_start();

$id = recoge("id");
print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$pago = pago::recogePago( "id", $id );
$_SESSION["recargo"] = ($pago->incremento * ( $_SESSION["cesta"]->total + $_SESSION["coste_envio"] ) ) / 100 ;
print "<pago><tipo>".$pago->pago."</tipo><incremento>".$pago->incremento."</incremento><recargo>".$_SESSION["recargo"]."</recargo><total>".($_SESSION["cesta"]->total + $_SESSION["recargo"] + $_SESSION["coste_envio"])."</total></pago>";
?>