var guarda_producto;
var parametros = new Array();
function guardar_producto(nombre) {
	if( ! guarda_producto ) {
		parametros[0] = "producto[nombre]";
		parametros[1] = nombre;
		guarda_producto = new Ajax("http://"+location.hostname+"/procesos/guardar_producto.php","POST",guardar_producto,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		total = guarda_producto.objecto.responseText.match(/<total[^>]*>(.*?)<\/total>/);
		document.getElementById("total").innerHTML = "Total: "+total[1]+"€";
		guarda_producto = null;
		location.assign("http://"+location.hostname+"/ordenadores");
	}
}