var eliminado_producto;
var parametros = new Array();
function eliminar_producto(nombre) {
	if( ! eliminado_producto ) {
		parametros[0] = "producto[nombre]";
		parametros[1] = nombre;
		eliminado_producto = new Ajax("http://"+location.hostname+"/procesos/eliminar_producto.php","POST",eliminar_producto,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		total = eliminado_producto.objecto.responseText.match(/<total[^>]*>(.*?)<\/total>/);
		document.getElementById("total").innerHTML = "Total: "+total[1]+"€";
		eliminado_producto = null;
		location.assign("http://"+location.hostname+"/ordenadores");
	}
}