var visto;
var parametros = new Array();
function ver_producto(producto) {
	if( ! visto ) {
		parametros[0] = "producto";
		parametros[1] = producto;
		visto = new Ajax("http://"+location.hostname+"/procesos/ver_producto.php","POST",ver_producto,"Texto",parametros,"application/x-www-form-urlencoded" );
	} else {
		producto = visto.objecto.responseXML.getElementsByTagName('producto')[0];
		document.getElementById("pantalla").className = "mostrar";
		document.getElementById("producto_detalle").className = "mostrar";
		document.getElementById("imagen_detalle").alt = "producto_"+producto.getElementsByTagName("id")[0].innerHTML;
		document.getElementById("imagen_detalle").src = producto.getElementsByTagName("imagen")[0].innerHTML;
		document.getElementById("nombre").innerHTML = producto.getElementsByTagName("nombre")[0].innerHTML;
		document.getElementById("detalle").innerHTML = producto.getElementsByTagName("descripcion")[0].innerHTML;
		document.getElementById("precio").innerHTML = producto.getElementsByTagName("precio")[0].innerHTML;
		visto = null;
	}
}