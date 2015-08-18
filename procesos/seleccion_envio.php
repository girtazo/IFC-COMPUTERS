<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

session_start();

$id = recoge("id");
$incremento = recoge("incremento_pago");
print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$envio = envio::recogeEnvio( "id", $id );
$empresa = empresa_transporte::recogeEmpresa_transporte("id",$envio->empresas_transporte_id);
$_SESSION["coste_envio"] = $envio->coste;
$_SESSION["recargo"] = ( $_SESSION["cesta"]->total + $envio->coste ) * ( $incremento / 100 );
print "<envio><recargo>".$_SESSION["recargo"]."</recargo><tipo>".$envio->tipo."</tipo><empresa>".$empresa->nombre."</empresa><coste>".$envio->coste."</coste><total>".($_SESSION["cesta"]->total + $_SESSION["coste_envio"] + $_SESSION["recargo"] )."</total></envio>";
?>