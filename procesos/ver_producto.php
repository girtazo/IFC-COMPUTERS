<?php
header("Content-type:text/xml");
// BIBLIOTECAS
require_once "../Bibliotecas/autocarga.php";
require_once "../Bibliotecas/Formulario.php";

$producto = recoge("producto");
print "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
print("<producto>");
if( ! $producto = producto::recogeProducto( "id", $producto ) ) {
	print $producto->respuestaxml;
} else {
	print "<id>".$producto->id."</id>";
	print "<nombre>".$producto->nombre."</nombre>";
	print "<imagen>./imagenes/".$producto->imagen."</imagen>";
	print "<descripcion>".$producto->descripcion."</descripcion>";
	print "<precio>Precio: ".$producto->precio."€</precio>";
}
print("</producto>");
?>