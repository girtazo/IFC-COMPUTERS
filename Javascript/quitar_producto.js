var quitado_producto;
var parametros = new Array();
function quitar_producto(nombre) {
	if( ! quitado_producto ) {
		parametros[0] = "producto[nombre]";
		parametros[1] = nombre;
		quitado_producto = new Ajax("http://"+location.hostname+"/procesos/quitar_producto.php","POST",quitar_producto,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		total = quitado_producto.objecto.responseText.match(/<total[^>]*>(.*?)<\/total>/);
		document.getElementById("total").innerHTML = "Total: "+total[1]+"€";
		quitado_producto = null;
		location.assign("http://"+location.hostname+"/ordenadores");
	}
}